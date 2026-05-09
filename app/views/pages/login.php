<?php // app/views/pages/login.php ?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Masuk — <?= htmlspecialchars($settings['org_name']['value'] ?? APP_NAME) ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,500;1,400;1,500&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
<style>
/* ============================================================
   LOGIN PAGE — isolated scope: lp-*
   Reuses tokens from custom.css where possible.
   ============================================================ */

/* ── Scope reset ── */
#lp-root, #lp-root * { box-sizing: border-box; margin: 0; padding: 0; }
#lp-root a { text-decoration: none; color: inherit; }
#lp-root button { font-family: inherit; cursor: pointer; border: none; background: none; }

html.lp-page, html.lp-page body {
  height: 100%; width: 100%;
  overflow-x: hidden;
  background: #050b18 !important;
  color: #e2e8f5 !important;
  font-family: 'Sora', system-ui, sans-serif !important;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}

/* ── Local design tokens (extend custom.css globals) ── */
#lp-root {
  --lp-bg:            #050b18;
  --lp-bg2:           #08101f;
  --lp-bg3:           #0c1628;
  --lp-surface:       rgba(14, 28, 52, 0.85);

  /* Accent: cyan (matches --color-accent in custom.css) */
  --lp-cyan:          #06b6d4;
  --lp-cyan-lt:       #22d3ee;
  --lp-cyan-dk:       #0891b2;
  --lp-cyan-bg:       rgba(6, 182, 212, 0.08);
  --lp-cyan-ring:     rgba(6, 182, 212, 0.20);

  /* Admin accent: indigo */
  --lp-indigo:        #818cf8;
  --lp-indigo-lt:     #a5b4fc;
  --lp-indigo-bg:     rgba(129, 140, 248, 0.08);
  --lp-indigo-ring:   rgba(129, 140, 248, 0.22);

  /* Text */
  --lp-text:          #e2e8f5;
  --lp-text2:         rgba(226, 232, 245, 0.60);
  --lp-text3:         rgba(226, 232, 245, 0.32);
  --lp-text4:         rgba(226, 232, 245, 0.16);

  /* Borders */
  --lp-border:        rgba(226, 232, 245, 0.07);
  --lp-border2:       rgba(226, 232, 245, 0.11);
  --lp-border3:       rgba(226, 232, 245, 0.18);

  /* Semantic */
  --lp-green:         #10b981;
  --lp-green-bg:      rgba(16, 185, 129, 0.08);
  --lp-red:           #ef4444;
  --lp-red-bg:        rgba(239, 68, 68, 0.08);

  /* Typography */
  --lp-serif:         'Playfair Display', Georgia, serif;
  --lp-mono:          'JetBrains Mono', monospace;
  --lp-sans:          'Sora', system-ui, sans-serif;

  /* Radius — mirrors custom.css */
  --lp-r:             0.5rem;
  --lp-r2:            0.75rem;
  --lp-r3:            1rem;

  /* Easing */
  --lp-ease:          cubic-bezier(0.22, 1, 0.36, 1);
  --lp-ease2:         cubic-bezier(0.16, 1, 0.3, 1);

  display: flex;
  width: 100%;
  min-height: 100vh;
  min-height: 100dvh;
  background: var(--lp-bg);
  position: relative;
}

/* ══════════════════════════════════════════
   SIDEBAR
══════════════════════════════════════════ */
.lp-sidebar {
  width: 400px;
  min-width: 400px;
  flex-shrink: 0;
  background: var(--lp-bg2);
  border-right: 1px solid var(--lp-border);
  position: sticky;
  top: 0;
  height: 100vh;
  height: 100dvh;
  overflow: hidden;
  display: none;
  flex-direction: column;
}
@media (min-width: 1080px) { .lp-sidebar { display: flex; } }

/* Top accent line */
.lp-sidebar::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0; height: 1px;
  background: linear-gradient(90deg, transparent, var(--lp-cyan), transparent);
  opacity: 0.4;
  z-index: 1;
}

/* Decorative orbs */
.lp-sb-orb {
  position: absolute;
  border-radius: 50%;
  pointer-events: none;
}
.lp-sb-orb1 {
  top: -100px; left: -80px;
  width: 340px; height: 340px;
  background: radial-gradient(circle, rgba(6,182,212,0.07) 0%, transparent 65%);
}
.lp-sb-orb2 {
  bottom: 60px; right: -100px;
  width: 280px; height: 280px;
  background: radial-gradient(circle, rgba(129,140,248,0.05) 0%, transparent 65%);
}

/* Fine grid */
.lp-sb-grid {
  position: absolute; inset: 0; pointer-events: none;
  background-image:
    linear-gradient(rgba(226,232,245,0.018) 1px, transparent 1px),
    linear-gradient(90deg, rgba(226,232,245,0.018) 1px, transparent 1px);
  background-size: 36px 36px;
}

.lp-sb-inner {
  position: relative; z-index: 2;
  display: flex; flex-direction: column;
  height: 100%;
  padding: 2.25rem 2.25rem 2rem;
  overflow-y: auto;
  overflow-x: hidden;
  scrollbar-width: thin;
  scrollbar-color: var(--lp-border2) transparent;
}
.lp-sb-inner::-webkit-scrollbar { width: 3px; }
.lp-sb-inner::-webkit-scrollbar-thumb { background: var(--lp-border2); border-radius: 9999px; }

/* ── Brand ── */
.lp-brand {
  display: flex; align-items: center; gap: 11px;
  margin-bottom: 2.75rem;
}
.lp-brand-logo {
  width: 38px; height: 38px; flex-shrink: 0;
  background: var(--lp-cyan-bg);
  border: 1px solid rgba(6,182,212,0.18);
  border-radius: var(--lp-r2);
  display: flex; align-items: center; justify-content: center;
  overflow: hidden;
  position: relative;
}
.lp-brand-logo::after {
  content: '';
  position: absolute; inset: 0;
  background: linear-gradient(135deg, rgba(6,182,212,0.12) 0%, transparent 60%);
}
.lp-brand-logo img {
  width: 100%; height: 100%; object-fit: contain; padding: 8px;
  filter: brightness(0) invert(1);
  position: relative; z-index: 1;
}
.lp-brand-logo-fb { display: none; color: var(--lp-cyan-lt); position: relative; z-index: 1; }
.lp-brand-logo-fb svg { width: 16px; height: 16px; }
.lp-brand-name {
  font-size: 0.875rem; font-weight: 600;
  color: var(--lp-text);
  letter-spacing: -0.02em;
  line-height: 1.2;
}
.lp-brand-sub {
  font-family: var(--lp-mono);
  font-size: 0.575rem; color: var(--lp-text3);
  letter-spacing: 0.10em; text-transform: uppercase;
  margin-top: 2px;
}

/* ── Sidebar headline ── */
.lp-sb-eyebrow {
  font-family: var(--lp-mono);
  font-size: 0.575rem; font-weight: 500;
  color: var(--lp-cyan-lt);
  letter-spacing: 0.18em; text-transform: uppercase;
  margin-bottom: 0.875rem;
  display: flex; align-items: center; gap: 10px;
}
.lp-sb-eyebrow::before {
  content: '';
  display: block;
  width: 18px; height: 1px;
  background: var(--lp-cyan);
  flex-shrink: 0;
}

.lp-sb-hl {
  font-family: var(--lp-serif);
  font-size: 2.4rem; line-height: 1.1; font-weight: 400;
  color: var(--lp-text);
  margin-bottom: 2.25rem;
  letter-spacing: -0.01em;
}
.lp-sb-hl em { font-style: italic; color: var(--lp-cyan-lt); }

/* ── Stats ── */
.lp-stats {
  display: grid; grid-template-columns: 1fr 1fr;
  gap: 1px;
  background: var(--lp-border);
  border: 1px solid var(--lp-border);
  border-radius: var(--lp-r2);
  overflow: hidden;
  margin-bottom: 2.25rem;
}
.lp-stat {
  background: rgba(8,16,31,0.95);
  padding: 1.125rem 1.125rem 1rem;
  position: relative; overflow: hidden;
  transition: background 0.2s;
}
.lp-stat::before {
  content: '';
  position: absolute; top: 0; left: 0; right: 0; height: 2px;
  background: linear-gradient(90deg, var(--lp-cyan-dk), var(--lp-cyan));
  transform: scaleX(0); transform-origin: left;
  transition: transform 0.3s var(--lp-ease);
}
.lp-stat:hover { background: rgba(14,28,52,0.98); }
.lp-stat:hover::before { transform: scaleX(1); }
.lp-stat-n {
  font-family: var(--lp-serif);
  font-size: 2rem; line-height: 1; font-weight: 400;
  color: var(--lp-text); margin-bottom: 5px;
  letter-spacing: -0.02em;
}
.lp-stat-l {
  font-family: var(--lp-mono);
  font-size: 0.54rem; color: var(--lp-text3);
  letter-spacing: 0.10em; text-transform: uppercase;
}

/* ── Feature list ── */
.lp-feats { flex: 1; }
.lp-feat {
  display: flex; align-items: flex-start; gap: 13px;
  padding: 0.9rem 0;
  border-bottom: 1px solid var(--lp-border);
  transition: opacity 0.18s;
}
.lp-feat:last-child { border-bottom: none; }
.lp-feat:hover { opacity: 0.85; }
.lp-feat-ico {
  width: 30px; height: 30px; flex-shrink: 0;
  background: var(--lp-cyan-bg);
  border: 1px solid rgba(6,182,212,0.14);
  border-radius: var(--lp-r);
  display: flex; align-items: center; justify-content: center;
  margin-top: 1px;
}
.lp-feat-ico svg { width: 13px; height: 13px; color: var(--lp-cyan-lt); }
.lp-feat-t {
  font-size: 0.78rem; font-weight: 600;
  color: var(--lp-text2); margin-bottom: 2px;
  letter-spacing: -0.01em;
}
.lp-feat-d {
  font-size: 0.695rem; color: var(--lp-text3); line-height: 1.65;
}

/* ── Sidebar footer ── */
.lp-sb-foot {
  margin-top: 1.5rem;
  padding-top: 1.25rem;
  border-top: 1px solid var(--lp-border);
  display: flex; align-items: center; justify-content: space-between;
}
.lp-status {
  display: flex; align-items: center; gap: 7px;
  font-family: var(--lp-mono); font-size: 0.55rem;
  color: var(--lp-text4); letter-spacing: 0.07em; text-transform: uppercase;
}
.lp-dot {
  width: 5px; height: 5px; border-radius: 50%;
  background: var(--lp-green);
  box-shadow: 0 0 6px rgba(16,185,129,0.6);
  animation: lpPulse 3s ease-in-out infinite;
  flex-shrink: 0;
}
@keyframes lpPulse { 0%,100%{opacity:1} 50%{opacity:0.25} }
.lp-copy {
  font-family: var(--lp-mono); font-size: 0.54rem; color: var(--lp-text4);
}

/* ══════════════════════════════════════════
   MAIN
══════════════════════════════════════════ */
.lp-main {
  flex: 1;
  display: flex; flex-direction: column;
  overflow-y: auto; overflow-x: hidden;
  background: var(--lp-bg);
  min-height: 100vh; min-height: 100dvh;
  position: relative;
}

/* Background decorations */
.lp-bg-wrap { position: absolute; inset: 0; pointer-events: none; overflow: hidden; z-index: 0; }
.lp-bg-g1 {
  position: absolute; top: -140px; right: -80px;
  width: 460px; height: 460px;
  background: radial-gradient(circle, rgba(6,182,212,0.07) 0%, transparent 65%);
}
.lp-bg-g2 {
  position: absolute; bottom: -80px; left: 8%;
  width: 320px; height: 320px;
  background: radial-gradient(circle, rgba(129,140,248,0.04) 0%, transparent 65%);
}
.lp-bg-grid {
  position: absolute; inset: 0;
  background-image:
    linear-gradient(rgba(226,232,245,0.013) 1px, transparent 1px),
    linear-gradient(90deg, rgba(226,232,245,0.013) 1px, transparent 1px);
  background-size: 48px 48px;
  -webkit-mask-image: radial-gradient(ellipse 70% 65% at 50% 35%, black 20%, transparent 100%);
  mask-image: radial-gradient(ellipse 70% 65% at 50% 35%, black 20%, transparent 100%);
}
.lp-bg-corner {
  position: absolute; top: 2rem; right: 2rem;
  width: 72px; height: 72px;
  border-top: 1px solid rgba(6,182,212,0.15);
  border-right: 1px solid rgba(6,182,212,0.15);
  border-radius: 0 var(--lp-r2) 0 0;
}
.lp-bg-corner2 {
  position: absolute; bottom: 3.5rem; left: 2rem;
  width: 52px; height: 52px;
  border-bottom: 1px solid rgba(6,182,212,0.10);
  border-left: 1px solid rgba(6,182,212,0.10);
}

/* Center wrapper */
.lp-center {
  position: relative; z-index: 1;
  flex: 1;
  display: flex; flex-direction: column;
  align-items: center; justify-content: center;
  padding: 2.75rem 1.75rem 5rem;
  width: 100%;
}

/* ── Mobile brand ── */
.lp-mbrand {
  display: flex; align-items: center; gap: 11px;
  margin-bottom: 2rem;
  animation: lpUp 0.5s var(--lp-ease) both;
}
@media (min-width: 1080px) { .lp-mbrand { display: none; } }
.lp-mbrand-logo {
  width: 36px; height: 36px; flex-shrink: 0;
  background: var(--lp-cyan-bg);
  border: 1px solid rgba(6,182,212,0.20);
  border-radius: var(--lp-r2);
  display: flex; align-items: center; justify-content: center;
  overflow: hidden;
}
.lp-mbrand-logo img {
  width: 100%; height: 100%; object-fit: contain; padding: 7px;
  filter: brightness(0) invert(1);
}
.lp-mbrand-logo-fb { display: none; color: var(--lp-cyan-lt); }
.lp-mbrand-logo-fb svg { width: 14px; height: 14px; }
.lp-mbrand-name { font-size: 0.875rem; font-weight: 600; color: var(--lp-text); letter-spacing: -0.01em; }
.lp-mbrand-sub {
  font-family: var(--lp-mono); font-size: 0.555rem;
  color: var(--lp-text3); letter-spacing: 0.08em; text-transform: uppercase; margin-top: 1px;
}

/* ── Card ── */
.lp-card { width: 100%; max-width: 440px; }

/* ── Card header ── */
.lp-head {
  margin-bottom: 1.75rem;
  animation: lpUp 0.5s var(--lp-ease) 0.04s both;
}
.lp-kicker {
  display: inline-flex; align-items: center; gap: 6px;
  font-family: var(--lp-mono); font-size: 0.575rem; font-weight: 500;
  color: var(--lp-cyan-lt); letter-spacing: 0.14em; text-transform: uppercase;
  margin-bottom: 0.875rem;
  padding: 4px 10px;
  background: var(--lp-cyan-bg);
  border: 1px solid rgba(6,182,212,0.16);
  border-radius: 9999px;
}
.lp-kicker::before {
  content: '';
  width: 5px; height: 5px; border-radius: 50%;
  background: var(--lp-cyan);
  box-shadow: 0 0 5px rgba(6,182,212,0.7);
  flex-shrink: 0;
}
.lp-title {
  font-family: var(--lp-serif);
  font-size: 2.5rem; font-weight: 400;
  color: var(--lp-text); line-height: 1.05;
  letter-spacing: -0.02em;
  margin-bottom: 0.5rem;
}
.lp-title em { font-style: italic; color: var(--lp-cyan-lt); }
.lp-sub {
  font-size: 0.815rem; color: var(--lp-text3); line-height: 1.75;
}

/* ── Alerts — reuses .alert pattern from custom.css ── */
.lp-alert {
  display: flex; align-items: flex-start; gap: 10px;
  padding: 0.75rem 0.875rem;
  border-radius: var(--lp-r);
  font-size: 0.79rem; line-height: 1.55;
  border: 1px solid transparent;
  margin-bottom: 1.375rem;
}
.lp-alert svg { width: 14px; height: 14px; flex-shrink: 0; margin-top: 2px; }
.lp-alert-error {
  background: rgba(239,68,68,0.08);
  border-color: rgba(239,68,68,0.22);
  color: #fca5a5;
  animation: lpUp 0.22s var(--lp-ease) both;
}
.lp-alert-success {
  background: rgba(16,185,129,0.08);
  border-color: rgba(16,185,129,0.22);
  color: #6ee7b7;
  animation: lpUp 0.22s var(--lp-ease) both;
}

/* ── Tab toggle ── */
.lp-toggle-wrap {
  display: flex;
  background: rgba(8,16,31,0.90);
  border: 1px solid var(--lp-border2);
  border-radius: var(--lp-r2);
  padding: 3px; gap: 3px;
  margin-bottom: 1.75rem;
  animation: lpUp 0.5s var(--lp-ease) 0.08s both;
  position: relative;
}

/* Sliding indicator */
.lp-toggle-ind {
  position: absolute;
  top: 3px; bottom: 3px;
  width: calc(50% - 4.5px);
  left: 3px;
  border-radius: calc(var(--lp-r2) - 2px);
  transition: transform 0.36s var(--lp-ease2), background 0.25s, border-color 0.25s;
  z-index: 0;
  pointer-events: none;
}
.lp-toggle-ind.on-member {
  background: rgba(6,182,212,0.12);
  border: 1px solid rgba(6,182,212,0.20);
  transform: translateX(0);
}
.lp-toggle-ind.on-admin {
  background: rgba(129,140,248,0.10);
  border: 1px solid rgba(129,140,248,0.18);
  transform: translateX(calc(100% + 3px));
}

.lp-tab {
  flex: 1; display: flex; align-items: center; justify-content: center; gap: 6px;
  padding: 9px 12px;
  font-size: 0.78rem; font-weight: 400;
  color: var(--lp-text3);
  border-radius: calc(var(--lp-r2) - 3px);
  transition: color 0.2s;
  cursor: pointer; border: none; background: none;
  white-space: nowrap;
  position: relative; z-index: 1;
}
.lp-tab svg { width: 12px; height: 12px; flex-shrink: 0; }
.lp-tab:hover:not(.lp-tab-on) { color: var(--lp-text2); }
.lp-tab.lp-tab-on { font-weight: 600; }
.lp-tab.lp-tab-on[data-t="member"] { color: var(--lp-cyan-lt); }
.lp-tab.lp-tab-on[data-t="admin"]  { color: var(--lp-indigo-lt); }

/* ── Slide viewport ── */
.lp-vp {
  overflow: hidden; width: 100%;
  animation: lpUp 0.5s var(--lp-ease) 0.12s both;
}
.lp-track {
  display: flex;
  transition: transform 0.40s var(--lp-ease2);
  will-change: transform;
  align-items: flex-start;
}
.lp-slide { min-width: 100%; flex-shrink: 0; }

/* ── Form fields — mirrors .form-group from custom.css ── */
.lp-fields { display: flex; flex-direction: column; gap: 1.125rem; }
.lp-field  { display: flex; flex-direction: column; gap: 5px; }

.lp-label {
  display: flex; align-items: center; justify-content: space-between;
  font-size: 0.765rem; font-weight: 600;
  color: var(--lp-text2);
  letter-spacing: -0.01em;
}
.lp-label-note {
  font-size: 0.64rem; font-weight: 400;
  color: var(--lp-text4);
  font-family: var(--lp-mono); letter-spacing: 0.03em;
}

.lp-fw { position: relative; display: flex; align-items: center; }
.lp-fi {
  position: absolute; left: 12px; pointer-events: none;
  color: var(--lp-text4);
  display: flex; align-items: center;
  transition: color 0.16s;
}
.lp-fi svg { width: 14px; height: 14px; }

/* ── Input — mirrors .form-input from custom.css ── */
.lp-inp {
  width: 100%;
  height: 46px;
  background: rgba(8,16,31,0.85) !important;
  border: 1px solid var(--lp-border2) !important;
  border-radius: var(--lp-r) !important;
  padding: 0 42px !important;
  color: var(--lp-text) !important;
  font-size: 0.875rem !important;
  font-family: var(--lp-sans) !important;
  font-weight: 400 !important;
  outline: none !important;
  box-shadow: none !important;
  transition: border-color 0.15s, box-shadow 0.15s, background 0.15s;
  appearance: none;
}
.lp-inp::placeholder { color: var(--lp-text4) !important; }
.lp-inp:hover:not(:disabled) {
  border-color: var(--lp-border3) !important;
  background: rgba(12,22,40,0.90) !important;
}

/* Member — cyan focus */
#lp-panel-m .lp-inp:focus {
  border-color: var(--lp-cyan) !important;
  box-shadow: 0 0 0 3px var(--lp-cyan-ring) !important;
  background: rgba(6,182,212,0.03) !important;
}
#lp-panel-m .lp-fw:focus-within .lp-fi { color: var(--lp-cyan-lt); }

/* Admin — indigo focus */
#lp-panel-a .lp-inp:focus {
  border-color: var(--lp-indigo) !important;
  box-shadow: 0 0 0 3px var(--lp-indigo-ring) !important;
  background: rgba(129,140,248,0.03) !important;
}
#lp-panel-a .lp-fw:focus-within .lp-fi { color: var(--lp-indigo-lt); }

.lp-inp.is-invalid {
  border-color: var(--lp-red) !important;
  box-shadow: 0 0 0 3px rgba(239,68,68,0.15) !important;
}

/* Eye toggle */
.lp-eye {
  position: absolute; right: 10px;
  background: none !important; border: none !important; padding: 5px;
  color: var(--lp-text4); border-radius: 5px;
  display: flex; align-items: center;
  transition: color 0.14s, background 0.14s;
}
.lp-eye:hover { color: var(--lp-text2); background: rgba(226,232,245,0.05) !important; }
.lp-eye svg { width: 14px; height: 14px; }

/* Form hints — mirrors .form-hint from custom.css */
.lp-hint {
  font-size: 0.68rem; min-height: 14px;
  display: flex; align-items: center; gap: 4px;
  color: var(--lp-text4);
  font-family: var(--lp-mono);
  transition: color 0.15s;
}
.lp-hint-ok  { color: var(--lp-green); }
.lp-hint-err { color: #fca5a5; }

/* ── Password strength ── */
.lp-pws { display: none; margin-top: 5px; }
.lp-pws-bar {
  height: 2px; background: var(--lp-border);
  border-radius: 9999px; overflow: hidden; margin-bottom: 6px;
}
.lp-pws-fill { height: 100%; border-radius: 9999px; width: 0; transition: width 0.32s var(--lp-ease), background 0.22s; }
.lp-pws-row {
  display: flex; align-items: center; justify-content: space-between;
  font-family: var(--lp-mono); font-size: 0.585rem;
}
.lp-pws-dots { display: flex; gap: 4px; }
.lp-pws-dot {
  width: 4px; height: 4px; border-radius: 50%;
  background: var(--lp-border); transition: all 0.18s;
}
.lp-pws-dot.on { transform: scale(1.5); }

/* ── Admin notice ── */
.lp-adm-note {
  display: flex; align-items: flex-start; gap: 10px;
  padding: 0.75rem 0.875rem;
  background: var(--lp-indigo-bg);
  border: 1px solid rgba(129,140,248,0.15);
  border-radius: var(--lp-r);
  font-size: 0.755rem;
  color: rgba(165,172,253,0.75);
  line-height: 1.65;
}
.lp-adm-note svg { width: 13px; height: 13px; flex-shrink: 0; margin-top: 2px; color: var(--lp-indigo); }

/* ── Divider ── */
.lp-divider {
  display: flex; align-items: center; gap: 10px;
  font-family: var(--lp-mono); font-size: 0.56rem;
  color: var(--lp-text4); letter-spacing: 0.08em; text-transform: uppercase;
  margin: 0.125rem 0;
}
.lp-divider::before, .lp-divider::after {
  content: ''; flex: 1; height: 1px; background: var(--lp-border);
}

/* ── Submit button — mirrors .btn from custom.css ── */
.lp-btn {
  display: flex !important;
  align-items: center; justify-content: center; gap: 7px;
  width: 100%; height: 48px;
  font-size: 0.875rem !important; font-weight: 600 !important;
  font-family: var(--lp-sans) !important;
  border-radius: var(--lp-r) !important;
  border: none !important; cursor: pointer;
  position: relative; overflow: hidden;
  transition: transform 0.16s var(--lp-ease), box-shadow 0.16s var(--lp-ease), opacity 0.14s;
  letter-spacing: -0.01em;
  margin-top: 0.25rem;
  text-decoration: none !important;
}
.lp-btn::before {
  content: '';
  position: absolute; top: 0; left: -100%; width: 100%; height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255,255,255,0.07), transparent);
  transition: left 0.45s;
  pointer-events: none;
}
.lp-btn:hover::before { left: 100%; }
.lp-btn:hover:not(:disabled) { transform: translateY(-1px); }
.lp-btn:active:not(:disabled) { transform: scale(0.985); }
.lp-btn:disabled { opacity: 0.35; cursor: not-allowed; }

/* Member — cyan */
.lp-btn-m {
  background: linear-gradient(135deg, #0891b2, #06b6d4, #0891b2) !important;
  background-size: 200% 200% !important;
  background-position: 0% 50% !important;
  box-shadow: 0 4px 18px rgba(8,145,178,0.35), 0 1px 4px rgba(0,0,0,0.4);
  color: #fff !important;
  transition: transform 0.16s var(--lp-ease), box-shadow 0.16s var(--lp-ease),
              background-position 0.38s var(--lp-ease), opacity 0.14s;
}
.lp-btn-m:hover:not(:disabled) {
  background-position: 100% 50% !important;
  box-shadow: 0 8px 28px rgba(6,182,212,0.42), 0 2px 6px rgba(0,0,0,0.35);
}

/* Admin — indigo */
.lp-btn-a {
  background: linear-gradient(135deg, #4f46e5, #818cf8, #6366f1) !important;
  background-size: 200% 200% !important;
  background-position: 0% 50% !important;
  box-shadow: 0 4px 18px rgba(99,102,241,0.30), 0 1px 4px rgba(0,0,0,0.4);
  color: #fff !important;
  transition: transform 0.16s var(--lp-ease), box-shadow 0.16s var(--lp-ease),
              background-position 0.38s var(--lp-ease), opacity 0.14s;
}
.lp-btn-a:hover:not(:disabled) {
  background-position: 100% 50% !important;
  box-shadow: 0 8px 28px rgba(129,140,248,0.40), 0 2px 6px rgba(0,0,0,0.35);
}

/* Spinner (mirrors .btn.is-loading from custom.css) */
.lp-btn-sp { display: none; }
.lp-btn-sp svg { width: 16px; height: 16px; animation: lpSpin 0.65s linear infinite; }
@keyframes lpSpin { to { transform: rotate(360deg); } }

/* Arrow */
.lp-btn-arr {
  display: flex; align-items: center;
  opacity: 0.50; transition: transform 0.20s, opacity 0.20s;
}
.lp-btn-arr svg { width: 14px; height: 14px; }
.lp-btn:hover:not(:disabled) .lp-btn-arr { transform: translateX(3px); opacity: 1; }

/* ── Page footer ── */
.lp-foot {
  margin-top: 1.75rem;
  display: flex; flex-direction: column; align-items: center; gap: 0.75rem;
  animation: lpUp 0.5s var(--lp-ease) 0.18s both;
}
.lp-foot-row {
  display: flex; align-items: center; gap: 5px;
  font-size: 0.80rem; color: var(--lp-text3);
}
.lp-lnk { font-weight: 600; transition: color 0.14s; }
.lp-lnk-cy { color: var(--lp-cyan-lt); }
.lp-lnk-cy:hover { color: #67e8f9; }
.lp-lnk-in { color: var(--lp-indigo-lt); }
.lp-lnk-in:hover { color: #c7d2fe; }
.lp-back {
  display: inline-flex; align-items: center; gap: 5px;
  font-family: var(--lp-mono); font-size: 0.57rem;
  color: var(--lp-text4); letter-spacing: 0.06em; text-transform: uppercase;
  transition: color 0.14s;
}
.lp-back:hover { color: var(--lp-text2); }
.lp-back svg { width: 10px; height: 10px; transition: transform 0.18s; }
.lp-back:hover svg { transform: translateX(-3px); }
.lp-sec-badge {
  display: flex; align-items: center; gap: 6px;
  font-family: var(--lp-mono); font-size: 0.55rem;
  color: var(--lp-text4); letter-spacing: 0.06em; text-transform: uppercase;
}
.lp-sec-badge svg { width: 9px; height: 9px; color: var(--lp-cyan-lt); opacity: 0.45; }

/* ══════════════════════════════════════════
   TICKER
══════════════════════════════════════════ */
.lp-ticker {
  position: fixed; bottom: 0; left: 0; right: 0; z-index: 999;
  height: 30px; overflow: hidden;
  background: rgba(5,11,24,0.96);
  border-top: 1px solid var(--lp-border);
  backdrop-filter: blur(16px);
  -webkit-backdrop-filter: blur(16px);
}
.lp-ticker::before {
  content: '';
  position: absolute; top: 0; left: 0; right: 0; height: 1px;
  background: linear-gradient(90deg, transparent, rgba(6,182,212,0.22), transparent);
}
.lp-ticker-t {
  display: flex; height: 100%; width: max-content;
  animation: lpTicker 52s linear infinite;
}
.lp-ticker-i {
  display: flex; align-items: center; gap: 9px;
  padding: 0 1.5rem;
  font-family: var(--lp-mono); font-size: 0.55rem;
  color: rgba(226,232,245,0.16); letter-spacing: 0.10em; text-transform: uppercase;
  white-space: nowrap;
}
.lp-ticker-sep {
  width: 3px; height: 3px; border-radius: 50%;
  background: var(--lp-cyan); opacity: 0.35; flex-shrink: 0;
}
@keyframes lpTicker { from{transform:translateX(0)} to{transform:translateX(-50%)} }

/* ══════════════════════════════════════════
   ANIMATIONS
══════════════════════════════════════════ */
@keyframes lpUp {
  from { opacity: 0; transform: translateY(10px); }
  to   { opacity: 1; transform: translateY(0); }
}
@keyframes lpShake {
  0%,100%{transform:translateX(0)}
  20%{transform:translateX(-4px)}
  40%{transform:translateX(4px)}
  60%{transform:translateX(-2px)}
  80%{transform:translateX(2px)}
}
.lp-shake { animation: lpShake 0.28s ease; }

/* ── Responsive ── */
@media (max-width: 500px) {
  .lp-title { font-size: 2rem; }
  .lp-center { padding: 1.75rem 1.25rem 5rem; }
  .lp-tab { padding: 8px 10px; font-size: 0.765rem; }
}

/* ── Focus visible (mirrors custom.css global) ── */
#lp-root *:focus-visible { outline: 2px solid var(--lp-cyan); outline-offset: 2px; border-radius: 4px; }
#lp-panel-a *:focus-visible { outline-color: var(--lp-indigo); }
</style>
</head>
<body>
<script>document.documentElement.classList.add('lp-page');</script>

<div id="lp-root">

  <!-- ══ SIDEBAR ══ -->
  <aside class="lp-sidebar" aria-label="Informasi aplikasi">
    <div class="lp-sb-orb lp-sb-orb1"></div>
    <div class="lp-sb-orb lp-sb-orb2"></div>
    <div class="lp-sb-grid"></div>
    <div class="lp-sb-inner">

      <!-- Brand -->
      <div class="lp-brand">
        <div class="lp-brand-logo">
          <img src="<?= BASE_URL ?>/assets/img/logo-com.png" alt="Logo"
               onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
          <div class="lp-brand-logo-fb" style="display:none">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
          </div>
        </div>
        <div>
          <div class="lp-brand-name"><?= htmlspecialchars($settings['org_name']['value'] ?? APP_NAME) ?></div>
          <div class="lp-brand-sub">Management Portal</div>
        </div>
      </div>

      <div class="lp-sb-eyebrow">Platform Resmi</div>
      <h2 class="lp-sb-hl">Kelola <em>organisasi</em><br>lebih cerdas.</h2>

      <!-- Stats -->
      <div class="lp-stats">
        <div class="lp-stat">
          <div class="lp-stat-n" id="lpStatA">—</div>
          <div class="lp-stat-l">Total Anggota</div>
        </div>
        <div class="lp-stat">
          <div class="lp-stat-n" id="lpStatB">—</div>
          <div class="lp-stat-l">Aktif Bulan Ini</div>
        </div>
      </div>

      <!-- Features -->
      <div class="lp-feats">
        <div class="lp-feat">
          <div class="lp-feat-ico">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
          </div>
          <div>
            <div class="lp-feat-t">Manajemen Anggota</div>
            <div class="lp-feat-d">Data terpusat dengan sistem berlapis dan riwayat lengkap.</div>
          </div>
        </div>
        <div class="lp-feat">
          <div class="lp-feat-ico">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
          </div>
          <div>
            <div class="lp-feat-t">Absensi &amp; Kegiatan</div>
            <div class="lp-feat-d">Rekap kehadiran dan jadwal kegiatan secara real-time.</div>
          </div>
        </div>
        <div class="lp-feat">
          <div class="lp-feat-ico">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
          </div>
          <div>
            <div class="lp-feat-t">Laporan &amp; Analitik</div>
            <div class="lp-feat-d">Statistik komprehensif dan ekspor laporan otomatis.</div>
          </div>
        </div>
        <div class="lp-feat">
          <div class="lp-feat-ico">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
          </div>
          <div>
            <div class="lp-feat-t">Keamanan Data</div>
            <div class="lp-feat-d">Enkripsi end-to-end dan proteksi CSRF menjaga data organisasi.</div>
          </div>
        </div>
      </div>

      <!-- Sidebar footer -->
      <div class="lp-sb-foot">
        <div class="lp-status">
          <div class="lp-dot"></div>
          Semua sistem aktif
        </div>
        <div class="lp-copy">&copy; <?= date('Y') ?> <?= htmlspecialchars($settings['org_name']['value'] ?? APP_NAME) ?></div>
      </div>

    </div>
  </aside>

  <!-- ══ MAIN ══ -->
  <main class="lp-main">
    <div class="lp-bg-wrap">
      <div class="lp-bg-g1"></div>
      <div class="lp-bg-g2"></div>
      <div class="lp-bg-grid"></div>
      <div class="lp-bg-corner"></div>
      <div class="lp-bg-corner2"></div>
    </div>

    <div class="lp-center">

      <!-- Mobile brand -->
      <div class="lp-mbrand">
        <div class="lp-mbrand-logo">
          <img src="<?= BASE_URL ?>/assets/img/logo-com.png" alt="Logo"
               onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
          <div class="lp-mbrand-logo-fb" style="display:none">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
          </div>
        </div>
        <div>
          <div class="lp-mbrand-name"><?= htmlspecialchars($settings['org_name']['value'] ?? APP_NAME) ?></div>
          <div class="lp-mbrand-sub">Management Portal</div>
        </div>
      </div>

      <div class="lp-card">

        <!-- Header -->
        <div class="lp-head">
          <div class="lp-kicker">Masuk ke Portal</div>
          <h1 class="lp-title">Selamat <em>datang</em><br>kembali</h1>
          <p class="lp-sub">Akses dasbor dan kelola data organisasi Anda dengan aman.</p>
        </div>

        <!-- PHP flash — pakai struktur .lp-alert (mirrors .alert dari custom.css) -->
        <?php if (!empty($flash)): ?>
        <div class="lp-alert <?= $flash['type'] === 'error' ? 'lp-alert-error' : 'lp-alert-success' ?>"
             role="alert" data-auto-dismiss="6000">
          <?php if ($flash['type'] === 'error'): ?>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
          <?php else: ?>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
          <?php endif; ?>
          <span><?= htmlspecialchars($flash['msg']) ?></span>
        </div>
        <?php endif; ?>

        <!-- JS-injected alert -->
        <div class="lp-alert" id="lp-jsa" role="alert" aria-live="polite" style="display:none"></div>

        <!-- Tab toggle -->
        <div class="lp-toggle-wrap" role="tablist" aria-label="Tipe akun">
          <div class="lp-toggle-ind on-member" id="lp-ind"></div>
          <button class="lp-tab lp-tab-on" data-t="member" role="tab"
                  aria-selected="true" aria-controls="lp-panel-m" id="lp-tab-m">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            <span>Anggota</span>
          </button>
          <button class="lp-tab" data-t="admin" role="tab"
                  aria-selected="false" aria-controls="lp-panel-a" id="lp-tab-a">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            <span>Administrator</span>
          </button>
        </div>

        <!-- Slide viewport -->
        <div class="lp-vp">
          <div class="lp-track" id="lp-track">

            <!-- ── Panel Anggota ── -->
            <div class="lp-slide" id="lp-panel-m" role="tabpanel" aria-labelledby="lp-tab-m">
              <form method="POST" action="<?= BASE_URL ?>/login"
                    class="lp-fields" id="lp-fm" novalidate autocomplete="on">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
                <input type="hidden" name="login_type" value="member">

                <div class="lp-field">
                  <label class="lp-label" for="lp-nia">
                    Nomor Induk Anggota (NIA)
                    <span class="lp-label-note">Wajib</span>
                  </label>
                  <div class="lp-fw">
                    <span class="lp-fi" aria-hidden="true">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="16" rx="2"/><circle cx="12" cy="10" r="3"/><path d="M7 20v-1a5 5 0 0 1 10 0v1"/></svg>
                    </span>
                    <input type="text" id="lp-nia" name="nia" class="lp-inp"
                           placeholder="Contoh: 2024001"
                           autocomplete="username"
                           inputmode="numeric"
                           maxlength="12"
                           value="<?= htmlspecialchars($_POST['nia'] ?? '') ?>"
                           required>
                  </div>
                  <div class="lp-hint" id="lp-nia-hint" aria-live="polite"></div>
                </div>

                <div class="lp-field">
                  <label class="lp-label" for="lp-pw-m">Kata Sandi</label>
                  <div class="lp-fw">
                    <span class="lp-fi" aria-hidden="true">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    </span>
                    <input type="password" id="lp-pw-m" name="password" class="lp-inp"
                           placeholder="Masukkan kata sandi"
                           autocomplete="current-password"
                           required>
                    <button type="button" class="lp-eye" data-for="lp-pw-m" aria-label="Tampilkan kata sandi">
                      <svg class="lp-ey-s" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                      <svg class="lp-ey-h" style="display:none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                    </button>
                  </div>
                  <div class="lp-pws" id="lp-pws-m">
                    <div class="lp-pws-bar"><div class="lp-pws-fill" id="lp-pwf-m"></div></div>
                    <div class="lp-pws-row">
                      <span id="lp-pwl-m"></span>
                      <div class="lp-pws-dots">
                        <div class="lp-pws-dot" id="lp-pd-m1"></div>
                        <div class="lp-pws-dot" id="lp-pd-m2"></div>
                        <div class="lp-pws-dot" id="lp-pd-m3"></div>
                        <div class="lp-pws-dot" id="lp-pd-m4"></div>
                      </div>
                    </div>
                  </div>
                </div>

                <button type="submit" class="lp-btn lp-btn-m" id="lp-sbt-m">
                  <span class="lp-btn-sp" id="lp-sp-m">
                    <svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" opacity=".3"/><path d="M22 12a10 10 0 01-10 10" stroke="currentColor" stroke-width="3" stroke-linecap="round"/></svg>
                  </span>
                  <span class="lp-btn-tx">Masuk sebagai Anggota</span>
                  <span class="lp-btn-arr">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                  </span>
                </button>
              </form>
            </div>

            <!-- ── Panel Admin ── -->
            <div class="lp-slide" id="lp-panel-a" role="tabpanel" aria-labelledby="lp-tab-a">
              <form method="POST" action="<?= BASE_URL ?>/login"
                    class="lp-fields" id="lp-fa" novalidate autocomplete="on">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
                <input type="hidden" name="login_type" value="admin">

                <div class="lp-field">
                  <label class="lp-label" for="lp-email">
                    Alamat Email
                    <span class="lp-label-note">Wajib</span>
                  </label>
                  <div class="lp-fw">
                    <span class="lp-fi" aria-hidden="true">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    </span>
                    <input type="email" id="lp-email" name="email" class="lp-inp"
                           placeholder="admin@organisasi.id"
                           autocomplete="email"
                           required>
                  </div>
                  <div class="lp-hint" id="lp-email-hint" aria-live="polite"></div>
                </div>

                <div class="lp-field">
                  <label class="lp-label" for="lp-pw-a">Kata Sandi Administrator</label>
                  <div class="lp-fw">
                    <span class="lp-fi" aria-hidden="true">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    </span>
                    <input type="password" id="lp-pw-a" name="password" class="lp-inp"
                           placeholder="Masukkan kata sandi"
                           autocomplete="current-password"
                           required>
                    <button type="button" class="lp-eye" data-for="lp-pw-a" aria-label="Tampilkan kata sandi">
                      <svg class="lp-ey-s" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                      <svg class="lp-ey-h" style="display:none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                    </button>
                  </div>
                  <div class="lp-pws" id="lp-pws-a">
                    <div class="lp-pws-bar"><div class="lp-pws-fill" id="lp-pwf-a"></div></div>
                    <div class="lp-pws-row">
                      <span id="lp-pwl-a"></span>
                      <div class="lp-pws-dots">
                        <div class="lp-pws-dot" id="lp-pd-a1"></div>
                        <div class="lp-pws-dot" id="lp-pd-a2"></div>
                        <div class="lp-pws-dot" id="lp-pd-a3"></div>
                        <div class="lp-pws-dot" id="lp-pd-a4"></div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="lp-adm-note" role="note">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                  <span>Area ini hanya untuk staf administrator yang berwenang. Akses tidak sah akan dicatat dan dilaporkan kepada tim keamanan.</span>
                </div>

                <button type="submit" class="lp-btn lp-btn-a" id="lp-sbt-a">
                  <span class="lp-btn-sp" id="lp-sp-a">
                    <svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" opacity=".3"/><path d="M22 12a10 10 0 01-10 10" stroke="currentColor" stroke-width="3" stroke-linecap="round"/></svg>
                  </span>
                  <span class="lp-btn-tx">Masuk sebagai Administrator</span>
                  <span class="lp-btn-arr">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                  </span>
                </button>
              </form>
            </div>

          </div><!-- /lp-track -->
        </div><!-- /lp-vp -->

        <!-- Footer -->
        <div class="lp-foot">
          <div id="lp-fr-m" class="lp-foot-row">
            <span>Belum punya akun?</span>
            <a href="<?= BASE_URL ?>/pab" class="lp-lnk lp-lnk-cy">Daftar sekarang</a>
          </div>
          <div id="lp-fr-a" class="lp-foot-row" style="display:none">
            <span>Butuh akses admin?</span>
            <a href="mailto:it@organisasi.id" class="lp-lnk lp-lnk-in">Hubungi tim IT</a>
          </div>
          <a href="<?= BASE_URL ?>/" class="lp-back">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Kembali ke beranda
          </a>
          <div class="lp-sec-badge">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            Koneksi terenkripsi SSL
          </div>
        </div>

      </div><!-- /lp-card -->
    </div><!-- /lp-center -->
  </main>

</div><!-- /lp-root -->

<!-- Ticker -->
<div class="lp-ticker" aria-hidden="true">
  <div class="lp-ticker-t">
    <?php
      $raw   = $settings['ticker_items']['value'] ?? 'COM Academy|Penerimaan Anggota Baru|Tech Talk & Workshop|Creative Festival|Absensi Digital|Manajemen Anggota|Platform Modern';
      $items = array_filter(array_map('trim', explode('|', $raw)));
      $all   = array_merge($items, $items);
      foreach ($all as $item):
    ?>
    <span class="lp-ticker-i">
      <span class="lp-ticker-sep"></span>
      <?= htmlspecialchars($item) ?>
    </span>
    <?php endforeach; ?>
  </div>
</div>

<script>
(function () {
'use strict';

/* ── State ── */
var cur   = 'member';
var tabs  = document.querySelectorAll('.lp-tab');
var track = document.getElementById('lp-track');
var ind   = document.getElementById('lp-ind');
var frM   = document.getElementById('lp-fr-m');
var frA   = document.getElementById('lp-fr-a');
var jsa   = document.getElementById('lp-jsa');
var REX_EMAIL = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;

/* ── Counter animation (sidebar stats) ── */
function countUp(el, end, sfx, dur) {
  if (!el) return;
  var t0 = null;
  function step(ts) {
    if (!t0) t0 = ts;
    var p = Math.min((ts - t0) / dur, 1);
    var e = 1 - Math.pow(1 - p, 3);
    el.textContent = Math.round(e * end) + (sfx || '');
    if (p < 1) requestAnimationFrame(step);
  }
  requestAnimationFrame(step);
}
setTimeout(function () {
  countUp(document.getElementById('lpStatA'), 248, '', 1400);
  countUp(document.getElementById('lpStatB'), 91, '%', 1100);
}, 800);

/* ── Alert helpers ── */
var ICO_ERR = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>';
var ICO_OK  = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>';

function showJsAlert(type, msg) {
  jsa.className = 'lp-alert ' + (type === 'error' ? 'lp-alert-error' : 'lp-alert-success');
  jsa.innerHTML = (type === 'error' ? ICO_ERR : ICO_OK) + '<span>' + esc(msg) + '</span>';
  jsa.style.display = 'flex';
}
function hideJsAlert() { jsa.style.display = 'none'; }

/* Auto-dismiss PHP flash — delegates to main.js pattern via data attribute */
/* (handled by main.js _scheduleAlertDismiss if loaded; fallback below) */
document.querySelectorAll('.lp-alert[data-auto-dismiss]').forEach(function (el) {
  var delay = parseInt(el.dataset.autoDismiss, 10) || 6000;
  setTimeout(function () { dismissEl(el); }, delay);
});
function dismissEl(el) {
  if (el._lp_dismissing) return;
  el._lp_dismissing = true;
  var reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  if (reduced) { el.remove(); return; }
  el.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
  el.style.opacity    = '0';
  el.style.transform  = 'translateY(-4px)';
  setTimeout(function () { el.remove(); }, 350);
}

/* ── Tab switch ── */
function go(t) {
  if (t === cur) return;
  cur = t;
  tabs.forEach(function (b) {
    var on = b.dataset.t === t;
    b.classList.toggle('lp-tab-on', on);
    b.setAttribute('aria-selected', on ? 'true' : 'false');
  });
  track.style.transform = t === 'admin' ? 'translateX(-100%)' : 'translateX(0)';
  if (ind) ind.className = 'lp-toggle-ind ' + (t === 'admin' ? 'on-admin' : 'on-member');
  frM.style.display = t === 'member' ? '' : 'none';
  frA.style.display = t === 'admin'  ? '' : 'none';
  hideJsAlert();
}

tabs.forEach(function (b) {
  b.addEventListener('click', function () { go(b.dataset.t); });
});

/* Arrow-key navigation on tabs */
var tabArr = Array.from(tabs);
tabArr.forEach(function (b, i) {
  b.addEventListener('keydown', function (e) {
    var nxt;
    if (e.key === 'ArrowRight' || e.key === 'ArrowDown') nxt = tabArr[(i + 1) % tabArr.length];
    if (e.key === 'ArrowLeft'  || e.key === 'ArrowUp')   nxt = tabArr[(i - 1 + tabArr.length) % tabArr.length];
    if (nxt) { nxt.click(); nxt.focus(); e.preventDefault(); }
  });
});

/* ── Shake helper ── */
function shake(el) {
  if (!el) return;
  el.classList.remove('lp-shake');
  void el.offsetWidth;
  el.classList.add('lp-shake');
  el.addEventListener('animationend', function () { el.classList.remove('lp-shake'); }, { once: true });
}

/* ── Eye toggle ── */
document.querySelectorAll('.lp-eye[data-for]').forEach(function (btn) {
  btn.addEventListener('click', function () {
    var inp  = document.getElementById(btn.dataset.for);
    if (!inp) return;
    var show = inp.type === 'password';
    inp.type = show ? 'text' : 'password';
    btn.querySelector('.lp-ey-s').style.display = show ? 'none' : '';
    btn.querySelector('.lp-ey-h').style.display = show ? ''     : 'none';
    btn.setAttribute('aria-label', show ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi');
    inp.focus();
  });
});

/* ── NIA validation (mirrors main.js input handler) ── */
var niaEl   = document.getElementById('lp-nia');
var niaHint = document.getElementById('lp-nia-hint');
if (niaEl) {
  niaEl.addEventListener('input', function () {
    this.value = this.value.replace(/\D/g, '');
    var v = this.value;
    if (!v) { niaHint.textContent = ''; niaHint.className = 'lp-hint'; this.classList.remove('is-invalid'); return; }
    if (v.length >= 5 && v.length <= 12) {
      niaHint.innerHTML = CHK + ' Format NIA valid';
      niaHint.className = 'lp-hint lp-hint-ok';
      this.classList.remove('is-invalid');
    } else {
      niaHint.textContent = 'Masukkan 5–12 digit angka';
      niaHint.className = 'lp-hint lp-hint-err';
    }
  });
}

/* ── Email validation ── */
var emailEl   = document.getElementById('lp-email');
var emailHint = document.getElementById('lp-email-hint');
if (emailEl) {
  emailEl.addEventListener('input', function () {
    var v = this.value;
    if (!v) { emailHint.textContent = ''; emailHint.className = 'lp-hint'; this.classList.remove('is-invalid'); return; }
    var ok = REX_EMAIL.test(v);
    emailHint.innerHTML = ok ? CHK + ' Format email valid' : 'Format email tidak valid';
    emailHint.className = 'lp-hint ' + (ok ? 'lp-hint-ok' : 'lp-hint-err');
    this.classList.toggle('is-invalid', !ok);
  });
}

/* ── Password strength ── */
var PWC = ['#ef4444', '#f97316', '#eab308', '#10b981'];
var PWL = ['Lemah', 'Cukup', 'Kuat', 'Sangat Kuat'];

function pwScore(v) {
  var s = 0;
  if (v.length >= 8)  s++;
  if (v.length >= 12) s++;
  if (/[A-Z]/.test(v) && /[a-z]/.test(v)) s++;
  if (/[0-9]/.test(v)) s++;
  if (/[^A-Za-z0-9]/.test(v)) s++;
  return Math.min(3, Math.max(0, s - 1));
}

function updateStrength(inp, wrapId, fillId, labelId, dotIds) {
  var v = inp.value;
  var wrap  = document.getElementById(wrapId);
  var fill  = document.getElementById(fillId);
  var label = document.getElementById(labelId);
  if (!v) { wrap.style.display = 'none'; return; }
  wrap.style.display = '';
  var sc = pwScore(v);
  fill.style.width      = ((sc + 1) / 4 * 100) + '%';
  fill.style.background = PWC[sc];
  label.textContent     = PWL[sc];
  label.style.color     = PWC[sc];
  dotIds.forEach(function (id, i) {
    var d = document.getElementById(id);
    if (!d) return;
    d.classList.toggle('on', i <= sc);
    d.style.background = i <= sc ? PWC[sc] : '';
  });
}

var pwM = document.getElementById('lp-pw-m');
var pwA = document.getElementById('lp-pw-a');
if (pwM) pwM.addEventListener('input', function () {
  updateStrength(this, 'lp-pws-m', 'lp-pwf-m', 'lp-pwl-m', ['lp-pd-m1','lp-pd-m2','lp-pd-m3','lp-pd-m4']);
});
if (pwA) pwA.addEventListener('input', function () {
  updateStrength(this, 'lp-pws-a', 'lp-pwf-a', 'lp-pwl-a', ['lp-pd-a1','lp-pd-a2','lp-pd-a3','lp-pd-a4']);
});

/* ── Submit — replicates main.js form loading pattern ── */
[['lp-fm','member'], ['lp-fa','admin']].forEach(function (pair) {
  var frm  = document.getElementById(pair[0]);
  var type = pair[1];
  if (!frm) return;

  frm.addEventListener('submit', function (e) {
    hideJsAlert();
    var valid = true, first = null;

    /* Required fields */
    this.querySelectorAll('input[required]').forEach(function (f) {
      if (!f.value.trim()) {
        valid = false;
        f.classList.add('is-invalid');
        setTimeout(function () { f.classList.remove('is-invalid'); }, 2800);
        if (!first) first = f;
      }
    });

    if (!valid) {
      e.preventDefault();
      showJsAlert('error', 'Harap isi semua kolom yang diperlukan.');
      shake(frm.querySelector('.lp-btn'));
      if (first) first.focus();
      return;
    }

    /* Email format check for admin */
    if (type === 'admin') {
      var em = document.getElementById('lp-email');
      if (em && !REX_EMAIL.test(em.value)) {
        e.preventDefault();
        showJsAlert('error', 'Masukkan alamat email yang valid.');
        em.classList.add('is-invalid');
        setTimeout(function () { em.classList.remove('is-invalid'); }, 2800);
        shake(em.closest('.lp-fw'));
        em.focus();
        return;
      }
    }

    /* Loading state — mirrors .btn.is-loading from custom.css */
    var btn = this.querySelector('.lp-btn');
    var sp  = document.getElementById(type === 'member' ? 'lp-sp-m' : 'lp-sp-a');
    var tx  = this.querySelector('.lp-btn-tx');
    var ar  = this.querySelector('.lp-btn-arr');
    if (btn) btn.disabled = true;
    if (sp)  sp.style.display = 'flex';
    if (tx)  tx.textContent = 'Memproses…';
    if (ar)  ar.style.display = 'none';
  });
});

/* ── Utilities ── */
var CHK = '<svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>';

function esc(s) {
  return String(s)
    .replace(/&/g,'&amp;').replace(/</g,'&lt;')
    .replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

}());
</script>
</body>
</html>