<?php
// app/views/member/surat_pernyataan.php

$orgName      = htmlspecialchars($settings['org_name']['value'] ?? APP_NAME);
$months       = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',
                 7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'];
$today        = date('d') . ' ' . $months[(int)date('m')] . ' ' . date('Y');
$nomorSurat   = 'COM/SP/' . date('Y') . '/' . str_pad($user['id'], 4, '0', STR_PAD_LEFT);
$namaLengkap  = htmlspecialchars($user['nama_lengkap']);
$nia          = htmlspecialchars($user['nia']);
$kelas        = htmlspecialchars($user['kelas'] ?? '—');
$noHp         = htmlspecialchars($user['no_hp'] ?? '—');
$tahunDaftar  = htmlspecialchars($user['tahun_daftar'] ?? date('Y'));
$fotoUrl      = $user['foto'] ? (UPLOAD_URL . '/' . htmlspecialchars($user['foto'])) : null;
$emailOrg     = htmlspecialchars($settings['contact_email']['value'] ?? 'comsmakda@gmail.com');
$namaOrangtua = htmlspecialchars($user['nama_orangtua'] ?? '');
$filenamePdf  = 'Surat_Pernyataan_' . str_replace(' ', '_', $user['nama_lengkap']) . '_' . date('Ymd') . '.pdf';
?>

<style>
/* ═══════════════════════════════════════════════════════════
   UI SHELL — mengikuti design token halaman member lainnya
═══════════════════════════════════════════════════════════ */
.sp-page { max-width: 900px; margin: 0 auto; }

.sp-header {
  display: flex; align-items: flex-start;
  justify-content: space-between;
  margin-bottom: 18px; gap: 14px; flex-wrap: wrap;
}
.sp-header__title h1 {
  font-size: 18px; font-weight: 800;
  color: var(--c-ink); margin-bottom: 3px; letter-spacing: -0.3px;
}
.sp-header__title p { font-size: 12.5px; color: var(--c-muted); }
.sp-header__actions { display: flex; gap: 8px; flex-wrap: wrap; }

.btn {
  display: inline-flex; align-items: center; gap: 7px;
  padding: 9px 16px; border-radius: var(--radius-sm);
  font-size: 13px; font-weight: 700; border: 1px solid transparent;
  cursor: pointer; font-family: inherit; transition: background 150ms var(--ease),
  color 150ms var(--ease), border-color 150ms var(--ease), transform 120ms var(--ease-spring);
  white-space: nowrap; text-decoration: none;
}
.btn svg { width: 15px; height: 15px; flex-shrink: 0; }
.btn:active { transform: translateY(1px); }
.btn-primary {
  background: var(--c-primary); color: #fff;
}
.btn-primary:hover { background: var(--c-primary-dk); }
.btn-ghost {
  background: var(--c-white); color: var(--c-muted);
  border-color: var(--c-border);
}
.btn-ghost:hover { background: #f4f7fa; color: var(--c-ink); border-color: rgba(14,116,144,.25); }
.btn[disabled] { opacity: .6; cursor: not-allowed; }

.paper-select {
  padding: 9px 12px; border-radius: var(--radius-sm);
  font-size: 13px; font-weight: 600; font-family: inherit;
  border: 1px solid var(--c-border); background: var(--c-white);
  color: var(--c-ink); cursor: pointer;
}

.sp-shell {
  background: var(--c-white);
  border: 1px solid var(--c-border);
  border-radius: var(--radius-lg); overflow: hidden;
}
.sp-bar {
  display: flex; align-items: center; justify-content: space-between;
  padding: 9px 16px;
  background: #f4f7fa; border-bottom: 1px solid var(--c-border);
}
.sp-bar__dots { display: flex; gap: 6px; }
.sp-bar__dots span {
  width: 9px; height: 9px; border-radius: 50%; display: block; opacity: .55;
}
.sp-bar__dots span:nth-child(1) { background: var(--c-red-text); }
.sp-bar__dots span:nth-child(2) { background: var(--c-amber-icon); }
.sp-bar__dots span:nth-child(3) { background: var(--c-green-text); }
.sp-bar__label { font-size: 11.5px; color: var(--c-muted2); font-weight: 600; }
.sp-scroll {
  overflow-x: auto;
  padding: 24px;
  background: var(--c-page);
}

@keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }

/* ═══════════════════════════════════════════════════════════
   SURAT A4
═══════════════════════════════════════════════════════════ */
#surat-preview {
  width: 794px;
  min-height: 1123px;
  margin: 0 auto;
  background: #ffffff;
  box-shadow: 0 4px 20px rgba(15,23,42,.12), 0 1px 4px rgba(15,23,42,.08);
  padding: 30px 46px 46px 46px;
  font-family: 'Times New Roman', Times, Georgia, serif;
  font-size: 12pt;
  line-height: 1.6;
  color: #000;
  position: relative;
  box-sizing: border-box;
}

/* Catatan: bingkai dekoratif ganda yang tadinya di sini sudah DIHAPUS.
   Selain jadi sumber artefak render "miring/bergelombang" yang berulang
   di html2canvas, bingkai halaman semacam itu juga bukan konvensi surat
   resmi Indonesia — cukup kop + garis tebal-tipis di bawahnya (sudah ada
   di .kop-divider-thick/.kop-divider-thin). */

.surat-inner { position: relative; z-index: 1; }

/* ── KOP SURAT ──────────────────────────────────────────── */
.kop {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 14px;
  padding-bottom: 9px;
}

/* Logo TANPA bingkai/lingkaran — mengikuti konvensi kop surat resmi.
   Tinggi kedua logo disamakan (bukan lebarnya) supaya bobot visualnya
   tetap seimbang walau rasio/bentuk file logo aslinya berbeda. */
.kop__logo {
  flex-shrink: 0;
  width: 78px;
  height: 78px;
  display: flex;
  align-items: center;
  justify-content: center;
}
.kop__logo img {
  height: 78px;
  width: auto;
  max-width: 78px;
  object-fit: contain;
  display: block;
}
.kop__logo-fallback {
  width: 74px; height: 74px;
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
  padding: 0 4px;
  min-width: 0;
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
  font-size: 15.5pt;
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

.kop-divider { margin: 8px 0 0 0; }
.kop-divider-thick { height: 3.5px; background: #1a1a6e; }
.kop-divider-thin  { height: 1px;   background: #1a1a6e; margin-top: 2px; }

/* ── NOMOR SURAT & PERIHAL ───────────────────────────────
   Ditumpuk rata kiri (format surat resmi baku), bukan
   space-between, supaya tetap rapi walau teks Perihal panjang. */
.info-surat {
  font-family: Arial, sans-serif;
  font-size: 9.5pt;
  color: #222;
  margin: 10px 0 0 0;
}
.info-surat table { border-collapse: collapse; }
.info-surat td { padding: 1.5px 0; vertical-align: top; }
.info-surat td.label { width: 58px; white-space: nowrap; }
.info-surat td.colon { width: 12px; }

/* ── JUDUL SURAT ────────────────────────────────────────── */
.surat-judul {
  text-align: center;
  margin: 18px 0 4px;
}
.surat-judul h2 {
  font-family: Arial Black, 'Arial Bold', Arial, sans-serif;
  font-size: 13pt;
  font-weight: 900;
  text-transform: uppercase;
  letter-spacing: 1.5px;
  text-decoration: underline;
  text-underline-offset: 4px;
  color: #000;
  margin: 0;
}
.surat-judul .sub {
  font-family: Arial, sans-serif;
  font-size: 9.5pt;
  color: #444;
  margin-top: 3px;
}

/* ── TUBUH SURAT ────────────────────────────────────────── */
.surat-body {
  margin-top: 14px;
  text-align: justify;
  hyphens: auto;
}
.surat-body p {
  font-size: 11.5pt;
  margin-bottom: 8px;
  text-align: justify;
  line-height: 1.75;
  orphans: 3;
  widows: 3;
}
.surat-body p.indent { text-indent: 2em; }

/* ── JUDUL SEKSI ────────────────────────────────────────── */
.seksi-judul {
  font-family: Arial, sans-serif;
  font-weight: 700;
  font-size: 10.5pt;
  text-transform: uppercase;
  letter-spacing: 0.4px;
  margin: 16px 0 6px;
  padding: 4px 8px;
  background: #1a1a6e;
  color: #fff;
  break-after: avoid;
  page-break-after: avoid;
}

/* ── IDENTITAS + FOTO ───────────────────────────────────── */
.id-wrapper {
  display: flex;
  gap: 20px;
  align-items: center;
  justify-content: flex-start;
  margin: 6px 0 10px;
  break-inside: avoid;
  page-break-inside: avoid;
}
.id-table {
  flex: 1 1 auto;
  max-width: 480px;
  border-collapse: collapse;
  font-size: 11.5pt;
}
.id-foto {
  flex-shrink: 0;
  text-align: center;
  margin-left: 8px;
}
.id-table td {
  padding: 3.5px 0;
  vertical-align: top;
  line-height: 1.5;
}
.id-table td:first-child { width: 165px; font-weight: normal; }
.id-table td:nth-child(2) { width: 18px; padding: 3.5px 6px; text-align: center; }

.id-foto img {
  width: 86px; height: 108px;
  object-fit: cover;
  border: 1px solid #555;
  display: block;
}
.id-foto-placeholder {
  width: 86px; height: 108px;
  border: 1px dashed #999;
  display: flex; align-items: center; justify-content: center;
  font-size: 8.5pt; color: #aaa;
  font-family: Arial, sans-serif;
  text-align: center; line-height: 1.5;
  padding: 6px; box-sizing: border-box;
}
.id-foto-label {
  display: block;
  font-size: 8pt; color: #666;
  font-family: Arial, sans-serif;
  margin-top: 4px; font-style: italic;
  text-align: center;
}

/* ── JADWAL ─────────────────────────────────────────────── */
.jadwal-table {
  width: 100%;
  table-layout: fixed;
  border-collapse: collapse;
  font-size: 11pt;
  margin: 6px 0 4px;
  break-inside: avoid;
  page-break-inside: avoid;
}
.jadwal-table th {
  background: #1a1a6e;
  color: #fff;
  font-family: Arial, sans-serif;
  font-size: 9.5pt;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  padding: 6px 12px;
  text-align: left;
  border: 1px solid #1a1a6e;
}
.jadwal-table td {
  padding: 6px 12px;
  border: 1px solid #c0c0c0;
  font-size: 11pt;
  vertical-align: middle;
  color: #111;
  break-inside: avoid;
  page-break-inside: avoid;
}
.jadwal-table tr { break-inside: avoid; page-break-inside: avoid; }
.jadwal-table tr:nth-child(even) td { background: #f5f6fb; }

.catatan-jadwal {
  font-family: Arial, sans-serif;
  font-size: 8.5pt;
  color: #555;
  font-style: italic;
  margin: 2px 0 12px;
}

/* ── DAFTAR PERNYATAAN ──────────────────────────────────── */
.pernyataan-list {
  margin: 6px 0 10px;
  padding-left: 0;
  list-style: none;
  font-size: 11.5pt;
}
.pernyataan-list li {
  display: flex;
  gap: 10px;
  margin-bottom: 7px;
  text-align: justify;
  line-height: 1.7;
  break-inside: avoid;
  page-break-inside: avoid;
}
.pernyataan-list li .num {
  flex-shrink: 0;
  width: 22px;
  font-weight: 700;
  font-family: Arial, sans-serif;
}

/* ── TANDA TANGAN ───────────────────────────────────────── */
.ttd-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 24px;
  margin-top: 26px;
  font-family: Arial, sans-serif;
  font-size: 10.5pt;
  break-inside: avoid;
  page-break-inside: avoid;
}
.ttd-col { text-align: center; }
.ttd-col p { margin: 0; line-height: 1.6; }
/* Area judul (di atas garis tanda tangan) disamakan tingginya di kedua
   kolom — kolom kanan punya 2 baris teks ("Pinrang, tanggal" +
   "Yang Membuat Pernyataan,") sedangkan kolom kiri cuma 1 baris
   ("Orang Tua/Wali,"), jadi tanpa ini garis tanda tangannya jadi
   tidak sejajar/tidak balance. */
.ttd-heading {
  min-height: calc(1.6em * 2);
  display: flex;
  flex-direction: column;
  justify-content: flex-end;
}
.ttd-space { height: 60px; }
.ttd-name-box {
  display: inline-block;
  min-width: 200px;
  border-top: 1px solid #000;
  padding-top: 4px;
  font-weight: 700;
  font-size: 10.5pt;
  text-align: center;
}
.ttd-sub {
  display: block;
  font-size: 9pt;
  color: #555;
  margin-top: 2px;
  font-style: italic;
}

/* ── FOOTER DOKUMEN ─────────────────────────────────────── */
.surat-footer {
  margin-top: 22px;
  padding-top: 8px;
  border-top: 1px dashed #bbb;
  text-align: center;
  font-size: 7.5pt;
  color: #888;
  font-family: Arial, sans-serif;
  break-inside: avoid;
  page-break-inside: avoid;
}

/* Blok section A-D: judul + 1-2 baris pertama isinya jangan sampai
   sendirian di ujung halaman (hindari "orphan heading"). */
.seksi-block {
  break-inside: avoid-page;
}

/* ═══════════════════════════════════════════════════════════
   PRINT
═══════════════════════════════════════════════════════════ */
@media print {
  @page {
    size: A4 portrait;
    margin: 15mm 18mm 18mm 20mm;
  }
  .sp-header { display: none !important; }
  .sp-bar    { display: none !important; }
  .sp-page   { max-width: 100% !important; margin: 0 !important; }
  .sp-shell  { border: none !important; border-radius: 0 !important; box-shadow: none !important; }
  .sp-scroll {
    padding: 0 !important;
    background: #fff !important;
    overflow: visible !important;
  }
  #surat-preview {
    width: 100% !important;
    min-height: auto !important;
    margin: 0 !important;
    padding: 0 !important;
    box-shadow: none !important;
  }
  .kop, .ttd-grid, .id-wrapper, .jadwal-table, .pernyataan-list li, .surat-footer {
    break-inside: avoid !important;
    page-break-inside: avoid !important;
  }
  .seksi-judul { break-after: avoid !important; page-break-after: avoid !important; }
  * {
    -webkit-print-color-adjust: exact !important;
    print-color-adjust: exact !important;
  }
}

/* ═══════════════════════════════════════════════════════════
   RESPONSIF
═══════════════════════════════════════════════════════════ */
@media (max-width: 768px) {
  .sp-header { flex-direction: column; }
  .sp-header__actions { width: 100%; }
  .btn { flex: 1; justify-content: center; }
  .sp-scroll { padding: 14px; }
}
</style>

<!-- ═══════════════════════════════════════════════════════
     UI SHELL — konten ini dirender di dalam <main class="page-content">
     milik layout member (main_member.php), sehingga sidebar & topbar
     tetap tampil seperti halaman lain.
════════════════════════════════════════════════════════ -->
<div class="sp-page">

  <div class="sp-header">
    <div class="sp-header__title">
      <h1>Surat Pernyataan &amp; Izin Orang Tua</h1>
      <p>Dokumen resmi keanggotaan &mdash; Nomor: <?= $nomorSurat ?></p>
    </div>
    <div class="sp-header__actions">
      <select id="paperFormatSelect" class="paper-select" title="Ukuran kertas">
        <option value="a4">A4 (210 &times; 297 mm)</option>
        <option value="f4">F4 / Folio (215 &times; 330 mm)</option>
      </select>
      <button class="btn btn-ghost" type="button" onclick="printSurat()">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.75 19.5m10.56-5.671.72.096m-.72-.096L17.25 19.5M9 10.5h.008v.008H9V10.5Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm4.125 0h.008v.008H13.5V10.5Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM6 7.5H4.875a1.875 1.875 0 0 0-1.875 1.875v6c0 1.036.84 1.875 1.875 1.875h14.25A1.875 1.875 0 0 0 21 15.375v-6A1.875 1.875 0 0 0 19.125 7.5H18M6 7.5V6a2.25 2.25 0 0 1 2.25-2.25h7.5A2.25 2.25 0 0 1 18 6v1.5m-12 0h12"/>
        </svg>
        Cetak
      </button>
      <button class="btn btn-primary" type="button" onclick="downloadPDF()">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"/>
        </svg>
        Unduh PDF
      </button>
    </div>
  </div>

  <div class="sp-shell">
    <div class="sp-bar">
      <div class="sp-bar__dots"><span></span><span></span><span></span></div>
      <span class="sp-bar__label">Pratinjau Dokumen &mdash; A4 Portrait</span>
      <span></span>
    </div>

    <div class="sp-scroll">

      <!-- ══════════════════════════════════════════════════
           SURAT A4
      ═══════════════════════════════════════════════════ -->
      <div id="surat-preview">
        <div class="surat-inner">

          <!-- ── KOP SURAT ─────────────────────────────── -->
          <div class="kop">
            <div class="kop__logo">
              <img src="<?= BASE_URL ?>/assets/img/logo.png"
                   alt="Logo SMK Negeri 2 Pinrang"
                   onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
              <div class="kop__logo-fallback">S2P</div>
            </div>

            <div class="kop__text">
              <div class="kop__org"><?= $orgName ?></div>
              <div class="kop__school">SMK Negeri 2 Pinrang</div>
              <div class="kop__address">Jalan Kesehatan, Kelurahan Salo, Kecamatan Wattang Sawitto, Kabupaten Pinrang</div>
              <div class="kop__email">Surel: <?= $emailOrg ?></div>
            </div>

            <div class="kop__logo">
              <img src="<?= BASE_URL ?>/assets/img/logo-com.png"
                   alt="Logo <?= $orgName ?>"
                   onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
              <div class="kop__logo-fallback">COM</div>
            </div>
          </div><!-- /.kop -->

          <div class="kop-divider">
            <div class="kop-divider-thick"></div>
            <div class="kop-divider-thin"></div>
          </div>

          <!-- Nomor & Perihal ditumpuk rata kiri (format surat resmi) -->
          <div class="info-surat">
            <table>
              <tr>
                <td class="label">Nomor</td>
                <td class="colon">:</td>
                <td><?= $nomorSurat ?></td>
              </tr>
              <tr>
                <td class="label">Perihal</td>
                <td class="colon">:</td>
                <td>Pernyataan Keanggotaan dan Izin Orang Tua</td>
              </tr>
            </table>
          </div>

          <!-- ── JUDUL SURAT ─────────────────────────────── -->
          <div class="surat-judul">
            <h2>Surat Pernyataan dan Izin Orang Tua</h2>
            <p class="sub">Keanggotaan <?= $orgName ?> &mdash; SMK Negeri 2 Pinrang</p>
          </div>

          <!-- ── PEMBUKA ──────────────────────────────────── -->
          <div class="surat-body" style="margin-top: 16px;">
            <p class="indent">
              Yang bertanda tangan di bawah ini, dengan menyadari sepenuhnya makna dan
              konsekuensi dari pernyataan ini, menyatakan hal-hal sebagai berikut sehubungan
              dengan keikutsertaan sebagai anggota <strong><?= $orgName ?></strong>
              SMK Negeri 2 Pinrang, Kabupaten Pinrang, Provinsi Sulawesi Selatan.
            </p>
          </div>

          <!-- ── A. IDENTITAS ANGGOTA ──────────────────────── -->
          <div class="seksi-block">
            <div class="seksi-judul">A.&nbsp;&nbsp;Identitas Anggota</div>

            <div class="id-wrapper">
              <table class="id-table">
                <tbody>
                  <tr>
                    <td>Nama Lengkap</td>
                    <td>:</td>
                    <td><?= $namaLengkap ?></td>
                  </tr>
                  <tr>
                    <td>Nomor Induk Anggota</td>
                    <td>:</td>
                    <td><?= $nia ?></td>
                  </tr>
                  <tr>
                    <td>Kelas</td>
                    <td>:</td>
                    <td><?= $kelas ?></td>
                  </tr>
                  <tr>
                    <td>Nomor Wa</td>
                    <td>:</td>
                    <td><?= $noHp ?></td>
                  </tr>
                  <tr>
                    <td>Tahun Bergabung</td>
                    <td>:</td>
                    <td><?= $tahunDaftar ?></td>
                  </tr>
                </tbody>
              </table>

              <div class="id-foto">
                <?php if ($fotoUrl): ?>
                  <img src="<?= $fotoUrl ?>" alt="Foto <?= $namaLengkap ?>">
                <?php else: ?>
                  <div class="id-foto-placeholder">Pas Foto<br>3 &times; 4</div>
                <?php endif; ?>
                <span class="id-foto-label">Foto Siswa</span>
              </div>
            </div>
          </div>

          <!-- ── B. JADWAL PERTEMUAN ───────────────────────── -->
          <div class="seksi-block">
            <div class="seksi-judul">B.&nbsp;&nbsp;Jadwal Pertemuan Rutin</div>

            <table class="jadwal-table">
              <thead>
                <tr>
                  <th style="width:18%;">Hari</th>
                  <th style="width:52%;">Waktu</th>
                  <th style="width:30%;">Tempat</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Kamis</td>
                  <td>Pukul 15.30 WITA, setelah jam pelajaran berakhir sampai dengan Pukul 17.00 WITA</td>
                  <td>Laboratorium Komputer SMK Negeri 2 Pinrang</td>
                </tr>
                <tr>
                  <td>Jumat</td>
                  <td>Pukul 14.30 WITA, setelah jam pelajaran berakhir sampai dengan Pukul 17.00 WITA</td>
                  <td>Laboratorium Komputer SMK Negeri 2 Pinrang</td>
                </tr>
              </tbody>
            </table>
            <p class="catatan-jadwal">
              Catatan: Jadwal dapat berubah sewaktu-waktu dan akan dikomunikasikan terlebih
              dahulu kepada anggota beserta orang tua/wali.
            </p>
          </div>

          <!-- ── C. PERNYATAAN ANGGOTA ─────────────────────── -->
          <div class="seksi-block">
            <div class="seksi-judul">C.&nbsp;&nbsp;Pernyataan Anggota</div>

            <div class="surat-body">
              <p class="indent">
                Berdasarkan identitas tersebut di atas, saya menyatakan dengan sesungguhnya
                bahwa:
              </p>
            </div>

            <ol class="pernyataan-list">
              <li>
                <span class="num">1.</span>
                <span>
                  Saya merupakan anggota resmi <strong><?= $orgName ?></strong> SMK Negeri 2
                  Pinrang yang terdaftar dengan Nomor Induk Anggota (NIA) <strong><?= $nia ?></strong>.
                </span>
              </li>
              <li>
                <span class="num">2.</span>
                <span>
                  Saya bersedia mematuhi seluruh peraturan, tata tertib, dan kode etik
                  organisasi yang berlaku selama menjadi anggota <?= $orgName ?>.
                </span>
              </li>
              <li>
                <span class="num">3.</span>
                <span>
                  Saya bersedia hadir dan berpartisipasi aktif dalam setiap kegiatan dan
                  pertemuan rutin yang diselenggarakan oleh <?= $orgName ?>.
                </span>
              </li>
              <li>
                <span class="num">4.</span>
                <span>
                  Seluruh data dan informasi yang tercantum dalam surat ini adalah benar dan
                  dapat dipertanggungjawabkan. Apabila di kemudian hari terdapat
                  ketidaksesuaian, saya bersedia menerima sanksi sesuai dengan ketentuan yang
                  berlaku.
                </span>
              </li>
            </ol>
          </div>

          <!-- ── D. IZIN ORANG TUA / WALI ──────────────────── -->
          <div class="seksi-block">
            <div class="seksi-judul">D.&nbsp;&nbsp;Pernyataan Izin Orang Tua/Wali</div>

            <div class="surat-body">
              <p class="indent">
                Saya yang bertindak selaku orang tua/wali dari <strong><?= $namaLengkap ?></strong>
                dengan ini menyatakan memberikan izin sepenuhnya kepada anak/wali kami untuk
                bergabung dan mengikuti seluruh kegiatan <strong><?= $orgName ?></strong>
                SMK Negeri 2 Pinrang, termasuk pertemuan rutin setiap hari <strong>Kamis</strong>
                dan <strong>Jumat</strong> hingga pukul <strong>17.00 WITA</strong>.
              </p>
              <p class="indent">
                Kami menyanggupi untuk memastikan kepulangan anak/wali kami dengan aman
                setelah kegiatan selesai, serta mendukung penuh partisipasi anak/wali kami
                dalam setiap program yang diselenggarakan oleh organisasi tersebut.
              </p>
            </div>
          </div>

          <!-- ── PENUTUP ────────────────────────────────────── -->
          <div class="surat-body" style="margin-top:8px;">
            <p class="indent">
              Demikian surat pernyataan dan izin ini dibuat dengan sadar, jujur, dan tanpa
              paksaan dari pihak mana pun, untuk dapat dipergunakan sebagaimana mestinya.
            </p>
          </div>

          <!-- ── TANDA TANGAN ───────────────────────────────── -->
          <div class="ttd-grid">
            <div class="ttd-col">
              <div class="ttd-heading">
                <p>Orang Tua/Wali,</p>
              </div>
              <div class="ttd-space"></div>
              <span class="ttd-name-box">
                <?= $namaOrangtua ?: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ?>
              </span>
              <span class="ttd-sub">Orang Tua/Wali Murid</span>
            </div>

            <div class="ttd-col">
              <div class="ttd-heading">
                <p>Pinrang, <?= $today ?></p>
                <p style="margin-top:2px;">Yang Membuat Pernyataan,</p>
              </div>
              <div class="ttd-space"></div>
              <span class="ttd-name-box"><?= $namaLengkap ?></span>
              <span class="ttd-sub">NIA: <?= $nia ?></span>
            </div>
          </div><!-- /.ttd-grid -->

          <!-- ── FOOTER ─────────────────────────────────────── -->
          <div class="surat-footer">
            Dicetak melalui Sistem Informasi <?= $orgName ?> &mdash; <?= date('d/m/Y H:i') ?>
            &nbsp;&bull;&nbsp;
            Dokumen ini sah apabila telah diverifikasi melalui sistem.
          </div>

        </div><!-- /.surat-inner -->
      </div><!-- /#surat-preview -->

    </div><!-- /.sp-scroll -->
  </div><!-- /.sp-shell -->

</div><!-- /.sp-page -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
function getPaperFormat() {
  var sel = document.getElementById('paperFormatSelect');
  return sel ? sel.value : 'a4';
}

// @page CSS bersifat statis, jadi untuk mendukung 2 ukuran kertas (A4/F4)
// dari satu tombol Cetak, ukurannya disuntikkan lewat <style> sesaat
// sebelum window.print() dipanggil.
function printSurat() {
  var fmt  = getPaperFormat();
  var size = fmt === 'f4' ? '215mm 330mm' : 'A4 portrait';
  var el   = document.getElementById('dynamic-page-size');
  if (!el) {
    el = document.createElement('style');
    el.id = 'dynamic-page-size';
    document.head.appendChild(el);
  }
  el.textContent = '@media print { @page { size: ' + size + '; margin: 15mm 18mm 18mm 20mm; } }';
  window.print();
}

async function downloadPDF() {
  var el      = document.getElementById('surat-preview');
  var scroll  = document.querySelector('.sp-scroll');
  var btn     = document.querySelector('.btn-primary');
  var orig    = btn.innerHTML;

  if (!el) { alert('Elemen surat tidak ditemukan.'); return; }

  // CATATAN PENTING (setelah 2x percobaan gagal):
  // html2pdf.js versi 0.10.1 (yang dipakai di sini lewat CDN) punya bug
  // yang sudah dikonfirmasi resmi oleh pembuatnya sendiri di GitHub —
  // logika auto-fit "gambar ke halaman PDF" miliknya sering salah
  // hitung skala saat dikombinasikan dengan html2canvas scale > 1,
  // sehingga hasil render jadi lebih lebar dari halaman dan
  // terpotong di kiri/kanan secara tidak konsisten (persis gejala yang
  // dilaporkan). Karena itu, fungsi ini TIDAK lagi memakai html2pdf()
  // sama sekali untuk proses render — hanya memakai html2canvas dan
  // jsPDF (dua library yang ikut ter-bundle di file yang sama) secara
  // langsung, dengan lebar gambar dikunci manual = lebar halaman PDF.
  // Ini menghilangkan sumber bug di atas sepenuhnya.
  if (typeof html2canvas === 'undefined') {
    alert('Gagal memuat pustaka PDF. Periksa koneksi internet Anda, lalu muat ulang halaman.');
    return;
  }
  var JsPDFCtor = (window.jspdf && window.jspdf.jsPDF) || window.jsPDF;
  if (!JsPDFCtor) {
    alert('Gagal memuat pustaka PDF. Periksa koneksi internet Anda, lalu muat ulang halaman.');
    return;
  }

  // Reset posisi scroll horizontal sebelum capture (jaga-jaga di layar sempit).
  if (scroll) scroll.scrollLeft = 0;
  window.scrollTo(0, 0);

  btn.disabled = true;
  btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:14px;height:14px;animation:spin 1s linear infinite"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99"/></svg>&nbsp;Menyiapkan...';

  var fmt         = getPaperFormat();
  var jsPDFFormat = fmt === 'f4' ? [215, 330] : 'a4';

  try {
    var canvas = await html2canvas(el, {
      scale           : 2,
      useCORS         : true,
      allowTaint      : true,
      backgroundColor : '#ffffff',
      logging         : false,
      scrollX         : 0,
      scrollY         : 0,
      windowWidth     : el.scrollWidth,
      windowHeight    : el.scrollHeight
    });

    var pdf = new JsPDFCtor({ unit: 'mm', format: jsPDFFormat, orientation: 'portrait' });
    var pageWidthMM  = pdf.internal.pageSize.getWidth
      ? pdf.internal.pageSize.getWidth()
      : pdf.internal.pageSize.width;
    var pageHeightMM = pdf.internal.pageSize.getHeight
      ? pdf.internal.pageSize.getHeight()
      : pdf.internal.pageSize.height;

    // Kunci lebar gambar PERSIS selebar halaman (tanpa margin tambahan
    // dari jsPDF — margin visual surat sudah ada di padding CSS
    // #surat-preview dan ikut ter-capture). Tinggi dihitung proporsional
    // dari rasio canvas asli, lalu dipotong per halaman sesuai tinggi
    // halaman kertas.
    var imgWidthMM  = pageWidthMM;
    var imgHeightMM = canvas.height * (imgWidthMM / canvas.width);
    var imgData     = canvas.toDataURL('image/png');

    var heightLeftMM = imgHeightMM;
    var positionMM   = 0;

    pdf.addImage(imgData, 'PNG', 0, positionMM, imgWidthMM, imgHeightMM);
    heightLeftMM -= pageHeightMM;

    while (heightLeftMM > 0) {
      positionMM = heightLeftMM - imgHeightMM;
      pdf.addPage();
      pdf.addImage(imgData, 'PNG', 0, positionMM, imgWidthMM, imgHeightMM);
      heightLeftMM -= pageHeightMM;
    }

    pdf.save('<?= addslashes($filenamePdf) ?>');
  } catch (e) {
    console.error('PDF error:', e);
    alert('Gagal membuat PDF. Gunakan tombol Cetak sebagai alternatif.');
  } finally {
    btn.disabled = false;
    btn.innerHTML = orig;
  }
}
</script>