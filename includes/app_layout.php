<?php

if (!function_exists('app_menu_items')) {
    function app_menu_items(int $rol): array
    {
        if ($rol === 1) {
            return [
                ['key' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'layout-dashboard', 'href' => 'panel_cliente.php'],
                ['key' => 'inventario', 'label' => 'Mi Inventario', 'icon' => 'package-search', 'href' => 'mi-inventario.php'],
                ['key' => 'catalogo', 'label' => 'Catálogo de Autos', 'icon' => 'car-front', 'href' => 'catalogo-autos.php'],
            ];
        }

        return [
            ['key' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'layout-dashboard', 'href' => 'index.php'],
            ['key' => 'catalogo', 'label' => 'Catálogo de Autos', 'icon' => 'car-front', 'href' => 'catalogo-autos.php'],
            ['key' => 'inventario', 'label' => 'Mi Inventario', 'icon' => 'package-search', 'href' => 'mi-inventario.php'],
            ['key' => 'sep-admin', 'label' => 'ADMINISTRACIÓN', 'type' => 'title'],
            ['key' => 'yonkes', 'label' => 'Gestionar Yonkes', 'icon' => 'building-2', 'href' => 'yonkes.php'],
            ['key' => 'usuarios', 'label' => 'Usuarios y Roles', 'icon' => 'users', 'href' => 'usuarios-roles.php'],
        ];
    }
}

if (!function_exists('render_app_layout_start')) {
    function render_app_layout_start(string $title, string $activeKey, string $heading, string $subtitle = ''): void
    {
        $rol = (int) ($_SESSION['rol'] ?? 0);
        $menu = app_menu_items($rol);
        $nombre = htmlspecialchars((string) ($_SESSION['nombre'] ?? 'Usuario'), ENT_QUOTES, 'UTF-8');
        $correo = htmlspecialchars((string) ($_SESSION['correo'] ?? 'usuario@yonkemovil.local'), ENT_QUOTES, 'UTF-8');

        echo '<!DOCTYPE html>';
        echo '<html lang="es" class="bg-gray-100">';
        echo '<head>';
        echo '<meta charset="UTF-8">';
        echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
        echo '<title>' . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . '</title>';
        echo '<script src="https://cdn.tailwindcss.com"></script>';
        echo '<script>tailwind.config={theme:{extend:{colors:{yonke:{dark:"#0a1931",blue:"#1c3a6e",yellow:"#ffcc00",accent:"#eab308"}}}}};</script>';
        echo '<script src="https://unpkg.com/lucide@latest"></script>';
        echo '<style>';
        echo '.sidebar-transition{transition:transform .3s ease-in-out}.ym-sort-btn{display:inline-flex;align-items:center;gap:.25rem;font-weight:600;color:#6b7280}.ym-sort-btn.active{color:#0a1931}.ym-table-wrap{border:1px solid #f1f5f9;border-radius:.75rem;overflow:hidden}.ym-table-wrap table{width:100%;border-collapse:separate;border-spacing:0}.ym-table-wrap thead th{background:#f8fafc;color:#6b7280;text-transform:uppercase;font-size:.72rem;letter-spacing:.06em;padding:.8rem .9rem;border-bottom:1px solid #e5e7eb}.ym-table-wrap tbody td{padding:.75rem .9rem;border-bottom:1px solid #f1f5f9}.ym-table-wrap tbody tr:hover{background:#f9fafb}.ym-table-meta{display:flex;align-items:center;justify-content:space-between;gap:.75rem;padding:.8rem 0}.ym-table-select{border:1px solid #d1d5db;border-radius:.5rem;padding:.35rem .6rem}.ym-pagination{display:flex;align-items:center;gap:.4rem}.ym-page-btn{padding:.34rem .65rem;border:1px solid #e5e7eb;border-radius:.45rem;background:#fff;color:#374151;font-size:.83rem}.ym-page-btn.active{background:#0a1931;color:#ffcc00;border-color:#0a1931}.ym-page-btn:disabled{opacity:.45;cursor:not-allowed}.ym-table-empty{padding:1rem;color:#6b7280;text-align:center}.ym-head-search{width:100%;border:1px solid #d1d5db;border-radius:999px;padding:.5rem 1rem .5rem 2.5rem}' ;
        echo '</style>';
        echo '</head>';
        echo '<body class="h-screen overflow-hidden">';
        echo '<div class="flex h-screen bg-gray-100 relative">';
        echo '<div id="mobile-overlay" class="fixed inset-0 bg-black opacity-50 z-20 hidden lg:hidden"></div>';

        echo '<aside id="sidebar" class="sidebar-transition fixed inset-y-0 left-0 z-30 w-64 bg-yonke-dark text-white flex flex-col transform -translate-x-full lg:translate-x-0 lg:static shadow-2xl">';
        echo '<div class="flex items-center justify-center h-20 border-b border-gray-700/50 bg-yonke-dark px-4 relative">';
        echo '<button id="close-sidebar-btn" class="absolute left-4 lg:hidden text-gray-400 hover:text-white"><i data-lucide="x" class="w-6 h-6"></i></button>';
        echo '<img src="./src/img/logo.png" alt="YonkeMovil Logo" class="h-40 w-auto object-contain">';
        echo '</div>';

        echo '<nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">';
        echo '<p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4 px-2">PRINCIPAL</p>';
        foreach ($menu as $item) {
            if (($item['type'] ?? '') === 'title') {
                echo '<p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mt-8 mb-4 px-2">' . htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8') . '</p>';
                continue;
            }
            $isActive = $activeKey === $item['key'];
            $aClass = $isActive
                ? 'flex items-center px-4 py-3 text-yonke-yellow bg-yonke-blue rounded-lg font-medium transition-colors group'
                : 'flex items-center px-4 py-3 text-gray-300 hover:bg-yonke-blue hover:text-white rounded-lg transition-colors font-medium group';
            $iClass = $isActive
                ? 'w-5 h-5 mr-3 text-yonke-yellow'
                : 'w-5 h-5 mr-3 text-gray-400 group-hover:text-yonke-yellow';

            echo '<a href="' . htmlspecialchars($item['href'], ENT_QUOTES, 'UTF-8') . '" class="' . $aClass . '">';
            echo '<i data-lucide="' . htmlspecialchars($item['icon'], ENT_QUOTES, 'UTF-8') . '" class="' . $iClass . '"></i>';
            echo htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8');
            echo '</a>';
        }
        echo '</nav>';

        echo '<div class="p-4 border-t border-gray-700/50 flex items-center">';
        echo '<img class="h-10 w-10 rounded-full border-2 border-yonke-yellow" src="https://ui-avatars.com/api/?name=' . rawurlencode($nombre) . '&background=ffcc00&color=0a1931" alt="User Avatar">';
        echo '<div class="ml-3 flex-1">';
        echo '<p class="text-sm font-medium text-white leading-none">' . $nombre . '</p>';
        echo '<p class="text-xs text-gray-400 leading-none mt-1">' . $correo . '</p>';
        echo '</div>';
        echo '<a href="backend/login/cerrar-sesion.php" class="text-gray-400 hover:text-yonke-yellow"><i data-lucide="log-out" class="w-5 h-5"></i></a>';
        echo '</div>';
        echo '</aside>';

        echo '<div class="flex-1 flex flex-col overflow-hidden">';
        echo '<header class="bg-white shadow-sm z-10 h-20 flex items-center justify-between px-6 lg:px-10">';
        echo '<button id="open-sidebar-btn" class="text-gray-500 focus:outline-none lg:hidden p-2 rounded-md hover:bg-gray-100"><i data-lucide="menu" class="w-6 h-6"></i></button>';
        echo '<div>';
        echo '<h2 class="text-xl md:text-2xl font-bold text-yonke-dark">' . htmlspecialchars($heading, ENT_QUOTES, 'UTF-8') . '</h2>';
        if ($subtitle !== '') {
            echo '<p class="text-sm text-gray-500">' . htmlspecialchars($subtitle, ENT_QUOTES, 'UTF-8') . '</p>';
        }
        echo '</div>';
        echo '<div class="flex items-center space-x-4 flex-1 justify-end">';
        echo '<div class="relative w-full max-w-md hidden sm:block">';
        echo '<span class="absolute inset-y-0 left-0 pl-3 flex items-center"><i data-lucide="search" class="w-5 h-5 text-gray-400"></i></span>';
        echo '<input id="global-table-search" class="ym-head-search" type="text" placeholder="Buscar en tablas...">';
        echo '</div>';
        echo '</div>';
        echo '</header>';
        echo '<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6 lg:p-10">';
    }
}

if (!function_exists('render_app_layout_end')) {
    function render_app_layout_end(): void
    {
        echo '</main></div></div>';
        echo '<script>';
        echo 'lucide.createIcons();';
        echo 'const s=document.getElementById("sidebar"),o=document.getElementById("mobile-overlay"),op=document.getElementById("open-sidebar-btn"),cl=document.getElementById("close-sidebar-btn");';
        echo 'function openS(){s.classList.remove("-translate-x-full");o.classList.remove("hidden");document.body.classList.add("overflow-hidden")}';
        echo 'function closeS(){s.classList.add("-translate-x-full");o.classList.add("hidden");document.body.classList.remove("overflow-hidden")}';
        echo 'if(op)op.addEventListener("click",openS);if(cl)cl.addEventListener("click",closeS);if(o)o.addEventListener("click",closeS);';
        echo 'class YMTable{constructor(table){this.table=table;this.tbody=table.tBodies[0];this.headers=[...table.tHead.rows[0].cells];this.rows=[...this.tbody.rows];this.filtered=[...this.rows];this.page=1;this.pageSize=10;this.sortIdx=-1;this.sortDir="asc";this.mount()}';
        echo 'mount(){this.wrap=document.createElement("div");this.wrap.className="ym-table-wrap";this.table.parentNode.insertBefore(this.wrap,this.table);this.wrap.appendChild(this.table);';
        echo 'this.meta=document.createElement("div");this.meta.className="ym-table-meta";this.wrap.parentNode.insertBefore(this.meta,this.wrap.nextSibling);';
        echo 'const left=document.createElement("div");left.className="text-sm text-gray-500";this.info=left;const right=document.createElement("div");right.className="flex items-center gap-2";';
        echo 'this.size=document.createElement("select");this.size.className="ym-table-select";[5,10,25,50].forEach(n=>{const op=document.createElement("option");op.value=n;op.textContent=n;this.size.appendChild(op)});this.size.value="10";';
        echo 'this.size.addEventListener("change",()=>{this.pageSize=parseInt(this.size.value,10);this.page=1;this.render()});';
        echo 'this.pag=document.createElement("div");this.pag.className="ym-pagination";right.appendChild(this.size);right.appendChild(this.pag);this.meta.appendChild(left);this.meta.appendChild(right);';
        echo 'this.headers.forEach((th,idx)=>{const txt=th.textContent.trim();th.innerHTML="";const b=document.createElement("button");b.type="button";b.className="ym-sort-btn";b.innerHTML=`<span>${txt}</span><span data-arrow="1">↕</span>`;b.addEventListener("click",()=>this.sort(idx));th.appendChild(b)});';
        echo 'this.render()}';
        echo 'search(q){const v=q.trim().toLowerCase();this.filtered=v?this.rows.filter(r=>r.innerText.toLowerCase().includes(v)):[...this.rows];this.page=1;this.render()}';
        echo 'sort(idx){if(this.sortIdx===idx){this.sortDir=this.sortDir==="asc"?"desc":"asc"}else{this.sortIdx=idx;this.sortDir="asc"}';
        echo 'const dir=this.sortDir==="asc"?1:-1;this.filtered.sort((a,b)=>{const av=(a.cells[idx]?.innerText||"").trim();const bv=(b.cells[idx]?.innerText||"").trim();const an=parseFloat(av.replace(/[^0-9.-]/g,""));const bn=parseFloat(bv.replace(/[^0-9.-]/g,""));if(!Number.isNaN(an)&&!Number.isNaN(bn))return (an-bn)*dir;return av.localeCompare(bv,"es",{numeric:true,sensitivity:"base"})*dir});';
        echo 'this.headers.forEach((th,i)=>{const btn=th.querySelector(".ym-sort-btn");if(!btn)return;btn.classList.toggle("active",i===idx);const arrow=btn.querySelector("[data-arrow]");if(arrow)arrow.textContent=i===idx?(this.sortDir==="asc"?"↑":"↓"):"↕"});this.render()}';
        echo 'render(){this.tbody.innerHTML="";const total=this.filtered.length;const pages=Math.max(1,Math.ceil(total/this.pageSize));if(this.page>pages)this.page=pages;const start=(this.page-1)*this.pageSize;const end=start+this.pageSize;const slice=this.filtered.slice(start,end);';
        echo 'if(slice.length===0){const tr=document.createElement("tr");const td=document.createElement("td");td.colSpan=this.headers.length;td.className="ym-table-empty";td.textContent="Sin resultados";tr.appendChild(td);this.tbody.appendChild(tr)}else{slice.forEach(r=>this.tbody.appendChild(r))}';
        echo 'this.info.textContent=`Mostrando ${total===0?0:start+1} - ${Math.min(end,total)} de ${total}`;this.renderPagination(pages)}';
        echo 'renderPagination(pages){this.pag.innerHTML="";const mk=(label,p,disabled=false,active=false)=>{const b=document.createElement("button");b.type="button";b.className="ym-page-btn"+(active?" active":"");b.textContent=label;b.disabled=disabled;b.addEventListener("click",()=>{this.page=p;this.render()});this.pag.appendChild(b)};';
        echo 'mk("Anterior",Math.max(1,this.page-1),this.page===1);for(let i=1;i<=pages;i++){if(i===1||i===pages||Math.abs(i-this.page)<=1){mk(String(i),i,false,i===this.page)}else if((i===2&&this.page>3)||(i===pages-1&&this.page<pages-2)){const s=document.createElement("span");s.className="px-1 text-gray-400";s.textContent="...";this.pag.appendChild(s)}}mk("Siguiente",Math.min(pages,this.page+1),this.page===pages)}';
        echo '}';
        echo 'window.__ymTables=[...document.querySelectorAll(".js-table")].map(t=>new YMTable(t));';
        echo 'const globalSearch=document.getElementById("global-table-search");if(globalSearch){globalSearch.addEventListener("input",e=>window.__ymTables.forEach(t=>t.search(e.target.value)))}';
        echo '</script>';
        echo '</body></html>';
    }
}
