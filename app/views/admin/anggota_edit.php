<?php // app/views/admin/anggota_edit.php ?>

<style>
@import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;500;600&family=Sora:wght@300;400;500;600;700;800&display=swap');

:root {
  --font-ui:    'Sora', sans-serif;
  --font-mono:  'IBM Plex Mono', monospace;
  --bg-surface:  #0f1117;
  --bg-elevated: #141820;
  --bg-overlay:  #1a1f2e;
  --bd-subtle:   rgba(255,255,255,0.055);
  --bd-default:  rgba(255,255,255,0.10);
  --bd-accent:   rgba(99,179,237,0.35);
  --tx-primary:  #e8ecf4;
  --tx-secondary:#9aa3b8;
  --tx-muted:    #4f5773;
  --ac:          #63b3ed;
  --ac-dim:      rgba(99,179,237,0.10);
  --ac-glow:     rgba(99,179,237,0.18);
  --blue:        #4f9eff;
  --blue-d:      rgba(79,158,255,0.12);
  --green:       #48bb78;
  --green-d:     rgba(72,187,120,0.12);
  --red:         #fc8181;
  --red-d:       rgba(252,129,129,0.12);
  --amber:       #f6c244;
  --amber-d:     rgba(246,194,68,0.12);
  --r-xs: 4px; --r-sm: 6px; --r-md: 10px; --r-lg: 14px; --r-xl: 20px;
  --ease: cubic-bezier(0.16,1,0.3,1);
  --t-fast: 120ms; --t-base: 200ms;
}

.edit-root * { box-sizing: border-box; margin: 0; padding: 0; }
.edit-root a { text-decoration: none; color: inherit; }
.edit-root {
  font-family: var(--font-ui);
  color: var(--tx-primary);
  font-size: 13px;
  line-height: 1.5;
  -webkit-font-smoothing: antialiased;
}

/* ── Layout ── */
.edit-wrap {
  max-width: 620px;
}

/* ── Breadcrumb / back ── */
.edit-back {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  font-size: 12px;
  font-weight: 600;
  color: var(--tx-muted);
  margin-bottom: 20px;
  padding: 5px 0;
  border-radius: var(--r-xs);
  transition: color var(--t-fast) var(--ease);
}
.edit-back:hover { color: var(--tx-secondary); }
.edit-back svg { width: 13px; height: 13px; }

/* ── Page header ── */
.edit-ph {
  margin-bottom: 24px;
}
.edit-ph__eyebrow {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  font-family: var(--font-mono);
  font-size: 10px;
  font-weight: 500;
  letter-spacing: 0.14em;
  text-transform: uppercase;
  color: var(--ac);
  margin-bottom: 7px;
}
.edit-ph__eyebrow::before {
  content: '';
  width: 6px; height: 6px;
  border-radius: 50%;
  background: var(--ac);
  box-shadow: 0 0 6px var(--ac);
}
.edit-ph__title {
  font-size: 22px;
  font-weight: 800;
  letter-spacing: -0.04em;
  color: var(--tx-primary);
  line-height: 1.1;
}

/* ── Flash alert ── */
.flash {
  display: flex;
  align-items: flex-start;
  gap: 10px;
  padding: 12px 14px;
  border-radius: var(--r-md);
  font-size: 12.5px;
  font-weight: 500;
  margin-bottom: 18px;
  border: 1px solid;
}
.flash svg { width: 15px; height: 15px; flex-shrink: 0; margin-top: 1px; }
.flash--success { background: var(--green-d); border-color: rgba(72,187,120,0.25); color: var(--green); }
.flash--error   { background: var(--red-d);   border-color: rgba(252,129,129,0.25); color: var(--red); }
.flash--warning { background: var(--amber-d); border-color: rgba(246,194,68,0.25);  color: var(--amber); }
.flash--info    { background: var(--blue-d);  border-color: rgba(79,158,255,0.25);  color: var(--blue); }

/* ── NIA Badge ── */
.nia-badge {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 14px 16px;
  background: var(--ac-dim);
  border: 1px solid var(--bd-accent);
  border-radius: var(--r-md);
  margin-bottom: 22px;
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
.nia-badge__icon svg { width: 16px; height: 16px; }
.nia-badge__val {
  font-family: var(--font-mono);
  font-size: 18px;
  font-weight: 700;
  color: var(--ac);
  letter-spacing: 0.06em;
  line-height: 1;
}
.nia-badge__lbl {
  font-size: 10.5px;
  color: var(--tx-muted);
  margin-top: 3px;
}

/* ── Panel ── */
.edit-panel {
  background: var(--bg-surface);
  border: 1px solid var(--bd-subtle);
  border-radius: var(--r-lg);
  overflow: hidden;
}
.edit-panel__head {
  padding: 14px 20px;
  border-bottom: 1px solid var(--bd-subtle);
  display: flex;
  align-items: center;
  gap: 8px;
}
.edit-panel__head-title {
  font-size: 12.5px;
  font-weight: 700;
  color: var(--tx-primary);
  letter-spacing: -0.01em;
}
.edit-panel__head-sub {
  font-size: 11px;
  color: var(--tx-muted);
}
.edit-panel__body {
  padding: 22px 20px;
  display: flex;
  flex-direction: column;
  gap: 18px;
}

/* ── Section divider inside form ── */
.form-section {
  display: flex;
  flex-direction: column;
  gap: 16px;
}
.form-section + .form-section {
  padding-top: 18px;
  border-top: 1px solid var(--bd-subtle);
}
.form-section__label {
  font-family: var(--font-mono);
  font-size: 9.5px;
  font-weight: 600;
  letter-spacing: 0.16em;
  text-transform: uppercase;
  color: var(--tx-muted);
  margin-bottom: 4px;
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
  font-weight: 600;
  color: var(--tx-secondary);
  letter-spacing: 0.01em;
}
.field__label--req::after {
  content: ' *';
  color: var(--red);
  font-size: 11px;
}
.field__hint {
  font-size: 10.5px;
  color: var(--tx-muted);
  margin-top: -2px;
}

/* Input & select base */
.finput {
  font-family: var(--font-ui);
  font-size: 13px;
  color: var(--tx-primary);
  background: var(--bg-elevated);
  border: 1px solid var(--bd-subtle);
  border-radius: var(--r-md);
  padding: 9px 12px;
  outline: none;
  width: 100%;
  transition:
    border-color var(--t-fast) var(--ease),
    background   var(--t-fast) var(--ease),
    box-shadow   var(--t-base) var(--ease);
}
.finput::placeholder { color: var(--tx-muted); font-size: 12.5px; }
.finput:focus {
  border-color: var(--bd-accent);
  background: var(--bg-overlay);
  box-shadow: 0 0 0 3px rgba(99,179,237,0.08);
}
.finput:disabled {
  opacity: .5;
  cursor: not-allowed;
}

/* Input with leading icon */
.finput-wrap { position: relative; }
.finput-wrap .finput { padding-left: 34px; }
.finput-ico {
  position: absolute;
  left: 11px;
  top: 50%;
  transform: translateY(-50%);
  color: var(--tx-muted);
  display: flex;
  pointer-events: none;
}
.finput-ico svg { width: 13px; height: 13px; }

/* ── Foto section ── */
.foto-row {
  display: flex;
  align-items: flex-start;
  gap: 16px;
  flex-wrap: wrap;
}
.foto-preview {
  flex-shrink: 0;
}
.foto-preview__img {
  width: 72px; height: 72px;
  border-radius: var(--r-md);
  object-fit: cover;
  border: 1px solid var(--bd-subtle);
  display: block;
}
.foto-preview__fallback {
  width: 72px; height: 72px;
  border-radius: var(--r-md);
  background: var(--bg-overlay);
  border: 1px solid var(--bd-subtle);
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: var(--font-mono);
  font-size: 18px;
  font-weight: 700;
  color: var(--tx-muted);
  text-transform: uppercase;
}
.foto-preview__cap {
  font-size: 10px;
  color: var(--tx-muted);
  margin-top: 5px;
  text-align: center;
}

.foto-upload { flex: 1; min-width: 0; }
.foto-dropzone {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 8px;
  padding: 20px;
  background: var(--bg-elevated);
  border: 1.5px dashed var(--bd-default);
  border-radius: var(--r-md);
  cursor: pointer;
  transition:
    border-color var(--t-base) var(--ease),
    background   var(--t-base) var(--ease);
  position: relative;
}
.foto-dropzone:hover,
.foto-dropzone.drag-over {
  border-color: var(--bd-accent);
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
  width: 32px; height: 32px;
  border-radius: var(--r-sm);
  background: var(--bg-overlay);
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--tx-muted);
}
.foto-dropzone__ico svg { width: 15px; height: 15px; }
.foto-dropzone__text {
  font-size: 12px;
  font-weight: 600;
  color: var(--tx-secondary);
  text-align: center;
}
.foto-dropzone__hint {
  font-size: 10.5px;
  color: var(--tx-muted);
  text-align: center;
}
.foto-dropzone__chosen {
  font-family: var(--font-mono);
  font-size: 11px;
  color: var(--ac);
  display: none;
  text-align: center;
}

/* ── Form footer / actions ── */
.edit-panel__foot {
  padding: 14px 20px;
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
  padding: 9px 16px;
  background: var(--bg-elevated);
  color: var(--tx-secondary);
  font-family: var(--font-ui);
  font-size: 12.5px;
  font-weight: 600;
  border: 1px solid var(--bd-subtle);
  border-radius: var(--r-md);
  cursor: pointer;
  transition: all var(--t-fast) var(--ease);
}
.btn-cancel:hover { border-color: var(--bd-default); color: var(--tx-primary); background: var(--bg-overlay); }

.btn-save {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  padding: 9px 20px;
  background: var(--ac);
  color: #0a0c10;
  font-family: var(--font-ui);
  font-size: 12.5px;
  font-weight: 700;
  border: none;
  border-radius: var(--r-md);
  cursor: pointer;
  transition:
    background  var(--t-fast) var(--ease),
    box-shadow  var(--t-base) var(--ease),
    transform   var(--t-fast) var(--ease);
}
.btn-save:hover {
  background: #7ec8f5;
  box-shadow: 0 4px 18px rgba(99,179,237,0.28);
  transform: translateY(-1px);
}
.btn-save:active { transform: translateY(0); }
.btn-save svg { width: 14px; height: 14px; }
.btn-save.is-loading { opacity: .7; pointer-events: none; }
</style>

<div class="edit-root">
<div class="edit-wrap">

  <!-- Back -->
  <a href="<?= BASE_URL ?>/admin/anggota" class="edit-back">
    <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
      <path d="M9 2L4 7l5 5"/>
    </svg>
    Kembali ke Daftar Anggota
  </a>

  <!-- Page header -->
  <div class="edit-ph">
    <div class="edit-ph__eyebrow">Manajemen Anggota</div>
    <h1 class="edit-ph__title">Edit Anggota</h1>
  </div>

  <!-- Flash -->
  <?php if (!empty($flash)): ?>
  <?php
    $flashIcons = [
      'success' => '<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="8" cy="8" r="6.5"/><path d="M5 8l2 2 4-4"/></svg>',
      'error'   => '<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="8" cy="8" r="6.5"/><path d="M8 5v3.5"/><circle cx="8" cy="11" r=".6" fill="currentColor"/></svg>',
      'warning' => '<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M8 2L1.5 13h13L8 2z"/><path d="M8 7v3"/><circle cx="8" cy="11.5" r=".6" fill="currentColor"/></svg>',
      'info'    => '<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="8" cy="8" r="6.5"/><path d="M8 7v4M8 5.5v.5"/></svg>',
    ];
  ?>
  <div class="flash flash--<?= htmlspecialchars($flash['type']) ?>">
    <?= $flashIcons[$flash['type']] ?? $flashIcons['info'] ?>
    <span><?= htmlspecialchars($flash['msg']) ?></span>
  </div>
  <?php endif; ?>

  <!-- NIA Badge -->
  <?php if (!empty($anggota['nia'])): ?>
  <div class="nia-badge">
    <div class="nia-badge__icon">
      <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <rect x="2" y="2" width="12" height="12" rx="1.5"/>
        <path d="M5 6h6M5 8.5h4M5 11h3"/>
      </svg>
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
              <span class="finput-ico">
                <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                  <circle cx="7" cy="4.5" r="2.5"/>
                  <path d="M2 13c0-2.76 2.24-5 5-5s5 2.24 5 5"/>
                </svg>
              </span>
              <input type="text" id="f-nama" name="nama_lengkap" required
                     class="finput"
                     placeholder="Masukkan nama lengkap…"
                     value="<?= htmlspecialchars($anggota['nama_lengkap']) ?>">
            </div>
          </div>

          <!-- Kelas + No HP -->
          <div class="form-row">
            <div class="field">
              <label class="field__label" for="f-kelas">Kelas</label>
              <div class="finput-wrap">
                <span class="finput-ico">
                  <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <rect x="1.5" y="1.5" width="11" height="11" rx="1.5"/>
                  </svg>
                </span>
                <input type="text" id="f-kelas" name="kelas"
                       class="finput"
                       placeholder="mis. XII RPL 1"
                       value="<?= htmlspecialchars($anggota['kelas'] ?? '') ?>">
              </div>
            </div>
            <div class="field">
              <label class="field__label" for="f-nohp">No HP / WhatsApp</label>
              <div class="finput-wrap">
                <span class="finput-ico">
                  <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <rect x="3.5" y="1" width="7" height="12" rx="1.5"/>
                    <circle cx="7" cy="10.5" r=".5" fill="currentColor"/>
                  </svg>
                </span>
                <input type="tel" id="f-nohp" name="no_hp"
                       class="finput"
                       placeholder="08xx xxxx xxxx"
                       value="<?= htmlspecialchars($anggota['no_hp'] ?? '') ?>">
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
              <label class="field__label" style="margin-bottom:6px;display:block;">
                Ganti Foto
                <span style="font-weight:400;color:var(--tx-muted);"> — opsional</span>
              </label>
              <div class="foto-dropzone" id="foto-dropzone">
                <input type="file" name="foto" accept="image/*"
                       id="foto-input" aria-label="Upload foto">
                <div class="foto-dropzone__ico">
                  <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M8 11V4M5 7l3-3 3 3"/>
                    <path d="M2 13h12"/>
                  </svg>
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
          <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M2 7l3.5 3.5L12 3"/>
          </svg>
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
          /* swap fallback for real img */
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

    /* drag & drop highlight */
    dropzone.addEventListener('dragover', function (e) {
      e.preventDefault();
      dropzone.classList.add('drag-over');
    });
    ['dragleave','drop'].forEach(function (ev) {
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
      saveBtn.innerHTML = '<svg width="14" height="14" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true"><path d="M7 2a5 5 0 110 10" stroke-dasharray="20" stroke-dashoffset="20"><animate attributeName="stroke-dashoffset" values="20;0" dur="0.8s" repeatCount="indefinite"/></path></svg> Menyimpan…';
    });
  }
}());
</script>