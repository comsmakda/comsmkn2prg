<?php
// app/views/admin/berita.php
?>

<style>
/* ── Base & Variables (selaras design system — sama seperti dashboard.php / absensi.php) ── */
.bn * { box-sizing: border-box; }

.bn {
  /* Font */
  --font:      var(--ff, 'Plus Jakarta Sans', sans-serif);
  --font-mono: var(--ff, 'Plus Jakarta Sans', sans-serif);

  /* Surface */
  --bg-surface:  var(--c-white, #ffffff);
  --bg-raised:   #f8fafc;
  --bg-overlay:  #eef2f6;

  /* Border */
  --bd-subtle:  var(--c-border, #e6ebf1);
  --bd-default: var(--c-border, #e6ebf1);
  --bd-accent:  var(--c-primary-25, rgba(14,116,144,.25));

  /* Text */
  --tx-primary:   var(--c-ink,    #0f172a);
  --tx-secondary: var(--c-muted,  #64748b);
  --tx-muted:     var(--c-muted2, #94a3b8);

  /* Aksen — satu-satunya warna aksen dekoratif */
  --ac:        var(--c-primary,    #0e7490);
  --ac-bright: var(--c-primary-lt, #06b6d4);
  --ac-dim:    var(--c-primary-08, rgba(14,116,144,.08));

  /* Status */
  --ok:      var(--c-green-text,   #15803d);
  --ok-dim:  var(--c-green-bg,     #f0fdf4);
  --ok-bd:   var(--c-green-border, #bbf7d0);
  --er:      var(--c-red-text,     #b91c1c);
  --er-dim:  var(--c-red-bg,       #fef2f2);
  --er-bd:   var(--c-red-border,   #fecaca);
  --wa:      var(--c-amber-icon,   #d9910c);
  --wa-dim:  var(--c-amber-bg,     #fef6e2);
  --wa-bd:   var(--c-amber-border, #fbe3a8);

  /* Radius */
  --r-sm: var(--radius-sm, 9px);
  --r-md: var(--radius-sm, 9px);
  --r-lg: var(--radius-lg, 22px);

  display: flex;
  flex-direction: column;
  gap: 1.75rem;
  font-family: var(--font);
  color: var(--tx-primary);
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
  font-family: var(--font-mono);
  font-size: .75rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: .08em;
  color: var(--ac);
}
.bn-eyebrow__dot {
  width: 6px; height: 6px;
  border-radius: 50%;
  background: var(--ac);
  box-shadow: 0 0 8px var(--ac);
  animation: bn-pulse 2s ease-in-out infinite;
}
@keyframes bn-pulse {
  0%, 100% { opacity: 1; transform: scale(1); box-shadow: 0 0 8px var(--ac); }
  50%      { opacity: 0.5; transform: scale(0.7); box-shadow: 0 0 2px var(--ac); }
}
.bn-page-title {
  font-size: 1.85rem;
  font-weight: 800;
  color: var(--c-primary-dk, #0b5a70);
  letter-spacing: -.03em;
  margin: 0;
  line-height: 1.2;
}
.bn-page-sub {
  font-size: .875rem;
  color: var(--tx-secondary);
  margin: 0;
}
.bn-page-sub b { color: var(--tx-primary); font-weight: 700; }

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
  border-radius: var(--r-md);
  font-size: .875rem;
  font-weight: 600;
  border: 1px solid transparent;
  animation: bn-fadein .3s cubic-bezier(0.16, 1, 0.3, 1);
}
@keyframes bn-fadein {
  from { opacity: 0; transform: translateY(-8px); }
  to   { opacity: 1; transform: translateY(0); }
}
.bn-flash--success { background: var(--ok-dim); color: var(--ok); border-color: var(--ok-bd); }
.bn-flash--error   { background: var(--er-dim); color: var(--er); border-color: var(--er-bd); }
.bn-flash--warning { background: var(--wa-dim); color: var(--wa); border-color: var(--wa-bd); }

/* ── Buttons ── */
.bn-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: .5rem;
  font-family: inherit;
  font-weight: 700;
  border: 1px solid transparent;
  border-radius: var(--r-sm);
  cursor: pointer;
  text-decoration: none;
  white-space: nowrap;
  transition: all .18s cubic-bezier(0.4, 0, 0.2, 1);
  line-height: 1;
}
.bn-btn:hover  { transform: translateY(-2px); }
.bn-btn:active { transform: translateY(0); filter: brightness(0.97); }

.bn-btn--primary {
  height: 40px; padding: 0 18px; font-size: .875rem;
  background: var(--ac); color: #fff;
  box-shadow: 0 8px 20px rgba(14,116,144,.22);
}
.bn-btn--primary:hover {
  background: var(--ac-bright);
  box-shadow: 0 12px 26px rgba(6,182,212,.30);
}
.bn-btn--warning {
  height: 40px; padding: 0 16px; font-size: .875rem;
  background: var(--wa-dim); border: 1px solid var(--wa-bd); color: var(--wa);
}
.bn-btn--sm-edit,
.bn-btn--sm-del {
  height: 30px; padding: 0 12px; font-size: .75rem; border-radius: var(--r-sm);
  background: transparent;
}
.bn-btn--sm-edit {
  color: var(--ac);
}
.bn-btn--sm-edit:hover { background: var(--ac-dim); }
.bn-btn--sm-del {
  color: var(--er);
}
.bn-btn--sm-del:hover { background: var(--er-dim); }

.bn-btn--sm-icon {
  width: 30px; height: 30px; padding: 0; border-radius: var(--r-sm);
  background: transparent; color: var(--tx-muted);
  display: inline-flex; align-items: center; justify-content: center;
}
.bn-btn--sm-icon:hover { color: var(--tx-primary); background: var(--bg-overlay); }

/* ── Stat cards (selaras gaya KPI dashboard.php) ── */
.bn-stats {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 1.1rem;
}
@media (max-width: 960px) { .bn-stats { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 540px) { .bn-stats { grid-template-columns: 1fr; } }

.bn-stat {
  background: var(--bg-surface);
  border: 1px solid var(--bd-subtle);
  border-radius: var(--r-lg);
  padding: 1.15rem 1.4rem 1rem;
  display: flex;
  flex-direction: column;
  gap: .7rem;
  position: relative;
  overflow: hidden;
  transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
}
.bn-stat:hover {
  transform: translateY(-3px);
  box-shadow: 0 16px 34px -14px rgba(15,23,42,.18), 0 4px 12px rgba(15,23,42,.05);
}
.bn-stat::after {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 3px;
  border-radius: var(--r-lg) var(--r-lg) 0 0;
}
.bn-stat--total::after { background: var(--ac); }
.bn-stat--live::after  { background: var(--ok); }
.bn-stat--draft::after { background: var(--c-primary-dk, #0b5a70); }
.bn-stat--views::after { background: var(--ac-bright); }

.bn-stat__head {
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.bn-stat__label {
  font-size: .72rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: .05em;
  color: var(--tx-muted);
}
.bn-stat__icon {
  width: 34px; height: 34px;
  border-radius: var(--r-sm);
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
}
.bn-stat--total .bn-stat__icon { background: var(--ac-dim);   color: var(--ac); }
.bn-stat--live  .bn-stat__icon { background: var(--ok-dim);   color: var(--ok); }
.bn-stat--draft .bn-stat__icon { background: var(--bg-overlay); color: var(--tx-muted); }
.bn-stat--views .bn-stat__icon { background: rgba(6,182,212,.10); color: var(--ac-bright); }

.bn-stat__val {
  font-family: var(--font-mono);
  font-size: 1.9rem;
  font-weight: 800;
  color: var(--tx-primary);
  letter-spacing: -.03em;
  line-height: 1;
}

/* ── Panel ── */
.bn-panel {
  background: var(--bg-surface);
  border: 1px solid var(--bd-subtle);
  border-radius: var(--r-lg);
  overflow: hidden;
}

.bn-panel__head {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 1rem;
  padding: 1.15rem 1.4rem;
  border-bottom: 1px solid var(--bd-subtle);
  background: transparent;
  flex-wrap: wrap;
}
.bn-panel__head-l {
  display: flex;
  align-items: center;
  gap: .75rem;
}
.bn-panel__title {
  font-size: .8rem;
  font-weight: 800;
  letter-spacing: .04em;
  color: var(--tx-primary);
}
.bn-panel__sep {
  width: 1px; height: 16px;
  background: var(--bd-subtle);
}
.bn-panel__sub {
  font-size: .8rem;
  color: var(--tx-muted);
  font-family: var(--font-mono);
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
  color: var(--tx-muted);
  pointer-events: none;
  display: flex;
}
.bn-search__input {
  width: 100%;
  height: 36px;
  background: #fbfcfe;
  border: 1.5px solid var(--bd-subtle);
  border-radius: var(--r-sm);
  padding: 0 12px 0 36px;
  font-size: .875rem;
  font-family: inherit;
  color: var(--tx-primary);
  outline: none;
  transition: all .18s ease;
}
.bn-search__input::placeholder { color: var(--tx-muted); }
.bn-search__input:focus {
  background: #fff;
  border-color: var(--ac-bright);
  box-shadow: 0 0 0 3px rgba(6,182,212,.12);
}
.bn-search__btn {
  height: 36px; padding: 0 16px;
  font-size: .875rem; font-weight: 700;
  background: var(--ac); color: #fff;
  border: none; border-radius: var(--r-sm);
  cursor: pointer; font-family: inherit;
  display: inline-flex; align-items: center; gap: .4rem;
  transition: all .18s ease;
}
.bn-search__btn:hover { background: var(--ac-bright); }
.bn-reset {
  height: 36px; padding: 0 14px;
  font-size: .875rem; font-weight: 700;
  background: transparent;
  border: 1.5px solid var(--bd-subtle);
  color: var(--tx-secondary);
  border-radius: var(--r-sm); cursor: pointer;
  font-family: inherit;
  text-decoration: none;
  display: inline-flex; align-items: center; gap: .4rem;
  transition: all .18s ease;
}
.bn-reset:hover { border-color: var(--er); color: var(--er); background: var(--er-dim); }


/* =========================================
   ── TABLE (Sleek & Borderless, versi terang) ──
   ========================================= */
.bn-tbl-wrap {
  width: 100%;
  overflow-x: auto;
}
.bn-tbl-wrap::-webkit-scrollbar { height: 6px; }
.bn-tbl-wrap::-webkit-scrollbar-thumb { background: var(--bd-default); border-radius: 3px; }
.bn-tbl-wrap::-webkit-scrollbar-track { background: transparent; }

.bn-tbl {
  width: 100%;
  border-collapse: collapse;
  min-width: 800px;
}

.bn-tbl thead th {
  padding: 1.1rem 1.4rem;
  text-align: left;
  font-size: .65rem;
  font-weight: 700;
  letter-spacing: .12em;
  text-transform: uppercase;
  color: var(--tx-muted);
  background: var(--bg-raised);
  border-bottom: 1px solid var(--bd-subtle);
  border-right: none;
  border-left: none;
  white-space: nowrap;
  user-select: none;
}
.bn-tbl thead th.c { text-align: center; }

.bn-tbl tbody tr {
  transition: background .18s ease;
  background: transparent;
}
.bn-tbl tbody tr:hover {
  background: rgba(14,116,144,.035);
}

.bn-tbl td {
  padding: 1.1rem 1.4rem;
  vertical-align: middle;
  font-size: .875rem;
  color: var(--tx-secondary);
  border-bottom: 1px solid var(--bd-subtle);
  border-right: none;
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

/* ── Row number ── */
.bn-rn {
  font-family: var(--font-mono);
  font-size: .75rem; font-weight: 700;
  color: var(--tx-muted);
}

/* ── Title cell ── */
.bn-tc { display: flex; align-items: center; gap: 1rem; }
.bn-tc__title {
  font-size: .95rem;
  font-weight: 700;
  color: var(--tx-primary);
  display: block;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  max-width: 380px;
  line-height: 1.4;
}
.bn-tc__slug {
  font-family: var(--font);
  font-size: .75rem;
  color: var(--tx-muted);
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
  color: var(--wa);
  background: transparent;
  padding: 0;
  margin-top: .3rem;
  line-height: 1;
  text-transform: uppercase;
  letter-spacing: 0.05em;
}

/* ── Category ── */
.bn-kat {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  font-size: .875rem;
  font-weight: 600;
  color: var(--tx-secondary);
  white-space: nowrap;
}
.bn-kat__dot {
  width: 6px; height: 6px;
  border-radius: 50%;
  background: var(--ac);
  opacity: .85;
}

/* ── Status ── */
.bn-st {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 4px 10px;
  border-radius: 99px;
  background: var(--ok-dim);
  border: 1px solid var(--ok-bd);
  font-size: .65rem;
  font-weight: 700;
  letter-spacing: .08em;
  text-transform: uppercase;
  color: var(--ok);
  white-space: nowrap;
}
.bn-st__dot { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
.bn-st--live { background: var(--ok-dim); color: var(--ok); border-color: var(--ok-bd); }
.bn-st--live .bn-st__dot { background: var(--ok); box-shadow: 0 0 6px var(--ok); animation: bn-pulse 2.2s ease-in-out infinite; }
.bn-st--dft  { background: var(--bg-overlay); color: var(--tx-muted); border-color: var(--bd-subtle); }
.bn-st--dft  .bn-st__dot { background: var(--tx-muted); }

/* ── Views ── */
.bn-vw {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  font-family: var(--font-mono);
  font-size: .875rem;
  color: var(--tx-secondary);
}

/* ── Date ── */
.bn-dt {
  font-family: var(--font-mono);
  font-size: .875rem;
  color: var(--tx-muted);
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
  border-radius: var(--r-lg);
  background: var(--bg-overlay);
  border: 1px dashed var(--bd-default);
  display: flex; align-items: center; justify-content: center;
  color: var(--tx-muted);
  margin-bottom: .5rem;
}
.bn-empty__h { font-size: 1rem; font-weight: 700; color: var(--tx-primary); margin: 0; }
.bn-empty__p { font-size: .875rem; color: var(--tx-muted); margin: 0; }
.bn-empty__p a { color: var(--ac); text-decoration: none; font-weight: 700; }
.bn-empty__p a:hover { text-decoration: underline; }

/* ── Footer ── */
.bn-panel__foot {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 1.25rem;
  padding: 1.15rem 1.4rem;
  background: transparent;
  border-top: 1px solid var(--bd-subtle);
  flex-wrap: wrap;
}
.bn-foot-info {
  font-size: .875rem;
  color: var(--tx-muted);
}
.bn-foot-info b { color: var(--tx-primary); font-weight: 700; }
.bn-foot-info .ac { color: var(--ac); font-weight: 700; }

.bn-pager { display: flex; gap: .4rem; align-items: center; }
.bn-pg {
  display: inline-flex; align-items: center; justify-content: center;
  min-width: 32px; height: 32px; padding: 0 8px;
  border-radius: var(--r-sm);
  font-size: .875rem; font-weight: 700;
  text-decoration: none;
  background: transparent;
  color: var(--tx-secondary);
  transition: all .18s ease;
}
.bn-pg:hover { color: var(--ac); background: var(--ac-dim); }
.bn-pg--on {
  background: var(--ac); color: #fff;
  pointer-events: none;
}
.bn-pg-dots {
  display: inline-flex; align-items: center; justify-content: center;
  width: 24px; height: 32px;
  font-size: .875rem; color: var(--tx-muted);
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