<?php // app/views/pages/login.php ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Masuk — <?= htmlspecialchars($settings['org_name']['value'] ?? APP_NAME) ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />

  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --blue-50:  #E6F1FB;
      --blue-100: #B5D4F4;
      --blue-200: #85B7EB;
      --blue-400: #378ADD;
      --blue-600: #185FA5;
      --blue-800: #0C447C;
      --blue-900: #042C53;
      --red-50:   #FCEBEB;
      --red-200:  #F09595;
      --red-600:  #A32D2D;
      --green-50: #EAF3DE;
      --green-200:#97C459;
      --green-600:#3B6D11;
      --radius-sm: 8px;
      --radius-md: 12px;
      --radius-lg: 18px;
      --radius-xl: 24px;
    }

    html, body {
      height: 100%;
      font-family: 'Plus Jakarta Sans', sans-serif;
      background: var(--blue-50);
    }

    /* ─── Page Layout ─── */
    .page {
      min-height: 100vh;
      display: grid;
      grid-template-columns: 1fr 1fr;
    }

    /* ─── Left Panel ─── */
    .left-panel {
      background: var(--blue-900);
      position: relative;
      overflow: hidden;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      padding: 3rem;
    }

    .left-panel::before {
      content: '';
      position: absolute;
      width: 480px; height: 480px;
      border-radius: 50%;
      background: rgba(55,138,221,0.12);
      top: -120px; right: -120px;
      pointer-events: none;
    }
    .left-panel::after {
      content: '';
      position: absolute;
      width: 300px; height: 300px;
      border-radius: 50%;
      background: rgba(12,68,124,0.25);
      bottom: -80px; left: -80px;
      pointer-events: none;
    }

    .brand {
      display: flex;
      align-items: center;
      gap: 12px;
      position: relative;
      z-index: 1;
    }
    .brand-icon {
      width: 46px; height: 46px;
      background: var(--blue-600);
      border-radius: var(--radius-sm);
      display: flex; align-items: center; justify-content: center;
      flex-shrink: 0;
      overflow: hidden;
    }
    .brand-icon img {
      width: 100%; height: 100%;
      object-fit: contain;
      padding: 8px;
      filter: brightness(0) invert(1);
    }
    .brand-icon i { color: #fff; font-size: 22px; }
    .brand-name {
      font-size: 20px;
      font-weight: 700;
      color: #fff;
      letter-spacing: -0.4px;
    }
    .brand-tagline {
      font-size: 11.5px;
      color: var(--blue-200);
      font-weight: 400;
      display: block;
      margin-top: 2px;
      letter-spacing: 0.3px;
      text-transform: uppercase;
    }

    .left-content {
      position: relative;
      z-index: 1;
    }
    .left-headline {
      font-size: 36px;
      font-weight: 700;
      color: #fff;
      line-height: 1.2;
      letter-spacing: -0.8px;
      margin-bottom: 1.25rem;
    }
    .left-headline span {
      color: var(--blue-400);
    }
    .left-desc {
      font-size: 14.5px;
      color: var(--blue-200);
      line-height: 1.75;
      max-width: 340px;
    }

    .feature-list {
      display: flex;
      flex-direction: column;
      gap: 14px;
      margin-top: 2.5rem;
    }
    .feature-item {
      display: flex;
      align-items: center;
      gap: 12px;
    }
    .feature-dot {
      width: 32px; height: 32px;
      border-radius: var(--radius-sm);
      background: rgba(55,138,221,0.18);
      display: flex; align-items: center; justify-content: center;
      flex-shrink: 0;
    }
    .feature-dot i { color: var(--blue-400); font-size: 15px; }
    .feature-text {
      font-size: 13.5px;
      color: var(--blue-100);
      font-weight: 400;
    }

    .left-footer {
      position: relative;
      z-index: 1;
      font-size: 12px;
      color: rgba(133,183,235,0.55);
    }

    /* ─── Right Panel ─── */
    .right-panel {
      display: flex;
      align-items: center;
      justify-content: center;
      background: #f4f8fd;
      padding: 2.5rem 2rem;
    }

    .login-box {
      width: 100%;
      max-width: 420px;
    }

    .login-header {
      margin-bottom: 2rem;
    }
    .login-greeting {
      font-size: 26px;
      font-weight: 700;
      color: var(--blue-900);
      letter-spacing: -0.5px;
    }
    .login-sub {
      font-size: 14px;
      color: #6b8fae;
      margin-top: 4px;
      font-weight: 400;
    }

    /* ─── Flash Message ─── */
    .flash {
      display: flex;
      align-items: flex-start;
      gap: 10px;
      border-radius: var(--radius-md);
      padding: 12px 14px;
      font-size: 13.5px;
      font-weight: 500;
      margin-bottom: 1.5rem;
      animation: slideIn 0.22s ease;
    }
    .flash i { font-size: 17px; margin-top: 1px; flex-shrink: 0; }
    .flash.error   { background: var(--red-50);   color: var(--red-600);   border: 1px solid var(--red-200);   }
    .flash.success { background: var(--green-50); color: var(--green-600); border: 1px solid var(--green-200); }

    @keyframes slideIn {
      from { opacity: 0; transform: translateY(-6px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    /* ─── Tab Switcher ─── */
    .tab-bar {
      display: flex;
      background: var(--blue-50);
      border: 1.5px solid var(--blue-100);
      border-radius: var(--radius-md);
      padding: 4px;
      gap: 4px;
      margin-bottom: 1.75rem;
    }
    .tab-btn {
      flex: 1;
      display: flex; align-items: center; justify-content: center;
      gap: 7px;
      padding: 9px 0;
      border: none;
      background: transparent;
      border-radius: 9px;
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 13.5px;
      font-weight: 600;
      color: var(--blue-600);
      cursor: pointer;
      transition: background 0.18s, color 0.18s, box-shadow 0.18s;
      letter-spacing: 0.1px;
    }
    .tab-btn i { font-size: 16px; }
    .tab-btn.active {
      background: var(--blue-600);
      color: #fff;
      box-shadow: 0 3px 10px rgba(24,95,165,0.22);
    }
    .tab-btn:not(.active):hover {
      background: var(--blue-100);
    }

    /* ─── Form Fields ─── */
    .field-group {
      margin-bottom: 1.15rem;
    }
    .field-label {
      display: block;
      font-size: 12.5px;
      font-weight: 600;
      color: var(--blue-800);
      margin-bottom: 6px;
      letter-spacing: 0.1px;
    }
    .field-wrap {
      position: relative;
    }
    .field-icon {
      position: absolute;
      left: 13px;
      top: 50%;
      transform: translateY(-50%);
      font-size: 17px;
      color: var(--blue-400);
      pointer-events: none;
    }
    .field-input {
      width: 100%;
      padding: 11px 14px 11px 42px;
      border: 1.5px solid var(--blue-100);
      border-radius: var(--radius-sm);
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 14px;
      color: var(--blue-900);
      background: #fff;
      outline: none;
      transition: border 0.16s, box-shadow 0.16s;
    }
    .field-input:focus {
      border-color: var(--blue-600);
      box-shadow: 0 0 0 3.5px rgba(24,95,165,0.11);
    }
    .field-input::placeholder {
      color: var(--blue-200);
      font-weight: 400;
    }
    .field-input.has-eye {
      padding-right: 42px;
    }
    .field-input.is-invalid {
      border-color: var(--red-600);
      box-shadow: 0 0 0 3px rgba(163,45,45,0.12);
    }
    .eye-btn {
      position: absolute;
      right: 13px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      cursor: pointer;
      padding: 0;
      color: var(--blue-200);
      font-size: 17px;
      line-height: 1;
      transition: color 0.15s;
    }
    .eye-btn:hover { color: var(--blue-600); }

    /* ─── Panel visibility ─── */
    .panel { display: none; }
    .panel.active { display: block; }

    /* ─── Submit Button ─── */
    .submit-btn {
      width: 100%;
      padding: 13px;
      background: var(--blue-600);
      color: #fff;
      border: none;
      border-radius: var(--radius-sm);
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 15px;
      font-weight: 700;
      cursor: pointer;
      letter-spacing: 0.1px;
      margin-top: 0.5rem;
      display: flex; align-items: center; justify-content: center; gap: 9px;
      transition: background 0.16s, transform 0.12s, box-shadow 0.16s;
    }
    .submit-btn:hover:not(:disabled) {
      background: var(--blue-800);
      box-shadow: 0 4px 16px rgba(24,95,165,0.28);
    }
    .submit-btn:active:not(:disabled) { transform: scale(0.985); }
    .submit-btn:disabled { opacity: 0.55; cursor: not-allowed; }
    .submit-btn i { font-size: 18px; }
    .submit-btn .spin {
      display: none;
      animation: spinAnim 0.65s linear infinite;
    }
    @keyframes spinAnim { to { transform: rotate(360deg); } }

    /* ─── Footer note ─── */
    .form-note {
      text-align: center;
      margin-top: 1.75rem;
      font-size: 12.5px;
      color: #8aacca;
    }
    .form-note a {
      color: var(--blue-600);
      text-decoration: none;
      font-weight: 600;
    }
    .form-note a:hover { text-decoration: underline; }

    /* ─── Divider ─── */
    .divider {
      display: flex; align-items: center; gap: 12px;
      margin: 1.5rem 0;
    }
    .divider-line { flex: 1; height: 1px; background: var(--blue-100); }
    .divider-text { font-size: 12px; color: var(--blue-200); font-weight: 500; }

    /* ─── Hint ─── */
    .field-hint {
      font-size: 11.5px;
      margin-top: 5px;
      min-height: 14px;
      display: flex; align-items: center; gap: 4px;
    }
    .field-hint.ok  { color: var(--green-600); }
    .field-hint.err { color: var(--red-600); }

    /* ─── Shake animation ─── */
    @keyframes shake {
      0%,100%{transform:translateX(0)}
      20%{transform:translateX(-4px)}
      40%{transform:translateX(4px)}
      60%{transform:translateX(-2px)}
      80%{transform:translateX(2px)}
    }
    .shake { animation: shake 0.28s ease; }

    /* ─── Responsive ─── */
    @media (max-width: 768px) {
      .page { grid-template-columns: 1fr; }
      .left-panel { display: none; }
      .right-panel { padding: 2rem 1.25rem; min-height: 100vh; }
    }
  </style>
</head>

<body>
<main class="page">

  <!-- ═══ LEFT PANEL ═══ -->
  <aside class="left-panel">
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
      <h1 class="left-headline">
        Selamat datang<br>kembali, <span>Anggota</span>
      </h1>
      <p class="left-desc">
        Akses informasi keanggotaan, kelola profil, dan pantau aktivitas Anda kapan saja dan di mana saja.
      </p>

      <div class="feature-list">
        <div class="feature-item">
          <div class="feature-dot"><i class="ti ti-users" aria-hidden="true"></i></div>
          <span class="feature-text">Manajemen data anggota terpusat</span>
        </div>
        <div class="feature-item">
          <div class="feature-dot"><i class="ti ti-calendar-event" aria-hidden="true"></i></div>
          <span class="feature-text">Absensi &amp; jadwal kegiatan real-time</span>
        </div>
        <div class="feature-item">
          <div class="feature-dot"><i class="ti ti-chart-bar" aria-hidden="true"></i></div>
          <span class="feature-text">Laporan &amp; statistik otomatis</span>
        </div>
        <div class="feature-item">
          <div class="feature-dot"><i class="ti ti-lock" aria-hidden="true"></i></div>
          <span class="feature-text">Keamanan data terenkripsi end-to-end</span>
        </div>
      </div>
    </div>

    <p class="left-footer">
      &copy; <?= date('Y') ?> <?= htmlspecialchars($settings['org_name']['value'] ?? APP_NAME) ?>. Hak cipta dilindungi.
    </p>
  </aside>

  <!-- ═══ RIGHT PANEL ═══ -->
  <section class="right-panel">
    <div class="login-box">

      <div class="login-header">
        <h2 class="login-greeting">Masuk ke akun</h2>
        <p class="login-sub">Pilih tipe akun lalu masukkan kredensial Anda.</p>
      </div>

      <!-- PHP Flash Message (dari dokumen 1) -->
      <?php if (!empty($flash)): ?>
      <div class="flash <?= $flash['type'] === 'error' ? 'error' : 'success' ?>"
           role="alert" data-auto-dismiss="6000">
        <?php if ($flash['type'] === 'error'): ?>
          <i class="ti ti-alert-circle" aria-hidden="true"></i>
        <?php else: ?>
          <i class="ti ti-circle-check" aria-hidden="true"></i>
        <?php endif; ?>
        <span><?= htmlspecialchars($flash['msg']) ?></span>
      </div>
      <?php endif; ?>

      <!-- JS-injected alert -->
      <div class="flash error" id="js-alert" role="alert" aria-live="polite" style="display:none">
        <i class="ti ti-alert-circle" aria-hidden="true"></i>
        <span id="js-alert-msg"></span>
      </div>

      <!-- Tab Switcher -->
      <div class="tab-bar" role="tablist" aria-label="Tipe login">
        <button class="tab-btn active" id="tab-member" role="tab"
                aria-selected="true" aria-controls="panel-member" type="button">
          <i class="ti ti-id-badge" aria-hidden="true"></i> Anggota
        </button>
        <button class="tab-btn" id="tab-admin" role="tab"
                aria-selected="false" aria-controls="panel-admin" type="button">
          <i class="ti ti-user-shield" aria-hidden="true"></i> Administrator
        </button>
      </div>

      <!-- ── Form Anggota ── -->
      <form method="POST" action="<?= BASE_URL ?>/login"
            id="form-member" novalidate autocomplete="on"
            style="display:block">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
        <input type="hidden" name="login_type" value="member">

        <div id="panel-member" class="panel active" role="tabpanel" aria-labelledby="tab-member">
          <div class="field-group">
            <label class="field-label" for="nia">Nomor Induk Anggota (NIA)</label>
            <div class="field-wrap">
              <i class="ti ti-id field-icon" aria-hidden="true"></i>
              <input type="text" id="nia" name="nia" class="field-input"
                     placeholder="Contoh: 2024001"
                     autocomplete="username"
                     inputmode="numeric"
                     maxlength="12"
                     value="<?= htmlspecialchars($_POST['nia'] ?? '') ?>"
                     required />
            </div>
            <div class="field-hint" id="nia-hint" aria-live="polite"></div>
          </div>
        </div>

        <!-- Password (member) -->
        <div class="field-group">
          <label class="field-label" for="password-m">Kata Sandi</label>
          <div class="field-wrap">
            <i class="ti ti-lock field-icon" aria-hidden="true"></i>
            <input type="password" id="password-m" name="password" class="field-input has-eye"
                   placeholder="Masukkan kata sandi"
                   autocomplete="current-password"
                   required />
            <button type="button" class="eye-btn" data-for="password-m" aria-label="Tampilkan atau sembunyikan kata sandi">
              <i class="ti ti-eye" aria-hidden="true"></i>
            </button>
          </div>
        </div>

        <button type="submit" class="submit-btn" id="submit-member">
          <i class="ti ti-login spin" id="spin-member" aria-hidden="true"></i>
          <i class="ti ti-login btn-ico" aria-hidden="true"></i>
          <span class="btn-tx">Masuk sebagai Anggota</span>
        </button>
      </form>

      <!-- ── Form Admin ── -->
      <form method="POST" action="<?= BASE_URL ?>/login"
            id="form-admin" novalidate autocomplete="on"
            style="display:none">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
        <input type="hidden" name="login_type" value="admin">

        <div id="panel-admin" class="panel active" role="tabpanel" aria-labelledby="tab-admin">
          <div class="field-group">
            <label class="field-label" for="email">Alamat Email</label>
            <div class="field-wrap">
              <i class="ti ti-mail field-icon" aria-hidden="true"></i>
              <input type="email" id="email" name="email" class="field-input"
                     placeholder="admin@organisasi.id"
                     autocomplete="email"
                     required />
            </div>
            <div class="field-hint" id="email-hint" aria-live="polite"></div>
          </div>

          <!-- Password (admin) -->
          <div class="field-group">
            <label class="field-label" for="password-a">Kata Sandi Administrator</label>
            <div class="field-wrap">
              <i class="ti ti-lock field-icon" aria-hidden="true"></i>
              <input type="password" id="password-a" name="password" class="field-input has-eye"
                     placeholder="Masukkan kata sandi"
                     autocomplete="current-password"
                     required />
              <button type="button" class="eye-btn" data-for="password-a" aria-label="Tampilkan atau sembunyikan kata sandi">
                <i class="ti ti-eye" aria-hidden="true"></i>
              </button>
            </div>
          </div>

          <div class="flash" style="background:rgba(24,95,165,0.07);border:1px solid var(--blue-100);color:var(--blue-800);margin-bottom:1rem;font-size:12.5px;font-weight:400">
            <i class="ti ti-shield-lock" style="font-size:15px;margin-top:1px;color:var(--blue-600)" aria-hidden="true"></i>
            <span>Area ini hanya untuk staf administrator yang berwenang. Akses tidak sah akan dicatat dan dilaporkan.</span>
          </div>
        </div>

        <button type="submit" class="submit-btn" id="submit-admin">
          <i class="ti ti-login spin" id="spin-admin" aria-hidden="true"></i>
          <i class="ti ti-login btn-ico" aria-hidden="true"></i>
          <span class="btn-tx">Masuk sebagai Administrator</span>
        </button>
      </form>

      <div class="divider">
        <span class="divider-line"></span>
        <span class="divider-text">atau</span>
        <span class="divider-line"></span>
      </div>

      <p class="form-note" id="note-member">
        Belum punya akun?
        <a href="<?= BASE_URL ?>/pab">Daftar sekarang</a>
        &nbsp;·&nbsp;
        <a href="<?= BASE_URL ?>/">← Beranda</a>
      </p>
      <p class="form-note" id="note-admin" style="display:none">
        Butuh akses admin?
        <a href="mailto:it@organisasi.id">Hubungi tim IT</a>
        &nbsp;·&nbsp;
        <a href="<?= BASE_URL ?>/">← Beranda</a>
      </p>

    </div>
  </section>
</main>

<script>
(function () {
'use strict';

var REX_EMAIL = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;
var cur = 'member';

/* ── Tab switching ── */
var tabMember  = document.getElementById('tab-member');
var tabAdmin   = document.getElementById('tab-admin');
var formMember = document.getElementById('form-member');
var formAdmin  = document.getElementById('form-admin');
var noteMember = document.getElementById('note-member');
var noteAdmin  = document.getElementById('note-admin');
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

  noteMember.style.display = isMember ? '' : 'none';
  noteAdmin.style.display  = isMember ? 'none' : '';

  hideAlert();

  // Clear opposite form fields
  if (isMember) {
    document.getElementById('email').value      = '';
    document.getElementById('password-a').value = '';
  } else {
    document.getElementById('nia').value        = '';
    document.getElementById('password-m').value = '';
  }

  try { sessionStorage.setItem('login_tab', type); } catch(e) {}
}

tabMember.addEventListener('click', function() { switchTab('member'); });
tabAdmin.addEventListener('click',  function() { switchTab('admin');  });

// Arrow key navigation on tabs
[tabMember, tabAdmin].forEach(function(btn, i) {
  btn.addEventListener('keydown', function(e) {
    var tabs = [tabMember, tabAdmin];
    var nxt;
    if (e.key === 'ArrowRight' || e.key === 'ArrowDown') nxt = tabs[(i+1) % 2];
    if (e.key === 'ArrowLeft'  || e.key === 'ArrowUp')   nxt = tabs[(i+1) % 2];
    if (nxt) { nxt.click(); nxt.focus(); e.preventDefault(); }
  });
});

// Restore saved tab
(function() {
  var saved = 'member';
  try { saved = sessionStorage.getItem('login_tab') || 'member'; } catch(e) {}
  if (saved === 'admin') switchTab('admin');
})();

/* ── Alert helpers ── */
function showAlert(msg) {
  jsAlertMsg.textContent = msg;
  jsAlert.style.display = 'flex';
}
function hideAlert() {
  jsAlert.style.display = 'none';
}

/* ── Auto-dismiss PHP flash ── */
document.querySelectorAll('.flash[data-auto-dismiss]').forEach(function(el) {
  var delay = parseInt(el.dataset.autoDismiss, 10) || 6000;
  setTimeout(function() { fadeOut(el); }, delay);
});
function fadeOut(el) {
  if (el._dismissing) return;
  el._dismissing = true;
  el.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
  el.style.opacity = '0';
  el.style.transform = 'translateY(-4px)';
  setTimeout(function() { if (el.parentNode) el.parentNode.removeChild(el); }, 350);
}

/* ── Eye toggle ── */
document.querySelectorAll('.eye-btn[data-for]').forEach(function(btn) {
  btn.addEventListener('click', function() {
    var inp = document.getElementById(btn.dataset.for);
    if (!inp) return;
    var show = inp.type === 'password';
    inp.type = show ? 'text' : 'password';
    var ico = btn.querySelector('i');
    ico.className = show ? 'ti ti-eye-off' : 'ti ti-eye';
    btn.setAttribute('aria-label', show ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi');
    inp.focus();
  });
});

/* ── NIA validation ── */
var niaEl   = document.getElementById('nia');
var niaHint = document.getElementById('nia-hint');
if (niaEl) {
  niaEl.addEventListener('input', function() {
    this.value = this.value.replace(/\D/g, '');
    var v = this.value;
    if (!v) { niaHint.textContent = ''; niaHint.className = 'field-hint'; this.classList.remove('is-invalid'); return; }
    if (v.length >= 5 && v.length <= 12) {
      niaHint.textContent = '✓ Format NIA valid';
      niaHint.className = 'field-hint ok';
      this.classList.remove('is-invalid');
    } else {
      niaHint.textContent = 'Masukkan 5–12 digit angka';
      niaHint.className = 'field-hint err';
    }
  });
}

/* ── Email validation ── */
var emailEl   = document.getElementById('email');
var emailHint = document.getElementById('email-hint');
if (emailEl) {
  emailEl.addEventListener('input', function() {
    var v = this.value;
    if (!v) { emailHint.textContent = ''; emailHint.className = 'field-hint'; this.classList.remove('is-invalid'); return; }
    var ok = REX_EMAIL.test(v);
    emailHint.textContent = ok ? '✓ Format email valid' : 'Format email tidak valid';
    emailHint.className = 'field-hint ' + (ok ? 'ok' : 'err');
    this.classList.toggle('is-invalid', !ok);
  });
}

/* ── Shake helper ── */
function shake(el) {
  if (!el) return;
  el.classList.remove('shake');
  void el.offsetWidth;
  el.classList.add('shake');
  el.addEventListener('animationend', function() { el.classList.remove('shake'); }, { once: true });
}

/* ── Submit handlers ── */
function handleSubmit(frm, type) {
  frm.addEventListener('submit', function(e) {
    hideAlert();
    var valid = true;
    var first = null;

    frm.querySelectorAll('input[required]').forEach(function(f) {
      if (!f.value.trim()) {
        valid = false;
        f.classList.add('is-invalid');
        setTimeout(function() { f.classList.remove('is-invalid'); }, 2800);
        if (!first) first = f;
      }
    });

    if (!valid) {
      e.preventDefault();
      showAlert('Harap isi semua kolom yang diperlukan.');
      shake(frm.querySelector('.submit-btn'));
      if (first) first.focus();
      return;
    }

    if (type === 'admin') {
      var em = document.getElementById('email');
      if (em && !REX_EMAIL.test(em.value)) {
        e.preventDefault();
        showAlert('Masukkan alamat email yang valid.');
        em.classList.add('is-invalid');
        setTimeout(function() { em.classList.remove('is-invalid'); }, 2800);
        shake(em.closest('.field-wrap'));
        em.focus();
        return;
      }
    }

    // Loading state
    var btn  = frm.querySelector('.submit-btn');
    var spin = frm.querySelector('.spin');
    var ico  = frm.querySelector('.btn-ico');
    var tx   = frm.querySelector('.btn-tx');
    if (btn) btn.disabled = true;
    if (spin) spin.style.display = 'inline-block';
    if (ico)  ico.style.display  = 'none';
    if (tx)   tx.textContent = 'Memproses…';

    try { sessionStorage.setItem('login_tab', type); } catch(err) {}
  });
}

handleSubmit(formMember, 'member');
handleSubmit(formAdmin,  'admin');

}());
</script>
</body>
</html>