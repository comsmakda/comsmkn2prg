<?php // app/views/admin/anggota_form.php ?>

<style>
@import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;500;600&family=Sora:wght@300;400;500;600;700;800&display=swap');

/* ── Design tokens ── */
.tambah-root {
  --font-ui:    'Sora', sans-serif;
  --font-mono:  'IBM Plex Mono', monospace;
  --bg-surface:  #0f1117;
  --bg-elevated: #141820;
  --bg-overlay:  #1a1f2e;
  --bd-subtle:   rgba(255,255,255,0.055);
  --bd-default:  rgba(255,255,255,0.10);
  --bd-accent:   rgba(99,179,237,0.35);
  --tx-primary:  #e8ecf4;
  --tx-secondary:#9aa3b8;
  --tx-muted:    #4f5773;
  --ac:          #63b3ed;
  --ac-dim:      rgba(99,179,237,0.10);
  --ac-glow:     rgba(99,179,237,0.18);
  --blue-d:      rgba(79,158,255,0.12);
  --green:       #48bb78;
  --green-d:     rgba(72,187,120,0.12);
  --red:         #fc8181;
  --red-d:       rgba(252,129,129,0.12);
  --amber:       #f6c244;
  --amber-d:     rgba(246,194,68,0.12);
  --r-xs: 4px; --r-sm: 6px; --r-md: 10px; --r-lg: 14px;
  --ease: cubic-bezier(0.16,1,0.3,1);
  --t-fast: 120ms; --t-base: 200ms;
}

.tambah-root *, .tambah-root *::before, .tambah-root *::after {
  box-sizing: border-box; margin: 0; padding: 0;
}
.tambah-root a { text-decoration: none; color: inherit; }
.tambah-root {
  font-family: var(--font-ui);
  color: var(--tx-primary);
  font-size: 13px;
  line-height: 1.5;
  -webkit-font-smoothing: antialiased;
}

/* ── Layout ── */
.tambah-wrap { max-width: 620px; }

/* ── Back link ── */
.tambah-back {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  font-size: 12px;
  font-weight: 600;
  color: var(--tx-muted);
  margin-bottom: 20px;
  padding: 5px 0;
  transition: color var(--t-fast) var(--ease);
}
.tambah-back:hover { color: var(--tx-secondary); }
.tambah-back svg { width: 13px; height: 13px; display: block; flex-shrink: 0; }

/* ── Page header ── */
.tambah-ph { margin-bottom: 24px; }
.tambah-ph__eyebrow {
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
.tambah-ph__eyebrow::before {
  content: '';
  width: 6px; height: 6px;
  border-radius: 50%;
  background: var(--ac);
  box-shadow: 0 0 6px var(--ac);
  flex-shrink: 0;
}
.tambah-ph__title {
  font-size: 22px;
  font-weight: 800;
  letter-spacing: -0.04em;
  color: var(--tx-primary);
  line-height: 1.1;
}

/* ── Flash ── */
.t-flash {
  display: flex;
  align-items: flex-start;
  gap: 10px;
  padding: 12px 14px;
  border-radius: var(--r-md);
  font-size: 12.5px;
  font-weight: 500;
  margin-bottom: 18px;
  border: 1px solid;
}
.t-flash svg { width: 15px; height: 15px; flex-shrink: 0; display: block; margin-top: 1px; }
.t-flash--success { background: var(--green-d); border-color: rgba(72,187,120,0.25); color: var(--green); }
.t-flash--error   { background: var(--red-d);   border-color: rgba(252,129,129,0.25); color: var(--red); }
.t-flash--warning { background: var(--amber-d); border-color: rgba(246,194,68,0.25);  color: var(--amber); }
.t-flash--info    { background: var(--blue-d);  border-color: rgba(79,158,255,0.25);  color: #4f9eff; }

/* ── Panel ── */
.t-panel {
  background: var(--bg-surface);
  border: 1px solid var(--bd-subtle);
  border-radius: var(--r-lg);
  overflow: hidden;
}
.t-panel__head {
  padding: 14px 20px;
  border-bottom: 1px solid var(--bd-subtle);
  display: flex;
  align-items: center;
  gap: 8px;
  flex-wrap: wrap;
}
.t-panel__head-title { font-size: 12.5px; font-weight: 700; color: var(--tx-primary); }
.t-panel__head-sub   { font-size: 11px; color: var(--tx-muted); }
.t-panel__body {
  padding: 22px 20px;
  display: flex;
  flex-direction: column;
  gap: 18px;
}
.t-panel__foot {
  padding: 14px 20px;
  border-top: 1px solid var(--bd-subtle);
  display: flex;
  align-items: center;
  gap: 8px;
  justify-content: flex-end;
  flex-wrap: wrap;
}

/* ── Section ── */
.t-section { display: flex; flex-direction: column; gap: 14px; }
.t-section + .t-section { padding-top: 18px; border-top: 1px solid var(--bd-subtle); }
.t-section__lbl {
  font-family: var(--font-mono);
  font-size: 9.5px;
  font-weight: 600;
  letter-spacing: 0.16em;
  text-transform: uppercase;
  color: var(--tx-muted);
}

/* ── Row ── */
.t-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
@media (max-width: 520px) { .t-row { grid-template-columns: 1fr; } }

/* ── Field ── */
.t-field { display: flex; flex-direction: column; gap: 5px; }
.t-field__lbl { font-size: 11.5px; font-weight: 600; color: var(--tx-secondary); }
.t-field__lbl--req::after { content: ' *'; color: var(--red); font-size: 11px; }
.t-field__hint { font-size: 10.5px; color: var(--tx-muted); }

/* ── Input base ── */
.t-input {
  font-family: var(--font-ui);
  font-size: 13px;
  color: var(--tx-primary);
  background: var(--bg-elevated);
  border: 1px solid var(--bd-subtle);
  border-radius: var(--r-md);
  padding: 9px 12px;
  outline: none;
  width: 100%;
  -webkit-appearance: none;
  transition:
    border-color var(--t-fast) var(--ease),
    background   var(--t-fast) var(--ease),
    box-shadow   var(--t-base) var(--ease);
}
.t-input::placeholder { color: var(--tx-muted); font-size: 12.5px; }
.t-input:focus {
  border-color: var(--bd-accent);
  background: var(--bg-overlay);
  box-shadow: 0 0 0 3px rgba(99,179,237,0.08);
}

/* Input with leading icon */
.t-input-wrap { position: relative; }
.t-input-wrap .t-input { padding-left: 34px; }
.t-input-ico {
  position: absolute;
  left: 11px;
  top: 50%;
  transform: translateY(-50%);
  color: var(--tx-muted);
  display: flex;
  align-items: center;
  pointer-events: none;
  line-height: 0;
}
/* CRITICAL: lock icon dimensions to prevent blowout */
.t-input-ico svg { width: 13px !important; height: 13px !important; display: block; flex-shrink: 0; }

/* Password toggle */
.t-input-wrap--pwd .t-input { padding-right: 36px; }
.t-pwd-toggle {
  position: absolute;
  right: 10px;
  top: 50%;
  transform: translateY(-50%);
  width: 22px;
  height: 22px;
  background: none;
  border: none;
  cursor: pointer;
  color: var(--tx-muted);
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 0;
  line-height: 0;
  transition: color var(--t-fast) var(--ease);
}
.t-pwd-toggle:hover { color: var(--tx-secondary); }
/* CRITICAL: lock icon dimensions */
.t-pwd-toggle svg { width: 13px !important; height: 13px !important; display: block; flex-shrink: 0; }

/* ── Dropzone ── */
.t-dropzone {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 8px;
  padding: 20px;
  background: var(--bg-elevated);
  border: 1.5px dashed var(--bd-default);
  border-radius: var(--r-md);
  cursor: pointer;
  text-align: center;
  position: relative;
  transition:
    border-color var(--t-base) var(--ease),
    background   var(--t-base) var(--ease);
}
.t-dropzone:hover, .t-dropzone.drag-over {
  border-color: var(--bd-accent);
  background: var(--ac-dim);
}
.t-dropzone input[type="file"] {
  position: absolute;
  inset: 0;
  width: 100%;
  height: 100%;
  opacity: 0;
  cursor: pointer;
}
.t-dropzone__ico {
  width: 32px; height: 32px;
  border-radius: var(--r-sm);
  background: var(--bg-overlay);
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--tx-muted);
  flex-shrink: 0;
}
.t-dropzone__ico svg { width: 15px !important; height: 15px !important; display: block; }
.t-dropzone__text { font-size: 12px; font-weight: 600; color: var(--tx-secondary); }
.t-dropzone__hint { font-size: 10.5px; color: var(--tx-muted); }

/* ── Foto preview strip ── */
.t-foto-strip {
  display: none;
  align-items: center;
  gap: 10px;
  padding: 10px 12px;
  background: var(--ac-dim);
  border: 1px solid var(--bd-accent);
  border-radius: var(--r-md);
  margin-top: 8px;
}
.t-foto-strip.visible { display: flex; }
.t-foto-strip__img {
  width: 44px; height: 44px;
  border-radius: var(--r-sm);
  object-fit: cover;
  border: 1px solid var(--bd-accent);
  flex-shrink: 0;
  display: block;
}
.t-foto-strip__name {
  font-family: var(--font-mono);
  font-size: 11px;
  color: var(--ac);
  flex: 1;
  min-width: 0;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}
.t-foto-strip__clear {
  width: 22px; height: 22px;
  background: none; border: none;
  cursor: pointer;
  color: var(--tx-muted);
  display: flex; align-items: center; justify-content: center;
  padding: 0; flex-shrink: 0; line-height: 0;
  transition: color var(--t-fast) var(--ease);
}
.t-foto-strip__clear:hover { color: var(--red); }
.t-foto-strip__clear svg { width: 13px !important; height: 13px !important; display: block; }

/* ── Checkbox row ── */
.t-check-row {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 12px 14px;
  background: var(--bg-elevated);
  border: 1px solid var(--bd-subtle);
  border-radius: var(--r-md);
  cursor: pointer;
  user-select: none;
  transition:
    border-color var(--t-fast) var(--ease),
    background   var(--t-fast) var(--ease);
}
.t-check-row:has(input:checked) {
  border-color: var(--bd-accent);
  background: var(--ac-dim);
}
.t-check-row input[type="checkbox"] { display: none; }
.t-check-box {
  width: 16px; height: 16px;
  border-radius: var(--r-xs);
  border: 1.5px solid var(--bd-default);
  background: var(--bg-overlay);
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
  transition: all var(--t-fast) var(--ease);
}
.t-check-row:has(input:checked) .t-check-box { background: var(--ac); border-color: var(--ac); }
.t-check-box svg { width: 10px !important; height: 10px !important; display: none; stroke: #0a0c10; flex-shrink: 0; }
.t-check-row:has(input:checked) .t-check-box svg { display: block; }
.t-check-text { font-size: 12.5px; font-weight: 500; color: var(--tx-secondary); flex: 1; }
.t-check-row:has(input:checked) .t-check-text { color: var(--tx-primary); }
.t-check-badge {
  font-family: var(--font-mono);
  font-size: 9px; font-weight: 600;
  letter-spacing: 0.1em; text-transform: uppercase;
  padding: 2px 7px;
  border-radius: 100px;
  background: var(--ac-glow);
  color: var(--ac);
  opacity: 0;
  white-space: nowrap;
  transition: opacity var(--t-base) var(--ease);
}
.t-check-row:has(input:checked) .t-check-badge { opacity: 1; }

/* ── Buttons ── */
.t-btn-cancel {
  display: inline-flex; align-items: center; gap: 6px;
  padding: 9px 16px;
  background: var(--bg-elevated);
  color: var(--tx-secondary);
  font-family: var(--font-ui);
  font-size: 12.5px; font-weight: 600;
  border: 1px solid var(--bd-subtle);
  border-radius: var(--r-md);
  cursor: pointer;
  text-decoration: none;
  transition: all var(--t-fast) var(--ease);
}
.t-btn-cancel:hover { border-color: var(--bd-default); color: var(--tx-primary); background: var(--bg-overlay); }

.t-btn-save {
  display: inline-flex; align-items: center; gap: 7px;
  padding: 9px 20px;
  background: var(--ac);
  color: #0a0c10;
  font-family: var(--font-ui);
  font-size: 12.5px; font-weight: 700;
  border: none;
  border-radius: var(--r-md);
  cursor: pointer;
  line-height: 1;
  transition:
    background  var(--t-fast) var(--ease),
    box-shadow  var(--t-base) var(--ease),
    transform   var(--t-fast) var(--ease);
}
.t-btn-save svg { width: 14px !important; height: 14px !important; display: block; flex-shrink: 0; }
.t-btn-save:hover { background: #7ec8f5; box-shadow: 0 4px 18px rgba(99,179,237,0.28); transform: translateY(-1px); }
.t-btn-save:active { transform: translateY(0); }
.t-btn-save.is-loading { opacity: .7; pointer-events: none; }
</style>

<div class="tambah-root">
<div class="tambah-wrap">

  <!-- Back -->
  <a href="<?= BASE_URL ?>/admin/anggota" class="tambah-back">
    <svg viewBox="0 0 14 14" width="13" height="13" fill="none" stroke="currentColor"
         stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
      <path d="M9 2L4 7l5 5"/>
    </svg>
    Kembali ke Daftar Anggota
  </a>

  <!-- Header -->
  <div class="tambah-ph">
    <div class="tambah-ph__eyebrow">Manajemen Anggota</div>
    <h1 class="tambah-ph__title">Tambah Anggota Manual</h1>
  </div>

  <!-- Flash -->
  <?php if (!empty($flash)): ?>
  <?php
    $flashIcons = [
      'success' => '<svg viewBox="0 0 16 16" width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="8" cy="8" r="6.5"/><path d="M5 8l2 2 4-4"/></svg>',
      'error'   => '<svg viewBox="0 0 16 16" width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="8" cy="8" r="6.5"/><path d="M8 5v3.5"/><circle cx="8" cy="11" r=".6" fill="currentColor"/></svg>',
      'warning' => '<svg viewBox="0 0 16 16" width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M8 2L1.5 13h13L8 2z"/><path d="M8 7v3"/><circle cx="8" cy="11.5" r=".6" fill="currentColor"/></svg>',
      'info'    => '<svg viewBox="0 0 16 16" width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="8" cy="8" r="6.5"/><path d="M8 7v4M8 5.5v.5"/></svg>',
    ];
  ?>
  <div class="t-flash t-flash--<?= htmlspecialchars($flash['type']) ?>">
    <?= $flashIcons[$flash['type']] ?? $flashIcons['info'] ?>
    <span><?= htmlspecialchars($flash['msg']) ?></span>
  </div>
  <?php endif; ?>

  <!-- Panel -->
  <div class="t-panel">
    <div class="t-panel__head">
      <span class="t-panel__head-title">Data Anggota Baru</span>
      <span class="t-panel__head-sub">— NIA dapat digenerate otomatis setelah simpan</span>
    </div>

    <form method="POST"
          action="<?= BASE_URL ?>/admin/anggota/tambah"
          enctype="multipart/form-data"
          id="add-form">
      <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">

      <div class="t-panel__body">

        <!-- ── Identitas ── -->
        <div class="t-section">
          <div class="t-section__lbl">Identitas</div>

          <div class="t-row">
            <!-- Nama -->
            <div class="t-field">
              <label class="t-field__lbl t-field__lbl--req" for="f-nama">Nama Lengkap</label>
              <div class="t-input-wrap">
                <span class="t-input-ico">
                  <svg viewBox="0 0 14 14" width="13" height="13" fill="none" stroke="currentColor"
                       stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <circle cx="7" cy="4.5" r="2.5"/>
                    <path d="M2 13c0-2.76 2.24-5 5-5s5 2.24 5 5"/>
                  </svg>
                </span>
                <input type="text" id="f-nama" name="nama_lengkap" required
                       class="t-input" placeholder="Nama lengkap…">
              </div>
            </div>
            <!-- Kelas -->
            <div class="t-field">
              <label class="t-field__lbl t-field__lbl--req" for="f-kelas">Kelas</label>
              <div class="t-input-wrap">
                <span class="t-input-ico">
                  <svg viewBox="0 0 14 14" width="13" height="13" fill="none" stroke="currentColor"
                       stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <rect x="1.5" y="1.5" width="11" height="11" rx="1.5"/>
                    <path d="M4.5 5h5M4.5 7.5h3.5M4.5 10h2.5"/>
                  </svg>
                </span>
                <input type="text" id="f-kelas" name="kelas" required
                       class="t-input" placeholder="mis. XI RPL 1">
              </div>
            </div>
          </div>

          <div class="t-row">
            <!-- No HP -->
            <div class="t-field">
              <label class="t-field__lbl" for="f-nohp">No HP / WhatsApp</label>
              <div class="t-input-wrap">
                <span class="t-input-ico">
                  <svg viewBox="0 0 14 14" width="13" height="13" fill="none" stroke="currentColor"
                       stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <rect x="3.5" y="1" width="7" height="12" rx="1.5"/>
                    <circle cx="7" cy="10.5" r=".5" fill="currentColor"/>
                  </svg>
                </span>
                <input type="tel" id="f-nohp" name="no_hp"
                       class="t-input" placeholder="08xx xxxx xxxx">
              </div>
            </div>
            <!-- Email -->
            <div class="t-field">
              <label class="t-field__lbl" for="f-email">Email</label>
              <div class="t-input-wrap">
                <span class="t-input-ico">
                  <svg viewBox="0 0 14 14" width="13" height="13" fill="none" stroke="currentColor"
                       stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <rect x="1" y="3" width="12" height="8" rx="1.5"/>
                    <path d="M1 4.5l6 3.5 6-3.5"/>
                  </svg>
                </span>
                <input type="email" id="f-email" name="email"
                       class="t-input" placeholder="email@domain.com">
              </div>
              <span class="t-field__hint">Opsional</span>
            </div>
          </div>
        </div>

        <!-- ── Keamanan ── -->
        <div class="t-section">
          <div class="t-section__lbl">Keamanan</div>

          <div class="t-field">
            <label class="t-field__lbl t-field__lbl--req" for="f-pass">Password</label>
            <div class="t-input-wrap t-input-wrap--pwd">
              <span class="t-input-ico">
                <svg viewBox="0 0 14 14" width="13" height="13" fill="none" stroke="currentColor"
                     stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                  <rect x="2.5" y="6" width="9" height="7" rx="1.2"/>
                  <path d="M4.5 6V4.5a2.5 2.5 0 015 0V6"/>
                </svg>
              </span>
              <input type="password" id="f-pass" name="password" required minlength="6"
                     class="t-input" placeholder="Min. 6 karakter">
              <button type="button" class="t-pwd-toggle" id="pwd-toggle"
                      aria-label="Toggle tampilkan password">
                <svg id="ico-eye" viewBox="0 0 14 14" width="13" height="13" fill="none"
                     stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                     stroke-linejoin="round" aria-hidden="true">
                  <ellipse cx="7" cy="7" rx="5.5" ry="3.5"/>
                  <circle cx="7" cy="7" r="1.5"/>
                </svg>
                <svg id="ico-eye-off" viewBox="0 0 14 14" width="13" height="13" fill="none"
                     stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                     stroke-linejoin="round" aria-hidden="true" style="display:none">
                  <path d="M1 1l12 12"/>
                  <path d="M8.95 8.95A3.5 3.5 0 015.05 5.05"/>
                  <path d="M3.1 3.1C1.8 4.1 1 5.46 1 7c0 0 2 4 6 4a7 7 0 002.9-.65M10.9 10.9C12.2 9.9 13 8.54 13 7c0 0-2-4-6-4a7 7 0 00-2.9.65"/>
                </svg>
              </button>
            </div>
            <span class="t-field__hint">Minimum 6 karakter</span>
          </div>
        </div>

        <!-- ── Foto Profil ── -->
        <div class="t-section">
          <div class="t-section__lbl">Foto Profil</div>

          <div class="t-field">
            <label class="t-field__lbl">
              Pas Foto
              <span style="font-weight:400;color:var(--tx-muted);"> — opsional, maks. 2 MB</span>
            </label>

            <div class="t-dropzone" id="foto-dropzone">
              <input type="file" name="foto" accept="image/*"
                     id="foto-input" aria-label="Upload foto profil">
              <div class="t-dropzone__ico">
                <svg viewBox="0 0 16 16" width="15" height="15" fill="none" stroke="currentColor"
                     stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                  <path d="M8 11V4M5 7l3-3 3 3"/>
                  <path d="M2 13h12"/>
                </svg>
              </div>
              <div class="t-dropzone__text">Klik atau seret foto ke sini</div>
              <div class="t-dropzone__hint">PNG, JPG, WEBP — maks. 2 MB</div>
            </div>

            <div class="t-foto-strip" id="foto-strip">
              <img class="t-foto-strip__img" id="foto-strip-img" src="" alt="Preview foto">
              <span class="t-foto-strip__name" id="foto-strip-name"></span>
              <button type="button" class="t-foto-strip__clear" id="foto-clear"
                      aria-label="Hapus pilihan foto">
                <svg viewBox="0 0 14 14" width="13" height="13" fill="none" stroke="currentColor"
                     stroke-width="1.8" stroke-linecap="round" aria-hidden="true">
                  <path d="M2 2l10 10M12 2L2 12"/>
                </svg>
              </button>
            </div>
          </div>
        </div>

        <!-- ── Pengaturan ── -->
        <div class="t-section">
          <div class="t-section__lbl">Pengaturan</div>

          <label class="t-check-row">
            <input type="checkbox" name="aktivasi_langsung" value="1" checked id="chk-aktif">
            <span class="t-check-box">
              <svg viewBox="0 0 10 10" width="10" height="10" fill="none" stroke="currentColor"
                   stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M2 5l2 2 4-4"/>
              </svg>
            </span>
            <span class="t-check-text">Aktifkan langsung &amp; generate NIA sekarang</span>
            <span class="t-check-badge">Auto NIA</span>
          </label>
        </div>

      </div><!-- /.t-panel__body -->

      <div class="t-panel__foot">
        <a href="<?= BASE_URL ?>/admin/anggota" class="t-btn-cancel">Batal</a>
        <button type="submit" class="t-btn-save" id="btn-save">
          <svg viewBox="0 0 14 14" width="14" height="14" fill="none" stroke="currentColor"
               stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M2 7l3.5 3.5L12 3"/>
          </svg>
          Simpan Anggota
        </button>
      </div>

    </form>
  </div><!-- /.t-panel -->

</div>
</div>

<script>
(function () {
  'use strict';

  /* ── Password toggle ── */
  var passInput = document.getElementById('f-pass');
  var pwdToggle = document.getElementById('pwd-toggle');
  var icoEye    = document.getElementById('ico-eye');
  var icoEyeOff = document.getElementById('ico-eye-off');

  if (pwdToggle && passInput) {
    pwdToggle.addEventListener('click', function () {
      var show = passInput.type === 'password';
      passInput.type = show ? 'text' : 'password';
      icoEye.style.display    = show ? 'none' : '';
      icoEyeOff.style.display = show ? ''     : 'none';
    });
  }

  /* ── Foto dropzone ── */
  var fileInput = document.getElementById('foto-input');
  var dropzone  = document.getElementById('foto-dropzone');
  var strip     = document.getElementById('foto-strip');
  var stripImg  = document.getElementById('foto-strip-img');
  var stripName = document.getElementById('foto-strip-name');
  var clearBtn  = document.getElementById('foto-clear');

  function showPreview(file) {
    stripName.textContent = file.name;
    var reader = new FileReader();
    reader.onload = function (e) {
      stripImg.src = e.target.result;
      strip.classList.add('visible');
    };
    reader.readAsDataURL(file);
  }

  function clearPreview() {
    fileInput.value = '';
    strip.classList.remove('visible');
    stripImg.src = '';
    stripName.textContent = '';
  }

  if (fileInput) {
    fileInput.addEventListener('change', function () {
      if (fileInput.files && fileInput.files[0]) showPreview(fileInput.files[0]);
    });
    dropzone.addEventListener('dragover', function (e) {
      e.preventDefault();
      dropzone.classList.add('drag-over');
    });
    ['dragleave', 'drop'].forEach(function (ev) {
      dropzone.addEventListener(ev, function () { dropzone.classList.remove('drag-over'); });
    });
  }

  if (clearBtn) { clearBtn.addEventListener('click', clearPreview); }

  /* ── Submit loading ── */
  var form    = document.getElementById('add-form');
  var saveBtn = document.getElementById('btn-save');
  if (form && saveBtn) {
    form.addEventListener('submit', function () {
      saveBtn.classList.add('is-loading');
      saveBtn.innerHTML =
        '<svg width="14" height="14" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true">' +
          '<path d="M7 2a5 5 0 110 10" stroke-dasharray="20" stroke-dashoffset="20">' +
            '<animate attributeName="stroke-dashoffset" values="20;0" dur="0.8s" repeatCount="indefinite"/>' +
          '</path>' +
        '</svg> Menyimpan…';
    });
  }
}());
</script>