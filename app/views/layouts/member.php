<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Member | <?= htmlspecialchars(APP_NAME) ?></title>

  <!-- Font sesuai Design System §3 -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">

  <!-- Ikon sesuai Design System §4 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/custom.css">
  <style>

    /* ─────────────────────────────────────────
       RESET & BASE
    ───────────────────────────────────────── */
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html { height: 100%; overflow: hidden; }
    a    { color: inherit; text-decoration: none; }
    button { font-family: inherit; cursor: pointer; border: none; background: none; }

    /* ─────────────────────────────────────────
       DESIGN TOKENS — Design System §2
    ───────────────────────────────────────── */
    :root {
      --sidebar-width : 240px;
      --topbar-height : 60px;

      /* Base surface */
      --c-page:        #eef2f6;
      --c-white:       #ffffff;
      --c-ink:         #0f172a;
      --c-muted:       #64748b;
      --c-muted2:      #94a3b8;
      --c-border:      #e6ebf1;

      /* Aksen utama */
      --c-primary:     #0e7490;
      --c-primary-dk:  #0b5a70;
      --c-primary-lt:  #06b6d4;

      /* Status */
      --c-amber-bg:     #fef6e2;
      --c-amber-border: #fbe3a8;
      --c-amber-text:   #8a5a06;
      --c-amber-icon:   #d9910c;

      --c-red-bg:      #fef2f2;
      --c-red-border:  #fecaca;
      --c-red-text:    #b91c1c;

      --c-green-bg:    #f0fdf4;
      --c-green-border:#bbf7d0;
      --c-green-text:  #15803d;

      --c-info-bg:     #eff6ff;
      --c-info-border: #bfdbfe;
      --c-info-text:   #1d4ed8;

      /* Radius */
      --radius-sm: 9px;
      --radius-md: 13px;
      --radius-lg: 22px;

      --ease: cubic-bezier(.4,0,.2,1);
      --ease-spring: cubic-bezier(.34,1.56,.64,1);
    }

    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background : var(--c-page);
      color      : var(--c-ink);
      font-size  : 14px;
      line-height: 1.55;
      height     : 100%;
      overflow   : hidden;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
    }

    /* ─────────────────────────────────────────
       LAYOUT SHELL
    ───────────────────────────────────────── */
    .app-shell {
      display  : flex;
      height   : 100dvh;
      overflow : hidden;
    }

    /* ─────────────────────────────────────────
       SIDEBAR — Design System §5.1 (card style)
    ───────────────────────────────────────── */
    .sidebar {
      position      : fixed;
      inset         : 0 auto 0 0;
      z-index       : 50;
      width         : var(--sidebar-width);
      background    : var(--c-white);
      border-right  : 1px solid var(--c-border);
      display       : flex;
      flex-direction: column;
      transition    : transform 240ms var(--ease), box-shadow 240ms var(--ease);
      will-change   : transform;
    }

    /* ── Brand ── */
    .sidebar__brand {
      display      : flex;
      align-items  : center;
      gap          : 10px;
      height       : var(--topbar-height);
      padding      : 0 18px;
      border-bottom: 1px solid var(--c-border);
      flex-shrink  : 0;
    }

    .brand__logo {
      height    : 32px;
      width     : auto;
      max-width : 140px;
      object-fit: contain;
      flex-shrink: 0;
      /* Logo tidak boleh dalam kotak/background — Design System §6 */
      filter    : drop-shadow(0 1px 2px rgba(15,23,42,.08));
    }

    .brand__mark {
      display        : none;
      width          : 32px;
      height         : 32px;
      border-radius  : var(--radius-sm);
      background     : var(--c-primary);
      align-items    : center;
      justify-content: center;
      font-size      : 13px;
      font-weight    : 800;
      color          : #fff;
      flex-shrink    : 0;
      letter-spacing : -0.4px;
    }

    .brand__logo.error + .brand__mark { display: flex; }

    .brand__name {
      font-size    : 14.5px;
      font-weight  : 800;
      color        : var(--c-primary-dk);
      letter-spacing: -0.3px;
      white-space  : nowrap;
      overflow     : hidden;
      text-overflow: ellipsis;
      line-height  : 1;
    }

    /* ── Nav ── */
    .sidebar__nav {
      flex      : 1;
      padding   : 14px 12px;
      overflow-y: auto;
      scrollbar-width: none;
      min-height: 0;
    }
    .sidebar__nav::-webkit-scrollbar { display: none; }

    .nav-group { margin-bottom: 4px; }

    .nav-group__label {
      display       : block;
      font-size     : 10.5px;
      font-weight   : 700;
      letter-spacing: 0.08em;
      text-transform: uppercase;
      color         : var(--c-muted2);
      padding       : 10px 10px 6px;
    }

    .nav-link {
      display       : flex;
      align-items   : center;
      gap           : 10px;
      padding       : 9px 11px;
      border-radius : var(--radius-sm);
      font-size     : 13.5px;
      font-weight   : 500;
      color         : var(--c-muted);
      border        : 1px solid transparent;
      transition    : background 150ms var(--ease),
                      color 150ms var(--ease),
                      border-color 150ms var(--ease),
                      transform 120ms var(--ease-spring);
      white-space   : nowrap;
      overflow      : hidden;
      text-overflow : ellipsis;
      position      : relative;
    }
    .nav-link:hover {
      background: #f4f7fa;
      color     : var(--c-ink);
      transform : translateX(2px);
    }
    .nav-link--active {
      background  : rgba(14,116,144,.08);
      color       : var(--c-primary);
      border-color: rgba(14,116,144,.22);
      font-weight : 700;
    }
    .nav-link--active:hover {
      background: rgba(14,116,144,.12);
      color     : var(--c-primary);
      transform : translateX(2px);
    }
    .nav-link--active::before {
      content      : '';
      position     : absolute;
      left         : 0;
      top          : 20%;
      height       : 60%;
      width        : 3px;
      border-radius: 0 99px 99px 0;
      background   : var(--c-primary);
    }

    .nav-link__icon {
      font-size  : 16px;
      width      : 16px;
      flex-shrink: 0;
      opacity    : 0.8;
      transition : opacity 150ms;
    }
    .nav-link:hover .nav-link__icon,
    .nav-link--active .nav-link__icon {
      opacity: 1;
    }

    /* ── Footer kartu profil ── */
    .sidebar__footer {
      padding    : 12px;
      border-top : 1px solid var(--c-border);
      flex-shrink: 0;
    }

    .user-card {
      display      : flex;
      align-items  : center;
      gap          : 10px;
      padding      : 9px 11px;
      border-radius: var(--radius-md);
      background   : #f4f7fa;
      border       : 1px solid var(--c-border);
      transition   : border-color 150ms;
    }
    .user-card:hover { border-color: rgba(14,116,144,.25); }

    .user-card__avatar {
      width          : 32px;
      height         : 32px;
      border-radius  : 50%;
      background     : rgba(14,116,144,.12);
      border         : 1.5px solid rgba(14,116,144,.3);
      display        : flex;
      align-items    : center;
      justify-content: center;
      font-size      : 12px;
      font-weight    : 800;
      color          : var(--c-primary);
      flex-shrink    : 0;
      text-transform : uppercase;
    }

    .user-card__info { min-width: 0; flex: 1; }

    .user-card__name {
      font-size    : 13px;
      font-weight  : 700;
      color        : var(--c-ink);
      white-space  : nowrap;
      overflow     : hidden;
      text-overflow: ellipsis;
      line-height  : 1.3;
    }

    .user-card__role {
      font-size  : 11px;
      color      : var(--c-muted2);
      line-height: 1.3;
      font-weight: 600;
      letter-spacing: 0.02em;
    }

    .user-card__status {
      width        : 7px;
      height       : 7px;
      border-radius: 50%;
      background   : var(--c-green-text);
      flex-shrink  : 0;
    }

    /* ─────────────────────────────────────────
       MOBILE OVERLAY
    ───────────────────────────────────────── */
    .overlay {
      position  : fixed;
      inset     : 0;
      z-index   : 49;
      background: rgba(15,23,42,0.45);
      backdrop-filter: blur(3px);
      -webkit-backdrop-filter: blur(3px);
      opacity   : 0;
      visibility: hidden;
      transition: opacity 240ms var(--ease), visibility 240ms var(--ease);
    }
    .overlay--show {
      opacity   : 1;
      visibility: visible;
    }

    /* ─────────────────────────────────────────
       MAIN AREA
    ───────────────────────────────────────── */
    .main-area {
      flex          : 1;
      margin-left   : var(--sidebar-width);
      display       : flex;
      flex-direction: column;
      min-width     : 0;
      min-height    : 0;
      height        : 100dvh;
      overflow-y    : auto;
      overflow-x    : hidden;
      scrollbar-width: thin;
      scrollbar-color: var(--c-border) transparent;
    }
    .main-area::-webkit-scrollbar { width: 4px; }
    .main-area::-webkit-scrollbar-thumb {
      background   : var(--c-border);
      border-radius: 99px;
    }

    /* ─────────────────────────────────────────
       TOPBAR
    ───────────────────────────────────────── */
    .topbar {
      position       : sticky;
      top            : 0;
      z-index        : 40;
      height         : var(--topbar-height);
      background     : rgba(255,255,255,0.85);
      backdrop-filter: blur(14px);
      -webkit-backdrop-filter: blur(14px);
      border-bottom  : 1px solid var(--c-border);
      display        : flex;
      align-items    : center;
      justify-content: space-between;
      padding        : 0 22px;
      flex-shrink    : 0;
      gap            : 12px;
    }

    .topbar__start {
      display    : flex;
      align-items: center;
      gap        : 10px;
      min-width  : 0;
    }

    .topbar__end {
      display    : flex;
      align-items: center;
      gap        : 4px;
      flex-shrink: 0;
    }

    /* Hamburger */
    .btn-hamburger {
      display        : none;
      align-items    : center;
      justify-content: center;
      width          : 34px;
      height         : 34px;
      border-radius  : var(--radius-sm);
      background     : #f4f7fa;
      border         : 1px solid var(--c-border);
      color          : var(--c-muted);
      font-size      : 16px;
      flex-shrink    : 0;
      transition     : background 150ms var(--ease),
                       color 150ms var(--ease),
                       border-color 150ms;
    }
    .btn-hamburger:hover {
      background  : #eef2f6;
      color       : var(--c-ink);
      border-color: rgba(14,116,144,.25);
    }

    /* Breadcrumb */
    .breadcrumb {
      display    : flex;
      align-items: center;
      gap        : 6px;
      font-size  : 13px;
      min-width  : 0;
    }

    .breadcrumb__link {
      display    : flex;
      align-items: center;
      gap        : 5px;
      color      : var(--c-muted2);
      font-weight: 600;
      transition : color 150ms;
      white-space: nowrap;
      font-size  : 14px;
    }
    .breadcrumb__link:hover { color: var(--c-primary); }

    .breadcrumb__sep {
      color    : var(--c-muted2);
      font-size: 11px;
      opacity  : 0.7;
    }

    .breadcrumb__current {
      color      : var(--c-ink);
      font-weight: 700;
      white-space: nowrap;
      overflow   : hidden;
      text-overflow: ellipsis;
    }

    /* Icon button */
    .icon-btn {
      position       : relative;
      display        : flex;
      align-items    : center;
      justify-content: center;
      width          : 34px;
      height         : 34px;
      border-radius  : var(--radius-sm);
      background     : transparent;
      border         : 1px solid transparent;
      color          : var(--c-muted);
      font-size      : 17px;
      transition     : background 150ms var(--ease),
                       border-color 150ms var(--ease),
                       color 150ms var(--ease);
    }
    .icon-btn:hover {
      background  : #f4f7fa;
      border-color: var(--c-border);
      color       : var(--c-ink);
    }

    .notif-dot {
      position     : absolute;
      top          : 7px;
      right        : 7px;
      width        : 6px;
      height       : 6px;
      border-radius: 50%;
      background   : var(--c-primary-lt);
      border       : 1.5px solid var(--c-white);
    }

    .topbar__sep {
      width     : 1px;
      height    : 20px;
      background: var(--c-border);
      margin    : 0 4px;
    }

    /* ── Avatar + dropdown profil ── */
    .topbar-avatar-wrap { position: relative; }

    .topbar-avatar {
      width          : 32px;
      height         : 32px;
      border-radius  : 50%;
      background     : rgba(14,116,144,.12);
      border         : 1.5px solid rgba(14,116,144,.3);
      display        : flex;
      align-items    : center;
      justify-content: center;
      font-size      : 12px;
      font-weight    : 800;
      color          : var(--c-primary);
      text-transform : uppercase;
      flex-shrink    : 0;
      transition     : box-shadow 150ms var(--ease);
    }
    .topbar-avatar:hover { box-shadow: 0 0 0 4px rgba(14,116,144,.12); }
    .topbar-avatar[aria-expanded="true"] { box-shadow: 0 0 0 4px rgba(14,116,144,.12); }

    .avatar-menu {
      position     : absolute;
      top          : calc(100% + 10px);
      right        : 0;
      width         : 250px;
      background    : var(--c-white);
      border        : 1px solid var(--c-border);
      border-radius : var(--radius-md);
      box-shadow    : 0 24px 48px rgba(15,23,42,.14), 0 4px 14px rgba(15,23,42,.06);
      padding       : 6px;
      opacity       : 0;
      visibility    : hidden;
      transform     : translateY(-6px) scale(.98);
      transform-origin: top right;
      transition    : opacity 160ms var(--ease), transform 160ms var(--ease-spring), visibility 160ms;
      z-index       : 60;
    }
    .avatar-menu--open {
      opacity   : 1;
      visibility: visible;
      transform : translateY(0) scale(1);
    }

    .avatar-menu__header {
      display      : flex;
      align-items  : center;
      gap          : 10px;
      padding      : 9px 10px 12px;
      border-bottom: 1px solid var(--c-border);
      margin-bottom: 6px;
    }
    .avatar-menu__avatar {
      width          : 36px;
      height         : 36px;
      border-radius  : 50%;
      background     : rgba(14,116,144,.12);
      border         : 1.5px solid rgba(14,116,144,.3);
      display        : flex;
      align-items    : center;
      justify-content: center;
      font-size      : 12px;
      font-weight    : 800;
      color          : var(--c-primary);
      flex-shrink    : 0;
      text-transform : uppercase;
    }
    .avatar-menu__info { min-width: 0; flex: 1; }
    .avatar-menu__name {
      font-size    : 13px;
      font-weight  : 800;
      color        : var(--c-ink);
      white-space  : nowrap;
      overflow     : hidden;
      text-overflow: ellipsis;
      line-height  : 1.3;
    }
    .avatar-menu__role {
      font-size  : 11px;
      color      : var(--c-muted2);
      font-weight: 600;
    }

    .avatar-menu__item {
      display      : flex;
      align-items  : center;
      gap          : 10px;
      padding      : 9px 10px;
      border-radius: var(--radius-sm);
      font-size    : 13px;
      font-weight  : 600;
      color        : var(--c-muted);
      transition   : background 140ms var(--ease), color 140ms var(--ease);
      width        : 100%;
      text-align   : left;
    }
    .avatar-menu__item:hover {
      background: #f4f7fa;
      color     : var(--c-ink);
    }
    .avatar-menu__item i { font-size: 15px; flex-shrink: 0; opacity: .85; }

    .avatar-menu__item--danger { color: var(--c-red-text); }
    .avatar-menu__item--danger:hover {
      background: var(--c-red-bg);
      color     : var(--c-red-text);
    }

    .avatar-menu__item--static { cursor: default; }
    .avatar-menu__item--static:hover { background: transparent; }

    .avatar-menu__item-text {
      flex          : 1;
      display       : flex;
      flex-direction: column;
      gap           : 1px;
      min-width     : 0;
    }
    .avatar-menu__item-label {
      font-size  : 12.5px;
      font-weight: 700;
      color      : var(--c-ink);
    }
    .avatar-menu__item-hint {
      font-size: 10.5px;
      color    : var(--c-muted2);
      line-height: 1.3;
      font-weight: 500;
    }

    .avatar-menu__divider {
      height    : 1px;
      background: var(--c-border);
      margin    : 6px 4px;
    }

    /* Toggle switch — Mode Hemat Daya */
    .switch {
      position     : relative;
      width        : 38px;
      height       : 21px;
      border-radius: 99px;
      background   : #e2e8f0;
      border       : 1px solid var(--c-border);
      flex-shrink  : 0;
      transition   : background 160ms var(--ease), border-color 160ms var(--ease);
    }
    .switch__thumb {
      position     : absolute;
      top          : 2px;
      left         : 2px;
      width        : 15px;
      height       : 15px;
      border-radius: 50%;
      background   : #fff;
      box-shadow   : 0 1px 3px rgba(15,23,42,.25);
      transition   : transform 160ms var(--ease-spring), background 160ms var(--ease);
    }
    .switch--on {
      background  : var(--c-primary);
      border-color: var(--c-primary-dk);
    }
    .switch--on .switch__thumb {
      transform : translateX(17px);
    }

    /* ─────────────────────────────────────────
       FLASH / ALERT — Design System §5.5
    ───────────────────────────────────────── */
    .flash-zone { padding: 18px 22px 0; }

    .alert {
      display      : flex;
      align-items  : flex-start;
      gap          : 10px;
      padding      : 12px 15px;
      border-radius: var(--radius-md);
      font-size    : 13.5px;
      font-weight  : 500;
      border       : 1px solid;
      line-height  : 1.5;
      animation    : alertIn 300ms var(--ease-spring) both;
    }
    @keyframes alertIn {
      from { opacity:0; transform: translateY(-6px); }
      to   { opacity:1; transform: translateY(0); }
    }
    .alert i { font-size: 17px; flex-shrink: 0; margin-top: 1px; }

    .alert--success { background: var(--c-green-bg); border-color: var(--c-green-border); color: var(--c-green-text); }
    .alert--danger,
    .alert--error   { background: var(--c-red-bg);   border-color: var(--c-red-border);   color: var(--c-red-text); }
    .alert--warning { background: var(--c-amber-bg); border-color: var(--c-amber-border); color: var(--c-amber-text); }
    .alert--info    { background: var(--c-info-bg);  border-color: var(--c-info-border);  color: var(--c-info-text); }

    /* ─────────────────────────────────────────
       PAGE CONTENT
    ───────────────────────────────────────── */
    .page-content {
      flex   : 1;
      padding: 26px 22px 32px;
      animation: pageIn 250ms var(--ease) both;
    }
    @keyframes pageIn {
      from { opacity:0; transform: translateY(8px); }
      to   { opacity:1; transform: translateY(0); }
    }

    /* ─────────────────────────────────────────
       MODE HEMAT DAYA
       Mematikan blur & animasi berat — cocok
       untuk device lawas / baterai lemah.
    ───────────────────────────────────────── */
    body.power-save .topbar {
      backdrop-filter: none;
      -webkit-backdrop-filter: none;
      background: var(--c-white);
    }
    body.power-save .overlay {
      backdrop-filter: none;
      -webkit-backdrop-filter: none;
    }
    body.power-save *,
    body.power-save *::before,
    body.power-save *::after {
      animation-duration: 0ms !important;
      animation-delay: 0ms !important;
      transition-duration: 0ms !important;
    }
    body.power-save .avatar-menu {
      box-shadow: 0 4px 14px rgba(15,23,42,.12);
    }

    /* ─────────────────────────────────────────
       RESPONSIF — Design System §8 (≤ 860px,
       disesuaikan ke 768px untuk layout sidebar)
    ───────────────────────────────────────── */
    @media (max-width: 768px) {
      .sidebar {
        transform: translateX(-100%);
      }
      .sidebar--open {
        transform : translateX(0);
        box-shadow: 6px 0 40px rgba(15,23,42,.18);
      }
      .main-area {
        margin-left: 0;
      }
      .btn-hamburger {
        display: flex;
      }
      .page-content {
        padding: 16px 14px 24px;
      }
      .flash-zone {
        padding: 14px 14px 0;
      }
      .topbar {
        padding: 0 14px;
      }
      .avatar-menu {
        right: -6px;
        width: 230px;
      }
    }

    @media (max-width: 480px) {
      .breadcrumb__link span { display: none; }
    }

  </style>
</head>
<body>

<?php
  /* ── Helpers ────────────────────────────── */
  $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
  $userName    = $_SESSION['user_name'] ?? '';
  $initials    = mb_strtoupper(mb_substr(strip_tags($userName), 0, 1));

  /* ── Navigation structure ─────────────────
     Ikon memakai Tabler Icons class name
     (tanpa prefix "ti ti-", cukup nama ikonnya).
  ─────────────────────────────────────────── */
  $navGroups = [
    'Utama' => [
      [
        'href'  => '/member/dashboard',
        'label' => 'Dashboard',
        'icon'  => 'layout-dashboard',
      ],
    ],
    'Aktivitas' => [
      [
        'href'  => '/member/absensi',
        'label' => 'Absensi Saya',
        'icon'  => 'clipboard-check',
      ],
    ],
    'Akun' => [
      [
        'href'  => '/member/profile',
        'label' => 'Profil Saya',
        'icon'  => 'user-circle',
      ],
      [
        'href'  => '/member/surat-pernyataan',
        'label' => 'Surat Pernyataan',
        'icon'  => 'file-text',
      ],
    ],
  ];

  /* ── Active page label ───────────────── */
  $pageLabel = 'Dashboard';
  foreach ($navGroups as $items) {
    foreach ($items as $item) {
      if (str_starts_with($currentPath, $item['href'])) {
        $pageLabel = $item['label'];
        break 2;
      }
    }
  }

  /* ── Alert icon helper (Tabler Icons) ────── */
  function alertIcon(string $type): string {
    $icon = match($type) {
      'success'        => 'circle-check',
      'danger','error' => 'alert-circle',
      'warning'        => 'alert-triangle',
      default          => 'info-circle',
    };
    return '<i class="ti ti-' . $icon . '" aria-hidden="true"></i>';
  }

  /* ── Nav icon shorthand (Tabler Icons) ───── */
  function navIcon(string $icon): string {
    return '<i class="ti ti-' . htmlspecialchars($icon) . ' nav-link__icon" aria-hidden="true"></i>';
  }
?>

<div class="app-shell">

  <!-- ── Overlay (mobile) ────────────────── -->
  <div class="overlay" id="js-overlay" onclick="closeSidebar()" role="presentation"></div>

  <!-- ── Sidebar ─────────────────────────── -->
  <aside class="sidebar" id="js-sidebar" aria-label="Navigasi utama">

    <div class="sidebar__brand">
      <!-- Logo tampil polos, tanpa kotak/background — Design System §6 -->
      <img
        src="<?= BASE_URL ?>/assets/img/logo-com.png"
        alt="<?= htmlspecialchars(APP_NAME) ?>"
        class="brand__logo"
        onerror="this.classList.add('error');this.style.display='none';"
        loading="eager"
        decoding="async"
      >
      <div class="brand__mark" aria-hidden="true">
        <?= htmlspecialchars(mb_strtoupper(mb_substr(APP_NAME, 0, 1))) ?>
      </div>
      <span class="brand__name" id="js-brand-name" style="display:none">
        <?= htmlspecialchars(APP_NAME) ?>
      </span>
    </div>

    <nav class="sidebar__nav">
      <?php foreach ($navGroups as $groupLabel => $items): ?>
        <div class="nav-group">
          <span class="nav-group__label"><?= htmlspecialchars($groupLabel) ?></span>

          <?php foreach ($items as $item):
            $isActive = str_starts_with($currentPath, $item['href']);
            $cls = 'nav-link' . ($isActive ? ' nav-link--active' : '');
          ?>
            <a href="<?= BASE_URL . htmlspecialchars($item['href']) ?>"
               class="<?= $cls ?>"
               <?= $isActive ? 'aria-current="page"' : '' ?>>
              <?= navIcon($item['icon']) ?>
              <?= htmlspecialchars($item['label']) ?>
            </a>
          <?php endforeach; ?>
        </div>
      <?php endforeach; ?>
    </nav>

    <!-- Kartu profil ringkas — logout ada di dropdown avatar topbar -->
    <div class="sidebar__footer">
      <div class="user-card">
        <div class="user-card__avatar" aria-hidden="true"><?= htmlspecialchars($initials) ?></div>
        <div class="user-card__info">
          <div class="user-card__name"><?= htmlspecialchars($userName) ?></div>
          <div class="user-card__role">Anggota</div>
        </div>
        <div class="user-card__status" title="Online" aria-label="Status: online"></div>
      </div>
    </div>

  </aside>

  <!-- ── Main area ────────────────────────── -->
  <div class="main-area" id="js-main">

    <!-- Topbar -->
    <header class="topbar">
      <div class="topbar__start">

        <button class="btn-hamburger" id="js-menu-btn"
                onclick="openSidebar()"
                aria-label="Buka navigasi"
                aria-expanded="false"
                aria-controls="js-sidebar">
          <i class="ti ti-menu-2" aria-hidden="true"></i>
        </button>

        <nav class="breadcrumb" aria-label="Breadcrumb">
          <a href="<?= BASE_URL ?>/member/dashboard" class="breadcrumb__link">
            <i class="ti ti-home" aria-hidden="true"></i>
            <span>Beranda</span>
          </a>
          <span class="breadcrumb__sep" aria-hidden="true">/</span>
          <span class="breadcrumb__current" aria-current="page">
            <?= htmlspecialchars($pageLabel) ?>
          </span>
        </nav>

      </div>

      <div class="topbar__end">

        <button class="icon-btn" aria-label="Notifikasi">
          <i class="ti ti-bell" aria-hidden="true"></i>
          <span class="notif-dot" aria-hidden="true"></span>
        </button>

        <div class="topbar__sep" aria-hidden="true"></div>

        <!-- Avatar + dropdown (Profil, Mode Hemat Daya, Keluar) -->
        <div class="topbar-avatar-wrap" id="js-avatar-wrap">
          <button
            class="topbar-avatar"
            id="js-avatar-btn"
            aria-haspopup="true"
            aria-expanded="false"
            aria-controls="js-avatar-menu"
            title="<?= htmlspecialchars($userName) ?>">
            <?= htmlspecialchars($initials) ?>
          </button>

          <div class="avatar-menu" id="js-avatar-menu" role="menu">
            <div class="avatar-menu__header">
              <div class="avatar-menu__avatar" aria-hidden="true"><?= htmlspecialchars($initials) ?></div>
              <div class="avatar-menu__info">
                <div class="avatar-menu__name"><?= htmlspecialchars($userName) ?></div>
                <div class="avatar-menu__role">Anggota</div>
              </div>
            </div>

            <a href="<?= BASE_URL ?>/member/profile" class="avatar-menu__item" role="menuitem">
              <i class="ti ti-user-circle" aria-hidden="true"></i>
              Profil Saya
            </a>

            <div class="avatar-menu__item avatar-menu__item--static" role="menuitem">
              <div class="avatar-menu__item-text">
                <span class="avatar-menu__item-label">Mode Hemat Daya</span>
                <span class="avatar-menu__item-hint">Kurangi efek blur &amp; animasi</span>
              </div>
              <button
                type="button"
                class="switch"
                id="js-power-save-toggle"
                role="switch"
                aria-checked="false"
                aria-label="Aktifkan mode hemat daya">
                <span class="switch__thumb"></span>
              </button>
            </div>

            <div class="avatar-menu__divider"></div>

            <a href="<?= BASE_URL ?>/logout" class="avatar-menu__item avatar-menu__item--danger" role="menuitem">
              <i class="ti ti-logout" aria-hidden="true"></i>
              Keluar
            </a>
          </div>
        </div>

      </div>
    </header>

    <!-- Flash -->
    <?php if (!empty($flash)): ?>
      <?php
        $type = $flash['type'] ?? 'info';
        $safeType = in_array($type, ['success','danger','error','warning','info']) ? $type : 'info';
      ?>
      <div class="flash-zone" role="status" aria-live="polite" aria-atomic="true">
        <div class="alert alert--<?= $safeType ?>">
          <?= alertIcon($type) ?>
          <span><?= htmlspecialchars($flash['msg'] ?? '') ?></span>
        </div>
      </div>
    <?php endif; ?>

    <!-- Page content -->
    <main class="page-content" id="main-content">
      <?= $content ?>
    </main>

  </div><!-- /main-area -->

</div><!-- /app-shell -->

<script>
(function () {
  var sidebar = document.getElementById('js-sidebar');
  var overlay = document.getElementById('js-overlay');
  var menuBtn = document.getElementById('js-menu-btn');

  function openSidebar() {
    sidebar.classList.add('sidebar--open');
    overlay.classList.add('overlay--show');
    if (menuBtn) menuBtn.setAttribute('aria-expanded', 'true');
    document.body.style.overflow = 'hidden';
  }

  function closeSidebar() {
    sidebar.classList.remove('sidebar--open');
    overlay.classList.remove('overlay--show');
    if (menuBtn) menuBtn.setAttribute('aria-expanded', 'false');
    document.body.style.overflow = '';
  }

  window.openSidebar  = openSidebar;
  window.closeSidebar = closeSidebar;

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeSidebar();
  });

  var navLinks = sidebar.querySelectorAll('.nav-link');
  navLinks.forEach(function(link) {
    link.addEventListener('click', function() {
      if (window.innerWidth <= 768) closeSidebar();
    });
  });

  var logo      = document.querySelector('.brand__logo');
  var brandName = document.getElementById('js-brand-name');
  if (logo && brandName) {
    logo.addEventListener('error', function() {
      brandName.style.display = '';
    });
  }

  /* ════════════════════════════════════════════
     DROPDOWN PROFIL (avatar)
  ════════════════════════════════════════════ */
  var avatarBtn  = document.getElementById('js-avatar-btn');
  var avatarMenu = document.getElementById('js-avatar-menu');

  function closeAvatarMenu() {
    avatarMenu.classList.remove('avatar-menu--open');
    avatarBtn.setAttribute('aria-expanded', 'false');
  }
  function toggleAvatarMenu(e) {
    e.stopPropagation();
    var isOpen = avatarMenu.classList.toggle('avatar-menu--open');
    avatarBtn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
  }

  avatarBtn.addEventListener('click', toggleAvatarMenu);

  document.addEventListener('click', function (e) {
    if (!avatarMenu.contains(e.target) && e.target !== avatarBtn) {
      closeAvatarMenu();
    }
  });
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeAvatarMenu();
  });

  /* ════════════════════════════════════════════
     MODE HEMAT DAYA — toggle + simpan preferensi
  ════════════════════════════════════════════ */
  var POWER_SAVE_KEY = 'com_member_power_save';
  var powerToggle     = document.getElementById('js-power-save-toggle');

  function applyPowerSave(isOn) {
    document.body.classList.toggle('power-save', isOn);
    if (powerToggle) {
      powerToggle.classList.toggle('switch--on', isOn);
      powerToggle.setAttribute('aria-checked', isOn ? 'true' : 'false');
    }
  }

  var savedPreference = localStorage.getItem(POWER_SAVE_KEY) === '1';
  applyPowerSave(savedPreference);

  if (powerToggle) {
    powerToggle.addEventListener('click', function (e) {
      e.stopPropagation();
      var willBeOn = !document.body.classList.contains('power-save');
      applyPowerSave(willBeOn);
      localStorage.setItem(POWER_SAVE_KEY, willBeOn ? '1' : '0');
    });
  }

}());
</script>

<script src="<?= BASE_URL ?>/assets/js/main.js"></script>
</body>
</html>