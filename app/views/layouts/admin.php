<!DOCTYPE html>
<html lang="id" dir="ltr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="noindex, nofollow">
  <title>Admin Panel &mdash; <?= htmlspecialchars(APP_NAME) ?></title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/custom.css">

  <style>
/* ==========================================================================
   RESET
   ========================================================================== */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

/* ==========================================================================
   DESIGN TOKENS
   ========================================================================== */
:root {
  --sidebar-w:  248px;
  --topbar-h:   60px;

  /* Surfaces */
  --bg-canvas:  #070b13;
  --bg-surface: #0b1120;
  --bg-raised:  #0f1929;
  --bg-overlay: #152035;
  --bg-hover:   rgba(255,255,255,0.035);
  --bg-active:  rgba(99,161,255,0.08);

  /* Borders */
  --bd-faint:   rgba(255,255,255,0.04);
  --bd-subtle:  rgba(255,255,255,0.07);
  --bd-default: rgba(255,255,255,0.11);
  --bd-strong:  rgba(255,255,255,0.18);
  --bd-accent:  rgba(99,161,255,0.28);

  /* Text */
  --tx-primary:   #dce8f5;
  --tx-secondary: #6b829e;
  --tx-muted:     #2e3f55;
  --tx-hint:      #1c2a3a;

  /* Accent — electric blue */
  --ac:        #63a1ff;
  --ac-bright: #85b8ff;
  --ac-dim:    rgba(99,161,255,0.09);
  --ac-glow:   rgba(99,161,255,0.15);

  /* Semantic */
  --ok:     #34d399;
  --ok-dim: rgba(52,211,153,0.08);
  --ok-bd:  rgba(52,211,153,0.22);

  --er:     #f87171;
  --er-dim: rgba(248,113,113,0.08);
  --er-bd:  rgba(248,113,113,0.22);

  --wa:     #fbbf24;
  --wa-dim: rgba(251,191,36,0.08);
  --wa-bd:  rgba(251,191,36,0.22);

  --in:     #60a5fa;
  --in-dim: rgba(96,165,250,0.08);
  --in-bd:  rgba(96,165,250,0.22);

  /* Radius */
  --r-xs: 4px;
  --r-sm: 6px;
  --r-md: 9px;
  --r-lg: 13px;
  --r-xl: 18px;

  /* Typography */
  --font:      'DM Sans', system-ui, sans-serif;
  --font-mono: 'DM Mono', 'SFMono-Regular', Consolas, monospace;

  /* Motion */
  --ease:   cubic-bezier(0.22, 1, 0.36, 1);
  --t-fast: 110ms;
  --t-base: 200ms;
  --t-slow: 320ms;
}

/* ==========================================================================
   BASE
   ========================================================================== */
html, body { height: 100%; }

body {
  font-family:             var(--font);
  background:              var(--bg-canvas);
  color:                   var(--tx-primary);
  font-size:               13.5px;
  line-height:             1.6;
  -webkit-font-smoothing:  antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-rendering:          optimizeLegibility;
}

a      { color: inherit; text-decoration: none; }
button { font-family: inherit; cursor: pointer; }
svg    { display: block; }

::-webkit-scrollbar       { width: 3px; height: 3px; }
::-webkit-scrollbar-track { background: transparent; }
::-webkit-scrollbar-thumb { background: var(--bd-subtle); border-radius: 99px; }
::-webkit-scrollbar-thumb:hover { background: var(--bd-default); }

:focus-visible {
  outline:        2px solid var(--ac);
  outline-offset: 2px;
  border-radius:  var(--r-xs);
}

/* ==========================================================================
   APP SHELL
   ========================================================================== */
.app-shell {
  display:  flex;
  height:   100vh;
  overflow: hidden;
}

/* Subtle grid texture */
.app-shell::before {
  content:    '';
  position:   fixed;
  inset:      0;
  z-index:    0;
  pointer-events: none;
  background-image:
    linear-gradient(rgba(99,161,255,0.022) 1px, transparent 1px),
    linear-gradient(90deg, rgba(99,161,255,0.022) 1px, transparent 1px);
  background-size: 40px 40px;
  mask-image: radial-gradient(ellipse 80% 60% at 50% 0%, black 30%, transparent 100%);
}

/* ==========================================================================
   BACKDROP
   ========================================================================== */
.backdrop {
  display:    none;
  position:   fixed;
  inset:      0;
  z-index:    35;
  background: rgba(7,11,19,0.82);
  backdrop-filter: blur(6px);
  -webkit-backdrop-filter: blur(6px);
}
.backdrop.is-visible {
  display:   block;
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
  border-right:   1px solid var(--bd-faint);
  transform:      translateX(-100%);
  transition:
    transform  var(--t-slow) var(--ease),
    box-shadow var(--t-slow) var(--ease);
  will-change: transform;
  overflow:    hidden;
}

/* Top ambient glow */
.sidebar::after {
  content:    '';
  position:   absolute;
  top: 0; left: 0; right: 0;
  height:     200px;
  background: radial-gradient(ellipse 100% 100% at 50% -10%, rgba(99,161,255,0.07) 0%, transparent 100%);
  pointer-events: none;
  z-index:    0;
}

@media (min-width: 768px) {
  .sidebar { transform: translateX(0) !important; box-shadow: none !important; }
}
.sidebar.is-open {
  transform:  translateX(0);
  box-shadow: 32px 0 80px rgba(0,0,0,0.6);
}

/* ── Brand ── */
.sidebar__brand {
  display:       flex;
  align-items:   center;
  gap:           10px;
  height:        var(--topbar-h);
  padding:       0 16px;
  border-bottom: 1px solid var(--bd-faint);
  flex-shrink:   0;
  user-select:   none;
  position:      relative;
  z-index:       1;
}

.sidebar__logo-wrap {
  width:           32px;
  height:          32px;
  border-radius:   var(--r-md);
  background:      var(--ac-dim);
  border:          1px solid var(--bd-accent);
  display:         flex;
  align-items:     center;
  justify-content: center;
  flex-shrink:     0;
  box-shadow:      0 0 0 4px var(--ac-glow);
  overflow:        hidden;
}

.sidebar__logo {
  width:      100%;
  height:     100%;
  object-fit: contain;
  display:    block;
}

.sidebar__logo-icon {
  width:  16px;
  height: 16px;
  color:  var(--ac-bright);
}

.sidebar__appname {
  flex:           1;
  font-size:      13.5px;
  font-weight:    700;
  letter-spacing: -0.03em;
  color:          var(--tx-primary);
  white-space:    nowrap;
  overflow:       hidden;
  text-overflow:  ellipsis;
}

.sidebar__tag {
  font-family:    var(--font-mono);
  font-size:      9px;
  font-weight:    500;
  letter-spacing: 0.08em;
  text-transform: uppercase;
  color:          var(--ac);
  background:     var(--ac-dim);
  border:         1px solid var(--bd-accent);
  border-radius:  var(--r-xs);
  padding:        2px 8px;
  flex-shrink:    0;
}

/* ── Nav ── */
.sidebar__nav {
  flex:           1;
  overflow-y:     auto;
  padding:        10px;
  display:        flex;
  flex-direction: column;
  gap:            1px;
  position:       relative;
  z-index:        1;
}

.nav-section { margin-bottom: 2px; }

.nav-section + .nav-section {
  margin-top:  8px;
  padding-top: 8px;
  border-top:  1px solid var(--bd-faint);
}

.nav-group__label {
  font-size:      9.5px;
  font-weight:    600;
  letter-spacing: 0.12em;
  text-transform: uppercase;
  color:          var(--tx-muted);
  padding:        6px 10px 5px;
  display:        block;
}

.nav-item {
  position:      relative;
  display:       flex;
  align-items:   center;
  gap:           10px;
  padding:       8.5px 10px;
  border-radius: var(--r-md);
  font-size:     13px;
  font-weight:   500;
  color:         var(--tx-secondary);
  transition:
    color      var(--t-fast) var(--ease),
    background var(--t-fast) var(--ease);
  user-select: none;
}

.nav-item:hover {
  color:      var(--tx-primary);
  background: var(--bg-hover);
}

.nav-item.is-active {
  color:      var(--ac-bright);
  background: var(--bg-active);
}

/* Active indicator */
.nav-item.is-active::before {
  content:       '';
  position:      absolute;
  left:          0;
  top:           50%;
  transform:     translateY(-50%);
  width:         2.5px;
  height:        16px;
  background:    linear-gradient(180deg, var(--ac-bright), var(--ac));
  border-radius: 0 2px 2px 0;
}

.nav-item__icon {
  width:       16px;
  height:      16px;
  flex-shrink: 0;
  color:       var(--tx-muted);
  transition:  color var(--t-fast) var(--ease);
}
.nav-item:hover .nav-item__icon     { color: var(--tx-secondary); }
.nav-item.is-active .nav-item__icon { color: var(--ac); }

.nav-item__label { flex: 1; line-height: 1.2; }

/* ── Nav item badge (e.g. "SSO") ── */
.nav-item__badge {
  font-family:    var(--font-mono);
  font-size:      8.5px;
  font-weight:    500;
  letter-spacing: 0.07em;
  text-transform: uppercase;
  color:          var(--wa);
  background:     var(--wa-dim);
  border:         1px solid var(--wa-bd);
  border-radius:  var(--r-xs);
  padding:        1px 6px;
  flex-shrink:    0;
  line-height:    1.5;
}

/* ── Footer ── */
.sidebar__footer {
  padding:     10px;
  border-top:  1px solid var(--bd-faint);
  flex-shrink: 0;
  position:    relative;
  z-index:     1;
}

.sidebar__version {
  font-size:      10px;
  font-family:    var(--font-mono);
  color:          var(--tx-muted);
  text-align:     center;
  margin-bottom:  8px;
  letter-spacing: 0.04em;
}

.user-card {
  display:       flex;
  align-items:   center;
  gap:           10px;
  padding:       10px 11px;
  border-radius: var(--r-lg);
  background:    var(--bg-raised);
  border:        1px solid var(--bd-subtle);
  transition:
    border-color var(--t-fast) var(--ease),
    background   var(--t-fast) var(--ease);
}
.user-card:hover {
  border-color: var(--bd-default);
  background:   var(--bg-overlay);
}

.user-card__av {
  width:           34px;
  height:          34px;
  border-radius:   50%;
  background:      linear-gradient(135deg, var(--ac-dim), var(--bg-overlay));
  border:          1px solid var(--bd-accent);
  display:         flex;
  align-items:     center;
  justify-content: center;
  flex-shrink:     0;
  font-size:       12px;
  font-weight:     700;
  color:           var(--ac-bright);
  letter-spacing:  -0.02em;
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
  letter-spacing: -0.015em;
  line-height:    1.3;
}

.user-card__role {
  font-size:   10.5px;
  color:       var(--tx-muted);
  margin-top:  1px;
  font-weight: 500;
}

.btn-logout {
  display:         flex;
  align-items:     center;
  justify-content: center;
  width:           28px;
  height:          28px;
  border-radius:   var(--r-sm);
  background:      transparent;
  border:          1px solid transparent;
  color:           var(--tx-muted);
  transition:
    background   var(--t-fast) var(--ease),
    border-color var(--t-fast) var(--ease),
    color        var(--t-fast) var(--ease);
  flex-shrink:     0;
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
  position:       relative;
  z-index:        1;
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
  padding:       0 22px;
  background:    var(--bg-surface);
  border-bottom: 1px solid var(--bd-faint);
  flex-shrink:   0;
  position:      sticky;
  top:           0;
  z-index:       20;
}

/* Accent line at bottom of topbar */
.topbar::after {
  content:    '';
  position:   absolute;
  bottom:     0; left: 0; right: 0;
  height:     1px;
  background: linear-gradient(90deg,
    transparent,
    rgba(99,161,255,0.12) 25%,
    rgba(99,161,255,0.12) 75%,
    transparent
  );
  pointer-events: none;
}

.btn-menu {
  display:         flex;
  align-items:     center;
  justify-content: center;
  width:           34px;
  height:          34px;
  border-radius:   var(--r-md);
  background:      transparent;
  border:          1px solid var(--bd-subtle);
  color:           var(--tx-secondary);
  transition:
    background   var(--t-fast) var(--ease),
    border-color var(--t-fast) var(--ease),
    color        var(--t-fast) var(--ease);
  flex-shrink: 0;
}
.btn-menu:hover {
  background:   var(--bg-hover);
  border-color: var(--bd-default);
  color:        var(--tx-primary);
}
.btn-menu svg { width: 14px; height: 14px; }
@media (min-width: 768px) { .btn-menu { display: none; } }

/* ── Breadcrumb ── */
.breadcrumb {
  display:     flex;
  align-items: center;
  gap:         0;
  font-size:   12.5px;
}
.breadcrumb__root {
  color:       var(--tx-muted);
  font-weight: 500;
  font-size:   12px;
}
.breadcrumb__sep {
  color:       var(--tx-hint);
  font-size:   16px;
  margin:      0 6px;
  line-height: 1;
}
.breadcrumb__page {
  color:       var(--tx-secondary);
  font-weight: 600;
  font-size:   13px;
}
@media (max-width: 767px) { .breadcrumb { display: none; } }

/* ── Search ── */
.topbar__search {
  flex:        1;
  max-width:   300px;
  margin-left: auto;
  position:    relative;
}
.topbar__search input {
  width:         100%;
  height:        34px;
  background:    var(--bg-raised);
  border:        1px solid var(--bd-subtle);
  border-radius: var(--r-md);
  padding:       0 44px 0 34px;
  font-family:   var(--font);
  font-size:     12.5px;
  color:         var(--tx-primary);
  outline:       none;
  transition:
    border-color var(--t-fast) var(--ease),
    background   var(--t-fast) var(--ease),
    box-shadow   var(--t-fast) var(--ease);
}
.topbar__search input::placeholder { color: var(--tx-muted); }
.topbar__search input:focus {
  border-color: var(--bd-accent);
  background:   var(--bg-overlay);
  box-shadow:   0 0 0 3px var(--ac-glow);
}
.topbar__search-icon {
  position:       absolute;
  left:           10px;
  top:            50%;
  transform:      translateY(-50%);
  width:          14px;
  height:         14px;
  color:          var(--tx-muted);
  pointer-events: none;
}
.topbar__search-kbd {
  position:       absolute;
  right:          9px;
  top:            50%;
  transform:      translateY(-50%);
  font-family:    var(--font-mono);
  font-size:      9px;
  color:          var(--tx-muted);
  background:     var(--bg-canvas);
  border:         1px solid var(--bd-subtle);
  border-radius:  var(--r-xs);
  padding:        1px 5px;
  pointer-events: none;
}

/* ── Actions ── */
.topbar__actions {
  display:     flex;
  align-items: center;
  gap:         6px;
  flex-shrink: 0;
}

@media (max-width: 767px) {
  .topbar__search  { display: none; }
  .topbar__actions { margin-left: auto; }
}

.btn-icon {
  position:        relative;
  display:         flex;
  align-items:     center;
  justify-content: center;
  width:           34px;
  height:          34px;
  border-radius:   var(--r-md);
  background:      transparent;
  border:          1px solid var(--bd-subtle);
  color:           var(--tx-secondary);
  transition:
    background   var(--t-fast) var(--ease),
    border-color var(--t-fast) var(--ease),
    color        var(--t-fast) var(--ease);
}
.btn-icon:hover {
  background:   var(--bg-hover);
  border-color: var(--bd-default);
  color:        var(--tx-primary);
}
.btn-icon svg { width: 14px; height: 14px; }

.notif-dot {
  position:      absolute;
  top:           7px;
  right:         7px;
  width:         6px;
  height:        6px;
  border-radius: 50%;
  background:    var(--er);
  border:        1.5px solid var(--bg-surface);
}

/* ── Status chip ── */
.chip-status {
  display:        flex;
  align-items:    center;
  gap:            7px;
  padding:        5px 12px;
  border-radius:  var(--r-lg);
  background:     var(--ok-dim);
  border:         1px solid var(--ok-bd);
  font-size:      11.5px;
  font-weight:    600;
  color:          var(--ok);
  letter-spacing: 0.01em;
  user-select:    none;
}
.chip-status__dot {
  width:         5px;
  height:        5px;
  border-radius: 50%;
  background:    var(--ok);
  flex-shrink:   0;
  animation:     pulse-dot 2.4s ease infinite;
}
@keyframes pulse-dot {
  0%, 100% { opacity: 1;   box-shadow: 0 0 0 0   rgba(52,211,153,0.4); }
  50%       { opacity: 0.7; box-shadow: 0 0 0 4px rgba(52,211,153,0);   }
}

/* ── Topbar avatar ── */
.topbar__av {
  width:           34px;
  height:          34px;
  border-radius:   50%;
  background:      var(--ac-dim);
  border:          1px solid var(--bd-accent);
  display:         flex;
  align-items:     center;
  justify-content: center;
  font-size:       12px;
  font-weight:     700;
  color:           var(--ac-bright);
  cursor:          pointer;
  flex-shrink:     0;
  transition:
    border-color var(--t-fast) var(--ease),
    box-shadow   var(--t-fast) var(--ease);
  letter-spacing: -0.02em;
}
.topbar__av:hover {
  border-color: var(--ac);
  box-shadow:   0 0 0 3px var(--ac-glow);
}

/* ==========================================================================
   FLASH ALERT
   ========================================================================== */
.flash-region { padding: 18px 22px 0; }

.alert {
  display:       flex;
  align-items:   flex-start;
  gap:           11px;
  padding:       12px 14px;
  border-radius: var(--r-lg);
  font-size:     13px;
  font-weight:   500;
  border:        1px solid;
  line-height:   1.5;
}
.alert__icon    { width: 15px; height: 15px; flex-shrink: 0; margin-top: 1.5px; }
.alert__message { flex: 1; }
.alert__close {
  background:  none;
  border:      none;
  font-size:   18px;
  line-height: 1;
  color:       inherit;
  opacity:     0.4;
  padding:     0;
  transition:  opacity var(--t-fast);
  flex-shrink: 0;
}
.alert__close:hover { opacity: 1; }

.alert--success { background: var(--ok-dim); border-color: var(--ok-bd); color: var(--ok); }
.alert--error,
.alert--danger  { background: var(--er-dim); border-color: var(--er-bd); color: var(--er); }
.alert--warning { background: var(--wa-dim); border-color: var(--wa-bd); color: var(--wa); }
.alert--info    { background: var(--in-dim); border-color: var(--in-bd); color: var(--in); }

/* ==========================================================================
   PAGE CONTENT
   ========================================================================== */
.page-content {
  flex:       1;
  overflow-y: auto;
  padding:    26px 22px;
}

@media (max-width: 480px) {
  .topbar        { padding: 0 14px; gap: 10px; }
  .flash-region  { padding: 12px 14px 0; }
  .page-content  { padding: 16px 14px; }
}
  </style>
</head>
<body>

<div class="app-shell">

  <!-- Backdrop -->
  <div class="backdrop" id="js-backdrop" onclick="closeSidebar()" aria-hidden="true"></div>

  <!-- ================================================================
       SIDEBAR
       ================================================================ -->
  <aside class="sidebar" id="js-sidebar" role="navigation" aria-label="Navigasi utama">

    <!-- Brand -->
    <div class="sidebar__brand">
      <div class="sidebar__logo-wrap">
        <img
          class="sidebar__logo"
          src="<?= BASE_URL ?>/assets/img/logo-com.png"
          alt="Logo <?= htmlspecialchars(APP_NAME) ?>"
          loading="eager"
          decoding="sync"
          onerror="this.style.display='none';this.nextElementSibling.style.display='block';"
        >
        <svg class="sidebar__logo-icon" style="display:none;" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M8 1L13.5 4v8L8 15 2.5 12V4L8 1z"/>
          <path d="M8 6l2.5 1.5v3L8 12 5.5 10.5v-3L8 6z"/>
        </svg>
      </div>
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
            [
              // ✅ FIX: href berisi path relatif saja — BASE_URL TIDAK dipakai untuk external
              // generate_sso.php ada di root web utama, dipanggil via path absolut
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
        <div class="nav-section">
          <span class="nav-group__label"><?= htmlspecialchars($group) ?></span>
          <?php foreach ($items as $item):
            $isExternal = !empty($item['external']);

            // ✅ FIX: Untuk external, href sudah lengkap (sudah ada BASE_URL di definisi array).
            //         Untuk internal, tambahkan BASE_URL di depan path relatif.
            $fullHref = $isExternal
              ? htmlspecialchars($item['href'])
              : BASE_URL . htmlspecialchars($item['href']);

            $active = !$isExternal && str_starts_with($current, $item['href']);
            $cls    = $active ? ' is-active' : '';
            $aria   = $active ? ' aria-current="page"' : '';
            $target = $isExternal ? ' target="_blank" rel="noopener noreferrer"' : '';
          ?>
          <a
            href="<?= $fullHref ?>"
            class="nav-item<?= $cls ?>"<?= $aria ?><?= $target ?>
          >
            <span class="nav-item__icon" aria-hidden="true"><?= $item['icon'] ?></span>
            <span class="nav-item__label"><?= htmlspecialchars($item['label']) ?></span>
            <?php if (!empty($item['badge'])): ?>
              <span class="nav-item__badge"><?= htmlspecialchars($item['badge']) ?></span>
            <?php endif; ?>
          </a>
          <?php endforeach; ?>
        </div>
      <?php endforeach; ?>
    </nav>

    <!-- User / Footer -->
    <div class="sidebar__footer">
      <div class="user-card">
        <div class="user-card__av" aria-hidden="true">
          <?php
            $name     = $_SESSION['user_name'] ?? 'Administrator';
            $initials = '';
            foreach (explode(' ', $name) as $word) {
              $initials .= mb_strtoupper(mb_substr($word, 0, 1));
              if (strlen($initials) >= 2) break;
            }
            echo htmlspecialchars($initials ?: 'A');
          ?>
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

  <!-- ================================================================
       MAIN AREA
       ================================================================ -->
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
        <span class="breadcrumb__sep" aria-hidden="true">›</span>
        <span class="breadcrumb__page">Panel Administrator</span>
      </nav>

      <div class="topbar__search" role="search">
        <svg class="topbar__search-icon" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <circle cx="7" cy="7" r="4.5"/>
          <path d="M10.5 10.5L14 14"/>
        </svg>
        <input type="text" placeholder="Cari menu atau halaman…" aria-label="Cari" id="js-search-input">
        <span class="topbar__search-kbd" aria-hidden="true">⌘K</span>
      </div>

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

        <?php
          $name     = $_SESSION['user_name'] ?? 'Administrator';
          $initials = '';
          foreach (explode(' ', $name) as $word) {
            $initials .= mb_strtoupper(mb_substr($word, 0, 1));
            if (strlen($initials) >= 2) break;
          }
        ?>
        <div class="topbar__av" role="button" tabindex="0" aria-label="Profil admin" title="<?= htmlspecialchars($name) ?>">
          <?= htmlspecialchars($initials ?: 'A') ?>
        </div>

      </div>
    </header>

    <!-- Flash -->
    <?php if (!empty($flash)): ?>
    <div class="flash-region" role="alert" aria-live="assertive">
      <?php
        $type  = $flash['type'] ?? 'info';
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

  </div><!-- /.main-area -->

</div><!-- /.app-shell -->

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

  /* Close sidebar on nav click (mobile only, skip external links) */
  sidebar.querySelectorAll('.nav-item:not([target="_blank"])').forEach(function (el) {
    el.addEventListener('click', function () {
      if (window.innerWidth < 768) closeSidebar();
    });
  });

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && sidebar.classList.contains('is-open')) closeSidebar();
  });

  window.matchMedia('(min-width: 768px)').addEventListener('change', function (e) {
    if (e.matches) {
      sidebar.classList.remove('is-open');
      backdrop.classList.remove('is-visible');
      document.body.style.overflow = '';
    }
  });

  /* Flash dismiss */
  var flashEl = document.getElementById('js-flash');

  window.dismissFlash = function () {
    if (!flashEl) return;
    flashEl.style.transition = 'opacity 220ms ease, transform 220ms ease';
    flashEl.style.opacity    = '0';
    flashEl.style.transform  = 'translateY(-5px)';
    setTimeout(function () { flashEl && flashEl.remove(); }, 240);
  };

  if (flashEl) setTimeout(window.dismissFlash, 5500);

  /* Search shortcut ⌘K / Ctrl+K */
  document.addEventListener('keydown', function (e) {
    if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
      e.preventDefault();
      var inp = document.getElementById('js-search-input');
      if (inp) inp.focus();
    }
  });

}());
</script>
<script src="<?= BASE_URL ?>/assets/js/main.js"></script>
</body>
</html>