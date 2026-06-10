<?php
// app/views/admin/berita.php
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

.bn-header-actions {
  display: flex;
  gap: .75rem;
  align-items: center;
  flex-shrink: 0;
  flex-wrap: wrap;
}

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
.bn-flash--success { background: var(--ok-dim, rgba(16,185,129,0.1)); color: var(--ok, #10b981); border-color: var(--ok-bd, rgba(16,185,129,0.2)); }
.bn-flash--error   { background: var(--er-dim, rgba(239,68,68,0.1)); color: var(--er, #ef4444); border-color: var(--er-bd, rgba(239,68,68,0.2)); }
.bn-flash--warning { background: var(--wa-dim, rgba(245,158,11,0.1)); color: var(--wa, #f59e0b); border-color: var(--wa-bd, rgba(245,158,11,0.2)); }

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
.bn-btn--warning {
  height: 40px; padding: 0 16px; font-size: .875rem;
  background: var(--wa-dim, rgba(245,158,11,0.15)); border: 1px solid var(--wa-bd, rgba(245,158,11,0.3)); color: var(--wa, #fbbf24);
}
.bn-btn--sm-edit,
.bn-btn--sm-del {
  height: 30px; padding: 0 12px; font-size: .75rem; border-radius: var(--r-sm, 6px);
  background: transparent; /* Membuatnya clean seperti di referensi */
}
.bn-btn--sm-edit {
  color: var(--ac-bright, #93c5fd);
}
.bn-btn--sm-edit:hover { background: rgba(59,130,246,0.1); }
.bn-btn--sm-del {
  color: var(--er, #f87171);
}
.bn-btn--sm-del:hover { background: rgba(239,68,68,0.1); }

.bn-btn--sm-icon {
  width: 30px; height: 30px; padding: 0; border-radius: var(--r-sm, 6px);
  background: transparent; color: var(--tx-muted, #9ca3af);
  display: inline-flex; align-items: center; justify-content: center;
}
.bn-btn--sm-icon:hover { color: var(--tx-primary, #fff); background: rgba(255,255,255,0.05); }

/* ── Stat cards ── */
.bn-stats {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 1.25rem;
}
@media (max-width: 960px) { .bn-stats { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 540px) { .bn-stats { grid-template-columns: 1fr; } }

.bn-stat {
  background: linear-gradient(145deg, var(--bg-surface, #0f172a), var(--bg-raised, #0b0f19));
  border: 1px solid rgba(255, 255, 255, 0.05);
  border-radius: var(--r-lg, 12px);
  padding: 1.25rem 1.5rem;
  display: flex;
  flex-direction: column;
  gap: .75rem;
  position: relative;
  overflow: hidden;
  transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3);
}
.bn-stat:hover {
  transform: translateY(-4px);
  border-color: rgba(255, 255, 255, 0.1);
  box-shadow: 0 12px 24px -5px rgba(0, 0, 0, 0.5);
}
.bn-stat::after {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 3px;
  border-radius: var(--r-lg, 12px) var(--r-lg, 12px) 0 0;
}
.bn-stat--total::after { background: var(--ac, #3b82f6); }
.bn-stat--live::after  { background: var(--ok, #10b981); }
.bn-stat--draft::after { background: var(--tx-muted, #6b7280); }
.bn-stat--views::after { background: #6366f1; }

.bn-stat__head {
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.bn-stat__label {
  font-size: .75rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: .05em;
  color: var(--tx-muted, #9ca3af);
}
.bn-stat__icon {
  width: 36px; height: 36px;
  border-radius: var(--r-sm, 8px);
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
}
.bn-stat--total .bn-stat__icon { background: rgba(59,130,246,0.1);  color: var(--ac, #60a5fa); }
.bn-stat--live  .bn-stat__icon { background: rgba(16,185,129,0.1);  color: var(--ok, #34d399); }
.bn-stat--draft .bn-stat__icon { background: rgba(255,255,255,0.03); color: var(--tx-muted, #9ca3af); }
.bn-stat--views .bn-stat__icon { background: rgba(99,102,241,0.1); color: #818cf8; }

.bn-stat__val {
  font-family: var(--font-mono, monospace);
  font-size: 2rem;
  font-weight: 800;
  color: var(--tx-primary, #ffffff);
  letter-spacing: -.03em;
  line-height: 1;
}

/* ── Panel ── */
.bn-panel {
  background: var(--bg-surface, #0f172a);
  border: 1px solid rgba(255, 255, 255, 0.04);
  border-radius: var(--r-lg, 12px);
  box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.5);
  overflow: hidden;
}

.bn-panel__head {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 1rem;
  padding: 1.25rem 1.5rem;
  border-bottom: 1px solid rgba(255, 255, 255, 0.04);
  background: transparent;
  flex-wrap: wrap;
}
.bn-panel__head-l {
  display: flex;
  align-items: center;
  gap: .75rem;
}
.bn-panel__title {
  font-size: .875rem;
  font-weight: 700;
  color: var(--tx-primary, #ffffff);
}
.bn-panel__sep {
  width: 1px; height: 16px;
  background: rgba(255, 255, 255, 0.1);
}
.bn-panel__sub {
  font-size: .875rem;
  color: var(--tx-muted, #9ca3af);
  font-family: var(--font-mono, monospace);
}
.bn-panel__head-r {
  display: flex;
  align-items: center;
  gap: .5rem;
  flex-wrap: wrap;
  flex-grow: 1;
  justify-content: flex-end;
}
.bn-form-search {
  display: flex;
  gap: .5rem;
  align-items: center;
  flex-wrap: wrap;
  width: 100%;
  max-width: 350px;
}

/* ── Search ── */
.bn-search {
  position: relative;
  flex-grow: 1;
}
.bn-search__ico {
  position: absolute;
  left: 12px; top: 50%;
  transform: translateY(-50%);
  color: var(--tx-muted, #64748b);
  pointer-events: none;
  display: flex;
}
.bn-search__input {
  width: 100%;
  height: 36px;
  background: transparent;
  border: 1px solid transparent;
  border-radius: var(--r-sm, 6px);
  padding: 0 12px 0 36px;
  font-size: .875rem;
  font-family: inherit;
  color: var(--tx-primary, #ffffff);
  outline: none;
  transition: all .2s ease;
}
.bn-search__input::placeholder { color: var(--tx-muted, #64748b); }
.bn-search__input:focus {
  background: rgba(255, 255, 255, 0.02);
}
.bn-search__btn {
  height: 36px; padding: 0 16px;
  font-size: .875rem; font-weight: 600;
  background: var(--ac, #3b82f6); color: #fff;
  border: none; border-radius: var(--r-sm, 6px);
  cursor: pointer; font-family: inherit;
  display: inline-flex; align-items: center; gap: .4rem;
  transition: all .2s ease;
}
.bn-search__btn:hover { filter: brightness(1.1); }
.bn-reset {
  height: 36px; padding: 0 14px;
  font-size: .875rem; font-weight: 600;
  background: transparent;
  border: 1px solid rgba(255, 255, 255, 0.1);
  color: var(--tx-secondary, #d1d5db);
  border-radius: var(--r-sm, 6px); cursor: pointer;
  font-family: inherit;
  text-decoration: none;
  display: inline-flex; align-items: center; gap: .4rem;
}
.bn-reset:hover { border-color: var(--er, #ef4444); color: var(--er, #ef4444); }


/* =========================================
   ── TABLE REVISION (Sleek & Borderless) ──
   ========================================= */
.bn-tbl-wrap { 
  width: 100%;
  overflow-x: auto; 
}
.bn-tbl-wrap::-webkit-scrollbar { height: 6px; }
.bn-tbl-wrap::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 3px; }
.bn-tbl-wrap::-webkit-scrollbar-track { background: transparent; }

.bn-tbl {
  width: 100%;
  border-collapse: collapse; /* Menggunakan collapse untuk garis horizontal seamless */
  min-width: 800px;
}

/* Header styling sangat clean, huruf kecil dengan letter spacing */
.bn-tbl thead th {
  padding: 1.25rem 1.5rem;
  text-align: left;
  font-size: .65rem; 
  font-weight: 700;
  letter-spacing: .12em; 
  text-transform: uppercase;
  color: rgba(255, 255, 255, 0.35); /* Teks sangat muted */
  background: rgba(255, 255, 255, 0.015); /* Background hampir tak terlihat */
  border-bottom: 1px solid rgba(255, 255, 255, 0.03); /* Garis bawah yang amat tipis */
  border-right: none; /* NO VERTICAL BORDERS */
  border-left: none;
  white-space: nowrap;
  user-select: none;
}
.bn-tbl thead th.c { text-align: center; }

/* Baris dengan transisi hover yang elegan */
.bn-tbl tbody tr {
  transition: background .2s ease;
  background: transparent;
}
.bn-tbl tbody tr:hover { 
  background: rgba(255, 255, 255, 0.02); /* Hover super soft */
}

/* Sel tanpa border vertikal dan garis bawah tipis */
.bn-tbl td {
  padding: 1.25rem 1.5rem; /* Ruang lega */
  vertical-align: middle;
  font-size: .875rem;
  color: rgba(255, 255, 255, 0.85);
  border-bottom: 1px solid rgba(255, 255, 255, 0.03); /* Subtle row divider */
  border-right: none; /* NO VERTICAL BORDERS */
  border-left: none;
}
.bn-tbl td.c { text-align: center; }
.bn-tbl tbody tr:last-child td { border-bottom: none; } 

/* col widths */
col.c-no    { width: 60px; }
col.c-title { width: auto; }
col.c-kat   { width: 160px; }
col.c-st    { width: 100px; }
col.c-views { width: 100px; }
col.c-date  { width: 140px; }
col.c-act   { width: 140px; }

/* ── Row number (Tanpa Kotak) ── */
.bn-rn {
  font-family: var(--font-mono, monospace);
  font-size: .75rem; font-weight: 700;
  color: rgba(255, 255, 255, 0.4);
}

/* ── Title cell ── */
.bn-tc { display: flex; align-items: center; gap: 1rem; }
.bn-tc__title {
  font-size: .95rem;
  font-weight: 600;
  color: rgba(255, 255, 255, 0.95);
  display: block;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  max-width: 380px;
  line-height: 1.4;
}
.bn-tc__slug {
  font-family: var(--font, sans-serif);
  font-size: .75rem;
  color: rgba(255, 255, 255, 0.4); /* Sama dengan gaya teks "Alumni" di gambar referensi */
  display: block;
  margin-top: .2rem;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  max-width: 340px;
}
.bn-tc__pending {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  font-size: .65rem;
  font-weight: 700;
  color: var(--wa, #fbbf24);
  background: transparent;
  padding: 0;
  margin-top: .3rem;
  line-height: 1;
  text-transform: uppercase;
  letter-spacing: 0.05em;
}

/* ── Category (Minimalis) ── */
.bn-kat {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  font-size: .875rem;
  font-weight: 500;
  color: rgba(255, 255, 255, 0.7);
  white-space: nowrap;
}
.bn-kat__dot {
  width: 6px; height: 6px;
  border-radius: 50%;
  background: var(--ac, #60a5fa);
  opacity: .8;
}

/* ── Status (Mengikuti desain hijau PAB) ── */
.bn-st {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 4px 10px;
  border-radius: 99px;
  background: rgba(16, 185, 129, 0.05);
  border: 1px solid rgba(16, 185, 129, 0.2);
  font-size: .65rem;
  font-weight: 700;
  letter-spacing: .08em;
  text-transform: uppercase;
  color: var(--ok, #34d399);
  white-space: nowrap;
}
.bn-st__dot { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
.bn-st--live { background: rgba(16,185,129,0.05); color: var(--ok, #34d399); border-color: rgba(16,185,129,0.2); }
.bn-st--live .bn-st__dot { background: var(--ok, #10b981); box-shadow: 0 0 6px var(--ok, #10b981); animation: bn-pulse 2.2s ease-in-out infinite; }
.bn-st--dft  { background: transparent; color: var(--tx-muted, #64748b); border-color: rgba(255,255,255,0.1); }
.bn-st--dft  .bn-st__dot { background: var(--tx-muted, #64748b); }

/* ── Views ── */
.bn-vw {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  font-family: var(--font-mono, monospace);
  font-size: .875rem;
  color: rgba(255, 255, 255, 0.85);
}

/* ── Date ── */
.bn-dt {
  font-family: var(--font-mono, monospace);
  font-size: .875rem;
  color: rgba(255, 255, 255, 0.5);
  white-space: nowrap;
}

/* ── Actions ── */
.bn-acts {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: .25rem;
}

/* ── Empty ── */
.bn-empty {
  padding: 5rem 1.5rem;
  text-align: center;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: .75rem;
}
.bn-empty__icon {
  width: 56px; height: 56px;
  border-radius: var(--r-lg, 12px);
  background: rgba(255,255,255,0.02);
  border: 1px dashed rgba(255,255,255,0.1);
  display: flex; align-items: center; justify-content: center;
  color: rgba(255,255,255,0.3);
  margin-bottom: .5rem;
}
.bn-empty__h { font-size: 1rem; font-weight: 600; color: rgba(255,255,255,0.8); margin: 0; }
.bn-empty__p { font-size: .875rem; color: rgba(255,255,255,0.4); margin: 0; }
.bn-empty__p a { color: var(--ac, #60a5fa); text-decoration: none; font-weight: 600; }
.bn-empty__p a:hover { text-decoration: underline; }

/* ── Footer ── */
.bn-panel__foot {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 1.25rem;
  padding: 1.25rem 1.5rem;
  background: transparent;
  flex-wrap: wrap;
}
.bn-foot-info {
  font-size: .875rem;
  color: rgba(255, 255, 255, 0.5);
}
.bn-foot-info b { color: rgba(255, 255, 255, 0.9); font-weight: 600; }
.bn-foot-info .ac { color: var(--ac, #60a5fa); font-weight: 600; }

.bn-pager { display: flex; gap: .4rem; align-items: center; }
.bn-pg {
  display: inline-flex; align-items: center; justify-content: center;
  min-width: 32px; height: 32px; padding: 0 8px;
  border-radius: var(--r-sm, 6px);
  font-size: .875rem; font-weight: 600;
  text-decoration: none;
  background: transparent;
  color: rgba(255, 255, 255, 0.6);
  transition: all .2s ease;
}
.bn-pg:hover { color: var(--ac-bright, #93c5fd); background: rgba(255, 255, 255, 0.05); }
.bn-pg--on {
  background: rgba(255, 255, 255, 0.1); color: #fff;
  pointer-events: none;
}
.bn-pg-dots {
  display: inline-flex; align-items: center; justify-content: center;
  width: 24px; height: 32px;
  font-size: .875rem; color: rgba(255, 255, 255, 0.4);
}
</style>

<?php
function bn_page_range(int $cur, int $tot, int $d = 2): array {
  $range = [];
  $l = max(1, $cur - $d); $r = min($tot, $cur + $d);
  if ($l > 1) { $range[] = 1; if ($l > 2) $range[] = '…'; }
  for ($i = $l; $i <= $r; $i++) $range[] = $i;
  if ($r < $tot) { if ($r < $tot - 1) $range[] = '…'; $range[] = $tot; }
  return $range;
}

$page    = max(1, (int)($page   ?? 1));
$pages   = max(1, (int)($pages  ?? 1));
$total   = (int)($total  ?? 0);
$items   = $items ?? [];
$perPage = (int)($perPage ?? 15);
$offset  = ($page - 1) * $perPage;

$cntPub   = count(array_filter($items, fn($b) => $b['status'] === 'published'));
$cntDraft = count($items) - $cntPub;
$cntViews = (int)array_sum(array_column($items, 'views'));

$ficons = [
  'success' => '<svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>',
  'error'   => '<svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>',
  'warning' => '<svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>',
];
?>

<div class="bn">

  <div class="bn-header">
    <div class="bn-header-text">
      <h1 class="bn-page-title">Berita &amp; Artikel</h1>
      <p class="bn-page-sub">Total <?= number_format($total) ?> artikel tersimpan di database</p>
    </div>
    <div class="bn-header-actions">
      <?php if (!empty($pendingKomen) && (int)$pendingKomen > 0): ?>
      <a href="<?= BASE_URL ?>/admin/berita/komentar" class="bn-btn bn-btn--warning">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
        <?= (int)$pendingKomen ?> Komentar Pending
      </a>
      <?php endif; ?>
      <a href="<?= BASE_URL ?>/admin/berita/create" class="bn-btn bn-btn--primary">
        Tulis Berita
      </a>
    </div>
  </div>

  <?php if (!empty($flash)): ?>
  <div class="bn-flash bn-flash--<?= htmlspecialchars($flash['type']) ?>">
    <?= $ficons[$flash['type']] ?? '' ?>
    <span><?= htmlspecialchars($flash['msg']) ?></span>
  </div>
  <?php endif; ?>

  <div class="bn-stats">
    <div class="bn-stat bn-stat--total">
      <div class="bn-stat__head">
        <span class="bn-stat__label">Total Artikel</span>
        <div class="bn-stat__icon">
          <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
        </div>
      </div>
      <span class="bn-stat__val"><?= number_format($total) ?></span>
    </div>

    <div class="bn-stat bn-stat--live">
      <div class="bn-stat__head">
        <span class="bn-stat__label">Dipublikasi</span>
        <div class="bn-stat__icon">
          <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
        </div>
      </div>
      <span class="bn-stat__val"><?= number_format($cntPub) ?></span>
    </div>

    <div class="bn-stat bn-stat--draft">
      <div class="bn-stat__head">
        <span class="bn-stat__label">Draft</span>
        <div class="bn-stat__icon">
          <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4z"/></svg>
        </div>
      </div>
      <span class="bn-stat__val"><?= number_format($cntDraft) ?></span>
    </div>

    <div class="bn-stat bn-stat--views">
      <div class="bn-stat__head">
        <span class="bn-stat__label">Total Views</span>
        <div class="bn-stat__icon">
          <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
        </div>
      </div>
      <span class="bn-stat__val"><?= $cntViews >= 1000 ? number_format($cntViews/1000,1).'k' : number_format($cntViews) ?></span>
    </div>
  </div>

  <div class="bn-panel">

    <div class="bn-panel__head">
      <div class="bn-panel__head-l">
        <span class="bn-panel__title">DAFTAR ARTIKEL</span>
        <?php if (!empty($items)): ?>
        <span class="bn-panel__sub" style="margin-left: 8px;">
          <?= number_format(count($items)) ?> dari <?= number_format($total) ?>
        </span>
        <?php endif; ?>
      </div>

      <div class="bn-panel__head-r">
        <form method="GET" action="<?= BASE_URL ?>/admin/berita" class="bn-form-search">
          <div class="bn-search">
            <span class="bn-search__ico">
              <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            </span>
            <input type="text" name="q" value="<?= htmlspecialchars($search ?? '') ?>" placeholder="Cari judul atau kategori..." class="bn-search__input" autocomplete="off">
          </div>
          <button type="submit" class="bn-search__btn">Cari</button>
          <?php if (!empty($search)): ?>
          <a href="<?= BASE_URL ?>/admin/berita" class="bn-reset" title="Reset">Reset</a>
          <?php endif; ?>
        </form>
      </div>
    </div>

    <div class="bn-tbl-wrap">
      <table class="bn-tbl">
        <colgroup>
          <col class="c-no">
          <col class="c-title">
          <col class="c-kat">
          <col class="c-st">
          <col class="c-views">
          <col class="c-date">
          <col class="c-act">
        </colgroup>
        <thead>
          <tr>
            <th class="c">#</th>
            <th>Judul Artikel</th>
            <th>Kategori</th>
            <th>Status</th>
            <th class="c">Views</th>
            <th>Tanggal</th>
            <th class="c">Aksi</th>
          </tr>
        </thead>
        <tbody>
        <?php if (empty($items)): ?>
          <tr>
            <td colspan="7" style="padding:0;border:none">
              <div class="bn-empty">
                <div class="bn-empty__icon">
                  <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                </div>
                <?php if (!empty($search)): ?>
                  <p class="bn-empty__h">Tidak ada hasil</p>
                  <p class="bn-empty__p">Tidak ada artikel yang cocok dengan "<strong><?= htmlspecialchars($search) ?></strong>"</p>
                <?php else: ?>
                  <p class="bn-empty__h">Belum ada artikel</p>
                  <p class="bn-empty__p"><a href="<?= BASE_URL ?>/admin/berita/create">Tulis artikel pertama →</a></p>
                <?php endif; ?>
              </div>
            </td>
          </tr>
        <?php else: foreach ($items as $i => $b): ?>
          <tr>
            <td class="c">
              <span class="bn-rn"><?= $offset + $i + 1 ?></span>
            </td>

            <td>
              <div class="bn-tc">
                <div>
                  <span class="bn-tc__title" title="<?= htmlspecialchars($b['judul']) ?>"><?= htmlspecialchars($b['judul']) ?></span>
                  <?php if (!empty($b['slug'])): ?>
                  <span class="bn-tc__slug">/<?= htmlspecialchars($b['slug']) ?></span>
                  <?php endif; ?>
                </div>
              </div>
            </td>

            <td>
              <span class="bn-kat"><span class="bn-kat__dot"></span> <?= htmlspecialchars($b['kategori_nama'] ?? 'Tanpa Kategori') ?></span>
            </td>

            <td>
              <?php if ($b['status'] === 'published'): ?>
                <span class="bn-st bn-st--live"><span class="bn-st__dot"></span>Live</span>
              <?php else: ?>
                <span class="bn-st bn-st--dft"><span class="bn-st__dot"></span>Draft</span>
              <?php endif; ?>
            </td>

            <td class="c">
              <span class="bn-vw">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                &nbsp;<?= number_format($b['views']) ?>
              </span>
            </td>

            <td>
              <span class="bn-dt"><?= date('d/m/Y', strtotime($b['published_at'] ?: $b['created_at'])) ?></span>
            </td>

            <td>
              <div class="bn-acts">
                <a href="<?= BASE_URL ?>/berita/<?= htmlspecialchars($b['slug']) ?>" target="_blank" class="bn-btn bn-btn--sm-icon" title="Lihat">
                  <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                </a>
                <a href="<?= BASE_URL ?>/admin/berita/<?= (int)$b['id'] ?>/edit" class="bn-btn bn-btn--sm-edit">Edit</a>
                <form method="POST" action="<?= BASE_URL ?>/admin/berita/<?= (int)$b['id'] ?>/delete" style="display:inline;margin:0" onsubmit="return confirm('Hapus artikel ini?')">
                  <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
                  <button type="submit" class="bn-btn bn-btn--sm-del">Hapus</button>
                </form>
              </div>
            </td>
          </tr>
        <?php endforeach; endif; ?>
        </tbody>
      </table>
    </div>

    <?php if (!empty($items)): ?>
    <div class="bn-panel__foot">
      <span class="bn-foot-info">
        Menampilkan <?= number_format($offset + 1) ?>–<?= number_format(min($offset + count($items), $total)) ?> dari <?= number_format($total) ?> artikel
      </span>

      <?php if ($pages > 1): ?>
      <nav class="bn-pager" aria-label="Paginasi">
        <?php
          $burl = BASE_URL . '/admin/berita?page=';
          $qs   = !empty($search) ? '&q=' . urlencode($search) : '';
        ?>
        <?php if ($page > 1): ?>
        <a href="<?= $burl.($page-1).$qs ?>" class="bn-pg">
          <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
        </a>
        <?php endif; ?>

        <?php foreach (bn_page_range($page, $pages) as $p): ?>
          <?php if ($p === '…'): ?>
            <span class="bn-pg-dots">…</span>
          <?php elseif ($p === $page): ?>
            <span class="bn-pg bn-pg--on"><?= $p ?></span>
          <?php else: ?>
            <a href="<?= $burl.$p.$qs ?>" class="bn-pg"><?= $p ?></a>
          <?php endif; ?>
        <?php endforeach; ?>

        <?php if ($page < $pages): ?>
        <a href="<?= $burl.($page+1).$qs ?>" class="bn-pg">
          <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
        </a>
        <?php endif; ?>
      </nav>
      <?php endif; ?>
    </div>
    <?php endif; ?>

  </div></div>