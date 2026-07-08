<?php
// app/views/admin/berita_form.php
$isEdit = isset($berita) && $berita !== null;
$action = $isEdit
    ? BASE_URL . '/admin/berita/' . $berita['id'] . '/update'
    : BASE_URL . '/admin/berita/store';
?>
<style>
/* ═══════════════════════════════════════
   SCOPE ROOT — alias ke Design System
   (token asli didefinisikan global di layout;
    fallback disertakan bila file ini dirender berdiri sendiri)
═══════════════════════════════════════ */
.bf-root {
  --t1: var(--c-ink,     #0f172a);
  --t2: var(--c-muted,   #64748b);
  --t3: var(--c-muted2,  #94a3b8);

  --bg-0: var(--c-page,  #eef2f6);
  --bg-1: var(--c-white, #ffffff);
  --bg-2: #fbfcfe;
  --bg-3: #ffffff;
  --bg-h: #f4f7fa;

  --b0: var(--c-border, #e6ebf1);
  --b1: var(--c-border, #e6ebf1);
  --b2: #d5dde6;

  --ac:    var(--c-primary,    #0e7490);
  --ac-dk: var(--c-primary-dk, #0b5a70);
  --ba:    var(--c-primary-lt, #06b6d4);
  --ac-lo: var(--c-primary-08, rgba(14,116,144,.08));
  --ac-gl: rgba(6,182,212,.12);
  --ac-hi: var(--c-primary-dk, #0b5a70);

  --ok:   var(--c-green-text,   #15803d);
  --ok-d: var(--c-green-bg,     #f0fdf4);
  --ok-b: var(--c-green-border, #bbf7d0);

  --wa:   var(--c-amber-text,   #8a5a06);
  --wa-d: var(--c-amber-bg,     #fef6e2);
  --wa-b: var(--c-amber-border, #fbe3a8);

  --er:   var(--c-red-text,   #b91c1c);
  --er-d: var(--c-red-bg,     #fef2f2);
  --er-b: var(--c-red-border, #fecaca);

  --r1: 6px;
  --r2: 7px;
  --r3: var(--radius-sm, 9px);
  --r4: var(--radius-md, 13px);
  --r5: var(--radius-lg, 22px);

  --ff: var(--font-ui, 'Plus Jakarta Sans', sans-serif);
  --fm: ui-monospace, 'SFMono-Regular', Menlo, Consolas, monospace;

  --ease: cubic-bezier(0.22, 1, 0.36, 1);
  --tf: 160ms var(--ease);
  --tm: 200ms var(--ease);
}

.bf-root * { box-sizing: border-box; }
.bf-root {
  font-family: var(--ff);
  color: var(--t1);
  font-size: 13.5px;
  line-height: 1.5;
  -webkit-font-smoothing: antialiased;
}
.bf-root .bf-wrap { max-width: 1120px; }

/* ── Field ── */
.bf-field { display:flex; flex-direction:column; gap:6px; }
.bf-label {
  font-family: var(--ff);
  font-size: 11.5px;
  font-weight: 700;
  letter-spacing: .01em;
  color: var(--t1);
}
.bf-label span { color: var(--er); margin-left:2px; }
.bf-label-optional { font-weight: 400; color: var(--t3); font-size: 11px; }

.bf-input,
.bf-textarea,
.bf-select {
  width: 100%;
  background: var(--bg-2);
  border: 1.5px solid var(--b1);
  border-radius: var(--r3);
  padding: 11px 14px;
  font-family: var(--ff);
  font-size: 13.5px;
  color: var(--t1);
  outline: none;
  transition: border-color var(--tf), box-shadow var(--tf), background var(--tf);
  appearance: none;
  -webkit-appearance: none;
}
.bf-input:focus,
.bf-textarea:focus,
.bf-select:focus {
  border-color: var(--ba);
  background: var(--bg-3);
  box-shadow: 0 0 0 3px var(--ac-gl);
}
.bf-input::placeholder,
.bf-textarea::placeholder { color: var(--t3); font-size: 12.5px; }
.bf-input.title-input {
  font-size: 16px;
  font-weight: 700;
  letter-spacing: -.02em;
  padding: 13px 16px;
}
.bf-textarea { resize: vertical; line-height: 1.7; }
.bf-textarea.code { font-family: var(--fm); font-size: 12.5px; }
.bf-select {
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%2364748b' stroke-width='2' viewBox='0 0 16 16'%3E%3Cpolyline points='4 6 8 10 12 6'/%3E%3C/svg%3E");
  background-repeat: no-repeat;
  background-position: right 12px center;
  padding-right: 34px;
  cursor: pointer;
}
.bf-hint {
  font-size: 11px;
  color: var(--t3);
  line-height: 1.5;
}

/* ── Card ── */
.bf-card {
  background: var(--bg-1);
  border: 1px solid var(--b0);
  border-radius: var(--r5);
  padding: 1.15rem 1.25rem;
}
.bf-card-title {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 10.5px;
  font-weight: 700;
  letter-spacing: .1em;
  text-transform: uppercase;
  color: var(--ac);
  margin-bottom: 1rem;
}
.bf-card-title i { font-size: 14px; }
.bf-card-title::after {
  content: '';
  flex: 1;
  height: 1px;
  background: linear-gradient(to right, var(--ba), transparent);
}
.bf-divider { height: 1px; background: var(--b0); margin: .75rem 0; }

/* ── File upload ── */
.bf-upload-zone {
  position: relative;
  border: 1.5px dashed var(--b2);
  border-radius: var(--r4);
  padding: 20px;
  text-align: center;
  cursor: pointer;
  background: var(--bg-h);
  transition: border-color var(--tm), background var(--tm);
}
.bf-upload-zone:hover { border-color: var(--ba); background: var(--ac-lo); }
.bf-upload-zone input[type="file"] {
  position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%;
}
.bf-upload-icon {
  width: 34px; height: 34px;
  border-radius: var(--r3);
  background: #eef2f6;
  display: flex; align-items: center; justify-content: center;
  color: var(--t3);
  margin: 0 auto 8px;
}
.bf-upload-icon i { font-size: 16px; }
.bf-upload-text { font-size: 12px; color: var(--t2); font-weight: 700; }
.bf-upload-sub  { font-size: 10.5px; color: var(--t3); margin-top: 2px; }

/* ── Thumb preview ── */
.bf-thumb-wrap {
  border-radius: var(--r4);
  overflow: hidden;
  aspect-ratio: 16/9;
  background: var(--bg-2);
  border: 1px solid var(--b1);
  position: relative;
}
.bf-thumb-wrap img { width:100%; height:100%; object-fit:cover; display:block; }
.bf-thumb-badge {
  position: absolute; top:7px; right:7px;
  font-size:10px; font-weight:700;
  background: rgba(15,23,42,.65); color: #fff;
  padding: 2px 8px; border-radius: 999px;
  backdrop-filter: blur(4px);
}

/* ── Status badge / dot ── */
.bf-status-dot {
  width: 6px; height: 6px; border-radius: 50%; flex-shrink:0;
  background: var(--t3);
}
.bf-status-dot.pub { background: var(--ok); box-shadow: 0 0 0 3px var(--ok-d); }
.bf-status-dot.dft { background: var(--wa); box-shadow: 0 0 0 3px var(--wa-d); }

/* ── Buttons ── */
.btn-primary {
  display: flex; align-items: center; justify-content: center; gap: 7px;
  width: 100%; padding: 12px 16px;
  background: var(--ac); border: none; border-radius: var(--r3);
  font-family: var(--ff); font-size: 12.5px; font-weight: 800;
  color: #fff; cursor: pointer; letter-spacing: -.01em;
  box-shadow: 0 8px 22px rgba(14,116,144,.25);
  transition: background var(--tf), transform 120ms var(--ease), box-shadow var(--tf);
}
.btn-primary:hover {
  background: var(--ba);
  transform: translateY(-2px);
  box-shadow: 0 12px 28px rgba(6,182,212,.3);
}
.btn-primary:active { transform: translateY(0); }
.btn-primary i { font-size: 15px; flex-shrink:0; }

.btn-ghost {
  display: inline-flex; align-items: center; gap: 6px;
  padding: 9px 15px;
  background: #fff; border: 1.5px solid var(--b1); border-radius: var(--r3);
  font-family: var(--ff); font-size: 12.5px; font-weight: 700;
  color: var(--t1); cursor: pointer; text-decoration:none;
  transition: border-color var(--tf), color var(--tf), background var(--tf);
}
.btn-ghost:hover { border-color: var(--b2); background: var(--bg-h); }
.btn-ghost i { font-size: 15px; }

.btn-view {
  display: flex; align-items: center; justify-content: center; gap: 6px;
  width: 100%; padding: 10px;
  background: var(--ac-lo); border: 1px solid rgba(14,116,144,.25); border-radius: var(--r3);
  font-family: var(--ff); font-size: 12px; font-weight: 700;
  color: var(--ac-hi); cursor: pointer; text-decoration:none;
  transition: background var(--tf), border-color var(--tf);
}
.btn-view:hover { background: rgba(14,116,144,.14); }
.btn-view i { font-size: 15px; }

/* ── Char counter ── */
.bf-counter {
  font-family: var(--fm);
  font-size: 10px;
  color: var(--t3);
  text-align: right;
}
.bf-counter.warn { color: var(--wa); }

/* ── Toolbar markdown hint ── */
.bf-toolbar {
  display: flex; gap: 4px; flex-wrap: wrap;
  padding: 8px 10px;
  background: var(--bg-2);
  border: 1.5px solid var(--b1);
  border-bottom: none;
  border-radius: var(--r3) var(--r3) 0 0;
}
.bf-toolbar .bf-textarea { border-radius: 0 0 var(--r3) var(--r3) !important; }
.tb-btn {
  display: flex; align-items: center; gap: 4px;
  padding: 4px 9px; border-radius: var(--r1);
  background: none; border: 1px solid transparent;
  font-family: var(--ff); font-size: 11px; font-weight: 700;
  color: var(--t3); cursor: pointer;
  transition: color var(--tf), background var(--tf), border-color var(--tf);
}
.tb-btn:hover { color: var(--t1); background: var(--bg-3); border-color: var(--b1); }
.tb-btn i { font-size: 13px; }

/* ── Flash alert ── */
.bf-flash {
  display: flex; align-items: center; gap: 10px;
  padding: 12px 14px; border-radius: var(--r4);
  font-size: 12.5px; font-weight: 500; border: 1px solid;
  margin-bottom: 1rem;
}
.bf-flash i { font-size: 16px; flex-shrink:0; }
.bf-flash--success { background: var(--ok-d); border-color: var(--ok-b); color: var(--ok); }
.bf-flash--error   { background: var(--er-d); border-color: var(--er-b); color: var(--er); }
.bf-flash--warning { background: var(--wa-d); border-color: var(--wa-b); color: var(--wa); }

/* ── Page header ── */
.bf-ph {
  display:flex; align-items:flex-start; justify-content:space-between;
  gap:1rem; margin-bottom:1.5rem; flex-wrap:wrap;
}
.bf-ph__eyebrow {
  display:flex; align-items:center; gap:8px; margin-bottom:5px;
}
.bf-ph__eyebrow-label {
  font-size: 11px; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; color: var(--ac);
}
.bf-ph__badge {
  font-size:10px; font-weight:700; padding:2px 8px; border-radius:999px; border:1px solid;
  display:inline-flex; align-items:center; gap:5px;
}
.bf-ph__title {
  font-size: 1.4rem; font-weight: 800; color: var(--ac-dk);
  letter-spacing: -.025em; line-height: 1.2;
}
.bf-ph__sub { font-size: 11.5px; color: var(--t3); margin-top:4px; }

/* ── Info rows (sidebar) ── */
.bf-info-row { display:flex; align-items:center; justify-content:space-between; gap:8px; }
.bf-info-k { font-size: 11.5px; color: var(--t3); font-weight: 500; display:flex; align-items:center; gap:6px; }
.bf-info-k i { font-size: 13px; }
.bf-info-v { font-size: 11.5px; color: var(--t1); font-weight: 700; text-align:right; word-break: break-all; }

/* ── Tip card ── */
.bf-tip {
  background: var(--ac-lo);
  border: 1px solid rgba(14,116,144,.25);
  display: flex; gap: 10px; align-items: flex-start;
}
.bf-tip__icon { color: var(--ac); flex-shrink:0; margin-top:1px; }
.bf-tip__icon i { font-size: 16px; }
.bf-tip__text { font-size: 11.5px; line-height: 1.55; color: var(--t2); }
.bf-tip__text strong { color: var(--t1); font-weight: 700; }

/* ── Grid layout ── */
.bf-grid {
  display: grid;
  grid-template-columns: 1fr 320px;
  gap: 1.25rem;
  align-items: start;
}
.bf-sidebar { position: sticky; top: 16px; display:flex; flex-direction:column; gap:1rem; }
@media (max-width: 900px) {
  .bf-grid { grid-template-columns: 1fr; }
  .bf-sidebar { order: -1; position: static; }
}
</style>

<div class="bf-root">
<div class="bf-wrap">

  <!-- ── Page Header ── -->
  <div class="bf-ph">
    <div>
      <div class="bf-ph__eyebrow">
        <span class="bf-ph__eyebrow-label"><?= $isEdit ? 'Edit Berita' : 'Berita Baru' ?></span>
        <?php if ($isEdit): ?>
        <?php $pub = ($berita['status'] ?? 'draft') === 'published'; ?>
        <span class="bf-ph__badge" style="background:var(--<?= $pub?'ok-d':'wa-d' ?>);border-color:var(--<?= $pub?'ok-b':'wa-b' ?>);color:var(--<?= $pub?'ok':'wa' ?>)">
          <span class="bf-status-dot <?= $pub?'pub':'dft' ?>"></span>
          <?= $pub ? 'Published' : 'Draft' ?>
        </span>
        <?php endif; ?>
      </div>
      <h1 class="bf-ph__title"><?= $isEdit ? htmlspecialchars($berita['judul']) : 'Tulis Artikel Baru' ?></h1>
      <?php if ($isEdit): ?>
      <p class="bf-ph__sub">Terakhir diperbarui <?= isset($berita['updated_at']) ? date('d M Y, H:i', strtotime($berita['updated_at'])) : '—' ?></p>
      <?php endif; ?>
    </div>
    <a href="<?= BASE_URL ?>/admin/berita" class="btn-ghost">
      <i class="ti ti-arrow-left" aria-hidden="true"></i>
      Kembali
    </a>
  </div>

  <?php if (!empty($flash)): ?>
  <?php
    $flashIcons = ['success' => 'ti-circle-check', 'error' => 'ti-alert-circle', 'warning' => 'ti-alert-triangle'];
    $ftype = $flash['type'] === 'success' ? 'success' : ($flash['type'] === 'error' ? 'error' : 'warning');
  ?>
  <div class="bf-flash bf-flash--<?= $ftype ?>">
    <i class="ti <?= $flashIcons[$ftype] ?>" aria-hidden="true"></i>
    <span><?= htmlspecialchars($flash['msg']) ?></span>
  </div>
  <?php endif; ?>

  <form method="POST" action="<?= $action ?>" enctype="multipart/form-data" id="bf-form">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">

    <div class="bf-grid">

      <!-- ════ Kolom Kiri ════ -->
      <div style="display:flex;flex-direction:column;gap:1.15rem">

        <!-- Judul -->
        <div class="bf-card">
          <div class="bf-field">
            <label class="bf-label" for="bf-judul">Judul Berita <span>*</span></label>
            <input
              type="text" id="bf-judul" name="judul"
              class="bf-input title-input"
              value="<?= htmlspecialchars($berita['judul'] ?? '') ?>"
              placeholder="Tulis judul yang menarik dan informatif…"
              maxlength="200"
              required
              oninput="updateCounter(this,'jc',200)"
            >
            <div style="display:flex;justify-content:flex-end">
              <span class="bf-counter" id="jc"><?= strlen($berita['judul'] ?? '') ?>/200</span>
            </div>
          </div>
        </div>

        <!-- Ringkasan -->
        <div class="bf-card">
          <div class="bf-field">
            <div style="display:flex;align-items:center;justify-content:space-between">
              <label class="bf-label" for="bf-ringkasan">Ringkasan / Excerpt</label>
              <span class="bf-label-optional">opsional</span>
            </div>
            <textarea
              id="bf-ringkasan" name="ringkasan" rows="3"
              class="bf-textarea"
              maxlength="300"
              placeholder="Deskripsi singkat yang ditampilkan di daftar artikel dan meta description…"
              oninput="updateCounter(this,'rc',300)"
            ><?= htmlspecialchars($berita['ringkasan'] ?? '') ?></textarea>
            <div style="display:flex;align-items:center;justify-content:space-between">
              <span class="bf-hint">Idealnya 120–160 karakter untuk SEO.</span>
              <span class="bf-counter" id="rc"><?= strlen($berita['ringkasan'] ?? '') ?>/300</span>
            </div>
          </div>
        </div>

        <!-- Konten -->
        <div class="bf-card">
          <div class="bf-card-title"><i class="ti ti-article" aria-hidden="true"></i> Konten Artikel</div>
          <div class="bf-field">
            <label class="bf-label" for="bf-konten">Isi Artikel <span>*</span></label>

            <!-- Toolbar -->
            <div class="bf-toolbar">
              <button type="button" class="tb-btn" onclick="wrapTag('h2')"><b>H2</b></button>
              <button type="button" class="tb-btn" onclick="wrapTag('h3')"><b>H3</b></button>
              <button type="button" class="tb-btn" onclick="wrapTag('p')"><i class="ti ti-pilcrow" aria-hidden="true"></i> P</button>
              <button type="button" class="tb-btn" onclick="wrapTag('strong')"><b>B</b></button>
              <button type="button" class="tb-btn" onclick="wrapTag('em')"><i>I</i></button>
              <button type="button" class="tb-btn" onclick="wrapTag('a','href=\"\"')">
                <i class="ti ti-link" aria-hidden="true"></i> Link
              </button>
              <button type="button" class="tb-btn" onclick="wrapTag('blockquote')">
                <i class="ti ti-blockquote" aria-hidden="true"></i> Quote
              </button>
              <button type="button" class="tb-btn" onclick="insertImg()">
                <i class="ti ti-photo" aria-hidden="true"></i> Img
              </button>
              <button type="button" class="tb-btn" onclick="insertList()">
                <i class="ti ti-list" aria-hidden="true"></i> UL
              </button>
            </div>

            <textarea
              id="bf-konten" name="konten" rows="22"
              class="bf-textarea code"
              style="border-radius:0 0 var(--r3) var(--r3);"
              placeholder="Tulis isi artikel HTML di sini…&#10;&#10;Contoh:&#10;&lt;h2&gt;Sub Judul&lt;/h2&gt;&#10;&lt;p&gt;Paragraf artikel...&lt;/p&gt;"
              required
            ><?= htmlspecialchars($berita['konten'] ?? '') ?></textarea>
            <span class="bf-hint">Mendukung HTML: &lt;h2&gt; &lt;h3&gt; &lt;p&gt; &lt;ul&gt; &lt;ol&gt; &lt;img&gt; &lt;blockquote&gt; &lt;strong&gt; &lt;em&gt; &lt;a&gt;</span>
          </div>
        </div>

      </div><!-- /kolom kiri -->

      <!-- ════ Kolom Kanan (Sidebar) ════ -->
      <div class="bf-sidebar">

        <!-- Publikasi -->
        <div class="bf-card">
          <div class="bf-card-title"><i class="ti ti-send" aria-hidden="true"></i> Publikasi</div>

          <div style="display:flex;flex-direction:column;gap:.75rem">
            <div class="bf-field">
              <label class="bf-label" for="bf-status">Status</label>
              <select id="bf-status" name="status" class="bf-select" onchange="updateStatusDot(this)">
                <option value="draft"     <?= ($berita['status'] ?? 'draft') !== 'published' ? 'selected' : '' ?>>
                  Draft — Tidak Tampil
                </option>
                <option value="published" <?= ($berita['status'] ?? '') === 'published' ? 'selected' : '' ?>>
                  Published — Tampil Publik
                </option>
              </select>
            </div>

            <div class="bf-divider"></div>

            <button type="submit" class="btn-primary" id="bf-submit">
              <i class="ti <?= $isEdit ? 'ti-device-floppy' : 'ti-send' ?>" aria-hidden="true"></i>
              <?= $isEdit ? 'Simpan Perubahan' : 'Simpan Berita' ?>
            </button>

            <?php if ($isEdit): ?>
            <a href="<?= BASE_URL ?>/berita/<?= htmlspecialchars($berita['slug'] ?? '') ?>"
               target="_blank" class="btn-view">
              <i class="ti ti-eye" aria-hidden="true"></i>
              Lihat di halaman publik
            </a>
            <?php endif; ?>
          </div>
        </div>

        <!-- Kategori -->
        <div class="bf-card">
          <div class="bf-card-title"><i class="ti ti-category" aria-hidden="true"></i> Kategori</div>
          <div class="bf-field">
            <label class="bf-label" for="bf-kat">Pilih Kategori</label>
            <select id="bf-kat" name="kategori_id" class="bf-select">
              <option value="">— Tidak ada —</option>
              <?php foreach ($kategoriList as $k): ?>
              <option value="<?= htmlspecialchars($k['id']) ?>"
                <?= ($berita['kategori_id'] ?? '') == $k['id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($k['nama']) ?>
              </option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <!-- Thumbnail -->
        <div class="bf-card">
          <div class="bf-card-title"><i class="ti ti-photo-up" aria-hidden="true"></i> Thumbnail</div>

          <?php if (!empty($berita['thumbnail'])): ?>
          <div style="margin-bottom:.85rem">
            <div class="bf-thumb-wrap">
              <img src="<?= UPLOAD_URL . '/' . htmlspecialchars($berita['thumbnail']) ?>" alt="Thumbnail saat ini">
              <span class="bf-thumb-badge">Saat ini</span>
            </div>
          </div>
          <?php endif; ?>

          <div class="bf-upload-zone" id="bf-drop">
            <input type="file" name="thumbnail" accept="image/jpeg,image/png,image/webp,image/gif"
                   onchange="previewThumb(this)">
            <div class="bf-upload-icon"><i class="ti ti-cloud-upload" aria-hidden="true"></i></div>
            <p class="bf-upload-text">Klik atau seret gambar ke sini</p>
            <p class="bf-upload-sub">JPG, PNG, WEBP — maks. 2 MB</p>
          </div>

          <!-- Preview baru -->
          <div id="bf-new-thumb" style="display:none;margin-top:.7rem">
            <div class="bf-thumb-wrap">
              <img id="bf-thumb-img" src="" alt="Preview">
              <span class="bf-thumb-badge" style="background:rgba(21,128,61,.8)">Baru</span>
            </div>
            <button type="button" onclick="clearThumb()" style="margin-top:6px;background:none;border:none;font-size:11px;color:var(--er);cursor:pointer;font-family:var(--ff);font-weight:600;padding:0;display:flex;align-items:center;gap:4px">
              <i class="ti ti-x" aria-hidden="true" style="font-size:13px"></i> Hapus pilihan
            </button>
          </div>

          <p class="bf-hint" style="margin-top:.6rem">Rekomendasi: 1200×630 px (rasio 16:9).</p>
        </div>

        <!-- Info (edit mode) -->
        <?php if ($isEdit): ?>
        <div class="bf-card">
          <div class="bf-card-title"><i class="ti ti-info-circle" aria-hidden="true"></i> Info</div>
          <div style="display:flex;flex-direction:column;gap:9px">
            <?php
              $rows = [
                ['ti-hash', 'ID Artikel', '#' . $berita['id']],
                ['ti-link', 'Slug', $berita['slug'] ?? '—'],
                ['ti-calendar-plus', 'Dibuat', isset($berita['created_at']) ? date('d M Y', strtotime($berita['created_at'])) : '—'],
                ['ti-user-edit', 'Penulis', $berita['penulis'] ?? ($_SESSION['user_name'] ?? '—')],
              ];
              foreach ($rows as [$ic, $lbl, $val]):
            ?>
            <div class="bf-info-row">
              <span class="bf-info-k"><i class="ti <?= $ic ?>" aria-hidden="true"></i> <?= $lbl ?></span>
              <span class="bf-info-v"><?= htmlspecialchars($val) ?></span>
            </div>
            <?php endforeach; ?>
          </div>
        </div>
        <?php endif; ?>

        <!-- Tips menulis -->
        <div class="bf-card bf-tip">
          <span class="bf-tip__icon"><i class="ti ti-bulb" aria-hidden="true"></i></span>
          <span class="bf-tip__text">
            <strong>Tips:</strong> gunakan <code>&lt;h2&gt;</code> untuk sub judul agar artikel mudah dipindai pembaca, dan isi Ringkasan supaya tampil rapi di pratinjau media sosial.
          </span>
        </div>

      </div><!-- /kolom kanan -->
    </div><!-- /grid -->
  </form>

</div>
</div>

<script>
/* Counter */
function updateCounter(el, id, max) {
  var c = document.getElementById(id);
  if (!c) return;
  var n = el.value.length;
  c.textContent = n + '/' + max;
  c.classList.toggle('warn', n > max * .85);
}
/* Init counters */
(function(){
  var j = document.getElementById('bf-judul');
  var r = document.getElementById('bf-ringkasan');
  if (j) updateCounter(j, 'jc', 200);
  if (r) updateCounter(r, 'rc', 300);
})();

/* Toolbar helpers */
function getTA(){ return document.getElementById('bf-konten'); }
function wrapTag(tag, attrs) {
  var ta = getTA();
  var s  = ta.selectionStart, e = ta.selectionEnd;
  var sel = ta.value.substring(s, e) || 'teks di sini';
  var open = attrs ? '<' + tag + ' ' + attrs + '>' : '<' + tag + '>';
  ta.setRangeText(open + sel + '</' + tag + '>', s, e, 'select');
  ta.focus();
}
function insertImg(){
  var ta = getTA();
  var s  = ta.selectionStart;
  var url = prompt('URL gambar:', 'https://');
  if (!url) return;
  var alt = prompt('Alt text:', 'Keterangan gambar') || '';
  ta.setRangeText('<img src="' + url + '" alt="' + alt + '" style="max-width:100%;">', s, s, 'end');
  ta.focus();
}
function insertList(){
  var ta = getTA();
  var s  = ta.selectionStart;
  ta.setRangeText('\n<ul>\n  <li>Item 1</li>\n  <li>Item 2</li>\n  <li>Item 3</li>\n</ul>\n', s, s, 'end');
  ta.focus();
}

/* Thumbnail preview */
function previewThumb(input) {
  if (!input.files || !input.files[0]) return;
  var reader = new FileReader();
  reader.onload = function(e) {
    document.getElementById('bf-thumb-img').src = e.target.result;
    document.getElementById('bf-new-thumb').style.display = 'block';
  };
  reader.readAsDataURL(input.files[0]);
}
function clearThumb() {
  document.querySelector('#bf-drop input[type=file]').value = '';
  document.getElementById('bf-new-thumb').style.display = 'none';
}

/* Drag & drop highlight */
var dz = document.getElementById('bf-drop');
if (dz) {
  ['dragenter','dragover'].forEach(function(ev){
    dz.addEventListener(ev, function(e){ e.preventDefault(); dz.style.borderColor='var(--ba)'; dz.style.background='var(--ac-lo)'; });
  });
  ['dragleave','drop'].forEach(function(ev){
    dz.addEventListener(ev, function(e){ dz.style.borderColor=''; dz.style.background=''; });
  });
}

/* Submit state */
document.getElementById('bf-form').addEventListener('submit', function(){
  var btn = document.getElementById('bf-submit');
  if (btn) { btn.disabled = true; btn.style.opacity = '.7'; }
});
</script>