<?php // app/views/admin/dashboard.php ?>

<style>
@import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;500;600&family=Sora:wght@300;400;500;600;700;800&display=swap');

/* ═══════════════════════════════════════
   ROOT & RESET
═══════════════════════════════════════ */
:root {
  --font-ui:   'Sora', sans-serif;
  --font-mono: 'IBM Plex Mono', monospace;

  /* Surface */
  --bg-base:     #0a0c10;
  --bg-surface:  #0f1117;
  --bg-elevated: #141820;
  --bg-overlay:  #1a1f2e;
  --bg-active:   #1e2436;

  /* Border */
  --bd-subtle:  rgba(255,255,255,0.055);
  --bd-default: rgba(255,255,255,0.10);
  --bd-accent:  rgba(99,179,237,0.35);

  /* Text */
  --tx-primary:   #e8ecf4;
  --tx-secondary: #9aa3b8;
  --tx-muted:     #4f5773;

  /* Accent */
  --ac:        #63b3ed;
  --ac-dim:    rgba(99,179,237,0.10);
  --ac-glow:   rgba(99,179,237,0.15);

  /* Brand colors */
  --blue:   #4f9eff;
  --blue-d: rgba(79,158,255,0.12);
  --amber:  #f6c244;
  --amber-d:rgba(246,194,68,0.12);
  --purple: #b794f4;
  --purple-d:rgba(183,148,244,0.12);
  --green:  #48bb78;
  --green-d:rgba(72,187,120,0.12);
  --red:    #fc8181;
  --red-d:  rgba(252,129,129,0.12);

  /* Radius */
  --r-xs: 4px;
  --r-sm: 6px;
  --r-md: 10px;
  --r-lg: 14px;
  --r-xl: 20px;

  /* Motion */
  --ease:  cubic-bezier(0.16, 1, 0.3, 1);
  --t-fast: 120ms;
  --t-base: 200ms;
  --t-slow: 350ms;
}

/* Base reset for dashboard scope */
.dash-root * { box-sizing: border-box; margin: 0; padding: 0; }
.dash-root a { text-decoration: none; color: inherit; }
.dash-root {
  font-family: var(--font-ui);
  color: var(--tx-primary);
  font-size: 13px;
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
  margin-bottom: 32px;
  flex-wrap: wrap;
}

.dh__left { flex: 1; min-width: 0; }

.dh__eyebrow {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  font-family: var(--font-mono);
  font-size: 10px;
  font-weight: 500;
  letter-spacing: 0.14em;
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
  letter-spacing: -0.04em;
  color: var(--tx-primary);
  line-height: 1.1;
}
.dh__sub {
  font-size: 13px;
  color: var(--tx-muted);
  margin-top: 6px;
  font-weight: 400;
}
.dh__sub strong { color: var(--tx-secondary); font-weight: 600; }

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
  gap: 7px;
  padding: 7px 12px;
  background: var(--bg-elevated);
  border: 1px solid var(--bd-subtle);
  border-radius: var(--r-md);
}
.dh__clock-time {
  font-family: var(--font-mono);
  font-size: 14px;
  font-weight: 600;
  color: var(--tx-primary);
  letter-spacing: 0.04em;
  min-width: 44px;
}
.dh__clock-date {
  font-family: var(--font-mono);
  font-size: 10px;
  color: var(--tx-muted);
  letter-spacing: 0.02em;
  border-left: 1px solid var(--bd-subtle);
  padding-left: 8px;
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
.sec-label__num {
  font-family: var(--font-mono);
  font-size: 9px;
  color: var(--tx-muted);
  opacity: .5;
}

/* ═══════════════════════════════════════
   STAT CARDS
═══════════════════════════════════════ */
.kpi-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
  gap: 10px;
  margin-bottom: 32px;
}

.kpi {
  position: relative;
  padding: 18px 18px 14px;
  background: var(--bg-surface);
  border: 1px solid var(--bd-subtle);
  border-radius: var(--r-lg);
  overflow: hidden;
  cursor: default;
  transition:
    border-color var(--t-base) var(--ease),
    transform    var(--t-fast) var(--ease),
    box-shadow   var(--t-base) var(--ease);
}
.kpi:hover {
  transform: translateY(-2px);
  box-shadow: 0 12px 40px rgba(0,0,0,0.35);
}

/* Accent bar top */
.kpi::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 2px;
  border-radius: var(--r-lg) var(--r-lg) 0 0;
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
.kpi--blue  { border-color: rgba(79,158,255,0.18); }
.kpi--amber { border-color: rgba(246,194,68,0.18); }
.kpi--purple{ border-color: rgba(183,148,244,0.18); }
.kpi--green { border-color: rgba(72,187,120,0.18); }

.kpi--blue::before   { background: var(--blue); }
.kpi--amber::before  { background: var(--amber); }
.kpi--purple::before { background: var(--purple); }
.kpi--green::before  { background: var(--green); }

.kpi--blue::after   { background: radial-gradient(circle, rgba(79,158,255,0.08), transparent 70%); }
.kpi--amber::after  { background: radial-gradient(circle, rgba(246,194,68,0.08), transparent 70%); }
.kpi--purple::after { background: radial-gradient(circle, rgba(183,148,244,0.08), transparent 70%); }
.kpi--green::after  { background: radial-gradient(circle, rgba(72,187,120,0.08), transparent 70%); }

.kpi:hover.kpi--blue   { border-color: rgba(79,158,255,0.35); }
.kpi:hover.kpi--amber  { border-color: rgba(246,194,68,0.35); }
.kpi:hover.kpi--purple { border-color: rgba(183,148,244,0.35); }
.kpi:hover.kpi--green  { border-color: rgba(72,187,120,0.35); }

.kpi__row {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  margin-bottom: 16px;
}
.kpi__label {
  font-size: 11px;
  font-weight: 600;
  color: var(--tx-muted);
  letter-spacing: 0.04em;
  text-transform: uppercase;
}
.kpi__icon {
  width: 32px; height: 32px;
  border-radius: var(--r-sm);
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}
.kpi__icon svg { width: 15px; height: 15px; }

.kpi--blue  .kpi__icon { background: var(--blue-d);   color: var(--blue); }
.kpi--amber .kpi__icon { background: var(--amber-d);  color: var(--amber); }
.kpi--purple.kpi__icon { background: var(--purple-d); color: var(--purple); }
.kpi--green .kpi__icon { background: var(--green-d);  color: var(--green); }
/* repeated explicitly for specificity */
.kpi--purple .kpi__icon { background: var(--purple-d); color: var(--purple); }

.kpi__val {
  font-size: 32px;
  font-weight: 800;
  letter-spacing: -0.05em;
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
  font-family: var(--font-mono);
  font-size: 10px;
  font-weight: 600;
  padding: 3px 7px;
  border-radius: var(--r-xs);
}
.kpi__badge svg { width: 9px; height: 9px; }
.kpi__badge--up   { background: rgba(72,187,120,0.12); color: var(--green); }
.kpi__badge--flat { background: rgba(255,255,255,0.05); color: var(--tx-muted); }
.kpi__badge--warn { background: var(--amber-d); color: var(--amber); }

.kpi__sublabel {
  font-size: 10px;
  color: var(--tx-muted);
  font-family: var(--font-mono);
}

/* ═══════════════════════════════════════
   MAIN GRID
═══════════════════════════════════════ */
.main-grid {
  display: grid;
  grid-template-columns: 1fr 340px;
  gap: 12px;
  margin-bottom: 12px;
}
@media (max-width: 1024px) { .main-grid { grid-template-columns: 1fr; } }

/* ═══════════════════════════════════════
   PANEL BASE
═══════════════════════════════════════ */
.panel {
  background: var(--bg-surface);
  border: 1px solid var(--bd-subtle);
  border-radius: var(--r-lg);
  overflow: hidden;
}
.panel__head {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 14px 18px;
  border-bottom: 1px solid var(--bd-subtle);
  gap: 8px;
}
.panel__title {
  font-size: 12.5px;
  font-weight: 700;
  color: var(--tx-primary);
  letter-spacing: -0.01em;
}
.panel__title-sub {
  font-size: 11px;
  color: var(--tx-muted);
  font-weight: 400;
  margin-left: 8px;
}
.panel__action {
  font-family: var(--font-mono);
  font-size: 10px;
  font-weight: 600;
  letter-spacing: 0.06em;
  color: var(--ac);
  padding: 4px 8px;
  border: 1px solid var(--bd-accent);
  border-radius: var(--r-xs);
  transition: background var(--t-fast) var(--ease);
  white-space: nowrap;
}
.panel__action:hover { background: var(--ac-dim); }
.panel__body { padding: 16px 18px; }

/* ═══════════════════════════════════════
   QUICK ACCESS
═══════════════════════════════════════ */
.qa-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 8px;
}
@media (max-width: 640px) { .qa-grid { grid-template-columns: repeat(2, 1fr); } }

.qa-item {
  display: flex;
  flex-direction: column;
  gap: 10px;
  padding: 14px;
  border-radius: var(--r-md);
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
  box-shadow: 0 8px 24px rgba(0,0,0,.30);
}
.qa-item::before {
  content: '';
  position: absolute;
  bottom: -1px; right: -1px;
  width: 40px; height: 40px;
  border-radius: var(--r-md) 0;
  background: var(--bd-subtle);
  transition: background var(--t-base) var(--ease);
}
.qa-item:hover::before { background: var(--bd-accent); }

.qa-item__icon {
  width: 34px; height: 34px;
  border-radius: var(--r-sm);
  display: flex;
  align-items: center;
  justify-content: center;
  background: var(--bg-overlay);
  color: var(--tx-secondary);
  flex-shrink: 0;
  transition: color var(--t-base) var(--ease), background var(--t-base) var(--ease);
}
.qa-item__icon svg { width: 15px; height: 15px; }
.qa-item:hover .qa-item__icon { background: var(--ac-glow); color: var(--ac); }

.qa-item__title {
  font-size: 12px;
  font-weight: 700;
  color: var(--tx-primary);
  line-height: 1.2;
}
.qa-item__desc {
  font-size: 10.5px;
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

/* vertical timeline line */
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

.feed__dot--blue   { color: var(--blue);   background: rgba(79,158,255,.25); }
.feed__dot--green  { color: var(--green);  background: rgba(72,187,120,.25); }
.feed__dot--amber  { color: var(--amber);  background: rgba(246,194,68,.25); }
.feed__dot--purple { color: var(--purple); background: rgba(183,148,244,.25); }
.feed__dot--red    { color: var(--red);    background: rgba(252,129,129,.25); }

.feed__body { flex: 1; min-width: 0; }
.feed__action {
  font-size: 12px;
  color: var(--tx-secondary);
  line-height: 1.5;
}
.feed__action strong { color: var(--tx-primary); font-weight: 600; }
.feed__action em {
  font-style: normal;
  font-family: var(--font-mono);
  font-size: 10.5px;
  color: var(--ac);
  background: var(--ac-dim);
  padding: 1px 5px;
  border-radius: 3px;
}
.feed__meta {
  display: flex;
  align-items: center;
  gap: 8px;
  margin-top: 3px;
}
.feed__time {
  font-family: var(--font-mono);
  font-size: 10px;
  color: var(--tx-muted);
}
.feed__type {
  font-size: 9.5px;
  font-weight: 600;
  letter-spacing: 0.08em;
  text-transform: uppercase;
  padding: 1px 6px;
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
  font-size: 12px;
}
.feed__empty svg {
  width: 32px; height: 32px;
  color: var(--tx-muted);
  opacity: .4;
  margin-bottom: 10px;
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
  font-size: 11px;
  color: var(--tx-muted);
  flex-shrink: 0;
}
.sysinfo__val {
  font-family: var(--font-mono);
  font-size: 10.5px;
  color: var(--tx-secondary);
  text-align: right;
}

.sys-badge {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  font-family: var(--font-mono);
  font-size: 9.5px;
  font-weight: 700;
  letter-spacing: 0.05em;
  padding: 3px 8px;
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
  font-family: var(--font-mono);
  font-size: 9px;
  font-weight: 600;
  letter-spacing: 0.16em;
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
.pbar-label { font-size: 11px; color: var(--tx-muted); }
.pbar-pct {
  font-family: var(--font-mono);
  font-size: 10px;
  color: var(--tx-secondary);
}
.pbar-track {
  height: 3px;
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
.pbar-fill::after {
  content: '';
  position: absolute;
  right: 0; top: 0; bottom: 0;
  width: 8px;
  background: rgba(255,255,255,.3);
  border-radius: 99px;
  filter: blur(2px);
}
.pbar-fill--blue   { background: linear-gradient(to right, rgba(79,158,255,.5), var(--blue)); }
.pbar-fill--amber  { background: linear-gradient(to right, rgba(246,194,68,.5), var(--amber)); }
.pbar-fill--green  { background: linear-gradient(to right, rgba(72,187,120,.5), var(--green)); }

/* ═══════════════════════════════════════
   BOTTOM ROW (second main grid)
═══════════════════════════════════════ */
.bottom-grid {
  display: grid;
  grid-template-columns: 1fr 340px;
  gap: 12px;
}
@media (max-width: 1024px) { .bottom-grid { grid-template-columns: 1fr; } }

/* ═══════════════════════════════════════
   ANGGOTA TABLE (compact)
═══════════════════════════════════════ */
.atbl { width: 100%; border-collapse: collapse; }
.atbl th {
  font-family: var(--font-mono);
  font-size: 9.5px;
  font-weight: 600;
  letter-spacing: 0.12em;
  text-transform: uppercase;
  color: var(--tx-muted);
  text-align: left;
  padding: 0 10px 10px 0;
  border-bottom: 1px solid var(--bd-subtle);
}
.atbl td {
  padding: 10px 10px 10px 0;
  border-bottom: 1px solid var(--bd-subtle);
  font-size: 12px;
  color: var(--tx-secondary);
  vertical-align: middle;
}
.atbl tr:last-child td { border-bottom: none; }
.atbl tr:hover td { background: rgba(255,255,255,.015); }

.atbl__name { color: var(--tx-primary); font-weight: 600; display: block; margin-bottom: 1px; }
.atbl__nim  { font-family: var(--font-mono); font-size: 10px; color: var(--tx-muted); }

.status-chip {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  font-size: 10px;
  font-weight: 600;
  padding: 2px 7px;
  border-radius: var(--r-xs);
  white-space: nowrap;
}
.status-chip__dot { width: 5px; height: 5px; border-radius: 50%; background: currentColor; }
.chip--aktif  { background: var(--green-d);  color: var(--green); }
.chip--pending{ background: var(--amber-d);  color: var(--amber); }
.chip--tolak  { background: var(--red-d);    color: var(--red); }
.chip--non    { background: rgba(255,255,255,.05); color: var(--tx-muted); }

.atbl__empty {
  text-align: center;
  padding: 30px;
  color: var(--tx-muted);
  font-size: 12px;
  font-style: italic;
}

/* ═══════════════════════════════════════
   PAB QUEUE COMPACT LIST
═══════════════════════════════════════ */
.pab-list { display: flex; flex-direction: column; gap: 0; }
.pab-item {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 10px 0;
  border-bottom: 1px solid var(--bd-subtle);
}
.pab-item:last-child { border-bottom: none; }
.pab-item__ava {
  width: 32px; height: 32px;
  border-radius: var(--r-sm);
  background: var(--bg-overlay);
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: var(--font-mono);
  font-size: 11px;
  font-weight: 700;
  color: var(--ac);
  flex-shrink: 0;
  text-transform: uppercase;
}
.pab-item__info { flex: 1; min-width: 0; }
.pab-item__name {
  font-size: 12px;
  font-weight: 600;
  color: var(--tx-primary);
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.pab-item__sub {
  font-family: var(--font-mono);
  font-size: 10px;
  color: var(--tx-muted);
  margin-top: 1px;
}
.pab-item__since {
  font-family: var(--font-mono);
  font-size: 10px;
  color: var(--tx-muted);
  flex-shrink: 0;
}
.pab-empty {
  text-align: center;
  padding: 30px;
  font-size: 12px;
  color: var(--tx-muted);
  font-style: italic;
}

/* ═══════════════════════════════════════
   RESPONSIVE
═══════════════════════════════════════ */
@media (max-width: 640px) {
  .kpi-grid  { grid-template-columns: repeat(2, 1fr); }
  .dh__clock { display: none; }
  .dh__title { font-size: 20px; }
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
      <div>
        <div class="dh__clock-time" id="js-clock-time">--:--</div>
      </div>
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
      <span class="kpi__icon">
        <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <circle cx="5.5" cy="5" r="2.5"/>
          <path d="M1 14c0-2.485 2.015-4.5 4.5-4.5S10 11.515 10 14"/>
          <circle cx="12" cy="5.5" r="2"/>
          <path d="M14.5 12.5c0-1.657-1.12-3-2.5-3"/>
        </svg>
      </span>
    </div>
    <div class="kpi__val"><?= number_format($stats['total_anggota'] ?? 0) ?></div>
    <div class="kpi__footer">
      <span class="kpi__badge kpi__badge--up">
        <svg viewBox="0 0 10 10" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true"><path d="M2 8L8 2M8 2H4M8 2v4"/></svg>
        Terdaftar
      </span>
      <span class="kpi__sublabel">total</span>
    </div>
  </div>

  <!-- Antrian PAB -->
  <div class="kpi kpi--amber">
    <div class="kpi__row">
      <span class="kpi__label">Antrian PAB</span>
      <span class="kpi__icon" style="background:var(--amber-d);color:var(--amber);">
        <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <rect x="2" y="2" width="12" height="12" rx="1.5"/>
          <path d="M5 8l2 2 4-4"/>
        </svg>
      </span>
    </div>
    <div class="kpi__val"><?= number_format($stats['pending_pab'] ?? 0) ?></div>
    <div class="kpi__footer">
      <span class="kpi__badge kpi__badge--warn">
        <svg viewBox="0 0 10 10" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true"><circle cx="5" cy="5" r="4"/><path d="M5 3v2.5"/><circle cx="5" cy="7" r=".5" fill="currentColor"/></svg>
        Menunggu
      </span>
      <span class="kpi__sublabel">verifikasi</span>
    </div>
  </div>

  <!-- Pending Manual -->
  <div class="kpi kpi--purple">
    <div class="kpi__row">
      <span class="kpi__label">Pending Manual</span>
      <span class="kpi__icon" style="background:var(--purple-d);color:var(--purple);">
        <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <circle cx="8" cy="8" r="6"/>
          <path d="M8 5v3.5l2 1.5"/>
        </svg>
      </span>
    </div>
    <div class="kpi__val"><?= number_format($stats['pending_manual'] ?? 0) ?></div>
    <div class="kpi__footer">
      <span class="kpi__badge kpi__badge--flat">
        <svg viewBox="0 0 10 10" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true"><path d="M2 5h6M6 3l2 2-2 2"/></svg>
        Perlu Aksi
      </span>
      <span class="kpi__sublabel">entri</span>
    </div>
  </div>

  <!-- Sesi Absensi -->
  <div class="kpi kpi--green">
    <div class="kpi__row">
      <span class="kpi__label">Sesi Absensi</span>
      <span class="kpi__icon" style="background:var(--green-d);color:var(--green);">
        <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <rect x="2" y="2.5" width="12" height="12" rx="1.5"/>
          <path d="M2 6.5h12M5.5 1v3.5M10.5 1v3.5"/>
        </svg>
      </span>
    </div>
    <div class="kpi__val"><?= number_format($stats['total_sesi'] ?? 0) ?></div>
    <div class="kpi__footer">
      <span class="kpi__badge kpi__badge--up">
        <svg viewBox="0 0 10 10" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true"><path d="M2 8L8 2M8 2H4M8 2v4"/></svg>
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
            'icon'  => '<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="12" height="12" rx="1.5"/><path d="M5 8l2 2 4-4"/></svg>',
          ],
          [
            'href'  => '/admin/anggota/tambah',
            'title' => 'Tambah Anggota',
            'desc'  => 'Input data manual',
            'icon'  => '<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="6" cy="5.5" r="2.5"/><path d="M1.5 13.5c0-2.485 2.015-4.5 4.5-4.5"/><path d="M12 8v5M9.5 10.5H14.5"/></svg>',
          ],
          [
            'href'  => '/admin/absensi',
            'title' => 'Kelola Absensi',
            'desc'  => 'Buat sesi & daftar hadir',
            'icon'  => '<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2.5" width="12" height="12" rx="1.5"/><path d="M2 6.5h12M5.5 1v3.5M10.5 1v3.5"/></svg>',
          ],
          [
            'href'  => '/admin/anggota',
            'title' => 'Data Anggota',
            'desc'  => 'Lihat & kelola semua',
            'icon'  => '<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="5.5" cy="5" r="2.5"/><path d="M1 14c0-2.485 2.015-4.5 4.5-4.5S10 11.515 10 14"/><circle cx="12" cy="5.5" r="2"/></svg>',
          ],
          [
            'href'  => '/admin/settings',
            'title' => 'Pengaturan CMS',
            'desc'  => 'Update konten website',
            'icon'  => '<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="8" r="2.25"/><path d="M8 1.5v1.5M8 13v1.5M1.5 8H3M13 8h1.5M3.4 3.4l1.05 1.05M11.55 11.55l1.05 1.05M3.4 12.6l1.05-1.05M11.55 4.45l1.05-1.05"/></svg>',
          ],
          [
            'href'  => '/admin/laporan',
            'title' => 'Laporan & Ekspor',
            'desc'  => 'Cetak & unduh data',
            'icon'  => '<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 2h10a1 1 0 011 1v10a1 1 0 01-1 1H3a1 1 0 01-1-1V3a1 1 0 011-1z"/><path d="M5 6h6M5 8.5h4M5 11h3"/></svg>',
          ],
        ];
        foreach ($links as $l):
        ?>
        <a href="<?= BASE_URL . htmlspecialchars($l['href']) ?>" class="qa-item">
          <span class="qa-item__icon" aria-hidden="true"><?= $l['icon'] ?></span>
          <span class="qa-item__title"><?= htmlspecialchars($l['title']) ?></span>
          <span class="qa-item__desc"><?= htmlspecialchars($l['desc']) ?></span>
        </a>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

  <!-- RIGHT: Activity Feed + System Info -->
  <div style="display:flex;flex-direction:column;gap:12px;">

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
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true" style="display:block;margin:0 auto 10px;">
              <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
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
<div class="sec-label" style="margin-top:12px;">
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
    <div class="panel__body" style="padding:0 18px;">
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