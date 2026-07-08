<?php // app/views/member/profile.php ?>

<style>
  /* ─── Page heading ─── */
  .page-title {
    font-size    : 21px;
    font-weight  : 800;
    color        : var(--c-primary-dk);
    letter-spacing: -0.4px;
    margin-bottom: 20px;
    line-height  : 1.3;
  }

  /* ─── Two-column grid — dilebarkan & dibuat seimbang ─── */
  .profile-grid {
    display              : grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    align-items          : stretch;   /* kartu di baris yang sama menyamakan tinggi */
    gap                  : 16px;
    max-width            : 960px;
    margin               : 0 auto;    /* center di layar lebar */
  }

  /* ─── Card ─── */
  .profile-card {
    display      : flex;
    flex-direction: column;
    background   : var(--c-white);
    border       : 1px solid var(--c-border);
    border-radius: var(--radius-lg);
    padding      : 24px 26px;
    box-shadow   : 0 20px 46px -18px rgba(15,23,42,.14), 0 3px 12px rgba(15,23,42,.05);
  }

  .profile-card__header {
    display      : flex;
    align-items  : center;
    gap          : 10px;
    margin-bottom: 18px;
    padding-bottom: 14px;
    border-bottom: 1px solid var(--c-border);
  }

  .profile-card__header-icon {
    width          : 30px;
    height         : 30px;
    border-radius  : var(--radius-sm);
    background     : rgba(14,116,144,.08);
    border         : 1px solid rgba(14,116,144,.22);
    display        : flex;
    align-items    : center;
    justify-content: center;
    color          : var(--c-primary);
    flex-shrink    : 0;
    font-size      : 15px;
  }

  .profile-card__title {
    font-size  : 14.5px;
    font-weight: 700;
    color      : var(--c-ink);
  }

  /* ─── User identity row ─── */
  .user-identity {
    display      : flex;
    align-items  : center;
    gap          : 12px;
    margin-bottom: 18px;
    padding      : 12px 14px;
    background   : #f4f7fa;
    border       : 1px solid var(--c-border);
    border-radius: var(--radius-md);
  }

  .user-identity__avatar {
    width          : 44px;
    height         : 44px;
    border-radius  : 50%;
    object-fit     : cover;
    border         : 2px solid rgba(14,116,144,.3);
    flex-shrink    : 0;
  }

  .user-identity__avatar-fallback {
    width          : 44px;
    height         : 44px;
    border-radius  : 50%;
    background     : rgba(14,116,144,.12);
    border         : 2px solid rgba(14,116,144,.3);
    display        : flex;
    align-items    : center;
    justify-content: center;
    font-size      : 17px;
    font-weight    : 800;
    color          : var(--c-primary);
    flex-shrink    : 0;
    text-transform : uppercase;
  }

  .user-identity__info { min-width: 0; }

  .user-identity__name {
    font-size    : 14px;
    font-weight  : 700;
    color        : var(--c-ink);
    white-space  : nowrap;
    overflow     : hidden;
    text-overflow: ellipsis;
    line-height  : 1.3;
  }

  .user-identity__nia {
    font-size    : 11.5px;
    font-weight  : 700;
    color        : var(--c-primary);
    font-variant-numeric: tabular-nums;
    letter-spacing: 0.04em;
    line-height  : 1.3;
  }

  /* ─── Form ─── */
  .form-stack { display: flex; flex-direction: column; gap: 14px; flex: 1; }

  .form-field { display: flex; flex-direction: column; gap: 5px; }

  .form-field label {
    font-size    : 12px;
    font-weight  : 700;
    color        : var(--c-muted);
    letter-spacing: 0.01em;
  }

  .form-field input[type="text"],
  .form-field input[type="tel"],
  .form-field input[type="password"] {
    width        : 100%;
    height       : 40px;
    padding      : 0 13px;
    background   : #fbfcfe;
    border       : 1.5px solid var(--c-border);
    border-radius: var(--radius-sm);
    color        : var(--c-ink);
    font-family  : inherit;
    font-size    : 13.5px;
    outline      : none;
    transition   : border-color 150ms ease, box-shadow 150ms ease, background 150ms ease;
  }

  .form-field input:hover {
    border-color: #cbd5e1;
  }

  .form-field input:focus {
    border-color: var(--c-primary-lt);
    box-shadow  : 0 0 0 3px rgba(6,182,212,.12);
    background  : #fff;
  }

  .form-field input::placeholder { color: var(--c-muted2); }

  /* File input */
  .file-field {
    display      : flex;
    align-items  : center;
    gap          : 10px;
    padding      : 10px 13px;
    background   : #fbfcfe;
    border       : 1.5px dashed var(--c-border);
    border-radius: var(--radius-sm);
    cursor       : pointer;
    transition   : border-color 150ms, background 150ms;
  }
  .file-field:hover {
    border-color: var(--c-primary-lt);
    background  : rgba(6,182,212,.05);
  }

  .file-field__icon {
    width          : 30px;
    height         : 30px;
    border-radius  : var(--radius-sm);
    background     : #eef2f6;
    border         : 1px solid var(--c-border);
    display        : flex;
    align-items    : center;
    justify-content: center;
    color          : var(--c-muted);
    flex-shrink    : 0;
    font-size      : 14px;
  }

  .file-field__label {
    flex      : 1;
    min-width : 0;
  }
  .file-field__label span {
    display  : block;
    font-size: 12.5px;
    font-weight: 600;
    color    : var(--c-ink);
  }
  .file-field__label small {
    font-size: 11px;
    color    : var(--c-muted2);
  }

  .file-field input[type="file"] {
    position: absolute;
    opacity : 0;
    width   : 0;
    height  : 0;
  }

  /* Submit button — Design System §5.3 */
  .btn-submit {
    display        : flex;
    align-items    : center;
    justify-content: center;
    gap            : 8px;
    width          : 100%;
    height         : 42px;
    border-radius  : var(--radius-sm);
    background     : var(--c-primary);
    border         : none;
    color          : #fff;
    font-family    : inherit;
    font-size      : 13.5px;
    font-weight    : 800;
    cursor         : pointer;
    box-shadow     : 0 8px 22px rgba(14,116,144,.25);
    transition     : background 180ms, transform 120ms, box-shadow 180ms;
    margin-top     : auto;
    padding-top    : 4px;
  }
  .btn-submit:hover {
    background: var(--c-primary-lt);
    transform : translateY(-2px);
    box-shadow: 0 12px 28px rgba(6,182,212,.3);
  }
  .btn-submit:active  { transform: translateY(0) scale(0.98); }
  .btn-submit i { font-size: 15px; }

  /* ─── Flash inside page (if needed) ─── */
  .flash-local { margin-bottom: 16px; max-width: 960px; margin-left: auto; margin-right: auto; }

  /* ─── Responsif — 1 kolom di layar sempit ─── */
  @media (max-width: 700px) {
    .profile-grid { grid-template-columns: 1fr; }
  }
</style>

<p class="page-title">Profil Saya</p>

<?php if (!empty($flash)): ?>
  <?php
    $type = $flash['type'] ?? 'info';
    $safeType = in_array($type, ['success','danger','error','warning','info']) ? $type : 'info';
  ?>
  <div class="flash-local">
    <div class="alert alert--<?= $safeType ?>" role="alert">
      <?= alertIcon($type) ?>
      <span><?= htmlspecialchars($flash['msg'] ?? '') ?></span>
    </div>
  </div>
<?php endif; ?>

<div class="profile-grid">

  <!-- ── Edit profil ─────────────────────── -->
  <div class="profile-card">

    <div class="profile-card__header">
      <div class="profile-card__header-icon" aria-hidden="true">
        <i class="ti ti-edit"></i>
      </div>
      <h2 class="profile-card__title">Edit Data Diri</h2>
    </div>

    <!-- Identity preview -->
    <div class="user-identity">
      <?php if (!empty($user['foto'])): ?>
        <img src="<?= UPLOAD_URL . '/' . htmlspecialchars($user['foto']) ?>"
             class="user-identity__avatar"
             alt="Foto <?= htmlspecialchars($user['nama_lengkap']) ?>">
      <?php else: ?>
        <div class="user-identity__avatar-fallback" aria-hidden="true">
          <?= htmlspecialchars(mb_strtoupper(mb_substr($user['nama_lengkap'], 0, 1))) ?>
        </div>
      <?php endif; ?>
      <div class="user-identity__info">
        <p class="user-identity__name"><?= htmlspecialchars($user['nama_lengkap']) ?></p>
        <p class="user-identity__nia"><?= htmlspecialchars($user['nia'] ?? '—') ?></p>
      </div>
    </div>

    <form method="POST" action="<?= BASE_URL ?>/member/profile/update"
          enctype="multipart/form-data" autocomplete="off" style="display:flex; flex-direction:column; flex:1;">
      <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">

      <div class="form-stack">

        <div class="form-field">
          <label for="nama_lengkap">Nama Lengkap</label>
          <input type="text" id="nama_lengkap" name="nama_lengkap" required
                 placeholder="Nama lengkap"
                 value="<?= htmlspecialchars($user['nama_lengkap']) ?>">
        </div>

        <div class="form-field">
          <label for="kelas">Kelas</label>
          <input type="text" id="kelas" name="kelas"
                 placeholder="Contoh: XII IPA 1"
                 value="<?= htmlspecialchars($user['kelas'] ?? '') ?>">
        </div>

        <div class="form-field">
          <label for="no_hp">Nomor HP</label>
          <input type="tel" id="no_hp" name="no_hp"
                 placeholder="08xx-xxxx-xxxx"
                 value="<?= htmlspecialchars($user['no_hp'] ?? '') ?>">
        </div>

        <div class="form-field">
          <label>Ganti Foto Profil</label>
          <label class="file-field" for="foto_upload">
            <div class="file-field__icon" aria-hidden="true">
              <i class="ti ti-upload"></i>
            </div>
            <div class="file-field__label">
              <span id="file-label-text">Pilih gambar…</span>
              <small>JPG, PNG, WebP — maks. 2 MB</small>
            </div>
            <input type="file" id="foto_upload" name="foto" accept="image/*"
                   aria-label="Upload foto profil"
                   onchange="document.getElementById('file-label-text').textContent = this.files[0]?.name ?? 'Pilih gambar…'">
          </label>
        </div>

        <button type="submit" class="btn-submit">
          <i class="ti ti-device-floppy"></i>
          Simpan Perubahan
        </button>

      </div>
    </form>
  </div>

  <!-- ── Ganti password ──────────────────── -->
  <div class="profile-card">

    <div class="profile-card__header">
      <div class="profile-card__header-icon" aria-hidden="true">
        <i class="ti ti-lock"></i>
      </div>
      <h2 class="profile-card__title">Ganti Password</h2>
    </div>

    <form method="POST" action="<?= BASE_URL ?>/member/profile/change-password"
          autocomplete="off" style="display:flex; flex-direction:column; flex:1;">
      <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">

      <div class="form-stack">

        <div class="form-field">
          <label for="password_lama">Password Lama</label>
          <input type="password" id="password_lama" name="password_lama"
                 required placeholder="Masukkan password lama">
        </div>

        <div class="form-field">
          <label for="password_baru">Password Baru</label>
          <input type="password" id="password_baru" name="password_baru"
                 required minlength="6" placeholder="Minimal 6 karakter">
        </div>

        <div class="form-field">
          <label for="password_konfirmasi">Konfirmasi Password Baru</label>
          <input type="password" id="password_konfirmasi" name="password_konfirmasi"
                 required placeholder="Ulangi password baru">
        </div>

        <!-- Info box pengisi ruang kosong sekaligus panduan — menjaga tinggi kartu seimbang dengan kartu Edit Data Diri -->
        <div class="alert alert--info" style="margin-top: 2px;">
          <i class="ti ti-info-circle"></i>
          <span>Gunakan kombinasi huruf & angka agar password lebih kuat dan mudah diingat.</span>
        </div>

        <button type="submit" class="btn-submit">
          <i class="ti ti-shield-check"></i>
          Ubah Password
        </button>

      </div>
    </form>
  </div>

</div>