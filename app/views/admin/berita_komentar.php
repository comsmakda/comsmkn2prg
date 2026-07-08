<?php
// app/views/admin/berita_komentar.php
// Variabel: $items, $page, $pending, $flash, $csrf
?>

<style>
/* ═══════════════════════════════════════
   SCOPE ROOT — alias ke Design System
   (token asli didefinisikan global di layout;
    fallback disertakan bila file ini dirender berdiri sendiri)
═══════════════════════════════════════ */
.km-root {
  --tx-primary:   var(--c-ink,    #0f172a);
  --tx-secondary: var(--c-muted,  #64748b);
  --tx-muted:     var(--c-muted2, #94a3b8);

  --bg-surface:  var(--c-white, #ffffff);
  --bg-raised:   #f4f7fa;
  --bg-overlay:  #eef2f6;

  --bd-subtle: var(--c-border, #e6ebf1);
  --bd-faint:  var(--c-border, #e6ebf1);

  --ac: var(--c-primary, #0e7490);
  --ac-dk: var(--c-primary-dk, #0b5a70);
  --ac-lo: var(--c-primary-08, rgba(14,116,144,.08));

  --ok:     var(--c-green-text,   #15803d);
  --ok-dim: var(--c-green-bg,     #f0fdf4);
  --ok-bd:  var(--c-green-border, #bbf7d0);

  --wa:     var(--c-amber-text,   #8a5a06);
  --wa-dim: var(--c-amber-bg,     #fef6e2);
  --wa-bd:  var(--c-amber-border, #fbe3a8);

  --er:     var(--c-red-text,   #b91c1c);
  --er-dim: var(--c-red-bg,     #fef2f2);
  --er-bd:  var(--c-red-border, #fecaca);

  --r-sm: var(--radius-sm, 9px);
  --r-md: var(--radius-sm, 9px);
  --r-lg: var(--radius-lg, 22px);

  --font:      var(--font-ui, 'Plus Jakarta Sans', sans-serif);
  --font-mono: ui-monospace, 'SFMono-Regular', Menlo, Consolas, monospace;

  --ease: cubic-bezier(0.22, 1, 0.36, 1);
}

.km-root * { box-sizing: border-box; }
.km-root {
  font-family: var(--font);
  color: var(--tx-primary);
  -webkit-font-smoothing: antialiased;
}
.km-root .km-wrap { max-width: 900px; }

/* ── Header ─────────────────────────────────── */
.km-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 1rem;
  margin-bottom: 1.5rem;
  flex-wrap: wrap;
}
.km-header__eyebrow {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  font-size: 11px;
  font-weight: 700;
  letter-spacing: .1em;
  text-transform: uppercase;
  color: var(--ac);
  margin-bottom: 8px;
}
.km-header__eyebrow-dot {
  width: 6px; height: 6px;
  border-radius: 50%;
  background: var(--ac);
  box-shadow: 0 0 6px var(--ac);
}
.km-header__title {
  font-size: 1.4rem;
  font-weight: 800;
  color: var(--ac-dk);
  letter-spacing: -.03em;
  margin: 0;
  line-height: 1.2;
}
.km-header__sub {
  font-size: .78rem;
  color: var(--tx-secondary);
  margin: 6px 0 0;
}
.km-header__sub strong {
  color: var(--wa);
  font-weight: 700;
}

/* ── Back button ──────────────────────────────── */
.km-back {
  display: inline-flex;
  align-items: center;
  gap: .4rem;
  padding: 9px 15px;
  border: 1.5px solid var(--bd-subtle);
  border-radius: var(--r-md);
  font-size: .78rem;
  font-weight: 700;
  color: var(--tx-primary);
  text-decoration: none;
  background: #fff;
  transition: border-color .15s var(--ease), color .15s var(--ease), background .15s var(--ease);
}
.km-back:hover {
  border-color: var(--ac);
  color: var(--ac);
  background: var(--ac-lo);
}
.km-back i { font-size: 15px; }

/* ── Stat row (ringkasan) ─────────────────────── */
.km-stats {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 10px;
  margin-bottom: 1.25rem;
}
@media (max-width: 700px) { .km-stats { grid-template-columns: repeat(2, 1fr); } }
.km-stat {
  background: var(--bg-surface);
  border: 1px solid var(--bd-subtle);
  border-radius: var(--r-lg);
  padding: 14px 16px;
  display: flex;
  align-items: center;
  gap: 11px;
}
.km-stat__icon {
  width: 34px; height: 34px;
  border-radius: var(--r-sm);
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}
.km-stat__icon i { font-size: 16px; }
.km-stat--all      .km-stat__icon { background: var(--ac-lo);  color: var(--ac); }
.km-stat--pending  .km-stat__icon { background: var(--wa-dim); color: var(--wa); }
.km-stat--approved .km-stat__icon { background: var(--ok-dim); color: var(--ok); }
.km-stat--rejected .km-stat__icon { background: var(--er-dim); color: var(--er); }
.km-stat__val {
  font-size: 17px;
  font-weight: 800;
  color: var(--tx-primary);
  line-height: 1.1;
  font-variant-numeric: tabular-nums;
}
.km-stat__lbl {
  font-size: 10.5px;
  color: var(--tx-muted);
  font-weight: 600;
  margin-top: 2px;
}

/* ── Alert ────────────────────────────────────── */
.km-alert {
  display: flex;
  align-items: center;
  gap: .65rem;
  padding: .75rem 1rem;
  border-radius: var(--r-lg);
  font-size: .8rem;
  font-weight: 500;
  margin-bottom: 1.25rem;
  border: 1px solid;
}
.km-alert i { font-size: 16px; flex-shrink: 0; }
.km-alert--success { background:var(--ok-dim); color:var(--ok); border-color:var(--ok-bd); }
.km-alert--error   { background:var(--er-dim); color:var(--er); border-color:var(--er-bd); }
.km-alert--warning { background:var(--wa-dim); color:var(--wa); border-color:var(--wa-bd); }

/* ── Filter tabs ──────────────────────────────── */
.km-tabs {
  display: flex;
  gap: .35rem;
  margin-bottom: 1.1rem;
  flex-wrap: wrap;
}
.km-tab {
  display: inline-flex;
  align-items: center;
  gap: .4rem;
  padding: 6px 14px;
  border-radius: var(--r-md);
  font-size: .76rem;
  font-weight: 700;
  cursor: pointer;
  border: 1.5px solid var(--bd-subtle);
  background: #fff;
  color: var(--tx-secondary);
  transition: all .15s var(--ease);
  user-select: none;
  font-family: var(--font);
}
.km-tab:hover { border-color: var(--ac); color: var(--ac); }
.km-tab.is-active {
  background: var(--ac);
  border-color: var(--ac);
  color: #fff;
  box-shadow: 0 6px 16px rgba(14,116,144,.22);
}
.km-tab__count {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  min-width: 18px;
  height: 18px;
  padding: 0 5px;
  border-radius: 99px;
  font-size: .62rem;
  font-weight: 700;
  background: rgba(255,255,255,.25);
  color: inherit;
}
.km-tab:not(.is-active) .km-tab__count {
  background: var(--bg-overlay);
  color: var(--tx-muted);
}

/* ── Empty state ──────────────────────────────── */
.km-empty {
  text-align: center;
  padding: 4rem 2rem;
  color: var(--tx-muted);
  background: var(--bg-surface);
  border: 1px solid var(--bd-subtle);
  border-radius: var(--r-lg);
}
.km-empty__icon {
  width: 56px; height: 56px;
  border-radius: 50%;
  background: var(--bg-overlay);
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 1rem;
  color: var(--tx-muted);
}
.km-empty__icon i { font-size: 26px; }
.km-empty__text {
  font-size: .84rem;
  margin: 0;
  font-weight: 500;
}

/* ── Comment list ─────────────────────────────── */
.km-list {
  display: flex;
  flex-direction: column;
  gap: .65rem;
}

/* ── Comment card ─────────────────────────────── */
.km-card {
  background: var(--bg-surface);
  border: 1px solid var(--bd-faint);
  border-radius: var(--r-lg);
  overflow: hidden;
  transition: box-shadow .15s var(--ease);
}
.km-card:hover {
  box-shadow: 0 8px 24px rgba(15,23,42,.07);
}
.km-card--pending  { border-left: 3px solid var(--wa); }
.km-card--approved { border-left: 3px solid var(--ok); }
.km-card--rejected { border-left: 3px solid var(--er); opacity: .68; }

.km-card__body {
  padding: 1rem 1.15rem;
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  gap: 1rem;
  flex-wrap: wrap;
}

/* ── Comment meta ─────────────────────────────── */
.km-meta { flex: 1; min-width: 0; }
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
  font-size: .66rem;
  color: var(--tx-muted);
}
.km-meta__time {
  font-family: var(--font-mono);
  font-size: .64rem;
  color: var(--tx-muted);
  margin-left: auto;
}

/* Status badge */
.km-badge {
  display: inline-block;
  font-family: var(--font-mono);
  font-size: .6rem;
  font-weight: 700;
  padding: 2px 9px;
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
  gap: .4rem;
  font-size: .72rem;
  color: var(--tx-muted);
}
.km-article i { font-size: 13px; }
.km-article a {
  color: var(--ac);
  text-decoration: none;
  font-weight: 700;
}
.km-article a:hover { text-decoration: underline; }

/* ── Action buttons ───────────────────────────── */
.km-actions {
  display: flex;
  flex-direction: column;
  gap: .35rem;
  flex-shrink: 0;
  align-items: stretch;
  min-width: 92px;
}
.km-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: .4rem;
  padding: 7px 12px;
  border-radius: var(--r-sm);
  font-family: var(--font);
  font-size: .74rem;
  font-weight: 700;
  cursor: pointer;
  border: 1.5px solid;
  transition: opacity .15s var(--ease), transform .1s var(--ease);
  white-space: nowrap;
  width: 100%;
}
.km-btn i { font-size: 13px; }
.km-btn:hover   { opacity: .82; transform: translateY(-1px); }
.km-btn:active  { transform: translateY(0); }
.km-btn--approve { background:var(--ok-dim); border-color:var(--ok-bd); color:var(--ok); }
.km-btn--reject  { background:var(--wa-dim); border-color:var(--wa-bd); color:var(--wa); }
.km-btn--delete  { background:var(--er-dim); border-color:var(--er-bd); color:var(--er); }
</style>

<?php
/* ── Helpers ───────────────────────────────────── */
$alert_icons = [
  'success' => 'ti-circle-check',
  'error'   => 'ti-alert-circle',
  'warning' => 'ti-alert-triangle',
];

$counts = [
  'all'      => count($items),
  'pending'  => count(array_filter($items, fn($k) => $k['status'] === 'pending')),
  'approved' => count(array_filter($items, fn($k) => $k['status'] === 'approved')),
  'rejected' => count(array_filter($items, fn($k) => $k['status'] === 'rejected')),
];
?>

<div class="km-root">
<div class="km-wrap">

  <!-- ── Header ──────────────────────────────────── -->
  <div class="km-header">
    <div>
      <div class="km-header__eyebrow">
        <span class="km-header__eyebrow-dot"></span>
        Moderasi
      </div>
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
      <i class="ti ti-arrow-left" aria-hidden="true"></i>
      Kembali ke Berita
    </a>
  </div>

  <!-- ── Ringkasan statistik ─────────────────────── -->
  <?php if (!empty($items)): ?>
  <div class="km-stats">
    <div class="km-stat km-stat--all">
      <div class="km-stat__icon"><i class="ti ti-messages" aria-hidden="true"></i></div>
      <div>
        <div class="km-stat__val"><?= $counts['all'] ?></div>
        <div class="km-stat__lbl">Total Komentar</div>
      </div>
    </div>
    <div class="km-stat km-stat--pending">
      <div class="km-stat__icon"><i class="ti ti-clock" aria-hidden="true"></i></div>
      <div>
        <div class="km-stat__val"><?= $counts['pending'] ?></div>
        <div class="km-stat__lbl">Menunggu</div>
      </div>
    </div>
    <div class="km-stat km-stat--approved">
      <div class="km-stat__icon"><i class="ti ti-circle-check" aria-hidden="true"></i></div>
      <div>
        <div class="km-stat__val"><?= $counts['approved'] ?></div>
        <div class="km-stat__lbl">Disetujui</div>
      </div>
    </div>
    <div class="km-stat km-stat--rejected">
      <div class="km-stat__icon"><i class="ti ti-circle-x" aria-hidden="true"></i></div>
      <div>
        <div class="km-stat__val"><?= $counts['rejected'] ?></div>
        <div class="km-stat__lbl">Ditolak</div>
      </div>
    </div>
  </div>
  <?php endif; ?>

  <!-- ── Flash alert ─────────────────────────────── -->
  <?php if (!empty($flash)): ?>
  <div class="km-alert km-alert--<?= htmlspecialchars($flash['type']) ?>">
    <i class="ti <?= $alert_icons[$flash['type']] ?? 'ti-info-circle' ?>" aria-hidden="true"></i>
    <span><?= htmlspecialchars($flash['msg']) ?></span>
  </div>
  <?php endif; ?>

  <?php if (empty($items)): ?>

  <!-- ── Empty state ───────────────────────────────── -->
  <div class="km-empty">
    <div class="km-empty__icon">
      <i class="ti ti-message-off" aria-hidden="true"></i>
    </div>
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
            <i class="ti ti-file-text" aria-hidden="true"></i>
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
              <i class="ti ti-check" aria-hidden="true"></i>
              Setujui
            </button>
          </form>
          <?php endif; ?>

          <?php if ($k['status'] !== 'rejected'): ?>
          <form method="POST" action="<?= BASE_URL ?>/admin/berita/komentar/<?= (int)$k['id'] ?>/reject">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
            <button type="submit" class="km-btn km-btn--reject">
              <i class="ti ti-x" aria-hidden="true"></i>
              Tolak
            </button>
          </form>
          <?php endif; ?>

          <form method="POST" action="<?= BASE_URL ?>/admin/berita/komentar/<?= (int)$k['id'] ?>/delete"
                onsubmit="return confirm('Hapus komentar ini secara permanen?')">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
            <button type="submit" class="km-btn km-btn--delete">
              <i class="ti ti-trash" aria-hidden="true"></i>
              Hapus
            </button>
          </form>
        </div>

      </div><!-- /.km-card__body -->
    </div><!-- /.km-card -->
    <?php endforeach; ?>
  </div><!-- /.km-list -->

  <?php endif; ?>

</div>
</div>

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