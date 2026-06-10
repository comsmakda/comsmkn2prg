<?php
// app/views/admin/galeri_foto.php
// Variabel: $album, $fotos, $flash, $csrf
?>

<style>
/* ── Base & Variables Fallback ── */
.bn * { box-sizing: border-box; }
.bn {
  display: flex;
  flex-direction: column;
  gap: 1.75rem;
  font-family: var(--font, system-ui, -apple-system, sans-serif);
}

/* ── Header ── */
.bn-header {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  gap: 1.25rem;
  flex-wrap: wrap;
}
.bn-header-text {
  display: flex;
  flex-direction: column;
  gap: 0.25rem;
}
.bn-page-title {
  font-size: 1.75rem;
  font-weight: 800;
  color: var(--tx-primary, #ffffff);
  letter-spacing: -.03em;
  margin: 0;
  line-height: 1.2;
}
.bn-page-sub {
  font-size: .875rem;
  color: var(--tx-muted, #9ca3af);
  margin: 0;
}
.bn-header-actions {
  display: flex;
  gap: .5rem;
  align-items: center;
  flex-wrap: wrap;
}

/* ── Buttons ── */
.bn-btn {
  display: inline-flex; align-items: center; justify-content: center; gap: 6px;
  height: 38px; padding: 0 16px; border-radius: var(--r-md, 8px);
  font-size: .875rem; font-weight: 600; text-decoration: none; font-family: inherit;
  border: 1px solid transparent; cursor: pointer; transition: all .2s ease;
}
.bn-btn:hover { transform: translateY(-1px); filter: brightness(1.1); }
.bn-btn:active { transform: translateY(0); }

.bn-btn--back {
  background: transparent; color: var(--tx-secondary, #d1d5db); border-color: rgba(255,255,255,0.15);
}
.bn-btn--back:hover { background: rgba(255,255,255,0.05); }

.bn-btn--view {
  background: var(--ac-dim, rgba(59,130,246,0.15)); color: var(--ac-bright, #93c5fd); border-color: rgba(59,130,246,0.3);
}

.bn-btn--primary {
  background: var(--ac, #3b82f6); color: #fff;
  box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

/* ── Flash ── */
.bn-flash {
  display: flex; align-items: center; gap: .75rem; padding: 1rem 1.25rem;
  border-radius: var(--r-md, 8px); font-size: .875rem; font-weight: 600;
  border: 1px solid rgba(255,255,255,0.05); animation: bn-fadein .3s ease-out;
  box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}
@keyframes bn-fadein { from { opacity:0; transform:translateY(-8px); } to { opacity:1; transform:translateY(0); } }
.bn-flash--success { background: rgba(16,185,129,0.1); color: var(--ok, #34d399); border-color: rgba(16,185,129,0.2); }
.bn-flash--error   { background: rgba(239,68,68,0.1); color: var(--er, #f87171); border-color: rgba(239,68,68,0.2); }

/* ── Panels ── */
.bn-panel {
  background: var(--bg-surface, #0f172a);
  border: 1px solid rgba(255, 255, 255, 0.05);
  border-radius: var(--r-lg, 12px);
  padding: 1.5rem;
  box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.4);
}
.bn-panel-header {
  font-family: var(--font-mono, monospace);
  font-size: .65rem; font-weight: 700; color: var(--ac, #60a5fa);
  text-transform: uppercase; letter-spacing: .12em;
  margin-bottom: 1.25rem; display: flex; align-items: center; gap: 10px;
}
.bn-panel-header__line {
  flex: 1; height: 1px; background: linear-gradient(to right, rgba(255,255,255,0.1), transparent);
}

/* ── Dropzone ── */
.bn-drop {
  border: 2px dashed rgba(255,255,255,0.15);
  border-radius: var(--r-lg, 12px);
  padding: 2.5rem 1rem;
  text-align: center;
  cursor: pointer; transition: all .2s ease;
  background: rgba(0,0,0,0.2);
}
.bn-drop:hover, .bn-drop.dragover {
  border-color: var(--ac, #3b82f6); background: rgba(59,130,246,0.05);
}
.bn-drop__icon {
  width: 40px; height: 40px; color: rgba(255,255,255,0.3); margin: 0 auto 1rem; display: block;
}
.bn-drop__h { font-size: 1rem; font-weight: 600; color: var(--tx-primary, #ffffff); margin: 0 0 .5rem 0; }
.bn-drop__p { font-size: .8rem; color: var(--tx-muted, #9ca3af); margin: 0; }

/* ── Preview Grid ── */
.bn-preview {
  display: grid; grid-template-columns: repeat(auto-fill, minmax(110px, 1fr)); gap: 1rem; margin-top: 1.5rem;
}
.bn-preview-item {
  position: relative; aspect-ratio: 1; border-radius: var(--r-md, 8px); overflow: hidden;
  background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.1);
  box-shadow: 0 4px 6px rgba(0,0,0,0.3);
}
.bn-preview-item img { width: 100%; height: 100%; object-fit: cover; display: block; }
.bn-preview-item__lbl {
  position: absolute; bottom: 0; left: 0; right: 0;
  background: linear-gradient(transparent, rgba(0,0,0,0.8));
  padding: 10px 6px 6px; font-size: .65rem; color: #fff;
  white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
  font-family: var(--font-mono, monospace); text-align: center;
}

/* ── Photo Grid (Saved Photos) ── */
.bn-grid-foto {
  display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 1rem;
}
.bn-foto {
  position: relative; aspect-ratio: 1; border-radius: var(--r-md, 8px); overflow: hidden;
  background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.05);
  box-shadow: 0 4px 10px rgba(0,0,0,0.3); transition: transform .3s ease;
}
.bn-foto:hover { transform: translateY(-3px); border-color: rgba(255,255,255,0.15); box-shadow: 0 8px 16px rgba(0,0,0,0.4); }
.bn-foto img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform .5s ease; }
.bn-foto:hover img { transform: scale(1.05); }

/* Overlay Actions */
.bn-foto__overlay {
  position: absolute; inset: 0; background: rgba(0,0,0,0.6);
  display: flex; align-items: center; justify-content: center;
  opacity: 0; transition: opacity .2s ease; backdrop-filter: blur(2px);
}
.bn-foto:hover .bn-foto__overlay { opacity: 1; }

.bn-foto__del {
  padding: 8px 14px; background: var(--er, #ef4444); color: #fff;
  border: none; border-radius: var(--r-sm, 6px); font-size: .75rem; font-weight: 700;
  cursor: pointer; display: inline-flex; align-items: center; gap: 6px;
  transition: all .2s ease; box-shadow: 0 4px 10px rgba(239,68,68,0.4);
}
.bn-foto__del:hover { background: #dc2626; transform: scale(1.05); }

/* Foto Label */
.bn-foto__title {
  position: absolute; bottom: 0; left: 0; right: 0;
  background: linear-gradient(transparent, rgba(0,0,0,0.9));
  padding: 12px 10px 8px; font-size: .75rem; font-weight: 500; color: #fff;
  white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
  pointer-events: none;
}

/* ── Empty State ── */
.bn-empty {
  padding: 4rem 2rem; text-align: center; color: var(--tx-muted, #9ca3af);
}
.bn-empty svg { width: 48px; height: 48px; opacity: 0.2; margin-bottom: 1rem; }
</style>

<div class="bn">

  <div class="bn-header">
    <div class="bn-header-text">
      <h1 class="bn-page-title">Foto: <?= htmlspecialchars($album['judul']) ?></h1>
      <p class="bn-page-sub"><?= count($fotos) ?> foto tersimpan dalam album ini</p>
    </div>
    <div class="bn-header-actions">
      <a href="<?= BASE_URL ?>/admin/galeri" class="bn-btn bn-btn--back">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        Kembali
      </a>
      <a href="<?= BASE_URL ?>/galeri/<?= htmlspecialchars($album['slug']) ?>" target="_blank" class="bn-btn bn-btn--view">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
        Lihat Publik
      </a>
    </div>
  </div>

  <?php if (!empty($flash)): ?>
  <div class="bn-flash bn-flash--<?= htmlspecialchars($flash['type']) ?>">
    <?php if($flash['type'] === 'success'): ?>
      <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
    <?php else: ?>
      <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
    <?php endif; ?>
    <span><?= htmlspecialchars($flash['msg']) ?></span>
  </div>
  <?php endif; ?>

  <div class="bn-panel">
    <div class="bn-panel-header">
      Upload Foto Baru <span class="bn-panel-header__line"></span>
    </div>

    <form method="POST" action="<?= BASE_URL ?>/admin/galeri/<?= $album['id'] ?>/upload" enctype="multipart/form-data">
      <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">

      <div id="drop-zone" class="bn-drop"
           onclick="document.getElementById('foto-input').click()"
           ondragover="event.preventDefault(); this.classList.add('dragover');"
           ondragleave="this.classList.remove('dragover');"
           ondrop="handleDrop(event)">
        <svg class="bn-drop__icon" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M17 8l-5-5-5 5M12 3v12"/></svg>
        <p class="bn-drop__h">Klik atau seret foto ke area ini</p>
        <p class="bn-drop__p">Mendukung format JPG, PNG, WEBP. Dapat memilih banyak file sekaligus.</p>
        <input type="file" id="foto-input" name="fotos[]" accept="image/jpeg,image/png,image/webp" multiple style="display:none" onchange="previewFiles(this.files)">
      </div>

      <div id="preview-grid" class="bn-preview"></div>

      <div style="display:flex; justify-content:flex-end; margin-top: 1.5rem;">
        <button type="submit" id="upload-btn" class="bn-btn bn-btn--primary" style="display:none;">
          <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="19" x2="12" y2="5"/><polyline points="5 12 12 5 19 12"/></svg>
          Mulai Upload
        </button>
      </div>
    </form>
  </div>

  <div class="bn-panel">
    <div class="bn-panel-header" style="color:var(--tx-muted)">
      <?= count($fotos) ?> Foto Dalam Album <span class="bn-panel-header__line"></span>
    </div>

    <?php if (empty($fotos)): ?>
      <div class="bn-empty">
        <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
        <p>Album masih kosong. Silakan upload foto di atas.</p>
      </div>
    <?php else: ?>
      <div class="bn-grid-foto">
        <?php foreach ($fotos as $f): ?>
        <div class="bn-foto">
          <img src="<?= UPLOAD_URL . '/' . htmlspecialchars($f['file']) ?>" alt="<?= htmlspecialchars($f['judul'] ?? '') ?>" loading="lazy">
          
          <div class="bn-foto__overlay">
            <form method="POST" action="<?= BASE_URL ?>/admin/galeri/foto/<?= $f['id'] ?>/delete" onsubmit="return confirm('Apakah Anda yakin ingin menghapus foto ini?')" style="margin:0">
              <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
              <button type="submit" class="bn-foto__del" title="Hapus Foto">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                Hapus
              </button>
            </form>
          </div>

          <?php if ($f['judul']): ?>
            <div class="bn-foto__title"><?= htmlspecialchars($f['judul']) ?></div>
          <?php endif; ?>
        </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>

</div>

<script>
function previewFiles(files) {
  var grid = document.getElementById('preview-grid');
  var btn  = document.getElementById('upload-btn');
  var drop = document.getElementById('drop-zone');
  
  grid.innerHTML = '';
  drop.classList.remove('dragover');

  if (!files.length) { 
    btn.style.display = 'none'; 
    return; 
  }
  
  btn.style.display = 'inline-flex';
  
  Array.from(files).forEach(function(file) {
    if(!file.type.startsWith('image/')) return; // Hanya preview gambar
    
    var reader = new FileReader();
    reader.onload = function(e) {
      var div = document.createElement('div');
      div.className = 'bn-preview-item';
      
      var img = document.createElement('img');
      img.src = e.target.result;
      
      var lbl = document.createElement('div');
      lbl.className = 'bn-preview-item__lbl';
      lbl.textContent = file.name;
      
      div.appendChild(img);
      div.appendChild(lbl);
      grid.appendChild(div);
    };
    reader.readAsDataURL(file);
  });
}

function handleDrop(e) {
  e.preventDefault();
  var input = document.getElementById('foto-input');
  input.files = e.dataTransfer.files;
  previewFiles(e.dataTransfer.files);
}
</script>