<?php // app/views/admin/profil.php ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />
<style>
/* ═══════════════════════════════════════
   SCOPE ROOT — alias ke Design System
   (token asli didefinisikan global di layout;
    fallback disertakan bila file ini dirender berdiri sendiri)
═══════════════════════════════════════ */
.prf {
  /* Text */
  --tx-primary:   var(--c-ink,    #0f172a);
  --tx-secondary: var(--c-muted,  #64748b);
  --tx-muted:     var(--c-muted2, #94a3b8);

  /* Surface */
  --bg-surface:  var(--c-white, #ffffff);
  --bg-elevated: #f8fafc;
  --bg-overlay:  #eef2f6;
  --bg-active:   var(--c-primary-08, rgba(14,116,144,.08));

  /* Border */
  --bd-subtle:  var(--c-border, #e6ebf1);
  --bd-default: var(--c-border, #e6ebf1);
  --bd-accent:  var(--c-primary-25, rgba(14,116,144,.25));

  /* Accent (satu-satunya warna aksen dekoratif) */
  --ac:      var(--c-primary,    #0e7490);
  --ac-dk:   var(--c-primary-dk, #0b5a70);
  --ac-lt:   var(--c-primary-lt, #06b6d4);
  --ac-dim:  var(--c-primary-08, rgba(14,116,144,.08));
  --ac-glow: var(--c-primary-12, rgba(14,116,144,.12));

  /* Status */
  --green:   var(--c-green-text, #15803d);
  --green-d: var(--c-green-bg,   #f0fdf4);
  --red:     var(--c-red-text,   #b91c1c);
  --red-d:   var(--c-red-bg,     #fef2f2);
  --amber:   var(--c-amber-icon, #d9910c);
  --amber-d: var(--c-amber-bg,   #fef6e2);

  /* Radius */
  --r-xs: 6px;
  --r-sm: var(--radius-sm, 9px);
  --r-md: var(--radius-md, 13px);
  --r-lg: var(--radius-lg, 22px);

  /* Font — satu keluarga font di seluruh sistem */
  --font-ui: var(--ff, 'Plus Jakarta Sans', sans-serif);

  /* Motion */
  --ease:  cubic-bezier(0.22, 1, 0.36, 1);
  --t-fast: 120ms;
  --t-base: 160ms;
  --t-slow: 300ms;
}

.prf * { box-sizing: border-box; margin: 0; padding: 0; }
.prf {
  font-family: var(--font-ui);
  color: var(--tx-primary);
  font-size: 13.5px;
  line-height: 1.5;
  -webkit-font-smoothing: antialiased;
  max-width: 900px;
}
.prf a { text-decoration: none; color: inherit; }

/* ═══════════════════════════════════════
   PAGE HEADER
═══════════════════════════════════════ */
.ph {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  gap: 16px;
  margin-bottom: 28px;
  flex-wrap: wrap;
}
.ph__eyebrow {
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
.ph__eyebrow::before {
  content: '';
  width: 6px; height: 6px;
  border-radius: 50%;
  background: var(--ac);
  box-shadow: 0 0 6px var(--ac);
  animation: pulse-dot 2.4s ease-in-out infinite;
}
@keyframes pulse-dot {
  0%,100% { opacity:1; box-shadow: 0 0 6px var(--ac); }
  50%      { opacity:.5; box-shadow: 0 0 12px var(--ac); }
}
.ph__title {
  font-size: 26px;
  font-weight: 800;
  letter-spacing: -0.03em;
  color: var(--ac-dk);
  line-height: 1.1;
}
.ph__sub {
  font-size: 13px;
  color: var(--tx-secondary);
  margin-top: 6px;
}

/* ═══════════════════════════════════════
   BUTTONS
═══════════════════════════════════════ */
.btn-sec {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 9px 16px;
  background: var(--bg-surface);
  color: var(--tx-secondary);
  font-family: var(--font-ui);
  font-size: 12.5px;
  font-weight: 700;
  border: 1.5px solid var(--bd-subtle);
  border-radius: var(--r-sm);
  cursor: pointer;
  text-decoration: none;
  transition: all var(--t-fast) var(--ease);
}
.btn-sec:hover {
  border-color: var(--bd-accent);
  color: var(--ac);
  background: var(--ac-dim);
}
.btn-sec i { font-size: 14px; }

.btn-pri {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  padding: 11px 22px;
  background: var(--ac);
  color: #fff;
  font-family: var(--font-ui);
  font-size: 13px;
  font-weight: 800;
  border: none;
  border-radius: var(--r-sm);
  cursor: pointer;
  box-shadow: 0 8px 22px rgba(14,116,144,.22);
  transition: background var(--t-base) var(--ease), box-shadow var(--t-base) var(--ease), transform var(--t-fast) var(--ease);
}
.btn-pri:hover {
  background: var(--ac-lt);
  box-shadow: 0 12px 28px rgba(6,182,212,.3);
  transform: translateY(-2px);
}
.btn-pri i { font-size: 15px; }

.btn-danger {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 9px 15px;
  background: var(--red-d);
  color: var(--red);
  font-family: var(--font-ui);
  font-size: 12.5px;
  font-weight: 700;
  border: 1px solid rgba(185,28,28,.2);
  border-radius: var(--r-sm);
  cursor: pointer;
  white-space: nowrap;
  transition: all var(--t-fast) var(--ease);
}
.btn-danger:hover {
  background: rgba(185,28,28,.14);
  border-color: var(--red);
}
.btn-danger i { font-size: 14px; }

/* ═══════════════════════════════════════
   LAYOUT GRID
═══════════════════════════════════════ */
.prf-grid {
  display: grid;
  grid-template-columns: 240px 1fr;
  gap: 16px;
  align-items: start;
}
@media (max-width: 640px) {
  .prf-grid { grid-template-columns: 1fr; }
}

/* ═══════════════════════════════════════
   CARD BASE
═══════════════════════════════════════ */
.card {
  background: var(--bg-surface);
  border: 1px solid var(--bd-subtle);
  border-radius: var(--r-lg);
  overflow: hidden;
}

/* ═══════════════════════════════════════
   AVATAR CARD
═══════════════════════════════════════ */
.ava-card {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 30px 20px 22px;
  gap: 14px;
}

.foto-preview-wrap {
  position: relative;
  width: 100px;
  height: 100px;
}
.ava-img {
  width: 100px;
  height: 100px;
  border-radius: 50%;
  object-fit: cover;
  border: 3px solid var(--ac-dim);
  display: block;
}
.ava-initials {
  width: 100px;
  height: 100px;
  border-radius: 50%;
  background: var(--ac-dim);
  border: 3px solid var(--ac-dim);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 30px;
  font-weight: 800;
  color: var(--ac);
  text-transform: uppercase;
  letter-spacing: -0.02em;
  user-select: none;
}

.ava-upload-btn {
  position: absolute;
  bottom: 2px;
  right: 2px;
  width: 30px;
  height: 30px;
  border-radius: 50%;
  background: var(--ac);
  border: 2px solid var(--bg-surface);
  color: #fff;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all var(--t-fast) var(--ease);
}
.ava-upload-btn:hover {
  background: var(--ac-lt);
  transform: scale(1.06);
}
.ava-upload-btn i { font-size: 14px; }

.foto-remove-btn {
  display: none;
  position: absolute;
  top: -3px; left: -3px;
  width: 22px; height: 22px;
  border-radius: 50%;
  background: var(--red);
  border: 2px solid var(--bg-surface);
  color: #fff;
  align-items: center; justify-content: center;
  cursor: pointer;
  font-size: 12px; line-height: 1;
  font-weight: 700;
  z-index: 2;
}
.foto-remove-btn.is-visible { display: flex; }

.ava-name {
  font-size: 15px;
  font-weight: 800;
  color: var(--tx-primary);
  letter-spacing: -0.02em;
  text-align: center;
}
.ava-role {
  font-size: 10.5px;
  font-weight: 700;
  letter-spacing: 0.1em;
  text-transform: uppercase;
  color: var(--ac);
  background: var(--ac-dim);
  border: 1px solid var(--bd-accent);
  border-radius: var(--r-xs);
  padding: 3px 11px;
}

.ava-meta {
  width: 100%;
  display: flex;
  flex-direction: column;
  gap: 9px;
  border-top: 1px solid var(--bd-subtle);
  padding-top: 15px;
  margin-top: 2px;
}
.ava-meta-row {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 11.5px;
  color: var(--tx-muted);
}
.ava-meta-row i { font-size: 14px; flex-shrink: 0; color: var(--tx-muted); }
.ava-meta-row span { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

/* ═══════════════════════════════════════
   FORM CARD
═══════════════════════════════════════ */
.form-section {
  padding: 20px 22px;
  border-bottom: 1px solid var(--bd-subtle);
}
.form-section:last-child { border-bottom: none; }

.section-title {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 10.5px;
  font-weight: 700;
  letter-spacing: 0.12em;
  text-transform: uppercase;
  color: var(--tx-muted);
  margin-bottom: 18px;
}
.section-title i { font-size: 15px; color: var(--ac); }

/* ── Fields ── */
.form-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 14px;
  margin-bottom: 14px;
}
.form-row--single { grid-template-columns: 1fr; }
@media (max-width: 520px) {
  .form-row { grid-template-columns: 1fr; }
}

.field label {
  display: block;
  font-size: 11.5px;
  font-weight: 700;
  color: var(--tx-secondary);
  letter-spacing: 0.01em;
  margin-bottom: 6px;
}
.field label .req { color: var(--red); margin-left: 2px; }

.field input,
.field textarea {
  width: 100%;
  font-family: var(--font-ui);
  font-size: 13px;
  color: var(--tx-primary);
  background: #fbfcfe;
  border: 1.5px solid var(--bd-subtle);
  border-radius: var(--r-sm);
  padding: 11px 14px;
  outline: none;
  transition: border var(--t-fast) var(--ease), box-shadow var(--t-fast) var(--ease), background var(--t-fast) var(--ease);
  -webkit-appearance: none;
}
.field input:focus,
.field textarea:focus {
  border-color: var(--ac-lt);
  box-shadow: 0 0 0 3px rgba(6,182,212,.12);
  background: #fff;
}
.field input::placeholder,
.field textarea::placeholder { color: var(--tx-muted); }
.field input[readonly] { color: var(--tx-muted); cursor: not-allowed; }

.field__hint {
  font-size: 11px;
  color: var(--tx-muted);
  margin-top: 5px;
  line-height: 1.5;
}

/* ── Password strength ── */
.pw-strength { margin-top: 8px; display: none; }
.pw-strength.is-visible { display: block; }
.pw-strength__bar {
  height: 4px;
  background: var(--bg-overlay);
  border-radius: 99px;
  overflow: hidden;
  margin-bottom: 5px;
}
.pw-strength__fill {
  height: 100%;
  border-radius: 99px;
  transition: width var(--t-base) var(--ease), background var(--t-base) var(--ease);
  width: 0%;
}
.pw-strength__label { font-size: 10.5px; font-weight: 700; }
.pw-strength--weak   .pw-strength__fill { width: 25%; background: var(--red); }
.pw-strength--weak   .pw-strength__label { color: var(--red); }
.pw-strength--fair   .pw-strength__fill { width: 50%; background: var(--amber); }
.pw-strength--fair   .pw-strength__label { color: var(--amber); }
.pw-strength--good   .pw-strength__fill { width: 75%; background: var(--ac); }
.pw-strength--good   .pw-strength__label { color: var(--ac); }
.pw-strength--strong .pw-strength__fill { width: 100%; background: var(--green); }
.pw-strength--strong .pw-strength__label { color: var(--green); }

/* ── Input with toggle ── */
.input-wrap { position: relative; }
.input-wrap input { padding-right: 42px; }
.input-wrap__toggle {
  position: absolute;
  right: 11px;
  top: 50%;
  transform: translateY(-50%);
  background: none;
  border: none;
  cursor: pointer;
  color: var(--tx-muted);
  display: flex;
  padding: 0;
  transition: color var(--t-fast) var(--ease);
}
.input-wrap__toggle:hover { color: var(--ac); }
.input-wrap__toggle i { font-size: 16px; }

#foto-input { display: none; }

/* ── Foto profil chooser ── */
.foto-choose-btn {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  padding: 9px 15px;
  background: var(--bg-elevated);
  color: var(--tx-secondary);
  font-family: var(--font-ui);
  font-size: 12.5px;
  font-weight: 700;
  border: 1.5px solid var(--bd-subtle);
  border-radius: var(--r-sm);
  cursor: pointer;
  transition: all var(--t-fast) var(--ease);
}
.foto-choose-btn:hover {
  border-color: var(--bd-accent);
  color: var(--ac);
  background: var(--ac-dim);
}
.foto-choose-btn i { font-size: 15px; }

/* ── Form actions ── */
.form-actions {
  display: flex;
  align-items: center;
  justify-content: flex-end;
  gap: 10px;
  padding: 18px 22px;
  border-top: 1px solid var(--bd-subtle);
  background: var(--bg-elevated);
}

/* ── Danger zone ── */
.danger-zone {
  margin-top: 20px;
  background: var(--bg-surface);
  border: 1px solid rgba(185,28,28,.18);
  border-radius: var(--r-lg);
  overflow: hidden;
}
.danger-zone__head {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 14px 22px;
  border-bottom: 1px solid rgba(185,28,28,.12);
  font-size: 10.5px;
  font-weight: 700;
  letter-spacing: 0.12em;
  text-transform: uppercase;
  color: var(--red);
}
.danger-zone__head i { font-size: 15px; }
.danger-zone__body {
  padding: 18px 22px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 16px;
  flex-wrap: wrap;
}
.danger-zone__desc {
  font-size: 12.5px;
  color: var(--tx-muted);
  line-height: 1.6;
  flex: 1;
}
.danger-zone__desc strong { color: var(--tx-secondary); }

/* ═══════════════════════════════════════
   TOAST
═══════════════════════════════════════ */
.toast {
  position: fixed;
  bottom: 24px;
  right: 24px;
  z-index: 9998;
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 13px 17px;
  background: var(--bg-surface);
  border: 1px solid var(--bd-subtle);
  border-radius: var(--r-sm);
  font-size: 12.5px;
  font-weight: 700;
  color: var(--tx-primary);
  box-shadow: 0 20px 45px -14px rgba(15,23,42,.28), 0 4px 16px rgba(15,23,42,.08);
  opacity: 0;
  transform: translateY(8px);
  transition: opacity var(--t-base) var(--ease), transform var(--t-base) var(--ease);
  pointer-events: none;
  max-width: 320px;
}
.toast.is-visible { opacity: 1; transform: translateY(0); }
.toast__dot { width: 7px; height: 7px; border-radius: 50%; flex-shrink: 0; }
.toast--ok  .toast__dot { background: var(--green); }
.toast--err .toast__dot { background: var(--red); }

/* ═══════════════════════════════════════
   CONFIRM OVERLAY
═══════════════════════════════════════ */
.confirm-overlay {
  display: none;
  position: fixed;
  inset: 0;
  background: rgba(15,23,42,.55);
  backdrop-filter: blur(4px);
  z-index: 9999;
  align-items: center;
  justify-content: center;
}
.confirm-overlay.is-open { display: flex; }
.confirm-box {
  background: var(--bg-surface);
  border: 1px solid var(--bd-subtle);
  border-radius: var(--r-lg);
  padding: 28px;
  max-width: 360px;
  width: 90%;
  box-shadow: 0 30px 70px -20px rgba(15,23,42,.35), 0 4px 18px rgba(15,23,42,.08);
  animation: pop-in 300ms var(--ease) both;
}
@keyframes pop-in {
  from { transform: scale(.94) translateY(10px); opacity: 0; }
  to   { transform: scale(1)   translateY(0);    opacity: 1; }
}
.confirm-box__ico {
  width: 44px; height: 44px;
  border-radius: var(--r-md);
  background: var(--red-d);
  display: flex; align-items: center; justify-content: center;
  color: var(--red);
  margin-bottom: 16px;
}
.confirm-box__ico i { font-size: 20px; }
.confirm-box__title {
  font-size: 15.5px; font-weight: 800;
  color: var(--tx-primary);
  margin-bottom: 6px;
  letter-spacing: -0.02em;
}
.confirm-box__sub {
  font-size: 12.5px; color: var(--tx-muted);
  line-height: 1.6; margin-bottom: 20px;
}
.confirm-box__acts { display: flex; gap: 8px; justify-content: flex-end; }

@media (max-width: 480px) {
  .form-actions { flex-direction: column-reverse; }
  .btn-sec, .btn-pri { width: 100%; justify-content: center; }
}
</style>

<div class="prf">

  <!-- Page Header -->
  <div class="ph">
    <div>
      <div class="ph__eyebrow">Sistem</div>
      <h1 class="ph__title">Edit Profil Admin</h1>
      <p class="ph__sub">Kelola informasi akun dan keamanan login administrator.</p>
    </div>
    <a href="<?= BASE_URL ?>/admin/dashboard" class="btn-sec" style="align-self:flex-start;margin-top:4px;">
      <i class="ti ti-arrow-left" aria-hidden="true"></i>
      Dashboard
    </a>
  </div>

  <!-- Grid Layout -->
  <div class="prf-grid">

    <!-- ── Kolom kiri: avatar card ── -->
    <div class="card ava-card">

      <!-- Avatar -->
      <div class="foto-preview-wrap">
        <?php
          $fotoUrl  = !empty($admin['foto']) ? UPLOAD_URL . '/' . htmlspecialchars($admin['foto']) : null;
          $initials = mb_strtoupper(mb_substr($admin['nama_lengkap'] ?? 'A', 0, 2));
        ?>
        <div id="ava-container">
          <?php if ($fotoUrl): ?>
            <img id="ava-img" class="ava-img" src="<?= $fotoUrl ?>" alt="Foto Admin">
          <?php else: ?>
            <div id="ava-img" class="ava-initials"><?= $initials ?></div>
          <?php endif; ?>
        </div>
        <button type="button" class="ava-upload-btn" id="ava-upload-btn" title="Ganti foto" onclick="document.getElementById('foto-input').click()">
          <i class="ti ti-camera" aria-hidden="true"></i>
        </button>
        <button type="button" class="foto-remove-btn" id="foto-remove-btn" title="Hapus foto baru" aria-label="Hapus preview foto">×</button>
      </div>

      <div class="ava-name" id="display-name"><?= htmlspecialchars($admin['nama_lengkap'] ?? 'Administrator') ?></div>
      <div class="ava-role">Administrator</div>

      <div class="ava-meta">
        <div class="ava-meta-row">
          <i class="ti ti-mail" aria-hidden="true"></i>
          <span id="display-email"><?= htmlspecialchars($admin['email'] ?? '—') ?></span>
        </div>
        <div class="ava-meta-row">
          <i class="ti ti-phone" aria-hidden="true"></i>
          <span id="display-nohp"><?= !empty($admin['no_hp']) ? htmlspecialchars($admin['no_hp']) : '—' ?></span>
        </div>
        <div class="ava-meta-row">
          <i class="ti ti-clock" aria-hidden="true"></i>
          <span>Bergabung <?= !empty($admin['created_at']) ? date('M Y', strtotime($admin['created_at'])) : '—' ?></span>
        </div>
        <div class="ava-meta-row">
          <i class="ti ti-shield-check" aria-hidden="true" style="color:var(--green);"></i>
          <span style="color:var(--green);font-weight:600;">Status Aktif</span>
        </div>
      </div>

    </div><!-- /.ava-card -->

    <!-- ── Kolom kanan: form card ── -->
    <div>
      <form
        method="POST"
        action="<?= BASE_URL ?>/admin/profil/simpan"
        enctype="multipart/form-data"
        id="profil-form"
        novalidate
      >
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
        <input type="file" name="foto" id="foto-input" accept="image/jpeg,image/png,image/webp" aria-label="Upload foto profil">

        <div class="card">

          <!-- ── Seksi: Informasi Dasar ── -->
          <div class="form-section">
            <div class="section-title">
              <i class="ti ti-user" aria-hidden="true"></i>
              Informasi Dasar
            </div>

            <div class="form-row">
              <div class="field">
                <label for="nama_lengkap">Nama Lengkap <span class="req">*</span></label>
                <input
                  type="text"
                  id="nama_lengkap"
                  name="nama_lengkap"
                  value="<?= htmlspecialchars($admin['nama_lengkap'] ?? '') ?>"
                  placeholder="Nama administrator"
                  required
                  autocomplete="name"
                >
              </div>
              <div class="field">
                <label for="email">Email <span class="req">*</span></label>
                <input
                  type="email"
                  id="email"
                  name="email"
                  value="<?= htmlspecialchars($admin['email'] ?? '') ?>"
                  placeholder="admin@example.com"
                  required
                  autocomplete="email"
                >
              </div>
            </div>

            <div class="form-row form-row--single">
              <div class="field">
                <label for="no_hp">No HP</label>
                <input
                  type="text"
                  id="no_hp"
                  name="no_hp"
                  value="<?= htmlspecialchars($admin['no_hp'] ?? '') ?>"
                  placeholder="08xxxxxxxxxx"
                  autocomplete="tel"
                  inputmode="numeric"
                >
                <div class="field__hint">Opsional — tidak ditampilkan ke publik.</div>
              </div>
            </div>

          </div><!-- /.form-section -->

          <!-- ── Seksi: Foto Profil ── -->
          <div class="form-section">
            <div class="section-title">
              <i class="ti ti-photo" aria-hidden="true"></i>
              Foto Profil
            </div>

            <div style="display:flex;align-items:center;gap:16px;flex-wrap:wrap;">
              <button type="button" class="foto-choose-btn" onclick="document.getElementById('foto-input').click()">
                <i class="ti ti-upload" aria-hidden="true"></i>
                Pilih Foto Baru
              </button>
              <span class="field__hint" id="foto-filename">Belum ada file dipilih &mdash; JPG, PNG, WebP maks. 2 MB.</span>
            </div>

            <?php if (!empty($admin['foto'])): ?>
            <div style="margin-top:14px;">
              <label style="display:flex;align-items:center;gap:8px;font-size:12px;color:var(--tx-muted);cursor:pointer;">
                <input type="checkbox" name="hapus_foto" value="1" id="hapus-foto-cb" style="accent-color:var(--red);width:15px;height:15px;">
                <span>Hapus foto saat ini (gunakan inisial nama)</span>
              </label>
            </div>
            <?php endif; ?>

          </div><!-- /.form-section -->

          <!-- ── Seksi: Keamanan ── -->
          <div class="form-section">
            <div class="section-title">
              <i class="ti ti-lock" aria-hidden="true"></i>
              Ubah Password
            </div>

            <div class="form-row form-row--single" style="margin-bottom:14px;">
              <div class="field">
                <label for="password_lama">Password Saat Ini</label>
                <div class="input-wrap">
                  <input
                    type="password"
                    id="password_lama"
                    name="password_lama"
                    placeholder="Masukkan password saat ini"
                    autocomplete="current-password"
                  >
                  <button type="button" class="input-wrap__toggle" data-target="password_lama" aria-label="Tampilkan/sembunyikan password">
                    <i class="ti ti-eye" aria-hidden="true"></i>
                  </button>
                </div>
                <div class="field__hint">Wajib diisi jika ingin mengganti password.</div>
              </div>
            </div>

            <div class="form-row">
              <div class="field">
                <label for="password_baru">Password Baru</label>
                <div class="input-wrap">
                  <input
                    type="password"
                    id="password_baru"
                    name="password_baru"
                    placeholder="Min. 8 karakter"
                    autocomplete="new-password"
                  >
                  <button type="button" class="input-wrap__toggle" data-target="password_baru" aria-label="Tampilkan/sembunyikan password baru">
                    <i class="ti ti-eye" aria-hidden="true"></i>
                  </button>
                </div>
                <div class="pw-strength" id="pw-strength">
                  <div class="pw-strength__bar"><div class="pw-strength__fill" id="pw-fill"></div></div>
                  <span class="pw-strength__label" id="pw-label"></span>
                </div>
              </div>
              <div class="field">
                <label for="password_konfirmasi">Konfirmasi Password Baru</label>
                <div class="input-wrap">
                  <input
                    type="password"
                    id="password_konfirmasi"
                    name="password_konfirmasi"
                    placeholder="Ulangi password baru"
                    autocomplete="new-password"
                  >
                  <button type="button" class="input-wrap__toggle" data-target="password_konfirmasi" aria-label="Tampilkan/sembunyikan konfirmasi password">
                    <i class="ti ti-eye" aria-hidden="true"></i>
                  </button>
                </div>
                <div class="field__hint" id="pw-match-hint"></div>
              </div>
            </div>

            <div class="field__hint" style="margin-top:4px;">
              Kosongkan semua field password jika tidak ingin menggantinya.
            </div>

          </div><!-- /.form-section -->

          <!-- ── Form Actions ── -->
          <div class="form-actions">
            <a href="<?= BASE_URL ?>/admin/dashboard" class="btn-sec">Batal</a>
            <button type="submit" class="btn-pri" id="submit-btn">
              <i class="ti ti-check" aria-hidden="true"></i>
              Simpan Perubahan
            </button>
          </div>

        </div><!-- /.card -->
      </form>

      <!-- ── Danger Zone: Logout Semua Sesi ── -->
      <div class="danger-zone">
        <div class="danger-zone__head">
          <i class="ti ti-alert-triangle" aria-hidden="true"></i>
          Zona Berbahaya
        </div>
        <div class="danger-zone__body">
          <div class="danger-zone__desc">
            <strong>Keluar dari semua sesi aktif.</strong><br>
            Kamu akan logout dan semua sesi browser lain akan dihentikan. Gunakan hanya jika akun kamu mungkin diakses orang lain.
          </div>
          <button type="button" class="btn-danger" id="logout-all-btn">
            <i class="ti ti-logout" aria-hidden="true"></i>
            Logout Semua Sesi
          </button>
        </div>
      </div>

    </div><!-- /right col -->

  </div><!-- /.prf-grid -->

</div><!-- /.prf -->

<!-- ── Toast ── -->
<div class="toast" id="toast" role="alert" aria-live="polite">
  <span class="toast__dot"></span>
  <span id="toast-msg"></span>
</div>

<!-- ── Confirm Dialog: Logout Semua Sesi ── -->
<div class="confirm-overlay" id="logout-overlay" role="dialog" aria-modal="true" aria-labelledby="logout-dialog-title">
  <div class="confirm-box">
    <div class="confirm-box__ico">
      <i class="ti ti-logout" aria-hidden="true"></i>
    </div>
    <div class="confirm-box__title" id="logout-dialog-title">Logout Semua Sesi?</div>
    <div class="confirm-box__sub">
      Kamu akan keluar dari semua perangkat yang sedang login. Kamu perlu login ulang setelah ini.
    </div>
    <div class="confirm-box__acts">
      <button type="button" class="btn-sec" id="logout-cancel">Batal</button>
      <form method="POST" action="<?= BASE_URL ?>/admin/profil/logout-all" style="margin:0;padding:0;">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
        <button type="submit" class="btn-pri" style="background:var(--red);box-shadow:0 8px 22px rgba(185,28,28,.22);">
          Ya, Logout Semua
        </button>
      </form>
    </div>
  </div>
</div>

<script>
(function () {
  'use strict';

  /* ══════════════════════════════════
     FOTO PREVIEW
  ══════════════════════════════════ */
  var fotoInput     = document.getElementById('foto-input');
  var avaContainer  = document.getElementById('ava-container');
  var removeBtn     = document.getElementById('foto-remove-btn');
  var fotoFilename  = document.getElementById('foto-filename');
  var hapusCb       = document.getElementById('hapus-foto-cb');

  var originalAvaSrc = avaContainer ? avaContainer.innerHTML : '';

  if (fotoInput) {
    fotoInput.addEventListener('change', function () {
      var file = fotoInput.files[0];
      if (!file) return;

      if (file.size > 2 * 1024 * 1024) {
        showToast('Ukuran foto maksimal 2 MB.', 'err');
        fotoInput.value = '';
        return;
      }

      var reader = new FileReader();
      reader.onload = function (e) {
        avaContainer.innerHTML = '<img id="ava-img" class="ava-img" src="' + e.target.result + '" alt="Preview foto">';
        removeBtn.classList.add('is-visible');
        fotoFilename.textContent = file.name;
        if (hapusCb) hapusCb.checked = false;
      };
      reader.readAsDataURL(file);
    });
  }

  if (removeBtn) {
    removeBtn.addEventListener('click', function () {
      fotoInput.value = '';
      avaContainer.innerHTML = originalAvaSrc;
      removeBtn.classList.remove('is-visible');
      fotoFilename.textContent = 'Belum ada file dipilih \u2014 JPG, PNG, WebP maks. 2 MB.';
    });
  }

  /* ══════════════════════════════════
     LIVE NAME & META DISPLAY
  ══════════════════════════════════ */
  var namaInput    = document.getElementById('nama_lengkap');
  var emailInput   = document.getElementById('email');
  var noHpInput    = document.getElementById('no_hp');
  var displayName  = document.getElementById('display-name');
  var displayEmail = document.getElementById('display-email');
  var displayNohp  = document.getElementById('display-nohp');

  if (namaInput && displayName) {
    namaInput.addEventListener('input', function () {
      displayName.textContent = namaInput.value.trim() || 'Administrator';
    });
  }
  if (emailInput && displayEmail) {
    emailInput.addEventListener('input', function () {
      displayEmail.textContent = emailInput.value.trim() || '—';
    });
  }
  if (noHpInput && displayNohp) {
    noHpInput.addEventListener('input', function () {
      displayNohp.textContent = noHpInput.value.trim() || '—';
    });
  }

  /* ══════════════════════════════════
     PASSWORD TOGGLE VISIBILITY
  ══════════════════════════════════ */
  document.querySelectorAll('.input-wrap__toggle').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var target = document.getElementById(btn.dataset.target);
      if (!target) return;
      target.type = target.type === 'password' ? 'text' : 'password';
    });
  });

  /* ══════════════════════════════════
     PASSWORD STRENGTH
  ══════════════════════════════════ */
  var pwBaru     = document.getElementById('password_baru');
  var pwStrength = document.getElementById('pw-strength');
  var pwLabel    = document.getElementById('pw-label');

  function calcStrength(pw) {
    var score = 0;
    if (pw.length >= 8)  score++;
    if (pw.length >= 12) score++;
    if (/[A-Z]/.test(pw) && /[a-z]/.test(pw)) score++;
    if (/[0-9]/.test(pw)) score++;
    if (/[^A-Za-z0-9]/.test(pw)) score++;
    return score;
  }

  var levels = [
    { cls: 'pw-strength--weak',   label: 'Lemah' },
    { cls: 'pw-strength--weak',   label: 'Lemah' },
    { cls: 'pw-strength--fair',   label: 'Cukup' },
    { cls: 'pw-strength--good',   label: 'Kuat' },
    { cls: 'pw-strength--strong', label: 'Sangat Kuat' },
    { cls: 'pw-strength--strong', label: 'Sangat Kuat' },
  ];

  if (pwBaru) {
    pwBaru.addEventListener('input', function () {
      var val = pwBaru.value;
      if (!val) {
        pwStrength.className = 'pw-strength';
        return;
      }
      var s  = calcStrength(val);
      var lv = levels[Math.min(s, levels.length - 1)];
      pwStrength.className = 'pw-strength is-visible ' + lv.cls;
      pwLabel.textContent  = lv.label;
    });
  }

  /* ══════════════════════════════════
     PASSWORD MATCH HINT
  ══════════════════════════════════ */
  var pwKonfirmasi = document.getElementById('password_konfirmasi');
  var pwMatchHint  = document.getElementById('pw-match-hint');

  function checkMatch() {
    if (!pwBaru || !pwKonfirmasi || !pwKonfirmasi.value) {
      pwMatchHint.textContent = '';
      pwKonfirmasi.style.borderColor = '';
      return;
    }
    if (pwBaru.value === pwKonfirmasi.value) {
      pwMatchHint.textContent         = '✓ Password cocok';
      pwMatchHint.style.color         = 'var(--green)';
      pwKonfirmasi.style.borderColor  = 'rgba(21,128,61,0.4)';
    } else {
      pwMatchHint.textContent         = '✗ Password tidak cocok';
      pwMatchHint.style.color         = 'var(--red)';
      pwKonfirmasi.style.borderColor  = 'rgba(185,28,28,0.4)';
    }
  }

  if (pwBaru)       pwBaru.addEventListener('input', checkMatch);
  if (pwKonfirmasi) pwKonfirmasi.addEventListener('input', checkMatch);

  /* ══════════════════════════════════
     CLIENT-SIDE VALIDATION
  ══════════════════════════════════ */
  var form = document.getElementById('profil-form');

  if (form) {
    form.addEventListener('submit', function (e) {
      var nama = document.getElementById('nama_lengkap').value.trim();
      var eml  = document.getElementById('email').value.trim();
      var lama = document.getElementById('password_lama').value;
      var baru = document.getElementById('password_baru').value;
      var konf = document.getElementById('password_konfirmasi').value;

      if (nama.length < 3) {
        e.preventDefault();
        showToast('Nama minimal 3 karakter.', 'err');
        document.getElementById('nama_lengkap').focus();
        return;
      }
      if (!eml || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(eml)) {
        e.preventDefault();
        showToast('Email tidak valid.', 'err');
        document.getElementById('email').focus();
        return;
      }
      if (baru || konf) {
        if (!lama) {
          e.preventDefault();
          showToast('Isi password saat ini untuk mengganti password.', 'err');
          document.getElementById('password_lama').focus();
          return;
        }
        if (baru.length < 8) {
          e.preventDefault();
          showToast('Password baru minimal 8 karakter.', 'err');
          document.getElementById('password_baru').focus();
          return;
        }
        if (baru !== konf) {
          e.preventDefault();
          showToast('Konfirmasi password tidak cocok.', 'err');
          document.getElementById('password_konfirmasi').focus();
          return;
        }
      }
    });
  }

  /* ══════════════════════════════════
     TOAST
  ══════════════════════════════════ */
  var toastEl  = document.getElementById('toast');
  var toastMsg = document.getElementById('toast-msg');
  var toastTimer;

  function showToast(msg, type) {
    toastEl.className = 'toast toast--' + (type || 'ok');
    toastMsg.textContent = msg;
    toastEl.classList.add('is-visible');
    clearTimeout(toastTimer);
    toastTimer = setTimeout(function () {
      toastEl.classList.remove('is-visible');
    }, 3500);
  }

  /* ══════════════════════════════════
     LOGOUT ALL DIALOG
  ══════════════════════════════════ */
  var logoutOverlay = document.getElementById('logout-overlay');
  var logoutAllBtn  = document.getElementById('logout-all-btn');
  var logoutCancel  = document.getElementById('logout-cancel');

  if (logoutAllBtn) {
    logoutAllBtn.addEventListener('click', function () {
      logoutOverlay.classList.add('is-open');
      document.body.style.overflow = 'hidden';
    });
  }
  function closeLogout() {
    logoutOverlay.classList.remove('is-open');
    document.body.style.overflow = '';
  }
  if (logoutCancel)  logoutCancel.addEventListener('click', closeLogout);
  if (logoutOverlay) {
    logoutOverlay.addEventListener('click', function (e) {
      if (e.target === logoutOverlay) closeLogout();
    });
  }
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeLogout();
  });

  /* ══════════════════════════════════
     AUTO-SHOW FLASH VIA TOAST
  ══════════════════════════════════ */
  <?php if (!empty($flash)): ?>
  showToast(<?= json_encode(strip_tags($flash['msg'] ?? '')) ?>, '<?= ($flash['type'] ?? 'info') === 'success' ? 'ok' : 'err' ?>');
  <?php endif; ?>

}());
</script>