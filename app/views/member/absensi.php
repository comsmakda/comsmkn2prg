<?php
/**
 * app/views/member/absensi.php
 *
 * Variabel yang tersedia:
 * $riwayat (array dari FingerprintModel::getRiwayatAbsensiAnggota),
 * $tanggalMulai, $tanggalAkhir, $stats
 */
?>

<style>
.absw-root {
  --tx-primary:   var(--c-ink,    #0f172a);
  --tx-secondary: var(--c-muted,  #64748b);
  --tx-muted:     var(--c-muted2, #94a3b8);

  --bg-surface:  var(--c-white, #ffffff);
  --bd-subtle:   var(--c-border, #e6ebf1);
  --bd-accent:   var(--c-primary-25, rgba(14,116,144,.25));

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
}

.absw-root * { box-sizing: border-box; }
.absw-root {
  font-family: var(--font-ui);
  color: var(--tx-primary);
  font-size: 13.5px;
  line-height: 1.5;
  -webkit-font-smoothing: antialiased;
}

.absw-header { margin-bottom: 20px; }
.absw-eyebrow {
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
.absw-eyebrow::before {
  content: '';
  width: 6px; height: 6px;
  border-radius: 50%;
  background: var(--ac);
  box-shadow: 0 0 6px var(--ac);
}
.absw-title {
  font-size: 22px;
  font-weight: 800;
  letter-spacing: -.03em;
  color: var(--ac-dk);
}

/* Stat cards */
.absw-stats {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 12px;
  margin-bottom: 16px;
}
.absw-stat {
  background: var(--bg-surface);
  border: 1px solid var(--bd-subtle);
  border-radius: var(--r-lg);
  padding: 16px 18px;
  display: flex;
  align-items: center;
  gap: 12px;
}
.absw-stat__icon {
  width: 38px; height: 38px;
  border-radius: var(--r-sm);
  display: flex; align-items: center; justify-content: center;
  font-size: 18px;
  flex-shrink: 0;
}
.absw-stat--green .absw-stat__icon { background: var(--green-d); color: var(--green); }
.absw-stat--amber .absw-stat__icon { background: var(--amber-d); color: var(--amber); }
.absw-stat--red   .absw-stat__icon { background: var(--red-d);   color: var(--red); }
.absw-stat__num {
  font-size: 20px;
  font-weight: 800;
  color: var(--tx-primary);
  line-height: 1.1;
}
.absw-stat__label {
  font-size: 11.5px;
  font-weight: 600;
  color: var(--tx-muted);
}

/* Panel */
.absw-panel {
  background: var(--bg-surface);
  border: 1px solid var(--bd-subtle);
  border-radius: var(--r-lg);
  overflow: hidden;
  margin-bottom: 16px;
}
.absw-panel__head {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 15px 20px;
  border-bottom: 1px solid var(--bd-subtle);
  gap: 8px;
}
.absw-panel__title {
  font-size: 13px;
  font-weight: 800;
  color: var(--tx-primary);
  letter-spacing: -.01em;
}
.absw-panel__body { padding: 18px 20px; }

/* Filter */
.absw-filter {
  display: flex;
  flex-wrap: wrap;
  align-items: flex-end;
  gap: 12px;
}
.absw-field { display: flex; flex-direction: column; gap: 5px; }
.absw-field label {
  font-size: 10.5px;
  font-weight: 700;
  letter-spacing: .06em;
  text-transform: uppercase;
  color: var(--tx-muted);
}
.absw-field input {
  font-family: var(--font-ui);
  font-size: 12.5px;
  font-weight: 600;
  color: var(--tx-primary);
  padding: 9px 12px;
  border: 1.5px solid var(--bd-subtle);
  border-radius: var(--r-sm);
  background: var(--bg-surface);
  min-width: 150px;
  transition: border-color var(--t-fast) var(--ease);
}
.absw-field input:focus {
  outline: none;
  border-color: var(--ac);
  box-shadow: 0 0 0 3px var(--ac-dim);
}

.absw-btn {
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
  background: var(--ac);
  color: #fff;
  box-shadow: 0 8px 18px rgba(14,116,144,.22);
  transition: all var(--t-fast) var(--ease);
}
.absw-btn:hover { background: var(--ac-lt); transform: translateY(-1px); box-shadow: 0 10px 22px rgba(6,182,212,.28); }
.absw-btn i { font-size: 15px; }

/* Table */
.absw-tbl-wrap { overflow-x: auto; }
.absw-tbl { width: 100%; border-collapse: collapse; min-width: 560px; }
.absw-tbl th {
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
.absw-tbl td {
  padding: 12px 10px 12px 0;
  border-bottom: 1px solid var(--bd-subtle);
  font-size: 12.5px;
  color: var(--tx-secondary);
  vertical-align: middle;
}
.absw-tbl tr:last-child td { border-bottom: none; }
.absw-tbl tr:hover td { background: rgba(14,116,144,.03); }
.absw-tbl__date { color: var(--tx-primary); font-weight: 700; }

.absw-empty {
  text-align: center;
  padding: 34px 20px;
  color: var(--tx-muted);
  font-size: 12.5px;
}

.absw-badge {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  font-size: 10.5px;
  font-weight: 700;
  padding: 3px 9px;
  border-radius: var(--r-xs);
  white-space: nowrap;
}
.absw-badge::before { content: ''; width: 5px; height: 5px; border-radius: 50%; background: currentColor; }
.absw-badge--green { background: var(--green-d); color: var(--green); }
.absw-badge--red   { background: var(--red-d);   color: var(--red); }
.absw-badge--amber { background: var(--amber-d); color: var(--amber); }

@media (max-width: 640px) {
  .absw-stats { grid-template-columns: 1fr; }
  .absw-filter { flex-direction: column; align-items: stretch; }
  .absw-filter .absw-btn { justify-content: center; }
  .absw-field input { min-width: 0; width: 100%; }
}
</style>

<div class="absw-root">

  <div class="absw-header">
    <div class="absw-eyebrow">Riwayat</div>
    <h1 class="absw-title">Absensi Saya</h1>
  </div>

  <!-- ── Ringkasan ── -->
  <div class="absw-stats">
    <div class="absw-stat absw-stat--green">
      <div class="absw-stat__icon"><i class="ti ti-circle-check" aria-hidden="true"></i></div>
      <div>
        <div class="absw-stat__num"><?= (int)$stats['hadir'] ?></div>
        <div class="absw-stat__label">Hadir</div>
      </div>
    </div>
    <div class="absw-stat absw-stat--amber">
      <div class="absw-stat__icon"><i class="ti ti-clock-hour-4" aria-hidden="true"></i></div>
      <div>
        <div class="absw-stat__num"><?= (int)$stats['terlambat'] ?></div>
        <div class="absw-stat__label">Terlambat</div>
      </div>
    </div>
    <div class="absw-stat absw-stat--red">
      <div class="absw-stat__icon"><i class="ti ti-alert-circle" aria-hidden="true"></i></div>
      <div>
        <div class="absw-stat__num"><?= (int)$stats['alpa'] ?></div>
        <div class="absw-stat__label">Alpa</div>
      </div>
    </div>
  </div>

  <!-- ── Filter ── -->
  <div class="absw-panel">
    <div class="absw-panel__body">
      <form method="get" action="<?= BASE_URL ?>/member/absensi" class="absw-filter">
        <div class="absw-field">
          <label for="absw-tgl-mulai">Tanggal Mulai</label>
          <input type="date" id="absw-tgl-mulai" name="tanggal_mulai"
                 value="<?= htmlspecialchars($tanggalMulai) ?>">
        </div>
        <div class="absw-field">
          <label for="absw-tgl-akhir">Tanggal Akhir</label>
          <input type="date" id="absw-tgl-akhir" name="tanggal_akhir"
                 value="<?= htmlspecialchars($tanggalAkhir) ?>">
        </div>
        <button type="submit" class="absw-btn">
          <i class="ti ti-filter" aria-hidden="true"></i>
          Tampilkan
        </button>
      </form>
    </div>
  </div>

  <!-- ── Tabel Riwayat ── -->
  <div class="absw-panel">
    <div class="absw-panel__head">
      <span class="absw-panel__title">Riwayat Kehadiran</span>
    </div>
    <div class="absw-panel__body">
      <div class="absw-tbl-wrap">
        <table class="absw-tbl">
          <thead>
            <tr>
              <th>Tanggal</th>
              <th>Jam Masuk</th>
              <th>Jam Pulang</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
          <?php if (empty($riwayat)): ?>
              <tr>
                  <td colspan="4" class="absw-empty">
                      Tidak ada data untuk rentang tanggal ini.
                  </td>
              </tr>
          <?php else: ?>
              <?php foreach ($riwayat as $row): ?>
                  <?php
                      $badgeClass = match ($row['status']) {
                          'hadir'     => 'absw-badge--green',
                          'terlambat' => 'absw-badge--amber',
                          default     => 'absw-badge--red',
                      };
                      $badgeLabel = match ($row['status']) {
                          'hadir'     => 'Hadir',
                          'terlambat' => 'Terlambat',
                          default     => 'Alpa',
                      };
                  ?>
                  <tr>
                      <td class="absw-tbl__date"><?= htmlspecialchars(date('d/m/Y', strtotime($row['tanggal']))) ?></td>
                      <td><?= $row['jam_masuk'] ? htmlspecialchars(substr($row['jam_masuk'], 0, 5)) : '-' ?></td>
                      <td><?= $row['jam_pulang'] ? htmlspecialchars(substr($row['jam_pulang'], 0, 5)) : '-' ?></td>
                      <td><span class="absw-badge <?= $badgeClass ?>"><?= $badgeLabel ?></span></td>
                  </tr>
              <?php endforeach; ?>
          <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>