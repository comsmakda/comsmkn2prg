<?php // app/views/admin/dashboard.php ?>

<style>
/* ═══════════════════════════════════════
   SCOPE ROOT — alias ke Design System
   (token asli didefinisikan global di layout;
    fallback disertakan bila file ini dirender berdiri sendiri)
═══════════════════════════════════════ */
.dash-root {
  /* Text */
  --tx-primary:   var(--c-ink,    #0f172a);
  --tx-secondary: var(--c-muted,  #64748b);
  --tx-muted:     var(--c-muted2, #94a3b8);

  /* Surface */
  --bg-surface:  var(--c-white, #ffffff);
  --bg-elevated: #f8fafc;
  --bg-overlay:  #eef2f6;
  --bg-active:   var(--c-primary-08, rgba(14,116,144,.08));

  /* Border */
  --bd-subtle:  var(--c-border, #e6ebf1);
  --bd-default: var(--c-border, #e6ebf1);
  --bd-accent:  var(--c-primary-25, rgba(14,116,144,.25));

  /* Accent (satu-satunya warna aksen dekoratif) */
  --ac:      var(--c-primary,    #0e7490);
  --ac-dim:  var(--c-primary-08, rgba(14,116,144,.08));
  --ac-glow: var(--c-primary-12, rgba(14,116,144,.12));

  /* Kategori KPI/feed — tetap dalam keluarga primary + warna status */
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

  /* Radius */
  --r-xs: 6px;
  --r-sm: var(--radius-sm, 9px);
  --r-md: var(--radius-sm, 9px);
  --r-lg: var(--radius-md, 13px);
  --r-xl: var(--radius-lg, 22px);

  /* Font — satu keluarga font di seluruh sistem */
  --font-ui:   var(--ff, 'Plus Jakarta Sans', sans-serif);
  --font-mono: var(--ff, 'Plus Jakarta Sans', sans-serif);

  /* Motion */
  --ease:  cubic-bezier(0.22, 1, 0.36, 1);
  --t-fast: 120ms;
  --t-base: 160ms;
  --t-slow: 300ms;
}

/* Base reset for dashboard scope */
.dash-root * { box-sizing: border-box; margin: 0; padding: 0; }
.dash-root a { text-decoration: none; color: inherit; }
.dash-root {
  font-family: var(--font-ui);
  color: var(--tx-primary);
  font-size: 13.5px;
  line-height: 1.5;
  -webkit-font-smoothing: antialiased;
}

/* ═══════════════════════════════════════
   HEADER
═══════════════════════════════════════ */
.dh {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  gap: 16px;
  margin-bottom: 28px;
  flex-wrap: wrap;
}

.dh__left { flex: 1; min-width: 0; }

.dh__eyebrow {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  font-size: 11px;
  font-weight: 700;
  letter-spacing: 0.1em;
  text-transform: uppercase;
  color: var(--ac);
  margin-bottom: 8px;
}
.dh__eyebrow-dot {
  width: 6px; height: 6px;
  border-radius: 50%;
  background: var(--ac);
  box-shadow: 0 0 6px var(--ac);
  animation: pulse-dot 2.4s ease-in-out infinite;
}
@keyframes pulse-dot {
  0%,100% { opacity:1; box-shadow: 0 0 6px var(--ac); }
  50%      { opacity:.5; box-shadow: 0 0 12px var(--ac); }
}

.dh__title {
  font-size: 26px;
  font-weight: 800;
  letter-spacing: -0.03em;
  color: var(--c-primary-dk, #0b5a70);
  line-height: 1.1;
}
.dh__sub {
  font-size: 13px;
  color: var(--tx-secondary);
  margin-top: 6px;
  font-weight: 400;
}
.dh__sub strong { color: var(--tx-primary); font-weight: 700; }

.dh__right {
  display: flex;
  align-items: center;
  gap: 8px;
  flex-shrink: 0;
  padding-top: 4px;
}

.dh__clock {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 8px 14px;
  background: var(--bg-surface);
  border: 1px solid var(--bd-subtle);
  border-radius: var(--r-md);
}
.dh__clock-time {
  font-size: 14px;
  font-weight: 700;
  color: var(--tx-primary);
  letter-spacing: 0.02em;
  min-width: 50px;
  font-variant-numeric: tabular-nums;
}
.dh__clock-date {
  font-size: 10.5px;
  color: var(--tx-muted);
  font-weight: 500;
  border-left: 1px solid var(--bd-subtle);
  padding-left: 9px;
}

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
.sec-label__num {
  font-size: 10px;
  color: var(--tx-muted);
  opacity: .6;
  font-weight: 600;
}

/* ═══════════════════════════════════════
   STAT CARDS
═══════════════════════════════════════ */
.kpi-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
  gap: 12px;
  margin-bottom: 28px;
}

.kpi {
  position: relative;
  padding: 18px 18px 14px;
  background: var(--bg-surface);
  border: 1px solid var(--bd-subtle);
  border-radius: var(--r-xl);
  overflow: hidden;
  cursor: default;
  transition:
    border-color var(--t-base) var(--ease),
    transform    var(--t-fast) var(--ease),
    box-shadow   var(--t-base) var(--ease);
}
.kpi:hover {
  transform: translateY(-2px);
  box-shadow: 0 16px 36px -14px rgba(15,23,42,.18), 0 4px 14px rgba(15,23,42,.05);
}

/* Accent bar top */
.kpi::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 3px;
  border-radius: var(--r-xl) var(--r-xl) 0 0;
}

/* Ambient glow */
.kpi::after {
  content: '';
  position: absolute;
  top: -30px; left: -30px;
  width: 120px; height: 120px;
  border-radius: 50%;
  opacity: 0;
  pointer-events: none;
  transition: opacity var(--t-slow) var(--ease);
}
.kpi:hover::after { opacity: 1; }

/* Color variants */
.kpi--blue  { border-color: rgba(14,116,144,0.20); }
.kpi--amber { border-color: rgba(217,145,12,0.20); }
.kpi--purple{ border-color: rgba(11,90,112,0.20); }
.kpi--green { border-color: rgba(21,128,61,0.20); }

.kpi--blue::before   { background: var(--blue); }
.kpi--amber::before  { background: var(--amber); }
.kpi--purple::before { background: var(--purple); }
.kpi--green::before  { background: var(--green); }

.kpi--blue::after   { background: radial-gradient(circle, rgba(14,116,144,.10), transparent 70%); }
.kpi--amber::after  { background: radial-gradient(circle, rgba(217,145,12,.10), transparent 70%); }
.kpi--purple::after { background: radial-gradient(circle, rgba(11,90,112,.10), transparent 70%); }
.kpi--green::after  { background: radial-gradient(circle, rgba(21,128,61,.10), transparent 70%); }

.kpi:hover.kpi--blue   { border-color: rgba(14,116,144,0.4); }
.kpi:hover.kpi--amber  { border-color: rgba(217,145,12,0.4); }
.kpi:hover.kpi--purple { border-color: rgba(11,90,112,0.4); }
.kpi:hover.kpi--green  { border-color: rgba(21,128,61,0.4); }

.kpi__row {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  margin-bottom: 16px;
}
.kpi__label {
  font-size: 11px;
  font-weight: 700;
  color: var(--tx-muted);
  letter-spacing: 0.03em;
  text-transform: uppercase;
}
.kpi__icon {
  width: 34px; height: 34px;
  border-radius: var(--r-sm);
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}
.kpi__icon i { font-size: 16px; }

.kpi--blue   .kpi__icon { background: var(--blue-d);   color: var(--blue); }
.kpi--amber  .kpi__icon { background: var(--amber-d);  color: var(--amber); }
.kpi--purple .kpi__icon { background: var(--purple-d); color: var(--purple); }
.kpi--green  .kpi__icon { background: var(--green-d);  color: var(--green); }

.kpi__val {
  font-size: 32px;
  font-weight: 800;
  letter-spacing: -0.03em;
  color: var(--tx-primary);
  line-height: 1;
  font-variant-numeric: tabular-nums;
}

.kpi__footer {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-top: 12px;
  padding-top: 10px;
  border-top: 1px solid var(--bd-subtle);
}
.kpi__badge {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  font-size: 10.5px;
  font-weight: 700;
  padding: 3px 8px;
  border-radius: var(--r-xs);
}
.kpi__badge i { font-size: 11px; }
.kpi__badge--up   { background: var(--green-d); color: var(--green); }
.kpi__badge--flat { background: var(--bg-overlay); color: var(--tx-muted); }
.kpi__badge--warn { background: var(--amber-d); color: var(--amber); }

.kpi__sublabel {
  font-size: 10.5px;
  color: var(--tx-muted);
  font-weight: 500;
}

/* ═══════════════════════════════════════
   MAIN GRID
═══════════════════════════════════════ */
.main-grid {
  display: grid;
  grid-template-columns: 1fr 350px;
  gap: 14px;
  margin-bottom: 14px;
}
@media (max-width: 1024px) { .main-grid { grid-template-columns: 1fr; } }

/* ═══════════════════════════════════════
   PANEL BASE
═══════════════════════════════════════ */
.panel {
  background: var(--bg-surface);
  border: 1px solid var(--bd-subtle);
  border-radius: var(--r-xl);
  overflow: hidden;
}
.panel__head {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 15px 20px;
  border-bottom: 1px solid var(--bd-subtle);
  gap: 8px;
}
.panel__title {
  font-size: 13px;
  font-weight: 800;
  color: var(--tx-primary);
  letter-spacing: -0.01em;
}
.panel__title-sub {
  font-size: 11.5px;
  color: var(--tx-muted);
  font-weight: 400;
  margin-left: 8px;
}
.panel__action {
  font-size: 11px;
  font-weight: 700;
  letter-spacing: 0.02em;
  color: var(--ac);
  padding: 5px 10px;
  border: 1px solid var(--bd-accent);
  border-radius: var(--r-xs);
  transition: background var(--t-fast) var(--ease);
  white-space: nowrap;
}
.panel__action:hover { background: var(--ac-dim); }
.panel__body { padding: 18px 20px; }

/* ═══════════════════════════════════════
   QUICK ACCESS
═══════════════════════════════════════ */
.qa-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 10px;
}
@media (max-width: 640px) { .qa-grid { grid-template-columns: repeat(2, 1fr); } }

.qa-item {
  display: flex;
  flex-direction: column;
  gap: 10px;
  padding: 15px;
  border-radius: var(--r-lg);
  background: var(--bg-elevated);
  border: 1px solid var(--bd-subtle);
  position: relative;
  overflow: hidden;
  transition:
    border-color var(--t-base) var(--ease),
    background   var(--t-base) var(--ease),
    transform    var(--t-fast) var(--ease),
    box-shadow   var(--t-base) var(--ease);
}
.qa-item:hover {
  border-color: var(--bd-accent);
  background: var(--bg-active);
  transform: translateY(-2px);
  box-shadow: 0 10px 24px rgba(15,23,42,.09);
}

.qa-item__icon {
  width: 36px; height: 36px;
  border-radius: var(--r-sm);
  display: flex;
  align-items: center;
  justify-content: center;
  background: var(--bg-overlay);
  color: var(--tx-secondary);
  flex-shrink: 0;
  transition: color var(--t-base) var(--ease), background var(--t-base) var(--ease);
}
.qa-item__icon i { font-size: 16px; }
.qa-item:hover .qa-item__icon { background: var(--ac-glow); color: var(--ac); }

.qa-item__title {
  font-size: 12.5px;
  font-weight: 700;
  color: var(--tx-primary);
  line-height: 1.2;
}
.qa-item__desc {
  font-size: 11px;
  color: var(--tx-muted);
  line-height: 1.4;
}

/* ═══════════════════════════════════════
   ACTIVITY FEED
═══════════════════════════════════════ */
.feed {
  display: flex;
  flex-direction: column;
  position: relative;
}

.feed::before {
  content: '';
  position: absolute;
  left: 7px;
  top: 12px;
  bottom: 12px;
  width: 1px;
  background: linear-gradient(to bottom, var(--bd-default), transparent);
}

.feed__item {
  display: flex;
  align-items: flex-start;
  gap: 12px;
  padding: 10px 0;
  border-bottom: 1px solid var(--bd-subtle);
  position: relative;
}
.feed__item:last-child { border-bottom: none; }

.feed__dot-wrap {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 16px;
  flex-shrink: 0;
  padding-top: 4px;
  z-index: 1;
}
.feed__dot {
  width: 8px; height: 8px;
  border-radius: 50%;
  border: 1.5px solid currentColor;
  flex-shrink: 0;
}

.feed__dot--blue   { color: var(--blue);   background: rgba(14,116,144,.18); }
.feed__dot--green  { color: var(--green);  background: rgba(21,128,61,.18); }
.feed__dot--amber  { color: var(--amber);  background: rgba(217,145,12,.18); }
.feed__dot--purple { color: var(--purple); background: rgba(11,90,112,.18); }
.feed__dot--red    { color: var(--red);    background: rgba(185,28,28,.18); }

.feed__body { flex: 1; min-width: 0; }
.feed__action {
  font-size: 12.5px;
  color: var(--tx-secondary);
  line-height: 1.5;
}
.feed__action strong { color: var(--tx-primary); font-weight: 700; }
.feed__action em {
  font-style: normal;
  font-size: 11px;
  color: var(--ac);
  background: var(--ac-dim);
  padding: 1px 6px;
  border-radius: var(--r-xs);
}
.feed__meta {
  display: flex;
  align-items: center;
  gap: 8px;
  margin-top: 3px;
}
.feed__time {
  font-size: 10.5px;
  color: var(--tx-muted);
  font-weight: 500;
}
.feed__type {
  font-size: 10px;
  font-weight: 700;
  letter-spacing: 0.04em;
  text-transform: uppercase;
  padding: 1px 7px;
  border-radius: var(--r-xs);
}
.feed__type--pab     { background: var(--blue-d);   color: var(--blue); }
.feed__type--absensi { background: var(--green-d);  color: var(--green); }
.feed__type--manual  { background: var(--amber-d);  color: var(--amber); }
.feed__type--sistem  { background: var(--purple-d); color: var(--purple); }
.feed__type--tolak   { background: var(--red-d);    color: var(--red); }

.feed__empty {
  text-align: center;
  padding: 40px 20px;
  color: var(--tx-muted);
  font-size: 12.5px;
}
.feed__empty i {
  font-size: 30px;
  color: var(--tx-muted);
  opacity: .5;
  margin-bottom: 10px;
  display: block;
}

/* ═══════════════════════════════════════
   SYSTEM INFO
═══════════════════════════════════════ */
.sysinfo { display: flex; flex-direction: column; }
.sysinfo-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 9px 0;
  border-bottom: 1px solid var(--bd-subtle);
  gap: 12px;
}
.sysinfo-row:last-child { border-bottom: none; }
.sysinfo__key {
  font-size: 11.5px;
  color: var(--tx-muted);
  flex-shrink: 0;
  font-weight: 500;
}
.sysinfo__val {
  font-size: 11.5px;
  color: var(--tx-secondary);
  text-align: right;
  font-weight: 600;
}

.sys-badge {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  font-size: 10.5px;
  font-weight: 700;
  letter-spacing: 0.02em;
  padding: 3px 9px;
  border-radius: var(--r-xs);
}
.sys-badge__led {
  width: 5px; height: 5px;
  border-radius: 50%;
  background: currentColor;
}
.sys-badge--ok   { background: var(--green-d);  color: var(--green); }
.sys-badge--warn { background: var(--amber-d);  color: var(--amber); }

/* ═══════════════════════════════════════
   PROGRESS BARS
═══════════════════════════════════════ */
.usage-section {
  margin-top: 14px;
  padding-top: 14px;
  border-top: 1px solid var(--bd-subtle);
}
.usage-title {
  font-size: 10.5px;
  font-weight: 700;
  letter-spacing: 0.1em;
  text-transform: uppercase;
  color: var(--tx-muted);
  margin-bottom: 12px;
}
.pbar-wrap { margin-bottom: 12px; }
.pbar-wrap:last-child { margin-bottom: 0; }
.pbar-top {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 5px;
}
.pbar-label { font-size: 11.5px; color: var(--tx-muted); }
.pbar-pct {
  font-size: 11px;
  color: var(--tx-secondary);
  font-weight: 700;
}
.pbar-track {
  height: 4px;
  background: var(--bg-overlay);
  border-radius: 99px;
  overflow: hidden;
}
.pbar-fill {
  height: 100%;
  border-radius: 99px;
  position: relative;
  transition: width 0.8s var(--ease);
}
.pbar-fill--blue   { background: linear-gradient(to right, rgba(14,116,144,.45), var(--blue)); }
.pbar-fill--amber  { background: linear-gradient(to right, rgba(217,145,12,.45), var(--amber)); }
.pbar-fill--green  { background: linear-gradient(to right, rgba(21,128,61,.45), var(--green)); }

/* ═══════════════════════════════════════
   BOTTOM ROW
═══════════════════════════════════════ */
.bottom-grid {
  display: grid;
  grid-template-columns: 1fr 350px;
  gap: 14px;
}
@media (max-width: 1024px) { .bottom-grid { grid-template-columns: 1fr; } }

/* ═══════════════════════════════════════
   ANGGOTA TABLE
═══════════════════════════════════════ */
.atbl { width: 100%; border-collapse: collapse; }
.atbl th {
  font-size: 10.5px;
  font-weight: 700;
  letter-spacing: 0.08em;
  text-transform: uppercase;
  color: var(--tx-muted);
  text-align: left;
  padding: 0 10px 10px 0;
  border-bottom: 1px solid var(--bd-subtle);
}
.atbl td {
  padding: 11px 10px 11px 0;
  border-bottom: 1px solid var(--bd-subtle);
  font-size: 12.5px;
  color: var(--tx-secondary);
  vertical-align: middle;
}
.atbl tr:last-child td { border-bottom: none; }
.atbl tr:hover td { background: rgba(14,116,144,.03); }

.atbl__name { color: var(--tx-primary); font-weight: 700; display: block; margin-bottom: 1px; }
.atbl__nim  { font-size: 10.5px; color: var(--tx-muted); }

.status-chip {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  font-size: 10.5px;
  font-weight: 700;
  padding: 2px 8px;
  border-radius: var(--r-xs);
  white-space: nowrap;
}
.status-chip__dot { width: 5px; height: 5px; border-radius: 50%; background: currentColor; }
.chip--aktif  { background: var(--green-d);  color: var(--green); }
.chip--pending{ background: var(--amber-d);  color: var(--amber); }
.chip--tolak  { background: var(--red-d);    color: var(--red); }
.chip--non    { background: var(--bg-overlay); color: var(--tx-muted); }

.atbl__empty {
  text-align: center;
  padding: 30px;
  color: var(--tx-muted);
  font-size: 12.5px;
}

/* ═══════════════════════════════════════
   PAB QUEUE COMPACT LIST
═══════════════════════════════════════ */
.pab-list { display: flex; flex-direction: column; gap: 0; }
.pab-item {
  display: flex;
  align-items: center;
  gap: 11px;
  padding: 11px 0;
  border-bottom: 1px solid var(--bd-subtle);
}
.pab-item:last-child { border-bottom: none; }
.pab-item__ava {
  width: 34px; height: 34px;
  border-radius: var(--r-sm);
  background: var(--ac-dim);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 11.5px;
  font-weight: 800;
  color: var(--ac);
  flex-shrink: 0;
  text-transform: uppercase;
}
.pab-item__info { flex: 1; min-width: 0; }
.pab-item__name {
  font-size: 12.5px;
  font-weight: 700;
  color: var(--tx-primary);
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.pab-item__sub {
  font-size: 10.5px;
  color: var(--tx-muted);
  margin-top: 1px;
}
.pab-item__since {
  font-size: 10.5px;
  color: var(--tx-muted);
  flex-shrink: 0;
  font-weight: 500;
}
.pab-empty {
  text-align: center;
  padding: 30px;
  font-size: 12.5px;
  color: var(--tx-muted);
}

/* ═══════════════════════════════════════
   RESPONSIVE
═══════════════════════════════════════ */
@media (max-width: 640px) {
  .kpi-grid  { grid-template-columns: repeat(2, 1fr); }
  .dh__clock { display: none; }
  .dh__title { font-size: 21px; }
}
@media (max-width: 400px) {
  .kpi-grid { grid-template-columns: 1fr; }
}
</style>

<!-- ═══════════════════════════════════════
     ROOT WRAPPER
═══════════════════════════════════════ -->
<div class="dash-root">

<!-- ─────────────────────────────────────
     HEADER
───────────────────────────────────────── -->
<div class="dh">
  <div class="dh__left">
    <div class="dh__eyebrow">
      <span class="dh__eyebrow-dot"></span>
      Panel Administrasi
    </div>
    <h1 class="dh__title">Dashboard</h1>
    <p class="dh__sub">Selamat datang, <strong><?= htmlspecialchars($_SESSION['user_name'] ?? 'Administrator') ?></strong> — Berikut ringkasan sistem hari ini.</p>
  </div>
  <div class="dh__right">
    <div class="dh__clock">
      <div class="dh__clock-time" id="js-clock-time">--:--</div>
      <div class="dh__clock-date" id="js-clock-date">-- --- ----</div>
    </div>
  </div>
</div>

<!-- ─────────────────────────────────────
     KPI CARDS
───────────────────────────────────────── -->
<div class="sec-label">
  <span class="sec-label__text">Ringkasan Utama</span>
  <span class="sec-label__line"></span>
  <span class="sec-label__num">01</span>
</div>

<div class="kpi-grid">

  <!-- Anggota Aktif -->
  <div class="kpi kpi--blue">
    <div class="kpi__row">
      <span class="kpi__label">Anggota Aktif</span>
      <span class="kpi__icon"><i class="ti ti-users" aria-hidden="true"></i></span>
    </div>
    <div class="kpi__val"><?= number_format($stats['total_anggota'] ?? 0) ?></div>
    <div class="kpi__footer">
      <span class="kpi__badge kpi__badge--up">
        <i class="ti ti-trending-up" aria-hidden="true"></i>
        Terdaftar
      </span>
      <span class="kpi__sublabel">total</span>
    </div>
  </div>

  <!-- Antrian PAB -->
  <div class="kpi kpi--amber">
    <div class="kpi__row">
      <span class="kpi__label">Antrian PAB</span>
      <span class="kpi__icon"><i class="ti ti-clipboard-check" aria-hidden="true"></i></span>
    </div>
    <div class="kpi__val"><?= number_format($stats['pending_pab'] ?? 0) ?></div>
    <div class="kpi__footer">
      <span class="kpi__badge kpi__badge--warn">
        <i class="ti ti-clock-hour-4" aria-hidden="true"></i>
        Menunggu
      </span>
      <span class="kpi__sublabel">verifikasi</span>
    </div>
  </div>

  <!-- Pending Manual -->
  <div class="kpi kpi--purple">
    <div class="kpi__row">
      <span class="kpi__label">Pending Manual</span>
      <span class="kpi__icon"><i class="ti ti-hourglass" aria-hidden="true"></i></span>
    </div>
    <div class="kpi__val"><?= number_format($stats['pending_manual'] ?? 0) ?></div>
    <div class="kpi__footer">
      <span class="kpi__badge kpi__badge--flat">
        <i class="ti ti-arrow-right" aria-hidden="true"></i>
        Perlu Aksi
      </span>
      <span class="kpi__sublabel">entri</span>
    </div>
  </div>

  <!-- Sesi Absensi -->
  <div class="kpi kpi--green">
    <div class="kpi__row">
      <span class="kpi__label">Sesi Absensi</span>
      <span class="kpi__icon"><i class="ti ti-calendar-event" aria-hidden="true"></i></span>
    </div>
    <div class="kpi__val"><?= number_format($stats['total_sesi'] ?? 0) ?></div>
    <div class="kpi__footer">
      <span class="kpi__badge kpi__badge--up">
        <i class="ti ti-trending-up" aria-hidden="true"></i>
        Aktif
      </span>
      <span class="kpi__sublabel">sesi dibuat</span>
    </div>
  </div>

</div>

<!-- ─────────────────────────────────────
     MAIN GRID (Quick Access + Activity + Sysinfo)
───────────────────────────────────────── -->
<div class="sec-label">
  <span class="sec-label__text">Operasional</span>
  <span class="sec-label__line"></span>
  <span class="sec-label__num">02</span>
</div>

<div class="main-grid">

  <!-- LEFT: Quick Access -->
  <div class="panel">
    <div class="panel__head">
      <span class="panel__title">Akses Cepat <span class="panel__title-sub">— navigasi modul utama</span></span>
    </div>
    <div class="panel__body">
      <div class="qa-grid">
        <?php
        $links = [
          [
            'href'  => '/admin/pab',
            'title' => 'Verifikasi PAB',
            'desc'  => 'Setujui pendaftar baru',
            'icon'  => 'ti-clipboard-check',
          ],
          [
            'href'  => '/admin/anggota/tambah',
            'title' => 'Tambah Anggota',
            'desc'  => 'Input data manual',
            'icon'  => 'ti-user-plus',
          ],
          [
            'href'  => '/admin/absensi',
            'title' => 'Kelola Absensi',
            'desc'  => 'Buat sesi & daftar hadir',
            'icon'  => 'ti-calendar-event',
          ],
          [
            'href'  => '/admin/anggota',
            'title' => 'Data Anggota',
            'desc'  => 'Lihat & kelola semua',
            'icon'  => 'ti-users',
          ],
          [
            'href'  => '/admin/settings',
            'title' => 'Pengaturan CMS',
            'desc'  => 'Update konten website',
            'icon'  => 'ti-settings',
          ],
          [
            'href'  => '/admin/laporan',
            'title' => 'Laporan & Ekspor',
            'desc'  => 'Cetak & unduh data',
            'icon'  => 'ti-file-analytics',
          ],
        ];
        foreach ($links as $l):
        ?>
        <a href="<?= BASE_URL . htmlspecialchars($l['href']) ?>" class="qa-item">
          <span class="qa-item__icon" aria-hidden="true"><i class="ti <?= htmlspecialchars($l['icon']) ?>"></i></span>
          <span class="qa-item__title"><?= htmlspecialchars($l['title']) ?></span>
          <span class="qa-item__desc"><?= htmlspecialchars($l['desc']) ?></span>
        </a>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

  <!-- RIGHT: Activity Feed + System Info -->
  <div style="display:flex;flex-direction:column;gap:14px;">

    <!-- Activity Feed — NO dummy data -->
    <div class="panel">
      <div class="panel__head">
        <span class="panel__title">Log Aktivitas</span>
        <a href="<?= BASE_URL ?>/admin/log" class="panel__action">Lihat semua →</a>
      </div>
      <div class="panel__body" style="padding-top:10px;padding-bottom:10px;">

        <?php
          /*
           * $recentActivity diisi oleh controller — format array:
           * [
           *   'dot'    => 'blue|green|amber|purple|red',
           *   'label'  => 'pab|absensi|manual|sistem|tolak',  ← untuk chip tipe
           *   'label_text' => 'PAB|Absensi|Manual|Sistem|Ditolak',
           *   'text'   => 'HTML aman (hanya <strong> dan <em>)',
           *   'time'   => 'relatif atau timestamp',
           * ]
           *
           * Jika $recentActivity kosong / null, tampilkan empty state.
           */
          $activities = $recentActivity ?? [];
        ?>

        <?php if (empty($activities)): ?>
          <div class="feed__empty">
            <i class="ti ti-inbox" aria-hidden="true"></i>
            Belum ada aktivitas tercatat.
          </div>
        <?php else: ?>
          <div class="feed">
            <?php foreach ($activities as $a): ?>
            <div class="feed__item">
              <div class="feed__dot-wrap">
                <span class="feed__dot feed__dot--<?= htmlspecialchars($a['dot']) ?>" aria-hidden="true"></span>
              </div>
              <div class="feed__body">
                <div class="feed__action"><?= $a['text'] /* dipercaya HTML dari controller */ ?></div>
                <div class="feed__meta">
                  <span class="feed__time"><?= htmlspecialchars($a['time']) ?></span>
                  <?php if (!empty($a['label'])): ?>
                    <span class="feed__type feed__type--<?= htmlspecialchars($a['label']) ?>"><?= htmlspecialchars($a['label_text'] ?? strtoupper($a['label'])) ?></span>
                  <?php endif; ?>
                </div>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

      </div>
    </div>

    <!-- System Info -->
    <div class="panel">
      <div class="panel__head">
        <span class="panel__title">Info Sistem</span>
        <span class="sys-badge sys-badge--ok">
          <span class="sys-badge__led" aria-hidden="true"></span>
          Online
        </span>
      </div>
      <div class="panel__body" style="padding-top:8px;padding-bottom:8px;">
        <div class="sysinfo">
          <div class="sysinfo-row">
            <span class="sysinfo__key">PHP Version</span>
            <span class="sysinfo__val"><?= PHP_VERSION ?></span>
          </div>
          <div class="sysinfo-row">
            <span class="sysinfo__key">App Version</span>
            <span class="sysinfo__val"><?= defined('APP_VERSION') ? htmlspecialchars(APP_VERSION) : '1.0.0' ?></span>
          </div>
          <div class="sysinfo-row">
            <span class="sysinfo__key">Environment</span>
            <span class="sys-badge <?= (defined('APP_ENV') && APP_ENV === 'production') ? 'sys-badge--ok' : 'sys-badge--warn' ?>">
              <span class="sys-badge__led" aria-hidden="true"></span>
              <?= defined('APP_ENV') ? htmlspecialchars(strtoupper(APP_ENV)) : 'PRODUCTION' ?>
            </span>
          </div>
          <div class="sysinfo-row">
            <span class="sysinfo__key">Server Time</span>
            <span class="sysinfo__val"><?= date('d M Y, H:i:s') ?></span>
          </div>
          <div class="sysinfo-row">
            <span class="sysinfo__key">Timezone</span>
            <span class="sysinfo__val"><?= date_default_timezone_get() ?></span>
          </div>
        </div>

        <!-- Progress bars: data usage -->
        <div class="usage-section">
          <div class="usage-title">Proporsi Data</div>
          <?php
            $totalAng = $stats['total_anggota'] ?? 0;
            $pendPab  = $stats['pending_pab']   ?? 0;
            $totSesi  = $stats['total_sesi']     ?? 0;
            $maxVal   = max($totalAng + $pendPab, 1);
            $pctAng   = min(round(($totalAng / $maxVal) * 100), 100);
            $pctPab   = min(round(($pendPab   / $maxVal) * 100), 100);
            $pctSesi  = min($totSesi, 100);
          ?>
          <div class="pbar-wrap">
            <div class="pbar-top">
              <span class="pbar-label">Anggota aktif</span>
              <span class="pbar-pct"><?= $pctAng ?>%</span>
            </div>
            <div class="pbar-track">
              <div class="pbar-fill pbar-fill--blue" style="width:<?= $pctAng ?>%"></div>
            </div>
          </div>
          <div class="pbar-wrap">
            <div class="pbar-top">
              <span class="pbar-label">PAB pending</span>
              <span class="pbar-pct"><?= $pctPab ?>%</span>
            </div>
            <div class="pbar-track">
              <div class="pbar-fill pbar-fill--amber" style="width:<?= $pctPab ?>%"></div>
            </div>
          </div>
          <div class="pbar-wrap">
            <div class="pbar-top">
              <span class="pbar-label">Sesi absensi</span>
              <span class="pbar-pct"><?= $pctSesi ?>%</span>
            </div>
            <div class="pbar-track">
              <div class="pbar-fill pbar-fill--green" style="width:<?= $pctSesi ?>%"></div>
            </div>
          </div>
        </div>

      </div>
    </div>

  </div><!-- /right -->

</div><!-- /.main-grid -->

<!-- ─────────────────────────────────────
     BOTTOM ROW: Anggota Terbaru + Antrian PAB
───────────────────────────────────────── -->
<div class="sec-label" style="margin-top:14px;">
  <span class="sec-label__text">Data Terkini</span>
  <span class="sec-label__line"></span>
  <span class="sec-label__num">03</span>
</div>

<div class="bottom-grid">

  <!-- Anggota Terbaru -->
  <div class="panel">
    <div class="panel__head">
      <span class="panel__title">Anggota Terbaru <span class="panel__title-sub">— baru didaftarkan</span></span>
      <a href="<?= BASE_URL ?>/admin/anggota" class="panel__action">Semua data →</a>
    </div>
    <div class="panel__body" style="padding:0 20px;">
      <?php
        /*
         * $latestAnggota → array dari controller, contoh per baris:
         * ['name'=>'...', 'nim'=>'...', 'status'=>'aktif|pending|tolak|non-aktif', 'joined'=>'tgl']
         */
        $latestAnggota = $latestAnggota ?? [];
      ?>
      <?php if (empty($latestAnggota)): ?>
        <p class="atbl__empty">Belum ada data anggota.</p>
      <?php else: ?>
        <table class="atbl">
          <thead>
            <tr>
              <th>Nama / NIM</th>
              <th>Status</th>
              <th>Bergabung</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($latestAnggota as $row): ?>
            <tr>
              <td>
                <span class="atbl__name"><?= htmlspecialchars($row['name']) ?></span>
                <span class="atbl__nim"><?= htmlspecialchars($row['nim'] ?? '—') ?></span>
              </td>
              <td>
                <?php
                  $statusMap = [
                    'aktif'     => ['class' => 'chip--aktif',  'label' => 'Aktif'],
                    'pending'   => ['class' => 'chip--pending','label' => 'Pending'],
                    'tolak'     => ['class' => 'chip--tolak',  'label' => 'Ditolak'],
                    'non-aktif' => ['class' => 'chip--non',    'label' => 'Non-Aktif'],
                  ];
                  $st = $statusMap[$row['status'] ?? ''] ?? ['class' => 'chip--non', 'label' => ucfirst($row['status'] ?? '?')];
                ?>
                <span class="status-chip <?= $st['class'] ?>">
                  <span class="status-chip__dot" aria-hidden="true"></span>
                  <?= $st['label'] ?>
                </span>
              </td>
              <td><?= htmlspecialchars($row['joined'] ?? '—') ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </div>
  </div>

  <!-- Antrian PAB Pending -->
  <div class="panel">
    <div class="panel__head">
      <span class="panel__title">Antrian PAB</span>
      <a href="<?= BASE_URL ?>/admin/pab" class="panel__action">Verifikasi →</a>
    </div>
    <div class="panel__body" style="padding-top:8px;padding-bottom:8px;">
      <?php
        /*
         * $pendingPabList → array dari controller, contoh per baris:
         * ['name'=>'...', 'nim'=>'...', 'since'=>'...']
         */
        $pendingPabList = $pendingPabList ?? [];
      ?>
      <?php if (empty($pendingPabList)): ?>
        <p class="pab-empty">Tidak ada antrian PAB saat ini.</p>
      <?php else: ?>
        <div class="pab-list">
          <?php foreach ($pendingPabList as $p): ?>
          <div class="pab-item">
            <div class="pab-item__ava" aria-hidden="true">
              <?= mb_substr(htmlspecialchars($p['name']), 0, 2) ?>
            </div>
            <div class="pab-item__info">
              <div class="pab-item__name"><?= htmlspecialchars($p['name']) ?></div>
              <div class="pab-item__sub"><?= htmlspecialchars($p['nim'] ?? '—') ?></div>
            </div>
            <div class="pab-item__since"><?= htmlspecialchars($p['since'] ?? '—') ?></div>
          </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>

</div><!-- /.bottom-grid -->

</div><!-- /.dash-root -->

<script>
(function () {
  'use strict';

  var DAYS   = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
  var MONTHS = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agt','Sep','Okt','Nov','Des'];

  function pad(n) { return n < 10 ? '0' + n : n; }

  function tick() {
    var now = new Date();
    var timeEl = document.getElementById('js-clock-time');
    var dateEl = document.getElementById('js-clock-date');
    if (timeEl) timeEl.textContent = pad(now.getHours()) + ':' + pad(now.getMinutes()) + ':' + pad(now.getSeconds());
    if (dateEl) dateEl.textContent = DAYS[now.getDay()] + ', ' + pad(now.getDate()) + ' ' + MONTHS[now.getMonth()] + ' ' + now.getFullYear();
  }

  tick();
  setInterval(tick, 1000);
}());
</script>