<!DOCTYPE html>
<html lang="id" dir="ltr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="noindex, nofollow">
  <title>Admin Panel &mdash; <?= htmlspecialchars(APP_NAME) ?></title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/custom.css">

  <style>
/* ==========================================================================
   RESET
   ========================================================================== */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

/* ==========================================================================
   TOKENS — Design System: Community Programmer SMKN 2 Pinrang
   ========================================================================== */
:root {
  --sw: 264px;
  --th: 64px;

  /* Base surface */
  --c-page:   #eef2f6;
  --c-white:  #ffffff;
  --c-ink:    #0f172a;
  --c-muted:  #64748b;
  --c-muted2: #94a3b8;
  --c-border: #e6ebf1;

  /* Aksen utama */
  --c-primary:    #0e7490;
  --c-primary-dk: #0b5a70;
  --c-primary-lt: #06b6d4;
  --c-primary-08: rgba(14,116,144,.08);
  --c-primary-12: rgba(14,116,144,.12);
  --c-primary-25: rgba(14,116,144,.25);

  /* Status */
  --c-amber-bg: #fef6e2; --c-amber-border: #fbe3a8; --c-amber-text: #8a5a06; --c-amber-icon: #d9910c;
  --c-red-bg:   #fef2f2; --c-red-border:   #fecaca; --c-red-text:   #b91c1c;
  --c-green-bg: #f0fdf4; --c-green-border: #bbf7d0; --c-green-text: #15803d;

  /* Radius */
  --radius-sm: 9px;
  --radius-md: 13px;
  --radius-lg: 22px;

  /* Font */
  --ff: 'Plus Jakarta Sans', sans-serif;

  /* Motion */
  --ease: cubic-bezier(.22,1,.36,1);
  --tf: 150ms; --tm: 200ms; --ts: 260ms;
}

/* ==========================================================================
   BASE
   ========================================================================== */
html, body { height: 100%; }
body {
  font-family: var(--ff);
  background: var(--c-page);
  color: var(--c-ink);
  font-size: 14px;
  line-height: 1.6;
  -webkit-font-smoothing: antialiased;
}
a { color: inherit; text-decoration: none; }
button { font-family: inherit; cursor: pointer; }

::-webkit-scrollbar { width: 6px; height: 6px; }
::-webkit-scrollbar-track { background: transparent; }
::-webkit-scrollbar-thumb { background: var(--c-border); border-radius: 99px; }
::-webkit-scrollbar-thumb:hover { background: var(--c-muted2); }
:focus-visible { outline: 2px solid var(--c-primary-lt); outline-offset: 2px; border-radius: var(--radius-sm); }

/* ==========================================================================
   SHELL
   ========================================================================== */
.shell {
  display: flex;
  height: 100vh;
  overflow: hidden;
}

/* ==========================================================================
   BACKDROP (mobile)
   ========================================================================== */
.bd {
  display: none;
  position: fixed;
  inset: 0;
  z-index: 35;
  background: rgba(15,23,42,.45);
  backdrop-filter: blur(4px);
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
  background: var(--c-white);
  border-right: 1px solid var(--c-border);
  transform: translateX(-100%);
  transition: transform var(--ts) var(--ease), box-shadow var(--ts) var(--ease);
  overflow: hidden;
}
@media (min-width: 768px) {
  .sb { transform: translateX(0) !important; box-shadow: none !important; }
}
.sb.on { transform: translateX(0); box-shadow: 30px 0 60px rgba(15,23,42,.18); }

/* Brand */
.sb-brand {
  display: flex;
  align-items: center;
  gap: 12px;
  height: var(--th);
  padding: 0 20px;
  border-bottom: 1px solid var(--c-border);
  flex-shrink: 0;
}
.sb-logo-wrap {
  width: 36px; height: 36px;
  border-radius: var(--radius-sm);
  background: var(--c-primary-08);
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
  overflow: hidden;
}
.sb-logo { width: 100%; height: 100%; object-fit: contain; }
.sb-logo-fallback { font-size: 17px; color: var(--c-primary); }
.sb-name {
  flex: 1;
  font-size: 14.5px;
  font-weight: 800;
  letter-spacing: -.02em;
  color: var(--c-primary-dk);
  white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.sb-badge {
  font-size: 10px;
  font-weight: 700;
  letter-spacing: .06em;
  text-transform: uppercase;
  color: var(--c-primary);
  background: var(--c-primary-08);
  border: 1px solid var(--c-primary-25);
  border-radius: var(--radius-sm);
  padding: 3px 8px;
  flex-shrink: 0;
}

/* Nav scroll */
.sb-nav {
  flex: 1;
  overflow-y: auto;
  padding: 16px 14px;
  display: flex;
  flex-direction: column;
  gap: 0;
}

/* Section */
.nav-sec { margin-bottom: 4px; }
.nav-sec + .nav-sec {
  margin-top: 10px;
  padding-top: 10px;
  border-top: 1px solid var(--c-border);
}
.nav-sec-label {
  font-size: 10.5px;
  font-weight: 700;
  letter-spacing: .1em;
  text-transform: uppercase;
  color: var(--c-muted2);
  padding: 6px 12px 8px;
  display: block;
}

/* Nav item */
.ni {
  position: relative;
  display: flex;
  align-items: center;
  gap: 11px;
  padding: 10px 12px;
  border-radius: var(--radius-sm);
  font-size: 13.5px;
  font-weight: 600;
  color: var(--c-muted);
  transition: color var(--tf) var(--ease), background var(--tf) var(--ease);
  user-select: none;
  margin-bottom: 2px;
}
.ni:hover { color: var(--c-ink); background: #f4f7fa; }
.ni.act {
  color: #fff;
  background: var(--c-primary);
  box-shadow: 0 6px 16px rgba(14,116,144,.25);
}
.ni-icon {
  font-size: 17px;
  width: 17px; height: 17px;
  flex-shrink: 0;
  color: var(--c-muted2);
  display: flex; align-items: center; justify-content: center;
  transition: color var(--tf) var(--ease);
}
.ni:hover .ni-icon { color: var(--c-primary); }
.ni.act .ni-icon { color: #fff; }
.ni-label { flex: 1; line-height: 1.2; }
.ni-badge {
  font-size: 9px;
  font-weight: 700;
  letter-spacing: .05em;
  text-transform: uppercase;
  color: var(--c-amber-icon);
  background: var(--c-amber-bg);
  border: 1px solid var(--c-amber-border);
  border-radius: var(--radius-sm);
  padding: 2px 6px;
  flex-shrink: 0;
}
.ni-new {
  font-size: 9px;
  font-weight: 700;
  color: var(--c-green-text);
  background: var(--c-green-bg);
  border: 1px solid var(--c-green-border);
  border-radius: var(--radius-sm);
  padding: 2px 6px;
  flex-shrink: 0;
}
.ni-ext-icon { font-size: 12px; color: var(--c-muted2); flex-shrink: 0; }
.ni.act .ni-ext-icon { color: rgba(255,255,255,.8); }

/* Footer */
.sb-footer {
  padding: 14px;
  border-top: 1px solid var(--c-border);
  flex-shrink: 0;
}
.sb-ver {
  font-size: 10px;
  color: var(--c-muted2);
  text-align: center;
  margin-bottom: 10px;
  letter-spacing: .03em;
  font-weight: 500;
}
.ucard {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 10px 12px;
  border-radius: var(--radius-md);
  background: #f8fafc;
  border: 1px solid var(--c-border);
  transition: border-color var(--tf) var(--ease), background var(--tf) var(--ease);
}
.ucard:hover { border-color: var(--c-primary-25); background: #f4f8fa; }
.ucard-av {
  width: 34px; height: 34px;
  border-radius: 50%;
  background: var(--c-primary);
  display: flex; align-items: center; justify-content: center;
  font-size: 12px;
  font-weight: 800;
  color: #fff;
  flex-shrink: 0;
  letter-spacing: -.02em;
}
.ucard-info { flex: 1; min-width: 0; }
.ucard-name {
  font-size: 12.5px;
  font-weight: 700;
  color: var(--c-ink);
  white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
  letter-spacing: -.01em;
  line-height: 1.3;
}
.ucard-role {
  font-size: 10.5px;
  color: var(--c-muted);
  font-weight: 500;
  margin-top: 1px;
}
.btn-logout {
  display: flex; align-items: center; justify-content: center;
  width: 30px; height: 30px;
  border-radius: var(--radius-sm);
  background: transparent;
  border: 1px solid transparent;
  color: var(--c-muted2);
  font-size: 15px;
  transition: background var(--tf) var(--ease), border-color var(--tf) var(--ease), color var(--tf) var(--ease);
  flex-shrink: 0;
}
.btn-logout:hover { background: var(--c-red-bg); border-color: var(--c-red-border); color: var(--c-red-text); }

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
}
@media (min-width: 768px) { .main { margin-left: var(--sw); } }

/* ==========================================================================
   TOPBAR
   ========================================================================== */
.tb {
  height: var(--th);
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 0 28px;
  background: var(--c-white);
  border-bottom: 1px solid var(--c-border);
  flex-shrink: 0;
  position: sticky; top: 0; z-index: 20;
}
.btn-menu {
  display: flex; align-items: center; justify-content: center;
  width: 36px; height: 36px;
  border-radius: var(--radius-sm);
  background: transparent;
  border: 1px solid var(--c-border);
  color: var(--c-muted);
  font-size: 16px;
  transition: background var(--tf), border-color var(--tf), color var(--tf);
  flex-shrink: 0;
}
.btn-menu:hover { background: #f4f7fa; border-color: var(--c-primary-25); color: var(--c-primary); }
@media (min-width: 768px) { .btn-menu { display: none; } }

/* Breadcrumb */
.bc {
  display: flex;
  align-items: center;
  font-size: 13px;
}
.bc-root { color: var(--c-muted2); font-weight: 600; }
.bc-sep  { color: var(--c-muted2); font-size: 15px; margin: 0 6px; display: flex; }
.bc-page { color: var(--c-primary-dk); font-weight: 800; font-size: 14px; }
@media (max-width: 767px) { .bc { display: none; } }

/* Search */
.tb-search {
  flex: 1;
  max-width: 300px;
  margin-left: auto;
  position: relative;
}
.tb-search input {
  width: 100%;
  height: 38px;
  background: #fbfcfe;
  border: 1.5px solid var(--c-border);
  border-radius: var(--radius-sm);
  padding: 0 44px 0 38px;
  font-family: var(--ff);
  font-size: 13px;
  color: var(--c-ink);
  outline: none;
  transition: border var(--tf), background var(--tf), box-shadow var(--tf);
}
.tb-search input::placeholder { color: var(--c-muted2); }
.tb-search input:focus { border-color: var(--c-primary-lt); background: #fff; box-shadow: 0 0 0 3px rgba(6,182,212,.12); }
.tb-si {
  position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
  font-size: 15px; color: var(--c-muted2); pointer-events: none;
}
.tb-kbd {
  position: absolute; right: 10px; top: 50%; transform: translateY(-50%);
  font-size: 10px; font-weight: 600; color: var(--c-muted2);
  background: var(--c-page); border: 1px solid var(--c-border);
  border-radius: 5px; padding: 2px 6px; pointer-events: none;
}

/* Actions */
.tb-actions {
  display: flex; align-items: center; gap: 8px; flex-shrink: 0;
}
@media (max-width: 767px) { .tb-search { display: none; } .tb-actions { margin-left: auto; } }

.btn-icon {
  position: relative;
  display: flex; align-items: center; justify-content: center;
  width: 38px; height: 38px;
  border-radius: var(--radius-sm);
  background: transparent;
  border: 1px solid var(--c-border);
  color: var(--c-muted);
  font-size: 16px;
  transition: background var(--tf), border-color var(--tf), color var(--tf);
}
.btn-icon:hover { background: #f4f7fa; border-color: var(--c-primary-25); color: var(--c-primary); }
.ndot {
  position: absolute; top: 7px; right: 7px;
  width: 6px; height: 6px;
  border-radius: 50%; background: var(--c-red-text); border: 1.5px solid var(--c-white);
}
.chip-ok {
  display: flex; align-items: center; gap: 7px;
  padding: 6px 13px;
  border-radius: 99px;
  background: var(--c-green-bg); border: 1px solid var(--c-green-border);
  font-size: 11.5px; font-weight: 700; color: var(--c-green-text);
  user-select: none;
}
.chip-dot {
  width: 6px; height: 6px; border-radius: 50%; background: var(--c-green-text); flex-shrink: 0;
  animation: pdot 2.4s ease infinite;
}
@keyframes pdot {
  0%,100% { opacity:1; box-shadow: 0 0 0 0 rgba(21,128,61,.35); }
  50%      { opacity:.7; box-shadow: 0 0 0 4px rgba(21,128,61,0); }
}
@media (max-width: 560px) { .chip-ok span:last-child { display: none; } }

.tb-av {
  width: 38px; height: 38px;
  border-radius: 50%;
  background: var(--c-primary);
  display: flex; align-items: center; justify-content: center;
  font-size: 12.5px; font-weight: 800; color: #fff;
  cursor: pointer; flex-shrink: 0;
  transition: box-shadow var(--tf), transform var(--tf);
  letter-spacing: -.02em;
}
.tb-av:hover { box-shadow: 0 0 0 4px var(--c-primary-12); transform: translateY(-1px); }

/* ==========================================================================
   FLASH
   ========================================================================== */
.flash-wrap { padding: 20px 28px 0; }
.alert {
  display: flex; align-items: flex-start; gap: 11px;
  padding: 13px 15px;
  border-radius: var(--radius-md);
  font-size: 13px; font-weight: 500;
  border: 1px solid; line-height: 1.5;
}
.alert i { font-size: 17px; flex-shrink: 0; margin-top: 1px; }
.alert-msg { flex: 1; }
.alert-x {
  background: none; border: none; font-size: 18px; line-height: 1;
  color: inherit; opacity: .45; padding: 0; flex-shrink: 0;
  transition: opacity var(--tf);
}
.alert-x:hover { opacity: 1; }
.alert-s { background: var(--c-green-bg); border-color: var(--c-green-border); color: var(--c-green-text); }
.alert-e { background: var(--c-red-bg);   border-color: var(--c-red-border);   color: var(--c-red-text); }
.alert-w { background: var(--c-amber-bg); border-color: var(--c-amber-border); color: var(--c-amber-text); }
.alert-i { background: var(--c-primary-08); border-color: var(--c-primary-25); color: var(--c-primary-dk); }

/* ==========================================================================
   PAGE
   ========================================================================== */
.pg {
  flex: 1; overflow-y: auto;
  padding: 32px 28px;
}
@media (max-width: 480px) {
  .tb        { padding: 0 16px; }
  .flash-wrap{ padding: 14px 16px 0; }
  .pg        { padding: 18px 16px; }
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
          onerror="this.style.display='none';this.nextElementSibling.style.display='flex';"
        >
        <i class="ti ti-shield-check sb-logo-fallback" style="display:none;" aria-hidden="true"></i>
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
              'icon'  => 'ti-layout-dashboard',
            ],
            [
              'href'  => '/admin/anggota',
              'label' => 'Manajemen Anggota',
              'icon'  => 'ti-users',
            ],
            [
              'href'  => '/admin/pab',
              'label' => 'Verifikasi PAB',
              'icon'  => 'ti-clipboard-check',
            ],
            [
              'href'  => '/admin/absensi',
              'label' => 'Absensi',
              'icon'  => 'ti-calendar-event',
            ],
          ],

          'Konten' => [
            [
              'href'  => '/admin/berita',
              'label' => 'Berita & Artikel',
              'icon'  => 'ti-news',
              'new'   => false,
            ],
            [
              'href'  => '/admin/galeri',
              'label' => 'Galeri Foto',
              'icon'  => 'ti-photo',
            ],
          ],

          'Tools' => [
            [
              'href'     => BASE_URL . '/generate_sso.php',
              'label'    => 'Surat Digital',
              'icon'     => 'ti-file-certificate',
              'badge'    => 'SSO',
              'external' => true,
            ],
          ],

          'Sistem' => [
            [
              'href'  => '/admin/settings',
              'label' => 'Pengaturan & CMS',
              'icon'  => 'ti-settings',
            ],
            [
              'href'  => '/admin/profil',
              'label' => 'Edit Profil Admin',
              'icon'  => 'ti-user-edit',
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
            <span class="ni-icon" aria-hidden="true"><i class="ti <?= htmlspecialchars($item['icon']) ?>"></i></span>
            <span class="ni-label"><?= htmlspecialchars($item['label']) ?></span>
            <?php if (!empty($item['badge'])): ?>
              <span class="ni-badge"><?= htmlspecialchars($item['badge']) ?></span>
            <?php endif; ?>
            <?php if (!empty($item['new'])): ?>
              <span class="ni-new">Baru</span>
            <?php endif; ?>
            <?php if ($ext): ?>
              <i class="ti ti-external-link ni-ext-icon" aria-hidden="true"></i>
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
          <i class="ti ti-logout" aria-hidden="true"></i>
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
        <i class="ti ti-menu-2" aria-hidden="true"></i>
      </button>

      <nav class="bc" aria-label="Breadcrumb">
        <span class="bc-root"><?= htmlspecialchars(APP_NAME) ?></span>
        <span class="bc-sep" aria-hidden="true"><i class="ti ti-chevron-right"></i></span>
        <span class="bc-page">Panel Administrator</span>
      </nav>

      <div class="tb-search" role="search">
        <i class="ti ti-search tb-si" aria-hidden="true"></i>
        <input type="text" placeholder="Cari menu…" aria-label="Cari menu" id="js-search">
        <span class="tb-kbd" aria-hidden="true">⌘K</span>
      </div>

      <div class="tb-actions" role="toolbar" aria-label="Aksi topbar">

        <button class="btn-icon" aria-label="Notifikasi" title="Notifikasi">
          <i class="ti ti-bell" aria-hidden="true"></i>
          <span class="ndot" aria-hidden="true"></span>
        </button>

        <a href="<?= BASE_URL ?>/" class="btn-icon" aria-label="Lihat situs" title="Lihat situs publik" target="_blank">
          <i class="ti ti-world" aria-hidden="true"></i>
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
          'success' => 'ti-circle-check',
          'error'   => 'ti-alert-circle',
          'danger'  => 'ti-alert-circle',
          'warning' => 'ti-alert-triangle',
          'info'    => 'ti-info-circle',
        ];
        $fcls = ['success'=>'alert-s','error'=>'alert-e','danger'=>'alert-e','warning'=>'alert-w','info'=>'alert-i'];
      ?>
      <div class="alert <?= $fcls[$ft] ?? 'alert-i' ?>" id="js-flash">
        <i class="ti <?= $ficons[$ft] ?? $ficons['info'] ?>" aria-hidden="true"></i>
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