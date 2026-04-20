<?php
require_once __DIR__ . '/../models/Usuario.php';

class AuthController
{
    public function login(string $username, string $password): array
    {
        $usuarioModel = new Usuario();
        $usuario = $usuarioModel->obtenerPorUsuario($username);

        if (!$usuario) {
            return ['estado' => 2];
        }

        if ((int) $usuario['estatus'] !== 1) {
            return ['estado' => 4];
        }

        if (!password_verify($password, $usuario['contrasena'])) {
            return ['estado' => 3];
        }

        $_SESSION['sistema'] = 'yonkemovil';
        $_SESSION['id'] = (int) $usuario['id'];
        $_SESSION['nombre'] = $usuario['nombre'];
        $_SESSION['apellido'] = $usuario['apellido'];
        $_SESSION['user'] = $usuario['usuario'];
        $_SESSION['username'] = $usuario['usuario'];
        $_SESSION['rol'] = (int) $usuario['rol_id'];
        $_SESSION['rol_nombre'] = $usuario['nombre_rol'];
        $_SESSION['estatus'] = (int) $usuario['estatus'];
        $_SESSION['puesto'] = $usuario['puesto'] ?: $usuario['nombre_rol'];
        $_SESSION['foto_perfil'] = $usuario['foto_perfil'] ?? '';

        return [
            'estado' => 1,
            'rol' => (int) $usuario['rol_id'],
        ];
    }
}
