<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($settings['org_name']['value'] ?? APP_NAME) ?> — COM SMKN 2 Pinrang</title>
  <meta name="description" content="<?= htmlspecialchars($settings['org_description']['value'] ?? 'Organisasi resmi COM SMKN 2 Pinrang') ?>">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/custom.css">
  <?= $extra_head ?? '' ?>
  <style>
    /* ─── FLUID ROOT ───
       Semua ukuran turunan (rem) di bawah ini otomatis mengikuti nilai ini.
       Skala dari layar kecil (~15px) sampai layar besar/PC monitor (~19px). */
    html {
      font-size: clamp(15px, 0.4vw + 12px, 19px);
    }
    :root {
      /* Base surface — sama seperti design-system.md §2 */
      --c-page:        #eef2f6;
      --c-white:       #ffffff;
      --c-ink:         #0f172a;
      --c-muted:       #64748b;
      --c-muted2:      #94a3b8;
      --c-border:      #e6ebf1;
      /* Aksen utama — SATU warna, dipakai konsisten */
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
      /* Radius (rem — ikut skala root font) */
      --radius-sm: 0.56rem;
      --radius-md: 0.81rem;
      --radius-lg: 1.38rem;
      /* Navbar & topbar height — clamp sendiri (rem + vh) supaya proporsinya
         terkontrol independen dari skala font, tidak melar berlebihan */
      --nav-h:  clamp(3.9rem, 6.2vh, 4.6rem);
      --top-h:  clamp(1.85rem, 3vh, 2.15rem);
      /* Lebar maksimum kontainer — melebar sedikit di layar sangat besar */
      --container-w: clamp(77.5rem, 64vw + 20rem, 92rem);
      --font-display: 'Plus Jakarta Sans', sans-serif;
      --font-body:    'Plus Jakarta Sans', sans-serif;
    }
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html { scroll-behavior: smooth; }
    body {
      font-family: var(--font-body);
      background: var(--c-page);
      color: var(--c-ink);
      min-height: 100vh;
      display: flex; flex-direction: column;
      -webkit-font-smoothing: antialiased;
    }
    main { flex: 1; padding-top: calc(var(--nav-h) + var(--top-h)); }
    @media(max-width: 640px) { main { padding-top: var(--nav-h); } }
    /* ─── TOPBAR ─── */
    #topbar {
      height: var(--top-h);
      background: var(--c-white);
      border-bottom: 1px solid var(--c-border);
      position: fixed; top: 0; left: 0; right: 0; z-index: 210;
      display: flex; align-items: center;
      overflow: hidden;
      transition: height .35s cubic-bezier(.22,1,.36,1), opacity .3s ease, border-color .3s ease;
    }
    #topbar.collapsed {
      height: 0; opacity: 0; border-bottom-color: transparent; pointer-events: none;
    }
    .topbar-inner {
      max-width: var(--container-w); margin: 0 auto; width: 100%; padding: 0 1.5rem;
      display: flex; align-items: center; justify-content: space-between;
    }
    .topbar-left {
      display: flex; align-items: center; gap: 0.31rem;
      font-size: 0.68rem; font-weight: 600;
      color: var(--c-muted2); letter-spacing: 0.03em;
    }
    .topbar-left span.lbl { color: var(--c-muted2); }
    #server-clock {
      font-size: 0.68rem; font-weight: 700;
      color: var(--c-primary); letter-spacing: 0.03em; min-width: 3.25rem;
    }
    .topbar-right { display: flex; align-items: center; gap: 0.75rem; }
    .topbar-right a {
      font-size: 0.68rem; color: var(--c-muted);
      text-decoration: none; letter-spacing: 0.02em; transition: color 0.18s;
      font-weight: 500;
    }
    .topbar-right a:hover { color: var(--c-primary); }
    .tb-sep { width: 1px; height: 0.625rem; background: var(--c-border); }
    @media(max-width: 640px) { #topbar { display: none; } }
    /* ─── NAVBAR ───
       Selalu tetap terlihat (fixed) saat scroll — tidak lagi disembunyikan.
       Saat halaman di-scroll: topbar mengecil ke 0 dan navbar "naik" mengisi
       posisinya (top:0), plus efek glass/blur + shadow + garis aksen tipis
       supaya terasa lebih premium & tidak polos, namun tetap balance dengan
       warna netral Design System. */
    #nav {
      position: fixed; top: var(--top-h); left: 0; right: 0; z-index: 200;
      height: var(--nav-h);
      background: var(--c-white);
      border-bottom: 1px solid var(--c-border);
      box-shadow: 0 1px 0 rgba(15,23,42,.02);
      transition:
        top .35s cubic-bezier(.22,1,.36,1),
        box-shadow .35s ease,
        background .35s ease,
        border-color .35s ease,
        backdrop-filter .35s ease;
    }
    @media(max-width: 640px) { #nav { top: 0; } }
    #nav::after {
      content: '';
      position: absolute; left: 0; right: 0; bottom: -1px; height: 2px;
      background: linear-gradient(90deg, transparent, rgba(14,116,144,.35), rgba(6,182,212,.28), transparent);
      opacity: 0;
      transition: opacity .35s ease;
      pointer-events: none;
    }
    #nav.pinned { top: 0; }
    #nav.scrolled {
      background: rgba(255,255,255,.86);
      backdrop-filter: saturate(180%) blur(14px);
      -webkit-backdrop-filter: saturate(180%) blur(14px);
      border-color: rgba(230,235,241,.75);
      box-shadow: 0 16px 40px -20px rgba(15,23,42,.20), 0 3px 12px rgba(15,23,42,.06);
    }
    #nav.scrolled::after { opacity: 1; }
    .nav-wrap {
      max-width: var(--container-w); margin: 0 auto; height: var(--nav-h);
      display: flex; align-items: center; justify-content: space-between;
      padding: 0 1.5rem;
    }
    .nav-brand { display: flex; align-items: center; gap: 0.625rem; text-decoration: none; flex-shrink: 0; }
    .nav-brand-logo {
      width: 2.13rem; height: 2.13rem; object-fit: contain; display: block; flex-shrink: 0;
      transition: opacity .2s, transform .3s cubic-bezier(.22,1,.36,1);
    }
    .nav-brand:hover .nav-brand-logo { opacity: .85; transform: rotate(-5deg) scale(1.05); }
    .nav-brand-name {
      font-family: var(--font-display); font-weight: 800; font-size: .95rem;
      color: var(--c-primary-dk); letter-spacing: -.025em; line-height: 1; display: block;
      transition: color .18s;
    }
    .nav-brand:hover .nav-brand-name { color: var(--c-primary); }
    .nav-brand-sub {
      font-size: .62rem; color: var(--c-muted2); font-weight: 600;
      letter-spacing: .07em; text-transform: uppercase; display: block; margin-top: 0.19rem;
    }
    .nav-sep { width: 1px; height: 1.25rem; background: var(--c-border); flex-shrink: 0; }
    /* ─── NAV LINKS ───
       FIX: link jadi flex container (icon + <span> teks) supaya ikon
       otomatis center secara vertikal terhadap teks — tidak lagi
       bergantung pada vertical-align inline yang gampang meleset. */
    .nav-links { display: flex; align-items: center; gap: 0.125rem; }
    .nav-link {
      position: relative;
      display: inline-flex;
      align-items: center;
      gap: 0.4rem;
      font-size: .82rem; font-weight: 600; color: var(--c-muted);
      text-decoration: none; padding: 0.5rem 0.75rem; border-radius: var(--radius-sm);
      transition: color .18s, background .18s; letter-spacing: -.01em; white-space: nowrap;
      line-height: 1;
    }
    .nav-link:hover { color: var(--c-ink); background: #f4f7fa; }
    .nav-link.active { color: var(--c-primary); }
    .nav-link.active::after {
      content: ''; position: absolute; bottom: 0; left: 50%; transform: translateX(-50%);
      width: 0.875rem; height: 2px; border-radius: 2px; background: var(--c-primary);
    }
    .nav-link-icon {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 0.95rem;
      line-height: 1;
      color: var(--c-muted2);
      flex-shrink: 0;
    }
    .nav-link:hover .nav-link-icon,
    .nav-link.active .nav-link-icon { color: currentColor; }
    /* ─── DROPDOWN (hover-based) ─── */
    .nav-dd { position: relative; }
    .nav-dd::after {
      content: ''; position: absolute; top: 100%; left: 0; right: 0; height: 0.75rem; background: transparent;
    }
    .nav-dd-toggle {
      display: flex; align-items: center; gap: 0.25rem;
      font-size: .82rem; font-weight: 600; color: var(--c-muted);
      background: none; border: none; cursor: pointer;
      padding: 0.5rem 0.75rem; border-radius: var(--radius-sm);
      transition: color .18s, background .18s;
      font-family: var(--font-body);
      letter-spacing: -.01em;
      user-select: none;
      line-height: 1;
    }
    .nav-dd-toggle:hover,
    .nav-dd:hover .nav-dd-toggle { color: var(--c-ink); background: #f4f7fa; }
    .nav-dd-toggle .dd-chevron { transition: transform .25s cubic-bezier(.22,1,.36,1); flex-shrink: 0; }
    .nav-dd:hover .nav-dd-toggle .dd-chevron { transform: rotate(180deg); }
    .nav-dd-menu {
      visibility: hidden; opacity: 0; pointer-events: none;
      position: absolute; top: calc(100% + 0.625rem); left: 50%;
      transform: translateX(-50%) translateY(-6px) scale(.97);
      min-width: 13.75rem;
      background: var(--c-white);
      border: 1px solid var(--c-border);
      border-radius: var(--radius-md);
      padding: .5rem;
      box-shadow: 0 30px 70px -20px rgba(15,23,42,.28), 0 4px 18px rgba(15,23,42,.06);
      z-index: 300;
      transition: opacity .22s cubic-bezier(.22,1,.36,1), transform .22s cubic-bezier(.22,1,.36,1), visibility .22s;
    }
    .nav-dd:hover .nav-dd-menu {
      visibility: visible; opacity: 1; pointer-events: all;
      transform: translateX(-50%) translateY(0) scale(1);
    }
    .nav-dd-menu::before {
      content: ''; position: absolute; top: -1px; left: 1.25rem; right: 1.25rem; height: 1px;
      background: linear-gradient(90deg, transparent, rgba(14,116,144,.35), transparent);
      border-radius: 1px;
    }
    .dd-header {
      padding: 0.38rem 0.75rem 0.25rem; font-size: .62rem; color: var(--c-muted2);
      text-transform: uppercase; letter-spacing: .1em; font-weight: 700;
    }
    .dd-item {
      display: flex; align-items: center; gap: 0.625rem;
      padding: 0.56rem 0.75rem; border-radius: var(--radius-sm);
      font-size: .84rem; font-weight: 600; color: var(--c-ink);
      text-decoration: none; transition: color .15s, background .15s, transform .18s;
      position: relative; overflow: hidden;
    }
    .dd-item:hover { background: #f4f7fa; transform: translateX(2px); }
    .dd-item-icon {
      width: 1.88rem; height: 1.88rem; flex-shrink: 0;
      background: rgba(14,116,144,.08);
      border: 1px solid rgba(14,116,144,.14);
      border-radius: 0.44rem;
      display: flex; align-items: center; justify-content: center;
      color: var(--c-primary);
      transition: background .18s, border-color .18s, transform .18s;
      font-size: 0.94rem;
    }
    .dd-item:hover .dd-item-icon { background: rgba(14,116,144,.14); border-color: rgba(14,116,144,.3); transform: scale(1.08); }
    .dd-item-text { display: flex; flex-direction: column; gap: 1px; }
    .dd-item-label { font-size: .84rem; font-weight: 700; color: inherit; line-height: 1; }
    .dd-item-desc  { font-size: .7rem; color: var(--c-muted); line-height: 1.3; }
    .dd-sep { height: 1px; background: var(--c-border); margin: .35rem .5rem; }
    .dd-footer {
      padding: 0.38rem 0.625rem 0.13rem; display: flex; align-items: center; gap: 0.31rem;
      font-size: .68rem; color: var(--c-muted2); font-weight: 500;
    }
    .dd-footer-dot { width: 0.31rem; height: 0.31rem; border-radius: 50%; background: var(--c-green-text); animation: fp 2.4s ease-in-out infinite; }
    /* Mobile sub-menu */
    .mob-sub { padding-left: 1rem; display: none; }
    .mob-sub.open { display: block; }
    .mob-sub-item {
      display: flex; align-items: center; gap: 0.44rem;
      font-size: .84rem; color: var(--c-muted); font-weight: 600;
      text-decoration: none; padding: .55rem .75rem; border-radius: var(--radius-sm);
      transition: color .15s, background .15s;
    }
    .mob-sub-item:hover { color: var(--c-ink); background: #f4f7fa; }
    /* ─── TOMBOL AKSI NAVBAR ───
       Daftar PAB (ghost) & Masuk/Dashboard (CTA) disamakan tinggi, padding,
       radius, dan ukuran ikon supaya terlihat sepasang tombol yang seimbang
       dan profesional, bukan dua tombol berbeda bobot. */
    .nav-actions { display: flex; align-items: center; gap: 0.5rem; }
    .nav-btn-ghost,
    .nav-btn-cta {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.4rem;
      height: 2.5rem;
      padding: 0 1.05rem;
      font-size: .82rem;
      font-weight: 700;
      border-radius: var(--radius-sm);
      text-decoration: none;
      letter-spacing: -.01em;
      line-height: 1;
      white-space: nowrap;
      transition: background .18s, border-color .18s, color .18s, transform .12s, box-shadow .18s;
    }
    .nav-btn-ghost i,
    .nav-btn-cta i { font-size: 0.95rem; line-height: 1; }
    .nav-btn-ghost {
      color: var(--c-ink);
      background: var(--c-white);
      border: 1.5px solid var(--c-border);
    }
    .nav-btn-ghost:hover {
      background: #f4f7fa;
      border-color: #d7dee7;
      transform: translateY(-1px);
    }
    .nav-btn-cta {
      color: #fff;
      background: var(--c-primary);
      border: 1.5px solid var(--c-primary);
      box-shadow: 0 8px 20px rgba(14,116,144,.22);
    }
    .nav-btn-cta:hover {
      background: var(--c-primary-lt);
      border-color: var(--c-primary-lt);
      box-shadow: 0 12px 26px rgba(6,182,212,.28);
      transform: translateY(-2px);
    }
    .hamburger {
      display: none; flex-direction: column; gap: 0.25rem; cursor: pointer;
      padding: 0.5rem; background: var(--c-white);
      border: 1.5px solid var(--c-border); border-radius: var(--radius-sm);
    }
    .hamburger span {
      display: block; width: 1.13rem; height: 1.5px;
      background: var(--c-muted); border-radius: 2px;
      transition: all .3s cubic-bezier(.22,1,.36,1);
    }
    .hamburger.open span:nth-child(1) { transform: rotate(45deg) translate(4px,4px); }
    .hamburger.open span:nth-child(2) { opacity:0; transform: scaleX(0); }
    .hamburger.open span:nth-child(3) { transform: rotate(-45deg) translate(4px,-4px); }
    .mobile-drawer {
      position: fixed; top: calc(var(--nav-h) + var(--top-h)); left:0; right:0; z-index:199;
      background: var(--c-white);
      border-bottom: 1px solid var(--c-border);
      box-shadow: 0 24px 48px -20px rgba(15,23,42,.18);
      padding: .75rem 1.25rem 1.25rem;
      display: flex; flex-direction: column; gap: 1px;
      transform: translateY(-110%); opacity:0;
      transition: transform .35s cubic-bezier(.22,1,.36,1), opacity .28s, top .35s cubic-bezier(.22,1,.36,1);
      pointer-events: none;
    }
    @media(max-width:640px) { .mobile-drawer { top: var(--nav-h); } }
    .mobile-drawer.open { transform: translateY(0); opacity:1; pointer-events:all; }
    .mob-link {
      display: flex; align-items: center; justify-content: space-between;
      font-size: .88rem; font-weight: 700; color: var(--c-ink);
      text-decoration: none; padding: .68rem .75rem; border-radius: var(--radius-sm);
      transition: color .18s, background .18s;
    }
    .mob-link:hover { background: #f4f7fa; }
    .mob-link svg { opacity:.35; transition: opacity .18s; color: var(--c-muted2); }
    .mob-link:hover svg { opacity:.8; }
    .mob-sep { height:1px; background: var(--c-border); margin: .5rem 0; }
    .mob-actions { display:flex; gap:0.44rem; }
    .mob-ghost {
      flex:1; padding:0.69rem; text-align:center; font-size:.83rem; font-weight:700;
      color: var(--c-ink); border:1.5px solid var(--c-border); border-radius:var(--radius-sm);
      text-decoration:none; transition: all .18s; background: var(--c-white);
    }
    .mob-ghost:hover { background: #f4f7fa; }
    .mob-cta {
      flex:1; padding:0.69rem; text-align:center; background: var(--c-primary);
      font-size:.83rem; font-weight:800; color:#fff; border-radius:var(--radius-sm);
      text-decoration:none; transition: all .18s;
    }
    .mob-cta:hover { background: var(--c-primary-lt); }
    @media(max-width:860px) { .nav-links,.nav-actions,.nav-sep { display:none; } .hamburger { display:flex; } }
    /* ─── ALERT ─── */
    .alert-wrap { max-width: var(--container-w); margin:1rem auto; padding:0 1.5rem; }
    .alert {
      display:flex; align-items:center; gap:0.56rem; padding:0.75rem 1rem; border-radius:var(--radius-md);
      font-size:.85rem; font-weight:600; border:1px solid; animation: aIn .25s ease;
    }
    @keyframes aIn { from { opacity:0; transform:translateY(-5px); } to { opacity:1; transform:translateY(0); } }
    .alert-error   { background: var(--c-red-bg);   border-color: var(--c-red-border);   color: var(--c-red-text); }
    .alert-success { background: var(--c-green-bg); border-color: var(--c-green-border); color: var(--c-green-text); }
    .alert-info    { background: var(--c-amber-bg); border-color: var(--c-amber-border); color: var(--c-amber-text); }
    /* ─── FOOTER ─── */
    .site-footer { position:relative; overflow:hidden; background: var(--c-white); border-top:1px solid var(--c-border); }
    .site-footer::before {
      content:''; position:absolute; top:0; left:50%; transform:translateX(-50%);
      width:37.5rem; height:1px;
      background:linear-gradient(90deg, transparent, rgba(14,116,144,.35), rgba(6,182,212,.25), transparent);
    }
    .footer-inner { max-width: var(--container-w); margin:0 auto; padding:0 1.5rem 2.5rem; position:relative; z-index:1; }
    .f-grid {
      display:grid; grid-template-columns:2.1fr 1fr 1fr 1.1fr;
      gap:3rem; padding:3.5rem 0 3rem; border-bottom:1px solid var(--c-border);
    }
    @media(max-width:900px) { .f-grid { grid-template-columns:1fr 1fr; gap:2.5rem; } }
    @media(max-width:520px) { .f-grid { grid-template-columns:1fr; gap:2rem; } }
    .fb-row { display:flex; align-items:center; gap:0.56rem; text-decoration:none; margin-bottom:.9rem; width:fit-content; }
    .fb-logo { width:2.25rem; height:2.25rem; object-fit:contain; display:block; flex-shrink:0; transition:opacity .18s; }
    .fb-row:hover .fb-logo { opacity:.85; }
    .fb-name { font-family:var(--font-display); font-weight:800; font-size:.9rem; color: var(--c-primary-dk); letter-spacing:-.022em; display:block; transition:color .18s; }
    .fb-row:hover .fb-name { color: var(--c-primary); }
    .fb-sub  { font-size:.62rem; color: var(--c-muted2); font-weight:600; letter-spacing:.07em; text-transform:uppercase; display:block; margin-top:0.13rem; }
    .fb-desc { font-size:.83rem; color: var(--c-muted); line-height:1.9; margin-bottom:1.4rem; max-width:18.13rem; }
    .fb-socials { display:flex; gap:0.38rem; margin-bottom:1.5rem; }
    .fb-social {
      width:2.13rem; height:2.13rem; border-radius:var(--radius-sm); background: var(--c-white);
      border:1.5px solid var(--c-border); display:flex; align-items:center; justify-content:center;
      color: var(--c-muted); text-decoration:none; transition: all .22s cubic-bezier(.22,1,.36,1); font-size:0.94rem;
    }
    .fb-social:hover { background: #f4f7fa; border-color: rgba(14,116,144,.3); color: var(--c-primary); transform:translateY(-2px); box-shadow:0 6px 16px rgba(14,116,144,.12); }
    .fb-nl-lbl { font-size:.68rem; color: var(--c-muted); font-weight:700; text-transform:uppercase; letter-spacing:.08em; display:block; margin-bottom:0.38rem; }
    .fb-nl-row { display:flex; gap:0.31rem; }
    .fb-nl-inp {
      flex:1; background: #fbfcfe; border:1.5px solid var(--c-border); border-radius:var(--radius-sm);
      padding:0.625rem 0.81rem; font-family:var(--font-body); font-size:.82rem; color: var(--c-ink); outline:none;
      transition: border-color .16s, box-shadow .16s, background .16s;
    }
    .fb-nl-inp::placeholder { color: var(--c-muted2); }
    .fb-nl-inp:focus { border-color: var(--c-primary-lt); box-shadow:0 0 0 3px rgba(6,182,212,.12); background:#fff; }
    .fb-nl-btn {
      padding:0.625rem 1rem; background: var(--c-primary); border:none; border-radius:var(--radius-sm);
      font-family:var(--font-body); font-size:.82rem; font-weight:800; color:#fff;
      cursor:pointer; transition: all .18s; white-space:nowrap;
    }
    .fb-nl-btn:hover { background: var(--c-primary-lt); transform:translateY(-1px); }
    .fc-head { display:flex; align-items:center; gap:0.5rem; margin-bottom:1rem; }
    .fc-head h4 { font-size:.68rem; font-weight:700; text-transform:uppercase; letter-spacing:.1em; color: var(--c-primary); white-space:nowrap; }
    .fc-line { flex:1; height:1px; background:linear-gradient(90deg,rgba(14,116,144,.25),transparent); }
    .fc-ul { list-style:none; }
    .fc-ul li { margin-bottom:.4rem; }
    .fc-ul li a {
      font-size:.82rem; color: var(--c-muted); font-weight:500; text-decoration:none;
      display:inline-flex; align-items:center; gap:0.38rem; transition: color .18s, gap .18s;
    }
    .fc-ul li a::before { content:''; display:block; width:0.25rem; height:1px; background: var(--c-muted2); border-radius:1px; flex-shrink:0; transition: width .18s, background .18s; }
    .fc-ul li a:hover { color: var(--c-ink); gap:0.56rem; }
    .fc-ul li a:hover::before { width:0.5rem; background: var(--c-primary); }
    .fc-contacts { display:flex; flex-direction:column; gap:2px; }
    .fc-ci {
      display:flex; align-items:flex-start; gap:0.56rem; padding:0.5rem 0.56rem; border-radius:var(--radius-sm);
      border:1px solid transparent; transition: background .18s, border-color .18s;
    }
    .fc-ci:hover { background: #f8fafc; border-color: var(--c-border); }
    .fc-ci-icon {
      width:1.75rem; height:1.75rem; flex-shrink:0; background:rgba(14,116,144,.08);
      border:1px solid rgba(14,116,144,.14); border-radius:0.44rem;
      display:flex; align-items:center; justify-content:center; color: var(--c-primary); font-size:0.81rem;
    }
    .fc-ci-lbl { font-size:.65rem; color: var(--c-muted2); font-weight:700; text-transform:uppercase; letter-spacing:.06em; display:block; margin-bottom:1px; }
    .fc-ci-val { font-size:.8rem; color: var(--c-muted); line-height:1.45; }
    .fc-ci-val a { color: var(--c-muted); text-decoration:none; transition:color .18s; }
    .fc-ci-val a:hover { color: var(--c-primary); }
    .f-bottom { padding-top:1.75rem; display:flex; align-items:center; justify-content:space-between; gap:1rem; flex-wrap:wrap; }
    .f-copy { font-size:.76rem; color: var(--c-muted); }
    .f-bottom-r { display:flex; align-items:center; gap:0.75rem; }
    .f-policy { display:flex; gap:0.75rem; }
    .f-policy a { font-size:.7rem; color: var(--c-muted); text-decoration:none; font-weight:600; letter-spacing:.02em; transition:color .18s; text-transform:uppercase; }
    .f-policy a:hover { color: var(--c-primary); }
    .f-vsep { width:1px; height:0.75rem; background: var(--c-border); }
    .f-clock-badge {
      display:inline-flex; align-items:center; gap:0.38rem; font-size:.68rem; font-weight:600; color: var(--c-muted);
      background: #f4f7fa; border:1px solid var(--c-border);
      padding:0.25rem 0.625rem; border-radius:var(--radius-sm);
    }
    .f-clk-dot { width:0.31rem; height:0.31rem; border-radius:50%; background: var(--c-green-text); flex-shrink:0; animation:fp 2.4s ease-in-out infinite; }
    @keyframes fp { 0%,100%{opacity:1} 50%{opacity:.3} }
    #footer-clock { color: var(--c-primary); }
    #back-top {
      position:fixed; right:1.5rem; bottom:2rem; z-index:150;
      width:2.63rem; height:2.63rem; background: var(--c-white); border:1.5px solid var(--c-border);
      border-radius:var(--radius-sm); display:flex; align-items:center; justify-content:center;
      color: var(--c-primary); cursor:pointer;
      opacity:0; transform:translateY(10px) scale(.92);
      transition: all .3s cubic-bezier(.22,1,.36,1); box-shadow:0 12px 28px -10px rgba(15,23,42,.22);
    }
    #back-top.show { opacity:1; transform:translateY(0) scale(1); }
    #back-top:hover { background: var(--c-primary); color:#fff; transform:translateY(-3px) scale(1.04); box-shadow:0 14px 30px rgba(14,116,144,.28); }
    [data-reveal] { opacity:0; transform:translateY(16px); transition: opacity .5s ease, transform .5s ease; }
    [data-reveal]._vis { opacity:1; transform:translateY(0); }
  </style>
</head>
<body>
<!-- ══ TOPBAR ══ -->
<div id="topbar">
  <div class="topbar-inner">
    <div class="topbar-left">
      <span class="lbl">Server</span>
      <div id="server-clock">--:--:--</div>
      <span class="lbl">WITA</span>
    </div>
    <div class="topbar-right">
      <?php if (!empty($settings['social_instagram']['value'])): ?>
        <a href="https://instagram.com/<?= htmlspecialchars($settings['social_instagram']['value']) ?>" target="_blank" rel="noopener">Instagram</a>
        <div class="tb-sep"></div>
      <?php endif; ?>
      <?php if (!empty($settings['social_tiktok']['value'])): ?>
        <a href="https://tiktok.com/@<?= htmlspecialchars($settings['social_tiktok']['value']) ?>" target="_blank" rel="noopener">TikTok</a>
        <div class="tb-sep"></div>
      <?php endif; ?>
      <?php if (!empty($settings['contact_email']['value'])): ?>
        <a href="mailto:<?= htmlspecialchars($settings['contact_email']['value']) ?>"><?= htmlspecialchars($settings['contact_email']['value']) ?></a>
      <?php endif; ?>
    </div>
  </div>
</div>
<!-- ══ NAVBAR ══ -->
<nav id="nav">
  <div class="nav-wrap">
    <a href="<?= BASE_URL ?>/" class="nav-brand">
      <?php if (!empty($settings['org_logo']['value'])): ?>
        <img src="<?= UPLOAD_URL . '/' . htmlspecialchars($settings['org_logo']['value']) ?>" class="nav-brand-logo" alt="Logo">
      <?php else: ?>
        <img src="<?= BASE_URL ?>/assets/img/logo-com.png" class="nav-brand-logo" alt="COM Logo">
      <?php endif; ?>
      <div>
        <span class="nav-brand-name"><?= htmlspecialchars($settings['org_name']['value'] ?? APP_NAME) ?></span>
        <span class="nav-brand-sub">SMKN 2 Pinrang</span>
      </div>
    </a>
    <div class="nav-sep"></div>
    <div class="nav-links">
      <a href="<?= BASE_URL ?>/" class="nav-link" data-page="home">
        <i class="ti ti-home nav-link-icon"></i>
        <span>Home</span>
      </a>
      <a href="<?= BASE_URL ?>/#about"    class="nav-link"><span>Tentang</span></a>
      <a href="<?= BASE_URL ?>/#features" class="nav-link"><span>Layanan</span></a>
      <a href="<?= BASE_URL ?>/#programs" class="nav-link"><span>Program</span></a>
      <!-- Dropdown: Konten — hover only, no JS click needed -->
      <div class="nav-dd" id="dd-konten">
        <button class="nav-dd-toggle" type="button" aria-haspopup="true" aria-expanded="false">
          Konten
          <i class="ti ti-chevron-down dd-chevron" style="font-size:0.88em"></i>
        </button>
        <div class="nav-dd-menu" role="menu">
          <div class="dd-header">Konten &amp; Media</div>
          <a href="<?= BASE_URL ?>/berita" class="dd-item" role="menuitem">
            <div class="dd-item-icon"><i class="ti ti-news"></i></div>
            <div class="dd-item-text">
              <span class="dd-item-label">Berita &amp; Artikel</span>
              <span class="dd-item-desc">Info &amp; pengumuman terbaru</span>
            </div>
          </a>
          <div class="dd-sep"></div>
          <a href="<?= BASE_URL ?>/galeri" class="dd-item" role="menuitem">
            <div class="dd-item-icon"><i class="ti ti-photo"></i></div>
            <div class="dd-item-text">
              <span class="dd-item-label">Galeri Foto</span>
              <span class="dd-item-desc">Dokumentasi kegiatan COM</span>
            </div>
          </a>
          <div class="dd-footer">
            <span class="dd-footer-dot"></span>
            Diperbarui secara berkala
          </div>
        </div>
      </div>
      <a href="<?= BASE_URL ?>/#contact" class="nav-link"><span>Kontak</span></a>
    </div>
    <div class="nav-actions">
      <?php if (empty($_SESSION['user_id'])): ?>
        <a href="<?= BASE_URL ?>/pab" class="nav-btn-ghost">
          <i class="ti ti-user-plus"></i>
          <span>Daftar PAB</span>
        </a>
        <a href="<?= BASE_URL ?>/login" class="nav-btn-cta">
          <i class="ti ti-login-2"></i>
          <span>Masuk</span>
        </a>
      <?php else: ?>
        <a href="<?= BASE_URL ?>/<?= $_SESSION['user_role'] === 'admin' ? 'admin' : 'member' ?>/dashboard" class="nav-btn-cta">
          <i class="ti ti-layout-dashboard"></i>
          <span>Dashboard</span>
        </a>
      <?php endif; ?>
    </div>
    <button class="hamburger" id="hamburger" aria-label="Toggle menu">
      <span></span><span></span><span></span>
    </button>
  </div>
</nav>
<!-- ══ MOBILE DRAWER ══ -->
<div class="mobile-drawer" id="mobile-drawer">
  <a href="<?= BASE_URL ?>/" class="mob-link">
    Home
    <i class="ti ti-chevron-right"></i>
  </a>
  <a href="<?= BASE_URL ?>/#about"    class="mob-link">Tentang Kami <i class="ti ti-chevron-right"></i></a>
  <a href="<?= BASE_URL ?>/#features" class="mob-link">Layanan <i class="ti ti-chevron-right"></i></a>
  <a href="<?= BASE_URL ?>/#programs" class="mob-link">Program <i class="ti ti-chevron-right"></i></a>
  <!-- Konten sub-menu mobile -->
  <div>
    <button onclick="this.nextElementSibling.classList.toggle('open')"
            style="width:100%;display:flex;align-items:center;justify-content:space-between;font-size:.88rem;font-weight:700;color:var(--c-ink);background:none;border:none;cursor:pointer;padding:.68rem .75rem;border-radius:var(--radius-sm);font-family:var(--font-body)">
      Konten
      <i class="ti ti-chevron-down"></i>
    </button>
    <div class="mob-sub">
      <a href="<?= BASE_URL ?>/berita" class="mob-sub-item">
        <i class="ti ti-news"></i>
        Berita &amp; Artikel
      </a>
      <a href="<?= BASE_URL ?>/galeri" class="mob-sub-item">
        <i class="ti ti-photo"></i>
        Galeri Foto
      </a>
    </div>
  </div>
  <a href="<?= BASE_URL ?>/#contact" class="mob-link">Kontak <i class="ti ti-chevron-right"></i></a>
  <div class="mob-sep"></div>
  <div class="mob-actions">
    <?php if (empty($_SESSION['user_id'])): ?>
      <a href="<?= BASE_URL ?>/pab"   class="mob-ghost">Daftar PAB</a>
      <a href="<?= BASE_URL ?>/login" class="mob-cta">Masuk Portal</a>
    <?php else: ?>
      <a href="<?= BASE_URL ?>/<?= $_SESSION['user_role'] === 'admin' ? 'admin' : 'member' ?>/dashboard" class="mob-cta" style="flex:1">Dashboard</a>
    <?php endif; ?>
  </div>
</div>
<!-- Alert -->
<?php if (!empty($flash)): ?>
<div class="alert-wrap">
  <div class="alert alert-<?= $flash['type'] ?>">
    <i class="ti ti-alert-circle" style="font-size:1em"></i>
    <?= $flash['msg'] ?>
  </div>
</div>
<?php endif; ?>
<main><?= $content ?></main>
<!-- ══ FOOTER ══ -->
<footer class="site-footer">
  <div class="footer-inner">
    <div class="f-grid">
      <!-- Brand -->
      <div data-reveal>
        <a href="<?= BASE_URL ?>/" class="fb-row">
          <?php if (!empty($settings['org_logo']['value'])): ?>
            <img src="<?= UPLOAD_URL . '/' . htmlspecialchars($settings['org_logo']['value']) ?>" class="fb-logo" alt="Logo">
          <?php else: ?>
            <img src="<?= BASE_URL ?>/assets/img/logo-com.png" class="fb-logo" alt="COM Logo">
          <?php endif; ?>
          <div>
            <span class="fb-name"><?= htmlspecialchars($settings['org_name']['value'] ?? APP_NAME) ?></span>
            <span class="fb-sub">SMKN 2 Pinrang</span>
          </div>
        </a>
        <p class="fb-desc"><?= htmlspecialchars($settings['org_description']['value'] ?? 'Organisasi siswa resmi SMKN 2 Pinrang yang berfokus pada pengembangan teknologi, kreativitas, dan kepemimpinan.') ?></p>
        <div class="fb-socials">
          <?php if (!empty($settings['social_instagram']['value'])): ?>
          <a href="https://instagram.com/<?= htmlspecialchars($settings['social_instagram']['value']) ?>" class="fb-social" target="_blank" rel="noopener" title="Instagram">
            <i class="ti ti-brand-instagram"></i>
          </a>
          <?php endif; ?>
          <?php if (!empty($settings['social_tiktok']['value'])): ?>
          <a href="https://tiktok.com/@<?= htmlspecialchars($settings['social_tiktok']['value']) ?>" class="fb-social" target="_blank" rel="noopener" title="TikTok">
            <i class="ti ti-brand-tiktok"></i>
          </a>
          <?php endif; ?>
          <?php if (!empty($settings['social_youtube']['value'])): ?>
          <a href="<?= htmlspecialchars($settings['social_youtube']['value']) ?>" class="fb-social" target="_blank" rel="noopener" title="YouTube">
            <i class="ti ti-brand-youtube"></i>
          </a>
          <?php endif; ?>
          <?php if (!empty($settings['contact_phone']['value'])): ?>
          <a href="https://wa.me/<?= preg_replace('/\D/','',$settings['contact_phone']['value']) ?>" class="fb-social" target="_blank" rel="noopener" title="WhatsApp">
            <i class="ti ti-brand-whatsapp"></i>
          </a>
          <?php endif; ?>
        </div>
        <span class="fb-nl-lbl">Tetap Terhubung</span>
        <div class="fb-nl-row">
          <input type="email" placeholder="Email kamu" class="fb-nl-inp" id="nl-inp">
          <button class="fb-nl-btn" id="nl-btn">Ikuti</button>
        </div>
      </div>
      <!-- Navigasi -->
      <div data-reveal>
        <div class="fc-head"><h4>Navigasi</h4><div class="fc-line"></div></div>
        <ul class="fc-ul">
          <li><a href="<?= BASE_URL ?>/">Home</a></li>
          <li><a href="<?= BASE_URL ?>/#about">Tentang Kami</a></li>
          <li><a href="<?= BASE_URL ?>/#features">Platform Digital</a></li>
          <li><a href="<?= BASE_URL ?>/#programs">Program Kegiatan</a></li>
          <li><a href="<?= BASE_URL ?>/berita">Berita &amp; Artikel</a></li>
          <li><a href="<?= BASE_URL ?>/galeri">Galeri Foto</a></li>
          <li><a href="<?= BASE_URL ?>/#contact">Hubungi Kami</a></li>
        </ul>
      </div>
      <!-- Anggota -->
      <div data-reveal>
        <div class="fc-head"><h4>Anggota</h4><div class="fc-line"></div></div>
        <ul class="fc-ul">
          <li><a href="<?= BASE_URL ?>/pab">Pendaftaran PAB</a></li>
          <li><a href="<?= BASE_URL ?>/login">Login Portal</a></li>
          <?php if (!empty($_SESSION['user_id'])): ?>
          <li><a href="<?= BASE_URL ?>/member/dashboard">Dashboard</a></li>
          <li><a href="<?= BASE_URL ?>/member/profile">Profil Saya</a></li>
          <?php endif; ?>
          <li><a href="<?= BASE_URL ?>/#faq">FAQ</a></li>
        </ul>
      </div>
      <!-- Kontak -->
      <div data-reveal>
        <div class="fc-head"><h4>Kontak</h4><div class="fc-line"></div></div>
        <div class="fc-contacts">
          <?php if (!empty($settings['social_instagram']['value'])): ?>
          <div class="fc-ci">
            <div class="fc-ci-icon"><i class="ti ti-brand-instagram"></i></div>
            <div><span class="fc-ci-lbl">Instagram</span><span class="fc-ci-val"><a href="https://instagram.com/<?= htmlspecialchars($settings['social_instagram']['value']) ?>" target="_blank" rel="noopener">@<?= htmlspecialchars($settings['social_instagram']['value']) ?></a></span></div>
          </div>
          <?php endif; ?>
          <?php if (!empty($settings['social_tiktok']['value'])): ?>
          <div class="fc-ci">
            <div class="fc-ci-icon"><i class="ti ti-brand-tiktok"></i></div>
            <div><span class="fc-ci-lbl">TikTok</span><span class="fc-ci-val"><a href="https://tiktok.com/@<?= htmlspecialchars($settings['social_tiktok']['value']) ?>" target="_blank" rel="noopener">@<?= htmlspecialchars($settings['social_tiktok']['value']) ?></a></span></div>
          </div>
          <?php endif; ?>
          <?php if (!empty($settings['contact_email']['value'])): ?>
          <div class="fc-ci">
            <div class="fc-ci-icon"><i class="ti ti-mail"></i></div>
            <div><span class="fc-ci-lbl">Email</span><span class="fc-ci-val"><a href="mailto:<?= htmlspecialchars($settings['contact_email']['value']) ?>"><?= htmlspecialchars($settings['contact_email']['value']) ?></a></span></div>
          </div>
          <?php endif; ?>
          <?php if (!empty($settings['contact_address']['value'])): ?>
          <div class="fc-ci">
            <div class="fc-ci-icon"><i class="ti ti-map-pin"></i></div>
            <div><span class="fc-ci-lbl">Alamat</span><span class="fc-ci-val"><?= htmlspecialchars($settings['contact_address']['value']) ?></span></div>
          </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <!-- Bottom -->
    <div class="f-bottom">
      <p class="f-copy"><?= htmlspecialchars($settings['footer_text']['value'] ?? '© ' . date('Y') . ' ' . ($settings['org_name']['value'] ?? APP_NAME) . '. All rights reserved.') ?></p>
      <div class="f-bottom-r">
        <div class="f-policy"><a href="#">Privasi</a><a href="#">Ketentuan</a></div>
        <div class="f-vsep"></div>
        <div class="f-clock-badge">
          <span class="f-clk-dot"></span>
          <span id="footer-clock">--:--:--</span>&nbsp;WIB
        </div>
      </div>
    </div>
  </div>
</footer>
<button id="back-top" aria-label="Kembali ke atas">
  <i class="ti ti-arrow-up" style="font-size:0.94em"></i>
</button>
<script>
(function(){
  /* ── Clock ── */
  function tick(){
    const d=new Date(), u=new Date(d.getTime()+8*3600000);
    const t=[u.getUTCHours(),u.getUTCMinutes(),u.getUTCSeconds()].map(n=>String(n).padStart(2,'0')).join(':');
    ['server-clock','footer-clock'].forEach(id=>{ const el=document.getElementById(id); if(el) el.textContent=t; });
  }
  tick(); setInterval(tick,1000);
  /* ── Scroll: navbar tetap terlihat (fixed), topbar mengecil,
        navbar naik ke top:0 + efek glass/shadow untuk kesan premium ── */
  const nav=document.getElementById('nav');
  const topbar=document.getElementById('topbar');
  window.addEventListener('scroll',()=>{
    const y=window.scrollY;
    nav.classList.toggle('scrolled', y>24);
    const collapsed = y>120;
    if (topbar) topbar.classList.toggle('collapsed', collapsed);
    nav.classList.toggle('pinned', collapsed);
  },{passive:true});
  /* ── Mobile drawer ── */
  const btn=document.getElementById('hamburger'),drw=document.getElementById('mobile-drawer');
  btn.addEventListener('click',()=>{
    btn.classList.toggle('open'); drw.classList.toggle('open');
    document.body.style.overflow=drw.classList.contains('open')?'hidden':'';
  });
  drw.querySelectorAll('a').forEach(a=>a.addEventListener('click',()=>{
    btn.classList.remove('open'); drw.classList.remove('open');
    document.body.style.overflow='';
  }));
  /* ── Back to top ── */
  const bt=document.getElementById('back-top');
  window.addEventListener('scroll',()=>bt.classList.toggle('show',window.scrollY>500),{passive:true});
  bt.addEventListener('click',()=>window.scrollTo({top:0,behavior:'smooth'}));
  /* ── Dropdown: update aria-expanded on hover for accessibility ── */
  document.querySelectorAll('.nav-dd').forEach(dd => {
    const toggle = dd.querySelector('.nav-dd-toggle');
    dd.addEventListener('mouseenter', () => toggle && toggle.setAttribute('aria-expanded','true'));
    dd.addEventListener('mouseleave', () => toggle && toggle.setAttribute('aria-expanded','false'));
  });
  /* ── Active nav link ── */
  const path = window.location.pathname.replace(/\/+$/,'');
  const base = '<?= rtrim(BASE_URL, '/') ?>';
  const isHome = (path === base || path === base + '/');
  document.querySelectorAll('.nav-link').forEach(l => {
    const href = l.getAttribute('href');
    if (isHome && (href === base + '/' || href === base)) l.classList.add('active');
  });
  document.querySelectorAll('section[id]').forEach(s=>{
    new IntersectionObserver(entries=>{
      entries.forEach(e=>{
        if(e.isIntersecting){
          document.querySelectorAll('.nav-link').forEach(l=>{
            l.classList.toggle('active', l.getAttribute('href').includes('#'+s.id));
          });
        }
      });
    },{threshold:0.35}).observe(s);
  });
  /* ── Reveal on scroll ── */
  const rv=new IntersectionObserver(entries=>{
    entries.forEach((e,i)=>{ if(e.isIntersecting){ setTimeout(()=>e.target.classList.add('_vis'),i*65); rv.unobserve(e.target); } });
  },{threshold:0.1});
  document.querySelectorAll('[data-reveal]').forEach(el=>rv.observe(el));
  /* ── Newsletter ── */
  const nb=document.getElementById('nl-btn'),ni=document.getElementById('nl-inp');
  if(nb&&ni) nb.addEventListener('click',()=>{
    if(!ni.value.trim()) return;
    nb.textContent='Terkirim ✓'; nb.style.background='#15803d'; ni.value='';
    setTimeout(()=>{ nb.textContent='Ikuti'; nb.style.background=''; },2800);
  });
})();
</script>
<script src="<?= BASE_URL ?>/assets/js/main.js" defer></script>
</body>
</html>