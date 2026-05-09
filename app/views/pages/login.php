<?php // app/views/pages/login.php ?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Masuk — <?= htmlspecialchars($settings['org_name']['value'] ?? APP_NAME) ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Outfit:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

<style>
/*
 * SEMUA style di-scope di dalam #portal-root
 * untuk mencegah konflik dengan CSS framework lain (Bootstrap, dll)
 */

/* ─── Reset minimal, hanya berlaku dalam scope ─── */
#portal-root,
#portal-root *,
#portal-root *::before,
#portal-root *::after {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

/* ─── CSS Variables ─── */
#portal-root {
  --pr-bg:        #0a0b0f;
  --pr-bg2:       #111318;
  --pr-bg3:       #181b22;
  --pr-surface:   #1e2028;
  --pr-surface2:  #252830;

  --pr-gold:      #d4a843;
  --pr-gold2:     #e8c36a;
  --pr-gold3:     #b88a2a;
  --pr-gold-glow: rgba(212,168,67,.18);
  --pr-gold-ring: rgba(212,168,67,.25);

  --pr-ruby:      #c0445a;
  --pr-ruby2:     #e05a72;
  --pr-ruby-glow: rgba(192,68,90,.15);
  --pr-ruby-ring: rgba(192,68,90,.28);

  --pr-text:      #e8e4dc;
  --pr-text2:     rgba(232,228,220,.60);
  --pr-text3:     rgba(232,228,220,.35);
  --pr-text4:     rgba(232,228,220,.18);

  --pr-border:    rgba(232,228,220,.08);
  --pr-border2:   rgba(232,228,220,.13);
  --pr-border3:   rgba(232,228,220,.22);

  --pr-green:     #3aaa72;
  --pr-green-bg:  rgba(58,170,114,.10);
  --pr-red:       #cc4444;
  --pr-red-bg:    rgba(204,68,68,.10);

  --pr-serif:     'Playfair Display', Georgia, serif;
  --pr-sans:      'Outfit', system-ui, sans-serif;
  --pr-mono:      'JetBrains Mono', monospace;

  --pr-r:         8px;
  --pr-r2:        12px;
  --pr-r3:        20px;
  --pr-ease:      cubic-bezier(0.22, 1, 0.36, 1);
  --pr-ease2:     cubic-bezier(0.16, 1, 0.30, 1);
}

/* ─── Root layout ─── */
#portal-root {
  display: flex;
  min-height: 100vh;
  min-height: 100dvh;
  width: 100%;
  background: var(--pr-bg);
  color: var(--pr-text);
  font-family: var(--pr-sans);
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  overflow-x: hidden;
}

/* Pastikan body mendukung full height */
html, body {
  min-height: 100%;
}

/* ═══════════════════════════════
   LEFT PANEL
═══════════════════════════════ */
#portal-root .pr-left {
  width: 460px;
  min-width: 460px;
  flex-shrink: 0;
  background: var(--pr-bg2);
  position: sticky;
  top: 0;
  height: 100vh;
  height: 100dvh;
  overflow: hidden;
  display: none;
  flex-direction: column;
  padding: 0;
  border-right: 1px solid var(--pr-border);
}

@media (min-width: 1080px) {
  #portal-root .pr-left { display: flex; }
}

/* Noise grain */
#portal-root .pr-left::after {
  content: '';
  position: absolute;
  inset: 0;
  background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.035'/%3E%3C/svg%3E");
  pointer-events: none;
  z-index: 0;
}

/* Gold glow orb top-left */
#portal-root .pr-left-orb {
  position: absolute;
  top: -80px;
  left: -80px;
  width: 360px;
  height: 360px;
  background: radial-gradient(circle, rgba(212,168,67,.09) 0%, transparent 65%);
  pointer-events: none;
  z-index: 0;
}

/* Ruby orb bottom */
#portal-root .pr-left-orb2 {
  position: absolute;
  bottom: -60px;
  right: -60px;
  width: 280px;
  height: 280px;
  background: radial-gradient(circle, rgba(192,68,90,.07) 0%, transparent 65%);
  pointer-events: none;
  z-index: 0;
}

/* Diagonal grid lines */
#portal-root .pr-left-grid {
  position: absolute;
  inset: 0;
  background-image:
    linear-gradient(rgba(232,228,220,.025) 1px, transparent 1px),
    linear-gradient(90deg, rgba(232,228,220,.025) 1px, transparent 1px);
  background-size: 52px 52px;
  pointer-events: none;
  z-index: 0;
}

/* Gold accent line at bottom */
#portal-root .pr-left-accent {
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  height: 1px;
  background: linear-gradient(90deg, transparent, var(--pr-gold), transparent);
  opacity: .3;
  z-index: 1;
}

#portal-root .pr-left-inner {
  position: relative;
  z-index: 2;
  display: flex;
  flex-direction: column;
  height: 100%;
  padding: 3rem;
}

/* Brand mark */
#portal-root .pr-brand {
  display: flex;
  align-items: center;
  gap: 14px;
}

#portal-root .pr-brand-icon {
  width: 44px;
  height: 44px;
  border-radius: var(--pr-r2);
  border: 1px solid rgba(212,168,67,.2);
  background: rgba(212,168,67,.08);
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  flex-shrink: 0;
}

#portal-root .pr-brand-icon img {
  width: 100%;
  height: 100%;
  object-fit: contain;
  padding: 8px;
  filter: brightness(0) invert(1);
}

#portal-root .pr-brand-icon-fb {
  color: var(--pr-gold2);
  display: none;
}

#portal-root .pr-brand-icon-fb svg {
  width: 18px;
  height: 18px;
}

#portal-root .pr-brand-name {
  font-size: .9rem;
  font-weight: 600;
  color: var(--pr-text);
  letter-spacing: -.01em;
}

#portal-root .pr-brand-sub {
  font-family: var(--pr-mono);
  font-size: .48rem;
  color: var(--pr-text3);
  letter-spacing: .14em;
  text-transform: uppercase;
  margin-top: 2px;
}

/* Main content area */
#portal-root .pr-left-content {
  flex: 1;
  display: flex;
  flex-direction: column;
  justify-content: center;
  padding: 3rem 0;
}

#portal-root .pr-eyebrow {
  display: flex;
  align-items: center;
  gap: 10px;
  font-family: var(--pr-mono);
  font-size: .52rem;
  color: var(--pr-gold);
  letter-spacing: .18em;
  text-transform: uppercase;
  margin-bottom: 1.5rem;
}

#portal-root .pr-eyebrow::after {
  content: '';
  flex: 1;
  height: 1px;
  background: linear-gradient(90deg, var(--pr-gold), transparent);
  opacity: .25;
}

#portal-root .pr-left-title {
  font-family: var(--pr-serif);
  font-size: 3.2rem;
  line-height: 1.1;
  color: var(--pr-text);
  margin-bottom: 1.25rem;
  font-weight: 400;
}

#portal-root .pr-left-title em {
  font-style: italic;
  color: var(--pr-gold2);
}

#portal-root .pr-left-desc {
  font-size: .82rem;
  line-height: 1.9;
  color: var(--pr-text3);
  max-width: 320px;
  font-weight: 300;
}

/* Stats */
#portal-root .pr-stats {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  border: 1px solid var(--pr-border);
  border-radius: var(--pr-r2);
  overflow: hidden;
  margin-top: 2.5rem;
}

#portal-root .pr-stat {
  padding: 1.25rem 1rem;
  background: rgba(232,228,220,.02);
  border-right: 1px solid var(--pr-border);
  text-align: center;
  transition: background .2s;
}

#portal-root .pr-stat:last-child { border-right: none; }

#portal-root .pr-stat:hover {
  background: rgba(212,168,67,.04);
}

#portal-root .pr-stat-n {
  font-family: var(--pr-serif);
  font-size: 2rem;
  color: var(--pr-text);
  line-height: 1;
  margin-bottom: 4px;
}

#portal-root .pr-stat-l {
  font-family: var(--pr-mono);
  font-size: .48rem;
  color: var(--pr-text4);
  letter-spacing: .1em;
  text-transform: uppercase;
}

/* Feature list */
#portal-root .pr-features {
  margin-top: 2.25rem;
}

#portal-root .pr-feat {
  display: flex;
  align-items: flex-start;
  gap: 12px;
  padding: .9rem 0;
  border-bottom: 1px solid var(--pr-border);
}

#portal-root .pr-feat:last-child { border-bottom: none; }

#portal-root .pr-feat-icon {
  width: 30px;
  height: 30px;
  flex-shrink: 0;
  border: 1px solid rgba(212,168,67,.15);
  border-radius: var(--pr-r);
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--pr-gold2);
  margin-top: 1px;
  background: rgba(212,168,67,.05);
}

#portal-root .pr-feat-icon svg { width: 13px; height: 13px; }

#portal-root .pr-feat-title {
  font-size: .78rem;
  font-weight: 600;
  color: var(--pr-text2);
  margin-bottom: 2px;
}

#portal-root .pr-feat-desc {
  font-size: .7rem;
  color: var(--pr-text4);
  line-height: 1.65;
  font-weight: 300;
}

/* Left footer */
#portal-root .pr-left-foot {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding-top: 2rem;
  border-top: 1px solid var(--pr-border);
}

#portal-root .pr-status {
  display: flex;
  align-items: center;
  gap: 7px;
  font-family: var(--pr-mono);
  font-size: .48rem;
  color: var(--pr-text4);
  letter-spacing: .07em;
  text-transform: uppercase;
}

#portal-root .pr-status-dot {
  width: 6px;
  height: 6px;
  border-radius: 50%;
  background: var(--pr-green);
  box-shadow: 0 0 8px rgba(58,170,114,.6);
  animation: prPulse 3s ease-in-out infinite;
}

#portal-root .pr-left-copy {
  font-family: var(--pr-mono);
  font-size: .48rem;
  color: var(--pr-text4);
}

/* ═══════════════════════════════
   RIGHT / MAIN
═══════════════════════════════ */
#portal-root .pr-main {
  flex: 1;
  display: flex;
  flex-direction: column;
  background: var(--pr-bg);
  min-height: 100vh;
  min-height: 100dvh;
  position: relative;
  overflow-y: auto;
}

/* Bg atmospheric gradients */
#portal-root .pr-main::before {
  content: '';
  position: absolute;
  inset: 0;
  background:
    radial-gradient(ellipse 55% 45% at 75% 8%, rgba(212,168,67,.055) 0%, transparent 60%),
    radial-gradient(ellipse 40% 40% at 20% 92%, rgba(192,68,90,.04) 0%, transparent 55%);
  pointer-events: none;
  z-index: 0;
}

/* Corner decoration */
#portal-root .pr-corner {
  position: absolute;
  pointer-events: none;
  z-index: 1;
}

#portal-root .pr-corner-tl {
  top: 2.5rem;
  left: 2.5rem;
  width: 48px;
  height: 48px;
  border-top: 1px solid rgba(212,168,67,.2);
  border-left: 1px solid rgba(212,168,67,.2);
}

#portal-root .pr-corner-br {
  bottom: 4rem;
  right: 2.5rem;
  width: 36px;
  height: 36px;
  border-bottom: 1px solid rgba(232,228,220,.06);
  border-right: 1px solid rgba(232,228,220,.06);
}

/* Center wrapper */
#portal-root .pr-center {
  position: relative;
  z-index: 2;
  flex: 1;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 3.5rem 2rem 6rem;
}

/* Mobile brand */
#portal-root .pr-m-brand {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-bottom: 2.5rem;
  animation: prSlideUp .5s var(--pr-ease) both;
}

@media (min-width: 1080px) {
  #portal-root .pr-m-brand { display: none; }
}

#portal-root .pr-m-brand-icon {
  width: 40px;
  height: 40px;
  border-radius: var(--pr-r2);
  border: 1px solid var(--pr-border2);
  background: var(--pr-surface);
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  flex-shrink: 0;
}

#portal-root .pr-m-brand-icon img {
  width: 100%;
  height: 100%;
  object-fit: contain;
  padding: 8px;
  filter: brightness(0) invert(1);
}

#portal-root .pr-m-brand-name {
  font-size: .9rem;
  font-weight: 600;
  color: var(--pr-text);
}

#portal-root .pr-m-brand-sub {
  font-family: var(--pr-mono);
  font-size: .48rem;
  color: var(--pr-text3);
  letter-spacing: .1em;
  text-transform: uppercase;
  margin-top: 2px;
}

/* Card wrapper */
#portal-root .pr-card {
  width: 100%;
  max-width: 430px;
}

/* Header */
#portal-root .pr-head {
  margin-bottom: 2rem;
  animation: prSlideUp .5s var(--pr-ease) .04s both;
}

#portal-root .pr-badge {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  font-family: var(--pr-mono);
  font-size: .52rem;
  color: var(--pr-gold);
  letter-spacing: .13em;
  text-transform: uppercase;
  margin-bottom: 1.1rem;
  padding: 5px 12px 5px 9px;
  background: rgba(212,168,67,.08);
  border: 1px solid rgba(212,168,67,.18);
  border-radius: 999px;
}

#portal-root .pr-badge-dot {
  width: 5px;
  height: 5px;
  border-radius: 50%;
  background: var(--pr-gold);
  box-shadow: 0 0 6px rgba(212,168,67,.7);
  flex-shrink: 0;
  animation: prPulse 2.5s ease-in-out infinite;
}

#portal-root .pr-title {
  font-family: var(--pr-serif);
  font-size: 2.75rem;
  font-weight: 400;
  line-height: 1.08;
  color: var(--pr-text);
  letter-spacing: -.02em;
  margin-bottom: .6rem;
}

#portal-root .pr-title em {
  font-style: italic;
  color: var(--pr-gold2);
}

#portal-root .pr-subtitle {
  font-size: .82rem;
  color: var(--pr-text3);
  line-height: 1.75;
  font-weight: 300;
}

/* Alert boxes */
#portal-root .pr-alert {
  display: flex;
  align-items: flex-start;
  gap: 10px;
  padding: .85rem 1rem;
  border-radius: var(--pr-r);
  font-size: .8rem;
  line-height: 1.55;
  border: 1px solid transparent;
  margin-bottom: 1.25rem;
}

#portal-root .pr-alert svg {
  width: 14px;
  height: 14px;
  flex-shrink: 0;
  margin-top: 2px;
}

#portal-root .pr-alert-error {
  background: var(--pr-red-bg);
  border-color: rgba(204,68,68,.22);
  color: #f08080;
  animation: prSlideUp .2s var(--pr-ease) both;
}

#portal-root .pr-alert-success {
  background: var(--pr-green-bg);
  border-color: rgba(58,170,114,.22);
  color: #5cc494;
  animation: prSlideUp .2s var(--pr-ease) both;
}

/* Tab switcher */
#portal-root .pr-tabs {
  display: flex;
  background: var(--pr-surface);
  border: 1px solid var(--pr-border2);
  border-radius: var(--pr-r2);
  padding: 4px;
  gap: 4px;
  margin-bottom: 2rem;
  animation: prSlideUp .5s var(--pr-ease) .08s both;
  position: relative;
}

#portal-root .pr-tab-slider {
  position: absolute;
  top: 4px;
  bottom: 4px;
  width: calc(50% - 6px);
  left: 4px;
  border-radius: calc(var(--pr-r2) - 2px);
  pointer-events: none;
  z-index: 0;
  transition: transform .38s var(--pr-ease2), background .25s, box-shadow .25s;
}

#portal-root .pr-tab-slider[data-active="member"] {
  background: var(--pr-bg3);
  box-shadow: 0 2px 16px rgba(0,0,0,.3);
  transform: translateX(0);
}

#portal-root .pr-tab-slider[data-active="admin"] {
  background: var(--pr-bg3);
  box-shadow: 0 2px 16px rgba(0,0,0,.3);
  transform: translateX(calc(100% + 4px));
}

#portal-root .pr-tab-btn {
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 7px;
  padding: 10px 12px;
  font-size: .8rem;
  font-weight: 400;
  font-family: var(--pr-sans);
  color: var(--pr-text3);
  border-radius: calc(var(--pr-r2) - 3px);
  border: none;
  background: none;
  cursor: pointer;
  transition: color .2s;
  white-space: nowrap;
  position: relative;
  z-index: 1;
}

#portal-root .pr-tab-btn svg {
  width: 13px;
  height: 13px;
  flex-shrink: 0;
}

#portal-root .pr-tab-btn:hover:not(.pr-tab-active) {
  color: var(--pr-text2);
}

#portal-root .pr-tab-btn.pr-tab-active {
  font-weight: 600;
}

#portal-root .pr-tab-btn.pr-tab-active[data-t="member"] {
  color: var(--pr-text);
}

#portal-root .pr-tab-btn.pr-tab-active[data-t="admin"] {
  color: var(--pr-gold2);
}

/* Slide viewport */
#portal-root .pr-viewport {
  overflow: hidden;
  width: 100%;
  animation: prSlideUp .5s var(--pr-ease) .12s both;
}

#portal-root .pr-track {
  display: flex;
  transition: transform .42s var(--pr-ease2);
  will-change: transform;
  align-items: flex-start;
}

#portal-root .pr-slide {
  min-width: 100%;
  flex-shrink: 0;
}

/* Form fields */
#portal-root .pr-fields {
  display: flex;
  flex-direction: column;
  gap: 1.125rem;
}

#portal-root .pr-field {
  display: flex;
  flex-direction: column;
  gap: 6px;
}

#portal-root .pr-label-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
}

#portal-root .pr-label {
  font-size: .78rem;
  font-weight: 600;
  color: var(--pr-text2);
  letter-spacing: -.01em;
}

#portal-root .pr-label-note {
  font-family: var(--pr-mono);
  font-size: .62rem;
  font-weight: 400;
  color: var(--pr-text4);
}

#portal-root .pr-input-wrap {
  position: relative;
  display: flex;
  align-items: center;
}

#portal-root .pr-input-icon {
  position: absolute;
  left: 13px;
  color: var(--pr-text4);
  pointer-events: none;
  display: flex;
  align-items: center;
  transition: color .15s;
}

#portal-root .pr-input-icon svg { width: 15px; height: 15px; }

/* THE CRITICAL INPUT — fully scoped, no inheritance from outside */
#portal-root .pr-inp {
  display: block;
  width: 100%;
  height: 50px;
  padding: 0 46px;
  font-family: var(--pr-sans);
  font-size: .875rem;
  font-weight: 400;
  line-height: normal;
  color: var(--pr-text);
  background: var(--pr-surface);
  border: 1px solid var(--pr-border2);
  border-radius: var(--pr-r);
  outline: none;
  box-shadow: inset 0 1px 0 rgba(0,0,0,.2), 0 1px 3px rgba(0,0,0,.15);
  transition: border-color .15s, box-shadow .15s, background .15s;
  -webkit-appearance: none;
  appearance: none;
}

#portal-root .pr-inp::placeholder {
  color: var(--pr-text4);
}

#portal-root .pr-inp:hover:not(:disabled) {
  border-color: var(--pr-border3);
}

#portal-root .pr-inp:disabled {
  opacity: .5;
  cursor: not-allowed;
}

/* Member focus — gold */
#portal-root .pr-panel-member .pr-inp:focus {
  border-color: var(--pr-gold);
  box-shadow: 0 0 0 3px var(--pr-gold-ring), inset 0 1px 0 rgba(0,0,0,.2);
  background: var(--pr-surface2);
}

#portal-root .pr-panel-member .pr-input-wrap:focus-within .pr-input-icon {
  color: var(--pr-gold3);
}

/* Admin focus — ruby */
#portal-root .pr-panel-admin .pr-inp:focus {
  border-color: var(--pr-ruby);
  box-shadow: 0 0 0 3px var(--pr-ruby-ring), inset 0 1px 0 rgba(0,0,0,.2);
  background: var(--pr-surface2);
}

#portal-root .pr-panel-admin .pr-input-wrap:focus-within .pr-input-icon {
  color: var(--pr-ruby2);
}

/* Invalid state */
#portal-root .pr-inp.pr-invalid {
  border-color: var(--pr-red);
  box-shadow: 0 0 0 3px rgba(204,68,68,.15);
}

/* Eye toggle button */
#portal-root .pr-eye-btn {
  position: absolute;
  right: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 6px;
  border: none;
  background: none;
  cursor: pointer;
  color: var(--pr-text4);
  border-radius: 5px;
  transition: color .14s, background .14s;
}

#portal-root .pr-eye-btn:hover {
  color: var(--pr-text2);
  background: rgba(232,228,220,.06);
}

#portal-root .pr-eye-btn svg { width: 14px; height: 14px; }

/* Field hint */
#portal-root .pr-hint {
  font-family: var(--pr-mono);
  font-size: .65rem;
  min-height: 16px;
  display: flex;
  align-items: center;
  gap: 5px;
  color: var(--pr-text4);
  transition: color .15s;
}

#portal-root .pr-hint-ok  { color: var(--pr-green); }
#portal-root .pr-hint-err { color: var(--pr-red); }

/* Password strength */
#portal-root .pr-pw-strength {
  display: none;
  margin-top: 6px;
}

#portal-root .pr-pw-bar-bg {
  height: 2px;
  background: var(--pr-border);
  border-radius: 99px;
  overflow: hidden;
  margin-bottom: 6px;
}

#portal-root .pr-pw-bar-fill {
  height: 100%;
  border-radius: 99px;
  width: 0;
  transition: width .3s var(--pr-ease), background .22s;
}

#portal-root .pr-pw-meta {
  display: flex;
  align-items: center;
  justify-content: space-between;
  font-family: var(--pr-mono);
  font-size: .55rem;
}

#portal-root .pr-pw-dots {
  display: flex;
  gap: 5px;
}

#portal-root .pr-pw-dot {
  width: 4px;
  height: 4px;
  border-radius: 50%;
  background: var(--pr-border2);
  transition: background .18s, transform .18s;
}

#portal-root .pr-pw-dot.pr-dot-on {
  transform: scale(1.5);
}

/* Admin warning notice */
#portal-root .pr-admin-warn {
  display: flex;
  align-items: flex-start;
  gap: 10px;
  padding: .9rem 1rem;
  background: var(--pr-ruby-glow);
  border: 1px solid rgba(192,68,90,.18);
  border-radius: var(--pr-r);
  font-size: .76rem;
  color: rgba(224,90,114,.75);
  line-height: 1.65;
  font-weight: 300;
}

#portal-root .pr-admin-warn svg {
  width: 13px;
  height: 13px;
  flex-shrink: 0;
  margin-top: 2px;
  color: var(--pr-ruby2);
}

/* Submit buttons */
#portal-root .pr-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 9px;
  width: 100%;
  height: 52px;
  font-family: var(--pr-sans);
  font-size: .9rem;
  font-weight: 600;
  letter-spacing: -.01em;
  border: none;
  border-radius: var(--pr-r);
  cursor: pointer;
  position: relative;
  overflow: hidden;
  transition: transform .18s var(--pr-ease), box-shadow .18s var(--pr-ease), opacity .14s;
  margin-top: .25rem;
  text-decoration: none;
}

#portal-root .pr-btn::after {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255,255,255,.07), transparent);
  transition: left .45s;
  pointer-events: none;
}

#portal-root .pr-btn:hover::after { left: 100%; }

#portal-root .pr-btn:hover:not(:disabled) { transform: translateY(-1px); }

#portal-root .pr-btn:active:not(:disabled) { transform: scale(.985); }

#portal-root .pr-btn:disabled { opacity: .4; cursor: not-allowed; }

/* Member button */
#portal-root .pr-btn-member {
  background: linear-gradient(135deg, #1e2028 0%, #2d3141 100%);
  color: var(--pr-text);
  border: 1px solid var(--pr-border3);
  box-shadow: 0 4px 20px rgba(0,0,0,.3), 0 1px 3px rgba(0,0,0,.2);
}

#portal-root .pr-btn-member:hover:not(:disabled) {
  background: linear-gradient(135deg, #252830 0%, #343848 100%);
  border-color: rgba(212,168,67,.25);
  box-shadow: 0 8px 30px rgba(0,0,0,.38), 0 0 20px rgba(212,168,67,.06);
}

/* Admin button */
#portal-root .pr-btn-admin {
  background: linear-gradient(135deg, var(--pr-gold3) 0%, var(--pr-gold) 50%, var(--pr-gold3) 100%);
  background-size: 200% 100%;
  background-position: 0% 0%;
  color: #1a1200;
  box-shadow: 0 4px 20px rgba(212,168,67,.28), 0 1px 3px rgba(0,0,0,.2);
  transition: transform .18s var(--pr-ease), box-shadow .18s var(--pr-ease),
              background-position .4s var(--pr-ease), opacity .14s;
}

#portal-root .pr-btn-admin:hover:not(:disabled) {
  background-position: 100% 0%;
  box-shadow: 0 8px 30px rgba(212,168,67,.38), 0 2px 6px rgba(0,0,0,.2);
}

/* Spinner inside button */
#portal-root .pr-btn-spinner {
  display: none;
  flex-shrink: 0;
}

#portal-root .pr-btn-spinner svg {
  width: 17px;
  height: 17px;
  animation: prSpin .65s linear infinite;
}

/* Arrow inside button */
#portal-root .pr-btn-arrow {
  display: flex;
  align-items: center;
  opacity: .4;
  transition: transform .2s, opacity .2s;
  flex-shrink: 0;
}

#portal-root .pr-btn-arrow svg { width: 14px; height: 14px; }

#portal-root .pr-btn:hover:not(:disabled) .pr-btn-arrow {
  transform: translateX(3px);
  opacity: 1;
}

/* Footer area */
#portal-root .pr-form-footer {
  margin-top: 2rem;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: .8rem;
  animation: prSlideUp .5s var(--pr-ease) .18s both;
}

#portal-root .pr-foot-row {
  display: flex;
  align-items: center;
  gap: 6px;
  font-size: .8rem;
  color: var(--pr-text3);
  font-weight: 300;
}

#portal-root .pr-link {
  font-weight: 600;
  text-decoration: none;
  transition: color .14s;
}

#portal-root .pr-link-gold { color: var(--pr-gold); }
#portal-root .pr-link-gold:hover { color: var(--pr-gold2); }
#portal-root .pr-link-ruby { color: var(--pr-ruby); }
#portal-root .pr-link-ruby:hover { color: var(--pr-ruby2); }

#portal-root .pr-back-link {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  font-family: var(--pr-mono);
  font-size: .52rem;
  color: var(--pr-text4);
  letter-spacing: .07em;
  text-transform: uppercase;
  text-decoration: none;
  padding: 5px 9px;
  border-radius: 5px;
  transition: color .14s, background .14s;
}

#portal-root .pr-back-link:hover {
  color: var(--pr-text2);
  background: rgba(232,228,220,.05);
}

#portal-root .pr-back-link svg {
  width: 10px;
  height: 10px;
  transition: transform .18s;
}

#portal-root .pr-back-link:hover svg {
  transform: translateX(-2px);
}

#portal-root .pr-ssl-badge {
  display: flex;
  align-items: center;
  gap: 5px;
  font-family: var(--pr-mono);
  font-size: .48rem;
  color: var(--pr-text4);
  letter-spacing: .07em;
  text-transform: uppercase;
}

#portal-root .pr-ssl-badge svg { width: 9px; height: 9px; color: var(--pr-green); opacity: .5; }

/* ═══════════════════════════════
   TICKER BAR
═══════════════════════════════ */
#portal-ticker {
  position: fixed;
  bottom: 0;
  left: 0;
  right: 0;
  z-index: 9999;
  height: 30px;
  overflow: hidden;
  background: rgba(10,11,15,.95);
  border-top: 1px solid rgba(212,168,67,.12);
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
}

#portal-ticker::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 1px;
  background: linear-gradient(90deg, transparent, rgba(212,168,67,.25), transparent);
}

#portal-ticker .tck-track {
  display: flex;
  height: 100%;
  width: max-content;
  animation: prTicker 55s linear infinite;
}

#portal-ticker .tck-item {
  display: flex;
  align-items: center;
  gap: 9px;
  padding: 0 1.5rem;
  font-family: var(--pr-mono);
  font-size: .5rem;
  color: rgba(232,228,220,.22);
  letter-spacing: .12em;
  text-transform: uppercase;
  white-space: nowrap;
}

#portal-ticker .tck-dot {
  width: 3px;
  height: 3px;
  border-radius: 50%;
  background: var(--pr-gold);
  opacity: .45;
  flex-shrink: 0;
}

/* ═══════════════════════════════
   ANIMATIONS
═══════════════════════════════ */
@keyframes prSlideUp {
  from { opacity: 0; transform: translateY(14px); }
  to   { opacity: 1; transform: translateY(0); }
}

@keyframes prPulse {
  0%, 100% { opacity: 1; }
  50%       { opacity: .2; }
}

@keyframes prSpin {
  to { transform: rotate(360deg); }
}

@keyframes prTicker {
  from { transform: translateX(0); }
  to   { transform: translateX(-50%); }
}

@keyframes prShake {
  0%, 100% { transform: translateX(0); }
  20%       { transform: translateX(-6px); }
  40%       { transform: translateX(6px); }
  60%       { transform: translateX(-3px); }
  80%       { transform: translateX(3px); }
}

#portal-root .pr-shake {
  animation: prShake .32s ease;
}

/* ═══════════════════════════════
   FOCUS VISIBLE
═══════════════════════════════ */
#portal-root *:focus-visible {
  outline: 2px solid var(--pr-gold);
  outline-offset: 2px;
  border-radius: 4px;
}

#portal-root .pr-panel-admin *:focus-visible {
  outline-color: var(--pr-ruby);
}

/* ═══════════════════════════════
   RESPONSIVE
═══════════════════════════════ */
@media (max-width: 520px) {
  #portal-root .pr-title { font-size: 2.2rem; }
  #portal-root .pr-center { padding: 2.5rem 1.25rem 5.5rem; }
  #portal-root .pr-tab-btn { font-size: .775rem; padding: 9px 10px; }
}
</style>
</head>
<body>

<div id="portal-root">

  <!-- ══ LEFT PANEL ══ -->
  <aside class="pr-left" aria-label="Informasi portal">
    <div class="pr-left-orb"></div>
    <div class="pr-left-orb2"></div>
    <div class="pr-left-grid"></div>
    <div class="pr-left-accent"></div>

    <div class="pr-left-inner">

      <!-- Brand -->
      <div class="pr-brand">
        <div class="pr-brand-icon">
          <img src="<?= BASE_URL ?>/assets/img/logo-com.png" alt="Logo"
               onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
          <div class="pr-brand-icon-fb" style="display:none">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
          </div>
        </div>
        <div>
          <div class="pr-brand-name"><?= htmlspecialchars($settings['org_name']['value'] ?? APP_NAME) ?></div>
          <div class="pr-brand-sub">Management Portal</div>
        </div>
      </div>

      <!-- Content -->
      <div class="pr-left-content">
        <div class="pr-eyebrow">Platform Resmi</div>
        <h2 class="pr-left-title">Kelola <em>organisasi</em><br>lebih cerdas.</h2>
        <p class="pr-left-desc">Sistem manajemen anggota, kegiatan, dan administrasi terintegrasi dalam satu platform modern.</p>

        <!-- Stats -->
        <div class="pr-stats">
          <div class="pr-stat">
            <div class="pr-stat-n" id="prStatA">—</div>
            <div class="pr-stat-l">Anggota</div>
          </div>
          <div class="pr-stat">
            <div class="pr-stat-n" id="prStatB">—</div>
            <div class="pr-stat-l">Aktif Ini</div>
          </div>
          <div class="pr-stat">
            <div class="pr-stat-n">99%</div>
            <div class="pr-stat-l">Uptime</div>
          </div>
        </div>

        <!-- Features -->
        <div class="pr-features">
          <div class="pr-feat">
            <div class="pr-feat-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <div>
              <div class="pr-feat-title">Manajemen Anggota</div>
              <div class="pr-feat-desc">Data terpusat dengan riwayat lengkap dan berlapis.</div>
            </div>
          </div>
          <div class="pr-feat">
            <div class="pr-feat-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <div>
              <div class="pr-feat-title">Absensi &amp; Kegiatan</div>
              <div class="pr-feat-desc">Rekap kehadiran dan jadwal secara real-time.</div>
            </div>
          </div>
          <div class="pr-feat">
            <div class="pr-feat-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            </div>
            <div>
              <div class="pr-feat-title">Keamanan Data</div>
              <div class="pr-feat-desc">Enkripsi end-to-end &amp; proteksi CSRF aktif.</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Left footer -->
      <div class="pr-left-foot">
        <div class="pr-status">
          <div class="pr-status-dot"></div>
          Semua sistem aktif
        </div>
        <div class="pr-left-copy">&copy; <?= date('Y') ?> <?= htmlspecialchars($settings['org_name']['value'] ?? APP_NAME) ?></div>
      </div>

    </div>
  </aside>

  <!-- ══ MAIN PANEL ══ -->
  <main class="pr-main">
    <div class="pr-corner pr-corner-tl"></div>
    <div class="pr-corner pr-corner-br"></div>

    <div class="pr-center">

      <!-- Mobile brand -->
      <div class="pr-m-brand">
        <div class="pr-m-brand-icon">
          <img src="<?= BASE_URL ?>/assets/img/logo-com.png" alt="Logo"
               onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
          <div style="display:none;color:var(--pr-gold2)">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="16" height="16"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
          </div>
        </div>
        <div>
          <div class="pr-m-brand-name"><?= htmlspecialchars($settings['org_name']['value'] ?? APP_NAME) ?></div>
          <div class="pr-m-brand-sub">Management Portal</div>
        </div>
      </div>

      <div class="pr-card">

        <!-- Header -->
        <div class="pr-head">
          <div class="pr-badge">
            <span class="pr-badge-dot"></span>
            Masuk ke Portal
          </div>
          <h1 class="pr-title">Selamat <em>datang</em><br>kembali</h1>
          <p class="pr-subtitle">Akses dasbor dan kelola data organisasi Anda dengan aman.</p>
        </div>

        <!-- PHP flash alert -->
        <?php if (!empty($flash)): ?>
        <div class="pr-alert <?= $flash['type'] === 'error' ? 'pr-alert-error' : 'pr-alert-success' ?>"
             role="alert" data-auto-dismiss="6000">
          <?php if ($flash['type'] === 'error'): ?>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
          <?php else: ?>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
          <?php endif; ?>
          <span><?= htmlspecialchars($flash['msg']) ?></span>
        </div>
        <?php endif; ?>

        <!-- JS alert -->
        <div class="pr-alert" id="pr-jsa" role="alert" aria-live="polite" style="display:none"></div>

        <!-- Tab switcher -->
        <div class="pr-tabs" role="tablist" aria-label="Tipe akun">
          <div class="pr-tab-slider" id="pr-slider" data-active="member"></div>
          <button class="pr-tab-btn pr-tab-active" data-t="member"
                  role="tab" aria-selected="true" aria-controls="pr-panel-member" id="pr-tab-member">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            Anggota
          </button>
          <button class="pr-tab-btn" data-t="admin"
                  role="tab" aria-selected="false" aria-controls="pr-panel-admin" id="pr-tab-admin">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            Administrator
          </button>
        </div>

        <!-- Slide track -->
        <div class="pr-viewport">
          <div class="pr-track" id="pr-track">

            <!-- Anggota panel -->
            <div class="pr-slide" id="pr-panel-member" role="tabpanel" aria-labelledby="pr-tab-member">
              <form method="POST" action="<?= BASE_URL ?>/login"
                    class="pr-fields pr-panel-member" id="pr-form-member" novalidate autocomplete="on">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
                <input type="hidden" name="login_type" value="member">

                <div class="pr-field">
                  <div class="pr-label-row">
                    <label class="pr-label" for="pr-inp-nia">Nomor Induk Anggota (NIA)</label>
                    <span class="pr-label-note">Wajib</span>
                  </div>
                  <div class="pr-input-wrap">
                    <span class="pr-input-icon" aria-hidden="true">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="16" rx="2"/><circle cx="12" cy="10" r="3"/><path d="M7 20v-1a5 5 0 0 1 10 0v1"/></svg>
                    </span>
                    <input type="text" id="pr-inp-nia" name="nia"
                           class="pr-inp"
                           placeholder="Contoh: 2024001"
                           autocomplete="username"
                           inputmode="numeric"
                           maxlength="12"
                           value="<?= htmlspecialchars($_POST['nia'] ?? '') ?>"
                           required>
                  </div>
                  <div class="pr-hint" id="pr-hint-nia" aria-live="polite"></div>
                </div>

                <div class="pr-field">
                  <div class="pr-label-row">
                    <label class="pr-label" for="pr-inp-pw-m">Kata Sandi</label>
                  </div>
                  <div class="pr-input-wrap">
                    <span class="pr-input-icon" aria-hidden="true">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    </span>
                    <input type="password" id="pr-inp-pw-m" name="password"
                           class="pr-inp"
                           placeholder="Masukkan kata sandi"
                           autocomplete="current-password"
                           required>
                    <button type="button" class="pr-eye-btn" data-for="pr-inp-pw-m" aria-label="Tampilkan kata sandi">
                      <svg class="pr-eye-show" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                      <svg class="pr-eye-hide" style="display:none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                    </button>
                  </div>
                  <div class="pr-pw-strength" id="pr-pws-m">
                    <div class="pr-pw-bar-bg"><div class="pr-pw-bar-fill" id="pr-pwfill-m"></div></div>
                    <div class="pr-pw-meta">
                      <span id="pr-pwlabel-m" style="color:var(--pr-text4)"></span>
                      <div class="pr-pw-dots">
                        <div class="pr-pw-dot" id="pr-pwdot-m-1"></div>
                        <div class="pr-pw-dot" id="pr-pwdot-m-2"></div>
                        <div class="pr-pw-dot" id="pr-pwdot-m-3"></div>
                        <div class="pr-pw-dot" id="pr-pwdot-m-4"></div>
                      </div>
                    </div>
                  </div>
                </div>

                <button type="submit" class="pr-btn pr-btn-member" id="pr-btn-member">
                  <span class="pr-btn-spinner" id="pr-sp-member">
                    <svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" opacity=".25"/><path d="M22 12a10 10 0 01-10 10" stroke="currentColor" stroke-width="3" stroke-linecap="round"/></svg>
                  </span>
                  <span class="pr-btn-label">Masuk sebagai Anggota</span>
                  <span class="pr-btn-arrow">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                  </span>
                </button>
              </form>
            </div>

            <!-- Admin panel -->
            <div class="pr-slide" id="pr-panel-admin" role="tabpanel" aria-labelledby="pr-tab-admin">
              <form method="POST" action="<?= BASE_URL ?>/login"
                    class="pr-fields pr-panel-admin" id="pr-form-admin" novalidate autocomplete="on">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
                <input type="hidden" name="login_type" value="admin">

                <div class="pr-field">
                  <div class="pr-label-row">
                    <label class="pr-label" for="pr-inp-email">Alamat Email</label>
                    <span class="pr-label-note">Wajib</span>
                  </div>
                  <div class="pr-input-wrap">
                    <span class="pr-input-icon" aria-hidden="true">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    </span>
                    <input type="email" id="pr-inp-email" name="email"
                           class="pr-inp"
                           placeholder="admin@organisasi.id"
                           autocomplete="email"
                           required>
                  </div>
                  <div class="pr-hint" id="pr-hint-email" aria-live="polite"></div>
                </div>

                <div class="pr-field">
                  <div class="pr-label-row">
                    <label class="pr-label" for="pr-inp-pw-a">Kata Sandi Administrator</label>
                  </div>
                  <div class="pr-input-wrap">
                    <span class="pr-input-icon" aria-hidden="true">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    </span>
                    <input type="password" id="pr-inp-pw-a" name="password"
                           class="pr-inp"
                           placeholder="Masukkan kata sandi"
                           autocomplete="current-password"
                           required>
                    <button type="button" class="pr-eye-btn" data-for="pr-inp-pw-a" aria-label="Tampilkan kata sandi">
                      <svg class="pr-eye-show" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                      <svg class="pr-eye-hide" style="display:none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                    </button>
                  </div>
                  <div class="pr-pw-strength" id="pr-pws-a">
                    <div class="pr-pw-bar-bg"><div class="pr-pw-bar-fill" id="pr-pwfill-a"></div></div>
                    <div class="pr-pw-meta">
                      <span id="pr-pwlabel-a" style="color:var(--pr-text4)"></span>
                      <div class="pr-pw-dots">
                        <div class="pr-pw-dot" id="pr-pwdot-a-1"></div>
                        <div class="pr-pw-dot" id="pr-pwdot-a-2"></div>
                        <div class="pr-pw-dot" id="pr-pwdot-a-3"></div>
                        <div class="pr-pw-dot" id="pr-pwdot-a-4"></div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="pr-admin-warn" role="note">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                  <span>Area ini hanya untuk staf administrator berwenang. Akses tidak sah akan dicatat dan dilaporkan kepada tim keamanan.</span>
                </div>

                <button type="submit" class="pr-btn pr-btn-admin" id="pr-btn-admin">
                  <span class="pr-btn-spinner" id="pr-sp-admin">
                    <svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" opacity=".25"/><path d="M22 12a10 10 0 01-10 10" stroke="currentColor" stroke-width="3" stroke-linecap="round"/></svg>
                  </span>
                  <span class="pr-btn-label">Masuk sebagai Administrator</span>
                  <span class="pr-btn-arrow">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                  </span>
                </button>
              </form>
            </div>

          </div><!-- /pr-track -->
        </div><!-- /pr-viewport -->

        <!-- Form footer -->
        <div class="pr-form-footer">
          <div id="pr-foot-member" class="pr-foot-row">
            <span>Belum punya akun?</span>
            <a href="<?= BASE_URL ?>/pab" class="pr-link pr-link-gold">Daftar sekarang</a>
          </div>
          <div id="pr-foot-admin" class="pr-foot-row" style="display:none">
            <span>Butuh akses admin?</span>
            <a href="mailto:it@organisasi.id" class="pr-link pr-link-ruby">Hubungi tim IT</a>
          </div>
          <a href="<?= BASE_URL ?>/" class="pr-back-link">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Kembali ke beranda
          </a>
          <div class="pr-ssl-badge">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            Koneksi terenkripsi SSL
          </div>
        </div>

      </div><!-- /pr-card -->
    </div><!-- /pr-center -->
  </main>

</div><!-- /portal-root -->

<!-- Ticker bar -->
<div id="portal-ticker" aria-hidden="true">
  <div class="tck-track">
    <?php
      $raw   = $settings['ticker_items']['value'] ?? 'COM Academy|Penerimaan Anggota Baru|Tech Talk & Workshop|Creative Festival|Absensi Digital|Manajemen Anggota|Platform Modern';
      $items = array_filter(array_map('trim', explode('|', $raw)));
      $all   = array_merge($items, $items);
      foreach ($all as $item):
    ?>
    <span class="tck-item">
      <span class="tck-dot"></span>
      <?= htmlspecialchars($item) ?>
    </span>
    <?php endforeach; ?>
  </div>
</div>

<script>
(function () {
'use strict';

/* ── Refs ── */
var root    = document.getElementById('portal-root');
var track   = document.getElementById('pr-track');
var slider  = document.getElementById('pr-slider');
var tabs    = root.querySelectorAll('.pr-tab-btn');
var jsa     = document.getElementById('pr-jsa');
var footM   = document.getElementById('pr-foot-member');
var footA   = document.getElementById('pr-foot-admin');
var cur     = 'member';
var REX_EMAIL = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;

/* ── Counter animation ── */
function countUp(el, end, suffix, dur) {
  if (!el) return;
  var t0 = null;
  function step(ts) {
    if (!t0) t0 = ts;
    var prog = Math.min((ts - t0) / dur, 1);
    var ease = 1 - Math.pow(1 - prog, 3);
    el.textContent = Math.round(ease * end) + (suffix || '');
    if (prog < 1) requestAnimationFrame(step);
  }
  requestAnimationFrame(step);
}
setTimeout(function () {
  countUp(document.getElementById('prStatA'), 248, '', 1400);
  countUp(document.getElementById('prStatB'), 91, '%', 1100);
}, 900);

/* ── Alert ── */
var ICO_ERR = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>';
var ICO_OK  = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>';

function showAlert(type, msg) {
  jsa.className = 'pr-alert ' + (type === 'error' ? 'pr-alert-error' : 'pr-alert-success');
  jsa.innerHTML = (type === 'error' ? ICO_ERR : ICO_OK) + '<span>' + esc(msg) + '</span>';
  jsa.style.display = 'flex';
}
function hideAlert() { jsa.style.display = 'none'; }

/* Auto-dismiss PHP flash alert */
document.querySelectorAll('.pr-alert[data-auto-dismiss]').forEach(function (el) {
  var ms = parseInt(el.dataset.autoDismiss, 10) || 6000;
  setTimeout(function () {
    el.style.transition = 'opacity .3s ease, transform .3s ease';
    el.style.opacity = '0';
    el.style.transform = 'translateY(-4px)';
    setTimeout(function () { el.remove(); }, 350);
  }, ms);
});

/* ── Tab switch ── */
function switchTab(t) {
  if (t === cur) return;
  cur = t;

  tabs.forEach(function (btn) {
    var on = btn.dataset.t === t;
    btn.classList.toggle('pr-tab-active', on);
    btn.setAttribute('aria-selected', on ? 'true' : 'false');
  });

  track.style.transform = (t === 'admin') ? 'translateX(-100%)' : 'translateX(0)';
  slider.dataset.active = t;
  footM.style.display = (t === 'member') ? '' : 'none';
  footA.style.display = (t === 'admin')  ? '' : 'none';
  hideAlert();
}

tabs.forEach(function (btn) {
  btn.addEventListener('click', function () { switchTab(btn.dataset.t); });
});

/* Arrow key nav on tabs */
var tabsArr = Array.from(tabs);
tabsArr.forEach(function (btn, i) {
  btn.addEventListener('keydown', function (e) {
    var nxt;
    if (e.key === 'ArrowRight' || e.key === 'ArrowDown')
      nxt = tabsArr[(i + 1) % tabsArr.length];
    if (e.key === 'ArrowLeft'  || e.key === 'ArrowUp')
      nxt = tabsArr[(i - 1 + tabsArr.length) % tabsArr.length];
    if (nxt) { nxt.click(); nxt.focus(); e.preventDefault(); }
  });
});

/* ── Shake ── */
function shake(el) {
  if (!el) return;
  el.classList.remove('pr-shake');
  void el.offsetWidth;
  el.classList.add('pr-shake');
  el.addEventListener('animationend', function () {
    el.classList.remove('pr-shake');
  }, { once: true });
}

/* ── Eye toggle ── */
root.querySelectorAll('.pr-eye-btn[data-for]').forEach(function (btn) {
  btn.addEventListener('click', function () {
    var inp = document.getElementById(btn.dataset.for);
    if (!inp) return;
    var showing = inp.type === 'password';
    inp.type = showing ? 'text' : 'password';
    btn.querySelector('.pr-eye-show').style.display = showing ? 'none' : '';
    btn.querySelector('.pr-eye-hide').style.display = showing ? '' : 'none';
    btn.setAttribute('aria-label', showing ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi');
    inp.focus();
  });
});

/* ── NIA validation ── */
var niaEl   = document.getElementById('pr-inp-nia');
var niaHint = document.getElementById('pr-hint-nia');
var CHK_SVG = '<svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>';

if (niaEl) {
  niaEl.addEventListener('input', function () {
    this.value = this.value.replace(/\D/g, '');
    var v = this.value;
    if (!v) {
      niaHint.innerHTML = '';
      niaHint.className = 'pr-hint';
      this.classList.remove('pr-invalid');
      return;
    }
    if (v.length >= 5 && v.length <= 12) {
      niaHint.innerHTML = CHK_SVG + ' Format NIA valid';
      niaHint.className = 'pr-hint pr-hint-ok';
      this.classList.remove('pr-invalid');
    } else {
      niaHint.textContent = 'Masukkan 5–12 digit angka';
      niaHint.className = 'pr-hint pr-hint-err';
    }
  });
}

/* ── Email validation ── */
var emailEl   = document.getElementById('pr-inp-email');
var emailHint = document.getElementById('pr-hint-email');

if (emailEl) {
  emailEl.addEventListener('input', function () {
    var v = this.value;
    if (!v) {
      emailHint.innerHTML = '';
      emailHint.className = 'pr-hint';
      this.classList.remove('pr-invalid');
      return;
    }
    var ok = REX_EMAIL.test(v);
    emailHint.innerHTML = ok ? CHK_SVG + ' Format email valid' : 'Format email tidak valid';
    emailHint.className = 'pr-hint ' + (ok ? 'pr-hint-ok' : 'pr-hint-err');
    this.classList.toggle('pr-invalid', !ok);
  });
}

/* ── Password strength ── */
var PW_COLORS = ['#cc4444', '#c07030', '#b88a2a', '#3aaa72'];
var PW_LABELS = ['Lemah', 'Cukup', 'Kuat', 'Sangat Kuat'];

function pwScore(v) {
  var s = 0;
  if (v.length >= 8)  s++;
  if (v.length >= 12) s++;
  if (/[A-Z]/.test(v) && /[a-z]/.test(v)) s++;
  if (/[0-9]/.test(v)) s++;
  if (/[^A-Za-z0-9]/.test(v)) s++;
  return Math.min(3, Math.max(0, s - 1));
}

function updatePwStrength(inp, wrapId, fillId, labelId, dotPrefix) {
  var v     = inp.value;
  var wrap  = document.getElementById(wrapId);
  var fill  = document.getElementById(fillId);
  var label = document.getElementById(labelId);
  if (!v) { wrap.style.display = 'none'; return; }
  wrap.style.display = '';
  var sc = pwScore(v);
  fill.style.width      = ((sc + 1) / 4 * 100) + '%';
  fill.style.background = PW_COLORS[sc];
  label.textContent     = PW_LABELS[sc];
  label.style.color     = PW_COLORS[sc];
  for (var i = 1; i <= 4; i++) {
    var dot = document.getElementById(dotPrefix + i);
    if (!dot) continue;
    dot.classList.toggle('pr-dot-on', i - 1 <= sc);
    dot.style.background = (i - 1 <= sc) ? PW_COLORS[sc] : '';
  }
}

var pwM = document.getElementById('pr-inp-pw-m');
var pwA = document.getElementById('pr-inp-pw-a');

if (pwM) {
  pwM.addEventListener('input', function () {
    updatePwStrength(this, 'pr-pws-m', 'pr-pwfill-m', 'pr-pwlabel-m', 'pr-pwdot-m-');
  });
}
if (pwA) {
  pwA.addEventListener('input', function () {
    updatePwStrength(this, 'pr-pws-a', 'pr-pwfill-a', 'pr-pwlabel-a', 'pr-pwdot-a-');
  });
}

/* ── Form submit ── */
[
  { formId: 'pr-form-member', type: 'member', btnId: 'pr-btn-member', spId: 'pr-sp-member' },
  { formId: 'pr-form-admin',  type: 'admin',  btnId: 'pr-btn-admin',  spId: 'pr-sp-admin'  }
].forEach(function (cfg) {
  var frm = document.getElementById(cfg.formId);
  if (!frm) return;

  frm.addEventListener('submit', function (e) {
    hideAlert();
    var valid = true;
    var first = null;

    frm.querySelectorAll('input[required]').forEach(function (f) {
      if (!f.value.trim()) {
        valid = false;
        f.classList.add('pr-invalid');
        setTimeout(function () { f.classList.remove('pr-invalid'); }, 2800);
        if (!first) first = f;
      }
    });

    if (!valid) {
      e.preventDefault();
      showAlert('error', 'Harap isi semua kolom yang diperlukan.');
      shake(frm.querySelector('.pr-btn'));
      if (first) first.focus();
      return;
    }

    if (cfg.type === 'admin') {
      var em = document.getElementById('pr-inp-email');
      if (em && !REX_EMAIL.test(em.value)) {
        e.preventDefault();
        showAlert('error', 'Masukkan alamat email yang valid.');
        em.classList.add('pr-invalid');
        setTimeout(function () { em.classList.remove('pr-invalid'); }, 2800);
        shake(em.closest('.pr-input-wrap'));
        em.focus();
        return;
      }
    }

    /* Loading state */
    var btn = document.getElementById(cfg.btnId);
    var sp  = document.getElementById(cfg.spId);
    var lbl = frm.querySelector('.pr-btn-label');
    var arr = frm.querySelector('.pr-btn-arrow');
    if (btn) btn.disabled = true;
    if (sp)  sp.style.display = 'flex';
    if (lbl) lbl.textContent = 'Memproses…';
    if (arr) arr.style.display = 'none';
  });
});

/* ── Utils ── */
function esc(s) {
  return String(s)
    .replace(/&/g, '&amp;').replace(/</g, '&lt;')
    .replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}

}());
</script>
</body>
</html>