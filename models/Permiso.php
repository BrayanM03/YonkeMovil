<?php
require_once __DIR__ . '/../config/conexion.php';

class Permiso
{
    private Database $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function verificarPermiso(int $rolId, int $usuarioId, string $slug): array
    {
        $sql = "SELECT
                    CASE
                        WHEN pu.activo IS NOT NULL THEN pu.activo
                        WHEN pr.activo IS NOT NULL THEN pr.activo
                        ELSE 0
                    END AS tiene_acceso
                FROM permisos p
                LEFT JOIN permisos_roles pr ON pr.permiso_id = p.id AND pr.rol_id = ?
                LEFT JOIN permisos_usuarios pu ON pu.permiso_id = p.id AND pu.usuario_id = ?
                WHERE p.slug = ? AND p.estatus = 1
                LIMIT 1";

        $res = $this->db->one($sql, [$rolId, $usuarioId, $slug]);
        $ok = $res ? (int) $res['tiene_acceso'] === 1 : false;

        return [
            'estatus' => $ok,
            'mensaje' => $ok ? 'Tiene permiso' : 'No tiene permiso',
        ];
    }
}
