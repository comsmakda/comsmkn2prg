<?php // app/views/member/profile.php ?>

<style>
  /* ─── Page heading ─── */
  .page-title {
    font-size    : 20px;
    font-weight  : 650;
    color        : var(--color-text-1);
    letter-spacing: -0.4px;
    margin-bottom: 20px;
    line-height  : 1.3;
  }

  /* ─── Two-column grid ─── */
  .profile-grid {
    display              : grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap                  : 14px;
    max-width            : 840px;
  }

  /* ─── Card ─── */
  .profile-card {
    background   : var(--color-surface-2);
    border       : 1px solid var(--color-border);
    border-radius: var(--radius-lg);
    padding      : 20px 22px;
  }

  .profile-card__header {
    display      : flex;
    align-items  : center;
    gap          : 8px;
    margin-bottom: 18px;
    padding-bottom: 14px;
    border-bottom: 1px solid var(--color-border);
  }

  .profile-card__header-icon {
    width          : 28px;
    height         : 28px;
    border-radius  : var(--radius-sm);
    background     : var(--color-accent-dim);
    border         : 1px solid var(--color-accent-border);
    display        : flex;
    align-items    : center;
    justify-content: center;
    color          : var(--color-accent);
    flex-shrink    : 0;
  }
  .profile-card__header-icon svg { width: 14px; height: 14px; }

  .profile-card__title {
    font-size  : 14px;
    font-weight: 600;
    color      : var(--color-text-1);
  }

  /* ─── User identity row ─── */
  .user-identity {
    display      : flex;
    align-items  : center;
    gap          : 12px;
    margin-bottom: 18px;
    padding      : 12px 14px;
    background   : var(--color-surface);
    border       : 1px solid var(--color-border);
    border-radius: var(--radius-md);
  }

  .user-identity__avatar {
    width          : 42px;
    height         : 42px;
    border-radius  : 50%;
    object-fit     : cover;
    border         : 2px solid var(--color-accent-border);
    flex-shrink    : 0;
  }

  .user-identity__avatar-fallback {
    width          : 42px;
    height         : 42px;
    border-radius  : 50%;
    background     : var(--color-accent-dim);
    border         : 2px solid var(--color-accent-border);
    display        : flex;
    align-items    : center;
    justify-content: center;
    font-size      : 16px;
    font-weight    : 700;
    color          : var(--color-accent);
    flex-shrink    : 0;
    text-transform : uppercase;
  }

  .user-identity__info { min-width: 0; }

  .user-identity__name {
    font-size    : 14px;
    font-weight  : 600;
    color        : var(--color-text-1);
    white-space  : nowrap;
    overflow     : hidden;
    text-overflow: ellipsis;
    line-height  : 1.3;
  }

  .user-identity__nia {
    font-size    : 11.5px;
    font-weight  : 500;
    color        : var(--color-accent);
    font-variant-numeric: tabular-nums;
    letter-spacing: 0.04em;
    line-height  : 1.3;
  }

  /* ─── Form ─── */
  .form-stack { display: flex; flex-direction: column; gap: 14px; }

  .form-field { display: flex; flex-direction: column; gap: 5px; }

  .form-field label {
    font-size    : 12px;
    font-weight  : 550;
    color        : var(--color-text-2);
    letter-spacing: 0.01em;
  }

  .form-field input[type="text"],
  .form-field input[type="tel"],
  .form-field input[type="password"] {
    width        : 100%;
    height       : 36px;
    padding      : 0 11px;
    background   : var(--color-surface);
    border       : 1px solid var(--color-border-2);
    border-radius: var(--radius-sm);
    color        : var(--color-text-1);
    font-family  : inherit;
    font-size    : 13.5px;
    outline      : none;
    transition   : border-color 150ms ease, box-shadow 150ms ease;
  }

  .form-field input:hover {
    border-color: rgba(255,255,255,0.18);
  }

  .form-field input:focus {
    border-color: var(--color-accent-border);
    box-shadow  : 0 0 0 3px var(--color-accent-dim);
  }

  .form-field input::placeholder { color: var(--color-text-3); }

  /* File input */
  .file-field {
    display      : flex;
    align-items  : center;
    gap          : 10px;
    padding      : 9px 12px;
    background   : var(--color-surface);
    border       : 1px dashed var(--color-border-2);
    border-radius: var(--radius-sm);
    cursor       : pointer;
    transition   : border-color 150ms, background 150ms;
  }
  .file-field:hover {
    border-color: var(--color-accent-border);
    background  : var(--color-accent-dim);
  }

  .file-field__icon {
    width          : 28px;
    height         : 28px;
    border-radius  : var(--radius-xs);
    background     : var(--color-surface-2);
    border         : 1px solid var(--color-border);
    display        : flex;
    align-items    : center;
    justify-content: center;
    color          : var(--color-text-2);
    flex-shrink    : 0;
  }
  .file-field__icon svg { width: 13px; height: 13px; }

  .file-field__label {
    flex      : 1;
    min-width : 0;
  }
  .file-field__label span {
    display  : block;
    font-size: 12.5px;
    font-weight: 500;
    color    : var(--color-text-2);
  }
  .file-field__label small {
    font-size: 11px;
    color    : var(--color-text-3);
  }

  .file-field input[type="file"] {
    position: absolute;
    opacity : 0;
    width   : 0;
    height  : 0;
  }

  /* Submit button */
  .btn-submit {
    display        : flex;
    align-items    : center;
    justify-content: center;
    gap            : 7px;
    width          : 100%;
    height         : 36px;
    border-radius  : var(--radius-sm);
    background     : var(--color-accent);
    border         : none;
    color          : #fff;
    font-family    : inherit;
    font-size      : 13.5px;
    font-weight    : 600;
    cursor         : pointer;
    transition     : opacity 150ms, transform 100ms;
    margin-top     : 4px;
  }
  .btn-submit:hover   { opacity: 0.88; }
  .btn-submit:active  { transform: scale(0.98); }
  .btn-submit svg     { width: 14px; height: 14px; }

  /* ─── Flash inside page (if needed) ─── */
  .flash-local { margin-bottom: 16px; max-width: 840px; }
</style>

<p class="page-title">Profil Saya</p>

<?php if (!empty($flash)): ?>
  <?php
    $type = $flash['type'] ?? 'info';
    $safeType = in_array($type, ['success','danger','error','warning','info']) ? $type : 'info';
    function inlineAlertIcon(string $t): string {
      return match($t) {
        'success'        => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true" style="width:15px;height:15px;flex-shrink:0"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>',
        'danger','error' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true" style="width:15px;height:15px;flex-shrink:0"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z"/></svg>',
        default          => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true" style="width:15px;height:15px;flex-shrink:0"><path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z"/></svg>',
      };
    }
  ?>
  <div class="flash-local">
    <div class="alert alert--<?= $safeType ?>" role="alert">
      <?= inlineAlertIcon($type) ?>
      <span><?= htmlspecialchars($flash['msg'] ?? '') ?></span>
    </div>
  </div>
<?php endif; ?>

<div class="profile-grid">

  <!-- ── Edit profil ─────────────────────── -->
  <div class="profile-card">

    <div class="profile-card__header">
      <div class="profile-card__header-icon" aria-hidden="true">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
             stroke-width="1.75" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round"
                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125"/>
        </svg>
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
          enctype="multipart/form-data" autocomplete="off">
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
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                   stroke-width="1.75" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5"/>
              </svg>
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
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
               stroke-width="2" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z"/>
          </svg>
          Simpan Perubahan
        </button>

      </div>
    </form>
  </div>

  <!-- ── Ganti password ──────────────────── -->
  <div class="profile-card">

    <div class="profile-card__header">
      <div class="profile-card__header-icon" aria-hidden="true">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
             stroke-width="1.75" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round"
                d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/>
        </svg>
      </div>
      <h2 class="profile-card__title">Ganti Password</h2>
    </div>

    <form method="POST" action="<?= BASE_URL ?>/member/profile/change-password"
          autocomplete="off">
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

        <button type="submit" class="btn-submit">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
               stroke-width="2" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z"/>
          </svg>
          Ubah Password
        </button>

      </div>
    </form>
  </div>

</div>