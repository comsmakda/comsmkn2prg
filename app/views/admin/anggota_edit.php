<?php // app/views/admin/anggota_edit.php ?>

<style>
/* ═══════════════════════════════════════
   SCOPE ROOT — alias ke Design System
   (token asli didefinisikan global di layout;
    fallback disertakan bila file ini dirender berdiri sendiri)
═══════════════════════════════════════ */
.edit-root {
  --tx-primary:   var(--c-ink,    #0f172a);
  --tx-secondary: var(--c-muted,  #64748b);
  --tx-muted:     var(--c-muted2, #94a3b8);

  --bg-surface:  var(--c-white, #ffffff);
  --bg-elevated: #f8fafc;
  --bg-overlay:  #eef2f6;

  --bd-subtle:  var(--c-border, #e6ebf1);
  --bd-default: var(--c-border, #e6ebf1);
  --bd-accent:  var(--c-primary-25, rgba(14,116,144,.25));

  --ac:      var(--c-primary,    #0e7490);
  --ac-dim:  var(--c-primary-08, rgba(14,116,144,.08));
  --ac-glow: var(--c-primary-12, rgba(14,116,144,.12));
  --ac-lt:   var(--c-primary-lt, #06b6d4);

  --green:   var(--c-green-text, #15803d);
  --green-d: var(--c-green-bg,   #f0fdf4);
  --red:     var(--c-red-text,   #b91c1c);
  --red-d:   var(--c-red-bg,     #fef2f2);
  --amber:   var(--c-amber-icon, #d9910c);
  --amber-d: var(--c-amber-bg,   #fef6e2);
  --blue:    var(--c-primary,    #0e7490);
  --blue-d:  var(--c-primary-08, rgba(14,116,144,.08));

  --r-xs: 6px;
  --r-sm: var(--radius-sm, 9px);
  --r-md: var(--radius-sm, 9px);
  --r-lg: var(--radius-md, 13px);
  --r-xl: var(--radius-lg, 22px);

  --font-ui: var(--ff, 'Plus Jakarta Sans', sans-serif);

  --ease:   cubic-bezier(0.22, 1, 0.36, 1);
  --t-fast: 120ms;
  --t-base: 160ms;
}

.edit-root * { box-sizing: border-box; margin: 0; padding: 0; }
.edit-root a { text-decoration: none; color: inherit; }
.edit-root {
  font-family: var(--font-ui);
  color: var(--tx-primary);
  font-size: 13.5px;
  line-height: 1.5;
  -webkit-font-smoothing: antialiased;
}

.edit-wrap { max-width: 680px; }

/* ── Back link ── */
.edit-back {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  font-size: 12px;
  font-weight: 700;
  color: var(--tx-muted);
  margin-bottom: 18px;
  transition: color var(--t-fast) var(--ease);
}
.edit-back:hover { color: var(--ac); }
.edit-back i { font-size: 14px; }

/* ── Page header (samakan dgn .dh dashboard) ── */
.edit-ph { margin-bottom: 22px; }
.edit-ph__eyebrow {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  font-size: 11px;
  font-weight: 700;
  letter-spacing: 0.1em;
  text-transform: uppercase;
  color: var(--ac);
  margin-bottom: 8px;
}
.edit-ph__eyebrow-dot {
  width: 6px; height: 6px;
  border-radius: 50%;
  background: var(--ac);
  box-shadow: 0 0 6px var(--ac);
}
.edit-ph__title {
  font-size: 24px;
  font-weight: 800;
  letter-spacing: -0.03em;
  color: var(--c-primary-dk, #0b5a70);
  line-height: 1.1;
}
.edit-ph__sub {
  font-size: 12.5px;
  color: var(--tx-secondary);
  margin-top: 6px;
}
.edit-ph__sub strong { color: var(--tx-primary); font-weight: 700; }

/* ── Flash alert (§5.5) ── */
.flash {
  display: flex;
  align-items: flex-start;
  gap: 10px;
  padding: 12px 14px;
  border-radius: var(--r-lg);
  font-size: 12.5px;
  font-weight: 500;
  margin-bottom: 16px;
  border: 1px solid;
}
.flash i { font-size: 16px; flex-shrink: 0; margin-top: 1px; }
.flash--success { background: var(--green-d); border-color: rgba(21,128,61,.22); color: var(--green); }
.flash--error   { background: var(--red-d);   border-color: rgba(185,28,28,.22); color: var(--red); }
.flash--warning { background: var(--amber-d); border-color: rgba(217,145,12,.22); color: var(--amber); }
.flash--info    { background: var(--blue-d);  border-color: rgba(14,116,144,.22); color: var(--blue); }

/* ── NIA badge (kecil, aksen, konsisten dgn kpi style) ── */
.nia-badge {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 13px 16px;
  background: var(--ac-dim);
  border: 1px solid var(--bd-accent);
  border-radius: var(--r-lg);
  margin-bottom: 18px;
}
.nia-badge__icon {
  width: 36px; height: 36px;
  border-radius: var(--r-sm);
  background: var(--ac-glow);
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--ac);
  flex-shrink: 0;
}
.nia-badge__icon i { font-size: 16px; }
.nia-badge__val {
  font-size: 16px;
  font-weight: 800;
  color: var(--c-primary-dk, #0b5a70);
  letter-spacing: 0.01em;
  line-height: 1;
  font-variant-numeric: tabular-nums;
}
.nia-badge__lbl {
  font-size: 10.5px;
  color: var(--tx-muted);
  margin-top: 3px;
  font-weight: 500;
}

/* ── Panel (identik dgn .panel dashboard) ── */
.edit-panel {
  background: var(--bg-surface);
  border: 1px solid var(--bd-subtle);
  border-radius: var(--r-xl);
  overflow: hidden;
}
.edit-panel__head {
  padding: 15px 20px;
  border-bottom: 1px solid var(--bd-subtle);
}
.edit-panel__head-title {
  font-size: 13px;
  font-weight: 800;
  color: var(--tx-primary);
  letter-spacing: -0.01em;
}
.edit-panel__head-sub {
  font-size: 11.5px;
  color: var(--tx-muted);
  font-weight: 400;
  margin-left: 6px;
}
.edit-panel__body {
  padding: 22px 20px;
  display: flex;
  flex-direction: column;
  gap: 20px;
}

/* ── Section label (mengikuti .sec-label dashboard, versi ringkas) ── */
.form-section { display: flex; flex-direction: column; gap: 14px; }
.form-section + .form-section {
  padding-top: 18px;
  border-top: 1px solid var(--bd-subtle);
}
.form-section__label {
  font-size: 10.5px;
  font-weight: 700;
  letter-spacing: 0.12em;
  text-transform: uppercase;
  color: var(--tx-muted);
}

/* ── Form row 2-col ── */
.form-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 12px;
}
@media (max-width: 480px) { .form-row { grid-template-columns: 1fr; } }

/* ── Field ── */
.field { display: flex; flex-direction: column; gap: 6px; }
.field__label {
  font-size: 11.5px;
  font-weight: 700;
  color: var(--tx-ink, var(--tx-primary));
}
.field__label--req::after {
  content: ' *';
  color: var(--red);
}
.field__label-optional {
  font-weight: 400;
  color: var(--tx-muted);
}

/* Input base (§5.2 — icon SELALU di kanan) */
.finput {
  font-family: var(--font-ui);
  font-size: 13.5px;
  color: var(--tx-primary);
  background: #fbfcfe;
  border: 1.5px solid var(--bd-subtle);
  border-radius: var(--r-sm);
  padding: 11px 14px;
  outline: none;
  width: 100%;
  transition:
    border-color var(--t-base) var(--ease),
    background   var(--t-base) var(--ease),
    box-shadow   var(--t-base) var(--ease);
}
.finput::placeholder { color: var(--tx-muted); font-size: 12.5px; }
.finput:focus {
  border-color: var(--ac-lt);
  background: #fff;
  box-shadow: 0 0 0 3px rgba(6,182,212,.12);
}

.finput-wrap { position: relative; }
.finput-wrap .finput { padding-right: 36px; }
.finput-ico {
  position: absolute;
  right: 12px;
  top: 50%;
  transform: translateY(-50%);
  color: var(--tx-muted);
  display: flex;
  pointer-events: none;
}
.finput-ico i { font-size: 15px; }

/* ── Foto section ── */
.foto-row {
  display: flex;
  align-items: flex-start;
  gap: 16px;
  flex-wrap: wrap;
}
.foto-preview { flex-shrink: 0; }
.foto-preview__img {
  width: 72px; height: 72px;
  border-radius: var(--r-lg);
  object-fit: cover;
  border: 1px solid var(--bd-subtle);
  display: block;
}
.foto-preview__fallback {
  width: 72px; height: 72px;
  border-radius: var(--r-lg);
  background: var(--ac-dim);
  border: 1px solid var(--bd-accent);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 18px;
  font-weight: 800;
  color: var(--ac);
  text-transform: uppercase;
}
.foto-preview__cap {
  font-size: 10px;
  color: var(--tx-muted);
  margin-top: 6px;
  text-align: center;
  font-weight: 500;
}

.foto-upload { flex: 1; min-width: 220px; }
.foto-upload__label {
  font-size: 11.5px;
  font-weight: 700;
  color: var(--tx-primary);
  margin-bottom: 8px;
  display: block;
}
.foto-dropzone {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 8px;
  padding: 22px;
  background: var(--bg-elevated);
  border: 1.5px dashed var(--bd-default);
  border-radius: var(--r-lg);
  cursor: pointer;
  transition:
    border-color var(--t-base) var(--ease),
    background   var(--t-base) var(--ease);
  position: relative;
}
.foto-dropzone:hover,
.foto-dropzone.drag-over {
  border-color: var(--ac-lt);
  background: var(--ac-dim);
}
.foto-dropzone input[type="file"] {
  position: absolute;
  inset: 0;
  opacity: 0;
  cursor: pointer;
  width: 100%;
  height: 100%;
}
.foto-dropzone__ico {
  width: 34px; height: 34px;
  border-radius: var(--r-sm);
  background: var(--bg-overlay);
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--tx-muted);
}
.foto-dropzone__ico i { font-size: 16px; }
.foto-dropzone__text {
  font-size: 12px;
  font-weight: 700;
  color: var(--tx-secondary);
  text-align: center;
}
.foto-dropzone__hint {
  font-size: 10.5px;
  color: var(--tx-muted);
  text-align: center;
}
.foto-dropzone__chosen {
  font-size: 11px;
  font-weight: 600;
  color: var(--ac);
  display: none;
  text-align: center;
}

/* ── Footer / actions ── */
.edit-panel__foot {
  padding: 15px 20px;
  border-top: 1px solid var(--bd-subtle);
  display: flex;
  align-items: center;
  gap: 8px;
  justify-content: flex-end;
  flex-wrap: wrap;
}

.btn-cancel {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 11px 18px;
  background: #fff;
  color: var(--tx-primary);
  font-family: var(--font-ui);
  font-size: 12.5px;
  font-weight: 700;
  border: 1.5px solid var(--bd-subtle);
  border-radius: var(--r-sm);
  cursor: pointer;
  transition: all var(--t-fast) var(--ease);
}
.btn-cancel:hover { background: #f4f7fa; border-color: var(--bd-default); }

.btn-save {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  padding: 11px 22px;
  background: var(--ac);
  color: #fff;
  font-family: var(--font-ui);
  font-size: 12.5px;
  font-weight: 800;
  border: none;
  border-radius: var(--r-sm);
  cursor: pointer;
  box-shadow: 0 8px 22px rgba(14,116,144,.25);
  transition:
    background  var(--t-fast) var(--ease),
    box-shadow  var(--t-base) var(--ease),
    transform   var(--t-fast) var(--ease);
}
.btn-save:hover {
  background: var(--ac-lt);
  transform: translateY(-2px);
  box-shadow: 0 12px 28px rgba(6,182,212,.3);
}
.btn-save:active { transform: translateY(0); }
.btn-save i { font-size: 15px; }
.btn-save.is-loading { opacity: .75; pointer-events: none; }
.btn-save .ti-loader-2 { animation: spin .8s linear infinite; }
@keyframes spin { to { transform: rotate(360deg); } }

@media (max-width: 640px) {
  .edit-panel { border-radius: var(--r-lg); }
}
</style>

<div class="edit-root">
<div class="edit-wrap">

  <!-- Back -->
  <a href="<?= BASE_URL ?>/admin/anggota" class="edit-back">
    <i class="ti ti-arrow-left" aria-hidden="true"></i>
    Kembali ke Daftar Anggota
  </a>

  <!-- Page header -->
  <div class="edit-ph">
    <div class="edit-ph__eyebrow">
      <span class="edit-ph__eyebrow-dot"></span>
      Manajemen Anggota
    </div>
    <h1 class="edit-ph__title">Edit Anggota</h1>
    <p class="edit-ph__sub">Perbarui data <strong><?= htmlspecialchars($anggota['nama_lengkap']) ?></strong>.</p>
  </div>

  <!-- Flash -->
  <?php if (!empty($flash)): ?>
  <?php
    $flashIcons = [
      'success' => 'ti-circle-check',
      'error'   => 'ti-alert-circle',
      'warning' => 'ti-alert-triangle',
      'info'    => 'ti-info-circle',
    ];
  ?>
  <div class="flash flash--<?= htmlspecialchars($flash['type']) ?>">
    <i class="ti <?= $flashIcons[$flash['type']] ?? $flashIcons['info'] ?>" aria-hidden="true"></i>
    <span><?= htmlspecialchars($flash['msg']) ?></span>
  </div>
  <?php endif; ?>

  <!-- NIA Badge -->
  <?php if (!empty($anggota['nia'])): ?>
  <div class="nia-badge">
    <div class="nia-badge__icon">
      <i class="ti ti-id-badge-2" aria-hidden="true"></i>
    </div>
    <div>
      <div class="nia-badge__val"><?= htmlspecialchars($anggota['nia']) ?></div>
      <div class="nia-badge__lbl">Nomor Induk Anggota</div>
    </div>
  </div>
  <?php endif; ?>

  <!-- Form panel -->
  <div class="edit-panel">
    <div class="edit-panel__head">
      <span class="edit-panel__head-title">Data Anggota</span>
      <span class="edit-panel__head-sub">— perubahan disimpan langsung ke database</span>
    </div>

    <form method="POST"
          action="<?= BASE_URL ?>/admin/anggota/<?= (int)$anggota['id'] ?>/update"
          enctype="multipart/form-data"
          id="edit-form">
      <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">

      <div class="edit-panel__body">

        <!-- ── Identitas ── -->
        <div class="form-section">
          <div class="form-section__label">Identitas</div>

          <!-- Nama -->
          <div class="field">
            <label class="field__label field__label--req" for="f-nama">Nama Lengkap</label>
            <div class="finput-wrap">
              <input type="text" id="f-nama" name="nama_lengkap" required
                     class="finput"
                     placeholder="Masukkan nama lengkap…"
                     value="<?= htmlspecialchars($anggota['nama_lengkap']) ?>">
              <span class="finput-ico">
                <i class="ti ti-user" aria-hidden="true"></i>
              </span>
            </div>
          </div>

          <!-- Kelas + No HP -->
          <div class="form-row">
            <div class="field">
              <label class="field__label" for="f-kelas">Kelas</label>
              <div class="finput-wrap">
                <input type="text" id="f-kelas" name="kelas"
                       class="finput"
                       placeholder="mis. XII RPL 1"
                       value="<?= htmlspecialchars($anggota['kelas'] ?? '') ?>">
                <span class="finput-ico">
                  <i class="ti ti-school" aria-hidden="true"></i>
                </span>
              </div>
            </div>
            <div class="field">
              <label class="field__label" for="f-nohp">No HP / WhatsApp</label>
              <div class="finput-wrap">
                <input type="tel" id="f-nohp" name="no_hp"
                       class="finput"
                       placeholder="08xx xxxx xxxx"
                       value="<?= htmlspecialchars($anggota['no_hp'] ?? '') ?>">
                <span class="finput-ico">
                  <i class="ti ti-phone" aria-hidden="true"></i>
                </span>
              </div>
            </div>
          </div>
        </div>

        <!-- ── Foto ── -->
        <div class="form-section">
          <div class="form-section__label">Foto Profil</div>

          <div class="foto-row">

            <!-- Preview current -->
            <div class="foto-preview">
              <?php if (!empty($anggota['foto'])): ?>
                <img id="foto-preview-img"
                     src="<?= UPLOAD_URL . '/' . htmlspecialchars($anggota['foto']) ?>"
                     class="foto-preview__img"
                     alt="Foto <?= htmlspecialchars($anggota['nama_lengkap']) ?>">
              <?php else: ?>
                <div class="foto-preview__fallback" id="foto-preview-fallback">
                  <?= mb_strtoupper(mb_substr($anggota['nama_lengkap'], 0, 2)) ?>
                </div>
              <?php endif; ?>
              <div class="foto-preview__cap">Saat ini</div>
            </div>

            <!-- Upload zone -->
            <div class="foto-upload">
              <label class="foto-upload__label">
                Ganti Foto <span class="field__label-optional">— opsional</span>
              </label>
              <div class="foto-dropzone" id="foto-dropzone">
                <input type="file" name="foto" accept="image/*"
                       id="foto-input" aria-label="Upload foto">
                <div class="foto-dropzone__ico">
                  <i class="ti ti-cloud-upload" aria-hidden="true"></i>
                </div>
                <div class="foto-dropzone__text">Klik atau seret foto ke sini</div>
                <div class="foto-dropzone__hint">PNG, JPG, WEBP — maks. 2 MB</div>
                <div class="foto-dropzone__chosen" id="foto-chosen"></div>
              </div>
            </div>

          </div>
        </div>

      </div><!-- /.edit-panel__body -->

      <!-- Footer actions -->
      <div class="edit-panel__foot">
        <a href="<?= BASE_URL ?>/admin/anggota" class="btn-cancel">Batal</a>
        <button type="submit" class="btn-save" id="btn-save">
          <i class="ti ti-check" aria-hidden="true"></i>
          Simpan Perubahan
        </button>
      </div>

    </form>
  </div><!-- /.edit-panel -->

</div>
</div>

<script>
(function () {
  'use strict';

  /* ── Foto: preview on select ── */
  var fileInput  = document.getElementById('foto-input');
  var dropzone   = document.getElementById('foto-dropzone');
  var chosenEl   = document.getElementById('foto-chosen');
  var previewImg = document.getElementById('foto-preview-img');
  var fallback   = document.getElementById('foto-preview-fallback');

  if (fileInput) {
    fileInput.addEventListener('change', function () {
      var file = fileInput.files[0];
      if (!file) return;

      chosenEl.textContent = file.name;
      chosenEl.style.display = 'block';

      var reader = new FileReader();
      reader.onload = function (e) {
        if (previewImg) {
          previewImg.src = e.target.result;
        } else if (fallback) {
          var img = document.createElement('img');
          img.id        = 'foto-preview-img';
          img.className = 'foto-preview__img';
          img.src       = e.target.result;
          img.alt       = 'Preview';
          fallback.parentNode.replaceChild(img, fallback);
          previewImg = img;
          fallback   = null;
        }
      };
      reader.readAsDataURL(file);
    });

    dropzone.addEventListener('dragover', function (e) {
      e.preventDefault();
      dropzone.classList.add('drag-over');
    });
    ['dragleave', 'drop'].forEach(function (ev) {
      dropzone.addEventListener(ev, function () {
        dropzone.classList.remove('drag-over');
      });
    });
  }

  /* ── Save button loading state ── */
  var form    = document.getElementById('edit-form');
  var saveBtn = document.getElementById('btn-save');
  if (form && saveBtn) {
    form.addEventListener('submit', function () {
      saveBtn.classList.add('is-loading');
      saveBtn.innerHTML = '<i class="ti ti-loader-2" aria-hidden="true"></i> Menyimpan…';
    });
  }
}());
</script>