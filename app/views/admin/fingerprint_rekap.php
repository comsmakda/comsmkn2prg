<?php
/**
 * app/views/admin/fingerprint_rekap.php
 *
 * Variabel yang tersedia:
 * $rekap (array baris hasil FingerprintModel::getRekapHarian),
 * $tanggalMulai, $tanggalAkhir, $kelas, $kelasList, $flash
 */
?>

<style>
/* ═══════════════════════════════════════
   SCOPE ROOT — alias ke Design System
   (disamakan dengan app/views/admin/fingerprint.php)
═══════════════════════════════════════ */
.fpr-root {
  --tx-primary:   var(--c-ink,    #0f172a);
  --tx-secondary: var(--c-muted,  #64748b);
  --tx-muted:     var(--c-muted2, #94a3b8);

  --bg-surface:  var(--c-white, #ffffff);
  --bg-elevated: #f8fafc;

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
  --gray:    #64748b;
  --gray-d:  #f1f5f9;
  --blue:    #2563eb;
  --blue-d:  #eff6ff;

  --r-xs: 6px;
  --r-sm: var(--radius-sm, 9px);
  --r-md: var(--radius-md, 13px);
  --r-lg: var(--radius-lg, 22px);

  --font-ui: var(--ff, 'Plus Jakarta Sans', sans-serif);
  --ease: cubic-bezier(0.22, 1, 0.36, 1);
  --t-fast: 120ms;
}

.fpr-root * { box-sizing: border-box; }
.fpr-root {
  font-family: var(--font-ui);
  color: var(--tx-primary);
  font-size: 13.5px;
  line-height: 1.5;
  -webkit-font-smoothing: antialiased;
}

/* ── Header ── */
.fpr-header { margin-bottom: 20px; }
.fpr-eyebrow {
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
.fpr-eyebrow::before {
  content: '';
  width: 6px; height: 6px;
  border-radius: 50%;
  background: var(--ac);
  box-shadow: 0 0 6px var(--ac);
}
.fpr-title {
  font-size: 22px;
  font-weight: 800;
  letter-spacing: -.03em;
  color: var(--ac-dk);
}

/* ── Alert (flash) ── */
.fpr-alert {
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
.fpr-alert i { font-size: 17px; flex-shrink: 0; }
.fpr-alert--success { background: var(--green-d); border-color: rgba(21,128,61,.25); color: var(--green); }
.fpr-alert--error,
.fpr-alert--danger   { background: var(--red-d);   border-color: rgba(185,28,28,.25); color: var(--red); }
.fpr-alert--warning  { background: var(--amber-d); border-color: rgba(217,145,12,.3); color: var(--amber); }
.fpr-alert--info      { background: var(--ac-dim);  border-color: var(--bd-accent);   color: var(--ac-dk); }

/* ── Panel base ── */
.fpr-panel {
  background: var(--bg-surface);
  border: 1px solid var(--bd-subtle);
  border-radius: var(--r-lg);
  overflow: hidden;
  margin-bottom: 16px;
}
.fpr-panel__head {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 15px 20px;
  border-bottom: 1px solid var(--bd-subtle);
  gap: 8px;
}
.fpr-panel__title {
  font-size: 13px;
  font-weight: 800;
  color: var(--tx-primary);
  letter-spacing: -.01em;
}
.fpr-panel__body { padding: 18px 20px; }

/* ── Quick date presets ── */
.fpr-presets {
  display: flex;
  flex-wrap: wrap;
  gap: 7px;
  margin-bottom: 14px;
}
.fpr-preset-btn {
  font-family: var(--font-ui);
  font-size: 11.5px;
  font-weight: 700;
  padding: 7px 13px;
  border-radius: 999px;
  border: 1.5px solid var(--bd-subtle);
  background: var(--bg-elevated);
  color: var(--tx-secondary);
  cursor: pointer;
  transition: all var(--t-fast) var(--ease);
}
.fpr-preset-btn:hover {
  border-color: var(--bd-accent);
  background: var(--ac-dim);
  color: var(--ac-dk);
}
.fpr-preset-btn.is-active {
  background: var(--ac);
  border-color: var(--ac);
  color: #fff;
}

/* ── Filter form ── */
.fpr-filter {
  display: flex;
  flex-wrap: wrap;
  align-items: flex-end;
  gap: 12px;
}
.fpr-field { display: flex; flex-direction: column; gap: 5px; }
.fpr-field label {
  font-size: 10.5px;
  font-weight: 700;
  letter-spacing: .06em;
  text-transform: uppercase;
  color: var(--tx-muted);
}
.fpr-field input,
.fpr-field select {
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
.fpr-field input:focus,
.fpr-field select:focus {
  outline: none;
  border-color: var(--ac);
  box-shadow: 0 0 0 3px var(--ac-dim);
}
.fpr-filter__actions {
  display: flex;
  gap: 8px;
  margin-left: auto;
  flex-wrap: wrap;
}

/* ── Buttons ── */
.fpr-btn {
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
  text-decoration: none;
  transition: all var(--t-fast) var(--ease);
}
.fpr-btn i { font-size: 15px; }

.fpr-btn--sec {
  background: var(--bg-surface);
  color: var(--ac);
  border: 1.5px solid var(--bd-accent);
}
.fpr-btn--sec:hover { background: var(--ac-dim); }

.fpr-btn--pri {
  background: var(--ac);
  color: #fff;
  box-shadow: 0 8px 18px rgba(14,116,144,.22);
}
.fpr-btn--pri:hover { background: var(--ac-lt); transform: translateY(-1px); box-shadow: 0 10px 22px rgba(6,182,212,.28); }

/* ── Table ── */
.fpr-tbl-wrap { overflow-x: auto; }
.fpr-tbl { width: 100%; border-collapse: collapse; min-width: 760px; }
.fpr-tbl th {
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
.fpr-tbl td {
  padding: 12px 10px 12px 0;
  border-bottom: 1px solid var(--bd-subtle);
  font-size: 12.5px;
  color: var(--tx-secondary);
  vertical-align: middle;
}
.fpr-tbl tr:last-child td { border-bottom: none; }
.fpr-tbl tr:hover td { background: rgba(14,116,144,.03); }
.fpr-tbl__name { color: var(--tx-primary); font-weight: 700; }
.fpr-tbl__no { color: var(--tx-muted); font-weight: 600; }

.fpr-empty {
  text-align: center;
  padding: 34px 20px;
  color: var(--tx-muted);
  font-size: 12.5px;
}

/* ── Badge status ── */
.fpr-badge {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  font-size: 10.5px;
  font-weight: 700;
  padding: 3px 9px;
  border-radius: var(--r-xs);
  white-space: nowrap;
}
.fpr-badge::before { content: ''; width: 5px; height: 5px; border-radius: 50%; background: currentColor; }
.fpr-badge--green { background: var(--green-d); color: var(--green); }
.fpr-badge--red   { background: var(--red-d);   color: var(--red); }
.fpr-badge--amber { background: var(--amber-d); color: var(--amber); }
.fpr-badge--gray  { background: var(--gray-d);  color: var(--gray); }
.fpr-badge--blue  { background: var(--blue-d);  color: var(--blue); }

@media (max-width: 640px) {
  .fpr-filter { flex-direction: column; align-items: stretch; }
  .fpr-filter__actions { margin-left: 0; justify-content: stretch; }
  .fpr-filter__actions .fpr-btn { flex: 1; justify-content: center; }
  .fpr-field select, .fpr-field input { min-width: 0; width: 100%; }
}
</style>

<div class="fpr-root">

  <div class="fpr-header">
    <div class="fpr-eyebrow">Laporan</div>
    <h1 class="fpr-title">Rekap Absensi Fingerprint</h1>
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
      <div class="fpr-alert fpr-alert--<?= $flashType ?>">
          <i class="ti <?= $flashIcon ?>" aria-hidden="true"></i>
          <span><?= htmlspecialchars($flash['msg']) ?></span>
      </div>
  <?php endif; ?>

  <!-- ── Filter ── -->
  <div class="fpr-panel">
    <div class="fpr-panel__body">

      <!-- Pintasan tanggal cepat -->
      <div class="fpr-presets" id="fpr-presets">
        <button type="button" class="fpr-preset-btn" data-preset="today">Hari Ini</button>
        <button type="button" class="fpr-preset-btn" data-preset="week">Minggu Ini</button>
        <button type="button" class="fpr-preset-btn" data-preset="month">Bulan Ini</button>
        <button type="button" class="fpr-preset-btn" data-preset="last7">7 Hari Terakhir</button>
        <button type="button" class="fpr-preset-btn" data-preset="last30">30 Hari Terakhir</button>
      </div>

      <form method="get" action="/admin/fingerprint/rekap" class="fpr-filter" id="fpr-filter-form">
        <div class="fpr-field">
          <label for="fpr-tgl-mulai">Tanggal Mulai</label>
          <input type="date" id="fpr-tgl-mulai" name="tanggal_mulai"
                 value="<?= htmlspecialchars($tanggalMulai) ?>">
        </div>
        <div class="fpr-field">
          <label for="fpr-tgl-akhir">Tanggal Akhir</label>
          <input type="date" id="fpr-tgl-akhir" name="tanggal_akhir"
                 value="<?= htmlspecialchars($tanggalAkhir) ?>">
        </div>
        <div class="fpr-field">
          <label for="fpr-kelas">Kelas</label>
          <select id="fpr-kelas" name="kelas" onchange="document.getElementById('fpr-filter-form').submit()">
              <option value="">Semua Kelas</option>
              <?php foreach ($kelasList as $k): ?>
                  <option value="<?= htmlspecialchars($k) ?>"
                      <?= $kelas === $k ? 'selected' : '' ?>>
                      <?= htmlspecialchars($k) ?>
                  </option>
              <?php endforeach; ?>
          </select>
        </div>

        <div class="fpr-filter__actions">
          <button type="submit" class="fpr-btn fpr-btn--pri">
            <i class="ti ti-filter" aria-hidden="true"></i>
            Tampilkan
          </button>
          <a class="fpr-btn fpr-btn--sec"
             target="_blank"
             href="/admin/fingerprint/rekap/print?tanggal_mulai=<?= urlencode($tanggalMulai) ?>&tanggal_akhir=<?= urlencode($tanggalAkhir) ?>&kelas=<?= urlencode($kelas) ?>">
            <i class="ti ti-printer" aria-hidden="true"></i>
            Cetak
          </a>
          <a class="fpr-btn fpr-btn--sec"
             href="/admin/fingerprint/rekap/export?tanggal_mulai=<?= urlencode($tanggalMulai) ?>&tanggal_akhir=<?= urlencode($tanggalAkhir) ?>&kelas=<?= urlencode($kelas) ?>">
            <i class="ti ti-file-spreadsheet" aria-hidden="true"></i>
            Export Excel
          </a>
        </div>
      </form>
    </div>
  </div>

  <!-- ── Tabel Rekap ── -->
  <div class="fpr-panel">
    <div class="fpr-panel__head">
      <span class="fpr-panel__title">Data Rekap Absensi</span>
    </div>
    <div class="fpr-panel__body">
      <div class="fpr-tbl-wrap">
        <table class="fpr-tbl">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>NIA</th>
              <th>Kelas</th>
              <th>Tanggal</th>
              <th>Jam Masuk</th>
              <th>Jam Pulang</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
          <?php if (empty($rekap)): ?>
              <tr>
                  <td colspan="8" class="fpr-empty">
                      Tidak ada data untuk rentang tanggal ini.
                  </td>
              </tr>
          <?php else: ?>
              <?php $no = 1; ?>
              <?php foreach ($rekap as $row): ?>
                  <?php
                      $badgeClass = match ($row['status']) {
                          'hadir'        => 'fpr-badge--green',
                          'terlambat'    => 'fpr-badge--amber',
                          'libur'        => 'fpr-badge--gray',
                          'belum_mulai'  => 'fpr-badge--blue',
                          default        => 'fpr-badge--red',
                      };
                      $badgeLabel = match ($row['status']) {
                          'hadir'        => 'Hadir',
                          'terlambat'    => 'Terlambat',
                          'libur'        => 'Libur',
                          'belum_mulai'  => 'Belum Mulai',
                          default        => 'Alpa',
                      };
                  ?>
                  <tr>
                      <td class="fpr-tbl__no"><?= $no++ ?></td>
                      <td class="fpr-tbl__name"><?= htmlspecialchars($row['nama_lengkap']) ?></td>
                      <td><?= htmlspecialchars($row['nia']) ?></td>
                      <td><?= htmlspecialchars($row['kelas']) ?></td>
                      <td><?= htmlspecialchars(date('d/m/Y', strtotime($row['tanggal']))) ?></td>
                      <td><?= $row['jam_masuk'] ? htmlspecialchars(substr($row['jam_masuk'], 0, 5)) : '-' ?></td>
                      <td><?= $row['jam_pulang'] ? htmlspecialchars(substr($row['jam_pulang'], 0, 5)) : '-' ?></td>
                      <td><span class="fpr-badge <?= $badgeClass ?>"><?= $badgeLabel ?></span></td>
                  </tr>
              <?php endforeach; ?>
          <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>

<script>
(function () {
  const inputMulai = document.getElementById('fpr-tgl-mulai');
  const inputAkhir = document.getElementById('fpr-tgl-akhir');
  const form        = document.getElementById('fpr-filter-form');
  const presetBtns  = document.querySelectorAll('.fpr-preset-btn');

  function fmt(d) {
    const y = d.getFullYear();
    const m = String(d.getMonth() + 1).padStart(2, '0');
    const day = String(d.getDate()).padStart(2, '0');
    return `${y}-${m}-${day}`;
  }

  function setRange(start, end) {
    inputMulai.value = fmt(start);
    inputAkhir.value = fmt(end);
    form.submit();
  }

  presetBtns.forEach(function (btn) {
    btn.addEventListener('click', function () {
      const today = new Date();
      const preset = btn.dataset.preset;

      if (preset === 'today') {
        setRange(today, today);
      } else if (preset === 'week') {
        // Senin s.d. hari ini (minggu berjalan)
        const day = today.getDay(); // 0 = Minggu
        const diffToMonday = day === 0 ? 6 : day - 1;
        const monday = new Date(today);
        monday.setDate(today.getDate() - diffToMonday);
        setRange(monday, today);
      } else if (preset === 'month') {
        const first = new Date(today.getFullYear(), today.getMonth(), 1);
        setRange(first, today);
      } else if (preset === 'last7') {
        const start = new Date(today);
        start.setDate(today.getDate() - 6);
        setRange(start, today);
      } else if (preset === 'last30') {
        const start = new Date(today);
        start.setDate(today.getDate() - 29);
        setRange(start, today);
      }
    });
  });
})();
</script>