<?php
// app/views/admin/galeri.php
// Variabel: $albums, $page, $pages, $total, $flash, $csrf
?>

<style>
/* ── Base & Variables Fallback ── */
.bn * { box-sizing: border-box; }
.bn {
  display: flex;
  flex-direction: column;
  gap: 1.75rem;
  font-family: var(--font, system-ui, -apple-system, sans-serif);
}

/* ── Header ── */
.bn-header {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  gap: 1.25rem;
  flex-wrap: wrap;
}
.bn-header-text {
  display: flex;
  flex-direction: column;
  gap: 0.25rem;
}
.bn-eyebrow {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  font-family: var(--font-mono, monospace);
  font-size: .75rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: .08em;
  color: var(--ac, #60a5fa);
}
.bn-eyebrow__dot {
  width: 6px; height: 6px;
  border-radius: 50%;
  background: var(--ac, #60a5fa);
  box-shadow: 0 0 8px var(--ac, #60a5fa);
  animation: bn-pulse 2s ease-in-out infinite;
}
@keyframes bn-pulse {
  0%, 100% { opacity: 1; transform: scale(1); box-shadow: 0 0 8px var(--ac, #60a5fa); }
  50%      { opacity: 0.4; transform: scale(0.6); box-shadow: 0 0 2px var(--ac, #60a5fa); }
}
.bn-page-title {
  font-size: 1.75rem;
  font-weight: 800;
  color: var(--tx-primary, #ffffff);
  letter-spacing: -.03em;
  margin: 0;
  line-height: 1.2;
}
.bn-page-sub {
  font-size: .875rem;
  color: var(--tx-muted, #9ca3af);
  margin: 0;
}
.bn-page-sub b { color: var(--tx-secondary, #e5e7eb); font-weight: 600; }

/* ── Flash ── */
.bn-flash {
  display: flex;
  align-items: center;
  gap: .75rem;
  padding: 1rem 1.25rem;
  border-radius: var(--r-md, 8px);
  font-size: .875rem;
  font-weight: 600;
  border: 1px solid rgba(255,255,255,0.05);
  animation: bn-fadein .3s cubic-bezier(0.16, 1, 0.3, 1);
  box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}
@keyframes bn-fadein {
  from { opacity: 0; transform: translateY(-8px); }
  to   { opacity: 1; transform: translateY(0); }
}
.bn-flash--success { background: rgba(16,185,129,0.1); color: var(--ok, #34d399); border-color: rgba(16,185,129,0.2); }
.bn-flash--error   { background: rgba(239,68,68,0.1); color: var(--er, #f87171); border-color: rgba(239,68,68,0.2); }
.bn-flash--warning { background: rgba(245,158,11,0.1); color: var(--wa, #fbbf24); border-color: rgba(245,158,11,0.2); }

/* ── Buttons ── */
.bn-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: .5rem;
  font-family: inherit;
  font-weight: 600;
  border: 1px solid transparent;
  border-radius: var(--r-md, 8px);
  cursor: pointer;
  text-decoration: none;
  white-space: nowrap;
  transition: all .2s cubic-bezier(0.4, 0, 0.2, 1);
  line-height: 1;
}
.bn-btn:hover  { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(0,0,0,0.3); filter: brightness(1.1); }
.bn-btn:active { transform: translateY(0); filter: brightness(0.95); }

.bn-btn--primary {
  height: 40px; padding: 0 18px; font-size: .875rem;
  background: var(--ac, #3b82f6); color: #fff;
  border-color: rgba(255,255,255,0.05);
  box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);
}

/* ── Grid & Cards ── */
.bn-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
  gap: 1.5rem;
}

.bn-card {
  background: linear-gradient(145deg, var(--bg-surface, #0f172a), var(--bg-raised, #0b0f19));
  border: 1px solid rgba(255, 255, 255, 0.05);
  border-radius: var(--r-lg, 12px);
  overflow: hidden;
  display: flex;
  flex-direction: column;
  transition: transform .3s ease, box-shadow .3s ease, border-color .3s ease;
  box-shadow: 0 4px 10px -2px rgba(0, 0, 0, 0.3);
}
.bn-card:hover {
  transform: translateY(-5px);
  border-color: rgba(255, 255, 255, 0.15);
  box-shadow: 0 16px 32px -5px rgba(0, 0, 0, 0.5);
}

/* Card Image/Cover */
.bn-card__cover {
  aspect-ratio: 4/3;
  background: rgba(0,0,0,0.2);
  position: relative;
  overflow: hidden;
}
.bn-card__img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
  transition: transform .5s cubic-bezier(0.16, 1, 0.3, 1);
}
.bn-card:hover .bn-card__img {
  transform: scale(1.05);
}
.bn-card__empty-img {
  width: 100%; height: 100%;
  display: flex; align-items: center; justify-content: center;
  color: rgba(255,255,255,0.2);
}

/* Badges on Cover */
.bn-badge-status {
  position: absolute;
  top: 10px; right: 10px;
  font-family: var(--font-mono, monospace);
  font-size: .65rem; font-weight: 700;
  padding: 4px 10px; border-radius: 99px;
  letter-spacing: .05em; text-transform: uppercase;
  backdrop-filter: blur(8px);
}
.bn-badge-status--pub { background: rgba(16, 185, 129, 0.2); color: var(--ok, #34d399); border: 1px solid rgba(16, 185, 129, 0.3); }
.bn-badge-status--dft { background: rgba(255, 255, 255, 0.1); color: var(--tx-secondary, #d1d5db); border: 1px solid rgba(255, 255, 255, 0.15); }

.bn-badge-count {
  position: absolute;
  bottom: 10px; left: 10px;
  font-family: var(--font-mono, monospace);
  font-size: .7rem; font-weight: 600;
  padding: 4px 10px; border-radius: 99px;
  background: rgba(0, 0, 0, 0.6); color: rgba(255,255,255,0.9);
  backdrop-filter: blur(8px);
  border: 1px solid rgba(255,255,255,0.1);
  display: inline-flex; align-items: center; gap: 4px;
}

/* Card Body */
.bn-card__body {
  padding: 1.25rem;
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}
.bn-card__title {
  font-size: 1.05rem;
  font-weight: 700;
  color: var(--tx-primary, #ffffff);
  letter-spacing: -.02em;
  margin: 0;
  line-height: 1.3;
}
.bn-card__desc {
  font-size: .8rem;
  color: var(--tx-muted, #9ca3af);
  line-height: 1.6;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
  margin: 0;
}

/* Card Actions */
.bn-card__acts {
  padding: 1rem 1.25rem;
  border-top: 1px solid rgba(255, 255, 255, 0.04);
  display: flex;
  gap: .5rem;
  flex-wrap: wrap;
  background: rgba(0,0,0,0.1);
}
.bn-btn-c {
  flex: 1;
  display: inline-flex; align-items: center; justify-content: center; gap: 6px;
  padding: 8px 0; border-radius: var(--r-sm, 6px);
  font-size: .75rem; font-weight: 600; text-decoration: none;
  transition: all .2s ease; cursor: pointer; border: 1px solid transparent;
}
.bn-btn-c--foto {
  background: rgba(59,130,246,0.1); color: var(--ac-bright, #93c5fd); border-color: rgba(59,130,246,0.2);
}
.bn-btn-c--foto:hover { background: rgba(59,130,246,0.2); transform: translateY(-1px); }

.bn-btn-c--edit {
  background: transparent; color: var(--tx-secondary, #d1d5db); border-color: rgba(255,255,255,0.1);
}
.bn-btn-c--edit:hover { background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.2); }

.bn-btn-c--del {
  background: transparent; color: var(--er, #f87171); border-color: transparent;
  flex: 0 0 auto; padding: 8px 12px;
}
.bn-btn-c--del:hover { background: rgba(239,68,68,0.1); border-color: rgba(239,68,68,0.2); }

/* ── Empty State ── */
.bn-empty {
  padding: 6rem 2rem;
  text-align: center;
  background: linear-gradient(145deg, var(--bg-surface, #0f172a), transparent);
  border: 1px dashed rgba(255, 255, 255, 0.1);
  border-radius: var(--r-lg, 12px);
  display: flex; flex-direction: column; align-items: center; gap: .75rem;
}
.bn-empty__icon {
  width: 64px; height: 64px; border-radius: 16px;
  background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);
  display: flex; align-items: center; justify-content: center;
  color: rgba(255,255,255,0.2); margin-bottom: .5rem;
}
.bn-empty__h { font-size: 1.1rem; font-weight: 600; color: rgba(255,255,255,0.8); margin: 0; }
.bn-empty__p a { color: var(--ac, #60a5fa); text-decoration: none; font-weight: 600; font-size: .875rem; }
.bn-empty__p a:hover { text-decoration: underline; }

/* ── Pagination ── */
.bn-pager { display: flex; gap: .4rem; align-items: center; justify-content: center; margin-top: 2rem; }
.bn-pg {
  display: inline-flex; align-items: center; justify-content: center;
  min-width: 36px; height: 36px; padding: 0 8px;
  border-radius: var(--r-sm, 6px);
  font-size: .875rem; font-weight: 600;
  text-decoration: none;
  background: transparent; border: 1px solid rgba(255, 255, 255, 0.1);
  color: rgba(255, 255, 255, 0.6);
  transition: all .2s ease;
}
.bn-pg:hover { color: var(--ac-bright, #93c5fd); background: rgba(255, 255, 255, 0.05); border-color: rgba(255, 255, 255, 0.2); }
.bn-pg--on { background: rgba(255, 255, 255, 0.1); color: #fff; border-color: transparent; pointer-events: none; }
</style>

<div class="bn">

  <div class="bn-header">
    <div class="bn-header-text">
      <div class="bn-eyebrow"><span class="bn-eyebrow__dot"></span>Manajemen Konten</div>
      <h1 class="bn-page-title">Album Galeri</h1>
      <p class="bn-page-sub">Total <b><?= number_format($total) ?></b> album foto tersimpan</p>
    </div>
    <div class="bn-header-actions">
      <a href="<?= BASE_URL ?>/admin/galeri/create" class="bn-btn bn-btn--primary">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Buat Album
      </a>
    </div>
  </div>

  <?php if (!empty($flash)): ?>
  <div class="bn-flash bn-flash--<?= htmlspecialchars($flash['type']) ?>">
    <?php if($flash['type'] === 'success'): ?>
      <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
    <?php else: ?>
      <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
    <?php endif; ?>
    <span><?= htmlspecialchars($flash['msg']) ?></span>
  </div>
  <?php endif; ?>

  <?php if (empty($albums)): ?>
  <div class="bn-empty">
    <div class="bn-empty__icon">
      <svg width="32" height="32" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
    </div>
    <p class="bn-empty__h">Belum ada album galeri</p>
    <p class="bn-empty__p"><a href="<?= BASE_URL ?>/admin/galeri/create">Buat album pertama sekarang →</a></p>
  </div>
  <?php else: ?>

  <div class="bn-grid">
    <?php foreach ($albums as $a): ?>
    <div class="bn-card">
      
      <div class="bn-card__cover">
        <?php if (!empty($a['cover'])): ?>
          <img src="<?= UPLOAD_URL . '/' . htmlspecialchars($a['cover']) ?>" 
               alt="<?= htmlspecialchars($a['judul']) ?>" 
               class="bn-card__img" loading="lazy">
        <?php else: ?>
          <div class="bn-card__empty-img">
            <svg width="32" height="32" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
          </div>
        <?php endif; ?>

        <?php if ($a['status'] === 'published'): ?>
          <span class="bn-badge-status bn-badge-status--pub">Publik</span>
        <?php else: ?>
          <span class="bn-badge-status bn-badge-status--dft">Draft</span>
        <?php endif; ?>

        <span class="bn-badge-count">
          <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/><path d="M19 11l-7-7-7 7"/></svg>
          <?= (int)$a['jumlah_foto'] ?> foto
        </span>
      </div>

      <div class="bn-card__body">
        <h3 class="bn-card__title" title="<?= htmlspecialchars($a['judul']) ?>">
          <?= htmlspecialchars($a['judul']) ?>
        </h3>
        <?php if ($a['deskripsi']): ?>
          <p class="bn-card__desc"><?= htmlspecialchars($a['deskripsi']) ?></p>
        <?php else: ?>
          <p class="bn-card__desc" style="font-style:italic;opacity:0.5">Tidak ada deskripsi.</p>
        <?php endif; ?>
      </div>

      <div class="bn-card__acts">
        <a href="<?= BASE_URL ?>/admin/galeri/<?= $a['id'] ?>/foto" class="bn-btn-c bn-btn-c--foto">
          <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
          Kelola Foto
        </a>
        <a href="<?= BASE_URL ?>/admin/galeri/<?= $a['id'] ?>/edit" class="bn-btn-c bn-btn-c--edit" title="Edit Album">
          Edit
        </a>
        <form method="POST" action="<?= BASE_URL ?>/admin/galeri/<?= $a['id'] ?>/delete" style="margin:0;display:inline" onsubmit="return confirm('Hapus album dan SEMUA foto di dalamnya?\nTindakan ini tidak dapat dibatalkan.')">
          <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
          <button type="submit" class="bn-btn-c bn-btn-c--del" title="Hapus Album">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
          </button>
        </form>
      </div>

    </div>
    <?php endforeach; ?>
  </div>

  <?php if ($pages > 1): ?>
  <nav class="bn-pager" aria-label="Paginasi">
    <?php for ($i = 1; $i <= $pages; $i++): ?>
      <?php if ($i === (int)$page): ?>
        <span class="bn-pg bn-pg--on"><?= $i ?></span>
      <?php else: ?>
        <a href="<?= BASE_URL ?>/admin/galeri?page=<?= $i ?>" class="bn-pg"><?= $i ?></a>
      <?php endif; ?>
    <?php endfor; ?>
  </nav>
  <?php endif; ?>

  <?php endif; ?>

</div>