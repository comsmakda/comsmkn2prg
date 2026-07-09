<?php // app/views/pages/pab.php ?>

<?php
/* ── Open Graph meta tags (inject ke <head> via layout) ── */
$og_title       = "Daftar Sekarang! PAB " . ($settings['org_name']['value'] ?? APP_NAME) . " — Komunitas Programmer SMKN 2 Pinrang";
$og_description = "Bergabunglah bersama komunitas programmer SMKN 2 Pinrang! Daftarkan diri kamu sekarang dan jadilah bagian dari generasi teknologi berikutnya. 💻🚀";
$og_url         = BASE_URL . "/pab";
$og_image       = BASE_URL . "/assets/img/logo-com.png";

if (!isset($extra_head)) $extra_head = '';
$extra_head .= '
<meta property="og:type"         content="website">
<meta property="og:url"          content="' . htmlspecialchars($og_url) . '">
<meta property="og:title"        content="' . htmlspecialchars($og_title) . '">
<meta property="og:description"  content="' . htmlspecialchars($og_description) . '">
<meta property="og:image"        content="' . htmlspecialchars($og_image) . '">
<meta property="og:image:width"  content="1200">
<meta property="og:image:height" content="630">
<meta property="og:locale"       content="id_ID">
<meta property="og:site_name"    content="' . htmlspecialchars($settings['org_name']['value'] ?? APP_NAME) . '">
<meta name="twitter:card"        content="summary_large_image">
<meta name="twitter:title"       content="' . htmlspecialchars($og_title) . '">
<meta name="twitter:description" content="' . htmlspecialchars($og_description) . '">
<meta name="twitter:image"       content="' . htmlspecialchars($og_image) . '">
<meta name="description"         content="' . htmlspecialchars($og_description) . '">
';
?>

<style>
/* ═══════════════════════════════════════════
   PAB PAGE — versi simple, jelas, satu kolom
   (token asli didefinisikan global di layout;
    fallback disertakan bila halaman ini dirender berdiri sendiri)
═══════════════════════════════════════════ */
.pab-wrap {
  --tx-primary:   var(--c-ink,    #0f172a);
  --tx-secondary: var(--c-muted,  #64748b);
  --tx-muted:     var(--c-muted2, #94a3b8);
  --bg-page:      var(--c-page,   #f4f6f9);
  --bg-surface:   var(--c-white,  #ffffff);
  --bg-elevated:  #f8fafc;
  --bd-subtle:    var(--c-border, #e6ebf1);
  --ac:           var(--c-primary,    #0e7490);
  --ac-dk:        var(--c-primary-dk, #0b5a70);
  --ac-lt:        var(--c-primary-lt, #06b6d4);
  --green:      var(--c-green-text,   #15803d);
  --green-bg:   var(--c-green-bg,     #f0fdf4);
  --green-bd:   var(--c-green-border, #bbf7d0);
  --red:        var(--c-red-text,     #b91c1c);
  --red-bg:     var(--c-red-bg,       #fef2f2);
  --red-bd:     var(--c-red-border,   #fecaca);
  --amber:      var(--c-amber-icon,   #b7791f);
  --amber-bg:   var(--c-amber-bg,     #fef6e2);
  --amber-bd:   var(--c-amber-border, #fbe3a8);
  --r-sm: var(--radius-sm, 9px);
  --r-md: var(--radius-md, 13px);
  --r-lg: var(--radius-lg, 18px);
  --font-ui: var(--ff, 'Plus Jakarta Sans', sans-serif);

  min-height: calc(100svh - 68px);
  padding: 3rem 1.25rem;
  background: var(--bg-page);
  font-family: var(--font-ui);
  color: var(--tx-primary);
}

.pab-shell {
  width: 100%;
  max-width: 620px;
  margin: 0 auto;
}

/* ── Header ── */
.pab-header { text-align: center; margin-bottom: 1.75rem; }
.pab-logo {
  height: 48px; width: auto; object-fit: contain;
  margin: 0 auto 1rem;
  display: block;
}
.pab-eyebrow {
  font-size: .72rem; font-weight: 700; color: var(--ac);
  letter-spacing: .06em; text-transform: uppercase;
  margin-bottom: .4rem;
}
.pab-title {
  font-size: clamp(1.4rem, 4vw, 1.7rem);
  font-weight: 800; color: var(--tx-primary);
  letter-spacing: -.02em; line-height: 1.25;
  margin-bottom: .5rem;
}
.pab-subtitle {
  font-size: .88rem; color: var(--tx-secondary);
  line-height: 1.6; max-width: 460px; margin: 0 auto;
}
.pab-deadline {
  display: inline-flex; align-items: center; gap: 6px;
  margin-top: .9rem;
  font-size: .74rem; font-weight: 700; color: var(--amber);
  background: var(--amber-bg); border: 1px solid var(--amber-bd);
  border-radius: 99px; padding: 5px 14px;
}

/* ── Flash alert ── */
.pab-alert {
  border-radius: var(--r-md); padding: .85rem 1rem; font-size: .84rem;
  margin-bottom: 1.25rem; border: 1px solid;
  display: flex; align-items: flex-start; gap: 9px;
  font-weight: 500;
}
.pab-alert-icon { flex-shrink: 0; margin-top: 1px; }
.pab-alert.success { background: var(--green-bg); border-color: var(--green-bd); color: var(--green); }
.pab-alert.error   { background: var(--red-bg);   border-color: var(--red-bd);   color: var(--red); }
.pab-alert.info    { background: rgba(14,116,144,.07); border-color: rgba(14,116,144,.22); color: var(--ac); }

/* ── Persyaratan (info card ringkas) ── */
.pab-req {
  background: var(--bg-elevated);
  border: 1px solid var(--bd-subtle);
  border-radius: var(--r-md);
  padding: 1rem 1.15rem;
  margin-bottom: 1.5rem;
}
.pab-req-title {
  display: flex; align-items: center; gap: 7px;
  font-size: .78rem; font-weight: 800; color: var(--tx-primary);
  margin-bottom: .6rem;
}
.pab-req-title svg { color: var(--ac); flex-shrink: 0; }
.pab-req-list { display: flex; flex-direction: column; gap: .4rem; }
.pab-req-item {
  display: flex; align-items: flex-start; gap: 8px;
  font-size: .78rem; color: var(--tx-secondary); line-height: 1.5;
}
.pab-req-item svg { flex-shrink: 0; margin-top: 3px; color: var(--green); }

/* ── Card ── */
.pab-card {
  background: var(--bg-surface);
  border: 1px solid var(--bd-subtle);
  border-radius: var(--r-lg);
  overflow: hidden;
  box-shadow: 0 8px 28px -8px rgba(15,23,42,.10);
}

/* ── Closed state ── */
.pab-closed { text-align: center; padding: 3rem 2rem; }
.pab-closed-icon {
  width: 56px; height: 56px;
  background: var(--red-bg);
  border: 1px solid var(--red-bd);
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  margin: 0 auto 1.1rem; color: var(--red);
}
.pab-closed h2 { font-size: 1.1rem; font-weight: 800; color: var(--tx-primary); margin-bottom: .5rem; }
.pab-closed p { font-size: .84rem; color: var(--tx-secondary); line-height: 1.7; max-width: 360px; margin: 0 auto; }

.pab-card-body { padding: 1.75rem; }

/* ── Section label (pengganti step indicator) ── */
.pab-section {
  display: flex; align-items: center; gap: 9px;
  margin: 1.6rem 0 1rem;
}
.pab-section:first-child { margin-top: 0; }
.pab-section-num {
  width: 22px; height: 22px; border-radius: 50%;
  background: var(--ac); color: #fff;
  font-size: .68rem; font-weight: 800;
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
}
.pab-section-title {
  font-size: .84rem; font-weight: 800; color: var(--tx-primary);
}

/* ── Form fields ── */
.pab-form { display: flex; flex-direction: column; gap: 1rem; }
.pab-field { display: flex; flex-direction: column; gap: .4rem; }
.pab-label { font-size: .78rem; font-weight: 700; color: var(--tx-primary); letter-spacing: -.01em; }
.pab-label span { color: var(--red); margin-left: 2px; }
.pab-hint { font-size: .7rem; color: var(--tx-muted); letter-spacing: .01em; }

.pab-input {
  width: 100%;
  background: #fbfcfe;
  border: 1.5px solid var(--bd-subtle);
  border-radius: var(--r-sm);
  padding: 12px 15px;
  font-size: .9rem; color: var(--tx-primary);
  font-family: inherit;
  outline: none;
  transition: border-color .16s, box-shadow .16s, background .16s;
  appearance: none;
}
.pab-input::placeholder { color: var(--tx-muted); }
.pab-input:hover  { border-color: var(--c-muted2, #94a3b8); }
.pab-input:focus  { border-color: var(--ac-lt); box-shadow: 0 0 0 3px rgba(6,182,212,.12); background: #fff; }

.pab-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }

/* ── Dropzone ── */
.pab-dropzone {
  width: 100%;
  border: 1.5px dashed var(--bd-subtle);
  border-radius: var(--r-sm);
  background: #fbfcfe;
  cursor: pointer;
  transition: border-color .2s, background .2s;
  overflow: hidden; position: relative;
  min-height: 120px;
  display: flex; align-items: center; justify-content: center;
}
.pab-dropzone:hover, .pab-dropzone.drag-over { border-color: var(--ac-lt); background: rgba(6,182,212,.05); }
.pab-dropzone-inner {
  display: flex; flex-direction: column; align-items: center; justify-content: center;
  gap: .4rem; padding: 1.4rem; text-align: center; pointer-events: none;
}
.pab-dropzone-icon {
  width: 36px; height: 36px; border-radius: var(--r-sm);
  background: rgba(14,116,144,.09);
  display: flex; align-items: center; justify-content: center;
  color: var(--ac); margin-bottom: .2rem;
  transition: background .2s;
}
.pab-dropzone:hover .pab-dropzone-icon { background: rgba(14,116,144,.16); }
.pab-dropzone-label { font-size: .82rem; font-weight: 700; color: var(--tx-primary); }
.pab-dropzone-sub { font-size: .66rem; color: var(--tx-muted); letter-spacing: .02em; }
#pab-preview { width: 100%; height: 140px; object-fit: cover; display: none; }
#pab-preview.show { display: block; }
.pab-preview-reset {
  position: absolute; top: 8px; right: 8px;
  width: 28px; height: 28px; border-radius: 50%;
  background: rgba(15,23,42,.55);
  border: 1px solid rgba(255,255,255,.25);
  display: none; align-items: center; justify-content: center;
  cursor: pointer; color: #fff; z-index: 2;
  transition: background .2s;
}
.pab-preview-reset:hover { background: rgba(185,28,28,.7); }
.pab-preview-reset.show { display: flex; }
.pab-file-error {
  display: none;
  align-items: center; gap: 6px;
  font-size: .72rem; color: var(--red);
  margin-top: .2rem;
  font-weight: 500;
}
.pab-file-error.show { display: flex; }

/* ── Submit button ── */
.pab-submit {
  width: 100%; padding: 13px;
  background: var(--ac); color: #fff;
  font-weight: 800; font-size: .9rem;
  border: none; border-radius: var(--r-sm); cursor: pointer;
  display: flex; align-items: center; justify-content: center; gap: 8px;
  transition: background .18s, box-shadow .18s;
  box-shadow: 0 6px 16px rgba(14,116,144,.22);
  letter-spacing: -.01em; margin-top: .5rem;
  font-family: inherit;
}
.pab-submit:hover { background: var(--ac-lt); }
.pab-submit:disabled { opacity: .55; cursor: not-allowed; }

.pab-privacy-note {
  font-size: .68rem; color: var(--tx-muted); text-align: center; line-height: 1.6;
  margin-top: .7rem;
}

.pab-back { text-align: center; margin-top: 1.5rem; }
.pab-back a {
  font-size: .82rem; color: var(--tx-secondary); text-decoration: none;
  transition: color .2s;
  display: inline-flex; align-items: center; gap: 5px;
  font-weight: 600;
}
.pab-back a:hover { color: var(--ac); }

/* ── Responsive ── */
@media (max-width: 480px) {
  .pab-wrap { padding: 2rem 1rem 2.5rem; }
  .pab-card-body { padding: 1.25rem; }
  .pab-grid-2 { grid-template-columns: 1fr; }
  .pab-title { font-size: 1.3rem; }
}

@keyframes spin { to { transform: rotate(360deg); } }
</style>

<div class="pab-wrap">
  <div class="pab-shell">

    <!-- ── Header ── -->
    <div class="pab-header">
      <img
        src="<?= BASE_URL ?>/assets/img/logo-com.png"
        alt="Logo <?= htmlspecialchars($settings['org_name']['value'] ?? APP_NAME) ?>"
        class="pab-logo"
        width="48" height="48"
        loading="eager"
        onerror="this.style.display='none'">
      <div class="pab-eyebrow">Penerimaan Anggota Baru</div>
      <h1 class="pab-title"><?= htmlspecialchars($settings['org_name']['value'] ?? APP_NAME) ?></h1>
      <p class="pab-subtitle">
        Daftar sekarang dan jadi bagian dari komunitas programmer SMKN 2 Pinrang. Belajar coding, kerjakan proyek nyata, tumbuh bareng.
      </p>
      <?php if (!empty($settings['pab_deadline']['value'])): ?>
        <div class="pab-deadline">
          <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
          Pendaftaran ditutup: <?= htmlspecialchars($settings['pab_deadline']['value']) ?>
        </div>
      <?php endif; ?>
    </div>

    <!-- ── Flash alert ── -->
    <?php if (!empty($flash)): ?>
      <?php
        $alertType = $flash['type'] === 'success' ? 'success' : ($flash['type'] === 'info' ? 'info' : 'error');
        $alertIcon = $alertType === 'success'
          ? '<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>'
          : '<circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>';
      ?>
      <div class="pab-alert <?= $alertType ?>" role="alert">
        <svg class="pab-alert-icon" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><?= $alertIcon ?></svg>
        <?= $flash['msg'] ?>
      </div>
    <?php endif; ?>

    <?php if ($isOpen): ?>
    <!-- ── Yang perlu disiapkan ── -->
    <section class="pab-req" aria-labelledby="pab-req-title">
      <div class="pab-req-title" id="pab-req-title">
        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
        Siapkan sebelum mengisi form
      </div>
      <div class="pab-req-list">
        <div class="pab-req-item">
          <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
          <span>Nama lengkap, kelas, dan nomor HP aktif (untuk dihubungi lewat WhatsApp).</span>
        </div>
        <div class="pab-req-item">
          <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
          <span>Password baru (minimal 6 karakter) untuk login ke portal setelah daftar.</span>
        </div>
        <div class="pab-req-item">
          <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
          <span>Pas foto JPG/PNG/WEBP, maksimal 2 MB.</span>
        </div>
      </div>
    </section>
    <?php endif; ?>

    <!-- ── Card ── -->
    <div class="pab-card">

      <?php if (!$isOpen): ?>
        <!-- Closed state -->
        <div class="pab-closed">
          <div class="pab-closed-icon">
            <svg width="26" height="26" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
          </div>
          <h2>Pendaftaran Ditutup</h2>
          <p>Saat ini pendaftaran PAB sedang tidak dibuka. Pantau terus informasi selanjutnya melalui media sosial kami.</p>
        </div>

      <?php else: ?>
        <div class="pab-card-body">
          <form method="POST" action="<?= BASE_URL ?>/pab/register"
                enctype="multipart/form-data" class="pab-form" id="pab-form" novalidate>
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">

            <!-- Section 1: Data Diri -->
            <div class="pab-section">
              <span class="pab-section-num">1</span>
              <span class="pab-section-title">Data Diri</span>
            </div>

            <div class="pab-field">
              <label class="pab-label" for="pab-nama">Nama Lengkap <span>*</span></label>
              <input id="pab-nama" type="text" name="nama_lengkap" required
                     class="pab-input" placeholder="Nama sesuai rapor"
                     autocomplete="name">
            </div>

            <div class="pab-grid-2">
              <div class="pab-field">
                <label class="pab-label" for="pab-kelas">Kelas <span>*</span></label>
                <input id="pab-kelas" type="text" name="kelas" required
                       class="pab-input" placeholder="Contoh: XI RPL 1">
              </div>
              <div class="pab-field">
                <label class="pab-label" for="pab-hp">Nomor HP <span>*</span></label>
                <input id="pab-hp" type="tel" name="no_hp" required
                       class="pab-input" placeholder="08xxxxxxxxxx"
                       autocomplete="tel" pattern="[0-9]{10,15}"
                       inputmode="numeric">
              </div>
            </div>

            <!-- Section 2: Akun Portal -->
            <div class="pab-section">
              <span class="pab-section-num">2</span>
              <span class="pab-section-title">Buat Akun Portal</span>
            </div>

            <div class="pab-field">
              <label class="pab-label" for="pab-pass">Password <span>*</span></label>
              <div style="position:relative">
                <input id="pab-pass" type="password" name="password" required
                       minlength="6" class="pab-input" placeholder="Minimal 6 karakter"
                       autocomplete="new-password" style="padding-right:2.8rem">
                <button type="button" id="toggle-pass"
                        style="position:absolute;right:.75rem;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--tx-muted);padding:0;display:flex;align-items:center;"
                        aria-label="Tampilkan password">
                  <svg id="eye-icon" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                </button>
              </div>
              <span class="pab-hint">Dipakai untuk login ke portal — jangan sampai lupa, ya.</span>
            </div>

            <div class="pab-field">
              <label class="pab-label" for="pab-pass2">Konfirmasi Password <span>*</span></label>
              <div style="position:relative">
                <input id="pab-pass2" type="password" name="password_confirmation" required
                       class="pab-input" placeholder="Ulangi password yang sama"
                       autocomplete="new-password" style="padding-right:2.8rem">
                <span id="pass-match-icon"
                      style="position:absolute;right:.75rem;top:50%;transform:translateY(-50%);display:none;"></span>
              </div>
              <span class="pab-hint" id="pass-match-text"></span>
            </div>

            <!-- Section 3: Pas Foto -->
            <div class="pab-section">
              <span class="pab-section-num">3</span>
              <span class="pab-section-title">Pas Foto</span>
            </div>

            <div class="pab-field">
              <div class="pab-dropzone" id="pab-dropzone" role="button" tabindex="0"
                   aria-label="Unggah pas foto">
                <img id="pab-preview" alt="Preview foto">
                <button type="button" class="pab-preview-reset" id="pab-reset-photo"
                        aria-label="Hapus foto">
                  <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
                <div class="pab-dropzone-inner" id="pab-dz-inner">
                  <div class="pab-dropzone-icon">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                  </div>
                  <span class="pab-dropzone-label">Klik atau seret foto ke sini</span>
                  <span class="pab-dropzone-sub">JPG · PNG · WEBP — Maks. 2 MB</span>
                </div>
                <input type="file" name="foto" id="pab-foto"
                       accept="image/jpeg,image/png,image/webp"
                       class="hidden" required style="display:none">
              </div>
              <span class="pab-file-error" id="pab-file-error">
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                <span id="pab-file-error-text">Ukuran foto maksimal 2 MB.</span>
              </span>
            </div>

            <!-- Submit -->
            <button type="submit" class="pab-submit" id="pab-submit">
              <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
              Kirim Pendaftaran
            </button>

            <p class="pab-privacy-note">
              Dengan mengirim formulir ini, kamu menyetujui data digunakan hanya untuk keperluan seleksi anggota.
            </p>

          </form>
        </div><!-- .pab-card-body -->
      <?php endif; ?>
    </div><!-- .pab-card -->

    <div class="pab-back">
      <a href="<?= BASE_URL ?>/">
        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
        Kembali ke beranda
      </a>
    </div>

  </div><!-- .pab-shell -->
</div><!-- .pab-wrap -->

<script>
(function () {
  'use strict';

  /* ── Toggle password visibility ── */
  var passInput  = document.getElementById('pab-pass');
  var toggleBtn  = document.getElementById('toggle-pass');
  var eyeIcon    = document.getElementById('eye-icon');
  if (toggleBtn && passInput) {
    toggleBtn.addEventListener('click', function () {
      var isHidden = passInput.type === 'password';
      passInput.type = isHidden ? 'text' : 'password';
      toggleBtn.setAttribute('aria-label', isHidden ? 'Sembunyikan password' : 'Tampilkan password');
      eyeIcon.innerHTML = isHidden
        ? '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>'
        : '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
    });
  }

  /* ── Password match indicator ── */
  var pass2Input   = document.getElementById('pab-pass2');
  var matchIcon    = document.getElementById('pass-match-icon');
  var matchText    = document.getElementById('pass-match-text');
  function checkMatch() {
    if (!passInput || !pass2Input || !pass2Input.value) {
      if (matchIcon) matchIcon.style.display = 'none';
      if (matchText) matchText.textContent = '';
      return;
    }
    var ok = passInput.value === pass2Input.value;
    matchIcon.style.display = 'flex';
    matchIcon.innerHTML = ok
      ? '<svg width="16" height="16" fill="none" stroke="#15803d" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>'
      : '<svg width="16" height="16" fill="none" stroke="#b91c1c" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>';
    if (matchText) {
      matchText.textContent = ok ? 'Password cocok.' : 'Password belum sama.';
      matchText.style.color = ok ? '#15803d' : '#b91c1c';
    }
  }
  if (pass2Input) {
    pass2Input.addEventListener('input', checkMatch);
    if (passInput) passInput.addEventListener('input', checkMatch);
  }

  /* ── Dropzone / file upload ── */
  var dropzone   = document.getElementById('pab-dropzone');
  var fileInput  = document.getElementById('pab-foto');
  var preview    = document.getElementById('pab-preview');
  var dzInner    = document.getElementById('pab-dz-inner');
  var resetBtn   = document.getElementById('pab-reset-photo');
  var fileError  = document.getElementById('pab-file-error');
  var fileErrTxt = document.getElementById('pab-file-error-text');

  function showFileError(msg) {
    if (fileError && fileErrTxt) {
      fileErrTxt.textContent = msg;
      fileError.classList.add('show');
    }
  }
  function hideFileError() {
    if (fileError) fileError.classList.remove('show');
  }

  function showPreview(file) {
    if (!file) return;
    if (!file.type.startsWith('image/')) {
      showFileError('File harus berupa gambar (JPG, PNG, atau WEBP).');
      return;
    }
    if (file.size > 2 * 1024 * 1024) {
      showFileError('Ukuran foto maksimal 2 MB.');
      return;
    }
    hideFileError();
    var reader = new FileReader();
    reader.onload = function (e) {
      preview.src = e.target.result;
      preview.classList.add('show');
      dzInner.style.display = 'none';
      resetBtn.classList.add('show');
    };
    reader.readAsDataURL(file);
  }

  function resetPhoto() {
    preview.src = '';
    preview.classList.remove('show');
    dzInner.style.display = '';
    resetBtn.classList.remove('show');
    fileInput.value = '';
    hideFileError();
  }

  if (dropzone) {
    dropzone.addEventListener('click', function (e) {
      if (e.target === resetBtn || resetBtn.contains(e.target)) return;
      fileInput.click();
    });
    dropzone.addEventListener('keydown', function (e) {
      if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); fileInput.click(); }
    });
    dropzone.addEventListener('dragover', function (e) {
      e.preventDefault();
      dropzone.classList.add('drag-over');
    });
    dropzone.addEventListener('dragleave', function () {
      dropzone.classList.remove('drag-over');
    });
    dropzone.addEventListener('drop', function (e) {
      e.preventDefault();
      dropzone.classList.remove('drag-over');
      var files = e.dataTransfer.files;
      if (files.length) {
        fileInput.files = files;
        showPreview(files[0]);
      }
    });
  }
  if (fileInput) {
    fileInput.addEventListener('change', function () {
      if (this.files[0]) showPreview(this.files[0]);
    });
  }
  if (resetBtn) {
    resetBtn.addEventListener('click', function (e) {
      e.stopPropagation();
      resetPhoto();
    });
  }

  /* ── Submit loading state ── */
  var form      = document.getElementById('pab-form');
  var submitBtn = document.getElementById('pab-submit');
  if (form && submitBtn) {
    form.addEventListener('submit', function () {
      submitBtn.disabled = true;
      submitBtn.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="animation:spin .8s linear infinite"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/></svg> Mengirim...';
    });
  }
})();
</script>