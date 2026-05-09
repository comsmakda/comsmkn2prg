<?php // app/views/admin/anggota.php ?>

<style>
@import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;500;600&family=Sora:wght@300;400;500;600;700;800&display=swap');

/* ═══════════════════════════════════════
   INHERIT DESIGN SYSTEM (same as dashboard)
═══════════════════════════════════════ */
:root {
  --font-ui:   'Sora', sans-serif;
  --font-mono: 'IBM Plex Mono', monospace;
  --bg-base:     #0a0c10;
  --bg-surface:  #0f1117;
  --bg-elevated: #141820;
  --bg-overlay:  #1a1f2e;
  --bg-active:   #1e2436;
  --bd-subtle:   rgba(255,255,255,0.055);
  --bd-default:  rgba(255,255,255,0.10);
  --bd-accent:   rgba(99,179,237,0.35);
  --tx-primary:  #e8ecf4;
  --tx-secondary:#9aa3b8;
  --tx-muted:    #4f5773;
  --ac:          #63b3ed;
  --ac-dim:      rgba(99,179,237,0.10);
  --ac-glow:     rgba(99,179,237,0.15);
  --blue:        #4f9eff;
  --blue-d:      rgba(79,158,255,0.12);
  --amber:       #f6c244;
  --amber-d:     rgba(246,194,68,0.12);
  --purple:      #b794f4;
  --purple-d:    rgba(183,148,244,0.12);
  --green:       #48bb78;
  --green-d:     rgba(72,187,120,0.12);
  --red:         #fc8181;
  --red-d:       rgba(252,129,129,0.12);
  --r-xs: 4px; --r-sm: 6px; --r-md: 10px; --r-lg: 14px; --r-xl: 20px;
  --ease: cubic-bezier(0.16,1,0.3,1);
  --t-fast: 120ms; --t-base: 200ms; --t-slow: 350ms;
}

.ang-root * { box-sizing: border-box; margin: 0; padding: 0; }
.ang-root a { text-decoration: none; color: inherit; }
.ang-root {
  font-family: var(--font-ui);
  color: var(--tx-primary);
  font-size: 13px;
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
  margin-bottom: 28px;
  flex-wrap: wrap;
}
.ph__left {}
.ph__eyebrow {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  font-family: var(--font-mono);
  font-size: 10px;
  font-weight: 500;
  letter-spacing: 0.14em;
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
  letter-spacing: -0.04em;
  color: var(--tx-primary);
  line-height: 1.1;
}
.ph__sub {
  font-size: 12.5px;
  color: var(--tx-muted);
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
  padding: 9px 16px;
  background: var(--ac);
  color: #0a0c10;
  font-family: var(--font-ui);
  font-size: 12px;
  font-weight: 700;
  letter-spacing: -0.01em;
  border-radius: var(--r-md);
  border: none;
  cursor: pointer;
  transition:
    background var(--t-fast) var(--ease),
    box-shadow var(--t-base) var(--ease),
    transform  var(--t-fast) var(--ease);
}
.btn-pri:hover {
  background: #7ec8f5;
  box-shadow: 0 4px 20px rgba(99,179,237,0.30);
  transform: translateY(-1px);
}
.btn-pri svg { width: 14px; height: 14px; }

/* Secondary/ghost button */
.btn-sec {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 8px 14px;
  background: var(--bg-elevated);
  color: var(--tx-secondary);
  font-family: var(--font-ui);
  font-size: 12px;
  font-weight: 600;
  border: 1px solid var(--bd-subtle);
  border-radius: var(--r-md);
  cursor: pointer;
  transition:
    border-color var(--t-fast) var(--ease),
    background   var(--t-fast) var(--ease),
    color        var(--t-fast) var(--ease);
}
.btn-sec:hover {
  border-color: var(--bd-default);
  background: var(--bg-overlay);
  color: var(--tx-primary);
}
.btn-sec svg { width: 13px; height: 13px; }

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
  font-family: var(--font-mono);
  font-size: 9.5px;
  font-weight: 600;
  letter-spacing: 0.18em;
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
  gap: 10px;
  margin-bottom: 24px;
  flex-wrap: wrap;
}
.stat-pill {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 10px 14px;
  background: var(--bg-surface);
  border: 1px solid var(--bd-subtle);
  border-radius: var(--r-md);
  flex: 1;
  min-width: 120px;
}
.stat-pill__ico {
  width: 28px; height: 28px;
  border-radius: var(--r-sm);
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}
.stat-pill__ico svg { width: 13px; height: 13px; }
.stat-pill--blue   .stat-pill__ico { background: var(--blue-d);   color: var(--blue); }
.stat-pill--green  .stat-pill__ico { background: var(--green-d);  color: var(--green); }
.stat-pill--amber  .stat-pill__ico { background: var(--amber-d);  color: var(--amber); }
.stat-pill--purple .stat-pill__ico { background: var(--purple-d); color: var(--purple); }

.stat-pill__body {}
.stat-pill__val {
  font-size: 18px;
  font-weight: 800;
  letter-spacing: -0.04em;
  color: var(--tx-primary);
  line-height: 1;
  font-variant-numeric: tabular-nums;
}
.stat-pill__lbl {
  font-size: 10.5px;
  color: var(--tx-muted);
  margin-top: 2px;
}

/* ═══════════════════════════════════════
   FILTER BAR
═══════════════════════════════════════ */
.filter-bar {
  display: flex;
  align-items: center;
  gap: 8px;
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
  left: 10px;
  color: var(--tx-muted);
  pointer-events: none;
  display: flex;
}
.fi__icon svg { width: 13px; height: 13px; }

.fi input,
.fi select {
  font-family: var(--font-ui);
  font-size: 12px;
  color: var(--tx-primary);
  background: var(--bg-elevated);
  border: 1px solid var(--bd-subtle);
  border-radius: var(--r-md);
  padding: 8px 12px 8px 30px;
  outline: none;
  transition: border-color var(--t-fast) var(--ease), background var(--t-fast) var(--ease);
  -webkit-appearance: none;
}
.fi input { width: 220px; }
.fi select { width: 160px; }
.fi input:focus,
.fi select:focus {
  border-color: var(--bd-accent);
  background: var(--bg-overlay);
}
.fi input::placeholder { color: var(--tx-muted); }

/* custom select arrow */
.fi--select::after {
  content: '';
  position: absolute;
  right: 10px;
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
  padding: 8px 14px;
  background: var(--bg-elevated);
  color: var(--tx-secondary);
  font-family: var(--font-ui);
  font-size: 12px;
  font-weight: 600;
  border: 1px solid var(--bd-subtle);
  border-radius: var(--r-md);
  cursor: pointer;
  transition: all var(--t-fast) var(--ease);
}
.filter-btn:hover {
  border-color: var(--bd-accent);
  background: var(--ac-dim);
  color: var(--ac);
}
.filter-btn svg { width: 13px; height: 13px; }

.filter-reset {
  font-family: var(--font-mono);
  font-size: 10.5px;
  color: var(--tx-muted);
  padding: 4px 8px;
  border-radius: var(--r-xs);
  transition: color var(--t-fast) var(--ease);
}
.filter-reset:hover { color: var(--red); }

/* ═══════════════════════════════════════
   PENDING ACTIVATION BANNER
═══════════════════════════════════════ */
.pending-banner {
  margin-bottom: 20px;
  background: linear-gradient(135deg, rgba(246,194,68,0.06), rgba(246,194,68,0.02));
  border: 1px solid rgba(246,194,68,0.22);
  border-radius: var(--r-lg);
  overflow: hidden;
}
.pending-banner__head {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 12px 16px;
  border-bottom: 1px solid rgba(246,194,68,0.14);
  gap: 8px;
}
.pending-banner__title {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 12.5px;
  font-weight: 700;
  color: var(--amber);
}
.pending-banner__title svg { width: 14px; height: 14px; }
.pending-banner__count {
  font-family: var(--font-mono);
  font-size: 10px;
  font-weight: 700;
  background: var(--amber-d);
  color: var(--amber);
  padding: 2px 8px;
  border-radius: var(--r-xs);
}
.pending-banner__body {
  padding: 12px 16px;
  display: flex;
  flex-direction: column;
  gap: 6px;
}

.pending-item {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 10px 12px;
  background: var(--bg-surface);
  border: 1px solid var(--bd-subtle);
  border-radius: var(--r-md);
  transition: border-color var(--t-fast) var(--ease);
}
.pending-item:hover { border-color: rgba(246,194,68,0.28); }

.pending-item__ava {
  width: 32px; height: 32px;
  border-radius: var(--r-sm);
  background: var(--amber-d);
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: var(--font-mono);
  font-size: 11px;
  font-weight: 700;
  color: var(--amber);
  flex-shrink: 0;
  text-transform: uppercase;
}
.pending-item__info { flex: 1; min-width: 0; }
.pending-item__name {
  font-size: 12.5px;
  font-weight: 600;
  color: var(--tx-primary);
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.pending-item__meta {
  font-family: var(--font-mono);
  font-size: 10px;
  color: var(--tx-muted);
  margin-top: 1px;
  display: flex;
  gap: 8px;
  flex-wrap: wrap;
}
.pending-item__meta span { display: inline-flex; align-items: center; gap: 3px; }

.btn-activate {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 6px 12px;
  background: var(--amber-d);
  color: var(--amber);
  font-family: var(--font-ui);
  font-size: 11px;
  font-weight: 700;
  border: 1px solid rgba(246,194,68,0.25);
  border-radius: var(--r-sm);
  cursor: pointer;
  transition: all var(--t-fast) var(--ease);
  white-space: nowrap;
  flex-shrink: 0;
}
.btn-activate:hover {
  background: rgba(246,194,68,0.22);
  border-color: var(--amber);
  box-shadow: 0 0 12px rgba(246,194,68,0.15);
}
.btn-activate svg { width: 11px; height: 11px; }

/* ═══════════════════════════════════════
   MAIN TABLE PANEL
═══════════════════════════════════════ */
.tpanel {
  background: var(--bg-surface);
  border: 1px solid var(--bd-subtle);
  border-radius: var(--r-lg);
  overflow: hidden;
}
.tpanel__head {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 14px 18px;
  border-bottom: 1px solid var(--bd-subtle);
  gap: 10px;
  flex-wrap: wrap;
}
.tpanel__title {
  font-size: 12.5px;
  font-weight: 700;
  color: var(--tx-primary);
  letter-spacing: -0.01em;
}
.tpanel__meta {
  font-family: var(--font-mono);
  font-size: 10.5px;
  color: var(--tx-muted);
}
.tpanel__meta strong {
  color: var(--tx-secondary);
  font-weight: 600;
}

/* ─── Table ─────────────────────────── */
.mtbl { width: 100%; border-collapse: collapse; }
.mtbl thead tr {
  background: var(--bg-elevated);
}
.mtbl th {
  font-family: var(--font-mono);
  font-size: 9.5px;
  font-weight: 600;
  letter-spacing: 0.12em;
  text-transform: uppercase;
  color: var(--tx-muted);
  text-align: left;
  padding: 10px 14px;
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
.mtbl tbody tr:hover { background: rgba(255,255,255,0.018); }

.mtbl td {
  padding: 11px 14px;
  font-size: 12.5px;
  color: var(--tx-secondary);
  vertical-align: middle;
}

/* ─── Cell types ─────────────────────── */
.cell-nia {
  font-family: var(--font-mono);
  font-size: 11px;
  color: var(--ac);
  letter-spacing: 0.04em;
}
.cell-empty-nia {
  font-family: var(--font-mono);
  font-size: 11px;
  color: var(--tx-muted);
}

.cell-name-wrap {}
.cell-name {
  font-size: 13px;
  font-weight: 600;
  color: var(--tx-primary);
  display: block;
  line-height: 1.3;
}
.cell-kelas-inline {
  font-family: var(--font-mono);
  font-size: 10px;
  color: var(--tx-muted);
}

.cell-mono {
  font-family: var(--font-mono);
  font-size: 11px;
  color: var(--tx-muted);
}

/* Avatar */
.ava-wrap { display: flex; align-items: center; gap: 10px; }
.ava {
  width: 34px; height: 34px;
  border-radius: var(--r-sm);
  flex-shrink: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: var(--font-mono);
  font-size: 11px;
  font-weight: 700;
  text-transform: uppercase;
  background: var(--bg-overlay);
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
  font-family: var(--font-mono);
  font-size: 9.5px;
  font-weight: 700;
  letter-spacing: 0.08em;
  padding: 3px 7px;
  border-radius: var(--r-xs);
  text-transform: uppercase;
}
.src-chip--pab    { background: var(--blue-d);   color: var(--blue);   border: 1px solid rgba(79,158,255,0.20); }
.src-chip--manual { background: var(--purple-d); color: var(--purple); border: 1px solid rgba(183,148,244,0.20); }

/* Status chip */
.status-chip {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  font-size: 10.5px;
  font-weight: 600;
  padding: 3px 8px;
  border-radius: var(--r-xs);
}
.status-chip__dot { width: 5px; height: 5px; border-radius: 50%; background: currentColor; }
.chip--aktif   { background: var(--green-d);  color: var(--green); }
.chip--pending { background: var(--amber-d);  color: var(--amber); }
.chip--non     { background: rgba(255,255,255,.05); color: var(--tx-muted); }
.chip--tolak   { background: var(--red-d);    color: var(--red); }

/* Action buttons */
.act-group { display: flex; align-items: center; gap: 6px; }

.act-btn {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  padding: 5px 10px;
  font-family: var(--font-ui);
  font-size: 11px;
  font-weight: 600;
  border-radius: var(--r-sm);
  border: 1px solid var(--bd-subtle);
  cursor: pointer;
  background: var(--bg-elevated);
  color: var(--tx-secondary);
  transition: all var(--t-fast) var(--ease);
  white-space: nowrap;
}
.act-btn:hover { border-color: var(--bd-default); color: var(--tx-primary); background: var(--bg-overlay); }
.act-btn svg { width: 11px; height: 11px; }

.act-btn--danger {
  background: transparent;
  color: var(--red);
  border-color: var(--red-d);
}
.act-btn--danger:hover {
  background: var(--red-d);
  border-color: rgba(252,129,129,0.30);
}

/* ── TAMBAHAN: Reset password button ── */
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
  width: 40px; height: 40px;
  opacity: .25;
  margin: 0 auto 12px;
}
.tbl-empty__title {
  font-size: 14px;
  font-weight: 600;
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
  padding: 12px 18px;
  border-top: 1px solid var(--bd-subtle);
  gap: 12px;
  flex-wrap: wrap;
}
.pagi-info {
  font-family: var(--font-mono);
  font-size: 10.5px;
  color: var(--tx-muted);
}
.pagi-info strong { color: var(--tx-secondary); }
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
  font-family: var(--font-mono);
  font-size: 11px;
  font-weight: 600;
  border-radius: var(--r-sm);
  border: 1px solid var(--bd-subtle);
  background: var(--bg-elevated);
  color: var(--tx-muted);
  cursor: pointer;
  transition: all var(--t-fast) var(--ease);
}
.pagi-btn:hover { border-color: var(--bd-default); color: var(--tx-primary); }
.pagi-btn--active {
  background: var(--ac-dim);
  border-color: var(--bd-accent);
  color: var(--ac);
}
.pagi-btn--disabled { opacity: .35; cursor: not-allowed; pointer-events: none; }
.pagi-btn svg { width: 11px; height: 11px; }

/* ═══════════════════════════════════════
   CONFIRM DIALOG OVERLAY
═══════════════════════════════════════ */
.confirm-overlay {
  display: none;
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,.65);
  backdrop-filter: blur(4px);
  z-index: 9999;
  align-items: center;
  justify-content: center;
}
.confirm-overlay.is-open { display: flex; }
.confirm-box {
  background: var(--bg-elevated);
  border: 1px solid var(--bd-default);
  border-radius: var(--r-xl);
  padding: 28px;
  max-width: 380px;
  width: 90%;
  box-shadow: 0 24px 60px rgba(0,0,0,.5);
  animation: pop-in var(--t-slow) var(--ease) both;
}
@keyframes pop-in {
  from { transform: scale(.94) translateY(10px); opacity: 0; }
  to   { transform: scale(1)   translateY(0);    opacity: 1; }
}
.confirm-box__ico {
  width: 42px; height: 42px;
  border-radius: var(--r-md);
  background: var(--red-d);
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--red);
  margin-bottom: 16px;
}
.confirm-box__ico svg { width: 20px; height: 20px; }
.confirm-box__title {
  font-size: 15px;
  font-weight: 700;
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
  font-family: var(--font-mono);
  font-size: 11.5px;
  font-weight: 600;
  color: var(--ac);
  background: var(--ac-dim);
  border: 1px solid var(--bd-accent);
  border-radius: var(--r-xs);
  padding: 2px 8px;
  letter-spacing: 0.05em;
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
  .mtbl th:nth-child(6),
  .mtbl td:nth-child(6) { display: none; }
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
    <a href="<?= BASE_URL ?>/admin/laporan/anggota" class="btn-sec">
      <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <path d="M7 1v8M4 6l3 3 3-3M2 11h10"/>
      </svg>
      Ekspor
    </a>
    <a href="<?= BASE_URL ?>/admin/anggota/tambah" class="btn-pri">
      <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <path d="M7 2v10M2 7h10"/>
      </svg>
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
    <div class="stat-pill__ico">
      <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <circle cx="5" cy="4" r="2.5"/>
        <path d="M1 12c0-2.2 1.8-4 4-4s4 1.8 4 4"/>
        <circle cx="11" cy="4.5" r="1.8"/>
        <path d="M13 11c0-1.5-1-2.7-2.2-2.7"/>
      </svg>
    </div>
    <div class="stat-pill__body">
      <div class="stat-pill__val"><?= number_format($totalAktif) ?></div>
      <div class="stat-pill__lbl">Anggota Aktif</div>
    </div>
  </div>

  <div class="stat-pill stat-pill--amber">
    <div class="stat-pill__ico">
      <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <circle cx="7" cy="7" r="5.5"/><path d="M7 4.5v3l1.5 1.5"/>
      </svg>
    </div>
    <div class="stat-pill__body">
      <div class="stat-pill__val"><?= number_format($totalPending) ?></div>
      <div class="stat-pill__lbl">Pending Aktivasi</div>
    </div>
  </div>

  <div class="stat-pill stat-pill--green">
    <div class="stat-pill__ico">
      <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <rect x="1.5" y="1.5" width="11" height="11" rx="1.5"/>
        <path d="M4 7l2 2 4-4"/>
      </svg>
    </div>
    <div class="stat-pill__body">
      <div class="stat-pill__val"><?= number_format($totalPab) ?></div>
      <div class="stat-pill__lbl">Via PAB</div>
    </div>
  </div>

  <div class="stat-pill stat-pill--purple">
    <div class="stat-pill__ico">
      <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <path d="M2 2h10a1 1 0 011 1v9a1 1 0 01-1 1H2a1 1 0 01-1-1V3a1 1 0 011-1z"/>
        <path d="M4 5h6M4 7.5h4M4 10h3"/>
      </svg>
    </div>
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
      <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <circle cx="7" cy="7" r="5.5"/><path d="M7 4.5v3"/><circle cx="7" cy="9.5" r=".5" fill="currentColor"/>
      </svg>
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
            <span>
              <svg width="10" height="10" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" aria-hidden="true"><rect x="1.5" y="1.5" width="11" height="11" rx="1.5"/></svg>
              <?= htmlspecialchars($p['kelas']) ?>
            </span>
          <?php endif; ?>
          <?php if (!empty($p['no_hp'])): ?>
            <span><?= htmlspecialchars($p['no_hp']) ?></span>
          <?php endif; ?>
          <?php if (!empty($p['created_at'])): ?>
            <span>Daftar: <?= htmlspecialchars($p['created_at']) ?></span>
          <?php endif; ?>
        </div>
      </div>
      <form method="POST" action="<?= BASE_URL ?>/admin/anggota/<?= (int)$p['id'] ?>/activate">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
        <button type="submit" class="btn-activate">
          <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M2 7l3.5 3.5L12 3"/>
          </svg>
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
    <span class="fi__icon">
      <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" aria-hidden="true">
        <circle cx="6" cy="6" r="4.5"/><path d="M10 10l2.5 2.5"/>
      </svg>
    </span>
    <input type="text" name="search"
           value="<?= htmlspecialchars($filter['search'] ?? '') ?>"
           placeholder="Cari nama, NIA, No HP…"
           autocomplete="off">
  </div>

  <!-- Kelas -->
  <div class="fi fi--select">
    <span class="fi__icon">
      <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" aria-hidden="true">
        <rect x="1.5" y="1.5" width="11" height="11" rx="1.5"/>
      </svg>
    </span>
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
    <span class="fi__icon">
      <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" aria-hidden="true">
        <circle cx="7" cy="7" r="5.5"/><path d="M7 4.5v3l1.5 1.5"/>
      </svg>
    </span>
    <select name="sumber">
      <option value="">Semua Sumber</option>
      <option value="pab"    <?= ($filter['sumber'] ?? '') === 'pab'    ? 'selected' : '' ?>>PAB</option>
      <option value="manual" <?= ($filter['sumber'] ?? '') === 'manual' ? 'selected' : '' ?>>Manual</option>
    </select>
  </div>

  <button type="submit" class="filter-btn">
    <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" aria-hidden="true">
      <path d="M1.5 4h11M3.5 7h7M5.5 10h3"/>
    </svg>
    Filter
  </button>

  <?php if (!empty($filter['search']) || !empty($filter['kelas']) || !empty($filter['sumber'])): ?>
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
          <th style="width:80px;">Status</th>
          <th style="width:50px;">Foto</th>
          <th style="width:160px;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($list)): ?>
        <tr>
          <td colspan="7">
            <div class="tbl-empty">
              <svg class="tbl-empty__ico" viewBox="0 0 40 40" fill="none" stroke="currentColor" stroke-width="1.2" aria-hidden="true">
                <circle cx="18" cy="18" r="13"/>
                <path d="M28 28l8 8M18 12v6M18 21v2" stroke-linecap="round"/>
              </svg>
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
                <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                  <path d="M9.5 2.5l2 2L4 12H2v-2L9.5 2.5z"/>
                </svg>
                Edit
              </a>

              <!-- Reset Password -->
              <button type="button" class="act-btn act-btn--reset"
                      data-reset-id="<?= (int)$m['id'] ?>"
                      data-reset-name="<?= htmlspecialchars($m['nama_lengkap'], ENT_QUOTES) ?>"
                      title="Reset Password">
                <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                  <path d="M2.5 7A4.5 4.5 0 0 1 11 4.5"/>
                  <path d="M11.5 2v3h-3"/>
                  <rect x="3" y="8" width="8" height="5" rx="1"/>
                  <circle cx="7" cy="10.5" r=".8" fill="currentColor" stroke="none"/>
                </svg>
              </button>

              <!-- Nonaktifkan -->
              <button type="button" class="act-btn act-btn--danger"
                      data-confirm-id="<?= (int)$m['id'] ?>"
                      data-confirm-name="<?= htmlspecialchars($m['nama_lengkap'], ENT_QUOTES) ?>"
                      title="Nonaktifkan">
                <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                  <path d="M2 4h10M5 4V2.5h4V4M5.5 7v3M8.5 7v3M3 4l.8 7.5a1 1 0 001 .9h4.4a1 1 0 001-.9L11 4"/>
                </svg>
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
  <div class="pagination">
    <span class="pagi-info">
      Halaman <strong><?= $pagination['current_page'] ?></strong>
      dari <strong><?= $pagination['total_pages'] ?></strong>
      &nbsp;·&nbsp; <?= number_format($pagination['total_rows']) ?> total baris
    </span>
    <div class="pagi-pages">
      <!-- Prev -->
      <?php $hasPrev = $pagination['current_page'] > 1; ?>
      <a href="<?= $hasPrev ? BASE_URL . '/admin/anggota?page=' . ($pagination['current_page'] - 1) . '&' . http_build_query(array_filter(['search'=>$filter['search']??'','kelas'=>$filter['kelas']??'','sumber'=>$filter['sumber']??''])) : '#' ?>"
         class="pagi-btn <?= !$hasPrev ? 'pagi-btn--disabled' : '' ?>">
        <svg viewBox="0 0 11 11" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 2L4 5.5 7 9"/></svg>
      </a>

      <?php for ($pg = 1; $pg <= $pagination['total_pages']; $pg++): ?>
        <?php if ($pg === 1 || $pg === $pagination['total_pages'] || abs($pg - $pagination['current_page']) <= 1): ?>
          <a href="<?= BASE_URL ?>/admin/anggota?page=<?= $pg ?>&<?= http_build_query(array_filter(['search'=>$filter['search']??'','kelas'=>$filter['kelas']??'','sumber'=>$filter['sumber']??''])) ?>"
             class="pagi-btn <?= $pg === $pagination['current_page'] ? 'pagi-btn--active' : '' ?>">
            <?= $pg ?>
          </a>
        <?php elseif (abs($pg - $pagination['current_page']) === 2): ?>
          <span class="pagi-btn" style="pointer-events:none;opacity:.35;">…</span>
        <?php endif; ?>
      <?php endfor; ?>

      <!-- Next -->
      <?php $hasNext = $pagination['current_page'] < $pagination['total_pages']; ?>
      <a href="<?= $hasNext ? BASE_URL . '/admin/anggota?page=' . ($pagination['current_page'] + 1) . '&' . http_build_query(array_filter(['search'=>$filter['search']??'','kelas'=>$filter['kelas']??'','sumber'=>$filter['sumber']??''])) : '#' ?>"
         class="pagi-btn <?= !$hasNext ? 'pagi-btn--disabled' : '' ?>">
        <svg viewBox="0 0 11 11" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 2l3 3.5-3 3.5"/></svg>
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
      <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <path d="M3 6h14M8 6V4.5a1.5 1.5 0 013 0V6M7 9l.5 6M13 9l-.5 6M5 6l.8 10.5A1 1 0 006.8 18h6.4a1 1 0 001-.9L15 6"/>
      </svg>
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
        <button type="submit" class="btn-pri" style="background:var(--red);color:#fff;">
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
      <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <path d="M3.5 10A6.5 6.5 0 0 1 15 5.5"/>
        <path d="M16 2.5v4h-4"/>
        <rect x="4" y="11" width="12" height="7" rx="1.5"/>
        <circle cx="10" cy="14.5" r="1.2" fill="currentColor" stroke="none"/>
      </svg>
    </div>
    <div class="confirm-box__title" id="reset-title">Reset Password?</div>
    <div class="confirm-box__sub">
      Password <strong id="reset-name-display">—</strong> akan direset ke
      <span class="pw-badge">cosmakda</span>.
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
     AUTO-SUBMIT FILTER
  ════════════════════════════════════ */
  var form = document.getElementById('filter-form');
  form.querySelectorAll('select').forEach(function (sel) {
    sel.addEventListener('change', function () { form.submit(); });
  });

}());
</script>