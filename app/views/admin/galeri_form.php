<?php
// app/views/admin/galeri_form.php
$isEdit = isset($album) && $album !== null;
$action = $isEdit
    ? BASE_URL . '/admin/galeri/' . $album['id'] . '/update'
    : BASE_URL . '/admin/galeri/store';
?>
<style>
/* ═══════════════════════════════════════
   SCOPE ROOT — alias ke Design System
   (token asli didefinisikan global di layout;
    fallback disertakan bila file ini dirender berdiri sendiri)
═══════════════════════════════════════ */
.gf-root {
  --tx-primary:   var(--c-ink,    #0f172a);
  --tx-secondary: var(--c-muted,  #64748b);
  --tx-muted:     var(--c-muted2, #94a3b8);

  --bg-surface: var(--c-white, #ffffff);
  --bg-2:       #fbfcfe;
  --bg-overlay: #eef2f6;
  --bg-hover:   #f4f7fa;

  --bd-subtle: var(--c-border, #e6ebf1);
  --bd-strong: #d5dde6;

  --ac:    var(--c-primary,    #0e7490);
  --ac-dk: var(--c-primary-dk, #0b5a70);
  --ac-lt: var(--c-primary-lt, #06b6d4);
  --ac-lo: var(--c-primary-08, rgba(14,116,144,.08));
  --ac-gl: rgba(6,182,212,.12);

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

.gf-root *, .gf-root *::before, .gf-root *::after { box-sizing: border-box; margin: 0; padding: 0; }

.gf-page {
  max-width: 1040px;
  margin: 0 auto;
  padding: 0 0 4rem;
  font-family: var(--font);
  color: var(--tx-primary);
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
  -webkit-font-smoothing: antialiased;
}

/* ── Breadcrumb ── */
.gf-breadcrumb {
  display: inline-flex; align-items: center; gap: .5rem;
  font-size: .72rem; font-weight: 700; text-transform: uppercase; letter-spacing: .06em;
  color: var(--tx-muted);
}
.gf-breadcrumb a { color: var(--tx-muted); text-decoration: none; transition: color .2s var(--ease); }
.gf-breadcrumb a:hover { color: var(--ac); }
.gf-breadcrumb-sep { opacity: .5; }
.gf-breadcrumb-current { color: var(--ac); }

/* ── Header ── */
.gf-header {
  display: flex; align-items: flex-start; justify-content: space-between; gap: 1.25rem; flex-wrap: wrap;
}
.gf-header-left { display: flex; flex-direction: column; gap: 0.25rem; }
.gf-eyebrow {
  display: inline-flex; align-items: center; gap: 8px;
  font-size: .72rem; font-weight: 700;
  text-transform: uppercase; letter-spacing: .08em; color: var(--ac);
}
.gf-eyebrow__dot {
  width: 6px; height: 6px; border-radius: 50%; background: var(--ac);
  box-shadow: 0 0 6px var(--ac);
}
.gf-title { font-size: 1.5rem; font-weight: 800; color: var(--ac-dk); letter-spacing: -.03em; line-height: 1.2; margin: 0; }
.gf-sub { font-size: .8rem; color: var(--tx-secondary); display: flex; align-items: center; gap: .5rem; flex-wrap: wrap; margin-top: .25rem; }

/* Status Pill Header */
.gf-st {
  display: inline-flex; align-items: center; gap: 6px; padding: 3px 10px; border-radius: 99px;
  font-size: .66rem; font-weight: 700; letter-spacing: .04em; text-transform: uppercase;
  border: 1px solid;
}
.gf-st-dot { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
.gf-st--pub { color: var(--ok); background: var(--ok-dim); border-color: var(--ok-bd); }
.gf-st--pub .gf-st-dot { background: var(--ok); box-shadow: 0 0 5px var(--ok); }
.gf-st--dft { color: var(--tx-muted); background: var(--bg-overlay); border-color: var(--bd-subtle); }
.gf-st--dft .gf-st-dot { background: var(--tx-muted); }

/* Buttons */
.bn-btn {
  display: inline-flex; align-items: center; justify-content: center; gap: 6px;
  height: 38px; padding: 0 16px; border-radius: var(--r-md);
  font-size: .82rem; font-weight: 700; text-decoration: none; font-family: inherit;
  border: 1.5px solid transparent; cursor: pointer; transition: all .18s var(--ease);
}
.bn-btn i { font-size: 15px; }
.bn-btn--back { background: #fff; color: var(--tx-primary); border-color: var(--bd-subtle); }
.bn-btn--back:hover { background: var(--bg-hover); border-color: var(--bd-strong); }

/* Flash */
.gf-flash {
  display: flex; align-items: center; gap: .7rem; padding: .8rem 1.1rem;
  border-radius: var(--r-lg); font-size: .82rem; font-weight: 500;
  border: 1px solid;
}
.gf-flash i { font-size: 17px; flex-shrink: 0; }
.gf-flash--success { background: var(--ok-dim); color: var(--ok); border-color: var(--ok-bd); }
.gf-flash--error   { background: var(--er-dim); color: var(--er); border-color: var(--er-bd); }

/* ── Grid Layout ── */
.gf-grid {
  display: grid; grid-template-columns: 1fr 320px; gap: 1.25rem; align-items: start;
}
.gf-col { display: flex; flex-direction: column; gap: 1.15rem; }
.gf-col--sidebar { position: sticky; top: 1rem; }

/* ── Panels ── */
.gf-panel {
  background: var(--bg-surface);
  border: 1px solid var(--bd-subtle);
  border-radius: var(--r-lg);
  overflow: hidden;
}
.gf-panel-head {
  padding: 1rem 1.25rem; border-bottom: 1px solid var(--bd-subtle);
  font-size: .68rem; font-weight: 700;
  color: var(--ac); text-transform: uppercase; letter-spacing: .1em;
  display: flex; align-items: center; gap: 8px;
}
.gf-panel-head::after { content: ''; flex: 1; height: 1px; background: linear-gradient(to right, var(--ac-lt), transparent); }
.gf-panel-body { padding: 1.25rem; display: flex; flex-direction: column; gap: 1.2rem; }

/* ── Forms & Fields ── */
.gf-field { display: flex; flex-direction: column; gap: .45rem; }
.gf-field-head { display: flex; align-items: center; justify-content: space-between; gap: 1rem; }
.gf-label { font-size: .81rem; font-weight: 700; color: var(--tx-primary); }
.gf-label-req { color: var(--er); margin-left: 2px; }
.gf-label-opt { font-size: .72rem; font-weight: 400; color: var(--tx-muted); margin-left: 6px; }
.gf-counter { font-family: var(--font-mono); font-size: .68rem; color: var(--tx-muted); }

.gf-input, .gf-textarea {
  width: 100%; background: var(--bg-2); border: 1.5px solid var(--bd-subtle);
  border-radius: var(--r-sm); padding: 0 14px; font-family: inherit; font-size: .85rem;
  color: var(--tx-primary); transition: border-color .16s var(--ease), background .16s var(--ease), box-shadow .16s var(--ease);
}
.gf-input { height: 42px; }
.gf-input--title { font-size: 1rem; font-weight: 700; }
.gf-textarea { padding: 12px 14px; resize: vertical; min-height: 110px; line-height: 1.65; }
.gf-input:focus, .gf-textarea:focus {
  outline: none; border-color: var(--ac-lt); background: #fff;
  box-shadow: 0 0 0 3px var(--ac-gl);
}
.gf-input::placeholder, .gf-textarea::placeholder { color: var(--tx-muted); font-size: .8rem; }

/* Hint */
.gf-hint { font-size: .74rem; color: var(--tx-muted); line-height: 1.55; display: flex; align-items: flex-start; gap: 6px; }
.gf-hint i { flex-shrink: 0; margin-top: 1px; font-size: 14px; color: var(--tx-muted); }

/* ── Dropzone Cover ── */
.gf-drop {
  border: 1.5px dashed var(--bd-strong); border-radius: var(--r-md);
  padding: 2rem 1.5rem; text-align: center; cursor: pointer; transition: all .18s var(--ease);
  background: var(--bg-hover); position: relative;
}
.gf-drop:hover, .gf-drop.is-over { border-color: var(--ac-lt); background: var(--ac-lo); }
.gf-drop-icon {
  width: 36px; height: 36px; border-radius: var(--r-sm);
  background: var(--bg-overlay); color: var(--tx-muted);
  display: flex; align-items: center; justify-content: center;
  margin: 0 auto 1rem;
}
.gf-drop-icon i { font-size: 17px; }
.gf-drop-lbl { font-size: .87rem; font-weight: 700; color: var(--tx-secondary); margin-bottom: .35rem; }
.gf-drop-sub { font-size: .72rem; color: var(--tx-muted); }
.gf-drop-sub b { color: var(--ac); font-weight: 700; }

/* ── Thumbnails ── */
.gf-thumb-wrap { position: relative; border-radius: var(--r-md); overflow: hidden; aspect-ratio: 16/9; background: var(--bg-2); border: 1px solid var(--bd-subtle); }
.gf-thumb-wrap img { width: 100%; height: 100%; object-fit: cover; display: block; }
.gf-badge { position: absolute; top: 10px; right: 10px; padding: 3px 10px; border-radius: 99px; font-size: .64rem; font-weight: 700; text-transform: uppercase; letter-spacing: .04em; backdrop-filter: blur(4px); }
.gf-badge--cur { background: rgba(15,23,42,.65); color: #fff; }
.gf-badge--new { background: rgba(21,128,61,.8); color: #fff; }
.gf-btn-clear {
  position: absolute; bottom: 10px; right: 10px; padding: 6px 12px;
  background: rgba(15,23,42,.7); color: #fff; border: none; border-radius: var(--r-sm);
  font-size: .72rem; font-weight: 700; cursor: pointer; transition: background .18s var(--ease);
  backdrop-filter: blur(4px); display: inline-flex; align-items: center; gap: 5px;
  font-family: var(--font);
}
.gf-btn-clear i { font-size: 13px; }
.gf-btn-clear:hover { background: var(--er); }

/* ── Status Toggle ── */
.gf-status-grid { display: grid; grid-template-columns: 1fr 1fr; gap: .65rem; }
.gf-radio { position: absolute; opacity: 0; pointer-events: none; }
.gf-radio-lbl {
  display: flex; align-items: center; gap: .65rem; padding: .9rem;
  border: 1.5px solid var(--bd-subtle); border-radius: var(--r-md); cursor: pointer;
  background: var(--bg-2); transition: all .18s var(--ease);
}
.gf-radio-lbl:hover { border-color: var(--bd-strong); background: var(--bg-hover); }
.gf-radio:checked + .gf-radio-lbl { border-color: var(--ac-lt); background: var(--ac-lo); box-shadow: 0 0 0 1px var(--ac-lt); }
.gf-radio-indicator { width: 11px; height: 11px; border-radius: 50%; flex-shrink: 0; }
.gf-radio-indicator--pub { background: var(--ok); box-shadow: 0 0 0 3px var(--ok-dim); }
.gf-radio-indicator--dft { background: var(--tx-muted); box-shadow: 0 0 0 3px var(--bg-overlay); }
.gf-radio-text h4 { margin: 0 0 3px 0; font-size: .81rem; font-weight: 700; color: var(--tx-primary); }
.gf-radio-text p { margin: 0; font-size: .68rem; color: var(--tx-muted); }

/* ── Actions Sidebar ── */
.gf-btn-submit {
  width: 100%; display: flex; align-items: center; justify-content: center; gap: .5rem;
  padding: 12px 18px; background: var(--ac); color: #fff;
  border: none; border-radius: var(--r-sm);
  font-size: .85rem; font-weight: 800; cursor: pointer; transition: all .18s var(--ease);
  box-shadow: 0 8px 22px rgba(14,116,144,.25); font-family: inherit;
}
.gf-btn-submit i { font-size: 16px; }
.gf-btn-submit:hover { background: var(--ac-lt); transform: translateY(-2px); box-shadow: 0 12px 28px rgba(6,182,212,.3); }
.gf-btn-submit:active { transform: translateY(0); }
.gf-btn-submit:disabled { opacity: .65; cursor: not-allowed; transform: none; }

.gf-btn-secondary {
  width: 100%; display: flex; align-items: center; justify-content: center; gap: .5rem;
  padding: 10px 14px; background: #fff; border: 1.5px solid var(--bd-subtle);
  border-radius: var(--r-sm); font-size: .82rem; font-weight: 700; color: var(--tx-primary);
  text-decoration: none; transition: all .18s var(--ease); cursor: pointer; font-family: inherit;
}
.gf-btn-secondary i { font-size: 15px; }
.gf-btn-secondary:hover { background: var(--bg-hover); border-color: var(--bd-strong); }
.gf-btn-view { color: var(--ac-dk); border-color: rgba(14,116,144,.25); background: var(--ac-lo); }
.gf-btn-view:hover { background: rgba(14,116,144,.14); border-color: var(--ac); }

/* ── Info Table Sidebar ── */
.gf-info-list { display: flex; flex-direction: column; gap: 0; }
.gf-info-row { display: flex; justify-content: space-between; align-items: center; padding: 9px 0; border-bottom: 1px solid var(--bd-subtle); }
.gf-info-row:last-child { border-bottom: none; padding-bottom: 0; }
.gf-info-row:first-child { padding-top: 0; }
.gf-info-lbl { font-size: .74rem; color: var(--tx-muted); }
.gf-info-val { font-family: var(--font-mono); font-size: .78rem; font-weight: 700; color: var(--tx-primary); }

/* ── Tip card ── */
.gf-tip {
  background: var(--ac-lo);
  border: 1px solid rgba(14,116,144,.25);
  display: flex; gap: 10px; align-items: flex-start;
  padding: 1rem 1.1rem;
}
.gf-tip i { color: var(--ac); flex-shrink: 0; margin-top: 1px; font-size: 16px; }
.gf-tip span { font-size: .76rem; line-height: 1.55; color: var(--tx-secondary); }
.gf-tip strong { color: var(--tx-primary); font-weight: 700; }

@media (max-width: 880px) {
  .gf-grid { grid-template-columns: 1fr; }
  .gf-col--sidebar { order: -1; position: static; }
}
@media (max-width: 500px) {
  .gf-status-grid { grid-template-columns: 1fr; }
}
</style>

<div class="gf-root">
<div class="gf-page">

  <nav class="gf-breadcrumb" aria-label="breadcrumb">
    <a href="<?= BASE_URL ?>/admin/galeri">Manajemen Galeri</a>
    <span class="gf-breadcrumb-sep">/</span>
    <span class="gf-breadcrumb-current"><?= $isEdit ? 'Edit Album' : 'Album Baru' ?></span>
  </nav>

  <div class="gf-header">
    <div class="gf-header-left">
      <div class="gf-eyebrow">
        <span class="gf-eyebrow__dot"></span>
        <?= $isEdit ? 'Mode Edit' : 'Mode Publikasi' ?>
      </div>
      <h1 class="gf-title">
        <?= $isEdit ? htmlspecialchars($album['judul']) : 'Buat Album Baru' ?>
      </h1>
      <div class="gf-sub">
        <?php if ($isEdit): ?>
          <?php $st = ($album['status'] ?? 'draft') === 'published'; ?>
          <span class="gf-st gf-st--<?= $st ? 'pub' : 'dft' ?>">
            <span class="gf-st-dot"></span> <?= $st ? 'Publik' : 'Draft' ?>
          </span>
          <span>&bull;</span>
          <span>Diperbarui <?= $album['updated_at'] ? date('d M Y, H:i', strtotime($album['updated_at'])) : '—' ?></span>
        <?php else: ?>
          <span>Silakan isi formulir di bawah untuk membuat album baru.</span>
        <?php endif; ?>
      </div>
    </div>
    <a href="<?= BASE_URL ?>/admin/galeri" class="bn-btn bn-btn--back">
      <i class="ti ti-arrow-left" aria-hidden="true"></i>
      Kembali
    </a>
  </div>

  <?php if (!empty($flash)): ?>
  <div class="gf-flash gf-flash--<?= htmlspecialchars($flash['type']) ?>">
    <i class="ti <?= $flash['type'] === 'success' ? 'ti-circle-check' : 'ti-alert-circle' ?>" aria-hidden="true"></i>
    <span><?= htmlspecialchars($flash['msg']) ?></span>
  </div>
  <?php endif; ?>

  <form method="POST" action="<?= $action ?>" enctype="multipart/form-data" id="gf-form" novalidate>
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">

    <div class="gf-grid">

      <div class="gf-col">

        <div class="gf-panel">
          <div class="gf-panel-head"><i class="ti ti-info-square-rounded" aria-hidden="true"></i> Informasi Dasar</div>
          <div class="gf-panel-body">

            <div class="gf-field">
              <div class="gf-field-head">
                <label class="gf-label" for="gf-judul">Nama Album <span class="gf-label-req">*</span></label>
                <span class="gf-counter" id="gf-jc"><?= strlen($album['judul'] ?? '') ?>/160</span>
              </div>
              <input type="text" id="gf-judul" name="judul" class="gf-input gf-input--title"
                     value="<?= htmlspecialchars($album['judul'] ?? '') ?>"
                     placeholder="cth. Dokumentasi Kegiatan 2025" required maxlength="160" autocomplete="off" oninput="gfCount(this,'gf-jc',160)">
            </div>

            <div class="gf-field">
              <div class="gf-field-head">
                <label class="gf-label" for="gf-desk">Keterangan <span class="gf-label-opt">(opsional)</span></label>
                <span class="gf-counter" id="gf-dc"><?= strlen($album['deskripsi'] ?? '') ?>/500</span>
              </div>
              <textarea id="gf-desk" name="deskripsi" class="gf-textarea" rows="4" maxlength="500"
                        placeholder="Keterangan singkat tentang album ini..." oninput="gfCount(this,'gf-dc',500)"><?= htmlspecialchars($album['deskripsi'] ?? '') ?></textarea>
              <div class="gf-hint">
                <i class="ti ti-info-circle" aria-hidden="true"></i>
                <span>Ditampilkan di halaman galeri publik sebagai deskripsi album.</span>
              </div>
            </div>

          </div>
        </div>

        <div class="gf-panel">
          <div class="gf-panel-head"><i class="ti ti-photo" aria-hidden="true"></i> Foto Cover</div>
          <div class="gf-panel-body">

            <?php if (!empty($album['cover'])): ?>
              <div class="gf-field" style="margin-bottom: 1rem;">
                <label class="gf-label">Cover Saat Ini</label>
                <div class="gf-thumb-wrap" id="gf-current-thumb">
                  <img src="<?= UPLOAD_URL . '/' . htmlspecialchars($album['cover']) ?>" alt="Cover saat ini">
                  <span class="gf-badge gf-badge--cur">Aktif</span>
                </div>
              </div>
              <label class="gf-label">Ganti Cover <span class="gf-label-opt">(opsional)</span></label>
            <?php endif; ?>

            <div class="gf-drop" id="gf-drop"
                 onclick="document.getElementById('gf-cover-file').click()"
                 ondragover="event.preventDefault(); this.classList.add('is-over');"
                 ondragleave="this.classList.remove('is-over');"
                 ondrop="handleDrop(event)">
              <input type="file" name="cover" id="gf-cover-file" accept="image/jpeg,image/png,image/webp" style="display:none;" aria-label="Upload foto cover">
              <div class="gf-drop-icon"><i class="ti ti-cloud-upload" aria-hidden="true"></i></div>
              <div class="gf-drop-lbl" id="gf-drop-label">Klik atau seret foto ke sini</div>
              <div class="gf-drop-sub">Format JPG, PNG, WebP &mdash; Maks. <b>2 MB</b></div>
            </div>

            <div id="gf-new-thumb" style="display:none; margin-top:1rem;">
              <div class="gf-thumb-wrap">
                <img id="gf-thumb-img" src="" alt="Preview cover baru">
                <span class="gf-badge gf-badge--new">Preview Baru</span>
                <button type="button" class="gf-btn-clear" onclick="gfClearCover()">
                  <i class="ti ti-x" aria-hidden="true"></i> Hapus
                </button>
              </div>
            </div>

            <div class="gf-hint">
              <i class="ti ti-info-circle" aria-hidden="true"></i>
              <span>Jika dikosongkan, sistem akan otomatis menggunakan foto pertama yang diupload ke dalam album ini.</span>
            </div>

          </div>
        </div>

      </div><div class="gf-col gf-col--sidebar">

        <div class="gf-panel">
          <div class="gf-panel-head"><i class="ti ti-send" aria-hidden="true"></i> Pengaturan &amp; Publikasi</div>
          <div class="gf-panel-body">

            <div class="gf-field">
              <label class="gf-label">Status Penayangan</label>
              <?php $curStatus = $album['status'] ?? 'published'; ?>
              <div class="gf-status-grid">

                <input type="radio" name="status" id="st-pub" value="published" class="gf-radio" <?= $curStatus === 'published' ? 'checked' : '' ?>>
                <label for="st-pub" class="gf-radio-lbl">
                  <span class="gf-radio-indicator gf-radio-indicator--pub"></span>
                  <div class="gf-radio-text">
                    <h4>Publik</h4>
                    <p>Tampil di web</p>
                  </div>
                </label>

                <input type="radio" name="status" id="st-dft" value="draft" class="gf-radio" <?= $curStatus === 'draft' ? 'checked' : '' ?>>
                <label for="st-dft" class="gf-radio-lbl">
                  <span class="gf-radio-indicator gf-radio-indicator--dft"></span>
                  <div class="gf-radio-text">
                    <h4>Draft</h4>
                    <p>Sembunyikan</p>
                  </div>
                </label>

              </div>
            </div>

            <div class="gf-field">
              <label class="gf-label" for="gf-urut">Urutan Tampil (Sortir)</label>
              <input type="number" id="gf-urut" name="urutan" class="gf-input" min="0" max="999" value="<?= (int)($album['urutan'] ?? 0) ?>">
              <div class="gf-hint" style="margin-top:2px;">Angka terkecil (0) akan tampil paling atas/awal.</div>
            </div>

            <div style="height:1px; background:var(--bd-subtle); margin: .5rem 0;"></div>

            <button type="submit" class="gf-btn-submit" id="gf-submit-btn">
              <i class="ti <?= $isEdit ? 'ti-device-floppy' : 'ti-plus' ?>" aria-hidden="true"></i>
              <?= $isEdit ? 'Simpan Perubahan' : 'Buat Album Baru' ?>
            </button>

            <?php if ($isEdit): ?>
              <a href="<?= BASE_URL ?>/galeri/<?= htmlspecialchars($album['slug'] ?? '') ?>" target="_blank" rel="noopener" class="gf-btn-secondary gf-btn-view">
                <i class="ti ti-eye" aria-hidden="true"></i>
                Lihat di Publik
              </a>
            <?php endif; ?>

          </div>
        </div>

        <?php if ($isEdit): ?>
        <div class="gf-panel">
          <div class="gf-panel-head"><i class="ti ti-info-circle" aria-hidden="true"></i> Informasi Metadata</div>
          <div class="gf-panel-body" style="padding-top:1rem; padding-bottom:1rem;">
            <div class="gf-info-list">
              <?php foreach ([
                ['ID Album',      '#' . $album['id']],
                ['Total Foto',    ($album['jumlah_foto'] ?? 0) . ' foto'],
                ['Dibuat Pada',   isset($album['created_at']) ? date('d M Y', strtotime($album['created_at'])) : '—'],
              ] as [$k, $v]): ?>
              <div class="gf-info-row">
                <span class="gf-info-lbl"><?= $k ?></span>
                <span class="gf-info-val"><?= htmlspecialchars($v) ?></span>
              </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
        <?php endif; ?>

        <!-- Tip -->
        <div class="gf-panel gf-tip">
          <i class="ti ti-bulb" aria-hidden="true"></i>
          <span><strong>Tips:</strong> gunakan foto cover berorientasi landscape (16:9) agar tampil rapi di thumbnail galeri publik.</span>
        </div>

      </div></div></form>

</div>
</div>

<script>
(function () {
  'use strict';

  /* ─ Character Counter ─ */
  window.gfCount = function (el, counterId, max) {
    var counter = document.getElementById(counterId);
    if (!counter) return;
    var n = el.value.length;
    counter.textContent = n + '/' + max;
    counter.style.color = n > max * 0.9 ? 'var(--er)' : '';
  };

  /* ─ Elements ─ */
  var fileInput  = document.getElementById('gf-cover-file');
  var dropzone   = document.getElementById('gf-drop');
  var dropLabel  = document.getElementById('gf-drop-label');
  var newThumb   = document.getElementById('gf-new-thumb');
  var thumbImg   = document.getElementById('gf-thumb-img');
  var form       = document.getElementById('gf-form');
  var submitBtn  = document.getElementById('gf-submit-btn');

  /* ─ Show Preview ─ */
  function showPreview(file) {
    if (!file || !file.type.startsWith('image/')) return;
    var reader = new FileReader();
    reader.onload = function (e) {
      thumbImg.src = e.target.result;
      newThumb.style.display = 'block';
    };
    reader.readAsDataURL(file);
    dropLabel.textContent = file.name;
  }

  /* ─ Clear Cover ─ */
  window.gfClearCover = function () {
    if (fileInput) fileInput.value = '';
    newThumb.style.display = 'none';
    dropLabel.textContent = 'Klik atau seret foto ke sini';
  };

  /* ─ File Input Change ─ */
  if (fileInput) {
    fileInput.addEventListener('change', function () {
      if (this.files && this.files[0]) showPreview(this.files[0]);
    });
  }

  /* ─ Drag & Drop Handlers ─ */
  window.handleDrop = function(e) {
    e.preventDefault();
    dropzone.classList.remove('is-over');
    var file = e.dataTransfer.files[0];
    if (file && fileInput) {
      fileInput.files = e.dataTransfer.files;
      showPreview(file);
    }
  };

  /* ─ Form Submit (Disable Double Submit) ─ */
  if (form && submitBtn) {
    form.addEventListener('submit', function () {
      submitBtn.disabled = true;
      submitBtn.innerHTML = '<i class="ti ti-loader-2" style="animation:gf-spin 0.8s linear infinite" aria-hidden="true"></i> Menyimpan...';
    });
  }

  /* ─ Spinner Animation CSS ─ */
  var style = document.createElement('style');
  style.textContent = '@keyframes gf-spin { to { transform: rotate(360deg); } }';
  document.head.appendChild(style);
})();
</script>