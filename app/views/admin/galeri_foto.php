<?php
// app/views/admin/galeri_foto.php
// Variabel: $album, $fotos, $flash, $csrf
?>

<style>
/* ═══════════════════════════════════════
   SCOPE ROOT — alias ke Design System
   (token asli didefinisikan global di layout;
    fallback disertakan bila file ini dirender berdiri sendiri)
═══════════════════════════════════════ */
.bn-root {
  --tx-primary:   var(--c-ink,    #0f172a);
  --tx-secondary: var(--c-muted,  #64748b);
  --tx-muted:     var(--c-muted2, #94a3b8);

  --bg-surface: var(--c-white, #ffffff);
  --bg-2:       #fbfcfe;
  --bg-overlay: #eef2f6;
  --bg-hover:   #f4f7fa;

  --bd-subtle: var(--c-border, #e6ebf1);
  --bd-strong: #d5dde6;

  --ac:     var(--c-primary,    #0e7490);
  --ac-dk:  var(--c-primary-dk, #0b5a70);
  --ac-lt:  var(--c-primary-lt, #06b6d4);
  --ac-dim: var(--c-primary-08, rgba(14,116,144,.08));

  --ok:     var(--c-green-text,   #15803d);
  --ok-dim: var(--c-green-bg,     #f0fdf4);
  --ok-bd:  var(--c-green-border, #bbf7d0);

  --er:     var(--c-red-text,   #b91c1c);
  --er-dim: var(--c-red-bg,     #fef2f2);
  --er-bd:  var(--c-red-border, #fecaca);

  --r-sm: var(--radius-sm, 9px);
  --r-md: var(--radius-sm, 9px);
  --r-lg: var(--radius-lg, 22px);

  --font:      var(--font-ui, 'Plus Jakarta Sans', sans-serif);
  --font-mono: ui-monospace, 'SFMono-Regular', Menlo, Consolas, monospace;

  --ease: cubic-bezier(0.22, 1, 0.36, 1);
}

.bn-root * { box-sizing: border-box; }
.bn-root {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
  font-family: var(--font);
  color: var(--tx-primary);
  -webkit-font-smoothing: antialiased;
}
.bn-root .bn-wrap { max-width: 1100px; }

/* ── Header ── */
.bn-header {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  gap: 1.25rem;
  flex-wrap: wrap;
}
.bn-header-text { display: flex; flex-direction: column; gap: 0.25rem; }
.bn-eyebrow {
  display: inline-flex; align-items: center; gap: 7px;
  font-size: .72rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase;
  color: var(--ac); margin-bottom: 4px;
}
.bn-eyebrow__dot { width: 6px; height: 6px; border-radius: 50%; background: var(--ac); box-shadow: 0 0 6px var(--ac); }
.bn-page-title {
  font-size: 1.45rem; font-weight: 800; color: var(--ac-dk);
  letter-spacing: -.03em; margin: 0; line-height: 1.2;
}
.bn-page-sub { font-size: .82rem; color: var(--tx-secondary); margin: 4px 0 0; }
.bn-header-actions { display: flex; gap: .5rem; align-items: center; flex-wrap: wrap; }

/* ── Buttons ── */
.bn-btn {
  display: inline-flex; align-items: center; justify-content: center; gap: 6px;
  height: 38px; padding: 0 16px; border-radius: var(--r-md);
  font-size: .82rem; font-weight: 700; text-decoration: none; font-family: inherit;
  border: 1.5px solid transparent; cursor: pointer; transition: all .18s var(--ease);
}
.bn-btn i { font-size: 15px; }
.bn-btn:active { transform: translateY(0); }

.bn-btn--back { background: #fff; color: var(--tx-primary); border-color: var(--bd-subtle); }
.bn-btn--back:hover { background: var(--bg-hover); border-color: var(--bd-strong); }

.bn-btn--view { background: var(--ac-dim); color: var(--ac-dk); border-color: rgba(14,116,144,.25); }
.bn-btn--view:hover { background: rgba(14,116,144,.14); }

.bn-btn--primary {
  background: var(--ac); color: #fff; border: none;
  box-shadow: 0 8px 22px rgba(14,116,144,.25);
}
.bn-btn--primary:hover { background: var(--ac-lt); transform: translateY(-2px); box-shadow: 0 12px 28px rgba(6,182,212,.3); }

/* ── Flash ── */
.bn-flash {
  display: flex; align-items: center; gap: .7rem; padding: .8rem 1.1rem;
  border-radius: var(--r-lg); font-size: .82rem; font-weight: 500;
  border: 1px solid; animation: bn-fadein .3s var(--ease);
}
.bn-flash i { font-size: 17px; flex-shrink: 0; }
@keyframes bn-fadein { from { opacity:0; transform:translateY(-8px); } to { opacity:1; transform:translateY(0); } }
.bn-flash--success { background: var(--ok-dim); color: var(--ok); border-color: var(--ok-bd); }
.bn-flash--error   { background: var(--er-dim); color: var(--er); border-color: var(--er-bd); }

/* ── Panels ── */
.bn-panel {
  background: var(--bg-surface);
  border: 1px solid var(--bd-subtle);
  border-radius: var(--r-lg);
  padding: 1.35rem 1.4rem;
}
.bn-panel-header {
  font-size: .68rem; font-weight: 700; color: var(--ac);
  text-transform: uppercase; letter-spacing: .1em;
  margin-bottom: 1.15rem; display: flex; align-items: center; gap: 8px;
}
.bn-panel-header i { font-size: 15px; }
.bn-panel-header--muted { color: var(--tx-muted); }
.bn-panel-header__line { flex: 1; height: 1px; background: linear-gradient(to right, var(--ac-lt), transparent); }
.bn-panel-header--muted .bn-panel-header__line { background: linear-gradient(to right, var(--bd-strong), transparent); }

/* ── Dropzone ── */
.bn-drop {
  border: 1.5px dashed var(--bd-strong);
  border-radius: var(--r-lg);
  padding: 2.25rem 1rem;
  text-align: center;
  cursor: pointer; transition: all .18s var(--ease);
  background: var(--bg-hover);
}
.bn-drop:hover, .bn-drop.dragover { border-color: var(--ac-lt); background: var(--ac-dim); }
.bn-drop__icon {
  width: 44px; height: 44px; border-radius: var(--r-md);
  background: var(--bg-overlay); color: var(--tx-muted);
  display: flex; align-items: center; justify-content: center;
  margin: 0 auto 1rem;
}
.bn-drop__icon i { font-size: 20px; }
.bn-drop__h { font-size: .95rem; font-weight: 700; color: var(--tx-primary); margin: 0 0 .4rem 0; }
.bn-drop__p { font-size: .78rem; color: var(--tx-muted); margin: 0; }

/* ── Preview Grid ── */
.bn-preview {
  display: grid; grid-template-columns: repeat(auto-fill, minmax(110px, 1fr)); gap: 1rem; margin-top: 1.5rem;
}
.bn-preview-item {
  position: relative; aspect-ratio: 1; border-radius: var(--r-md); overflow: hidden;
  background: var(--bg-2); border: 1px solid var(--bd-subtle);
}
.bn-preview-item img { width: 100%; height: 100%; object-fit: cover; display: block; }
.bn-preview-item__lbl {
  position: absolute; bottom: 0; left: 0; right: 0;
  background: linear-gradient(transparent, rgba(15,23,42,.8));
  padding: 10px 6px 6px; font-size: .64rem; color: #fff;
  white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
  font-family: var(--font-mono); text-align: center;
}

/* ── Photo Grid (Saved Photos) ── */
.bn-grid-foto {
  display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 1rem;
}
.bn-foto {
  position: relative; aspect-ratio: 1; border-radius: var(--r-md); overflow: hidden;
  background: var(--bg-2); border: 1px solid var(--bd-subtle);
  transition: transform .25s var(--ease), box-shadow .25s var(--ease), border-color .25s var(--ease);
}
.bn-foto:hover { transform: translateY(-3px); border-color: var(--bd-strong); box-shadow: 0 12px 26px rgba(15,23,42,.1); }
.bn-foto img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform .5s var(--ease); }
.bn-foto:hover img { transform: scale(1.05); }

/* Overlay Actions */
.bn-foto__overlay {
  position: absolute; inset: 0; background: rgba(15,23,42,.55);
  display: flex; align-items: center; justify-content: center;
  opacity: 0; transition: opacity .18s var(--ease); backdrop-filter: blur(2px);
}
.bn-foto:hover .bn-foto__overlay { opacity: 1; }

.bn-foto__del {
  padding: 8px 14px; background: var(--er); color: #fff;
  border: none; border-radius: var(--r-sm); font-size: .74rem; font-weight: 700;
  cursor: pointer; display: inline-flex; align-items: center; gap: 6px;
  transition: all .18s var(--ease); box-shadow: 0 4px 12px rgba(185,28,28,.4);
  font-family: var(--font);
}
.bn-foto__del i { font-size: 14px; }
.bn-foto__del:hover { background: #a51818; transform: scale(1.05); }

/* Foto Label */
.bn-foto__title {
  position: absolute; bottom: 0; left: 0; right: 0;
  background: linear-gradient(transparent, rgba(15,23,42,.9));
  padding: 12px 10px 8px; font-size: .74rem; font-weight: 600; color: #fff;
  white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
  pointer-events: none;
}

/* ── Empty State ── */
.bn-empty {
  padding: 3.5rem 2rem; text-align: center; color: var(--tx-muted);
}
.bn-empty__icon {
  width: 56px; height: 56px; border-radius: 50%;
  background: var(--bg-overlay); color: var(--tx-muted);
  display: flex; align-items: center; justify-content: center;
  margin: 0 auto 1rem;
}
.bn-empty__icon i { font-size: 26px; }
.bn-empty p { font-size: .84rem; margin: 0; font-weight: 500; }
</style>

<div class="bn-root">
<div class="bn-wrap">

  <div class="bn-header">
    <div class="bn-header-text">
      <div class="bn-eyebrow">
        <span class="bn-eyebrow__dot"></span>
        Manajemen Galeri
      </div>
      <h1 class="bn-page-title">Foto: <?= htmlspecialchars($album['judul']) ?></h1>
      <p class="bn-page-sub"><?= count($fotos) ?> foto tersimpan dalam album ini</p>
    </div>
    <div class="bn-header-actions">
      <a href="<?= BASE_URL ?>/admin/galeri" class="bn-btn bn-btn--back">
        <i class="ti ti-arrow-left" aria-hidden="true"></i>
        Kembali
      </a>
      <a href="<?= BASE_URL ?>/galeri/<?= htmlspecialchars($album['slug']) ?>" target="_blank" class="bn-btn bn-btn--view">
        <i class="ti ti-eye" aria-hidden="true"></i>
        Lihat Publik
      </a>
    </div>
  </div>

  <?php if (!empty($flash)): ?>
  <div class="bn-flash bn-flash--<?= htmlspecialchars($flash['type']) ?>">
    <i class="ti <?= $flash['type'] === 'success' ? 'ti-circle-check' : 'ti-alert-circle' ?>" aria-hidden="true"></i>
    <span><?= htmlspecialchars($flash['msg']) ?></span>
  </div>
  <?php endif; ?>

  <div class="bn-panel">
    <div class="bn-panel-header">
      <i class="ti ti-cloud-upload" aria-hidden="true"></i>
      Upload Foto Baru <span class="bn-panel-header__line"></span>
    </div>

    <form method="POST" action="<?= BASE_URL ?>/admin/galeri/<?= $album['id'] ?>/upload" enctype="multipart/form-data">
      <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">

      <div id="drop-zone" class="bn-drop"
           onclick="document.getElementById('foto-input').click()"
           ondragover="event.preventDefault(); this.classList.add('dragover');"
           ondragleave="this.classList.remove('dragover');"
           ondrop="handleDrop(event)">
        <div class="bn-drop__icon"><i class="ti ti-cloud-upload" aria-hidden="true"></i></div>
        <p class="bn-drop__h">Klik atau seret foto ke area ini</p>
        <p class="bn-drop__p">Mendukung format JPG, PNG, WEBP. Dapat memilih banyak file sekaligus.</p>
        <input type="file" id="foto-input" name="fotos[]" accept="image/jpeg,image/png,image/webp" multiple style="display:none" onchange="previewFiles(this.files)">
      </div>

      <div id="preview-grid" class="bn-preview"></div>

      <div style="display:flex; justify-content:flex-end; margin-top: 1.5rem;">
        <button type="submit" id="upload-btn" class="bn-btn bn-btn--primary" style="display:none;">
          <i class="ti ti-upload" aria-hidden="true"></i>
          Mulai Upload
        </button>
      </div>
    </form>
  </div>

  <div class="bn-panel">
    <div class="bn-panel-header bn-panel-header--muted">
      <i class="ti ti-photo" aria-hidden="true"></i>
      <?= count($fotos) ?> Foto Dalam Album <span class="bn-panel-header__line"></span>
    </div>

    <?php if (empty($fotos)): ?>
      <div class="bn-empty">
        <div class="bn-empty__icon"><i class="ti ti-photo-off" aria-hidden="true"></i></div>
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
                <i class="ti ti-trash" aria-hidden="true"></i>
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