<?php
require_once __DIR__ . '/../../config/conexion.php';

class Conectando
{
    public function conexion(): PDO
    {
        $db = new Database();
        return $db->pdo();
    }
}

$conectando = new Conectando();
