<?php
$s  = fn(string $k, string $d = '') => htmlspecialchars($settings[$k]['value'] ?? $d);
$sr = fn(string $k, string $d = '') => $settings[$k]['value'] ?? $d;

$og_title       = htmlspecialchars($settings['org_name']['value'] ?? (defined('APP_NAME') ? APP_NAME : 'COM'));
$og_description = htmlspecialchars(
    $settings['og_description']['value']
    ?? $settings['org_description']['value']
    ?? 'Platform Digital Organisasi Siswa SMKN 2 Pinrang yang modern dan terpadu.'
);

if (!empty($settings['og_image']['value'])) {
    $og_image = UPLOAD_URL . '/' . $settings['og_image']['value'];
} elseif (!empty($settings['org_photo']['value'])) {
    $og_image = UPLOAD_URL . '/' . $settings['org_photo']['value'];
} else {
    $og_image = BASE_URL . '/assets/img/og-image.svg';
}

$og_url      = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http')
             . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$og_sitename = $og_title;

/* ══════════════════════════════════════════════════════════════
   FALLBACK GAMBAR CDN (tema pendidikan) — HANYA dipakai jika admin
   belum upload gambar sendiri. Semua gambar utama tetap ambil dari
   UPLOAD_URL + kolom DB (org_logo, org_photo, hero_image_1..3, gallery_img_N,
   pembina_foto, foto riwayat pengurus, dst).
   ══════════════════════════════════════════════════════════════ */
$heroFallbackImgs = [
    'https://images.unsplash.com/photo-1743090660977-babf07732432?auto=format&fit=crop&w=1600&q=60',
    'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=1600&q=60',
    'https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?auto=format&fit=crop&w=1600&q=60',
];
$aboutFallbackImg    = 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?auto=format&fit=crop&w=1000&q=60';
$sambutanFallbackImg = 'https://images.unsplash.com/photo-1544717297-fa95b6ee9643?auto=format&fit=crop&w=600&q=60';
$galleryFallbackImgs = [
    'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=800&q=60',
    'https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?auto=format&fit=crop&w=800&q=60',
    'https://images.unsplash.com/photo-1529390079861-591de354faf5?auto=format&fit=crop&w=800&q=60',
    'https://images.unsplash.com/photo-1571260899304-425eee4c7efc?auto=format&fit=crop&w=800&q=60',
    'https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&w=800&q=60',
    'https://images.unsplash.com/photo-1580582932707-520aed937b7b?auto=format&fit=crop&w=800&q=60',
];

/* ── Hero carousel: kumpulkan hingga 3 gambar dari admin, fallback ke stok ── */
$heroImages = [];
for ($hi = 1; $hi <= 3; $hi++) {
    $img = $sr("hero_image_{$hi}");
    if ($img) $heroImages[] = UPLOAD_URL . '/' . htmlspecialchars($img);
}
if (empty($heroImages)) {
    $heroImages = $heroFallbackImgs;
}

/* ── Berita terbaru (dikirim dari HomeController, aman jika kosong) ── */
$beritaList = isset($beritaList) && is_array($beritaList) ? $beritaList : [];
?>

<!-- ══ SEO: PRIMARY META ══ -->
<title>Website Resmi COM SMKN 2 Pinrang – Community Programmer SMK Negeri 2 Pinrang</title>
<meta name="description" content="Website resmi COM (Community Programmer) SMKN 2 Pinrang – Organisasi siswa bidang IT Software, IT Network, Multimedia, Desain Grafis, IoT, dan Robotik di SMK Negeri 2 Pinrang, Sulawesi Selatan. Daftar PAB sekarang!">
<meta name="keywords" content="COM SMKN 2 Pinrang, Community Programmer SMKN 2 Pinrang, SMK Negeri 2 Pinrang, SMKN 2 Pinrang, SMK 2 Pinrang, organisasi programmer Pinrang, IT SMK Pinrang, komunitas coding Pinrang, PAB COM Pinrang">
<meta name="author" content="COM SMKN 2 Pinrang">
<meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
<meta name="geo.region" content="ID-SN">
<meta name="geo.placename" content="Pinrang, Sulawesi Selatan">
<link rel="canonical" href="<?= htmlspecialchars($og_url) ?>">

<!-- ══ SEO: OPEN GRAPH ══ -->
<meta property="og:type"        content="website">
<meta property="og:url"         content="<?= htmlspecialchars($og_url) ?>">
<meta property="og:title"       content="Website Resmi COM SMKN 2 Pinrang – Community Programmer">
<meta property="og:description" content="<?= $og_description ?>">
<meta property="og:image"       content="<?= htmlspecialchars($og_image) ?>">
<meta property="og:image:width"  content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:alt"   content="COM SMKN 2 Pinrang">
<meta property="og:site_name"   content="COM SMKN 2 Pinrang">
<meta property="og:locale"      content="id_ID">

<!-- ══ SEO: TWITTER CARD ══ -->
<meta name="twitter:card"        content="summary_large_image">
<meta name="twitter:title"       content="Website Resmi COM SMKN 2 Pinrang – Community Programmer">
<meta name="twitter:description" content="<?= $og_description ?>">
<meta name="twitter:image"       content="<?= htmlspecialchars($og_image) ?>">

<!-- ══ SEO: STRUCTURED DATA (JSON-LD) ══ -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "COM SMKN 2 Pinrang – Community Programmer",
  "alternateName": ["COM SMKN 2 Pinrang", "Community Programmer SMKN 2 Pinrang", "COM SMK Negeri 2 Pinrang"],
  "description": "Organisasi siswa bidang IT Software, IT Network, Multimedia, Desain Grafis, IoT, dan Robotik di SMK Negeri 2 Pinrang, Sulawesi Selatan.",
  "url": "<?= htmlspecialchars($og_url) ?>",
  "logo": "<?= htmlspecialchars($og_image) ?>",
  "address": {
    "@type": "PostalAddress",
    "addressLocality": "Pinrang",
    "addressRegion": "Sulawesi Selatan",
    "addressCountry": "ID"
  },
  "parentOrganization": {
    "@type": "EducationalOrganization",
    "name": "SMK Negeri 2 Pinrang",
    "alternateName": ["SMKN 2 Pinrang", "SMK 2 Pinrang"]
  }
}
</script>

<!-- ══ FAVICONS ══ -->
<link rel="icon" type="image/x-icon"  href="<?= BASE_URL ?>/assets/img/favicon.ico">
<link rel="icon" type="image/png" sizes="32x32" href="<?= BASE_URL ?>/assets/img/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="<?= BASE_URL ?>/assets/img/favicon-16x16.png">
<link rel="apple-touch-icon" sizes="180x180" href="<?= BASE_URL ?>/assets/img/apple-touch-icon.png">

<!-- ══ DESIGN SYSTEM: FONT & ICON ══ -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

<style>
/* ─── RESET & BASE ───────────────────────────────────────────── */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

/* ─── DESIGN SYSTEM: ROOT VARIABLES ──────────────────────────── */
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

  --font-display: 'Plus Jakarta Sans', sans-serif;
  --ease-out: cubic-bezier(.22,1,.36,1);
  --ease-in-out: cubic-bezier(.65,0,.35,1);
}

#home-page { font-family: 'Plus Jakarta Sans', sans-serif; }
#home-page i.ti { line-height: 1; }

/* ─── REVEAL ANIMATION ───────────────────────────────────────── */
[data-reveal] {
  opacity: 0;
  transform: translateY(18px);
  transition: opacity .5s var(--ease-out), transform .5s var(--ease-out);
}
[data-reveal]._vis { opacity: 1; transform: none; }
[data-reveal][data-delay="1"] { transition-delay: .06s; }
[data-reveal][data-delay="2"] { transition-delay: .12s; }
[data-reveal][data-delay="3"] { transition-delay: .18s; }
[data-reveal][data-delay="4"] { transition-delay: .24s; }
[data-reveal][data-delay="5"] { transition-delay: .3s; }

/* ─── HERO ───────────────────────────────────────────────────── */
.hero {
  position: relative;
  min-height: calc(100svh - 64px);
  display: flex; align-items: center; overflow: hidden;
  background: linear-gradient(165deg, var(--c-primary-dk) 0%, #082c3a 100%);
}
/* ── HERO BACKGROUND CAROUSEL (3 foto, auto-slide crossfade) ── */
.hero-bg-carousel { position: absolute; inset: 0; z-index: 0; }
.hero-bg-slide {
  position: absolute; inset: 0; opacity: 0;
  transition: opacity 1.1s ease-in-out;
}
.hero-bg-slide.is-active { opacity: 1; }
.hero-bg-slide img { width: 100%; height: 100%; object-fit: cover; opacity: 0; transition: opacity .6s ease; }
.hero-bg-slide img.is-loaded { opacity: .55; }
.hero-carousel-dots {
  position: absolute; z-index: 2; bottom: 1.9rem; right: 2rem;
  display: flex; gap: 6px;
}
.hero-carousel-dot {
  width: 6px; height: 6px; border-radius: 99px; background: rgba(255,255,255,.35);
  border: none; cursor: pointer; transition: all .3s; padding: 0;
}
.hero-carousel-dot.active { width: 20px; background: var(--c-primary-lt); }
.hero-bg-overlay {
  position: absolute; inset: 0; z-index: 0;
  background: linear-gradient(175deg, rgba(8,20,32,.55) 0%, rgba(9,45,64,.72) 45%, rgba(6,30,44,.94) 100%);
}
.hero-inner {
  position: relative; z-index: 1;
  width: 100%; max-width: 1200px; margin: 0 auto;
  padding: 4rem 2rem 3.5rem;
  display: grid; grid-template-columns: 1fr 400px; gap: 3rem; align-items: center;
}
.hero-badge {
  display: inline-flex; align-items: center; gap: 8px;
  padding: 5px 14px;
  background: rgba(255,255,255,.09); border: 1px solid rgba(255,255,255,.16);
  border-radius: 99px; font-size: .68rem; font-weight: 700; color: #7dd3e8;
  letter-spacing: .05em; text-transform: uppercase; margin-bottom: 1.2rem;
  opacity: 0; transform: translateY(16px);
}
.hero-badge-dot { width: 6px; height: 6px; border-radius: 50%; background: var(--c-primary-lt); animation: pulse-dot 2s ease-in-out infinite; flex-shrink: 0; }
@keyframes pulse-dot { 0%,100% { opacity:1; box-shadow: 0 0 0 0 rgba(6,182,212,.5); } 50% { opacity:.6; box-shadow: 0 0 0 5px rgba(6,182,212,0); } }
.hero-title {
  font-family: var(--font-display); font-size: clamp(2rem, 4.5vw, 3.4rem); font-weight: 800;
  color: #fff; line-height: 1.09; letter-spacing: -.035em; margin-bottom: .9rem;
  text-shadow: 0 2px 20px rgba(0,0,0,.2);
}
.hero-title .t-grad { color: #67e8f9; }
.hero-tagline { font-size: .76rem; font-weight: 600; color: #7dd3e8; letter-spacing: .04em; margin-bottom: .7rem; }
.hero-desc { font-size: .93rem; color: rgba(255,255,255,.78); line-height: 1.85; max-width: 470px; margin-bottom: 1.8rem; }

.hero-sambutan {
  background: rgba(255,255,255,.07); border: 1px solid rgba(255,255,255,.14);
  border-radius: var(--radius-md); padding: 1rem 1.2rem; margin-bottom: 1.7rem;
  position: relative; opacity: 0; transform: translateY(16px);
}
.hero-sambutan::before { content: ''; position: absolute; top: 0; left: 0; width: 3px; height: 100%; background: var(--c-primary-lt); border-radius: 2px 0 0 2px; }
.hero-sambutan-label { font-size: .64rem; font-weight: 700; color: #7dd3e8; letter-spacing: .08em; text-transform: uppercase; margin-bottom: .4rem; display: flex; align-items: center; gap: 5px; }
.hero-sambutan-text { font-size: .84rem; color: rgba(255,255,255,.82); line-height: 1.7; font-style: italic; }

.hero-actions { display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 1.8rem; }

/* ─── BUTTONS ────────────────────────────────────────────────── */
.btn-primary {
  display: inline-flex; align-items: center; gap: 7px; padding: 13px 24px;
  background: var(--c-primary); color: #fff;
  font-family: var(--font-display); font-weight: 700; font-size: .86rem;
  border-radius: var(--radius-sm); text-decoration: none;
  transition: background .18s, transform .12s, box-shadow .18s;
  box-shadow: 0 8px 22px rgba(14,116,144,.32); letter-spacing: -.01em; white-space: nowrap;
}
.btn-primary:hover { background: var(--c-primary-lt); transform: translateY(-2px); box-shadow: 0 12px 28px rgba(6,182,212,.35); }
.btn-outline {
  display: inline-flex; align-items: center; gap: 7px; padding: 12px 22px;
  border: 1.5px solid rgba(255,255,255,.22); color: #fff; font-weight: 700; font-size: .85rem;
  border-radius: var(--radius-sm); text-decoration: none; background: rgba(255,255,255,.05);
  transition: all .2s; letter-spacing: -.01em; white-space: nowrap;
}
.btn-outline:hover { border-color: rgba(255,255,255,.4); background: rgba(255,255,255,.1); transform: translateY(-2px); }
.btn-outline--light { border-color: var(--c-border); color: var(--c-ink); background: var(--c-white); }
.btn-outline--light:hover { background: #f4f7fa; border-color: #d7dee7; }

/* ─── HERO TRUST ─────────────────────────────────────────────── */
.hero-trust { display: flex; align-items: center; gap: 12px; }
.hero-trust-avs { display: flex; }
.hero-trust-av {
  width: 28px; height: 28px; border-radius: 50%; background: var(--c-primary-lt);
  border: 2px solid var(--c-primary-dk); display: flex; align-items: center; justify-content: center;
  font-size: .58rem; font-weight: 800; color: #06313d; margin-left: -6px;
}
.hero-trust-av:first-child { margin-left: 0; }
.hero-trust-text { font-size: .76rem; color: rgba(255,255,255,.68); }
.hero-trust-text strong { color: #fff; }

/* ─── HERO VISUAL ────────────────────────────────────────────── */
.hero-visual { position: relative; }
.hero-mosaic { display: grid; grid-template-columns: 1fr 1fr; grid-template-rows: auto auto auto; gap: .7rem; }
.hm-card {
  background: rgba(255,255,255,.96); border: 1px solid rgba(255,255,255,.5);
  border-radius: var(--radius-md); padding: 1.05rem 1.15rem;
  transition: transform .25s var(--ease-out), box-shadow .25s;
  box-shadow: 0 14px 34px -14px rgba(0,0,0,.35);
}
.hm-card:hover { transform: translateY(-3px); box-shadow: 0 18px 40px -14px rgba(0,0,0,.4); }
.hm-card--wide { grid-column: 1 / -1; display: flex; align-items: center; gap: 1rem; }
.hm-icon {
  width: 36px; height: 36px; border-radius: 9px; background: rgba(14,116,144,.09);
  display: flex; align-items: center; justify-content: center; color: var(--c-primary); flex-shrink: 0; font-size: 16px;
}
.hm-logo-wrap {
  width: 38px; height: 38px; border-radius: 9px; overflow: hidden; flex-shrink: 0;
  background: var(--c-primary); display: flex; align-items: center; justify-content: center;
}
.hm-logo-wrap img { width: 100%; height: 100%; object-fit: cover; }
.hm-logo-fallback { font-family: var(--font-display); font-size: .85rem; font-weight: 900; color: #fff; }
.hm-num { font-family: var(--font-display); font-size: 1.65rem; font-weight: 800; color: var(--c-primary-dk); line-height: 1; display: block; margin-bottom: 3px; }
.hm-label { font-size: .64rem; color: var(--c-muted); text-transform: uppercase; letter-spacing: .07em; font-weight: 600; }
.hm-title { font-family: var(--font-display); font-size: .88rem; font-weight: 700; color: var(--c-ink); margin-bottom: .25rem; }
.hm-sub { font-size: .71rem; color: var(--c-muted); line-height: 1.5; }

/* ─── SCROLL CUE ─────────────────────────────────────────────── */
.scroll-cue { position: absolute; bottom: 1.8rem; left: 50%; transform: translateX(-50%); display: flex; flex-direction: column; align-items: center; gap: 6px; z-index: 1; pointer-events: none; }
.scroll-cue-text { font-size: .58rem; font-weight: 600; letter-spacing: .14em; text-transform: uppercase; color: rgba(255,255,255,.55); }
.scroll-cue-track { width: 1px; height: 36px; background: rgba(255,255,255,.2); border-radius: 2px; overflow: hidden; position: relative; }
.scroll-cue-track::after { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 50%; border-radius: 2px; background: linear-gradient(to bottom, var(--c-primary-lt), transparent); animation: track-drop 2s ease-in-out infinite; }
@keyframes track-drop { 0% { transform: translateY(-100%); opacity: 0; } 30% { opacity: 1; } 100% { transform: translateY(200%); opacity: 0; } }

@media (max-width: 768px) {
  .hero-carousel-dots { right: 50%; transform: translateX(50%); bottom: 4.6rem; }
}

/* ─── TICKER ─────────────────────────────────────────────────── */
.ticker-section { background: var(--c-white); border-top: 1px solid var(--c-border); border-bottom: 1px solid var(--c-border); padding: 11px 0; overflow: hidden; }
.ticker-track { display: flex; gap: 0; width: max-content; animation: ticker 32s linear infinite; }
.ticker-track:hover { animation-play-state: paused; }
.ticker-item { display: flex; align-items: center; gap: 8px; padding: 0 2rem; font-size: .72rem; font-weight: 600; color: var(--c-muted); letter-spacing: .03em; white-space: nowrap; }
.ticker-dot { width: 4px; height: 4px; border-radius: 50%; background: var(--c-primary); flex-shrink: 0; }
@keyframes ticker { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }

/* ─── STATS BAR ──────────────────────────────────────────────── */
.stats-section { background: var(--c-page); padding: 2rem 2rem; }
.stats-inner { max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: repeat(4, 1fr); gap: 1px; background: var(--c-border); border: 1px solid var(--c-border); border-radius: var(--radius-lg); overflow: hidden; }
.stat-cell { background: var(--c-white); padding: 1.5rem 1rem; text-align: center; position: relative; transition: background .2s; cursor: default; }
.stat-cell:hover { background: #fbfcfe; }
.stat-cell-bar { position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); width: 0; height: 2px; background: var(--c-primary); transition: width .35s var(--ease-out); border-radius: 2px; }
.stat-cell:hover .stat-cell-bar { width: 50%; }
.stat-num   { font-family: var(--font-display); font-size: 1.9rem; font-weight: 800; color: var(--c-primary-dk); line-height: 1; display: block; margin-bottom: 5px; letter-spacing: -.03em; }
.stat-label { font-size: .66rem; color: var(--c-muted); text-transform: uppercase; letter-spacing: .07em; font-weight: 600; }

/* ─── SECTION TYPOGRAPHY ─────────────────────────────────────── */
.eyebrow { display: inline-flex; align-items: center; gap: 8px; font-size: .68rem; font-weight: 700; color: var(--c-primary); text-transform: uppercase; letter-spacing: .1em; margin-bottom: .75rem; }
.eyebrow-bar { display: block; width: 20px; height: 1.5px; background: var(--c-primary); border-radius: 2px; }
.section-title { font-family: var(--font-display); font-size: clamp(1.5rem, 2.8vw, 2.1rem); font-weight: 800; color: var(--c-primary-dk); line-height: 1.14; letter-spacing: -.03em; margin-bottom: .7rem; }
.section-desc { font-size: .88rem; color: var(--c-muted); line-height: 1.8; max-width: 500px; }

/* ─── SECTION WRAPPER ────────────────────────────────────────── */
.section-wrap { max-width: 1200px; margin: 0 auto; padding: 0 2rem; }
.section-pad  { padding: 4.5rem 0; }

/* ─── ABOUT ──────────────────────────────────────────────────── */
.about-section { background: var(--c-white); }
.about-header { max-width: 580px; margin-bottom: 2.5rem; }
.about-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 2.5rem; align-items: start; }
.about-img-wrap { border-radius: var(--radius-lg); overflow: hidden; border: 1px solid var(--c-border); aspect-ratio: 4/3; background: var(--c-page); position: relative; }
.about-img-wrap img { width: 100%; height: 100%; object-fit: cover; display: block; }
.about-img-fallback-tag { position: absolute; left: 12px; bottom: 12px; background: rgba(6,30,44,.72); color: #fff; font-size: .66rem; font-weight: 600; letter-spacing: .03em; padding: 5px 11px; border-radius: 99px; backdrop-filter: blur(3px); }

.vm-stack { display: flex; flex-direction: column; gap: .85rem; }
.vm-item { background: var(--c-page); border: 1px solid var(--c-border); border-radius: var(--radius-md); padding: 1.2rem; display: flex; gap: .9rem; transition: border-color .2s, transform .2s; }
.vm-item:hover { border-color: rgba(14,116,144,.28); transform: translateX(3px); }
.vm-icon { width: 38px; height: 38px; flex-shrink: 0; background: rgba(14,116,144,.09); border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center; color: var(--c-primary); font-size: 17px; }
.vm-item h3 { font-family: var(--font-display); font-size: .85rem; font-weight: 700; color: var(--c-ink); margin-bottom: .3rem; }
.vm-item p  { font-size: .8rem; color: var(--c-muted); line-height: 1.72; }

/* ─── SAMBUTAN ───────────────────────────────────────────────── */
.sambutan-section { background: var(--c-page); }
.sambutan-box { background: var(--c-white); border: 1px solid var(--c-border); border-radius: var(--radius-lg); box-shadow: 0 30px 70px -20px rgba(15,23,42,.14), 0 4px 18px rgba(15,23,42,.04); padding: 2.4rem; display: grid; grid-template-columns: 260px 1fr; gap: 2.4rem; align-items: start; margin-top: 2.2rem; }
.sambutan-photo-col { display: flex; flex-direction: column; align-items: center; gap: 0; }
.sambutan-photo-frame { width: 100%; aspect-ratio: 3/4; border-radius: var(--radius-md) var(--radius-md) 0 0; overflow: hidden; border: 1px solid var(--c-border); border-bottom: none; background: var(--c-page); position: relative; flex-shrink: 0; }
.sambutan-photo-frame img { width: 100%; height: 100%; object-fit: cover; object-position: center top; display: block; }
.sambutan-identity { width: 100%; background: #f4f7fa; border: 1px solid var(--c-border); border-top: none; border-radius: 0 0 var(--radius-md) var(--radius-md); padding: .9rem 1rem; text-align: center; }
.sambutan-name { font-family: var(--font-display); font-size: 1rem; font-weight: 800; color: var(--c-ink); letter-spacing: -.02em; margin-bottom: .25rem; }
.sambutan-role { font-size: .74rem; color: var(--c-primary); font-weight: 700; line-height: 1.45; margin-bottom: .4rem; }
.sambutan-masa { display: inline-flex; align-items: center; gap: 4px; font-size: .64rem; font-weight: 600; color: var(--c-muted); background: var(--c-white); border: 1px solid var(--c-border); border-radius: 99px; padding: 2px 9px; }
.sambutan-content-col { display: flex; flex-direction: column; }
.sambutan-content-title { font-family: var(--font-display); font-size: clamp(1.2rem, 2vw, 1.55rem); font-weight: 800; color: var(--c-primary-dk); letter-spacing: -.03em; margin-bottom: 1.2rem; line-height: 1.18; }
.sambutan-content-title span { color: var(--c-primary); }
.sambutan-quote-icon { font-size: 2rem; margin-bottom: .6rem; display: block; color: rgba(14,116,144,.18); }
.sambutan-content { font-size: .91rem; color: var(--c-muted); line-height: 1.95; font-style: italic; padding-left: 1.1rem; border-left: 2px solid rgba(14,116,144,.25); }
.sambutan-sig { display: flex; align-items: center; gap: 10px; margin-top: 1.4rem; }
.sambutan-sig-line { width: 30px; height: 1.5px; background: var(--c-primary); border-radius: 2px; }
.sambutan-sig span { font-family: var(--font-display); font-size: .82rem; font-weight: 700; color: var(--c-primary-dk); }

/* ─── RIWAYAT ────────────────────────────────────────────────── */
.riwayat-section { background: var(--c-white); }
.riwayat-group { margin-top: 2.2rem; }
.riwayat-group + .riwayat-group { margin-top: 2.5rem; }
.riwayat-group-head { display: flex; align-items: center; gap: 12px; margin-bottom: 1.2rem; }
.riwayat-badge { display: inline-flex; align-items: center; gap: 5px; font-size: .66rem; font-weight: 700; letter-spacing: .05em; text-transform: uppercase; padding: 4px 12px; border-radius: 99px; white-space: nowrap; }
.riwayat-badge--ketua   { background: rgba(14,116,144,.09); border: 1px solid rgba(14,116,144,.24); color: var(--c-primary); }
.riwayat-badge--pembina { background: var(--c-page); border: 1px solid var(--c-border); color: var(--c-muted); }
.riwayat-group-line { flex: 1; height: 1px; background: linear-gradient(to right, var(--c-border), transparent); }
.riwayat-cards { display: grid; grid-template-columns: repeat(auto-fill, minmax(170px, 1fr)); gap: .85rem; }
.riwayat-card { background: var(--c-white); border: 1px solid var(--c-border); border-radius: var(--radius-md); padding: 1.3rem 1rem 1rem; display: flex; flex-direction: column; align-items: center; text-align: center; gap: .8rem; position: relative; transition: all .25s var(--ease-out); }
.riwayat-card:hover { border-color: rgba(14,116,144,.28); transform: translateY(-3px); box-shadow: 0 14px 30px -14px rgba(15,23,42,.2); }
.riwayat-current-badge { position: absolute; top: 8px; right: 8px; font-size: .58rem; font-weight: 700; padding: 2px 8px; border-radius: 99px; background: rgba(14,116,144,.1); color: var(--c-primary); border: 1px solid rgba(14,116,144,.22); letter-spacing: .03em; }
.riwayat-current-badge--pembina { background: var(--c-page); color: var(--c-muted); border-color: var(--c-border); }
.riwayat-card-foto { width: 70px; height: 70px; border-radius: 50%; overflow: hidden; border: 2px solid var(--c-border); background: var(--c-page); transition: border-color .2s; }
.riwayat-card:hover .riwayat-card-foto { border-color: rgba(14,116,144,.4); }
.riwayat-card-foto img { width: 100%; height: 100%; object-fit: cover; display: block; }
.riwayat-foto-ph { width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-family: var(--font-display); font-size: 1.1rem; font-weight: 800; color: #fff; background: var(--c-primary); }
.riwayat-foto-ph--pembina { background: var(--c-muted2); }
.riwayat-card-name    { font-family: var(--font-display); font-size: .85rem; font-weight: 800; color: var(--c-ink); line-height: 1.2; letter-spacing: -.01em; }
.riwayat-card-jabatan { font-size: .68rem; color: var(--c-primary); font-weight: 700; }
.riwayat-jabatan--pembina { color: var(--c-muted); }
.riwayat-card-periode { display: inline-flex; align-items: center; justify-content: center; gap: 4px; font-size: .62rem; font-weight: 600; color: var(--c-muted); background: var(--c-page); border: 1px solid var(--c-border); border-radius: 99px; padding: 2px 9px; }
.riwayat-card-catatan { font-size: .68rem; color: var(--c-muted); line-height: 1.5; }
.riwayat-card--current { border-color: rgba(14,116,144,.2); background: #fbfeff; }
.riwayat-card--current.riwayat-card--pembina { border-color: var(--c-border); background: #fbfcfe; }

/* ─── FEATURES ───────────────────────────────────────────────── */
.features-section { background: var(--c-page); }
.features-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: .85rem; margin-top: 2.2rem; }
.feat-card { background: var(--c-white); border: 1px solid var(--c-border); border-radius: var(--radius-md); padding: 1.4rem; position: relative; overflow: hidden; transition: all .22s var(--ease-out); }
.feat-card:hover { border-color: rgba(14,116,144,.28); transform: translateY(-3px); box-shadow: 0 14px 30px -14px rgba(15,23,42,.18); }
.feat-bg-num { position: absolute; bottom: -8px; right: 10px; font-family: var(--font-display); font-size: 3.6rem; font-weight: 800; color: rgba(14,116,144,.045); pointer-events: none; line-height: 1; user-select: none; }
.feat-icon { width: 40px; height: 40px; border-radius: var(--radius-sm); background: rgba(14,116,144,.09); display: flex; align-items: center; justify-content: center; color: var(--c-primary); margin-bottom: 1rem; font-size: 19px; }
.feat-card:hover .feat-icon { background: rgba(14,116,144,.16); }
.feat-card h4 { font-family: var(--font-display); font-size: .9rem; font-weight: 700; color: var(--c-ink); margin-bottom: .45rem; }
.feat-card p  { font-size: .79rem; color: var(--c-muted); line-height: 1.72; position: relative; z-index: 1; }

/* ─── PROGRAMS ───────────────────────────────────────────────── */
.programs-section { background: var(--c-white); }
.programs-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: .85rem; margin-top: 2.2rem; }
.prog-card { background: var(--c-page); border: 1px solid var(--c-border); border-radius: var(--radius-md); padding: 1.6rem; display: flex; gap: 1.1rem; align-items: flex-start; transition: all .22s var(--ease-out); }
.prog-card:hover { border-color: rgba(14,116,144,.24); transform: translateY(-2px); box-shadow: 0 12px 28px -14px rgba(15,23,42,.16); }
.prog-num { font-family: var(--font-display); font-size: 2rem; font-weight: 800; color: rgba(14,116,144,.18); line-height: 1; flex-shrink: 0; }
.prog-card:hover .prog-num { color: rgba(14,116,144,.32); }
.prog-card h3 { font-family: var(--font-display); font-size: .93rem; font-weight: 700; color: var(--c-ink); margin-bottom: .35rem; }
.prog-card p  { font-size: .8rem; color: var(--c-muted); line-height: 1.7; }
.prog-tag { display: inline-flex; align-items: center; gap: 4px; margin-top: .7rem; font-size: .64rem; font-weight: 600; padding: 2px 10px; border-radius: 99px; background: rgba(14,116,144,.08); border: 1px solid rgba(14,116,144,.2); color: var(--c-primary); letter-spacing: .01em; }

/* ─── GALLERY (carousel auto-slide 3 kolom) ──────────────────── */
.gallery-section { background: var(--c-page); }
.gallery-carousel-viewport { overflow: hidden; margin-top: 2.2rem; }
.gallery-carousel-track { display: flex; gap: .85rem; transition: transform .55s var(--ease-in-out); will-change: transform; }
.gallery-slide { flex: 0 0 calc(33.333% - .567rem); min-width: 0; }
.gallery-card { position: relative; border-radius: var(--radius-md); overflow: hidden; border: 1px solid var(--c-border); background: var(--c-white); aspect-ratio: 4/3; cursor: zoom-in; transition: transform .3s var(--ease-out), box-shadow .3s; }
.gallery-card:hover { transform: translateY(-3px) scale(1.015); box-shadow: 0 16px 36px -14px rgba(15,23,42,.26); z-index: 2; }
.gallery-card img { width: 100%; height: 100%; object-fit: cover; display: block; }
.gallery-overlay { position: absolute; inset: 0; background: linear-gradient(to top, rgba(9,25,38,.8) 0%, transparent 55%); opacity: 0; transition: opacity .25s; display: flex; align-items: flex-end; justify-content: space-between; gap: 8px; padding: .8rem; }
.gallery-card:hover .gallery-overlay { opacity: 1; }
.gallery-overlay-text { font-size: .73rem; font-weight: 700; color: #fff; }
.gallery-zoom-hint { width: 26px; height: 26px; border-radius: 50%; background: rgba(255,255,255,.18); border: 1px solid rgba(255,255,255,.3); display: flex; align-items: center; justify-content: center; color: #fff; flex-shrink: 0; font-size: 13px; }
.gallery-carousel-controls { display: flex; align-items: center; gap: 9px; margin-top: 1.5rem; }
.gallery-btn { width: 36px; height: 36px; background: var(--c-white); border: 1px solid var(--c-border); border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center; color: var(--c-muted); cursor: pointer; transition: all .2s; font-size: 15px; }
.gallery-btn:hover { background: var(--c-primary); color: #fff; border-color: var(--c-primary); }
.gallery-dots { display: flex; gap: 5px; }
.gallery-dot { width: 6px; height: 6px; border-radius: 99px; background: var(--c-border); transition: all .3s; cursor: pointer; border: none; }
.gallery-dot.active { width: 18px; background: var(--c-primary); }
.gallery-more-wrap { display: flex; justify-content: center; margin-top: 1.7rem; }

/* ─── LIGHTBOX ───────────────────────────────────────────────── */
.lightbox-overlay { position: fixed; inset: 0; z-index: 999; background: rgba(6,14,22,.9); display: none; align-items: center; justify-content: center; padding: 2rem; backdrop-filter: blur(2px); }
.lightbox-overlay.is-open { display: flex; }
.lightbox-img-wrap { max-width: 90vw; max-height: 85vh; position: relative; }
.lightbox-img-wrap img { max-width: 90vw; max-height: 85vh; border-radius: var(--radius-md); display: block; box-shadow: 0 30px 80px rgba(0,0,0,.5); }
.lightbox-caption { text-align: center; color: rgba(255,255,255,.8); font-size: .8rem; margin-top: .8rem; }
.lightbox-close { position: absolute; top: -18px; right: -18px; width: 36px; height: 36px; border-radius: 50%; background: #fff; color: var(--c-ink); border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 22px rgba(0,0,0,.35); font-size: 16px; }

/* ─── BERITA ─────────────────────────────────────────────────── */
.berita-section { background: var(--c-white); }
.berita-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: .9rem; margin-top: 2.2rem; }
.berita-card {
  background: var(--c-page); border: 1px solid var(--c-border); border-radius: var(--radius-md);
  overflow: hidden; text-decoration: none; display: flex; flex-direction: column;
  transition: all .22s var(--ease-out);
}
.berita-card:hover { border-color: rgba(14,116,144,.28); transform: translateY(-3px); box-shadow: 0 14px 30px -14px rgba(15,23,42,.2); }
.berita-card-img { aspect-ratio: 16/9; background: var(--c-border); overflow: hidden; }
.berita-card-img img { width: 100%; height: 100%; object-fit: cover; display: block; }
.berita-card-body { padding: 1.1rem 1.2rem 1.3rem; display: flex; flex-direction: column; gap: .5rem; }
.berita-card-tag {
  display: inline-flex; align-items: center; width: fit-content; font-size: .62rem; font-weight: 700;
  padding: 2px 10px; border-radius: 99px; background: rgba(14,116,144,.09); border: 1px solid rgba(14,116,144,.22);
  color: var(--c-primary); letter-spacing: .02em; text-transform: uppercase;
}
.berita-card-body h3 { font-family: var(--font-display); font-size: .92rem; font-weight: 700; color: var(--c-ink); line-height: 1.35; }
.berita-card-body p { font-size: .79rem; color: var(--c-muted); line-height: 1.65; }
.berita-card-date { font-size: .68rem; color: var(--c-muted2); display: inline-flex; align-items: center; gap: 4px; margin-top: 2px; }
.empty-berita { text-align: center; padding: 2.4rem 1rem; color: var(--c-muted); font-size: .86rem; background: var(--c-page); border: 1px dashed var(--c-border); border-radius: var(--radius-md); margin-top: 2rem; }
.berita-more-wrap { display: flex; justify-content: center; margin-top: 2rem; }
@media (max-width: 900px) { .berita-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 600px) { .berita-grid { grid-template-columns: 1fr; } }

/* ─── TESTIMONIALS CAROUSEL ──────────────────────────────────── */
.carousel-section { background: var(--c-white); overflow: hidden; }
.carousel-viewport { overflow: hidden; }
.carousel-track { display: flex; gap: 1rem; transition: transform .5s var(--ease-in-out); will-change: transform; }
.carousel-slide { flex: 0 0 calc(33.333% - .67rem); min-width: 0; }
.test-card { background: var(--c-page); border: 1px solid var(--c-border); border-radius: var(--radius-md); padding: 1.4rem; height: 100%; transition: border-color .2s; }
.test-card:hover { border-color: rgba(14,116,144,.25); }
.test-stars { display: flex; gap: 3px; margin-bottom: .8rem; font-size: 12px; }
.test-stars i { color: #d9910c; }
.test-quote { font-size: .83rem; color: var(--c-muted); line-height: 1.8; margin-bottom: 1.2rem; font-style: italic; }
.test-author { display: flex; align-items: center; gap: 9px; }
.test-avatar { width: 34px; height: 34px; border-radius: 50%; background: var(--c-primary); display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: .7rem; color: #fff; flex-shrink: 0; }
.test-name { font-size: .81rem; font-weight: 700; color: var(--c-ink); }
.test-role { font-size: .68rem; color: var(--c-muted); margin-top: 1px; }
.carousel-controls { display: flex; align-items: center; gap: 9px; margin-top: 1.5rem; }
.carousel-btn { width: 36px; height: 36px; background: var(--c-white); border: 1px solid var(--c-border); border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center; color: var(--c-muted); cursor: pointer; transition: all .2s; font-size: 15px; }
.carousel-btn:hover { background: var(--c-primary); color: #fff; border-color: var(--c-primary); }
.carousel-dots { display: flex; gap: 5px; }
.carousel-dot { width: 6px; height: 6px; border-radius: 99px; background: var(--c-border); transition: all .3s; cursor: pointer; border: none; }
.carousel-dot.active { width: 18px; background: var(--c-primary); }

/* ─── CTA ────────────────────────────────────────────────────── */
.cta-section { background: var(--c-page); }
.cta-box { background: var(--c-white); border: 1px solid var(--c-border); border-radius: var(--radius-lg); box-shadow: 0 30px 70px -20px rgba(15,23,42,.14), 0 4px 18px rgba(15,23,42,.04); padding: 2.6rem 2.4rem; display: grid; grid-template-columns: 1fr auto; gap: 2rem; align-items: center; position: relative; border-top: 3px solid var(--c-primary); }
.cta-box h2 { font-family: var(--font-display); font-size: clamp(1.35rem, 2.5vw, 1.8rem); font-weight: 800; color: var(--c-primary-dk); letter-spacing: -.03em; margin-bottom: .65rem; }
.cta-box p { font-size: .88rem; color: var(--c-muted); line-height: 1.75; max-width: 500px; }
.cta-actions { display: flex; flex-direction: column; gap: 8px; flex-shrink: 0; }

/* ─── CONTACT (2 kolom: kartu kiri, peta kanan) ──────────────── */
.contact-section { background: var(--c-white); }
.contact-layout { display: grid; grid-template-columns: 1fr 1.15fr; gap: 1rem; margin-top: 2rem; align-items: stretch; }
.contact-cards-col { display: flex; flex-direction: column; gap: .85rem; }
.contact-card { background: var(--c-page); border: 1px solid var(--c-border); border-radius: var(--radius-md); padding: 1.3rem; display: flex; align-items: center; gap: .9rem; text-decoration: none; transition: all .2s; }
.contact-card:hover { border-color: rgba(14,116,144,.28); transform: translateY(-2px); box-shadow: 0 10px 26px -14px rgba(15,23,42,.18); }
.contact-icon { width: 42px; height: 42px; flex-shrink: 0; background: rgba(14,116,144,.09); border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center; color: var(--c-primary); font-size: 18px; }
.contact-label { font-size: .62rem; color: var(--c-muted2); font-weight: 700; text-transform: uppercase; letter-spacing: .07em; margin-bottom: 3px; }
.contact-val   { font-size: .85rem; color: var(--c-ink); font-weight: 700; }
.contact-cards-col .contact-card { flex: 1; }

.contact-map-card { background: var(--c-page); border: 1px solid var(--c-border); border-radius: var(--radius-md); overflow: hidden; display: flex; flex-direction: column; }
.contact-map-head { display: flex; align-items: center; gap: .9rem; padding: 1.1rem 1.3rem; }
.contact-map-frame { width: 100%; flex: 1; min-height: 260px; display: block; border: 0; filter: grayscale(.15) contrast(1.02); }
.contact-map-foot { display: flex; align-items: center; justify-content: space-between; gap: 1rem; padding: .8rem 1.3rem; flex-wrap: wrap; border-top: 1px solid var(--c-border); background: var(--c-white); }
.contact-map-foot span { font-size: .78rem; color: var(--c-muted); }
.contact-map-link { display: inline-flex; align-items: center; gap: 5px; font-size: .76rem; font-weight: 700; color: var(--c-primary); text-decoration: none; white-space: nowrap; }
.contact-map-link:hover { color: var(--c-primary-dk); }

/* ─── DIVIDER ────────────────────────────────────────────────── */
.section-divider { width: 100%; height: 1px; background: var(--c-border); }

/* ─── RESPONSIVE ─────────────────────────────────────────────── */
@media (max-width: 1024px) {
  .hero-inner      { grid-template-columns: 1fr 340px; gap: 2rem; }
  .features-grid   { grid-template-columns: repeat(2, 1fr); }
  .carousel-slide, .gallery-slide  { flex: 0 0 calc(50% - .5rem); }
  .sambutan-box    { grid-template-columns: 210px 1fr; gap: 2rem; }
}

@media (max-width: 900px) {
  .contact-layout { grid-template-columns: 1fr; }
  .contact-map-frame { min-height: 220px; }
}

@media (max-width: 768px) {
  .hero            { min-height: auto; }
  .hero-inner      { grid-template-columns: 1fr; padding: 3.2rem 1.25rem 3rem; gap: 0; text-align: center; }
  .hero-visual     { display: none; }
  .hero-desc       { margin-left: auto; margin-right: auto; }
  .hero-actions    { justify-content: center; }
  .hero-trust      { justify-content: center; }
  .hero-sambutan   { text-align: left; }
  .stats-inner     { grid-template-columns: repeat(2, 1fr); }
  .about-grid      { grid-template-columns: 1fr; gap: 1.8rem; }
  .features-grid   { grid-template-columns: 1fr; }
  .programs-grid   { grid-template-columns: 1fr; }
  .carousel-slide, .gallery-slide  { flex: 0 0 100%; }
  .cta-box         { grid-template-columns: 1fr; text-align: center; padding: 2rem 1.5rem; gap: 1.5rem; }
  .cta-actions     { align-items: center; }
  .cta-box p       { margin-left: auto; margin-right: auto; }
  .sambutan-box    { grid-template-columns: 1fr; padding: 1.6rem; gap: 1.8rem; }
  .sambutan-photo-col { flex-direction: row; align-items: flex-end; gap: 1.2rem; }
  .sambutan-photo-frame { width: 130px; flex-shrink: 0; aspect-ratio: 3/4; }
  .riwayat-cards   { grid-template-columns: repeat(2, 1fr); }
  .section-pad     { padding: 3.5rem 0; }
  .section-wrap    { padding: 0 1.25rem; }
  .stats-section   { padding: 1.5rem 1.25rem; }
}

@media (max-width: 480px) {
  .hero-inner      { padding: 3rem 1rem 2.8rem; }
  .hero-title      { font-size: 1.9rem; }
  .hero-badge      { font-size: .6rem; }
  .stats-inner     { grid-template-columns: repeat(2, 1fr); border-radius: var(--radius-md); }
  .stat-num        { font-size: 1.6rem; }
  .stat-cell       { padding: 1.2rem .85rem; }
  .section-title   { font-size: 1.4rem; }
  .prog-card       { flex-direction: column; gap: .6rem; }
  .prog-num        { font-size: 1.6rem; }
  .cta-box         { padding: 1.75rem 1.1rem; }
  .btn-primary, .btn-outline { padding: 11px 19px; font-size: .82rem; }
  .contact-icon    { width: 38px; height: 38px; border-radius: var(--radius-sm); }
  .contact-val     { font-size: .82rem; word-break: break-all; }
  .riwayat-cards   { grid-template-columns: 1fr; }
  .sambutan-content { font-size: .86rem; }
  .sambutan-photo-col { flex-direction: column; align-items: center; }
  .sambutan-photo-frame { width: 100%; max-width: 200px; }
  .section-wrap    { padding: 0 1rem; }
}
</style>

<div id="home-page">

<!-- ══ HERO ══ -->
<section class="hero">
  <div class="hero-bg-carousel" id="hero-bg-carousel">
    <?php foreach ($heroImages as $hIdx => $hSrc): ?>
    <div class="hero-bg-slide<?= $hIdx === 0 ? ' is-active' : '' ?>" data-hero-slide="<?= $hIdx ?>">
      <img src="<?= htmlspecialchars($hSrc) ?>" alt="" loading="<?= $hIdx === 0 ? 'eager' : 'lazy' ?>" decoding="async" onload="this.classList.add('is-loaded')">
    </div>
    <?php endforeach; ?>
  </div>
  <div class="hero-bg-overlay"></div>

  <?php if (count($heroImages) > 1): ?>
  <div class="hero-carousel-dots" id="hero-carousel-dots" aria-hidden="true">
    <?php foreach ($heroImages as $hIdx => $hSrc): ?>
    <button type="button" class="hero-carousel-dot<?= $hIdx === 0 ? ' active' : '' ?>" data-hero-dot="<?= $hIdx ?>" aria-label="Slide <?= $hIdx + 1 ?>"></button>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>

  <div class="hero-inner">
    <div class="hero-left">

      <div class="hero-badge" id="hero-badge">
        <span class="hero-badge-dot"></span>
        <?= $s('hero_badge_text', 'Organisasi Resmi · SMKN 2 Pinrang') ?>
      </div>

      <h1 class="hero-title" id="hero-title" style="opacity:0;transform:translateY(22px)">
        <?php
          $name  = $sr('org_name') ?: (defined('APP_NAME') ? APP_NAME : 'COM');
          $parts = explode(' ', $name);
          $last  = array_pop($parts);
          echo htmlspecialchars(implode(' ', $parts));
          echo count($parts) ? ' ' : '';
          echo '<span class="t-grad">' . htmlspecialchars($last) . '</span>';
        ?>
      </h1>

      <?php if ($sr('org_tagline')): ?>
      <p class="hero-tagline" id="hero-tagline" style="opacity:0;transform:translateY(16px)"><?= $s('org_tagline') ?></p>
      <?php endif; ?>

      <?php if ($sr('org_description')): ?>
      <p class="hero-desc" id="hero-desc" style="opacity:0;transform:translateY(16px)"><?= $s('org_description') ?></p>
      <?php endif; ?>

      <div class="hero-sambutan" id="hero-sambutan">
        <div class="hero-sambutan-label"><i class="ti ti-heart-handshake"></i> Selamat Datang</div>
        <div class="hero-sambutan-text">
          <?= htmlspecialchars(
            $settings['hero_sambutan']['value']
            ?? 'Selamat datang di website resmi COM (Community Programmer) SMKN 2 Pinrang — wadah pengembangan siswa di bidang IT Software, IT Network, Multimedia, Desain Grafis, IoT, dan Robotik. Bersama kami, wujudkan potensi terbaikmu!'
          ) ?>
        </div>
      </div>

      <div class="hero-actions" id="hero-actions" style="opacity:0;transform:translateY(16px)">
        <?php if (empty($_SESSION['user_id'])): ?>
          <a href="<?= BASE_URL ?>/pab" class="btn-primary"><i class="ti ti-user-plus"></i> Daftar PAB</a>
          <a href="<?= BASE_URL ?>/login" class="btn-outline"><i class="ti ti-login-2"></i> Masuk Portal</a>
        <?php else: ?>
          <a href="<?= BASE_URL ?>/<?= $_SESSION['user_role'] === 'admin' ? 'admin' : 'member' ?>/dashboard" class="btn-primary">Dashboard Saya</a>
        <?php endif; ?>
      </div>

      <div class="hero-trust" id="hero-trust" style="opacity:0;transform:translateY(16px)">
        <div class="hero-trust-avs">
          <div class="hero-trust-av">AB</div>
          <div class="hero-trust-av">CD</div>
          <div class="hero-trust-av">EF</div>
          <div class="hero-trust-av">+<?= $s('stat_members', '97') ?></div>
        </div>
        <span class="hero-trust-text">Bergabung dengan <strong><?= $s('stat_members', '100+') ?></strong> anggota aktif</span>
      </div>
    </div>

    <div class="hero-visual" aria-hidden="true">
      <div class="hero-mosaic">
        <div class="hm-card">
          <div class="hm-icon"><i class="ti ti-users"></i></div>
          <span class="hm-num"><?= $s('stat_members', '100+') ?></span>
          <span class="hm-label">Anggota Aktif</span>
        </div>
        <div class="hm-card">
          <div class="hm-icon"><i class="ti ti-clock-hour-8"></i></div>
          <span class="hm-num"><?= $s('stat_years', '5+') ?></span>
          <span class="hm-label">Tahun Berdiri</span>
        </div>
        <div class="hm-card hm-card--wide">
          <?php if ($sr('org_logo') || $sr('org_photo')): ?>
          <div class="hm-logo-wrap"><img src="<?= UPLOAD_URL . '/' . $s($sr('org_logo') ? 'org_logo' : 'org_photo') ?>" alt="Logo COM"></div>
          <?php else: ?>
          <div class="hm-logo-wrap"><span class="hm-logo-fallback">COM</span></div>
          <?php endif; ?>
          <div>
            <div class="hm-title">Community Programmer</div>
            <div class="hm-sub">COM · SMKN 2 Pinrang — Platform Digital Organisasi Siswa</div>
          </div>
        </div>
        <div class="hm-card">
          <div class="hm-icon"><i class="ti ti-calendar-event"></i></div>
          <span class="hm-num"><?= $s('stat_events', '50+') ?></span>
          <span class="hm-label">Kegiatan</span>
        </div>
        <div class="hm-card">
          <div class="hm-icon"><i class="ti ti-trophy"></i></div>
          <span class="hm-num"><?= $s('stat_awards', '20+') ?></span>
          <span class="hm-label">Prestasi</span>
        </div>
      </div>
    </div>
  </div>

  <div class="scroll-cue" aria-hidden="true">
    <span class="scroll-cue-text">Scroll</span>
    <div class="scroll-cue-track"></div>
  </div>
</section>

<!-- ══ TICKER ══ -->
<?php
$tickerRaw   = $sr('ticker_items', 'COM Academy|Penerimaan Anggota Baru|Tech Talk & Workshop|Creative Festival|COM SMKN 2 Pinrang|Community Programmer');
$tickerItems = array_filter(array_map('trim', explode('|', $tickerRaw)));
$tickerAll   = array_merge($tickerItems, $tickerItems);
?>
<div class="ticker-section" aria-hidden="true">
  <div class="ticker-track">
    <?php foreach ($tickerAll as $item): ?>
    <span class="ticker-item"><span class="ticker-dot"></span><?= htmlspecialchars($item) ?></span>
    <?php endforeach; ?>
  </div>
</div>

<!-- ══ STATS ══ -->
<div class="stats-section">
  <div class="stats-inner">
    <div class="stat-cell" data-reveal>
      <span class="stat-num"><?= $s('stat_members', '100+') ?></span>
      <div class="stat-label">Anggota Aktif</div>
      <div class="stat-cell-bar"></div>
    </div>
    <div class="stat-cell" data-reveal data-delay="1">
      <span class="stat-num"><?= $s('stat_years', '5+') ?></span>
      <div class="stat-label">Tahun Berdiri</div>
      <div class="stat-cell-bar"></div>
    </div>
    <div class="stat-cell" data-reveal data-delay="2">
      <span class="stat-num"><?= $s('stat_events', '50+') ?></span>
      <div class="stat-label">Kegiatan</div>
      <div class="stat-cell-bar"></div>
    </div>
    <div class="stat-cell" data-reveal data-delay="3">
      <span class="stat-num"><?= $s('stat_awards', '20+') ?></span>
      <div class="stat-label">Prestasi</div>
      <div class="stat-cell-bar"></div>
    </div>
  </div>
</div>

<div class="section-divider"></div>

<!-- ══ ABOUT ══ -->
<section class="about-section section-pad" id="about">
  <div class="section-wrap">
    <div class="about-header">
      <div class="eyebrow" data-reveal><span class="eyebrow-bar"></span>Tentang Kami</div>
      <h2 class="section-title" data-reveal data-delay="1">Visi &amp; Misi<br>Organisasi</h2>
      <p class="section-desc" data-reveal data-delay="2">Kami berkomitmen membentuk generasi yang berdedikasi, kompeten, dan berintegritas melalui program organisasi yang terstruktur dan berkelanjutan.</p>
    </div>

    <div class="about-grid">
      <div class="about-img-wrap" data-reveal data-delay="1">
        <?php if ($sr('org_photo')): ?>
          <img src="<?= UPLOAD_URL . '/' . $s('org_photo') ?>" alt="Foto Organisasi COM SMKN 2 Pinrang" loading="lazy">
        <?php else: ?>
          <img src="<?= htmlspecialchars($aboutFallbackImg) ?>" alt="Foto Organisasi COM SMKN 2 Pinrang" loading="lazy">
          <span class="about-img-fallback-tag">Foto Organisasi</span>
        <?php endif; ?>
      </div>

      <div class="vm-stack" data-reveal data-delay="2">
        <div class="vm-item">
          <div class="vm-icon"><i class="ti ti-eye"></i></div>
          <div>
            <h3>Visi</h3>
            <p><?= nl2br($s('org_vision', 'Menjadi organisasi siswa yang unggul, berdedikasi, dan mampu mencetak generasi pemimpin masa depan yang berintegritas dan kompeten di bidang teknologi.')) ?></p>
          </div>
        </div>
        <div class="vm-item">
          <div class="vm-icon"><i class="ti ti-target-arrow"></i></div>
          <div>
            <h3>Misi</h3>
            <p><?= nl2br($s('org_mission', 'Membina anggota secara aktif, menyelenggarakan kegiatan edukatif dan inovatif, serta membangun sinergi positif di lingkungan sekolah maupun masyarakat luas.')) ?></p>
          </div>
        </div>
        <div class="vm-item">
          <div class="vm-icon"><i class="ti ti-shield-check"></i></div>
          <div>
            <h3>Nilai Organisasi</h3>
            <p><?= $s('org_nilai', 'Integritas, inovasi, kolaborasi, dan dedikasi menjadi fondasi setiap langkah kami dalam berorganisasi.') ?></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="section-divider"></div>

<!-- ══ SAMBUTAN ══ -->
<?php if (($settings['sambutan_show']['value'] ?? '1') === '1'): ?>
<section class="sambutan-section section-pad" id="sambutan">
  <div class="section-wrap">
    <div class="eyebrow" data-reveal><span class="eyebrow-bar"></span><?= htmlspecialchars($settings['sambutan_eyebrow']['value'] ?? 'Sambutan Pembina') ?></div>
    <h2 class="section-title" data-reveal data-delay="1">Kata-Kata dari Pembina</h2>

    <div class="sambutan-box" data-reveal data-delay="2">
      <div class="sambutan-photo-col">
        <?php $pembinaFoto = $settings['pembina_foto']['value'] ?? ''; ?>
        <div class="sambutan-photo-frame">
          <?php if ($pembinaFoto): ?>
            <img src="<?= UPLOAD_URL . '/' . htmlspecialchars($pembinaFoto) ?>" alt="Foto Pembina COM SMKN 2 Pinrang" loading="lazy">
          <?php else: ?>
            <img src="<?= htmlspecialchars($sambutanFallbackImg) ?>" alt="Foto Pembina COM SMKN 2 Pinrang" loading="lazy">
          <?php endif; ?>
        </div>
        <div class="sambutan-identity">
          <div class="sambutan-name"><?= htmlspecialchars($settings['pembina_nama']['value'] ?? 'Nama Pembina') ?></div>
          <div class="sambutan-role"><?= htmlspecialchars($settings['pembina_jabatan']['value'] ?? 'Guru Pembina') ?></div>
          <?php if (!empty($settings['pembina_masa']['value'])): ?>
          <div class="sambutan-masa"><i class="ti ti-calendar"></i> <?= htmlspecialchars($settings['pembina_masa']['value']) ?></div>
          <?php endif; ?>
        </div>
      </div>

      <div class="sambutan-content-col">
        <div class="sambutan-content-title">Sambutan<br><span>Pembina</span></div>
        <i class="ti ti-quote sambutan-quote-icon"></i>
        <div class="sambutan-content">
          <?= nl2br(htmlspecialchars(
              $settings['pembina_sambutan']['value']
              ?? 'Selamat datang di platform digital COM SMKN 2 Pinrang. Kami berharap organisasi ini menjadi wadah terbaik untuk pengembangan diri seluruh anggota.'
          )) ?>
        </div>
        <div class="sambutan-sig">
          <div class="sambutan-sig-line"></div>
          <span><?= htmlspecialchars($settings['pembina_nama']['value'] ?? 'Pembina') ?></span>
        </div>
      </div>
    </div>
  </div>
</section>
<div class="section-divider"></div>
<?php endif; ?>

<!-- ══ RIWAYAT ══ -->
<?php
if (!isset($ketuaList))     { $ketuaList     = (new RiwayatPengurusModel())->getByTipe('ketua'); }
if (!isset($riwPembinaList)){ $riwPembinaList = (new RiwayatPengurusModel())->getByTipe('pembina'); }
$showRiwayat = count($ketuaList) || count($riwPembinaList);
?>
<?php if ($showRiwayat): ?>
<section class="riwayat-section section-pad" id="riwayat">
  <div class="section-wrap">
    <div class="eyebrow" data-reveal><span class="eyebrow-bar"></span>Sejarah Kepemimpinan</div>
    <h2 class="section-title" data-reveal data-delay="1">Riwayat Ketua &amp; Pembina</h2>
    <p class="section-desc" data-reveal data-delay="2">Mereka yang telah memimpin dan membimbing organisasi dari periode ke periode.</p>

    <?php if (count($ketuaList)): ?>
    <div class="riwayat-group" data-reveal data-delay="2">
      <div class="riwayat-group-head"><span class="riwayat-badge riwayat-badge--ketua">Ketua Organisasi</span><div class="riwayat-group-line"></div></div>
      <div class="riwayat-cards">
        <?php foreach ($ketuaList as $idx => $k): $isFirst = ($idx === 0); ?>
        <div class="riwayat-card <?= $isFirst ? 'riwayat-card--current' : '' ?>">
          <?php if ($isFirst): ?><div class="riwayat-current-badge">Terkini</div><?php endif; ?>
          <div class="riwayat-card-foto">
            <?php if (!empty($k['foto'])): ?>
              <img src="<?= UPLOAD_URL . '/' . htmlspecialchars($k['foto']) ?>" alt="<?= htmlspecialchars($k['nama']) ?>" loading="lazy">
            <?php else: ?>
              <div class="riwayat-foto-ph"><?= strtoupper(mb_substr($k['nama'], 0, 2)) ?></div>
            <?php endif; ?>
          </div>
          <div>
            <div class="riwayat-card-name"><?= htmlspecialchars($k['nama']) ?></div>
            <div class="riwayat-card-jabatan"><?= htmlspecialchars($k['jabatan']) ?></div>
            <div class="riwayat-card-periode"><i class="ti ti-calendar"></i> <?= htmlspecialchars($k['periode']) ?></div>
            <?php if (!empty($k['catatan'])): ?><div class="riwayat-card-catatan"><?= htmlspecialchars($k['catatan']) ?></div><?php endif; ?>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>

    <?php if (count($riwPembinaList)): ?>
    <div class="riwayat-group" data-reveal data-delay="3">
      <div class="riwayat-group-head"><span class="riwayat-badge riwayat-badge--pembina">Guru Pembina</span><div class="riwayat-group-line"></div></div>
      <div class="riwayat-cards">
        <?php foreach ($riwPembinaList as $idx => $p): $isFirst = ($idx === 0); ?>
        <div class="riwayat-card <?= $isFirst ? 'riwayat-card--current' : '' ?> riwayat-card--pembina">
          <?php if ($isFirst): ?><div class="riwayat-current-badge riwayat-current-badge--pembina">Terkini</div><?php endif; ?>
          <div class="riwayat-card-foto">
            <?php if (!empty($p['foto'])): ?>
              <img src="<?= UPLOAD_URL . '/' . htmlspecialchars($p['foto']) ?>" alt="<?= htmlspecialchars($p['nama']) ?>" loading="lazy">
            <?php else: ?>
              <div class="riwayat-foto-ph riwayat-foto-ph--pembina"><?= strtoupper(mb_substr($p['nama'], 0, 2)) ?></div>
            <?php endif; ?>
          </div>
          <div>
            <div class="riwayat-card-name"><?= htmlspecialchars($p['nama']) ?></div>
            <div class="riwayat-card-jabatan riwayat-jabatan--pembina"><?= htmlspecialchars($p['jabatan']) ?></div>
            <div class="riwayat-card-periode"><i class="ti ti-calendar"></i> <?= htmlspecialchars($p['periode']) ?></div>
            <?php if (!empty($p['catatan'])): ?><div class="riwayat-card-catatan"><?= htmlspecialchars($p['catatan']) ?></div><?php endif; ?>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>
  </div>
</section>
<div class="section-divider"></div>
<?php endif; ?>

<!-- ══ FEATURES ══ -->
<?php
$featIcons = ['ti-users', 'ti-calendar-event', 'ti-file-text', 'ti-user-circle', 'ti-shield-check', 'ti-presentation'];
?>
<section class="features-section section-pad" id="features">
  <div class="section-wrap">
    <div class="eyebrow" data-reveal><span class="eyebrow-bar"></span>Platform Digital</div>
    <h2 class="section-title" data-reveal data-delay="1">Apa yang Kami Sediakan</h2>
    <p class="section-desc" data-reveal data-delay="2">Sistem manajemen organisasi berbasis web yang memudahkan pengelolaan anggota, kegiatan, dan administrasi secara terpusat dan efisien.</p>

    <div class="features-grid">
      <?php for ($i = 1; $i <= 6; $i++):
        $idx   = $i - 1;
        $delay = ($idx % 3) + 1;
        $title = $sr("feature_{$i}_title");
        $desc  = $sr("feature_{$i}_desc");
        if (!$title && !$desc) continue;
      ?>
      <div class="feat-card" data-reveal data-delay="<?= $delay ?>">
        <div class="feat-icon"><i class="ti <?= $featIcons[$idx] ?? 'ti-star' ?>"></i></div>
        <h4><?= htmlspecialchars($title) ?></h4>
        <p><?= htmlspecialchars($desc) ?></p>
        <span class="feat-bg-num" aria-hidden="true"><?= str_pad($i, 2, '0', STR_PAD_LEFT) ?></span>
      </div>
      <?php endfor; ?>
    </div>
  </div>
</section>

<div class="section-divider"></div>

<!-- ══ PROGRAMS ══ -->
<section class="programs-section section-pad" id="programs">
  <div class="section-wrap">
    <div class="eyebrow" data-reveal><span class="eyebrow-bar"></span>Program</div>
    <h2 class="section-title" data-reveal data-delay="1">Kegiatan Unggulan</h2>
    <p class="section-desc" data-reveal data-delay="2">Program rutin dan unggulan yang dirancang untuk memaksimalkan potensi setiap anggota.</p>

    <div class="programs-grid">
      <?php for ($i = 1; $i <= 4; $i++):
        $title = $sr("program_{$i}_title");
        $desc  = $sr("program_{$i}_desc");
        $tag   = $sr("program_{$i}_tag");
        if (!$title) continue;
        $delay = ($i % 2) + 1;
      ?>
      <div class="prog-card" data-reveal data-delay="<?= $delay ?>">
        <span class="prog-num" aria-hidden="true"><?= str_pad($i, 2, '0', STR_PAD_LEFT) ?></span>
        <div>
          <h3><?= htmlspecialchars($title) ?></h3>
          <p><?= htmlspecialchars($desc) ?></p>
          <?php if ($tag): ?>
          <span class="prog-tag"><i class="ti ti-point-filled"></i> <?= htmlspecialchars($tag) ?></span>
          <?php endif; ?>
        </div>
      </div>
      <?php endfor; ?>
    </div>
  </div>
</section>

<div class="section-divider"></div>

<!-- ══ GALLERY (CAROUSEL 3 KOLOM, AUTO-SLIDE 3 DETIK) ══ -->
<section class="gallery-section section-pad" id="gallery">
  <div class="section-wrap">
    <div class="eyebrow" data-reveal><span class="eyebrow-bar"></span>Galeri</div>
    <h2 class="section-title" data-reveal data-delay="1">Momen Kegiatan</h2>
    <p class="section-desc" data-reveal data-delay="2">Dokumentasi kegiatan dan prestasi organisasi kami. Klik foto untuk memperbesar, atau jelajahi seluruh galeri kami.</p>

    <div data-reveal data-delay="2">
      <div class="gallery-carousel-viewport">
        <div class="gallery-carousel-track" id="gallery-track">
          <?php for ($i = 1; $i <= 6; $i++):
            $img    = $sr("gallery_img_{$i}");
            $label  = $s("gallery_label_{$i}", "Kegiatan " . $i);
            $imgSrc = $img ? (UPLOAD_URL . '/' . htmlspecialchars($img)) : htmlspecialchars($galleryFallbackImgs[($i - 1) % count($galleryFallbackImgs)]);
          ?>
          <div class="gallery-slide">
            <div class="gallery-card" data-lightbox="<?= $imgSrc ?>" data-caption="<?= $label ?>">
              <img src="<?= $imgSrc ?>" alt="<?= $label ?> - COM SMKN 2 Pinrang" loading="lazy">
              <div class="gallery-overlay">
                <span class="gallery-overlay-text"><?= $label ?></span>
                <span class="gallery-zoom-hint"><i class="ti ti-zoom-in"></i></span>
              </div>
            </div>
          </div>
          <?php endfor; ?>
        </div>
      </div>

      <div class="gallery-carousel-controls" aria-label="Kontrol galeri">
        <button class="gallery-btn" id="gal-prev" aria-label="Sebelumnya"><i class="ti ti-chevron-left"></i></button>
        <button class="gallery-btn" id="gal-next" aria-label="Berikutnya"><i class="ti ti-chevron-right"></i></button>
        <div class="gallery-dots" id="gal-dots" role="tablist"></div>
      </div>

      <div class="gallery-more-wrap">
        <a href="<?= BASE_URL ?>/galeri" class="btn-primary">
          <i class="ti ti-photo"></i> Lihat Semua Galeri
        </a>
      </div>
    </div>
  </div>
</section>

<div class="lightbox-overlay" id="lightbox">
  <div class="lightbox-img-wrap">
    <button class="lightbox-close" id="lightbox-close" aria-label="Tutup"><i class="ti ti-x"></i></button>
    <img id="lightbox-img" src="" alt="">
    <div class="lightbox-caption" id="lightbox-caption"></div>
  </div>
</div>

<div class="section-divider"></div>

<!-- ══ BERITA ══ -->
<section class="berita-section section-pad" id="berita">
  <div class="section-wrap">
    <div class="eyebrow" data-reveal><span class="eyebrow-bar"></span>Informasi</div>
    <h2 class="section-title" data-reveal data-delay="1">Berita &amp; Kegiatan Terbaru</h2>
    <p class="section-desc" data-reveal data-delay="2">Ikuti perkembangan dan kabar terkini seputar organisasi kami.</p>

    <?php if (!empty($beritaList)): ?>
    <div class="berita-grid">
      <?php foreach ($beritaList as $bIdx => $b): ?>
      <a href="<?= BASE_URL ?>/berita/<?= htmlspecialchars($b['slug'] ?? $b['id']) ?>" class="berita-card" data-reveal data-delay="<?= ($bIdx % 3) + 1 ?>">
        <div class="berita-card-img">
          <?php if (!empty($b['thumbnail'])): ?>
            <img src="<?= UPLOAD_URL . '/' . htmlspecialchars($b['thumbnail']) ?>" alt="<?= htmlspecialchars($b['judul']) ?>" loading="lazy">
          <?php else: ?>
            <img src="<?= htmlspecialchars($aboutFallbackImg) ?>" alt="<?= htmlspecialchars($b['judul']) ?>" loading="lazy">
          <?php endif; ?>
        </div>
        <div class="berita-card-body">
          <?php if (!empty($b['kategori_nama'])): ?>
          <span class="berita-card-tag"><?= htmlspecialchars($b['kategori_nama']) ?></span>
          <?php endif; ?>
          <h3><?= htmlspecialchars($b['judul']) ?></h3>
          <p><?= htmlspecialchars(mb_strimwidth(strip_tags($b['ringkasan'] ?? $b['konten'] ?? ''), 0, 110, '…')) ?></p>
          <?php if (!empty($b['created_at'])): ?>
          <span class="berita-card-date"><i class="ti ti-calendar"></i> <?= date('d M Y', strtotime($b['created_at'])) ?></span>
          <?php endif; ?>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
    <?php else: ?>
    <div class="empty-berita" data-reveal data-delay="2">
      Belum ada berita yang dipublikasikan saat ini. Nantikan kabar terbaru dari kami!
    </div>
    <?php endif; ?>

    <div class="berita-more-wrap" data-reveal data-delay="3">
      <a href="<?= BASE_URL ?>/berita" class="btn-primary">
        <i class="ti ti-news"></i> Lihat Semua Berita
      </a>
    </div>
  </div>
</section>

<div class="section-divider"></div>

<!-- ══ TESTIMONIALS ══ -->
<section class="carousel-section section-pad">
  <div class="section-wrap">
    <div class="eyebrow" data-reveal><span class="eyebrow-bar"></span>Testimoni</div>
    <h2 class="section-title" data-reveal data-delay="1">Apa Kata Anggota Kami</h2>
    <p class="section-desc" data-reveal data-delay="2">Pengalaman nyata dari anggota aktif organisasi.</p>

    <div style="margin-top:1.8rem" data-reveal data-delay="2">
      <div class="carousel-viewport">
        <div class="carousel-track" id="carousel-track">
          <?php for ($i = 1; $i <= 5; $i++):
            $quote = $sr("testi_{$i}_quote");
            $name  = $sr("testi_{$i}_name");
            $role  = $sr("testi_{$i}_role");
            if (!$quote || !$name) continue;
          ?>
          <div class="carousel-slide">
            <div class="test-card">
              <div class="test-stars" aria-label="5 bintang">
                <?php for ($j = 0; $j < 5; $j++): ?><i class="ti ti-star-filled"></i><?php endfor; ?>
              </div>
              <p class="test-quote">"<?= htmlspecialchars($quote) ?>"</p>
              <div class="test-author">
                <div class="test-avatar" aria-hidden="true"><?= strtoupper(mb_substr($name, 0, 2)) ?></div>
                <div>
                  <div class="test-name"><?= htmlspecialchars($name) ?></div>
                  <div class="test-role"><?= htmlspecialchars($role) ?></div>
                </div>
              </div>
            </div>
          </div>
          <?php endfor; ?>
        </div>
      </div>

      <div class="carousel-controls" aria-label="Kontrol carousel">
        <button class="carousel-btn" id="car-prev" aria-label="Sebelumnya"><i class="ti ti-chevron-left"></i></button>
        <button class="carousel-btn" id="car-next" aria-label="Berikutnya"><i class="ti ti-chevron-right"></i></button>
        <div class="carousel-dots" id="car-dots" role="tablist"></div>
      </div>
    </div>
  </div>
</section>

<div class="section-divider"></div>

<!-- ══ CTA ══ -->
<section class="cta-section section-pad">
  <div class="section-wrap">
    <div class="cta-box" data-reveal>
      <div>
        <h2><?= $s('cta_title', 'Siap Bergabung Bersama Kami?') ?></h2>
        <p><?= $s('cta_desc', 'Daftarkan diri kamu melalui program Penerimaan Anggota Baru dan jadilah bagian dari keluarga besar organisasi kami.') ?></p>
      </div>
      <div class="cta-actions">
        <a href="<?= BASE_URL ?>/pab" class="btn-primary"><i class="ti ti-user-plus"></i> Daftar Sekarang</a>
        <?php if (empty($_SESSION['user_id'])): ?>
        <a href="<?= BASE_URL ?>/login" class="btn-outline btn-outline--light">Sudah Anggota? Login</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<div class="section-divider"></div>

<!-- ══ CONTACT (kartu di kiri, peta di kanan) ══ -->
<section class="contact-section section-pad" id="contact">
  <div class="section-wrap">
    <div class="eyebrow" data-reveal><span class="eyebrow-bar"></span>Kontak</div>
    <h2 class="section-title" data-reveal data-delay="1">Hubungi Kami</h2>

    <?php
      $mapsQuery = $sr('maps_query') ?: ($sr('contact_address') ?: 'SMK Negeri 2 Pinrang');
      $mapsEmbed = 'https://www.google.com/maps?q=' . urlencode($mapsQuery) . '&output=embed';
      $mapsLink  = 'https://www.google.com/maps/search/?api=1&query=' . urlencode($mapsQuery);

      // Instagram: field admin bisa diisi username saja atau URL lengkap
      $igHandleRaw   = $sr('contact_instagram') ?: 'com_smakdapinrang';
      $igHandleClean = ltrim(trim($igHandleRaw), '@');
      $igUrl         = (stripos($igHandleClean, 'http') === 0) ? $igHandleClean : ('https://instagram.com/' . $igHandleClean);
      // Ambil username saja untuk ditampilkan (buang domain kalau admin isi URL penuh)
      $igDisplay = $igHandleClean;
      if (stripos($igHandleClean, 'instagram.com') !== false) {
          $igDisplay = trim(parse_url($igHandleClean, PHP_URL_PATH) ?? '', '/');
      }
    ?>
    <div class="contact-layout">

      <!-- Kolom kiri: kartu kontak -->
      <div class="contact-cards-col">
        <?php if ($sr('contact_email')): ?>
        <a href="mailto:<?= $s('contact_email') ?>" class="contact-card" data-reveal data-delay="1">
          <div class="contact-icon"><i class="ti ti-mail"></i></div>
          <div>
            <div class="contact-label">Email</div>
            <div class="contact-val"><?= $s('contact_email') ?></div>
          </div>
        </a>
        <?php endif; ?>

        <?php if ($sr('contact_phone')): ?>
        <a href="https://wa.me/<?= preg_replace('/\D/', '', $sr('contact_phone')) ?>" class="contact-card" data-reveal data-delay="2" target="_blank" rel="noopener noreferrer">
          <div class="contact-icon"><i class="ti ti-brand-whatsapp"></i></div>
          <div>
            <div class="contact-label">WhatsApp / Telepon</div>
            <div class="contact-val"><?= $s('contact_phone') ?></div>
          </div>
        </a>
        <?php endif; ?>

        <a href="<?= htmlspecialchars($igUrl) ?>" class="contact-card" data-reveal data-delay="3" target="_blank" rel="noopener noreferrer">
          <div class="contact-icon"><i class="ti ti-brand-instagram"></i></div>
          <div>
            <div class="contact-label">Instagram</div>
            <div class="contact-val">@<?= htmlspecialchars($igDisplay) ?></div>
          </div>
        </a>

        <?php if ($sr('contact_address')): ?>
        <div class="contact-card" data-reveal data-delay="3">
          <div class="contact-icon"><i class="ti ti-map-pin"></i></div>
          <div>
            <div class="contact-label">Alamat</div>
            <div class="contact-val"><?= $s('contact_address') ?></div>
          </div>
        </div>
        <?php endif; ?>

      </div>

      <!-- Kolom kanan: peta -->
      <div class="contact-map-card" data-reveal data-delay="4">
        <div class="contact-map-head">
          <div class="contact-icon"><i class="ti ti-map-2"></i></div>
          <div>
            <div class="contact-label">Peta Lokasi</div>
            <div class="contact-val">SMK Negeri 2 Pinrang</div>
          </div>
        </div>
        <iframe class="contact-map-frame" src="<?= htmlspecialchars($mapsEmbed) ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Peta Lokasi SMK Negeri 2 Pinrang"></iframe>
        <div class="contact-map-foot">
          <span><?= $s('contact_address', 'SMK Negeri 2 Pinrang, Sulawesi Selatan') ?></span>
          <a href="<?= htmlspecialchars($mapsLink) ?>" target="_blank" rel="noopener noreferrer" class="contact-map-link">
            Buka di Google Maps <i class="ti ti-arrow-up-right"></i>
          </a>
        </div>
      </div>

    </div>
  </div>
</section>

</div><!-- /#home-page -->

<script>
(function () {
  'use strict';

  /* ── Hero entrance ── */
  var heroItems = [
    { id: 'hero-badge',    delay: 80  },
    { id: 'hero-title',    delay: 180 },
    { id: 'hero-tagline',  delay: 280 },
    { id: 'hero-desc',     delay: 360 },
    { id: 'hero-sambutan', delay: 440 },
    { id: 'hero-actions',  delay: 530 },
    { id: 'hero-trust',    delay: 610 },
  ];
  heroItems.forEach(function (item) {
    var el = document.getElementById(item.id);
    if (!el) return;
    setTimeout(function () {
      el.style.transition = 'opacity .6s cubic-bezier(.22,1,.36,1), transform .6s cubic-bezier(.22,1,.36,1)';
      el.style.opacity    = '1';
      el.style.transform  = 'none';
    }, item.delay);
  });

  /* ── Hero background carousel (auto-slide, 3 foto) ── */
  (function () {
    var slides = document.querySelectorAll('#hero-bg-carousel .hero-bg-slide');
    var dots   = document.querySelectorAll('#hero-carousel-dots .hero-carousel-dot');
    if (slides.length <= 1) return;

    var cur = 0, timer = null;

    function goTo(idx) {
      cur = ((idx % slides.length) + slides.length) % slides.length;
      slides.forEach(function (sl, i) { sl.classList.toggle('is-active', i === cur); });
      dots.forEach(function (d, i) { d.classList.toggle('active', i === cur); });
    }
    function start() { timer = setInterval(function () { goTo(cur + 1); }, 5000); }
    function stop()  { clearInterval(timer); }

    dots.forEach(function (d, i) {
      d.addEventListener('click', function () { goTo(i); stop(); start(); });
    });

    start();
  })();

  /* ── Scroll reveal ── */
  var revealEls = document.querySelectorAll('[data-reveal]');
  if ('IntersectionObserver' in window) {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (e) {
        if (e.isIntersecting) { e.target.classList.add('_vis'); io.unobserve(e.target); }
      });
    }, { threshold: 0.07 });
    revealEls.forEach(function (el) { io.observe(el); });
  } else {
    revealEls.forEach(function (el) { el.classList.add('_vis'); });
  }

  /* ── Generic carousel factory (dipakai testimoni & galeri) ── */
  function initCarousel(opts) {
    var track  = document.getElementById(opts.trackId);
    var dotsEl = document.getElementById(opts.dotsId);
    var prevBtn = document.getElementById(opts.prevId);
    var nextBtn = document.getElementById(opts.nextId);
    if (!track || !dotsEl) return null;

    var slides = Array.prototype.slice.call(track.querySelectorAll(opts.slideSelector));
    if (!slides.length) return null;

    var cur = 0, timer = null;

    function getPerView() {
      var w = window.innerWidth;
      if (w < 560) return 1;
      if (w < 1024) return 2;
      return 3;
    }

    var perView = getPerView();
    var total   = Math.max(1, Math.ceil(slides.length / perView));

    dotsEl.innerHTML = '';
    for (var i = 0; i < total; i++) {
      (function (idx) {
        var d = document.createElement('button');
        d.className = opts.dotClass + (idx === 0 ? ' active' : '');
        d.setAttribute('aria-label', 'Halaman ' + (idx + 1));
        d.setAttribute('role', 'tab');
        d.addEventListener('click', function () { goTo(idx); stopTimer(); startTimer(); });
        dotsEl.appendChild(d);
      })(i);
    }

    function goTo(p) {
      cur = ((p % total) + total) % total;
      var gap    = opts.gap;
      var slideW = slides[0].offsetWidth + gap;
      track.style.transform = 'translateX(-' + (cur * perView * slideW) + 'px)';
      dotsEl.querySelectorAll('.' + opts.dotClass).forEach(function (d, i) {
        d.classList.toggle('active', i === cur);
        d.setAttribute('aria-selected', i === cur ? 'true' : 'false');
      });
    }

    function startTimer() { timer = setInterval(function () { goTo(cur + 1); }, opts.interval); }
    function stopTimer()  { clearInterval(timer); }

    if (prevBtn) prevBtn.addEventListener('click', function () { goTo(cur - 1); stopTimer(); startTimer(); });
    if (nextBtn) nextBtn.addEventListener('click', function () { goTo(cur + 1); stopTimer(); startTimer(); });

    track.addEventListener('mouseenter', stopTimer);
    track.addEventListener('mouseleave', startTimer);

    var touchStartX = 0;
    track.addEventListener('touchstart', function (e) { touchStartX = e.touches[0].clientX; }, { passive: true });
    track.addEventListener('touchend', function (e) {
      var diff = touchStartX - e.changedTouches[0].clientX;
      if (Math.abs(diff) > 45) { goTo(diff > 0 ? cur + 1 : cur - 1); stopTimer(); startTimer(); }
    }, { passive: true });

    var resizeTimer;
    window.addEventListener('resize', function () {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(function () {
        var np = getPerView();
        if (np !== perView) {
          perView = np;
          total   = Math.max(1, Math.ceil(slides.length / perView));
          cur     = 0;
          goTo(0);
        }
      }, 180);
    });

    startTimer();
    return { goTo: goTo, stopTimer: stopTimer, startTimer: startTimer };
  }

  initCarousel({ trackId: 'carousel-track', dotsId: 'car-dots', prevId: 'car-prev', nextId: 'car-next', slideSelector: '.carousel-slide', dotClass: 'carousel-dot', gap: 16, interval: 3000 });
  initCarousel({ trackId: 'gallery-track', dotsId: 'gal-dots', prevId: 'gal-prev', nextId: 'gal-next', slideSelector: '.gallery-slide', dotClass: 'gallery-dot', gap: 13.6, interval: 3000 });

  /* ── Lightbox galeri ── */
  var lightbox      = document.getElementById('lightbox');
  var lightboxImg    = document.getElementById('lightbox-img');
  var lightboxCap    = document.getElementById('lightbox-caption');
  var lightboxClose  = document.getElementById('lightbox-close');

  document.querySelectorAll('.gallery-card').forEach(function (card) {
    card.addEventListener('click', function () {
      lightboxImg.src = card.getAttribute('data-lightbox');
      lightboxCap.textContent = card.getAttribute('data-caption') || '';
      lightbox.classList.add('is-open');
    });
  });
  function closeLightbox() { lightbox.classList.remove('is-open'); lightboxImg.src = ''; }
  if (lightboxClose) lightboxClose.addEventListener('click', closeLightbox);
  if (lightbox) lightbox.addEventListener('click', function (e) { if (e.target === lightbox) closeLightbox(); });
  document.addEventListener('keydown', function (e) { if (e.key === 'Escape') closeLightbox(); });

})();
</script>