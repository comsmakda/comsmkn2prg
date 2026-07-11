<?php // app/views/pages/pab.php ?>

<?php
$old = $old ?? [];

/* ── Open Graph meta tags (inject ke <head> via layout) ── */
$og_title       = "Daftar Sekarang! PAB " . ($settings['org_name']['value'] ?? APP_NAME) . " — Komunitas Programmer SMKN 2 Pinrang";
$og_description = "Bergabunglah bersama komunitas programmer SMKN 2 Pinrang! Daftarkan diri kamu sekarang dan jadilah bagian dari generasi teknologi berikutnya. 💻🚀";
$og_url         = BASE_URL . "/pab";
$og_image       = BASE_URL . "/assets/img/logo-com.png";

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

/* ── Normalisasi flash jadi bentuk {type, messages[]} agar aman dipakai di JS ── */
$flashType = $flash['type'] ?? 'error';
$flashMsgs = $flash['msg'] ?? [];
if (!is_array($flashMsgs)) {
    $flashMsgs = array_filter([trim(strip_tags((string) $flashMsgs))]);
}
$flashMsgs = array_values(array_filter(array_map('trim', $flashMsgs)));
?>

<style>
/* ═══════════════════════════════════════════
   PAB PAGE — mengikuti Design System
   (token asli didefinisikan global di layout;
    fallback disertakan bila halaman ini dirender berdiri sendiri)
═══════════════════════════════════════════ */
.pab-wrap {
  --tx-primary:   var(--c-ink,    #0f172a);
  --tx-secondary: var(--c-muted,  #64748b);
  --tx-muted:     var(--c-muted2, #94a3b8);
  --bg-page:      var(--c-page,   #eef2f6);
  --bg-surface:   var(--c-white,  #ffffff);
  --bg-elevated:  #f8fafc;
  --bd-subtle:    var(--c-border, #e6ebf1);
  --ac:           var(--c-primary,    #0e7490);
  --ac-dk:        var(--c-primary-dk, #0b5a70);
  --ac-lt:        var(--c-primary-lt, #06b6d4);
  --green:      var(--c-green-text,   #15803d);
  --green-bg:   var(--c-green-bg,     #f0fdf4);
  --green-bd:   var(--c-green-border, #bbf7d0);
  --red:        var(--c-red-text,     #b91c1c);
  --red-bg:     var(--c-red-bg,       #fef2f2);
  --red-bd:     var(--c-red-border,   #fecaca);
  --amber:      var(--c-amber-icon,   #d9910c);
  --amber-bg:   var(--c-amber-bg,     #fef6e2);
  --amber-bd:   var(--c-amber-border, #fbe3a8);
  --r-sm: var(--radius-sm, 9px);
  --r-md: var(--radius-md, 13px);
  --r-lg: var(--radius-lg, 22px);
  --font-ui: var(--ff, 'Plus Jakarta Sans', sans-serif);

  min-height: calc(100svh - 68px);
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 3.5rem 1.5rem;
  position: relative;
  overflow: hidden;
  background: var(--bg-page);
  font-family: var(--font-ui);
  color: var(--tx-primary);
}

.pab-wrap::before {
  content: '';
  position: fixed;
  inset: 0;
  pointer-events: none;
  background:
    radial-gradient(ellipse 55% 45% at 80% 8%, rgba(14,116,144,.07) 0%, transparent 65%),
    radial-gradient(ellipse 45% 45% at 6% 90%, rgba(14,116,144,.055) 0%, transparent 60%);
  z-index: 0;
}
.pab-wrap::after {
  content: '';
  position: fixed;
  inset: 0;
  pointer-events: none;
  background-image:
    linear-gradient(rgba(14,116,144,.035) 1px, transparent 1px),
    linear-gradient(90deg, rgba(14,116,144,.035) 1px, transparent 1px);
  background-size: 64px 64px;
  mask-image: radial-gradient(ellipse 80% 80% at 50% 40%, black 0%, transparent 75%);
  z-index: 0;
}

/* ── Shell: two-column balance on desktop, single column on mobile ── */
.pab-shell {
  position: relative;
  z-index: 1;
  width: 100%;
  max-width: 1120px;
  margin: 0 auto;
  display: grid;
  grid-template-columns: minmax(0, 420px) minmax(0, 1fr);
  gap: clamp(2rem, 4vw, 4.5rem);
  align-items: start;
}

/* ── Side panel (branding / info) ── */
.pab-side {
  position: sticky;
  top: 2.5rem;
  display: flex;
  flex-direction: column;
  gap: 1.75rem;
  max-height: calc(100svh - 5rem);
  overflow-y: auto;
  scrollbar-width: thin;
}

.pab-logo-wrap { display: flex; align-items: center; gap: .85rem; }
.pab-logo {
  height: 52px;
  width: auto;
  object-fit: contain;
  filter: drop-shadow(0 3px 10px rgba(15,23,42,.14));
  flex-shrink: 0;
}
.pab-logo-org { font-size: .78rem; font-weight: 800; color: var(--tx-primary); letter-spacing: -.01em; line-height: 1.3; }
.pab-logo-sub { font-size: .68rem; color: var(--tx-muted); font-weight: 600; letter-spacing: .02em; }

.pab-badge {
  display: inline-flex; align-items: center; gap: 8px;
  width: fit-content;
  padding: 5px 14px;
  background: rgba(14,116,144,.08);
  border: 1px solid rgba(14,116,144,.22);
  border-radius: 99px;
  font-size: .68rem; color: var(--ac);
  font-weight: 700;
  letter-spacing: .07em; text-transform: uppercase;
}
.pab-badge-pulse { width: 6px; height: 6px; border-radius: 50%; background: var(--ac-lt); animation: pulse-glow 2s ease-in-out infinite; flex-shrink: 0; }
@keyframes pulse-glow { 0%,100%{opacity:1;box-shadow:0 0 0 0 rgba(6,182,212,.4)} 50%{opacity:.7;box-shadow:0 0 0 5px rgba(6,182,212,0)} }

.pab-title {
  font-size: clamp(1.7rem, 2.6vw, 2.15rem);
  font-weight: 800; color: var(--ac-dk);
  letter-spacing: -.035em; line-height: 1.12;
}
.pab-title .t-grad {
  background: linear-gradient(130deg, var(--ac) 0%, var(--ac-dk) 100%);
  -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
}
.pab-tagline { font-size: .87rem; color: var(--tx-secondary); line-height: 1.75; letter-spacing: .01em; }
.pab-tagline strong { color: var(--ac-dk); font-weight: 700; }
.pab-info { font-size: .84rem; color: var(--tx-secondary); line-height: 1.7; }

.pab-deadline {
  display: inline-flex; align-items: center; gap: 6px;
  width: fit-content;
  font-size: .72rem; font-weight: 700; color: var(--amber);
  background: var(--amber-bg); border: 1px solid var(--amber-bd);
  border-radius: 99px; padding: 5px 13px;
}

/* Benefit list — memberi konteks singkat kenapa bergabung */
.pab-benefits { display: flex; flex-direction: column; gap: .8rem; }
.pab-benefit {
  display: flex; align-items: flex-start; gap: 11px;
}
.pab-benefit-icon {
  width: 30px; height: 30px; border-radius: 9px;
  background: var(--bg-surface);
  border: 1px solid var(--bd-subtle);
  display: flex; align-items: center; justify-content: center;
  color: var(--ac); flex-shrink: 0;
  box-shadow: 0 2px 6px rgba(15,23,42,.04);
}
.pab-benefit-text { font-size: .81rem; color: var(--tx-secondary); line-height: 1.55; padding-top: 4px; }
.pab-benefit-text strong { color: var(--tx-primary); font-weight: 700; }

/* ── Persyaratan (info card) — tinggal di side panel ── */
.pab-req {
  background: var(--bg-surface);
  border: 1px solid var(--bd-subtle);
  border-radius: var(--r-md);
  padding: 1.25rem 1.4rem;
  box-shadow: 0 4px 18px rgba(15,23,42,.05);
}
.pab-req-title {
  display: flex; align-items: center; gap: 8px;
  font-size: .82rem; font-weight: 800; color: var(--tx-primary);
  margin-bottom: .8rem;
}
.pab-req-title svg { color: var(--ac); flex-shrink: 0; }
.pab-req-list { display: flex; flex-direction: column; gap: .55rem; }
.pab-req-item {
  display: flex; align-items: flex-start; gap: 9px;
  font-size: .79rem; color: var(--tx-secondary); line-height: 1.55;
}
.pab-req-item svg { flex-shrink: 0; margin-top: 2px; color: var(--green); }

.pab-back { margin-top: .25rem; }
.pab-back a {
  font-size: .82rem; color: var(--tx-secondary); text-decoration: none;
  transition: color .2s;
  display: inline-flex; align-items: center; gap: 5px;
  font-weight: 600;
}
.pab-back a:hover { color: var(--ac); }

/* ── Main column ── */
.pab-main { min-width: 0; }

/* ── Card ── */
.pab-card {
  background: var(--bg-surface);
  border: 1px solid var(--bd-subtle);
  border-radius: var(--r-lg);
  overflow: hidden;
  box-shadow: 0 30px 70px -20px rgba(15,23,42,.16), 0 4px 18px rgba(15,23,42,.05);
}
.pab-card-head {
  padding: 1.5rem 2rem;
  border-bottom: 1px solid var(--bd-subtle);
  display: flex; align-items: center; justify-content: space-between;
  gap: 1.25rem; flex-wrap: wrap;
  background: var(--bg-elevated);
}
.pab-card-head-left { display: flex; align-items: center; gap: .75rem; }
.pab-card-head-icon {
  width: 38px; height: 38px; border-radius: var(--r-sm);
  background: rgba(14,116,144,.1);
  display: flex; align-items: center; justify-content: center;
  color: var(--ac); flex-shrink: 0;
}
.pab-card-head h2 { font-size: .98rem; font-weight: 800; color: var(--tx-primary); }
.pab-card-head span { font-size: .69rem; color: var(--tx-muted); letter-spacing: .03em; }
.pab-card-body { padding: 2rem; }

/* ── Closed state ── */
.pab-closed { text-align: center; padding: 3.5rem 2rem; }
.pab-closed-icon {
  width: 64px; height: 64px;
  background: var(--red-bg);
  border: 1px solid var(--red-bd);
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  margin: 0 auto 1.25rem; color: var(--red);
}
.pab-closed h2 { font-size: 1.2rem; font-weight: 800; color: var(--tx-primary); margin-bottom: .5rem; }
.pab-closed p { font-size: .84rem; color: var(--tx-secondary); line-height: 1.75; max-width: 380px; margin: 0 auto; }

/* ── Step indicator ── */
.pab-steps { display: flex; align-items: center; gap: 0; margin-bottom: 1.9rem; }
.pab-step { flex: 1; display: flex; flex-direction: column; align-items: center; gap: 5px; position: relative; }
.pab-step::after { content: ''; position: absolute; top: 14px; left: 50%; width: 100%; height: 1px; background: var(--bd-subtle); }
.pab-step:last-child::after { display: none; }
.pab-step-dot {
  width: 28px; height: 28px; border-radius: 50%;
  background: #fbfcfe; border: 1px solid var(--bd-subtle);
  display: flex; align-items: center; justify-content: center;
  font-size: .68rem; font-weight: 700; color: var(--tx-muted);
  position: relative; z-index: 1; transition: all .3s;
}
.pab-step.active .pab-step-dot { background: var(--ac); border-color: var(--ac); color: #fff; box-shadow: 0 0 0 4px rgba(14,116,144,.15); }
.pab-step.done .pab-step-dot { background: var(--green-bg); border-color: var(--green-bd); color: var(--green); }
.pab-step-label { font-size: .62rem; color: var(--tx-muted); font-weight: 700; letter-spacing: .05em; text-transform: uppercase; white-space: nowrap; }
.pab-step.active .pab-step-label { color: var(--ac); }
.pab-step.done  .pab-step-label  { color: var(--green); }

/* ── Form fields ── */
.pab-form { display: flex; flex-direction: column; gap: 1.15rem; }
.pab-field { display: flex; flex-direction: column; gap: .45rem; }
.pab-label { font-size: .78rem; font-weight: 700; color: var(--tx-primary); letter-spacing: -.01em; }
.pab-label span { color: var(--red); margin-left: 2px; }
.pab-hint { font-size: .68rem; color: var(--tx-muted); letter-spacing: .01em; }

.pab-input {
  width: 100%;
  background: #fbfcfe;
  border: 1.5px solid var(--bd-subtle);
  border-radius: var(--r-sm);
  padding: 12px 15px;
  font-size: .9rem; color: var(--tx-primary);
  font-family: inherit;
  outline: none;
  transition: border-color .16s, box-shadow .16s, background .16s;
  appearance: none;
}
.pab-input::placeholder { color: var(--tx-muted); }
.pab-input:hover  { border-color: var(--c-muted2, #94a3b8); }
.pab-input:focus  { border-color: var(--ac-lt); box-shadow: 0 0 0 3px rgba(6,182,212,.12); background: #fff; }

.pab-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }

.pab-pass-hint { font-size: .68rem; color: var(--tx-muted); margin-top: 3px; letter-spacing: .01em; }

.pab-divider {
  display: flex; align-items: center; gap: .75rem;
  color: var(--tx-muted); font-size: .72rem; font-weight: 700;
  letter-spacing: .06em; text-transform: uppercase;
  margin: .25rem 0;
}
.pab-divider::before, .pab-divider::after { content: ''; flex: 1; height: 1px; background: var(--bd-subtle); }

/* ── Dropzone ── */
.pab-dropzone {
  width: 100%;
  border: 1.5px dashed var(--bd-subtle);
  border-radius: var(--r-sm);
  background: #fbfcfe;
  cursor: pointer;
  transition: border-color .2s, background .2s;
  overflow: hidden; position: relative;
  min-height: 128px;
  display: flex; align-items: center; justify-content: center;
}
.pab-dropzone:hover, .pab-dropzone.drag-over { border-color: var(--ac-lt); background: rgba(6,182,212,.05); }
.pab-dropzone-inner {
  display: flex; flex-direction: column; align-items: center; justify-content: center;
  gap: .4rem; padding: 1.5rem; text-align: center; pointer-events: none;
}
.pab-dropzone-icon {
  width: 40px; height: 40px; border-radius: var(--r-sm);
  background: rgba(14,116,144,.09);
  display: flex; align-items: center; justify-content: center;
  color: var(--ac); margin-bottom: .2rem;
  transition: background .2s;
}
.pab-dropzone:hover .pab-dropzone-icon { background: rgba(14,116,144,.16); }
.pab-dropzone-label { font-size: .83rem; font-weight: 700; color: var(--tx-primary); }
.pab-dropzone-sub { font-size: .66rem; color: var(--tx-muted); letter-spacing: .02em; }
#pab-preview { width: 100%; height: 150px; object-fit: cover; display: none; }
#pab-preview.show { display: block; }
.pab-preview-reset {
  position: absolute; top: 8px; right: 8px;
  width: 28px; height: 28px; border-radius: 50%;
  background: rgba(15,23,42,.55);
  border: 1px solid rgba(255,255,255,.25);
  display: none; align-items: center; justify-content: center;
  cursor: pointer; color: #fff; z-index: 2;
  transition: background .2s;
}
.pab-preview-reset:hover { background: rgba(185,28,28,.7); }
.pab-preview-reset.show { display: flex; }
.pab-file-error {
  display: none;
  align-items: center; gap: 6px;
  font-size: .72rem; color: var(--red);
  margin-top: .2rem;
  font-weight: 500;
}
.pab-file-error.show { display: flex; }

/* ── Submit button ── */
.pab-submit {
  width: 100%; padding: 13px;
  background: var(--ac); color: #fff;
  font-weight: 800; font-size: .9rem;
  border: none; border-radius: var(--r-sm); cursor: pointer;
  display: flex; align-items: center; justify-content: center; gap: 8px;
  transition: background .18s, transform .12s, box-shadow .18s;
  box-shadow: 0 8px 22px rgba(14,116,144,.25);
  letter-spacing: -.01em; margin-top: .3rem;
  font-family: inherit;
}
.pab-submit:hover { background: var(--ac-lt); transform: translateY(-2px); box-shadow: 0 12px 28px rgba(6,182,212,.3); }
.pab-submit:active { transform: translateY(0); }
.pab-submit:disabled { opacity: .55; cursor: not-allowed; transform: none; }

.pab-privacy-note {
  font-size: .68rem; color: var(--tx-muted); text-align: center; line-height: 1.6;
  margin-top: .4rem;
}

/* ── Modal alert (gaya SweetAlert) ── */
.pab-modal-overlay {
  position: fixed; inset: 0; z-index: 999;
  background: rgba(15,23,42,.52);
  backdrop-filter: blur(3px);
  display: none;
  align-items: center; justify-content: center;
  padding: 1.5rem;
  opacity: 0;
  transition: opacity .22s ease;
}
.pab-modal-overlay.show { display: flex; opacity: 1; }
.pab-modal {
  background: #fff;
  border-radius: 20px;
  padding: 2rem 1.85rem 1.75rem;
  max-width: 380px; width: 100%;
  text-align: center;
  box-shadow: 0 30px 80px -18px rgba(15,23,42,.4);
  transform: scale(.85) translateY(12px);
  opacity: 0;
  transition: transform .3s cubic-bezier(.34,1.56,.64,1), opacity .25s ease;
}
.pab-modal-overlay.show .pab-modal { transform: scale(1) translateY(0); opacity: 1; }
.pab-modal-icon {
  width: 62px; height: 62px; border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  margin: 0 auto 1.1rem;
}
.pab-modal-icon.error   { background: var(--red-bg);   color: var(--red); }
.pab-modal-icon.success { background: var(--green-bg); color: var(--green); }
.pab-modal-icon.info    { background: rgba(14,116,144,.09); color: var(--ac); }
.pab-modal-title { font-size: 1.05rem; font-weight: 800; color: var(--tx-primary); margin-bottom: .55rem; }
.pab-modal-body { font-size: .84rem; color: var(--tx-secondary); line-height: 1.7; }
.pab-modal-body p { margin: 0; text-align: center; }
.pab-modal-body ul { margin: 0; padding-left: 1.15rem; text-align: left; display: flex; flex-direction: column; gap: .4rem; }
.pab-modal-btn {
  margin-top: 1.4rem; width: 100%; padding: 11px;
  background: var(--ac); color: #fff; font-weight: 800; font-size: .86rem;
  border: none; border-radius: var(--r-sm); cursor: pointer;
  font-family: inherit;
  transition: background .18s, transform .12s;
}
.pab-modal-btn:hover { background: var(--ac-lt); transform: translateY(-1px); }
.pab-modal-btn.is-success { background: var(--green); }
.pab-modal-btn.is-success:hover { background: #16a34a; }

/* ── Responsive ── */
@media (max-width: 900px) {
  .pab-shell { grid-template-columns: 1fr; max-width: 560px; gap: 2.25rem; }
  .pab-side { position: static; text-align: center; align-items: center; max-height: none; overflow: visible; }
  .pab-logo-wrap { flex-direction: column; gap: .5rem; }
  .pab-benefits { text-align: left; width: 100%; }
  .pab-badge, .pab-deadline { margin-inline: auto; }
}

@media (max-width: 480px) {
  .pab-wrap { padding: 2.5rem 1rem 3.5rem; }
  .pab-card-body { padding: 1.4rem; }
  .pab-card-head { padding: 1.1rem 1.4rem; }
  .pab-grid-2 { grid-template-columns: 1fr; }
  .pab-steps { display: none; }
  .pab-title { font-size: 1.55rem; }
  .pab-logo { height: 46px; }
  .pab-req { padding: 1rem 1.1rem; }
  .pab-modal { padding: 1.6rem 1.4rem 1.4rem; }
}

@keyframes spin { to { transform: rotate(360deg); } }
</style>

<div class="pab-wrap">
  <div class="pab-shell">

    <!-- ── Side panel: branding & info ── -->
    <aside class="pab-side">

      <div class="pab-logo-wrap">
        <img
          src="<?= BASE_URL ?>/assets/img/logo-com.png"
          alt="Logo <?= htmlspecialchars($settings['org_name']['value'] ?? APP_NAME) ?>"
          class="pab-logo"
          width="52" height="52"
          loading="eager"
          onerror="this.style.display='none'">
        <div>
          <div class="pab-logo-org"><?= htmlspecialchars($settings['org_name']['value'] ?? APP_NAME) ?></div>
          <div class="pab-logo-sub">SMK Negeri 2 Pinrang</div>
        </div>
      </div>

      <div class="pab-badge">
        <span class="pab-badge-pulse"></span>
        Penerimaan Anggota Baru
      </div>

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

      <p class="pab-tagline">
        Bergabunglah bersama <strong>Komunitas Programmer SMKN 2 Pinrang</strong>. Jadilah bagian dari generasi teknologi berikutnya!
      </p>

      <?php if (!empty($settings['pab_info']['value'])): ?>
        <p class="pab-info"><?= htmlspecialchars($settings['pab_info']['value']) ?></p>
      <?php endif; ?>

      <?php if (!empty($settings['pab_deadline']['value'])): ?>
        <span class="pab-deadline">
          <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
          Batas: <?= htmlspecialchars($settings['pab_deadline']['value']) ?>
        </span>
      <?php endif; ?>

      <!-- Kenapa gabung -->
      <div class="pab-benefits">
        <div class="pab-benefit">
          <div class="pab-benefit-icon">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
          </div>
          <div class="pab-benefit-text"><strong>Belajar coding bareng</strong> — dari dasar sampai proyek nyata, dibimbing kakak kelas dan mentor.</div>
        </div>
        <div class="pab-benefit">
          <div class="pab-benefit-icon">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
          </div>
          <div class="pab-benefit-text"><strong>Komunitas suportif</strong> — tempat berbagi ide, berkolaborasi, dan tumbuh bersama.</div>
        </div>
        <div class="pab-benefit">
          <div class="pab-benefit-icon">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z"/></svg>
          </div>
          <div class="pab-benefit-text"><strong>Portofolio nyata</strong> — kesempatan mengerjakan proyek yang bisa kamu tunjukkan ke dunia luar.</div>
        </div>
      </div>

      <?php if ($isOpen): ?>
      <!-- ── Persyaratan pendaftaran ── -->
      <section class="pab-req" aria-labelledby="pab-req-title">
        <div class="pab-req-title" id="pab-req-title">
          <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
          Yang Perlu Disiapkan
        </div>
        <div class="pab-req-list">
          <div class="pab-req-item">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Nama lengkap, kelas, dan nomor HP aktif yang bisa dihubungi.</span>
          </div>
          <div class="pab-req-item">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Password akun portal (minimal 6 karakter) untuk login setelah mendaftar.</span>
          </div>
          <div class="pab-req-item">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Pas foto terbaru format JPG/PNG/WEBP, ukuran maksimal 2 MB.</span>
          </div>
        </div>
      </section>
      <?php endif; ?>

      <div class="pab-back">
        <a href="<?= BASE_URL ?>/">
          <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
          Kembali ke beranda
        </a>
      </div>

    </aside>

    <!-- ── Main column: card ── -->
    <div class="pab-main">

      <!-- ── Card ── -->
      <div class="pab-card">

        <?php if (!$isOpen): ?>
          <!-- Closed state -->
          <div class="pab-closed">
            <div class="pab-closed-icon">
              <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            </div>
            <h2>Pendaftaran Ditutup</h2>
            <p>Saat ini pendaftaran PAB sedang tidak dibuka. Pantau terus informasi selanjutnya melalui media sosial kami.</p>
          </div>

        <?php else: ?>
          <!-- Card header -->
          <div class="pab-card-head">
            <div class="pab-card-head-left">
              <div class="pab-card-head-icon">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="21" y1="8" x2="21" y2="14"/><line x1="18" y1="11" x2="24" y2="11"/></svg>
              </div>
              <div>
                <h2>Formulir Pendaftaran</h2>
                <span>Isi data diri dengan lengkap dan benar</span>
              </div>
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
                  enctype="multipart/form-data" class="pab-form" id="pab-form" novalidate>
              <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">

              <!-- Nama -->
              <div class="pab-field">
                <label class="pab-label" for="pab-nama">Nama Lengkap <span>*</span></label>
                <input id="pab-nama" type="text" name="nama_lengkap" required
                       class="pab-input" placeholder="Nama sesuai rapor"
                       value="<?= htmlspecialchars($old['nama_lengkap'] ?? '') ?>"
                       autocomplete="name">
              </div>

              <!-- Kelas + No HP -->
              <div class="pab-grid-2">
                <div class="pab-field">
                  <label class="pab-label" for="pab-kelas">Kelas <span>*</span></label>
                  <input id="pab-kelas" type="text" name="kelas" required
                         class="pab-input" placeholder="Contoh: XI RPL 1"
                         value="<?= htmlspecialchars($old['kelas'] ?? '') ?>">
                </div>
                <div class="pab-field">
                  <label class="pab-label" for="pab-hp">Nomor HP <span>*</span></label>
                  <input id="pab-hp" type="tel" name="no_hp" required
                         class="pab-input" placeholder="08xxxxxxxxxx"
                         value="<?= htmlspecialchars($old['no_hp'] ?? '') ?>"
                         autocomplete="tel" pattern="[0-9]{10,15}"
                         inputmode="numeric">
                </div>
              </div>
              <span class="pab-hint">Pastikan nomor HP aktif — panitia akan menghubungi lewat WhatsApp.</span>

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
                          style="position:absolute;right:.75rem;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--tx-muted);padding:0;display:flex;align-items:center;"
                          aria-label="Tampilkan password">
                    <svg id="eye-icon" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                  </button>
                </div>
                <span class="pab-pass-hint">Password ini digunakan untuk login ke portal komunitas — jangan lupa dicatat.</span>
              </div>

              <!-- Konfirmasi Password -->
              <div class="pab-field">
                <label class="pab-label" for="pab-pass2">Konfirmasi Password <span>*</span></label>
                <div style="position:relative">
                  <input id="pab-pass2" type="password" name="password_confirmation" required
                         class="pab-input" placeholder="Ulangi password yang sama"
                         autocomplete="new-password" style="padding-right:2.8rem">
                  <span id="pass-match-icon"
                        style="position:absolute;right:.75rem;top:50%;transform:translateY(-50%);display:none;"></span>
                </div>
                <span class="pab-hint" id="pass-match-text"></span>
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
                <span class="pab-file-error" id="pab-file-error">
                  <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                  <span id="pab-file-error-text">Ukuran foto maksimal 2 MB.</span>
                </span>
                <?php if (!empty($old)): ?>
                  <span class="pab-hint">Foto perlu dipilih ulang — file tidak bisa disimpan otomatis karena alasan keamanan browser.</span>
                <?php endif; ?>
              </div>

              <!-- Submit -->
              <button type="submit" class="pab-submit" id="pab-submit">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                Kirim Pendaftaran
              </button>

              <p class="pab-privacy-note">
                Dengan mengirim formulir ini, kamu menyetujui data digunakan hanya untuk keperluan seleksi anggota.
              </p>

            </form>
          </div><!-- .pab-card-body -->
        <?php endif; ?>
      </div><!-- .pab-card -->

    </div><!-- .pab-main -->

  </div><!-- .pab-shell -->
</div><!-- .pab-wrap -->

<!-- ── Modal alert (gaya SweetAlert), dipopulate lewat JS dari data flash ── -->
<div class="pab-modal-overlay" id="pab-modal-overlay">
  <div class="pab-modal" role="alertdialog" aria-modal="true" aria-labelledby="pab-modal-title">
    <div class="pab-modal-icon" id="pab-modal-icon"></div>
    <h3 class="pab-modal-title" id="pab-modal-title"></h3>
    <div class="pab-modal-body" id="pab-modal-body"></div>
    <button type="button" class="pab-modal-btn" id="pab-modal-btn">Mengerti</button>
  </div>
</div>

<?php if (!empty($flashMsgs)): ?>
<script>
  window.__pabFlash = <?= json_encode(['type' => $flashType, 'messages' => $flashMsgs], JSON_UNESCAPED_UNICODE) ?>;
</script>
<?php endif; ?>

<script>
(function () {
  'use strict';

  /* ── Modal alert ── */
  (function initFlashModal() {
    var data = window.__pabFlash;
    if (!data || !data.messages || !data.messages.length) return;

    var overlay = document.getElementById('pab-modal-overlay');
    var iconEl  = document.getElementById('pab-modal-icon');
    var titleEl = document.getElementById('pab-modal-title');
    var bodyEl  = document.getElementById('pab-modal-body');
    var btnEl   = document.getElementById('pab-modal-btn');
    if (!overlay) return;

    var type = data.type === 'success' ? 'success' : (data.type === 'info' ? 'info' : 'error');

    var icons = {
      success: '<svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>',
      error:   '<svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>',
      info:    '<svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12.01"/><line x1="12" y1="16" x2="12" y2="16.01"/></svg>'
    };
    var titles = { success: 'Berhasil!', error: 'Periksa Lagi', info: 'Informasi' };

    iconEl.className   = 'pab-modal-icon ' + type;
    iconEl.innerHTML   = icons[type];
    titleEl.textContent = titles[type];

    bodyEl.innerHTML = '';
    if (data.messages.length > 1) {
      var ul = document.createElement('ul');
      data.messages.forEach(function (m) {
        var li = document.createElement('li');
        li.textContent = m;
        ul.appendChild(li);
      });
      bodyEl.appendChild(ul);
    } else {
      var p = document.createElement('p');
      p.textContent = data.messages[0];
      bodyEl.appendChild(p);
    }

    btnEl.className   = 'pab-modal-btn' + (type === 'success' ? ' is-success' : '');
    btnEl.textContent = type === 'success' ? 'Selesai' : 'Mengerti';

    function closeModal() { overlay.classList.remove('show'); }
    btnEl.addEventListener('click', closeModal);
    overlay.addEventListener('click', function (e) { if (e.target === overlay) closeModal(); });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') closeModal(); });

    requestAnimationFrame(function () { overlay.classList.add('show'); });
  })();

  /* ── Toggle password visibility ── */
  var passInput  = document.getElementById('pab-pass');
  var toggleBtn  = document.getElementById('toggle-pass');
  var eyeIcon    = document.getElementById('eye-icon');
  if (toggleBtn && passInput) {
    toggleBtn.addEventListener('click', function () {
      var isHidden = passInput.type === 'password';
      passInput.type = isHidden ? 'text' : 'password';
      toggleBtn.setAttribute('aria-label', isHidden ? 'Sembunyikan password' : 'Tampilkan password');
      eyeIcon.innerHTML = isHidden
        ? '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>'
        : '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
    });
  }

  /* ── Password match indicator ── */
  var pass2Input   = document.getElementById('pab-pass2');
  var matchIcon    = document.getElementById('pass-match-icon');
  var matchText    = document.getElementById('pass-match-text');
  function checkMatch() {
    if (!passInput || !pass2Input || !pass2Input.value) {
      if (matchIcon) matchIcon.style.display = 'none';
      if (matchText) matchText.textContent = '';
      return;
    }
    var ok = passInput.value === pass2Input.value;
    matchIcon.style.display = 'flex';
    matchIcon.innerHTML = ok
      ? '<svg width="16" height="16" fill="none" stroke="#15803d" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>'
      : '<svg width="16" height="16" fill="none" stroke="#b91c1c" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>';
    if (matchText) {
      matchText.textContent = ok ? 'Password cocok.' : 'Password belum sama.';
      matchText.style.color = ok ? '#15803d' : '#b91c1c';
    }
  }
  if (pass2Input) {
    pass2Input.addEventListener('input', checkMatch);
    if (passInput) passInput.addEventListener('input', checkMatch);
  }

  /* ── Dropzone / file upload ── */
  var dropzone   = document.getElementById('pab-dropzone');
  var fileInput  = document.getElementById('pab-foto');
  var preview    = document.getElementById('pab-preview');
  var dzInner    = document.getElementById('pab-dz-inner');
  var resetBtn   = document.getElementById('pab-reset-photo');
  var fileError  = document.getElementById('pab-file-error');
  var fileErrTxt = document.getElementById('pab-file-error-text');

  function showFileError(msg) {
    if (fileError && fileErrTxt) {
      fileErrTxt.textContent = msg;
      fileError.classList.add('show');
    }
  }
  function hideFileError() {
    if (fileError) fileError.classList.remove('show');
  }

  function showPreview(file) {
    if (!file) return;
    if (!file.type.startsWith('image/')) {
      showFileError('File harus berupa gambar (JPG, PNG, atau WEBP).');
      return;
    }
    if (file.size > 2 * 1024 * 1024) {
      showFileError('Ukuran foto maksimal 2 MB.');
      return;
    }
    hideFileError();
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
    hideFileError();
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
  updateSteps();

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