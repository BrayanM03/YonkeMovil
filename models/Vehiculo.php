<?php
require_once __DIR__ . '/../config/conexion.php';

class Vehiculo
{
    private Database $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function listarMarcasPorAno(int $anio): array
    {
        return $this->db->select('SELECT DISTINCT marca FROM catalogo_autos WHERE anio = ? ORDER BY marca ASC', [$anio]);
    }

    public function listarModelos(int $anio, string $marca): array
    {
        $sql = 'SELECT DISTINCT modelo FROM catalogo_autos WHERE anio = ? AND marca = ? ORDER BY modelo ASC';
        return $this->db->select($sql, [$anio, $marca]);
    }

    public function crear(array $data): int
    {
        return $this->db->insert('vehiculos_inventario', $data);
    }

    public function listarPorUsuario(int $usuarioId): array
    {
        $sql = "SELECT vi.id, vi.anio, vi.modelo, vi.marca, vi.stock, vi.cantidad, vi.estatus,
                       DATE_FORMAT(vi.fecha_registro, '%Y-%m-%d %H:%i') AS fecha
                FROM vehiculos_inventario vi
                INNER JOIN yonkes y ON y.id = vi.yonke_id
                WHERE y.usuario_id = ?
                ORDER BY vi.id DESC";
        return $this->db->select($sql, [$usuarioId]);
    }

    public function eliminar(int $id, int $usuarioId): bool
    {
        $sql = "UPDATE vehiculos_inventario vi
                INNER JOIN yonkes y ON y.id = vi.yonke_id
                SET vi.estatus = 0
                WHERE vi.id = ? AND y.usuario_id = ?";
        $count = $this->db->query($sql, [$id, $usuarioId])->rowCount();
        return $count > 0;
    }
}
