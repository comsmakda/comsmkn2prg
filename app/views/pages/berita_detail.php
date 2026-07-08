<?php
// app/views/pages/berita_detail.php
// Variabel: $berita, $komentar, $related, $isLiked, $totalLikes, $flash
$shareUrl   = rtrim(BASE_URL, '/') . '/berita/' . $berita['slug'];
$shareTitle = urlencode($berita['judul']);
$catColor   = htmlspecialchars($berita['kategori_warna'] ?? '#0e7490');
?>
<!-- Font & icon set mengikuti design system (idempotent bila sudah di-load di layout utama) -->
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

<style>
*, *::before, *::after { box-sizing: border-box; }

@media (prefers-reduced-motion: reduce) {
  * { transition-duration: .01ms !important; animation-duration: .01ms !important; }
}

/* ── Design tokens (fallback bila belum ada di layout global) ── */
.bd-page {
  --c-page:        #eef2f6;
  --c-white:       #ffffff;
  --c-ink:         #0f172a;
  --c-muted:       #64748b;
  --c-muted2:      #94a3b8;
  --c-border:      #e6ebf1;
  --c-primary:     #0e7490;
  --c-primary-dk:  #0b5a70;
  --c-primary-lt:  #06b6d4;
  --c-red-bg:      #fef2f2;
  --c-red-border:  #fecaca;
  --c-red-text:    #b91c1c;
  --c-green-bg:    #f0fdf4;
  --c-green-border:#bbf7d0;
  --c-green-text:  #15803d;
  --radius-sm: 9px;
  --radius-md: 13px;
  --radius-lg: 22px;

  position: relative;
  font-family: 'Plus Jakarta Sans', sans-serif;
  max-width: 1180px;
  margin: 0 auto;
  padding: 2.25rem 1.5rem 4rem;
  color: var(--c-ink);
}

/* Full-bleed canvas: memastikan area ini tetap terang meski layout induk gelap */
.bd-page::before {
  content: "";
  position: absolute;
  top: 0;
  bottom: 0;
  left: 50%;
  width: 100vw;
  transform: translateX(-50%);
  background: var(--c-page);
  z-index: -1;
}

/* ── Breadcrumb ── */
.bd-breadcrumb {
  display: flex;
  align-items: center;
  gap: 6px;
  margin-bottom: 1.75rem;
  font-size: .78rem;
  font-weight: 500;
  color: var(--c-muted);
}
.bd-breadcrumb a {
  color: var(--c-muted);
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 5px;
  transition: color .18s;
}
.bd-breadcrumb a:hover, .bd-breadcrumb a:focus-visible { color: var(--c-primary); }
.bd-breadcrumb i { font-size: 14px; }
.bd-breadcrumb-sep { opacity: .5; font-size: .7rem; }
.bd-breadcrumb [aria-current="page"] { color: var(--c-ink); font-weight: 600; }

/* ── Main grid ── */
.bd-grid {
  display: grid;
  grid-template-columns: minmax(0, 1fr) 320px;
  gap: 2.5rem;
  align-items: start;
}

/* ── Article container (panel besar, §5.1) ── */
.bd-article-card {
  background: var(--c-white);
  border-radius: var(--radius-lg);
  box-shadow: 0 30px 70px -20px rgba(15,23,42,.14), 0 4px 18px rgba(15,23,42,.05);
  padding: 2rem 2.2rem;
}

/* ── Article header ── */
.bd-header { margin-bottom: 1.5rem; }

.bd-category {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  font-size: .68rem;
  font-weight: 700;
  letter-spacing: .04em;
  text-transform: uppercase;
  padding: 5px 13px;
  border-radius: var(--radius-sm);
  margin-bottom: .9rem;
}

.bd-title {
  font-size: clamp(1.5rem, 3.2vw, 2.1rem);
  font-weight: 800;
  color: var(--c-primary-dk);
  line-height: 1.24;
  letter-spacing: -.03em;
  margin: 0 0 1.1rem;
}

.bd-meta {
  display: flex;
  align-items: center;
  flex-wrap: wrap;
  gap: .3rem 1.1rem;
  padding: .9rem 0;
  border-top: 1px solid var(--c-border);
  border-bottom: 1px solid var(--c-border);
}
.bd-meta-chip {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  font-size: .78rem;
  font-weight: 500;
  color: var(--c-muted);
}
.bd-meta-chip i { font-size: 15px; color: var(--c-muted2); }

/* ── Cover image ── */
.bd-cover {
  margin: 1.5rem 0;
  border-radius: var(--radius-md);
  overflow: hidden;
  aspect-ratio: 16 / 9;
  background: var(--c-page);
  border: 1px solid var(--c-border);
  contain: layout paint;
}
.bd-cover img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
  transition: transform .5s ease;
}
.bd-cover:hover img { transform: scale(1.02); }

/* ── Article body ── */
.bd-body {
  font-size: .92rem;
  font-weight: 500;
  color: var(--c-ink);
  line-height: 1.85;
  margin-bottom: 2rem;
  overflow-wrap: break-word;
}
.bd-body h2 {
  color: var(--c-primary-dk);
  font-size: 1.2rem;
  font-weight: 800;
  margin: 1.9rem 0 .7rem;
  letter-spacing: -.02em;
  padding-bottom: .5rem;
  border-bottom: 2px solid var(--c-border);
}
.bd-body h3 {
  color: var(--c-ink);
  font-size: 1.02rem;
  font-weight: 700;
  margin: 1.5rem 0 .5rem;
  letter-spacing: -.01em;
}
.bd-body p { margin-bottom: 1.05rem; }
.bd-body ul, .bd-body ol { margin: 0 0 1.05rem 1.4rem; }
.bd-body li { margin-bottom: .4rem; }
.bd-body img { max-width: 100%; height: auto; border-radius: var(--radius-md); margin: 1.1rem 0; display: block; border: 1px solid var(--c-border); }
.bd-body blockquote {
  margin: 1.5rem 0;
  padding: 1rem 1.2rem;
  border-left: 3px solid var(--c-primary-lt);
  background: rgba(6,182,212,.06);
  border-radius: 0 var(--radius-sm) var(--radius-sm) 0;
  color: var(--c-ink);
  font-style: italic;
}
.bd-body a { color: var(--c-primary); text-decoration: underline; text-underline-offset: 2px; font-weight: 600; }
.bd-body strong { color: var(--c-primary-dk); }
.bd-body hr { border: none; border-top: 1px solid var(--c-border); margin: 1.9rem 0; }

/* ── Engagement panel (share + like unified, one visual block) ── */
.bd-engage {
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 1rem;
  padding: 1rem 1.25rem;
  background: var(--c-page);
  border: 1px solid var(--c-border);
  border-radius: var(--radius-md);
  margin: 0 0 2.25rem;
}

.icon-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  border: none;
  cursor: pointer;
  text-decoration: none;
  transition: opacity .18s, transform .15s, box-shadow .18s, background .18s, color .18s, border-color .18s;
  flex-shrink: 0;
  font-family: inherit;
}
.icon-btn:focus-visible { outline: 2px solid var(--c-primary-lt); outline-offset: 2px; }
.icon-btn i { display: block; }

.bd-like-btn {
  gap: 8px;
  padding: 9px 18px;
  border-radius: var(--radius-sm);
  border: 1.5px solid var(--c-border);
  background: var(--c-white);
  color: var(--c-ink);
  font-size: .82rem;
  font-weight: 700;
  white-space: nowrap;
}
.bd-like-btn i { font-size: 16px; transition: transform .25s; }
.bd-like-btn:hover { border-color: rgba(14,116,144,.3); transform: translateY(-1px); }
.bd-like-btn:hover i { transform: scale(1.15); }
.bd-like-btn.liked {
  background: var(--c-primary);
  border-color: var(--c-primary);
  color: #fff;
  box-shadow: 0 8px 18px rgba(14,116,144,.22);
}
.bd-like-btn:disabled { opacity: .6; cursor: not-allowed; transform: none; }
.bd-like-count {
  font-size: .78rem;
  font-weight: 600;
  color: var(--c-muted);
  white-space: nowrap;
}
.bd-like-count strong { color: var(--c-ink); font-weight: 800; }
.bd-engage-left { display: flex; align-items: center; gap: 1rem; flex-wrap: wrap; }

.bd-share-icons { display: flex; align-items: center; gap: .5rem; flex-wrap: wrap; }
.sh-icon { width: 36px; height: 36px; border-radius: var(--radius-sm); }
.sh-icon i { font-size: 16px; }
.sh-icon:hover { transform: translateY(-2px); box-shadow: 0 8px 18px rgba(15,23,42,.16); }

/* Brand icons mempertahankan warna resmi masing-masing platform (bukan bagian dari sistem aksen) */
.sh-wa   { background: #22c55e; color: #fff; }
.sh-fb   { background: #1877F2; color: #fff; }
.sh-tw   { background: #0f1419; color: #fff; }
.sh-tt   { background: #111;    color: #fff; }
.sh-ig   { background: linear-gradient(135deg,#f58529,#dd2a7b,#8134af); color: #fff; }
.sh-copy { background: var(--c-white); color: var(--c-muted); border: 1.5px solid var(--c-border); }
.sh-copy:hover { color: var(--c-primary); border-color: rgba(14,116,144,.35); background: rgba(6,182,212,.08); box-shadow: none; }

.bd-engage-divider {
  width: 1px;
  align-self: stretch;
  background: var(--c-border);
}

/* ── Comments (below the fold: defer rendering cost) ── */
.bd-comments { margin-top: .25rem; content-visibility: auto; contain-intrinsic-size: 800px; }
.bd-comments-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 1.1rem;
}
.bd-comments-title {
  font-size: 1rem;
  font-weight: 800;
  color: var(--c-primary-dk);
  letter-spacing: -.02em;
}
.bd-comments-count {
  font-size: .72rem;
  font-weight: 700;
  color: var(--c-muted);
  background: var(--c-page);
  border: 1px solid var(--c-border);
  border-radius: 99px;
  padding: 3px 11px;
}
.bd-no-comments {
  text-align: center;
  padding: 2rem 1rem;
  background: var(--c-page);
  border: 1px dashed var(--c-border);
  border-radius: var(--radius-md);
  margin-bottom: 1.5rem;
}
.bd-no-comments p { font-size: .84rem; font-weight: 500; color: var(--c-muted); margin: 0; }

.bd-comment-list { display: flex; flex-direction: column; gap: .6rem; margin-bottom: 1.75rem; }
.bd-comment {
  background: var(--c-white);
  border: 1px solid var(--c-border);
  border-radius: var(--radius-md);
  padding: 1rem 1.1rem;
  transition: border-color .18s, box-shadow .18s;
}
.bd-comment:hover { border-color: rgba(14,116,144,.25); box-shadow: 0 10px 22px rgba(15,23,42,.06); }
.bd-comment-head {
  display: flex;
  align-items: center;
  gap: .7rem;
  margin-bottom: .6rem;
}
.bd-comment-avatar {
  width: 36px;
  height: 36px;
  border-radius: 50%;
  background: linear-gradient(135deg, var(--c-primary), var(--c-primary-dk));
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 800;
  font-size: .68rem;
  color: #fff;
  flex-shrink: 0;
  letter-spacing: .02em;
}
.bd-comment-name { font-weight: 700; font-size: .84rem; color: var(--c-ink); line-height: 1.2; }
.bd-comment-date { font-size: .68rem; font-weight: 500; color: var(--c-muted2); margin-top: 2px; }
.bd-comment-body {
  font-size: .84rem;
  font-weight: 500;
  color: var(--c-ink);
  line-height: 1.75;
  padding-left: calc(36px + .7rem);
  overflow-wrap: break-word;
}

/* ── Comment form ── */
.bd-comment-form {
  background: var(--c-white);
  border: 1px solid var(--c-border);
  border-radius: var(--radius-md);
  overflow: hidden;
}
.bd-comment-form-head {
  padding: 1rem 1.3rem .8rem;
  border-bottom: 1px solid var(--c-border);
  background: var(--c-page);
}
.bd-comment-form-title {
  font-size: .9rem;
  font-weight: 800;
  color: var(--c-primary-dk);
  letter-spacing: -.01em;
}
.bd-comment-form-body { padding: 1.2rem 1.3rem 1.3rem; }
.f-row2 { display: grid; grid-template-columns: 1fr 1fr; gap: .6rem; margin-bottom: .6rem; }
.f-group { display: flex; flex-direction: column; gap: .35rem; margin-bottom: .6rem; }
.f-label {
  font-size: .74rem;
  font-weight: 700;
  color: var(--c-ink);
}
.f-label span { color: var(--c-red-text); }
.f-field {
  background: #fbfcfe;
  border: 1.5px solid var(--c-border);
  border-radius: var(--radius-sm);
  padding: 12px 14px;
  font-size: .88rem;
  font-weight: 500;
  color: var(--c-ink);
  outline: none;
  font-family: inherit;
  transition: border .16s, box-shadow .16s, background .16s;
  width: 100%;
}
.f-field:focus {
  border-color: var(--c-primary-lt);
  box-shadow: 0 0 0 3px rgba(6,182,212,.12);
  background: #fff;
}
.f-field::placeholder { color: var(--c-muted2); }
textarea.f-field { resize: vertical; min-height: 100px; }
.f-hint { font-size: .72rem; font-weight: 500; color: var(--c-muted2); line-height: 1.55; margin-bottom: .9rem; }
.f-submit {
  gap: 7px;
  padding: 12px 24px;
  background: var(--c-primary);
  border-radius: var(--radius-sm);
  font-size: .85rem;
  font-weight: 800;
  color: #fff;
  box-shadow: 0 8px 20px rgba(14,116,144,.24);
}
.f-submit:hover { background: var(--c-primary-lt); transform: translateY(-2px); box-shadow: 0 12px 26px rgba(6,182,212,.3); }

/* ── Sidebar ── */
.bd-sidebar {
  position: sticky;
  top: 1.5rem;
  display: flex;
  flex-direction: column;
  gap: 1rem;
}
.sb-block {
  background: var(--c-white);
  border: 1px solid var(--c-border);
  border-radius: var(--radius-md);
  overflow: hidden;
}
.sb-head {
  padding: .85rem 1.1rem;
  border-bottom: 1px solid var(--c-border);
  background: var(--c-page);
}
.sb-head-label {
  font-size: .68rem;
  color: var(--c-primary);
  text-transform: uppercase;
  letter-spacing: .08em;
  font-weight: 800;
}
.sb-body { padding: .5rem .8rem .8rem; }

.rel-item {
  display: flex;
  align-items: flex-start;
  gap: .65rem;
  padding: .65rem .3rem;
  border-bottom: 1px solid var(--c-border);
  border-radius: var(--radius-sm);
  margin: 0 -.3rem;
  transition: background .15s;
}
.rel-item:last-child { border-bottom: none; }
.rel-item:hover { background: var(--c-page); }
.rel-thumb {
  width: 68px;
  height: 48px;
  border-radius: 8px;
  overflow: hidden;
  background: var(--c-page);
  border: 1px solid var(--c-border);
  flex-shrink: 0;
}
.rel-thumb img { width: 100%; height: 100%; object-fit: cover; display: block; }
.rel-thumb-empty { width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: var(--c-muted2); }
.rel-thumb-empty i { font-size: 18px; }
.rel-link {
  font-size: .8rem;
  font-weight: 700;
  color: var(--c-ink);
  text-decoration: none;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
  line-height: 1.4;
  transition: color .18s;
}
.rel-link:hover, .rel-link:focus-visible { color: var(--c-primary); }
.rel-date { font-size: .68rem; font-weight: 500; color: var(--c-muted2); margin-top: 4px; }

/* ── Sidebar: Info Artikel (stats) — always rendered so sidebar is never empty ── */
.stat-list { display: flex; flex-direction: column; }
.stat-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: .75rem;
  padding: .6rem .2rem;
  border-bottom: 1px solid var(--c-border);
}
.stat-row:last-child { border-bottom: none; }
.stat-label {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: .78rem;
  font-weight: 500;
  color: var(--c-muted);
}
.stat-label i { font-size: 15px; color: var(--c-muted2); }
.stat-value {
  font-size: .8rem;
  font-weight: 700;
  color: var(--c-ink);
  white-space: nowrap;
}
.stat-value.is-liked { color: var(--c-primary); }

/* ── Sidebar: fallback CTA when there is no related news ── */
.sb-cta {
  padding: 1.4rem 1.1rem;
  text-align: center;
}
.sb-cta p {
  font-size: .8rem;
  font-weight: 500;
  color: var(--c-muted);
  line-height: 1.6;
  margin: 0 0 .9rem;
}
.sb-cta-btn {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 9px 18px;
  border-radius: var(--radius-sm);
  background: var(--c-primary);
  color: #fff;
  font-size: .8rem;
  font-weight: 700;
  text-decoration: none;
  box-shadow: 0 8px 18px rgba(14,116,144,.22);
  transition: background .18s, transform .15s;
}
.sb-cta-btn:hover { background: var(--c-primary-lt); transform: translateY(-1px); }

/* ── Responsive (mobile-first overrides, satu breakpoint utama) ── */
@media (max-width: 960px) {
  .bd-grid { grid-template-columns: 1fr; }
  .bd-sidebar { position: static; }
}
@media (max-width: 600px) {
  .bd-page { padding: 1.5rem 1rem 3rem; }
  .bd-article-card { padding: 1.4rem 1.1rem; border-radius: var(--radius-md); box-shadow: none; }
  .f-row2 { grid-template-columns: 1fr; }
  .bd-title { font-size: 1.5rem; }
  .bd-engage { flex-direction: column; align-items: stretch; }
  .bd-engage-left { justify-content: space-between; }
  .bd-engage-divider { display: none; }
  /* Touch target minimum 44px */
  .sh-icon { width: 44px; height: 44px; }
  .bd-like-btn { padding: 10px 18px; min-height: 44px; }
}
</style>

<?php if (!empty($flash)): ?>
<div style="max-width:1180px;margin:1rem auto 0;padding:0 1.5rem">
  <div class="alert alert-<?= $flash['type'] ?>" role="alert"><?= htmlspecialchars($flash['msg']) ?></div>
</div>
<?php endif; ?>

<div class="bd-page">

  <!-- Breadcrumb -->
  <nav class="bd-breadcrumb" aria-label="Navigasi">
    <a href="<?= BASE_URL ?>">
      <i class="ti ti-home" aria-hidden="true"></i>
      Beranda
    </a>
    <span class="bd-breadcrumb-sep" aria-hidden="true">
      <i class="ti ti-chevron-right"></i>
    </span>
    <a href="<?= BASE_URL ?>/berita">Berita</a>
    <?php if ($berita['kategori_nama']): ?>
    <span class="bd-breadcrumb-sep" aria-hidden="true">
      <i class="ti ti-chevron-right"></i>
    </span>
    <span aria-current="page"><?= htmlspecialchars($berita['kategori_nama']) ?></span>
    <?php endif; ?>
  </nav>

  <div class="bd-grid">

    <!-- ═══════════════════════════════════
         ARTICLE
         ═══════════════════════════════════ -->
    <article class="bd-article-card">

      <header class="bd-header">

        <?php if ($berita['kategori_nama']): ?>
        <span class="bd-category"
              style="background:<?= $catColor ?>16; color:<?= $catColor ?>; border:1px solid <?= $catColor ?>3d">
          <i class="ti ti-point-filled" style="font-size:9px" aria-hidden="true"></i>
          <?= htmlspecialchars($berita['kategori_nama']) ?>
        </span>
        <?php endif; ?>

        <h1 class="bd-title"><?= htmlspecialchars($berita['judul']) ?></h1>

        <div class="bd-meta" role="list">
          <span class="bd-meta-chip" role="listitem">
            <i class="ti ti-calendar" aria-hidden="true"></i>
            <?= $berita['published_at'] ? date('d F Y', strtotime($berita['published_at'])) : '' ?>
          </span>
          <?php if ($berita['penulis_nama']): ?>
          <span class="bd-meta-chip" role="listitem">
            <i class="ti ti-user" aria-hidden="true"></i>
            <?= htmlspecialchars($berita['penulis_nama']) ?>
          </span>
          <?php endif; ?>
          <span class="bd-meta-chip" role="listitem">
            <i class="ti ti-eye" aria-hidden="true"></i>
            <?= number_format($berita['views']) ?> views
          </span>
        </div>

      </header>

      <?php if ($berita['thumbnail']): ?>
      <figure class="bd-cover">
        <img src="<?= UPLOAD_URL . '/' . htmlspecialchars($berita['thumbnail']) ?>"
             alt="<?= htmlspecialchars($berita['judul']) ?>"
             loading="eager" fetchpriority="high" decoding="async">
      </figure>
      <?php endif; ?>

      <div class="bd-body"><?= $berita['konten'] ?></div>

      <!-- Engagement: like + share dalam satu panel yang seimbang -->
      <div class="bd-engage">
        <div class="bd-engage-left">
          <button type="button" class="icon-btn bd-like-btn <?= $isLiked ? 'liked' : '' ?>"
                  id="like-btn"
                  data-id="<?= $berita['id'] ?>"
                  data-url="<?= BASE_URL ?>/berita/<?= $berita['id'] ?>/like"
                  aria-pressed="<?= $isLiked ? 'true' : 'false' ?>">
            <i id="like-icon" class="<?= $isLiked ? 'ti ti-heart-filled' : 'ti ti-heart' ?>" aria-hidden="true"></i>
            <span id="like-lbl"><?= $isLiked ? 'Disukai' : 'Suka' ?></span>
          </button>
          <span class="bd-like-count">
            <strong id="like-cnt"><?= number_format($totalLikes) ?></strong> menyukai artikel ini
          </span>
        </div>

        <div class="bd-engage-divider" aria-hidden="true"></div>

        <div class="bd-share-icons">
          <a href="https://wa.me/?text=<?= $shareTitle ?>%20<?= urlencode($shareUrl) ?>"
             target="_blank" rel="noopener noreferrer"
             class="icon-btn sh-icon sh-wa" title="Bagikan ke WhatsApp" aria-label="Bagikan ke WhatsApp">
            <i class="ti ti-brand-whatsapp" aria-hidden="true"></i>
          </a>
          <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode($shareUrl) ?>"
             target="_blank" rel="noopener noreferrer"
             class="icon-btn sh-icon sh-fb" title="Bagikan ke Facebook" aria-label="Bagikan ke Facebook">
            <i class="ti ti-brand-facebook" aria-hidden="true"></i>
          </a>
          <a href="https://twitter.com/intent/tweet?text=<?= $shareTitle ?>&url=<?= urlencode($shareUrl) ?>"
             target="_blank" rel="noopener noreferrer"
             class="icon-btn sh-icon sh-tw" title="Bagikan ke Twitter/X" aria-label="Bagikan ke Twitter / X">
            <i class="ti ti-brand-x" aria-hidden="true"></i>
          </a>
          <a href="https://www.tiktok.com/share?url=<?= urlencode($shareUrl) ?>"
             target="_blank" rel="noopener noreferrer"
             class="icon-btn sh-icon sh-tt" title="Bagikan ke TikTok" aria-label="Bagikan ke TikTok">
            <i class="ti ti-brand-tiktok" aria-hidden="true"></i>
          </a>
          <a href="https://www.instagram.com/" target="_blank" rel="noopener noreferrer"
             class="icon-btn sh-icon sh-ig" title="Salin link, lalu bagikan di Instagram" aria-label="Bagikan ke Instagram">
            <i class="ti ti-brand-instagram" aria-hidden="true"></i>
          </a>
          <button type="button" class="icon-btn sh-icon sh-copy" id="copy-btn"
                  data-url="<?= htmlspecialchars($shareUrl) ?>"
                  title="Salin link" aria-label="Salin link">
            <i id="copy-icon" class="ti ti-copy" aria-hidden="true"></i>
          </button>
        </div>
      </div>

      <!-- Komentar -->
      <section class="bd-comments" id="komentar" aria-label="Komentar">

        <div class="bd-comments-header">
          <h2 class="bd-comments-title">Komentar</h2>
          <span class="bd-comments-count"><?= count($komentar) ?> komentar</span>
        </div>

        <?php if (empty($komentar)): ?>
        <div class="bd-no-comments">
          <p>Belum ada komentar — jadilah yang pertama berkomentar!</p>
        </div>
        <?php else: ?>
        <div class="bd-comment-list" role="list">
          <?php foreach ($komentar as $k): ?>
          <div class="bd-comment" role="listitem">
            <div class="bd-comment-head">
              <div class="bd-comment-avatar" aria-hidden="true">
                <?= strtoupper(mb_substr($k['nama'], 0, 2)) ?>
              </div>
              <div>
                <div class="bd-comment-name"><?= htmlspecialchars($k['nama']) ?></div>
                <div class="bd-comment-date">
                  <time datetime="<?= $k['created_at'] ?>"><?= date('d M Y, H:i', strtotime($k['created_at'])) ?></time>
                </div>
              </div>
            </div>
            <div class="bd-comment-body"><?= nl2br(htmlspecialchars($k['komentar'])) ?></div>
          </div>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <div class="bd-comment-form">
          <div class="bd-comment-form-head">
            <div class="bd-comment-form-title">Tulis Komentar</div>
          </div>
          <div class="bd-comment-form-body">
            <form method="POST" action="<?= BASE_URL ?>/berita/<?= htmlspecialchars($berita['slug']) ?>/komentar" novalidate>
              <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
              <div class="f-row2">
                <div class="f-group">
                  <label class="f-label" for="inp-nama">Nama <span>*</span></label>
                  <input type="text" id="inp-nama" name="nama" class="f-field"
                         placeholder="Nama kamu" required maxlength="100" autocomplete="name">
                </div>
                <div class="f-group">
                  <label class="f-label" for="inp-email">Email <span>*</span></label>
                  <input type="email" id="inp-email" name="email" class="f-field"
                         placeholder="email@kamu.com" required maxlength="150" autocomplete="email">
                </div>
              </div>
              <div class="f-group">
                <label class="f-label" for="inp-komentar">Komentar <span>*</span></label>
                <textarea id="inp-komentar" name="komentar" class="f-field"
                          placeholder="Tulis komentarmu di sini…" required maxlength="1000"></textarea>
              </div>
              <p class="f-hint">* Email tidak akan ditampilkan. Komentar akan muncul setelah disetujui admin.</p>
              <button type="submit" class="icon-btn f-submit">
                Kirim Komentar
                <i class="ti ti-send-2" aria-hidden="true"></i>
              </button>
            </form>
          </div>
        </div>

      </section>
    </article>

    <!-- ═══════════════════════════════════
         SIDEBAR
         ═══════════════════════════════════ -->
    <aside class="bd-sidebar" aria-label="Sidebar">

      <!-- Info Artikel: selalu tampil agar sidebar tidak pernah kosong -->
      <div class="sb-block">
        <div class="sb-head">
          <div class="sb-head-label">Info Artikel</div>
        </div>
        <div class="sb-body">
          <div class="stat-list">
            <div class="stat-row">
              <span class="stat-label">
                <i class="ti ti-calendar" aria-hidden="true"></i>
                Dipublikasikan
              </span>
              <span class="stat-value"><?= $berita['published_at'] ? date('d M Y', strtotime($berita['published_at'])) : '-' ?></span>
            </div>
            <?php if ($berita['penulis_nama']): ?>
            <div class="stat-row">
              <span class="stat-label">
                <i class="ti ti-user" aria-hidden="true"></i>
                Penulis
              </span>
              <span class="stat-value"><?= htmlspecialchars($berita['penulis_nama']) ?></span>
            </div>
            <?php endif; ?>
            <div class="stat-row">
              <span class="stat-label">
                <i class="ti ti-eye" aria-hidden="true"></i>
                Dilihat
              </span>
              <span class="stat-value"><?= number_format($berita['views']) ?> kali</span>
            </div>
            <div class="stat-row">
              <span class="stat-label">
                <i class="<?= $isLiked ? 'ti ti-heart-filled' : 'ti ti-heart' ?>" aria-hidden="true"></i>
                Disukai
              </span>
              <span class="stat-value <?= $isLiked ? 'is-liked' : '' ?>"><?= number_format($totalLikes) ?> orang</span>
            </div>
            <div class="stat-row">
              <span class="stat-label">
                <i class="ti ti-message-circle" aria-hidden="true"></i>
                Komentar
              </span>
              <span class="stat-value"><?= count($komentar) ?> komentar</span>
            </div>
          </div>
        </div>
      </div>

      <?php if (!empty($related)): ?>
      <div class="sb-block">
        <div class="sb-head">
          <div class="sb-head-label">Berita Terkait</div>
        </div>
        <div class="sb-body">
          <?php foreach ($related as $r): ?>
          <div class="rel-item">
            <div class="rel-thumb">
              <?php if ($r['thumbnail']): ?>
                <img src="<?= UPLOAD_URL . '/' . htmlspecialchars($r['thumbnail']) ?>" alt=""
                     width="68" height="48" loading="lazy" decoding="async">
              <?php else: ?>
                <div class="rel-thumb-empty">
                  <i class="ti ti-photo" aria-hidden="true"></i>
                </div>
              <?php endif; ?>
            </div>
            <div>
              <a href="<?= BASE_URL ?>/berita/<?= htmlspecialchars($r['slug']) ?>" class="rel-link">
                <?= htmlspecialchars($r['judul']) ?>
              </a>
              <?php if ($r['published_at']): ?>
              <div class="rel-date">
                <time datetime="<?= $r['published_at'] ?>"><?= date('d M Y', strtotime($r['published_at'])) ?></time>
              </div>
              <?php endif; ?>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
      <?php else: ?>
      <div class="sb-block">
        <div class="sb-head">
          <div class="sb-head-label">Jelajahi Lainnya</div>
        </div>
        <div class="sb-cta">
          <p>Belum ada berita terkait untuk topik ini. Lihat berita lain dari Com SMKN 2 Pinrang.</p>
          <a href="<?= BASE_URL ?>/berita" class="sb-cta-btn">
            Lihat Semua Berita
            <i class="ti ti-arrow-narrow-right" aria-hidden="true"></i>
          </a>
        </div>
      </div>
      <?php endif; ?>

    </aside>
  </div><!-- /.bd-grid -->
</div><!-- /.bd-page -->

<script>
(function () {
  'use strict';

  /* ---- Like ---- */
  var likeBtn = document.getElementById('like-btn');
  if (likeBtn) {
    likeBtn.addEventListener('click', function () {
      if (likeBtn.disabled) return;
      likeBtn.disabled = true;
      fetch(likeBtn.dataset.url, {
        method: 'POST',
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      })
        .then(function (r) {
          if (!r.ok) throw new Error('Request gagal');
          return r.json();
        })
        .then(function (d) {
          document.getElementById('like-cnt').textContent = d.total.toLocaleString('id-ID');
          likeBtn.classList.toggle('liked', d.liked);
          likeBtn.setAttribute('aria-pressed', d.liked ? 'true' : 'false');
          document.getElementById('like-lbl').textContent = d.liked ? 'Disukai' : 'Suka';
          var icon = document.getElementById('like-icon');
          if (icon) icon.className = d.liked ? 'ti ti-heart-filled' : 'ti ti-heart';
        })
        .catch(function () { /* gagal senyap, biarkan user coba lagi */ })
        .finally(function () { likeBtn.disabled = false; });
    });
  }

  /* ---- Salin link ---- */
  var copyBtn = document.getElementById('copy-btn');
  if (copyBtn) {
    var resetTimer = null;

    copyBtn.addEventListener('click', function () {
      if (!navigator.clipboard) return;
      navigator.clipboard.writeText(copyBtn.dataset.url).then(function () {
        var ic = document.getElementById('copy-icon');
        if (ic) ic.className = 'ti ti-check';
        copyBtn.style.borderColor = 'rgba(21,128,61,.4)';
        copyBtn.style.color = '#15803d';
        copyBtn.title = 'Tersalin!';

        clearTimeout(resetTimer);
        resetTimer = setTimeout(function () {
          var current = document.getElementById('copy-icon');
          if (current) current.className = 'ti ti-copy';
          copyBtn.style.borderColor = '';
          copyBtn.style.color = '';
          copyBtn.title = 'Salin link';
        }, 2500);
      }).catch(function () {});
    });
  }

})();
</script>