<?php
/**
 * app/views/admin/fingerprint_rekap.php
 *
 * Variabel yang tersedia:
 * $rekap (array baris hasil FingerprintModel::getRekapHarian),
 * $tanggalMulai, $tanggalAkhir, $kelas, $kelasList, $flash
 *
 * Setiap baris $rekap sekarang membawa field tambahan:
 * user_id, keterangan, sumber ('otomatis'|'manual'), is_arsip (bool)
 * — lihat FingerprintModel::getRekapHarian().
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
  --purple:  #7c3aed;
  --purple-d:#f5f3ff;

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
.fpr-field select,
.fpr-field textarea {
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
.fpr-field textarea { min-width: 0; width: 100%; resize: vertical; font-weight: 500; }
.fpr-field input:focus,
.fpr-field select:focus,
.fpr-field textarea:focus {
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

.fpr-btn--danger-outline {
  background: var(--bg-surface);
  color: var(--red);
  border: 1.5px solid rgba(185,28,28,.3);
}
.fpr-btn--danger-outline:hover { background: var(--red-d); }

.fpr-btn--ghost {
  background: transparent;
  color: var(--tx-secondary);
  border: 1.5px solid var(--bd-subtle);
}
.fpr-btn--ghost:hover { background: var(--bg-elevated); }

.fpr-btn--sm { padding: 6px 11px; font-size: 11px; }
.fpr-btn--icon { padding: 7px; }
.fpr-btn:disabled { opacity: .5; cursor: not-allowed; }

/* ── Table ── */
.fpr-tbl-wrap { overflow-x: auto; }
.fpr-tbl { width: 100%; border-collapse: collapse; min-width: 900px; }
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
.fpr-tbl__name-wrap { display: flex; flex-direction: column; gap: 2px; }
.fpr-tbl__ket {
  font-size: 10.5px;
  color: var(--tx-muted);
  font-weight: 500;
  max-width: 160px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.fpr-tbl__aksi { text-align: right; white-space: nowrap; }

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
.fpr-badge--green  { background: var(--green-d);  color: var(--green); }
.fpr-badge--red    { background: var(--red-d);    color: var(--red); }
.fpr-badge--amber  { background: var(--amber-d);  color: var(--amber); }
.fpr-badge--gray   { background: var(--gray-d);   color: var(--gray); }
.fpr-badge--blue   { background: var(--blue-d);   color: var(--blue); }
.fpr-badge--purple { background: var(--purple-d); color: var(--purple); }

.fpr-tag-manual {
  display: inline-flex;
  align-items: center;
  gap: 3px;
  font-size: 9.5px;
  font-weight: 700;
  letter-spacing: .03em;
  text-transform: uppercase;
  color: var(--ac);
  margin-left: 6px;
}
.fpr-tag-arsip {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  font-size: 10.5px;
  font-weight: 700;
  color: var(--tx-muted);
}

@media (max-width: 640px) {
  .fpr-filter { flex-direction: column; align-items: stretch; }
  .fpr-filter__actions { margin-left: 0; justify-content: stretch; }
  .fpr-filter__actions .fpr-btn { flex: 1; justify-content: center; }
  .fpr-field select, .fpr-field input { min-width: 0; width: 100%; }
}

/* ═══════════════════════════════════════
   MODAL EDIT REKAP MANUAL
═══════════════════════════════════════ */
.fpr-modal-overlay {
  display: none;
  position: fixed;
  inset: 0;
  background: rgba(15,23,42,.5);
  backdrop-filter: blur(2px);
  z-index: 1000;
  align-items: center;
  justify-content: center;
  padding: 16px;
}
.fpr-modal-overlay.is-open { display: flex; }
.fpr-modal {
  background: var(--bg-surface);
  border-radius: var(--r-lg);
  width: 100%;
  max-width: 440px;
  max-height: 90vh;
  overflow-y: auto;
  box-shadow: 0 24px 60px rgba(15,23,42,.3);
}
.fpr-modal__head {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  gap: 10px;
  padding: 18px 20px 14px;
  border-bottom: 1px solid var(--bd-subtle);
}
.fpr-modal__title { font-size: 15px; font-weight: 800; color: var(--ac-dk); }
.fpr-modal__subtitle { font-size: 11.5px; color: var(--tx-muted); font-weight: 600; margin-top: 3px; }
.fpr-modal__close {
  background: var(--bg-elevated);
  border: none;
  border-radius: 8px;
  width: 28px; height: 28px;
  display: flex; align-items: center; justify-content: center;
  cursor: pointer;
  color: var(--tx-secondary);
  flex-shrink: 0;
}
.fpr-modal__close:hover { background: var(--bd-subtle); }
.fpr-modal__body { padding: 18px 20px; display: flex; flex-direction: column; gap: 14px; }
.fpr-modal__foot {
  display: flex;
  gap: 8px;
  padding: 14px 20px 18px;
  border-top: 1px solid var(--bd-subtle);
}
.fpr-modal__foot .fpr-btn { flex: 1; justify-content: center; }

.fpr-status-grid {
  display: grid;
  grid-template-columns: repeat(5, 1fr);
  gap: 6px;
}
.fpr-status-opt { display: none; }
.fpr-status-opt-label {
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  padding: 8px 4px;
  border-radius: var(--r-sm);
  border: 1.5px solid var(--bd-subtle);
  font-size: 10.5px;
  font-weight: 700;
  color: var(--tx-secondary);
  cursor: pointer;
  transition: all var(--t-fast) var(--ease);
}
.fpr-status-opt:checked + .fpr-status-opt-label {
  background: var(--ac);
  border-color: var(--ac);
  color: #fff;
}
.fpr-jam-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 10px;
}
.fpr-jam-grid[hidden] { display: none; }

.fpr-modal-note {
  display: flex;
  gap: 8px;
  align-items: flex-start;
  background: var(--ac-dim);
  border: 1px solid var(--bd-accent);
  color: var(--ac-dk);
  font-size: 11px;
  font-weight: 600;
  padding: 10px 12px;
  border-radius: var(--r-sm);
}
.fpr-modal-note i { font-size: 15px; margin-top: 1px; flex-shrink: 0; }

form.fpr-hidden-form { display: none; }
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
              <th class="fpr-tbl__aksi">Aksi</th>
            </tr>
          </thead>
          <tbody>
          <?php if (empty($rekap)): ?>
              <tr>
                  <td colspan="9" class="fpr-empty">
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
                          'izin'         => 'fpr-badge--blue',
                          'sakit'        => 'fpr-badge--purple',
                          default        => 'fpr-badge--red', // alpa
                      };
                      $badgeLabel = match ($row['status']) {
                          'hadir'        => 'Hadir',
                          'terlambat'    => 'Terlambat',
                          'libur'        => 'Libur',
                          'belum_mulai'  => 'Belum Mulai',
                          'izin'         => 'Izin',
                          'sakit'        => 'Sakit',
                          default        => 'Alpa',
                      };
                      $isManual = ($row['sumber'] ?? 'otomatis') === 'manual';
                      $isArsip  = !empty($row['is_arsip']);
                  ?>
                  <tr>
                      <td class="fpr-tbl__no"><?= $no++ ?></td>
                      <td>
                        <div class="fpr-tbl__name-wrap">
                          <span class="fpr-tbl__name">
                            <?= htmlspecialchars($row['nama_lengkap']) ?>
                            <?php if ($isManual): ?>
                              <span class="fpr-tag-manual"><i class="ti ti-pencil" aria-hidden="true"></i>Manual</span>
                            <?php endif; ?>
                          </span>
                          <?php if (!empty($row['keterangan'])): ?>
                            <span class="fpr-tbl__ket" title="<?= htmlspecialchars($row['keterangan']) ?>">
                              <?= htmlspecialchars($row['keterangan']) ?>
                            </span>
                          <?php endif; ?>
                        </div>
                      </td>
                      <td><?= htmlspecialchars($row['nia']) ?></td>
                      <td><?= htmlspecialchars($row['kelas'] ?? '-') ?></td>
                      <td><?= htmlspecialchars(date('d/m/Y', strtotime($row['tanggal']))) ?></td>
                      <td><?= $row['jam_masuk'] ? htmlspecialchars(substr($row['jam_masuk'], 0, 5)) : '-' ?></td>
                      <td><?= $row['jam_pulang'] ? htmlspecialchars(substr($row['jam_pulang'], 0, 5)) : '-' ?></td>
                      <td><span class="fpr-badge <?= $badgeClass ?>"><?= $badgeLabel ?></span></td>
                      <td class="fpr-tbl__aksi">
                        <?php if ($isArsip): ?>
                          <span class="fpr-tag-arsip" title="Anggota sudah dihapus dari sistem — data ini arsip permanen">
                            <i class="ti ti-archive" aria-hidden="true"></i> Arsip
                          </span>
                        <?php else: ?>
                          <button type="button"
                                  class="fpr-btn fpr-btn--sec fpr-btn--sm fpr-edit-btn"
                                  data-user-id="<?= (int) $row['user_id'] ?>"
                                  data-nama="<?= htmlspecialchars($row['nama_lengkap'], ENT_QUOTES) ?>"
                                  data-tanggal="<?= htmlspecialchars($row['tanggal']) ?>"
                                  data-status="<?= htmlspecialchars($row['status']) ?>"
                                  data-jam-masuk="<?= htmlspecialchars($row['jam_masuk'] ?? '') ?>"
                                  data-jam-pulang="<?= htmlspecialchars($row['jam_pulang'] ?? '') ?>"
                                  data-keterangan="<?= htmlspecialchars($row['keterangan'] ?? '', ENT_QUOTES) ?>"
                                  data-manual="<?= $isManual ? '1' : '0' ?>">
                            <i class="ti ti-edit" aria-hidden="true"></i>
                            Edit
                          </button>
                        <?php endif; ?>
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

<!-- ═══════════════════════════════════════
     MODAL EDIT REKAP MANUAL
═══════════════════════════════════════ -->
<div class="fpr-modal-overlay fpr-root" id="fpr-modal-overlay">
  <div class="fpr-modal">
    <div class="fpr-modal__head">
      <div>
        <div class="fpr-modal__title">Edit Kehadiran</div>
        <div class="fpr-modal__subtitle" id="fpr-modal-subtitle">-</div>
      </div>
      <button type="button" class="fpr-modal__close" id="fpr-modal-close">
        <i class="ti ti-x" aria-hidden="true"></i>
      </button>
    </div>

    <form method="post" action="/admin/fingerprint/rekap/edit" id="fpr-edit-form">
      <input type="hidden" name="user_id" id="fpr-f-user-id">
      <input type="hidden" name="tanggal" id="fpr-f-tanggal">
      <input type="hidden" name="tanggal_mulai" value="<?= htmlspecialchars($tanggalMulai) ?>">
      <input type="hidden" name="tanggal_akhir" value="<?= htmlspecialchars($tanggalAkhir) ?>">
      <input type="hidden" name="kelas" value="<?= htmlspecialchars($kelas) ?>">

      <div class="fpr-modal__body">

        <div class="fpr-modal-note">
          <i class="ti ti-info-circle" aria-hidden="true"></i>
          <span>Pilih status kehadiran. Jam masuk/pulang hanya perlu diisi untuk status Hadir atau Terlambat.</span>
        </div>

        <div class="fpr-field">
          <label>Status</label>
          <div class="fpr-status-grid" id="fpr-status-grid">
            <?php
              $statusOptions = [
                  'hadir'     => 'Hadir',
                  'terlambat' => 'Terlambat',
                  'izin'      => 'Izin',
                  'sakit'     => 'Sakit',
                  'alpa'      => 'Alpa',
              ];
              $i = 0;
              foreach ($statusOptions as $val => $label):
                  $i++;
            ?>
              <input type="radio" name="status" value="<?= $val ?>" id="fpr-status-<?= $val ?>" class="fpr-status-opt">
              <label for="fpr-status-<?= $val ?>" class="fpr-status-opt-label"><?= $label ?></label>
            <?php endforeach; ?>
          </div>
        </div>

        <div class="fpr-jam-grid" id="fpr-jam-grid">
          <div class="fpr-field">
            <label for="fpr-f-jam-masuk">Jam Masuk</label>
            <input type="time" name="jam_masuk" id="fpr-f-jam-masuk">
          </div>
          <div class="fpr-field">
            <label for="fpr-f-jam-pulang">Jam Pulang</label>
            <input type="time" name="jam_pulang" id="fpr-f-jam-pulang">
          </div>
        </div>

        <div class="fpr-field">
          <label for="fpr-f-keterangan">Keterangan (opsional)</label>
          <textarea name="keterangan" id="fpr-f-keterangan" rows="2" placeholder="Contoh: Izin acara keluarga, lupa absen tapi hadir jam 07:00, dsb."></textarea>
        </div>

      </div>

      <div class="fpr-modal__foot">
        <button type="button" class="fpr-btn fpr-btn--ghost" id="fpr-modal-cancel">Batal</button>
        <button type="submit" class="fpr-btn fpr-btn--pri">
          <i class="ti ti-device-floppy" aria-hidden="true"></i>
          Simpan
        </button>
      </div>
    </form>

    <div style="padding: 0 20px 18px;" id="fpr-reset-wrap" hidden>
      <form method="post" action="/admin/fingerprint/rekap/reset" id="fpr-reset-form"
            onsubmit="return confirm('Kembalikan status ini ke hasil hitung otomatis dari mesin fingerprint? Data manual akan dihapus.');">
        <input type="hidden" name="user_id" id="fpr-r-user-id">
        <input type="hidden" name="tanggal" id="fpr-r-tanggal">
        <input type="hidden" name="tanggal_mulai" value="<?= htmlspecialchars($tanggalMulai) ?>">
        <input type="hidden" name="tanggal_akhir" value="<?= htmlspecialchars($tanggalAkhir) ?>">
        <input type="hidden" name="kelas" value="<?= htmlspecialchars($kelas) ?>">
        <button type="submit" class="fpr-btn fpr-btn--danger-outline" style="width:100%; justify-content:center;">
          <i class="ti ti-rotate" aria-hidden="true"></i>
          Batalkan Edit Manual (Kembalikan ke Otomatis)
        </button>
      </form>
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
        const day = today.getDay();
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

/* ── Modal Edit Rekap Manual ── */
(function () {
  const overlay      = document.getElementById('fpr-modal-overlay');
  const closeBtn      = document.getElementById('fpr-modal-close');
  const cancelBtn      = document.getElementById('fpr-modal-cancel');
  const subtitle      = document.getElementById('fpr-modal-subtitle');
  const jamGrid       = document.getElementById('fpr-jam-grid');
  const fUserId       = document.getElementById('fpr-f-user-id');
  const fTanggal      = document.getElementById('fpr-f-tanggal');
  const fJamMasuk      = document.getElementById('fpr-f-jam-masuk');
  const fJamPulang    = document.getElementById('fpr-f-jam-pulang');
  const fKeterangan   = document.getElementById('fpr-f-keterangan');
  const resetWrap      = document.getElementById('fpr-reset-wrap');
  const rUserId       = document.getElementById('fpr-r-user-id');
  const rTanggal      = document.getElementById('fpr-r-tanggal');
  const statusRadios  = document.querySelectorAll('input[name="status"]');

  const JAM_STATUSES = ['hadir', 'terlambat'];

  function toggleJamGrid() {
    const checked = document.querySelector('input[name="status"]:checked');
    const show = checked && JAM_STATUSES.includes(checked.value);
    jamGrid.hidden = !show;
  }

  statusRadios.forEach(function (r) {
    r.addEventListener('change', toggleJamGrid);
  });

  function openModal(btn) {
    const d = btn.dataset;

    subtitle.textContent = d.nama + ' — ' + formatTanggalIndo(d.tanggal);

    fUserId.value = d.userId;
    fTanggal.value = d.tanggal;
    fJamMasuk.value = d.jamMasuk || '';
    fJamPulang.value = d.jamPulang || '';
    fKeterangan.value = d.keterangan || '';

    statusRadios.forEach(function (r) {
      r.checked = (r.value === d.status);
    });
    // Kalau status saat ini bukan salah satu opsi manual (mis. libur/belum_mulai),
    // jangan pre-select apa pun — biarkan admin pilih sendiri.
    const anyChecked = document.querySelector('input[name="status"]:checked');
    if (!anyChecked) {
      statusRadios.forEach(function (r) { r.checked = false; });
    }

    toggleJamGrid();

    if (d.manual === '1') {
      resetWrap.hidden = false;
      rUserId.value = d.userId;
      rTanggal.value = d.tanggal;
    } else {
      resetWrap.hidden = true;
    }

    overlay.classList.add('is-open');
  }

  function closeModal() {
    overlay.classList.remove('is-open');
  }

  function formatTanggalIndo(ymd) {
    const parts = ymd.split('-');
    if (parts.length !== 3) return ymd;
    return parts[2] + '/' + parts[1] + '/' + parts[0];
  }

  document.querySelectorAll('.fpr-edit-btn').forEach(function (btn) {
    btn.addEventListener('click', function () { openModal(btn); });
  });

  closeBtn.addEventListener('click', closeModal);
  cancelBtn.addEventListener('click', closeModal);
  overlay.addEventListener('click', function (e) {
    if (e.target === overlay) closeModal();
  });
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeModal();
  });

  document.getElementById('fpr-edit-form').addEventListener('submit', function (e) {
    const checked = document.querySelector('input[name="status"]:checked');
    if (!checked) {
      e.preventDefault();
      alert('Pilih status kehadiran terlebih dahulu.');
    }
  });
})();
</script>