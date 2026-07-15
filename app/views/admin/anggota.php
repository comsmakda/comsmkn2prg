<?php // app/views/admin/anggota.php ?>

<style>
/* ═══════════════════════════════════════
   INHERIT DESIGN SYSTEM (alias ke token global, sama seperti dashboard)
═══════════════════════════════════════ */
.ang-root {
  --font-ui:   var(--ff, 'Plus Jakarta Sans', sans-serif);
  --font-mono: var(--ff, 'Plus Jakarta Sans', sans-serif);

  --bg-base:     var(--c-page,  #eef2f6);
  --bg-surface:  var(--c-white, #ffffff);
  --bg-elevated: #f8fafc;
  --bg-overlay:  #eef2f6;
  --bg-active:   var(--c-primary-08, rgba(14,116,144,.08));

  --bd-subtle:  var(--c-border, #e6ebf1);
  --bd-default: var(--c-border, #e6ebf1);
  --bd-accent:  var(--c-primary-25, rgba(14,116,144,.25));

  --tx-primary:   var(--c-ink,    #0f172a);
  --tx-secondary: var(--c-muted,  #64748b);
  --tx-muted:     var(--c-muted2, #94a3b8);

  --ac:      var(--c-primary,    #0e7490);
  --ac-dim:  var(--c-primary-08, rgba(14,116,144,.08));
  --ac-glow: var(--c-primary-12, rgba(14,116,144,.12));

  --blue:    var(--c-primary,    #0e7490);
  --blue-d:  var(--c-primary-08, rgba(14,116,144,.08));
  --amber:   var(--c-amber-icon, #d9910c);
  --amber-d: var(--c-amber-bg,   #fef6e2);
  --purple:  var(--c-primary-dk, #0b5a70);
  --purple-d:var(--c-primary-08, rgba(14,116,144,.08));
  --green:   var(--c-green-text, #15803d);
  --green-d: var(--c-green-bg,   #f0fdf4);
  --red:     var(--c-red-text,   #b91c1c);
  --red-d:   var(--c-red-bg,     #fef2f2);

  --r-xs: 6px;
  --r-sm: var(--radius-sm, 9px);
  --r-md: var(--radius-sm, 9px);
  --r-lg: var(--radius-md, 13px);
  --r-xl: var(--radius-lg, 22px);

  --ease: cubic-bezier(0.22,1,0.36,1);
  --t-fast: 120ms; --t-base: 160ms; --t-slow: 300ms;
}

.ang-root * { box-sizing: border-box; margin: 0; padding: 0; }
.ang-root a { text-decoration: none; color: inherit; }
.ang-root {
  font-family: var(--font-ui);
  color: var(--tx-primary);
  font-size: 13.5px;
  line-height: 1.5;
  -webkit-font-smoothing: antialiased;
}

/* ═══════════════════════════════════════
   PAGE HEADER
═══════════════════════════════════════ */
.ph {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  gap: 16px;
  margin-bottom: 26px;
  flex-wrap: wrap;
}
.ph__left {}
.ph__eyebrow {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  font-size: 11px;
  font-weight: 700;
  letter-spacing: 0.1em;
  text-transform: uppercase;
  color: var(--ac);
  margin-bottom: 7px;
}
.ph__eyebrow::before {
  content: '';
  width: 6px; height: 6px;
  border-radius: 50%;
  background: var(--ac);
  box-shadow: 0 0 6px var(--ac);
}
.ph__title {
  font-size: 24px;
  font-weight: 800;
  letter-spacing: -0.03em;
  color: var(--c-primary-dk, #0b5a70);
  line-height: 1.1;
}
.ph__sub {
  font-size: 12.5px;
  color: var(--tx-secondary);
  margin-top: 5px;
}

.ph__actions {
  display: flex;
  align-items: center;
  gap: 8px;
  flex-shrink: 0;
  padding-top: 4px;
}

/* Primary button */
.btn-pri {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  padding: 10px 17px;
  background: var(--ac);
  color: #fff;
  font-family: var(--font-ui);
  font-size: 12.5px;
  font-weight: 700;
  letter-spacing: -0.01em;
  border-radius: var(--r-md);
  border: none;
  cursor: pointer;
  box-shadow: 0 6px 16px rgba(14,116,144,.22);
  transition:
    background var(--t-fast) var(--ease),
    box-shadow var(--t-base) var(--ease),
    transform  var(--t-fast) var(--ease);
}
.btn-pri:hover {
  background: var(--c-primary-lt, #06b6d4);
  box-shadow: 0 8px 20px rgba(6,182,212,.28);
  transform: translateY(-1px);
}
.btn-pri i { font-size: 14px; }

/* Secondary/ghost button */
.btn-sec {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 9px 15px;
  background: var(--bg-surface);
  color: var(--tx-secondary);
  font-family: var(--font-ui);
  font-size: 12.5px;
  font-weight: 700;
  border: 1px solid var(--bd-subtle);
  border-radius: var(--r-md);
  cursor: pointer;
  transition:
    border-color var(--t-fast) var(--ease),
    background   var(--t-fast) var(--ease),
    color        var(--t-fast) var(--ease);
}
.btn-sec:hover {
  border-color: var(--bd-accent);
  background: var(--bg-elevated);
  color: var(--tx-primary);
}
.btn-sec i { font-size: 13px; }

/* ── Export dropdown ── */
.export-dropdown { position: relative; }
.export-menu {
  display: none;
  position: absolute;
  top: calc(100% + 6px);
  right: 0;
  min-width: 180px;
  background: var(--bg-surface);
  border: 1px solid var(--bd-subtle);
  border-radius: var(--r-lg);
  box-shadow: 0 16px 40px -12px rgba(15,23,42,.18), 0 4px 14px rgba(15,23,42,.06);
  padding: 6px;
  z-index: 40;
}
.export-menu.is-open { display: block; }
.export-menu a {
  display: flex;
  align-items: center;
  gap: 9px;
  padding: 9px 11px;
  font-size: 12.5px;
  font-weight: 600;
  color: var(--tx-secondary);
  border-radius: var(--r-sm);
  transition: background var(--t-fast) var(--ease), color var(--t-fast) var(--ease);
}
.export-menu a:hover { background: var(--ac-dim); color: var(--ac); }
.export-menu a i { font-size: 15px; color: var(--tx-muted); }
.export-menu a:hover i { color: var(--ac); }

/* ═══════════════════════════════════════
   SECTION LABEL
═══════════════════════════════════════ */
.sec-label {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 12px;
}
.sec-label__text {
  font-size: 10.5px;
  font-weight: 700;
  letter-spacing: 0.14em;
  text-transform: uppercase;
  color: var(--tx-muted);
  white-space: nowrap;
}
.sec-label__line {
  flex: 1;
  height: 1px;
  background: linear-gradient(to right, var(--bd-subtle), transparent);
}

/* ═══════════════════════════════════════
   STATS STRIP
═══════════════════════════════════════ */
.stats-strip {
  display: flex;
  gap: 12px;
  margin-bottom: 22px;
  flex-wrap: wrap;
}
.stat-pill {
  display: flex;
  align-items: center;
  gap: 11px;
  padding: 12px 15px;
  background: var(--bg-surface);
  border: 1px solid var(--bd-subtle);
  border-radius: var(--r-lg);
  flex: 1;
  min-width: 130px;
}
.stat-pill__ico {
  width: 30px; height: 30px;
  border-radius: var(--r-sm);
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}
.stat-pill__ico i { font-size: 14px; }
.stat-pill--blue   .stat-pill__ico { background: var(--blue-d);   color: var(--blue); }
.stat-pill--green  .stat-pill__ico { background: var(--green-d);  color: var(--green); }
.stat-pill--amber  .stat-pill__ico { background: var(--amber-d);  color: var(--amber); }
.stat-pill--purple .stat-pill__ico { background: var(--purple-d); color: var(--purple); }

.stat-pill__body {}
.stat-pill__val {
  font-size: 18px;
  font-weight: 800;
  letter-spacing: -0.03em;
  color: var(--tx-primary);
  line-height: 1;
  font-variant-numeric: tabular-nums;
}
.stat-pill__lbl {
  font-size: 10.5px;
  color: var(--tx-muted);
  margin-top: 2px;
  font-weight: 500;
}

/* ═══════════════════════════════════════
   FILTER BAR
═══════════════════════════════════════ */
.filter-bar {
  display: flex;
  align-items: center;
  gap: 9px;
  flex-wrap: wrap;
  margin-bottom: 20px;
}

.fi {
  position: relative;
  display: flex;
  align-items: center;
}
.fi__icon {
  position: absolute;
  left: 11px;
  color: var(--tx-muted);
  pointer-events: none;
  display: flex;
  font-size: 13px;
}

.fi input,
.fi select {
  font-family: var(--font-ui);
  font-size: 12.5px;
  color: var(--tx-primary);
  background: var(--bg-surface);
  border: 1.5px solid var(--bd-subtle);
  border-radius: var(--r-md);
  padding: 9px 14px 9px 32px;
  outline: none;
  transition: border-color var(--t-fast) var(--ease), background var(--t-fast) var(--ease), box-shadow var(--t-fast) var(--ease);
  -webkit-appearance: none;
}
.fi input { width: 230px; }
.fi select { width: 165px; }
.fi input:focus,
.fi select:focus {
  border-color: var(--c-primary-lt, #06b6d4);
  background: #fff;
  box-shadow: 0 0 0 3px rgba(6,182,212,.12);
}
.fi input::placeholder { color: var(--tx-muted); }

/* custom select arrow */
.fi--select::after {
  content: '';
  position: absolute;
  right: 11px;
  width: 0; height: 0;
  border-left: 4px solid transparent;
  border-right: 4px solid transparent;
  border-top: 4px solid var(--tx-muted);
  pointer-events: none;
}

.filter-btn {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 9px 15px;
  background: var(--bg-surface);
  color: var(--tx-secondary);
  font-family: var(--font-ui);
  font-size: 12.5px;
  font-weight: 700;
  border: 1.5px solid var(--bd-subtle);
  border-radius: var(--r-md);
  cursor: pointer;
  transition: all var(--t-fast) var(--ease);
}
.filter-btn:hover {
  border-color: var(--bd-accent);
  background: var(--ac-dim);
  color: var(--ac);
}
.filter-btn i { font-size: 13px; }

.filter-reset {
  font-size: 11px;
  font-weight: 600;
  color: var(--tx-muted);
  padding: 5px 9px;
  border-radius: var(--r-xs);
  transition: color var(--t-fast) var(--ease);
}
.filter-reset:hover { color: var(--red); }

/* ═══════════════════════════════════════
   PENDING ACTIVATION BANNER
═══════════════════════════════════════ */
.pending-banner {
  margin-bottom: 20px;
  background: var(--amber-d);
  border: 1px solid rgba(217,145,12,0.28);
  border-radius: var(--r-xl);
  overflow: hidden;
}
.pending-banner__head {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 13px 18px;
  border-bottom: 1px solid rgba(217,145,12,0.18);
  gap: 8px;
}
.pending-banner__title {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 12.5px;
  font-weight: 700;
  color: var(--c-amber-text, #8a5a06);
}
.pending-banner__title i { font-size: 15px; }
.pending-banner__count {
  font-size: 10.5px;
  font-weight: 700;
  background: #fff;
  color: var(--amber);
  padding: 3px 9px;
  border-radius: var(--r-xs);
}
.pending-banner__body {
  padding: 13px 18px;
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.pending-item {
  display: flex;
  align-items: center;
  gap: 11px;
  padding: 11px 13px;
  background: var(--bg-surface);
  border: 1px solid var(--bd-subtle);
  border-radius: var(--r-lg);
  transition: border-color var(--t-fast) var(--ease);
}
.pending-item:hover { border-color: rgba(217,145,12,0.35); }

.pending-item__ava {
  width: 34px; height: 34px;
  border-radius: var(--r-sm);
  background: var(--amber-d);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 11.5px;
  font-weight: 800;
  color: var(--amber);
  flex-shrink: 0;
  text-transform: uppercase;
}
.pending-item__info { flex: 1; min-width: 0; }
.pending-item__name {
  font-size: 12.5px;
  font-weight: 700;
  color: var(--tx-primary);
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.pending-item__meta {
  font-size: 10.5px;
  color: var(--tx-muted);
  margin-top: 2px;
  display: flex;
  gap: 9px;
  flex-wrap: wrap;
  font-weight: 500;
}
.pending-item__meta span { display: inline-flex; align-items: center; gap: 4px; }
.pending-item__meta i { font-size: 11px; }

.btn-activate {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 7px 13px;
  background: #fff;
  color: var(--c-amber-text, #8a5a06);
  font-family: var(--font-ui);
  font-size: 11.5px;
  font-weight: 700;
  border: 1px solid rgba(217,145,12,0.3);
  border-radius: var(--r-sm);
  cursor: pointer;
  transition: all var(--t-fast) var(--ease);
  white-space: nowrap;
  flex-shrink: 0;
}
.btn-activate:hover {
  background: var(--amber);
  color: #fff;
  border-color: var(--amber);
  box-shadow: 0 4px 14px rgba(217,145,12,0.25);
}
.btn-activate i { font-size: 12px; }

/* ═══════════════════════════════════════
   MAIN TABLE PANEL
═══════════════════════════════════════ */
.tpanel {
  background: var(--bg-surface);
  border: 1px solid var(--bd-subtle);
  border-radius: var(--r-xl);
  overflow: hidden;
}
.tpanel__head {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 15px 20px;
  border-bottom: 1px solid var(--bd-subtle);
  gap: 10px;
  flex-wrap: wrap;
}
.tpanel__title {
  font-size: 13px;
  font-weight: 800;
  color: var(--tx-primary);
  letter-spacing: -0.01em;
}
.tpanel__meta {
  font-size: 11px;
  color: var(--tx-muted);
  font-weight: 500;
}
.tpanel__meta strong {
  color: var(--tx-secondary);
  font-weight: 700;
}

/* ─── Table ─────────────────────────── */
.mtbl { width: 100%; border-collapse: collapse; }
.mtbl thead tr {
  background: var(--bg-elevated);
}
.mtbl th {
  font-size: 10.5px;
  font-weight: 700;
  letter-spacing: 0.08em;
  text-transform: uppercase;
  color: var(--tx-muted);
  text-align: left;
  padding: 11px 14px;
  border-bottom: 1px solid var(--bd-subtle);
  white-space: nowrap;
  user-select: none;
}
.mtbl th.sortable { cursor: pointer; }
.mtbl th.sortable:hover { color: var(--tx-secondary); }
.mtbl th .sort-ico { display: inline-block; margin-left: 4px; opacity: .4; font-size: 8px; }
.mtbl th.sort-asc  .sort-ico,
.mtbl th.sort-desc .sort-ico { opacity: 1; color: var(--ac); }

.mtbl tbody tr {
  border-bottom: 1px solid var(--bd-subtle);
  transition: background var(--t-fast) var(--ease);
}
.mtbl tbody tr:last-child { border-bottom: none; }
.mtbl tbody tr:hover { background: rgba(14,116,144,.03); }

.mtbl td {
  padding: 12px 14px;
  font-size: 12.5px;
  color: var(--tx-secondary);
  vertical-align: middle;
}

/* ─── Cell types ─────────────────────── */
.cell-nia {
  font-size: 11.5px;
  font-weight: 700;
  color: var(--ac);
  letter-spacing: 0.02em;
}
.cell-empty-nia {
  font-size: 11.5px;
  color: var(--tx-muted);
}

.cell-name-wrap {}
.cell-name {
  font-size: 13px;
  font-weight: 700;
  color: var(--tx-primary);
  display: block;
  line-height: 1.3;
}
.cell-kelas-inline {
  font-size: 10.5px;
  color: var(--tx-muted);
  font-weight: 500;
}

.cell-mono {
  font-size: 11.5px;
  color: var(--tx-muted);
  font-weight: 500;
}

/* Avatar */
.ava-wrap { display: flex; align-items: center; gap: 10px; }
.ava {
  width: 36px; height: 36px;
  border-radius: var(--r-sm);
  flex-shrink: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 11.5px;
  font-weight: 700;
  text-transform: uppercase;
  background: var(--bg-elevated);
  color: var(--tx-secondary);
  border: 1px solid var(--bd-subtle);
  overflow: hidden;
}
.ava img {
  width: 100%; height: 100%;
  object-fit: cover;
  display: block;
}

/* Source chip */
.src-chip {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  font-size: 10px;
  font-weight: 700;
  letter-spacing: 0.05em;
  padding: 3px 8px;
  border-radius: var(--r-xs);
  text-transform: uppercase;
}
.src-chip--pab    { background: var(--blue-d);   color: var(--blue);   border: 1px solid rgba(14,116,144,0.22); }
.src-chip--manual { background: var(--purple-d); color: var(--purple); border: 1px solid rgba(11,90,112,0.22); }

/* Jabatan chip */
.jbt-chip {
  display: inline-flex;
  align-items: center;
  font-size: 10.5px;
  font-weight: 700;
  padding: 3px 9px;
  border-radius: var(--r-xs);
  background: var(--bg-overlay);
  color: var(--tx-secondary);
  border: 1px solid var(--bd-subtle);
  white-space: nowrap;
}
.jbt-chip--pengurus {
  background: var(--ac-dim);
  color: var(--ac);
  border-color: rgba(14,116,144,0.22);
}

/* Status chip */
.status-chip {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  font-size: 10.5px;
  font-weight: 700;
  padding: 3px 9px;
  border-radius: var(--r-xs);
}
.status-chip__dot { width: 5px; height: 5px; border-radius: 50%; background: currentColor; }
.chip--aktif   { background: var(--green-d);  color: var(--green); }
.chip--pending { background: var(--amber-d);  color: var(--amber); }
.chip--non     { background: var(--bg-overlay); color: var(--tx-muted); }
.chip--tolak   { background: var(--red-d);    color: var(--red); }

/* Action buttons */
.act-group { display: flex; align-items: center; gap: 6px; }

.act-btn {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  padding: 6px 11px;
  font-family: var(--font-ui);
  font-size: 11px;
  font-weight: 700;
  border-radius: var(--r-sm);
  border: 1px solid var(--bd-subtle);
  cursor: pointer;
  background: var(--bg-surface);
  color: var(--tx-secondary);
  transition: all var(--t-fast) var(--ease);
  white-space: nowrap;
}
.act-btn:hover { border-color: var(--bd-accent); color: var(--tx-primary); background: var(--bg-elevated); }
.act-btn i { font-size: 12px; }

.act-btn--danger {
  background: transparent;
  color: var(--red);
  border-color: var(--red-d);
}
.act-btn--danger:hover {
  background: var(--red-d);
  border-color: rgba(185,28,28,0.3);
}

/* ── Reset password button ── */
.act-btn--reset {
  background: transparent;
  color: var(--ac);
  border-color: var(--ac-dim);
}
.act-btn--reset:hover {
  background: var(--ac-dim);
  border-color: var(--bd-accent);
  color: var(--ac);
}

/* Row empty state */
.tbl-empty {
  text-align: center;
  padding: 60px 24px;
  color: var(--tx-muted);
}
.tbl-empty__ico {
  font-size: 38px;
  opacity: .35;
  margin-bottom: 12px;
  display: block;
}
.tbl-empty__title {
  font-size: 14px;
  font-weight: 700;
  color: var(--tx-secondary);
  margin-bottom: 4px;
}
.tbl-empty__sub { font-size: 12px; }

/* ═══════════════════════════════════════
   PAGINATION
═══════════════════════════════════════ */
.pagination {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 13px 20px;
  border-top: 1px solid var(--bd-subtle);
  gap: 12px;
  flex-wrap: wrap;
}
.pagi-info {
  font-size: 11px;
  color: var(--tx-muted);
  font-weight: 500;
}
.pagi-info strong { color: var(--tx-secondary); font-weight: 700; }
.pagi-pages {
  display: flex;
  align-items: center;
  gap: 4px;
}
.pagi-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  min-width: 30px;
  height: 30px;
  padding: 0 6px;
  font-size: 11.5px;
  font-weight: 700;
  border-radius: var(--r-sm);
  border: 1px solid var(--bd-subtle);
  background: var(--bg-surface);
  color: var(--tx-muted);
  cursor: pointer;
  transition: all var(--t-fast) var(--ease);
}
.pagi-btn:hover { border-color: var(--bd-accent); color: var(--tx-primary); }
.pagi-btn--active {
  background: var(--ac-dim);
  border-color: var(--bd-accent);
  color: var(--ac);
}
.pagi-btn--disabled { opacity: .35; cursor: not-allowed; pointer-events: none; }
.pagi-btn i { font-size: 12px; }

/* ═══════════════════════════════════════
   CONFIRM DIALOG OVERLAY
═══════════════════════════════════════ */
.confirm-overlay {
  display: none;
  position: fixed;
  inset: 0;
  background: rgba(15,23,42,.45);
  backdrop-filter: blur(4px);
  z-index: 9999;
  align-items: center;
  justify-content: center;
}
.confirm-overlay.is-open { display: flex; }
.confirm-box {
  background: var(--bg-surface);
  border: 1px solid var(--bd-subtle);
  border-radius: var(--r-xl);
  padding: 28px;
  max-width: 380px;
  width: 90%;
  box-shadow: 0 30px 70px -20px rgba(15,23,42,.28), 0 4px 18px rgba(15,23,42,.08);
  animation: pop-in var(--t-slow) var(--ease) both;
}
@keyframes pop-in {
  from { transform: scale(.94) translateY(10px); opacity: 0; }
  to   { transform: scale(1)   translateY(0);    opacity: 1; }
}
.confirm-box__ico {
  width: 44px; height: 44px;
  border-radius: var(--r-lg);
  background: var(--red-d);
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--red);
  margin-bottom: 16px;
  font-size: 20px;
}
.confirm-box__title {
  font-size: 15.5px;
  font-weight: 800;
  color: var(--tx-primary);
  margin-bottom: 6px;
  letter-spacing: -0.02em;
}
.confirm-box__sub {
  font-size: 12.5px;
  color: var(--tx-muted);
  line-height: 1.6;
  margin-bottom: 20px;
}
.confirm-box__sub strong { color: var(--tx-secondary); }
.confirm-box__acts {
  display: flex;
  gap: 8px;
  justify-content: flex-end;
}

/* ── Reset dialog: password badge ── */
.pw-badge {
  display: inline-block;
  font-size: 12px;
  font-weight: 700;
  color: var(--ac);
  background: var(--ac-dim);
  border: 1px solid var(--bd-accent);
  border-radius: var(--r-xs);
  padding: 2px 9px;
  letter-spacing: 0.03em;
}

/* ═══════════════════════════════════════
   RESPONSIVE
═══════════════════════════════════════ */
@media (max-width: 768px) {
  .stats-strip { display: grid; grid-template-columns: repeat(2, 1fr); }
  .ph { flex-direction: column; gap: 12px; }
  .ph__actions { flex-wrap: wrap; }
  .filter-bar { flex-direction: column; align-items: stretch; }
  .fi input, .fi select { width: 100%; }
  .mtbl th:nth-child(4),
  .mtbl td:nth-child(4),
  .mtbl th:nth-child(5),
  .mtbl td:nth-child(5) { display: none; }
}
@media (max-width: 480px) {
  .stats-strip { grid-template-columns: 1fr 1fr; }
  .mtbl th:nth-child(7),
  .mtbl td:nth-child(7) { display: none; }
}
</style>

<!-- ═══════════════════════════════════════
     ROOT
═══════════════════════════════════════ -->
<div class="ang-root">

<!-- ─────────────────────────────────
     PAGE HEADER
────────────────────────────────── -->
<div class="ph">
  <div class="ph__left">
    <div class="ph__eyebrow">Manajemen Data</div>
    <h1 class="ph__title">Anggota</h1>
    <p class="ph__sub">Kelola seluruh data anggota — aktif, pending, dan riwayat.</p>
  </div>
  <div class="ph__actions">

    <?php
      $exportQuery = http_build_query(array_filter([
        'search'  => $filter['search']  ?? '',
        'kelas'   => $filter['kelas']   ?? '',
        'sumber'  => $filter['sumber']  ?? '',
        'jabatan' => $filter['jabatan'] ?? '',
      ]));
    ?>
    <div class="export-dropdown" id="export-dropdown">
      <button type="button" class="btn-sec" id="export-toggle">
        <i class="ti ti-download" aria-hidden="true"></i>
        Ekspor
        <i class="ti ti-chevron-down" aria-hidden="true" style="font-size:11px;"></i>
      </button>
      <div class="export-menu" id="export-menu">
        <a href="<?= BASE_URL ?>/admin/anggota/export?format=csv<?= $exportQuery ? '&' . $exportQuery : '' ?>">
          <i class="ti ti-file-type-csv" aria-hidden="true"></i> Export CSV
        </a>
        <a href="<?= BASE_URL ?>/admin/anggota/export?format=xlsx<?= $exportQuery ? '&' . $exportQuery : '' ?>">
          <i class="ti ti-file-spreadsheet" aria-hidden="true"></i> Export Excel
        </a>
      </div>
    </div>

    <a href="<?= BASE_URL ?>/admin/anggota/import" class="btn-sec">
      <i class="ti ti-file-upload" aria-hidden="true"></i>
      Impor
    </a>

    <a href="<?= BASE_URL ?>/admin/anggota/tambah" class="btn-pri">
      <i class="ti ti-plus" aria-hidden="true"></i>
      Tambah Anggota
    </a>
  </div>
</div>

<!-- ─────────────────────────────────
     STATS STRIP
────────────────────────────────── -->
<?php
  $totalAktif   = $stats['total_aktif']   ?? 0;
  $totalPending = $stats['total_pending'] ?? 0;
  $totalPab     = $stats['total_pab']     ?? 0;
  $totalManual  = $stats['total_manual']  ?? 0;
?>
<div class="stats-strip">

  <div class="stat-pill stat-pill--blue">
    <div class="stat-pill__ico"><i class="ti ti-users" aria-hidden="true"></i></div>
    <div class="stat-pill__body">
      <div class="stat-pill__val"><?= number_format($totalAktif) ?></div>
      <div class="stat-pill__lbl">Anggota Aktif</div>
    </div>
  </div>

  <div class="stat-pill stat-pill--amber">
    <div class="stat-pill__ico"><i class="ti ti-clock-hour-4" aria-hidden="true"></i></div>
    <div class="stat-pill__body">
      <div class="stat-pill__val"><?= number_format($totalPending) ?></div>
      <div class="stat-pill__lbl">Pending Aktivasi</div>
    </div>
  </div>

  <div class="stat-pill stat-pill--green">
    <div class="stat-pill__ico"><i class="ti ti-clipboard-check" aria-hidden="true"></i></div>
    <div class="stat-pill__body">
      <div class="stat-pill__val"><?= number_format($totalPab) ?></div>
      <div class="stat-pill__lbl">Via PAB</div>
    </div>
  </div>

  <div class="stat-pill stat-pill--purple">
    <div class="stat-pill__ico"><i class="ti ti-file-text" aria-hidden="true"></i></div>
    <div class="stat-pill__body">
      <div class="stat-pill__val"><?= number_format($totalManual) ?></div>
      <div class="stat-pill__lbl">Input Manual</div>
    </div>
  </div>

</div>

<!-- ─────────────────────────────────
     PENDING ACTIVATION BANNER
────────────────────────────────── -->
<?php if (!empty($pending)): ?>
<div class="pending-banner">
  <div class="pending-banner__head">
    <div class="pending-banner__title">
      <i class="ti ti-hourglass-high" aria-hidden="true"></i>
      Menunggu Aktivasi &amp; Generate NIA
    </div>
    <span class="pending-banner__count"><?= count($pending) ?> anggota</span>
  </div>
  <div class="pending-banner__body">
    <?php foreach ($pending as $p): ?>
    <div class="pending-item">
      <div class="pending-item__ava" aria-hidden="true">
        <?= mb_strtoupper(mb_substr($p['nama_lengkap'], 0, 2)) ?>
      </div>
      <div class="pending-item__info">
        <div class="pending-item__name"><?= htmlspecialchars($p['nama_lengkap']) ?></div>
        <div class="pending-item__meta">
          <?php if (!empty($p['kelas'])): ?>
            <span><i class="ti ti-school" aria-hidden="true"></i> <?= htmlspecialchars($p['kelas']) ?></span>
          <?php endif; ?>
          <?php if (!empty($p['no_hp'])): ?>
            <span><i class="ti ti-phone" aria-hidden="true"></i> <?= htmlspecialchars($p['no_hp']) ?></span>
          <?php endif; ?>
          <?php if (!empty($p['created_at'])): ?>
            <span><i class="ti ti-calendar" aria-hidden="true"></i> Daftar: <?= htmlspecialchars($p['created_at']) ?></span>
          <?php endif; ?>
        </div>
      </div>
      <form method="POST" action="<?= BASE_URL ?>/admin/anggota/<?= (int)$p['id'] ?>/activate">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
        <button type="submit" class="btn-activate">
          <i class="ti ti-check" aria-hidden="true"></i>
          Aktifkan &amp; NIA
        </button>
      </form>
    </div>
    <?php endforeach; ?>
  </div>
</div>
<?php endif; ?>

<!-- ─────────────────────────────────
     FILTER BAR
────────────────────────────────── -->
<div class="sec-label">
  <span class="sec-label__text">Daftar Anggota Aktif</span>
  <span class="sec-label__line"></span>
</div>

<form method="GET" class="filter-bar" id="filter-form">
  <!-- Search -->
  <div class="fi">
    <span class="fi__icon"><i class="ti ti-search" aria-hidden="true"></i></span>
    <input type="text" name="search"
           value="<?= htmlspecialchars($filter['search'] ?? '') ?>"
           placeholder="Cari nama, NIA, No HP…"
           autocomplete="off">
  </div>

  <!-- Kelas -->
  <div class="fi fi--select">
    <span class="fi__icon"><i class="ti ti-school" aria-hidden="true"></i></span>
    <select name="kelas">
      <option value="">Semua Kelas</option>
      <?php foreach ($kelasList as $k): ?>
        <option value="<?= htmlspecialchars($k['kelas']) ?>"
                <?= ($filter['kelas'] ?? '') === $k['kelas'] ? 'selected' : '' ?>>
          <?= htmlspecialchars($k['kelas']) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <!-- Sumber -->
  <div class="fi fi--select">
    <span class="fi__icon"><i class="ti ti-tag" aria-hidden="true"></i></span>
    <select name="sumber">
      <option value="">Semua Sumber</option>
      <option value="pab"    <?= ($filter['sumber'] ?? '') === 'pab'    ? 'selected' : '' ?>>PAB</option>
      <option value="manual" <?= ($filter['sumber'] ?? '') === 'manual' ? 'selected' : '' ?>>Manual</option>
    </select>
  </div>

  <!-- Jabatan -->
  <div class="fi fi--select">
    <span class="fi__icon"><i class="ti ti-id-badge-2" aria-hidden="true"></i></span>
    <select name="jabatan">
      <option value="">Semua Jabatan</option>
      <?php foreach (UserModel::JABATAN_LIST as $jKey => $jLabel): ?>
        <option value="<?= htmlspecialchars($jKey) ?>"
                <?= ($filter['jabatan'] ?? '') === $jKey ? 'selected' : '' ?>>
          <?= htmlspecialchars($jLabel) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <button type="submit" class="filter-btn">
    <i class="ti ti-filter" aria-hidden="true"></i>
    Filter
  </button>

  <?php if (!empty($filter['search']) || !empty($filter['kelas']) || !empty($filter['sumber']) || !empty($filter['jabatan'])): ?>
    <a href="<?= BASE_URL ?>/admin/anggota" class="filter-reset">✕ Reset</a>
  <?php endif; ?>
</form>

<!-- ─────────────────────────────────
     TABLE PANEL
────────────────────────────────── -->
<div class="tpanel">
  <div class="tpanel__head">
    <span class="tpanel__title">Tabel Anggota</span>
    <span class="tpanel__meta">
      Total <strong><?= number_format(count($list)) ?></strong> anggota ditampilkan
    </span>
  </div>

  <div style="overflow-x:auto;">
    <table class="mtbl">
      <thead>
        <tr>
          <th style="width:120px;">NIA</th>
          <th>Nama Lengkap</th>
          <th style="width:100px;">No HP</th>
          <th style="width:90px;">Sumber</th>
          <th style="width:170px;">Jabatan</th>
          <th style="width:80px;">Status</th>
          <th style="width:50px;">Foto</th>
          <th style="width:160px;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($list)): ?>
        <tr>
          <td colspan="8">
            <div class="tbl-empty">
              <i class="ti ti-users-group tbl-empty__ico" aria-hidden="true"></i>
              <div class="tbl-empty__title">Tidak ada anggota ditemukan</div>
              <div class="tbl-empty__sub">Coba ubah filter atau tambah anggota baru.</div>
            </div>
          </td>
        </tr>
        <?php else: ?>
        <?php foreach ($list as $m): ?>
        <tr>
          <!-- NIA -->
          <td>
            <?php if (!empty($m['nia'])): ?>
              <span class="cell-nia"><?= htmlspecialchars($m['nia']) ?></span>
            <?php else: ?>
              <span class="cell-empty-nia">—</span>
            <?php endif; ?>
          </td>

          <!-- Nama + Kelas inline -->
          <td>
            <div class="cell-name-wrap">
              <span class="cell-name"><?= htmlspecialchars($m['nama_lengkap']) ?></span>
              <span class="cell-kelas-inline"><?= htmlspecialchars($m['kelas'] ?? '—') ?></span>
            </div>
          </td>

          <!-- No HP -->
          <td><span class="cell-mono"><?= htmlspecialchars($m['no_hp'] ?? '—') ?></span></td>

          <!-- Sumber -->
          <td>
            <?php if (($m['sumber'] ?? '') === 'pab'): ?>
              <span class="src-chip src-chip--pab">PAB</span>
            <?php else: ?>
              <span class="src-chip src-chip--manual">Manual</span>
            <?php endif; ?>
          </td>

          <!-- Jabatan -->
          <td>
            <?php $jKeyRow = $m['jabatan'] ?? 'anggota'; ?>
            <span class="jbt-chip <?= $jKeyRow !== 'anggota' ? 'jbt-chip--pengurus' : '' ?>">
              <?= htmlspecialchars(UserModel::jabatanLabel($jKeyRow)) ?>
            </span>
          </td>

          <!-- Status -->
          <td>
            <?php
              $sMap = [
                'aktif'     => ['chip--aktif',  'Aktif'],
                'pending'   => ['chip--pending','Pending'],
                'non-aktif' => ['chip--non',    'Non-Aktif'],
                'tolak'     => ['chip--tolak',  'Tolak'],
              ];
              [$sc, $sl] = $sMap[$m['status'] ?? ''] ?? ['chip--non', ucfirst($m['status'] ?? '?')];
            ?>
            <span class="status-chip <?= $sc ?>">
              <span class="status-chip__dot" aria-hidden="true"></span>
              <?= $sl ?>
            </span>
          </td>

          <!-- Foto -->
          <td>
            <div class="ava">
              <?php if (!empty($m['foto'])): ?>
                <img src="<?= UPLOAD_URL . '/' . htmlspecialchars($m['foto']) ?>" alt="Foto <?= htmlspecialchars($m['nama_lengkap']) ?>">
              <?php else: ?>
                <?= mb_strtoupper(mb_substr($m['nama_lengkap'], 0, 2)) ?>
              <?php endif; ?>
            </div>
          </td>

          <!-- Aksi -->
          <td>
            <div class="act-group">

              <!-- Edit -->
              <a href="<?= BASE_URL ?>/admin/anggota/<?= (int)$m['id'] ?>/edit" class="act-btn">
                <i class="ti ti-edit" aria-hidden="true"></i>
                Edit
              </a>

              <!-- Reset Password -->
              <button type="button" class="act-btn act-btn--reset"
                      data-reset-id="<?= (int)$m['id'] ?>"
                      data-reset-name="<?= htmlspecialchars($m['nama_lengkap'], ENT_QUOTES) ?>"
                      title="Reset Password">
                <i class="ti ti-key" aria-hidden="true"></i>
              </button>

              <!-- Nonaktifkan -->
              <button type="button" class="act-btn act-btn--danger"
                      data-confirm-id="<?= (int)$m['id'] ?>"
                      data-confirm-name="<?= htmlspecialchars($m['nama_lengkap'], ENT_QUOTES) ?>"
                      title="Nonaktifkan">
                <i class="ti ti-user-off" aria-hidden="true"></i>
              </button>

            </div>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <!-- Pagination -->
  <?php if (!empty($pagination) && $pagination['total_pages'] > 1): ?>
  <?php
    $pagiFilterQuery = http_build_query(array_filter([
      'search'  => $filter['search']  ?? '',
      'kelas'   => $filter['kelas']   ?? '',
      'sumber'  => $filter['sumber']  ?? '',
      'jabatan' => $filter['jabatan'] ?? '',
    ]));
  ?>
  <div class="pagination">
    <span class="pagi-info">
      Halaman <strong><?= $pagination['current_page'] ?></strong>
      dari <strong><?= $pagination['total_pages'] ?></strong>
      &nbsp;·&nbsp; <?= number_format($pagination['total_rows']) ?> total baris
    </span>
    <div class="pagi-pages">
      <!-- Prev -->
      <?php $hasPrev = $pagination['current_page'] > 1; ?>
      <a href="<?= $hasPrev ? BASE_URL . '/admin/anggota?page=' . ($pagination['current_page'] - 1) . '&' . $pagiFilterQuery : '#' ?>"
         class="pagi-btn <?= !$hasPrev ? 'pagi-btn--disabled' : '' ?>">
        <i class="ti ti-chevron-left" aria-hidden="true"></i>
      </a>

      <?php for ($pg = 1; $pg <= $pagination['total_pages']; $pg++): ?>
        <?php if ($pg === 1 || $pg === $pagination['total_pages'] || abs($pg - $pagination['current_page']) <= 1): ?>
          <a href="<?= BASE_URL ?>/admin/anggota?page=<?= $pg ?>&<?= $pagiFilterQuery ?>"
             class="pagi-btn <?= $pg === $pagination['current_page'] ? 'pagi-btn--active' : '' ?>">
            <?= $pg ?>
          </a>
        <?php elseif (abs($pg - $pagination['current_page']) === 2): ?>
          <span class="pagi-btn" style="pointer-events:none;opacity:.35;">…</span>
        <?php endif; ?>
      <?php endfor; ?>

      <!-- Next -->
      <?php $hasNext = $pagination['current_page'] < $pagination['total_pages']; ?>
      <a href="<?= $hasNext ? BASE_URL . '/admin/anggota?page=' . ($pagination['current_page'] + 1) . '&' . $pagiFilterQuery : '#' ?>"
         class="pagi-btn <?= !$hasNext ? 'pagi-btn--disabled' : '' ?>">
        <i class="ti ti-chevron-right" aria-hidden="true"></i>
      </a>
    </div>
  </div>
  <?php endif; ?>

</div><!-- /.tpanel -->

<!-- ─────────────────────────────────
     DIALOG: Nonaktifkan
────────────────────────────────── -->
<div class="confirm-overlay" id="confirm-overlay" role="dialog" aria-modal="true" aria-labelledby="confirm-title">
  <div class="confirm-box">
    <div class="confirm-box__ico">
      <i class="ti ti-alert-triangle" aria-hidden="true"></i>
    </div>
    <div class="confirm-box__title" id="confirm-title">Nonaktifkan Anggota?</div>
    <div class="confirm-box__sub">
      Anggota <strong id="confirm-name-display">—</strong> akan dinonaktifkan.
      Aksi ini dapat dikembalikan melalui panel data.
    </div>
    <div class="confirm-box__acts">
      <button type="button" class="btn-sec" id="confirm-cancel">Batal</button>
      <form method="POST" id="confirm-form">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
        <button type="submit" class="btn-pri" style="background:var(--red);box-shadow:0 6px 16px rgba(185,28,28,.22);">
          Ya, Nonaktifkan
        </button>
      </form>
    </div>
  </div>
</div>

<!-- ─────────────────────────────────
     DIALOG: Reset Password
────────────────────────────────── -->
<div class="confirm-overlay" id="reset-overlay" role="dialog" aria-modal="true" aria-labelledby="reset-title">
  <div class="confirm-box">
    <div class="confirm-box__ico" style="background:var(--ac-dim);color:var(--ac);">
      <i class="ti ti-key" aria-hidden="true"></i>
    </div>
    <div class="confirm-box__title" id="reset-title">Reset Password?</div>
    <div class="confirm-box__sub">
      Password <strong id="reset-name-display">—</strong> akan direset ke
      <span class="pw-badge">comsmakda</span>.
      Anggota wajib mengganti password setelah login kembali.
    </div>
    <div class="confirm-box__acts">
      <button type="button" class="btn-sec" id="reset-cancel">Batal</button>
      <form method="POST" id="reset-form">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
        <button type="submit" class="btn-pri">
          Ya, Reset Password
        </button>
      </form>
    </div>
  </div>
</div>

</div><!-- /.ang-root -->

<script>
(function () {
  'use strict';

  /* ════════════════════════════════════
     DIALOG: Nonaktifkan
  ════════════════════════════════════ */
  var overlay   = document.getElementById('confirm-overlay');
  var nameEl    = document.getElementById('confirm-name-display');
  var formEl    = document.getElementById('confirm-form');
  var cancelBtn = document.getElementById('confirm-cancel');

  document.querySelectorAll('[data-confirm-id]').forEach(function (btn) {
    btn.addEventListener('click', function () {
      nameEl.textContent = btn.dataset.confirmName;
      formEl.action      = '<?= BASE_URL ?>/admin/anggota/' + btn.dataset.confirmId + '/delete';
      overlay.classList.add('is-open');
      document.body.style.overflow = 'hidden';
    });
  });

  function closeConfirm() {
    overlay.classList.remove('is-open');
    document.body.style.overflow = '';
  }

  cancelBtn.addEventListener('click', closeConfirm);
  overlay.addEventListener('click', function (e) { if (e.target === overlay) closeConfirm(); });

  /* ════════════════════════════════════
     DIALOG: Reset Password
  ════════════════════════════════════ */
  var resetOverlay = document.getElementById('reset-overlay');
  var resetNameEl  = document.getElementById('reset-name-display');
  var resetFormEl  = document.getElementById('reset-form');
  var resetCancel  = document.getElementById('reset-cancel');

  document.querySelectorAll('[data-reset-id]').forEach(function (btn) {
    btn.addEventListener('click', function () {
      resetNameEl.textContent = btn.dataset.resetName;
      resetFormEl.action      = '<?= BASE_URL ?>/admin/anggota/' + btn.dataset.resetId + '/reset-password';
      resetOverlay.classList.add('is-open');
      document.body.style.overflow = 'hidden';
    });
  });

  function closeReset() {
    resetOverlay.classList.remove('is-open');
    document.body.style.overflow = '';
  }

  resetCancel.addEventListener('click', closeReset);
  resetOverlay.addEventListener('click', function (e) { if (e.target === resetOverlay) closeReset(); });

  /* ── Escape menutup dialog mana pun yang terbuka ── */
  document.addEventListener('keydown', function (e) {
    if (e.key !== 'Escape') return;
    if (overlay.classList.contains('is-open'))      closeConfirm();
    if (resetOverlay.classList.contains('is-open')) closeReset();
  });

  /* ════════════════════════════════════
     EXPORT DROPDOWN
  ════════════════════════════════════ */
  var exportToggle = document.getElementById('export-toggle');
  var exportMenu   = document.getElementById('export-menu');
  var exportWrap   = document.getElementById('export-dropdown');

  if (exportToggle) {
    exportToggle.addEventListener('click', function (e) {
      e.stopPropagation();
      exportMenu.classList.toggle('is-open');
    });
    document.addEventListener('click', function (e) {
      if (!exportWrap.contains(e.target)) exportMenu.classList.remove('is-open');
    });
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') exportMenu.classList.remove('is-open');
    });
  }

  /* ════════════════════════════════════
     AUTO-SUBMIT FILTER
  ════════════════════════════════════ */
  var form = document.getElementById('filter-form');
  form.querySelectorAll('select').forEach(function (sel) {
    sel.addEventListener('change', function () { form.submit(); });
  });

}());
</script>