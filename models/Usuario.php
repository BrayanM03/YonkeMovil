<?php
require_once __DIR__ . '/../config/conexion.php';

class Usuario
{
    private Database $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function obtenerPorUsuario(string $username): ?array
    {
        $sql = "SELECT u.*, r.nombre AS nombre_rol
                FROM usuarios u
                INNER JOIN roles r ON r.id = u.rol_id
                WHERE u.usuario = ?
                LIMIT 1";
        return $this->db->one($sql, [$username]);
    }

    public function obtenerPorId(int $id): ?array
    {
        $sql = "SELECT u.*, r.nombre AS nombre_rol
                FROM usuarios u
                INNER JOIN roles r ON r.id = u.rol_id
                WHERE u.id = ?
                LIMIT 1";
        return $this->db->one($sql, [$id]);
    }
}
