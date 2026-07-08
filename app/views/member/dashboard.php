<?php // app/views/member/dashboard.php ?>

<style>
  /* ─── Page heading ─── */
  .dash-heading {
    font-size    : 21px;
    font-weight  : 800;
    color        : var(--c-primary-dk);
    letter-spacing: -0.4px;
    margin-bottom: 20px;
    line-height  : 1.3;
  }
  .dash-heading span { color: var(--c-muted); font-weight: 500; }

  /* ─── NIA Card ─── */
  .nia-card {
    position     : relative;
    background   : var(--c-white);
    border       : 1px solid var(--c-border);
    border-radius: var(--radius-lg);
    padding      : 22px 24px;
    margin-bottom: 20px;
    overflow     : hidden;
    box-shadow   : 0 20px 46px -18px rgba(15,23,42,.16), 0 3px 12px rgba(15,23,42,.05);
  }
  .nia-card::before {
    content      : '';
    position     : absolute;
    inset        : 0;
    background   : linear-gradient(135deg, rgba(14,116,144,0.06) 0%, transparent 60%);
    pointer-events: none;
  }
  .nia-card__accent {
    position     : absolute;
    right        : 20px;
    top          : 50%;
    transform    : translateY(-50%);
    width        : 90px;
    height       : 90px;
    border-radius: 50%;
    background   : var(--c-primary);
    opacity      : 0.06;
    pointer-events: none;
  }
  .nia-card__label {
    font-size  : 11.5px;
    font-weight: 700;
    color      : var(--c-muted2);
    letter-spacing: 0.06em;
    text-transform: uppercase;
    margin-bottom: 6px;
  }
  .nia-card__number {
    font-size    : 28px;
    font-weight  : 800;
    color        : var(--c-ink);
    letter-spacing: 0.10em;
    font-variant-numeric: tabular-nums;
    font-family  : 'Courier New', monospace;
    margin-bottom: 10px;
    line-height  : 1.1;
  }
  .nia-card__org {
    display    : inline-flex;
    align-items: center;
    gap        : 6px;
    font-size  : 12px;
    font-weight: 700;
    color      : var(--c-primary);
    background : rgba(14,116,144,.08);
    border     : 1px solid rgba(14,116,144,.22);
    border-radius: var(--radius-sm);
    padding    : 3px 10px;
  }
  .nia-card__org i { font-size: 13px; }

  /* ─── Info grid ─── */
  .info-grid {
    display              : grid;
    grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
    gap                  : 10px;
    margin-bottom        : 24px;
  }

  .info-card {
    background   : var(--c-white);
    border       : 1px solid var(--c-border);
    border-radius: var(--radius-md);
    padding      : 14px 16px;
  }
  .info-card__label {
    font-size    : 11px;
    font-weight  : 700;
    color        : var(--c-muted2);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 5px;
  }
  .info-card__value {
    font-size  : 14px;
    font-weight: 700;
    color      : var(--c-ink);
    line-height: 1.3;
  }

  .badge-aktif {
    display      : inline-flex;
    align-items  : center;
    gap          : 5px;
    font-size    : 12px;
    font-weight  : 700;
    color        : var(--c-green-text);
    background   : var(--c-green-bg);
    border       : 1px solid var(--c-green-border);
    border-radius: var(--radius-sm);
    padding      : 3px 9px;
  }
  .badge-aktif__dot {
    width        : 5px;
    height       : 5px;
    border-radius: 50%;
    background   : var(--c-green-text);
    flex-shrink  : 0;
  }

  /* ─── Section label ─── */
  .section-label {
    font-size    : 11.5px;
    font-weight  : 700;
    color        : var(--c-muted2);
    text-transform: uppercase;
    letter-spacing: 0.07em;
    margin-bottom: 10px;
  }

  /* ─── Action cards ─── */
  .action-grid {
    display              : grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap                  : 10px;
  }

  .action-card {
    display      : flex;
    align-items  : flex-start;
    gap          : 14px;
    background   : var(--c-white);
    border       : 1px solid var(--c-border);
    border-radius: var(--radius-md);
    padding      : 16px 18px;
    text-decoration: none;
    transition   : border-color 150ms ease, transform 150ms ease, box-shadow 150ms ease;
  }
  .action-card:hover {
    border-color: rgba(14,116,144,.3);
    transform   : translateY(-2px);
    box-shadow  : 0 12px 26px rgba(15,23,42,.08);
  }

  .action-card__icon-wrap {
    width          : 36px;
    height         : 36px;
    border-radius  : var(--radius-sm);
    background     : rgba(14,116,144,.08);
    border         : 1px solid rgba(14,116,144,.22);
    display        : flex;
    align-items    : center;
    justify-content: center;
    flex-shrink    : 0;
    color          : var(--c-primary);
    font-size      : 17px;
  }

  .action-card__body { min-width: 0; }

  .action-card__title {
    font-size    : 14px;
    font-weight  : 700;
    color        : var(--c-ink);
    margin-bottom: 3px;
    line-height  : 1.3;
  }

  .action-card__desc {
    font-size  : 12.5px;
    color      : var(--c-muted);
    line-height: 1.4;
  }

  .action-card__arrow {
    font-size  : 15px;
    color      : var(--c-muted2);
    flex-shrink: 0;
    margin-left: auto;
    align-self : center;
    transition : color 150ms, transform 150ms;
  }
  .action-card:hover .action-card__arrow {
    color    : var(--c-primary);
    transform: translateX(2px);
  }
</style>

<!-- Greeting -->
<p class="dash-heading">
  Selamat datang,
  <span><?= htmlspecialchars($user['nama_lengkap']) ?></span>
</p>

<!-- NIA Card -->
<div class="nia-card">
  <div class="nia-card__accent" aria-hidden="true"></div>
  <p class="nia-card__label">Nomor Induk Anggota</p>
  <p class="nia-card__number"><?= htmlspecialchars($user['nia'] ?? '—') ?></p>
  <span class="nia-card__org">
    <i class="ti ti-building" aria-hidden="true"></i>
    <?= htmlspecialchars($settings['org_name']['value'] ?? APP_NAME) ?>
  </span>
</div>

<!-- Info cards -->
<div class="info-grid">
  <div class="info-card">
    <p class="info-card__label">Nama Lengkap</p>
    <p class="info-card__value"><?= htmlspecialchars($user['nama_lengkap']) ?></p>
  </div>
  <div class="info-card">
    <p class="info-card__label">Kelas</p>
    <p class="info-card__value"><?= htmlspecialchars($user['kelas'] ?? '—') ?></p>
  </div>
  <div class="info-card">
    <p class="info-card__label">Status</p>
    <span class="badge-aktif">
      <span class="badge-aktif__dot" aria-hidden="true"></span>
      Aktif
    </span>
  </div>
</div>

<!-- Quick actions -->
<p class="section-label">Menu Cepat</p>
<div class="action-grid">

  <a href="<?= BASE_URL ?>/member/surat-pernyataan" class="action-card">
    <div class="action-card__icon-wrap" aria-hidden="true">
      <i class="ti ti-file-text"></i>
    </div>
    <div class="action-card__body">
      <p class="action-card__title">Surat Pernyataan</p>
      <p class="action-card__desc">Download & cetak surat pernyataan anggota</p>
    </div>
    <i class="ti ti-chevron-right action-card__arrow" aria-hidden="true"></i>
  </a>

  <a href="<?= BASE_URL ?>/member/profile" class="action-card">
    <div class="action-card__icon-wrap" aria-hidden="true">
      <i class="ti ti-user-circle"></i>
    </div>
    <div class="action-card__body">
      <p class="action-card__title">Profil Saya</p>
      <p class="action-card__desc">Perbarui data diri & ganti password</p>
    </div>
    <i class="ti ti-chevron-right action-card__arrow" aria-hidden="true"></i>
  </a>

</div>