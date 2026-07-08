<?php
// app/views/pages/galeri.php
// Variabel: $albums, $page, $pages, $total
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
.gal-page {
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
.gal-hero {
  position: relative;
  background: var(--bg-page);
  border-bottom: 1px solid var(--bd-subtle);
  padding: 2.75rem 0 2.1rem;
}
.gal-hero-inner {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 2rem;
}
.gal-eyebrow {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  font-size: 11px;
  font-weight: 700;
  letter-spacing: .1em;
  text-transform: uppercase;
  color: var(--ac);
  margin-bottom: .6rem;
}
.gal-eyebrow::before {
  content: '';
  width: 6px; height: 6px;
  border-radius: 50%;
  background: var(--ac);
  box-shadow: 0 0 6px var(--ac);
}
.gal-hero h1 {
  font-size: clamp(1.5rem, 3vw, 2.1rem);
  font-weight: 800;
  color: var(--ac-dk);
  letter-spacing: -.03em;
  margin: 0 0 .4rem;
}
.gal-hero p {
  font-size: .86rem;
  font-weight: 500;
  color: var(--tx-secondary);
  margin: 0;
}

/* ── Wrap ── */
.gal-wrap { max-width: 1200px; margin: 0 auto; padding: 2.25rem 2rem 3.5rem; }

/* ── Empty state ── */
.gal-empty {
  text-align: center;
  padding: 4rem 2rem;
  color: var(--tx-muted);
  background: var(--bg-surface);
  border: 1px dashed var(--bd-subtle);
  border-radius: var(--r-lg);
}
.gal-empty i { font-size: 42px; opacity: .35; display: block; margin-bottom: 1rem; }
.gal-empty p { font-size: .88rem; font-weight: 500; margin: 0; }

/* ── Grid ── */
.gal-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.1rem; }

.gal-card {
  background: var(--bg-surface);
  border: 1px solid var(--bd-subtle);
  border-radius: var(--r-md);
  overflow: hidden;
  text-decoration: none;
  display: flex;
  flex-direction: column;
  transition: border-color .24s cubic-bezier(.22,1,.36,1),
              transform .2s cubic-bezier(.22,1,.36,1),
              box-shadow .24s cubic-bezier(.22,1,.36,1);
}
.gal-card:hover {
  border-color: rgba(14,116,144,.3);
  transform: translateY(-3px);
  box-shadow: 0 16px 36px -14px rgba(15,23,42,.18), 0 4px 14px rgba(15,23,42,.06);
}

.gal-cover {
  aspect-ratio: 4 / 3;
  background: var(--bg-page);
  overflow: hidden;
  position: relative;
}
.gal-cover img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
  transition: transform .4s ease;
}
.gal-card:hover .gal-cover img { transform: scale(1.05); }
.gal-cover-ph {
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--tx-muted);
}
.gal-cover-ph i { font-size: 30px; opacity: .4; }

.gal-overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(to top, rgba(11,90,112,.55) 0%, transparent 55%);
  display: flex;
  align-items: flex-end;
  padding: .65rem;
  opacity: 0;
  transition: opacity .24s ease;
}
.gal-card:hover .gal-overlay { opacity: 1; }
.gal-cnt {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  font-size: .66rem;
  font-weight: 700;
  color: #fff;
  background: rgba(255,255,255,.18);
  border: 1px solid rgba(255,255,255,.35);
  border-radius: 99px;
  padding: 3px 10px;
  backdrop-filter: blur(2px);
}
.gal-cnt i { font-size: 12px; }

.gal-body { padding: .95rem 1rem 1.05rem; }
.gal-title {
  font-size: .9rem;
  font-weight: 700;
  color: var(--tx-primary);
  margin-bottom: .28rem;
  letter-spacing: -.015em;
  line-height: 1.35;
}
.gal-desc {
  font-size: .76rem;
  font-weight: 500;
  color: var(--tx-secondary);
  line-height: 1.6;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

/* ── Pagination ── */
.gal-pag { display: flex; gap: .4rem; justify-content: center; margin-top: 2.25rem; flex-wrap: wrap; }
.gal-pag a {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 38px;
  height: 38px;
  border-radius: var(--r-sm);
  border: 1.5px solid var(--bd-subtle);
  background: var(--bg-surface);
  color: var(--tx-secondary);
  font-size: .8rem;
  font-weight: 700;
  text-decoration: none;
  transition: all .18s ease;
}
.gal-pag a:hover { border-color: rgba(14,116,144,.3); color: var(--ac); background: rgba(14,116,144,.06); }
.gal-pag a.active {
  background: var(--ac);
  border-color: var(--ac);
  color: #fff;
  box-shadow: 0 8px 18px rgba(14,116,144,.24);
}

/* ── Responsive ── */
@media (max-width: 1024px) { .gal-grid { grid-template-columns: repeat(3, 1fr); } }
@media (max-width: 768px)  { .gal-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 480px) {
  .gal-grid { grid-template-columns: 1fr; }
  .gal-wrap { padding: 1.75rem 1.2rem 3rem; }
  .gal-hero-inner { padding: 0 1.2rem; }
}
</style>

<div class="gal-page">

  <div class="gal-hero">
    <div class="gal-hero-inner">
      <div class="gal-eyebrow">Galeri</div>
      <h1>Galeri Foto</h1>
      <p>Dokumentasi momen dan kegiatan <?= htmlspecialchars($settings['org_name']['value'] ?? 'COM SMKN 2 Pinrang') ?></p>
    </div>
  </div>

  <div class="gal-wrap">
    <?php if (empty($albums)): ?>
    <div class="gal-empty">
      <i class="ti ti-photo" aria-hidden="true"></i>
      <p>Belum ada album foto yang tersedia.</p>
    </div>
    <?php else: ?>

    <div class="gal-grid">
      <?php foreach ($albums as $a):
        $coverSrc = !empty($a['cover']) ? UPLOAD_URL.'/'.$a['cover']
                  : (!empty($a['first_foto']) ? UPLOAD_URL.'/'.$a['first_foto'] : null);
      ?>
      <a href="<?= BASE_URL ?>/galeri/<?= htmlspecialchars($a['slug']) ?>" class="gal-card">
        <div class="gal-cover">
          <?php if ($coverSrc): ?>
            <img src="<?= htmlspecialchars($coverSrc) ?>"
                 alt="<?= htmlspecialchars($a['judul']) ?>" loading="lazy" decoding="async">
          <?php else: ?>
            <div class="gal-cover-ph">
              <i class="ti ti-photo" aria-hidden="true"></i>
            </div>
          <?php endif; ?>
          <div class="gal-overlay">
            <span class="gal-cnt">
              <i class="ti ti-photo" aria-hidden="true"></i>
              <?= (int)$a['jumlah_foto'] ?> foto
            </span>
          </div>
        </div>
        <div class="gal-body">
          <div class="gal-title"><?= htmlspecialchars($a['judul']) ?></div>
          <?php if ($a['deskripsi']): ?>
          <div class="gal-desc"><?= htmlspecialchars($a['deskripsi']) ?></div>
          <?php endif; ?>
        </div>
      </a>
      <?php endforeach; ?>
    </div>

    <?php if ($pages > 1): ?>
    <div class="gal-pag">
      <?php for ($i = 1; $i <= $pages; $i++): ?>
      <a href="<?= BASE_URL ?>/galeri?page=<?= $i ?>" class="<?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
      <?php endfor; ?>
    </div>
    <?php endif; ?>

    <?php endif; ?>
  </div>

</div>