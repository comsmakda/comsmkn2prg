<?php // app/views/admin/anggota_form.php ?>

<style>
/* ═══════════════════════════════════════
   SCOPE ROOT — alias ke Design System
═══════════════════════════════════════ */
.tambah-root {
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

.tambah-root *, .tambah-root *::before, .tambah-root *::after {
  box-sizing: border-box; margin: 0; padding: 0;
}
.tambah-root a { text-decoration: none; color: inherit; }
.tambah-root {
  font-family: var(--font-ui);
  color: var(--tx-primary);
  font-size: 13.5px;
  line-height: 1.5;
  -webkit-font-smoothing: antialiased;
}

/* ── Layout ── */
.tambah-wrap { max-width: 680px; }

/* ── Back link ── */
.tambah-back {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  font-size: 12px;
  font-weight: 700;
  color: var(--tx-muted);
  margin-bottom: 18px;
  transition: color var(--t-fast) var(--ease);
}
.tambah-back:hover { color: var(--ac); }
.tambah-back i { font-size: 14px; }

/* ── Page header (samakan dgn .dh dashboard) ── */
.tambah-ph { margin-bottom: 22px; }
.tambah-ph__eyebrow {
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
.tambah-ph__eyebrow-dot {
  width: 6px; height: 6px;
  border-radius: 50%;
  background: var(--ac);
  box-shadow: 0 0 6px var(--ac);
  flex-shrink: 0;
}
.tambah-ph__title {
  font-size: 24px;
  font-weight: 800;
  letter-spacing: -0.03em;
  color: var(--c-primary-dk, #0b5a70);
  line-height: 1.1;
}
.tambah-ph__sub {
  font-size: 12.5px;
  color: var(--tx-secondary);
  margin-top: 6px;
}

/* ── Flash (§5.5) ── */
.t-flash {
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
.t-flash i { font-size: 16px; flex-shrink: 0; margin-top: 1px; }
.t-flash--success { background: var(--green-d); border-color: rgba(21,128,61,.22); color: var(--green); }
.t-flash--error   { background: var(--red-d);   border-color: rgba(185,28,28,.22); color: var(--red); }
.t-flash--warning { background: var(--amber-d); border-color: rgba(217,145,12,.22); color: var(--amber); }
.t-flash--info    { background: var(--blue-d);  border-color: rgba(14,116,144,.22); color: var(--blue); }

/* ── Panel (identik dgn .panel dashboard) ── */
.t-panel {
  background: var(--bg-surface);
  border: 1px solid var(--bd-subtle);
  border-radius: var(--r-xl);
  overflow: hidden;
}
.t-panel__head {
  padding: 15px 20px;
  border-bottom: 1px solid var(--bd-subtle);
  display: flex;
  align-items: center;
  gap: 6px;
  flex-wrap: wrap;
}
.t-panel__head-title {
  font-size: 13px;
  font-weight: 800;
  color: var(--tx-primary);
  letter-spacing: -0.01em;
}
.t-panel__head-sub {
  font-size: 11.5px;
  color: var(--tx-muted);
  font-weight: 400;
}
.t-panel__body {
  padding: 22px 20px;
  display: flex;
  flex-direction: column;
  gap: 20px;
}
.t-panel__foot {
  padding: 15px 20px;
  border-top: 1px solid var(--bd-subtle);
  display: flex;
  align-items: center;
  gap: 8px;
  justify-content: flex-end;
  flex-wrap: wrap;
}

/* ── Section ── */
.t-section { display: flex; flex-direction: column; gap: 14px; }
.t-section + .t-section { padding-top: 18px; border-top: 1px solid var(--bd-subtle); }
.t-section__lbl {
  font-size: 10.5px;
  font-weight: 700;
  letter-spacing: 0.12em;
  text-transform: uppercase;
  color: var(--tx-muted);
}

/* ── Row ── */
.t-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
@media (max-width: 520px) { .t-row { grid-template-columns: 1fr; } }

/* ── Field ── */
.t-field { display: flex; flex-direction: column; gap: 6px; }
.t-field__lbl { font-size: 11.5px; font-weight: 700; color: var(--tx-primary); }
.t-field__lbl--req::after { content: ' *'; color: var(--red); }
.t-field__lbl-optional { font-weight: 400; color: var(--tx-muted); }
.t-field__hint { font-size: 10.5px; color: var(--tx-muted); font-weight: 500; }

/* ── Input base (§5.2 — icon di kanan) ── */
.t-input {
  font-family: var(--font-ui);
  font-size: 13.5px;
  color: var(--tx-primary);
  background: #fbfcfe;
  border: 1.5px solid var(--bd-subtle);
  border-radius: var(--r-sm);
  padding: 11px 14px;
  outline: none;
  width: 100%;
  -webkit-appearance: none;
  transition:
    border-color var(--t-base) var(--ease),
    background   var(--t-base) var(--ease),
    box-shadow   var(--t-base) var(--ease);
}
.t-input::placeholder { color: var(--tx-muted); font-size: 12.5px; }
.t-input:focus {
  border-color: var(--ac-lt);
  background: #fff;
  box-shadow: 0 0 0 3px rgba(6,182,212,.12);
}

.t-input-wrap { position: relative; }
.t-input-wrap .t-input { padding-right: 36px; }
.t-input-ico {
  position: absolute;
  right: 12px;
  top: 50%;
  transform: translateY(-50%);
  color: var(--tx-muted);
  display: flex;
  align-items: center;
  pointer-events: none;
  line-height: 0;
}
.t-input-ico i { font-size: 15px; }

/* Password toggle — punya 2 elemen kanan, jadi geser icon kunci ke kiri */
.t-input-wrap--pwd .t-input { padding-left: 14px; padding-right: 38px; }
.t-pwd-toggle {
  position: absolute;
  right: 10px;
  top: 50%;
  transform: translateY(-50%);
  width: 24px;
  height: 24px;
  background: none;
  border: none;
  cursor: pointer;
  color: var(--tx-muted);
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 0;
  transition: color var(--t-fast) var(--ease);
}
.t-pwd-toggle:hover { color: var(--ac); }
.t-pwd-toggle i { font-size: 16px; }

/* ── Dropzone ── */
.t-dropzone {
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
  text-align: center;
  position: relative;
  transition:
    border-color var(--t-base) var(--ease),
    background   var(--t-base) var(--ease);
}
.t-dropzone:hover, .t-dropzone.drag-over {
  border-color: var(--ac-lt);
  background: var(--ac-dim);
}
.t-dropzone input[type="file"] {
  position: absolute;
  inset: 0;
  width: 100%;
  height: 100%;
  opacity: 0;
  cursor: pointer;
}
.t-dropzone__ico {
  width: 34px; height: 34px;
  border-radius: var(--r-sm);
  background: var(--bg-overlay);
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--tx-muted);
  flex-shrink: 0;
}
.t-dropzone__ico i { font-size: 16px; }
.t-dropzone__text { font-size: 12px; font-weight: 700; color: var(--tx-secondary); }
.t-dropzone__hint { font-size: 10.5px; color: var(--tx-muted); }

/* ── Foto preview strip ── */
.t-foto-strip {
  display: none;
  align-items: center;
  gap: 10px;
  padding: 10px 12px;
  background: var(--ac-dim);
  border: 1px solid var(--bd-accent);
  border-radius: var(--r-lg);
  margin-top: 8px;
}
.t-foto-strip.visible { display: flex; }
.t-foto-strip__img {
  width: 44px; height: 44px;
  border-radius: var(--r-sm);
  object-fit: cover;
  border: 1px solid var(--bd-accent);
  flex-shrink: 0;
  display: block;
}
.t-foto-strip__name {
  font-size: 11.5px;
  font-weight: 600;
  color: var(--ac);
  flex: 1;
  min-width: 0;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}
.t-foto-strip__clear {
  width: 24px; height: 24px;
  background: none; border: none;
  cursor: pointer;
  color: var(--tx-muted);
  display: flex; align-items: center; justify-content: center;
  padding: 0; flex-shrink: 0;
  transition: color var(--t-fast) var(--ease);
}
.t-foto-strip__clear:hover { color: var(--red); }
.t-foto-strip__clear i { font-size: 15px; }

/* ── Checkbox row (§5.6) ── */
.t-check-row {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 13px 14px;
  background: var(--bg-elevated);
  border: 1.5px solid var(--bd-subtle);
  border-radius: var(--r-lg);
  cursor: pointer;
  user-select: none;
  transition:
    border-color var(--t-fast) var(--ease),
    background   var(--t-fast) var(--ease);
}
.t-check-row:has(input:checked) {
  border-color: var(--ac-lt);
  background: var(--ac-dim);
}
.t-check-row input[type="checkbox"] { display: none; }
.t-check-box {
  width: 18px; height: 18px;
  border-radius: var(--r-xs);
  border: 1.5px solid var(--bd-default);
  background: #fff;
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
  transition: all var(--t-fast) var(--ease);
}
.t-check-row:has(input:checked) .t-check-box { background: var(--ac); border-color: var(--ac); }
.t-check-box i { font-size: 12px; display: none; color: #fff; }
.t-check-row:has(input:checked) .t-check-box i { display: block; }
.t-check-text { font-size: 12.5px; font-weight: 600; color: var(--tx-secondary); flex: 1; }
.t-check-row:has(input:checked) .t-check-text { color: var(--tx-primary); }
.t-check-badge {
  font-size: 9.5px; font-weight: 700;
  letter-spacing: 0.08em; text-transform: uppercase;
  padding: 3px 8px;
  border-radius: 100px;
  background: var(--ac-glow);
  color: var(--ac);
  opacity: 0;
  white-space: nowrap;
  transition: opacity var(--t-base) var(--ease);
}
.t-check-row:has(input:checked) .t-check-badge { opacity: 1; }

/* ── Buttons (§5.3) ── */
.t-btn-cancel {
  display: inline-flex; align-items: center; gap: 6px;
  padding: 11px 18px;
  background: #fff;
  color: var(--tx-primary);
  font-family: var(--font-ui);
  font-size: 12.5px; font-weight: 700;
  border: 1.5px solid var(--bd-subtle);
  border-radius: var(--r-sm);
  cursor: pointer;
  transition: all var(--t-fast) var(--ease);
}
.t-btn-cancel:hover { background: #f4f7fa; border-color: var(--bd-default); }

.t-btn-save {
  display: inline-flex; align-items: center; gap: 7px;
  padding: 11px 22px;
  background: var(--ac);
  color: #fff;
  font-family: var(--font-ui);
  font-size: 12.5px; font-weight: 800;
  border: none;
  border-radius: var(--r-sm);
  cursor: pointer;
  line-height: 1;
  box-shadow: 0 8px 22px rgba(14,116,144,.25);
  transition:
    background  var(--t-fast) var(--ease),
    box-shadow  var(--t-base) var(--ease),
    transform   var(--t-fast) var(--ease);
}
.t-btn-save i { font-size: 15px; }
.t-btn-save:hover { background: var(--ac-lt); transform: translateY(-2px); box-shadow: 0 12px 28px rgba(6,182,212,.3); }
.t-btn-save:active { transform: translateY(0); }
.t-btn-save.is-loading { opacity: .75; pointer-events: none; }
.t-btn-save .ti-loader-2 { animation: t-spin .8s linear infinite; }
@keyframes t-spin { to { transform: rotate(360deg); } }

@media (max-width: 640px) {
  .t-panel { border-radius: var(--r-lg); }
}
</style>

<div class="tambah-root">
<div class="tambah-wrap">

  <!-- Back -->
  <a href="<?= BASE_URL ?>/admin/anggota" class="tambah-back">
    <i class="ti ti-arrow-left" aria-hidden="true"></i>
    Kembali ke Daftar Anggota
  </a>

  <!-- Header -->
  <div class="tambah-ph">
    <div class="tambah-ph__eyebrow">
      <span class="tambah-ph__eyebrow-dot"></span>
      Manajemen Anggota
    </div>
    <h1 class="tambah-ph__title">Tambah Anggota Manual</h1>
    <p class="tambah-ph__sub">Isi data anggota baru — NIA dapat digenerate otomatis setelah disimpan.</p>
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
  <div class="t-flash t-flash--<?= htmlspecialchars($flash['type']) ?>">
    <i class="ti <?= $flashIcons[$flash['type']] ?? $flashIcons['info'] ?>" aria-hidden="true"></i>
    <span><?= htmlspecialchars($flash['msg']) ?></span>
  </div>
  <?php endif; ?>

  <!-- Panel -->
  <div class="t-panel">
    <div class="t-panel__head">
      <span class="t-panel__head-title">Data Anggota Baru</span>
      <span class="t-panel__head-sub">— NIA dapat digenerate otomatis setelah simpan</span>
    </div>

    <form method="POST"
          action="<?= BASE_URL ?>/admin/anggota/tambah"
          enctype="multipart/form-data"
          id="add-form">
      <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">

      <div class="t-panel__body">

        <!-- ── Identitas ── -->
        <div class="t-section">
          <div class="t-section__lbl">Identitas</div>

          <div class="t-row">
            <!-- Nama -->
            <div class="t-field">
              <label class="t-field__lbl t-field__lbl--req" for="f-nama">Nama Lengkap</label>
              <div class="t-input-wrap">
                <input type="text" id="f-nama" name="nama_lengkap" required
                       class="t-input" placeholder="Nama lengkap…">
                <span class="t-input-ico">
                  <i class="ti ti-user" aria-hidden="true"></i>
                </span>
              </div>
            </div>
            <!-- Kelas -->
            <div class="t-field">
              <label class="t-field__lbl t-field__lbl--req" for="f-kelas">Kelas</label>
              <div class="t-input-wrap">
                <input type="text" id="f-kelas" name="kelas" required
                       class="t-input" placeholder="mis. XI RPL 1">
                <span class="t-input-ico">
                  <i class="ti ti-school" aria-hidden="true"></i>
                </span>
              </div>
            </div>
          </div>

          <div class="t-row">
            <!-- No HP -->
            <div class="t-field">
              <label class="t-field__lbl" for="f-nohp">No HP / WhatsApp</label>
              <div class="t-input-wrap">
                <input type="tel" id="f-nohp" name="no_hp"
                       class="t-input" placeholder="08xx xxxx xxxx">
                <span class="t-input-ico">
                  <i class="ti ti-phone" aria-hidden="true"></i>
                </span>
              </div>
            </div>
            <!-- Email -->
            <div class="t-field">
              <label class="t-field__lbl" for="f-email">Email <span class="t-field__lbl-optional">— opsional</span></label>
              <div class="t-input-wrap">
                <input type="email" id="f-email" name="email"
                       class="t-input" placeholder="email@domain.com">
                <span class="t-input-ico">
                  <i class="ti ti-mail" aria-hidden="true"></i>
                </span>
              </div>
            </div>
          </div>
        </div>

        <!-- ── Keamanan ── -->
        <div class="t-section">
          <div class="t-section__lbl">Keamanan</div>

          <div class="t-field">
            <label class="t-field__lbl t-field__lbl--req" for="f-pass">Password</label>
            <div class="t-input-wrap t-input-wrap--pwd">
              <input type="password" id="f-pass" name="password" required minlength="6"
                     class="t-input" placeholder="Min. 6 karakter">
              <button type="button" class="t-pwd-toggle" id="pwd-toggle"
                      aria-label="Toggle tampilkan password">
                <i class="ti ti-eye" id="ico-eye" aria-hidden="true"></i>
                <i class="ti ti-eye-off" id="ico-eye-off" aria-hidden="true" style="display:none"></i>
              </button>
            </div>
            <span class="t-field__hint">Minimum 6 karakter</span>
          </div>
        </div>

        <!-- ── Foto Profil ── -->
        <div class="t-section">
          <div class="t-section__lbl">Foto Profil</div>

          <div class="t-field">
            <label class="t-field__lbl">
              Pas Foto <span class="t-field__lbl-optional">— opsional, maks. 2 MB</span>
            </label>

            <div class="t-dropzone" id="foto-dropzone">
              <input type="file" name="foto" accept="image/*"
                     id="foto-input" aria-label="Upload foto profil">
              <div class="t-dropzone__ico">
                <i class="ti ti-cloud-upload" aria-hidden="true"></i>
              </div>
              <div class="t-dropzone__text">Klik atau seret foto ke sini</div>
              <div class="t-dropzone__hint">PNG, JPG, WEBP — maks. 2 MB</div>
            </div>

            <div class="t-foto-strip" id="foto-strip">
              <img class="t-foto-strip__img" id="foto-strip-img" src="" alt="Preview foto">
              <span class="t-foto-strip__name" id="foto-strip-name"></span>
              <button type="button" class="t-foto-strip__clear" id="foto-clear"
                      aria-label="Hapus pilihan foto">
                <i class="ti ti-x" aria-hidden="true"></i>
              </button>
            </div>
          </div>
        </div>

        <!-- ── Pengaturan ── -->
        <div class="t-section">
          <div class="t-section__lbl">Pengaturan</div>

          <label class="t-check-row">
            <input type="checkbox" name="aktivasi_langsung" value="1" checked id="chk-aktif">
            <span class="t-check-box">
              <i class="ti ti-check" aria-hidden="true"></i>
            </span>
            <span class="t-check-text">Aktifkan langsung &amp; generate NIA sekarang</span>
            <span class="t-check-badge">Auto NIA</span>
          </label>
        </div>

      </div><!-- /.t-panel__body -->

      <div class="t-panel__foot">
        <a href="<?= BASE_URL ?>/admin/anggota" class="t-btn-cancel">Batal</a>
        <button type="submit" class="t-btn-save" id="btn-save">
          <i class="ti ti-check" aria-hidden="true"></i>
          Simpan Anggota
        </button>
      </div>

    </form>
  </div><!-- /.t-panel -->

</div>
</div>

<script>
(function () {
  'use strict';

  /* ── Password toggle ── */
  var passInput = document.getElementById('f-pass');
  var pwdToggle = document.getElementById('pwd-toggle');
  var icoEye    = document.getElementById('ico-eye');
  var icoEyeOff = document.getElementById('ico-eye-off');

  if (pwdToggle && passInput) {
    pwdToggle.addEventListener('click', function () {
      var show = passInput.type === 'password';
      passInput.type = show ? 'text' : 'password';
      icoEye.style.display    = show ? 'none' : '';
      icoEyeOff.style.display = show ? ''     : 'none';
    });
  }

  /* ── Foto dropzone ── */
  var fileInput = document.getElementById('foto-input');
  var dropzone  = document.getElementById('foto-dropzone');
  var strip     = document.getElementById('foto-strip');
  var stripImg  = document.getElementById('foto-strip-img');
  var stripName = document.getElementById('foto-strip-name');
  var clearBtn  = document.getElementById('foto-clear');

  function showPreview(file) {
    stripName.textContent = file.name;
    var reader = new FileReader();
    reader.onload = function (e) {
      stripImg.src = e.target.result;
      strip.classList.add('visible');
    };
    reader.readAsDataURL(file);
  }

  function clearPreview() {
    fileInput.value = '';
    strip.classList.remove('visible');
    stripImg.src = '';
    stripName.textContent = '';
  }

  if (fileInput) {
    fileInput.addEventListener('change', function () {
      if (fileInput.files && fileInput.files[0]) showPreview(fileInput.files[0]);
    });
    dropzone.addEventListener('dragover', function (e) {
      e.preventDefault();
      dropzone.classList.add('drag-over');
    });
    ['dragleave', 'drop'].forEach(function (ev) {
      dropzone.addEventListener(ev, function () { dropzone.classList.remove('drag-over'); });
    });
  }

  if (clearBtn) { clearBtn.addEventListener('click', clearPreview); }

  /* ── Submit loading ── */
  var form    = document.getElementById('add-form');
  var saveBtn = document.getElementById('btn-save');
  if (form && saveBtn) {
    form.addEventListener('submit', function () {
      saveBtn.classList.add('is-loading');
      saveBtn.innerHTML = '<i class="ti ti-loader-2" aria-hidden="true"></i> Menyimpan…';
    });
  }
}());
</script>