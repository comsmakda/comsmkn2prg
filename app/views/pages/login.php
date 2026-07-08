<?php // app/views/pages/login.php ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Masuk — <?= htmlspecialchars($settings['org_name']['value'] ?? 'Community Programmer SMKN 2 Pinrang') ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />

  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --c-page:        #eef2f6;
      --c-white:       #ffffff;
      --c-ink:         #0f172a;
      --c-muted:       #64748b;
      --c-muted2:      #94a3b8;
      --c-border:      #e6ebf1;

      --c-primary:     #0e7490;
      --c-primary-dk:  #0b5a70;
      --c-primary-lt:  #06b6d4;

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

      --radius-sm: 9px;
      --radius-md: 13px;
      --radius-lg: 22px;
    }

    html, body { height: 100%; font-family: 'Plus Jakarta Sans', sans-serif; background: var(--c-page); color: var(--c-ink); }

    /* ═══ PAGE WRAPPER ═══ */
    .page {
      min-height: 100vh; display: flex; align-items: center; justify-content: center;
      padding: 2.2rem 1.5rem;
    }

    /* ═══ SINGLE CONTAINER — split left(scroll)/right(fixed) ═══ */
    .auth-shell {
      width: 100%; max-width: 1130px;
      height: min(88vh, 760px);
      background: var(--c-white);
      border-radius: var(--radius-lg);
      box-shadow: 0 30px 70px -20px rgba(15,23,42,.28), 0 4px 18px rgba(15,23,42,.06);
      display: grid; grid-template-columns: 1.28fr 1fr;
      overflow: hidden; position: relative;
    }

    /* ─── LEFT: form + info, SCROLLABLE ─── */
    .auth-left {
      overflow-y: auto; overflow-x: hidden;
      padding: 2.6rem 3.2rem 2.8rem;
      position: relative;
    }
    .auth-left::-webkit-scrollbar { width: 7px; }
    .auth-left::-webkit-scrollbar-track { background: transparent; }
    .auth-left::-webkit-scrollbar-thumb { background: #dbe3ec; border-radius: 10px; }
    .auth-left::-webkit-scrollbar-thumb:hover { background: #c3cedb; }

    .back-btn {
      width: 42px; height: 42px; border-radius: 50%;
      border: 1.5px solid var(--c-border); background: var(--c-white);
      display: flex; align-items: center; justify-content: center;
      color: var(--c-primary); text-decoration: none; margin-bottom: 1.8rem;
      transition: background .15s, border-color .15s, transform .15s;
    }
    .back-btn:hover { background: #f0f9fb; border-color: var(--c-primary-lt); transform: translateX(-2px); }
    .back-btn i { font-size: 20px; }

    .login-title {
      font-size: 2.3rem; font-weight: 800; color: var(--c-primary-dk);
      letter-spacing: -.03em; margin-bottom: .35rem;
    }
    .login-sub { font-size: .87rem; color: var(--c-muted); margin-bottom: 1.5rem; line-height: 1.7; }

    /* Info / alert boxes */
    .info-box {
      display: flex; align-items: flex-start; gap: 10px;
      background: var(--c-amber-bg); border: 1px solid var(--c-amber-border);
      border-radius: var(--radius-md); padding: 12px 15px; margin-bottom: .85rem;
    }
    .info-box i { font-size: 17px; color: var(--c-amber-icon); margin-top: 1px; flex-shrink: 0; }
    .info-box p { font-size: .82rem; color: var(--c-amber-text); line-height: 1.65; font-weight: 500; }
    .info-box a { color: var(--c-primary-dk); font-weight: 700; text-decoration: underline; }

    .flash {
      display: flex; align-items: flex-start; gap: 10px;
      border-radius: var(--radius-md); padding: 11px 14px;
      font-size: .82rem; font-weight: 500; margin-bottom: .9rem; animation: slideIn .22s ease;
    }
    .flash i { font-size: 16px; margin-top: 1px; flex-shrink: 0; }
    .flash.error   { background:var(--c-red-bg);   color:var(--c-red-text);   border:1px solid var(--c-red-border);   }
    .flash.success { background:var(--c-green-bg); color:var(--c-green-text); border:1px solid var(--c-green-border); }
    .flash.info    { background:#f0f9fb; color:var(--c-muted); border:1px solid #d7ecf1; font-weight:400; font-size:.78rem; }
    @keyframes slideIn { from{opacity:0;transform:translateY(-6px)} to{opacity:1;transform:translateY(0)} }

    /* Tabs */
    .tab-bar {
      display: flex; background: #f4f7fa; border: 1px solid var(--c-border);
      border-radius: var(--radius-md); padding: 4px; gap: 4px; margin: 1.4rem 0 1.5rem;
    }
    .tab-btn {
      flex: 1; display: flex; align-items: center; justify-content: center; gap: 7px;
      padding: 9px 0; border: none; background: transparent; border-radius: 9px;
      font-family: 'Plus Jakarta Sans', sans-serif; font-size: .82rem; font-weight: 700;
      color: var(--c-muted); cursor: pointer;
      transition: background .18s, color .18s, box-shadow .18s;
    }
    .tab-btn i { font-size: 16px; }
    .tab-btn.active { background: var(--c-primary); color: #fff; box-shadow: 0 3px 14px rgba(14,116,144,.28); }
    .tab-btn:not(.active):hover { background: #eaeff4; color: var(--c-ink); }

    /* Fields */
    .field-group { margin-bottom: 1.1rem; }
    .field-label {
      display: block; font-size: .78rem; font-weight: 700; color: var(--c-ink);
      margin-bottom: 6px;
    }
    .field-wrap { position: relative; }
    .field-icon {
      position: absolute; right: 14px; top: 50%; transform: translateY(-50%);
      font-size: 17px; color: var(--c-muted2); pointer-events: none; transition: color .18s;
    }
    .field-wrap:focus-within .field-icon { color: var(--c-primary); }
    .field-input {
      width: 100%; padding: 12px 42px 12px 15px; background: #fbfcfe;
      border: 1.5px solid var(--c-border); border-radius: var(--radius-sm);
      font-family: 'Plus Jakarta Sans', sans-serif; font-size: .9rem; color: var(--c-ink);
      outline: none; transition: border .16s, box-shadow .16s, background .16s;
    }
    .field-input:focus { border-color: var(--c-primary-lt); box-shadow: 0 0 0 3px rgba(6,182,212,.12); background: #fff; }
    .field-input::placeholder { color: var(--c-muted2); }
    .field-input.has-eye { padding-right: 42px; }
    .field-input.is-invalid { border-color: #ef4444; box-shadow: 0 0 0 3px rgba(239,68,68,.1); }
    .eye-btn {
      position: absolute; right: 14px; top: 50%; transform: translateY(-50%);
      background: none; border: none; cursor: pointer; padding: 0; color: var(--c-muted2);
      font-size: 17px; line-height: 1; transition: color .15s;
    }
    .eye-btn:hover { color: var(--c-primary); }
    .panel { display: none; }
    .panel.active { display: block; }

    /* Remember-me row */
    .remember-row { display: flex; align-items: center; justify-content: space-between; margin: -.15rem 0 1.1rem; }
    .check-wrap { display: flex; align-items: center; gap: 8px; cursor: pointer; user-select: none; }
    .check-wrap input { position: absolute; opacity: 0; width: 0; height: 0; }
    .check-box {
      width: 17px; height: 17px; border-radius: 5px; border: 1.5px solid var(--c-border);
      background: #fbfcfe; display: flex; align-items: center; justify-content: center;
      transition: background .15s, border-color .15s; flex-shrink: 0;
    }
    .check-box::after {
      content: '\ea5e'; font-family: 'tabler-icons' !important; font-size: 12px; color: #fff;
      opacity: 0; transform: scale(.6); transition: opacity .12s, transform .12s;
    }
    .check-wrap input:checked + .check-box { background: var(--c-primary); border-color: var(--c-primary); }
    .check-wrap input:checked + .check-box::after { opacity: 1; transform: scale(1); }
    .check-wrap input:focus-visible + .check-box { box-shadow: 0 0 0 3px rgba(14,116,144,.18); }
    .check-label { font-size: .8rem; color: var(--c-muted); font-weight: 500; }
    .forgot-link { font-size: .8rem; color: var(--c-primary); font-weight: 700; text-decoration: none; }
    .forgot-link:hover { text-decoration: underline; }

    /* Submit */
    .submit-btn {
      width: 100%; padding: 13px; background: var(--c-primary); color: #fff; border: none;
      border-radius: var(--radius-sm); font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: .9rem; font-weight: 800; cursor: pointer;
      display: flex; align-items: center; justify-content: center; gap: 9px;
      transition: background .18s, transform .12s, box-shadow .18s;
      box-shadow: 0 8px 22px rgba(14,116,144,.25);
    }
    .submit-btn:hover:not(:disabled) { background: var(--c-primary-lt); transform: translateY(-2px); box-shadow: 0 12px 28px rgba(6,182,212,.3); }
    .submit-btn:active:not(:disabled) { transform: scale(0.985); }
    .submit-btn:disabled { opacity:.55; cursor:not-allowed; }
    .submit-btn i { font-size: 18px; }
    .submit-btn .spin { display:none; animation: spinAnim .65s linear infinite; }
    @keyframes spinAnim { to{transform:rotate(360deg)} }

    .help-note {
      display: flex; align-items: flex-start; gap: 8px; margin-top: 1rem;
      font-size: .76rem; color: var(--c-muted2); line-height: 1.6;
    }
    .help-note i { font-size: 14px; margin-top: 1px; color: var(--c-muted2); flex-shrink: 0; }
    .help-note a { color: var(--c-primary); font-weight: 700; text-decoration: none; }
    .help-note a:hover { text-decoration: underline; }

    /* Divider */
    .divider { display: flex; align-items: center; gap: 12px; margin: 1.5rem 0 1.1rem; }
    .divider-line { flex: 1; height: 1px; background: var(--c-border); }
    .divider-text { font-size: .72rem; color: var(--c-muted2); font-weight: 500; }

    /* PAB Card */
    .pab-card {
      background: #fbfcfe; border: 1px solid var(--c-border);
      border-radius: var(--radius-md); padding: 1.05rem 1.2rem;
      display: flex; align-items: center; gap: 1rem; text-decoration: none;
      transition: border-color .22s, transform .22s, box-shadow .22s;
      position: relative; overflow: hidden;
    }
    .pab-card::before {
      content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px;
      background: linear-gradient(90deg, var(--c-primary) 0%, var(--c-primary-lt) 100%);
      opacity: 0; transition: opacity .25s;
    }
    .pab-card:hover { border-color: rgba(14,116,144,.3); transform: translateY(-2px); box-shadow: 0 12px 26px rgba(15,23,42,.08); }
    .pab-card:hover::before { opacity: 1; }
    .pab-icon {
      width: 42px; height: 42px; flex-shrink: 0;
      background: #eaf6f8; border: 1px solid #d7ecf1;
      border-radius: 10px; display: flex; align-items: center; justify-content: center;
      color: var(--c-primary); transition: background .2s;
    }
    .pab-card:hover .pab-icon { background: #dcf1f4; }
    .pab-icon i { font-size: 20px; }
    .pab-body { flex: 1; min-width: 0; }
    .pab-label { font-size: .66rem; font-weight: 700; color: var(--c-muted2); text-transform: uppercase; letter-spacing: .07em; margin-bottom: 2px; }
    .pab-title { font-size: .9rem; font-weight: 800; color: var(--c-ink); letter-spacing: -.02em; }
    .pab-sub { font-size: .75rem; color: var(--c-muted); margin-top: 2px; }
    .pab-arrow { color: var(--c-primary); font-size: 20px; flex-shrink: 0; opacity: .6; transition: opacity .2s, transform .2s; }
    .pab-card:hover .pab-arrow { opacity: 1; transform: translateX(3px); }

    .form-note { text-align: center; margin-top: 1.2rem; font-size: .78rem; color: var(--c-muted2); padding-bottom: .3rem; }
    .form-note a { color: var(--c-primary); text-decoration: none; font-weight: 700; }
    .form-note a:hover { text-decoration: underline; }

    .field-hint { font-size: .7rem; margin-top: 5px; min-height: 13px; display: flex; align-items: center; gap: 4px; }
    .field-hint.ok  { color: var(--c-green-text); }
    .field-hint.err { color: var(--c-red-text); }

    @keyframes shake {
      0%,100%{transform:translateX(0)} 20%{transform:translateX(-4px)}
      40%{transform:translateX(4px)} 60%{transform:translateX(-2px)} 80%{transform:translateX(2px)}
    }
    .shake { animation: shake .28s ease; }

    /* ─── RIGHT: organization photo + logo + name, FIXED (no scroll) ─── */
    .auth-right {
      position: relative; overflow: hidden;
      background: linear-gradient(165deg, var(--c-primary-dk) 0%, #0a3a4c 100%); /* instant paint while photo loads */
      display: flex; flex-direction: column; justify-content: flex-end;
      padding: 2.4rem 2.2rem;
    }
    /* photo sits behind everything, fades in only once fully loaded */
    .auth-right-img {
      position: absolute; inset: 0; width: 100%; height: 100%;
      object-fit: cover; object-position: center;
      opacity: 0; transition: opacity .5s ease;
      z-index: 0;
    }
    .auth-right-img.is-loaded { opacity: 1; }
    /* darken overlay so text stays readable regardless of photo */
    .auth-right-overlay {
      position: absolute; inset: 0; z-index: 1; pointer-events: none;
      background: linear-gradient(175deg, rgba(9,25,38,.35) 0%, rgba(9,45,64,.55) 45%, rgba(6,30,44,.88) 100%);
    }
    .auth-right-glow {
      position: absolute; inset: 0; z-index: 1; pointer-events: none;
      background: radial-gradient(ellipse 90% 70% at 100% 100%, rgba(6,182,212,.18) 0%, transparent 60%);
    }

    /* logo — no background box, just the mark itself */
    .org-logo {
      position: relative; z-index: 2;
      max-width: 84px; max-height: 84px; width: auto; height: auto;
      object-fit: contain; margin-bottom: 1.1rem;
      filter: drop-shadow(0 3px 10px rgba(0,0,0,.35));
    }
    .org-logo-fallback {
      position: relative; z-index: 2;
      color: #fff; font-size: 40px; margin-bottom: 1.1rem;
      filter: drop-shadow(0 3px 10px rgba(0,0,0,.35));
      display: none;
    }
    .org-name {
      position: relative; z-index: 2;
      font-size: 1.65rem; font-weight: 800; color: #fff;
      line-height: 1.25; letter-spacing: -.02em;
      text-shadow: 0 2px 18px rgba(0,0,0,.25);
    }
    .org-tag {
      position: relative; z-index: 2;
      font-size: .78rem; color: rgba(255,255,255,.75); margin-top: .6rem; line-height: 1.6;
      max-width: 300px;
    }

    /* ═══════════════════════════════
       MOBILE  ≤ 860px
    ═══════════════════════════════ */
    @media (max-width: 860px) {
      .page { padding: 0; align-items: stretch; }
      .auth-shell {
        max-width: 100%; height: auto; min-height: 100vh;
        border-radius: 0; grid-template-columns: 1fr;
        grid-template-rows: auto 1fr;
      }
      .auth-right {
        order: -1; padding: 2rem 1.5rem 1.6rem; min-height: 190px;
      }
      .org-name { font-size: 1.3rem; }
      .org-logo { max-width: 64px; max-height: 64px; }
      .auth-left { overflow-y: visible; padding: 1.9rem 1.4rem 2.2rem; }
      .login-title { font-size: 1.7rem; }
    }
  </style>
</head>

<body>
<div class="page">
  <div class="auth-shell">

    <!-- ═══ LEFT: form + info — SCROLLABLE ═══ -->
    <div class="auth-left">

      <a href="<?= BASE_URL ?>/" class="back-btn" aria-label="Kembali ke beranda">
        <i class="ti ti-arrow-left"></i>
      </a>

      <h1 class="login-title">Login</h1>
      <p class="login-sub">Masuk ke portal keanggotaan menggunakan akun Anggota atau Administrator.</p>

      <div class="info-box">
        <i class="ti ti-alert-circle"></i>
        <p>Silahkan login menggunakan <strong>NIA (Nomor Induk Anggota)</strong> beserta kata sandi Anda untuk akun Anggota, atau <strong>email</strong> dan kata sandi untuk akun Administrator.</p>
      </div>
      <div class="info-box">
        <i class="ti ti-alert-circle"></i>
        <p>Butuh bantuan atau lupa kata sandi? Hubungi admin melalui grup WhatsApp Community Programmer pada link berikut: <a href="#" target="_blank" rel="noopener">Gabung Grup WhatsApp</a></p>
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
              <input type="text" id="nia" name="nia" class="field-input"
                     placeholder="Contoh: 2024001" autocomplete="username"
                     inputmode="numeric" maxlength="12"
                     value="<?= htmlspecialchars($_POST['nia'] ?? '') ?>" required />
              <i class="ti ti-id field-icon"></i>
            </div>
            <div class="field-hint" id="nia-hint" aria-live="polite"></div>
          </div>
        </div>
        <div class="field-group">
          <label class="field-label" for="password-m">Kata Sandi</label>
          <div class="field-wrap">
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
        <p class="help-note"><i class="ti ti-info-circle"></i><span>Belum punya akun? Lihat menu Penerimaan Anggota Baru di bawah.</span></p>
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
              <input type="email" id="email" name="email" class="field-input"
                     placeholder="admin@organisasi.id" autocomplete="email" required />
              <i class="ti ti-mail field-icon"></i>
            </div>
            <div class="field-hint" id="email-hint" aria-live="polite"></div>
          </div>
          <div class="field-group">
            <label class="field-label" for="password-a">Kata Sandi Administrator</label>
            <div class="field-wrap">
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

      <!-- PAB Section (member only) -->
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

      <p class="form-note">
        <a href="<?= BASE_URL ?>/">← Kembali ke Beranda</a>
      </p>

    </div><!-- /.auth-left -->

    <!-- ═══ RIGHT: organization branding — FIXED, no scroll ═══ -->
    <div class="auth-right">
      <img
        class="auth-right-img"
        id="auth-right-img"
        src="<?= BASE_URL ?>/assets/img/gedung-smkn2.webp"
        alt=""
        loading="eager"
        decoding="async"
        fetchpriority="high"
        onload="this.classList.add('is-loaded')"
        onerror="this.style.display='none'"
      />
      <div class="auth-right-overlay"></div>
      <div class="auth-right-glow"></div>

      <img src="<?= BASE_URL ?>/assets/img/logo-com.png" alt="Logo" class="org-logo"
           loading="eager" decoding="async"
           onerror="this.style.display='none';this.nextElementSibling.style.display='block'">
      <i class="ti ti-code org-logo-fallback"></i>

      <h2 class="org-name"><?= htmlspecialchars($settings['org_name']['value'] ?? 'Community Programmer SMKN 2 Pinrang') ?></h2>
      <p class="org-tag">Wadah belajar dan berkarya di bidang teknologi bagi siswa SMKN 2 Pinrang.</p>
    </div>

  </div><!-- /.auth-shell -->
</div><!-- /.page -->

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

/* if the org photo was already cached and loaded before this script ran, fade it in immediately */
(function() {
  var img = document.getElementById('auth-right-img');
  if (img && img.complete && img.naturalWidth > 0) img.classList.add('is-loaded');
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

}());
</script>
</body>
</html>