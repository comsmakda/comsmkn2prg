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
   FLUID ROOT
   FIX: sebelumnya pakai clamp(14px, 0.5vw + 10px, 20px) yang terlalu agresif
   — di lebar laptop umum (1280–1440px) sudah nyaris mentok 20px sehingga
   seluruh UI (sidebar, ikon, teks) tampak raksasa. Sekarang pakai
   breakpoint tetap yang lebih terkontrol & balance di semua ukuran layar.
   ========================================================================== */
html { font-size: 15px; }
@media (min-width: 400px)  { html { font-size: 14.5px; } }
@media (min-width: 768px)  { html { font-size: 15px; } }
@media (min-width: 1200px) { html { font-size: 15.5px; } }
@media (min-width: 1600px) { html { font-size: 16px; } }
@media (min-width: 2200px) { html { font-size: 17px; } }
@media (min-width: 2800px) { html { font-size: 18px; } }

/* ==========================================================================
   TOKENS — Design System: Community Programmer SMKN 2 Pinrang
   ========================================================================== */
:root {
  /* Sidebar & topbar: fixed di rem, tidak lagi pakai vw supaya tidak
     dobel-membesar bersamaan dengan root font-size. */
  --sw: 16rem;
  --th: 4rem;

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

  /* Radius (rem, ikut skala font root) */
  --radius-sm: 0.6rem;
  --radius-md: 0.9rem;
  --radius-lg: 1.4rem;

  /* Font */
  --ff: 'Plus Jakarta Sans', sans-serif;

  /* Motion */
  --ease: cubic-bezier(.22,1,.36,1);
  --tf: 150ms; --tm: 200ms; --ts: 260ms;
}

@media (min-width: 1600px) { :root { --sw: 17rem; } }
@media (max-width: 480px)  { :root { --th: 3.5rem; } }

/* ==========================================================================
   BASE
   ========================================================================== */
html, body {
  height: 100%;
  overflow: hidden; /* cegah body/window ikut scroll — scroll hanya di .pg */
}
body {
  font-family: var(--ff);
  background: var(--c-page);
  color: var(--c-ink);
  font-size: 1rem;
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
   FIX: pakai 100dvh dengan fallback 100vh supaya aman di browser mobile
   yang toolbar-nya dinamis (mencegah munculnya "sisa" ruang yang memicu
   scroll tak terduga).
   ========================================================================== */
.shell {
  display: flex;
  height: 100vh;
  height: 100dvh;
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
  gap: 0.75rem;
  height: var(--th);
  padding: 0 1.25rem;
  border-bottom: 1px solid var(--c-border);
  flex-shrink: 0;
}
.sb-logo-wrap {
  width: 2.35rem; height: 2.35rem;
  border-radius: var(--radius-sm);
  background: var(--c-primary-08);
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
  overflow: hidden;
}
.sb-logo { width: 100%; height: 100%; object-fit: contain; }
.sb-logo-fallback { font-size: 1.1rem; color: var(--c-primary); }
.sb-name {
  flex: 1;
  font-size: 0.98rem;
  font-weight: 800;
  letter-spacing: -.02em;
  color: var(--c-primary-dk);
  white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.sb-badge {
  font-size: 0.66rem;
  font-weight: 700;
  letter-spacing: .06em;
  text-transform: uppercase;
  color: var(--c-primary);
  background: var(--c-primary-08);
  border: 1px solid var(--c-primary-25);
  border-radius: var(--radius-sm);
  padding: 0.2rem 0.5rem;
  flex-shrink: 0;
}

/* Nav scroll */
.sb-nav {
  flex: 1;
  overflow-y: auto;
  padding: 1rem 0.85rem;
  display: flex;
  flex-direction: column;
  gap: 0;
}

/* Section */
.nav-sec { margin-bottom: 0.25rem; }
.nav-sec + .nav-sec {
  margin-top: 0.65rem;
  padding-top: 0.65rem;
  border-top: 1px solid var(--c-border);
}
.nav-sec-label {
  font-size: 0.7rem;
  font-weight: 700;
  letter-spacing: .1em;
  text-transform: uppercase;
  color: var(--c-muted2);
  padding: 0.4rem 0.8rem 0.5rem;
  display: block;
}

/* Nav item */
.ni {
  position: relative;
  display: flex;
  align-items: center;
  gap: 0.7rem;
  padding: 0.6rem 0.8rem;
  border-radius: var(--radius-sm);
  font-size: 0.88rem;
  font-weight: 600;
  color: var(--c-muted);
  transition: color var(--tf) var(--ease), background var(--tf) var(--ease);
  user-select: none;
  margin-bottom: 0.14rem;
}
.ni:hover { color: var(--c-ink); background: #f4f7fa; }
.ni.act {
  color: #fff;
  background: var(--c-primary);
  box-shadow: 0 6px 16px rgba(14,116,144,.25);
}
.ni-icon {
  font-size: 1.1rem;
  width: 1.1rem; height: 1.1rem;
  flex-shrink: 0;
  color: var(--c-muted2);
  display: flex; align-items: center; justify-content: center;
  transition: color var(--tf) var(--ease);
}
.ni:hover .ni-icon { color: var(--c-primary); }
.ni.act .ni-icon { color: #fff; }
.ni-label { flex: 1; line-height: 1.25; }
.ni-badge {
  font-size: 0.6rem;
  font-weight: 700;
  letter-spacing: .05em;
  text-transform: uppercase;
  color: var(--c-amber-icon);
  background: var(--c-amber-bg);
  border: 1px solid var(--c-amber-border);
  border-radius: var(--radius-sm);
  padding: 0.14rem 0.4rem;
  flex-shrink: 0;
}
.ni-new {
  font-size: 0.6rem;
  font-weight: 700;
  color: var(--c-green-text);
  background: var(--c-green-bg);
  border: 1px solid var(--c-green-border);
  border-radius: var(--radius-sm);
  padding: 0.14rem 0.4rem;
  flex-shrink: 0;
}
.ni-ext-icon { font-size: 0.8rem; color: var(--c-muted2); flex-shrink: 0; }
.ni.act .ni-ext-icon { color: rgba(255,255,255,.8); }

/* Footer */
.sb-footer {
  padding: 0.9rem;
  border-top: 1px solid var(--c-border);
  flex-shrink: 0;
}
.sb-ver {
  font-size: 0.66rem;
  color: var(--c-muted2);
  text-align: center;
  margin-bottom: 0.65rem;
  letter-spacing: .03em;
  font-weight: 500;
}
.ucard {
  display: flex;
  align-items: center;
  gap: 0.65rem;
  padding: 0.65rem 0.8rem;
  border-radius: var(--radius-md);
  background: #f8fafc;
  border: 1px solid var(--c-border);
  transition: border-color var(--tf) var(--ease), background var(--tf) var(--ease);
}
.ucard:hover { border-color: var(--c-primary-25); background: #f4f8fa; }
.ucard-av {
  width: 2.2rem; height: 2.2rem;
  border-radius: 50%;
  background: var(--c-primary);
  display: flex; align-items: center; justify-content: center;
  font-size: 0.8rem;
  font-weight: 800;
  color: #fff;
  flex-shrink: 0;
  letter-spacing: -.02em;
}
.ucard-info { flex: 1; min-width: 0; }
.ucard-name {
  font-size: 0.83rem;
  font-weight: 700;
  color: var(--c-ink);
  white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
  letter-spacing: -.01em;
  line-height: 1.3;
}
.ucard-role {
  font-size: 0.7rem;
  color: var(--c-muted);
  font-weight: 500;
  margin-top: 0.07rem;
}
.btn-logout {
  display: flex; align-items: center; justify-content: center;
  width: 1.95rem; height: 1.95rem;
  border-radius: var(--radius-sm);
  background: transparent;
  border: 1px solid transparent;
  color: var(--c-muted2);
  font-size: 1rem;
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
  min-height: 0; /* cegah .main ikut membesar mengikuti konten .pg */
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
  gap: 0.8rem;
  padding: 0 1.75rem;
  background: var(--c-white);
  border-bottom: 1px solid var(--c-border);
  flex-shrink: 0;
  position: sticky; top: 0; z-index: 20;
}
.btn-menu {
  display: flex; align-items: center; justify-content: center;
  width: 2.35rem; height: 2.35rem;
  border-radius: var(--radius-sm);
  background: transparent;
  border: 1px solid var(--c-border);
  color: var(--c-muted);
  font-size: 1.05rem;
  transition: background var(--tf), border-color var(--tf), color var(--tf);
  flex-shrink: 0;
}
.btn-menu:hover { background: #f4f7fa; border-color: var(--c-primary-25); color: var(--c-primary); }
@media (min-width: 768px) { .btn-menu { display: none; } }

/* Breadcrumb */
.bc {
  display: flex;
  align-items: center;
  font-size: 0.87rem;
}
.bc-root { color: var(--c-muted2); font-weight: 600; }
.bc-sep  { color: var(--c-muted2); font-size: 1rem; margin: 0 0.4rem; display: flex; }
.bc-page { color: var(--c-primary-dk); font-weight: 800; font-size: 0.93rem; }
@media (max-width: 767px) { .bc { display: none; } }

/* Search */
.tb-search {
  flex: 1;
  max-width: 19rem;
  margin-left: auto;
  position: relative;
}
.tb-search input {
  width: 100%;
  height: 2.5rem;
  background: #fbfcfe;
  border: 1.5px solid var(--c-border);
  border-radius: var(--radius-sm);
  padding: 0 2.9rem 0 2.5rem;
  font-family: var(--ff);
  font-size: 0.87rem;
  color: var(--c-ink);
  outline: none;
  transition: border var(--tf), background var(--tf), box-shadow var(--tf);
}
.tb-search input::placeholder { color: var(--c-muted2); }
.tb-search input:focus { border-color: var(--c-primary-lt); background: #fff; box-shadow: 0 0 0 3px rgba(6,182,212,.12); }
.tb-si {
  position: absolute; left: 0.8rem; top: 50%; transform: translateY(-50%);
  font-size: 1rem; color: var(--c-muted2); pointer-events: none;
}
.tb-kbd {
  position: absolute; right: 0.65rem; top: 50%; transform: translateY(-50%);
  font-size: 0.66rem; font-weight: 600; color: var(--c-muted2);
  background: var(--c-page); border: 1px solid var(--c-border);
  border-radius: 0.34rem; padding: 0.14rem 0.4rem; pointer-events: none;
}

/* Actions */
.tb-actions {
  display: flex; align-items: center; gap: 0.5rem; flex-shrink: 0;
}
@media (max-width: 767px) { .tb-search { display: none; } .tb-actions { margin-left: auto; } }

.btn-icon {
  position: relative;
  display: flex; align-items: center; justify-content: center;
  width: 2.5rem; height: 2.5rem;
  border-radius: var(--radius-sm);
  background: transparent;
  border: 1px solid var(--c-border);
  color: var(--c-muted);
  font-size: 1.05rem;
  transition: background var(--tf), border-color var(--tf), color var(--tf);
}
.btn-icon:hover { background: #f4f7fa; border-color: var(--c-primary-25); color: var(--c-primary); }
.ndot {
  position: absolute; top: 0.5rem; right: 0.5rem;
  width: 0.4rem; height: 0.4rem;
  border-radius: 50%; background: var(--c-red-text); border: 1.5px solid var(--c-white);
}
.chip-ok {
  display: flex; align-items: center; gap: 0.45rem;
  padding: 0.4rem 0.85rem;
  border-radius: 99px;
  background: var(--c-green-bg); border: 1px solid var(--c-green-border);
  font-size: 0.78rem; font-weight: 700; color: var(--c-green-text);
  user-select: none;
}
.chip-dot {
  width: 0.4rem; height: 0.4rem; border-radius: 50%; background: var(--c-green-text); flex-shrink: 0;
  animation: pdot 2.4s ease infinite;
}
@keyframes pdot {
  0%,100% { opacity:1; box-shadow: 0 0 0 0 rgba(21,128,61,.35); }
  50%      { opacity:.7; box-shadow: 0 0 0 4px rgba(21,128,61,0); }
}
@media (max-width: 560px) { .chip-ok span:last-child { display: none; } }

.tb-av {
  width: 2.5rem; height: 2.5rem;
  border-radius: 50%;
  background: var(--c-primary);
  display: flex; align-items: center; justify-content: center;
  font-size: 0.84rem; font-weight: 800; color: #fff;
  cursor: pointer; flex-shrink: 0;
  transition: box-shadow var(--tf), transform var(--tf);
  letter-spacing: -.02em;
}
.tb-av:hover { box-shadow: 0 0 0 4px var(--c-primary-12); transform: translateY(-1px); }

/* ==========================================================================
   FLASH
   ========================================================================== */
.flash-wrap { padding: 1.25rem 1.75rem 0; }
.alert {
  display: flex; align-items: flex-start; gap: 0.75rem;
  padding: 0.85rem 1rem;
  border-radius: var(--radius-md);
  font-size: 0.87rem; font-weight: 500;
  border: 1px solid; line-height: 1.5;
}
.alert i { font-size: 1.1rem; flex-shrink: 0; margin-top: 0.07rem; }
.alert-msg { flex: 1; }
.alert-x {
  background: none; border: none; font-size: 1.2rem; line-height: 1;
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
   Satu-satunya container yang boleh scroll di area konten.
   FIX: tambahkan scroll-margin-top ke semua elemen ber-id supaya kalau
   ada hash link (#id) di URL, target tidak ketutup topbar sticky dan
   scroll dilakukan dengan benar di dalam .pg (lihat script di bawah).
   ========================================================================== */
.pg {
  flex: 1;
  overflow-y: auto;
  overflow-x: hidden;
  padding: 2rem 1.75rem;
  min-height: 0; /* paksa .pg untuk benar-benar shrink & scroll di dalam dirinya sendiri */
  width: 100%;
  scroll-behavior: smooth;
}
.pg [id] { scroll-margin-top: calc(var(--th) + 1rem); }

/* Layar kecil / mobile: rapatkan padding */
@media (max-width: 480px) {
  .tb        { padding: 0 1rem; }
  .flash-wrap{ padding: 0.9rem 1rem 0; }
  .pg        { padding: 1.15rem 1rem; }
}

/* Layar besar (monitor PC / widescreen): beri ruang lebih & batasi lebar
   konten supaya tidak melebar tak terkendali di layar ultra-wide/4K. */
@media (min-width: 1600px) {
  .tb         { padding: 0 2.4rem; }
  .flash-wrap { padding: 1.4rem 2.4rem 0; }
  .pg         { padding: 2.4rem 2.4rem; max-width: 1600px; margin-inline: auto; }
}
@media (min-width: 2200px) {
  .pg { max-width: 1800px; }
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

          'Absensi' => [
    [
      'href'  => '/admin/absensi',
      'label' => 'Absensi Kegiatan',
      'icon'  => 'ti-calendar-event',
    ],
    [
      'href'  => '/admin/absensi-pertemuan',
      'label' => 'Absensi Pertemuan',
      'icon'  => 'ti-users-group',
    ],
    [
      'href'  => '/admin/fingerprint',
      'label' => 'Absensi Fingerprint',
      'icon'  => 'ti-fingerprint',
      'new'   => true,
    ],
    [
      'href'  => '/admin/jadwal-pertemuan',
      'label' => 'Jadwal Pertemuan',
      'icon'  => 'ti-calendar-time',
      'new'   => true,
    ],
],

          'Sistem' => [
  [
    'href'  => '/admin/settings',
    'label' => 'Pengaturan & CMS',
    'icon'  => 'ti-settings',
  ],
  [
    'href'  => '/admin/nia-sequence',
    'label' => 'Reset Sequence NIA',
    'icon'  => 'ti-hash',
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
  var pg  = document.getElementById('main-content');

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

  /* ========================================================================
     FIX BUG: hash anchor (#id) di URL.
     Karena body/html overflow:hidden dan yang scroll sebenarnya adalah
     .pg (#main-content), native browser anchor-scroll sering gagal/kadang
     malah memicu lompatan scroll aneh. Solusi: tangani manual — cari
     elemen target di dalam .pg lalu scrollIntoView ke situ saja.
     ========================================================================== */
  function goToHash(){
    var hash = window.location.hash;
    if(!hash || hash.length < 2) return;
    var target;
    try { target = document.getElementById(hash.slice(1)); } catch(e) { target = null; }
    if(target && pg && pg.contains(target)){
      requestAnimationFrame(function(){
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      });
    }
  }
  window.addEventListener('load', goToHash);
  window.addEventListener('hashchange', goToHash);

}());
</script>
<script src="<?= BASE_URL ?>/assets/js/main.js"></script>
</body>
</html>