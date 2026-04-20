<?php
require_once __DIR__ . '/backend/bootstrap.php';
require_once __DIR__ . '/backend/app_data.php';
require_once __DIR__ . '/includes/app_layout.php';

$controller_permiso->verificarSesion();
$controller_permiso->validarAcceso(1, CPermiso::VER_CATALOGO_AUTOS);

$catalogo = app_catalogo_autos();

render_app_layout_start('Catalogo de Autos | YonkeMovil', 'catalogo', 'Catalogo de Autos', 'Listado maestro de modelos');
?>
<div class="bg-white rounded-2xl shadow-sm overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100">
        <h3 class="text-lg font-bold text-yonke-dark">Modelos disponibles</h3>
        <p class="text-sm text-gray-500">Usa el buscador superior o los filtros de la tabla.</p>
    </div>
    <div class="p-4">
        <table class="js-table w-full text-sm">
            <thead><tr><th>#</th><th>Año</th><th>Marca</th><th>Modelo</th></tr></thead>
            <tbody>
            <?php foreach ($catalogo as $i => $row): ?>
                <tr>
                    <td><?= $i + 1; ?></td>
                    <td><?= (int)$row['anio']; ?></td>
                    <td><?= htmlspecialchars((string)$row['marca'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?= htmlspecialchars((string)$row['modelo'], ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php render_app_layout_end(); ?>
