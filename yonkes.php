<?php
require_once __DIR__ . '/backend/bootstrap.php';
require_once __DIR__ . '/backend/app_data.php';
require_once __DIR__ . '/includes/app_layout.php';

$controller_permiso->verificarSesion();
$controller_permiso->validarAcceso(1, CPermiso::VER_YONKES);

$userId = app_current_user_id();
$isAdmin = app_is_admin_user();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = (string) ($_POST['accion'] ?? 'crear');

    try {
        if ($accion === 'crear') {
            $nombre = trim((string) ($_POST['nombre'] ?? ''));
            $telefono = trim((string) ($_POST['telefono'] ?? ''));
            $direccion = trim((string) ($_POST['direccion'] ?? ''));
            $propietarioId = $isAdmin ? (int) ($_POST['usuario_id'] ?? 0) : null;
            if ($nombre === '') { throw new RuntimeException('El nombre del yonke es obligatorio.'); }
            app_yonke_crear($userId, $nombre, $telefono, $direccion, $propietarioId);
            header('Location: yonkes.php?ok=1'); exit;
        }

        if ($accion === 'editar') {
            $id = (int) ($_POST['id'] ?? 0);
            $nombre = trim((string) ($_POST['nombre'] ?? ''));
            $telefono = trim((string) ($_POST['telefono'] ?? ''));
            $direccion = trim((string) ($_POST['direccion'] ?? ''));
            $propietarioId = $isAdmin ? (int) ($_POST['usuario_id'] ?? 0) : null;
            if ($id <= 0 || $nombre === '') { throw new RuntimeException('Datos inválidos para actualizar yonke.'); }
            app_yonke_actualizar($id, $userId, $nombre, $telefono, $direccion, $propietarioId);
            header('Location: yonkes.php?ok=2'); exit;
        }

        if ($accion === 'estatus') {
            $id = (int) ($_POST['id'] ?? 0);
            $estatus = (int) ($_POST['estatus'] ?? 0);
            if ($id <= 0) { throw new RuntimeException('ID inválido para actualizar estatus.'); }
            app_yonke_cambiar_estatus($id, $userId, $estatus === 1 ? 1 : 0);
            header('Location: yonkes.php?ok=3'); exit;
        }
    } catch (Throwable $e) {
        $error = $e->getMessage();
    }
}

$editId = (int) ($_GET['edit'] ?? 0);
$editYonke = $editId > 0 ? app_yonke_obtener($editId, $userId) : null;
$yonkes = app_yonkes_gestion($userId);
$usuarios = app_usuarios_roles();

render_app_layout_start('Gestionar Yonkes | YonkeMovil', 'yonkes', 'Gestionar Yonkes', 'Administracion de sucursales');
?>
<?php if (!empty($_GET['ok'])): ?><div class="mb-4 rounded-xl border border-green-300 bg-green-50 text-green-700 px-4 py-3"><?php $m=(int)$_GET['ok']; echo $m===1?'Yonke registrado correctamente.':($m===2?'Yonke actualizado correctamente.':'Estatus de yonke actualizado.'); ?></div><?php endif; ?>
<?php if ($error !== ''): ?><div class="mb-4 rounded-xl border border-red-300 bg-red-50 text-red-700 px-4 py-3"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div><?php endif; ?>

<div class="bg-white rounded-2xl shadow-sm p-6 mb-6">
    <h3 class="text-lg font-bold text-yonke-dark mb-4"><?= $editYonke ? 'Editar yonke' : 'Agregar yonke'; ?></h3>
    <form method="post" class="grid grid-cols-1 md:grid-cols-6 gap-3">
        <input type="hidden" name="accion" value="<?= $editYonke ? 'editar' : 'crear'; ?>">
        <?php if ($editYonke): ?><input type="hidden" name="id" value="<?= (int)$editYonke['id']; ?>"><?php endif; ?>

        <input name="nombre" class="border rounded-lg px-3 py-2" placeholder="Nombre" required value="<?= htmlspecialchars((string)($editYonke['nombre'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>">
        <input name="telefono" class="border rounded-lg px-3 py-2" placeholder="Teléfono" value="<?= htmlspecialchars((string)($editYonke['telefono'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>">
        <input name="direccion" class="border rounded-lg px-3 py-2" placeholder="Dirección" value="<?= htmlspecialchars((string)($editYonke['direccion'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>">

        <?php if ($isAdmin): ?>
        <select name="usuario_id" class="border rounded-lg px-3 py-2" required>
            <?php foreach ($usuarios as $u): ?>
            <option value="<?= (int)$u['id']; ?>" <?= ((int)($editYonke['usuario_id'] ?? 0)===(int)$u['id'])?'selected':''; ?>><?= htmlspecialchars((string)$u['usuario'], ENT_QUOTES, 'UTF-8'); ?></option>
            <?php endforeach; ?>
        </select>
        <?php endif; ?>

        <button class="bg-yonke-yellow hover:bg-yonke-accent text-yonke-dark rounded-lg font-bold px-4"><?= $editYonke ? 'Actualizar' : 'Guardar'; ?></button>
        <?php if ($editYonke): ?><a href="yonkes.php" class="rounded-lg border px-4 py-2 text-center">Cancelar</a><?php endif; ?>
    </form>
</div>

<div class="bg-white rounded-2xl shadow-sm overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100"><h3 class="text-lg font-bold text-yonke-dark">Listado de yonkes</h3></div>
    <div class="p-4">
        <table class="js-table w-full text-sm">
            <thead><tr><th>ID</th><th>Nombre</th><th>Teléfono</th><th>Dirección</th><?php if($isAdmin): ?><th>Propietario</th><?php endif; ?><th>Estatus</th><th>Acciones</th></tr></thead>
            <tbody>
            <?php foreach ($yonkes as $row): ?>
                <tr>
                    <td><?= (int)$row['id']; ?></td>
                    <td><?= htmlspecialchars((string)$row['nombre'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?= htmlspecialchars((string)($row['telefono'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?= htmlspecialchars((string)($row['direccion'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
                    <?php if($isAdmin): ?><td><?= htmlspecialchars((string)($row['propietario'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td><?php endif; ?>
                    <td><?= ((int)($row['estatus'] ?? 0) === 1) ? 'Activo' : 'Inactivo'; ?></td>
                    <td>
                        <a href="yonkes.php?edit=<?= (int)$row['id']; ?>" class="inline-flex px-2 py-1 rounded border border-blue-300 text-blue-700 mr-2">Editar</a>
                        <form method="post" class="inline">
                            <input type="hidden" name="accion" value="estatus">
                            <input type="hidden" name="id" value="<?= (int)$row['id']; ?>">
                            <input type="hidden" name="estatus" value="<?= ((int)$row['estatus'] === 1) ? 0 : 1; ?>">
                            <button class="inline-flex px-2 py-1 rounded border <?= ((int)$row['estatus']===1)?'border-yellow-400 text-yellow-700':'border-green-400 text-green-700'; ?>"><?= ((int)$row['estatus']===1)?'Desactivar':'Activar'; ?></button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php render_app_layout_end(); ?>
