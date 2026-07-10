<?php
/**
 * app/views/admin/fingerprint.php
 *
 * Variabel yang tersedia:
 * $title, $health (['success'=>bool,'message'=>string]), $anggota (array baris users),
 * $csrfToken, $flash
 */
?>

<style>
/* ═══════════════════════════════════════
   SCOPE ROOT — alias ke Design System
   (token asli didefinisikan global di layout;
    fallback disertakan bila file ini dirender berdiri sendiri)
═══════════════════════════════════════ */
.fp-root {
  --tx-primary:   var(--c-ink,    #0f172a);
  --tx-secondary: var(--c-muted,  #64748b);
  --tx-muted:     var(--c-muted2, #94a3b8);

  --bg-surface:  var(--c-white, #ffffff);
  --bg-elevated: #f8fafc;
  --bg-overlay:  #eef2f6;

  --bd-subtle:  var(--c-border, #e6ebf1);
  --bd-accent:  var(--c-primary-25, rgba(14,116,144,.25));

  --ac:      var(--c-primary,    #0e7490);
  --ac-dk:   var(--c-primary-dk, #0b5a70);
  --ac-lt:   var(--c-primary-lt, #06b6d4);
  --ac-dim:  var(--c-primary-08, rgba(14,116,144,.08));

  --green:   var(--c-green-text, #15803d);
  --green-d: var(--c-green-bg,   #f0fdf4);
  --red:     var(--c-red-text,   #b91c1c);
  --red-d:   var(--c-red-bg,     #fef2f2);
  --amber:   var(--c-amber-icon, #d9910c);
  --amber-d: var(--c-amber-bg,   #fef6e2);

  --r-xs: 6px;
  --r-sm: var(--radius-sm, 9px);
  --r-md: var(--radius-md, 13px);
  --r-lg: var(--radius-lg, 22px);

  --font-ui: var(--ff, 'Plus Jakarta Sans', sans-serif);
  --ease: cubic-bezier(0.22, 1, 0.36, 1);
  --t-fast: 120ms;
  --t-base: 160ms;
}

.fp-root * { box-sizing: border-box; }
.fp-root {
  font-family: var(--font-ui);
  color: var(--tx-primary);
  font-size: 13.5px;
  line-height: 1.5;
  -webkit-font-smoothing: antialiased;
}

/* ── Header ── */
.fp-header { margin-bottom: 20px; }
.fp-eyebrow {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  font-size: 11px;
  font-weight: 700;
  letter-spacing: .1em;
  text-transform: uppercase;
  color: var(--ac);
  margin-bottom: 6px;
}
.fp-eyebrow::before {
  content: '';
  width: 6px; height: 6px;
  border-radius: 50%;
  background: var(--ac);
  box-shadow: 0 0 6px var(--ac);
}
.fp-title {
  font-size: 22px;
  font-weight: 800;
  letter-spacing: -.03em;
  color: var(--ac-dk);
}

/* ── Alert (flash) — sesuai §5.5 design system ── */
.fp-alert {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 12px 16px;
  border-radius: var(--r-md);
  font-size: 12.5px;
  font-weight: 600;
  margin-bottom: 16px;
  border: 1px solid;
}
.fp-alert i { font-size: 17px; flex-shrink: 0; }
.fp-alert--success { background: var(--green-d); border-color: rgba(21,128,61,.25); color: var(--green); }
.fp-alert--error,
.fp-alert--danger   { background: var(--red-d);   border-color: rgba(185,28,28,.25); color: var(--red); }
.fp-alert--warning  { background: var(--amber-d); border-color: rgba(217,145,12,.3); color: var(--amber); }
.fp-alert--info      { background: var(--ac-dim);  border-color: var(--bd-accent);   color: var(--ac-dk); }

/* ── Panel base ── */
.fp-panel {
  background: var(--bg-surface);
  border: 1px solid var(--bd-subtle);
  border-radius: var(--r-lg);
  overflow: hidden;
  margin-bottom: 16px;
}
.fp-panel__head {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 15px 20px;
  border-bottom: 1px solid var(--bd-subtle);
  gap: 8px;
}
.fp-panel__title {
  font-size: 13px;
  font-weight: 800;
  color: var(--tx-primary);
  letter-spacing: -.01em;
}
.fp-panel__body { padding: 18px 20px; }

/* ── Status mesin ── */
.fp-status {
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 14px;
  padding: 18px 20px;
}
.fp-status__left { display: flex; align-items: center; gap: 12px; min-width: 0; }
.fp-status-dot {
  width: 12px; height: 12px;
  border-radius: 50%;
  flex-shrink: 0;
  position: relative;
}
.fp-status-dot::after {
  content: '';
  position: absolute;
  inset: -4px;
  border-radius: 50%;
  border: 1.5px solid currentColor;
  opacity: .35;
}
.fp-status-dot--ok  { background: var(--green); color: var(--green); }
.fp-status-dot--err { background: var(--red);   color: var(--red); }

.fp-status__text { min-width: 0; }
.fp-status__label {
  font-size: 10.5px;
  font-weight: 700;
  letter-spacing: .08em;
  text-transform: uppercase;
  color: var(--tx-muted);
  margin-bottom: 2px;
}
.fp-status__msg {
  font-size: 13px;
  font-weight: 600;
  color: var(--tx-primary);
}

.fp-status__actions { display: flex; gap: 8px; flex-wrap: wrap; }

/* ── Buttons ── */
.fp-btn {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 9px 15px;
  font-family: var(--font-ui);
  font-size: 12px;
  font-weight: 700;
  border-radius: var(--r-sm);
  border: none;
  cursor: pointer;
  white-space: nowrap;
  transition: all var(--t-fast) var(--ease);
}
.fp-btn i { font-size: 15px; }

.fp-btn--sec {
  background: var(--bg-surface);
  color: var(--ac);
  border: 1.5px solid var(--bd-accent);
}
.fp-btn--sec:hover { background: var(--ac-dim); }

.fp-btn--pri {
  background: var(--ac);
  color: #fff;
  box-shadow: 0 8px 18px rgba(14,116,144,.22);
}
.fp-btn--pri:hover { background: var(--ac-lt); transform: translateY(-1px); box-shadow: 0 10px 22px rgba(6,182,212,.28); }

.fp-icon-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 30px; height: 30px;
  border-radius: var(--r-xs);
  border: 1.5px solid var(--bd-subtle);
  background: var(--bg-surface);
  color: var(--tx-secondary);
  cursor: pointer;
  transition: all var(--t-fast) var(--ease);
}
.fp-icon-btn i { font-size: 14px; }
.fp-icon-btn--push:hover  { border-color: var(--bd-accent); color: var(--ac); background: var(--ac-dim); }
.fp-icon-btn--del:hover   { border-color: rgba(185,28,28,.3); color: var(--red); background: var(--red-d); }

form.fp-inline { display: inline-flex; margin: 0; }

/* ── Table ── */
.fp-tbl-wrap { overflow-x: auto; }
.fp-tbl { width: 100%; border-collapse: collapse; min-width: 720px; }
.fp-tbl th {
  font-size: 10.5px;
  font-weight: 700;
  letter-spacing: .08em;
  text-transform: uppercase;
  color: var(--tx-muted);
  text-align: left;
  padding: 0 10px 10px 0;
  border-bottom: 1px solid var(--bd-subtle);
  white-space: nowrap;
}
.fp-tbl th.text-end, .fp-tbl td.text-end { text-align: right; }
.fp-tbl td {
  padding: 12px 10px 12px 0;
  border-bottom: 1px solid var(--bd-subtle);
  font-size: 12.5px;
  color: var(--tx-secondary);
  vertical-align: middle;
}
.fp-tbl tr:last-child td { border-bottom: none; }
.fp-tbl tr:hover td { background: rgba(14,116,144,.03); }
.fp-tbl__name { color: var(--tx-primary); font-weight: 700; }

.fp-empty {
  text-align: center;
  padding: 34px 20px;
  color: var(--tx-muted);
  font-size: 12.5px;
}

/* ── Badge status sync ── */
.fp-badge {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  font-size: 10.5px;
  font-weight: 700;
  padding: 3px 9px;
  border-radius: var(--r-xs);
  white-space: nowrap;
}
.fp-badge::before { content: ''; width: 5px; height: 5px; border-radius: 50%; background: currentColor; }
.fp-badge--green { background: var(--green-d); color: var(--green); }
.fp-badge--red   { background: var(--red-d);   color: var(--red); }
.fp-badge--amber { background: var(--amber-d); color: var(--amber); }

.fp-err-note {
  font-size: 10.5px;
  color: var(--tx-muted);
  margin-top: 4px;
  max-width: 260px;
}

.fp-actions-cell { display: flex; gap: 6px; justify-content: flex-end; }

@media (max-width: 640px) {
  .fp-status { flex-direction: column; align-items: stretch; }
  .fp-status__actions { justify-content: stretch; }
  .fp-status__actions .fp-inline, .fp-status__actions .fp-btn { flex: 1; justify-content: center; }
}
</style>

<div class="fp-root">

  <div class="fp-header">
    <div class="fp-eyebrow">Perangkat</div>
    <h1 class="fp-title"><?= htmlspecialchars($title ?? 'Perangkat Fingerprint') ?></h1>
  </div>

  <?php if (!empty($flash)): ?>
      <?php
        $flashType = htmlspecialchars($flash['type']);
        $flashIcon = match ($flash['type']) {
            'success' => 'ti-circle-check',
            'error', 'danger' => 'ti-alert-circle',
            'warning' => 'ti-alert-triangle',
            default   => 'ti-info-circle',
        };
      ?>
      <div class="fp-alert fp-alert--<?= $flashType ?>">
          <i class="ti <?= $flashIcon ?>" aria-hidden="true"></i>
          <span><?= htmlspecialchars($flash['msg']) ?></span>
      </div>
  <?php endif; ?>

  <!-- ── Status Mesin ── -->
  <div class="fp-panel">
    <div class="fp-status">
      <div class="fp-status__left">
        <span class="fp-status-dot <?= $health['success'] ? 'fp-status-dot--ok' : 'fp-status-dot--err' ?>" aria-hidden="true"></span>
        <div class="fp-status__text">
          <div class="fp-status__label">Status Mesin GEISA X107</div>
          <div class="fp-status__msg"><?= htmlspecialchars($health['msg']) ?></div>
        </div>
      </div>

      <div class="fp-status__actions">
        <form method="post" action="/admin/fingerprint/sync-logs" class="fp-inline">
          <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
          <button type="submit" class="fp-btn fp-btn--sec">
            <i class="ti ti-refresh" aria-hidden="true"></i>
            Tarik Log dari Mesin
          </button>
        </form>

        <form method="post" action="/admin/fingerprint/push-bulk" class="fp-inline"
              onsubmit="return confirm('Push semua anggota yang belum tersinkron ke mesin?');">
          <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
          <button type="submit" class="fp-btn fp-btn--pri">
            <i class="ti ti-upload" aria-hidden="true"></i>
            Push Semua
          </button>
        </form>
      </div>
    </div>
  </div>

  <!-- ── Tabel Anggota ── -->
  <div class="fp-panel">
    <div class="fp-panel__head">
      <span class="fp-panel__title">Daftar Anggota &amp; Status Sync</span>
    </div>
    <div class="fp-panel__body">
      <div class="fp-tbl-wrap">
        <table class="fp-tbl">
          <thead>
            <tr>
              <th>Nama</th>
              <th>NIA</th>
              <th>Kelas</th>
              <th>Status Sync</th>
              <th>Terakhir Sync</th>
              <th class="text-end">Aksi</th>
            </tr>
          </thead>
          <tbody>
          <?php if (empty($anggota)): ?>
              <tr>
                  <td colspan="6" class="fp-empty">
                      Belum ada anggota aktif.
                  </td>
              </tr>
          <?php else: ?>
              <?php foreach ($anggota as $row): ?>
                  <?php
                      $badgeClass = match ($row['fp_status']) {
                          'tersinkron' => 'fp-badge--green',
                          'gagal'      => 'fp-badge--red',
                          default      => 'fp-badge--amber',
                      };
                      $badgeLabel = match ($row['fp_status']) {
                          'tersinkron' => 'Tersinkron',
                          'gagal'      => 'Gagal',
                          default      => 'Belum Sync',
                      };
                  ?>
                  <tr>
                      <td class="fp-tbl__name"><?= htmlspecialchars($row['nama_lengkap']) ?></td>
                      <td><?= htmlspecialchars($row['nia']) ?></td>
                      <td><?= htmlspecialchars($row['kelas']) ?></td>
                      <td>
                          <span class="fp-badge <?= $badgeClass ?>"><?= $badgeLabel ?></span>
                          <?php if ($row['fp_status'] === 'gagal' && !empty($row['fp_last_error'])): ?>
                              <div class="fp-err-note">
                                  <?= htmlspecialchars($row['fp_last_error']) ?>
                              </div>
                          <?php endif; ?>
                      </td>
                      <td>
                          <?= $row['fp_synced_at']
                              ? htmlspecialchars(date('d/m/Y H:i', strtotime($row['fp_synced_at'])))
                              : '-' ?>
                      </td>
                      <td class="text-end">
                          <div class="fp-actions-cell">
                              <form method="post" action="/admin/fingerprint/<?= (int) $row['id'] ?>/push" class="fp-inline">
                                  <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                                  <button type="submit" class="fp-icon-btn fp-icon-btn--push" title="Push ke mesin" aria-label="Push ke mesin">
                                      <i class="ti ti-upload" aria-hidden="true"></i>
                                  </button>
                              </form>
                              <form method="post" action="/admin/fingerprint/<?= (int) $row['id'] ?>/delete" class="fp-inline"
                                    onsubmit="return confirm('Hapus anggota ini dari mesin fingerprint?');">
                                  <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                                  <button type="submit" class="fp-icon-btn fp-icon-btn--del" title="Hapus dari mesin" aria-label="Hapus dari mesin">
                                      <i class="ti ti-trash" aria-hidden="true"></i>
                                  </button>
                              </form>
                          </div>
                      </td>
                  </tr>
              <?php endforeach; ?>
          <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>