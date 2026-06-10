<?php
// app/views/admin/berita_komentar.php
// Variabel: $items, $page, $pending, $flash, $csrf
?>

<style>
  /* ── Layout ─────────────────────────────────── */
  .km-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    margin-bottom: 2rem;
    flex-wrap: wrap;
  }
  .km-header__title {
    font-size: 1.35rem;
    font-weight: 800;
    color: var(--tx-primary);
    letter-spacing: -.03em;
    margin: 0 0 .25rem;
    line-height: 1.2;
  }
  .km-header__sub {
    font-size: .75rem;
    color: var(--tx-muted);
    margin: 0;
  }
  .km-header__sub strong {
    color: var(--wa);
  }

  /* ── Back button ─────────────────────────────── */
  .km-back {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    padding: 7px 14px;
    border: 1px solid var(--bd-subtle);
    border-radius: var(--r-md);
    font-size: .78rem;
    font-weight: 500;
    color: var(--tx-secondary);
    text-decoration: none;
    background: var(--bg-raised);
    transition: border-color .15s, color .15s;
  }
  .km-back:hover {
    border-color: var(--ac);
    color: var(--ac);
  }

  /* ── Alert ───────────────────────────────────── */
  .km-alert {
    display: flex;
    align-items: center;
    gap: .65rem;
    padding: .75rem 1rem;
    border-radius: var(--r-md);
    font-size: .8rem;
    font-weight: 500;
    margin-bottom: 1.25rem;
    border: 1px solid;
  }
  .km-alert--success { background:var(--ok-dim); color:var(--ok); border-color:var(--ok-bd); }
  .km-alert--error   { background:var(--er-dim); color:var(--er); border-color:var(--er-bd); }
  .km-alert--warning { background:var(--wa-dim); color:var(--wa); border-color:var(--wa-bd); }

  /* ── Filter tabs ─────────────────────────────── */
  .km-tabs {
    display: flex;
    gap: .3rem;
    margin-bottom: 1.25rem;
    flex-wrap: wrap;
  }
  .km-tab {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    padding: 5px 13px;
    border-radius: var(--r-md);
    font-size: .75rem;
    font-weight: 600;
    cursor: pointer;
    border: 1px solid var(--bd-subtle);
    background: var(--bg-raised);
    color: var(--tx-secondary);
    transition: all .15s;
    user-select: none;
  }
  .km-tab:hover { border-color: var(--ac); color: var(--ac); }
  .km-tab.is-active { background: var(--ac); border-color: var(--ac); color: #fff; }
  .km-tab__count {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 18px;
    height: 18px;
    padding: 0 5px;
    border-radius: 99px;
    font-size: .6rem;
    font-weight: 700;
    background: rgba(255,255,255,.25);
    color: inherit;
  }
  .km-tab:not(.is-active) .km-tab__count {
    background: var(--bg-overlay);
    color: var(--tx-muted);
  }

  /* ── Empty state ─────────────────────────────── */
  .km-empty {
    text-align: center;
    padding: 4rem 2rem;
    color: var(--tx-muted);
  }
  .km-empty__icon {
    opacity: .25;
    margin: 0 auto 1rem;
    display: block;
  }
  .km-empty__text {
    font-size: .84rem;
    margin: 0;
  }

  /* ── Comment list ────────────────────────────── */
  .km-list {
    display: flex;
    flex-direction: column;
    gap: .65rem;
  }

  /* ── Comment card ────────────────────────────── */
  .km-card {
    background: var(--bg-surface);
    border: 1px solid var(--bd-faint);
    border-radius: var(--r-lg);
    overflow: hidden;
    transition: box-shadow .15s;
  }
  .km-card:hover {
    box-shadow: 0 2px 12px rgba(0,0,0,.06);
  }
  .km-card--pending  { border-left: 3px solid var(--wa); }
  .km-card--approved { border-left: 3px solid var(--ok); }
  .km-card--rejected { border-left: 3px solid var(--er); opacity: .65; }

  .km-card__body {
    padding: 1rem 1.1rem;
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 1rem;
    flex-wrap: wrap;
  }

  /* ── Comment meta ────────────────────────────── */
  .km-meta {
    flex: 1;
    min-width: 0;
  }
  .km-meta__row {
    display: flex;
    align-items: center;
    gap: .5rem;
    flex-wrap: wrap;
    margin-bottom: .5rem;
  }
  .km-meta__name {
    font-weight: 700;
    font-size: .85rem;
    color: var(--tx-primary);
  }
  .km-meta__email {
    font-family: var(--font-mono);
    font-size: .64rem;
    color: var(--tx-muted);
  }
  .km-meta__time {
    font-family: var(--font-mono);
    font-size: .62rem;
    color: var(--tx-muted);
    margin-left: auto;
  }

  /* Status badge */
  .km-badge {
    display: inline-block;
    font-family: var(--font-mono);
    font-size: .58rem;
    font-weight: 700;
    padding: 2px 8px;
    border-radius: 99px;
    text-transform: uppercase;
    letter-spacing: .04em;
    border: 1px solid;
  }
  .km-badge--pending  { background:var(--wa-dim); color:var(--wa); border-color:var(--wa-bd); }
  .km-badge--approved { background:var(--ok-dim); color:var(--ok); border-color:var(--ok-bd); }
  .km-badge--rejected { background:var(--er-dim); color:var(--er); border-color:var(--er-bd); }

  /* Comment text */
  .km-text {
    font-size: .83rem;
    color: var(--tx-secondary);
    line-height: 1.75;
    margin: 0 0 .6rem;
  }

  /* Article reference */
  .km-article {
    display: inline-flex;
    align-items: center;
    gap: .35rem;
    font-size: .7rem;
    color: var(--tx-muted);
  }
  .km-article a {
    color: var(--ac);
    text-decoration: none;
    font-weight: 500;
  }
  .km-article a:hover { text-decoration: underline; }

  /* ── Action buttons ──────────────────────────── */
  .km-actions {
    display: flex;
    flex-direction: column;
    gap: .3rem;
    flex-shrink: 0;
    align-items: stretch;
    min-width: 80px;
  }
  .km-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: .35rem;
    padding: 5px 12px;
    border-radius: var(--r-sm);
    font-family: var(--font);
    font-size: .73rem;
    font-weight: 600;
    cursor: pointer;
    border: 1px solid;
    transition: opacity .15s, transform .1s;
    white-space: nowrap;
  }
  .km-btn:hover   { opacity: .82; transform: translateY(-1px); }
  .km-btn:active  { transform: translateY(0); }
  .km-btn--approve { background:var(--ok-dim); border-color:var(--ok-bd); color:var(--ok); }
  .km-btn--reject  { background:var(--wa-dim); border-color:var(--wa-bd); color:var(--wa); }
  .km-btn--delete  { background:var(--er-dim); border-color:var(--er-bd); color:var(--er); }

  /* ── Separator ───────────────────────────────── */
  .km-card__footer {
    border-top: 1px solid var(--bd-faint);
    padding: .5rem 1.1rem;
    background: var(--bg-raised);
    display: flex;
    align-items: center;
    gap: .5rem;
    flex-wrap: wrap;
  }
  .km-footer__label {
    font-size: .68rem;
    color: var(--tx-muted);
    margin-right: auto;
  }
</style>

<?php
/* ── Helpers ───────────────────────────────────── */
$alert_icons = [
  'success' => '<svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>',
  'error'   => '<svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>',
  'warning' => '<svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>',
];

$counts = [
  'all'      => count($items),
  'pending'  => count(array_filter($items, fn($k) => $k['status'] === 'pending')),
  'approved' => count(array_filter($items, fn($k) => $k['status'] === 'approved')),
  'rejected' => count(array_filter($items, fn($k) => $k['status'] === 'rejected')),
];
?>

<!-- ── Header ─────────────────────────────────────── -->
<div class="km-header">
  <div>
    <h1 class="km-header__title">Kelola Komentar</h1>
    <p class="km-header__sub">
      <?php if ($pending > 0): ?>
        <strong><?= $pending ?> komentar</strong> menunggu persetujuan
      <?php else: ?>
        Semua komentar sudah ditinjau
      <?php endif; ?>
    </p>
  </div>
  <a href="<?= BASE_URL ?>/admin/berita" class="km-back">
    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
      <polyline points="15 18 9 12 15 6"/>
    </svg>
    Kembali ke Berita
  </a>
</div>

<!-- ── Flash alert ────────────────────────────────── -->
<?php if (!empty($flash)): ?>
<div class="km-alert km-alert--<?= htmlspecialchars($flash['type']) ?>">
  <?= $alert_icons[$flash['type']] ?? '' ?>
  <span><?= htmlspecialchars($flash['msg']) ?></span>
</div>
<?php endif; ?>

<?php if (empty($items)): ?>

<!-- ── Empty state ───────────────────────────────── -->
<div class="km-empty">
  <svg class="km-empty__icon" width="44" height="44" fill="none" stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24">
    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
  </svg>
  <p class="km-empty__text">Belum ada komentar yang perlu ditinjau.</p>
</div>

<?php else: ?>

<!-- ── Filter tabs ────────────────────────────────── -->
<div class="km-tabs" id="km-tabs">
  <button class="km-tab is-active" data-filter="all">
    Semua <span class="km-tab__count"><?= $counts['all'] ?></span>
  </button>
  <button class="km-tab" data-filter="pending">
    Pending <span class="km-tab__count"><?= $counts['pending'] ?></span>
  </button>
  <button class="km-tab" data-filter="approved">
    Disetujui <span class="km-tab__count"><?= $counts['approved'] ?></span>
  </button>
  <button class="km-tab" data-filter="rejected">
    Ditolak <span class="km-tab__count"><?= $counts['rejected'] ?></span>
  </button>
</div>

<!-- ── Comment list ───────────────────────────────── -->
<div class="km-list" id="km-list">
  <?php foreach ($items as $k):
    $st = htmlspecialchars($k['status']);
  ?>
  <div class="km-card km-card--<?= $st ?>" data-status="<?= $st ?>">

    <div class="km-card__body">

      <!-- Meta & text -->
      <div class="km-meta">
        <div class="km-meta__row">
          <span class="km-meta__name"><?= htmlspecialchars($k['nama']) ?></span>
          <span class="km-meta__email"><?= htmlspecialchars($k['email']) ?></span>
          <span class="km-badge km-badge--<?= $st ?>"><?= ucfirst($st) ?></span>
          <span class="km-meta__time"><?= date('d/m/Y H:i', strtotime($k['created_at'])) ?></span>
        </div>

        <p class="km-text"><?= nl2br(htmlspecialchars($k['komentar'])) ?></p>

        <div class="km-article">
          <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
            <polyline points="14 2 14 8 20 8"/>
          </svg>
          Pada artikel:
          <a href="<?= BASE_URL ?>/berita/<?= htmlspecialchars($k['berita_slug']) ?>" target="_blank">
            <?= htmlspecialchars($k['berita_judul']) ?>
          </a>
        </div>
      </div>

      <!-- Actions -->
      <div class="km-actions">
        <?php if ($k['status'] !== 'approved'): ?>
        <form method="POST" action="<?= BASE_URL ?>/admin/berita/komentar/<?= (int)$k['id'] ?>/approve">
          <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
          <button type="submit" class="km-btn km-btn--approve">
            <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
            Setujui
          </button>
        </form>
        <?php endif; ?>

        <?php if ($k['status'] !== 'rejected'): ?>
        <form method="POST" action="<?= BASE_URL ?>/admin/berita/komentar/<?= (int)$k['id'] ?>/reject">
          <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
          <button type="submit" class="km-btn km-btn--reject">
            <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            Tolak
          </button>
        </form>
        <?php endif; ?>

        <form method="POST" action="<?= BASE_URL ?>/admin/berita/komentar/<?= (int)$k['id'] ?>/delete"
              onsubmit="return confirm('Hapus komentar ini secara permanen?')">
          <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
          <button type="submit" class="km-btn km-btn--delete">
            <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>
            Hapus
          </button>
        </form>
      </div>

    </div><!-- /.km-card__body -->
  </div><!-- /.km-card -->
  <?php endforeach; ?>
</div><!-- /.km-list -->

<!-- ── Filter script ──────────────────────────────── -->
<script>
(function () {
  const tabs  = document.querySelectorAll('#km-tabs .km-tab');
  const cards = document.querySelectorAll('#km-list .km-card');

  tabs.forEach(tab => {
    tab.addEventListener('click', () => {
      const filter = tab.dataset.filter;

      tabs.forEach(t => t.classList.remove('is-active'));
      tab.classList.add('is-active');

      cards.forEach(card => {
        const show = filter === 'all' || card.dataset.status === filter;
        card.style.display = show ? '' : 'none';
      });
    });
  });
})();
</script>

<?php endif; ?>