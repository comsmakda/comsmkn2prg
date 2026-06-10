<?php
// app/views/pages/galeri_album.php
// Variabel: $album, $fotos
?>
<style>
.alb-hero{background:var(--c-surface);border-bottom:1px solid var(--c-border);padding:2.8rem 0 2rem}
.alb-hero-inner{max-width:1200px;margin:0 auto;padding:0 2rem}
.alb-back{display:inline-flex;align-items:center;gap:6px;font-size:.78rem;color:var(--c-muted2);text-decoration:none;margin-bottom:.9rem;transition:color .18s}
.alb-back:hover{color:var(--c-sky)}
.alb-title{font-family:var(--font-display);font-size:clamp(1.5rem,3vw,2.2rem);font-weight:900;color:#fff;letter-spacing:-.035em;margin-bottom:.4rem}
.alb-desc{font-size:.88rem;color:var(--c-muted2);line-height:1.7}
.alb-wrap{max-width:1200px;margin:0 auto;padding:2.5rem 2rem}
.foto-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:.75rem}
.foto-item{border-radius:11px;overflow:hidden;aspect-ratio:1;background:var(--c-surface2);border:1px solid var(--c-border);cursor:pointer;transition:all .25s cubic-bezier(.22,1,.36,1);position:relative}
.foto-item:hover{transform:scale(1.025);border-color:rgba(14,165,233,.3);box-shadow:0 8px 24px rgba(0,0,0,.35);z-index:2}
.foto-item img{width:100%;height:100%;object-fit:cover;display:block;transition:transform .3s}
.foto-item:hover img{transform:scale(1.05)}
.foto-item-cap{position:absolute;bottom:0;left:0;right:0;background:linear-gradient(transparent,rgba(4,8,15,.75));padding:.5rem;font-size:.65rem;color:#fff;opacity:0;transition:opacity .25s;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.foto-item:hover .foto-item-cap{opacity:1}
/* Lightbox */
.lb{display:none;position:fixed;inset:0;z-index:9999;background:rgba(3,7,14,.97);align-items:center;justify-content:center}
.lb.open{display:flex;animation:lb-in .2s ease}
@keyframes lb-in{from{opacity:0}to{opacity:1}}
.lb-inner{position:relative;display:flex;align-items:center;gap:1rem;max-width:92vw;max-height:92vh}
.lb-img-wrap{position:relative}
.lb-img{max-width:80vw;max-height:85vh;border-radius:10px;object-fit:contain;display:block;box-shadow:0 24px 80px rgba(0,0,0,.6)}
.lb-close{position:absolute;top:-44px;right:0;width:36px;height:36px;background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.12);border-radius:8px;display:flex;align-items:center;justify-content:center;color:#fff;cursor:pointer;transition:background .18s}
.lb-close:hover{background:rgba(255,255,255,.15)}
.lb-counter{position:absolute;top:-44px;left:0;font-family:var(--font-mono);font-size:.65rem;color:var(--c-muted2)}
.lb-caption{position:absolute;bottom:-34px;left:0;right:0;text-align:center;font-size:.78rem;color:var(--c-muted2)}
.lb-nav{width:42px;height:42px;background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.1);border-radius:9px;display:flex;align-items:center;justify-content:center;color:#fff;cursor:pointer;transition:all .18s;flex-shrink:0}
.lb-nav:hover{background:var(--c-sky);border-color:var(--c-sky)}
@media(max-width:1024px){.foto-grid{grid-template-columns:repeat(3,1fr)}}
@media(max-width:768px){.foto-grid{grid-template-columns:repeat(2,1fr)}}
@media(max-width:480px){.alb-wrap{padding:2rem 1.2rem}.lb-nav{width:36px;height:36px}}
</style>

<div class="alb-hero">
  <div class="alb-hero-inner">
    <a href="<?= BASE_URL ?>/galeri" class="alb-back">
      <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
      Kembali ke Galeri
    </a>
    <div class="eyebrow" style="margin-bottom:.5rem"><span class="eyebrow-bar"></span>Galeri</div>
    <h1 class="alb-title"><?= htmlspecialchars($album['judul']) ?></h1>
    <?php if ($album['deskripsi']): ?>
    <p class="alb-desc"><?= htmlspecialchars($album['deskripsi']) ?></p>
    <?php endif; ?>
  </div>
</div>

<div class="alb-wrap">
  <?php if (empty($fotos)): ?>
  <div style="text-align:center;padding:3rem 2rem;color:var(--c-muted)">
    <p style="font-size:.86rem">Album ini belum memiliki foto.</p>
  </div>
  <?php else: ?>

  <div style="font-family:var(--font-mono);font-size:.65rem;color:var(--c-muted);margin-bottom:1.2rem;display:flex;align-items:center;gap:.5rem">
    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
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

<!-- Lightbox -->
<div class="lb" id="lb" role="dialog" aria-modal="true" aria-label="Lightbox">
  <div class="lb-inner">
    <span class="lb-counter" id="lb-counter"></span>
    <button class="lb-close" id="lb-close" aria-label="Tutup">
      <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
    </button>
    <button class="lb-nav" id="lb-prev" aria-label="Sebelumnya">
      <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
    </button>
    <div class="lb-img-wrap">
      <img src="" alt="" class="lb-img" id="lb-img">
      <div class="lb-caption" id="lb-caption"></div>
    </div>
    <button class="lb-nav" id="lb-next" aria-label="Berikutnya">
      <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
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