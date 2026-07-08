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

.edit-wrap { max-width: 1040px; }

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

/* ── Page header ── */
.edit-ph {
  display: flex;
  align-items: flex-end;
  justify-content: space-between;
  gap: 16px;
  flex-wrap: wrap;
  margin-bottom: 22px;
}
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

.edit-ph__status {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  padding: 8px 14px;
  background: var(--green-d);
  border: 1px solid rgba(21,128,61,.22);
  border-radius: 999px;
  font-size: 11.5px;
  font-weight: 700;
  color: var(--green);
  flex-shrink: 0;
}
.edit-ph__status i { font-size: 14px; }

/* ── Flash alert ── */
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

/* ── Layout 2 kolom: form (kiri) + sidebar (kanan) ── */
.edit-grid {
  display: grid;
  grid-template-columns: 1fr 320px;
  gap: 20px;
  align-items: start;
}
@media (max-width: 860px) {
  .edit-grid { grid-template-columns: 1fr; }
}

/* ── Panel dasar ── */
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

/* ── Section label ── */
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

/* Input base (icon SELALU di kanan) */
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

/* ── Footer / actions (form kiri) ── */
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

/* ═══════════════════════════════════════
   SIDEBAR (kolom kanan)
═══════════════════════════════════════ */
.edit-side {
  display: flex;
  flex-direction: column;
  gap: 16px;
  position: sticky;
  top: 16px;
}

/* Kartu foto profil */
.side-photo {
  padding: 20px;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 14px;
  text-align: center;
}
.side-photo__frame {
  position: relative;
  width: 112px;
  height: 112px;
}
.side-photo__img {
  width: 112px; height: 112px;
  border-radius: var(--r-xl);
  object-fit: cover;
  border: 1px solid var(--bd-subtle);
  display: block;
}
.side-photo__fallback {
  width: 112px; height: 112px;
  border-radius: var(--r-xl);
  background: var(--ac-dim);
  border: 1px solid var(--bd-accent);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 30px;
  font-weight: 800;
  color: var(--ac);
  text-transform: uppercase;
}
.side-photo__badge {
  position: absolute;
  bottom: -4px;
  right: -4px;
  width: 30px; height: 30px;
  border-radius: 50%;
  background: var(--ac);
  border: 3px solid var(--bg-surface);
  display: flex;
  align-items: center;
  justify-content: center;
  color: #fff;
}
.side-photo__badge i { font-size: 13px; }

.side-photo__name {
  font-size: 14px;
  font-weight: 800;
  color: var(--tx-primary);
  letter-spacing: -0.01em;
  line-height: 1.3;
}
.side-photo__meta {
  font-size: 11.5px;
  color: var(--tx-muted);
  font-weight: 500;
}

/* Dropzone upload — full width di sidebar */
.foto-upload { width: 100%; }
.foto-upload__label {
  font-size: 11px;
  font-weight: 700;
  color: var(--tx-primary);
  margin-bottom: 8px;
  display: block;
  text-align: left;
}
.foto-dropzone {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 8px;
  padding: 20px 14px;
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
  width: 32px; height: 32px;
  border-radius: var(--r-sm);
  background: var(--bg-overlay);
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--tx-muted);
}
.foto-dropzone__ico i { font-size: 15px; }
.foto-dropzone__text {
  font-size: 11.5px;
  font-weight: 700;
  color: var(--tx-secondary);
  text-align: center;
}
.foto-dropzone__hint {
  font-size: 10px;
  color: var(--tx-muted);
  text-align: center;
}
.foto-dropzone__chosen {
  font-size: 10.5px;
  font-weight: 600;
  color: var(--ac);
  display: none;
  text-align: center;
  word-break: break-all;
}

/* Kartu NIA */
.side-nia {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 15px 16px;
}
.side-nia__icon {
  width: 38px; height: 38px;
  border-radius: var(--r-sm);
  background: var(--ac-glow);
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--ac);
  flex-shrink: 0;
}
.side-nia__icon i { font-size: 17px; }
.side-nia__val {
  font-size: 15px;
  font-weight: 800;
  color: var(--c-primary-dk, #0b5a70);
  letter-spacing: 0.01em;
  line-height: 1.2;
  font-variant-numeric: tabular-nums;
}
.side-nia__lbl {
  font-size: 10.5px;
  color: var(--tx-muted);
  margin-top: 2px;
  font-weight: 500;
}

/* Kartu info ringkas */
.side-info__list {
  display: flex;
  flex-direction: column;
}
.side-info__row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 10px;
  padding: 12px 20px;
}
.side-info__row + .side-info__row {
  border-top: 1px solid var(--bd-subtle);
}
.side-info__k {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 11.5px;
  color: var(--tx-secondary);
  font-weight: 600;
}
.side-info__k i { font-size: 14px; color: var(--tx-muted); }
.side-info__v {
  font-size: 12px;
  font-weight: 700;
  color: var(--tx-primary);
  text-align: right;
}

/* Kartu bantuan / tip */
.side-tip {
  padding: 16px 18px;
  background: var(--ac-dim);
  border: 1px solid var(--bd-accent);
  display: flex;
  gap: 10px;
  align-items: flex-start;
}
.side-tip__icon {
  color: var(--ac);
  flex-shrink: 0;
  margin-top: 1px;
}
.side-tip__icon i { font-size: 16px; }
.side-tip__text {
  font-size: 11.5px;
  line-height: 1.5;
  color: var(--tx-secondary);
}
.side-tip__text strong { color: var(--tx-primary); font-weight: 700; }

@media (max-width: 640px) {
  .edit-panel { border-radius: var(--r-lg); }
  .edit-side { position: static; }
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
    <div>
      <div class="edit-ph__eyebrow">
        <span class="edit-ph__eyebrow-dot"></span>
        Manajemen Anggota
      </div>
      <h1 class="edit-ph__title">Edit Anggota</h1>
      <p class="edit-ph__sub">Perbarui data <strong><?= htmlspecialchars($anggota['nama_lengkap']) ?></strong>.</p>
    </div>
    <span class="edit-ph__status">
      <i class="ti ti-user-check" aria-hidden="true"></i>
      Anggota Aktif
    </span>
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

  <form method="POST"
        action="<?= BASE_URL ?>/admin/anggota/<?= (int)$anggota['id'] ?>/update"
        enctype="multipart/form-data"
        id="edit-form">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">

    <div class="edit-grid">

      <!-- ══════════ KOLOM KIRI — Form utama ══════════ -->
      <div class="edit-panel">
        <div class="edit-panel__head">
          <span class="edit-panel__head-title">Data Anggota</span>
          <span class="edit-panel__head-sub">— perubahan disimpan langsung ke database</span>
        </div>

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

          <!-- ── Kontak & Alamat (opsional, mengisi hirarki form agar tidak timpang) ── -->
          <div class="form-section">
            <div class="form-section__label">Kontak &amp; Alamat</div>

            <div class="field">
              <label class="field__label" for="f-alamat">
                Alamat <span class="field__label-optional">— opsional</span>
              </label>
              <div class="finput-wrap">
                <input type="text" id="f-alamat" name="alamat"
                       class="finput"
                       placeholder="Nama jalan, RT/RW, kelurahan…"
                       value="<?= htmlspecialchars($anggota['alamat'] ?? '') ?>">
                <span class="finput-ico">
                  <i class="ti ti-map-pin" aria-hidden="true"></i>
                </span>
              </div>
            </div>

            <div class="form-row">
              <div class="field">
                <label class="field__label" for="f-email">
                  Email <span class="field__label-optional">— opsional</span>
                </label>
                <div class="finput-wrap">
                  <input type="email" id="f-email" name="email"
                         class="finput"
                         placeholder="nama@email.com"
                         value="<?= htmlspecialchars($anggota['email'] ?? '') ?>">
                  <span class="finput-ico">
                    <i class="ti ti-mail" aria-hidden="true"></i>
                  </span>
                </div>
              </div>
              <div class="field">
                <label class="field__label" for="f-jk">Jenis Kelamin</label>
                <div class="finput-wrap">
                  <input type="text" id="f-jk" name="jenis_kelamin"
                         class="finput"
                         placeholder="Laki-laki / Perempuan"
                         value="<?= htmlspecialchars($anggota['jenis_kelamin'] ?? '') ?>">
                  <span class="finput-ico">
                    <i class="ti ti-gender-bigender" aria-hidden="true"></i>
                  </span>
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
      </div><!-- /.edit-panel kiri -->

      <!-- ══════════ KOLOM KANAN — Sidebar ══════════ -->
      <div class="edit-side">

        <!-- Kartu foto profil + upload -->
        <div class="edit-panel side-photo">
          <div class="side-photo__frame">
            <?php if (!empty($anggota['foto'])): ?>
              <img id="foto-preview-img"
                   src="<?= UPLOAD_URL . '/' . htmlspecialchars($anggota['foto']) ?>"
                   class="side-photo__img"
                   alt="Foto <?= htmlspecialchars($anggota['nama_lengkap']) ?>">
            <?php else: ?>
              <div class="side-photo__fallback" id="foto-preview-fallback">
                <?= mb_strtoupper(mb_substr($anggota['nama_lengkap'], 0, 2)) ?>
              </div>
            <?php endif; ?>
            <span class="side-photo__badge">
              <i class="ti ti-camera" aria-hidden="true"></i>
            </span>
          </div>

          <div>
            <div class="side-photo__name"><?= htmlspecialchars($anggota['nama_lengkap']) ?></div>
            <div class="side-photo__meta"><?= htmlspecialchars($anggota['kelas'] ?? 'Kelas belum diisi') ?></div>
          </div>

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
              <div class="foto-dropzone__text">Klik atau seret foto</div>
              <div class="foto-dropzone__hint">PNG, JPG, WEBP — maks. 2 MB</div>
              <div class="foto-dropzone__chosen" id="foto-chosen"></div>
            </div>
          </div>
        </div>

        <!-- Kartu NIA -->
        <?php if (!empty($anggota['nia'])): ?>
        <div class="edit-panel side-nia">
          <div class="side-nia__icon">
            <i class="ti ti-id-badge-2" aria-hidden="true"></i>
          </div>
          <div>
            <div class="side-nia__val"><?= htmlspecialchars($anggota['nia']) ?></div>
            <div class="side-nia__lbl">Nomor Induk Anggota</div>
          </div>
        </div>
        <?php endif; ?>

        <!-- Kartu info ringkas -->
        <div class="edit-panel">
          <div class="edit-panel__head">
            <span class="edit-panel__head-title">Ringkasan</span>
          </div>
          <div class="side-info__list">
            <div class="side-info__row">
              <span class="side-info__k"><i class="ti ti-calendar-plus" aria-hidden="true"></i> Terdaftar</span>
              <span class="side-info__v"><?= !empty($anggota['created_at']) ? htmlspecialchars(date('d M Y', strtotime($anggota['created_at']))) : '—' ?></span>
            </div>
            <div class="side-info__row">
              <span class="side-info__k"><i class="ti ti-refresh" aria-hidden="true"></i> Terakhir diubah</span>
              <span class="side-info__v"><?= !empty($anggota['updated_at']) ? htmlspecialchars(date('d M Y', strtotime($anggota['updated_at']))) : '—' ?></span>
            </div>
            <div class="side-info__row">
              <span class="side-info__k"><i class="ti ti-hash" aria-hidden="true"></i> ID Sistem</span>
              <span class="side-info__v">#<?= (int)$anggota['id'] ?></span>
            </div>
          </div>
        </div>

        <!-- Tip -->
        <div class="edit-panel side-tip">
          <span class="side-tip__icon"><i class="ti ti-bulb" aria-hidden="true"></i></span>
          <span class="side-tip__text">
            <strong>Tips:</strong> pastikan No HP aktif agar notifikasi WhatsApp dari organisasi dapat diterima.
          </span>
        </div>

      </div><!-- /.edit-side -->

    </div><!-- /.edit-grid -->
  </form>

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
          img.className = 'side-photo__img';
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