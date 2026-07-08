<?php
// app/views/admin/galeri.php
// Variabel: $albums, $page, $pages, $total, $flash, $csrf
?>

<style>
/* ═══════════════════════════════════════
   SCOPE ROOT — alias ke Design System
   (token asli didefinisikan global di layout;
    fallback disertakan bila file ini dirender berdiri sendiri)
═══════════════════════════════════════ */
.gal-root {
  /* Text */
  --tx-primary:   var(--c-ink,    #0f172a);
  --tx-secondary: var(--c-muted,  #64748b);
  --tx-muted:     var(--c-muted2, #94a3b8);

  /* Surface */
  --bg-surface:  var(--c-white, #ffffff);
  --bg-elevated: #f8fafc;
  --bg-overlay:  #eef2f6;

  /* Border */
  --bd-subtle:  var(--c-border, #e6ebf1);
  --bd-default: var(--c-border, #e6ebf1);
  --bd-accent:  var(--c-primary-25, rgba(14,116,144,.25));

  /* Accent */
  --ac:      var(--c-primary,    #0e7490);
  --ac-dk:   var(--c-primary-dk, #0b5a70);
  --ac-lt:   var(--c-primary-lt, #06b6d4);
  --ac-dim:  var(--c-primary-08, rgba(14,116,144,.08));
  --ac-glow: var(--c-primary-12, rgba(14,116,144,.12));

  /* Status */
  --green:    var(--c-green-text,   #15803d);
  --green-bg: var(--c-green-bg,     #f0fdf4);
  --green-bd: var(--c-green-border, #bbf7d0);
  --red:      var(--c-red-text,     #b91c1c);
  --red-bg:   var(--c-red-bg,       #fef2f2);
  --red-bd:   var(--c-red-border,   #fecaca);
  --amber:      var(--c-amber-icon,   #d9910c);
  --amber-bg:   var(--c-amber-bg,     #fef6e2);
  --amber-bd:   var(--c-amber-border, #fbe3a8);

  /* Radius */
  --r-xs: 6px;
  --r-sm: var(--radius-sm, 9px);
  --r-md: var(--radius-md, 13px);
  --r-lg: var(--radius-lg, 22px);

  /* Font */
  --font-ui: var(--ff, 'Plus Jakarta Sans', sans-serif);

  /* Motion */
  --ease:  cubic-bezier(0.22, 1, 0.36, 1);
  --t-fast: 120ms;
  --t-base: 180ms;
  --t-slow: 300ms;
}

.gal-root * { box-sizing: border-box; }
.gal-root {
  display: flex;
  flex-direction: column;
  gap: 1.75rem;
  font-family: var(--font-ui);
  color: var(--tx-primary);
  -webkit-font-smoothing: antialiased;
}

/* ── Header ── */
.gal-header {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  gap: 1.25rem;
  flex-wrap: wrap;
}
.gal-header-text {
  display: flex;
  flex-direction: column;
  gap: 6px;
}
.gal-eyebrow {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  font-size: 11px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: .1em;
  color: var(--ac);
}
.gal-eyebrow__dot {
  width: 6px; height: 6px;
  border-radius: 50%;
  background: var(--ac);
  box-shadow: 0 0 6px var(--ac);
  animation: gal-pulse 2.4s ease-in-out infinite;
}
@keyframes gal-pulse {
  0%,100% { opacity:1; box-shadow: 0 0 6px var(--ac); }
  50%      { opacity:.5; box-shadow: 0 0 12px var(--ac); }
}
.gal-title {
  font-size: 26px;
  font-weight: 800;
  letter-spacing: -.03em;
  color: var(--ac-dk);
  line-height: 1.1;
  margin: 0;
}
.gal-sub {
  font-size: 13px;
  color: var(--tx-secondary);
  margin: 0;
  font-weight: 400;
}
.gal-sub b { color: var(--tx-primary); font-weight: 700; }

/* ── Buttons (sesuai §5.3 Design System) ── */
.gal-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  font-family: inherit;
  font-weight: 800;
  border: 1.5px solid transparent;
  border-radius: var(--r-sm);
  cursor: pointer;
  text-decoration: none;
  white-space: nowrap;
  transition: background var(--t-base) var(--ease), transform var(--t-fast) var(--ease), box-shadow var(--t-base) var(--ease), border-color var(--t-base) var(--ease);
  line-height: 1;
}
.gal-btn--primary {
  height: 42px; padding: 0 18px; font-size: .875rem;
  background: var(--ac); color: #fff;
  box-shadow: 0 8px 22px rgba(14,116,144,.25);
}
.gal-btn--primary:hover {
  background: var(--ac-lt);
  transform: translateY(-2px);
  box-shadow: 0 12px 28px rgba(6,182,212,.3);
}
.gal-btn--primary svg { flex-shrink: 0; }

/* ── Flash (sesuai §5.5) ── */
.gal-flash {
  display: flex;
  align-items: center;
  gap: .75rem;
  padding: 13px 18px;
  border-radius: var(--r-md);
  font-size: .875rem;
  font-weight: 600;
  border: 1px solid;
}
.gal-flash--success { background: var(--green-bg); color: var(--green); border-color: var(--green-bd); }
.gal-flash--error    { background: var(--red-bg);   color: var(--red);   border-color: var(--red-bd); }
.gal-flash--warning  { background: var(--amber-bg); color: var(--amber); border-color: var(--amber-bd); }
.gal-flash svg { flex-shrink: 0; }

/* ── Grid & Cards ── */
.gal-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
  gap: 16px;
}

.gal-card {
  background: var(--bg-surface);
  border: 1px solid var(--bd-subtle);
  border-radius: var(--r-md);
  overflow: hidden;
  display: flex;
  flex-direction: column;
  transition: transform var(--t-fast) var(--ease), box-shadow var(--t-base) var(--ease), border-color var(--t-base) var(--ease);
}
.gal-card:hover {
  transform: translateY(-2px);
  border-color: var(--bd-accent);
  box-shadow: 0 16px 36px -14px rgba(15,23,42,.18), 0 4px 14px rgba(15,23,42,.05);
}

/* Cover */
.gal-card__cover {
  aspect-ratio: 4/3;
  background: var(--bg-overlay);
  position: relative;
  overflow: hidden;
}
.gal-card__img {
  width: 100%; height: 100%;
  object-fit: cover;
  display: block;
  transition: transform .5s var(--ease);
}
.gal-card:hover .gal-card__img { transform: scale(1.05); }
.gal-card__empty-img {
  width: 100%; height: 100%;
  display: flex; align-items: center; justify-content: center;
  color: var(--tx-muted);
}

.gal-badge-status {
  position: absolute;
  top: 10px; right: 10px;
  font-size: 10px; font-weight: 700;
  padding: 4px 10px; border-radius: 99px;
  letter-spacing: .04em; text-transform: uppercase;
  backdrop-filter: blur(8px);
  border: 1px solid;
}
.gal-badge-status--pub { background: rgba(240,253,244,.92); color: var(--green); border-color: var(--green-bd); }
.gal-badge-status--dft { background: rgba(255,255,255,.92); color: var(--tx-secondary); border-color: var(--bd-subtle); }

.gal-badge-count {
  position: absolute;
  bottom: 10px; left: 10px;
  font-size: 10.5px; font-weight: 700;
  padding: 4px 10px; border-radius: 99px;
  background: rgba(15,23,42,.65); color: #fff;
  backdrop-filter: blur(8px);
  display: inline-flex; align-items: center; gap: 4px;
}

/* Body */
.gal-card__body {
  padding: 16px 18px;
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 6px;
}
.gal-card__title {
  font-size: 1rem;
  font-weight: 800;
  color: var(--tx-primary);
  letter-spacing: -.02em;
  margin: 0;
  line-height: 1.3;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}
.gal-card__desc {
  font-size: .8rem;
  color: var(--tx-muted);
  line-height: 1.55;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
  margin: 0;
}
.gal-card__desc--empty { font-style: italic; opacity: .7; }

/* Actions */
.gal-card__acts {
  padding: 12px 18px;
  border-top: 1px solid var(--bd-subtle);
  display: flex;
  gap: 8px;
  flex-wrap: wrap;
  background: var(--bg-elevated);
}
.gal-btn-c {
  flex: 1;
  display: inline-flex; align-items: center; justify-content: center; gap: 6px;
  padding: 9px 0; border-radius: var(--r-xs);
  font-size: .75rem; font-weight: 700; text-decoration: none;
  transition: all var(--t-base) var(--ease); cursor: pointer; border: 1px solid transparent;
  font-family: inherit;
}
.gal-btn-c--foto {
  background: var(--ac-dim); color: var(--ac); border-color: rgba(14,116,144,.18);
}
.gal-btn-c--foto:hover { background: var(--ac-glow); }

.gal-btn-c--edit {
  background: var(--bg-surface); color: var(--tx-secondary); border-color: var(--bd-subtle);
}
.gal-btn-c--edit:hover { background: var(--bg-overlay); }

.gal-btn-c--del {
  background: transparent; color: var(--red); border-color: transparent;
  flex: 0 0 auto; padding: 9px 12px;
}
.gal-btn-c--del:hover { background: var(--red-bg); border-color: var(--red-bd); }

/* ── Empty State ── */
.gal-empty {
  padding: 5rem 2rem;
  text-align: center;
  background: var(--bg-elevated);
  border: 1.5px dashed var(--bd-subtle);
  border-radius: var(--r-md);
  display: flex; flex-direction: column; align-items: center; gap: 10px;
}
.gal-empty__icon {
  width: 60px; height: 60px; border-radius: var(--r-sm);
  background: var(--bg-surface); border: 1px solid var(--bd-subtle);
  display: flex; align-items: center; justify-content: center;
  color: var(--tx-muted); margin-bottom: 4px;
}
.gal-empty__h { font-size: 1rem; font-weight: 700; color: var(--tx-primary); margin: 0; }
.gal-empty__p { margin: 0; }
.gal-empty__p a { color: var(--ac); text-decoration: none; font-weight: 700; font-size: .875rem; }
.gal-empty__p a:hover { text-decoration: underline; }

/* ── Pagination (sesuai §5.4 tab bar) ── */
.gal-pager {
  display: inline-flex; gap: 3px; align-items: center; justify-content: center;
  margin: 8px auto 0;
  background: var(--bg-elevated);
  border: 1px solid var(--bd-subtle);
  border-radius: var(--r-md);
  padding: 4px;
}
.gal-pg {
  display: inline-flex; align-items: center; justify-content: center;
  min-width: 34px; height: 34px; padding: 0 8px;
  border-radius: var(--r-xs);
  font-size: .8rem; font-weight: 700;
  text-decoration: none;
  color: var(--tx-secondary);
  transition: all var(--t-base) var(--ease);
}
.gal-pg:hover { background: var(--bg-surface); color: var(--ac); }
.gal-pg--on { background: var(--ac); color: #fff; box-shadow: 0 3px 14px rgba(14,116,144,.28); }

@media (max-width: 640px) {
  .gal-header { flex-direction: column; }
  .gal-btn--primary { width: 100%; }
}
</style>

<div class="gal-root">

  <div class="gal-header">
    <div class="gal-header-text">
      <div class="gal-eyebrow"><span class="gal-eyebrow__dot"></span>Manajemen Konten</div>
      <h1 class="gal-title">Album Galeri</h1>
      <p class="gal-sub">Total <b><?= number_format($total) ?></b> album foto tersimpan</p>
    </div>
    <div class="gal-header-actions">
      <a href="<?= BASE_URL ?>/admin/galeri/create" class="gal-btn gal-btn--primary">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Buat Album
      </a>
    </div>
  </div>

  <?php if (!empty($flash)): ?>
  <div class="gal-flash gal-flash--<?= htmlspecialchars($flash['type']) ?>">
    <?php if ($flash['type'] === 'success'): ?>
      <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
    <?php else: ?>
      <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
    <?php endif; ?>
    <span><?= htmlspecialchars($flash['msg']) ?></span>
  </div>
  <?php endif; ?>

  <?php if (empty($albums)): ?>
  <div class="gal-empty">
    <div class="gal-empty__icon">
      <svg width="30" height="30" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
    </div>
    <p class="gal-empty__h">Belum ada album galeri</p>
    <p class="gal-empty__p"><a href="<?= BASE_URL ?>/admin/galeri/create">Buat album pertama sekarang →</a></p>
  </div>
  <?php else: ?>

  <div class="gal-grid">
    <?php foreach ($albums as $a): ?>
    <div class="gal-card">

      <div class="gal-card__cover">
        <?php if (!empty($a['cover'])): ?>
          <img src="<?= UPLOAD_URL . '/' . htmlspecialchars($a['cover']) ?>"
               alt="<?= htmlspecialchars($a['judul']) ?>"
               class="gal-card__img" loading="lazy">
        <?php else: ?>
          <div class="gal-card__empty-img">
            <svg width="30" height="30" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
          </div>
        <?php endif; ?>

        <?php if ($a['status'] === 'published'): ?>
          <span class="gal-badge-status gal-badge-status--pub">Publik</span>
        <?php else: ?>
          <span class="gal-badge-status gal-badge-status--dft">Draft</span>
        <?php endif; ?>

        <span class="gal-badge-count">
          <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/><path d="M19 11l-7-7-7 7"/></svg>
          <?= (int)$a['jumlah_foto'] ?> foto
        </span>
      </div>

      <div class="gal-card__body">
        <h3 class="gal-card__title" title="<?= htmlspecialchars($a['judul']) ?>">
          <?= htmlspecialchars($a['judul']) ?>
        </h3>
        <?php if ($a['deskripsi']): ?>
          <p class="gal-card__desc"><?= htmlspecialchars($a['deskripsi']) ?></p>
        <?php else: ?>
          <p class="gal-card__desc gal-card__desc--empty">Tidak ada deskripsi.</p>
        <?php endif; ?>
      </div>

      <div class="gal-card__acts">
        <a href="<?= BASE_URL ?>/admin/galeri/<?= $a['id'] ?>/foto" class="gal-btn-c gal-btn-c--foto">
          <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
          Kelola Foto
        </a>
        <a href="<?= BASE_URL ?>/admin/galeri/<?= $a['id'] ?>/edit" class="gal-btn-c gal-btn-c--edit" title="Edit Album">
          Edit
        </a>
        <form method="POST" action="<?= BASE_URL ?>/admin/galeri/<?= $a['id'] ?>/delete" style="margin:0;display:inline" onsubmit="return confirm('Hapus album dan SEMUA foto di dalamnya?\nTindakan ini tidak dapat dibatalkan.')">
          <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
          <button type="submit" class="gal-btn-c gal-btn-c--del" title="Hapus Album">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
          </button>
        </form>
      </div>

    </div>
    <?php endforeach; ?>
  </div>

  <?php if ($pages > 1): ?>
  <nav class="gal-pager" aria-label="Paginasi">
    <?php for ($i = 1; $i <= $pages; $i++): ?>
      <?php if ($i === (int)$page): ?>
        <span class="gal-pg gal-pg--on"><?= $i ?></span>
      <?php else: ?>
        <a href="<?= BASE_URL ?>/admin/galeri?page=<?= $i ?>" class="gal-pg"><?= $i ?></a>
      <?php endif; ?>
    <?php endfor; ?>
  </nav>
  <?php endif; ?>

  <?php endif; ?>

</div>