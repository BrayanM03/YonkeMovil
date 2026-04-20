<?php
require_once __DIR__ . '/backend/bootstrap.php';
require_once __DIR__ . '/backend/app_data.php';
require_once __DIR__ . '/includes/app_layout.php';

$controller_permiso->verificarSesion();
$controller_permiso->validarAcceso(1, CPermiso::VER_MI_INVENTARIO);

$userId = app_current_user_id();
$id = (int) ($_GET['id'] ?? $_POST['id'] ?? 0);

if ($id <= 0) {
    header('Location: mi-inventario.php?error=' . rawurlencode('Registro inválido.'));
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $yonkeId = (int) ($_POST['yonke_id'] ?? 0);
        $anio = (int) ($_POST['anio'] ?? 0);
        $marca = trim((string) ($_POST['marca'] ?? ''));
        $modelo = trim((string) ($_POST['modelo'] ?? ''));
        $cantidad = max(1, (int) ($_POST['cantidad'] ?? 1));
        $estatus = (int) ($_POST['estatus'] ?? 1);

        if ($yonkeId <= 0 || $anio < 1930 || $anio > 2035 || $marca === '' || $modelo === '') {
            throw new RuntimeException('Completa correctamente los datos del registro.');
        }

        app_inventario_actualizar($id, $userId, $yonkeId, $anio, $marca, $modelo, $cantidad, $estatus);
        header('Location: mi-inventario.php?ok=1');
        exit;
    } catch (Throwable $e) {
        $error = $e->getMessage();
    }
}

$item = app_inventario_obtener($id, $userId);
if (!$item) {
    header('Location: mi-inventario.php?error=' . rawurlencode('No se encontró el registro.'));
    exit;
}

$yonkes = app_yonkes_disponibles_inventario($userId);
$fotos = app_inventario_fotos($id, $userId);

render_app_layout_start('Editar Inventario | YonkeMovil', 'inventario', 'Editar registro', 'Actualiza datos de la unidad');
?>
<?php if ($error !== ''): ?><div class="mb-4 rounded-xl border border-red-300 bg-red-50 text-red-700 px-4 py-3"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div><?php endif; ?>

<div class="bg-white rounded-2xl shadow-sm p-6 mb-6">
  <div class="flex items-center justify-between mb-4">
    <h3 class="text-lg font-bold text-yonke-dark">Registro #<?= (int)$item['id']; ?></h3>
    <a href="mi-inventario.php" class="inline-flex items-center px-3 py-2 border rounded-lg text-sm hover:bg-gray-50">Volver</a>
  </div>

  <form method="post" class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <input type="hidden" name="id" value="<?= (int)$item['id']; ?>">

    <div>
      <label class="block text-sm text-gray-600 mb-1">Yonke</label>
      <select name="yonke_id" class="w-full border rounded-lg px-3 py-2" required>
        <?php foreach ($yonkes as $y): ?>
          <option value="<?= (int)$y['id']; ?>" <?= ((int)$item['yonke_id'] === (int)$y['id']) ? 'selected' : ''; ?>><?= htmlspecialchars((string)$y['nombre'], ENT_QUOTES, 'UTF-8'); ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div>
      <label class="block text-sm text-gray-600 mb-1">Año</label>
      <input name="anio" type="number" min="1930" max="2035" class="w-full border rounded-lg px-3 py-2" value="<?= (int)$item['anio']; ?>" required>
    </div>

    <div>
      <label class="block text-sm text-gray-600 mb-1">Marca</label>
      <input name="marca" type="text" class="w-full border rounded-lg px-3 py-2" value="<?= htmlspecialchars((string)$item['marca'], ENT_QUOTES, 'UTF-8'); ?>" required>
    </div>

    <div>
      <label class="block text-sm text-gray-600 mb-1">Modelo</label>
      <input name="modelo" type="text" class="w-full border rounded-lg px-3 py-2" value="<?= htmlspecialchars((string)$item['modelo'], ENT_QUOTES, 'UTF-8'); ?>" required>
    </div>

    <div>
      <label class="block text-sm text-gray-600 mb-1">Cantidad</label>
      <input name="cantidad" type="number" min="1" class="w-full border rounded-lg px-3 py-2" value="<?= (int)$item['cantidad']; ?>" required>
    </div>
 
    <div>
      <label class="block text-sm text-gray-600 mb-1">Estatus</label>
      <select name="estatus" class="w-full border rounded-lg px-3 py-2" required>
        <option value="1" <?= ((int)$item['estatus'] === 1) ? 'selected' : ''; ?>>Activo</option>
        <option value="0" <?= ((int)$item['estatus'] === 0) ? 'selected' : ''; ?>>Inactivo</option>
      </select>
    </div>

    <div class="md:col-span-2 mt-2">
      <button class="bg-yonke-yellow hover:bg-yonke-accent text-yonke-dark font-bold px-5 py-2 rounded-lg">Guardar cambios</button>
      <a href="mi-inventario-nuevo.php" class="ml-3 text-sm text-yonke-blue underline">Agregar más fotos desde nuevo registro</a>
    </div>
  </form>
</div>

<div class="bg-white rounded-2xl shadow-sm p-6">
  <h3 class="text-lg font-bold text-yonke-dark mb-4">Fotos del auto</h3>
  <?php if (!$fotos): ?>
    <p class="text-sm text-gray-500">Este registro no tiene fotos cargadas.</p>
  <?php else: ?>
    <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
      <?php foreach ($fotos as $f): ?>
        <div class="rounded-lg overflow-hidden border bg-gray-50">
          <img src="<?= htmlspecialchars((string)$f['foto_path'], ENT_QUOTES, 'UTF-8'); ?>" alt="Foto" class="w-full h-32 object-cover">
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>
<?php render_app_layout_end(); ?>
