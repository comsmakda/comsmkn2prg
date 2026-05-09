<?php
// app/views/pages/home.php
// Semua konten dikontrol via CMS (settings DB)

$s  = fn(string $k, string $d = '') => htmlspecialchars($settings[$k]['value'] ?? $d);
$sr = fn(string $k, string $d = '') => $settings[$k]['value'] ?? $d;

/* ── Open Graph / Social Preview ── */
$og_title       = htmlspecialchars($settings['org_name']['value'] ?? (defined('APP_NAME') ? APP_NAME : 'COM'));
$og_description = htmlspecialchars(
    $settings['og_description']['value']
    ?? $settings['org_description']['value']
    ?? 'Platform Digital Organisasi Siswa SMKN 2 Pinrang yang modern dan terpadu.'
);

// Prioritas gambar: og_image khusus → org_photo → logo default
if (!empty($settings['og_image']['value'])) {
    $og_image = UPLOAD_URL . '/' . $settings['og_image']['value'];
} elseif (!empty($settings['org_photo']['value'])) {
    $og_image = UPLOAD_URL . '/' . $settings['org_photo']['value'];
} else {
    $og_image = BASE_URL . '/assets/img/og-image.jpg'; // buat file 1200×630px
}

$og_url      = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http')
             . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$og_sitename = $og_title;
?>
<!-- ═══════════════════════════════════════════
     OPEN GRAPH / SOCIAL PREVIEW META TAGS
     Letakkan blok ini di dalam <head> layout utama
     (atau biarkan di sini jika layout sudah meng-include-nya)
═══════════════════════════════════════════ -->
<meta name="description"        content="<?= $og_description ?>">

<!-- Open Graph — WhatsApp, Telegram, Facebook, Discord -->
<meta property="og:type"        content="website">
<meta property="og:url"         content="<?= htmlspecialchars($og_url) ?>">
<meta property="og:title"       content="<?= $og_title ?>">
<meta property="og:description" content="<?= $og_description ?>">
<meta property="og:image"       content="<?= htmlspecialchars($og_image) ?>">
<meta property="og:image:width"  content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:alt"   content="<?= $og_title ?>">
<meta property="og:site_name"   content="<?= $og_sitename ?>">
<meta property="og:locale"      content="id_ID">

<!-- Twitter Card — juga digunakan LinkedIn -->
<meta name="twitter:card"        content="summary_large_image">
<meta name="twitter:title"       content="<?= $og_title ?>">
<meta name="twitter:description" content="<?= $og_description ?>">
<meta name="twitter:image"       content="<?= htmlspecialchars($og_image) ?>">

<!-- Favicon & App Icon -->
<link rel="icon"             type="image/png" href="<?= BASE_URL ?>/assets/img/logo-com.png">
<link rel="apple-touch-icon"                  href="<?= BASE_URL ?>/assets/img/logo-com.png">
<!-- ═══════════════════════════════════════════ -->

<style>
/* ═══════════════════════════════════════════
   RESET & BASE
═══════════════════════════════════════════ */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

/* ═══════════════════════════════════════════
   SCROLL REVEAL
═══════════════════════════════════════════ */
[data-reveal] {
  opacity: 0;
  transform: translateY(24px);
  transition: opacity 0.65s cubic-bezier(.22,1,.36,1), transform 0.65s cubic-bezier(.22,1,.36,1);
}
[data-reveal]._vis { opacity: 1; transform: none; }
[data-reveal][data-delay="1"] { transition-delay: 0.08s; }
[data-reveal][data-delay="2"] { transition-delay: 0.16s; }
[data-reveal][data-delay="3"] { transition-delay: 0.24s; }
[data-reveal][data-delay="4"] { transition-delay: 0.32s; }
[data-reveal][data-delay="5"] { transition-delay: 0.40s; }

/* ═══════════════════════════════════════════
   HERO
═══════════════════════════════════════════ */
.hero {
  position: relative;
  min-height: calc(100svh - 68px);
  display: flex;
  align-items: center;
  overflow: hidden;
  background: var(--c-bg);
}

/* Background layers */
.hero-bg {
  position: absolute;
  inset: 0;
  z-index: 0;
  pointer-events: none;
}
.hero-bg::before {
  content: '';
  position: absolute;
  inset: 0;
  background-image:
    linear-gradient(rgba(14,165,233,0.04) 1px, transparent 1px),
    linear-gradient(90deg, rgba(14,165,233,0.04) 1px, transparent 1px);
  background-size: 64px 64px;
  mask-image: radial-gradient(ellipse 85% 85% at 50% 50%, black 10%, transparent 75%);
}
.hero-bg::after {
  content: '';
  position: absolute;
  inset: 0;
  background:
    radial-gradient(ellipse 65% 50% at 65% 5%, rgba(14,165,233,.10) 0%, transparent 65%),
    radial-gradient(ellipse 45% 40% at 8% 85%, rgba(99,102,241,.07) 0%, transparent 60%);
}
.hero-bg-img {
  position: absolute;
  inset: 0;
}
.hero-bg-img img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  opacity: .15;
}
.hero-orb {
  position: absolute;
  border-radius: 50%;
  pointer-events: none;
}
.hero-orb-1 {
  width: 480px; height: 480px;
  background: radial-gradient(circle, rgba(14,165,233,.07) 0%, transparent 70%);
  top: -140px; right: -100px;
  animation: orb-drift 14s ease-in-out infinite;
}
.hero-orb-2 {
  width: 320px; height: 320px;
  background: radial-gradient(circle, rgba(99,102,241,.06) 0%, transparent 70%);
  bottom: -80px; left: -70px;
  animation: orb-drift 18s ease-in-out infinite reverse;
}
@keyframes orb-drift {
  0%, 100% { transform: translate(0, 0) scale(1); }
  33%       { transform: translate(18px, -18px) scale(1.03); }
  66%       { transform: translate(-14px, 14px) scale(.98); }
}

/* Hero inner layout */
.hero-inner {
  position: relative;
  z-index: 1;
  width: 100%;
  max-width: 1160px;
  margin: 0 auto;
  padding: 5rem 1.5rem 4.5rem;
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 3.5rem;
  align-items: center;
}

/* Hero text */
.hero-badge {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 5px 14px;
  background: rgba(14,165,233,.07);
  border: 1px solid rgba(14,165,233,.2);
  border-radius: 99px;
  font-family: var(--font-mono);
  font-size: .67rem;
  color: var(--c-sky);
  letter-spacing: .07em;
  text-transform: uppercase;
  margin-bottom: 1.4rem;
}
.hero-badge-pulse {
  width: 6px; height: 6px;
  border-radius: 50%;
  background: var(--c-cyan);
  animation: pulse-glow 2s ease-in-out infinite;
  flex-shrink: 0;
}
@keyframes pulse-glow {
  0%, 100% { opacity: 1; box-shadow: 0 0 0 0 rgba(34,211,238,.4); }
  50%       { opacity: .7; box-shadow: 0 0 0 5px rgba(34,211,238,0); }
}
.hero-title {
  font-family: var(--font-display);
  font-size: clamp(2.2rem, 5vw, 3.8rem);
  font-weight: 900;
  color: #fff;
  line-height: 1.08;
  letter-spacing: -.035em;
  margin-bottom: 1rem;
}
.hero-title .t-grad {
  background: linear-gradient(130deg, var(--c-sky-light) 0%, var(--c-indigo) 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}
.hero-tagline {
  font-family: var(--font-mono);
  font-size: .78rem;
  color: var(--c-sky);
  letter-spacing: .04em;
  margin-bottom: .85rem;
}
.hero-desc {
  font-size: .95rem;
  color: var(--c-muted2);
  line-height: 1.85;
  max-width: 460px;
  margin-bottom: 2.2rem;
}

/* CTA Buttons */
.hero-actions {
  display: flex;
  gap: 10px;
  flex-wrap: wrap;
  margin-bottom: 2.2rem;
}
.btn-primary {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 13px 26px;
  background: var(--c-sky);
  color: #fff;
  font-family: var(--font-display);
  font-weight: 700;
  font-size: .88rem;
  border-radius: 11px;
  text-decoration: none;
  transition: all .25s cubic-bezier(.22,1,.36,1);
  box-shadow: 0 4px 24px rgba(14,165,233,.28);
  letter-spacing: -.01em;
  white-space: nowrap;
}
.btn-primary:hover {
  background: var(--c-sky-light);
  transform: translateY(-2px);
  box-shadow: 0 10px 36px rgba(14,165,233,.38);
}
.btn-outline {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 12px 24px;
  border: 1px solid rgba(255,255,255,.14);
  color: var(--c-muted2);
  font-weight: 600;
  font-size: .86rem;
  border-radius: 11px;
  text-decoration: none;
  background: rgba(255,255,255,.03);
  transition: all .25s;
  letter-spacing: -.01em;
  white-space: nowrap;
}
.btn-outline:hover {
  border-color: var(--c-border2);
  color: #fff;
  background: rgba(14,165,233,.06);
  transform: translateY(-2px);
}

/* Hero trust strip */
.hero-trust {
  display: flex;
  align-items: center;
  gap: 14px;
}
.hero-trust-avatars {
  display: flex;
}
.hero-trust-avatar {
  width: 30px; height: 30px;
  border-radius: 50%;
  background: linear-gradient(135deg, var(--c-sky), var(--c-indigo));
  border: 2px solid var(--c-bg);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: .62rem;
  font-weight: 700;
  color: #fff;
  margin-left: -7px;
}
.hero-trust-avatar:first-child { margin-left: 0; }
.hero-trust-text { font-size: .78rem; color: var(--c-muted); }
.hero-trust-text strong { color: var(--c-text); }

/* Hero visual mosaic */
.hero-visual { position: relative; z-index: 1; }
.hero-card-mosaic {
  position: relative;
  height: 400px;
  display: flex;
  align-items: center;
  justify-content: center;
}
.hcard {
  position: absolute;
  background: var(--c-surface2);
  border: 1px solid var(--c-border);
  border-radius: 16px;
  padding: 1.2rem 1.4rem;
  backdrop-filter: blur(12px);
  box-shadow: 0 8px 32px rgba(0,0,0,.36);
}
.hcard-main { width: 210px; top: 50%; left: 50%; transform: translate(-50%,-50%); z-index: 2; }
.hcard-tl   { width: 144px; top: 8%;  left: 0;   animation: float-sm 6s ease-in-out infinite; }
.hcard-tr   { width: 152px; top: 4%;  right: 0;  animation: float-sm 8s ease-in-out infinite reverse; }
.hcard-bl   { width: 150px; bottom: 6%; left: 2%; animation: float-sm 7s ease-in-out infinite 1s; }
.hcard-br   { width: 148px; bottom: 2%; right: 0;  animation: float-sm 9s ease-in-out infinite reverse .5s; }
@keyframes float-sm {
  0%, 100% { transform: translateY(0); }
  50%       { transform: translateY(-9px); }
}
.hcard-num   { font-family: var(--font-display); font-size: 1.85rem; font-weight: 900; color: var(--c-sky); line-height: 1; display: block; margin-bottom: 4px; }
.hcard-label { font-size: .7rem; color: var(--c-muted); text-transform: uppercase; letter-spacing: .07em; }
.hcard-icon  { width: 36px; height: 36px; border-radius: 9px; background: rgba(14,165,233,.1); display: flex; align-items: center; justify-content: center; color: var(--c-sky); margin-bottom: .9rem; }
.hcard-title { font-size: .86rem; font-weight: 700; color: #fff; margin-bottom: .3rem; }
.hcard-sub   { font-size: .74rem; color: var(--c-muted); line-height: 1.55; }

/* Scroll cue */
.scroll-cue {
  position: absolute;
  bottom: 2rem; left: 50%;
  transform: translateX(-50%);
  display: flex; flex-direction: column; align-items: center; gap: 7px;
  z-index: 1; pointer-events: none;
}
.scroll-cue-text { font-family: var(--font-mono); font-size: .58rem; letter-spacing: .15em; text-transform: uppercase; color: var(--c-muted); }
.scroll-cue-track { width: 1.5px; height: 42px; background: var(--c-border); border-radius: 2px; overflow: hidden; position: relative; }
.scroll-cue-track::after {
  content: ''; position: absolute; top: 0; left: 0; right: 0; height: 50%;
  border-radius: 2px; background: linear-gradient(to bottom, var(--c-sky), transparent);
  animation: track-drop 2s ease-in-out infinite;
}
@keyframes track-drop {
  0%   { transform: translateY(-100%); opacity: 0; }
  30%  { opacity: 1; }
  100% { transform: translateY(200%); opacity: 0; }
}

/* ═══════════════════════════════════════════
   TICKER
═══════════════════════════════════════════ */
.ticker-section {
  background: var(--c-surface);
  border-top: 1px solid var(--c-border);
  border-bottom: 1px solid var(--c-border);
  padding: 13px 0;
  overflow: hidden;
}
.ticker-track {
  display: flex;
  gap: 0;
  animation: ticker 30s linear infinite;
  width: max-content;
}
.ticker-track:hover { animation-play-state: paused; }
.ticker-item {
  display: flex; align-items: center; gap: 9px;
  padding: 0 2.2rem;
  font-family: var(--font-mono);
  font-size: .7rem;
  color: var(--c-muted);
  letter-spacing: .07em;
  text-transform: uppercase;
  white-space: nowrap;
}
.ticker-dot { width: 5px; height: 5px; border-radius: 50%; background: var(--c-sky); flex-shrink: 0; }
@keyframes ticker { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }

/* ═══════════════════════════════════════════
   STATS
═══════════════════════════════════════════ */
.stats-section {
  background: var(--c-surface);
  padding: 3rem 1.5rem;
}
.stats-inner {
  max-width: 1160px;
  margin: 0 auto;
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 1px;
  background: var(--c-border);
  border: 1px solid var(--c-border);
  border-radius: 16px;
  overflow: hidden;
}
.stat-cell {
  background: var(--c-surface2);
  padding: 1.75rem 1.25rem;
  text-align: center;
  position: relative;
  transition: background .2s;
}
.stat-cell:hover { background: var(--c-surface3); }
.stat-cell::after {
  content: ''; position: absolute; bottom: 0; left: 50%; transform: translateX(-50%);
  width: 0; height: 2px;
  background: linear-gradient(90deg, var(--c-sky), var(--c-indigo));
  transition: width .4s; border-radius: 2px;
}
.stat-cell:hover::after { width: 55%; }
.stat-num   { font-family: var(--font-display); font-size: 2.2rem; font-weight: 900; color: var(--c-sky); line-height: 1; display: block; margin-bottom: 6px; letter-spacing: -.04em; }
.stat-label { font-family: var(--font-mono); font-size: .66rem; color: var(--c-muted); text-transform: uppercase; letter-spacing: .09em; }

/* ═══════════════════════════════════════════
   SECTION COMMONS
═══════════════════════════════════════════ */
.eyebrow {
  display: inline-flex;
  align-items: center;
  gap: 9px;
  font-family: var(--font-mono);
  font-size: .66rem;
  font-weight: 500;
  color: var(--c-sky);
  text-transform: uppercase;
  letter-spacing: .12em;
  margin-bottom: .9rem;
}
.eyebrow-bar { display: block; width: 24px; height: 1.5px; background: var(--c-sky); border-radius: 2px; }
.section-title {
  font-family: var(--font-display);
  font-size: clamp(1.6rem, 3vw, 2.4rem);
  font-weight: 800;
  color: #fff;
  line-height: 1.12;
  letter-spacing: -.03em;
  margin-bottom: .85rem;
}
.section-desc {
  font-size: .91rem;
  color: var(--c-muted2);
  line-height: 1.85;
  max-width: 480px;
}

/* ═══════════════════════════════════════════
   ABOUT / VISI MISI
═══════════════════════════════════════════ */
.about-section {
  background: var(--c-surface);
  padding: 5.5rem 1.5rem;
}
.about-inner { max-width: 1160px; margin: 0 auto; }
.about-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 3.5rem;
  align-items: center;
  margin-top: 2.8rem;
}
.about-left img {
  width: 100%;
  border-radius: 16px;
  border: 1px solid var(--c-border);
  aspect-ratio: 4 / 3;
  object-fit: cover;
  display: block;
}
.about-img-placeholder {
  width: 100%;
  aspect-ratio: 4 / 3;
  background: var(--c-surface2);
  border: 1px solid var(--c-border);
  border-radius: 16px;
  display: flex; flex-direction: column; align-items: center; justify-content: center; gap: .9rem;
  color: var(--c-muted);
  position: relative;
  overflow: hidden;
}
.about-img-placeholder::before {
  content: ''; position: absolute; inset: 0;
  background: radial-gradient(ellipse 60% 60% at 30% 40%, rgba(14,165,233,.06) 0%, transparent 70%);
}
.about-img-placeholder svg,
.about-img-placeholder span { position: relative; z-index: 1; }
.about-img-placeholder span { font-size: .8rem; }

.vm-stack { display: flex; flex-direction: column; gap: 1rem; }
.vm-item {
  background: var(--c-surface3);
  border: 1px solid var(--c-border);
  border-radius: 13px;
  padding: 1.35rem;
  display: flex; gap: 1rem;
  transition: border-color .25s, transform .25s;
}
.vm-item:hover { border-color: var(--c-border2); transform: translateX(4px); }
.vm-item-icon {
  width: 42px; height: 42px;
  flex-shrink: 0;
  background: rgba(14,165,233,.09);
  border-radius: 10px;
  display: flex; align-items: center; justify-content: center;
  color: var(--c-sky);
}
.vm-item h3 { font-family: var(--font-display); font-size: .88rem; font-weight: 700; color: #fff; margin-bottom: .35rem; }
.vm-item p  { font-size: .81rem; color: var(--c-muted2); line-height: 1.78; }

/* ═══════════════════════════════════════════
   FEATURES
═══════════════════════════════════════════ */
.features-section {
  background: var(--c-bg);
  padding: 5.5rem 1.5rem;
}
.features-inner { max-width: 1160px; margin: 0 auto; }
.features-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 1rem;
  margin-top: 2.8rem;
}
.feat-card {
  background: var(--c-surface2);
  border: 1px solid var(--c-border);
  border-radius: 15px;
  padding: 1.6rem;
  position: relative;
  overflow: hidden;
  transition: all .3s cubic-bezier(.22,1,.36,1);
}
.feat-card::before {
  content: ''; position: absolute; top: 0; left: 0; right: 0;
  height: 1.5px;
  background: linear-gradient(90deg, var(--c-sky) 0%, var(--c-indigo) 100%);
  opacity: 0; transition: opacity .3s;
}
.feat-card:hover { border-color: rgba(14,165,233,.22); transform: translateY(-4px); box-shadow: 0 14px 44px rgba(0,0,0,.28); }
.feat-card:hover::before { opacity: 1; }
.feat-card-bg-num {
  position: absolute; bottom: -10px; right: 12px;
  font-family: var(--font-display); font-size: 4.5rem; font-weight: 900;
  color: rgba(14,165,233,.04); pointer-events: none; line-height: 1;
  transition: color .3s; user-select: none;
}
.feat-card:hover .feat-card-bg-num { color: rgba(14,165,233,.08); }
.feat-icon {
  width: 44px; height: 44px;
  border-radius: 11px;
  background: rgba(14,165,233,.09);
  display: flex; align-items: center; justify-content: center;
  color: var(--c-sky);
  margin-bottom: 1.1rem;
  transition: background .25s;
}
.feat-card:hover .feat-icon { background: rgba(14,165,233,.16); }
.feat-card h4 { font-family: var(--font-display); font-size: .93rem; font-weight: 700; color: #fff; margin-bottom: .5rem; }
.feat-card p  { font-size: .8rem; color: var(--c-muted2); line-height: 1.78; position: relative; z-index: 1; }

/* ═══════════════════════════════════════════
   PROGRAMS
═══════════════════════════════════════════ */
.programs-section {
  background: var(--c-surface);
  padding: 5.5rem 1.5rem;
}
.programs-inner { max-width: 1160px; margin: 0 auto; }
.programs-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 1rem;
  margin-top: 2.8rem;
}
.prog-card {
  background: var(--c-surface2);
  border: 1px solid var(--c-border);
  border-radius: 16px;
  padding: 1.8rem;
  display: grid;
  grid-template-columns: auto 1fr;
  gap: 1.25rem;
  align-items: start;
  transition: all .28s;
  position: relative;
  overflow: hidden;
}
.prog-card::after {
  content: ''; position: absolute; inset: 0;
  background: radial-gradient(ellipse 60% 60% at 0% 0%, rgba(14,165,233,.04) 0%, transparent 70%);
  opacity: 0; transition: opacity .3s;
}
.prog-card:hover { border-color: rgba(14,165,233,.2); transform: translateY(-3px); }
.prog-card:hover::after { opacity: 1; }
.prog-num { font-family: var(--font-display); font-size: 2.6rem; font-weight: 900; color: rgba(14,165,233,.12); line-height: 1; transition: color .3s; }
.prog-card:hover .prog-num { color: rgba(14,165,233,.22); }
.prog-card h3 { font-family: var(--font-display); font-size: .97rem; font-weight: 700; color: #fff; margin-bottom: .4rem; }
.prog-card p  { font-size: .81rem; color: var(--c-muted2); line-height: 1.76; }
.prog-tag {
  display: inline-flex; align-items: center; gap: 5px;
  margin-top: .8rem;
  font-family: var(--font-mono); font-size: .65rem; font-weight: 500;
  padding: 3px 11px;
  border-radius: 99px;
  background: rgba(14,165,233,.07);
  border: 1px solid rgba(14,165,233,.18);
  color: var(--c-sky);
  letter-spacing: .03em;
}

/* ═══════════════════════════════════════════
   GALLERY
═══════════════════════════════════════════ */
.gallery-section {
  background: var(--c-bg);
  padding: 5.5rem 1.5rem;
}
.gallery-inner { max-width: 1160px; margin: 0 auto; }
.gallery-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  grid-template-rows: repeat(2, 200px);
  gap: .85rem;
  margin-top: 2.8rem;
}
.gallery-item {
  border-radius: 13px;
  overflow: hidden;
  background: var(--c-surface2);
  border: 1px solid var(--c-border);
  position: relative;
  transition: transform .3s, box-shadow .3s;
}
.gallery-item:hover { transform: scale(1.025); box-shadow: 0 14px 44px rgba(0,0,0,.48); z-index: 2; }
.gallery-item:nth-child(1) { grid-column: 1 / 3; }
.gallery-item:nth-child(4) { grid-column: 3 / 5; }
.gallery-item img { width: 100%; height: 100%; object-fit: cover; display: block; }
.gallery-placeholder {
  width: 100%; height: 100%; min-height: 150px;
  display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 7px;
  color: var(--c-muted);
}
.gallery-placeholder svg { opacity: .35; }
.gallery-placeholder span { font-size: .73rem; opacity: .5; }
.gallery-overlay {
  position: absolute; inset: 0;
  background: linear-gradient(to top, rgba(4,8,15,.72) 0%, transparent 55%);
  opacity: 0; transition: opacity .3s;
  display: flex; align-items: flex-end;
  padding: .9rem;
}
.gallery-item:hover .gallery-overlay { opacity: 1; }
.gallery-overlay-text { font-size: .76rem; font-weight: 600; color: #fff; }

/* ═══════════════════════════════════════════
   TESTIMONIALS CAROUSEL
═══════════════════════════════════════════ */
.carousel-section {
  background: var(--c-surface);
  padding: 5.5rem 0;
  overflow: hidden;
}
.carousel-inner { max-width: 1160px; margin: 0 auto; padding: 0 1.5rem; }
.carousel-header { margin-bottom: 2.8rem; }
.carousel-viewport { overflow: hidden; }
.carousel-track {
  display: flex;
  gap: 1.1rem;
  transition: transform .5s cubic-bezier(.22,1,.36,1);
  will-change: transform;
}
.carousel-slide {
  flex: 0 0 calc(33.333% - .75rem);
  min-width: 0;
}
.test-card {
  background: var(--c-surface2);
  border: 1px solid var(--c-border);
  border-radius: 16px;
  padding: 1.6rem;
  height: 100%;
  transition: border-color .25s;
}
.test-card:hover { border-color: var(--c-border2); }
.test-stars { display: flex; gap: 3px; margin-bottom: .9rem; }
.test-stars svg { color: #fbbf24; }
.test-quote { font-size: .86rem; color: var(--c-muted2); line-height: 1.82; margin-bottom: 1.3rem; font-style: italic; }
.test-author { display: flex; align-items: center; gap: 10px; }
.test-avatar {
  width: 36px; height: 36px; border-radius: 50%;
  background: linear-gradient(135deg, var(--c-sky), var(--c-indigo));
  display: flex; align-items: center; justify-content: center;
  font-weight: 800; font-size: .76rem; color: #fff; flex-shrink: 0;
}
.test-name { font-size: .83rem; font-weight: 700; color: #fff; }
.test-role { font-size: .7rem; color: var(--c-muted); margin-top: 2px; }
.carousel-controls { display: flex; align-items: center; gap: 10px; margin-top: 1.8rem; }
.carousel-btn {
  width: 38px; height: 38px;
  background: var(--c-surface2);
  border: 1px solid var(--c-border);
  border-radius: 9px;
  display: flex; align-items: center; justify-content: center;
  color: var(--c-muted2);
  cursor: pointer;
  transition: all .2s;
}
.carousel-btn:hover { background: var(--c-sky); color: #fff; border-color: var(--c-sky); }
.carousel-dots { display: flex; gap: 5px; }
.carousel-dot {
  width: 6px; height: 6px;
  border-radius: 99px;
  background: var(--c-border);
  transition: all .3s; cursor: pointer; border: none;
}
.carousel-dot.active { width: 20px; background: var(--c-sky); }

/* ═══════════════════════════════════════════
   CTA
═══════════════════════════════════════════ */
.cta-section {
  background: var(--c-bg);
  padding: 5.5rem 1.5rem;
}
.cta-inner { max-width: 1160px; margin: 0 auto; }
.cta-box {
  background: var(--c-surface2);
  border: 1px solid var(--c-border2);
  border-radius: 22px;
  padding: 3.5rem 2.8rem;
  display: grid;
  grid-template-columns: 1fr auto;
  gap: 2.5rem;
  align-items: center;
  position: relative;
  overflow: hidden;
}
.cta-box::before {
  content: ''; position: absolute; top: -90px; right: -90px;
  width: 260px; height: 260px;
  background: radial-gradient(circle, rgba(14,165,233,.08) 0%, transparent 70%);
  pointer-events: none;
}
.cta-box::after {
  content: ''; position: absolute; bottom: -70px; left: -50px;
  width: 220px; height: 220px;
  background: radial-gradient(circle, rgba(99,102,241,.06) 0%, transparent 70%);
  pointer-events: none;
}
.cta-box h2 {
  font-family: var(--font-display);
  font-size: clamp(1.5rem, 2.8vw, 2.1rem);
  font-weight: 800;
  color: #fff;
  letter-spacing: -.03em;
  margin-bottom: .75rem;
  position: relative; z-index: 1;
}
.cta-box p {
  font-size: .91rem;
  color: var(--c-muted2);
  line-height: 1.82;
  max-width: 500px;
  position: relative; z-index: 1;
}
.cta-box-actions {
  display: flex;
  flex-direction: column;
  gap: 9px;
  flex-shrink: 0;
  position: relative; z-index: 1;
}

/* ═══════════════════════════════════════════
   CONTACT
═══════════════════════════════════════════ */
.contact-section {
  background: var(--c-surface);
  padding: 5.5rem 1.5rem;
}
.contact-inner { max-width: 1160px; margin: 0 auto; }
.contact-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1rem;
  margin-top: 2.4rem;
}
.contact-card {
  background: var(--c-surface2);
  border: 1px solid var(--c-border);
  border-radius: 14px;
  padding: 1.45rem;
  display: flex; align-items: center; gap: 1rem;
  text-decoration: none;
  transition: all .25s;
}
.contact-card:hover { border-color: var(--c-border2); transform: translateY(-3px); box-shadow: 0 9px 30px rgba(0,0,0,.28); }
.contact-icon {
  width: 46px; height: 46px; flex-shrink: 0;
  background: rgba(14,165,233,.09);
  border-radius: 11px;
  display: flex; align-items: center; justify-content: center;
  color: var(--c-sky);
}
.contact-label { font-family: var(--font-mono); font-size: .63rem; color: var(--c-muted); text-transform: uppercase; letter-spacing: .09em; margin-bottom: 4px; }
.contact-val   { font-size: .88rem; color: var(--c-text); font-weight: 600; }
.contact-card-span { grid-column: 1 / -1; cursor: default; }

/* ═══════════════════════════════════════════
   RESPONSIVE — TABLET (≤ 960px)
═══════════════════════════════════════════ */
@media (max-width: 960px) {
  .features-grid { grid-template-columns: repeat(2, 1fr); }
  .carousel-slide { flex: 0 0 calc(50% - .55rem); }
  .gallery-grid {
    grid-template-columns: repeat(2, 1fr);
    grid-template-rows: repeat(3, 180px);
  }
  .gallery-item:nth-child(1),
  .gallery-item:nth-child(4) { grid-column: 1 / -1; }
}

/* ═══════════════════════════════════════════
   RESPONSIVE — MOBILE (≤ 768px)
═══════════════════════════════════════════ */
@media (max-width: 768px) {
  /* Hero */
  .hero { min-height: auto; }
  .hero-inner {
    grid-template-columns: 1fr;
    text-align: center;
    padding: 4rem 1.25rem 3.5rem;
    gap: 0;
  }

  /* Sembunyikan seluruh kolom visual (card mosaic) di mobile */
  .hero-visual { display: none; }

  .hero-desc { margin-left: auto; margin-right: auto; }
  .hero-actions { justify-content: center; }
  .hero-trust  { justify-content: center; }

  /* Stats — 2 cols */
  .stats-inner { grid-template-columns: repeat(2, 1fr); }

  /* About */
  .about-grid { grid-template-columns: 1fr; gap: 2rem; }

  /* Features — 1 col */
  .features-grid { grid-template-columns: 1fr; }

  /* Programs — 1 col */
  .programs-grid { grid-template-columns: 1fr; }

  /* Gallery — 1 col, auto height */
  .gallery-grid {
    grid-template-columns: 1fr;
    grid-template-rows: auto;
  }
  .gallery-item { min-height: 180px; }
  .gallery-item:nth-child(1),
  .gallery-item:nth-child(4) { grid-column: 1 / -1; }

  /* Carousel */
  .carousel-slide { flex: 0 0 100%; }

  /* CTA */
  .cta-box {
    grid-template-columns: 1fr;
    text-align: center;
    padding: 2.5rem 1.5rem;
    gap: 1.8rem;
  }
  .cta-box-actions { align-items: center; }
  .cta-box p { margin-left: auto; margin-right: auto; }

  /* Contact */
  .contact-grid { grid-template-columns: 1fr; }
  .contact-card-span { grid-column: 1 / -1; }

  /* Section padding reduction */
  .about-section,
  .features-section,
  .programs-section,
  .gallery-section,
  .carousel-section,
  .cta-section,
  .contact-section { padding-top: 4rem; padding-bottom: 4rem; }
}

/* ═══════════════════════════════════════════
   RESPONSIVE — SMALL MOBILE (≤ 480px)
═══════════════════════════════════════════ */
@media (max-width: 480px) {
  .hero-inner { padding: 3.5rem 1rem 3rem; }
  .hero-title { font-size: 2rem; }

  .stats-inner { grid-template-columns: repeat(2, 1fr); border-radius: 12px; }
  .stat-num    { font-size: 1.8rem; }
  .stat-cell   { padding: 1.4rem 1rem; }

  .section-title { font-size: 1.55rem; }

  .prog-card { grid-template-columns: 1fr; gap: .75rem; }
  .prog-num  { font-size: 1.8rem; }

  .gallery-item   { min-height: 160px; }
  .gallery-grid   { gap: .6rem; }

  .cta-box { padding: 2rem 1.25rem; }
  .btn-primary,
  .btn-outline { padding: 12px 20px; font-size: .84rem; }

  /* Contact card — stack icon + text on narrow screens */
  .contact-card { gap: .8rem; }
  .contact-icon  { width: 40px; height: 40px; border-radius: 9px; }
  .contact-val   { font-size: .83rem; word-break: break-all; }
}
</style>

<div id="home-page">

<!-- ══ HERO ══ -->
<section class="hero">
  <div class="hero-bg"></div>

  <?php if ($sr('hero_image')): ?>
  <div class="hero-bg-img">
    <img src="<?= UPLOAD_URL . '/' . $s('hero_image') ?>" alt="" loading="lazy">
  </div>
  <?php endif; ?>

  <div class="hero-orb hero-orb-1"></div>
  <div class="hero-orb hero-orb-2"></div>

  <div class="hero-inner">
    <!-- Left / Text -->
    <div class="hero-left">
      <div class="hero-badge" id="hero-badge" style="opacity:0;transform:translateY(18px)">
        <span class="hero-badge-pulse"></span>
        <?= $s('hero_badge_text', 'Organisasi Resmi · SMKN 2 Pinrang') ?>
      </div>

      <h1 class="hero-title" id="hero-title" style="opacity:0;transform:translateY(26px)">
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
      <p class="hero-tagline" id="hero-tagline" style="opacity:0;transform:translateY(18px)"><?= $s('org_tagline') ?></p>
      <?php endif; ?>

      <?php if ($sr('org_description')): ?>
      <p class="hero-desc" id="hero-desc" style="opacity:0;transform:translateY(18px)"><?= $s('org_description') ?></p>
      <?php endif; ?>

      <div class="hero-actions" id="hero-actions" style="opacity:0;transform:translateY(18px)">
        <?php if (empty($_SESSION['user_id'])): ?>
          <a href="<?= BASE_URL ?>/pab" class="btn-primary">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Daftar PAB
          </a>
          <a href="<?= BASE_URL ?>/login" class="btn-outline">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
            Masuk Portal
          </a>
        <?php else: ?>
          <a href="<?= BASE_URL ?>/<?= $_SESSION['user_role'] === 'admin' ? 'admin' : 'member' ?>/dashboard" class="btn-primary">
            Dashboard Saya
          </a>
        <?php endif; ?>
      </div>

      <div class="hero-trust" id="hero-trust" style="opacity:0;transform:translateY(18px)">
        <div class="hero-trust-avatars">
          <div class="hero-trust-avatar">AB</div>
          <div class="hero-trust-avatar">CD</div>
          <div class="hero-trust-avatar">EF</div>
          <div class="hero-trust-avatar">+<?= $s('stat_members', '97') ?></div>
        </div>
        <span class="hero-trust-text">Bergabung dengan <strong><?= $s('stat_members', '100+') ?></strong> anggota aktif</span>
      </div>
    </div>

    <!-- Right / Visual — hanya tampil di desktop -->
    <div class="hero-visual">
      <div class="hero-card-mosaic">
        <div class="hcard hcard-tl">
          <div class="hcard-icon"><svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg></div>
          <span class="hcard-num"><?= $s('stat_members', '100+') ?></span>
          <span class="hcard-label">Anggota Aktif</span>
        </div>
        <div class="hcard hcard-tr">
          <div class="hcard-icon"><svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
          <span class="hcard-num"><?= $s('stat_years', '5+') ?></span>
          <span class="hcard-label">Tahun Berdiri</span>
        </div>
        <div class="hcard hcard-main">
          <div class="hcard-icon"><svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
          <div class="hcard-title"><?= $s('org_name', defined('APP_NAME') ? APP_NAME : 'COM') ?></div>
          <div class="hcard-sub">Platform Digital Organisasi Siswa SMKN 2 Pinrang yang modern dan terpadu.</div>
        </div>
        <div class="hcard hcard-bl">
          <div class="hcard-icon"><svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg></div>
          <span class="hcard-num"><?= $s('stat_events', '50+') ?></span>
          <span class="hcard-label">Kegiatan</span>
        </div>
        <div class="hcard hcard-br">
          <div class="hcard-icon"><svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg></div>
          <span class="hcard-num"><?= $s('stat_awards', '20+') ?></span>
          <span class="hcard-label">Prestasi</span>
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
$tickerRaw   = $sr('ticker_items', 'COM Academy|Penerimaan Anggota Baru|Tech Talk & Workshop|Creative Festival');
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
    </div>
    <div class="stat-cell" data-reveal data-delay="1">
      <span class="stat-num"><?= $s('stat_years', '5+') ?></span>
      <div class="stat-label">Tahun Berdiri</div>
    </div>
    <div class="stat-cell" data-reveal data-delay="2">
      <span class="stat-num"><?= $s('stat_events', '50+') ?></span>
      <div class="stat-label">Kegiatan</div>
    </div>
    <div class="stat-cell" data-reveal data-delay="3">
      <span class="stat-num"><?= $s('stat_awards', '20+') ?></span>
      <div class="stat-label">Prestasi</div>
    </div>
  </div>
</div>

<!-- ══ ABOUT / VISI MISI ══ -->
<section class="about-section" id="about">
  <div class="about-inner">
    <div class="eyebrow" data-reveal><span class="eyebrow-bar"></span>Tentang Kami</div>
    <h2 class="section-title" data-reveal data-delay="1">Visi &amp; Misi<br>Organisasi</h2>
    <p class="section-desc" data-reveal data-delay="2">Kami berkomitmen membentuk generasi yang berdedikasi, kompeten, dan berintegritas melalui program organisasi yang terstruktur dan berkelanjutan.</p>

    <div class="about-grid">
      <div class="about-left" data-reveal data-delay="1">
        <?php if ($sr('org_photo')): ?>
          <img src="<?= UPLOAD_URL . '/' . $s('org_photo') ?>" alt="Foto Organisasi" loading="lazy">
        <?php else: ?>
          <div class="about-img-placeholder">
            <svg width="44" height="44" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" color="#0ea5e9"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
            <span>Foto Organisasi</span>
          </div>
        <?php endif; ?>
      </div>

      <div class="vm-stack" data-reveal data-delay="2">
        <div class="vm-item">
          <div class="vm-item-icon"><svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"/></svg></div>
          <div>
            <h3>Visi</h3>
            <p><?= nl2br($s('org_vision', 'Menjadi organisasi siswa yang unggul, berdedikasi, dan mampu mencetak generasi pemimpin masa depan yang berintegritas dan kompeten di bidang teknologi.')) ?></p>
          </div>
        </div>
        <div class="vm-item">
          <div class="vm-item-icon"><svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg></div>
          <div>
            <h3>Misi</h3>
            <p><?= nl2br($s('org_mission', 'Membina anggota secara aktif, menyelenggarakan kegiatan edukatif dan inovatif, serta membangun sinergi positif di lingkungan sekolah maupun masyarakat luas.')) ?></p>
          </div>
        </div>
        <div class="vm-item">
          <div class="vm-item-icon"><svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
          <div>
            <h3>Nilai Organisasi</h3>
            <p><?= $s('org_nilai', 'Integritas, inovasi, kolaborasi, dan dedikasi menjadi fondasi setiap langkah kami dalam berorganisasi.') ?></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

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
<section class="features-section" id="features">
  <div class="features-inner">
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
          <svg width="21" height="21" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><?= $featIcons[$idx] ?? '' ?></svg>
        </div>
        <h4><?= htmlspecialchars($title) ?></h4>
        <p><?= htmlspecialchars($desc) ?></p>
        <span class="feat-card-bg-num" aria-hidden="true"><?= str_pad($i, 2, '0', STR_PAD_LEFT) ?></span>
      </div>
      <?php endfor; ?>
    </div>
  </div>
</section>

<!-- ══ PROGRAMS ══ -->
<section class="programs-section" id="programs">
  <div class="programs-inner">
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
            <svg width="9" height="9" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3"/></svg>
            <?= htmlspecialchars($tag) ?>
          </span>
          <?php endif; ?>
        </div>
      </div>
      <?php endfor; ?>
    </div>
  </div>
</section>

<!-- ══ GALLERY ══ -->
<section class="gallery-section" id="gallery">
  <div class="gallery-inner">
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
          <img src="<?= UPLOAD_URL . '/' . htmlspecialchars($img) ?>" alt="<?= $label ?>" loading="lazy">
        <?php else: ?>
          <div class="gallery-placeholder">
            <svg width="26" height="26" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
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

<!-- ══ TESTIMONIALS ══ -->
<section class="carousel-section">
  <div class="carousel-inner">
    <div class="carousel-header">
      <div class="eyebrow" data-reveal><span class="eyebrow-bar"></span>Testimoni</div>
      <h2 class="section-title" data-reveal data-delay="1">Apa Kata Anggota Kami</h2>
      <p class="section-desc" data-reveal data-delay="2">Pengalaman nyata dari anggota aktif organisasi.</p>
    </div>

    <div class="carousel-viewport" data-reveal data-delay="2">
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
              <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
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
        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
      </button>
      <button class="carousel-btn" id="car-next" aria-label="Berikutnya">
        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
      </button>
      <div class="carousel-dots" id="car-dots" role="tablist"></div>
    </div>
  </div>
</section>

<!-- ══ CTA ══ -->
<section class="cta-section">
  <div class="cta-inner">
    <div class="cta-box" data-reveal>
      <div>
        <h2><?= $s('cta_title', 'Siap Bergabung Bersama Kami?') ?></h2>
        <p><?= $s('cta_desc', 'Daftarkan diri kamu melalui program Penerimaan Anggota Baru dan jadilah bagian dari keluarga besar organisasi kami.') ?></p>
      </div>
      <div class="cta-box-actions">
        <a href="<?= BASE_URL ?>/pab" class="btn-primary">
          <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
          Daftar Sekarang
        </a>
        <?php if (empty($_SESSION['user_id'])): ?>
        <a href="<?= BASE_URL ?>/login" class="btn-outline">Sudah Anggota? Login</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<!-- ══ CONTACT ══ -->
<section class="contact-section" id="contact">
  <div class="contact-inner">
    <div class="eyebrow" data-reveal><span class="eyebrow-bar"></span>Kontak</div>
    <h2 class="section-title" data-reveal data-delay="1">Hubungi Kami</h2>

    <div class="contact-grid">
      <?php if ($sr('contact_email')): ?>
      <a href="mailto:<?= $s('contact_email') ?>" class="contact-card" data-reveal data-delay="1">
        <div class="contact-icon"><svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg></div>
        <div>
          <div class="contact-label">Email</div>
          <div class="contact-val"><?= $s('contact_email') ?></div>
        </div>
      </a>
      <?php endif; ?>

      <?php if ($sr('contact_phone')): ?>
      <a href="https://wa.me/<?= preg_replace('/\D/', '', $sr('contact_phone')) ?>" class="contact-card" data-reveal data-delay="2" target="_blank" rel="noopener noreferrer">
        <div class="contact-icon"><svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.4 2 2 0 0 1 3.6 1.21h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.8a16 16 0 0 0 6.29 6.29l.96-.95a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg></div>
        <div>
          <div class="contact-label">WhatsApp / Telepon</div>
          <div class="contact-val"><?= $s('contact_phone') ?></div>
        </div>
      </a>
      <?php endif; ?>

      <?php if ($sr('contact_address')): ?>
      <div class="contact-card contact-card-span" data-reveal data-delay="2">
        <div class="contact-icon"><svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg></div>
        <div>
          <div class="contact-label">Alamat</div>
          <div class="contact-val"><?= $s('contact_address') ?></div>
        </div>
      </div>
      <?php endif; ?>
    </div>
  </div>
</section>

</div><!-- #home-page -->

<script>
(function () {
  'use strict';

  /* ── Hero entrance stagger ── */
  var heroItems = [
    { id: 'hero-badge',   delay: 80  },
    { id: 'hero-title',   delay: 200 },
    { id: 'hero-tagline', delay: 320 },
    { id: 'hero-desc',    delay: 410 },
    { id: 'hero-actions', delay: 510 },
    { id: 'hero-trust',   delay: 610 },
  ];
  heroItems.forEach(function (item) {
    var el = document.getElementById(item.id);
    if (!el) return;
    setTimeout(function () {
      el.style.transition = 'opacity .65s cubic-bezier(.22,1,.36,1), transform .65s cubic-bezier(.22,1,.36,1)';
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
    }, { threshold: 0.08 });
    revealEls.forEach(function (el) { io.observe(el); });
  } else {
    revealEls.forEach(function (el) { el.classList.add('_vis'); });
  }

  /* ── Carousel ── */
  var track  = document.getElementById('carousel-track');
  var dotsEl = document.getElementById('car-dots');
  if (!track) return;

  var slides  = Array.prototype.slice.call(track.querySelectorAll('.carousel-slide'));
  if (!slides.length) return;

  var cur     = 0;
  var timer   = null;

  function getPerView() {
    var w = window.innerWidth;
    if (w < 560) return 1;
    if (w < 960) return 2;
    return 3;
  }

  var perView = getPerView();
  var total   = Math.max(1, Math.ceil(slides.length / perView));

  for (var i = 0; i < total; i++) {
    (function (idx) {
      var d = document.createElement('button');
      d.className = 'carousel-dot' + (idx === 0 ? ' active' : '');
      d.setAttribute('aria-label', 'Halaman ' + (idx + 1));
      d.setAttribute('role', 'tab');
      d.dataset.page = idx;
      d.addEventListener('click', function () { goTo(idx); });
      dotsEl.appendChild(d);
    })(i);
  }

  function goTo(p) {
    cur = ((p % total) + total) % total;
    var slideW = slides[0].offsetWidth + 17.6;
    track.style.transform = 'translateX(-' + (cur * perView * slideW) + 'px)';
    dotsEl.querySelectorAll('.carousel-dot').forEach(function (d, i) {
      d.classList.toggle('active', i === cur);
      d.setAttribute('aria-selected', i === cur ? 'true' : 'false');
    });
  }

  function startTimer() { timer = setInterval(function () { goTo(cur + 1); }, 5000); }
  function stopTimer()  { clearInterval(timer); }

  document.getElementById('car-prev').addEventListener('click', function () { goTo(cur - 1); });
  document.getElementById('car-next').addEventListener('click', function () { goTo(cur + 1); });

  track.addEventListener('mouseenter', stopTimer);
  track.addEventListener('mouseleave', startTimer);

  var touchStartX = 0;
  track.addEventListener('touchstart', function (e) { touchStartX = e.touches[0].clientX; }, { passive: true });
  track.addEventListener('touchend',   function (e) {
    var diff = touchStartX - e.changedTouches[0].clientX;
    if (Math.abs(diff) > 50) goTo(diff > 0 ? cur + 1 : cur - 1);
  }, { passive: true });

  var resizeTimer;
  window.addEventListener('resize', function () {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(function () {
      var newPer = getPerView();
      if (newPer !== perView) {
        perView = newPer;
        total   = Math.max(1, Math.ceil(slides.length / perView));
        cur     = 0;
        goTo(0);
      }
    }, 200);
  });

  startTimer();
})();
</script>