<!DOCTYPE html>
<html lang="id" dir="ltr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="noindex, nofollow">
  <title>Admin Panel &mdash; <?= htmlspecialchars(APP_NAME) ?></title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Geist:wght@300;400;500;600;700&family=Geist+Mono:wght@400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/custom.css">

  <style>
/* ==========================================================================
   RESET
   ========================================================================== */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

/* ==========================================================================
   TOKENS
   ========================================================================== */
:root {
  --sw: 252px;
  --th: 58px;

  /* Canvas */
  --bg-0: #060910;
  --bg-1: #090d17;
  --bg-2: #0d1220;
  --bg-3: #111829;
  --bg-4: #162032;
  --bg-h: rgba(255,255,255,.028);
  --bg-a: rgba(82,130,255,.07);

  /* Borders */
  --b0: rgba(255,255,255,.03);
  --b1: rgba(255,255,255,.06);
  --b2: rgba(255,255,255,.10);
  --b3: rgba(255,255,255,.16);
  --ba: rgba(82,130,255,.25);

  /* Text */
  --t1: #cdd9ec;
  --t2: #5a7391;
  --t3: #2a3d52;
  --t4: #19263a;

  /* Accent */
  --ac:    #5282ff;
  --ac-hi: #7da4ff;
  --ac-lo: rgba(82,130,255,.08);
  --ac-gl: rgba(82,130,255,.12);

  /* Semantic */
  --ok:    #2dd4a0; --ok-d: rgba(45,212,160,.07); --ok-b: rgba(45,212,160,.2);
  --er:    #f27070; --er-d: rgba(242,112,112,.07); --er-b: rgba(242,112,112,.2);
  --wa:    #f0b444; --wa-d: rgba(240,180,68,.07);  --wa-b: rgba(240,180,68,.2);
  --in:    #5aabf5; --in-d: rgba(90,171,245,.07);  --in-b: rgba(90,171,245,.2);

  /* Radius */
  --r1: 4px; --r2: 6px; --r3: 9px; --r4: 12px; --r5: 16px;

  /* Font */
  --ff: 'Geist', system-ui, sans-serif;
  --fm: 'Geist Mono', monospace;

  /* Motion */
  --ease: cubic-bezier(.22,1,.36,1);
  --tf: 100ms; --tm: 180ms; --ts: 300ms;
}

/* ==========================================================================
   BASE
   ========================================================================== */
html, body { height: 100%; }
body {
  font-family: var(--ff);
  background: var(--bg-0);
  color: var(--t1);
  font-size: 13.5px;
  line-height: 1.6;
  -webkit-font-smoothing: antialiased;
}
a { color: inherit; text-decoration: none; }
button { font-family: inherit; cursor: pointer; }
svg { display: block; }

::-webkit-scrollbar { width: 3px; height: 3px; }
::-webkit-scrollbar-track { background: transparent; }
::-webkit-scrollbar-thumb { background: var(--b1); border-radius: 99px; }
::-webkit-scrollbar-thumb:hover { background: var(--b2); }
:focus-visible { outline: 2px solid var(--ac); outline-offset: 2px; border-radius: var(--r1); }

/* ==========================================================================
   SHELL
   ========================================================================== */
.shell {
  display: flex;
  height: 100vh;
  overflow: hidden;
}

/* Grid bg */
.shell::before {
  content: '';
  position: fixed;
  inset: 0;
  z-index: 0;
  pointer-events: none;
  background-image:
    linear-gradient(rgba(82,130,255,.018) 1px, transparent 1px),
    linear-gradient(90deg, rgba(82,130,255,.018) 1px, transparent 1px);
  background-size: 36px 36px;
  mask-image: radial-gradient(ellipse 70% 50% at 50% 0%, black 20%, transparent 100%);
}

/* ==========================================================================
   BACKDROP
   ========================================================================== */
.bd {
  display: none;
  position: fixed;
  inset: 0;
  z-index: 35;
  background: rgba(6,9,16,.85);
  backdrop-filter: blur(8px);
}
.bd.on { display: block; animation: bdin var(--tm) var(--ease); }
@keyframes bdin { from { opacity:0; } to { opacity:1; } }

/* ==========================================================================
   SIDEBAR
   ========================================================================== */
.sb {
  position: fixed;
  inset-block: 0;
  left: 0;
  z-index: 40;
  width: var(--sw);
  height: 100%;
  display: flex;
  flex-direction: column;
  background: var(--bg-1);
  border-right: 1px solid var(--b0);
  transform: translateX(-100%);
  transition: transform var(--ts) var(--ease), box-shadow var(--ts) var(--ease);
  overflow: hidden;
}
.sb::after {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 220px;
  background: radial-gradient(ellipse 100% 100% at 50% -10%, rgba(82,130,255,.055) 0%, transparent 100%);
  pointer-events: none;
}
@media (min-width: 768px) {
  .sb { transform: translateX(0) !important; box-shadow: none !important; }
}
.sb.on { transform: translateX(0); box-shadow: 40px 0 80px rgba(0,0,0,.7); }

/* Brand */
.sb-brand {
  display: flex;
  align-items: center;
  gap: 10px;
  height: var(--th);
  padding: 0 14px;
  border-bottom: 1px solid var(--b0);
  flex-shrink: 0;
  position: relative;
  z-index: 1;
}
.sb-logo-wrap {
  width: 30px; height: 30px;
  border-radius: var(--r3);
  background: var(--ac-lo);
  border: 1px solid var(--ba);
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
  box-shadow: 0 0 0 3px var(--ac-gl);
  overflow: hidden;
}
.sb-logo { width: 100%; height: 100%; object-fit: contain; }
.sb-logo-fallback { width: 15px; height: 15px; color: var(--ac-hi); }
.sb-name {
  flex: 1;
  font-size: 13px;
  font-weight: 600;
  letter-spacing: -.025em;
  color: var(--t1);
  white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.sb-badge {
  font-family: var(--fm);
  font-size: 9px;
  font-weight: 500;
  letter-spacing: .07em;
  text-transform: uppercase;
  color: var(--ac);
  background: var(--ac-lo);
  border: 1px solid var(--ba);
  border-radius: var(--r1);
  padding: 2px 7px;
  flex-shrink: 0;
}

/* Nav scroll */
.sb-nav {
  flex: 1;
  overflow-y: auto;
  padding: 10px 8px;
  display: flex;
  flex-direction: column;
  gap: 0;
  position: relative;
  z-index: 1;
}

/* Section */
.nav-sec { margin-bottom: 2px; }
.nav-sec + .nav-sec {
  margin-top: 6px;
  padding-top: 6px;
  border-top: 1px solid var(--b0);
}
.nav-sec-label {
  font-size: 9px;
  font-weight: 600;
  letter-spacing: .12em;
  text-transform: uppercase;
  color: var(--t3);
  padding: 5px 10px 4px;
  display: block;
}

/* Nav item */
.ni {
  position: relative;
  display: flex;
  align-items: center;
  gap: 9px;
  padding: 7.5px 10px;
  border-radius: var(--r3);
  font-size: 12.5px;
  font-weight: 500;
  color: var(--t2);
  transition: color var(--tf) var(--ease), background var(--tf) var(--ease);
  user-select: none;
}
.ni:hover { color: var(--t1); background: var(--bg-h); }
.ni.act {
  color: var(--ac-hi);
  background: var(--bg-a);
}
.ni.act::before {
  content: '';
  position: absolute;
  left: 0; top: 50%; transform: translateY(-50%);
  width: 2.5px; height: 14px;
  background: linear-gradient(180deg, var(--ac-hi), var(--ac));
  border-radius: 0 2px 2px 0;
}
.ni-icon {
  width: 15px; height: 15px;
  flex-shrink: 0;
  color: var(--t3);
  transition: color var(--tf) var(--ease);
}
.ni:hover .ni-icon { color: var(--t2); }
.ni.act .ni-icon { color: var(--ac); }
.ni-label { flex: 1; line-height: 1.2; }
.ni-badge {
  font-family: var(--fm);
  font-size: 8px;
  font-weight: 500;
  letter-spacing: .06em;
  text-transform: uppercase;
  color: var(--wa);
  background: var(--wa-d);
  border: 1px solid var(--wa-b);
  border-radius: var(--r1);
  padding: 1px 5px;
  flex-shrink: 0;
}
.ni-new {
  font-family: var(--fm);
  font-size: 8px;
  font-weight: 500;
  color: var(--ok);
  background: var(--ok-d);
  border: 1px solid var(--ok-b);
  border-radius: var(--r1);
  padding: 1px 5px;
  flex-shrink: 0;
}

/* Footer */
.sb-footer {
  padding: 8px;
  border-top: 1px solid var(--b0);
  flex-shrink: 0;
  position: relative;
  z-index: 1;
}
.sb-ver {
  font-size: 9.5px;
  font-family: var(--fm);
  color: var(--t3);
  text-align: center;
  margin-bottom: 7px;
  letter-spacing: .04em;
}
.ucard {
  display: flex;
  align-items: center;
  gap: 9px;
  padding: 9px 10px;
  border-radius: var(--r4);
  background: var(--bg-2);
  border: 1px solid var(--b1);
  transition: border-color var(--tf) var(--ease), background var(--tf) var(--ease);
}
.ucard:hover { border-color: var(--b2); background: var(--bg-3); }
.ucard-av {
  width: 32px; height: 32px;
  border-radius: 50%;
  background: linear-gradient(135deg, var(--ac-lo), var(--bg-3));
  border: 1px solid var(--ba);
  display: flex; align-items: center; justify-content: center;
  font-size: 11.5px;
  font-weight: 700;
  color: var(--ac-hi);
  flex-shrink: 0;
  letter-spacing: -.02em;
}
.ucard-info { flex: 1; min-width: 0; }
.ucard-name {
  font-size: 12px;
  font-weight: 600;
  color: var(--t1);
  white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
  letter-spacing: -.015em;
  line-height: 1.3;
}
.ucard-role {
  font-size: 10px;
  color: var(--t3);
  font-weight: 500;
  margin-top: 1px;
}
.btn-logout {
  display: flex; align-items: center; justify-content: center;
  width: 28px; height: 28px;
  border-radius: var(--r2);
  background: transparent;
  border: 1px solid transparent;
  color: var(--t3);
  transition: background var(--tf) var(--ease), border-color var(--tf) var(--ease), color var(--tf) var(--ease);
  flex-shrink: 0;
}
.btn-logout:hover { background: var(--er-d); border-color: var(--er-b); color: var(--er); }
.btn-logout svg { width: 13px; height: 13px; }

/* ==========================================================================
   MAIN
   ========================================================================== */
.main {
  flex: 1;
  display: flex;
  flex-direction: column;
  overflow: hidden;
  min-width: 0;
  margin-left: 0;
  position: relative;
  z-index: 1;
}
@media (min-width: 768px) { .main { margin-left: var(--sw); } }

/* ==========================================================================
   TOPBAR
   ========================================================================== */
.tb {
  height: var(--th);
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 0 20px;
  background: var(--bg-1);
  border-bottom: 1px solid var(--b0);
  flex-shrink: 0;
  position: sticky; top: 0; z-index: 20;
}
.tb::after {
  content: '';
  position: absolute;
  bottom: 0; left: 0; right: 0;
  height: 1px;
  background: linear-gradient(90deg, transparent, rgba(82,130,255,.1) 30%, rgba(82,130,255,.1) 70%, transparent);
  pointer-events: none;
}
.btn-menu {
  display: flex; align-items: center; justify-content: center;
  width: 32px; height: 32px;
  border-radius: var(--r3);
  background: transparent;
  border: 1px solid var(--b1);
  color: var(--t2);
  transition: background var(--tf), border-color var(--tf), color var(--tf);
  flex-shrink: 0;
}
.btn-menu:hover { background: var(--bg-h); border-color: var(--b2); color: var(--t1); }
.btn-menu svg { width: 13px; height: 13px; }
@media (min-width: 768px) { .btn-menu { display: none; } }

/* Breadcrumb */
.bc {
  display: flex;
  align-items: center;
  font-size: 12px;
}
.bc-root { color: var(--t3); font-weight: 500; }
.bc-sep  { color: var(--t4); font-size: 15px; margin: 0 5px; }
.bc-page { color: var(--t2); font-weight: 600; font-size: 12.5px; }
@media (max-width: 767px) { .bc { display: none; } }

/* Search */
.tb-search {
  flex: 1;
  max-width: 280px;
  margin-left: auto;
  position: relative;
}
.tb-search input {
  width: 100%;
  height: 32px;
  background: var(--bg-2);
  border: 1px solid var(--b1);
  border-radius: var(--r3);
  padding: 0 40px 0 32px;
  font-family: var(--ff);
  font-size: 12px;
  color: var(--t1);
  outline: none;
  transition: border-color var(--tf), background var(--tf), box-shadow var(--tf);
}
.tb-search input::placeholder { color: var(--t3); }
.tb-search input:focus { border-color: var(--ba); background: var(--bg-3); box-shadow: 0 0 0 3px var(--ac-gl); }
.tb-si {
  position: absolute; left: 10px; top: 50%; transform: translateY(-50%);
  width: 13px; height: 13px; color: var(--t3); pointer-events: none;
}
.tb-kbd {
  position: absolute; right: 8px; top: 50%; transform: translateY(-50%);
  font-family: var(--fm); font-size: 9px; color: var(--t3);
  background: var(--bg-0); border: 1px solid var(--b1);
  border-radius: var(--r1); padding: 1px 4px; pointer-events: none;
}

/* Actions */
.tb-actions {
  display: flex; align-items: center; gap: 5px; flex-shrink: 0;
}
@media (max-width: 767px) { .tb-search { display: none; } .tb-actions { margin-left: auto; } }

.btn-icon {
  position: relative;
  display: flex; align-items: center; justify-content: center;
  width: 32px; height: 32px;
  border-radius: var(--r3);
  background: transparent;
  border: 1px solid var(--b1);
  color: var(--t2);
  transition: background var(--tf), border-color var(--tf), color var(--tf);
}
.btn-icon:hover { background: var(--bg-h); border-color: var(--b2); color: var(--t1); }
.btn-icon svg { width: 13px; height: 13px; }
.ndot {
  position: absolute; top: 6px; right: 6px;
  width: 5px; height: 5px;
  border-radius: 50%; background: var(--er); border: 1.5px solid var(--bg-1);
}
.chip-ok {
  display: flex; align-items: center; gap: 6px;
  padding: 4px 11px;
  border-radius: 99px;
  background: var(--ok-d); border: 1px solid var(--ok-b);
  font-size: 11px; font-weight: 600; color: var(--ok);
  user-select: none;
}
.chip-dot {
  width: 5px; height: 5px; border-radius: 50%; background: var(--ok); flex-shrink: 0;
  animation: pdot 2.4s ease infinite;
}
@keyframes pdot {
  0%,100% { opacity:1; box-shadow: 0 0 0 0 rgba(45,212,160,.4); }
  50%      { opacity:.7; box-shadow: 0 0 0 4px rgba(45,212,160,0); }
}
.tb-av {
  width: 32px; height: 32px;
  border-radius: 50%;
  background: var(--ac-lo); border: 1px solid var(--ba);
  display: flex; align-items: center; justify-content: center;
  font-size: 11px; font-weight: 700; color: var(--ac-hi);
  cursor: pointer; flex-shrink: 0;
  transition: border-color var(--tf), box-shadow var(--tf);
  letter-spacing: -.02em;
}
.tb-av:hover { border-color: var(--ac); box-shadow: 0 0 0 3px var(--ac-gl); }

/* ==========================================================================
   FLASH
   ========================================================================== */
.flash-wrap { padding: 16px 20px 0; }
.alert {
  display: flex; align-items: flex-start; gap: 10px;
  padding: 11px 13px;
  border-radius: var(--r4);
  font-size: 12.5px; font-weight: 500;
  border: 1px solid; line-height: 1.5;
}
.alert svg { width: 14px; height: 14px; flex-shrink: 0; margin-top: 1.5px; }
.alert-msg { flex: 1; }
.alert-x {
  background: none; border: none; font-size: 17px; line-height: 1;
  color: inherit; opacity: .4; padding: 0; flex-shrink: 0;
  transition: opacity var(--tf);
}
.alert-x:hover { opacity: 1; }
.alert-s { background: var(--ok-d); border-color: var(--ok-b); color: var(--ok); }
.alert-e { background: var(--er-d); border-color: var(--er-b); color: var(--er); }
.alert-w { background: var(--wa-d); border-color: var(--wa-b); color: var(--wa); }
.alert-i { background: var(--in-d); border-color: var(--in-b); color: var(--in); }

/* ==========================================================================
   PAGE
   ========================================================================== */
.pg {
  flex: 1; overflow-y: auto;
  padding: 24px 20px;
}
@media (max-width: 480px) {
  .tb        { padding: 0 12px; }
  .flash-wrap{ padding: 10px 12px 0; }
  .pg        { padding: 14px 12px; }
}
  </style>
</head>
<body>

<div class="shell">

  <div class="bd" id="js-bd" onclick="sbClose()" aria-hidden="true"></div>

  <!-- ============================================================
       SIDEBAR
       ============================================================ -->
  <aside class="sb" id="js-sb" role="navigation" aria-label="Navigasi admin">

    <!-- Brand -->
    <div class="sb-brand">
      <div class="sb-logo-wrap">
        <img
          class="sb-logo"
          src="<?= BASE_URL ?>/assets/img/logo-com.png"
          alt="Logo"
          loading="eager"
          decoding="sync"
          onerror="this.style.display='none';this.nextElementSibling.style.display='block';"
        >
        <svg class="sb-logo-fallback" style="display:none;" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" aria-hidden="true">
          <path d="M8 1L13.5 4v8L8 15 2.5 12V4L8 1z"/>
          <path d="M8 6l2.5 1.5v3L8 12 5.5 10.5v-3L8 6z"/>
        </svg>
      </div>
      <span class="sb-name"><?= htmlspecialchars(APP_NAME) ?></span>
      <span class="sb-badge">Admin</span>
    </div>

    <!-- Navigation -->
    <nav class="sb-nav" aria-label="Menu">
      <?php
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        $navGroups = [

          'Utama' => [
            [
              'href'  => '/admin/dashboard',
              'label' => 'Dashboard',
              'icon'  => '<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="1.5" y="1.5" width="5.5" height="5.5" rx="1.5"/><rect x="9" y="1.5" width="5.5" height="5.5" rx="1.5"/><rect x="1.5" y="9" width="5.5" height="5.5" rx="1.5"/><rect x="9" y="9" width="5.5" height="5.5" rx="1.5"/></svg>',
            ],
            [
              'href'  => '/admin/anggota',
              'label' => 'Manajemen Anggota',
              'icon'  => '<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="5.5" cy="5" r="2.5"/><path d="M1 14c0-2.485 2.015-4.5 4.5-4.5S10 11.515 10 14"/><circle cx="12" cy="5.5" r="2"/><path d="M14.5 12.5c0-1.657-1.12-3-2.5-3"/></svg>',
            ],
            [
              'href'  => '/admin/pab',
              'label' => 'Verifikasi PAB',
              'icon'  => '<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="12" height="12" rx="1.5"/><path d="M5 8l2 2 4-4"/></svg>',
            ],
            [
              'href'  => '/admin/absensi',
              'label' => 'Absensi',
              'icon'  => '<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2.5" width="12" height="12" rx="1.5"/><path d="M2 6.5h12M5.5 1v3.5M10.5 1v3.5"/><path d="M5 9.5h1M7.5 9.5h1M10 9.5h1M5 12h1M7.5 12h1"/></svg>',
            ],
          ],

          'Konten' => [
            [
              'href'  => '/admin/berita',
              'label' => 'Berita & Artikel',
              'icon'  => '<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 2h7l3 3v9a1 1 0 01-1 1H3a1 1 0 01-1-1V3a1 1 0 011-1z"/><path d="M10 2v3h3"/><path d="M5 7h6M5 9.5h6M5 12h4"/></svg>',
              'new'   => false,
            ],
            [
              'href'  => '/admin/galeri',
              'label' => 'Galeri Foto',
              'icon'  => '<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="1.5" y="1.5" width="13" height="13" rx="1.5"/><circle cx="5.5" cy="5.5" r="1.5"/><path d="M1.5 11l4-4 3 3 2-2 3.5 3.5"/></svg>',
            ],
          ],

          'Tools' => [
            [
              'href'     => BASE_URL . '/generate_sso.php',
              'label'    => 'Surat Digital',
              'icon'     => '<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 2h7l3 3v9a1 1 0 01-1 1H3a1 1 0 01-1-1V3a1 1 0 011-1z"/><path d="M10 2v3h3"/><path d="M5 7h6M5 9.5h6M5 12h4"/></svg>',
              'badge'    => 'SSO',
              'external' => true,
            ],
          ],

          'Sistem' => [
            [
              'href'  => '/admin/settings',
              'label' => 'Pengaturan & CMS',
              'icon'  => '<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="8" r="2.25"/><path d="M8 1.5v1.5M8 13v1.5M1.5 8H3M13 8h1.5M3.4 3.4l1.05 1.05M11.55 11.55l1.05 1.05M3.4 12.6l1.05-1.05M11.55 4.45l1.05-1.05"/></svg>',
            ],
            [
              'href'  => '/admin/profil',
              'label' => 'Edit Profil Admin',
              'icon'  => '<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="5.5" r="2.5"/><path d="M2.5 14c0-3.038 2.462-5.5 5.5-5.5s5.5 2.462 5.5 5.5"/><path d="M11 2l3 3-5 5H6V7l5-5z"/></svg>',
            ],
          ],

        ];

        foreach ($navGroups as $group => $items):
      ?>
        <div class="nav-sec">
          <span class="nav-sec-label"><?= htmlspecialchars($group) ?></span>
          <?php foreach ($items as $item):
            $ext      = !empty($item['external']);
            $href     = $ext ? htmlspecialchars($item['href']) : BASE_URL . htmlspecialchars($item['href']);
            $active   = !$ext && str_starts_with($uri, $item['href']);
            $cls      = $active ? ' act' : '';
            $aria     = $active ? ' aria-current="page"' : '';
            $target   = $ext ? ' target="_blank" rel="noopener noreferrer"' : '';
          ?>
          <a href="<?= $href ?>" class="ni<?= $cls ?>"<?= $aria ?><?= $target ?>>
            <span class="ni-icon" aria-hidden="true"><?= $item['icon'] ?></span>
            <span class="ni-label"><?= htmlspecialchars($item['label']) ?></span>
            <?php if (!empty($item['badge'])): ?>
              <span class="ni-badge"><?= htmlspecialchars($item['badge']) ?></span>
            <?php endif; ?>
            <?php if (!empty($item['new'])): ?>
              <span class="ni-new">Baru</span>
            <?php endif; ?>
            <?php if ($ext): ?>
              <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 16 16" style="color:var(--t3);flex-shrink:0;" aria-hidden="true"><path d="M10 2h4v4M14 2L8 8M6 4H3a1 1 0 00-1 1v8a1 1 0 001 1h8a1 1 0 001-1v-3"/></svg>
            <?php endif; ?>
          </a>
          <?php endforeach; ?>
        </div>
      <?php endforeach; ?>
    </nav>

    <!-- Footer -->
    <div class="sb-footer">
      <div class="sb-ver">v2.0.0 &mdash; <?= date('Y') ?></div>
      <div class="ucard">
        <div class="ucard-av" aria-hidden="true">
          <?php
            $uname = $_SESSION['user_name'] ?? 'Administrator';
            $ini   = '';
            foreach (explode(' ', $uname) as $w) {
              $ini .= mb_strtoupper(mb_substr($w, 0, 1));
              if (strlen($ini) >= 2) break;
            }
            echo htmlspecialchars($ini ?: 'A');
          ?>
        </div>
        <div class="ucard-info">
          <div class="ucard-name"><?= htmlspecialchars($_SESSION['user_name'] ?? 'Administrator') ?></div>
          <div class="ucard-role">Administrator</div>
        </div>
        <a href="<?= BASE_URL ?>/logout" class="btn-logout" title="Logout" aria-label="Keluar">
          <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M6 2H3.5A1.5 1.5 0 002 3.5v9A1.5 1.5 0 003.5 14H6"/>
            <path d="M10.5 11l3-3-3-3M13.5 8H6"/>
          </svg>
        </a>
      </div>
    </div>

  </aside>

  <!-- ============================================================
       MAIN AREA
       ============================================================ -->
  <div class="main" id="js-main">

    <!-- Topbar -->
    <header class="tb" role="banner">

      <button
        class="btn-menu"
        id="js-mbtn"
        onclick="sbToggle()"
        aria-label="Buka menu"
        aria-expanded="false"
        aria-controls="js-sb"
      >
        <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" aria-hidden="true">
          <path d="M2 4.5h12M2 8h12M2 11.5h12"/>
        </svg>
      </button>

      <nav class="bc" aria-label="Breadcrumb">
        <span class="bc-root"><?= htmlspecialchars(APP_NAME) ?></span>
        <span class="bc-sep" aria-hidden="true">›</span>
        <span class="bc-page">Panel Administrator</span>
      </nav>

      <div class="tb-search" role="search">
        <svg class="tb-si" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" aria-hidden="true">
          <circle cx="7" cy="7" r="4.5"/><path d="M10.5 10.5L14 14"/>
        </svg>
        <input type="text" placeholder="Cari menu…" aria-label="Cari menu" id="js-search">
        <span class="tb-kbd" aria-hidden="true">⌘K</span>
      </div>

      <div class="tb-actions" role="toolbar" aria-label="Aksi topbar">

        <button class="btn-icon" aria-label="Notifikasi" title="Notifikasi">
          <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M8 1.5A4.5 4.5 0 0112.5 6c0 3 1 3.5 1 5h-11c0-1.5 1-2 1-5A4.5 4.5 0 018 1.5z"/>
            <path d="M6.5 12.5a1.5 1.5 0 003 0"/>
          </svg>
          <span class="ndot" aria-hidden="true"></span>
        </button>

        <a href="<?= BASE_URL ?>/" class="btn-icon" aria-label="Lihat situs" title="Lihat situs publik" target="_blank">
          <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <circle cx="8" cy="8" r="6.5"/>
            <path d="M8 1.5c-2 2-3 4-3 6.5s1 4.5 3 6.5M8 1.5c2 2 3 4 3 6.5s-1 4.5-3 6.5M1.5 8h13"/>
          </svg>
        </a>

        <div class="chip-ok" role="status" aria-live="polite" aria-label="Status sistem">
          <span class="chip-dot" aria-hidden="true"></span>
          <span>Aktif</span>
        </div>

        <?php
          $uname2 = $_SESSION['user_name'] ?? 'Administrator';
          $ini2   = '';
          foreach (explode(' ', $uname2) as $w) {
            $ini2 .= mb_strtoupper(mb_substr($w, 0, 1));
            if (strlen($ini2) >= 2) break;
          }
        ?>
        <div class="tb-av" role="button" tabindex="0" aria-label="Profil admin" title="<?= htmlspecialchars($uname2) ?>">
          <?= htmlspecialchars($ini2 ?: 'A') ?>
        </div>

      </div>
    </header>

    <!-- Flash message -->
    <?php if (!empty($flash)): ?>
    <div class="flash-wrap" role="alert" aria-live="assertive">
      <?php
        $ft = $flash['type'] ?? 'info';
        $ficons = [
          'success' => '<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" aria-hidden="true"><circle cx="8" cy="8" r="6"/><path d="M5.5 8l2 2 3-3"/></svg>',
          'error'   => '<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" aria-hidden="true"><circle cx="8" cy="8" r="6"/><line x1="5.5" y1="5.5" x2="10.5" y2="10.5"/><line x1="10.5" y1="5.5" x2="5.5" y2="10.5"/></svg>',
          'danger'  => '<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" aria-hidden="true"><circle cx="8" cy="8" r="6"/><line x1="5.5" y1="5.5" x2="10.5" y2="10.5"/><line x1="10.5" y1="5.5" x2="5.5" y2="10.5"/></svg>',
          'warning' => '<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" aria-hidden="true"><path d="M8 2L14.5 13H1.5L8 2z"/><path d="M8 6v4M8 11.5v.5"/></svg>',
          'info'    => '<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" aria-hidden="true"><circle cx="8" cy="8" r="6"/><path d="M8 7v5M8 5.5v.5"/></svg>',
        ];
        $fcls = ['success'=>'alert-s','error'=>'alert-e','danger'=>'alert-e','warning'=>'alert-w','info'=>'alert-i'];
      ?>
      <div class="alert <?= $fcls[$ft] ?? 'alert-i' ?>" id="js-flash">
        <?= $ficons[$ft] ?? $ficons['info'] ?>
        <span class="alert-msg"><?= htmlspecialchars($flash['msg'] ?? '') ?></span>
        <button class="alert-x" onclick="dismissFlash()" aria-label="Tutup">&times;</button>
      </div>
    </div>
    <?php endif; ?>

    <!-- Page content -->
    <main class="pg" id="main-content" tabindex="-1">
      <?= $content ?>
    </main>

  </div><!-- /.main -->

</div><!-- /.shell -->

<script>
(function(){
  'use strict';
  var sb  = document.getElementById('js-sb');
  var bd  = document.getElementById('js-bd');
  var mb  = document.getElementById('js-mbtn');

  function sbOpen(){
    sb.classList.add('on');
    bd.classList.add('on');
    document.body.style.overflow = 'hidden';
    if(mb) mb.setAttribute('aria-expanded','true');
  }
  function sbClose(){
    sb.classList.remove('on');
    bd.classList.remove('on');
    document.body.style.overflow = '';
    if(mb) mb.setAttribute('aria-expanded','false');
  }
  window.sbClose  = sbClose;
  window.sbToggle = function(){ sb.classList.contains('on') ? sbClose() : sbOpen(); };

  sb.querySelectorAll('.ni:not([target="_blank"])').forEach(function(el){
    el.addEventListener('click', function(){ if(window.innerWidth < 768) sbClose(); });
  });

  document.addEventListener('keydown', function(e){
    if(e.key === 'Escape' && sb.classList.contains('on')) sbClose();
    if((e.metaKey||e.ctrlKey) && e.key === 'k'){
      e.preventDefault();
      var s = document.getElementById('js-search');
      if(s) s.focus();
    }
  });

  window.matchMedia('(min-width:768px)').addEventListener('change', function(e){
    if(e.matches){ sb.classList.remove('on'); bd.classList.remove('on'); document.body.style.overflow=''; }
  });

  /* Flash */
  var fl = document.getElementById('js-flash');
  window.dismissFlash = function(){
    if(!fl) return;
    fl.style.transition = 'opacity 200ms ease, transform 200ms ease';
    fl.style.opacity = '0';
    fl.style.transform = 'translateY(-4px)';
    setTimeout(function(){ fl && fl.remove(); }, 210);
  };
  if(fl) setTimeout(window.dismissFlash, 5000);

  /* Simple nav search highlight */
  var searchEl = document.getElementById('js-search');
  if(searchEl){
    searchEl.addEventListener('input', function(){
      var q = this.value.trim().toLowerCase();
      sb.querySelectorAll('.ni').forEach(function(el){
        if(!q){ el.style.display=''; return; }
        var lbl = el.querySelector('.ni-label');
        el.style.display = (lbl && lbl.textContent.toLowerCase().includes(q)) ? '' : 'none';
      });
      sb.querySelectorAll('.nav-sec').forEach(function(sec){
        var visible = Array.from(sec.querySelectorAll('.ni')).some(function(el){ return el.style.display !== 'none'; });
        sec.style.display = (!q || visible) ? '' : 'none';
      });
    });
  }

}());
</script>
<script src="<?= BASE_URL ?>/assets/js/main.js"></script>
</body>
</html>