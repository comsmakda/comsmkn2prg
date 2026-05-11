<?php // app/views/admin/absensi_print.php
$orgName = htmlspecialchars($settings['org_name']['value'] ?? APP_NAME);
$months  = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',
            7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'];
$today   = date('d') . ' ' . $months[(int)date('m')] . ' ' . date('Y');
?>

<style>
/* ═══════════════════════════════════════════════════════════
   RESET & BASE
═══════════════════════════════════════════════════════════ */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

/* ═══════════════════════════════════════════════════════════
   FILTER BAR  (tidak ikut cetak)
═══════════════════════════════════════════════════════════ */
.ab-filterbar {
  max-width: 210mm;
  margin: 16px auto 0 auto;
  background: #fff;
  padding: 14px 20px;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.09);
  font-family: 'Segoe UI', sans-serif;
  font-size: 13px;
}
.ab-filterbar form {
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
  align-items: flex-end;
}
.ab-filterbar label {
  display: block;
  font-size: 10px;
  color: #666;
  margin-bottom: 4px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.06em;
}
.ab-filterbar select {
  border: 1px solid #d0d0d0;
  border-radius: 5px;
  padding: 7px 11px;
  font-size: 12px;
  color: #333;
  background: #fafafa;
  outline: none;
  transition: border 0.2s;
  font-family: inherit;
}
.ab-filterbar select:focus { border-color: #1a1a6e; }

.ab-btn {
  padding: 7px 18px;
  border: none;
  border-radius: 5px;
  font-size: 12px;
  font-weight: 700;
  cursor: pointer;
  letter-spacing: 0.04em;
  transition: background 0.2s;
  font-family: 'Segoe UI', sans-serif;
}
.ab-btn-filter { background: #1a1a6e; color: #fff; }
.ab-btn-filter:hover { background: #13135a; }
.ab-btn-print  { background: #166534; color: #fff; }
.ab-btn-print:hover  { background: #14532d; }

/* ═══════════════════════════════════════════════════════════
   PAGE WRAPPER (A4 preview di layar)
═══════════════════════════════════════════════════════════ */
.page-wrapper {
  max-width: 210mm;
  margin: 20px auto 40px auto;
  background: #fff;
  /* margin surat: atas kanan bawah kiri */
  padding: 18mm 20mm 24mm 25mm;
  box-shadow: 0 6px 32px rgba(0,0,0,0.13);
  min-height: 297mm;
  font-family: 'Times New Roman', Times, Georgia, serif;
  font-size: 12pt;
  color: #000;
  line-height: 1.6;
}

/* ═══════════════════════════════════════════════════════════
   KOP SURAT  (identik dengan surat_pernyataan)
═══════════════════════════════════════════════════════════ */
.kop {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 10px;
  padding-bottom: 10px;
}

.kop__logo {
  flex-shrink: 0;
  width: 80px;
  display: flex;
  align-items: center;
  justify-content: center;
}
.kop__logo img {
  height: 80px;
  width: auto;
  max-width: 80px;
  object-fit: contain;
  display: block;
}
.kop__logo-fallback {
  width: 76px; height: 76px;
  border: 2px solid #1a1a6e;
  border-radius: 50%;
  display: none;
  align-items: center; justify-content: center;
  font-size: 11pt; font-weight: 900;
  font-family: Arial Black, Arial, sans-serif;
  color: #1a1a6e; text-align: center;
  line-height: 1.2; padding: 4px;
}

.kop__text {
  flex: 1;
  text-align: center;
  padding: 0 6px;
}
.kop__org {
  font-family: Arial Black, 'Arial Bold', Arial, sans-serif;
  font-size: 11pt;
  font-weight: 900;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  line-height: 1.25;
  color: #000;
}
.kop__school {
  font-family: Arial Black, 'Arial Bold', Arial, sans-serif;
  font-size: 16pt;
  font-weight: 900;
  text-transform: uppercase;
  letter-spacing: 1px;
  color: #1a1a6e;
  line-height: 1.2;
  margin-top: 1px;
}
.kop__address {
  font-family: Arial, sans-serif;
  font-size: 9pt;
  color: #000;
  margin-top: 3px;
}
.kop__email {
  font-family: Arial, sans-serif;
  font-size: 9pt;
  font-style: italic;
  color: #000;
  margin-top: 1px;
}

/* Garis kop: tebal + tipis (standar surat dinas) */
.kop-divider { margin: 8px 0 0 0; }
.kop-divider-thick { height: 3.5px; background: #1a1a6e; }
.kop-divider-thin  { height: 1px;   background: #1a1a6e; margin-top: 2px; }

/* ═══════════════════════════════════════════════════════════
   JUDUL DOKUMEN
═══════════════════════════════════════════════════════════ */
.doc-title-wrapper {
  text-align: center;
  margin: 18px 0 6px;
}
.doc-title {
  font-family: Arial Black, 'Arial Bold', Arial, sans-serif;
  font-size: 13pt;
  font-weight: 900;
  text-transform: uppercase;
  letter-spacing: 2px;
  text-decoration: underline;
  text-underline-offset: 4px;
  color: #000;
}
.doc-subtitle {
  font-family: Arial, sans-serif;
  font-size: 10pt;
  color: #444;
  margin-top: 4px;
}

/* ═══════════════════════════════════════════════════════════
   INFO KEGIATAN
═══════════════════════════════════════════════════════════ */
.doc-info {
  margin: 14px 0 16px 0;
  font-size: 10.5pt;
  color: #000;
  font-family: 'Times New Roman', Times, serif;
}
.doc-info table { border: none; width: auto; }
.doc-info td {
  border: none !important;
  padding: 2px 0;
  vertical-align: top;
  line-height: 1.5;
}
.doc-info td:first-child { min-width: 140px; }
.doc-info td:nth-child(2) { padding: 2px 8px; width: 12px; }

/* ═══════════════════════════════════════════════════════════
   TABEL ABSENSI
═══════════════════════════════════════════════════════════ */
.absensi-table {
  width: 100%;
  border-collapse: collapse;
  font-size: 10.5pt;
  margin-top: 4px;
  font-family: 'Times New Roman', Times, serif;
}

.absensi-table thead tr th {
  background: #1a1a6e;
  color: #fff;
  font-family: Arial, sans-serif;
  font-weight: 700;
  text-align: center;
  padding: 7px 10px;
  border: 1px solid #1a1a6e;
  font-size: 9.5pt;
  letter-spacing: 0.04em;
  text-transform: uppercase;
}
.absensi-table thead tr th.th-left { text-align: left; }

.absensi-table tbody tr td {
  border: 1px solid #aaa;
  padding: 6px 10px;
  vertical-align: middle;
  color: #000;
}
.absensi-table tbody tr:nth-child(even) td { background: #f5f6fb; }
.absensi-table tbody tr:nth-child(odd)  td { background: #fff; }

.td-no    { text-align: center; width: 36px; font-size: 10pt; }
.td-nia   { font-family: 'Courier New', Courier, monospace; font-size: 9.5pt; white-space: nowrap; }
.td-nama  { min-width: 160px; }
.td-kelas { text-align: center; white-space: nowrap; }
.td-ttd   { height: 40px; width: 130px; text-align: center; }
.td-empty { text-align: center; color: #888; padding: 28px; font-style: italic; font-family: Arial, sans-serif; }

/* ═══════════════════════════════════════════════════════════
   TANDA TANGAN
═══════════════════════════════════════════════════════════ */
.ttd-section {
  margin-top: 30px;
  display: flex;
  justify-content: space-between;
  align-items: flex-end;
  font-family: Arial, sans-serif;
  font-size: 10.5pt;
}

.ttd-kiri { text-align: center; }
.ttd-kiri p { margin: 0; line-height: 1.6; }
.ttd-kiri .ttd-space { height: 60px; }
.ttd-kiri .ttd-line {
  display: inline-block;
  min-width: 160px;
  border-top: 1px solid #000;
  padding-top: 4px;
  font-weight: 700;
  font-size: 10.5pt;
}
.ttd-kiri .ttd-sub {
  display: block;
  font-size: 9pt;
  color: #555;
  margin-top: 2px;
  font-style: italic;
}

.ttd-kanan { text-align: center; }
.ttd-kanan p { margin: 0; line-height: 1.6; }
.ttd-kanan .ttd-space { height: 60px; }
.ttd-kanan .ttd-line {
  display: inline-block;
  min-width: 180px;
  border-top: 1px solid #000;
  padding-top: 4px;
  font-weight: 700;
  font-size: 10.5pt;
}
.ttd-kanan .ttd-sub {
  display: block;
  font-size: 9pt;
  color: #555;
  margin-top: 2px;
  font-style: italic;
}

/* Total anggota */
.doc-total {
  margin-top: 10px;
  font-family: Arial, sans-serif;
  font-size: 9pt;
  color: #555;
  font-style: italic;
}

/* ═══════════════════════════════════════════════════════════
   PRINT  –  tanpa visibility hack
═══════════════════════════════════════════════════════════ */
@media print {
  @page {
    size: A4 portrait;
    margin: 18mm 20mm 22mm 25mm;
  }

  body { background: #fff !important; }

  /* Sembunyikan hanya filter bar */
  .ab-filterbar { display: none !important; }

  /* Reset page wrapper agar mengalir normal */
  .page-wrapper {
    box-shadow: none !important;
    margin: 0 !important;
    padding: 0 !important;
    max-width: 100% !important;
    min-height: auto !important;
  }

  /* Paksa warna latar ikut tercetak */
  * {
    -webkit-print-color-adjust: exact !important;
    print-color-adjust: exact !important;
  }
}
</style>

<!-- ═══════════════════════════════════════════════════════
     FILTER BAR
════════════════════════════════════════════════════════ -->
<div class="ab-filterbar">
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
    <button type="submit" class="ab-btn ab-btn-filter">Terapkan Filter</button>
    <button type="button" class="ab-btn ab-btn-print" onclick="window.print()">&#128438;&nbsp; Cetak</button>
  </form>
</div>

<!-- ═══════════════════════════════════════════════════════
     AREA CETAK  (A4 preview)
════════════════════════════════════════════════════════ -->
<div class="page-wrapper">

  <!-- ── KOP SURAT ─────────────────────────────────────── -->
  <div class="kop">

    <!-- Logo kiri: SMK Negeri 2 Pinrang -->
    <div class="kop__logo">
      <img src="<?= BASE_URL ?>/assets/img/logo.png?v=<?= filemtime($_SERVER['DOCUMENT_ROOT'] . '/assets/img/logo.png') ?: '1' ?>"
           alt="Logo SMK Negeri 2 Pinrang"
           onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
      <div class="kop__logo-fallback">S2P</div>
    </div>

    <!-- Teks tengah -->
    <div class="kop__text">
      <div class="kop__org"><?= $orgName ?></div>
      <div class="kop__school">SMK Negeri 2 Pinrang</div>
      <div class="kop__address">JL. Kesehatan, Kel. Salo, Kec. Wattang Sawitto, Kab. Pinrang</div>
      <div class="kop__email"><em>E-mail : comsmakda@gmail.com</em></div>
    </div>

    <!-- Logo kanan: COM -->
    <div class="kop__logo">
      <img src="<?= BASE_URL ?>/assets/img/logo-com.png?v=<?= filemtime($_SERVER['DOCUMENT_ROOT'] . '/assets/img/logo-com.png') ?: '1' ?>"
           alt="Logo <?= $orgName ?>"
           onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
      <div class="kop__logo-fallback">COM</div>
    </div>

  </div><!-- /.kop -->

  <!-- Garis kop: tebal + tipis -->
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
        <th style="width:36px;">No</th>
        <th class="th-left" style="width:110px;">NIA</th>
        <th class="th-left">Nama Lengkap</th>
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

  <!-- Total -->
  <p class="doc-total">Total: <?= count($records) ?> anggota terdaftar</p>

  <!-- ── TANDA TANGAN ───────────────────────────────────── -->
  <div class="ttd-section">

    <!-- Kiri: Pembina -->
    <div class="ttd-kiri">
      <p>Mengetahui,</p>
      <p>Pembina / Guru Pendamping</p>
      <div class="ttd-space"></div>
      <span class="ttd-line">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</span>
      <span class="ttd-sub">NIP. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
    </div>

    <!-- Kanan: Ketua Organisasi -->
    <div class="ttd-kanan">
      <p>Pinrang, <?= $today ?></p>
      <p>Ketua <?= $orgName ?>,</p>
      <div class="ttd-space"></div>
      <span class="ttd-line">(.......................................)</span>
      <span class="ttd-sub">NIA. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
    </div>

  </div><!-- /.ttd-section -->

</div><!-- /.page-wrapper -->