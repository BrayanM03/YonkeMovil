<?php
require_once __DIR__ . '/backend/bootstrap.php';
require_once __DIR__ . '/backend/app_data.php';
require_once __DIR__ . '/includes/app_layout.php';

$controller_permiso->verificarSesion();
$controller_permiso->validarAcceso(1, CPermiso::VER_MI_INVENTARIO);

$yonkes = app_yonkes_disponibles_inventario(app_current_user_id());
$sinYonkes = empty($yonkes);

render_app_layout_start('Agregar Auto | YonkeMovil', 'inventario', 'Nuevo registro de auto', 'Sube fotos y datos de la unidad');
?>
<div class="bg-white rounded-2xl shadow-sm p-6 mb-6">
  <div class="flex items-center justify-between mb-4">
    <h3 class="text-lg font-bold text-yonke-dark">Alta de unidad</h3>
    <a href="mi-inventario.php" class="inline-flex items-center px-3 py-2 border rounded-lg text-sm hover:bg-gray-50">Volver a inventario</a>
  </div>

  <?php if ($sinYonkes): ?>
    <div class="mb-4 rounded-xl border border-amber-300 bg-amber-50 text-amber-700 px-4 py-3">
      No hay yonkes activos para cargar autos. Registra uno en <a href="yonkes.php" class="underline font-semibold">Gestionar Yonkes</a>.
    </div>
  <?php endif; ?>

  <form id="form-auto" class="grid grid-cols-1 md:grid-cols-2 gap-4" enctype="multipart/form-data">
    <div>
      <label class="block text-sm text-gray-600 mb-1">Yonke</label>
      <select name="yonke_id" class="w-full border rounded-lg px-3 py-2" required <?= $sinYonkes ? 'disabled' : ''; ?>>
        <option value="">Selecciona un yonke</option>
        <?php foreach ($yonkes as $y): ?>
          <option value="<?= (int)$y['id']; ?>"><?= htmlspecialchars((string)$y['nombre'], ENT_QUOTES, 'UTF-8'); ?><?= !empty($y['propietario']) ? ' - ' . htmlspecialchars((string)$y['propietario'], ENT_QUOTES, 'UTF-8') : ''; ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div>
      <label class="block text-sm text-gray-600 mb-1">Año</label>
      <input name="anio" type="number" min="1930" max="2035" class="w-full border rounded-lg px-3 py-2" required>
    </div>

    <div>
      <label class="block text-sm text-gray-600 mb-1">Marca</label>
      <input name="marca" type="text" class="w-full border rounded-lg px-3 py-2" required>
    </div>

    <div>
      <label class="block text-sm text-gray-600 mb-1">Modelo</label>
      <input name="modelo" type="text" class="w-full border rounded-lg px-3 py-2" required>
    </div>

    <div>
      <label class="block text-sm text-gray-600 mb-1">Cantidad</label>
      <input name="cantidad" type="number" min="1" value="1" class="w-full border rounded-lg px-3 py-2" required>
    </div>

    <div class="md:col-span-2">
      <label class="block text-sm text-gray-600 mb-2">Fotos del auto</label>
      <div id="drop-zone" class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center bg-gray-50 hover:bg-gray-100 transition-colors cursor-pointer">
        <p class="text-sm text-gray-600">Arrastra y suelta fotos aquí o <span class="text-yonke-blue font-semibold">haz clic para seleccionar</span></p>
        <p class="text-xs text-gray-400 mt-1">Formato: JPG, JPEG, PNG, WEBP</p>
        <input id="fotos" name="fotos[]" type="file" accept=".jpg,.jpeg,.png,.webp" multiple class="hidden">
      </div>

      <div id="preview" class="grid grid-cols-2 md:grid-cols-5 gap-3 mt-4"></div>

      <div class="mt-4">
        <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
          <div id="progress-bar" class="h-2 bg-yonke-yellow w-0 transition-all"></div>
        </div>
        <div id="progress-text" class="text-xs text-gray-500 mt-1">Sin iniciar</div>
      </div>
    </div>

    <div class="md:col-span-2 flex items-center gap-3 mt-2">
      <button id="btn-submit" class="bg-yonke-yellow hover:bg-yonke-accent text-yonke-dark font-bold px-5 py-2 rounded-lg <?= $sinYonkes ? 'opacity-50 cursor-not-allowed' : ''; ?>" <?= $sinYonkes ? 'disabled' : ''; ?>>Guardar auto</button>
      <span id="status" class="text-sm text-gray-500"></span>
    </div>
  </form>
</div>

<script>
(function() {
  const dropZone = document.getElementById('drop-zone');
  const input = document.getElementById('fotos');
  const preview = document.getElementById('preview');
  const form = document.getElementById('form-auto');
  const progressBar = document.getElementById('progress-bar');
  const progressText = document.getElementById('progress-text');
  const status = document.getElementById('status');
  const submit = document.getElementById('btn-submit');

  let files = [];

  function renderPreview() {
    preview.innerHTML = '';
    files.forEach((file, idx) => {
      const card = document.createElement('div');
      card.className = 'relative rounded-lg overflow-hidden border bg-white';
      const img = document.createElement('img');
      img.className = 'w-full h-28 object-cover';
      img.src = URL.createObjectURL(file);
      const btn = document.createElement('button');
      btn.type = 'button';
      btn.className = 'absolute top-1 right-1 bg-black/70 text-white rounded-full w-6 h-6 text-xs';
      btn.textContent = 'x';
      btn.addEventListener('click', () => {
        files.splice(idx, 1);
        renderPreview();
      });
      card.appendChild(img);
      card.appendChild(btn);
      preview.appendChild(card);
    });
  }

  function addFiles(fileList) {
    const allowed = ['image/jpeg', 'image/png', 'image/webp'];
    Array.from(fileList).forEach(f => {
      if (allowed.includes(f.type)) files.push(f);
    });
    renderPreview();
  }

  dropZone.addEventListener('click', () => input.click());
  input.addEventListener('change', (e) => addFiles(e.target.files));

  ['dragenter', 'dragover'].forEach(evt => dropZone.addEventListener(evt, (e) => {
    e.preventDefault(); e.stopPropagation(); dropZone.classList.add('border-yonke-blue');
  }));

  ['dragleave', 'drop'].forEach(evt => dropZone.addEventListener(evt, (e) => {
    e.preventDefault(); e.stopPropagation(); dropZone.classList.remove('border-yonke-blue');
  }));

  dropZone.addEventListener('drop', (e) => addFiles(e.dataTransfer.files));

  form.addEventListener('submit', (e) => {
    e.preventDefault();

    if (files.length === 0) {
      status.textContent = 'Debes agregar al menos una foto del auto.';
      status.className = 'text-sm text-red-600';
      return;
    }

    const fd = new FormData(form);
    files.forEach(f => fd.append('fotos[]', f));

    submit.disabled = true;
    status.textContent = 'Subiendo...';
    progressText.textContent = '0%';
    progressBar.style.width = '0%';

    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'backend/inventario/subir-auto.php', true);

    xhr.upload.addEventListener('progress', (ev) => {
      if (!ev.lengthComputable) return;
      const percent = Math.round((ev.loaded / ev.total) * 100);
      progressBar.style.width = percent + '%';
      progressText.textContent = percent + '% cargado';
    });

    xhr.onreadystatechange = function() {
      if (xhr.readyState !== 4) return;
      submit.disabled = false;
      let resp = { ok: false, message: 'Error inesperado' };
      try { resp = JSON.parse(xhr.responseText || '{}'); } catch (_) {}

      if (xhr.status >= 200 && xhr.status < 300 && resp.ok) {
        status.textContent = 'Auto registrado correctamente';
        status.className = 'text-sm text-green-600';
        progressText.textContent = 'Carga completada';
        setTimeout(() => { window.location.href = 'mi-inventario.php?ok=1'; }, 700);
      } else {
        status.textContent = resp.message || 'No se pudo guardar';
        status.className = 'text-sm text-red-600';
      }
    };

    xhr.send(fd);
  });
})();
</script>
<?php render_app_layout_end(); ?>
