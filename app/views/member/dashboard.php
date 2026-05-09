<?php // app/views/member/dashboard.php ?>

<style>
  /* ─── Page heading ─── */
  .dash-heading {
    font-size    : 20px;
    font-weight  : 650;
    color        : var(--color-text-1);
    letter-spacing: -0.4px;
    margin-bottom: 20px;
    line-height  : 1.3;
  }
  .dash-heading span { color: var(--color-text-2); font-weight: 400; }

  /* ─── NIA Card ─── */
  .nia-card {
    position     : relative;
    background   : var(--color-surface-2);
    border       : 1px solid var(--color-border-2);
    border-radius: var(--radius-lg);
    padding      : 22px 24px;
    margin-bottom: 20px;
    overflow     : hidden;
  }
  .nia-card::before {
    content      : '';
    position     : absolute;
    inset        : 0;
    background   : linear-gradient(135deg, rgba(99,102,241,0.08) 0%, transparent 60%);
    pointer-events: none;
  }
  .nia-card__accent {
    position     : absolute;
    right        : 20px;
    top          : 50%;
    transform    : translateY(-50%);
    width        : 80px;
    height       : 80px;
    border-radius: 50%;
    background   : var(--color-accent);
    opacity      : 0.06;
    pointer-events: none;
  }
  .nia-card__label {
    font-size  : 11.5px;
    font-weight: 500;
    color      : var(--color-text-3);
    letter-spacing: 0.04em;
    text-transform: uppercase;
    margin-bottom: 6px;
  }
  .nia-card__number {
    font-size    : 28px;
    font-weight  : 700;
    color        : var(--color-text-1);
    letter-spacing: 0.12em;
    font-variant-numeric: tabular-nums;
    font-family  : 'Geist Mono', 'Courier New', monospace;
    margin-bottom: 10px;
    line-height  : 1.1;
  }
  .nia-card__org {
    display    : inline-flex;
    align-items: center;
    gap        : 6px;
    font-size  : 12px;
    font-weight: 500;
    color      : var(--color-accent);
    background : var(--color-accent-dim);
    border     : 1px solid var(--color-accent-border);
    border-radius: var(--radius-xs);
    padding    : 3px 9px;
  }

  /* ─── Info grid ─── */
  .info-grid {
    display              : grid;
    grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
    gap                  : 10px;
    margin-bottom        : 24px;
  }

  .info-card {
    background   : var(--color-surface-2);
    border       : 1px solid var(--color-border);
    border-radius: var(--radius-md);
    padding      : 14px 16px;
  }
  .info-card__label {
    font-size    : 11px;
    font-weight  : 500;
    color        : var(--color-text-3);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 5px;
  }
  .info-card__value {
    font-size  : 14px;
    font-weight: 600;
    color      : var(--color-text-1);
    line-height: 1.3;
  }

  .badge-aktif {
    display      : inline-flex;
    align-items  : center;
    gap          : 5px;
    font-size    : 12px;
    font-weight  : 600;
    color        : var(--color-success);
    background   : var(--color-success-dim);
    border       : 1px solid var(--color-success-border);
    border-radius: var(--radius-xs);
    padding      : 3px 9px;
  }
  .badge-aktif__dot {
    width        : 5px;
    height       : 5px;
    border-radius: 50%;
    background   : var(--color-success);
    flex-shrink  : 0;
  }

  /* ─── Section label ─── */
  .section-label {
    font-size    : 11.5px;
    font-weight  : 600;
    color        : var(--color-text-3);
    text-transform: uppercase;
    letter-spacing: 0.06em;
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
    background   : var(--color-surface-2);
    border       : 1px solid var(--color-border);
    border-radius: var(--radius-md);
    padding      : 16px 18px;
    text-decoration: none;
    transition   : background 150ms ease, border-color 150ms ease;
  }
  .action-card:hover {
    background  : var(--color-surface-3);
    border-color: var(--color-border-2);
  }

  .action-card__icon-wrap {
    width          : 36px;
    height         : 36px;
    border-radius  : var(--radius-sm);
    background     : var(--color-accent-dim);
    border         : 1px solid var(--color-accent-border);
    display        : flex;
    align-items    : center;
    justify-content: center;
    flex-shrink    : 0;
    color          : var(--color-accent);
  }
  .action-card__icon-wrap svg { width: 17px; height: 17px; }

  .action-card__body { min-width: 0; }

  .action-card__title {
    font-size    : 14px;
    font-weight  : 600;
    color        : var(--color-text-1);
    margin-bottom: 3px;
    line-height  : 1.3;
  }

  .action-card__desc {
    font-size  : 12.5px;
    color      : var(--color-text-3);
    line-height: 1.4;
  }

  .action-card__arrow {
    width      : 14px;
    height     : 14px;
    color      : var(--color-text-3);
    flex-shrink: 0;
    margin-left: auto;
    align-self : center;
    transition : color 150ms, transform 150ms;
  }
  .action-card:hover .action-card__arrow {
    color    : var(--color-text-2);
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
    <svg width="11" height="11" xmlns="http://www.w3.org/2000/svg" fill="none"
         viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
      <path stroke-linecap="round" stroke-linejoin="round"
            d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/>
    </svg>
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
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
           stroke-width="1.75" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/>
      </svg>
    </div>
    <div class="action-card__body">
      <p class="action-card__title">Surat Pernyataan</p>
      <p class="action-card__desc">Download & cetak surat pernyataan anggota</p>
    </div>
    <svg class="action-card__arrow" xmlns="http://www.w3.org/2000/svg" fill="none"
         viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
      <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
    </svg>
  </a>

  <a href="<?= BASE_URL ?>/member/profile" class="action-card">
    <div class="action-card__icon-wrap" aria-hidden="true">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
           stroke-width="1.75" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
      </svg>
    </div>
    <div class="action-card__body">
      <p class="action-card__title">Profil Saya</p>
      <p class="action-card__desc">Perbarui data diri & ganti password</p>
    </div>
    <svg class="action-card__arrow" xmlns="http://www.w3.org/2000/svg" fill="none"
         viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
      <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
    </svg>
  </a>

</div>