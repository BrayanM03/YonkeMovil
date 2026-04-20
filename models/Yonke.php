<?php
require_once __DIR__ . '/../config/conexion.php';

class Yonke
{
    private Database $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function listarPorUsuario(int $usuarioId): array
    {
        $sql = 'SELECT id AS id_yonke, nombre FROM yonkes WHERE usuario_id = ? AND estatus = 1 ORDER BY nombre ASC';
        return $this->db->select($sql, [$usuarioId]);
    }
}
