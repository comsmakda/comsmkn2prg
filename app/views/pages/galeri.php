<?php
// app/views/pages/galeri.php
// Variabel: $albums, $page, $pages, $total
?>
<style>
.gal-hero{background:var(--c-surface);border-bottom:1px solid var(--c-border);padding:3rem 0 2.2rem}
.gal-hero-inner{max-width:1200px;margin:0 auto;padding:0 2rem}
.gal-hero h1{font-family:var(--font-display);font-size:clamp(1.6rem,3vw,2.4rem);font-weight:900;color:#fff;letter-spacing:-.035em;margin-bottom:.4rem}
.gal-hero p{font-size:.88rem;color:var(--c-muted2)}
.gal-wrap{max-width:1200px;margin:0 auto;padding:2.5rem 2rem}
.gal-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:1rem}
.gal-card{background:var(--c-surface2);border:1px solid var(--c-border);border-radius:14px;overflow:hidden;text-decoration:none;display:flex;flex-direction:column;transition:all .28s cubic-bezier(.22,1,.36,1)}
.gal-card:hover{border-color:rgba(14,165,233,.25);transform:translateY(-3px);box-shadow:0 12px 36px rgba(0,0,0,.28)}
.gal-cover{aspect-ratio:4/3;background:var(--c-surface3);overflow:hidden;position:relative}
.gal-cover img{width:100%;height:100%;object-fit:cover;display:block;transition:transform .4s}
.gal-card:hover .gal-cover img{transform:scale(1.05)}
.gal-cover-ph{width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:var(--c-muted);opacity:.25}
.gal-overlay{position:absolute;inset:0;background:linear-gradient(to top,rgba(4,8,15,.65) 0%,transparent 55%);display:flex;align-items:flex-end;padding:.65rem;opacity:0;transition:opacity .28s}
.gal-card:hover .gal-overlay{opacity:1}
.gal-cnt{font-family:var(--font-mono);font-size:.62rem;color:#fff;background:rgba(14,165,233,.3);border:1px solid rgba(14,165,233,.45);border-radius:99px;padding:2px 9px}
.gal-body{padding:.85rem}
.gal-title{font-family:var(--font-display);font-size:.88rem;font-weight:800;color:#fff;margin-bottom:.25rem;letter-spacing:-.022em}
.gal-desc{font-size:.74rem;color:var(--c-muted2);line-height:1.6;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
.gal-pag{display:flex;gap:.4rem;justify-content:center;margin-top:2rem;flex-wrap:wrap}
.gal-pag a{display:inline-flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:8px;border:1px solid var(--c-border);background:var(--c-surface2);color:var(--c-muted2);font-size:.78rem;font-weight:600;text-decoration:none;transition:all .18s}
.gal-pag a.active,.gal-pag a:hover{background:var(--c-sky);border-color:var(--c-sky);color:#fff}
@media(max-width:1024px){.gal-grid{grid-template-columns:repeat(3,1fr)}}
@media(max-width:768px){.gal-grid{grid-template-columns:repeat(2,1fr)}}
@media(max-width:480px){.gal-grid{grid-template-columns:1fr}.gal-wrap{padding:2rem 1.2rem}}
</style>

<div class="gal-hero">
  <div class="gal-hero-inner">
    <div class="eyebrow" style="margin-bottom:.5rem"><span class="eyebrow-bar"></span>Galeri</div>
    <h1>Galeri Foto</h1>
    <p>Dokumentasi momen dan kegiatan <?= htmlspecialchars($settings['org_name']['value'] ?? 'COM SMKN 2 Pinrang') ?></p>
  </div>
</div>

<div class="gal-wrap">
  <?php if (empty($albums)): ?>
  <div style="text-align:center;padding:4rem 2rem;color:var(--c-muted)">
    <svg width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24" style="margin:0 auto 1rem;display:block;opacity:.2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
    <p style="font-size:.88rem">Belum ada album foto yang tersedia.</p>
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
               alt="<?= htmlspecialchars($a['judul']) ?>" loading="lazy">
        <?php else: ?>
          <div class="gal-cover-ph">
            <svg width="32" height="32" fill="none" stroke="currentColor" stroke-width="1.4" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
          </div>
        <?php endif; ?>
        <div class="gal-overlay">
          <span class="gal-cnt"><?= (int)$a['jumlah_foto'] ?> foto</span>
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