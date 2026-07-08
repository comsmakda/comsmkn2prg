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

/* Fallback CDN background untuk hero jika admin belum upload hero_image sendiri.
   Ringan: dikompresi via query param Unsplash (w=1600, q=60, auto=format). */
$heroFallbackImg = 'https://images.unsplash.com/photo-1743090660977-babf07732432?auto=format&fit=crop&w=1600&q=60';
$heroImgSrc      = $sr('hero_image') ? (UPLOAD_URL . '/' . $s('hero_image')) : $heroFallbackImg;
?>

<!-- ══ SEO: PRIMARY META (PENTING untuk ranking Google) ══ -->
<title>COM SMKN 2 Pinrang – Community Programmer SMK Negeri 2 Pinrang</title>
<meta name="description" content="COM (Community Programmer) SMKN 2 Pinrang – Organisasi siswa bidang IT Software, IT Network, Multimedia, Desain Grafis, IoT, dan Robotik di SMK Negeri 2 Pinrang, Sulawesi Selatan. Daftar PAB sekarang!">
<meta name="keywords" content="COM SMKN 2 Pinrang, Community Programmer SMKN 2 Pinrang, SMK Negeri 2 Pinrang, SMKN 2 Pinrang, SMK 2 Pinrang, organisasi programmer Pinrang, IT SMK Pinrang, komunitas coding Pinrang, PAB COM Pinrang">
<meta name="author" content="COM SMKN 2 Pinrang">
<meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
<meta name="geo.region" content="ID-SN">
<meta name="geo.placename" content="Pinrang, Sulawesi Selatan">
<link rel="canonical" href="<?= htmlspecialchars($og_url) ?>">

<!-- ══ SEO: OPEN GRAPH ══ -->
<meta property="og:type"        content="website">
<meta property="og:url"         content="<?= htmlspecialchars($og_url) ?>">
<meta property="og:title"       content="COM SMKN 2 Pinrang – Community Programmer">
<meta property="og:description" content="<?= $og_description ?>">
<meta property="og:image"       content="<?= htmlspecialchars($og_image) ?>">
<meta property="og:image:width"  content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:alt"   content="COM SMKN 2 Pinrang">
<meta property="og:site_name"   content="COM SMKN 2 Pinrang">
<meta property="og:locale"      content="id_ID">

<!-- ══ SEO: TWITTER CARD ══ -->
<meta name="twitter:card"        content="summary_large_image">
<meta name="twitter:title"       content="COM SMKN 2 Pinrang – Community Programmer">
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

<style>
/* ─── RESET & BASE ───────────────────────────────────────────── */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
:root {
  --ease-out: cubic-bezier(.22,1,.36,1);
  --ease-in-out: cubic-bezier(.65,0,.35,1);
}

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
/* Pola panel-branding design-system.md §6: foto + overlay gradient gelap + teks putih.
   Ini satu-satunya bagian gelap di halaman — sisanya tetap terang & bersih. */
.hero {
  position: relative;
  min-height: calc(100svh - 64px);
  display: flex;
  align-items: center;
  overflow: hidden;
  background: linear-gradient(165deg, var(--c-primary-dk) 0%, #082c3a 100%);
}
.hero-bg-img { position: absolute; inset: 0; z-index: 0; }
.hero-bg-img img {
  width: 100%; height: 100%; object-fit: cover;
  opacity: 0; transition: opacity .6s ease;
}
.hero-bg-img img.is-loaded { opacity: .55; }
.hero-bg-overlay {
  position: absolute; inset: 0; z-index: 0;
  background: linear-gradient(175deg, rgba(8,20,32,.55) 0%, rgba(9,45,64,.72) 45%, rgba(6,30,44,.94) 100%);
}

.hero-inner {
  position: relative; z-index: 1;
  width: 100%; max-width: 1200px;
  margin: 0 auto;
  padding: 4rem 2rem 3.5rem;
  display: grid;
  grid-template-columns: 1fr 400px;
  gap: 3rem;
  align-items: center;
}

.hero-badge {
  display: inline-flex; align-items: center; gap: 8px;
  padding: 5px 14px;
  background: rgba(255,255,255,.09);
  border: 1px solid rgba(255,255,255,.16);
  border-radius: 99px;
  font-size: .68rem; font-weight: 700; color: #7dd3e8;
  letter-spacing: .05em; text-transform: uppercase;
  margin-bottom: 1.2rem;
  opacity: 0;
  transform: translateY(16px);
}
.hero-badge-dot {
  width: 6px; height: 6px; border-radius: 50%;
  background: var(--c-primary-lt);
  animation: pulse-dot 2s ease-in-out infinite;
  flex-shrink: 0;
}
@keyframes pulse-dot {
  0%,100% { opacity:1; box-shadow: 0 0 0 0 rgba(6,182,212,.5); }
  50%      { opacity:.6; box-shadow: 0 0 0 5px rgba(6,182,212,0); }
}
.hero-title {
  font-family: var(--font-display);
  font-size: clamp(2rem, 4.5vw, 3.4rem);
  font-weight: 800;
  color: #fff;
  line-height: 1.09;
  letter-spacing: -.035em;
  margin-bottom: .9rem;
  text-shadow: 0 2px 20px rgba(0,0,0,.2);
}
.hero-title .t-grad {
  color: #67e8f9;
}
.hero-tagline {
  font-size: .76rem; font-weight: 600;
  color: #7dd3e8;
  letter-spacing: .04em;
  margin-bottom: .7rem;
}
.hero-desc {
  font-size: .93rem; color: rgba(255,255,255,.78);
  line-height: 1.85; max-width: 470px;
  margin-bottom: 1.8rem;
}

/* ─── HERO SAMBUTAN BOX ──────────────────────────────────────── */
.hero-sambutan {
  background: rgba(255,255,255,.07);
  border: 1px solid rgba(255,255,255,.14);
  border-radius: var(--radius-md);
  padding: 1rem 1.2rem;
  margin-bottom: 1.7rem;
  position: relative;
  opacity: 0;
  transform: translateY(16px);
}
.hero-sambutan::before {
  content: '';
  position: absolute; top: 0; left: 0;
  width: 3px; height: 100%;
  background: var(--c-primary-lt);
  border-radius: 2px 0 0 2px;
}
.hero-sambutan-label {
  font-size: .64rem; font-weight: 700;
  color: #7dd3e8;
  letter-spacing: .08em;
  text-transform: uppercase;
  margin-bottom: .4rem;
  display: flex; align-items: center; gap: 5px;
}
.hero-sambutan-text {
  font-size: .84rem;
  color: rgba(255,255,255,.82);
  line-height: 1.7;
  font-style: italic;
}

.hero-actions {
  display: flex; gap: 10px; flex-wrap: wrap;
  margin-bottom: 1.8rem;
}

/* ─── BUTTONS — persis §5.3 design-system.md ────────────────── */
.btn-primary {
  display: inline-flex; align-items: center; gap: 7px;
  padding: 13px 24px;
  background: var(--c-primary); color: #fff;
  font-family: var(--font-display); font-weight: 700; font-size: .86rem;
  border-radius: var(--radius-sm); text-decoration: none;
  transition: background .18s, transform .12s, box-shadow .18s;
  box-shadow: 0 8px 22px rgba(14,116,144,.32);
  letter-spacing: -.01em; white-space: nowrap;
}
.btn-primary:hover {
  background: var(--c-primary-lt);
  transform: translateY(-2px);
  box-shadow: 0 12px 28px rgba(6,182,212,.35);
}
.btn-outline {
  display: inline-flex; align-items: center; gap: 7px;
  padding: 12px 22px;
  border: 1.5px solid rgba(255,255,255,.22);
  color: #fff; font-weight: 700; font-size: .85rem;
  border-radius: var(--radius-sm); text-decoration: none;
  background: rgba(255,255,255,.05);
  transition: all .2s; letter-spacing: -.01em; white-space: nowrap;
}
.btn-outline:hover {
  border-color: rgba(255,255,255,.4);
  background: rgba(255,255,255,.1);
  transform: translateY(-2px);
}
/* Varian outline dipakai di atas kanvas terang (bukan hero) */
.btn-outline--light {
  border-color: var(--c-border); color: var(--c-ink); background: var(--c-white);
}
.btn-outline--light:hover { background: #f4f7fa; border-color: #d7dee7; }

/* ─── HERO TRUST ─────────────────────────────────────────────── */
.hero-trust { display: flex; align-items: center; gap: 12px; }
.hero-trust-avs { display: flex; }
.hero-trust-av {
  width: 28px; height: 28px; border-radius: 50%;
  background: var(--c-primary-lt);
  border: 2px solid var(--c-primary-dk);
  display: flex; align-items: center; justify-content: center;
  font-size: .58rem; font-weight: 800; color: #06313d;
  margin-left: -6px;
}
.hero-trust-av:first-child { margin-left: 0; }
.hero-trust-text { font-size: .76rem; color: rgba(255,255,255,.68); }
.hero-trust-text strong { color: #fff; }

/* ─── HERO VISUAL (stats mosaic) — kartu putih bersih di atas foto ─── */
.hero-visual { position: relative; }
.hero-mosaic {
  display: grid;
  grid-template-columns: 1fr 1fr;
  grid-template-rows: auto auto auto;
  gap: .7rem;
}
.hm-card {
  background: rgba(255,255,255,.96);
  border: 1px solid rgba(255,255,255,.5);
  border-radius: var(--radius-md);
  padding: 1.05rem 1.15rem;
  transition: transform .25s var(--ease-out), box-shadow .25s;
  box-shadow: 0 14px 34px -14px rgba(0,0,0,.35);
}
.hm-card:hover { transform: translateY(-3px); box-shadow: 0 18px 40px -14px rgba(0,0,0,.4); }
.hm-card--wide { grid-column: 1 / -1; display: flex; align-items: center; gap: 1rem; }
.hm-icon {
  width: 36px; height: 36px; border-radius: 9px;
  background: rgba(14,116,144,.09);
  display: flex; align-items: center; justify-content: center;
  color: var(--c-primary); flex-shrink: 0;
}
.hm-logo-wrap {
  width: 38px; height: 38px; border-radius: 9px;
  overflow: hidden; flex-shrink: 0;
  background: var(--c-primary);
  display: flex; align-items: center; justify-content: center;
}
.hm-logo-wrap img { width: 100%; height: 100%; object-fit: cover; }
.hm-logo-fallback { font-family: var(--font-display); font-size: .85rem; font-weight: 900; color: #fff; }
.hm-num { font-family: var(--font-display); font-size: 1.65rem; font-weight: 800; color: var(--c-primary-dk); line-height: 1; display: block; margin-bottom: 3px; }
.hm-label { font-size: .64rem; color: var(--c-muted); text-transform: uppercase; letter-spacing: .07em; font-weight: 600; }
.hm-title { font-family: var(--font-display); font-size: .88rem; font-weight: 700; color: var(--c-ink); margin-bottom: .25rem; }
.hm-sub { font-size: .71rem; color: var(--c-muted); line-height: 1.5; }

/* ─── SCROLL CUE ─────────────────────────────────────────────── */
.scroll-cue {
  position: absolute; bottom: 1.8rem; left: 50%;
  transform: translateX(-50%);
  display: flex; flex-direction: column; align-items: center; gap: 6px;
  z-index: 1; pointer-events: none;
}
.scroll-cue-text { font-size: .58rem; font-weight: 600; letter-spacing: .14em; text-transform: uppercase; color: rgba(255,255,255,.55); }
.scroll-cue-track { width: 1px; height: 36px; background: rgba(255,255,255,.2); border-radius: 2px; overflow: hidden; position: relative; }
.scroll-cue-track::after {
  content: ''; position: absolute; top: 0; left: 0; right: 0; height: 50%;
  border-radius: 2px; background: linear-gradient(to bottom, var(--c-primary-lt), transparent);
  animation: track-drop 2s ease-in-out infinite;
}
@keyframes track-drop {
  0%   { transform: translateY(-100%); opacity: 0; }
  30%  { opacity: 1; }
  100% { transform: translateY(200%); opacity: 0; }
}

/* ─── TICKER ─────────────────────────────────────────────────── */
.ticker-section {
  background: var(--c-white);
  border-top: 1px solid var(--c-border);
  border-bottom: 1px solid var(--c-border);
  padding: 11px 0; overflow: hidden;
}
.ticker-track {
  display: flex; gap: 0; width: max-content;
  animation: ticker 32s linear infinite;
}
.ticker-track:hover { animation-play-state: paused; }
.ticker-item {
  display: flex; align-items: center; gap: 8px;
  padding: 0 2rem;
  font-size: .72rem; font-weight: 600;
  color: var(--c-muted); letter-spacing: .03em;
  white-space: nowrap;
}
.ticker-dot { width: 4px; height: 4px; border-radius: 50%; background: var(--c-primary); flex-shrink: 0; }
@keyframes ticker { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }

/* ─── STATS BAR ──────────────────────────────────────────────── */
.stats-section { background: var(--c-page); padding: 2rem 2rem; }
.stats-inner {
  max-width: 1200px; margin: 0 auto;
  display: grid; grid-template-columns: repeat(4, 1fr);
  gap: 1px;
  background: var(--c-border);
  border: 1px solid var(--c-border);
  border-radius: var(--radius-lg);
  overflow: hidden;
}
.stat-cell {
  background: var(--c-white);
  padding: 1.5rem 1rem;
  text-align: center;
  position: relative;
  transition: background .2s;
  cursor: default;
}
.stat-cell:hover { background: #fbfcfe; }
.stat-cell-bar {
  position: absolute; bottom: 0; left: 50%;
  transform: translateX(-50%);
  width: 0; height: 2px;
  background: var(--c-primary);
  transition: width .35s var(--ease-out); border-radius: 2px;
}
.stat-cell:hover .stat-cell-bar { width: 50%; }
.stat-num   { font-family: var(--font-display); font-size: 1.9rem; font-weight: 800; color: var(--c-primary-dk); line-height: 1; display: block; margin-bottom: 5px; letter-spacing: -.03em; }
.stat-label { font-size: .66rem; color: var(--c-muted); text-transform: uppercase; letter-spacing: .07em; font-weight: 600; }

/* ─── SECTION TYPOGRAPHY ─────────────────────────────────────── */
.eyebrow {
  display: inline-flex; align-items: center; gap: 8px;
  font-size: .68rem; font-weight: 700;
  color: var(--c-primary); text-transform: uppercase; letter-spacing: .1em;
  margin-bottom: .75rem;
}
.eyebrow-bar { display: block; width: 20px; height: 1.5px; background: var(--c-primary); border-radius: 2px; }
.section-title {
  font-family: var(--font-display);
  font-size: clamp(1.5rem, 2.8vw, 2.1rem);
  font-weight: 800; color: var(--c-primary-dk);
  line-height: 1.14; letter-spacing: -.03em;
  margin-bottom: .7rem;
}
.section-desc {
  font-size: .88rem; color: var(--c-muted);
  line-height: 1.8; max-width: 500px;
}

/* ─── SECTION WRAPPER ────────────────────────────────────────── */
.section-wrap { max-width: 1200px; margin: 0 auto; padding: 0 2rem; }
.section-pad  { padding: 4.5rem 0; }

/* ─── ABOUT ──────────────────────────────────────────────────── */
.about-section { background: var(--c-white); }
.about-header { max-width: 580px; margin-bottom: 2.5rem; }
.about-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 2.5rem; align-items: start;
}
.about-img-wrap {
  border-radius: var(--radius-lg); overflow: hidden;
  border: 1px solid var(--c-border);
  aspect-ratio: 4/3;
  background: var(--c-page);
  position: relative;
}
.about-img-wrap img { width: 100%; height: 100%; object-fit: cover; display: block; }
.about-img-placeholder {
  width: 100%; height: 100%;
  display: flex; flex-direction: column; align-items: center; justify-content: center; gap: .8rem;
  color: var(--c-muted2);
}
.about-img-placeholder span { font-size: .76rem; }

.vm-stack { display: flex; flex-direction: column; gap: .85rem; }
.vm-item {
  background: var(--c-page);
  border: 1px solid var(--c-border);
  border-radius: var(--radius-md);
  padding: 1.2rem;
  display: flex; gap: .9rem;
  transition: border-color .2s, transform .2s;
}
.vm-item:hover { border-color: rgba(14,116,144,.28); transform: translateX(3px); }
.vm-icon {
  width: 38px; height: 38px; flex-shrink: 0;
  background: rgba(14,116,144,.09);
  border-radius: var(--radius-sm);
  display: flex; align-items: center; justify-content: center;
  color: var(--c-primary);
}
.vm-item h3 { font-family: var(--font-display); font-size: .85rem; font-weight: 700; color: var(--c-ink); margin-bottom: .3rem; }
.vm-item p  { font-size: .8rem; color: var(--c-muted); line-height: 1.72; }

/* ─── SAMBUTAN ── kartu putih bersih, foto persegi ── */
.sambutan-section { background: var(--c-page); }

.sambutan-box {
  background: var(--c-white);
  border: 1px solid var(--c-border);
  border-radius: var(--radius-lg);
  box-shadow: 0 30px 70px -20px rgba(15,23,42,.14), 0 4px 18px rgba(15,23,42,.04);
  padding: 2.4rem;
  display: grid;
  grid-template-columns: 260px 1fr;
  gap: 2.4rem;
  align-items: start;
  margin-top: 2.2rem;
}

.sambutan-photo-col { display: flex; flex-direction: column; align-items: center; gap: 0; }

.sambutan-photo-frame {
  width: 100%;
  aspect-ratio: 3/4;
  border-radius: var(--radius-md) var(--radius-md) 0 0;
  overflow: hidden;
  border: 1px solid var(--c-border);
  border-bottom: none;
  background: var(--c-page);
  position: relative;
  flex-shrink: 0;
}
.sambutan-photo-frame img {
  width: 100%; height: 100%;
  object-fit: cover; object-position: center top;
  display: block;
}
.sambutan-photo-placeholder {
  width: 100%; height: 100%;
  display: flex; flex-direction: column; align-items: center; justify-content: center; gap: .75rem;
  color: var(--c-muted2);
}

.sambutan-identity {
  width: 100%;
  background: #f4f7fa;
  border: 1px solid var(--c-border);
  border-top: none;
  border-radius: 0 0 var(--radius-md) var(--radius-md);
  padding: .9rem 1rem;
  text-align: center;
}

.sambutan-name {
  font-family: var(--font-display);
  font-size: 1rem; font-weight: 800;
  color: var(--c-ink); letter-spacing: -.02em;
  margin-bottom: .25rem;
}
.sambutan-role {
  font-size: .74rem; color: var(--c-primary);
  font-weight: 700; line-height: 1.45;
  margin-bottom: .4rem;
}
.sambutan-masa {
  display: inline-flex; align-items: center; gap: 4px;
  font-size: .64rem; font-weight: 600; color: var(--c-muted);
  background: var(--c-white); border: 1px solid var(--c-border);
  border-radius: 99px; padding: 2px 9px;
}

.sambutan-content-col { display: flex; flex-direction: column; }
.sambutan-content-title {
  font-family: var(--font-display);
  font-size: clamp(1.2rem, 2vw, 1.55rem);
  font-weight: 800; color: var(--c-primary-dk);
  letter-spacing: -.03em;
  margin-bottom: 1.2rem;
  line-height: 1.18;
}
.sambutan-content-title span { color: var(--c-primary); }
.sambutan-quote-icon { margin-bottom: .6rem; display: block; color: rgba(14,116,144,.14); }
.sambutan-content {
  font-size: .91rem; color: var(--c-muted);
  line-height: 1.95;
  font-style: italic;
  padding-left: 1.1rem;
  border-left: 2px solid rgba(14,116,144,.25);
}
.sambutan-sig { display: flex; align-items: center; gap: 10px; margin-top: 1.4rem; }
.sambutan-sig-line { width: 30px; height: 1.5px; background: var(--c-primary); border-radius: 2px; }
.sambutan-sig span { font-family: var(--font-display); font-size: .82rem; font-weight: 700; color: var(--c-primary-dk); }

/* ─── RIWAYAT ────────────────────────────────────────────────── */
.riwayat-section { background: var(--c-white); }
.riwayat-group { margin-top: 2.2rem; }
.riwayat-group + .riwayat-group { margin-top: 2.5rem; }
.riwayat-group-head { display: flex; align-items: center; gap: 12px; margin-bottom: 1.2rem; }
.riwayat-badge {
  display: inline-flex; align-items: center; gap: 5px;
  font-size: .66rem; font-weight: 700;
  letter-spacing: .05em; text-transform: uppercase;
  padding: 4px 12px; border-radius: 99px; white-space: nowrap;
}
/* Ketua = aksen utama. Pembina = netral abu-abu — TIDAK memakai warna aksen kedua,
   supaya tetap satu keluarga warna sesuai design-system.md §9. */
.riwayat-badge--ketua   { background: rgba(14,116,144,.09); border: 1px solid rgba(14,116,144,.24); color: var(--c-primary); }
.riwayat-badge--pembina { background: var(--c-page); border: 1px solid var(--c-border); color: var(--c-muted); }
.riwayat-group-line { flex: 1; height: 1px; background: linear-gradient(to right, var(--c-border), transparent); }

.riwayat-cards { display: grid; grid-template-columns: repeat(auto-fill, minmax(170px, 1fr)); gap: .85rem; }
.riwayat-card {
  background: var(--c-white);
  border: 1px solid var(--c-border);
  border-radius: var(--radius-md);
  padding: 1.3rem 1rem 1rem;
  display: flex; flex-direction: column; align-items: center;
  text-align: center; gap: .8rem;
  position: relative;
  transition: all .25s var(--ease-out);
}
.riwayat-card:hover { border-color: rgba(14,116,144,.28); transform: translateY(-3px); box-shadow: 0 14px 30px -14px rgba(15,23,42,.2); }
.riwayat-current-badge {
  position: absolute; top: 8px; right: 8px;
  font-size: .58rem; font-weight: 700;
  padding: 2px 8px; border-radius: 99px;
  background: rgba(14,116,144,.1); color: var(--c-primary);
  border: 1px solid rgba(14,116,144,.22); letter-spacing: .03em;
}
.riwayat-current-badge--pembina { background: var(--c-page); color: var(--c-muted); border-color: var(--c-border); }
.riwayat-card-foto {
  width: 70px; height: 70px; border-radius: 50%;
  overflow: hidden; border: 2px solid var(--c-border);
  background: var(--c-page);
  transition: border-color .2s;
}
.riwayat-card:hover .riwayat-card-foto { border-color: rgba(14,116,144,.4); }
.riwayat-card-foto img { width: 100%; height: 100%; object-fit: cover; display: block; }
.riwayat-foto-ph {
  width: 100%; height: 100%;
  display: flex; align-items: center; justify-content: center;
  font-family: var(--font-display); font-size: 1.1rem; font-weight: 800; color: #fff;
  background: var(--c-primary);
}
.riwayat-foto-ph--pembina { background: var(--c-muted2); }
.riwayat-card-name    { font-family: var(--font-display); font-size: .85rem; font-weight: 800; color: var(--c-ink); line-height: 1.2; letter-spacing: -.01em; }
.riwayat-card-jabatan { font-size: .68rem; color: var(--c-primary); font-weight: 700; }
.riwayat-jabatan--pembina { color: var(--c-muted); }
.riwayat-card-periode {
  display: inline-flex; align-items: center; justify-content: center; gap: 4px;
  font-size: .62rem; font-weight: 600; color: var(--c-muted);
  background: var(--c-page); border: 1px solid var(--c-border);
  border-radius: 99px; padding: 2px 9px;
}
.riwayat-card-catatan { font-size: .68rem; color: var(--c-muted); line-height: 1.5; }
.riwayat-card--current { border-color: rgba(14,116,144,.2); background: #fbfeff; }
.riwayat-card--current.riwayat-card--pembina { border-color: var(--c-border); background: #fbfcfe; }

/* ─── FEATURES ───────────────────────────────────────────────── */
.features-section { background: var(--c-page); }
.features-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: .85rem; margin-top: 2.2rem; }
.feat-card {
  background: var(--c-white);
  border: 1px solid var(--c-border);
  border-radius: var(--radius-md);
  padding: 1.4rem;
  position: relative; overflow: hidden;
  transition: all .22s var(--ease-out);
}
.feat-card:hover { border-color: rgba(14,116,144,.28); transform: translateY(-3px); box-shadow: 0 14px 30px -14px rgba(15,23,42,.18); }
.feat-bg-num {
  position: absolute; bottom: -8px; right: 10px;
  font-family: var(--font-display); font-size: 3.6rem; font-weight: 800;
  color: rgba(14,116,144,.045); pointer-events: none; line-height: 1;
  user-select: none;
}
.feat-icon {
  width: 40px; height: 40px; border-radius: var(--radius-sm);
  background: rgba(14,116,144,.09);
  display: flex; align-items: center; justify-content: center;
  color: var(--c-primary); margin-bottom: 1rem;
}
.feat-card:hover .feat-icon { background: rgba(14,116,144,.16); }
.feat-card h4 { font-family: var(--font-display); font-size: .9rem; font-weight: 700; color: var(--c-ink); margin-bottom: .45rem; }
.feat-card p  { font-size: .79rem; color: var(--c-muted); line-height: 1.72; position: relative; z-index: 1; }

/* ─── PROGRAMS ───────────────────────────────────────────────── */
.programs-section { background: var(--c-white); }
.programs-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: .85rem; margin-top: 2.2rem; }
.prog-card {
  background: var(--c-page);
  border: 1px solid var(--c-border);
  border-radius: var(--radius-md);
  padding: 1.6rem;
  display: flex; gap: 1.1rem; align-items: flex-start;
  transition: all .22s var(--ease-out);
}
.prog-card:hover { border-color: rgba(14,116,144,.24); transform: translateY(-2px); box-shadow: 0 12px 28px -14px rgba(15,23,42,.16); }
.prog-num { font-family: var(--font-display); font-size: 2rem; font-weight: 800; color: rgba(14,116,144,.18); line-height: 1; flex-shrink: 0; }
.prog-card:hover .prog-num { color: rgba(14,116,144,.32); }
.prog-card h3 { font-family: var(--font-display); font-size: .93rem; font-weight: 700; color: var(--c-ink); margin-bottom: .35rem; }
.prog-card p  { font-size: .8rem; color: var(--c-muted); line-height: 1.7; }
.prog-tag {
  display: inline-flex; align-items: center; gap: 4px;
  margin-top: .7rem;
  font-size: .64rem; font-weight: 600;
  padding: 2px 10px; border-radius: 99px;
  background: rgba(14,116,144,.08); border: 1px solid rgba(14,116,144,.2);
  color: var(--c-primary); letter-spacing: .01em;
}

/* ─── GALLERY ────────────────────────────────────────────────── */
.gallery-section { background: var(--c-page); }
.gallery-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  grid-auto-rows: 185px;
  gap: .75rem;
  margin-top: 2.2rem;
}
.gallery-item {
  border-radius: var(--radius-md); overflow: hidden;
  background: var(--c-white);
  border: 1px solid var(--c-border);
  position: relative;
  transition: transform .25s var(--ease-out), box-shadow .25s;
}
.gallery-item:hover { transform: scale(1.02); box-shadow: 0 16px 36px -14px rgba(15,23,42,.24); z-index: 2; }
.gallery-item:nth-child(1) { grid-column: 1 / 3; }
.gallery-item:nth-child(4) { grid-column: 3 / 5; }
.gallery-item img { width: 100%; height: 100%; object-fit: cover; display: block; }
.gallery-ph {
  width: 100%; height: 100%; min-height: 140px;
  display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 6px;
  color: var(--c-muted2);
}
.gallery-ph span { font-size: .7rem; }
.gallery-overlay {
  position: absolute; inset: 0;
  background: linear-gradient(to top, rgba(9,25,38,.78) 0%, transparent 55%);
  opacity: 0; transition: opacity .25s;
  display: flex; align-items: flex-end; padding: .8rem;
}
.gallery-item:hover .gallery-overlay { opacity: 1; }
.gallery-overlay-text { font-size: .73rem; font-weight: 700; color: #fff; }

/* ─── TESTIMONIALS CAROUSEL ──────────────────────────────────── */
.carousel-section { background: var(--c-white); overflow: hidden; }
.carousel-viewport { overflow: hidden; }
.carousel-track {
  display: flex; gap: 1rem;
  transition: transform .5s var(--ease-in-out);
  will-change: transform;
}
.carousel-slide { flex: 0 0 calc(33.333% - .67rem); min-width: 0; }
.test-card {
  background: var(--c-page);
  border: 1px solid var(--c-border);
  border-radius: var(--radius-md);
  padding: 1.4rem;
  height: 100%;
  transition: border-color .2s;
}
.test-card:hover { border-color: rgba(14,116,144,.25); }
.test-stars { display: flex; gap: 3px; margin-bottom: .8rem; }
.test-stars svg { color: #d9910c; }
.test-quote { font-size: .83rem; color: var(--c-muted); line-height: 1.8; margin-bottom: 1.2rem; font-style: italic; }
.test-author { display: flex; align-items: center; gap: 9px; }
.test-avatar {
  width: 34px; height: 34px; border-radius: 50%;
  background: var(--c-primary);
  display: flex; align-items: center; justify-content: center;
  font-weight: 800; font-size: .7rem; color: #fff; flex-shrink: 0;
}
.test-name { font-size: .81rem; font-weight: 700; color: var(--c-ink); }
.test-role { font-size: .68rem; color: var(--c-muted); margin-top: 1px; }
.carousel-controls { display: flex; align-items: center; gap: 9px; margin-top: 1.5rem; }
.carousel-btn {
  width: 36px; height: 36px;
  background: var(--c-white); border: 1px solid var(--c-border);
  border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center;
  color: var(--c-muted); cursor: pointer; transition: all .2s;
}
.carousel-btn:hover { background: var(--c-primary); color: #fff; border-color: var(--c-primary); }
.carousel-dots { display: flex; gap: 5px; }
.carousel-dot {
  width: 6px; height: 6px; border-radius: 99px;
  background: var(--c-border); transition: all .3s; cursor: pointer; border: none;
}
.carousel-dot.active { width: 18px; background: var(--c-primary); }

/* ─── CTA ────────────────────────────────────────────────────── */
.cta-section { background: var(--c-page); }
.cta-box {
  background: var(--c-white);
  border: 1px solid var(--c-border);
  border-radius: var(--radius-lg);
  box-shadow: 0 30px 70px -20px rgba(15,23,42,.14), 0 4px 18px rgba(15,23,42,.04);
  padding: 2.6rem 2.4rem;
  display: grid;
  grid-template-columns: 1fr auto;
  gap: 2rem; align-items: center;
  position: relative;
  border-top: 3px solid var(--c-primary);
}
.cta-box h2 {
  font-family: var(--font-display);
  font-size: clamp(1.35rem, 2.5vw, 1.8rem);
  font-weight: 800; color: var(--c-primary-dk); letter-spacing: -.03em;
  margin-bottom: .65rem;
}
.cta-box p { font-size: .88rem; color: var(--c-muted); line-height: 1.75; max-width: 500px; }
.cta-actions { display: flex; flex-direction: column; gap: 8px; flex-shrink: 0; }

/* ─── CONTACT ────────────────────────────────────────────────── */
.contact-section { background: var(--c-white); }
.contact-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: .85rem; margin-top: 2rem; }
.contact-card {
  background: var(--c-page);
  border: 1px solid var(--c-border);
  border-radius: var(--radius-md); padding: 1.3rem;
  display: flex; align-items: center; gap: .9rem;
  text-decoration: none;
  transition: all .2s;
}
.contact-card:hover { border-color: rgba(14,116,144,.28); transform: translateY(-2px); box-shadow: 0 10px 26px -14px rgba(15,23,42,.18); }
.contact-icon {
  width: 42px; height: 42px; flex-shrink: 0;
  background: rgba(14,116,144,.09); border-radius: var(--radius-sm);
  display: flex; align-items: center; justify-content: center;
  color: var(--c-primary);
}
.contact-label { font-size: .62rem; color: var(--c-muted2); font-weight: 700; text-transform: uppercase; letter-spacing: .07em; margin-bottom: 3px; }
.contact-val   { font-size: .85rem; color: var(--c-ink); font-weight: 700; }
.contact-card-span { grid-column: 1 / -1; cursor: default; }

/* Kartu peta lokasi */
.contact-map-card {
  grid-column: 1 / -1;
  background: var(--c-page);
  border: 1px solid var(--c-border);
  border-radius: var(--radius-md);
  overflow: hidden;
}
.contact-map-head {
  display: flex; align-items: center; gap: .9rem;
  padding: 1.1rem 1.3rem;
}
.contact-map-frame {
  width: 100%; height: 320px; display: block; border: 0;
  filter: grayscale(.15) contrast(1.02);
}
.contact-map-foot {
  display: flex; align-items: center; justify-content: space-between; gap: 1rem;
  padding: .8rem 1.3rem; flex-wrap: wrap;
  border-top: 1px solid var(--c-border);
  background: var(--c-white);
}
.contact-map-foot span { font-size: .78rem; color: var(--c-muted); }
.contact-map-link {
  display: inline-flex; align-items: center; gap: 5px;
  font-size: .76rem; font-weight: 700; color: var(--c-primary);
  text-decoration: none; white-space: nowrap;
}
.contact-map-link:hover { color: var(--c-primary-dk); }

/* ─── DIVIDER ────────────────────────────────────────────────── */
.section-divider { width: 100%; height: 1px; background: var(--c-border); }

/* ─── RESPONSIVE ─────────────────────────────────────────────── */
@media (max-width: 1024px) {
  .hero-inner      { grid-template-columns: 1fr 340px; gap: 2rem; }
  .features-grid   { grid-template-columns: repeat(2, 1fr); }
  .carousel-slide  { flex: 0 0 calc(50% - .5rem); }
  .gallery-grid    { grid-template-columns: repeat(2, 1fr); grid-auto-rows: 170px; }
  .gallery-item:nth-child(1),
  .gallery-item:nth-child(4) { grid-column: 1 / -1; }
  .sambutan-box    { grid-template-columns: 210px 1fr; gap: 2rem; }
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
  .gallery-grid    { grid-template-columns: 1fr; grid-auto-rows: auto; }
  .gallery-item    { min-height: 170px; }
  .gallery-item:nth-child(1),
  .gallery-item:nth-child(4) { grid-column: 1 / -1; }
  .carousel-slide  { flex: 0 0 100%; }
  .cta-box         { grid-template-columns: 1fr; text-align: center; padding: 2rem 1.5rem; gap: 1.5rem; }
  .cta-actions     { align-items: center; }
  .cta-box p       { margin-left: auto; margin-right: auto; }
  .contact-grid    { grid-template-columns: 1fr; }
  .contact-card-span { grid-column: 1 / -1; }
  .contact-map-frame { height: 240px; }
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
  .gallery-item    { min-height: 155px; }
  .gallery-grid    { gap: .55rem; }
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
  <div class="hero-bg-img">
    <img src="<?= htmlspecialchars($heroImgSrc) ?>" alt="" loading="eager" decoding="async"
         onload="this.classList.add('is-loaded')">
  </div>
  <div class="hero-bg-overlay"></div>

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

      <!-- SAMBUTAN / SELAMAT DATANG -->
      <div class="hero-sambutan" id="hero-sambutan">
        <div class="hero-sambutan-label">
          <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
          Selamat Datang
        </div>
        <div class="hero-sambutan-text">
          <?= htmlspecialchars(
            $settings['hero_sambutan']['value']
            ?? 'Selamat datang di website resmi COM (Community Programmer) SMKN 2 Pinrang — wadah pengembangan siswa di bidang IT Software, IT Network, Multimedia, Desain Grafis, IoT, dan Robotik. Bersama kami, wujudkan potensi terbaikmu!'
          ) ?>
        </div>
      </div>

      <div class="hero-actions" id="hero-actions" style="opacity:0;transform:translateY(16px)">
        <?php if (empty($_SESSION['user_id'])): ?>
          <a href="<?= BASE_URL ?>/pab" class="btn-primary">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Daftar PAB
          </a>
          <a href="<?= BASE_URL ?>/login" class="btn-outline">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
            Masuk Portal
          </a>
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
        <!-- Row 1 -->
        <div class="hm-card">
          <div class="hm-icon"><svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg></div>
          <span class="hm-num"><?= $s('stat_members', '100+') ?></span>
          <span class="hm-label">Anggota Aktif</span>
        </div>
        <div class="hm-card">
          <div class="hm-icon"><svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
          <span class="hm-num"><?= $s('stat_years', '5+') ?></span>
          <span class="hm-label">Tahun Berdiri</span>
        </div>
        <!-- Row 2 wide – dengan logo -->
        <div class="hm-card hm-card--wide">
          <?php if ($sr('org_logo') || $sr('org_photo')): ?>
          <div class="hm-logo-wrap">
            <img src="<?= UPLOAD_URL . '/' . $s($sr('org_logo') ? 'org_logo' : 'org_photo') ?>" alt="Logo COM">
          </div>
          <?php else: ?>
          <div class="hm-logo-wrap">
            <span class="hm-logo-fallback">COM</span>
          </div>
          <?php endif; ?>
          <div>
            <div class="hm-title">Community Programmer</div>
            <div class="hm-sub">COM · SMKN 2 Pinrang — Platform Digital Organisasi Siswa</div>
          </div>
        </div>
        <!-- Row 3 -->
        <div class="hm-card">
          <div class="hm-icon"><svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg></div>
          <span class="hm-num"><?= $s('stat_events', '50+') ?></span>
          <span class="hm-label">Kegiatan</span>
        </div>
        <div class="hm-card">
          <div class="hm-icon"><svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg></div>
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
    <span class="ticker-item">
      <span class="ticker-dot"></span>
      <?= htmlspecialchars($item) ?>
    </span>
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
          <div class="about-img-placeholder">
            <svg width="40" height="40" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
            <span>Foto Organisasi</span>
          </div>
        <?php endif; ?>
      </div>

      <div class="vm-stack" data-reveal data-delay="2">
        <div class="vm-item">
          <div class="vm-icon"><svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"/></svg></div>
          <div>
            <h3>Visi</h3>
            <p><?= nl2br($s('org_vision', 'Menjadi organisasi siswa yang unggul, berdedikasi, dan mampu mencetak generasi pemimpin masa depan yang berintegritas dan kompeten di bidang teknologi.')) ?></p>
          </div>
        </div>
        <div class="vm-item">
          <div class="vm-icon"><svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg></div>
          <div>
            <h3>Misi</h3>
            <p><?= nl2br($s('org_mission', 'Membina anggota secara aktif, menyelenggarakan kegiatan edukatif dan inovatif, serta membangun sinergi positif di lingkungan sekolah maupun masyarakat luas.')) ?></p>
          </div>
        </div>
        <div class="vm-item">
          <div class="vm-icon"><svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
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
    <div class="eyebrow" data-reveal>
      <span class="eyebrow-bar"></span>
      <?= htmlspecialchars($settings['sambutan_eyebrow']['value'] ?? 'Sambutan Pembina') ?>
    </div>
    <h2 class="section-title" data-reveal data-delay="1">Kata-Kata dari Pembina</h2>

    <div class="sambutan-box" data-reveal data-delay="2">

      <!-- Kolom kiri: foto persegi + identitas di bawah foto -->
      <div class="sambutan-photo-col">
        <?php $pembinaFoto = $settings['pembina_foto']['value'] ?? ''; ?>
        <div class="sambutan-photo-frame">
          <?php if ($pembinaFoto): ?>
            <img src="<?= UPLOAD_URL . '/' . htmlspecialchars($pembinaFoto) ?>"
                 alt="Foto Pembina COM SMKN 2 Pinrang"
                 loading="lazy">
          <?php else: ?>
            <div class="sambutan-photo-placeholder">
              <svg width="48" height="48" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                <circle cx="12" cy="7" r="4"/>
              </svg>
            </div>
          <?php endif; ?>
        </div>
        <!-- Identitas menempel di bawah foto -->
        <div class="sambutan-identity">
          <div class="sambutan-name"><?= htmlspecialchars($settings['pembina_nama']['value'] ?? 'Nama Pembina') ?></div>
          <div class="sambutan-role"><?= htmlspecialchars($settings['pembina_jabatan']['value'] ?? 'Guru Pembina') ?></div>
          <?php if (!empty($settings['pembina_masa']['value'])): ?>
          <div class="sambutan-masa">
            <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            <?= htmlspecialchars($settings['pembina_masa']['value']) ?>
          </div>
          <?php endif; ?>
        </div>
      </div>

      <!-- Kolom kanan: isi sambutan -->
      <div class="sambutan-content-col">
        <div class="sambutan-content-title">
          Sambutan<br><span>Pembina</span>
        </div>
        <svg class="sambutan-quote-icon" width="36" height="36" viewBox="0 0 44 44" fill="none">
          <path d="M8 28c0-5.52 4.48-10 10-10V12C9.4 12 2 19.4 2 28v8h14V28H8zm22 0c0-5.52 4.48-10 10-10V12c-8.6 0-16 7.4-16 16v8h14V28h-8z" fill="currentColor"/>
        </svg>
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
      <div class="riwayat-group-head">
        <span class="riwayat-badge riwayat-badge--ketua">Ketua Organisasi</span>
        <div class="riwayat-group-line"></div>
      </div>
      <div class="riwayat-cards">
        <?php foreach ($ketuaList as $idx => $k):
          $isFirst = ($idx === 0); ?>
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
            <div class="riwayat-card-periode">
              <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
              <?= htmlspecialchars($k['periode']) ?>
            </div>
            <?php if (!empty($k['catatan'])): ?>
            <div class="riwayat-card-catatan"><?= htmlspecialchars($k['catatan']) ?></div>
            <?php endif; ?>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>

    <?php if (count($riwPembinaList)): ?>
    <div class="riwayat-group" data-reveal data-delay="3">
      <div class="riwayat-group-head">
        <span class="riwayat-badge riwayat-badge--pembina">Guru Pembina</span>
        <div class="riwayat-group-line"></div>
      </div>
      <div class="riwayat-cards">
        <?php foreach ($riwPembinaList as $idx => $p):
          $isFirst = ($idx === 0); ?>
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
            <div class="riwayat-card-periode">
              <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
              <?= htmlspecialchars($p['periode']) ?>
            </div>
            <?php if (!empty($p['catatan'])): ?>
            <div class="riwayat-card-catatan"><?= htmlspecialchars($p['catatan']) ?></div>
            <?php endif; ?>
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
$featIcons = [
  '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
  '<rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>',
  '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/>',
  '<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>',
  '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>',
  '<rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/>',
];
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
        <div class="feat-icon">
          <svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><?= $featIcons[$idx] ?? '' ?></svg>
        </div>
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
          <span class="prog-tag">
            <svg width="8" height="8" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3"/></svg>
            <?= htmlspecialchars($tag) ?>
          </span>
          <?php endif; ?>
        </div>
      </div>
      <?php endfor; ?>
    </div>
  </div>
</section>

<div class="section-divider"></div>

<!-- ══ GALLERY ══ -->
<section class="gallery-section section-pad" id="gallery">
  <div class="section-wrap">
    <div class="eyebrow" data-reveal><span class="eyebrow-bar"></span>Galeri</div>
    <h2 class="section-title" data-reveal data-delay="1">Momen Kegiatan</h2>
    <p class="section-desc" data-reveal data-delay="2">Dokumentasi kegiatan dan prestasi organisasi kami.</p>

    <div class="gallery-grid" data-reveal data-delay="2">
      <?php for ($i = 1; $i <= 6; $i++):
        $img   = $sr("gallery_img_{$i}");
        $label = $s("gallery_label_{$i}", "Foto {$i}");
      ?>
      <div class="gallery-item">
        <?php if ($img): ?>
          <img src="<?= UPLOAD_URL . '/' . htmlspecialchars($img) ?>" alt="<?= $label ?> - COM SMKN 2 Pinrang" loading="lazy">
        <?php else: ?>
          <div class="gallery-ph">
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
            <span><?= $label ?></span>
          </div>
        <?php endif; ?>
        <div class="gallery-overlay">
          <span class="gallery-overlay-text"><?= $label ?></span>
        </div>
      </div>
      <?php endfor; ?>
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
                <?php for ($j = 0; $j < 5; $j++): ?>
                <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                <?php endfor; ?>
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
        <button class="carousel-btn" id="car-prev" aria-label="Sebelumnya">
          <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
        </button>
        <button class="carousel-btn" id="car-next" aria-label="Berikutnya">
          <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
        </button>
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
        <a href="<?= BASE_URL ?>/pab" class="btn-primary">
          <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
          Daftar Sekarang
        </a>
        <?php if (empty($_SESSION['user_id'])): ?>
        <a href="<?= BASE_URL ?>/login" class="btn-outline btn-outline--light">Sudah Anggota? Login</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<div class="section-divider"></div>

<!-- ══ CONTACT ══ -->
<section class="contact-section section-pad" id="contact">
  <div class="section-wrap">
    <div class="eyebrow" data-reveal><span class="eyebrow-bar"></span>Kontak</div>
    <h2 class="section-title" data-reveal data-delay="1">Hubungi Kami</h2>

    <div class="contact-grid">
      <?php if ($sr('contact_email')): ?>
      <a href="mailto:<?= $s('contact_email') ?>" class="contact-card" data-reveal data-delay="1">
        <div class="contact-icon"><svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg></div>
        <div>
          <div class="contact-label">Email</div>
          <div class="contact-val"><?= $s('contact_email') ?></div>
        </div>
      </a>
      <?php endif; ?>

      <?php if ($sr('contact_phone')): ?>
      <a href="https://wa.me/<?= preg_replace('/\D/', '', $sr('contact_phone')) ?>" class="contact-card" data-reveal data-delay="2" target="_blank" rel="noopener noreferrer">
        <div class="contact-icon"><svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.4 2 2 0 0 1 3.6 1.21h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.8a16 16 0 0 0 6.29 6.29l.96-.95a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg></div>
        <div>
          <div class="contact-label">WhatsApp / Telepon</div>
          <div class="contact-val"><?= $s('contact_phone') ?></div>
        </div>
      </a>
      <?php endif; ?>

      <?php if ($sr('contact_address')): ?>
      <div class="contact-card contact-card-span" data-reveal data-delay="3">
        <div class="contact-icon"><svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg></div>
        <div>
          <div class="contact-label">Alamat</div>
          <div class="contact-val"><?= $s('contact_address') ?></div>
        </div>
      </div>
      <?php endif; ?>

      <!-- Peta Lokasi SMKN 2 Pinrang -->
      <?php
        $mapsQuery = $sr('maps_query') ?: 'SMK Negeri 2 Pinrang';
        $mapsEmbed = 'https://www.google.com/maps?q=' . urlencode($mapsQuery) . '&output=embed';
        $mapsLink  = 'https://www.google.com/maps/search/?api=1&query=' . urlencode($mapsQuery);
      ?>
      <div class="contact-map-card" data-reveal data-delay="3">
        <div class="contact-map-head">
          <div class="contact-icon"><svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg></div>
          <div>
            <div class="contact-label">Lokasi</div>
            <div class="contact-val">SMK Negeri 2 Pinrang</div>
          </div>
        </div>
        <iframe
          class="contact-map-frame"
          src="<?= htmlspecialchars($mapsEmbed) ?>"
          loading="lazy"
          referrerpolicy="no-referrer-when-downgrade"
          title="Peta Lokasi SMK Negeri 2 Pinrang"></iframe>
        <div class="contact-map-foot">
          <span><?= $s('contact_address', 'SMK Negeri 2 Pinrang, Sulawesi Selatan') ?></span>
          <a href="<?= htmlspecialchars($mapsLink) ?>" target="_blank" rel="noopener noreferrer" class="contact-map-link">
            Buka di Google Maps
            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
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

  /* ── Scroll reveal ── */
  var revealEls = document.querySelectorAll('[data-reveal]');
  if ('IntersectionObserver' in window) {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (e) {
        if (e.isIntersecting) {
          e.target.classList.add('_vis');
          io.unobserve(e.target);
        }
      });
    }, { threshold: 0.07 });
    revealEls.forEach(function (el) { io.observe(el); });
  } else {
    revealEls.forEach(function (el) { el.classList.add('_vis'); });
  }

  /* ── Carousel ── */
  var track  = document.getElementById('carousel-track');
  var dotsEl = document.getElementById('car-dots');
  if (!track || !dotsEl) return;

  var slides = Array.prototype.slice.call(track.querySelectorAll('.carousel-slide'));
  if (!slides.length) return;

  var cur = 0, timer = null;

  function getPerView() {
    var w = window.innerWidth;
    if (w < 560) return 1;
    if (w < 1024) return 2;
    return 3;
  }

  var perView = getPerView();
  var total   = Math.max(1, Math.ceil(slides.length / perView));

  /* Build dots */
  for (var i = 0; i < total; i++) {
    (function (idx) {
      var d = document.createElement('button');
      d.className = 'carousel-dot' + (idx === 0 ? ' active' : '');
      d.setAttribute('aria-label', 'Halaman ' + (idx + 1));
      d.setAttribute('role', 'tab');
      d.addEventListener('click', function () { goTo(idx); stopTimer(); startTimer(); });
      dotsEl.appendChild(d);
    })(i);
  }

  function goTo(p) {
    cur = ((p % total) + total) % total;
    var gap     = 16;
    var slideW  = slides[0].offsetWidth + gap;
    track.style.transform = 'translateX(-' + (cur * perView * slideW) + 'px)';
    dotsEl.querySelectorAll('.carousel-dot').forEach(function (d, i) {
      d.classList.toggle('active', i === cur);
      d.setAttribute('aria-selected', i === cur ? 'true' : 'false');
    });
  }

  function startTimer() { timer = setInterval(function () { goTo(cur + 1); }, 5000); }
  function stopTimer()  { clearInterval(timer); }

  document.getElementById('car-prev').addEventListener('click', function () { goTo(cur - 1); stopTimer(); startTimer(); });
  document.getElementById('car-next').addEventListener('click', function () { goTo(cur + 1); stopTimer(); startTimer(); });

  track.addEventListener('mouseenter', stopTimer);
  track.addEventListener('mouseleave', startTimer);

  var touchStartX = 0;
  track.addEventListener('touchstart', function (e) { touchStartX = e.touches[0].clientX; }, { passive: true });
  track.addEventListener('touchend',   function (e) {
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
})();
</script>