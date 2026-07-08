<?php
// app/views/pages/berita.php
// Variabel: $items, $kategoriList, $katAktif, $page, $pages, $total
// Layout main.php sudah menyediakan header/footer
?>
<style>
/* ═══════════════════════════════════════════
   BERITA PAGE — mengikuti Design System
   (token asli didefinisikan global di layout;
    fallback disertakan bila halaman ini dirender berdiri sendiri)
═══════════════════════════════════════════ */
.brt-root {
  --tx-primary:   var(--c-ink,    #0f172a);
  --tx-secondary: var(--c-muted,  #64748b);
  --tx-muted:     var(--c-muted2, #94a3b8);
  --bg-page:      var(--c-page,   #eef2f6);
  --bg-surface:   var(--c-white,  #ffffff);
  --bg-elevated:  #f8fafc;
  --bd-subtle:    var(--c-border, #e6ebf1);
  --ac:           var(--c-primary,    #0e7490);
  --ac-dk:        var(--c-primary-dk, #0b5a70);
  --ac-lt:        var(--c-primary-lt, #06b6d4);
  --green:      var(--c-green-text,   #15803d);
  --r-sm: var(--radius-sm, 9px);
  --r-md: var(--radius-md, 13px);
  --r-lg: var(--radius-lg, 22px);
  --font-ui: var(--ff, 'Plus Jakarta Sans', sans-serif);
  font-family: var(--font-ui);
}

.brt-hero{background:var(--bg-surface);border-bottom:1px solid var(--bd-subtle);padding:3rem 0 2.2rem}
.brt-hero-inner{max-width:1200px;margin:0 auto;padding:0 2rem}
.brt-hero .eyebrow{display:inline-flex;align-items:center;gap:8px;font-size:.7rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--ac)}
.brt-hero .eyebrow-bar{width:16px;height:2px;border-radius:2px;background:var(--ac)}
.brt-hero h1{font-size:clamp(1.6rem,3vw,2.2rem);font-weight:800;color:var(--ac-dk);letter-spacing:-.035em;margin-bottom:.4rem}
.brt-hero p{font-size:.88rem;color:var(--tx-secondary)}

.brt-wrap{max-width:1200px;margin:0 auto;padding:2.5rem 2rem}

/* ---- Filter ---- */
.brt-filter{display:flex;gap:.5rem;flex-wrap:wrap;margin-bottom:2rem;align-items:center}
.brt-filter-label{font-size:.65rem;font-weight:700;color:var(--tx-muted);text-transform:uppercase;letter-spacing:.1em;margin-right:.3rem}
.brt-btn{padding:6px 15px;border-radius:99px;font-size:.76rem;font-weight:700;border:1px solid var(--bd-subtle);color:var(--tx-secondary);background:var(--bg-surface);text-decoration:none;transition:all .18s;white-space:nowrap}
.brt-btn:hover{color:var(--tx-primary);border-color:#d7dee7;background:var(--bg-elevated)}
.brt-btn.active{background:var(--ac);border-color:var(--ac);color:#fff}

/* ---- Grid & Card ---- */
.brt-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:1.2rem}

.brt-card{background:var(--bg-surface);border:1px solid var(--bd-subtle);border-radius:var(--r-md);overflow:hidden;display:flex;flex-direction:column;transition:all .28s cubic-bezier(.22,1,.36,1)}
.brt-card:hover{border-color:rgba(14,116,144,.28);transform:translateY(-3px);box-shadow:0 16px 36px -14px rgba(15,23,42,.18), 0 4px 14px rgba(15,23,42,.05)}

.brt-card-img{aspect-ratio:16/9;overflow:hidden;background:var(--bg-elevated);position:relative}
.brt-card-img img{width:100%;height:100%;object-fit:cover;display:block;transition:transform .4s}
.brt-card:hover .brt-card-img img{transform:scale(1.04)}
.brt-card-img-ph{width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:var(--tx-muted)}

.brt-card-body{padding:1.1rem;flex:1;display:flex;flex-direction:column}
.brt-card-kat{display:inline-block;font-size:.62rem;font-weight:700;letter-spacing:.06em;text-transform:uppercase;padding:3px 10px;border-radius:99px;margin-bottom:.65rem;width:fit-content}
.brt-card-title{font-size:.94rem;font-weight:800;color:var(--tx-primary);line-height:1.3;margin-bottom:.5rem;letter-spacing:-.022em;text-decoration:none;display:block;transition:color .18s}
.brt-card-title:hover{color:var(--ac)}
.brt-card-ring{font-size:.8rem;color:var(--tx-secondary);line-height:1.72;flex:1;margin-bottom:.9rem;display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden}

.brt-card-meta{display:flex;align-items:center;justify-content:space-between;font-size:.68rem;color:var(--tx-muted);font-weight:500}
.brt-card-stats{display:flex;gap:8px}
.brt-stat{display:flex;align-items:center;gap:3px}

/* ---- Share footer ---- */
.brt-card-footer{padding:.75rem 1.1rem .9rem;border-top:1px solid var(--bd-subtle);position:relative}
.brt-share-wrap{position:relative}
.brt-share-btn{display:inline-flex;align-items:center;gap:5px;font-size:.68rem;font-weight:700;color:var(--tx-secondary);background:var(--bg-elevated);border:1px solid var(--bd-subtle);border-radius:var(--r-sm);padding:5px 11px;cursor:pointer;transition:all .18s;white-space:nowrap}
.brt-share-btn:hover{color:var(--tx-primary);border-color:#d7dee7;background:#eef2f6}
.brt-share-btn:focus-visible{outline:2px solid var(--ac-lt);outline-offset:2px}

.brt-share-popup{display:none;position:absolute;bottom:calc(100% + 6px);left:0;background:var(--bg-surface);border:1px solid var(--bd-subtle);border-radius:var(--r-md);padding:.5rem;box-shadow:0 20px 48px -14px rgba(15,23,42,.22), 0 4px 16px rgba(15,23,42,.06);z-index:99;min-width:220px}
.brt-share-popup.open{display:block;animation:brtPopIn .16s ease}
@keyframes brtPopIn{from{opacity:0;transform:translateY(4px)}to{opacity:1;transform:translateY(0)}}
.brt-share-popup-row{display:flex;align-items:center;gap:.4rem;flex-wrap:wrap}

.sh-icon{display:inline-flex;align-items:center;justify-content:center;width:34px;height:34px;border-radius:var(--r-sm);border:none;cursor:pointer;text-decoration:none;transition:opacity .18s,transform .15s,box-shadow .18s;flex-shrink:0}
.sh-icon:hover{opacity:.9;transform:translateY(-2px);box-shadow:0 6px 16px rgba(15,23,42,.18)}
.sh-icon:active{transform:translateY(0)}
.sh-icon:focus-visible{outline:2px solid var(--ac-lt);outline-offset:2px}
.sh-icon svg{display:block}
.sh-wa{background:#22c55e;color:#fff}
.sh-fb{background:#1877F2;color:#fff}
.sh-tw{background:#0f1419;color:#fff}
.sh-tt{background:#111;color:#fff}
.sh-ig{background:linear-gradient(135deg,#f58529,#dd2a7b,#8134af);color:#fff}
.sh-copy{background:var(--bg-elevated);color:var(--tx-secondary);border:1px solid var(--bd-subtle)}
.sh-copy:hover{color:var(--ac);border-color:rgba(14,116,144,.35);background:rgba(14,116,144,.06)}

/* ---- Empty state ---- */
.brt-empty{text-align:center;padding:4rem 2rem;color:var(--tx-muted);background:var(--bg-surface);border:1.5px dashed var(--bd-subtle);border-radius:var(--r-md)}
.brt-empty svg{margin:0 auto 1rem;display:block;opacity:.4}
.brt-empty p{font-size:.88rem;font-weight:500}

/* ---- Pagination ---- */
.brt-pag{display:flex;gap:.4rem;justify-content:center;margin-top:2.5rem;flex-wrap:wrap}
.brt-pag a{display:inline-flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:var(--r-sm);border:1px solid var(--bd-subtle);background:var(--bg-surface);color:var(--tx-secondary);font-size:.8rem;font-weight:700;text-decoration:none;transition:all .18s}
.brt-pag a.active,.brt-pag a:hover{background:var(--ac);border-color:var(--ac);color:#fff}
.brt-pag a.disabled{opacity:.35;pointer-events:none}

@media(max-width:1024px){.brt-grid{grid-template-columns:repeat(2,1fr)}}
@media(max-width:640px){
  .brt-grid{grid-template-columns:1fr}
  .brt-wrap{padding:2rem 1.2rem}
  .brt-filter{gap:.4rem}
}
</style>

<div class="brt-root">

<div class="brt-hero">
  <div class="brt-hero-inner">
    <div class="eyebrow" style="margin-bottom:.5rem"><span class="eyebrow-bar"></span>Berita</div>
    <h1>Berita &amp; Artikel</h1>
    <p>Informasi terbaru kegiatan, prestasi, dan program <?= htmlspecialchars($settings['org_name']['value'] ?? 'COM SMKN 2 Pinrang') ?></p>
  </div>
</div>

<div class="brt-wrap">

  <!-- Filter Kategori -->
  <div class="brt-filter">
    <span class="brt-filter-label">Filter:</span>
    <a href="<?= BASE_URL ?>/berita" class="brt-btn <?= !$katAktif ? 'active' : '' ?>">Semua</a>
    <?php foreach ($kategoriList as $k):
      $isAktif = $katAktif && $katAktif['id'] == $k['id'];
    ?>
    <a href="<?= BASE_URL ?>/berita?kategori=<?= urlencode($k['slug']) ?>"
       class="brt-btn <?= $isAktif ? 'active' : '' ?>"
       style="<?= $isAktif ? 'background:'.htmlspecialchars($k['warna']).';border-color:'.htmlspecialchars($k['warna']).';color:#fff' : '' ?>">
      <?= htmlspecialchars($k['nama']) ?>
    </a>
    <?php endforeach; ?>
  </div>

  <?php if (empty($items)): ?>

  <!-- Empty state -->
  <div class="brt-empty">
    <svg width="40" height="40" fill="none" stroke="currentColor" stroke-width="1.4" viewBox="0 0 24 24">
      <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
      <polyline points="14 2 14 8 20 8"/>
    </svg>
    <p>Belum ada berita yang dipublikasikan.</p>
  </div>

  <?php else: ?>

  <div class="brt-grid">
    <?php foreach ($items as $b):
      $bUrl     = rtrim(BASE_URL, '/') . '/berita/' . $b['slug'];
      $bUrlEnc  = urlencode($bUrl);
      $bTitle   = urlencode($b['judul']);
      $bShareId = 'sp-' . $b['id'];
      $bKatColor = htmlspecialchars($b['kategori_warna'] ?? '#0e7490');
    ?>
    <article class="brt-card">

      <div class="brt-card-img">
        <?php if (!empty($b['thumbnail'])): ?>
          <img src="<?= UPLOAD_URL . '/' . htmlspecialchars($b['thumbnail']) ?>"
               alt="<?= htmlspecialchars($b['judul']) ?>" loading="lazy">
        <?php else: ?>
          <div class="brt-card-img-ph">
            <svg width="32" height="32" fill="none" stroke="currentColor" stroke-width="1.4" viewBox="0 0 24 24">
              <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
              <polyline points="14 2 14 8 20 8"/>
            </svg>
          </div>
        <?php endif; ?>
      </div>

      <div class="brt-card-body">
        <?php if (!empty($b['kategori_nama'])): ?>
        <span class="brt-card-kat" style="background:<?= $bKatColor ?>1a;color:<?= $bKatColor ?>;border:1px solid <?= $bKatColor ?>44">
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
          <button class="brt-share-btn" type="button" onclick="brtToggleShare('<?= $bShareId ?>', event)" aria-haspopup="true" aria-expanded="false">
            <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
            Bagikan
          </button>

          <div class="brt-share-popup" id="<?= $bShareId ?>">
            <div class="brt-share-popup-row">

              <a href="https://wa.me/?text=<?= $bTitle ?>%20<?= $bUrlEnc ?>"
                 target="_blank" rel="noopener noreferrer"
                 class="sh-icon sh-wa" title="Bagikan ke WhatsApp" aria-label="Bagikan ke WhatsApp">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
              </a>

              <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $bUrlEnc ?>"
                 target="_blank" rel="noopener noreferrer"
                 class="sh-icon sh-fb" title="Bagikan ke Facebook" aria-label="Bagikan ke Facebook">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
              </a>

              <a href="https://twitter.com/intent/tweet?text=<?= $bTitle ?>&url=<?= $bUrlEnc ?>"
                 target="_blank" rel="noopener noreferrer"
                 class="sh-icon sh-tw" title="Bagikan ke X / Twitter" aria-label="Bagikan ke X / Twitter">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.744l7.737-8.835L1.254 2.25H8.08l4.253 5.622zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
              </a>

              <a href="https://www.tiktok.com/share?url=<?= $bUrlEnc ?>"
                 target="_blank" rel="noopener noreferrer"
                 class="sh-icon sh-tt" title="Bagikan ke TikTok" aria-label="Bagikan ke TikTok">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-2.88 2.5 2.89 2.89 0 0 1-2.89-2.89 2.89 2.89 0 0 1 2.89-2.89c.28 0 .54.04.79.1V9.01a6.31 6.31 0 0 0-.79-.05 6.34 6.34 0 0 0-6.34 6.34 6.34 6.34 0 0 0 6.34 6.34 6.34 6.34 0 0 0 6.33-6.34V8.69a8.18 8.18 0 0 0 4.77 1.52V6.75a4.85 4.85 0 0 1-1-.06z"/></svg>
              </a>

              <a href="https://www.instagram.com/" target="_blank" rel="noopener noreferrer"
                 class="sh-icon sh-ig" title="Instagram" aria-label="Instagram">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
              </a>

              <button class="sh-icon sh-copy brt-copy-btn"
                      data-url="<?= htmlspecialchars($bUrl) ?>"
                      title="Salin link" aria-label="Salin link" type="button">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
              </button>

            </div>
          </div>
        </div>
      </div>

    </article>
    <?php endforeach; ?>
  </div>

  <?php if ($pages > 1):
    $qs = $katAktif ? '?kategori='.urlencode($katAktif['slug']).'&page=' : '?page=';
  ?>
  <nav class="brt-pag" aria-label="Navigasi halaman">
    <a href="<?= BASE_URL ?>/berita<?= $qs.max(1,$page-1) ?>" class="<?= $page<=1?'disabled':'' ?>" aria-label="Sebelumnya">‹</a>
    <?php for ($i=1;$i<=$pages;$i++): ?>
    <a href="<?= BASE_URL ?>/berita<?= $qs.$i ?>" class="<?= $i==$page?'active':'' ?>"><?= $i ?></a>
    <?php endfor; ?>
    <a href="<?= BASE_URL ?>/berita<?= $qs.min($pages,$page+1) ?>" class="<?= $page>=$pages?'disabled':'' ?>" aria-label="Berikutnya">›</a>
  </nav>
  <?php endif; ?>

  <?php endif; ?>
</div>

</div><!-- /.brt-root -->

<script>
(function(){
  'use strict';

  /* ---- Toggle share popup ---- */
  window.brtToggleShare = function(id, e) {
    e.stopPropagation();
    var popup = document.getElementById(id);
    var btn = e.currentTarget;
    var isOpen = popup.classList.contains('open');

    document.querySelectorAll('.brt-share-popup.open').forEach(function(p){
      p.classList.remove('open');
      var b = p.closest('.brt-share-wrap').querySelector('.brt-share-btn');
      if (b) b.setAttribute('aria-expanded', 'false');
    });

    if (!isOpen) {
      popup.classList.add('open');
      btn.setAttribute('aria-expanded', 'true');
    }
  };

  /* ---- Close on outside click / Escape ---- */
  document.addEventListener('click', function(){
    document.querySelectorAll('.brt-share-popup.open').forEach(function(p){
      p.classList.remove('open');
    });
    document.querySelectorAll('.brt-share-btn[aria-expanded="true"]').forEach(function(b){
      b.setAttribute('aria-expanded', 'false');
    });
  });
  document.addEventListener('keydown', function(e){
    if (e.key === 'Escape') {
      document.querySelectorAll('.brt-share-popup.open').forEach(function(p){
        p.classList.remove('open');
      });
    }
  });

  /* ---- Salin link per card ---- */
  document.querySelectorAll('.brt-copy-btn').forEach(function(btn){
    btn.addEventListener('click', function(e){
      e.stopPropagation();
      var url = btn.dataset.url;
      navigator.clipboard.writeText(url).then(function(){
        var svg = btn.querySelector('svg');
        var orig = svg.outerHTML;
        svg.outerHTML = '<svg width="14" height="14" fill="none" stroke="#15803d" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>';
        btn.style.borderColor = 'rgba(21,128,61,.4)';
        btn.title = 'Tersalin!';
        setTimeout(function(){
          var b = document.querySelector('.brt-copy-btn[data-url="'+url+'"]');
          if (b) {
            b.querySelector('svg').outerHTML = orig;
            b.style.borderColor = '';
            b.title = 'Salin link';
          }
        }, 2500);
      });
    });
  });

})();
</script>