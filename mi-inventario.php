<?php
require_once __DIR__ . '/backend/bootstrap.php';
require_once __DIR__ . '/backend/app_data.php';
require_once __DIR__ . '/includes/app_layout.php';

$controller_permiso->verificarSesion();
$controller_permiso->validarAcceso(1, CPermiso::VER_MI_INVENTARIO);

$userId = app_current_user_id();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = (string) ($_POST['accion'] ?? '');
    try {
        if ($accion === 'eliminar') {
            $id = (int) ($_POST['id'] ?? 0);
            if ($id <= 0) {
                throw new RuntimeException('ID inválido para eliminar.');
            }
            app_inventario_eliminar($id, $userId);
            header('Location: mi-inventario.php?ok=2');
            exit;
        }
    } catch (Throwable $e) {
        header('Location: mi-inventario.php?error=' . rawurlencode($e->getMessage()));
        exit;
    }
}

$inventario = app_inventario_usuario($userId);
$yonkes = app_yonkes_disponibles_inventario($userId);

render_app_layout_start('Mi Inventario | YonkeMovil', 'inventario', 'Mi Inventario', 'Control de unidades por yonke');
?>
<?php if (!empty($_GET['ok'])): ?><div class="mb-4 rounded-xl border border-green-300 bg-green-50 text-green-700 px-4 py-3"><?php $ok=(int)$_GET['ok']; echo $ok===2?'Registro eliminado correctamente.':'Registro agregado correctamente.'; ?></div><?php endif; ?>
<?php if (!empty($_GET['error'])): ?><div class="mb-4 rounded-xl border border-red-300 bg-red-50 text-red-700 px-4 py-3"><?= htmlspecialchars((string)$_GET['error'], ENT_QUOTES, 'UTF-8'); ?></div><?php endif; ?>
<?php if (!$yonkes): ?><div class="mb-4 rounded-xl border border-amber-300 bg-amber-50 text-amber-700 px-4 py-3">No hay yonkes disponibles para registrar unidades. Primero agrega un yonke activo en <a class="underline font-semibold" href="yonkes.php">Gestionar Yonkes</a>.</div><?php endif; ?>

<div class="bg-white rounded-2xl shadow-sm p-6 mb-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
        <div>
            <h3 class="text-lg font-bold text-yonke-dark">Agregar unidad con fotos</h3>
            <p class="text-sm text-gray-500">Nuevo formulario con drag & drop y progreso de subida.</p>
        </div>
        <a href="mi-inventario-nuevo.php" class="inline-flex items-center px-4 py-2 bg-yonke-yellow hover:bg-yonke-accent text-yonke-dark rounded-lg font-bold">
            <i data-lucide="plus-circle" class="w-5 h-5 mr-2"></i>Agregar auto
        </a>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100"><h3 class="text-lg font-bold text-yonke-dark">Unidades registradas</h3></div>
    <div class="p-4">
        <table class="js-table w-full text-sm">
            <thead><tr><th>ID</th><th>Foto</th><th>Yonke</th><th>Año</th><th>Marca</th><th>Modelo</th><th>Cantidad</th><th>Estatus</th><th>Acciones</th></tr></thead>
            <tbody>
            <?php foreach ($inventario as $row): ?>
                <tr>
                    <td><?= (int)$row['id']; ?></td>
                    <td>
                        <?php if (!empty($row['foto_principal'])): ?>
                            <img src="<?= htmlspecialchars((string)$row['foto_principal'], ENT_QUOTES, 'UTF-8'); ?>" alt="Foto auto" class="w-14 h-10 object-cover rounded">
                        <?php else: ?>
                            <span class="text-xs text-gray-500">Sin foto</span>
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars((string)($row['yonke'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?= (int)$row['anio']; ?></td>
                    <td><?= htmlspecialchars((string)$row['marca'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?= htmlspecialchars((string)$row['modelo'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?= (int)($row['cantidad'] ?? 0); ?></td>
                    <td><?= ((int)($row['estatus'] ?? 0) === 1) ? 'Activo' : 'Inactivo'; ?></td>
                    <td>
                        <a href="mi-inventario-editar.php?id=<?= (int)$row['id']; ?>" class="inline-flex px-2 py-1 rounded border border-blue-300 text-blue-700 mr-2">Editar</a>
                        <form method="post" class="inline" onsubmit="return confirm('¿Eliminar este registro y sus fotos?');">
                            <input type="hidden" name="accion" value="eliminar">
                            <input type="hidden" name="id" value="<?= (int)$row['id']; ?>">
                            <button class="inline-flex px-2 py-1 rounded border border-red-300 text-red-700">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php render_app_layout_end(); ?>
