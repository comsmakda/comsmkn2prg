<?php // app/views/admin/absensi_print.php
$orgName = htmlspecialchars($settings['org_name']['value'] ?? APP_NAME);
?>

<style>
  /* ─── Google Fonts ─────────────────────────────────────── */
  @import url('https://fonts.googleapis.com/css2?family=Times+New+Roman&family=EB+Garamond:ital,wght@0,400;0,600;0,700;1,400&display=swap');

  /* ─── Reset & Base ─────────────────────────────────────── */
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  body {
    font-family: 'Times New Roman', Times, serif;
    font-size: 12pt;
    color: #000;
    background: #f0f0f0;
  }

  /* ─── Page wrapper ─────────────────────────────────────── */
  .page-wrapper {
    max-width: 210mm;
    margin: 20px auto;
    background: #fff;
    padding: 20mm 20mm 25mm 25mm; /* margin surat: atas kanan bawah kiri */
    box-shadow: 0 4px 24px rgba(0,0,0,0.12);
    min-height: 297mm;
  }

  /* ─── KOP SURAT ────────────────────────────────────────── */
  .kop-surat {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    padding-bottom: 10px;
  }

  .kop-logo {
    width: 72px;
    height: 72px;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .kop-logo img {
    width: 100%;
    height: 100%;
    object-fit: contain;
  }

  /* Placeholder logo jika gambar tidak ada */
  .kop-logo-placeholder {
    width: 72px;
    height: 72px;
    border: 2px solid #1a1a6e;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 9pt;
    font-weight: 700;
    color: #1a1a6e;
    text-align: center;
    line-height: 1.2;
    padding: 6px;
    flex-shrink: 0;
  }

  .kop-text {
    flex: 1;
    text-align: center;
    line-height: 1.35;
  }

  .kop-text .kop-org {
    font-size: 13pt;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.03em;
    color: #000;
  }

  .kop-text .kop-sekolah {
    font-size: 15pt;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #1a1a6e;
  }

  .kop-text .kop-alamat {
    font-size: 9.5pt;
    color: #000;
    margin-top: 2px;
  }

  .kop-text .kop-email {
    font-size: 9.5pt;
    font-style: italic;
    color: #000;
  }

  /* Garis kop: tebal-tipis seperti surat resmi pemerintah */
  .kop-divider {
    margin-top: 8px;
    border: none;
  }

  .kop-divider-thick {
    height: 3px;
    background: #1a1a6e;
    margin-bottom: 1.5px;
  }

  .kop-divider-thin {
    height: 1px;
    background: #1a1a6e;
  }

  /* ─── JUDUL DOKUMEN ────────────────────────────────────── */
  .doc-title-wrapper {
    text-align: center;
    margin: 20px 0 14px 0;
  }

  .doc-title-wrapper .doc-title {
    font-size: 13pt;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    text-decoration: underline;
    color: #000;
  }

  .doc-title-wrapper .doc-subtitle {
    font-size: 11pt;
    margin-top: 3px;
    color: #000;
  }

  /* ─── INFO DOKUMEN ─────────────────────────────────────── */
  .doc-info {
    margin: 10px 0 16px 0;
    font-size: 10.5pt;
    color: #000;
  }

  .doc-info table {
    border: none;
    width: auto;
  }

  .doc-info td {
    border: none !important;
    padding: 1px 0;
    vertical-align: top;
  }

  .doc-info td:first-child {
    min-width: 130px;
    font-weight: normal;
  }

  .doc-info td:nth-child(2) {
    padding: 1px 6px;
    width: 10px;
  }

  /* ─── TABEL ABSENSI ────────────────────────────────────── */
  .absensi-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 10.5pt;
    margin-top: 4px;
  }

  .absensi-table thead tr th {
    background: #1a1a6e;
    color: #fff;
    font-weight: 700;
    text-align: center;
    padding: 7px 8px;
    border: 1px solid #1a1a6e;
    font-size: 10pt;
    letter-spacing: 0.02em;
  }

  .absensi-table thead tr th.text-left {
    text-align: left;
  }

  .absensi-table tbody tr td {
    border: 1px solid #999;
    padding: 6px 8px;
    vertical-align: middle;
    color: #000;
  }

  .absensi-table tbody tr:nth-child(even) td {
    background: #f5f6fb;
  }

  .absensi-table tbody tr:nth-child(odd) td {
    background: #fff;
  }

  .absensi-table .td-no {
    text-align: center;
    width: 34px;
    font-size: 10pt;
  }

  .absensi-table .td-nia {
    font-family: 'Courier New', Courier, monospace;
    font-size: 9.5pt;
    white-space: nowrap;
  }

  .absensi-table .td-nama {
    min-width: 160px;
  }

  .absensi-table .td-kelas {
    text-align: center;
    white-space: nowrap;
  }

  .absensi-table .td-ttd {
    height: 38px;
    width: 120px;
    text-align: center;
  }

  .absensi-table .td-empty {
    text-align: center;
    color: #777;
    padding: 24px;
    font-style: italic;
  }

  /* ─── TANDA TANGAN ─────────────────────────────────────── */
  .ttd-section {
    margin-top: 28px;
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    font-size: 10.5pt;
  }

  .ttd-left {
    font-size: 10pt;
    color: #444;
    align-self: flex-end;
  }

  .ttd-right {
    text-align: center;
    min-width: 180px;
  }

  .ttd-right .ttd-jabatan {
    font-weight: normal;
    margin-bottom: 0;
  }

  .ttd-right .ttd-space {
    height: 56px;
  }

  .ttd-right .ttd-nama {
    font-weight: 700;
    text-decoration: underline;
    border-top: 1px solid #000;
    padding-top: 3px;
    min-width: 180px;
    display: inline-block;
    letter-spacing: 0.01em;
  }

  /* ─── FILTER (no-print) ────────────────────────────────── */
  .no-print {
    max-width: 210mm;
    margin: 16px auto 0 auto;
    background: #fff;
    padding: 14px 20px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    font-family: 'Segoe UI', sans-serif;
    font-size: 13px;
  }

  .no-print form {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    align-items: flex-end;
  }

  .no-print label {
    display: block;
    font-size: 11px;
    color: #555;
    margin-bottom: 4px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.04em;
  }

  .no-print select {
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 6px 10px;
    font-size: 12px;
    color: #333;
    background: #fafafa;
    outline: none;
    transition: border 0.2s;
  }

  .no-print select:focus {
    border-color: #1a1a6e;
  }

  .no-print .btn-filter {
    padding: 7px 18px;
    background: #1a1a6e;
    color: #fff;
    border: none;
    border-radius: 5px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    letter-spacing: 0.04em;
    transition: background 0.2s;
  }

  .no-print .btn-filter:hover { background: #13135a; }

  .btn-print {
    padding: 7px 18px;
    background: #28a745;
    color: #fff;
    border: none;
    border-radius: 5px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    letter-spacing: 0.04em;
    transition: background 0.2s;
  }

  .btn-print:hover { background: #1e7e34; }

  /* ─── PRINT MEDIA ──────────────────────────────────────── */
  @media print {
    @page {
      size: A4 portrait;
      margin: 20mm 20mm 25mm 25mm;
    }

    body {
      background: #fff;
      font-size: 11pt;
    }

    .no-print { display: none !important; }

    .page-wrapper {
      box-shadow: none;
      margin: 0;
      padding: 0;
      max-width: 100%;
      min-height: auto;
    }

    .absensi-table thead tr th {
      /* Print-safe: background-color perlu -webkit-print-color-adjust */
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    .absensi-table tbody tr:nth-child(even) td {
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    .kop-divider-thick,
    .kop-divider-thin {
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }
  }
</style>

<!-- ═══════════════════════════════════════════════════════ -->
<!--  FILTER (tidak ikut cetak)                             -->
<!-- ═══════════════════════════════════════════════════════ -->
<div class="no-print">
  <form method="GET">
    <div>
      <label for="sel-kelas">Filter Kelas</label>
      <select id="sel-kelas" name="kelas">
        <option value="">Semua Kelas</option>
        <?php foreach ($kelasList as $k): ?>
          <option value="<?= htmlspecialchars($k['kelas']) ?>"
                  <?= ($filter['kelas'] ?? '') === $k['kelas'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($k['kelas']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>
    <button type="submit" class="btn-filter">Terapkan Filter</button>
    <button type="button" class="btn-print" onclick="window.print()">&#128438; Cetak</button>
  </form>
</div>

<!-- ═══════════════════════════════════════════════════════ -->
<!--  AREA CETAK                                            -->
<!-- ═══════════════════════════════════════════════════════ -->
<div class="page-wrapper">

  <!-- ── KOP SURAT ─────────────────────────────────────── -->
  <div class="kop-surat">

    <!-- Logo kiri (SMK / Sekolah) -->
    <div class="kop-logo">
      <img src="assets/img/logo.png" alt="Logo SMK Negeri 2 Pinrang">
    </div>

    <!-- Teks tengah -->
    <div class="kop-text">
      <div class="kop-org"><?= $orgName ?></div>
      <div class="kop-sekolah">SMK Negeri 2 Pinrang</div>
      <div class="kop-alamat">JL. Kesehatan, Kel. Salo, Kec. Wattang Sawitto, Kab. Pinrang</div>
      <div class="kop-email"><em>E-mail : comsmakda@gmail.com</em></div>
    </div>

    <!-- Logo kanan (COM / Organisasi) -->
    <div class="kop-logo">
      <img src="assets/img/logo-com.png" alt="Logo COM SMKN 2 Pinrang">
    </div>

  </div><!-- /.kop-surat -->

  <!-- Garis pemisah formal (tebal + tipis) -->
  <div class="kop-divider">
    <div class="kop-divider-thick"></div>
    <div class="kop-divider-thin"></div>
  </div>

  <!-- ── JUDUL DOKUMEN ──────────────────────────────────── -->
  <div class="doc-title-wrapper">
    <div class="doc-title">Daftar Hadir Anggota</div>
    <div class="doc-subtitle"><?= htmlspecialchars($sesi['judul']) ?></div>
  </div>

  <!-- ── INFO KEGIATAN ──────────────────────────────────── -->
  <div class="doc-info">
    <table>
      <tr>
        <td>Tanggal</td>
        <td>:</td>
        <td><?= date('d F Y', strtotime($sesi['tanggal'])) ?></td>
      </tr>
      <tr>
        <td>Kegiatan</td>
        <td>:</td>
        <td><?= htmlspecialchars($sesi['judul']) ?></td>
      </tr>
      <?php if (!empty($filter['kelas'])): ?>
      <tr>
        <td>Kelas</td>
        <td>:</td>
        <td><?= htmlspecialchars($filter['kelas']) ?></td>
      </tr>
      <?php endif; ?>
      <tr>
        <td>Jumlah Anggota</td>
        <td>:</td>
        <td><?= count($records) ?> orang</td>
      </tr>
    </table>
  </div>

  <!-- ── TABEL ABSENSI ──────────────────────────────────── -->
  <table class="absensi-table">
    <thead>
      <tr>
        <th style="width:34px;">No</th>
        <th class="text-left" style="width:110px;">NIA</th>
        <th class="text-left">Nama Lengkap</th>
        <th style="width:80px;">Kelas</th>
        <th style="width:130px;">Tanda Tangan</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($records)): ?>
      <tr>
        <td colspan="5" class="td-empty">Tidak ada data anggota.</td>
      </tr>
      <?php endif; ?>
      <?php foreach ($records as $i => $r): ?>
      <tr>
        <td class="td-no"><?= $i + 1 ?></td>
        <td class="td-nia"><?= htmlspecialchars($r['nia'] ?? '—') ?></td>
        <td class="td-nama"><?= htmlspecialchars($r['nama_lengkap']) ?></td>
        <td class="td-kelas"><?= htmlspecialchars($r['kelas'] ?? '—') ?></td>
        <td class="td-ttd"></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <!-- ── TANDA TANGAN ───────────────────────────────────── -->
  <div class="ttd-section">

    <!-- Keterangan di kiri (opsional) -->
    <div class="ttd-left">
      <p>Mengetahui,</p>
      <div style="height:56px;"></div>
      <p style="border-top:1px solid #000; padding-top:3px; min-width:150px; text-align:center;">
        <strong>Pembina / Guru Pendamping</strong>
      </p>
    </div>

    <!-- TTD pengurus di kanan -->
    <div class="ttd-right">
      <p class="ttd-jabatan">Pinrang, <?= date('d F Y') ?></p>
      <p class="ttd-jabatan">Ketua <?= $orgName ?></p>
      <div class="ttd-space"></div>
      <span class="ttd-nama">(.......................................)</span>
    </div>

  </div><!-- /.ttd-section -->

</div><!-- /.page-wrapper -->