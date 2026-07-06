<?php
// app/views/pages/berita.php
// Variabel: $items, $kategoriList, $katAktif, $page, $pages, $total
// Layout main.php sudah menyediakan header/footer
?>
<style>
.brt-hero{background:var(--c-surface);border-bottom:1px solid var(--c-border);padding:3rem 0 2.2rem}
.brt-hero-inner{max-width:1200px;margin:0 auto;padding:0 2rem}
.brt-hero h1{font-family:var(--font-display);font-size:clamp(1.6rem,3vw,2.4rem);font-weight:900;color:#fff;letter-spacing:-.035em;margin-bottom:.4rem}
.brt-hero p{font-size:.88rem;color:var(--c-muted2)}

.brt-wrap{max-width:1200px;margin:0 auto;padding:2.5rem 2rem}

.brt-filter{display:flex;gap:.5rem;flex-wrap:wrap;margin-bottom:2rem;align-items:center}
.brt-filter-label{font-family:var(--font-mono);font-size:.6rem;color:var(--c-muted);text-transform:uppercase;letter-spacing:.1em;margin-right:.3rem}
.brt-btn{padding:5px 15px;border-radius:99px;font-size:.74rem;font-weight:600;border:1px solid var(--c-border);color:var(--c-muted2);background:var(--c-surface2);text-decoration:none;transition:all .18s;white-space:nowrap}
.brt-btn:hover{color:#fff;border-color:rgba(255,255,255,.15);background:rgba(255,255,255,.06)}
.brt-btn.active{background:var(--c-sky);border-color:var(--c-sky);color:#fff}

.brt-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:1.2rem}

.brt-card{background:var(--c-surface2);border:1px solid var(--c-border);border-radius:14px;overflow:hidden;display:flex;flex-direction:column;transition:all .28s cubic-bezier(.22,1,.36,1)}
.brt-card:hover{border-color:rgba(14,165,233,.25);transform:translateY(-3px);box-shadow:0 12px 36px rgba(0,0,0,.28)}
.brt-card-img{aspect-ratio:16/9;overflow:hidden;background:var(--c-surface3);position:relative}
.brt-card-img img{width:100%;height:100%;object-fit:cover;display:block;transition:transform .4s}
.brt-card:hover .brt-card-img img{transform:scale(1.04)}
.brt-card-img-ph{width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:var(--c-muted);opacity:.3}
.brt-card-body{padding:1.1rem;flex:1;display:flex;flex-direction:column}
.brt-card-kat{display:inline-block;font-family:var(--font-mono);font-size:.59rem;font-weight:600;letter-spacing:.08em;text-transform:uppercase;padding:2px 9px;border-radius:99px;margin-bottom:.65rem;width:fit-content}
.brt-card-title{font-family:var(--font-display);font-size:.92rem;font-weight:800;color:#fff;line-height:1.3;margin-bottom:.5rem;letter-spacing:-.022em;text-decoration:none;display:block;transition:color .18s}
.brt-card-title:hover{color:var(--c-sky)}
.brt-card-ring{font-size:.78rem;color:var(--c-muted2);line-height:1.72;flex:1;margin-bottom:.9rem;display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden}
.brt-card-meta{display:flex;align-items:center;justify-content:space-between;font-family:var(--font-mono);font-size:.62rem;color:var(--c-muted)}
.brt-card-stats{display:flex;gap:8px}
.brt-stat{display:flex;align-items:center;gap:3px}

/* ── Share popup ── */
.brt-card-footer{padding:.75rem 1.1rem .9rem;border-top:1px solid var(--c-border);position:relative}
.brt-share-wrap{position:relative}
.brt-share-btn{display:inline-flex;align-items:center;gap:5px;font-family:var(--font-mono);font-size:.6rem;color:var(--c-muted);background:none;border:1px solid var(--c-border);border-radius:6px;padding:4px 10px;cursor:pointer;transition:all .18s;white-space:nowrap}
.brt-share-btn:hover{color:#fff;border-color:rgba(255,255,255,.2);background:rgba(255,255,255,.05)}
.brt-share-popup{display:none;position:absolute;bottom:calc(100% + 6px);left:0;background:var(--c-surface);border:1px solid var(--c-border);border-radius:10px;padding:.5rem;box-shadow:0 8px 28px rgba(0,0,0,.45);z-index:99;min-width:220px}
.brt-share-popup.open{display:block}
.brt-share-popup-row{display:flex;align-items:center;gap:.4rem;flex-wrap:wrap}
.sh-icon{display:inline-flex;align-items:center;justify-content:center;width:34px;height:34px;border-radius:7px;border:none;cursor:pointer;text-decoration:none;transition:opacity .18s,transform .15s,box-shadow .18s;flex-shrink:0}
.sh-icon:hover{opacity:.85;transform:translateY(-2px);box-shadow:0 4px 12px rgba(0,0,0,.35)}
.sh-icon:active{transform:translateY(0)}
.sh-icon svg{display:block}
.sh-wa{background:#22c55e;color:#fff}
.sh-fb{background:#1877F2;color:#fff}
.sh-tw{background:#0f1419;color:#fff;border:1px solid #2a2a2a}
.sh-tt{background:#111;color:#fff;border:1px solid #2a2a2a}
.sh-ig{background:linear-gradient(135deg,#f58529,#dd2a7b,#8134af);color:#fff}
.sh-copy{background:var(--c-surface2);color:var(--c-muted2);border:1px solid var(--c-border)}
.sh-copy:hover{color:#fff;border-color:rgba(14,165,233,.45);background:rgba(14,165,233,.08)}

.brt-empty{text-align:center;padding:4rem 2rem;color:var(--c-muted)}
.brt-pag{display:flex;gap:.4rem;justify-content:center;margin-top:2.5rem;flex-wrap:wrap}
.brt-pag a{display:inline-flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:8px;border:1px solid var(--c-border);background:var(--c-surface2);color:var(--c-muted2);font-size:.78rem;font-weight:600;text-decoration:none;transition:all .18s}
.brt-pag a.active,.brt-pag a:hover{background:var(--c-sky);border-color:var(--c-sky);color:#fff}
.brt-pag a.disabled{opacity:.35;pointer-events:none}

@media(max-width:1024px){.brt-grid{grid-template-columns:repeat(2,1fr)}}
@media(max-width:640px){.brt-grid{grid-template-columns:1fr}.brt-wrap{padding:2rem 1.2rem}}
</style>

<div class="brt-hero">
  <div class="brt-hero-inner">
    <div class="eyebrow" style="margin-bottom:.5rem"><span class="eyebrow-bar"></span>Berita</div>
    <h1>Berita &amp; Artikel</h1>
    <p>Informasi terbaru kegiatan, prestasi, dan program <?= htmlspecialchars($settings['org_name']['value'] ?? 'COM SMKN 2 Pinrang') ?></p>
  </div>
</div>

<div class="brt-wrap">
  <!-- Filter -->
  <div class="brt-filter">
    <span class="brt-filter-label">Filter:</span>
    <a href="<?= BASE_URL ?>/berita" class="brt-btn <?= !$katAktif ? 'active' : '' ?>">Semua</a>
    <?php foreach ($kategoriList as $k): ?>
    <?php $isAktif = $katAktif && $katAktif['id'] == $k['id']; ?>
    <a href="<?= BASE_URL ?>/berita?kategori=<?= urlencode($k['slug']) ?>"
       class="brt-btn <?= $isAktif ? 'active' : '' ?>"
       style="<?= $isAktif ? 'background:'.$k['warna'].';border-color:'.$k['warna'].';color:#fff' : '' ?>">
      <?= htmlspecialchars($k['nama']) ?>
    </a>
    <?php endforeach; ?>
  </div>

  <?php if (empty($items)): ?>
  <div class="brt-empty">
    <svg width="44" height="44" fill="none" stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24" style="margin:0 auto 1rem;display:block;opacity:.2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
    <p style="font-size:.88rem">Belum ada berita yang dipublikasikan.</p>
  </div>
  <?php else: ?>

  <div class="brt-grid">
    <?php foreach ($items as $b):
      $bUrl     = rtrim(BASE_URL, '/') . '/berita/' . $b['slug'];
$bUrlEnc  = urlencode($bUrl);
      $bUrlEnc  = urlencode($bUrl);
      $bTitle   = urlencode($b['judul']);
      $bShareId = 'sp-' . $b['id'];
    ?>
    <div class="brt-card">
      <div class="brt-card-img">
        <?php if ($b['thumbnail']): ?>
          <img src="<?= UPLOAD_URL . '/' . htmlspecialchars($b['thumbnail']) ?>"
               alt="<?= htmlspecialchars($b['judul']) ?>" loading="lazy">
        <?php else: ?>
          <div class="brt-card-img-ph">
            <svg width="36" height="36" fill="none" stroke="currentColor" stroke-width="1.4" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
          </div>
        <?php endif; ?>
      </div>
      <div class="brt-card-body">
        <?php if ($b['kategori_nama']): ?>
        <span class="brt-card-kat"
              style="background:<?= htmlspecialchars($b['kategori_warna'] ?? '#0ea5e9') ?>22;color:<?= htmlspecialchars($b['kategori_warna'] ?? '#0ea5e9') ?>;border:1px solid <?= htmlspecialchars($b['kategori_warna'] ?? '#0ea5e9') ?>44">
          <?= htmlspecialchars($b['kategori_nama']) ?>
        </span>
        <?php endif; ?>
        <a href="<?= BASE_URL ?>/berita/<?= htmlspecialchars($b['slug']) ?>" class="brt-card-title">
          <?= htmlspecialchars($b['judul']) ?>
        </a>
        <p class="brt-card-ring"><?= htmlspecialchars($b['ringkasan'] ?? '') ?></p>
        <div class="brt-card-meta">
          <span><?= $b['published_at'] ? date('d M Y', strtotime($b['published_at'])) : '' ?></span>
          <div class="brt-card-stats">
            <span class="brt-stat" title="Views">
              <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
              <?= number_format($b['views']) ?>
            </span>
            <span class="brt-stat" title="Likes">
              <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
              <?= $b['total_likes'] ?>
            </span>
            <span class="brt-stat" title="Komentar">
              <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
              <?= $b['total_komentar'] ?>
            </span>
          </div>
        </div>
      </div>

      <!-- Share footer -->
      <div class="brt-card-footer">
        <div class="brt-share-wrap">
          <button class="brt-share-btn" type="button" onclick="brtToggleShare('<?= $bShareId ?>', event)">
            <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
            Bagikan
          </button>
          <div class="brt-share-popup" id="<?= $bShareId ?>">
            <div class="brt-share-popup-row">
              <!-- WhatsApp -->
              <a href="https://wa.me/?text=<?= $bTitle ?>%20<?= $bUrlEnc ?>"
                 target="_blank" rel="noopener noreferrer"
                 class="sh-icon sh-wa" title="WhatsApp" aria-label="WhatsApp">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
              </a>
              <!-- Facebook -->
              <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $bUrlEnc ?>"
                 target="_blank" rel="noopener noreferrer"
                 class="sh-icon sh-fb" title="Facebook" aria-label="Facebook">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
              </a>
              <!-- Twitter/X -->
              <a href="https://twitter.com/intent/tweet?text=<?= $bTitle ?>&url=<?= $bUrlEnc ?>"
                 target="_blank" rel="noopener noreferrer"
                 class="sh-icon sh-tw" title="Twitter / X" aria-label="Twitter / X">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.744l7.737-8.835L1.254 2.25H8.08l4.253 5.622zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
              </a>
              <!-- TikTok -->
              <a href="https://www.tiktok.com/share?url=<?= $bUrlEnc ?>"
                 target="_blank" rel="noopener noreferrer"
                 class="sh-icon sh-tt" title="TikTok" aria-label="TikTok">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-2.88 2.5 2.89 2.89 0 0 1-2.89-2.89 2.89 2.89 0 0 1 2.89-2.89c.28 0 .54.04.79.1V9.01a6.31 6.31 0 0 0-.79-.05 6.34 6.34 0 0 0-6.34 6.34 6.34 6.34 0 0 0 6.34 6.34 6.34 6.34 0 0 0 6.33-6.34V8.69a8.18 8.18 0 0 0 4.77 1.52V6.75a4.85 4.85 0 0 1-1-.06z"/></svg>
              </a>
              <!-- Instagram -->
              <a href="https://www.instagram.com/" target="_blank" rel="noopener noreferrer"
                 class="sh-icon sh-ig" title="Instagram" aria-label="Instagram">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
              </a>
              <!-- Salin link -->
              <button class="sh-icon sh-copy brt-copy-btn"
                      data-url="<?= htmlspecialchars($bUrl) ?>"
                      title="Salin link" aria-label="Salin link" type="button">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
              </button>
            </div>
          </div>
        </div>
      </div>

    </div>
    <?php endforeach; ?>
  </div>

  <?php if ($pages > 1): ?>
  <?php $qs = $katAktif ? '?kategori='.urlencode($katAktif['slug']).'&page=' : '?page='; ?>
  <div class="brt-pag">
    <a href="<?= BASE_URL ?>/berita<?= $qs.max(1,$page-1) ?>" class="<?= $page<=1?'disabled':'' ?>">‹</a>
    <?php for ($i=1;$i<=$pages;$i++): ?>
    <a href="<?= BASE_URL ?>/berita<?= $qs.$i ?>" class="<?= $i==$page?'active':'' ?>"><?= $i ?></a>
    <?php endfor; ?>
    <a href="<?= BASE_URL ?>/berita<?= $qs.min($pages,$page+1) ?>" class="<?= $page>=$pages?'disabled':'' ?>">›</a>
  </div>
  <?php endif; ?>

  <?php endif; ?>
</div>

<script>
(function(){
  'use strict';

  /* ---- Toggle share popup ---- */
  window.brtToggleShare = function(id, e) {
    e.stopPropagation();
    var popup = document.getElementById(id);
    var isOpen = popup.classList.contains('open');
    // close all
    document.querySelectorAll('.brt-share-popup.open').forEach(function(p){ p.classList.remove('open'); });
    if (!isOpen) popup.classList.add('open');
  };

  /* ---- Close on outside click ---- */
  document.addEventListener('click', function(){
    document.querySelectorAll('.brt-share-popup.open').forEach(function(p){ p.classList.remove('open'); });
  });

  /* ---- Salin link per card ---- */
  document.querySelectorAll('.brt-copy-btn').forEach(function(btn){
    btn.addEventListener('click', function(e){
      e.stopPropagation();
      var url = btn.dataset.url;
      navigator.clipboard.writeText(url).then(function(){
        var svg = btn.querySelector('svg');
        var orig = svg.outerHTML;
        svg.outerHTML = '<svg width="14" height="14" fill="none" stroke="#22c55e" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>';
        btn.style.borderColor = 'rgba(34,197,94,.4)';
        btn.title = 'Tersalin!';
        setTimeout(function(){
          // re-query after outerHTML replacement
          var b = document.querySelector('.brt-copy-btn[data-url="'+url+'"]');
          if(b){ b.querySelector('svg').outerHTML = orig; b.style.borderColor=''; b.title='Salin link'; }
        }, 2500);
      });
    });
  });

})();
</script>