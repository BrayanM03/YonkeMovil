<?php
require_once __DIR__ . '/backend/bootstrap.php';
require_once __DIR__ . '/backend/app_data.php';
require_once __DIR__ . '/includes/app_layout.php';

$controller_permiso->verificarSesion();
$controller_permiso->validarAcceso(1, CPermiso::VER_PANEL_CLIENTE);

$inventario = app_inventario_usuario(app_current_user_id());
$yonkes = app_yonkes_usuario(app_current_user_id());
$catalogo = app_catalogo_autos();

render_app_layout_start('Dashboard Cliente | YonkeMovil', 'dashboard', 'Panel del Cliente', 'Tu operacion diaria');
?>
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-2xl shadow-sm p-6 flex items-center border-l-4 border-yonke-yellow">
        <div class="p-4 rounded-full bg-yellow-100 text-yonke-accent mr-4"><i data-lucide="car" class="w-8 h-8"></i></div>
        <div><p class="text-sm text-gray-500 uppercase tracking-wider">Mis Unidades</p><p class="text-3xl font-bold text-yonke-dark"><?= count($inventario); ?></p></div>
    </div>
    <div class="bg-white rounded-2xl shadow-sm p-6 flex items-center border-l-4 border-yonke-blue">
        <div class="p-4 rounded-full bg-blue-100 text-yonke-blue mr-4"><i data-lucide="building" class="w-8 h-8"></i></div>
        <div><p class="text-sm text-gray-500 uppercase tracking-wider">Mis Yonkes</p><p class="text-3xl font-bold text-yonke-dark"><?= count($yonkes); ?></p></div>
    </div>
    <div class="bg-white rounded-2xl shadow-sm p-6 flex items-center border-l-4 border-green-500">
        <div class="p-4 rounded-full bg-green-100 text-green-600 mr-4"><i data-lucide="database" class="w-8 h-8"></i></div>
        <div><p class="text-sm text-gray-500 uppercase tracking-wider">Catálogo general</p><p class="text-3xl font-bold text-yonke-dark"><?= count($catalogo); ?></p></div>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
        <div><h3 class="text-lg font-bold text-yonke-dark">Mi inventario reciente</h3></div>
        <a href="mi-inventario.php" class="inline-flex items-center px-4 py-2 bg-yonke-yellow hover:bg-yonke-accent text-yonke-dark rounded-lg font-bold"><i data-lucide="plus-circle" class="w-5 h-5 mr-2"></i>Agregar unidad</a>
    </div>
    <div class="p-4">
        <table class="js-table w-full text-sm">
            <thead><tr><th>ID</th><th>Yonke</th><th>Año</th><th>Marca</th><th>Modelo</th><th>Cantidad</th><th>Estatus</th></tr></thead>
            <tbody>
            <?php foreach ($inventario as $row): ?>
                <tr>
                    <td><?= (int)$row['id']; ?></td>
                    <td><?= htmlspecialchars((string)($row['yonke'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?= (int)$row['anio']; ?></td>
                    <td><?= htmlspecialchars((string)$row['marca'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?= htmlspecialchars((string)$row['modelo'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?= (int)($row['cantidad'] ?? 0); ?></td>
                    <td><?= ((int)($row['estatus'] ?? 0) === 1) ? 'Activo' : 'Inactivo'; ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php render_app_layout_end(); ?>
