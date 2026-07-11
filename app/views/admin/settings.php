<?php
// app/views/admin/settings.php
// CMS Admin — Kelola seluruh konten halaman home
?>
<style>
/* ═══════════════════════════════════════════════════
   CMS ADMIN — selaras design system (dashboard/absensi/berita)
   PERBAIKAN: token di-scope ke .cms-root (BUKAN :root global)
   supaya tidak bentrok/bocor ke halaman admin lain yang dirender
   dalam layout yang sama.
═══════════════════════════════════════════════════ */
.cms-root {
  --font-ui:   var(--ff, 'Plus Jakarta Sans', sans-serif);
  --font-mono: var(--ff, 'Plus Jakarta Sans', sans-serif);

  /* Surface */
  --bg:    var(--c-page,  #eef2f6);
  --bg-s:  var(--c-white, #ffffff);
  --bg-e:  #f8fafc;
  --bg-o:  #eef2f6;

  /* Border */
  --bd:    var(--c-border, #e6ebf1);
  --bd2:   rgba(15,23,42,.16);
  --bd-ac: var(--c-primary-lt, #06b6d4);

  /* Text */
  --tx:  var(--c-ink,    #0f172a);
  --tx2: var(--c-muted,  #64748b);
  --tx3: var(--c-muted2, #94a3b8);

  /* Aksen — satu-satunya warna aksen dekoratif */
  --ac:   var(--c-primary,    #0e7490);
  --ac-d: var(--c-primary-08, rgba(14,116,144,.08));
  --ac-g: var(--c-primary-12, rgba(14,116,144,.12));

  /* Status */
  --grn:   var(--c-green-text,   #15803d);
  --grn-d: var(--c-green-bg,     #f0fdf4);
  --red:   var(--c-red-text,     #b91c1c);
  --red-d: var(--c-red-bg,       #fef2f2);
  --amb:   var(--c-amber-icon,   #d9910c);
  --amb-d: var(--c-amber-bg,     #fef6e2);
  --pur:   var(--c-primary-dk,   #0b5a70);
  --pur-d: var(--c-primary-08,   rgba(14,116,144,.08));

  /* Radius */
  --r:  var(--radius-sm, 9px);
  --r2: var(--radius-md, 13px);
  --r3: var(--radius-lg, 22px);
  --ease: cubic-bezier(.16,1,.3,1);
}

.cms-root { font-family: var(--font-ui); color: var(--tx); font-size: 13px; }
.cms-root *, .cms-root *::before, .cms-root *::after { box-sizing: border-box; margin:0; padding:0; }

/* ── Page Header ── */
.cms-ph {
  display: flex; align-items: flex-start; justify-content: space-between;
  gap: 16px; flex-wrap: wrap; margin-bottom: 24px;
}
.cms-ph__eyebrow {
  font-family: var(--font-mono); font-size: 11px; font-weight: 700;
  letter-spacing: .1em; text-transform: uppercase; color: var(--ac);
  display: inline-flex; align-items: center; gap: 7px; margin-bottom: 6px;
}
.cms-ph__eyebrow::before {
  content:''; width:6px; height:6px; border-radius:50%;
  background: var(--ac); box-shadow: 0 0 8px var(--ac);
}
.cms-ph__title { font-size: 24px; font-weight: 800; letter-spacing: -.03em; line-height:1.1; color: var(--pur); }
.cms-ph__sub   { font-size:13px; color:var(--tx2); margin-top:5px; }

/* ── Flash ── */
.cms-flash {
  display:flex; align-items:center; gap:10px;
  padding: 11px 15px; border-radius: var(--r); font-size:12.5px; font-weight:600;
  border: 1px solid transparent; margin-bottom:20px;
}
.cms-flash--success { background:var(--grn-d); color:var(--grn); border-color: rgba(21,128,61,.22); }
.cms-flash--error   { background:var(--red-d); color:var(--red); border-color: rgba(185,28,28,.22); }

/* ══════════════════════════════════════════════════
   TAB NAVIGATION
══════════════════════════════════════════════════ */
.cms-tabs {
  display: flex; gap: 2px;
  background: var(--bg-s); border: 1px solid var(--bd);
  border-radius: var(--r2); padding: 4px;
  margin-bottom: 24px; flex-wrap: wrap;
}
.cms-tab {
  display: flex; align-items: center; gap: 7px;
  padding: 8px 14px; border-radius: var(--r);
  font-size:12px; font-weight:700; color: var(--tx3);
  cursor: pointer; transition: all 160ms var(--ease);
  border: none; background: none;
  white-space: nowrap;
}
.cms-tab svg { width:13px; height:13px; flex-shrink:0; }
.cms-tab:hover { color: var(--tx2); background: var(--bg-e); }
.cms-tab.active {
  background: var(--ac); color: #fff;
  box-shadow: 0 3px 12px rgba(14,116,144,.25);
}

/* ══════════════════════════════════════════════════
   TAB PANELS
══════════════════════════════════════════════════ */
.cms-panel { display: none; }
.cms-panel.active { display: flex; flex-direction: column; gap: 16px; }

/* ══════════════════════════════════════════════════
   CARDS
══════════════════════════════════════════════════ */
.cms-card {
  background: var(--bg-s); border: 1px solid var(--bd);
  border-radius: var(--r3); overflow: hidden;
}
.cms-card__head {
  display: flex; align-items: center; gap: 12px;
  padding: 14px 18px; border-bottom: 1px solid var(--bd);
}
.cms-card__ico {
  width:32px; height:32px; border-radius: var(--r);
  display:flex; align-items:center; justify-content:center; flex-shrink:0;
}
.cms-card__ico svg { width:15px; height:15px; }
.cms-card__ico--blue   { background:var(--ac-d);  color:var(--ac); }
.cms-card__ico--green  { background:var(--grn-d); color:var(--grn); }
.cms-card__ico--amber  { background:var(--amb-d); color:var(--amb); }
.cms-card__ico--purple { background:var(--pur-d); color:var(--pur); }
.cms-card__ico--red    { background:var(--red-d); color:var(--red); }
.cms-card__title { font-size:13px; font-weight:800; letter-spacing:-.01em; }
.cms-card__desc  { font-size:11.5px; color:var(--tx3); margin-top:2px; }
.cms-card__body  { padding: 18px; display:flex; flex-direction:column; gap:14px; }

/* ══════════════════════════════════════════════════
   FORM ELEMENTS
══════════════════════════════════════════════════ */
.fg       { display:flex; flex-direction:column; gap:6px; }
.fg--2    { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
.fg--3    { display:grid; grid-template-columns:1fr 1fr 1fr; gap:12px; }
@media(max-width:680px){
  .fg--2,.fg--3 { grid-template-columns:1fr; }
}

label.lbl {
  font-size:11.5px; font-weight:700; color:var(--tx2); letter-spacing:.01em;
  display:flex; align-items:center; gap:6px;
}
.lbl__hint {
  font-family:var(--font-mono); font-size:10px; color:var(--tx3);
  font-weight:400; margin-left:auto;
}
.lbl__badge {
  font-family:var(--font-mono); font-size:9px; padding:2px 7px;
  border-radius:99px; font-weight:700; letter-spacing:.04em;
}
.lbl__badge--stat  { background:var(--ac-d);  color:var(--ac); }
.lbl__badge--prog  { background:var(--pur-d); color:var(--pur); }
.lbl__badge--testi { background:var(--amb-d); color:var(--amb); }

input[type="text"].fi, input[type="email"].fi, input[type="tel"].fi,
input[type="url"].fi, textarea.fi, select.fi {
  width:100%; font-family:var(--font-ui); font-size:12.5px; color:var(--tx);
  background:#fbfcfe; border:1.5px solid var(--bd); border-radius:var(--r);
  padding:10px 12px; outline:none; display:block; -webkit-appearance:none;
  transition: border-color 140ms, background 140ms, box-shadow 140ms;
}
input[type="text"].fi:focus, input[type="email"].fi:focus, input[type="tel"].fi:focus,
input[type="url"].fi:focus, textarea.fi:focus, select.fi:focus {
  border-color: var(--bd-ac); background: #fff;
  box-shadow: 0 0 0 3px rgba(6,182,212,.12);
}
input[type="text"].fi::placeholder, textarea.fi::placeholder { color:var(--tx3); }
textarea.fi { resize:vertical; min-height:68px; line-height:1.65; }

/* ── Image Upload ── */
.img-upload {
  display:flex; align-items:center; gap:14px;
}
.img-thumb {
  width:64px; height:64px; border-radius:var(--r2);
  border:1px solid var(--bd); object-fit:cover; flex-shrink:0;
  background:var(--bg-o);
}
.img-thumb--empty {
  display:flex; align-items:center; justify-content:center; color:var(--tx3);
}
.img-thumb--empty svg { width:22px; height:22px; opacity:.5; }
.img-thumb--sm { width:48px; height:48px; }
.img-thumb--circle { border-radius:50%; }
.img-thumb--wide {
  width:120px; height:68px; border-radius:var(--r2);
  border:1px solid var(--bd); object-fit:cover; flex-shrink:0;
  background:var(--bg-o);
}
.img-thumb--wide.img-thumb--empty svg { width:28px; height:28px; }
.img-upload__area { flex:1; display:flex; flex-direction:column; gap:6px; }
.img-upload__btn {
  display:inline-flex; align-items:center; gap:7px;
  padding:8px 13px; background:var(--bg-e); color:var(--tx2);
  font-family:var(--font-ui); font-size:12px; font-weight:700;
  border:1.5px solid var(--bd); border-radius:var(--r);
  cursor:pointer; transition:all 140ms; width:fit-content;
}
.img-upload__btn:hover { border-color:var(--bd-ac); color:var(--ac); background:var(--ac-d); }
.img-upload__btn svg { width:12px; height:12px; }
.img-upload__name { font-family:var(--font-mono); font-size:10.5px; color:var(--tx3); }

/* ── Hidden file input ──
   FIX BUG: sebelumnya position:absolute tanpa parent relative membuat
   browser salah menghitung posisi elemen ini. Akibatnya, setiap kali
   dialog "Open File" ditutup (baik pilih file MAUPUN klik Cancel),
   browser mengembalikan focus ke input ini lalu mencoba scrollIntoView
   pada container scroll (.pg di layout admin) — dan karena posisinya
   salah dihitung, halaman melompat scroll ke bawah sampai terlihat
   blank. position:fixed membuat browser selalu menganggap elemen ini
   berada di viewport, sehingga tidak pernah memicu auto-scroll saat
   menerima focus. */
input[type="file"].fhidden {
  position: fixed;
  top: 0;
  left: 0;
  width: 1px; height: 1px;
  overflow: hidden; clip: rect(0,0,0,0); white-space: nowrap; border: 0;
  padding: 0; margin: 0;
}

/* ── Hero image preview area ── */
.hero-img-preview {
  position:relative; border-radius:var(--r2); overflow:hidden;
  background:var(--bg-o); border:1px solid var(--bd);
  min-height:120px; display:flex; align-items:center; justify-content:center;
}
.hero-img-preview img {
  width:100%; max-height:200px; object-fit:cover; display:block;
}
.hero-img-preview__empty {
  display:flex; flex-direction:column; align-items:center; justify-content:center;
  gap:8px; padding:28px; color:var(--tx3); min-height:120px;
}
.hero-img-preview__empty svg { opacity:.4; }
.hero-img-preview__empty span { font-size:11.5px; }
.hero-img-badge {
  position:absolute; top:8px; right:8px;
  font-family:var(--font-mono); font-size:9px; font-weight:700;
  padding:3px 9px; border-radius:99px; letter-spacing:.06em;
  background: var(--grn-d); color:var(--grn);
  border:1px solid rgba(21,128,61,.25);
}
.hero-img-badge--pending {
  background: var(--red-d); color: var(--red);
  border-color: rgba(185,28,28,.25);
}
.hero-img-badge--none {
  background: var(--bg-o); color: var(--tx3);
  border-color: var(--bd);
}
.hero-img-controls {
  display:flex; align-items:center; gap:8px; flex-wrap:wrap;
}

/* ── Divider ── */
.fdiv { height:1px; background:var(--bd); }

/* ── Repeater group (programs/testi) ── */
.repeater { display:flex; flex-direction:column; gap:12px; }
.rep-item {
  background:var(--bg-e); border:1px solid var(--bd);
  border-radius:var(--r2); padding:14px;
  display:flex; flex-direction:column; gap:10px;
  position:relative;
}
.rep-item__head {
  display:flex; align-items:center; gap:8px; margin-bottom:2px;
}
.rep-num {
  font-family:var(--font-mono); font-size:10px; font-weight:700;
  padding:2px 9px; border-radius:99px;
  background:var(--ac-d); color:var(--ac);
}
.rep-num--prog  { background:var(--pur-d); color:var(--pur); }
.rep-num--testi { background:var(--amb-d); color:var(--amb); }
.rep-num--gal   { background:var(--grn-d); color:var(--grn); }
.rep-title { font-size:12px; font-weight:700; color:var(--tx); }

/* ── Stats grid ── */
.stat-grid { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
@media(max-width:500px){ .stat-grid { grid-template-columns:1fr; } }
.stat-input-wrap {
  background:var(--bg-e); border:1px solid var(--bd);
  border-radius:var(--r2); padding:12px 14px;
  display:flex; flex-direction:column; gap:6px;
}
.stat-input-wrap .fi { background:#fff; }

/* ── Riwayat preview rows ── */
.riwayat-row {
  display:flex; align-items:center; gap:10px;
  background:var(--bg-e); border:1px solid var(--bd);
  border-radius:var(--r); padding:8px 12px;
}
.riwayat-avatar {
  width:32px; height:32px; border-radius:50%; flex-shrink:0;
  object-fit:cover;
}
.riwayat-avatar--placeholder {
  width:32px; height:32px; border-radius:50%; flex-shrink:0;
  background: linear-gradient(135deg, var(--ac), var(--pur));
  display:flex; align-items:center; justify-content:center;
  font-weight:800; font-size:.65rem; color:#fff;
}
.riwayat-info { flex:1; min-width:0; }
.riwayat-info__name {
  font-size:12px; font-weight:700; color:var(--tx);
  white-space:nowrap; overflow:hidden; text-overflow:ellipsis;
}
.riwayat-info__period { font-size:10.5px; color:var(--tx3); }
.riwayat-edit-btn {
  font-size:11px; color:var(--ac); text-decoration:none; font-weight:600;
  padding:4px 10px; border:1px solid var(--bd-ac);
  border-radius:6px; white-space:nowrap; flex-shrink:0;
  transition: all 140ms;
}
.riwayat-edit-btn:hover { background:var(--ac-d); }

/* ── Section label ── */
.sec-lbl {
  display:flex; align-items:center; gap:10px;
}
.sec-lbl__text {
  font-family:var(--font-mono); font-size:10.5px; font-weight:700;
  letter-spacing:.14em; text-transform:uppercase; color:var(--tx3);
  white-space:nowrap;
}
.sec-lbl__line { flex:1; height:1px; background:linear-gradient(to right, var(--bd), transparent); }

/* ── Empty state ── */
.empty-state {
  font-size:12px; color:var(--tx3); text-align:center;
  padding:20px 0;
}

/* ── Info box ── */
.info-box {
  display:flex; align-items:flex-start; gap:10px;
  background:var(--ac-d); border:1px solid var(--ac-g);
  border-radius:var(--r); padding:11px 14px; font-size:12px; color:var(--tx2);
  line-height:1.6;
}
.info-box svg { flex-shrink:0; color:var(--ac); margin-top:1px; }
.info-box--red {
  background:var(--red-d); border-color: rgba(185,28,28,.2); color:var(--red);
}

/* ═══════════════════════════════════════════════════
   SAVE BAR
═══════════════════════════════════════════════════ */
.cms-savebar {
  position:sticky; bottom:0; z-index:50;
  padding:14px 0 18px;
  display:flex; align-items:center; gap:14px;
}
.cms-savebar::before {
  content:''; position:absolute; inset:0;
  background:linear-gradient(to top, var(--bg) 55%, transparent);
  z-index:-1; pointer-events:none;
}
.btn-save {
  display:inline-flex; align-items:center; gap:8px;
  padding:11px 24px; background:var(--ac); color:#fff;
  font-family:var(--font-ui); font-size:13px; font-weight:800;
  letter-spacing:-.01em; border-radius:var(--r); border:none; cursor:pointer;
  transition: all 150ms var(--ease);
  box-shadow: 0 8px 22px rgba(14,116,144,.25);
}
.btn-save:hover {
  background:var(--bd-ac);
  box-shadow: 0 12px 28px rgba(6,182,212,.3);
  transform:translateY(-1px);
}
.btn-save svg { width:14px; height:14px; }
.save-hint { font-family:var(--font-mono); font-size:10.5px; color:var(--tx3); }

/* ── Btn outline (link style) ── */
.btn-outline {
  display:inline-flex; align-items:center; gap:8px;
  padding:9px 16px; background:var(--bg-e); color:var(--tx2);
  font-family:var(--font-ui); font-size:12px; font-weight:700;
  border:1.5px solid var(--bd); border-radius:var(--r);
  text-decoration:none; cursor:pointer;
  transition: all 150ms var(--ease);
}
.btn-outline:hover { border-color:var(--bd-ac); color:var(--ac); background:var(--ac-d); }
.btn-outline svg { width:13px; height:13px; }

/* ── Btn danger ── */
.btn-danger {
  display:inline-flex; align-items:center; gap:7px;
  padding:8px 13px; background:var(--red-d); color:var(--red);
  font-family:var(--font-ui); font-size:12px; font-weight:700;
  border:1px solid rgba(185,28,28,.22); border-radius:var(--r);
  cursor:pointer; transition:all 150ms var(--ease);
}
.btn-danger:hover {
  background:rgba(185,28,28,.14); border-color:rgba(185,28,28,.4);
}
.btn-danger svg { width:12px; height:12px; }
.btn-danger:disabled {
  opacity:.4; cursor:not-allowed; pointer-events:none;
}

/* ─── Preview badge ─── */
.preview-link {
  display:inline-flex; align-items:center; gap:6px;
  padding:9px 16px; background:var(--bg-s); color:var(--tx2);
  font-size:12px; font-weight:700; border:1.5px solid var(--bd);
  border-radius:var(--r); text-decoration:none;
  transition:all 150ms;
}
.preview-link:hover { border-color:var(--bd-ac); color:var(--ac); background:var(--ac-d); }
.preview-link svg { width:12px; height:12px; }

/* ── Toggle switch ── */
.toggle-wrap {
  display:flex; align-items:center; justify-content:space-between;
  background:var(--bg-e); border:1px solid var(--bd);
  border-radius:var(--r2); padding:12px 14px; gap:12px;
}
.toggle-wrap__info { flex:1; }
.toggle-wrap__label {
  font-size:12px; font-weight:700; color:var(--tx); display:block;
}
.toggle-wrap__hint {
  font-size:10.5px; color:var(--tx3); margin-top:2px; display:block;
}

/* ── Strikethrough / deleted state ── */
.img-deleted-notice {
  display:flex; align-items:center; gap:8px;
  font-size:12px; color:var(--red); font-weight:700;
  padding:8px 12px; background:var(--red-d);
  border:1px solid rgba(185,28,28,.2); border-radius:var(--r);
}
.img-deleted-notice svg { flex-shrink:0; }
</style>

<div class="cms-root">

<!-- ── Header ── -->
<div class="cms-ph">
  <div>
    <div class="cms-ph__eyebrow">CMS &amp; Konfigurasi</div>
    <h1 class="cms-ph__title">Pengaturan Situs</h1>
    <p class="cms-ph__sub">Kelola seluruh konten halaman publik — hero, statistik, program, galeri, dan lebih banyak lagi.</p>
  </div>
  <a href="<?= BASE_URL ?>/" target="_blank" class="preview-link">
    <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
      <path d="M6 2H2.5A.5.5 0 002 2.5v9a.5.5 0 00.5.5h9a.5.5 0 00.5-.5V8M8 2h4m0 0v4m0-4L5.5 8.5"/>
    </svg>
    Preview Halaman
  </a>
</div>

<!-- ── Flash ── -->
<?php if (!empty($flash)): ?>
<div class="cms-flash cms-flash--<?= htmlspecialchars($flash['type']) ?>">
  <?php if ($flash['type'] === 'success'): ?>
    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M2 7l3.5 3.5L12 3"/></svg>
  <?php else: ?>
    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="7" cy="7" r="5.5"/><path d="M7 4.5v3"/><circle cx="7" cy="9.5" r=".5" fill="currentColor"/></svg>
  <?php endif; ?>
  <?= htmlspecialchars($flash['msg']) ?>
</div>
<?php endif; ?>

<!-- ════════════════════════════════════════
     TAB NAV
════════════════════════════════════════ -->
<div class="cms-tabs" role="tablist">
  <button class="cms-tab active" data-tab="organisasi" role="tab">
    <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M7 1L1.5 4.5v5L7 13l5.5-3.5v-5L7 1z"/><circle cx="7" cy="7" r="2"/></svg>
    Organisasi
  </button>
  <button class="cms-tab" data-tab="hero" role="tab">
    <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="2" width="12" height="10" rx="1.5"/><path d="M1 6h12"/><path d="M5 10h4"/></svg>
    Hero
  </button>
  <button class="cms-tab" data-tab="statistik" role="tab">
    <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="8" width="3" height="5" rx="1"/><rect x="5.5" y="5" width="3" height="8" rx="1"/><rect x="10" y="2" width="3" height="11" rx="1"/></svg>
    Statistik
  </button>
  <button class="cms-tab" data-tab="fitur" role="tab">
    <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="1" width="5" height="5" rx="1"/><rect x="8" y="1" width="5" height="5" rx="1"/><rect x="1" y="8" width="5" height="5" rx="1"/><rect x="8" y="8" width="5" height="5" rx="1"/></svg>
    Fitur
  </button>
  <button class="cms-tab" data-tab="program" role="tab">
    <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="7" cy="7" r="5.5"/><path d="M7 4.5v3l2 1.5"/></svg>
    Program
  </button>
  <button class="cms-tab" data-tab="galeri" role="tab">
    <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="1" width="12" height="12" rx="1.5"/><circle cx="4.5" cy="4.5" r="1.2"/><path d="M1 9.5l3-3 3 3 2-2.5 4 4"/></svg>
    Galeri
  </button>
  <button class="cms-tab" data-tab="testimoni" role="tab">
    <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12.5 9a1.5 1.5 0 01-1.5 1.5H4L1.5 13V3A1.5 1.5 0 013 1.5h8A1.5 1.5 0 0112.5 3v6z"/></svg>
    Testimoni
  </button>
  <button class="cms-tab" data-tab="sambutan" role="tab">
    <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
      <circle cx="7" cy="5" r="3"/><path d="M1 13c0-3.3 2.7-6 6-6s6 2.7 6 6"/>
    </svg>
    Sambutan
  </button>
  <button class="cms-tab" data-tab="riwayat" role="tab">
    <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
      <circle cx="7" cy="7" r="5.5"/><path d="M7 4.5v3l2 1.5"/>
    </svg>
    Riwayat
  </button>
  <button class="cms-tab" data-tab="pab" role="tab">
    <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2 2h10a1 1 0 011 1v9a1 1 0 01-1 1H2a1 1 0 01-1-1V3a1 1 0 011-1z"/><path d="M4 5h6M4 7.5h4M4 10h3"/></svg>
    PAB &amp; CTA
  </button>
</div>

<!-- ════════════════════════════════════════
     FORM
════════════════════════════════════════ -->
<form method="POST" action="<?= BASE_URL ?>/admin/settings/save"
      enctype="multipart/form-data" id="cms-form">
  <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">

  <?php
  // Helper
  $v = fn(string $k, string $d='') => htmlspecialchars($settings[$k]['value'] ?? $d);
  ?>

  <!-- ══════════════════════════════════════════════
       PANEL: ORGANISASI
  ══════════════════════════════════════════════ -->
  <div class="cms-panel active" id="panel-organisasi">

    <div class="cms-card">
      <div class="cms-card__head">
        <div class="cms-card__ico cms-card__ico--blue">
          <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M7 1L1.5 4.5v5L7 13l5.5-3.5v-5L7 1z"/><circle cx="7" cy="7" r="2"/></svg>
        </div>
        <div>
          <div class="cms-card__title">Identitas Organisasi</div>
          <div class="cms-card__desc">Nama, tagline, deskripsi, visi, misi, dan kontak.</div>
        </div>
      </div>
      <div class="cms-card__body">
        <div class="fg--2">
          <div class="fg">
            <label class="lbl" for="f-org-name">Nama Organisasi</label>
            <input id="f-org-name" name="org_name" type="text" class="fi" placeholder="COM SMKN 2 Pinrang" value="<?= $v('org_name') ?>">
          </div>
          <div class="fg">
            <label class="lbl" for="f-tagline">Tagline</label>
            <input id="f-tagline" name="org_tagline" type="text" class="fi" placeholder="Creative, Outstanding, Meaningful" value="<?= $v('org_tagline') ?>">
          </div>
        </div>
        <div class="fg--2">
          <div class="fg">
            <label class="lbl" for="f-email">Email Kontak</label>
            <input id="f-email" name="contact_email" type="email" class="fi" placeholder="email@org.id" value="<?= $v('contact_email') ?>">
          </div>
          <div class="fg">
            <label class="lbl" for="f-phone">No HP / WhatsApp</label>
            <input id="f-phone" name="contact_phone" type="tel" class="fi" placeholder="08xx-xxxx-xxxx" value="<?= $v('contact_phone') ?>">
          </div>
        </div>
        <div class="fg--2">
          <div class="fg">
            <label class="lbl" for="f-address">Alamat</label>
            <input id="f-address" name="contact_address" type="text" class="fi" placeholder="Jl. ..." value="<?= $v('contact_address') ?>">
          </div>
          <div class="fg">
            <label class="lbl" for="f-instagram">Instagram <span class="lbl__hint">username atau URL lengkap</span></label>
            <input id="f-instagram" name="contact_instagram" type="text" class="fi" placeholder="com_smakdapinrang" value="<?= $v('contact_instagram') ?>">
          </div>
        </div>
        <div class="fdiv"></div>
        <div class="fg">
          <label class="lbl" for="f-desc">Deskripsi <span class="lbl__hint">Tampil di Hero &amp; About</span></label>
          <textarea id="f-desc" name="org_description" rows="3" class="fi" placeholder="Deskripsi singkat organisasi…"><?= $v('org_description') ?></textarea>
        </div>
        <div class="fg">
          <label class="lbl" for="f-visi">Visi</label>
          <textarea id="f-visi" name="org_vision" rows="2" class="fi"><?= $v('org_vision') ?></textarea>
        </div>
        <div class="fg">
          <label class="lbl" for="f-misi">Misi <span class="lbl__hint">Tiap poin di baris baru</span></label>
          <textarea id="f-misi" name="org_mission" rows="4" class="fi"><?= $v('org_mission') ?></textarea>
        </div>
        <div class="fg">
          <label class="lbl" for="f-nilai">Nilai Organisasi</label>
          <input id="f-nilai" name="org_nilai" type="text" class="fi" placeholder="Integritas, inovasi, kolaborasi, dedikasi…" value="<?= $v('org_nilai','Integritas, inovasi, kolaborasi, dan dedikasi menjadi fondasi setiap langkah kami dalam berorganisasi.') ?>">
        </div>
        <div class="fdiv"></div>
        <div class="fg">
          <label class="lbl" for="f-footer">Teks Footer</label>
          <input id="f-footer" name="footer_text" type="text" class="fi" placeholder="© 2025 Nama Org. All rights reserved." value="<?= $v('footer_text') ?>">
        </div>
        <div class="fdiv"></div>
        <div class="fg">
          <label class="lbl">Logo Organisasi</label>
          <div class="img-upload">
            <?php if ($settings['org_logo']['value'] ?? ''): ?>
              <img src="<?= UPLOAD_URL . '/' . $v('org_logo') ?>" class="img-thumb" id="prev-logo" alt="Logo">
            <?php else: ?>
              <div class="img-thumb img-thumb--empty" id="prev-logo-empty">
                <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.2"><rect x="2" y="2" width="16" height="16" rx="3"/><circle cx="7.5" cy="7.5" r="2"/><path d="M2 13l4-4 3 3 3-4 6 5"/></svg>
              </div>
              <img src="" class="img-thumb" id="prev-logo" style="display:none" alt="Preview">
            <?php endif; ?>
            <div class="img-upload__area">
              <label for="f-logo" class="img-upload__btn">
                <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"><path d="M7 9V1M4 4l3-3 3 3M1 11v1a1 1 0 001 1h10a1 1 0 001-1v-1"/></svg>
                Pilih File
              </label>
              <input type="file" id="f-logo" name="org_logo" accept="image/*" class="fhidden"
                     data-preview="prev-logo" data-empty="prev-logo-empty" data-name="fname-logo">
              <span class="img-upload__name" id="fname-logo"><?= $settings['org_logo']['value'] ? htmlspecialchars(basename($settings['org_logo']['value'])) : 'Belum ada file' ?></span>
            </div>
          </div>
        </div>
        <div class="fg">
          <label class="lbl">Foto Organisasi <span class="lbl__hint">Tampil di seksi About</span></label>
          <div class="img-upload">
            <?php if ($settings['org_photo']['value'] ?? ''): ?>
              <img src="<?= UPLOAD_URL . '/' . $v('org_photo') ?>" class="img-thumb" id="prev-photo" alt="Foto Org">
            <?php else: ?>
              <div class="img-thumb img-thumb--empty" id="prev-photo-empty">
                <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.2"><rect x="2" y="2" width="16" height="16" rx="3"/><circle cx="7.5" cy="7.5" r="2"/><path d="M2 13l4-4 3 3 3-4 6 5"/></svg>
              </div>
              <img src="" class="img-thumb" id="prev-photo" style="display:none" alt="Preview">
            <?php endif; ?>
            <div class="img-upload__area">
              <label for="f-photo" class="img-upload__btn">
                <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"><path d="M7 9V1M4 4l3-3 3 3M1 11v1a1 1 0 001 1h10a1 1 0 001-1v-1"/></svg>
                Pilih File
              </label>
              <input type="file" id="f-photo" name="org_photo" accept="image/*" class="fhidden"
                     data-preview="prev-photo" data-empty="prev-photo-empty" data-name="fname-photo">
              <span class="img-upload__name" id="fname-photo"><?= $settings['org_photo']['value'] ? htmlspecialchars(basename($settings['org_photo']['value'])) : 'Belum ada file' ?></span>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div><!-- /panel-organisasi -->

  <!-- ══════════════════════════════════════════════
       PANEL: HERO
  ══════════════════════════════════════════════ -->
  <div class="cms-panel" id="panel-hero">

    <!-- Card 1: Teks Hero -->
    <div class="cms-card">
      <div class="cms-card__head">
        <div class="cms-card__ico cms-card__ico--blue">
          <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2 4h10M2 7h7M2 10h5"/></svg>
        </div>
        <div>
          <div class="cms-card__title">Teks &amp; Badge Hero</div>
          <div class="cms-card__desc">Badge kecil di atas heading dan teks marquee/ticker berjalan.</div>
        </div>
      </div>
      <div class="cms-card__body">
        <div class="fg">
          <label class="lbl" for="f-hero-badge">Teks Badge <span class="lbl__hint">Teks kecil di atas heading</span></label>
          <input id="f-hero-badge" name="hero_badge_text" type="text" class="fi"
                 placeholder="Organisasi Resmi · SMKN 2 Pinrang"
                 value="<?= $v('hero_badge_text','Organisasi Resmi · SMKN 2 Pinrang') ?>">
        </div>
        <div class="fg">
          <label class="lbl" for="f-ticker">Ticker / Marquee <span class="lbl__hint">Pisahkan tiap item dengan tanda |</span></label>
          <textarea id="f-ticker" name="ticker_items" rows="2" class="fi"
                    placeholder="Item 1|Item 2|Item 3"><?= $v('ticker_items','COM Academy|Tech Talk|Creative Festival') ?></textarea>
        </div>
      </div>
    </div>

    <!-- Card 2: Gambar Hero — 3 SLOT (Carousel) -->
    <div class="cms-card">
      <div class="cms-card__head">
        <div class="cms-card__ico cms-card__ico--<?= (!empty($settings['hero_image_1']['value']) || !empty($settings['hero_image_2']['value']) || !empty($settings['hero_image_3']['value'])) ? 'green' : 'amber' ?>">
          <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="1" width="12" height="12" rx="1.5"/><circle cx="4.5" cy="4.5" r="1.2"/><path d="M1 9.5l3-3 3 3 2-2.5 4 4"/></svg>
        </div>
        <div>
          <div class="cms-card__title">Slider Hero (3 Foto)</div>
          <div class="cms-card__desc">Upload hingga 3 foto untuk slider background hero. Foto akan berganti otomatis setiap 5 detik di halaman utama.</div>
        </div>
      </div>
      <div class="cms-card__body">

        <?php for ($hi = 1; $hi <= 3; $hi++):
          $slotKey      = "hero_image_{$hi}";
          $hasThisImage = !empty($settings[$slotKey]['value']);
        ?>
        <div class="hero-slide-block" data-slide-index="<?= $hi ?>">
          <div class="sec-lbl" style="margin-bottom:10px">
            <span class="sec-lbl__text">Slide <?= $hi ?></span>
            <div class="sec-lbl__line"></div>
          </div>

          <div class="info-box hero-status-box-<?= $hi ?>" style="<?= $hasThisImage ? '' : 'display:none' ?>">
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><circle cx="7" cy="7" r="5.5"/><path d="M7 6.5v3"/><circle cx="7" cy="5" r=".5" fill="currentColor"/></svg>
            Gambar slide <?= $hi ?> sedang aktif. Anda bisa mengganti atau menghapusnya.
          </div>
          <div class="info-box hero-empty-box-<?= $hi ?>" style="<?= $hasThisImage ? 'display:none' : '' ?>">
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><circle cx="7" cy="7" r="5.5"/><path d="M7 6.5v3"/><circle cx="7" cy="5" r=".5" fill="currentColor"/></svg>
            Belum ada gambar untuk slide <?= $hi ?>.
          </div>

          <div class="fg">
            <label class="lbl">Pratinjau Slide <?= $hi ?></label>

            <div id="hero-preview-existing-<?= $hi ?>" style="<?= $hasThisImage ? '' : 'display:none' ?>">
              <div class="hero-img-preview" id="hero-existing-wrap-<?= $hi ?>">
                <img src="<?= $hasThisImage ? UPLOAD_URL . '/' . htmlspecialchars($settings[$slotKey]['value']) : '' ?>"
                     id="img-hero-existing-<?= $hi ?>" alt="Gambar Hero Slide <?= $hi ?>"
                     style="<?= $hasThisImage ? '' : 'display:none' ?>">
                <span class="hero-img-badge" id="hero-badge-existing-<?= $hi ?>">Terpasang</span>
              </div>
              <div style="margin-top:8px">
                <span class="img-upload__name" id="fname-hero-existing-<?= $hi ?>">
                  <?= $hasThisImage ? htmlspecialchars(basename($settings[$slotKey]['value'])) : '' ?>
                </span>
              </div>
              <div class="img-deleted-notice" id="hero-delete-notice-<?= $hi ?>" style="display:none;margin-top:8px">
                <svg width="13" height="13" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M2 4h10M5 4V3a1 1 0 011-1h2a1 1 0 011 1v1M6 7v3M8 7v3M3 4l.8 7.2A1 1 0 004.8 12h4.4a1 1 0 001-.8L11 4"/></svg>
                Gambar slide <?= $hi ?> akan dihapus saat kamu menyimpan perubahan.
                <button type="button" class="hero-undo-delete" data-slide="<?= $hi ?>"
                  style="margin-left:auto;font-size:11px;color:var(--tx2);background:none;border:none;cursor:pointer;text-decoration:underline;padding:0">
                  Batalkan
                </button>
              </div>
            </div>

            <div id="hero-preview-new-<?= $hi ?>" style="display:none">
              <div class="hero-img-preview">
                <img id="img-hero-new-<?= $hi ?>" src="" alt="Preview Slide <?= $hi ?> Baru">
                <span class="hero-img-badge" style="background:var(--pur-d);color:var(--pur);border-color:rgba(11,90,112,.3)">Baru — Belum Disimpan</span>
              </div>
              <div style="margin-top:8px">
                <span class="img-upload__name" id="fname-hero-new-<?= $hi ?>">–</span>
              </div>
            </div>

            <div id="hero-preview-empty-<?= $hi ?>" style="<?= $hasThisImage ? 'display:none' : '' ?>">
              <div class="hero-img-preview hero-img-preview__empty" style="display:flex">
                <svg width="36" height="36" viewBox="0 0 36 36" fill="none" stroke="currentColor" stroke-width="1.2"><rect x="3" y="3" width="30" height="30" rx="4"/><circle cx="12" cy="12" r="3.5"/><path d="M3 24l8-8 7 7 5-6 12 10"/></svg>
                <span>Belum ada gambar slide <?= $hi ?></span>
              </div>
            </div>
          </div>

          <div class="fdiv"></div>

          <div class="fg">
            <label class="lbl">Kelola Slide <?= $hi ?></label>
            <div class="hero-img-controls">
              <label for="f-hero-img-<?= $hi ?>" class="img-upload__btn hero-upload-btn" data-slide="<?= $hi ?>">
                <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"><path d="M7 9V1M4 4l3-3 3 3M1 11v1a1 1 0 001 1h10a1 1 0 001-1v-1"/></svg>
                <?= $hasThisImage ? 'Ganti Gambar' : 'Upload Gambar' ?>
              </label>
              <input type="file" id="f-hero-img-<?= $hi ?>" name="hero_image_<?= $hi ?>" accept="image/*" class="fhidden hero-file-input" data-slide="<?= $hi ?>">

              <button type="button" class="btn-danger hero-delete-btn" data-slide="<?= $hi ?>" <?= $hasThisImage ? '' : 'disabled' ?>>
                <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M2 4h10M5 4V3a1 1 0 011-1h2a1 1 0 011 1v1M6 7v3M8 7v3M3 4l.8 7.2A1 1 0 004.8 12h4.4a1 1 0 001-.8L11 4"/></svg>
                Hapus Slide <?= $hi ?>
              </button>
            </div>
            <span class="img-upload__name" style="margin-top:2px">Format: JPG, PNG, WebP · Rasio 16:9 atau 21:9 · Maks. 5 MB</span>
          </div>

          <div class="hero-cancel-new-wrap" data-slide="<?= $hi ?>" style="display:none">
            <button type="button" class="btn-outline hero-cancel-new" data-slide="<?= $hi ?>" style="font-size:11px;padding:6px 12px">
              <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M10 4L4 10M4 4l6 6"/></svg>
              Batalkan Pilihan Gambar Baru
            </button>
          </div>

          <input type="hidden" name="hero_image_<?= $hi ?>_delete" id="hero-image-delete-flag-<?= $hi ?>" value="0">

          <?php if ($hi < 3): ?><div class="fdiv" style="margin:14px 0 4px"></div><?php endif; ?>
        </div>
        <?php endfor; ?>

      </div>
    </div><!-- /card hero image -->

  </div><!-- /panel-hero -->

  <!-- ══════════════════════════════════════════════
       PANEL: STATISTIK
  ══════════════════════════════════════════════ -->
  <div class="cms-panel" id="panel-statistik">

    <div class="cms-card">
      <div class="cms-card__head">
        <div class="cms-card__ico cms-card__ico--green">
          <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="8" width="3" height="5" rx="1"/><rect x="5.5" y="5" width="3" height="8" rx="1"/><rect x="10" y="2" width="3" height="11" rx="1"/></svg>
        </div>
        <div>
          <div class="cms-card__title">Angka Statistik</div>
          <div class="cms-card__desc">Tampil di hero cards dan stats bar. Tulis nilai + satuan (contoh: 100+)</div>
        </div>
      </div>
      <div class="cms-card__body">
        <div class="stat-grid">
          <div class="stat-input-wrap">
            <label class="lbl" for="f-st-members">
              <span class="lbl__badge lbl__badge--stat">01</span>
              Anggota Aktif
            </label>
            <input id="f-st-members" name="stat_members" type="text" class="fi" placeholder="100+" value="<?= $v('stat_members','100+') ?>">
          </div>
          <div class="stat-input-wrap">
            <label class="lbl" for="f-st-years">
              <span class="lbl__badge lbl__badge--stat">02</span>
              Tahun Berdiri
            </label>
            <input id="f-st-years" name="stat_years" type="text" class="fi" placeholder="5+" value="<?= $v('stat_years','5+') ?>">
          </div>
          <div class="stat-input-wrap">
            <label class="lbl" for="f-st-events">
              <span class="lbl__badge lbl__badge--stat">03</span>
              Jumlah Kegiatan
            </label>
            <input id="f-st-events" name="stat_events" type="text" class="fi" placeholder="50+" value="<?= $v('stat_events','50+') ?>">
          </div>
          <div class="stat-input-wrap">
            <label class="lbl" for="f-st-awards">
              <span class="lbl__badge lbl__badge--stat">04</span>
              Prestasi
            </label>
            <input id="f-st-awards" name="stat_awards" type="text" class="fi" placeholder="20+" value="<?= $v('stat_awards','20+') ?>">
          </div>
        </div>
      </div>
    </div>

  </div><!-- /panel-statistik -->

  <!-- ══════════════════════════════════════════════
       PANEL: FITUR
  ══════════════════════════════════════════════ -->
  <div class="cms-panel" id="panel-fitur">

    <div class="cms-card">
      <div class="cms-card__head">
        <div class="cms-card__ico cms-card__ico--purple">
          <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="1" width="5" height="5" rx="1"/><rect x="8" y="1" width="5" height="5" rx="1"/><rect x="1" y="8" width="5" height="5" rx="1"/><rect x="8" y="8" width="5" height="5" rx="1"/></svg>
        </div>
        <div>
          <div class="cms-card__title">6 Fitur / Keunggulan Platform</div>
          <div class="cms-card__desc">Ditampilkan sebagai kartu di seksi "Apa yang Kami Sediakan".</div>
        </div>
      </div>
      <div class="cms-card__body">
        <div class="repeater">
          <?php for($i=1;$i<=6;$i++): ?>
          <div class="rep-item">
            <div class="rep-item__head">
              <span class="rep-num rep-num--prog">Fitur <?= $i ?></span>
            </div>
            <div class="fg--2">
              <div class="fg">
                <label class="lbl" for="f-feat<?=$i?>-t">Judul</label>
                <input id="f-feat<?=$i?>-t" name="feature_<?=$i?>_title" type="text" class="fi"
                       value="<?= $v("feature_{$i}_title") ?>" placeholder="Judul fitur…">
              </div>
              <div class="fg" style="grid-column:1/-1">
                <label class="lbl" for="f-feat<?=$i?>-d">Deskripsi</label>
                <textarea id="f-feat<?=$i?>-d" name="feature_<?=$i?>_desc" rows="2" class="fi"
                          placeholder="Deskripsi fitur…"><?= $v("feature_{$i}_desc") ?></textarea>
              </div>
            </div>
          </div>
          <?php endfor; ?>
        </div>
      </div>
    </div>

  </div><!-- /panel-fitur -->

  <!-- ══════════════════════════════════════════════
       PANEL: PROGRAM
  ══════════════════════════════════════════════ -->
  <div class="cms-panel" id="panel-program">

    <div class="cms-card">
      <div class="cms-card__head">
        <div class="cms-card__ico cms-card__ico--purple">
          <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="7" cy="7" r="5.5"/><path d="M7 4.5v3l2 1.5"/></svg>
        </div>
        <div>
          <div class="cms-card__title">4 Program Unggulan</div>
          <div class="cms-card__desc">Ditampilkan di seksi "Kegiatan Unggulan".</div>
        </div>
      </div>
      <div class="cms-card__body">
        <div class="repeater">
          <?php for($i=1;$i<=4;$i++): ?>
          <div class="rep-item">
            <div class="rep-item__head">
              <span class="rep-num rep-num--prog">Program <?= str_pad($i,2,'0',STR_PAD_LEFT) ?></span>
            </div>
            <div class="fg--2">
              <div class="fg">
                <label class="lbl" for="f-prog<?=$i?>-t">Judul</label>
                <input id="f-prog<?=$i?>-t" name="program_<?=$i?>_title" type="text" class="fi"
                       value="<?= $v("program_{$i}_title") ?>" placeholder="Nama program…">
              </div>
              <div class="fg">
                <label class="lbl" for="f-prog<?=$i?>-tag">Tag <span class="lbl__hint">contoh: Rutin · Semesteran</span></label>
                <input id="f-prog<?=$i?>-tag" name="program_<?=$i?>_tag" type="text" class="fi"
                       value="<?= $v("program_{$i}_tag") ?>" placeholder="Frekuensi · Tipe">
              </div>
              <div class="fg" style="grid-column:1/-1">
                <label class="lbl" for="f-prog<?=$i?>-d">Deskripsi</label>
                <textarea id="f-prog<?=$i?>-d" name="program_<?=$i?>_desc" rows="2" class="fi"
                          placeholder="Deskripsi singkat program…"><?= $v("program_{$i}_desc") ?></textarea>
              </div>
            </div>
          </div>
          <?php endfor; ?>
        </div>
      </div>
    </div>

  </div><!-- /panel-program -->

  <!-- ══════════════════════════════════════════════
       PANEL: GALERI
  ══════════════════════════════════════════════ -->
  <div class="cms-panel" id="panel-galeri">

    <div class="cms-card">
      <div class="cms-card__head">
        <div class="cms-card__ico cms-card__ico--green">
          <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="1" width="12" height="12" rx="1.5"/><circle cx="4.5" cy="4.5" r="1.2"/><path d="M1 9.5l3-3 3 3 2-2.5 4 4"/></svg>
        </div>
        <div>
          <div class="cms-card__title">Galeri (6 Foto)</div>
          <div class="cms-card__desc">Foto kegiatan di seksi "Momen Kegiatan". Upload + beri label.</div>
        </div>
      </div>
      <div class="cms-card__body">
        <div class="repeater">
          <?php
          $galLabels = ['COM Academy 2024','Creative Festival','Tech Workshop','Bakti Sosial','Pelantikan Anggota','Rapat Koordinasi'];
          for($i=1;$i<=6;$i++): $def = $galLabels[$i-1]; ?>
          <div class="rep-item">
            <div class="rep-item__head">
              <span class="rep-num rep-num--gal">Foto <?= $i ?></span>
            </div>
            <div class="fg--2" style="align-items:start">
              <div class="fg" style="grid-column:1/-1">
                <label class="lbl">Gambar</label>
                <div class="img-upload">
                  <?php if ($settings["gallery_img_{$i}"]['value'] ?? ''): ?>
                    <img src="<?= UPLOAD_URL . '/' . $v("gallery_img_{$i}") ?>" class="img-thumb img-thumb--sm" id="prev-gal<?=$i?>" alt="Foto <?=$i?>">
                  <?php else: ?>
                    <div class="img-thumb img-thumb--sm img-thumb--empty" id="prev-gal<?=$i?>-empty">
                      <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.2"><rect x="2" y="2" width="16" height="16" rx="3"/><circle cx="7.5" cy="7.5" r="2"/><path d="M2 13l4-4 3 3 3-4 6 5"/></svg>
                    </div>
                    <img src="" class="img-thumb img-thumb--sm" id="prev-gal<?=$i?>" style="display:none" alt="Preview">
                  <?php endif; ?>
                  <div class="img-upload__area">
                    <label for="f-gal<?=$i?>" class="img-upload__btn">
                      <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"><path d="M7 9V1M4 4l3-3 3 3M1 11v1a1 1 0 001 1h10a1 1 0 001-1v-1"/></svg>
                      Upload
                    </label>
                    <input type="file" id="f-gal<?=$i?>" name="gallery_img_<?=$i?>" accept="image/*" class="fhidden"
                           data-preview="prev-gal<?=$i?>" data-empty="prev-gal<?=$i?>-empty" data-name="fname-gal<?=$i?>">
                    <span class="img-upload__name" id="fname-gal<?=$i?>"><?= $settings["gallery_img_{$i}"]['value'] ? htmlspecialchars(basename($settings["gallery_img_{$i}"]['value'])) : 'Belum ada file' ?></span>
                  </div>
                </div>
              </div>
              <div class="fg" style="grid-column:1/-1">
                <label class="lbl" for="f-gal<?=$i?>-lbl">Label / Keterangan Foto</label>
                <input id="f-gal<?=$i?>-lbl" name="gallery_label_<?=$i?>" type="text" class="fi"
                       value="<?= $v("gallery_label_{$i}", $def) ?>" placeholder="<?= $def ?>">
              </div>
            </div>
          </div>
          <?php endfor; ?>
        </div>
      </div>
    </div>

  </div><!-- /panel-galeri -->

  <!-- ══════════════════════════════════════════════
       PANEL: TESTIMONI
  ══════════════════════════════════════════════ -->
  <div class="cms-panel" id="panel-testimoni">

    <div class="cms-card">
      <div class="cms-card__head">
        <div class="cms-card__ico cms-card__ico--amber">
          <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12.5 9a1.5 1.5 0 01-1.5 1.5H4L1.5 13V3A1.5 1.5 0 013 1.5h8A1.5 1.5 0 0112.5 3v6z"/></svg>
        </div>
        <div>
          <div class="cms-card__title">5 Testimoni Anggota</div>
          <div class="cms-card__desc">Ditampilkan di carousel "Apa Kata Anggota Kami".</div>
        </div>
      </div>
      <div class="cms-card__body">
        <div class="repeater">
          <?php for($i=1;$i<=5;$i++): ?>
          <div class="rep-item">
            <div class="rep-item__head">
              <span class="rep-num rep-num--testi">Testimoni <?= $i ?></span>
            </div>
            <div class="fg">
              <label class="lbl" for="f-testi<?=$i?>-q">Quote / Ucapan</label>
              <textarea id="f-testi<?=$i?>-q" name="testi_<?=$i?>_quote" rows="2" class="fi"
                        placeholder="Ucapan positif tentang organisasi…"><?= $v("testi_{$i}_quote") ?></textarea>
            </div>
            <div class="fg--2">
              <div class="fg">
                <label class="lbl" for="f-testi<?=$i?>-n">Nama</label>
                <input id="f-testi<?=$i?>-n" name="testi_<?=$i?>_name" type="text" class="fi"
                       value="<?= $v("testi_{$i}_name") ?>" placeholder="Nama anggota">
              </div>
              <div class="fg">
                <label class="lbl" for="f-testi<?=$i?>-r">Jabatan / Kelas</label>
                <input id="f-testi<?=$i?>-r" name="testi_<?=$i?>_role" type="text" class="fi"
                       value="<?= $v("testi_{$i}_role") ?>" placeholder="Anggota · XI RPL 1">
              </div>
            </div>
          </div>
          <?php endfor; ?>
        </div>
      </div>
    </div>

  </div><!-- /panel-testimoni -->

  <!-- ══════════════════════════════════════════════
       PANEL: SAMBUTAN PEMBINA
  ══════════════════════════════════════════════ -->
  <div class="cms-panel" id="panel-sambutan">

    <!-- Card 1: Visibilitas -->
    <div class="cms-card">
      <div class="cms-card__head">
        <div class="cms-card__ico cms-card__ico--blue">
          <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M1 7s2.5-5 6-5 6 5 6 5-2.5 5-6 5-6-5-6-5z"/>
            <circle cx="7" cy="7" r="2"/>
          </svg>
        </div>
        <div>
          <div class="cms-card__title">Visibilitas Seksi</div>
          <div class="cms-card__desc">Atur apakah seksi sambutan tampil di halaman publik.</div>
        </div>
      </div>
      <div class="cms-card__body">
        <div class="toggle-wrap">
          <div class="toggle-wrap__info">
            <span class="toggle-wrap__label">Tampilkan Seksi Sambutan</span>
            <span class="toggle-wrap__hint">Pilih "Ya" agar sambutan pembina tampil di halaman utama</span>
          </div>
          <select id="f-sambutan-show" name="sambutan_show" class="fi" style="width:auto;min-width:160px">
            <option value="1" <?= ($settings['sambutan_show']['value'] ?? '1') === '1' ? 'selected' : '' ?>>
              ✓ Ya — Tampilkan
            </option>
            <option value="0" <?= ($settings['sambutan_show']['value'] ?? '1') === '0' ? 'selected' : '' ?>>
              ✕ Tidak — Sembunyikan
            </option>
          </select>
        </div>
      </div>
    </div>

    <!-- Card 2: Identitas Pembina -->
    <div class="cms-card">
      <div class="cms-card__head">
        <div class="cms-card__ico cms-card__ico--blue">
          <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="7" cy="5" r="3"/><path d="M1 13c0-3.3 2.7-6 6-6s6 2.7 6 6"/>
          </svg>
        </div>
        <div>
          <div class="cms-card__title">Identitas Pembina</div>
          <div class="cms-card__desc">Foto, nama, jabatan, dan masa menjabat pembina.</div>
        </div>
      </div>
      <div class="cms-card__body">

        <!-- Foto pembina -->
        <div class="fg">
          <label class="lbl">Foto Pembina <span class="lbl__hint">Disarankan foto formal, rasio 1:1</span></label>
          <div class="img-upload">
            <?php if (!empty($settings['pembina_foto']['value'])): ?>
              <img src="<?= UPLOAD_URL . '/' . $v('pembina_foto') ?>"
                   class="img-thumb img-thumb--circle" id="prev-pembina-foto" alt="Foto Pembina">
            <?php else: ?>
              <div class="img-thumb img-thumb--empty img-thumb--circle" id="prev-pembina-foto-empty">
                <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.2">
                  <circle cx="10" cy="7" r="4"/>
                  <path d="M2 18c0-4.4 3.6-8 8-8s8 3.6 8 8"/>
                </svg>
              </div>
              <img src="" class="img-thumb img-thumb--circle" id="prev-pembina-foto"
                   style="display:none" alt="Preview">
            <?php endif; ?>
            <div class="img-upload__area">
              <label for="f-pembina-foto" class="img-upload__btn">
                <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round">
                  <path d="M7 9V1M4 4l3-3 3 3M1 11v1a1 1 0 001 1h10a1 1 0 001-1v-1"/>
                </svg>
                Pilih Foto
              </label>
              <input type="file" id="f-pembina-foto" name="pembina_foto" accept="image/*" class="fhidden"
                     data-preview="prev-pembina-foto"
                     data-empty="prev-pembina-foto-empty"
                     data-name="fname-pembina-foto">
              <span class="img-upload__name" id="fname-pembina-foto">
                <?= !empty($settings['pembina_foto']['value'])
                    ? htmlspecialchars(basename($settings['pembina_foto']['value']))
                    : 'Belum ada file' ?>
              </span>
            </div>
          </div>
        </div>

        <div class="fdiv"></div>

        <!-- Identitas -->
        <div class="fg--2">
          <div class="fg">
            <label class="lbl" for="f-pembina-nama">Nama Lengkap Pembina</label>
            <input id="f-pembina-nama" name="pembina_nama" type="text" class="fi"
                   placeholder="Drs. Nama Pembina, M.Pd."
                   value="<?= $v('pembina_nama') ?>">
          </div>
          <div class="fg">
            <label class="lbl" for="f-pembina-jabatan">Jabatan / Gelar</label>
            <input id="f-pembina-jabatan" name="pembina_jabatan" type="text" class="fi"
                   placeholder="Guru Pembina COM SMKN 2 Pinrang"
                   value="<?= $v('pembina_jabatan', 'Guru Pembina COM SMKN 2 Pinrang') ?>">
          </div>
        </div>

        <div class="fg--2">
          <div class="fg">
            <label class="lbl" for="f-pembina-masa">
              Masa Menjabat
              <span class="lbl__hint">Contoh: 2020 – Sekarang</span>
            </label>
            <input id="f-pembina-masa" name="pembina_masa" type="text" class="fi"
                   placeholder="2020 – Sekarang"
                   value="<?= $v('pembina_masa') ?>">
          </div>
          <div class="fg">
            <label class="lbl" for="f-sambutan-eyebrow">
              Teks Eyebrow Seksi
              <span class="lbl__hint">Label kecil di atas judul</span>
            </label>
            <input id="f-sambutan-eyebrow" name="sambutan_eyebrow" type="text" class="fi"
                   placeholder="Sambutan Pembina"
                   value="<?= $v('sambutan_eyebrow', 'Sambutan Pembina') ?>">
          </div>
        </div>

      </div>
    </div>

    <!-- Card 3: Teks Sambutan -->
    <div class="cms-card">
      <div class="cms-card__head">
        <div class="cms-card__ico cms-card__ico--purple">
          <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12.5 9a1.5 1.5 0 01-1.5 1.5H4L1.5 13V3A1.5 1.5 0 013 1.5h8A1.5 1.5 0 0112.5 3v6z"/>
          </svg>
        </div>
        <div>
          <div class="cms-card__title">Teks Sambutan</div>
          <div class="cms-card__desc">Isi sambutan yang ditampilkan di halaman utama.</div>
        </div>
      </div>
      <div class="cms-card__body">
        <div class="fg">
          <label class="lbl" for="f-pembina-sambutan">
            Isi Teks Sambutan
            <span class="lbl__hint">Baris baru = paragraf baru</span>
          </label>
          <textarea id="f-pembina-sambutan" name="pembina_sambutan" rows="8" class="fi"
                    placeholder="Assalamu'alaikum wr. wb.&#10;&#10;Selamat datang di platform digital COM SMKN 2 Pinrang..."><?= $v('pembina_sambutan') ?></textarea>
        </div>
      </div>
    </div>

  </div><!-- /panel-sambutan -->

  <!-- ══════════════════════════════════════════════
       PANEL: RIWAYAT PENGURUS
  ══════════════════════════════════════════════ -->
  <div class="cms-panel" id="panel-riwayat">

    <!-- Card info + tombol kelola -->
    <div class="cms-card">
      <div class="cms-card__head">
        <div class="cms-card__ico cms-card__ico--amber">
          <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="7" cy="7" r="5.5"/>
            <path d="M7 4.5v3l2 1.5"/>
          </svg>
        </div>
        <div>
          <div class="cms-card__title">Riwayat Ketua &amp; Pembina</div>
          <div class="cms-card__desc">Data periode kepengurusan dikelola di halaman terpisah.</div>
        </div>
      </div>
      <div class="cms-card__body">

        <a href="<?= BASE_URL ?>/admin/riwayat" class="btn-save"
           style="text-decoration:none;width:fit-content">
          <svg width="14" height="14" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M2 2h10a1 1 0 011 1v9a1 1 0 01-1 1H2a1 1 0 01-1-1V3a1 1 0 011-1z"/>
            <path d="M4 5h6M4 7.5h4M4 10h3"/>
          </svg>
          Kelola Riwayat Pengurus
        </a>

        <?php
          $rpmAll      = (new RiwayatPengurusModel())->getAll();
          $ketuaRows   = array_values(array_filter($rpmAll, fn($r) => $r['tipe'] === 'ketua'));
          $pembinaRows = array_values(array_filter($rpmAll, fn($r) => $r['tipe'] === 'pembina'));
        ?>

        <?php if (count($rpmAll)): ?>

          <?php foreach (['ketua' => ['label'=>'Ketua Organisasi','rows'=>$ketuaRows], 'pembina' => ['label'=>'Guru Pembina','rows'=>$pembinaRows]] as $tipe => $cfg): ?>
          <?php if (count($cfg['rows'])): ?>

          <div class="fdiv"></div>

          <div>
            <div class="sec-lbl" style="margin-bottom:10px">
              <span class="sec-lbl__text"><?= $cfg['label'] ?></span>
              <div class="sec-lbl__line"></div>
              <span style="font-family:var(--font-mono);font-size:10px;color:var(--tx3);white-space:nowrap">
                <?= count($cfg['rows']) ?> periode
              </span>
            </div>
            <div style="display:flex;flex-direction:column;gap:6px">
              <?php foreach ($cfg['rows'] as $rw): ?>
              <div class="riwayat-row">
                <?php if (!empty($rw['foto'])): ?>
                  <img src="<?= UPLOAD_URL . '/' . htmlspecialchars($rw['foto']) ?>"
                       class="riwayat-avatar" alt="<?= htmlspecialchars($rw['nama']) ?>">
                <?php else: ?>
                  <div class="riwayat-avatar--placeholder">
                    <?= strtoupper(mb_substr($rw['nama'], 0, 2)) ?>
                  </div>
                <?php endif; ?>
                <div class="riwayat-info">
                  <div class="riwayat-info__name"><?= htmlspecialchars($rw['nama']) ?></div>
                  <div class="riwayat-info__period"><?= htmlspecialchars($rw['periode']) ?></div>
                </div>
                <a href="<?= BASE_URL ?>/admin/riwayat/<?= $rw['id'] ?>/edit"
                   class="riwayat-edit-btn">Edit</a>
              </div>
              <?php endforeach; ?>
            </div>
          </div>

          <?php endif; ?>
          <?php endforeach; ?>

        <?php else: ?>
          <p class="empty-state">
            Belum ada data riwayat pengurus.<br>
            Klik tombol di atas untuk mulai menambahkan.
          </p>
        <?php endif; ?>

      </div>
    </div>

  </div><!-- /panel-riwayat -->

  <!-- ══════════════════════════════════════════════
       PANEL: PAB & CTA
  ══════════════════════════════════════════════ -->
  <div class="cms-panel" id="panel-pab">

    <div class="cms-card">
      <div class="cms-card__head">
        <div class="cms-card__ico cms-card__ico--amber">
          <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2 2h10a1 1 0 011 1v9a1 1 0 01-1 1H2a1 1 0 01-1-1V3a1 1 0 011-1z"/><path d="M4 5h6M4 7.5h4M4 10h3"/></svg>
        </div>
        <div>
          <div class="cms-card__title">Pengaturan PAB</div>
          <div class="cms-card__desc">Informasi dan batas waktu pendaftaran anggota baru.</div>
        </div>
      </div>
      <div class="cms-card__body">
        <div class="fg">
          <label class="lbl" for="f-pab-info">Info PAB <span class="lbl__hint">Tampil di halaman pendaftaran</span></label>
          <textarea id="f-pab-info" name="pab_info" rows="3" class="fi"
                    placeholder="Informasi PAB tahun ini…"><?= $v('pab_info') ?></textarea>
        </div>
        <div class="fg">
          <label class="lbl" for="f-pab-dl">Batas Akhir Pendaftaran</label>
          <input id="f-pab-dl" name="pab_deadline" type="text" class="fi"
                 placeholder="31 Agustus 2025" value="<?= $v('pab_deadline') ?>">
        </div>
      </div>
    </div>

    <div class="cms-card">
      <div class="cms-card__head">
        <div class="cms-card__ico cms-card__ico--blue">
          <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M7 1l1.8 3.6L13 5.4l-3 2.9.7 4.1L7 10.4 3.3 12.4l.7-4.1-3-2.9 4.2-.8L7 1z"/></svg>
        </div>
        <div>
          <div class="cms-card__title">Konten CTA Section</div>
          <div class="cms-card__desc">Seksi ajakan bergabung di bagian bawah halaman home.</div>
        </div>
      </div>
      <div class="cms-card__body">
        <div class="fg">
          <label class="lbl" for="f-cta-title">Judul CTA</label>
          <input id="f-cta-title" name="cta_title" type="text" class="fi"
                 placeholder="Siap Bergabung Bersama Kami?"
                 value="<?= $v('cta_title','Siap Bergabung Bersama Kami?') ?>">
        </div>
        <div class="fg">
          <label class="lbl" for="f-cta-desc">Deskripsi CTA</label>
          <textarea id="f-cta-desc" name="cta_desc" rows="3" class="fi"
                    placeholder="Daftarkan diri kamu…"><?= $v('cta_desc') ?></textarea>
        </div>
      </div>
    </div>

  </div><!-- /panel-pab -->

  <!-- ── Save Bar ── -->
  <div class="cms-savebar">
    <button type="submit" class="btn-save">
      <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 8v3.5A.5.5 0 002.5 12h9a.5.5 0 00.5-.5V8M7 1v7M4.5 5.5L7 8l2.5-2.5"/></svg>
      Simpan Perubahan
    </button>
    <span class="save-hint">⌘ / Ctrl + S</span>
  </div>

</form>
</div><!-- /.cms-root -->

<script>
(function(){
'use strict';

/* ── Tab switching ──
   PERBAIKAN BUG: sebelumnya ada 2 listener terpisah yang didaftarkan ke
   tombol tab yang sama (satu untuk ganti panel, satu lagi untuk update
   hash URL). Sekarang digabung jadi satu listener supaya urutan
   eksekusi konsisten dan tidak ada risiko salah satu listener
   "ketinggalan" saat elemen di-clone/di-re-render. */
const tabs   = document.querySelectorAll('.cms-tab');
const panels = document.querySelectorAll('.cms-panel');

function activateTab(tab, updateHash = true) {
  tabs.forEach(t => t.classList.remove('active'));
  panels.forEach(p => p.classList.remove('active'));
  tab.classList.add('active');
  const panel = document.getElementById('panel-' + tab.dataset.tab);
  if (panel) panel.classList.add('active');
  if (updateHash) history.replaceState(null, '', '#' + tab.dataset.tab);
}

tabs.forEach(tab => {
  tab.addEventListener('click', () => activateTab(tab, true));
});

/* ── Preserve active tab on reload via URL hash ── */
const hash = location.hash.replace('#', '');
if (hash) {
  const t = document.querySelector(`.cms-tab[data-tab="${hash}"]`);
  if (t) activateTab(t, false);
}

/* ── Image file preview (universal — non-hero) ──
   FIX BUG: tambahkan inp.blur() setelah proses selesai (baik ada file
   maupun dibatalkan) supaya focus dilepas dari input file. Tanpa ini,
   elemen yang di-hide via clip-rect tetap menerima focus dan memicu
   browser auto-scroll ke posisinya (yang salah dihitung), membuat
   halaman melompat dan terlihat blank. */
document.querySelectorAll('input[type="file"].fhidden:not(.hero-file-input)').forEach(inp => {
  inp.addEventListener('change', () => {
    const file = inp.files[0];
    if (!file) { inp.blur(); return; }
    const previewId = inp.dataset.preview;
    const emptyId   = inp.dataset.empty;
    const nameId    = inp.dataset.name;
    if (nameId) {
      const el = document.getElementById(nameId);
      if (el) el.textContent = file.name;
    }
    const reader = new FileReader();
    reader.onload = e => {
      const img = document.getElementById(previewId);
      if (img) { img.src = e.target.result; img.style.display = 'block'; }
      const empty = document.getElementById(emptyId);
      if (empty) empty.style.display = 'none';
    };
    reader.readAsDataURL(file);
    inp.blur(); // FIX BUG: lepas focus supaya tidak memicu auto-scroll
  });
});

/* ════════════════════════════════════════════════
   HERO IMAGE (3 SLIDE) — Logika hapus & preview per-slide
════════════════════════════════════════════════ */
function setupHeroSlide(i, hasExistingInitial) {
  const fileInput      = document.getElementById(`f-hero-img-${i}`);
  const deleteFlag      = document.getElementById(`hero-image-delete-flag-${i}`);
  const deleteBtn       = document.querySelector(`.hero-delete-btn[data-slide="${i}"]`);
  const undoDelete      = document.querySelector(`.hero-undo-delete[data-slide="${i}"]`);
  const deleteNotice    = document.getElementById(`hero-delete-notice-${i}`);
  const existingWrap    = document.getElementById(`hero-existing-wrap-${i}`);
  const previewExisting = document.getElementById(`hero-preview-existing-${i}`);
  const previewNew      = document.getElementById(`hero-preview-new-${i}`);
  const previewEmpty    = document.getElementById(`hero-preview-empty-${i}`);
  const imgNew          = document.getElementById(`img-hero-new-${i}`);
  const fnameNew        = document.getElementById(`fname-hero-new-${i}`);
  const statusBox       = document.querySelector(`.hero-status-box-${i}`);
  const emptyBox        = document.querySelector(`.hero-empty-box-${i}`);
  const uploadBtn       = document.querySelector(`.hero-upload-btn[data-slide="${i}"]`);
  const cancelNewWrap   = document.querySelector(`.hero-cancel-new-wrap[data-slide="${i}"]`);
  const cancelNewBtn    = document.querySelector(`.hero-cancel-new[data-slide="${i}"]`);
  const badgeExisting   = document.getElementById(`hero-badge-existing-${i}`);

  let hasExisting  = hasExistingInitial;
  let newSelected  = false;
  let markedDelete = false;

  function updateUI() {
    if (newSelected) {
      if (previewNew)      previewNew.style.display      = '';
      if (previewExisting) previewExisting.style.display = 'none';
      if (previewEmpty)    previewEmpty.style.display    = 'none';
      if (cancelNewWrap)   cancelNewWrap.style.display   = '';
      if (deleteBtn)       deleteBtn.disabled            = true;
      if (statusBox)       statusBox.style.display       = 'none';
      if (emptyBox)        emptyBox.style.display        = 'none';
      if (deleteNotice)    deleteNotice.style.display    = 'none';
      deleteFlag.value = '0';
      return;
    }

    if (hasExisting) {
      if (previewExisting) previewExisting.style.display = '';
      if (previewNew)      previewNew.style.display      = 'none';
      if (previewEmpty)    previewEmpty.style.display    = 'none';
      if (cancelNewWrap)   cancelNewWrap.style.display   = 'none';
      if (deleteBtn)       deleteBtn.disabled            = false;
      if (uploadBtn)       uploadBtn.textContent         = 'Ganti Gambar';

      if (markedDelete) {
        if (deleteNotice)  deleteNotice.style.display = '';
        if (existingWrap)  existingWrap.style.opacity  = '0.4';
        if (statusBox)     statusBox.style.display     = 'none';
        if (emptyBox)      emptyBox.style.display      = 'none';
        if (badgeExisting) {
          badgeExisting.textContent = 'Akan Dihapus';
          badgeExisting.classList.add('hero-img-badge--pending');
        }
        deleteFlag.value = '1';
      } else {
        if (deleteNotice) deleteNotice.style.display = 'none';
        if (existingWrap) existingWrap.style.opacity  = '1';
        if (statusBox)    statusBox.style.display     = '';
        if (emptyBox)     emptyBox.style.display      = 'none';
        if (badgeExisting) {
          badgeExisting.textContent = 'Terpasang';
          badgeExisting.classList.remove('hero-img-badge--pending');
        }
        deleteFlag.value = '0';
      }
    } else {
      if (previewExisting) previewExisting.style.display = 'none';
      if (previewNew)      previewNew.style.display      = 'none';
      if (previewEmpty)    previewEmpty.style.display    = '';
      if (cancelNewWrap)   cancelNewWrap.style.display   = 'none';
      if (deleteBtn)       deleteBtn.disabled            = true;
      if (uploadBtn)       uploadBtn.textContent         = 'Upload Gambar';
      if (statusBox)       statusBox.style.display       = 'none';
      if (emptyBox)        emptyBox.style.display        = '';
      deleteFlag.value = '0';
    }
  }

  if (fileInput) {
    fileInput.addEventListener('change', () => {
      const file = fileInput.files[0];
      if (!file) { fileInput.blur(); return; }
      newSelected  = true;
      markedDelete = false;
      const reader = new FileReader();
      reader.onload = e => {
        if (imgNew)   imgNew.src           = e.target.result;
        if (fnameNew) fnameNew.textContent = file.name;
      };
      reader.readAsDataURL(file);
      updateUI();
      fileInput.blur(); // FIX BUG: lepas focus supaya tidak memicu auto-scroll
    });
  }

  if (deleteBtn) {
    deleteBtn.addEventListener('click', () => {
      if (!hasExisting) return;
      if (!confirm(`Hapus gambar slide ${i}? Perubahan berlaku setelah kamu klik "Simpan Perubahan".`)) return;
      markedDelete = true;
      newSelected  = false;
      if (fileInput) fileInput.value = '';
      updateUI();
    });
  }

  if (undoDelete) {
    undoDelete.addEventListener('click', () => {
      markedDelete = false;
      updateUI();
    });
  }

  if (cancelNewBtn) {
    cancelNewBtn.addEventListener('click', () => {
      newSelected = false;
      if (fileInput) fileInput.value = '';
      updateUI();
    });
  }

  updateUI();
}

setupHeroSlide(1, <?= !empty($settings['hero_image_1']['value']) ? 'true' : 'false' ?>);
setupHeroSlide(2, <?= !empty($settings['hero_image_2']['value']) ? 'true' : 'false' ?>);
setupHeroSlide(3, <?= !empty($settings['hero_image_3']['value']) ? 'true' : 'false' ?>);

/* ── Ctrl+S / Cmd+S shortcut ── */
document.addEventListener('keydown', e => {
  if ((e.ctrlKey || e.metaKey) && e.key === 's') {
    e.preventDefault();
    document.getElementById('cms-form').submit();
  }
});

}());
</script>