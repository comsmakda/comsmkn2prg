<!DOCTYPE html>
<html lang="id" dir="ltr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="noindex, nofollow">
  <title>Admin Panel &mdash; <?= htmlspecialchars(APP_NAME) ?></title>

  <!-- Preconnect -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/custom.css">

  <style>
/* ==========================================================================
   RESET
   ========================================================================== */
*, *::before, *::after {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

/* ==========================================================================
   DESIGN TOKENS
   ========================================================================== */
:root {
  --sidebar-w:    260px;
  --topbar-h:     56px;

  /* Backgrounds */
  --bg-base:      #080c12;
  --bg-surface:   #0d1117;
  --bg-elevated:  #131b27;
  --bg-overlay:   #1a2333;
  --bg-hover:     rgba(255,255,255,0.04);
  --bg-active:    rgba(88,150,255,0.09);

  /* Borders */
  --bd-subtle:    rgba(255,255,255,0.055);
  --bd-default:   rgba(255,255,255,0.09);
  --bd-strong:    rgba(255,255,255,0.15);
  --bd-accent:    rgba(88,150,255,0.30);

  /* Text */
  --tx-primary:   #e6edf3;
  --tx-secondary: #7d8fa8;
  --tx-muted:     #3d4d60;

  /* Accent */
  --ac:           #5896ff;
  --ac-hover:     #74aaff;
  --ac-dim:       rgba(88,150,255,0.10);

  /* Semantic — Success */
  --ok:           #3fb950;
  --ok-dim:       rgba(63,185,80,0.10);
  --ok-bd:        rgba(63,185,80,0.25);

  /* Semantic — Danger */
  --er:           #f85149;
  --er-dim:       rgba(248,81,73,0.10);
  --er-bd:        rgba(248,81,73,0.25);

  /* Semantic — Warning */
  --wa:           #e3b341;
  --wa-dim:       rgba(227,179,65,0.10);
  --wa-bd:        rgba(227,179,65,0.25);

  /* Semantic — Info */
  --in:           #58a6ff;
  --in-dim:       rgba(88,166,255,0.10);
  --in-bd:        rgba(88,166,255,0.25);

  /* Shape */
  --r-xs:         4px;
  --r-sm:         6px;
  --r-md:         8px;
  --r-lg:         12px;

  /* Type */
  --font:         'Sora', system-ui, -apple-system, sans-serif;
  --font-mono:    'SFMono-Regular', Consolas, monospace;

  /* Motion */
  --ease:         cubic-bezier(0.16, 1, 0.3, 1);
  --t-fast:       120ms;
  --t-base:       200ms;
  --t-slow:       300ms;
}

/* ==========================================================================
   BASE
   ========================================================================== */
html, body { height: 100%; }

body {
  font-family:             var(--font);
  background:              var(--bg-base);
  color:                   var(--tx-primary);
  font-size:               13.5px;
  line-height:             1.6;
  -webkit-font-smoothing:  antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-rendering:          optimizeLegibility;
}

a    { color: inherit; text-decoration: none; }
button { font-family: inherit; cursor: pointer; }
svg  { display: block; }

::-webkit-scrollbar       { width: 4px; height: 4px; }
::-webkit-scrollbar-track { background: transparent; }
::-webkit-scrollbar-thumb { background: var(--bd-default); border-radius: 99px; }
::-webkit-scrollbar-thumb:hover { background: var(--bd-strong); }

:focus-visible { outline: 2px solid var(--ac); outline-offset: 2px; }

/* ==========================================================================
   APP SHELL
   ========================================================================== */
.app-shell {
  display:  flex;
  height:   100vh;
  overflow: hidden;
}

/* ==========================================================================
   BACKDROP — mobile overlay
   ========================================================================== */
.backdrop {
  display:    none;
  position:   fixed;
  inset:      0;
  z-index:    35;
  background: rgba(8,12,18,0.78);
  backdrop-filter: blur(4px);
  -webkit-backdrop-filter: blur(4px);
}
.backdrop.is-visible {
  display: block;
  animation: bd-in var(--t-base) var(--ease) both;
}
@keyframes bd-in { from { opacity: 0; } to { opacity: 1; } }

/* ==========================================================================
   SIDEBAR
   ========================================================================== */
.sidebar {
  position:       fixed;
  inset-block:    0;
  left:           0;
  z-index:        40;
  width:          var(--sidebar-w);
  height:         100%;
  display:        flex;
  flex-direction: column;
  background:     var(--bg-surface);
  border-right:   1px solid var(--bd-subtle);
  transform:      translateX(-100%);
  transition:     transform var(--t-slow) var(--ease),
                  box-shadow var(--t-slow) var(--ease);
  will-change:    transform;
  overflow:       hidden;
}
@media (min-width: 768px) {
  .sidebar { transform: translateX(0) !important; box-shadow: none !important; }
}
.sidebar.is-open {
  transform:  translateX(0);
  box-shadow: 24px 0 80px rgba(0,0,0,0.55);
}

/* ── Brand ── */
.sidebar__brand {
  display:       flex;
  align-items:   center;
  gap:           10px;
  height:        var(--topbar-h);
  padding:       0 16px;
  border-bottom: 1px solid var(--bd-subtle);
  flex-shrink:   0;
  user-select:   none;
}

.sidebar__logo {
  height:      26px;
  width:       auto;
  object-fit:  contain;
  flex-shrink: 0;
}

.sidebar__appname {
  flex:           1;
  font-size:      13.5px;
  font-weight:    700;
  letter-spacing: -0.025em;
  color:          var(--tx-primary);
  white-space:    nowrap;
  overflow:       hidden;
  text-overflow:  ellipsis;
}

.sidebar__tag {
  font-family:    var(--font-mono);
  font-size:      9px;
  font-weight:    700;
  letter-spacing: 0.1em;
  text-transform: uppercase;
  color:          var(--ac);
  background:     var(--ac-dim);
  border:         1px solid var(--bd-accent);
  border-radius:  var(--r-xs);
  padding:        2px 7px;
  flex-shrink:    0;
}

/* ── Nav ── */
.sidebar__nav {
  flex:           1;
  overflow-y:     auto;
  padding:        8px;
  display:        flex;
  flex-direction: column;
  gap:            1px;
}

.nav-group__label {
  font-size:      9px;
  font-weight:    700;
  letter-spacing: 0.14em;
  text-transform: uppercase;
  color:          var(--tx-muted);
  padding:        10px 10px 4px;
  margin-top:     4px;
}

.nav-item {
  position:      relative;
  display:       flex;
  align-items:   center;
  gap:           9px;
  padding:       8px 10px;
  border-radius: var(--r-md);
  font-size:     13px;
  font-weight:   500;
  color:         var(--tx-secondary);
  border:        1px solid transparent;
  transition:
    color        var(--t-fast) var(--ease),
    background   var(--t-fast) var(--ease),
    border-color var(--t-fast) var(--ease);
}

.nav-item:hover {
  color:        var(--tx-primary);
  background:   var(--bg-hover);
  border-color: var(--bd-subtle);
}

.nav-item.is-active {
  color:        var(--ac-hover);
  background:   var(--bg-active);
  border-color: var(--bd-accent);
}

.nav-item.is-active::before {
  content:      '';
  position:     absolute;
  left:         0;
  top:          50%;
  transform:    translateY(-50%);
  width:        3px;
  height:       14px;
  background:   var(--ac);
  border-radius: 0 3px 3px 0;
}

.nav-item__icon {
  width:      15px;
  height:     15px;
  flex-shrink: 0;
  opacity:     0.5;
  transition:  opacity var(--t-fast) var(--ease);
}
.nav-item:hover .nav-item__icon,
.nav-item.is-active .nav-item__icon { opacity: 1; }

.nav-item__label { flex: 1; line-height: 1; }

/* ── Divider ── */
.nav-divider {
  height:     1px;
  background: var(--bd-subtle);
  margin:     4px 2px;
}

/* ── Footer ── */
.sidebar__footer {
  padding:      8px;
  border-top:   1px solid var(--bd-subtle);
  flex-shrink:  0;
}

.user-card {
  display:       flex;
  align-items:   center;
  gap:           9px;
  padding:       8px 10px;
  border-radius: var(--r-md);
  background:    var(--bg-elevated);
  border:        1px solid var(--bd-subtle);
  transition:    border-color var(--t-fast) var(--ease);
}
.user-card:hover { border-color: var(--bd-default); }

.user-card__av {
  width:          30px;
  height:         30px;
  border-radius:  50%;
  background:     var(--ac-dim);
  border:         1px solid var(--bd-accent);
  display:        flex;
  align-items:    center;
  justify-content: center;
  flex-shrink:    0;
  color:          var(--ac);
}
.user-card__av svg { width: 14px; height: 14px; }

.user-card__info { flex: 1; min-width: 0; }

.user-card__name {
  font-size:      12.5px;
  font-weight:    600;
  color:          var(--tx-primary);
  white-space:    nowrap;
  overflow:       hidden;
  text-overflow:  ellipsis;
  letter-spacing: -0.01em;
  line-height:    1.2;
}

.user-card__role {
  font-size:  10.5px;
  color:      var(--tx-muted);
  margin-top: 1px;
}

.btn-logout {
  display:        flex;
  align-items:    center;
  justify-content: center;
  width:          27px;
  height:         27px;
  border-radius:  var(--r-sm);
  background:     transparent;
  border:         1px solid transparent;
  color:          var(--tx-muted);
  transition:
    background   var(--t-fast) var(--ease),
    border-color var(--t-fast) var(--ease),
    color        var(--t-fast) var(--ease);
  flex-shrink: 0;
}
.btn-logout:hover {
  background:   var(--er-dim);
  border-color: var(--er-bd);
  color:        var(--er);
}
.btn-logout svg { width: 13px; height: 13px; }

/* ==========================================================================
   MAIN AREA
   ========================================================================== */
.main-area {
  flex:           1;
  display:        flex;
  flex-direction: column;
  overflow:       hidden;
  min-width:      0;
  margin-left:    0;
}
@media (min-width: 768px) {
  .main-area { margin-left: var(--sidebar-w); }
}

/* ==========================================================================
   TOPBAR
   ========================================================================== */
.topbar {
  height:        var(--topbar-h);
  display:       flex;
  align-items:   center;
  gap:           12px;
  padding:       0 20px;
  background:    var(--bg-surface);
  border-bottom: 1px solid var(--bd-subtle);
  flex-shrink:   0;
  position:      sticky;
  top:           0;
  z-index:       20;
}

/* Hamburger */
.btn-menu {
  display:        flex;
  align-items:    center;
  justify-content: center;
  width:          32px;
  height:         32px;
  border-radius:  var(--r-sm);
  background:     transparent;
  border:         1px solid var(--bd-default);
  color:          var(--tx-secondary);
  transition:
    background var(--t-fast) var(--ease),
    color      var(--t-fast) var(--ease);
  flex-shrink: 0;
}
.btn-menu:hover { background: var(--bg-hover); color: var(--tx-primary); }
.btn-menu svg   { width: 14px; height: 14px; }
@media (min-width: 768px) { .btn-menu { display: none; } }

/* Breadcrumb */
.breadcrumb {
  display:     flex;
  align-items: center;
  gap:         6px;
  font-size:   12.5px;
}
.breadcrumb__root { color: var(--tx-muted); font-weight: 500; }
.breadcrumb__sep  { color: var(--tx-muted); opacity: 0.3; font-size: 13px; }
.breadcrumb__page { color: var(--tx-secondary); font-weight: 600; }
@media (max-width: 767px) { .breadcrumb { display: none; } }

/* Right toolbar */
.topbar__actions {
  margin-left: auto;
  display:     flex;
  align-items: center;
  gap:         6px;
}

/* Icon button */
.btn-icon {
  position:        relative;
  display:         flex;
  align-items:     center;
  justify-content: center;
  width:           32px;
  height:          32px;
  border-radius:   var(--r-sm);
  background:      transparent;
  border:          1px solid var(--bd-default);
  color:           var(--tx-secondary);
  transition:
    background var(--t-fast) var(--ease),
    color      var(--t-fast) var(--ease);
}
.btn-icon:hover  { background: var(--bg-hover); color: var(--tx-primary); }
.btn-icon svg    { width: 14px; height: 14px; }

.notif-dot {
  position:      absolute;
  top:           6px;
  right:         6px;
  width:         5px;
  height:        5px;
  border-radius: 50%;
  background:    var(--er);
  border:        1.5px solid var(--bg-surface);
}

/* Status chip */
.chip-status {
  display:        flex;
  align-items:    center;
  gap:            6px;
  padding:        4px 10px;
  border-radius:  var(--r-sm);
  background:     var(--bg-elevated);
  border:         1px solid var(--bd-subtle);
  font-size:      11.5px;
  font-weight:    600;
  color:          var(--tx-secondary);
  letter-spacing: 0.01em;
  user-select:    none;
}
.chip-status__dot {
  width:        5px;
  height:       5px;
  border-radius: 50%;
  background:   var(--ok);
  animation:    pulse-dot 2.6s ease infinite;
}
@keyframes pulse-dot {
  0%, 100% { opacity: 1; }
  50%       { opacity: 0.45; }
}

/* ==========================================================================
   FLASH ALERT
   ========================================================================== */
.flash-region { padding: 16px 20px 0; }

.alert {
  display:       flex;
  align-items:   flex-start;
  gap:           10px;
  padding:       11px 14px;
  border-radius: var(--r-md);
  font-size:     13px;
  font-weight:   500;
  border:        1px solid;
  line-height:   1.5;
}
.alert__icon    { width: 14px; height: 14px; flex-shrink: 0; margin-top: 2px; }
.alert__message { flex: 1; }
.alert__close {
  background: none;
  border:     none;
  font-size:  18px;
  line-height: 1;
  color:      inherit;
  opacity:    0.45;
  padding:    0;
  transition: opacity var(--t-fast) var(--ease);
  flex-shrink: 0;
}
.alert__close:hover { opacity: 1; }

.alert--success { background: var(--ok-dim); border-color: var(--ok-bd); color: #56d364; }
.alert--error,
.alert--danger  { background: var(--er-dim); border-color: var(--er-bd); color: #ff7b72; }
.alert--warning { background: var(--wa-dim); border-color: var(--wa-bd); color: var(--wa); }
.alert--info    { background: var(--in-dim); border-color: var(--in-bd); color: var(--in); }

/* ==========================================================================
   PAGE CONTENT
   ========================================================================== */
.page-content {
  flex:       1;
  overflow-y: auto;
  padding:    24px 20px;
}

@media (max-width: 480px) {
  .topbar       { padding: 0 14px; gap: 10px; }
  .flash-region { padding: 12px 14px 0; }
  .page-content { padding: 16px 14px; }
}
  </style>
</head>
<body>

<div class="app-shell">

  <!-- Backdrop -->
  <div class="backdrop" id="js-backdrop" onclick="closeSidebar()" aria-hidden="true"></div>

  <!-- ════════════════════════════════════════════
       SIDEBAR
  ════════════════════════════════════════════ -->
  <aside class="sidebar" id="js-sidebar" role="navigation" aria-label="Navigasi utama">

    <!-- Brand -->
    <div class="sidebar__brand">
      <img
        class="sidebar__logo"
        src="<?= BASE_URL ?>/assets/img/logo-com.png"
        alt="Logo <?= htmlspecialchars(APP_NAME) ?>"
        loading="eager"
        decoding="sync"
      >
      <span class="sidebar__appname"><?= htmlspecialchars(APP_NAME) ?></span>
      <span class="sidebar__tag">Admin</span>
    </div>

    <!-- Nav -->
    <nav class="sidebar__nav" aria-label="Menu">
      <?php
        $current = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

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
          'Sistem' => [
            [
              'href'  => '/admin/settings',
              'label' => 'Pengaturan & CMS',
              'icon'  => '<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="8" r="2.25"/><path d="M8 1.5v1.5M8 13v1.5M1.5 8H3M13 8h1.5M3.4 3.4l1.05 1.05M11.55 11.55l1.05 1.05M3.4 12.6l1.05-1.05M11.55 4.45l1.05-1.05"/></svg>',
            ],
          ],
        ];

        foreach ($navGroups as $group => $items):
      ?>
        <span class="nav-group__label"><?= htmlspecialchars($group) ?></span>
        <?php foreach ($items as $item):
          $active = str_starts_with($current, $item['href']);
          $cls    = $active ? ' is-active' : '';
          $aria   = $active ? ' aria-current="page"' : '';
        ?>
        <a
          href="<?= BASE_URL . htmlspecialchars($item['href']) ?>"
          class="nav-item<?= $cls ?>"<?= $aria ?>
        >
          <span class="nav-item__icon" aria-hidden="true"><?= $item['icon'] ?></span>
          <span class="nav-item__label"><?= htmlspecialchars($item['label']) ?></span>
        </a>
        <?php endforeach; ?>
        <div class="nav-divider" role="separator"></div>
      <?php endforeach; ?>
    </nav>

    <!-- User / Footer -->
    <div class="sidebar__footer">
      <div class="user-card">
        <div class="user-card__av" aria-hidden="true">
          <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="8" cy="5.5" r="2.5"/>
            <path d="M2.5 14c0-3.038 2.462-5.5 5.5-5.5s5.5 2.462 5.5 5.5"/>
          </svg>
        </div>
        <div class="user-card__info">
          <div class="user-card__name"><?= htmlspecialchars($_SESSION['user_name'] ?? 'Administrator') ?></div>
          <div class="user-card__role">Administrator</div>
        </div>
        <a
          href="<?= BASE_URL ?>/logout"
          class="btn-logout"
          title="Keluar dari sistem"
          aria-label="Logout"
        >
          <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M6 2H3.5A1.5 1.5 0 002 3.5v9A1.5 1.5 0 003.5 14H6"/>
            <path d="M10.5 11l3-3-3-3M13.5 8H6"/>
          </svg>
        </a>
      </div>
    </div>

  </aside>

  <!-- ════════════════════════════════════════════
       MAIN AREA
  ════════════════════════════════════════════ -->
  <div class="main-area" id="js-main">

    <!-- Topbar -->
    <header class="topbar" role="banner">

      <button
        class="btn-menu"
        id="js-menu-btn"
        onclick="toggleSidebar()"
        aria-label="Buka menu navigasi"
        aria-expanded="false"
        aria-controls="js-sidebar"
      >
        <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" aria-hidden="true">
          <path d="M2 4.5h12M2 8h12M2 11.5h12"/>
        </svg>
      </button>

      <nav class="breadcrumb" aria-label="Lokasi halaman">
        <span class="breadcrumb__root"><?= htmlspecialchars(APP_NAME) ?></span>
        <span class="breadcrumb__sep" aria-hidden="true">/</span>
        <span class="breadcrumb__page">Panel Administrator</span>
      </nav>

      <div class="topbar__actions" role="toolbar" aria-label="Aksi">

        <button class="btn-icon" aria-label="Notifikasi" title="Notifikasi">
          <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M8 1.5A4.5 4.5 0 0112.5 6c0 3 1 3.5 1 5h-11c0-1.5 1-2 1-5A4.5 4.5 0 018 1.5z"/>
            <path d="M6.5 12.5a1.5 1.5 0 003 0"/>
          </svg>
          <span class="notif-dot" aria-hidden="true"></span>
        </button>

        <div class="chip-status" role="status" aria-live="polite" aria-label="Status sistem">
          <span class="chip-status__dot" aria-hidden="true"></span>
          <span>Sistem Aktif</span>
        </div>

      </div>
    </header>

    <!-- Flash -->
    <?php if (!empty($flash)): ?>
    <div class="flash-region" role="alert" aria-live="assertive">
      <?php
        $type = $flash['type'] ?? 'info';
        $icons = [
          'success' => '<svg class="alert__icon" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="8" cy="8" r="6"/><path d="M5.5 8l2 2 3-3"/></svg>',
          'error'   => '<svg class="alert__icon" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="8" cy="8" r="6"/><line x1="5.5" y1="5.5" x2="10.5" y2="10.5"/><line x1="10.5" y1="5.5" x2="5.5" y2="10.5"/></svg>',
          'danger'  => '<svg class="alert__icon" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="8" cy="8" r="6"/><line x1="5.5" y1="5.5" x2="10.5" y2="10.5"/><line x1="10.5" y1="5.5" x2="5.5" y2="10.5"/></svg>',
          'warning' => '<svg class="alert__icon" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M8 2L14.5 13H1.5L8 2z"/><path d="M8 6v4M8 11.5v.5"/></svg>',
          'info'    => '<svg class="alert__icon" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="8" cy="8" r="6"/><path d="M8 7v5M8 5.5v.5"/></svg>',
        ];
        $icon = $icons[$type] ?? $icons['info'];
      ?>
      <div class="alert alert--<?= htmlspecialchars($type) ?>" id="js-flash">
        <?= $icon ?>
        <span class="alert__message"><?= htmlspecialchars($flash['msg'] ?? '') ?></span>
        <button class="alert__close" onclick="dismissFlash()" aria-label="Tutup notifikasi">&times;</button>
      </div>
    </div>
    <?php endif; ?>

    <!-- Content -->
    <main class="page-content" id="main-content" tabindex="-1">
      <?= $content ?>
    </main>

  </div>

</div>

<script>
(function () {
  'use strict';

  var sidebar  = document.getElementById('js-sidebar');
  var backdrop = document.getElementById('js-backdrop');
  var menuBtn  = document.getElementById('js-menu-btn');

  function openSidebar() {
    sidebar.classList.add('is-open');
    backdrop.classList.add('is-visible');
    document.body.style.overflow = 'hidden';
    if (menuBtn) menuBtn.setAttribute('aria-expanded', 'true');
  }

  function closeSidebar() {
    sidebar.classList.remove('is-open');
    backdrop.classList.remove('is-visible');
    document.body.style.overflow = '';
    if (menuBtn) menuBtn.setAttribute('aria-expanded', 'false');
  }

  window.closeSidebar = closeSidebar;

  window.toggleSidebar = function () {
    sidebar.classList.contains('is-open') ? closeSidebar() : openSidebar();
  };

  // Close on nav click (mobile)
  sidebar.querySelectorAll('.nav-item').forEach(function (el) {
    el.addEventListener('click', function () {
      if (window.innerWidth < 768) closeSidebar();
    });
  });

  // Close on Escape
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && sidebar.classList.contains('is-open')) closeSidebar();
  });

  // Restore on resize
  window.matchMedia('(min-width: 768px)').addEventListener('change', function (e) {
    if (e.matches) {
      sidebar.classList.remove('is-open');
      backdrop.classList.remove('is-visible');
      document.body.style.overflow = '';
    }
  });

  // Flash dismiss
  var flashEl = document.getElementById('js-flash');

  window.dismissFlash = function () {
    if (!flashEl) return;
    flashEl.style.transition = 'opacity 220ms ease, transform 220ms ease';
    flashEl.style.opacity    = '0';
    flashEl.style.transform  = 'translateY(-5px)';
    setTimeout(function () { flashEl && flashEl.remove(); }, 240);
  };

  if (flashEl) setTimeout(window.dismissFlash, 5500);

}());
</script>
<script src="<?= BASE_URL ?>/assets/js/main.js"></script>
</body>
</html>