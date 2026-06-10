<?php
// app/views/pages/berita_detail.php
// Variabel: $berita, $komentar, $related, $isLiked, $totalLikes, $flash
$shareUrl   = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http')
            . '://' . $_SERVER['HTTP_HOST'] . BASE_URL . '/berita/' . $berita['slug'];
$shareTitle = urlencode($berita['judul']);
?>
<style>
*, *::before, *::after { box-sizing: border-box; }

/* ── Page wrapper ── */
.bd-page {
  max-width: 1200px;
  margin: 0 auto;
  padding: 2.5rem 1.5rem 4rem;
}

/* ── Breadcrumb ── */
.bd-breadcrumb {
  display: flex;
  align-items: center;
  gap: 6px;
  margin-bottom: 2rem;
  font-family: var(--font-mono);
  font-size: .68rem;
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
.bd-breadcrumb a:hover { color: var(--c-sky); }
.bd-breadcrumb-sep { opacity: .35; font-size: .6rem; }

/* ── Main grid ── */
.bd-grid {
  display: grid;
  grid-template-columns: 1fr 300px;
  gap: 2.5rem;
  align-items: start;
}

/* ── Article header ── */
.bd-header { margin-bottom: 1.6rem; }

.bd-category {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  font-family: var(--font-mono);
  font-size: .6rem;
  font-weight: 700;
  letter-spacing: .1em;
  text-transform: uppercase;
  padding: 4px 12px;
  border-radius: 4px;
  margin-bottom: 1rem;
}

.bd-title {
  font-family: var(--font-display);
  font-size: clamp(1.5rem, 3.5vw, 2.2rem);
  font-weight: 900;
  color: #fff;
  line-height: 1.18;
  letter-spacing: -.04em;
  margin: 0 0 1.2rem;
}

.bd-meta {
  display: flex;
  align-items: center;
  flex-wrap: wrap;
  gap: .2rem .8rem;
  padding: 1rem 0;
  border-top: 1px solid var(--c-border);
  border-bottom: 1px solid var(--c-border);
}
.bd-meta-chip {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  font-family: var(--font-mono);
  font-size: .63rem;
  color: var(--c-muted);
}
.bd-meta-chip svg { opacity: .55; flex-shrink: 0; }

/* ── Cover image ── */
.bd-cover {
  margin: 1.6rem 0;
  border-radius: 12px;
  overflow: hidden;
  aspect-ratio: 16 / 9;
  background: var(--c-surface2);
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
  color: var(--c-muted2);
  line-height: 1.9;
  margin-bottom: 2.5rem;
}
.bd-body h2 {
  font-family: var(--font-display);
  color: #fff;
  font-size: 1.25rem;
  font-weight: 800;
  margin: 2rem 0 .7rem;
  letter-spacing: -.03em;
  padding-bottom: .5rem;
  border-bottom: 2px solid var(--c-border);
}
.bd-body h3 {
  font-family: var(--font-display);
  color: #fff;
  font-size: 1.05rem;
  font-weight: 700;
  margin: 1.6rem 0 .5rem;
  letter-spacing: -.02em;
}
.bd-body p { margin-bottom: 1.1rem; }
.bd-body ul, .bd-body ol { margin: 0 0 1.1rem 1.5rem; }
.bd-body li { margin-bottom: .4rem; }
.bd-body img { max-width: 100%; border-radius: 10px; margin: 1.2rem 0; display: block; }
.bd-body blockquote {
  margin: 1.6rem 0;
  padding: 1rem 1.2rem;
  border-left: 3px solid var(--c-sky);
  background: rgba(14,165,233,.05);
  border-radius: 0 8px 8px 0;
  color: var(--c-muted2);
  font-style: italic;
}
.bd-body a { color: var(--c-sky); text-decoration: underline; }
.bd-body strong { color: var(--c-text); }
.bd-body hr { border: none; border-top: 1px solid var(--c-border); margin: 2rem 0; }

/* ── Divider ── */
.bd-divider { height: 1px; background: var(--c-border); margin: 2rem 0; }

/* ── Share bar (icon-only, single instance) ── */
.bd-share { margin-bottom: 2rem; }
.bd-share-label {
  font-family: var(--font-mono);
  font-size: .62rem;
  color: var(--c-muted);
  text-transform: uppercase;
  letter-spacing: .1em;
  margin-bottom: .75rem;
}
.bd-share-icons {
  display: flex;
  align-items: center;
  gap: .5rem;
  flex-wrap: wrap;
}

/* Icon share button */
.sh-icon {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 38px;
  height: 38px;
  border-radius: 8px;
  border: none;
  cursor: pointer;
  text-decoration: none;
  transition: opacity .18s, transform .15s, box-shadow .18s;
  flex-shrink: 0;
}
.sh-icon:hover  { opacity: .85; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,.35); }
.sh-icon:active { transform: translateY(0); }
.sh-icon svg    { display: block; }

.sh-wa   { background: #22c55e; color: #fff; }
.sh-fb   { background: #1877F2; color: #fff; }
.sh-tw   { background: #0f1419; color: #fff; border: 1px solid #2a2a2a; }
.sh-tt   { background: #111;    color: #fff; border: 1px solid #2a2a2a; }
.sh-ig   { background: linear-gradient(135deg,#f58529,#dd2a7b,#8134af); color: #fff; }
.sh-copy { background: var(--c-surface2); color: var(--c-muted2); border: 1px solid var(--c-border); }
.sh-copy:hover { color: #fff; border-color: rgba(14,165,233,.45); background: rgba(14,165,233,.08); }

/* ── Like row ── */
.bd-like-row {
  display: flex;
  align-items: center;
  gap: 1rem;
  padding: 1rem 1.3rem;
  background: var(--c-surface2);
  border: 1px solid var(--c-border);
  border-radius: 10px;
  margin-bottom: 2.5rem;
}
.bd-like-btn {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 8px 18px;
  border-radius: 7px;
  border: 1px solid var(--c-border);
  background: var(--c-surface3);
  color: var(--c-muted2);
  font-size: .83rem;
  font-weight: 700;
  cursor: pointer;
  transition: all .2s;
  font-family: var(--font-body);
  white-space: nowrap;
}
.bd-like-btn:hover,
.bd-like-btn.liked {
  background: rgba(239,68,68,.08);
  border-color: rgba(239,68,68,.28);
  color: #f87171;
}
.bd-like-btn svg { transition: transform .25s; }
.bd-like-btn:hover svg { transform: scale(1.15); }
.bd-like-count {
  font-family: var(--font-mono);
  font-size: .72rem;
  color: var(--c-muted);
}
.bd-like-count strong { color: var(--c-muted2); font-size: .8rem; }

/* ── Comments ── */
.bd-comments { margin-top: .5rem; }
.bd-comments-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 1.2rem;
}
.bd-comments-title {
  font-family: var(--font-display);
  font-size: 1rem;
  font-weight: 800;
  color: #fff;
  letter-spacing: -.025em;
}
.bd-comments-count {
  font-family: var(--font-mono);
  font-size: .63rem;
  color: var(--c-muted);
  background: var(--c-surface2);
  border: 1px solid var(--c-border);
  border-radius: 99px;
  padding: 3px 10px;
}
.bd-no-comments {
  text-align: center;
  padding: 2rem 1rem;
  background: var(--c-surface2);
  border: 1px dashed var(--c-border);
  border-radius: 10px;
  margin-bottom: 1.6rem;
}
.bd-no-comments p { font-size: .82rem; color: var(--c-muted); margin: 0; }

.bd-comment-list { display: flex; flex-direction: column; gap: .6rem; margin-bottom: 1.8rem; }
.bd-comment {
  background: var(--c-surface2);
  border: 1px solid var(--c-border);
  border-radius: 10px;
  padding: 1rem 1.1rem;
  transition: border-color .18s;
}
.bd-comment:hover { border-color: var(--c-border2); }
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
  background: linear-gradient(135deg, var(--c-sky), var(--c-indigo));
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 800;
  font-size: .68rem;
  color: #fff;
  flex-shrink: 0;
  letter-spacing: .02em;
}
.bd-comment-name { font-weight: 700; font-size: .82rem; color: #fff; line-height: 1.2; }
.bd-comment-date { font-family: var(--font-mono); font-size: .58rem; color: var(--c-muted); margin-top: 2px; }
.bd-comment-body {
  font-size: .83rem;
  color: var(--c-muted2);
  line-height: 1.75;
  padding-left: calc(36px + .7rem);
}

/* ── Comment form ── */
.bd-comment-form {
  background: var(--c-surface2);
  border: 1px solid var(--c-border);
  border-radius: 12px;
  overflow: hidden;
}
.bd-comment-form-head {
  padding: 1rem 1.3rem .8rem;
  border-bottom: 1px solid var(--c-border);
  background: rgba(255,255,255,.02);
}
.bd-comment-form-title {
  font-family: var(--font-display);
  font-size: .9rem;
  font-weight: 700;
  color: #fff;
  letter-spacing: -.02em;
}
.bd-comment-form-body { padding: 1.2rem 1.3rem 1.3rem; }
.f-row2 { display: grid; grid-template-columns: 1fr 1fr; gap: .6rem; margin-bottom: .6rem; }
.f-group { display: flex; flex-direction: column; gap: .3rem; margin-bottom: .6rem; }
.f-label {
  font-family: var(--font-mono);
  font-size: .6rem;
  color: var(--c-muted);
  text-transform: uppercase;
  letter-spacing: .08em;
}
.f-field {
  background: var(--c-surface3);
  border: 1px solid var(--c-border);
  border-radius: 7px;
  padding: 9px 12px;
  font-size: .82rem;
  color: var(--c-text);
  outline: none;
  font-family: var(--font-body);
  transition: border-color .18s, box-shadow .18s;
  width: 100%;
}
.f-field:focus { border-color: rgba(14,165,233,.45); box-shadow: 0 0 0 3px rgba(14,165,233,.07); }
.f-field::placeholder { color: var(--c-muted); opacity: .5; }
textarea.f-field { resize: vertical; min-height: 105px; }
.f-hint { font-size: .68rem; color: var(--c-muted); line-height: 1.5; margin-bottom: .9rem; }
.f-submit {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  padding: 9px 22px;
  background: var(--c-sky);
  border: none;
  border-radius: 7px;
  font-size: .82rem;
  font-weight: 700;
  color: #fff;
  cursor: pointer;
  transition: background .18s, transform .15s;
  font-family: var(--font-body);
  letter-spacing: .01em;
}
.f-submit:hover { background: var(--c-sky-light); transform: translateY(-1px); }
.f-submit:active { transform: translateY(0); }

/* ── Sidebar ── */
.bd-sidebar {
  position: sticky;
  top: 1.5rem;
  display: flex;
  flex-direction: column;
  gap: 1rem;
}
.sb-block {
  background: var(--c-surface2);
  border: 1px solid var(--c-border);
  border-radius: 12px;
  overflow: hidden;
}
.sb-head {
  padding: .85rem 1.1rem;
  border-bottom: 1px solid var(--c-border);
  background: rgba(255,255,255,.02);
}
.sb-head-label {
  font-family: var(--font-mono);
  font-size: .6rem;
  color: var(--c-sky);
  text-transform: uppercase;
  letter-spacing: .12em;
  font-weight: 600;
}
.sb-body { padding: .5rem .8rem .8rem; }

.rel-item {
  display: flex;
  align-items: flex-start;
  gap: .65rem;
  padding: .6rem .3rem;
  border-bottom: 1px solid var(--c-border);
  border-radius: 6px;
  margin: 0 -.3rem;
  transition: background .15s;
}
.rel-item:last-child { border-bottom: none; }
.rel-item:hover { background: rgba(255,255,255,.025); }
.rel-thumb {
  width: 64px;
  height: 46px;
  border-radius: 6px;
  overflow: hidden;
  background: var(--c-surface3);
  flex-shrink: 0;
}
.rel-thumb img { width: 100%; height: 100%; object-fit: cover; display: block; }
.rel-thumb-empty { width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; opacity: .2; }
.rel-link {
  font-size: .77rem;
  font-weight: 600;
  color: var(--c-text);
  text-decoration: none;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
  line-height: 1.4;
  transition: color .18s;
}
.rel-link:hover { color: var(--c-sky); }
.rel-date { font-family: var(--font-mono); font-size: .57rem; color: var(--c-muted); margin-top: 4px; }

/* ── Responsive ── */
@media (max-width: 960px) {
  .bd-grid { grid-template-columns: 1fr; }
  .bd-sidebar { position: static; }
}
@media (max-width: 600px) {
  .bd-page { padding: 1.5rem 1rem 3rem; }
  .f-row2 { grid-template-columns: 1fr; }
  .bd-title { font-size: 1.55rem; }
  .bd-like-row { flex-wrap: wrap; }
}
</style>

<?php if (!empty($flash)): ?>
<div style="max-width:1200px;margin:1rem auto 0;padding:0 1.5rem">
  <div class="alert alert-<?= $flash['type'] ?>"><?= htmlspecialchars($flash['msg']) ?></div>
</div>
<?php endif; ?>

<div class="bd-page">

  <!-- Breadcrumb -->
  <nav class="bd-breadcrumb" aria-label="Navigasi">
    <a href="<?= BASE_URL ?>">
      <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
      Beranda
    </a>
    <span class="bd-breadcrumb-sep">›</span>
    <a href="<?= BASE_URL ?>/berita">Berita</a>
    <?php if ($berita['kategori_nama']): ?>
    <span class="bd-breadcrumb-sep">›</span>
    <span><?= htmlspecialchars($berita['kategori_nama']) ?></span>
    <?php endif; ?>
  </nav>

  <div class="bd-grid">

    <!-- ═══════════════════════════════════
         ARTICLE
         ═══════════════════════════════════ -->
    <article>

      <header class="bd-header">

        <?php if ($berita['kategori_nama']): ?>
        <span class="bd-category"
              style="background:<?= htmlspecialchars($berita['kategori_warna']??'#0ea5e9') ?>18;
                     color:<?= htmlspecialchars($berita['kategori_warna']??'#0ea5e9') ?>;
                     border:1px solid <?= htmlspecialchars($berita['kategori_warna']??'#0ea5e9') ?>35">
          <svg width="7" height="7" viewBox="0 0 8 8" fill="currentColor"><circle cx="4" cy="4" r="4"/></svg>
          <?= htmlspecialchars($berita['kategori_nama']) ?>
        </span>
        <?php endif; ?>

        <h1 class="bd-title"><?= htmlspecialchars($berita['judul']) ?></h1>

        <div class="bd-meta" role="list">
          <span class="bd-meta-chip" role="listitem">
            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            <?= $berita['published_at'] ? date('d F Y', strtotime($berita['published_at'])) : '' ?>
          </span>
          <?php if ($berita['penulis_nama']): ?>
          <span class="bd-meta-chip" role="listitem">
            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            <?= htmlspecialchars($berita['penulis_nama']) ?>
          </span>
          <?php endif; ?>
          <span class="bd-meta-chip" role="listitem">
            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
            <?= number_format($berita['views']) ?> views
          </span>
        </div>

      </header>

      <?php if ($berita['thumbnail']): ?>
      <figure class="bd-cover">
        <img src="<?= UPLOAD_URL . '/' . htmlspecialchars($berita['thumbnail']) ?>"
             alt="<?= htmlspecialchars($berita['judul']) ?>" loading="lazy">
      </figure>
      <?php endif; ?>

      <div class="bd-body"><?= $berita['konten'] ?></div>

      <div class="bd-divider"></div>

      <!-- Share (icon-only, satu tempat) -->
      <div class="bd-share">
        <div class="bd-share-label">Bagikan artikel ini</div>
        <div class="bd-share-icons">

          <!-- WhatsApp -->
          <a href="https://wa.me/?text=<?= $shareTitle ?>%20<?= urlencode($shareUrl) ?>"
             target="_blank" rel="noopener noreferrer"
             class="sh-icon sh-wa" title="Bagikan ke WhatsApp" aria-label="WhatsApp">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
          </a>

          <!-- Facebook -->
          <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode($shareUrl) ?>"
             target="_blank" rel="noopener noreferrer"
             class="sh-icon sh-fb" title="Bagikan ke Facebook" aria-label="Facebook">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
          </a>

          <!-- Twitter / X -->
          <a href="https://twitter.com/intent/tweet?text=<?= $shareTitle ?>&url=<?= urlencode($shareUrl) ?>"
             target="_blank" rel="noopener noreferrer"
             class="sh-icon sh-tw" title="Bagikan ke Twitter/X" aria-label="Twitter / X">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.744l7.737-8.835L1.254 2.25H8.08l4.253 5.622zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
          </a>

          <!-- TikTok -->
          <a href="https://www.tiktok.com/share?url=<?= urlencode($shareUrl) ?>"
             target="_blank" rel="noopener noreferrer"
             class="sh-icon sh-tt" title="Bagikan ke TikTok" aria-label="TikTok">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-2.88 2.5 2.89 2.89 0 0 1-2.89-2.89 2.89 2.89 0 0 1 2.89-2.89c.28 0 .54.04.79.1V9.01a6.31 6.31 0 0 0-.79-.05 6.34 6.34 0 0 0-6.34 6.34 6.34 6.34 0 0 0 6.34 6.34 6.34 6.34 0 0 0 6.33-6.34V8.69a8.18 8.18 0 0 0 4.77 1.52V6.75a4.85 4.85 0 0 1-1-.06z"/></svg>
          </a>

          <!-- Instagram -->
          <a href="https://www.instagram.com/" target="_blank" rel="noopener noreferrer"
             class="sh-icon sh-ig" title="Salin link, lalu bagikan di Instagram" aria-label="Instagram">
            <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
          </a>

          <!-- Salin link -->
          <button class="sh-icon sh-copy" id="copy-btn"
                  data-url="<?= htmlspecialchars($shareUrl) ?>"
                  title="Salin link" aria-label="Salin link">
            <svg id="copy-icon" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
          </button>

        </div>
      </div>

      <!-- Like -->
      <div class="bd-like-row">
        <button class="bd-like-btn <?= $isLiked ? 'liked' : '' ?>"
                id="like-btn"
                data-id="<?= $berita['id'] ?>"
                data-url="<?= BASE_URL ?>/berita/<?= $berita['id'] ?>/like"
                aria-pressed="<?= $isLiked ? 'true' : 'false' ?>">
          <svg width="16" height="16"
               fill="<?= $isLiked ? 'currentColor' : 'none' ?>"
               stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
          </svg>
          <span id="like-lbl"><?= $isLiked ? 'Disukai' : 'Suka' ?></span>
        </button>
        <span class="bd-like-count">
          <strong id="like-cnt"><?= number_format($totalLikes) ?></strong> orang menyukai artikel ini
        </span>
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
                  <label class="f-label" for="inp-nama">Nama <span style="color:#f87171">*</span></label>
                  <input type="text" id="inp-nama" name="nama" class="f-field"
                         placeholder="Nama kamu" required maxlength="100" autocomplete="name">
                </div>
                <div class="f-group">
                  <label class="f-label" for="inp-email">Email <span style="color:#f87171">*</span></label>
                  <input type="email" id="inp-email" name="email" class="f-field"
                         placeholder="email@kamu.com" required maxlength="150" autocomplete="email">
                </div>
              </div>
              <div class="f-group">
                <label class="f-label" for="inp-komentar">Komentar <span style="color:#f87171">*</span></label>
                <textarea id="inp-komentar" name="komentar" class="f-field"
                          placeholder="Tulis komentarmu di sini…" required maxlength="1000"></textarea>
              </div>
              <p class="f-hint">* Email tidak akan ditampilkan. Komentar akan muncul setelah disetujui admin.</p>
              <button type="submit" class="f-submit">
                Kirim Komentar
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
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
                <img src="<?= UPLOAD_URL . '/' . htmlspecialchars($r['thumbnail']) ?>" alt="" loading="lazy">
              <?php else: ?>
                <div class="rel-thumb-empty">
                  <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
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
      likeBtn.disabled = true;
      fetch(likeBtn.dataset.url, {
        method: 'POST',
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      })
        .then(function (r) { return r.json(); })
        .then(function (d) {
          document.getElementById('like-cnt').textContent = d.total.toLocaleString('id-ID');
          likeBtn.classList.toggle('liked', d.liked);
          likeBtn.setAttribute('aria-pressed', d.liked ? 'true' : 'false');
          document.getElementById('like-lbl').textContent = d.liked ? 'Disukai' : 'Suka';
          likeBtn.querySelector('svg').setAttribute('fill', d.liked ? 'currentColor' : 'none');
        })
        .catch(function () {})
        .finally(function () { likeBtn.disabled = false; });
    });
  }

  /* ---- Salin link ---- */
  var copyBtn = document.getElementById('copy-btn');
  if (copyBtn) {
    var copyIcon = document.getElementById('copy-icon');
    var ORIG_ICON = copyIcon ? copyIcon.outerHTML : '';
    copyBtn.addEventListener('click', function () {
      navigator.clipboard.writeText(copyBtn.dataset.url).then(function () {
        copyIcon.outerHTML = '<svg id="copy-icon" width="16" height="16" fill="none" stroke="#22c55e" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>';
        copyBtn.style.borderColor = 'rgba(34,197,94,.4)';
        copyBtn.title = 'Tersalin!';
        setTimeout(function () {
          var ic = document.getElementById('copy-icon');
          if (ic) ic.outerHTML = ORIG_ICON;
          copyBtn.style.borderColor = '';
          copyBtn.title = 'Salin link';
        }, 2500);
      });
    });
  }

})();
</script>