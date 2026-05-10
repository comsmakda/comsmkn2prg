<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($settings['org_name']['value'] ?? APP_NAME) ?> — COM SMKN 2 Pinrang</title>
  <meta name="description" content="<?= htmlspecialchars($settings['org_description']['value'] ?? 'Organisasi resmi COM SMKN 2 Pinrang') ?>">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700;800;900&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/custom.css">

  <?= $extra_head ?? '' ?>

  <style>
    :root {
      --c-bg:        #03070e;
      --c-surface:   #060b14;
      --c-surface2:  #091018;
      --c-surface3:  #0d1620;
      --c-border:    rgba(255,255,255,0.06);
      --c-border2:   rgba(14,165,233,0.2);
      --c-text:      #dde6f0;
      --c-muted:     #435566;
      --c-muted2:    #6e8799;
      --c-sky:       #0ea5e9;
      --c-sky-light: #38bdf8;
      --c-indigo:    #6366f1;
      --c-cyan:      #22d3ee;
      --nav-h:       66px;
      --top-h:       32px;
      --font-display:'Sora', sans-serif;
      --font-body:   'DM Sans', sans-serif;
      --font-mono:   'DM Mono', monospace;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html { scroll-behavior: smooth; }
    body {
      font-family: var(--font-body);
      background: var(--c-bg);
      color: var(--c-text);
      min-height: 100vh;
      display: flex; flex-direction: column;
      -webkit-font-smoothing: antialiased;
    }
    main { flex: 1; padding-top: calc(var(--nav-h) + var(--top-h)); }
    @media(max-width: 640px) { main { padding-top: var(--nav-h); } }

    /* ─── TOPBAR ─── */
    #topbar {
      height: var(--top-h);
      background: var(--c-surface);
      border-bottom: 1px solid var(--c-border);
      position: fixed; top: 0; left: 0; right: 0; z-index: 210;
      display: flex; align-items: center;
    }
    .topbar-inner {
      max-width: 1240px; margin: 0 auto; width: 100%; padding: 0 1.5rem;
      display: flex; align-items: center; justify-content: space-between;
    }
    .topbar-left {
      display: flex; align-items: center; gap: 5px;
      font-family: var(--font-mono); font-size: 0.62rem;
      color: var(--c-muted); letter-spacing: 0.04em;
    }
    .topbar-left span.lbl { color: var(--c-muted); }
    #server-clock {
      font-family: var(--font-mono); font-size: 0.62rem;
      color: var(--c-sky); letter-spacing: 0.06em; min-width: 52px;
    }
    .topbar-right { display: flex; align-items: center; gap: 12px; }
    .topbar-right a {
      font-size: 0.6rem; color: var(--c-muted);
      text-decoration: none; letter-spacing: 0.04em; transition: color 0.18s;
      font-family: var(--font-mono); text-transform: uppercase;
    }
    .topbar-right a:hover { color: var(--c-muted2); }
    .tb-sep { width: 1px; height: 10px; background: var(--c-border); }
    @media(max-width: 640px) { #topbar { display: none; } }

    /* ─── NAVBAR ─── */
    #nav {
      position: fixed; top: var(--top-h); left: 0; right: 0; z-index: 200;
      height: var(--nav-h);
      border-bottom: 1px solid transparent;
      transition: background .4s ease, box-shadow .4s ease, border-color .4s ease, transform .3s cubic-bezier(.22,1,.36,1);
    }
    @media(max-width: 640px) { #nav { top: 0; } }
    #nav.scrolled {
      background: rgba(3,7,14,0.93);
      backdrop-filter: blur(26px) saturate(180%);
      -webkit-backdrop-filter: blur(26px) saturate(180%);
      border-color: var(--c-border);
      box-shadow: 0 1px 0 rgba(14,165,233,0.04), 0 12px 48px rgba(0,0,0,0.72);
    }

    .nav-wrap {
      max-width: 1240px; margin: 0 auto; height: var(--nav-h);
      display: flex; align-items: center; justify-content: space-between;
      padding: 0 1.5rem;
    }

    .nav-brand { display: flex; align-items: center; gap: 10px; text-decoration: none; flex-shrink: 0; }
    .nav-brand-logo {
      width: 34px; height: 34px; object-fit: contain; display: block; flex-shrink: 0;
      transition: opacity .2s;
    }
    .nav-brand:hover .nav-brand-logo { opacity: .85; }
    .nav-brand-name {
      font-family: var(--font-display); font-weight: 800; font-size: .95rem;
      color: #fff; letter-spacing: -.025em; line-height: 1; display: block;
      transition: color .18s;
    }
    .nav-brand:hover .nav-brand-name { color: var(--c-sky-light); }
    .nav-brand-sub {
      font-family: var(--font-mono); font-size: .56rem; color: var(--c-muted2);
      letter-spacing: .1em; text-transform: uppercase; display: block; margin-top: 3px;
    }

    .nav-sep { width: 1px; height: 20px; background: var(--c-border); flex-shrink: 0; }

    .nav-links { display: flex; align-items: center; }
    .nav-link {
      position: relative; font-size: .78rem; font-weight: 500; color: var(--c-muted2);
      text-decoration: none; padding: 6px 12px; border-radius: 7px;
      transition: color .18s, background .18s; letter-spacing: -.01em; white-space: nowrap;
    }
    .nav-link:hover { color: #fff; background: rgba(255,255,255,.04); }
    .nav-link.active { color: var(--c-sky); }
    .nav-link.active::after {
      content: ''; position: absolute; bottom: 0; left: 50%; transform: translateX(-50%);
      width: 14px; height: 2px; border-radius: 2px; background: var(--c-sky);
    }

    .nav-actions { display: flex; align-items: center; gap: 7px; }
    .nav-btn-ghost {
      display: inline-flex; align-items: center; gap: 5px; padding: 7px 14px;
      font-size: .76rem; font-weight: 600; color: var(--c-muted2);
      border: 1px solid var(--c-border); border-radius: 7px; text-decoration: none;
      transition: all .18s; letter-spacing: -.01em;
    }
    .nav-btn-ghost:hover { color: #fff; border-color: rgba(255,255,255,.13); background: rgba(255,255,255,.04); }
    .nav-btn-cta {
      display: inline-flex; align-items: center; gap: 5px; padding: 8px 16px;
      font-size: .76rem; font-weight: 700; color: #fff; background: var(--c-sky);
      border-radius: 7px; text-decoration: none; transition: all .22s cubic-bezier(.22,1,.36,1);
      letter-spacing: -.01em; box-shadow: 0 2px 14px rgba(14,165,233,.22);
    }
    .nav-btn-cta:hover { background: var(--c-sky-light); box-shadow: 0 4px 22px rgba(14,165,233,.38); transform: translateY(-1px); }

    .hamburger {
      display: none; flex-direction: column; gap: 4px; cursor: pointer;
      padding: 8px; background: rgba(255,255,255,.03);
      border: 1px solid var(--c-border); border-radius: 8px;
    }
    .hamburger span {
      display: block; width: 18px; height: 1.5px;
      background: var(--c-muted2); border-radius: 2px;
      transition: all .3s cubic-bezier(.22,1,.36,1);
    }
    .hamburger.open span:nth-child(1) { transform: rotate(45deg) translate(4px,4px); }
    .hamburger.open span:nth-child(2) { opacity:0; transform: scaleX(0); }
    .hamburger.open span:nth-child(3) { transform: rotate(-45deg) translate(4px,-4px); }

    .mobile-drawer {
      position: fixed; top: calc(var(--nav-h) + var(--top-h)); left:0; right:0; z-index:199;
      background: rgba(3,7,14,.98); backdrop-filter: blur(28px);
      border-bottom: 1px solid var(--c-border);
      padding: .75rem 1.25rem 1.25rem;
      display: flex; flex-direction: column; gap: 1px;
      transform: translateY(-110%); opacity:0;
      transition: transform .35s cubic-bezier(.22,1,.36,1), opacity .28s;
      pointer-events: none;
    }
    @media(max-width:640px) { .mobile-drawer { top: var(--nav-h); } }
    .mobile-drawer.open { transform: translateY(0); opacity:1; pointer-events:all; }

    .mob-link {
      display: flex; align-items: center; justify-content: space-between;
      font-size: .88rem; font-weight: 600; color: var(--c-muted2);
      text-decoration: none; padding: .68rem .75rem; border-radius: 8px;
      transition: color .18s, background .18s;
    }
    .mob-link:hover { color:#fff; background: rgba(255,255,255,.04); }
    .mob-link svg { opacity:.3; transition: opacity .18s; }
    .mob-link:hover svg { opacity:.7; }
    .mob-sep { height:1px; background: var(--c-border); margin: .5rem 0; }
    .mob-actions { display:flex; gap:7px; }
    .mob-ghost {
      flex:1; padding:11px; text-align:center; font-size:.81rem; font-weight:600;
      color: var(--c-muted2); border:1px solid var(--c-border); border-radius:8px;
      text-decoration:none; transition: all .18s;
    }
    .mob-ghost:hover { color:#fff; border-color: rgba(255,255,255,.13); }
    .mob-cta {
      flex:1; padding:11px; text-align:center; background: var(--c-sky);
      font-size:.81rem; font-weight:700; color:#fff; border-radius:8px;
      text-decoration:none; transition: all .18s;
    }
    .mob-cta:hover { background: var(--c-sky-light); }

    @media(max-width:860px) { .nav-links,.nav-actions,.nav-sep { display:none; } .hamburger { display:flex; } }

    /* ─── ALERT ─── */
    .alert-wrap { max-width:1240px; margin:1rem auto; padding:0 1.5rem; }
    .alert {
      display:flex; align-items:center; gap:9px; padding:12px 16px; border-radius:9px;
      font-size:.85rem; font-weight:500; border:1px solid; animation: aIn .25s ease;
    }
    @keyframes aIn { from { opacity:0; transform:translateY(-5px); } to { opacity:1; transform:translateY(0); } }
    .alert-error   { background:rgba(239,68,68,.07);  border-color:rgba(239,68,68,.2);  color:#fca5a5; }
    .alert-success { background:rgba(34,197,94,.07);  border-color:rgba(34,197,94,.2);  color:#86efac; }
    .alert-info    { background:rgba(14,165,233,.07); border-color:rgba(14,165,233,.2); color:#7dd3fc; }

    /* ─── FOOTER ─── */
    .site-footer { position:relative; overflow:hidden; background: var(--c-surface); border-top:1px solid var(--c-border); }
    .site-footer::before {
      content:''; position:absolute; top:0; left:50%; transform:translateX(-50%);
      width:600px; height:1px;
      background:linear-gradient(90deg, transparent, rgba(14,165,233,.45), rgba(99,102,241,.35), transparent);
    }
    .site-footer::after {
      content:''; position:absolute; top:-180px; left:50%; transform:translateX(-50%);
      width:700px; height:420px;
      background:radial-gradient(ellipse, rgba(14,165,233,.03) 0%, transparent 68%);
      pointer-events:none;
    }

    .footer-inner { max-width:1240px; margin:0 auto; padding:0 1.5rem 2.5rem; position:relative; z-index:1; }

    /* grid */
    .f-grid {
      display:grid; grid-template-columns:2.1fr 1fr 1fr 1.1fr;
      gap:3rem; padding:3.5rem 0 3rem; border-bottom:1px solid var(--c-border);
    }
    @media(max-width:900px) { .f-grid { grid-template-columns:1fr 1fr; gap:2.5rem; } }
    @media(max-width:520px) { .f-grid { grid-template-columns:1fr; gap:2rem; } }

    /* brand */
    .fb-row { display:flex; align-items:center; gap:9px; text-decoration:none; margin-bottom:.9rem; width:fit-content; }
    .fb-logo { width:36px; height:36px; object-fit:contain; display:block; flex-shrink:0; transition:opacity .18s; }
    .fb-row:hover .fb-logo { opacity:.85; }
    .fb-name { font-family:var(--font-display); font-weight:800; font-size:.9rem; color:#fff; letter-spacing:-.022em; display:block; transition:color .18s; }
    .fb-row:hover .fb-name { color: var(--c-sky-light); }
    .fb-sub  { font-family:var(--font-mono); font-size:.56rem; color: var(--c-muted2); letter-spacing:.09em; text-transform:uppercase; display:block; margin-top:2px; }
    .fb-desc { font-size:.8rem; color: var(--c-muted); line-height:1.9; margin-bottom:1.4rem; max-width:290px; }

    .fb-socials { display:flex; gap:6px; margin-bottom:1.5rem; }
    .fb-social {
      width:34px; height:34px; border-radius:7px; background: var(--c-surface2);
      border:1px solid var(--c-border); display:flex; align-items:center; justify-content:center;
      color: var(--c-muted2); text-decoration:none; transition: all .22s cubic-bezier(.22,1,.36,1);
    }
    .fb-social:hover { background: var(--c-surface3); border-color: var(--c-border2); color: var(--c-sky); transform:translateY(-2px); box-shadow:0 6px 16px rgba(14,165,233,.15); }

    .fb-nl-lbl { font-family:var(--font-mono); font-size:.6rem; color: var(--c-muted); text-transform:uppercase; letter-spacing:.1em; display:block; margin-bottom:6px; }
    .fb-nl-row { display:flex; gap:5px; }
    .fb-nl-inp {
      flex:1; background: var(--c-surface2); border:1px solid var(--c-border); border-radius:7px;
      padding:8px 11px; font-family:var(--font-body); font-size:.77rem; color: var(--c-text); outline:none;
      transition: border-color .2s, box-shadow .2s;
    }
    .fb-nl-inp::placeholder { color: var(--c-muted); }
    .fb-nl-inp:focus { border-color: var(--c-border2); box-shadow:0 0 0 3px rgba(14,165,233,.06); }
    .fb-nl-btn {
      padding:8px 14px; background: var(--c-sky); border:none; border-radius:7px;
      font-family:var(--font-body); font-size:.77rem; font-weight:700; color:#fff;
      cursor:pointer; transition: all .18s; white-space:nowrap;
    }
    .fb-nl-btn:hover { background: var(--c-sky-light); transform:translateY(-1px); }

    /* col head */
    .fc-head { display:flex; align-items:center; gap:8px; margin-bottom:1rem; }
    .fc-head h4 { font-family:var(--font-mono); font-size:.62rem; font-weight:500; text-transform:uppercase; letter-spacing:.13em; color: var(--c-sky); white-space:nowrap; }
    .fc-line { flex:1; height:1px; background:linear-gradient(90deg,rgba(14,165,233,.22),transparent); }

    .fc-ul { list-style:none; }
    .fc-ul li { margin-bottom:.4rem; }
    .fc-ul li a {
      font-size:.8rem; color: var(--c-muted); text-decoration:none;
      display:inline-flex; align-items:center; gap:6px; transition: color .18s, gap .18s;
    }
    .fc-ul li a::before { content:''; display:block; width:4px; height:1px; background: var(--c-muted); border-radius:1px; flex-shrink:0; transition: width .18s, background .18s; }
    .fc-ul li a:hover { color: var(--c-text); gap:9px; }
    .fc-ul li a:hover::before { width:8px; background: var(--c-sky); }

    /* contact */
    .fc-contacts { display:flex; flex-direction:column; gap:2px; }
    .fc-ci {
      display:flex; align-items:flex-start; gap:9px; padding:8px 9px; border-radius:8px;
      border:1px solid transparent; transition: background .18s, border-color .18s;
    }
    .fc-ci:hover { background: var(--c-surface2); border-color: var(--c-border); }
    .fc-ci-icon {
      width:28px; height:28px; flex-shrink:0; background:rgba(14,165,233,.07);
      border:1px solid rgba(14,165,233,.12); border-radius:6px;
      display:flex; align-items:center; justify-content:center; color: var(--c-sky);
    }
    .fc-ci-lbl { font-family:var(--font-mono); font-size:.58rem; color: var(--c-muted); text-transform:uppercase; letter-spacing:.09em; display:block; margin-bottom:1px; }
    .fc-ci-val { font-size:.78rem; color: var(--c-muted2); line-height:1.45; }
    .fc-ci-val a { color: var(--c-muted2); text-decoration:none; transition:color .18s; }
    .fc-ci-val a:hover { color: var(--c-sky); }

    /* bottom */
    .f-bottom { padding-top:1.75rem; display:flex; align-items:center; justify-content:space-between; gap:1rem; flex-wrap:wrap; }
    .f-copy { font-size:.74rem; color: var(--c-muted); }
    .f-bottom-r { display:flex; align-items:center; gap:12px; }
    .f-policy { display:flex; gap:12px; }
    .f-policy a { font-size:.66rem; color: var(--c-muted); text-decoration:none; font-family:var(--font-mono); letter-spacing:.04em; transition:color .18s; text-transform:uppercase; }
    .f-policy a:hover { color: var(--c-muted2); }
    .f-vsep { width:1px; height:12px; background: var(--c-border); }
    .f-clock-badge {
      display:inline-flex; align-items:center; gap:6px; font-family:var(--font-mono);
      font-size:.62rem; color: var(--c-muted2);
      background: var(--c-surface2); border:1px solid var(--c-border);
      padding:4px 10px; border-radius:5px;
    }
    .f-clk-dot { width:5px; height:5px; border-radius:50%; background:#22c55e; flex-shrink:0; animation:fp 2.4s ease-in-out infinite; }
    @keyframes fp { 0%,100%{opacity:1} 50%{opacity:.3} }
    #footer-clock { color: var(--c-sky); }

    /* back top */
    #back-top {
      position:fixed; right:1.5rem; bottom:2rem; z-index:150;
      width:40px; height:40px; background: var(--c-surface2); border:1px solid var(--c-border2);
      border-radius:9px; display:flex; align-items:center; justify-content:center;
      color: var(--c-sky); cursor:pointer;
      opacity:0; transform:translateY(10px) scale(.92);
      transition: all .3s cubic-bezier(.22,1,.36,1); box-shadow:0 4px 18px rgba(0,0,0,.4);
    }
    #back-top.show { opacity:1; transform:translateY(0) scale(1); }
    #back-top:hover { background: var(--c-sky); color:#fff; transform:translateY(-3px) scale(1.04); box-shadow:0 10px 24px rgba(14,165,233,.3); }

    /* reveal */
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
      <span class="lbl">WIB</span>
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
        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24" style="display:inline-block;vertical-align:-1px;margin-right:3px"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
        Home
      </a>
      <a href="<?= BASE_URL ?>/#about"    class="nav-link">Tentang</a>
      <a href="<?= BASE_URL ?>/#features" class="nav-link">Layanan</a>
      <a href="<?= BASE_URL ?>/#programs" class="nav-link">Program</a>
      <a href="<?= BASE_URL ?>/#gallery"  class="nav-link">Galeri</a>
      <a href="<?= BASE_URL ?>/#contact"  class="nav-link">Kontak</a>
    </div>

    <div class="nav-actions">
      <?php if (empty($_SESSION['user_id'])): ?>
        <a href="<?= BASE_URL ?>/pab" class="nav-btn-ghost">
          <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
          Daftar PAB
        </a>
        <a href="<?= BASE_URL ?>/login" class="nav-btn-cta">
          <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
          Masuk
        </a>
      <?php else: ?>
        <a href="<?= BASE_URL ?>/<?= $_SESSION['user_role'] === 'admin' ? 'admin' : 'member' ?>/dashboard" class="nav-btn-cta">
          <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
          Dashboard
        </a>
      <?php endif; ?>
    </div>

    <button class="hamburger" id="hamburger" aria-label="Toggle menu">
      <span></span><span></span><span></span>
    </button>
  </div>
</nav>

<!-- Mobile drawer -->
<div class="mobile-drawer" id="mobile-drawer">
  <a href="<?= BASE_URL ?>/" class="mob-link">
    Home
    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
  </a>
  <a href="<?= BASE_URL ?>/#about"    class="mob-link">Tentang Kami <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></a>
  <a href="<?= BASE_URL ?>/#features" class="mob-link">Layanan <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></a>
  <a href="<?= BASE_URL ?>/#programs" class="mob-link">Program <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></a>
  <a href="<?= BASE_URL ?>/#gallery"  class="mob-link">Galeri <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></a>
  <a href="<?= BASE_URL ?>/#contact"  class="mob-link">Kontak <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></a>
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
    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
    <?= $flash['msg'] ?>
  </div>
</div>
<?php endif; ?>

<main><?= $content ?></main>

<!-- ══ FOOTER ══ -->
<footer class="site-footer">
  <div class="footer-inner">

    <!-- Grid -->
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
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
          </a>
          <?php endif; ?>
          <?php if (!empty($settings['social_tiktok']['value'])): ?>
          <a href="https://tiktok.com/@<?= htmlspecialchars($settings['social_tiktok']['value']) ?>" class="fb-social" target="_blank" rel="noopener" title="TikTok">
            <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-2.88 2.5 2.89 2.89 0 0 1-2.89-2.89 2.89 2.89 0 0 1 2.89-2.89c.28 0 .54.04.79.1V9.01a6.31 6.31 0 0 0-.79-.05 6.34 6.34 0 0 0-6.34 6.34 6.34 6.34 0 0 0 6.34 6.34 6.34 6.34 0 0 0 6.33-6.34V8.69a8.18 8.18 0 0 0 4.77 1.52V6.75a4.85 4.85 0 0 1-1-.06z"/></svg>
          </a>
          <?php endif; ?>
          <?php if (!empty($settings['social_youtube']['value'])): ?>
          <a href="<?= htmlspecialchars($settings['social_youtube']['value']) ?>" class="fb-social" target="_blank" rel="noopener" title="YouTube">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22.54 6.42A2.78 2.78 0 0 0 20.6 4.47C18.88 4 12 4 12 4s-6.88 0-8.6.47A2.78 2.78 0 0 0 1.46 6.42 29 29 0 0 0 1 12a29 29 0 0 0 .46 5.58A2.78 2.78 0 0 0 3.4 19.53C5.12 20 12 20 12 20s6.88 0 8.6-.47a2.78 2.78 0 0 0 1.94-1.95A29 29 0 0 0 23 12a29 29 0 0 0-.46-5.58z"/><polygon points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02"/></svg>
          </a>
          <?php endif; ?>
          <?php if (!empty($settings['contact_phone']['value'])): ?>
          <a href="https://wa.me/<?= preg_replace('/\D/','',$settings['contact_phone']['value']) ?>" class="fb-social" target="_blank" rel="noopener" title="WhatsApp">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
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
          <li><a href="<?= BASE_URL ?>/#gallery">Galeri</a></li>
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
            <div class="fc-ci-icon"><svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg></div>
            <div><span class="fc-ci-lbl">Instagram</span><span class="fc-ci-val"><a href="https://instagram.com/<?= htmlspecialchars($settings['social_instagram']['value']) ?>" target="_blank" rel="noopener">@<?= htmlspecialchars($settings['social_instagram']['value']) ?></a></span></div>
          </div>
          <?php endif; ?>
          <?php if (!empty($settings['social_tiktok']['value'])): ?>
          <div class="fc-ci">
            <div class="fc-ci-icon"><svg width="12" height="12" fill="currentColor" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-2.88 2.5 2.89 2.89 0 0 1-2.89-2.89 2.89 2.89 0 0 1 2.89-2.89c.28 0 .54.04.79.1V9.01a6.31 6.31 0 0 0-.79-.05 6.34 6.34 0 0 0-6.34 6.34 6.34 6.34 0 0 0 6.34 6.34 6.34 6.34 0 0 0 6.33-6.34V8.69a8.18 8.18 0 0 0 4.77 1.52V6.75a4.85 4.85 0 0 1-1-.06z"/></svg></div>
            <div><span class="fc-ci-lbl">TikTok</span><span class="fc-ci-val"><a href="https://tiktok.com/@<?= htmlspecialchars($settings['social_tiktok']['value']) ?>" target="_blank" rel="noopener">@<?= htmlspecialchars($settings['social_tiktok']['value']) ?></a></span></div>
          </div>
          <?php endif; ?>
          <?php if (!empty($settings['contact_email']['value'])): ?>
          <div class="fc-ci">
            <div class="fc-ci-icon"><svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg></div>
            <div><span class="fc-ci-lbl">Email</span><span class="fc-ci-val"><a href="mailto:<?= htmlspecialchars($settings['contact_email']['value']) ?>"><?= htmlspecialchars($settings['contact_email']['value']) ?></a></span></div>
          </div>
          <?php endif; ?>
          <?php if (!empty($settings['contact_address']['value'])): ?>
          <div class="fc-ci">
            <div class="fc-ci-icon"><svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg></div>
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
  <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="18 15 12 9 6 15"/></svg>
</button>

<script>
(function(){
  function tick(){
    const d=new Date(), u=new Date(d.getTime()+7*3600000);
    const t=[u.getUTCHours(),u.getUTCMinutes(),u.getUTCSeconds()].map(n=>String(n).padStart(2,'0')).join(':');
    ['server-clock','footer-clock'].forEach(id=>{ const el=document.getElementById(id); if(el) el.textContent=t; });
  }
  tick(); setInterval(tick,1000);

  const nav=document.getElementById('nav'); let ly=0;
  window.addEventListener('scroll',()=>{
    const y=window.scrollY;
    nav.classList.toggle('scrolled',y>24);
    nav.style.transform=(y>200&&y>ly)?'translateY(-100%)':'translateY(0)';
    ly=y;
  },{passive:true});

  const btn=document.getElementById('hamburger'),drw=document.getElementById('mobile-drawer');
  btn.addEventListener('click',()=>{
    btn.classList.toggle('open'); drw.classList.toggle('open');
    document.body.style.overflow=drw.classList.contains('open')?'hidden':'';
  });
  drw.querySelectorAll('a').forEach(a=>a.addEventListener('click',()=>{
    btn.classList.remove('open'); drw.classList.remove('open');
    document.body.style.overflow='';
  }));

  const bt=document.getElementById('back-top');
  window.addEventListener('scroll',()=>bt.classList.toggle('show',window.scrollY>500),{passive:true});
  bt.addEventListener('click',()=>window.scrollTo({top:0,behavior:'smooth'}));

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

  const rv=new IntersectionObserver(entries=>{
    entries.forEach((e,i)=>{ if(e.isIntersecting){ setTimeout(()=>e.target.classList.add('_vis'),i*65); rv.unobserve(e.target); } });
  },{threshold:0.1});
  document.querySelectorAll('[data-reveal]').forEach(el=>rv.observe(el));

  const nb=document.getElementById('nl-btn'),ni=document.getElementById('nl-inp');
  if(nb&&ni) nb.addEventListener('click',()=>{
    if(!ni.value.trim()) return;
    nb.textContent='Terkirim ✓'; nb.style.background='#22c55e'; ni.value='';
    setTimeout(()=>{ nb.textContent='Ikuti'; nb.style.background=''; },2800);
  });
})();
</script>
<script src="<?= BASE_URL ?>/assets/js/main.js" defer></script>
</body>
</html>