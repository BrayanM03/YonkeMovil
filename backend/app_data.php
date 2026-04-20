<?php
require_once __DIR__ . '/../config/conexion.php';

function app_db(): Database
{
    static $db = null;
    if ($db === null) {
        $db = new Database();
        if (!$db->isReady()) {
            $detail = $db->lastError();
            throw new RuntimeException('No se pudo conectar a la base de datos.' . ($detail ? ' ' . $detail : ''));
        }
    }
    return $db;
}

function app_is_demo_mode(): bool
{
    return false;
}

function app_current_user_id(): int
{
    return (int) ($_SESSION['id'] ?? 0);
}

function app_current_user_role(): int
{
    return (int) ($_SESSION['rol'] ?? 0);
}

function app_is_admin_user(): bool
{
    return app_current_user_role() === 2;
}

function app_demo_store_path(): string
{
    return __DIR__ . '/../database/demo_store.json';
}

function app_demo_default_data(): array
{
    return [
        'roles' => [
            ['id' => 1, 'nombre' => 'cliente', 'estatus' => 1],
            ['id' => 2, 'nombre' => 'admin', 'estatus' => 1],
        ],
        'usuarios' => [
            ['id' => 1, 'nombre' => 'Admin', 'apellido' => 'YonkeMovil', 'usuario' => 'admin', 'rol_id' => 2, 'estatus' => 1, 'puesto' => 'Administrador', 'correo' => 'admin@yonkemovil.local', 'contrasena' => password_hash('admin123', PASSWORD_DEFAULT)],
            ['id' => 2, 'nombre' => 'Cliente', 'apellido' => 'Demo', 'usuario' => 'cliente', 'rol_id' => 1, 'estatus' => 1, 'puesto' => 'Propietario de yonke', 'correo' => 'cliente@yonkemovil.local', 'contrasena' => password_hash('cliente123', PASSWORD_DEFAULT)],
        ],
        'yonkes' => [
            ['id' => 1, 'usuario_id' => 2, 'nombre' => 'Yonke Centro', 'telefono' => '6641234567', 'direccion' => 'Tijuana Centro', 'estatus' => 1],
            ['id' => 2, 'usuario_id' => 2, 'nombre' => 'Yonke Otay', 'telefono' => '6642345678', 'direccion' => 'Otay Universidad', 'estatus' => 1],
        ],
        'catalogo' => [
            ['anio' => 2019, 'marca' => 'Toyota', 'modelo' => 'Corolla'],
            ['anio' => 2020, 'marca' => 'Honda', 'modelo' => 'Civic'],
            ['anio' => 2021, 'marca' => 'Chevrolet', 'modelo' => 'Aveo'],
            ['anio' => 2022, 'marca' => 'Ford', 'modelo' => 'Ranger'],
            ['anio' => 2023, 'marca' => 'Kia', 'modelo' => 'Forte'],
        ],
        'inventario' => [
            ['id' => 1, 'usuario_id' => 2, 'yonke' => 'Yonke Centro', 'anio' => 2019, 'marca' => 'Toyota', 'modelo' => 'Corolla', 'cantidad' => 2, 'estatus' => 1],
        ],
    ];
}

function app_demo_read(): array
{
    $path = app_demo_store_path();
    if (!file_exists($path)) {
        $data = app_demo_default_data();
        file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        return $data;
    }

    $raw = file_get_contents($path);
    $json = json_decode($raw ?: '', true);
    if (!is_array($json)) {
        $json = app_demo_default_data();
        file_put_contents($path, json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
    return $json;
}

function app_demo_write(array $data): void
{
    file_put_contents(app_demo_store_path(), json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

function app_catalogo_autos(): array
{
    if (!app_is_demo_mode()) {
        return app_db()->select('SELECT anio, marca, modelo FROM catalogo_autos ORDER BY anio DESC, marca ASC, modelo ASC');
    }
    return app_demo_read()['catalogo'];
}

function app_usuarios_roles(): array
{
    if (!app_is_demo_mode()) {
        $sql = 'SELECT u.id, u.nombre, u.apellido, u.usuario, u.correo, u.puesto, u.rol_id, u.estatus, r.nombre AS rol
                FROM usuarios u INNER JOIN roles r ON r.id = u.rol_id
                ORDER BY u.id DESC';
        return app_db()->select($sql);
    }

    $data = app_demo_read();
    $roles = [];
    foreach ($data['roles'] as $r) {
        $roles[(int) $r['id']] = $r['nombre'];
    }

    return array_map(static function (array $u) use ($roles): array {
        return [
            'id' => $u['id'],
            'nombre' => $u['nombre'],
            'apellido' => $u['apellido'],
            'usuario' => $u['usuario'],
            'correo' => $u['correo'] ?? null,
            'puesto' => $u['puesto'] ?? null,
            'rol_id' => $u['rol_id'],
            'estatus' => $u['estatus'],
            'rol' => $roles[(int) $u['rol_id']] ?? 'sin rol',
        ];
    }, $data['usuarios']);
}

function app_usuario_obtener(int $id): ?array
{
    if (!app_is_demo_mode()) {
        return app_db()->one('SELECT * FROM usuarios WHERE id = ? LIMIT 1', [$id]);
    }
    foreach (app_demo_read()['usuarios'] as $u) {
        if ((int) $u['id'] === $id) {
            return $u;
        }
    }
    return null;
}

function app_usuario_crear(string $nombre, string $apellido, string $usuario, ?string $correo, ?string $puesto, int $rolId, string $password): void
{
    if (!app_is_demo_mode()) {
        app_db()->insert('usuarios', [
            'nombre' => $nombre,
            'apellido' => $apellido,
            'usuario' => $usuario,
            'contrasena' => password_hash($password, PASSWORD_DEFAULT),
            'correo' => $correo,
            'puesto' => $puesto,
            'rol_id' => $rolId,
            'estatus' => 1,
        ]);
        return;
    }

    $data = app_demo_read();
    foreach ($data['usuarios'] as $u) {
        if (strtolower((string) $u['usuario']) === strtolower($usuario)) {
            throw new RuntimeException('El usuario ya existe.');
        }
    }

    $nextId = 1;
    foreach ($data['usuarios'] as $u) {
        $nextId = max($nextId, ((int) $u['id']) + 1);
    }

    $data['usuarios'][] = [
        'id' => $nextId,
        'nombre' => $nombre,
        'apellido' => $apellido,
        'usuario' => $usuario,
        'correo' => $correo,
        'puesto' => $puesto,
        'rol_id' => $rolId,
        'estatus' => 1,
        'contrasena' => password_hash($password, PASSWORD_DEFAULT),
    ];
    app_demo_write($data);
}

function app_usuario_actualizar(int $id, string $nombre, string $apellido, ?string $correo, ?string $puesto, int $rolId, ?string $password): void
{
    if (!app_is_demo_mode()) {
        $update = [
            'nombre' => $nombre,
            'apellido' => $apellido,
            'correo' => $correo,
            'puesto' => $puesto,
            'rol_id' => $rolId,
        ];
        app_db()->update('usuarios', $update, 'id = ?', [$id]);

        if ($password !== null && trim($password) !== '') {
            app_db()->update('usuarios', ['contrasena' => password_hash($password, PASSWORD_DEFAULT)], 'id = ?', [$id]);
        }
        return;
    }

    $data = app_demo_read();
    foreach ($data['usuarios'] as &$u) {
        if ((int) $u['id'] === $id) {
            $u['nombre'] = $nombre;
            $u['apellido'] = $apellido;
            $u['correo'] = $correo;
            $u['puesto'] = $puesto;
            $u['rol_id'] = $rolId;
            if ($password !== null && trim($password) !== '') {
                $u['contrasena'] = password_hash($password, PASSWORD_DEFAULT);
            }
            break;
        }
    }
    unset($u);
    app_demo_write($data);
}

function app_usuario_cambiar_estatus(int $id, int $estatus): void
{
    if (!app_is_demo_mode()) {
        app_db()->update('usuarios', ['estatus' => $estatus], 'id = ?', [$id]);
        return;
    }

    $data = app_demo_read();
    foreach ($data['usuarios'] as &$u) {
        if ((int) $u['id'] === $id) {
            $u['estatus'] = $estatus;
            break;
        }
    }
    unset($u);
    app_demo_write($data);
}

function app_roles(bool $onlyActive = true): array
{
    if (!app_is_demo_mode()) {
        if ($onlyActive) {
            return app_db()->select('SELECT id, nombre, estatus FROM roles WHERE estatus = 1 ORDER BY nombre ASC');
        }
        return app_db()->select('SELECT id, nombre, estatus FROM roles ORDER BY id ASC');
    }

    $roles = app_demo_read()['roles'];
    if (!$onlyActive) {
        return $roles;
    }
    return array_values(array_filter($roles, static fn(array $r): bool => (int) ($r['estatus'] ?? 1) === 1));
}

function app_rol_obtener(int $id): ?array
{
    if (!app_is_demo_mode()) {
        return app_db()->one('SELECT id, nombre, estatus FROM roles WHERE id = ? LIMIT 1', [$id]);
    }
    foreach (app_demo_read()['roles'] as $r) {
        if ((int) $r['id'] === $id) {
            return $r;
        }
    }
    return null;
}

function app_rol_crear(string $nombre): void
{
    if (!app_is_demo_mode()) {
        app_db()->insert('roles', ['nombre' => $nombre, 'estatus' => 1]);
        return;
    }

    $data = app_demo_read();
    foreach ($data['roles'] as $r) {
        if (strtolower((string) $r['nombre']) === strtolower($nombre)) {
            throw new RuntimeException('El rol ya existe.');
        }
    }

    $nextId = 1;
    foreach ($data['roles'] as $r) {
        $nextId = max($nextId, ((int) $r['id']) + 1);
    }

    $data['roles'][] = ['id' => $nextId, 'nombre' => $nombre, 'estatus' => 1];
    app_demo_write($data);
}

function app_rol_actualizar(int $id, string $nombre): void
{
    if (!app_is_demo_mode()) {
        app_db()->update('roles', ['nombre' => $nombre], 'id = ?', [$id]);
        return;
    }

    $data = app_demo_read();
    foreach ($data['roles'] as &$r) {
        if ((int) $r['id'] === $id) {
            $r['nombre'] = $nombre;
            break;
        }
    }
    unset($r);
    app_demo_write($data);
}

function app_rol_cambiar_estatus(int $id, int $estatus): void
{
    if (!app_is_demo_mode()) {
        app_db()->update('roles', ['estatus' => $estatus], 'id = ?', [$id]);
        return;
    }

    $data = app_demo_read();
    foreach ($data['roles'] as &$r) {
        if ((int) $r['id'] === $id) {
            $r['estatus'] = $estatus;
            break;
        }
    }
    unset($r);
    app_demo_write($data);
}

function app_yonkes_usuario(int $usuarioId): array
{
    if (!app_is_demo_mode()) {
        $sql = 'SELECT id, usuario_id, nombre, telefono, direccion, estatus FROM yonkes WHERE usuario_id = ? ORDER BY id DESC';
        return app_db()->select($sql, [$usuarioId]);
    }

    $data = app_demo_read();
    return array_values(array_filter($data['yonkes'], static function (array $y) use ($usuarioId): bool {
        return (int) $y['usuario_id'] === $usuarioId;
    }));
}

function app_yonkes_disponibles_inventario(int $usuarioId): array
{
    if (!app_is_demo_mode()) {
        if (app_is_admin_user()) {
            $sql = 'SELECT y.id, y.usuario_id, y.nombre, y.estatus, u.usuario AS propietario
                    FROM yonkes y
                    INNER JOIN usuarios u ON u.id = y.usuario_id
                    WHERE y.estatus = 1
                    ORDER BY y.nombre ASC';
            return app_db()->select($sql);
        }

        $sql = 'SELECT y.id, y.usuario_id, y.nombre, y.estatus, u.usuario AS propietario
                FROM yonkes y
                INNER JOIN usuarios u ON u.id = y.usuario_id
                WHERE y.usuario_id = ? AND y.estatus = 1
                ORDER BY y.nombre ASC';
        return app_db()->select($sql, [$usuarioId]);
    }

    $rows = app_yonkes_gestion($usuarioId);
    return array_values(array_filter($rows, static function (array $y): bool {
        return (int) ($y['estatus'] ?? 0) === 1;
    }));
}

function app_yonkes_gestion(int $usuarioId): array
{
    if (!app_is_demo_mode()) {
        if (app_is_admin_user()) {
            $sql = 'SELECT y.id, y.usuario_id, y.nombre, y.telefono, y.direccion, y.estatus, u.usuario AS propietario
                    FROM yonkes y INNER JOIN usuarios u ON u.id = y.usuario_id
                    ORDER BY y.id DESC';
            return app_db()->select($sql);
        }

        $sql = 'SELECT y.id, y.usuario_id, y.nombre, y.telefono, y.direccion, y.estatus, u.usuario AS propietario
                FROM yonkes y INNER JOIN usuarios u ON u.id = y.usuario_id
                WHERE y.usuario_id = ?
                ORDER BY y.id DESC';
        return app_db()->select($sql, [$usuarioId]);
    }

    $data = app_demo_read();
    $usuarios = [];
    foreach ($data['usuarios'] as $u) {
        $usuarios[(int) $u['id']] = $u['usuario'];
    }

    $list = $data['yonkes'];
    if (!app_is_admin_user()) {
        $list = array_values(array_filter($list, static fn(array $y): bool => (int) $y['usuario_id'] === $usuarioId));
    }

    return array_map(static function (array $y) use ($usuarios): array {
        $y['propietario'] = $usuarios[(int) $y['usuario_id']] ?? 'n/a';
        return $y;
    }, $list);
}

function app_yonke_obtener(int $id, int $usuarioId): ?array
{
    if (!app_is_demo_mode()) {
        if (app_is_admin_user()) {
            return app_db()->one('SELECT * FROM yonkes WHERE id = ? LIMIT 1', [$id]);
        }
        return app_db()->one('SELECT * FROM yonkes WHERE id = ? AND usuario_id = ? LIMIT 1', [$id, $usuarioId]);
    }

    $list = app_yonkes_gestion($usuarioId);
    foreach ($list as $y) {
        if ((int) $y['id'] === $id) {
            return $y;
        }
    }
    return null;
}

function app_yonke_crear(int $usuarioId, string $nombre, string $telefono, string $direccion, ?int $propietarioId = null): void
{
    $owner = (app_is_admin_user() && $propietarioId !== null && $propietarioId > 0) ? $propietarioId : $usuarioId;

    if (!app_is_demo_mode()) {
        app_db()->insert('yonkes', [
            'usuario_id' => $owner,
            'nombre' => $nombre,
            'telefono' => $telefono,
            'direccion' => $direccion,
            'estatus' => 1,
        ]);
        return;
    }

    $data = app_demo_read();
    $nextId = 1;
    foreach ($data['yonkes'] as $row) {
        $nextId = max($nextId, ((int) $row['id']) + 1);
    }

    $data['yonkes'][] = [
        'id' => $nextId,
        'usuario_id' => $owner,
        'nombre' => $nombre,
        'telefono' => $telefono,
        'direccion' => $direccion,
        'estatus' => 1,
    ];

    app_demo_write($data);
}

function app_yonke_actualizar(int $id, int $usuarioId, string $nombre, string $telefono, string $direccion, ?int $propietarioId = null): void
{
    $yonke = app_yonke_obtener($id, $usuarioId);
    if (!$yonke) {
        throw new RuntimeException('No se encontro el yonke.');
    }

    $owner = (app_is_admin_user() && $propietarioId !== null && $propietarioId > 0) ? $propietarioId : (int) $yonke['usuario_id'];

    if (!app_is_demo_mode()) {
        app_db()->update('yonkes', [
            'usuario_id' => $owner,
            'nombre' => $nombre,
            'telefono' => $telefono,
            'direccion' => $direccion,
        ], 'id = ?', [$id]);
        return;
    }

    $data = app_demo_read();
    foreach ($data['yonkes'] as &$y) {
        if ((int) $y['id'] === $id) {
            $y['usuario_id'] = $owner;
            $y['nombre'] = $nombre;
            $y['telefono'] = $telefono;
            $y['direccion'] = $direccion;
            break;
        }
    }
    unset($y);
    app_demo_write($data);
}

function app_yonke_cambiar_estatus(int $id, int $usuarioId, int $estatus): void
{
    $yonke = app_yonke_obtener($id, $usuarioId);
    if (!$yonke) {
        throw new RuntimeException('No se encontro el yonke.');
    }

    if (!app_is_demo_mode()) {
        app_db()->update('yonkes', ['estatus' => $estatus], 'id = ?', [$id]);
        return;
    }

    $data = app_demo_read();
    foreach ($data['yonkes'] as &$y) {
        if ((int) $y['id'] === $id) {
            $y['estatus'] = $estatus;
            break;
        }
    }
    unset($y);
    app_demo_write($data);
}

function app_inventario_usuario(int $usuarioId): array
{
    if (app_is_admin_user()) {
        $sql = "SELECT vi.id, vi.usuario_id, vi.yonke_id, vi.anio, vi.marca, vi.modelo, vi.cantidad, vi.stock, vi.estatus, vi.foto_principal, y.nombre AS yonke
                FROM vehiculos_inventario vi
                INNER JOIN yonkes y ON y.id = vi.yonke_id
                ORDER BY vi.id DESC";
        return app_db()->select($sql);
    }

    $sql = "SELECT vi.id, vi.usuario_id, vi.yonke_id, vi.anio, vi.marca, vi.modelo, vi.cantidad, vi.stock, vi.estatus, vi.foto_principal, y.nombre AS yonke
            FROM vehiculos_inventario vi
            INNER JOIN yonkes y ON y.id = vi.yonke_id
            WHERE vi.usuario_id = ?
            ORDER BY vi.id DESC";
    return app_db()->select($sql, [$usuarioId]);
}

function app_inventario_agregar(int $usuarioId, string $yonkeNombre, int $anio, string $marca, string $modelo, int $cantidad): void
{
    if (!app_is_demo_mode()) {
        $yonke = app_db()->one('SELECT id FROM yonkes WHERE usuario_id = ? AND nombre = ? LIMIT 1', [$usuarioId, $yonkeNombre]);
        if (!$yonke) {
            throw new RuntimeException('No se encontro el yonke seleccionado.');
        }
        app_db()->insert('vehiculos_inventario', [
            'usuario_id' => $usuarioId,
            'yonke_id' => (int) $yonke['id'],
            'anio' => $anio,
            'marca' => $marca,
            'modelo' => $modelo,
            'cantidad' => $cantidad,
            'stock' => $cantidad,
            'estatus' => 1,
        ]);
        return;
    }

    $data = app_demo_read();
    $nextId = 1;
    foreach ($data['inventario'] as $row) {
        $nextId = max($nextId, ((int) $row['id']) + 1);
    }

    $data['inventario'][] = [
        'id' => $nextId,
        'usuario_id' => $usuarioId,
        'yonke' => $yonkeNombre,
        'anio' => $anio,
        'marca' => $marca,
        'modelo' => $modelo,
        'cantidad' => $cantidad,
        'stock' => $cantidad,
        'estatus' => 1,
    ];

    app_demo_write($data);
}

function app_inventario_crear_con_fotos(
    int $usuarioId,
    int $yonkeId,
    int $anio,
    string $marca,
    string $modelo,
    int $cantidad,
    array $files
): int {
    $cantidad = max(1, $cantidad);

    if (!app_is_demo_mode()) {
        if (app_is_admin_user()) {
            $yonke = app_db()->one('SELECT id, usuario_id FROM yonkes WHERE id = ? AND estatus = 1 LIMIT 1', [$yonkeId]);
        } else {
            $yonke = app_db()->one('SELECT id, usuario_id FROM yonkes WHERE id = ? AND usuario_id = ? AND estatus = 1 LIMIT 1', [$yonkeId, $usuarioId]);
        }

        if (!$yonke) {
            throw new RuntimeException('No se encontró el yonke seleccionado.');
        }

        $ownerId = (int) $yonke['usuario_id'];
        $uploadDirRel = 'frontend/recursos/img/autos';
        $uploadDirAbs = dirname(__DIR__) . '/' . $uploadDirRel;
        if (!is_dir($uploadDirAbs) && !mkdir($uploadDirAbs, 0775, true) && !is_dir($uploadDirAbs)) {
            throw new RuntimeException('No se pudo crear el directorio de fotos.');
        }
        if (!is_writable($uploadDirAbs)) {
            @chmod($uploadDirAbs, 0775);
        }
        if (!is_writable($uploadDirAbs)) {
            throw new RuntimeException('El directorio de fotos no tiene permisos de escritura.');
        }

        $photoPaths = [];
        $uploadErrors = [];

        $names = $files['name'] ?? [];
        $tmpNames = $files['tmp_name'] ?? [];
        $errors = $files['error'] ?? [];

        if (!is_array($names)) {
            $names = [$names];
            $tmpNames = [$tmpNames];
            $errors = [$errors];
        }

        $total = count($names);
        for ($i = 0; $i < $total; $i++) {
            $err = (int) ($errors[$i] ?? UPLOAD_ERR_NO_FILE);
            if ($err !== UPLOAD_ERR_OK) {
                if ($err !== UPLOAD_ERR_NO_FILE) {
                    $uploadErrors[] = app_upload_error_message($err);
                }
                continue;
            }

            $tmpName = (string) ($tmpNames[$i] ?? '');
            $original = (string) ($names[$i] ?? '');
            if ($tmpName === '' || $original === '') {
                $uploadErrors[] = 'Archivo inválido recibido.';
                continue;
            }

            $ext = strtolower((string) pathinfo($original, PATHINFO_EXTENSION));
            if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp'], true)) {
                $uploadErrors[] = 'Tipo de archivo no permitido: ' . $original;
                continue;
            }

            $filename = 'auto_' . date('Ymd_His') . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
            $targetAbs = $uploadDirAbs . '/' . $filename;
            if (move_uploaded_file($tmpName, $targetAbs)) {
                $photoPaths[] = $uploadDirRel . '/' . $filename;
            } else {
                $uploadErrors[] = 'No se pudo mover el archivo: ' . $original;
            }
        }

        if ($total > 0 && count($photoPaths) === 0) {
            $reason = !empty($uploadErrors) ? (' Detalle: ' . implode(' | ', array_unique($uploadErrors))) : '';
            throw new RuntimeException('No se subió ninguna foto correctamente.' . $reason);
        }

        $newId = app_db()->insert('vehiculos_inventario', [
            'usuario_id' => $ownerId,
            'yonke_id' => $yonkeId,
            'anio' => $anio,
            'marca' => $marca,
            'modelo' => $modelo,
            'cantidad' => $cantidad,
            'stock' => $cantidad,
            'foto_principal' => $photoPaths[0] ?? null,
            'estatus' => 1,
        ]);

        app_db()->query(
            "CREATE TABLE IF NOT EXISTS vehiculos_fotos (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                vehiculo_id INT UNSIGNED NOT NULL,
                foto_path VARCHAR(255) NOT NULL,
                orden SMALLINT UNSIGNED NOT NULL DEFAULT 0,
                fecha_registro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                CONSTRAINT fk_vf_vehiculo FOREIGN KEY (vehiculo_id) REFERENCES vehiculos_inventario(id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"
        );

        foreach ($photoPaths as $idx => $path) {
            app_db()->insert('vehiculos_fotos', [
                'vehiculo_id' => $newId,
                'foto_path' => $path,
                'orden' => $idx,
            ]);
        }

        return (int) $newId;
    }

    $data = app_demo_read();
    $nextId = 1;
    foreach ($data['inventario'] as $row) {
        $nextId = max($nextId, ((int) $row['id']) + 1);
    }

    $yonkeNombre = '';
    foreach (app_yonkes_disponibles_inventario($usuarioId) as $y) {
        if ((int) $y['id'] === $yonkeId) {
            $yonkeNombre = (string) ($y['nombre'] ?? '');
            break;
        }
    }
    if ($yonkeNombre === '') {
        throw new RuntimeException('No se encontró el yonke seleccionado.');
    }

    $data['inventario'][] = [
        'id' => $nextId,
        'usuario_id' => $usuarioId,
        'yonke' => $yonkeNombre,
        'anio' => $anio,
        'marca' => $marca,
        'modelo' => $modelo,
        'cantidad' => $cantidad,
        'stock' => $cantidad,
        'estatus' => 1,
        'foto_principal' => null,
    ];
    app_demo_write($data);
    return $nextId;
}

function app_upload_error_message(int $code): string
{
    return match ($code) {
        UPLOAD_ERR_INI_SIZE => 'Archivo excede upload_max_filesize.',
        UPLOAD_ERR_FORM_SIZE => 'Archivo excede MAX_FILE_SIZE del formulario.',
        UPLOAD_ERR_PARTIAL => 'Archivo subido parcialmente.',
        UPLOAD_ERR_NO_TMP_DIR => 'Falta directorio temporal de PHP.',
        UPLOAD_ERR_CANT_WRITE => 'No se pudo escribir el archivo en disco.',
        UPLOAD_ERR_EXTENSION => 'Una extensión de PHP detuvo la subida.',
        default => 'Error desconocido al subir archivo.',
    };
}

function app_inventario_obtener(int $id, int $usuarioId): ?array
{
    if (!app_is_demo_mode()) {
        if (app_is_admin_user()) {
            $sql = "SELECT vi.id, vi.usuario_id, vi.yonke_id, vi.anio, vi.marca, vi.modelo, vi.cantidad, vi.stock, vi.estatus, vi.foto_principal, y.nombre AS yonke
                    FROM vehiculos_inventario vi
                    INNER JOIN yonkes y ON y.id = vi.yonke_id
                    WHERE vi.id = ?
                    LIMIT 1";
            return app_db()->one($sql, [$id]);
        }

        $sql = "SELECT vi.id, vi.usuario_id, vi.yonke_id, vi.anio, vi.marca, vi.modelo, vi.cantidad, vi.stock, vi.estatus, vi.foto_principal, y.nombre AS yonke
                FROM vehiculos_inventario vi
                INNER JOIN yonkes y ON y.id = vi.yonke_id
                WHERE vi.id = ? AND vi.usuario_id = ?
                LIMIT 1";
        return app_db()->one($sql, [$id, $usuarioId]);
    }

    foreach (app_demo_read()['inventario'] as $row) {
        if ((int) $row['id'] === $id && (app_is_admin_user() || (int) $row['usuario_id'] === $usuarioId)) {
            if (!isset($row['yonke_id'])) {
                $row['yonke_id'] = 0;
                foreach (app_yonkes_disponibles_inventario($usuarioId) as $y) {
                    if ((string) ($row['yonke'] ?? '') === (string) ($y['nombre'] ?? '')) {
                        $row['yonke_id'] = (int) ($y['id'] ?? 0);
                        break;
                    }
                }
            }
            return $row;
        }
    }

    return null;
}

function app_inventario_fotos(int $vehiculoId, int $usuarioId): array
{
    $reg = app_inventario_obtener($vehiculoId, $usuarioId);
    if (!$reg) {
        return [];
    }

    if (!app_is_demo_mode()) {
        app_db()->query(
            "CREATE TABLE IF NOT EXISTS vehiculos_fotos (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                vehiculo_id INT UNSIGNED NOT NULL,
                foto_path VARCHAR(255) NOT NULL,
                orden SMALLINT UNSIGNED NOT NULL DEFAULT 0,
                fecha_registro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                CONSTRAINT fk_vf_vehiculo FOREIGN KEY (vehiculo_id) REFERENCES vehiculos_inventario(id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"
        );

        return app_db()->select('SELECT id, foto_path, orden FROM vehiculos_fotos WHERE vehiculo_id = ? ORDER BY orden ASC, id ASC', [$vehiculoId]);
    }

    $fotos = [];
    if (!empty($reg['foto_principal'])) {
        $fotos[] = ['id' => 1, 'foto_path' => (string) $reg['foto_principal'], 'orden' => 0];
    }
    return $fotos;
}

function app_inventario_actualizar(
    int $id,
    int $usuarioId,
    int $yonkeId,
    int $anio,
    string $marca,
    string $modelo,
    int $cantidad,
    int $estatus
): void {
    $reg = app_inventario_obtener($id, $usuarioId);
    if (!$reg) {
        throw new RuntimeException('No se encontró el registro de inventario.');
    }

    $cantidad = max(1, $cantidad);
    $estatus = $estatus === 1 ? 1 : 0;

    if (!app_is_demo_mode()) {
        if (app_is_admin_user()) {
            $yonke = app_db()->one('SELECT id, usuario_id FROM yonkes WHERE id = ? AND estatus = 1 LIMIT 1', [$yonkeId]);
        } else {
            $yonke = app_db()->one('SELECT id, usuario_id FROM yonkes WHERE id = ? AND usuario_id = ? AND estatus = 1 LIMIT 1', [$yonkeId, $usuarioId]);
        }
        if (!$yonke) {
            throw new RuntimeException('No se encontró el yonke seleccionado.');
        }

        app_db()->update('vehiculos_inventario', [
            'usuario_id' => (int) $yonke['usuario_id'],
            'yonke_id' => $yonkeId,
            'anio' => $anio,
            'marca' => $marca,
            'modelo' => $modelo,
            'cantidad' => $cantidad,
            'stock' => $cantidad,
            'estatus' => $estatus,
        ], 'id = ?', [$id]);
        return;
    }

    $data = app_demo_read();
    foreach ($data['inventario'] as &$row) {
        if ((int) $row['id'] === $id) {
            $row['anio'] = $anio;
            $row['marca'] = $marca;
            $row['modelo'] = $modelo;
            $row['cantidad'] = $cantidad;
            $row['stock'] = $cantidad;
            $row['estatus'] = $estatus;

            foreach (app_yonkes_disponibles_inventario($usuarioId) as $y) {
                if ((int) $y['id'] === $yonkeId) {
                    $row['yonke'] = (string) $y['nombre'];
                    break;
                }
            }
            break;
        }
    }
    unset($row);
    app_demo_write($data);
}

function app_inventario_eliminar(int $id, int $usuarioId): void
{
    $reg = app_inventario_obtener($id, $usuarioId);
    if (!$reg) {
        throw new RuntimeException('No se encontró el registro de inventario.');
    }

    if (!app_is_demo_mode()) {
        $fotos = app_inventario_fotos($id, $usuarioId);
        foreach ($fotos as $f) {
            $abs = dirname(__DIR__) . '/' . ltrim((string) ($f['foto_path'] ?? ''), '/');
            if (is_file($abs)) {
                @unlink($abs);
            }
        }

        if (!empty($reg['foto_principal'])) {
            $absMain = dirname(__DIR__) . '/' . ltrim((string) $reg['foto_principal'], '/');
            if (is_file($absMain)) {
                @unlink($absMain);
            }
        }

        app_db()->query('DELETE FROM vehiculos_inventario WHERE id = ?', [$id]);
        return;
    }

    $data = app_demo_read();
    $data['inventario'] = array_values(array_filter($data['inventario'], static fn(array $row): bool => (int) $row['id'] !== $id));
    app_demo_write($data);
}
