<?php // app/views/pages/login.php ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Masuk — <?= htmlspecialchars($settings['org_name']['value'] ?? APP_NAME) ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />

  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --c-bg:        #04080f;
      --c-surface:   #080e18;
      --c-surface2:  #0c1422;
      --c-surface3:  #111c2e;
      --c-border:    rgba(255,255,255,.07);
      --c-border2:   rgba(255,255,255,.13);
      --c-text:      #e8edf5;
      --c-muted:     #4d6282;
      --c-muted2:    #8aa3c0;
      --c-sky:       #0ea5e9;
      --c-sky-light: #38bdf8;
      --c-cyan:      #22d3ee;
      --c-indigo:    #6366f1;

      --c-red-bg:      rgba(239,68,68,.08);
      --c-red-border:  rgba(239,68,68,.22);
      --c-red-text:    #fca5a5;
      --c-green-bg:    rgba(34,197,94,.08);
      --c-green-border:rgba(34,197,94,.22);
      --c-green-text:  #86efac;

      --radius-sm: 9px;
      --radius-md: 13px;
      --radius-lg: 18px;
    }

    html, body { height: 100%; font-family: 'Plus Jakarta Sans', sans-serif; background: var(--c-bg); color: var(--c-text); }

    /* ═══ PAGE ═══ */
    .page { min-height: 100vh; display: grid; grid-template-columns: 1fr 1fr; }

    /* ═══ LEFT PANEL (illustration + brand) ═══ */
    .left-panel {
      background: var(--c-surface);
      border-right: 1px solid var(--c-border);
      position: relative; overflow: hidden;
      display: flex; flex-direction: column; justify-content: space-between;
      padding: 3rem;
    }
    .left-panel::before {
      content: ''; position: absolute; inset: 0;
      background-image:
        linear-gradient(rgba(14,165,233,0.04) 1px, transparent 1px),
        linear-gradient(90deg, rgba(14,165,233,0.04) 1px, transparent 1px);
      background-size: 64px 64px;
      mask-image: radial-gradient(ellipse 90% 90% at 50% 50%, black 10%, transparent 80%);
      pointer-events: none; z-index: 0;
    }
    .left-panel::after {
      content: ''; position: absolute; inset: 0;
      background:
        radial-gradient(ellipse 65% 45% at 70% 10%, rgba(14,165,233,.09) 0%, transparent 65%),
        radial-gradient(ellipse 50% 40% at 10% 85%, rgba(99,102,241,.07) 0%, transparent 60%);
      pointer-events: none; z-index: 0;
    }
    .left-orb-1 {
      position: absolute; width: 400px; height: 400px; border-radius: 50%;
      background: radial-gradient(circle, rgba(14,165,233,.06) 0%, transparent 70%);
      top: -120px; right: -100px; pointer-events: none; z-index: 0;
      animation: orb-drift 14s ease-in-out infinite;
    }
    .left-orb-2 {
      position: absolute; width: 260px; height: 260px; border-radius: 50%;
      background: radial-gradient(circle, rgba(99,102,241,.06) 0%, transparent 70%);
      bottom: -70px; left: -60px; pointer-events: none; z-index: 0;
      animation: orb-drift 18s ease-in-out infinite reverse;
    }
    @keyframes orb-drift {
      0%,100% { transform: translate(0,0) scale(1); }
      33%      { transform: translate(14px,-14px) scale(1.03); }
      66%      { transform: translate(-10px,12px) scale(.98); }
    }
    .brand { display: flex; align-items: center; gap: 13px; position: relative; z-index: 1; }
    .brand-icon {
      width: 46px; height: 46px; background: rgba(14,165,233,.1);
      border: 1px solid rgba(14,165,233,.2); border-radius: var(--radius-sm);
      display: flex; align-items: center; justify-content: center; flex-shrink: 0; overflow: hidden;
    }
    .brand-icon img { width: 100%; height: 100%; object-fit: contain; padding: 8px; filter: brightness(0) invert(1); }
    .brand-icon i { color: var(--c-sky); font-size: 22px; }
    .brand-name { font-size: 19px; font-weight: 800; color: #fff; letter-spacing: -.45px; }
    .brand-tagline { font-size: 10.5px; color: var(--c-muted2); display: block; margin-top: 2px; letter-spacing: .08em; text-transform: uppercase; }

    /* ─── center block: headline + illustration mock + stats ─── */
    .left-content { position: relative; z-index: 1; }
    .left-badge {
      display: inline-flex; align-items: center; gap: 7px; padding: 4px 13px;
      background: rgba(14,165,233,.07); border: 1px solid rgba(14,165,233,.2);
      border-radius: 99px; font-size: .65rem; color: var(--c-sky);
      letter-spacing: .08em; text-transform: uppercase; margin-bottom: 1.2rem;
    }
    .left-badge-pulse {
      width: 6px; height: 6px; border-radius: 50%; background: var(--c-cyan);
      animation: pulse-glow 2s ease-in-out infinite;
    }
    @keyframes pulse-glow {
      0%,100% { opacity:1; box-shadow:0 0 0 0 rgba(34,211,238,.4); }
      50%      { opacity:.7; box-shadow:0 0 0 5px rgba(34,211,238,0); }
    }
    .left-headline {
      font-size: clamp(1.7rem,2.6vw,2.4rem); font-weight: 900; color: #fff;
      line-height: 1.1; letter-spacing: -.045em; margin-bottom: .6rem;
    }
    .t-grad {
      background: linear-gradient(130deg, var(--c-sky-light) 0%, var(--c-indigo) 100%);
      -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
    }
    .left-desc { font-size: .84rem; color: var(--c-muted2); line-height: 1.8; max-width: 340px; margin-bottom: 1.8rem; }

    /* illustration mock — floating cards over a shield glyph, PMB-style hero */
    .illustration-wrap {
      position: relative; height: 210px; margin-bottom: 1.8rem;
      display: flex; align-items: center; justify-content: center;
    }
    .illus-shield {
      width: 128px; height: 128px; border-radius: 32px;
      background: linear-gradient(150deg, rgba(14,165,233,.14), rgba(99,102,241,.1));
      border: 1px solid rgba(14,165,233,.22);
      display: flex; align-items: center; justify-content: center;
      box-shadow: 0 20px 50px rgba(14,165,233,.12);
      animation: illus-float 6s ease-in-out infinite;
    }
    .illus-shield i { font-size: 52px; color: var(--c-sky-light); }
    @keyframes illus-float {
      0%,100% { transform: translateY(0); }
      50%      { transform: translateY(-8px); }
    }
    .illus-card {
      position: absolute; display: flex; align-items: center; gap: 10px;
      background: rgba(8,14,24,.9); backdrop-filter: blur(6px);
      border: 1px solid var(--c-border2); border-radius: var(--radius-md);
      padding: 9px 14px; box-shadow: 0 14px 34px rgba(0,0,0,.35);
    }
    .illus-card i { font-size: 18px; color: var(--c-sky); }
    .illus-card strong { display: block; font-size: .8rem; font-weight: 800; color: #fff; }
    .illus-card span { display: block; font-size: .65rem; color: var(--c-muted2); }
    .illus-card-1 { top: 4px; left: -6px; animation: illus-float 7s ease-in-out infinite; }
    .illus-card-2 { bottom: 4px; right: -10px; animation: illus-float 8s ease-in-out infinite reverse; }

    .trust-stats { display: flex; gap: 8px; flex-wrap: wrap; }
    .trust-stat {
      display: flex; align-items: center; gap: 6px;
      background: rgba(14,165,233,.07); border: 1px solid rgba(14,165,233,.16);
      border-radius: 99px; padding: 5px 12px;
      font-size: .72rem; color: var(--c-sky); font-weight: 600;
    }
    .trust-stat i { font-size: 13px; }

    .left-footer { position: relative; z-index: 1; font-size: .72rem; color: var(--c-muted); letter-spacing: .04em; }

    /* ═══ RIGHT PANEL (form) ═══ */
    .right-panel {
      display: flex; align-items: center; justify-content: center;
      background: var(--c-bg); padding: 2.5rem 2rem; position: relative;
    }
    .right-panel::before {
      content: ''; position: absolute; inset: 0;
      background: radial-gradient(ellipse 70% 60% at 50% 40%, rgba(14,165,233,.04) 0%, transparent 70%);
      pointer-events: none;
    }
    .login-box {
      width: 100%; max-width: 430px; position: relative; z-index: 1;
      animation: fadeUp .5s cubic-bezier(.22,1,.36,1) both;
    }
    @keyframes fadeUp { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }

    .login-header { margin-bottom: 1.4rem; }
    .login-greeting { font-size: 1.65rem; font-weight: 900; color: #fff; letter-spacing: -.04em; }
    .login-sub { font-size: .83rem; color: var(--c-muted2); margin-top: 6px; line-height: 1.7; }

    /* Flash */
    .flash {
      display: flex; align-items: flex-start; gap: 10px;
      border-radius: var(--radius-md); padding: 11px 14px;
      font-size: .825rem; font-weight: 500; margin-bottom: 1.4rem; animation: slideIn .22s ease;
    }
    .flash i { font-size: 16px; margin-top: 1px; flex-shrink: 0; }
    .flash.error   { background:var(--c-red-bg);   color:var(--c-red-text);   border:1px solid var(--c-red-border);   }
    .flash.success { background:var(--c-green-bg); color:var(--c-green-text); border:1px solid var(--c-green-border); }
    .flash.info    { background:rgba(14,165,233,.07); color:var(--c-muted2); border:1px solid rgba(14,165,233,.15); font-weight:400; font-size:.78rem; }
    @keyframes slideIn { from{opacity:0;transform:translateY(-6px)} to{opacity:1;transform:translateY(0)} }

    /* Tabs */
    .tab-bar {
      display: flex; background: var(--c-surface2); border: 1px solid var(--c-border);
      border-radius: var(--radius-md); padding: 4px; gap: 4px; margin-bottom: 1.5rem;
    }
    .tab-btn {
      flex: 1; display: flex; align-items: center; justify-content: center; gap: 7px;
      padding: 9px 0; border: none; background: transparent; border-radius: 9px;
      font-family: 'Plus Jakarta Sans', sans-serif; font-size: .82rem; font-weight: 700;
      color: var(--c-muted2); cursor: pointer;
      transition: background .18s, color .18s, box-shadow .18s; letter-spacing: -.01em;
    }
    .tab-btn i { font-size: 16px; }
    .tab-btn.active { background: var(--c-sky); color: #fff; box-shadow: 0 3px 14px rgba(14,165,233,.28); }
    .tab-btn:not(.active):hover { background: var(--c-surface3); color: var(--c-text); }

    /* Fields */
    .field-group { margin-bottom: 1.1rem; }
    .field-label { display: block; font-size: .72rem; font-weight: 700; color: var(--c-muted2); margin-bottom: 6px; letter-spacing: .06em; text-transform: uppercase; }
    .field-wrap { position: relative; }
    .field-icon { position: absolute; left: 13px; top: 50%; transform: translateY(-50%); font-size: 17px; color: var(--c-muted); pointer-events: none; transition: color .18s; }
    .field-wrap:focus-within .field-icon { color: var(--c-sky); }
    .field-input {
      width: 100%; padding: 11px 14px 11px 42px; background: var(--c-surface2);
      border: 1px solid var(--c-border); border-radius: var(--radius-sm);
      font-family: 'Plus Jakarta Sans', sans-serif; font-size: .875rem; color: var(--c-text);
      outline: none; transition: border .16s, box-shadow .16s, background .16s;
    }
    .field-input:focus { border-color: var(--c-sky); box-shadow: 0 0 0 3px rgba(14,165,233,.12); background: var(--c-surface3); }
    .field-input::placeholder { color: var(--c-muted); }
    .field-input.has-eye { padding-right: 42px; }
    .field-input.is-invalid { border-color: #ef4444; box-shadow: 0 0 0 3px rgba(239,68,68,.12); }
    .eye-btn {
      position: absolute; right: 13px; top: 50%; transform: translateY(-50%);
      background: none; border: none; cursor: pointer; padding: 0; color: var(--c-muted);
      font-size: 17px; line-height: 1; transition: color .15s;
    }
    .eye-btn:hover { color: var(--c-sky); }
    .panel { display: none; }
    .panel.active { display: block; }

    /* Remember-me row (PMB-style "Ingat Saya") */
    .remember-row { display: flex; align-items: center; justify-content: space-between; margin: -.2rem 0 1.1rem; }
    .check-wrap { display: flex; align-items: center; gap: 8px; cursor: pointer; user-select: none; }
    .check-wrap input { position: absolute; opacity: 0; width: 0; height: 0; }
    .check-box {
      width: 17px; height: 17px; border-radius: 5px; border: 1px solid var(--c-border2);
      background: var(--c-surface2); display: flex; align-items: center; justify-content: center;
      transition: background .15s, border-color .15s; flex-shrink: 0;
    }
    .check-box::after {
      content: '\ea5e'; font-family: 'tabler-icons' !important; font-size: 12px; color: #fff;
      opacity: 0; transform: scale(.6); transition: opacity .12s, transform .12s;
    }
    .check-wrap input:checked + .check-box { background: var(--c-sky); border-color: var(--c-sky); }
    .check-wrap input:checked + .check-box::after { opacity: 1; transform: scale(1); }
    .check-wrap input:focus-visible + .check-box { box-shadow: 0 0 0 3px rgba(14,165,233,.18); }
    .check-label { font-size: .78rem; color: var(--c-muted2); font-weight: 500; }
    .forgot-link { font-size: .78rem; color: var(--c-sky); font-weight: 600; text-decoration: none; }
    .forgot-link:hover { text-decoration: underline; }

    /* Submit */
    .submit-btn {
      width: 100%; padding: 13px; background: var(--c-sky); color: #fff; border: none;
      border-radius: var(--radius-sm); font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: .9rem; font-weight: 800; cursor: pointer; letter-spacing: -.01em;
      display: flex; align-items: center; justify-content: center; gap: 9px;
      transition: background .18s, transform .12s, box-shadow .18s;
      box-shadow: 0 4px 22px rgba(14,165,233,.25);
    }
    .submit-btn:hover:not(:disabled) { background: var(--c-sky-light); transform: translateY(-2px); box-shadow: 0 10px 32px rgba(14,165,233,.35); }
    .submit-btn:active:not(:disabled) { transform: scale(0.985); }
    .submit-btn:disabled { opacity:.55; cursor:not-allowed; }
    .submit-btn i { font-size: 18px; }
    .submit-btn .spin { display:none; animation: spinAnim .65s linear infinite; }
    @keyframes spinAnim { to{transform:rotate(360deg)} }

    /* Help note (mirrors PMB's contact/SSO helper line under the form) */
    .help-note {
      display: flex; align-items: flex-start; gap: 8px; margin-top: 1rem;
      font-size: .74rem; color: var(--c-muted); line-height: 1.6;
    }
    .help-note i { font-size: 14px; margin-top: 1px; color: var(--c-muted); flex-shrink: 0; }
    .help-note a { color: var(--c-sky); font-weight: 600; text-decoration: none; }
    .help-note a:hover { text-decoration: underline; }

    /* Divider */
    .divider { display: flex; align-items: center; gap: 12px; margin: 1.5rem 0 1.1rem; }
    .divider-line { flex: 1; height: 1px; background: var(--c-border); }
    .divider-text { font-size: .72rem; color: var(--c-muted); font-weight: 500; letter-spacing:.04em; }

    /* PAB Card */
    .pab-card {
      background: var(--c-surface2); border: 1px solid var(--c-border);
      border-radius: var(--radius-md); padding: 1.1rem 1.25rem;
      display: flex; align-items: center; gap: 1rem; text-decoration: none;
      transition: border-color .22s, transform .22s, box-shadow .22s;
      position: relative; overflow: hidden;
    }
    .pab-card::before {
      content: ''; position: absolute; top: 0; left: 0; right: 0; height: 1.5px;
      background: linear-gradient(90deg, var(--c-sky) 0%, var(--c-indigo) 100%);
      opacity: 0; transition: opacity .25s;
    }
    .pab-card:hover { border-color: rgba(14,165,233,.25); transform: translateY(-2px); box-shadow: 0 10px 30px rgba(0,0,0,.3); }
    .pab-card:hover::before { opacity: 1; }
    .pab-icon {
      width: 42px; height: 42px; flex-shrink: 0;
      background: rgba(14,165,233,.09); border: 1px solid rgba(14,165,233,.18);
      border-radius: 10px; display: flex; align-items: center; justify-content: center;
      color: var(--c-sky); transition: background .2s;
    }
    .pab-card:hover .pab-icon { background: rgba(14,165,233,.18); }
    .pab-icon i { font-size: 20px; }
    .pab-body { flex: 1; min-width: 0; }
    .pab-label { font-size: .68rem; font-weight: 700; color: var(--c-muted); text-transform: uppercase; letter-spacing: .08em; margin-bottom: 2px; }
    .pab-title { font-size: .9rem; font-weight: 800; color: #fff; letter-spacing: -.02em; }
    .pab-sub { font-size: .75rem; color: var(--c-muted2); margin-top: 2px; }
    .pab-arrow { color: var(--c-sky); font-size: 20px; flex-shrink: 0; opacity: .6; transition: opacity .2s, transform .2s; }
    .pab-card:hover .pab-arrow { opacity: 1; transform: translateX(3px); }

    .form-note { text-align: center; margin-top: 1.1rem; font-size: .75rem; color: var(--c-muted); }
    .form-note a { color: var(--c-sky); text-decoration: none; font-weight: 600; }
    .form-note a:hover { text-decoration: underline; }

    .field-hint { font-size: .7rem; margin-top: 5px; min-height: 13px; display: flex; align-items: center; gap: 4px; }
    .field-hint.ok  { color: var(--c-green-text); }
    .field-hint.err { color: var(--c-red-text); }

    @keyframes shake {
      0%,100%{transform:translateX(0)} 20%{transform:translateX(-4px)}
      40%{transform:translateX(4px)} 60%{transform:translateX(-2px)} 80%{transform:translateX(2px)}
    }
    .shake { animation: shake .28s ease; }

    /* ═══════════════════════════════
       MOBILE  ≤ 768px
    ═══════════════════════════════ */
    @media (max-width: 768px) {
      .page { grid-template-columns: 1fr; }
      .left-panel { display: none; }

      .right-panel {
        padding: 0; align-items: stretch; justify-content: stretch;
        background: var(--c-bg);
      }

      .mobile-shell { display: flex; flex-direction: column; min-height: 100vh; width: 100%; }

      .mobile-hero {
        position: relative; overflow: hidden;
        padding: 2.8rem 1.5rem 2rem;
        background: var(--c-surface);
        border-bottom: 1px solid var(--c-border);
        flex-shrink: 0;
      }
      .mobile-hero::before {
        content: ''; position: absolute; inset: 0;
        background-image:
          linear-gradient(rgba(14,165,233,0.05) 1px, transparent 1px),
          linear-gradient(90deg, rgba(14,165,233,0.05) 1px, transparent 1px);
        background-size: 48px 48px;
        mask-image: radial-gradient(ellipse 120% 100% at 50% 0%, black 20%, transparent 80%);
        pointer-events: none;
      }
      .mobile-hero::after {
        content: ''; position: absolute; inset: 0;
        background:
          radial-gradient(ellipse 90% 70% at 90% -10%, rgba(14,165,233,.13) 0%, transparent 60%),
          radial-gradient(ellipse 55% 45% at 0% 110%, rgba(99,102,241,.09) 0%, transparent 55%);
        pointer-events: none;
      }
      .mobile-orb {
        position: absolute; width: 260px; height: 260px; border-radius: 50%;
        background: radial-gradient(circle, rgba(14,165,233,.07) 0%, transparent 70%);
        top: -80px; right: -70px; pointer-events: none;
        animation: orb-drift 12s ease-in-out infinite;
      }

      .mobile-brand {
        display: flex; align-items: center; gap: 10px;
        position: relative; z-index: 1; margin-bottom: 1.3rem;
      }
      .mobile-brand-icon {
        width: 38px; height: 38px; background: rgba(14,165,233,.1);
        border: 1px solid rgba(14,165,233,.22); border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        overflow: hidden; flex-shrink: 0;
      }
      .mobile-brand-icon img { width:100%; height:100%; object-fit:contain; padding:6px; filter:brightness(0) invert(1); }
      .mobile-brand-icon i { color:var(--c-sky); font-size:17px; }
      .mobile-brand-name { font-size: 15px; font-weight: 800; color: #fff; letter-spacing: -.35px; }
      .mobile-brand-tag { font-size: 9px; color: var(--c-muted2); display:block; margin-top:1px; letter-spacing:.07em; text-transform:uppercase; }

      .mobile-badge {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 3px 11px;
        background: rgba(14,165,233,.07); border: 1px solid rgba(14,165,233,.2);
        border-radius: 99px; font-size: .6rem; color: var(--c-sky);
        letter-spacing: .08em; text-transform: uppercase;
        margin-bottom: .9rem; position: relative; z-index: 1;
      }
      .mobile-badge-pulse {
        width: 5px; height: 5px; border-radius: 50%; background: var(--c-cyan);
        animation: pulse-glow 2s ease-in-out infinite;
      }

      .mobile-headline {
        position: relative; z-index: 1;
        font-size: 1.65rem; font-weight: 900; color: #fff;
        line-height: 1.1; letter-spacing: -.045em; margin-bottom: .5rem;
      }
      .mobile-sub {
        position: relative; z-index: 1;
        font-size: .8rem; color: var(--c-muted2); line-height: 1.65; max-width: 280px;
      }
      .mobile-stats {
        display: flex; gap: 7px; margin-top: 1.1rem;
        position: relative; z-index: 1; flex-wrap: wrap;
      }

      .mobile-form-area {
        flex: 1; padding: 1.6rem 1.25rem 2.3rem;
        display: flex; flex-direction: column;
      }
      .login-box { max-width: 100%; animation: none; }
      .login-header { margin-bottom: 1.3rem; }
      .login-greeting { font-size: 1.2rem; }
      .login-sub { font-size: .78rem; }
    }

    @media (max-width: 380px) {
      .mobile-hero { padding: 2.2rem 1.1rem 1.6rem; }
      .mobile-headline { font-size: 1.45rem; }
      .mobile-form-area { padding: 1.4rem 1rem 1.8rem; }
      .mobile-stats { gap: 5px; }
      .trust-stat { font-size: .65rem; padding: 3px 9px; }
    }
  </style>
</head>

<body>
<main class="page">

  <!-- ═══ LEFT PANEL (desktop) — illustration + trust stats, PMB-style ═══ -->
  <aside class="left-panel">
    <div class="left-orb-1"></div>
    <div class="left-orb-2"></div>

    <div class="brand">
      <div class="brand-icon">
        <img src="<?= BASE_URL ?>/assets/img/logo-com.png" alt="Logo"
             onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
        <i class="ti ti-shield-lock" aria-hidden="true" style="display:none"></i>
      </div>
      <div>
        <span class="brand-name"><?= htmlspecialchars($settings['org_name']['value'] ?? APP_NAME) ?></span>
        <span class="brand-tagline">Management Portal</span>
      </div>
    </div>

    <div class="left-content">
      <div class="left-badge"><span class="left-badge-pulse"></span>Platform Aktif</div>
      <h1 class="left-headline">Selamat datang<br>kembali, <span class="t-grad">Anggota</span></h1>

      <div class="illustration-wrap">
        <div class="illus-shield"><i class="ti ti-shield-lock"></i></div>
        <div class="illus-card illus-card-1">
          <i class="ti ti-users"></i>
          <div><strong><?= htmlspecialchars($settings['stat_members']['value'] ?? '100+') ?></strong><span>Anggota</span></div>
        </div>
        <div class="illus-card illus-card-2">
          <i class="ti ti-calendar-event"></i>
          <div><strong><?= htmlspecialchars($settings['stat_events']['value'] ?? '50+') ?></strong><span>Kegiatan</span></div>
        </div>
      </div>

      <p class="left-desc">Masuk menggunakan Nomor Induk Anggota (NIA) untuk akun anggota, atau email untuk akun administrator. Pastikan kata sandi Anda terjaga kerahasiaannya.</p>

      <div class="trust-stats">
        <span class="trust-stat"><i class="ti ti-users"></i> <?= htmlspecialchars($settings['stat_members']['value'] ?? '100+') ?> Anggota</span>
        <span class="trust-stat"><i class="ti ti-calendar-event"></i> <?= htmlspecialchars($settings['stat_events']['value'] ?? '50+') ?> Kegiatan</span>
        <span class="trust-stat"><i class="ti ti-star"></i> <?= htmlspecialchars($settings['stat_awards']['value'] ?? '20+') ?> Prestasi</span>
      </div>
    </div>

    <p class="left-footer">&copy; <?= date('Y') ?> <?= htmlspecialchars($settings['org_name']['value'] ?? APP_NAME) ?>. Hak cipta dilindungi.</p>
  </aside>

  <!-- ═══ RIGHT PANEL ═══ -->
  <section class="right-panel">
    <div class="mobile-shell">

      <!-- Mobile hero strip (hidden on desktop via CSS — only visible ≤768px) -->
      <div class="mobile-hero">
        <div class="mobile-orb"></div>
        <div class="mobile-brand">
          <div class="mobile-brand-icon">
            <img src="<?= BASE_URL ?>/assets/img/logo-com.png" alt="Logo"
                 onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
            <i class="ti ti-shield-lock" style="display:none"></i>
          </div>
          <div>
            <span class="mobile-brand-name"><?= htmlspecialchars($settings['org_name']['value'] ?? APP_NAME) ?></span>
            <span class="mobile-brand-tag">Management Portal</span>
          </div>
        </div>
        <div class="mobile-badge"><span class="mobile-badge-pulse"></span>Platform Aktif</div>
        <h1 class="mobile-headline">Selamat datang,<br><span class="t-grad">Anggota</span></h1>
        <p class="mobile-sub">Masuk dan kelola aktivitas organisasimu dengan mudah.</p>
        <div class="mobile-stats">
          <span class="trust-stat"><i class="ti ti-users"></i> <?= htmlspecialchars($settings['stat_members']['value'] ?? '100+') ?> Anggota</span>
          <span class="trust-stat"><i class="ti ti-calendar-event"></i> <?= htmlspecialchars($settings['stat_events']['value'] ?? '50+') ?> Kegiatan</span>
          <span class="trust-stat"><i class="ti ti-star"></i> <?= htmlspecialchars($settings['stat_awards']['value'] ?? '20+') ?> Prestasi</span>
        </div>
      </div>

      <!-- Form area -->
      <div class="mobile-form-area">
        <div class="login-box">

          <div class="login-header">
            <h2 class="login-greeting">Masuk ke akun</h2>
            <p class="login-sub">Pilih tipe akun, lalu masukkan kredensial dan kata sandi Anda untuk melanjutkan.</p>
          </div>

          <?php if (!empty($flash)): ?>
          <div class="flash <?= $flash['type'] === 'error' ? 'error' : 'success' ?>"
               role="alert" data-auto-dismiss="6000">
            <i class="ti ti-<?= $flash['type']==='error' ? 'alert-circle' : 'circle-check' ?>"></i>
            <span><?= htmlspecialchars($flash['msg']) ?></span>
          </div>
          <?php endif; ?>

          <div class="flash error" id="js-alert" role="alert" aria-live="polite" style="display:none">
            <i class="ti ti-alert-circle"></i>
            <span id="js-alert-msg"></span>
          </div>

          <!-- Tabs -->
          <div class="tab-bar" role="tablist" aria-label="Tipe login">
            <button class="tab-btn active" id="tab-member" role="tab" aria-selected="true" aria-controls="panel-member" type="button">
              <i class="ti ti-id-badge"></i> Anggota
            </button>
            <button class="tab-btn" id="tab-admin" role="tab" aria-selected="false" aria-controls="panel-admin" type="button">
              <i class="ti ti-user-shield"></i> Administrator
            </button>
          </div>

          <!-- Form Anggota -->
          <form method="POST" action="<?= BASE_URL ?>/login" id="form-member" novalidate autocomplete="on" style="display:block">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
            <input type="hidden" name="login_type" value="member">
            <input type="hidden" name="redirect_to" value="<?= htmlspecialchars($redirectTo ?? '') ?>">
            <div id="panel-member" class="panel active" role="tabpanel" aria-labelledby="tab-member">
              <div class="field-group">
                <label class="field-label" for="nia">Nomor Induk Anggota (NIA)</label>
                <div class="field-wrap">
                  <i class="ti ti-id field-icon"></i>
                  <input type="text" id="nia" name="nia" class="field-input"
                         placeholder="Contoh: 2024001" autocomplete="username"
                         inputmode="numeric" maxlength="12"
                         value="<?= htmlspecialchars($_POST['nia'] ?? '') ?>" required />
                </div>
                <div class="field-hint" id="nia-hint" aria-live="polite"></div>
              </div>
            </div>
            <div class="field-group">
              <label class="field-label" for="password-m">Kata Sandi</label>
              <div class="field-wrap">
                <i class="ti ti-lock field-icon"></i>
                <input type="password" id="password-m" name="password" class="field-input has-eye"
                       placeholder="Masukkan kata sandi" autocomplete="current-password" required />
                <button type="button" class="eye-btn" data-for="password-m" aria-label="Tampilkan atau sembunyikan kata sandi">
                  <i class="ti ti-eye"></i>
                </button>
              </div>
            </div>
            <div class="remember-row">
              <label class="check-wrap">
                <input type="checkbox" name="remember" id="remember-m" value="1">
                <span class="check-box"></span>
                <span class="check-label">Ingat saya</span>
              </label>
              <a href="<?= BASE_URL ?>/forgot-password" class="forgot-link">Lupa sandi?</a>
            </div>
            <button type="submit" class="submit-btn" id="submit-member">
              <i class="ti ti-refresh spin"></i>
              <i class="ti ti-login btn-ico"></i>
              <span class="btn-tx">Masuk sebagai Anggota</span>
            </button>
            <p class="help-note"><i class="ti ti-info-circle"></i><span>Belum bisa masuk? Hubungi sekretariat atau lihat menu <a href="<?= BASE_URL ?>/pab">Penerimaan Anggota Baru</a> di bawah.</span></p>
          </form>

          <!-- Form Admin -->
          <form method="POST" action="<?= BASE_URL ?>/login" id="form-admin" novalidate autocomplete="on" style="display:none">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
            <input type="hidden" name="login_type" value="admin">
            <input type="hidden" name="redirect_to" value="<?= htmlspecialchars($redirectTo ?? '') ?>">
            <div id="panel-admin" class="panel active" role="tabpanel" aria-labelledby="tab-admin">
              <div class="field-group">
                <label class="field-label" for="email">Alamat Email</label>
                <div class="field-wrap">
                  <i class="ti ti-mail field-icon"></i>
                  <input type="email" id="email" name="email" class="field-input"
                         placeholder="admin@organisasi.id" autocomplete="email" required />
                </div>
                <div class="field-hint" id="email-hint" aria-live="polite"></div>
              </div>
              <div class="field-group">
                <label class="field-label" for="password-a">Kata Sandi Administrator</label>
                <div class="field-wrap">
                  <i class="ti ti-lock field-icon"></i>
                  <input type="password" id="password-a" name="password" class="field-input has-eye"
                         placeholder="Masukkan kata sandi" autocomplete="current-password" required />
                  <button type="button" class="eye-btn" data-for="password-a" aria-label="Tampilkan atau sembunyikan kata sandi">
                    <i class="ti ti-eye"></i>
                  </button>
                </div>
              </div>
              <div class="remember-row">
                <label class="check-wrap">
                  <input type="checkbox" name="remember" id="remember-a" value="1">
                  <span class="check-box"></span>
                  <span class="check-label">Ingat saya</span>
                </label>
                <a href="<?= BASE_URL ?>/forgot-password" class="forgot-link">Lupa sandi?</a>
              </div>
              <div class="flash info">
                <i class="ti ti-shield-lock"></i>
                <span>Area ini hanya untuk staf administrator yang berwenang. Akses tidak sah akan dicatat dan dilaporkan.</span>
              </div>
            </div>
            <button type="submit" class="submit-btn" id="submit-admin">
              <i class="ti ti-refresh spin"></i>
              <i class="ti ti-login btn-ico"></i>
              <span class="btn-tx">Masuk sebagai Administrator</span>
            </button>
          </form>

          <!-- PAB Section (member only, hidden on admin tab) -->
          <div id="pab-section">
            <div class="divider">
              <span class="divider-line"></span>
              <span class="divider-text">Belum punya akun?</span>
              <span class="divider-line"></span>
            </div>
            <a href="<?= BASE_URL ?>/pab" class="pab-card">
              <div class="pab-icon"><i class="ti ti-user-plus"></i></div>
              <div class="pab-body">
                <div class="pab-label">Penerimaan Anggota Baru</div>
                <div class="pab-title">Daftar PAB Sekarang</div>
                <div class="pab-sub">Bergabung dan jadilah bagian dari keluarga kami</div>
              </div>
              <i class="ti ti-chevron-right pab-arrow"></i>
            </a>
          </div>

          <!-- Back to home — single link, always shown -->
          <p class="form-note" style="margin-top:1.1rem">
            <a href="<?= BASE_URL ?>/">← Kembali ke Beranda</a>
          </p>

        </div><!-- /.login-box -->
      </div><!-- /.mobile-form-area -->

    </div><!-- /.mobile-shell -->
  </section>

</main>

<script>
(function () {
'use strict';

var REX_EMAIL = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;
var cur = 'member';

var tabMember  = document.getElementById('tab-member');
var tabAdmin   = document.getElementById('tab-admin');
var formMember = document.getElementById('form-member');
var formAdmin  = document.getElementById('form-admin');
var pabSection = document.getElementById('pab-section');
var jsAlert    = document.getElementById('js-alert');
var jsAlertMsg = document.getElementById('js-alert-msg');

function switchTab(type) {
  if (type === cur) return;
  cur = type;
  var isMember = (type === 'member');

  tabMember.classList.toggle('active', isMember);
  tabAdmin.classList.toggle('active', !isMember);
  tabMember.setAttribute('aria-selected', String(isMember));
  tabAdmin.setAttribute('aria-selected', String(!isMember));

  formMember.style.display = isMember ? 'block' : 'none';
  formAdmin.style.display  = isMember ? 'none'  : 'block';

  if (pabSection) pabSection.style.display = isMember ? 'block' : 'none';

  hideAlert();

  if (isMember) {
    document.getElementById('email').value      = '';
    document.getElementById('password-a').value = '';
    document.getElementById('remember-a').checked = false;
  } else {
    document.getElementById('nia').value        = '';
    document.getElementById('password-m').value = '';
    document.getElementById('remember-m').checked = false;
  }
  try { sessionStorage.setItem('login_tab', type); } catch(e) {}
}

tabMember.addEventListener('click', function() { switchTab('member'); });
tabAdmin.addEventListener('click',  function() { switchTab('admin'); });

[tabMember, tabAdmin].forEach(function(btn, i) {
  btn.addEventListener('keydown', function(e) {
    var tabs = [tabMember, tabAdmin], nxt;
    if (e.key==='ArrowRight'||e.key==='ArrowDown') nxt = tabs[(i+1)%2];
    if (e.key==='ArrowLeft' ||e.key==='ArrowUp')   nxt = tabs[(i+1)%2];
    if (nxt) { nxt.click(); nxt.focus(); e.preventDefault(); }
  });
});

(function() {
  var saved = 'member';
  try { saved = sessionStorage.getItem('login_tab') || 'member'; } catch(e) {}
  if (saved === 'admin') switchTab('admin');
})();

function showAlert(msg) { jsAlertMsg.textContent = msg; jsAlert.style.display = 'flex'; }
function hideAlert()    { jsAlert.style.display = 'none'; }

document.querySelectorAll('.flash[data-auto-dismiss]').forEach(function(el) {
  setTimeout(function() { fadeOut(el); }, parseInt(el.dataset.autoDismiss,10)||6000);
});
function fadeOut(el) {
  if (el._dismissing) return; el._dismissing = true;
  el.style.transition = 'opacity .3s, transform .3s';
  el.style.opacity = '0'; el.style.transform = 'translateY(-4px)';
  setTimeout(function() { if (el.parentNode) el.parentNode.removeChild(el); }, 350);
}

document.querySelectorAll('.eye-btn[data-for]').forEach(function(btn) {
  btn.addEventListener('click', function() {
    var inp = document.getElementById(btn.dataset.for); if (!inp) return;
    var show = inp.type==='password'; inp.type = show ? 'text' : 'password';
    btn.querySelector('i').className = show ? 'ti ti-eye-off' : 'ti ti-eye';
    btn.setAttribute('aria-label', show ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi');
    inp.focus();
  });
});

var niaEl=document.getElementById('nia'), niaHint=document.getElementById('nia-hint');
if (niaEl) niaEl.addEventListener('input', function() {
  this.value = this.value.replace(/\D/g,'');
  var v=this.value;
  if (!v) { niaHint.textContent=''; niaHint.className='field-hint'; this.classList.remove('is-invalid'); return; }
  if (v.length>=5&&v.length<=12) { niaHint.textContent='✓ Format NIA valid'; niaHint.className='field-hint ok'; this.classList.remove('is-invalid'); }
  else { niaHint.textContent='Masukkan 5–12 digit angka'; niaHint.className='field-hint err'; }
});

var emailEl=document.getElementById('email'), emailHint=document.getElementById('email-hint');
if (emailEl) emailEl.addEventListener('input', function() {
  var v=this.value;
  if (!v) { emailHint.textContent=''; emailHint.className='field-hint'; this.classList.remove('is-invalid'); return; }
  var ok=REX_EMAIL.test(v);
  emailHint.textContent = ok ? '✓ Format email valid' : 'Format email tidak valid';
  emailHint.className = 'field-hint '+(ok?'ok':'err');
  this.classList.toggle('is-invalid',!ok);
});

function shake(el) {
  if (!el) return;
  el.classList.remove('shake'); void el.offsetWidth; el.classList.add('shake');
  el.addEventListener('animationend', function(){el.classList.remove('shake');},{once:true});
}

function handleSubmit(frm, type) {
  frm.addEventListener('submit', function(e) {
    hideAlert();
    var valid=true, first=null;
    frm.querySelectorAll('input[required]').forEach(function(f) {
      if (!f.value.trim()) { valid=false; f.classList.add('is-invalid'); setTimeout(function(){f.classList.remove('is-invalid');},2800); if (!first) first=f; }
    });
    if (!valid) { e.preventDefault(); showAlert('Harap isi semua kolom yang diperlukan.'); shake(frm.querySelector('.submit-btn')); if (first) first.focus(); return; }
    if (type==='admin') {
      var em=document.getElementById('email');
      if (em&&!REX_EMAIL.test(em.value)) {
        e.preventDefault(); showAlert('Masukkan alamat email yang valid.');
        em.classList.add('is-invalid'); setTimeout(function(){em.classList.remove('is-invalid');},2800);
        shake(em.closest('.field-wrap')); em.focus(); return;
      }
    }
    var btn=frm.querySelector('.submit-btn'), spin=frm.querySelector('.spin'),
        ico=frm.querySelector('.btn-ico'), tx=frm.querySelector('.btn-tx');
    if (btn) btn.disabled=true;
    if (spin) spin.style.display='inline-block';
    if (ico)  ico.style.display='none';
    if (tx)   tx.textContent='Memproses…';
    try { sessionStorage.setItem('login_tab',type); } catch(err){}
  });
}

handleSubmit(formMember,'member');
handleSubmit(formAdmin,'admin');

/* hide mobile-hero on desktop so it takes no space */
(function() {
  var hero = document.querySelector('.mobile-hero');
  if (!hero) return;
  function check() {
    hero.style.display = window.innerWidth > 768 ? 'none' : '';
  }
  check();
  window.addEventListener('resize', check);
})();

}());
</script>
</body>
</html>