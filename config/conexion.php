<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class Database
{
    private ?PDO $pdo = null;
    private ?string $lastError = null;

    public function __construct(
        string $host = '127.0.0.1',
        string $dbname = 'yonkemovil',
        string $user = 'root',
        string $pass = 'root'
    ) {
        $host = (string) (getenv('DB_HOST') ?: $host);
        $dbname = (string) (getenv('DB_NAME') ?: $dbname);
        $user = (string) (getenv('DB_USER') ?: $user);
        $pass = (string) (getenv('DB_PASS') ?: $pass);
        $port = (string) (getenv('DB_PORT') ?: '');
        $socket = (string) (getenv('DB_SOCKET') ?: '');

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        $attempts = [];

        if ($socket !== '' && is_file($socket)) {
            $attempts[] = "mysql:unix_socket={$socket};dbname={$dbname};charset=utf8mb4";
        }

        $dsnMain = "mysql:host={$host};dbname={$dbname};charset=utf8mb4";
        if ($port !== '') {
            $dsnMain = "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4";
        }
        $attempts[] = $dsnMain;

        if ($host === '127.0.0.1' || $host === 'localhost') {
            if ($port === '') {
                $attempts[] = "mysql:host=127.0.0.1;port=3306;dbname={$dbname};charset=utf8mb4";
                $attempts[] = "mysql:host=127.0.0.1;port=8889;dbname={$dbname};charset=utf8mb4";
            }

            $commonSockets = [
                '/Applications/MAMP/tmp/mysql/mysql.sock',
                '/tmp/mysql.sock',
                '/opt/lampp/var/mysql/mysql.sock',
                '/var/run/mysqld/mysqld.sock',
            ];
            foreach ($commonSockets as $sockPath) {
                if (is_file($sockPath)) {
                    $attempts[] = "mysql:unix_socket={$sockPath};dbname={$dbname};charset=utf8mb4";
                }
            }
        }

        $attempts = array_values(array_unique($attempts));
        $lastMessage = null;

        foreach ($attempts as $dsn) {
            try {
                $this->pdo = new PDO($dsn, $user, $pass, $options);
                $this->lastError = null;
                return;
            } catch (Throwable $e) {
                $lastMessage = $e->getMessage();
            }
        }

        $this->lastError = $lastMessage ?: 'No se pudo establecer conexion PDO.';
        $this->pdo = null;
    }

    public function isReady(): bool
    {
        return $this->pdo instanceof PDO;
    }

    public function lastError(): ?string
    {
        return $this->lastError;
    }

    public function pdo(): PDO
    {
        if (!$this->isReady()) {
            throw new RuntimeException('Conexion a base de datos no disponible.');
        }
        return $this->pdo;
    }

    public function query(string $sql, array $params = []): PDOStatement
    {
        if (!$this->isReady()) {
            throw new RuntimeException('Conexion a base de datos no disponible.');
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function select(string $sql, array $params = []): array
    {
        return $this->query($sql, $params)->fetchAll();
    }

    public function one(string $sql, array $params = []): ?array
    {
        $row = $this->query($sql, $params)->fetch();
        return $row ?: null;
    }

    public function insert(string $table, array $data): int
    {
        $columns = array_keys($data);
        $holders = array_fill(0, count($columns), '?');
        $sql = sprintf(
            'INSERT INTO %s (%s) VALUES (%s)',
            $table,
            implode(', ', $columns),
            implode(', ', $holders)
        );
        $this->query($sql, array_values($data));
        return (int) $this->pdo->lastInsertId();
    }

    public function update(string $table, array $data, string $where, array $params = []): int
    {
        $set = implode(' = ?, ', array_keys($data)) . ' = ?';
        $sql = sprintf('UPDATE %s SET %s WHERE %s', $table, $set, $where);
        $stmt = $this->query($sql, array_merge(array_values($data), $params));
        return $stmt->rowCount();
    }
}
