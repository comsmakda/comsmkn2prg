<?php
// app/views/admin/galeri_form.php
$isEdit = isset($album) && $album !== null;
$action = $isEdit
    ? BASE_URL . '/admin/galeri/' . $album['id'] . '/update'
    : BASE_URL . '/admin/galeri/store';
?>
<style>
/* ── Base & Variables Fallback ── */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

.gf-page {
  max-width: 1000px;
  margin: 0 auto;
  padding: 0 0 4rem;
  font-family: var(--font, system-ui, -apple-system, sans-serif);
  display: flex;
  flex-direction: column;
  gap: 1.75rem;
}

/* ── Breadcrumb ── */
.gf-breadcrumb {
  display: inline-flex; align-items: center; gap: .5rem;
  font-family: var(--font-mono, monospace);
  font-size: .7rem; font-weight: 600; text-transform: uppercase; letter-spacing: .05em;
  color: var(--tx-muted, #6b7280);
}
.gf-breadcrumb a { color: var(--tx-muted, #6b7280); text-decoration: none; transition: color .2s; }
.gf-breadcrumb a:hover { color: var(--tx-primary, #fff); }
.gf-breadcrumb-sep { opacity: .4; }
.gf-breadcrumb-current { color: var(--ac, #60a5fa); }

/* ── Header ── */
.gf-header {
  display: flex; align-items: flex-start; justify-content: space-between; gap: 1.25rem; flex-wrap: wrap;
}
.gf-header-left { display: flex; flex-direction: column; gap: 0.25rem; }
.gf-eyebrow {
  display: inline-flex; align-items: center; gap: 8px;
  font-family: var(--font-mono, monospace); font-size: .75rem; font-weight: 700;
  text-transform: uppercase; letter-spacing: .08em; color: var(--ac, #60a5fa);
}
.gf-eyebrow__dot {
  width: 6px; height: 6px; border-radius: 50%; background: var(--ac, #60a5fa);
  box-shadow: 0 0 8px var(--ac, #60a5fa); animation: gf-pulse 2s ease-in-out infinite;
}
@keyframes gf-pulse {
  0%, 100% { opacity: 1; transform: scale(1); box-shadow: 0 0 8px var(--ac, #60a5fa); }
  50%      { opacity: 0.4; transform: scale(0.6); box-shadow: 0 0 2px var(--ac, #60a5fa); }
}
.gf-title { font-size: 1.75rem; font-weight: 800; color: var(--tx-primary, #ffffff); letter-spacing: -.03em; line-height: 1.2; margin: 0; }
.gf-sub { font-size: .875rem; color: var(--tx-muted, #9ca3af); display: flex; align-items: center; gap: .5rem; flex-wrap: wrap; margin-top: .2rem; }

/* Status Pill Header */
.gf-st {
  display: inline-flex; align-items: center; gap: 6px; padding: 3px 8px; border-radius: 99px;
  font-size: .65rem; font-weight: 700; letter-spacing: .08em; text-transform: uppercase;
  border: 1px solid; background: rgba(0,0,0,0.2);
}
.gf-st-dot { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
.gf-st--pub { color: var(--ok, #34d399); border-color: rgba(16,185,129,0.2); }
.gf-st--pub .gf-st-dot { background: var(--ok, #10b981); box-shadow: 0 0 6px var(--ok, #10b981); animation: gf-pulse 2.2s infinite; }
.gf-st--dft { color: var(--tx-muted, #9ca3af); border-color: rgba(255,255,255,0.1); }
.gf-st--dft .gf-st-dot { background: var(--tx-muted, #6b7280); }

/* Buttons */
.bn-btn {
  display: inline-flex; align-items: center; justify-content: center; gap: 6px;
  height: 38px; padding: 0 16px; border-radius: var(--r-md, 8px);
  font-size: .875rem; font-weight: 600; text-decoration: none; font-family: inherit;
  border: 1px solid transparent; cursor: pointer; transition: all .2s ease;
}
.bn-btn:hover { transform: translateY(-1px); filter: brightness(1.1); }
.bn-btn--back { background: transparent; color: var(--tx-secondary, #d1d5db); border-color: rgba(255,255,255,0.15); }
.bn-btn--back:hover { background: rgba(255,255,255,0.05); }

/* Flash */
.gf-flash {
  display: flex; align-items: center; gap: .75rem; padding: 1rem 1.25rem;
  border-radius: var(--r-md, 8px); font-size: .875rem; font-weight: 600;
  border: 1px solid rgba(255,255,255,0.05); box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}
.gf-flash--success { background: rgba(16,185,129,0.1); color: var(--ok, #34d399); border-color: rgba(16,185,129,0.2); }
.gf-flash--error   { background: rgba(239,68,68,0.1); color: var(--er, #f87171); border-color: rgba(239,68,68,0.2); }

/* ── Grid Layout ── */
.gf-grid {
  display: grid; grid-template-columns: 1fr 300px; gap: 1.5rem; align-items: start;
}
.gf-col { display: flex; flex-direction: column; gap: 1.5rem; }
.gf-col--sidebar { position: sticky; top: 1.5rem; }

/* ── Panels ── */
.gf-panel {
  background: var(--bg-surface, #0f172a);
  border: 1px solid rgba(255, 255, 255, 0.05);
  border-radius: var(--r-lg, 12px);
  box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.4);
  overflow: hidden;
}
.gf-panel-head {
  padding: 1.25rem 1.5rem; border-bottom: 1px solid rgba(255, 255, 255, 0.03);
  font-family: var(--font-mono, monospace); font-size: .65rem; font-weight: 700;
  color: rgba(255,255,255,0.4); text-transform: uppercase; letter-spacing: .12em;
  display: flex; align-items: center; gap: 10px;
}
.gf-panel-head::after { content: ''; flex: 1; height: 1px; background: rgba(255,255,255,0.03); }
.gf-panel-body { padding: 1.5rem; display: flex; flex-direction: column; gap: 1.25rem; }

/* ── Forms & Fields ── */
.gf-field { display: flex; flex-direction: column; gap: .5rem; }
.gf-field-head { display: flex; align-items: center; justify-content: space-between; gap: 1rem; }
.gf-label { font-size: .875rem; font-weight: 600; color: var(--tx-secondary, #d1d5db); }
.gf-label-req { color: var(--er, #f87171); margin-left: 2px; }
.gf-label-opt { font-size: .75rem; font-weight: 400; color: rgba(255,255,255,0.3); font-style: italic; margin-left: 6px; }
.gf-counter { font-family: var(--font-mono, monospace); font-size: .7rem; color: rgba(255,255,255,0.4); }

.gf-input, .gf-textarea {
  width: 100%; background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.15);
  border-radius: var(--r-sm, 6px); padding: 0 14px; font-family: inherit; font-size: .875rem;
  color: var(--tx-primary, #fff); transition: all .2s ease; box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);
}
.gf-input { height: 40px; }
.gf-input--title { font-size: 1rem; font-weight: 600; }
.gf-textarea { padding: 12px 14px; resize: vertical; min-height: 120px; line-height: 1.6; }
.gf-input:focus, .gf-textarea:focus {
  outline: none; border-color: var(--ac, #3b82f6); background: rgba(0,0,0,0.3);
  box-shadow: inset 0 2px 4px rgba(0,0,0,0.1), 0 0 0 3px rgba(59, 130, 246, 0.25);
}
.gf-input::placeholder, .gf-textarea::placeholder { color: rgba(255,255,255,0.3); }

/* Hint */
.gf-hint { font-size: .75rem; color: rgba(255,255,255,0.4); line-height: 1.5; display: flex; align-items: flex-start; gap: 6px; }
.gf-hint svg { flex-shrink: 0; margin-top: 2px; color: rgba(255,255,255,0.2); }

/* ── Dropzone Cover ── */
.gf-drop {
  border: 2px dashed rgba(255,255,255,0.15); border-radius: var(--r-md, 8px);
  padding: 2.5rem 1.5rem; text-align: center; cursor: pointer; transition: all .2s ease;
  background: rgba(0,0,0,0.2); position: relative;
}
.gf-drop:hover, .gf-drop.is-over { border-color: var(--ac, #3b82f6); background: rgba(59,130,246,0.05); }
.gf-drop-icon { width: 36px; height: 36px; color: rgba(255,255,255,0.3); margin: 0 auto 1rem; display: block; }
.gf-drop-lbl { font-size: .9rem; font-weight: 600; color: rgba(255,255,255,0.8); margin-bottom: .4rem; }
.gf-drop-sub { font-size: .75rem; color: rgba(255,255,255,0.4); }
.gf-drop-sub b { color: var(--ac, #60a5fa); font-weight: 600; }

/* ── Thumbnails ── */
.gf-thumb-wrap { position: relative; border-radius: var(--r-md, 8px); overflow: hidden; aspect-ratio: 16/9; background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.1); box-shadow: 0 4px 12px rgba(0,0,0,0.3); }
.gf-thumb-wrap img { width: 100%; height: 100%; object-fit: cover; display: block; }
.gf-badge { position: absolute; top: 10px; right: 10px; padding: 4px 10px; border-radius: 99px; font-family: var(--font-mono, monospace); font-size: .65rem; font-weight: 700; text-transform: uppercase; letter-spacing: .05em; backdrop-filter: blur(4px); }
.gf-badge--cur { background: rgba(0,0,0,0.6); color: rgba(255,255,255,0.9); border: 1px solid rgba(255,255,255,0.1); }
.gf-badge--new { background: rgba(16,185,129,0.8); color: #fff; }
.gf-btn-clear { position: absolute; bottom: 10px; right: 10px; padding: 6px 12px; background: rgba(0,0,0,0.7); color: #fff; border: 1px solid rgba(255,255,255,0.2); border-radius: 6px; font-size: .75rem; font-weight: 600; cursor: pointer; transition: all .2s; backdrop-filter: blur(4px); }
.gf-btn-clear:hover { background: var(--er, #ef4444); border-color: var(--er, #ef4444); }

/* ── Status Toggle ── */
.gf-status-grid { display: grid; grid-template-columns: 1fr 1fr; gap: .75rem; }
.gf-radio { display: none; }
.gf-radio-lbl {
  display: flex; align-items: center; gap: .75rem; padding: 1rem;
  border: 1px solid rgba(255,255,255,0.1); border-radius: var(--r-md, 8px); cursor: pointer;
  background: rgba(0,0,0,0.2); transition: all .2s ease;
}
.gf-radio-lbl:hover { background: rgba(255,255,255,0.02); border-color: rgba(255,255,255,0.2); }
.gf-radio:checked + .gf-radio-lbl { border-color: var(--ac, #3b82f6); background: rgba(59,130,246,0.1); box-shadow: 0 0 0 1px var(--ac, #3b82f6); }
.gf-radio-indicator { width: 12px; height: 12px; border-radius: 50%; flex-shrink: 0; border: 2px solid transparent; }
.gf-radio-indicator--pub { background: var(--ok, #10b981); box-shadow: 0 0 8px rgba(16,185,129,0.5); }
.gf-radio-indicator--dft { background: rgba(255,255,255,0.2); }
.gf-radio:checked + .gf-radio-lbl .gf-radio-indicator--dft { background: var(--tx-muted, #9ca3af); }
.gf-radio-text h4 { margin: 0 0 4px 0; font-size: .875rem; font-weight: 700; color: var(--tx-primary, #fff); }
.gf-radio-text p { margin: 0; font-size: .7rem; color: rgba(255,255,255,0.5); }

/* ── Actions Sidebar ── */
.gf-btn-submit {
  width: 100%; display: flex; align-items: center; justify-content: center; gap: .5rem;
  padding: 12px 18px; background: var(--ac, #3b82f6); color: #fff;
  border: 1px solid rgba(255,255,255,0.1); border-radius: var(--r-md, 8px);
  font-size: .9rem; font-weight: 700; cursor: pointer; transition: all .2s ease;
  box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3); font-family: inherit;
}
.gf-btn-submit:hover { filter: brightness(1.1); transform: translateY(-2px); box-shadow: 0 6px 16px rgba(59, 130, 246, 0.4); }
.gf-btn-submit:disabled { opacity: 0.6; cursor: not-allowed; transform: none; box-shadow: none; }

.gf-btn-secondary {
  width: 100%; display: flex; align-items: center; justify-content: center; gap: .5rem;
  padding: 10px 14px; background: transparent; border: 1px solid rgba(255,255,255,0.15);
  border-radius: var(--r-md, 8px); font-size: .875rem; font-weight: 600; color: var(--tx-secondary, #d1d5db);
  text-decoration: none; transition: all .2s; cursor: pointer; font-family: inherit;
}
.gf-btn-secondary:hover { background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.25); color: #fff; }
.gf-btn-view { color: var(--ac-bright, #93c5fd); border-color: rgba(59,130,246,0.3); background: rgba(59,130,246,0.05); }
.gf-btn-view:hover { background: rgba(59,130,246,0.15); border-color: var(--ac, #60a5fa); color: #fff; }

/* ── Info Table Sidebar ── */
.gf-info-list { display: flex; flex-direction: column; gap: 0; }
.gf-info-row { display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-bottom: 1px solid rgba(255,255,255,0.05); }
.gf-info-row:last-child { border-bottom: none; padding-bottom: 0; }
.gf-info-row:first-child { padding-top: 0; }
.gf-info-lbl { font-size: .75rem; color: rgba(255,255,255,0.4); }
.gf-info-val { font-family: var(--font-mono, monospace); font-size: .8rem; font-weight: 600; color: rgba(255,255,255,0.8); }

@media (max-width: 880px) {
  .gf-grid { grid-template-columns: 1fr; }
  .gf-col--sidebar { order: -1; position: static; }
}
@media (max-width: 500px) {
  .gf-status-grid { grid-template-columns: 1fr; }
}
</style>

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
      <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
      Kembali
    </a>
  </div>

  <?php if (!empty($flash)): ?>
  <div class="gf-flash gf-flash--<?= htmlspecialchars($flash['type']) ?>">
    <?php if ($flash['type'] === 'success'): ?>
      <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
    <?php else: ?>
      <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
    <?php endif; ?>
    <span><?= htmlspecialchars($flash['msg']) ?></span>
  </div>
  <?php endif; ?>

  <form method="POST" action="<?= $action ?>" enctype="multipart/form-data" id="gf-form" novalidate>
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">

    <div class="gf-grid">

      <div class="gf-col">

        <div class="gf-panel">
          <div class="gf-panel-head">Informasi Dasar</div>
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
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                <span>Ditampilkan di halaman galeri publik sebagai deksripsi album.</span>
              </div>
            </div>

          </div>
        </div>

        <div class="gf-panel">
          <div class="gf-panel-head">Foto Cover</div>
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
              <svg class="gf-drop-icon" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M17 8l-5-5-5 5M12 3v12"/></svg>
              <div class="gf-drop-lbl" id="gf-drop-label">Klik atau seret foto ke sini</div>
              <div class="gf-drop-sub">Format JPG, PNG, WebP &mdash; Maks. <b>2 MB</b></div>
            </div>

            <div id="gf-new-thumb" style="display:none; margin-top:1rem;">
              <div class="gf-thumb-wrap">
                <img id="gf-thumb-img" src="" alt="Preview cover baru">
                <span class="gf-badge gf-badge--new">Preview Baru</span>
                <button type="button" class="gf-btn-clear" onclick="gfClearCover()">× Hapus</button>
              </div>
            </div>

            <div class="gf-hint">
              <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
              <span>Jika dikosongkan, sistem akan otomatis menggunakan foto pertama yang diupload ke dalam album ini.</span>
            </div>

          </div>
        </div>

      </div><div class="gf-col gf-col--sidebar">

        <div class="gf-panel">
          <div class="gf-panel-head">Pengaturan & Publikasi</div>
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

            <div style="height:1px; background:rgba(255,255,255,0.05); margin: .5rem 0;"></div>

            <button type="submit" class="gf-btn-submit" id="gf-submit-btn">
              <?php if ($isEdit): ?>
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                Simpan Perubahan
              <?php else: ?>
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Buat Album Baru
              <?php endif; ?>
            </button>

            <?php if ($isEdit): ?>
              <a href="<?= BASE_URL ?>/galeri/<?= htmlspecialchars($album['slug'] ?? '') ?>" target="_blank" rel="noopener" class="gf-btn-secondary gf-btn-view">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                Lihat di Publik
              </a>
            <?php endif; ?>

          </div>
        </div>

        <?php if ($isEdit): ?>
        <div class="gf-panel">
          <div class="gf-panel-head">Informasi Metadata</div>
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

      </div></div></form>

</div><script>
(function () {
  'use strict';

  /* ─ Character Counter ─ */
  window.gfCount = function (el, counterId, max) {
    var counter = document.getElementById(counterId);
    if (!counter) return;
    var n = el.value.length;
    counter.textContent = n + '/' + max;
    counter.style.color = n > max * 0.9 ? 'var(--er, #f87171)' : 'inherit';
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
      submitBtn.innerHTML = '<svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="animation:spin 1s linear infinite"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/></svg> Menyimpan...';
    });
  }

  /* ─ Spinner Animation CSS ─ */
  var style = document.createElement('style');
  style.textContent = '@keyframes spin { to { transform: rotate(360deg); } }';
  document.head.appendChild(style);
})();
</script>