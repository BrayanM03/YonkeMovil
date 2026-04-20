<?php
require_once __DIR__ . '/backend/bootstrap.php';
require_once __DIR__ . '/backend/app_data.php';
require_once __DIR__ . '/includes/app_layout.php';

$controller_permiso->verificarSesion();
$controller_permiso->validarAcceso(1, CPermiso::VER_USUARIOS);

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = (string) ($_POST['accion'] ?? '');

    try {
        if ($accion === 'crear_usuario') {
            $nombre = trim((string) ($_POST['nombre'] ?? ''));
            $apellido = trim((string) ($_POST['apellido'] ?? ''));
            $usuario = trim((string) ($_POST['usuario'] ?? ''));
            $correo = trim((string) ($_POST['correo'] ?? '')) ?: null;
            $puesto = trim((string) ($_POST['puesto'] ?? '')) ?: null;
            $rolId = (int) ($_POST['rol_id'] ?? 0);
            $password = (string) ($_POST['password'] ?? '');
            if ($nombre === '' || $usuario === '' || $rolId <= 0 || $password === '') { throw new RuntimeException('Completa los campos obligatorios para crear el usuario.'); }
            app_usuario_crear($nombre, $apellido, $usuario, $correo, $puesto, $rolId, $password);
            header('Location: usuarios-roles.php?ok=1'); exit;
        }

        if ($accion === 'editar_usuario') {
            $id = (int) ($_POST['id'] ?? 0);
            $nombre = trim((string) ($_POST['nombre'] ?? ''));
            $apellido = trim((string) ($_POST['apellido'] ?? ''));
            $correo = trim((string) ($_POST['correo'] ?? '')) ?: null;
            $puesto = trim((string) ($_POST['puesto'] ?? '')) ?: null;
            $rolId = (int) ($_POST['rol_id'] ?? 0);
            $password = trim((string) ($_POST['password'] ?? ''));
            if ($id <= 0 || $nombre === '' || $rolId <= 0) { throw new RuntimeException('Datos inválidos para actualizar el usuario.'); }
            app_usuario_actualizar($id, $nombre, $apellido, $correo, $puesto, $rolId, $password !== '' ? $password : null);
            header('Location: usuarios-roles.php?ok=2'); exit;
        }

        if ($accion === 'estatus_usuario') {
            $id = (int) ($_POST['id'] ?? 0);
            $estatus = (int) ($_POST['estatus'] ?? 0);
            if ($id <= 0) { throw new RuntimeException('Usuario inválido.'); }
            if ($id === app_current_user_id()) { throw new RuntimeException('No puedes desactivar tu propio usuario.'); }
            app_usuario_cambiar_estatus($id, $estatus === 1 ? 1 : 0);
            header('Location: usuarios-roles.php?ok=3'); exit;
        }

        if ($accion === 'crear_rol') {
            $nombre = trim((string) ($_POST['nombre_rol'] ?? ''));
            if ($nombre === '') { throw new RuntimeException('El nombre del rol es obligatorio.'); }
            app_rol_crear($nombre);
            header('Location: usuarios-roles.php?ok=4'); exit;
        }

        if ($accion === 'editar_rol') {
            $id = (int) ($_POST['id'] ?? 0);
            $nombre = trim((string) ($_POST['nombre_rol'] ?? ''));
            if ($id <= 0 || $nombre === '') { throw new RuntimeException('Datos inválidos para actualizar rol.'); }
            app_rol_actualizar($id, $nombre);
            header('Location: usuarios-roles.php?ok=5'); exit;
        }

        if ($accion === 'estatus_rol') {
            $id = (int) ($_POST['id'] ?? 0);
            $estatus = (int) ($_POST['estatus'] ?? 0);
            if ($id <= 0) { throw new RuntimeException('Rol inválido.'); }
            if ($id === 2) { throw new RuntimeException('No puedes desactivar el rol admin.'); }
            app_rol_cambiar_estatus($id, $estatus === 1 ? 1 : 0);
            header('Location: usuarios-roles.php?ok=6'); exit;
        }
    } catch (Throwable $e) {
        $error = $e->getMessage();
    }
}

$editUserId = (int) ($_GET['edit_user'] ?? 0);
$editRoleId = (int) ($_GET['edit_role'] ?? 0);
$editUser = $editUserId > 0 ? app_usuario_obtener($editUserId) : null;
$editRole = $editRoleId > 0 ? app_rol_obtener($editRoleId) : null;

$usuarios = app_usuarios_roles();
$rolesActivos = app_roles(true);
$rolesGestion = app_roles(false);

render_app_layout_start('Usuarios y Roles | YonkeMovil', 'usuarios', 'Usuarios y Roles', 'Gestion de accesos del sistema');
?>
<?php if (!empty($_GET['ok'])): ?><div class="mb-4 rounded-xl border border-green-300 bg-green-50 text-green-700 px-4 py-3"><?php $m=(int)$_GET['ok']; $msg=[1=>'Usuario creado.',2=>'Usuario actualizado.',3=>'Estatus de usuario actualizado.',4=>'Rol creado.',5=>'Rol actualizado.',6=>'Estatus de rol actualizado.']; echo $msg[$m]??'Operación completada.'; ?></div><?php endif; ?>
<?php if ($error !== ''): ?><div class="mb-4 rounded-xl border border-red-300 bg-red-50 text-red-700 px-4 py-3"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div><?php endif; ?>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mb-6">
    <div class="xl:col-span-2 bg-white rounded-2xl shadow-sm p-6">
        <h3 class="text-lg font-bold text-yonke-dark mb-4"><?= $editUser ? 'Editar usuario' : 'Crear usuario'; ?></h3>
        <form method="post" class="grid grid-cols-1 md:grid-cols-3 gap-3">
            <input type="hidden" name="accion" value="<?= $editUser ? 'editar_usuario' : 'crear_usuario'; ?>">
            <?php if ($editUser): ?><input type="hidden" name="id" value="<?= (int)$editUser['id']; ?>"><?php endif; ?>
            <input name="nombre" class="border rounded-lg px-3 py-2" placeholder="Nombre" required value="<?= htmlspecialchars((string)($editUser['nombre'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>">
            <input name="apellido" class="border rounded-lg px-3 py-2" placeholder="Apellido" value="<?= htmlspecialchars((string)($editUser['apellido'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>">
            <input name="usuario" class="border rounded-lg px-3 py-2" placeholder="Usuario" <?= $editUser ? 'readonly' : 'required'; ?> value="<?= htmlspecialchars((string)($editUser['usuario'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>">
            <select name="rol_id" class="border rounded-lg px-3 py-2" required><?php foreach($rolesActivos as $r): ?><option value="<?= (int)$r['id']; ?>" <?= ((int)($editUser['rol_id']??0)===(int)$r['id'])?'selected':''; ?>><?= htmlspecialchars((string)$r['nombre'], ENT_QUOTES, 'UTF-8'); ?></option><?php endforeach; ?></select>
            <input name="puesto" class="border rounded-lg px-3 py-2" placeholder="Puesto" value="<?= htmlspecialchars((string)($editUser['puesto'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>">
            <input name="correo" type="email" class="border rounded-lg px-3 py-2" placeholder="Correo" value="<?= htmlspecialchars((string)($editUser['correo'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>">
            <input name="password" type="password" class="border rounded-lg px-3 py-2 md:col-span-2" placeholder="<?= $editUser ? 'Nueva contraseña (opcional)' : 'Contraseña'; ?>" <?= $editUser ? '' : 'required'; ?>>
            <button class="bg-yonke-yellow hover:bg-yonke-accent text-yonke-dark rounded-lg font-bold px-4"><?= $editUser ? 'Actualizar usuario' : 'Crear usuario'; ?></button>
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow-sm p-6">
        <h3 class="text-lg font-bold text-yonke-dark mb-4"><?= $editRole ? 'Editar rol' : 'Crear rol'; ?></h3>
        <form method="post" class="space-y-3">
            <input type="hidden" name="accion" value="<?= $editRole ? 'editar_rol' : 'crear_rol'; ?>">
            <?php if ($editRole): ?><input type="hidden" name="id" value="<?= (int)$editRole['id']; ?>"><?php endif; ?>
            <input name="nombre_rol" class="border rounded-lg px-3 py-2 w-full" placeholder="Nombre rol" required value="<?= htmlspecialchars((string)($editRole['nombre'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>">
            <button class="w-full border border-yonke-blue text-yonke-blue hover:bg-yonke-blue hover:text-white rounded-lg py-2"><?= $editRole ? 'Actualizar rol' : 'Crear rol'; ?></button>
        </form>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm overflow-hidden mb-6">
    <div class="px-6 py-5 border-b border-gray-100"><h3 class="text-lg font-bold text-yonke-dark">Usuarios</h3></div>
    <div class="p-4">
        <table class="js-table w-full text-sm">
            <thead><tr><th>ID</th><th>Nombre</th><th>Usuario</th><th>Rol</th><th>Estatus</th><th>Acciones</th></tr></thead>
            <tbody>
            <?php foreach($usuarios as $u): ?>
                <tr>
                    <td><?= (int)$u['id']; ?></td>
                    <td><?= htmlspecialchars(trim(($u['nombre'] ?? '').' '.($u['apellido'] ?? '')), ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?= htmlspecialchars((string)$u['usuario'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?= htmlspecialchars((string)$u['rol'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?= ((int)($u['estatus'] ?? 0)===1)?'Activo':'Inactivo'; ?></td>
                    <td>
                        <a href="usuarios-roles.php?edit_user=<?= (int)$u['id']; ?>" class="inline-flex px-2 py-1 rounded border border-blue-300 text-blue-700 mr-2">Editar</a>
                        <?php if ((int)$u['id'] !== app_current_user_id()): ?>
                        <form method="post" class="inline">
                            <input type="hidden" name="accion" value="estatus_usuario"><input type="hidden" name="id" value="<?= (int)$u['id']; ?>"><input type="hidden" name="estatus" value="<?= ((int)$u['estatus']===1)?0:1; ?>">
                            <button class="inline-flex px-2 py-1 rounded border <?= ((int)$u['estatus']===1)?'border-yellow-400 text-yellow-700':'border-green-400 text-green-700'; ?>"><?= ((int)$u['estatus']===1)?'Desactivar':'Activar'; ?></button>
                        </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100"><h3 class="text-lg font-bold text-yonke-dark">Roles</h3></div>
    <div class="p-4">
        <table class="js-table w-full text-sm">
            <thead><tr><th>ID</th><th>Nombre</th><th>Estatus</th><th>Acciones</th></tr></thead>
            <tbody>
            <?php foreach($rolesGestion as $r): ?>
                <tr>
                    <td><?= (int)$r['id']; ?></td>
                    <td><?= htmlspecialchars((string)$r['nombre'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?= ((int)($r['estatus'] ?? 0)===1)?'Activo':'Inactivo'; ?></td>
                    <td>
                        <a href="usuarios-roles.php?edit_role=<?= (int)$r['id']; ?>" class="inline-flex px-2 py-1 rounded border border-blue-300 text-blue-700 mr-2">Editar</a>
                        <form method="post" class="inline">
                            <input type="hidden" name="accion" value="estatus_rol"><input type="hidden" name="id" value="<?= (int)$r['id']; ?>"><input type="hidden" name="estatus" value="<?= ((int)$r['estatus']===1)?0:1; ?>">
                            <button class="inline-flex px-2 py-1 rounded border <?= ((int)$r['estatus']===1)?'border-yellow-400 text-yellow-700':'border-green-400 text-green-700'; ?>" <?= ((int)$r['id']===2)?'disabled':''; ?>><?= ((int)$r['estatus']===1)?'Desactivar':'Activar'; ?></button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php render_app_layout_end(); ?>
