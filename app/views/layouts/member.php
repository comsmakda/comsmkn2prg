<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Member | <?= htmlspecialchars(APP_NAME) ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/custom.css">
  <style>

    /* ─────────────────────────────────────────
       RESET & BASE
    ───────────────────────────────────────── */
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html { height: 100%; }
    a    { color: inherit; text-decoration: none; }
    button { font-family: inherit; cursor: pointer; border: none; }

    :root {
      --sidebar-width : 240px;
      --topbar-height : 56px;

      /* Core palette */
      --color-bg        : #07070a;
      --color-surface   : #0e0e12;
      --color-surface-2 : #16161c;
      --color-surface-3 : #1f1f28;
      --color-surface-4 : #2a2a36;

      --color-border    : rgba(255,255,255,0.05);
      --color-border-2  : rgba(255,255,255,0.09);
      --color-border-3  : rgba(255,255,255,0.14);

      --color-text-1    : #f0f0f5;
      --color-text-2    : #9898a8;
      --color-text-3    : #4a4a5a;

      /* Accent — rich indigo-violet */
      --color-accent        : #7c6cf2;
      --color-accent-light  : #9d91f5;
      --color-accent-dim    : rgba(124,108,242,0.12);
      --color-accent-dim-2  : rgba(124,108,242,0.20);
      --color-accent-border : rgba(124,108,242,0.30);
      --color-accent-glow   : rgba(124,108,242,0.18);

      /* Status colors */
      --color-success       : #34d399;
      --color-success-dim   : rgba(52,211,153,0.10);
      --color-success-border: rgba(52,211,153,0.25);
      --color-danger        : #f87171;
      --color-danger-dim    : rgba(248,113,113,0.10);
      --color-danger-border : rgba(248,113,113,0.25);
      --color-warning       : #fbbf24;
      --color-warning-dim   : rgba(251,191,36,0.10);
      --color-warning-border: rgba(251,191,36,0.25);
      --color-info          : #60a5fa;
      --color-info-dim      : rgba(96,165,250,0.10);
      --color-info-border   : rgba(96,165,250,0.25);

      /* Radius */
      --radius-xs : 4px;
      --radius-sm : 7px;
      --radius-md : 10px;
      --radius-lg : 14px;
      --radius-xl : 18px;

      --ease: cubic-bezier(.4,0,.2,1);
      --ease-spring: cubic-bezier(.34,1.56,.64,1);
    }

    body {
      font-family: 'DM Sans', system-ui, sans-serif;
      background : var(--color-bg);
      color      : var(--color-text-1);
      font-size  : 14px;
      line-height: 1.55;
      min-height : 100%;
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
       SIDEBAR
    ───────────────────────────────────────── */
    .sidebar {
      position      : fixed;
      inset         : 0 auto 0 0;
      z-index       : 50;
      width         : var(--sidebar-width);
      background    : var(--color-surface);
      border-right  : 1px solid var(--color-border);
      display       : flex;
      flex-direction: column;
      transition    : transform 240ms var(--ease), box-shadow 240ms var(--ease);
      will-change   : transform;
    }

    /* subtle inner glow on sidebar */
    .sidebar::after {
      content : '';
      position: absolute;
      inset   : 0;
      background: linear-gradient(180deg, rgba(124,108,242,0.04) 0%, transparent 40%);
      pointer-events: none;
    }

    /* ── Brand ── */
    .sidebar__brand {
      display      : flex;
      align-items  : center;
      gap          : 10px;
      height       : var(--topbar-height);
      padding      : 0 16px;
      border-bottom: 1px solid var(--color-border);
      flex-shrink  : 0;
      position     : relative;
      z-index      : 1;
    }

    .brand__logo {
      height    : 30px;
      width     : auto;
      max-width : 140px;
      object-fit: contain;
      filter    : brightness(1.05) saturate(1.1);
      flex-shrink: 0;
    }

    /* Fallback mark when logo fails */
    .brand__mark {
      display        : none;
      width          : 30px;
      height         : 30px;
      border-radius  : var(--radius-sm);
      background     : linear-gradient(135deg, var(--color-accent), #9d91f5);
      align-items    : center;
      justify-content: center;
      font-size      : 13px;
      font-weight    : 700;
      color          : #fff;
      flex-shrink    : 0;
      letter-spacing : -0.4px;
      box-shadow     : 0 0 18px var(--color-accent-glow);
    }

    .brand__logo.error + .brand__mark { display: flex; }

    .brand__name {
      font-size    : 14.5px;
      font-weight  : 700;
      color        : var(--color-text-1);
      letter-spacing: -0.4px;
      white-space  : nowrap;
      overflow     : hidden;
      text-overflow: ellipsis;
      line-height  : 1;
    }

    /* ── Nav ── */
    .sidebar__nav {
      flex      : 1;
      padding   : 12px 10px;
      overflow-y: auto;
      scrollbar-width: none;
      position  : relative;
      z-index   : 1;
    }
    .sidebar__nav::-webkit-scrollbar { display: none; }

    .nav-group { margin-bottom: 4px; }

    .nav-group__label {
      display       : block;
      font-size     : 10px;
      font-weight   : 600;
      letter-spacing: 0.10em;
      text-transform: uppercase;
      color         : var(--color-text-3);
      padding       : 10px 10px 5px;
      font-family   : 'DM Mono', monospace;
    }

    .nav-link {
      display       : flex;
      align-items   : center;
      gap           : 10px;
      padding       : 8px 10px;
      border-radius : var(--radius-sm);
      font-size     : 13.5px;
      font-weight   : 500;
      color         : var(--color-text-2);
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
      background: var(--color-surface-2);
      color     : var(--color-text-1);
      transform : translateX(2px);
    }
    .nav-link--active {
      background  : var(--color-accent-dim);
      color       : var(--color-accent-light);
      border-color: var(--color-accent-border);
    }
    .nav-link--active:hover {
      background  : var(--color-accent-dim-2);
      color       : var(--color-accent-light);
      transform   : translateX(2px);
    }
    /* Active indicator bar */
    .nav-link--active::before {
      content      : '';
      position     : absolute;
      left         : 0;
      top          : 20%;
      height       : 60%;
      width        : 2.5px;
      border-radius: 0 99px 99px 0;
      background   : var(--color-accent);
      box-shadow   : 0 0 8px var(--color-accent-glow);
    }

    .nav-link__icon {
      width    : 16px;
      height   : 16px;
      flex-shrink: 0;
      opacity  : 0.75;
      transition: opacity 150ms;
    }
    .nav-link:hover .nav-link__icon,
    .nav-link--active .nav-link__icon {
      opacity: 1;
    }

    /* ── Footer ── */
    .sidebar__footer {
      padding    : 12px 10px;
      border-top : 1px solid var(--color-border);
      flex-shrink: 0;
      position   : relative;
      z-index    : 1;
    }

    .user-card {
      display      : flex;
      align-items  : center;
      gap          : 10px;
      padding      : 9px 11px;
      border-radius: var(--radius-md);
      background   : var(--color-surface-2);
      border       : 1px solid var(--color-border-2);
      margin-bottom: 6px;
      transition   : border-color 150ms;
    }
    .user-card:hover { border-color: var(--color-border-3); }

    .user-card__avatar {
      width          : 30px;
      height         : 30px;
      border-radius  : 50%;
      background     : var(--color-accent-dim);
      border         : 1.5px solid var(--color-accent-border);
      display        : flex;
      align-items    : center;
      justify-content: center;
      font-size      : 11px;
      font-weight    : 700;
      color          : var(--color-accent-light);
      flex-shrink    : 0;
      text-transform : uppercase;
      box-shadow     : 0 0 10px var(--color-accent-glow);
    }

    .user-card__info { min-width: 0; flex: 1; }

    .user-card__name {
      font-size    : 13px;
      font-weight  : 600;
      color        : var(--color-text-1);
      white-space  : nowrap;
      overflow     : hidden;
      text-overflow: ellipsis;
      line-height  : 1.3;
    }

    .user-card__role {
      font-size  : 11px;
      color      : var(--color-text-3);
      line-height: 1.3;
      font-weight: 500;
      letter-spacing: 0.03em;
    }

    .user-card__status {
      width        : 7px;
      height       : 7px;
      border-radius: 50%;
      background   : var(--color-success);
      box-shadow   : 0 0 6px var(--color-success);
      flex-shrink  : 0;
    }

    .btn-logout {
      display        : flex;
      align-items    : center;
      justify-content: center;
      gap            : 8px;
      width          : 100%;
      padding        : 8px 10px;
      border-radius  : var(--radius-sm);
      background     : transparent;
      border         : 1px solid transparent;
      color          : var(--color-text-3);
      font-size      : 12.5px;
      font-weight    : 500;
      transition     : background 150ms var(--ease),
                       border-color 150ms var(--ease),
                       color 150ms var(--ease);
    }
    .btn-logout:hover {
      background  : var(--color-danger-dim);
      border-color: var(--color-danger-border);
      color       : var(--color-danger);
    }
    .btn-logout svg { width: 14px; height: 14px; flex-shrink: 0; }

    /* ─────────────────────────────────────────
       MOBILE OVERLAY
    ───────────────────────────────────────── */
    .overlay {
      position  : fixed;
      inset     : 0;
      z-index   : 49;
      background: rgba(0,0,0,0.65);
      backdrop-filter: blur(4px);
      -webkit-backdrop-filter: blur(4px);
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
      min-height    : 100dvh;
      min-width     : 0;
      overflow-y    : auto;
      overflow-x    : hidden;
      scrollbar-width: thin;
      scrollbar-color: var(--color-surface-3) transparent;
    }
    .main-area::-webkit-scrollbar { width: 4px; }
    .main-area::-webkit-scrollbar-thumb {
      background   : var(--color-surface-4);
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
      background     : rgba(14,14,18,0.85);
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
      border-bottom  : 1px solid var(--color-border);
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
      gap        : 3px;
      flex-shrink: 0;
    }

    /* Hamburger */
    .btn-hamburger {
      display        : none;
      align-items    : center;
      justify-content: center;
      width          : 32px;
      height         : 32px;
      border-radius  : var(--radius-sm);
      background     : var(--color-surface-2);
      border         : 1px solid var(--color-border-2);
      color          : var(--color-text-2);
      flex-shrink    : 0;
      transition     : background 150ms var(--ease),
                       color 150ms var(--ease),
                       border-color 150ms;
    }
    .btn-hamburger:hover {
      background  : var(--color-surface-3);
      color       : var(--color-text-1);
      border-color: var(--color-border-3);
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
      color      : var(--color-text-3);
      font-weight: 500;
      transition : color 150ms;
      white-space: nowrap;
    }
    .breadcrumb__link:hover { color: var(--color-text-2); }

    .breadcrumb__sep {
      color    : var(--color-text-3);
      font-size: 11px;
      opacity  : 0.6;
    }

    .breadcrumb__current {
      color      : var(--color-text-1);
      font-weight: 600;
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
      width          : 32px;
      height         : 32px;
      border-radius  : var(--radius-sm);
      background     : transparent;
      border         : 1px solid transparent;
      color          : var(--color-text-2);
      transition     : background 150ms var(--ease),
                       border-color 150ms var(--ease),
                       color 150ms var(--ease);
    }
    .icon-btn:hover {
      background  : var(--color-surface-2);
      border-color: var(--color-border-2);
      color       : var(--color-text-1);
    }
    .icon-btn svg { width: 16px; height: 16px; }

    .notif-dot {
      position     : absolute;
      top          : 6px;
      right        : 6px;
      width        : 6px;
      height       : 6px;
      border-radius: 50%;
      background   : var(--color-accent);
      border       : 1.5px solid var(--color-surface);
      box-shadow   : 0 0 6px var(--color-accent);
    }

    .topbar__sep {
      width     : 1px;
      height    : 20px;
      background: var(--color-border-2);
      margin    : 0 4px;
    }

    .topbar-avatar {
      width          : 30px;
      height         : 30px;
      border-radius  : 50%;
      background     : var(--color-accent-dim);
      border         : 1.5px solid var(--color-accent-border);
      display        : flex;
      align-items    : center;
      justify-content: center;
      font-size      : 11px;
      font-weight    : 700;
      color          : var(--color-accent-light);
      text-transform : uppercase;
      flex-shrink    : 0;
      box-shadow     : 0 0 12px var(--color-accent-glow);
    }

    /* ─────────────────────────────────────────
       FLASH / ALERT
    ───────────────────────────────────────── */
    .flash-zone { padding: 18px 22px 0; }

    .alert {
      display      : flex;
      align-items  : flex-start;
      gap          : 10px;
      padding      : 12px 15px;
      border-radius: var(--radius-md);
      font-size    : 13.5px;
      font-weight  : 450;
      border       : 1px solid;
      line-height  : 1.5;
      animation    : alertIn 300ms var(--ease-spring) both;
    }
    @keyframes alertIn {
      from { opacity:0; transform: translateY(-6px); }
      to   { opacity:1; transform: translateY(0); }
    }
    .alert svg { width: 16px; height: 16px; flex-shrink: 0; margin-top: 2px; }

    .alert--success { background: var(--color-success-dim); border-color: var(--color-success-border); color: var(--color-success); }
    .alert--danger,
    .alert--error   { background: var(--color-danger-dim);  border-color: var(--color-danger-border);  color: var(--color-danger); }
    .alert--warning { background: var(--color-warning-dim); border-color: var(--color-warning-border); color: var(--color-warning); }
    .alert--info    { background: var(--color-info-dim);    border-color: var(--color-info-border);    color: var(--color-info); }

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
       RESPONSIVE — ≤ 768px
    ───────────────────────────────────────── */
    @media (max-width: 768px) {
      .sidebar {
        transform: translateX(-100%);
      }
      .sidebar--open {
        transform : translateX(0);
        box-shadow: 6px 0 40px rgba(0,0,0,0.6);
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

  /* ── Navigation structure ─────────────── */
  $navGroups = [
    'Utama' => [
      [
        'href'  => '/member/dashboard',
        'label' => 'Dashboard',
        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z"/>',
      ],
    ],
    'Akun' => [
      [
        'href'  => '/member/profile',
        'label' => 'Profil Saya',
        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>',
      ],
      [
        'href'  => '/member/surat-pernyataan',
        'label' => 'Surat Pernyataan',
        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/>',
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

  /* ── Alert icon helper ───────────────── */
  function alertIcon(string $type): string {
    return match($type) {
      'success'        => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>',
      'danger','error' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z"/></svg>',
      'warning'        => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/></svg>',
      default          => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z"/></svg>',
    };
  }

  /* ── SVG icon shorthand ──────────────── */
  function navIcon(string $path): string {
    return '<svg class="nav-link__icon" xmlns="http://www.w3.org/2000/svg" fill="none"
                 viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" aria-hidden="true">'
           . $path .
           '</svg>';
  }
?>

<div class="app-shell">

  <!-- ── Overlay (mobile) ────────────────── -->
  <div class="overlay" id="js-overlay" onclick="closeSidebar()" role="presentation"></div>

  <!-- ── Sidebar ─────────────────────────── -->
  <aside class="sidebar" id="js-sidebar" aria-label="Navigasi utama">

    <div class="sidebar__brand">
      <!-- Logo utama dari assets -->
      <img
        src="<?= BASE_URL ?>/assets/img/logo-com.png"
        alt="<?= htmlspecialchars(APP_NAME) ?>"
        class="brand__logo"
        onerror="this.classList.add('error');this.style.display='none';"
        loading="eager"
        decoding="async"
      >
      <!-- Fallback initial mark jika logo gagal dimuat -->
      <div class="brand__mark" aria-hidden="true">
        <?= htmlspecialchars(mb_strtoupper(mb_substr(APP_NAME, 0, 1))) ?>
      </div>
      <!-- Nama app tampil jika logo tidak memiliki teks yang cukup jelas — hapus jika logo sudah memuat nama -->
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

    <div class="sidebar__footer">
      <div class="user-card">
        <div class="user-card__avatar" aria-hidden="true"><?= htmlspecialchars($initials) ?></div>
        <div class="user-card__info">
          <div class="user-card__name"><?= htmlspecialchars($userName) ?></div>
          <div class="user-card__role">Anggota</div>
        </div>
        <div class="user-card__status" title="Online" aria-label="Status: online"></div>
      </div>

      <a href="<?= BASE_URL ?>/logout" class="btn-logout">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
             stroke-width="2" stroke="currentColor" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round"
                d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15M12 9l3 3m0 0-3 3m3-3H2.25"/>
        </svg>
        Keluar
      </a>
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
          <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg"
               fill="none" viewBox="0 0 24 24" stroke-width="2.25" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
          </svg>
        </button>

        <nav class="breadcrumb" aria-label="Breadcrumb">
          <a href="<?= BASE_URL ?>/member/dashboard" class="breadcrumb__link">
            <svg width="13" height="13" xmlns="http://www.w3.org/2000/svg"
                 fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.25 12 11.204 3.045c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
            </svg>
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
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
               stroke-width="1.75" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0"/>
          </svg>
          <span class="notif-dot" aria-hidden="true"></span>
        </button>

        <div class="topbar__sep" aria-hidden="true"></div>

        <div class="topbar-avatar"
             title="<?= htmlspecialchars($userName) ?>"
             aria-label="Pengguna: <?= htmlspecialchars($userName) ?>">
          <?= htmlspecialchars($initials) ?>
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

  /* Close on Escape */
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeSidebar();
  });

  /* Close sidebar when nav link clicked on mobile */
  var navLinks = sidebar.querySelectorAll('.nav-link');
  navLinks.forEach(function(link) {
    link.addEventListener('click', function() {
      if (window.innerWidth <= 768) closeSidebar();
    });
  });

  /* Show brand name text if logo fails */
  var logo      = document.querySelector('.brand__logo');
  var brandName = document.getElementById('js-brand-name');
  if (logo && brandName) {
    logo.addEventListener('error', function() {
      brandName.style.display = '';
    });
    /* Also reveal name if logo is very wide (icon-only logos look fine without text) */
  }
}());
</script>

<script src="<?= BASE_URL ?>/assets/js/main.js"></script>
</body>
</html>