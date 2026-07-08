<?php
// app/views/pages/galeri_album.php
// Variabel: $album, $fotos
?>
<!-- Font & icon set mengikuti design system (idempotent bila sudah di-load di layout utama) -->
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

<style>
*, *::before, *::after { box-sizing: border-box; }

@media (prefers-reduced-motion: reduce) {
  * { transition-duration: .01ms !important; animation-duration: .01ms !important; }
}

/* ═══════════════════════════════════════
   SCOPE ROOT — alias ke Design System
   (token asli didefinisikan global di layout;
    fallback disertakan bila file ini dirender berdiri sendiri)
═══════════════════════════════════════ */
.alb-page {
  --bg-page:    var(--c-page,  #eef2f6);
  --bg-surface: var(--c-white, #ffffff);

  --tx-primary:   var(--c-ink,    #0f172a);
  --tx-secondary: var(--c-muted,  #64748b);
  --tx-muted:     var(--c-muted2, #94a3b8);

  --bd-subtle: var(--c-border, #e6ebf1);

  --ac:    var(--c-primary,    #0e7490);
  --ac-dk: var(--c-primary-dk, #0b5a70);
  --ac-lt: var(--c-primary-lt, #06b6d4);

  --r-sm: var(--radius-sm, 9px);
  --r-md: var(--radius-md, 13px);
  --r-lg: var(--radius-lg, 22px);

  --font-ui: var(--ff, 'Plus Jakarta Sans', sans-serif);

  font-family: var(--font-ui);
  color: var(--tx-primary);
}

/* ── Hero ── */
.alb-hero {
  background: var(--bg-page);
  border-bottom: 1px solid var(--bd-subtle);
  padding: 2.5rem 0 2rem;
}
.alb-hero-inner { max-width: 1200px; margin: 0 auto; padding: 0 2rem; }

.alb-back {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  font-size: .8rem;
  font-weight: 600;
  color: var(--tx-secondary);
  text-decoration: none;
  margin-bottom: 1rem;
  transition: color .18s;
}
.alb-back i { font-size: 15px; }
.alb-back:hover { color: var(--ac); }

.alb-eyebrow {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  font-size: 11px;
  font-weight: 700;
  letter-spacing: .1em;
  text-transform: uppercase;
  color: var(--ac);
  margin-bottom: .55rem;
}
.alb-eyebrow::before {
  content: '';
  width: 6px; height: 6px;
  border-radius: 50%;
  background: var(--ac);
  box-shadow: 0 0 6px var(--ac);
}

.alb-title {
  font-size: clamp(1.4rem, 3vw, 2.1rem);
  font-weight: 800;
  color: var(--ac-dk);
  letter-spacing: -.03em;
  margin: 0 0 .4rem;
}
.alb-desc {
  font-size: .88rem;
  font-weight: 500;
  color: var(--tx-secondary);
  line-height: 1.7;
  max-width: 720px;
}

/* ── Wrap ── */
.alb-wrap { max-width: 1200px; margin: 0 auto; padding: 2.25rem 2rem 3.5rem; }

.alb-empty {
  text-align: center;
  padding: 3rem 2rem;
  color: var(--tx-muted);
  background: var(--bg-surface);
  border: 1px dashed var(--bd-subtle);
  border-radius: var(--r-lg);
}
.alb-empty p { font-size: .86rem; font-weight: 500; margin: 0; }

.alb-count {
  font-size: .74rem;
  font-weight: 600;
  color: var(--tx-secondary);
  margin-bottom: 1.2rem;
  display: flex;
  align-items: center;
  gap: 7px;
}
.alb-count i { font-size: 15px; color: var(--tx-muted); }

/* ── Foto grid ── */
.foto-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: .85rem; }

.foto-item {
  border-radius: var(--r-md);
  overflow: hidden;
  aspect-ratio: 1;
  background: var(--bg-page);
  border: 1px solid var(--bd-subtle);
  cursor: pointer;
  transition: transform .22s cubic-bezier(.22,1,.36,1),
              border-color .22s cubic-bezier(.22,1,.36,1),
              box-shadow .22s cubic-bezier(.22,1,.36,1);
  position: relative;
}
.foto-item:hover {
  transform: scale(1.025);
  border-color: rgba(14,116,144,.3);
  box-shadow: 0 14px 32px -10px rgba(15,23,42,.25);
  z-index: 2;
}
.foto-item img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
  transition: transform .3s ease;
}
.foto-item:hover img { transform: scale(1.05); }

.foto-item-cap {
  position: absolute;
  bottom: 0; left: 0; right: 0;
  background: linear-gradient(transparent, rgba(11,90,112,.8));
  padding: .55rem .6rem;
  font-size: .68rem;
  font-weight: 600;
  color: #fff;
  opacity: 0;
  transition: opacity .22s ease;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.foto-item:hover .foto-item-cap { opacity: 1; }

/* ═══════════════════════════════════════
   LIGHTBOX — tetap kanvas gelap agar fokus ke foto
   (satu-satunya bagian halaman yang sengaja tidak ikut tema terang)
═══════════════════════════════════════ */
.lb {
  display: none;
  position: fixed;
  inset: 0;
  z-index: 9999;
  background: rgba(6,10,18,.96);
  align-items: center;
  justify-content: center;
}
.lb.open { display: flex; animation: lb-in .2s ease; }
@keyframes lb-in { from { opacity: 0; } to { opacity: 1; } }

.lb-inner {
  position: relative;
  display: flex;
  align-items: center;
  gap: 1rem;
  max-width: 92vw;
  max-height: 92vh;
}
.lb-img-wrap { position: relative; }
.lb-img {
  max-width: 80vw;
  max-height: 85vh;
  border-radius: var(--r-md);
  object-fit: contain;
  display: block;
  box-shadow: 0 24px 80px rgba(0,0,0,.6);
}
.lb-close {
  position: absolute;
  top: -46px; right: 0;
  width: 36px; height: 36px;
  background: rgba(255,255,255,.08);
  border: 1px solid rgba(255,255,255,.14);
  border-radius: var(--r-sm);
  display: flex;
  align-items: center;
  justify-content: center;
  color: #fff;
  cursor: pointer;
  transition: background .18s ease;
}
.lb-close i { font-size: 16px; }
.lb-close:hover { background: rgba(255,255,255,.16); }

.lb-counter {
  position: absolute;
  top: -42px; left: 0;
  font-size: .72rem;
  font-weight: 700;
  letter-spacing: .04em;
  color: rgba(255,255,255,.6);
}
.lb-caption {
  position: absolute;
  bottom: -36px; left: 0; right: 0;
  text-align: center;
  font-size: .8rem;
  font-weight: 500;
  color: rgba(255,255,255,.75);
}
.lb-nav {
  width: 42px; height: 42px;
  background: rgba(255,255,255,.08);
  border: 1px solid rgba(255,255,255,.12);
  border-radius: var(--r-sm);
  display: flex;
  align-items: center;
  justify-content: center;
  color: #fff;
  cursor: pointer;
  transition: all .18s ease;
  flex-shrink: 0;
}
.lb-nav i { font-size: 18px; }
.lb-nav:hover { background: var(--ac); border-color: var(--ac); }

/* ── Responsive ── */
@media (max-width: 1024px) { .foto-grid { grid-template-columns: repeat(3, 1fr); } }
@media (max-width: 768px)  { .foto-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 480px) {
  .alb-wrap { padding: 1.75rem 1.2rem 3rem; }
  .alb-hero-inner { padding: 0 1.2rem; }
  .lb-nav { width: 36px; height: 36px; }
}
</style>

<div class="alb-page">

  <div class="alb-hero">
    <div class="alb-hero-inner">
      <a href="<?= BASE_URL ?>/galeri" class="alb-back">
        <i class="ti ti-arrow-left" aria-hidden="true"></i>
        Kembali ke Galeri
      </a>
      <div class="alb-eyebrow">Galeri</div>
      <h1 class="alb-title"><?= htmlspecialchars($album['judul']) ?></h1>
      <?php if ($album['deskripsi']): ?>
      <p class="alb-desc"><?= htmlspecialchars($album['deskripsi']) ?></p>
      <?php endif; ?>
    </div>
  </div>

  <div class="alb-wrap">
    <?php if (empty($fotos)): ?>
    <div class="alb-empty">
      <p>Album ini belum memiliki foto.</p>
    </div>
    <?php else: ?>

    <div class="alb-count">
      <i class="ti ti-photo" aria-hidden="true"></i>
      <?= count($fotos) ?> foto · Klik untuk memperbesar
    </div>

    <div class="foto-grid">
      <?php foreach ($fotos as $idx => $f): ?>
      <div class="foto-item" data-idx="<?= $idx ?>">
        <img src="<?= UPLOAD_URL . '/' . htmlspecialchars($f['file']) ?>"
             alt="<?= htmlspecialchars($f['judul'] ?? $album['judul']) ?>"
             loading="lazy"
             data-full="<?= UPLOAD_URL . '/' . htmlspecialchars($f['file']) ?>"
             data-caption="<?= htmlspecialchars($f['judul'] ?? '') ?>">
        <?php if ($f['judul']): ?>
        <div class="foto-item-cap"><?= htmlspecialchars($f['judul']) ?></div>
        <?php endif; ?>
      </div>
      <?php endforeach; ?>
    </div>

    <?php endif; ?>
  </div>

</div>

<!-- Lightbox -->
<div class="lb" id="lb" role="dialog" aria-modal="true" aria-label="Lightbox">
  <div class="lb-inner">
    <span class="lb-counter" id="lb-counter"></span>
    <button class="lb-close" id="lb-close" aria-label="Tutup">
      <i class="ti ti-x" aria-hidden="true"></i>
    </button>
    <button class="lb-nav" id="lb-prev" aria-label="Sebelumnya">
      <i class="ti ti-chevron-left" aria-hidden="true"></i>
    </button>
    <div class="lb-img-wrap">
      <img src="" alt="" class="lb-img" id="lb-img">
      <div class="lb-caption" id="lb-caption"></div>
    </div>
    <button class="lb-nav" id="lb-next" aria-label="Berikutnya">
      <i class="ti ti-chevron-right" aria-hidden="true"></i>
    </button>
  </div>
</div>

<script>
(function(){
  var items = Array.from(document.querySelectorAll('.foto-item'));
  if (!items.length) return;
  var lb      = document.getElementById('lb');
  var lbImg   = document.getElementById('lb-img');
  var lbCap   = document.getElementById('lb-caption');
  var lbCnt   = document.getElementById('lb-counter');
  var cur     = 0;
  var total   = items.length;

  function show(idx) {
    cur = ((idx % total) + total) % total;
    var img = items[cur].querySelector('img');
    lbImg.src          = img.dataset.full || img.src;
    lbCap.textContent  = img.dataset.caption || '';
    lbCnt.textContent  = (cur + 1) + ' / ' + total;
    lb.classList.add('open');
    document.body.style.overflow = 'hidden';
  }

  function close() {
    lb.classList.remove('open');
    document.body.style.overflow = '';
  }

  items.forEach(function(el) {
    el.addEventListener('click', function(){ show(parseInt(el.dataset.idx)); });
  });

  document.getElementById('lb-close').addEventListener('click', close);
  document.getElementById('lb-prev').addEventListener('click', function(){ show(cur - 1); });
  document.getElementById('lb-next').addEventListener('click', function(){ show(cur + 1); });
  lb.addEventListener('click', function(e){ if (e.target === lb) close(); });

  // Keyboard
  document.addEventListener('keydown', function(e) {
    if (!lb.classList.contains('open')) return;
    if (e.key === 'ArrowLeft')  show(cur - 1);
    if (e.key === 'ArrowRight') show(cur + 1);
    if (e.key === 'Escape')     close();
  });

  // Touch swipe
  var tx = 0;
  lb.addEventListener('touchstart', function(e){ tx = e.touches[0].clientX; }, {passive:true});
  lb.addEventListener('touchend', function(e){
    var diff = tx - e.changedTouches[0].clientX;
    if (Math.abs(diff) > 50) show(diff > 0 ? cur + 1 : cur - 1);
  }, {passive:true});
})();
</script>