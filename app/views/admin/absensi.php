<?php // app/views/admin/absensi.php ?>

<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap');

/* ═══════════════════════════════════════
   INHERIT DESIGN SYSTEM (selaras dengan dashboard.php)
   Token global (--c-ink, --c-white, --c-primary, dst) didefinisikan
   di layout utama; fallback disertakan bila file ini dirender berdiri sendiri.
═══════════════════════════════════════ */
.abs-root {
  /* Font — satu keluarga font di seluruh sistem */
  --font-ui:   var(--ff, 'Plus Jakarta Sans', sans-serif);
  --font-mono: var(--ff, 'Plus Jakarta Sans', sans-serif);

  /* Surface */
  --bg-base:     var(--c-page,  #eef2f6);
  --bg-surface:  var(--c-white, #ffffff);
  --bg-elevated: #f8fafc;
  --bg-overlay:  #eef2f6;
  --bg-active:   var(--c-primary-08, rgba(14,116,144,.08));

  /* Border */
  --bd-subtle:  var(--c-border, #e6ebf1);
  --bd-default: var(--c-border, #e6ebf1);
  --bd-accent:  var(--c-primary-25, rgba(14,116,144,.25));

  /* Text */
  --tx-primary:   var(--c-ink,    #0f172a);
  --tx-secondary: var(--c-muted,  #64748b);
  --tx-muted:     var(--c-muted2, #94a3b8);

  /* Aksen — satu-satunya warna aksen dekoratif */
  --ac:      var(--c-primary,    #0e7490);
  --ac-dim:  var(--c-primary-08, rgba(14,116,144,.08));
  --ac-glow: var(--c-primary-12, rgba(14,116,144,.12));

  /* Kategori (tetap dalam keluarga primary + warna status) */
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
  --cyan:    var(--c-primary-lt, #06b6d4);
  --cyan-d:  var(--c-primary-08, rgba(14,116,144,.08));

  /* Radius — selaras dashboard.php */
  --r-xs: 6px;
  --r-sm: var(--radius-sm, 9px);
  --r-md: var(--radius-sm, 9px);
  --r-lg: var(--radius-md, 13px);
  --r-xl: var(--radius-lg, 22px);

  /* Motion */
  --ease: cubic-bezier(0.22, 1, 0.36, 1);
  --t-fast: 120ms; --t-base: 160ms; --t-slow: 300ms;
}

.abs-root * { box-sizing: border-box; margin: 0; padding: 0; }
.abs-root a { text-decoration: none; color: inherit; }
.abs-root {
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
  margin-bottom: 28px;
  flex-wrap: wrap;
}
.ph__eyebrow {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  font-family: var(--font-mono);
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
  font-size: 26px;
  font-weight: 800;
  letter-spacing: -0.03em;
  color: var(--c-primary-dk, #0b5a70);
  line-height: 1.1;
}
.ph__sub {
  font-size: 13px;
  color: var(--tx-secondary);
  margin-top: 6px;
}
.ph__actions {
  display: flex;
  align-items: center;
  gap: 8px;
  flex-shrink: 0;
  padding-top: 4px;
}

/* ─── Buttons ─────────────────────────── */
.btn-pri {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  padding: 10px 16px;
  background: var(--ac);
  color: #fff;
  font-family: var(--font-ui);
  font-size: 12.5px;
  font-weight: 800;
  letter-spacing: -0.01em;
  border-radius: var(--r-sm);
  border: none;
  cursor: pointer;
  box-shadow: 0 8px 20px rgba(14,116,144,.22);
  transition: background var(--t-fast) var(--ease), box-shadow var(--t-base) var(--ease), transform var(--t-fast) var(--ease);
}
.btn-pri:hover {
  background: var(--cyan);
  transform: translateY(-2px);
  box-shadow: 0 12px 26px rgba(6,182,212,.30);
}
.btn-pri svg { width: 14px; height: 14px; }

.btn-sec {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 9px 14px;
  background: var(--bg-surface);
  color: var(--tx-secondary);
  font-family: var(--font-ui);
  font-size: 12.5px;
  font-weight: 700;
  border: 1.5px solid var(--bd-subtle);
  border-radius: var(--r-sm);
  cursor: pointer;
  transition: border-color var(--t-fast) var(--ease), background var(--t-fast) var(--ease), color var(--t-fast) var(--ease);
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
  margin-bottom: 14px;
}
.sec-label__text {
  font-family: var(--font-mono);
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
   STATS STRIP (selaras gaya KPI di dashboard.php)
═══════════════════════════════════════ */
.stats-strip {
  display: flex;
  gap: 12px;
  margin-bottom: 28px;
  flex-wrap: wrap;
}
.stat-pill {
  position: relative;
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 14px 16px;
  background: var(--bg-surface);
  border: 1px solid var(--bd-subtle);
  border-radius: var(--r-xl);
  flex: 1;
  min-width: 150px;
  overflow: hidden;
  transition: border-color var(--t-base) var(--ease), transform var(--t-fast) var(--ease), box-shadow var(--t-base) var(--ease);
}
.stat-pill::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 3px;
  border-radius: var(--r-xl) var(--r-xl) 0 0;
}
.stat-pill:hover {
  transform: translateY(-2px);
  box-shadow: 0 14px 30px -12px rgba(15,23,42,.16), 0 4px 12px rgba(15,23,42,.05);
}
.stat-pill__ico {
  width: 32px; height: 32px;
  border-radius: var(--r-sm);
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}
.stat-pill__ico svg { width: 14px; height: 14px; }
.stat-pill--blue   .stat-pill__ico { background: var(--blue-d);   color: var(--blue); }
.stat-pill--green  .stat-pill__ico { background: var(--green-d);  color: var(--green); }
.stat-pill--amber  .stat-pill__ico { background: var(--amber-d);  color: var(--amber); }
.stat-pill--cyan   .stat-pill__ico { background: var(--cyan-d);   color: var(--cyan); }
.stat-pill--blue::before   { background: var(--blue); }
.stat-pill--green::before  { background: var(--green); }
.stat-pill--amber::before  { background: var(--amber); }
.stat-pill--cyan::before   { background: var(--cyan); }
.stat-pill__val {
  font-size: 19px;
  font-weight: 800;
  letter-spacing: -0.03em;
  color: var(--tx-primary);
  line-height: 1;
  font-variant-numeric: tabular-nums;
}
.stat-pill__lbl {
  font-size: 11px;
  color: var(--tx-muted);
  margin-top: 3px;
  font-weight: 500;
}

/* ═══════════════════════════════════════
   FLASH ALERT
═══════════════════════════════════════ */
.flash-alert {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 12px 15px;
  border-radius: var(--r-lg);
  font-size: 12.5px;
  font-weight: 600;
  margin-bottom: 18px;
  border: 1px solid transparent;
}
.flash-alert svg { width: 14px; height: 14px; flex-shrink: 0; }
.flash-alert--success { background: var(--green-d); color: var(--green); border-color: rgba(21,128,61,0.22); }
.flash-alert--error   { background: var(--red-d);   color: var(--red);   border-color: rgba(185,28,28,0.22); }
.flash-alert--info    { background: var(--blue-d);  color: var(--blue);  border-color: rgba(14,116,144,0.22); }

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
  left: 11px;
  color: var(--tx-muted);
  pointer-events: none;
  display: flex;
}
.fi__icon svg { width: 13px; height: 13px; }
.fi input,
.fi select {
  font-family: var(--font-ui);
  font-size: 12.5px;
  color: var(--tx-primary);
  background: #fbfcfe;
  border: 1.5px solid var(--bd-subtle);
  border-radius: var(--r-sm);
  padding: 9px 12px 9px 32px;
  outline: none;
  transition: border-color var(--t-fast) var(--ease), background var(--t-fast) var(--ease), box-shadow var(--t-fast) var(--ease);
  -webkit-appearance: none;
}
.fi input { width: 220px; }
.fi select { width: 160px; }
.fi input:focus,
.fi select:focus {
  border-color: var(--cyan);
  background: #fff;
  box-shadow: 0 0 0 3px rgba(6,182,212,.12);
}
.fi input::placeholder { color: var(--tx-muted); }
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
  padding: 9px 14px;
  background: var(--bg-surface);
  color: var(--tx-secondary);
  font-family: var(--font-ui);
  font-size: 12.5px;
  font-weight: 700;
  border: 1.5px solid var(--bd-subtle);
  border-radius: var(--r-sm);
  cursor: pointer;
  transition: all var(--t-fast) var(--ease);
}
.filter-btn:hover { border-color: var(--bd-accent); background: var(--ac-dim); color: var(--ac); }
.filter-btn svg { width: 13px; height: 13px; }
.filter-reset {
  font-family: var(--font-mono);
  font-size: 11px;
  font-weight: 600;
  color: var(--tx-muted);
  padding: 5px 8px;
  border-radius: var(--r-xs);
  cursor: pointer;
  transition: color var(--t-fast) var(--ease);
  text-decoration: none;
}
.filter-reset:hover { color: var(--red); }

/* ═══════════════════════════════════════
   TABLE PANEL
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
  font-family: var(--font-mono);
  font-size: 11px;
  color: var(--tx-muted);
}
.tpanel__meta strong { color: var(--tx-secondary); font-weight: 700; }

.mtbl { width: 100%; border-collapse: collapse; }
.mtbl thead tr { background: var(--bg-elevated); }
.mtbl th {
  font-family: var(--font-mono);
  font-size: 10.5px;
  font-weight: 700;
  letter-spacing: 0.1em;
  text-transform: uppercase;
  color: var(--tx-muted);
  text-align: left;
  padding: 11px 14px;
  border-bottom: 1px solid var(--bd-subtle);
  white-space: nowrap;
}
.mtbl tbody tr {
  border-bottom: 1px solid var(--bd-subtle);
  transition: background var(--t-fast) var(--ease);
}
.mtbl tbody tr:last-child { border-bottom: none; }
.mtbl tbody tr:hover { background: rgba(14,116,144,.035); }
.mtbl td {
  padding: 12px 14px;
  font-size: 12.5px;
  color: var(--tx-secondary);
  vertical-align: middle;
}

/* ─── Cell types ─────────────────────── */
.cell-title {
  font-size: 13px;
  font-weight: 700;
  color: var(--tx-primary);
  display: block;
  line-height: 1.3;
}
.cell-mono {
  font-family: var(--font-mono);
  font-size: 11.5px;
  color: var(--tx-muted);
}
.cell-note {
  font-size: 11.5px;
  color: var(--tx-muted);
  max-width: 200px;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
  display: block;
}

/* Sesi icon badge */
.sesi-ico {
  width: 34px; height: 34px;
  border-radius: var(--r-sm);
  background: var(--ac-dim);
  border: 1px solid var(--bd-accent);
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
  color: var(--ac);
}
.sesi-ico svg { width: 14px; height: 14px; }

.cell-sesi-wrap { display: flex; align-items: center; gap: 10px; }

/* Date chip */
.date-chip {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  font-family: var(--font-mono);
  font-size: 11px;
  font-weight: 700;
  padding: 4px 9px;
  border-radius: var(--r-xs);
  background: var(--bg-overlay);
  color: var(--tx-secondary);
  border: 1px solid var(--bd-subtle);
}
.date-chip svg { width: 10px; height: 10px; }

/* Creator chip */
.creator-chip {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  font-size: 11.5px;
  color: var(--tx-muted);
}
.creator-chip__ava {
  width: 21px; height: 21px;
  border-radius: 5px;
  background: var(--purple-d);
  color: var(--purple);
  font-family: var(--font-mono);
  font-size: 8.5px;
  font-weight: 800;
  display: flex;
  align-items: center;
  justify-content: center;
  text-transform: uppercase;
}

/* Action buttons */
.act-group { display: flex; align-items: center; gap: 6px; }
.act-btn {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  padding: 6px 10px;
  font-family: var(--font-ui);
  font-size: 11.5px;
  font-weight: 700;
  border-radius: var(--r-sm);
  border: 1.5px solid var(--bd-subtle);
  cursor: pointer;
  background: var(--bg-surface);
  color: var(--tx-secondary);
  transition: all var(--t-fast) var(--ease);
  white-space: nowrap;
  text-decoration: none;
}
.act-btn:hover { border-color: var(--bd-default); color: var(--tx-primary); background: var(--bg-overlay); }
.act-btn svg { width: 11px; height: 11px; }
.act-btn--cyan {
  background: var(--cyan-d);
  color: var(--cyan);
  border-color: rgba(6,182,212,0.25);
}
.act-btn--cyan:hover {
  background: rgba(6,182,212,0.16);
  border-color: var(--cyan);
  box-shadow: 0 0 0 3px rgba(6,182,212,.10);
}
.act-btn--danger {
  background: transparent;
  color: var(--red);
  border-color: var(--red-d);
}
.act-btn--danger:hover {
  background: var(--red-d);
  border-color: rgba(185,28,28,0.30);
}

/* Empty state */
.tbl-empty {
  text-align: center;
  padding: 60px 24px;
  color: var(--tx-muted);
}
.tbl-empty__ico { width: 40px; height: 40px; opacity: .3; margin: 0 auto 12px; color: var(--tx-muted); }
.tbl-empty__title { font-size: 14px; font-weight: 700; color: var(--tx-secondary); margin-bottom: 4px; }
.tbl-empty__sub { font-size: 12px; }

/* ═══════════════════════════════════════
   MODAL OVERLAY
═══════════════════════════════════════ */
.modal-overlay {
  display: none;
  position: fixed;
  inset: 0;
  background: rgba(15,23,42,.55);
  backdrop-filter: blur(4px);
  z-index: 9999;
  align-items: center;
  justify-content: center;
  padding: 16px;
}
.modal-overlay.is-open { display: flex; }
.modal-box {
  background: var(--bg-surface);
  border: 1px solid var(--bd-subtle);
  border-radius: var(--r-xl);
  padding: 28px;
  max-width: 440px;
  width: 100%;
  box-shadow: 0 30px 70px -20px rgba(15,23,42,.30), 0 4px 18px rgba(15,23,42,.08);
  animation: pop-in var(--t-slow) var(--ease) both;
}
@keyframes pop-in {
  from { transform: scale(.94) translateY(10px); opacity: 0; }
  to   { transform: scale(1)   translateY(0);    opacity: 1; }
}
.modal-box__header {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  margin-bottom: 20px;
  gap: 12px;
}
.modal-box__title-wrap {}
.modal-box__eyebrow {
  font-family: var(--font-mono);
  font-size: 10.5px;
  font-weight: 700;
  letter-spacing: 0.1em;
  text-transform: uppercase;
  color: var(--ac);
  margin-bottom: 4px;
}
.modal-box__title {
  font-size: 17px;
  font-weight: 800;
  letter-spacing: -0.03em;
  color: var(--c-primary-dk, #0b5a70);
}
.modal-close {
  width: 28px; height: 28px;
  border-radius: var(--r-sm);
  border: 1px solid var(--bd-subtle);
  background: var(--bg-overlay);
  color: var(--tx-muted);
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  flex-shrink: 0;
  transition: all var(--t-fast) var(--ease);
}
.modal-close:hover { border-color: var(--bd-default); color: var(--tx-primary); background: #fff; }
.modal-close svg { width: 12px; height: 12px; }

/* Form elements */
.form-group { margin-bottom: 14px; }
.form-label {
  display: block;
  font-size: 11.5px;
  font-weight: 700;
  color: var(--tx-secondary);
  margin-bottom: 6px;
  letter-spacing: 0.01em;
}
.form-label span { color: var(--red); margin-left: 2px; }
.form-input {
  width: 100%;
  font-family: var(--font-ui);
  font-size: 13px;
  color: var(--tx-primary);
  background: #fbfcfe;
  border: 1.5px solid var(--bd-subtle);
  border-radius: var(--r-sm);
  padding: 10px 13px;
  outline: none;
  transition: border-color var(--t-fast) var(--ease), background var(--t-fast) var(--ease), box-shadow var(--t-fast) var(--ease);
  display: block;
}
.form-input:focus {
  border-color: var(--cyan);
  background: #fff;
  box-shadow: 0 0 0 3px rgba(6,182,212,.12);
}
.form-input::placeholder { color: var(--tx-muted); }
textarea.form-input { resize: vertical; min-height: 72px; }

.modal-acts {
  display: flex;
  gap: 8px;
  margin-top: 20px;
}
.modal-acts .btn-pri { flex: 1; justify-content: center; }
.modal-acts .btn-cancel {
  flex: 1;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  padding: 10px 16px;
  background: var(--bg-overlay);
  color: var(--tx-secondary);
  font-family: var(--font-ui);
  font-size: 12.5px;
  font-weight: 700;
  border: 1.5px solid var(--bd-subtle);
  border-radius: var(--r-sm);
  cursor: pointer;
  transition: all var(--t-fast) var(--ease);
}
.modal-acts .btn-cancel:hover { background: #eef2f6; color: var(--tx-primary); border-color: var(--bd-default); }

/* ═══════════════════════════════════════
   CONFIRM DIALOG
═══════════════════════════════════════ */
.confirm-overlay {
  display: none;
  position: fixed;
  inset: 0;
  background: rgba(15,23,42,.55);
  backdrop-filter: blur(4px);
  z-index: 10000;
  align-items: center;
  justify-content: center;
}
.confirm-overlay.is-open { display: flex; }
.confirm-box {
  background: var(--bg-surface);
  border: 1px solid var(--bd-subtle);
  border-radius: var(--r-xl);
  padding: 28px;
  max-width: 360px;
  width: 90%;
  box-shadow: 0 30px 70px -20px rgba(15,23,42,.30), 0 4px 18px rgba(15,23,42,.08);
  animation: pop-in var(--t-slow) var(--ease) both;
}
.confirm-box__ico {
  width: 42px; height: 42px;
  border-radius: var(--r-lg);
  background: var(--red-d);
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--red);
  margin-bottom: 16px;
}
.confirm-box__ico svg { width: 20px; height: 20px; }
.confirm-box__title { font-size: 15.5px; font-weight: 800; color: var(--tx-primary); margin-bottom: 6px; letter-spacing: -0.02em; }
.confirm-box__sub { font-size: 12.5px; color: var(--tx-muted); line-height: 1.6; margin-bottom: 20px; }
.confirm-box__sub strong { color: var(--tx-secondary); }
.confirm-box__acts { display: flex; gap: 8px; justify-content: flex-end; }

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
  .mtbl td:nth-child(4) { display: none; }
}
@media (max-width: 480px) {
  .mtbl th:nth-child(3),
  .mtbl td:nth-child(3) { display: none; }
}
</style>

<!-- ═══════════════════════════════════════
     ROOT
═══════════════════════════════════════ -->
<div class="abs-root">

<!-- ─────────────────────────────────
     PAGE HEADER
────────────────────────────────── -->
<div class="ph">
  <div class="ph__left">
    <div class="ph__eyebrow">Manajemen Data</div>
    <h1 class="ph__title">Absensi</h1>
    <p class="ph__sub">Kelola sesi absensi — buat, cetak, dan pantau kehadiran anggota.</p>
  </div>
  <div class="ph__actions">
    <button type="button" class="btn-sec" id="btn-export">
      <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <path d="M7 1v8M4 6l3 3 3-3M2 11h10"/>
      </svg>
      Ekspor
    </button>
    <button type="button" class="btn-pri" id="btn-buat-sesi">
      <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <path d="M7 2v10M2 7h10"/>
      </svg>
      Buat Sesi Baru
    </button>
  </div>
</div>

<!-- ─────────────────────────────────
     FLASH ALERT
────────────────────────────────── -->
<?php if (!empty($flash)): ?>
<div class="flash-alert flash-alert--<?= htmlspecialchars($flash['type']) ?>">
  <?php if ($flash['type'] === 'success'): ?>
    <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2 7l3.5 3.5L12 3"/></svg>
  <?php else: ?>
    <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="7" cy="7" r="5.5"/><path d="M7 4.5v3"/><circle cx="7" cy="9.5" r=".5" fill="currentColor"/></svg>
  <?php endif; ?>
  <?= htmlspecialchars($flash['msg']) ?>
</div>
<?php endif; ?>

<!-- ─────────────────────────────────
     STATS STRIP
────────────────────────────────── -->
<?php
  $totalSesi   = $stats['total_sesi']   ?? 0;
  $totalBulan  = $stats['total_bulan']  ?? 0;
  $rataHadir   = $stats['rata_hadir']   ?? 0;
  $sesiAktif   = $stats['sesi_aktif']   ?? 0;
?>
<div class="stats-strip">

  <div class="stat-pill stat-pill--blue">
    <div class="stat-pill__ico">
      <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <rect x="1.5" y="2.5" width="11" height="10" rx="1.5"/>
        <path d="M4.5 1v3M9.5 1v3M1.5 6.5h11"/>
      </svg>
    </div>
    <div class="stat-pill__body">
      <div class="stat-pill__val"><?= number_format($totalSesi) ?></div>
      <div class="stat-pill__lbl">Total Sesi</div>
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
      <div class="stat-pill__val"><?= number_format($totalBulan) ?></div>
      <div class="stat-pill__lbl">Sesi Bulan Ini</div>
    </div>
  </div>

  <div class="stat-pill stat-pill--amber">
    <div class="stat-pill__ico">
      <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <circle cx="5" cy="4" r="2.5"/>
        <path d="M1 12c0-2.2 1.8-4 4-4s4 1.8 4 4"/>
        <circle cx="11" cy="4.5" r="1.8"/>
        <path d="M13 11c0-1.5-1-2.7-2.2-2.7"/>
      </svg>
    </div>
    <div class="stat-pill__body">
      <div class="stat-pill__val"><?= number_format($rataHadir) ?></div>
      <div class="stat-pill__lbl">Rata-rata Hadir</div>
    </div>
  </div>

  <div class="stat-pill stat-pill--cyan">
    <div class="stat-pill__ico">
      <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <circle cx="7" cy="7" r="5.5"/><path d="M7 4.5v3l1.5 1.5"/>
      </svg>
    </div>
    <div class="stat-pill__body">
      <div class="stat-pill__val"><?= number_format($sesiAktif) ?></div>
      <div class="stat-pill__lbl">Sesi Aktif</div>
    </div>
  </div>

</div>

<!-- ─────────────────────────────────
     FILTER BAR
────────────────────────────────── -->
<div class="sec-label">
  <span class="sec-label__text">Daftar Sesi Absensi</span>
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
           placeholder="Cari judul sesi…"
           autocomplete="off">
  </div>

  <!-- Bulan -->
  <div class="fi fi--select">
    <span class="fi__icon">
      <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" aria-hidden="true">
        <rect x="1.5" y="2.5" width="11" height="10" rx="1.5"/>
        <path d="M4.5 1v3M9.5 1v3M1.5 6.5h11"/>
      </svg>
    </span>
    <select name="bulan">
      <option value="">Semua Bulan</option>
      <?php
        $namaBulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        for ($b = 1; $b <= 12; $b++):
      ?>
        <option value="<?= $b ?>" <?= ($filter['bulan'] ?? '') == $b ? 'selected' : '' ?>>
          <?= $namaBulan[$b-1] ?>
        </option>
      <?php endfor; ?>
    </select>
  </div>

  <!-- Tahun -->
  <div class="fi fi--select">
    <span class="fi__icon">
      <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" aria-hidden="true">
        <circle cx="7" cy="7" r="5.5"/>
      </svg>
    </span>
    <select name="tahun">
      <option value="">Semua Tahun</option>
      <?php for ($y = date('Y'); $y >= date('Y') - 3; $y--): ?>
        <option value="<?= $y ?>" <?= ($filter['tahun'] ?? '') == $y ? 'selected' : '' ?>><?= $y ?></option>
      <?php endfor; ?>
    </select>
  </div>

  <button type="submit" class="filter-btn">
    <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" aria-hidden="true">
      <path d="M1.5 4h11M3.5 7h7M5.5 10h3"/>
    </svg>
    Filter
  </button>

  <?php if (!empty($filter['search']) || !empty($filter['bulan']) || !empty($filter['tahun'])): ?>
    <a href="<?= BASE_URL ?>/admin/absensi" class="filter-reset">✕ Reset</a>
  <?php endif; ?>
</form>

<!-- ─────────────────────────────────
     TABLE PANEL
────────────────────────────────── -->
<div class="tpanel">
  <div class="tpanel__head">
    <span class="tpanel__title">Tabel Sesi Absensi</span>
    <span class="tpanel__meta">
      Total <strong><?= number_format(count($sesi)) ?></strong> sesi ditampilkan
    </span>
  </div>

  <div style="overflow-x:auto;">
    <table class="mtbl">
      <thead>
        <tr>
          <th>Judul Sesi</th>
          <th style="width:120px;">Tanggal</th>
          <th style="width:220px;">Keterangan</th>
          <th style="width:140px;">Dibuat Oleh</th>
          <th style="width:140px;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($sesi)): ?>
        <tr>
          <td colspan="5">
            <div class="tbl-empty">
              <svg class="tbl-empty__ico" viewBox="0 0 40 40" fill="none" stroke="currentColor" stroke-width="1.2" aria-hidden="true">
                <rect x="6" y="4" width="28" height="32" rx="3"/>
                <path d="M13 13h14M13 19h14M13 25h8" stroke-linecap="round"/>
              </svg>
              <div class="tbl-empty__title">Belum ada sesi absensi</div>
              <div class="tbl-empty__sub">Buat sesi baru untuk mulai mencatat kehadiran.</div>
            </div>
          </td>
        </tr>
        <?php else: ?>
        <?php foreach ($sesi as $s): ?>
        <tr>
          <!-- Judul -->
          <td>
            <div class="cell-sesi-wrap">
              <div class="sesi-ico" aria-hidden="true">
                <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                  <rect x="1.5" y="2.5" width="11" height="10" rx="1.5"/>
                  <path d="M4.5 1v3M9.5 1v3M1.5 6.5h11"/>
                </svg>
              </div>
              <span class="cell-title"><?= htmlspecialchars($s['judul']) ?></span>
            </div>
          </td>

          <!-- Tanggal -->
          <td>
            <span class="date-chip">
              <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" aria-hidden="true">
                <rect x="1.5" y="2.5" width="11" height="10" rx="1.5"/>
                <path d="M1.5 6.5h11"/>
              </svg>
              <?= date('d/m/Y', strtotime($s['tanggal'])) ?>
            </span>
          </td>

          <!-- Keterangan -->
          <td>
            <?php if (!empty($s['keterangan'])): ?>
              <span class="cell-note"><?= htmlspecialchars($s['keterangan']) ?></span>
            <?php else: ?>
              <span class="cell-mono">—</span>
            <?php endif; ?>
          </td>

          <!-- Dibuat oleh -->
          <td>
            <?php if (!empty($s['created_by_name'])): ?>
              <div class="creator-chip">
                <div class="creator-chip__ava">
                  <?= mb_strtoupper(mb_substr($s['created_by_name'], 0, 2)) ?>
                </div>
                <?= htmlspecialchars($s['created_by_name']) ?>
              </div>
            <?php else: ?>
              <span class="cell-mono">—</span>
            <?php endif; ?>
          </td>

          <!-- Aksi -->
          <td>
            <div class="act-group">
              <a href="<?= BASE_URL ?>/admin/absensi/<?= (int)$s['id'] ?>/print"
                 target="_blank"
                 class="act-btn act-btn--cyan">
                <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                  <path d="M3.5 4V2.5h7V4M3 4h8a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1V5a1 1 0 011-1z"/>
                  <path d="M4 8.5h6M4 10.5h4"/>
                </svg>
                Cetak
              </a>
              <button type="button" class="act-btn act-btn--danger"
                      data-confirm-id="<?= (int)$s['id'] ?>"
                      data-confirm-title="<?= htmlspecialchars($s['judul'], ENT_QUOTES) ?>">
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
  <div class="pagination" style="display:flex;align-items:center;justify-content:space-between;padding:12px 18px;border-top:1px solid var(--bd-subtle);gap:12px;flex-wrap:wrap;">
    <span style="font-family:var(--font-mono);font-size:11px;color:var(--tx-muted);">
      Halaman <strong style="color:var(--tx-secondary);"><?= $pagination['current_page'] ?></strong>
      dari <strong style="color:var(--tx-secondary);"><?= $pagination['total_pages'] ?></strong>
      &nbsp;·&nbsp; <?= number_format($pagination['total_rows']) ?> total baris
    </span>
    <div style="display:flex;align-items:center;gap:4px;">
      <?php $hasPrev = $pagination['current_page'] > 1; ?>
      <a href="<?= $hasPrev ? BASE_URL . '/admin/absensi?page=' . ($pagination['current_page'] - 1) . '&' . http_build_query(array_filter(['search'=>$filter['search']??'','bulan'=>$filter['bulan']??'','tahun'=>$filter['tahun']??''])) : '#' ?>"
         style="display:inline-flex;align-items:center;justify-content:center;min-width:30px;height:30px;padding:0 6px;font-family:var(--font-mono);font-size:11px;font-weight:700;border-radius:var(--r-sm);border:1.5px solid var(--bd-subtle);background:var(--bg-surface);color:var(--tx-muted);text-decoration:none;<?= !$hasPrev ? 'opacity:.35;pointer-events:none;' : '' ?>">
        <svg viewBox="0 0 11 11" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 2L4 5.5 7 9"/></svg>
      </a>
      <?php for ($pg = 1; $pg <= $pagination['total_pages']; $pg++): ?>
        <?php if ($pg === 1 || $pg === $pagination['total_pages'] || abs($pg - $pagination['current_page']) <= 1): ?>
          <a href="<?= BASE_URL ?>/admin/absensi?page=<?= $pg ?>&<?= http_build_query(array_filter(['search'=>$filter['search']??'','bulan'=>$filter['bulan']??'','tahun'=>$filter['tahun']??''])) ?>"
             style="display:inline-flex;align-items:center;justify-content:center;min-width:30px;height:30px;padding:0 6px;font-family:var(--font-mono);font-size:11px;font-weight:700;border-radius:var(--r-sm);border:1.5px solid <?= $pg === $pagination['current_page'] ? 'var(--bd-accent)' : 'var(--bd-subtle)' ?>;background:<?= $pg === $pagination['current_page'] ? 'var(--ac-dim)' : 'var(--bg-surface)' ?>;color:<?= $pg === $pagination['current_page'] ? 'var(--ac)' : 'var(--tx-muted)' ?>;text-decoration:none;">
            <?= $pg ?>
          </a>
        <?php elseif (abs($pg - $pagination['current_page']) === 2): ?>
          <span style="display:inline-flex;align-items:center;justify-content:center;min-width:30px;height:30px;font-family:var(--font-mono);font-size:11px;color:var(--tx-muted);opacity:.5;">…</span>
        <?php endif; ?>
      <?php endfor; ?>
      <?php $hasNext = $pagination['current_page'] < $pagination['total_pages']; ?>
      <a href="<?= $hasNext ? BASE_URL . '/admin/absensi?page=' . ($pagination['current_page'] + 1) . '&' . http_build_query(array_filter(['search'=>$filter['search']??'','bulan'=>$filter['bulan']??'','tahun'=>$filter['tahun']??''])) : '#' ?>"
         style="display:inline-flex;align-items:center;justify-content:center;min-width:30px;height:30px;padding:0 6px;font-family:var(--font-mono);font-size:11px;font-weight:700;border-radius:var(--r-sm);border:1.5px solid var(--bd-subtle);background:var(--bg-surface);color:var(--tx-muted);text-decoration:none;<?= !$hasNext ? 'opacity:.35;pointer-events:none;' : '' ?>">
        <svg viewBox="0 0 11 11" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 2l3 3.5-3 3.5"/></svg>
      </a>
    </div>
  </div>
  <?php endif; ?>

</div><!-- /.tpanel -->

<!-- ─────────────────────────────────
     MODAL BUAT SESI
────────────────────────────────── -->
<div class="modal-overlay" id="modal-buat" role="dialog" aria-modal="true" aria-labelledby="modal-title">
  <div class="modal-box">
    <div class="modal-box__header">
      <div class="modal-box__title-wrap">
        <div class="modal-box__eyebrow">Absensi</div>
        <div class="modal-box__title" id="modal-title">Buat Sesi Baru</div>
      </div>
      <button type="button" class="modal-close" id="modal-close-btn" aria-label="Tutup">
        <svg viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true">
          <path d="M1 1l10 10M11 1L1 11"/>
        </svg>
      </button>
    </div>
    <form method="POST" action="<?= BASE_URL ?>/admin/absensi/create">
      <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">

      <div class="form-group">
        <label class="form-label" for="field-judul">
          Judul Sesi <span>*</span>
        </label>
        <input type="text" id="field-judul" name="judul" required
               class="form-input"
               placeholder="contoh: Rapat Pleno, Acara Tahunan…">
      </div>

      <div class="form-group">
        <label class="form-label" for="field-tanggal">Tanggal</label>
        <input type="date" id="field-tanggal" name="tanggal"
               class="form-input"
               value="<?= date('Y-m-d') ?>">
      </div>

      <div class="form-group">
        <label class="form-label" for="field-keterangan">Keterangan</label>
        <textarea id="field-keterangan" name="keterangan"
                  class="form-input"
                  placeholder="Opsional — deskripsi singkat sesi ini…"></textarea>
      </div>

      <div class="modal-acts">
        <button type="button" class="btn-cancel" id="modal-cancel-btn">Batal</button>
        <button type="submit" class="btn-pri">
          <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M7 2v10M2 7h10"/>
          </svg>
          Buat Sesi
        </button>
      </div>
    </form>
  </div>
</div>

<!-- ─────────────────────────────────
     CONFIRM DELETE DIALOG
────────────────────────────────── -->
<div class="confirm-overlay" id="confirm-overlay" role="dialog" aria-modal="true" aria-labelledby="confirm-title">
  <div class="confirm-box">
    <div class="confirm-box__ico">
      <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <path d="M3 6h14M8 6V4.5a1.5 1.5 0 013 0V6M7 9l.5 6M13 9l-.5 6M5 6l.8 10.5A1 1 0 006.8 18h6.4a1 1 0 001-.9L15 6"/>
      </svg>
    </div>
    <div class="confirm-box__title" id="confirm-title">Hapus Sesi Absensi?</div>
    <div class="confirm-box__sub">
      Sesi <strong id="confirm-title-display">—</strong> akan dihapus permanen beserta seluruh data kehadirannya.
      Aksi ini <strong>tidak dapat dikembalikan</strong>.
    </div>
    <div class="confirm-box__acts">
      <button type="button" class="btn-sec" id="confirm-cancel">Batal</button>
      <form method="POST" id="confirm-form">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
        <button type="submit" class="btn-pri" style="background:var(--red);box-shadow:none;">
          Ya, Hapus
        </button>
      </form>
    </div>
  </div>
</div>

</div><!-- /.abs-root -->

<script>
(function () {
  'use strict';

  /* ── Modal Buat Sesi ── */
  var modal      = document.getElementById('modal-buat');
  var btnBuat    = document.getElementById('btn-buat-sesi');
  var btnClose   = document.getElementById('modal-close-btn');
  var btnCancel  = document.getElementById('modal-cancel-btn');

  function openModal() {
    modal.classList.add('is-open');
    document.body.style.overflow = 'hidden';
    setTimeout(function () {
      document.getElementById('field-judul').focus();
    }, 50);
  }
  function closeModal() {
    modal.classList.remove('is-open');
    document.body.style.overflow = '';
  }

  btnBuat.addEventListener('click', openModal);
  btnClose.addEventListener('click', closeModal);
  btnCancel.addEventListener('click', closeModal);
  modal.addEventListener('click', function (e) { if (e.target === modal) closeModal(); });

  /* ── Confirm Delete Dialog ── */
  var confirmOverlay = document.getElementById('confirm-overlay');
  var confirmTitle   = document.getElementById('confirm-title-display');
  var confirmForm    = document.getElementById('confirm-form');
  var confirmCancel  = document.getElementById('confirm-cancel');

  document.querySelectorAll('[data-confirm-id]').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var id    = btn.dataset.confirmId;
      var title = btn.dataset.confirmTitle;
      confirmTitle.textContent = title;
      confirmForm.action = '<?= BASE_URL ?>/admin/absensi/' + id + '/delete';
      confirmOverlay.classList.add('is-open');
      document.body.style.overflow = 'hidden';
    });
  });

  function closeConfirm() {
    confirmOverlay.classList.remove('is-open');
    document.body.style.overflow = '';
  }

  confirmCancel.addEventListener('click', closeConfirm);
  confirmOverlay.addEventListener('click', function (e) { if (e.target === confirmOverlay) closeConfirm(); });

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') { closeModal(); closeConfirm(); }
  });

  /* ── Auto-submit filter on select change ── */
  var form = document.getElementById('filter-form');
  form.querySelectorAll('select').forEach(function (sel) {
    sel.addEventListener('change', function () { form.submit(); });
  });

}());
</script>