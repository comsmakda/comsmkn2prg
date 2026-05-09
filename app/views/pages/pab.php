<?php // app/views/pages/pab.php ?>

<?php
/* ── Open Graph meta tags (inject ke <head> via layout) ── */
$og_title       = "Daftar Sekarang! PAB " . ($settings['org_name']['value'] ?? APP_NAME) . " — Komunitas Programmer SMKN 2 Pinrang";
$og_description = "Bergabunglah bersama komunitas programmer SMKN 2 Pinrang! Daftarkan diri kamu sekarang dan jadilah bagian dari generasi teknologi berikutnya. 💻🚀";
$og_url         = BASE_URL . "/pab";
$og_image       = BASE_URL . "/assets/img/logo-com.png";

/* Inject ke <head> jika layout mendukung $extra_head atau ob_start */
if (!isset($extra_head)) $extra_head = '';
$extra_head .= '
<meta property="og:type"         content="website">
<meta property="og:url"          content="' . htmlspecialchars($og_url) . '">
<meta property="og:title"        content="' . htmlspecialchars($og_title) . '">
<meta property="og:description"  content="' . htmlspecialchars($og_description) . '">
<meta property="og:image"        content="' . htmlspecialchars($og_image) . '">
<meta property="og:image:width"  content="1200">
<meta property="og:image:height" content="630">
<meta property="og:locale"       content="id_ID">
<meta property="og:site_name"    content="' . htmlspecialchars($settings['org_name']['value'] ?? APP_NAME) . '">
<meta name="twitter:card"        content="summary_large_image">
<meta name="twitter:title"       content="' . htmlspecialchars($og_title) . '">
<meta name="twitter:description" content="' . htmlspecialchars($og_description) . '">
<meta name="twitter:image"       content="' . htmlspecialchars($og_image) . '">
<meta name="description"         content="' . htmlspecialchars($og_description) . '">
';
?>

<style>
/* ═══════════════════════════════════════════
   PAB PAGE
═══════════════════════════════════════════ */
.pab-wrap {
  min-height: calc(100svh - 68px);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 4rem 1.25rem 5rem;
  position: relative;
  overflow: hidden;
}

/* Subtle background decoration */
.pab-wrap::before {
  content: '';
  position: fixed;
  inset: 0;
  pointer-events: none;
  background:
    radial-gradient(ellipse 55% 45% at 75% 10%, rgba(14,165,233,.07) 0%, transparent 65%),
    radial-gradient(ellipse 40% 40% at 10% 85%, rgba(99,102,241,.06) 0%, transparent 60%);
  z-index: 0;
}
.pab-wrap::after {
  content: '';
  position: fixed;
  inset: 0;
  pointer-events: none;
  background-image:
    linear-gradient(rgba(14,165,233,.025) 1px, transparent 1px),
    linear-gradient(90deg, rgba(14,165,233,.025) 1px, transparent 1px);
  background-size: 64px 64px;
  mask-image: radial-gradient(ellipse 80% 80% at 50% 40%, black 0%, transparent 75%);
  z-index: 0;
}

.pab-container {
  position: relative;
  z-index: 1;
  width: 100%;
  max-width: 520px;
}

/* ── Header ── */
.pab-header {
  text-align: center;
  margin-bottom: 2rem;
}

/* ── Logo ── */
.pab-logo-wrap {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-bottom: 1.25rem;
}
.pab-logo {
  height: 88px;
  width: auto;
  object-fit: contain;
  filter: drop-shadow(0 0 20px rgba(14,165,233,.3)) drop-shadow(0 4px 12px rgba(0,0,0,.4));
  animation: logo-float 4s ease-in-out infinite;
}
@keyframes logo-float {
  0%, 100% { transform: translateY(0px); }
  50%       { transform: translateY(-5px); }
}

/* ── Tagline ajakan ── */
.pab-tagline {
  font-size: .82rem;
  color: var(--c-muted2);
  line-height: 1.75;
  margin-bottom: .75rem;
  letter-spacing: .01em;
}
.pab-tagline strong {
  color: var(--c-sky);
  font-weight: 600;
}

.pab-badge {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 5px 14px;
  background: rgba(14,165,233,.08);
  border: 1px solid rgba(14,165,233,.22);
  border-radius: 99px;
  font-family: var(--font-mono);
  font-size: .67rem;
  color: var(--c-sky);
  letter-spacing: .07em;
  text-transform: uppercase;
  margin-bottom: 1rem;
}
.pab-badge-pulse {
  width: 6px; height: 6px;
  border-radius: 50%;
  background: var(--c-cyan);
  animation: pulse-glow 2s ease-in-out infinite;
  flex-shrink: 0;
}
@keyframes pulse-glow {
  0%, 100% { opacity: 1; box-shadow: 0 0 0 0 rgba(34,211,238,.4); }
  50%       { opacity: .7; box-shadow: 0 0 0 5px rgba(34,211,238,0); }
}
.pab-title {
  font-family: var(--font-display);
  font-size: clamp(1.7rem, 4vw, 2.4rem);
  font-weight: 900;
  color: #fff;
  letter-spacing: -.035em;
  line-height: 1.1;
  margin-bottom: .65rem;
}
.pab-title .t-grad {
  background: linear-gradient(130deg, var(--c-sky-light) 0%, var(--c-indigo) 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}
.pab-info {
  font-size: .87rem;
  color: var(--c-muted2);
  line-height: 1.7;
  margin-bottom: .5rem;
}
.pab-deadline {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  font-family: var(--font-mono);
  font-size: .68rem;
  color: #fbbf24;
  background: rgba(251,191,36,.08);
  border: 1px solid rgba(251,191,36,.2);
  border-radius: 99px;
  padding: 4px 12px;
  margin-top: .25rem;
}

/* ── Alert ── */
.pab-alert {
  border-radius: 12px;
  padding: .9rem 1.1rem;
  font-size: .84rem;
  margin-bottom: 1.25rem;
  border: 1px solid;
  display: flex;
  align-items: flex-start;
  gap: 9px;
}
.pab-alert-icon { flex-shrink: 0; margin-top: 1px; }
.pab-alert.success { background: rgba(34,197,94,.07); border-color: rgba(34,197,94,.25); color: #4ade80; }
.pab-alert.error   { background: rgba(239,68,68,.07);  border-color: rgba(239,68,68,.25);  color: #f87171; }
.pab-alert.info    { background: rgba(14,165,233,.07); border-color: rgba(14,165,233,.22); color: var(--c-sky); }

/* ── Card ── */
.pab-card {
  background: var(--c-surface2);
  border: 1px solid var(--c-border);
  border-radius: 20px;
  overflow: hidden;
  box-shadow: 0 20px 60px rgba(0,0,0,.35);
}
.pab-card-head {
  padding: 1.4rem 1.8rem;
  border-bottom: 1px solid var(--c-border);
  display: flex;
  align-items: center;
  gap: .75rem;
  background: rgba(14,165,233,.03);
}
.pab-card-head-icon {
  width: 36px; height: 36px;
  border-radius: 9px;
  background: rgba(14,165,233,.1);
  display: flex; align-items: center; justify-content: center;
  color: var(--c-sky);
  flex-shrink: 0;
}
.pab-card-head h2 {
  font-family: var(--font-display);
  font-size: .97rem;
  font-weight: 700;
  color: #fff;
}
.pab-card-head span {
  font-family: var(--font-mono);
  font-size: .64rem;
  color: var(--c-muted);
  letter-spacing: .05em;
}
.pab-card-body { padding: 1.8rem; }

/* ── Closed state ── */
.pab-closed {
  text-align: center;
  padding: 3rem 1.8rem;
}
.pab-closed-icon {
  width: 64px; height: 64px;
  background: rgba(239,68,68,.07);
  border: 1px solid rgba(239,68,68,.2);
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  margin: 0 auto 1.25rem;
  color: #f87171;
}
.pab-closed h2 {
  font-family: var(--font-display);
  font-size: 1.2rem;
  font-weight: 700;
  color: #fff;
  margin-bottom: .5rem;
}
.pab-closed p {
  font-size: .84rem;
  color: var(--c-muted2);
  line-height: 1.75;
}

/* ── Form fields ── */
.pab-form { display: flex; flex-direction: column; gap: 1.1rem; }

.pab-field { display: flex; flex-direction: column; gap: .45rem; }
.pab-label {
  font-size: .8rem;
  font-weight: 600;
  color: var(--c-text);
  letter-spacing: -.01em;
}
.pab-label span { color: #f87171; margin-left: 2px; }

.pab-input {
  width: 100%;
  background: var(--c-surface3);
  border: 1px solid var(--c-border);
  border-radius: 10px;
  padding: .7rem .95rem;
  font-size: .88rem;
  color: var(--c-text);
  font-family: var(--font-body, inherit);
  outline: none;
  transition: border-color .2s, box-shadow .2s;
  appearance: none;
}
.pab-input::placeholder { color: var(--c-muted); }
.pab-input:hover  { border-color: var(--c-border2); }
.pab-input:focus  { border-color: var(--c-sky); box-shadow: 0 0 0 3px rgba(14,165,233,.12); }

/* Two-col grid for kelas + no_hp */
.pab-grid-2 {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1rem;
}

/* Password row */
.pab-pass-hint {
  font-family: var(--font-mono);
  font-size: .65rem;
  color: var(--c-muted);
  margin-top: 3px;
  letter-spacing: .02em;
}

/* Divider */
.pab-divider {
  display: flex;
  align-items: center;
  gap: .75rem;
  color: var(--c-muted);
  font-size: .72rem;
  font-family: var(--font-mono);
  letter-spacing: .06em;
  text-transform: uppercase;
  margin: .25rem 0;
}
.pab-divider::before,
.pab-divider::after { content: ''; flex: 1; height: 1px; background: var(--c-border); }

/* ── Dropzone ── */
.pab-dropzone {
  width: 100%;
  border: 1.5px dashed var(--c-border);
  border-radius: 12px;
  background: var(--c-surface3);
  cursor: pointer;
  transition: border-color .2s, background .2s;
  overflow: hidden;
  position: relative;
  min-height: 120px;
  display: flex;
  align-items: center;
  justify-content: center;
}
.pab-dropzone:hover,
.pab-dropzone.drag-over { border-color: var(--c-sky); background: rgba(14,165,233,.04); }
.pab-dropzone-inner {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: .4rem;
  padding: 1.5rem;
  text-align: center;
  pointer-events: none;
}
.pab-dropzone-icon {
  width: 40px; height: 40px;
  border-radius: 10px;
  background: rgba(14,165,233,.09);
  display: flex; align-items: center; justify-content: center;
  color: var(--c-sky);
  margin-bottom: .2rem;
  transition: background .2s;
}
.pab-dropzone:hover .pab-dropzone-icon { background: rgba(14,165,233,.16); }
.pab-dropzone-label {
  font-size: .83rem;
  font-weight: 600;
  color: var(--c-text);
}
.pab-dropzone-sub {
  font-family: var(--font-mono);
  font-size: .64rem;
  color: var(--c-muted);
  letter-spacing: .04em;
}
#pab-preview {
  width: 100%;
  height: 140px;
  object-fit: cover;
  display: none;
}
#pab-preview.show { display: block; }
.pab-preview-reset {
  position: absolute;
  top: 8px; right: 8px;
  width: 28px; height: 28px;
  border-radius: 50%;
  background: rgba(0,0,0,.55);
  border: 1px solid rgba(255,255,255,.15);
  display: none;
  align-items: center; justify-content: center;
  cursor: pointer; color: #fff;
  z-index: 2;
  transition: background .2s;
}
.pab-preview-reset:hover { background: rgba(239,68,68,.6); }
.pab-preview-reset.show { display: flex; }

/* ── Submit button ── */
.pab-submit {
  width: 100%;
  padding: .85rem;
  background: var(--c-sky);
  color: #fff;
  font-family: var(--font-display);
  font-weight: 700;
  font-size: .93rem;
  border: none;
  border-radius: 11px;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  transition: all .25s cubic-bezier(.22,1,.36,1);
  box-shadow: 0 4px 20px rgba(14,165,233,.28);
  letter-spacing: -.01em;
  margin-top: .3rem;
}
.pab-submit:hover {
  background: var(--c-sky-light);
  transform: translateY(-2px);
  box-shadow: 0 8px 32px rgba(14,165,233,.36);
}
.pab-submit:active { transform: translateY(0); }
.pab-submit:disabled { opacity: .55; cursor: not-allowed; transform: none; }

/* ── Footer link ── */
.pab-back {
  text-align: center;
  margin-top: 1.5rem;
}
.pab-back a {
  font-size: .82rem;
  color: var(--c-muted);
  text-decoration: none;
  transition: color .2s;
  display: inline-flex;
  align-items: center;
  gap: 5px;
}
.pab-back a:hover { color: var(--c-text); }

/* Step indicator */
.pab-steps {
  display: flex;
  align-items: center;
  gap: 0;
  margin-bottom: 1.6rem;
}
.pab-step {
  flex: 1;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 5px;
  position: relative;
}
.pab-step::after {
  content: '';
  position: absolute;
  top: 14px;
  left: 50%;
  width: 100%;
  height: 1px;
  background: var(--c-border);
}
.pab-step:last-child::after { display: none; }
.pab-step-dot {
  width: 28px; height: 28px;
  border-radius: 50%;
  background: var(--c-surface3);
  border: 1px solid var(--c-border);
  display: flex; align-items: center; justify-content: center;
  font-family: var(--font-mono);
  font-size: .68rem;
  color: var(--c-muted);
  position: relative;
  z-index: 1;
  transition: all .3s;
}
.pab-step.active .pab-step-dot {
  background: var(--c-sky);
  border-color: var(--c-sky);
  color: #fff;
  box-shadow: 0 0 0 4px rgba(14,165,233,.15);
}
.pab-step.done .pab-step-dot {
  background: rgba(34,197,94,.12);
  border-color: rgba(34,197,94,.4);
  color: #4ade80;
}
.pab-step-label {
  font-family: var(--font-mono);
  font-size: .6rem;
  color: var(--c-muted);
  letter-spacing: .05em;
  text-transform: uppercase;
  white-space: nowrap;
}
.pab-step.active .pab-step-label { color: var(--c-sky); }
.pab-step.done  .pab-step-label  { color: #4ade80; }

/* ── Responsive ── */
@media (max-width: 480px) {
  .pab-wrap { padding: 3rem .85rem 4rem; }
  .pab-card-body { padding: 1.4rem; }
  .pab-card-head { padding: 1.1rem 1.4rem; }
  .pab-grid-2 { grid-template-columns: 1fr; }
  .pab-steps { display: none; }
  .pab-title { font-size: 1.6rem; }
  .pab-logo { height: 68px; }
}

@keyframes spin { to { transform: rotate(360deg); } }
</style>

<div class="pab-wrap">
  <div class="pab-container">

    <!-- ── Header ── -->
    <div class="pab-header">

      <!-- Logo -->
      <div class="pab-logo-wrap">
        <img
          src="<?= BASE_URL ?>/assets/img/logo-com.png"
          alt="Logo <?= htmlspecialchars($settings['org_name']['value'] ?? APP_NAME) ?>"
          class="pab-logo"
          width="88" height="88"
          loading="eager"
          onerror="this.style.display='none'">
      </div>

      <!-- Badge -->
      <div class="pab-badge">
        <span class="pab-badge-pulse"></span>
        Penerimaan Anggota Baru
      </div>

      <!-- Judul -->
      <h1 class="pab-title">
        <?php
          $name  = $settings['org_name']['value'] ?? APP_NAME;
          $parts = explode(' ', $name);
          $last  = array_pop($parts);
          echo htmlspecialchars(implode(' ', $parts));
          echo count($parts) ? ' ' : '';
          echo '<span class="t-grad">' . htmlspecialchars($last) . '</span>';
        ?>
      </h1>

      <!-- Tagline ajakan -->
      <p class="pab-tagline">
        Bergabunglah bersama <strong>Komunitas Programmer SMKN 2 Pinrang</strong>.<br>
        Jadilah bagian dari generasi teknologi berikutnya!
      </p>

      <?php if (!empty($settings['pab_info']['value'])): ?>
        <p class="pab-info"><?= htmlspecialchars($settings['pab_info']['value']) ?></p>
      <?php endif; ?>

      <?php if (!empty($settings['pab_deadline']['value'])): ?>
        <div style="display:flex;justify-content:center">
          <span class="pab-deadline">
            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            Batas: <?= htmlspecialchars($settings['pab_deadline']['value']) ?>
          </span>
        </div>
      <?php endif; ?>
    </div>

    <!-- ── Flash alert ── -->
    <?php if (!empty($flash)): ?>
      <?php
        $alertType = $flash['type'] === 'success' ? 'success' : ($flash['type'] === 'info' ? 'info' : 'error');
        $alertIcon = $alertType === 'success'
          ? '<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>'
          : '<circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>';
      ?>
      <div class="pab-alert <?= $alertType ?>">
        <svg class="pab-alert-icon" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><?= $alertIcon ?></svg>
        <?= $flash['msg'] ?>
      </div>
    <?php endif; ?>

    <!-- ── Card ── -->
    <div class="pab-card">

      <?php if (!$isOpen): ?>
        <!-- Closed state -->
        <div class="pab-closed">
          <div class="pab-closed-icon">
            <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
          </div>
          <h2>Pendaftaran Ditutup</h2>
          <p>Saat ini pendaftaran PAB sedang tidak dibuka.<br>Pantau terus informasi selanjutnya melalui media sosial kami.</p>
          <a href="<?= BASE_URL ?>/" style="display:inline-flex;align-items:center;gap:6px;margin-top:1.5rem;font-size:.83rem;color:var(--c-sky);text-decoration:none;font-weight:600;">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali ke beranda
          </a>
        </div>

      <?php else: ?>
        <!-- Card header -->
        <div class="pab-card-head">
          <div class="pab-card-head-icon">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="21" y1="8" x2="21" y2="14"/><line x1="18" y1="11" x2="24" y2="11"/></svg>
          </div>
          <div>
            <h2>Formulir Pendaftaran</h2>
            <span>Isi data diri dengan lengkap dan benar</span>
          </div>
        </div>

        <!-- Card body -->
        <div class="pab-card-body">

          <!-- Step indicator -->
          <div class="pab-steps" aria-label="Langkah pendaftaran">
            <div class="pab-step active">
              <div class="pab-step-dot">1</div>
              <span class="pab-step-label">Data Diri</span>
            </div>
            <div class="pab-step">
              <div class="pab-step-dot">2</div>
              <span class="pab-step-label">Akun</span>
            </div>
            <div class="pab-step">
              <div class="pab-step-dot">3</div>
              <span class="pab-step-label">Foto</span>
            </div>
          </div>

          <form method="POST" action="<?= BASE_URL ?>/pab/register"
                enctype="multipart/form-data" class="pab-form" id="pab-form">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">

            <!-- Nama -->
            <div class="pab-field">
              <label class="pab-label" for="pab-nama">Nama Lengkap <span>*</span></label>
              <input id="pab-nama" type="text" name="nama_lengkap" required
                     class="pab-input" placeholder="Nama sesuai rapor"
                     autocomplete="name">
            </div>

            <!-- Kelas + No HP -->
            <div class="pab-grid-2">
              <div class="pab-field">
                <label class="pab-label" for="pab-kelas">Kelas <span>*</span></label>
                <input id="pab-kelas" type="text" name="kelas" required
                       class="pab-input" placeholder="XI RPL 1">
              </div>
              <div class="pab-field">
                <label class="pab-label" for="pab-hp">Nomor HP <span>*</span></label>
                <input id="pab-hp" type="tel" name="no_hp" required
                       class="pab-input" placeholder="08xxxxxxxxxx"
                       autocomplete="tel">
              </div>
            </div>

            <!-- Divider -->
            <div class="pab-divider">Akun Portal</div>

            <!-- Password -->
            <div class="pab-field">
              <label class="pab-label" for="pab-pass">Password <span>*</span></label>
              <div style="position:relative">
                <input id="pab-pass" type="password" name="password" required
                       minlength="6" class="pab-input" placeholder="Minimal 6 karakter"
                       autocomplete="new-password" style="padding-right:2.8rem">
                <button type="button" id="toggle-pass"
                        style="position:absolute;right:.75rem;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--c-muted);padding:0;display:flex;align-items:center;"
                        aria-label="Tampilkan password">
                  <svg id="eye-icon" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                </button>
              </div>
              <span class="pab-pass-hint">Minimal 6 karakter — gunakan kombinasi huruf dan angka</span>
            </div>

            <!-- Konfirmasi Password -->
            <div class="pab-field">
              <label class="pab-label" for="pab-pass2">Konfirmasi Password <span>*</span></label>
              <div style="position:relative">
                <input id="pab-pass2" type="password" name="password_confirmation" required
                       class="pab-input" placeholder="Ulangi password"
                       autocomplete="new-password" style="padding-right:2.8rem">
                <span id="pass-match-icon"
                      style="position:absolute;right:.75rem;top:50%;transform:translateY(-50%);display:none;"></span>
              </div>
            </div>

            <!-- Divider -->
            <div class="pab-divider">Pas Foto</div>

            <!-- Dropzone foto -->
            <div class="pab-field">
              <label class="pab-label">Pas Foto <span>*</span></label>
              <div class="pab-dropzone" id="pab-dropzone" role="button" tabindex="0"
                   aria-label="Unggah pas foto">
                <img id="pab-preview" alt="Preview foto">
                <button type="button" class="pab-preview-reset" id="pab-reset-photo"
                        aria-label="Hapus foto">
                  <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
                <div class="pab-dropzone-inner" id="pab-dz-inner">
                  <div class="pab-dropzone-icon">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                  </div>
                  <span class="pab-dropzone-label">Klik atau seret foto ke sini</span>
                  <span class="pab-dropzone-sub">JPG · PNG · WEBP — Maks. 2 MB</span>
                </div>
                <input type="file" name="foto" id="pab-foto"
                       accept="image/jpeg,image/png,image/webp"
                       class="hidden" required style="display:none">
              </div>
            </div>

            <!-- Submit -->
            <button type="submit" class="pab-submit" id="pab-submit">
              <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
              Kirim Pendaftaran
            </button>

          </form>
        </div><!-- .pab-card-body -->
      <?php endif; ?>
    </div><!-- .pab-card -->

    <!-- Back link -->
    <div class="pab-back">
      <a href="<?= BASE_URL ?>/">
        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
        Kembali ke beranda
      </a>
    </div>

  </div><!-- .pab-container -->
</div><!-- .pab-wrap -->

<script>
(function () {
  'use strict';

  /* ── Toggle password visibility ── */
  var passInput  = document.getElementById('pab-pass');
  var toggleBtn  = document.getElementById('toggle-pass');
  var eyeIcon    = document.getElementById('eye-icon');
  if (toggleBtn && passInput) {
    toggleBtn.addEventListener('click', function () {
      var isHidden = passInput.type === 'password';
      passInput.type = isHidden ? 'text' : 'password';
      eyeIcon.innerHTML = isHidden
        ? '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>'
        : '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
    });
  }

  /* ── Password match indicator ── */
  var pass2Input = document.getElementById('pab-pass2');
  var matchIcon  = document.getElementById('pass-match-icon');
  function checkMatch() {
    if (!passInput || !pass2Input || !pass2Input.value) {
      matchIcon.style.display = 'none';
      return;
    }
    var ok = passInput.value === pass2Input.value;
    matchIcon.style.display = 'flex';
    matchIcon.innerHTML = ok
      ? '<svg width="16" height="16" fill="none" stroke="#4ade80" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>'
      : '<svg width="16" height="16" fill="none" stroke="#f87171" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>';
  }
  if (pass2Input) {
    pass2Input.addEventListener('input', checkMatch);
    if (passInput) passInput.addEventListener('input', checkMatch);
  }

  /* ── Dropzone / file upload ── */
  var dropzone  = document.getElementById('pab-dropzone');
  var fileInput = document.getElementById('pab-foto');
  var preview   = document.getElementById('pab-preview');
  var dzInner   = document.getElementById('pab-dz-inner');
  var resetBtn  = document.getElementById('pab-reset-photo');

  function showPreview(file) {
    if (!file || !file.type.startsWith('image/')) return;
    if (file.size > 2 * 1024 * 1024) {
      alert('Ukuran foto maksimal 2 MB.');
      return;
    }
    var reader = new FileReader();
    reader.onload = function (e) {
      preview.src = e.target.result;
      preview.classList.add('show');
      dzInner.style.display = 'none';
      resetBtn.classList.add('show');
    };
    reader.readAsDataURL(file);
  }

  function resetPhoto() {
    preview.src = '';
    preview.classList.remove('show');
    dzInner.style.display = '';
    resetBtn.classList.remove('show');
    fileInput.value = '';
  }

  if (dropzone) {
    dropzone.addEventListener('click', function (e) {
      if (e.target === resetBtn || resetBtn.contains(e.target)) return;
      fileInput.click();
    });
    dropzone.addEventListener('keydown', function (e) {
      if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); fileInput.click(); }
    });
    dropzone.addEventListener('dragover', function (e) {
      e.preventDefault();
      dropzone.classList.add('drag-over');
    });
    dropzone.addEventListener('dragleave', function () {
      dropzone.classList.remove('drag-over');
    });
    dropzone.addEventListener('drop', function (e) {
      e.preventDefault();
      dropzone.classList.remove('drag-over');
      var files = e.dataTransfer.files;
      if (files.length) {
        fileInput.files = files;
        showPreview(files[0]);
      }
    });
  }
  if (fileInput) {
    fileInput.addEventListener('change', function () {
      if (this.files[0]) showPreview(this.files[0]);
    });
  }
  if (resetBtn) {
    resetBtn.addEventListener('click', function (e) {
      e.stopPropagation();
      resetPhoto();
    });
  }

  /* ── Step indicator update on input ── */
  var namaEl  = document.getElementById('pab-nama');
  var kelasEl = document.getElementById('pab-kelas');
  var hpEl    = document.getElementById('pab-hp');
  var steps   = document.querySelectorAll('.pab-step');

  function updateSteps() {
    var step1done = (namaEl && namaEl.value.trim()) && (kelasEl && kelasEl.value.trim()) && (hpEl && hpEl.value.trim());
    var step2done = (passInput && passInput.value.length >= 6) && (pass2Input && passInput.value === pass2Input.value);
    var step3done = preview && preview.classList.contains('show');
    if (steps[0]) { steps[0].className = 'pab-step ' + (step1done ? 'done' : 'active'); steps[0].querySelector('.pab-step-dot').textContent = step1done ? '✓' : '1'; }
    if (steps[1]) { steps[1].className = 'pab-step ' + (step1done && step2done ? 'done' : step1done ? 'active' : ''); steps[1].querySelector('.pab-step-dot').textContent = step2done ? '✓' : '2'; }
    if (steps[2]) { steps[2].className = 'pab-step ' + (step2done && step3done ? 'done' : step2done ? 'active' : ''); steps[2].querySelector('.pab-step-dot').textContent = step3done ? '✓' : '3'; }
  }

  [namaEl, kelasEl, hpEl, passInput, pass2Input].forEach(function (el) {
    if (el) el.addEventListener('input', updateSteps);
  });

  /* ── Submit loading state ── */
  var form      = document.getElementById('pab-form');
  var submitBtn = document.getElementById('pab-submit');
  if (form && submitBtn) {
    form.addEventListener('submit', function () {
      submitBtn.disabled = true;
      submitBtn.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="animation:spin .8s linear infinite"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/></svg> Mengirim...';
    });
  }
})();
</script>