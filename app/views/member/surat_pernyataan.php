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
   UI SHELL  (tidak ikut cetak)
═══════════════════════════════════════════════════════════ */
.sp-page { max-width: 980px; margin: 0 auto; }

.sp-header {
  display: flex; align-items: flex-start;
  justify-content: space-between;
  margin-bottom: 20px; gap: 16px; flex-wrap: wrap;
}
.sp-header__title h1 {
  font-size: 20px; font-weight: 700;
  color: var(--color-text-1); margin-bottom: 4px; letter-spacing: -0.3px;
}
.sp-header__title p { font-size: 13px; color: var(--color-text-3); }
.sp-header__actions { display: flex; gap: 8px; flex-wrap: wrap; }

.btn {
  display: inline-flex; align-items: center; gap: 7px;
  padding: 9px 18px; border-radius: var(--radius-md);
  font-size: 13px; font-weight: 600; border: 1px solid transparent;
  cursor: pointer; font-family: inherit; transition: all 150ms ease;
  white-space: nowrap; text-decoration: none;
}
.btn svg { width: 14px; height: 14px; flex-shrink: 0; }
.btn-primary {
  background: var(--color-accent); color: #fff;
  box-shadow: 0 0 18px var(--color-accent-glow);
}
.btn-primary:hover { filter: brightness(1.1); transform: translateY(-1px); }
.btn-ghost {
  background: var(--color-surface-2); color: var(--color-text-2);
  border-color: var(--color-border-2);
}
.btn-ghost:hover { background: var(--color-surface-3); color: var(--color-text-1); }

.sp-shell {
  background: var(--color-surface);
  border: 1px solid var(--color-border);
  border-radius: var(--radius-lg); overflow: hidden;
}
.sp-bar {
  display: flex; align-items: center; justify-content: space-between;
  padding: 9px 16px;
  background: var(--color-surface-2); border-bottom: 1px solid var(--color-border);
}
.sp-bar__dots { display: flex; gap: 6px; }
.sp-bar__dots span {
  width: 10px; height: 10px; border-radius: 50%; display: block;
}
.sp-bar__dots span:nth-child(1) { background: #ef4444; }
.sp-bar__dots span:nth-child(2) { background: #f59e0b; }
.sp-bar__dots span:nth-child(3) { background: #22c55e; }
.sp-bar__label { font-size: 11.5px; color: var(--color-text-3); font-weight: 500; }
.sp-scroll { overflow-x: auto; padding: 32px 24px; background: #7f8ea3; }

/* Tambahan: pastikan surat-inner punya padding saat print (bukan di preview) */
@media screen {
  #surat-preview { padding: 32px 48px 52px 48px; }
}
@media print {
  #surat-preview { padding: 0 !important; }
  .surat-inner   { padding: 0 !important; }
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
  box-shadow: 0 10px 56px rgba(0,0,0,0.4);
  padding: 32px 48px 52px 48px;
  font-family: 'Times New Roman', Times, Georgia, serif;
  font-size: 12pt;
  line-height: 1.6;
  color: #000;
  position: relative;
  box-sizing: border-box;
}

/* Bingkai hias dokumen resmi */
#surat-preview::before {
  content: '';
  position: absolute;
  inset: 10px;
  border: 1px solid #1a1a6e;
  pointer-events: none;
  z-index: 0;
}
#surat-preview::after {
  content: '';
  position: absolute;
  inset: 13px;
  border: 3px double #1a1a6e;
  pointer-events: none;
  z-index: 0;
}

.surat-inner { position: relative; z-index: 1; }

/* ── KOP SURAT ──────────────────────────────────────────── */
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

/* Garis kop tebal + tipis (standar surat dinas) */
.kop-divider { margin: 8px 0 0 0; }
.kop-divider-thick { height: 3.5px; background: #1a1a6e; }
.kop-divider-thin  { height: 1px;   background: #1a1a6e; margin-top: 2px; }

/* ── NOMOR SURAT ────────────────────────────────────────── */
.nomor-surat {
  text-align: center;
  font-family: Arial, sans-serif;
  font-size: 9pt;
  color: #333;
  margin: 6px 0 0 0;
}

/* ── JUDUL SURAT ────────────────────────────────────────── */
.surat-judul {
  text-align: center;
  margin: 20px 0 6px;
}
.surat-judul h2 {
  font-family: Arial Black, 'Arial Bold', Arial, sans-serif;
  font-size: 13pt;
  font-weight: 900;
  text-transform: uppercase;
  letter-spacing: 2px;
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
  margin-top: 16px;
  text-align: justify;
  hyphens: auto;
}
.surat-body p {
  font-size: 11.5pt;
  margin-bottom: 8px;
  text-align: justify;
  line-height: 1.75;
}

/* Indentasi paragraf seperti surat resmi */
.surat-body p.indent {
  text-indent: 2em;
}

/* ── JUDUL SEKSI ────────────────────────────────────────── */
.seksi-judul {
  font-family: Arial, sans-serif;
  font-weight: 700;
  font-size: 10.5pt;
  text-transform: uppercase;
  letter-spacing: 0.4px;
  margin: 18px 0 6px;
  padding: 4px 8px;
  background: #1a1a6e;
  color: #fff;
}

/* ── IDENTITAS + FOTO ───────────────────────────────────── */
.id-wrapper {
  display: flex;
  gap: 20px;
  align-items: flex-start;
  margin: 8px 0 12px;
}
.id-table {
  flex: 1;
  border-collapse: collapse;
  font-size: 11.5pt;
}
.id-table td {
  padding: 3.5px 0;
  vertical-align: top;
  line-height: 1.5;
}
.id-table td:first-child {
  width: 155px;
  font-weight: normal;
}
.id-table td:nth-child(2) {
  width: 18px;
  padding: 3.5px 6px;
  text-align: center;
}

.id-foto { flex-shrink: 0; text-align: center; }
.id-foto img {
  width: 86px;
  height: 108px;
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
  border-collapse: collapse;
  font-size: 11pt;
  margin: 8px 0 6px;
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
}
.jadwal-table tr:nth-child(even) td { background: #f5f6fb; }

.catatan-jadwal {
  font-family: Arial, sans-serif;
  font-size: 8.5pt;
  color: #555;
  font-style: italic;
  margin: 2px 0 14px;
}

/* ── DAFTAR PERNYATAAN ──────────────────────────────────── */
.pernyataan-list {
  margin: 8px 0 12px;
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
  margin-top: 30px;
  font-family: Arial, sans-serif;
  font-size: 10.5pt;
}
.ttd-col { text-align: center; }
.ttd-col p { margin: 0; line-height: 1.6; }
.ttd-space { height: 72px; }
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
  margin-top: 24px;
  padding-top: 8px;
  border-top: 1px dashed #bbb;
  text-align: center;
  font-size: 7.5pt;
  color: #888;
  font-family: Arial, sans-serif;
}

/* ═══════════════════════════════════════════════════════════
   PRINT  –  fixed blank-page bug
═══════════════════════════════════════════════════════════ */
@media print {
  @page {
    size: A4 portrait;
    margin: 15mm 18mm 18mm 20mm;
  }

  /* 1. Sembunyikan UI shell saja — JANGAN sembunyikan body */
  .sp-header { display: none !important; }
  .sp-bar    { display: none !important; }

  /* 2. Hilangkan chrome/background dari wrapper scroll */
  .sp-page  { max-width: 100% !important; margin: 0 !important; }
  .sp-shell { border: none !important; border-radius: 0 !important; box-shadow: none !important; }
  .sp-scroll {
    padding: 0 !important;
    background: #fff !important;
    overflow: visible !important;
  }

  /* 3. Reset surat preview agar mengalir normal */
  #surat-preview {
    width: 100% !important;
    min-height: auto !important;
    margin: 0 !important;
    padding: 0 !important;
    box-shadow: none !important;
  }

  /* 4. Hapus bingkai dekoratif (absolute positioning = masalah di print) */
  #surat-preview::before,
  #surat-preview::after { display: none !important; }

  /* 5. Paksa warna latar ikut tercetak */
  * {
    -webkit-print-color-adjust: exact !important;
    print-color-adjust: exact !important;
  }
}

@media (max-width: 768px) {
  .sp-header { flex-direction: column; }
  .sp-header__actions { width: 100%; }
  .btn { flex: 1; justify-content: center; }
}
</style>

<!-- ═══════════════════════════════════════════════════════
     UI SHELL
════════════════════════════════════════════════════════ -->
<div class="sp-page">

  <div class="sp-header">
    <div class="sp-header__title">
      <h1>Surat Pernyataan &amp; Izin Orang Tua</h1>
      <p>Dokumen resmi keanggotaan &mdash; No: <?= $nomorSurat ?></p>
    </div>
    <div class="sp-header__actions">
      <button class="btn btn-ghost" onclick="window.print()">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.75 19.5m10.56-5.671.72.096m-.72-.096L17.25 19.5M9 10.5h.008v.008H9V10.5Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm4.125 0h.008v.008H13.5V10.5Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM6 7.5H4.875a1.875 1.875 0 0 0-1.875 1.875v6c0 1.036.84 1.875 1.875 1.875h14.25A1.875 1.875 0 0 0 21 15.375v-6A1.875 1.875 0 0 0 19.125 7.5H18M6 7.5V6a2.25 2.25 0 0 1 2.25-2.25h7.5A2.25 2.25 0 0 1 18 6v1.5m-12 0h12"/>
        </svg>
        Cetak
      </button>
      <button class="btn btn-primary" onclick="downloadPDF()">
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

            <!-- Logo kiri: SMK Negeri 2 Pinrang -->
            <div class="kop__logo">
              <img src="<?= BASE_URL ?>/assets/img/logo.png"
                   alt="Logo SMK Negeri 2 Pinrang"
                   onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
              <div class="kop__logo-fallback">S2P</div>
            </div>

            <!-- Teks tengah -->
            <div class="kop__text">
              <div class="kop__org"><?= $orgName ?></div>
              <div class="kop__school">SMK Negeri 2 Pinrang</div>
              <div class="kop__address">JL. Kesehatan, Kel. Salo, Kec. Wattang Sawitto, Kab. Pinrang</div>
              <div class="kop__email"><em>E-mail : <?= $emailOrg ?></em></div>
            </div>

            <!-- Logo kanan: COM -->
            <div class="kop__logo">
              <img src="<?= BASE_URL ?>/assets/img/logo-com.png"
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

          <!-- Nomor surat di bawah garis kop -->
          <div class="nomor-surat">Nomor: <?= $nomorSurat ?></div>

          <!-- ── JUDUL SURAT ─────────────────────────────── -->
          <div class="surat-judul">
            <h2>Surat Pernyataan dan Izin Orang Tua</h2>
            <p class="sub">Keanggotaan <?= $orgName ?> &mdash; SMK Negeri 2 Pinrang</p>
          </div>

          <!-- ── PEMBUKA ──────────────────────────────────── -->
          <div class="surat-body" style="margin-top: 18px;">
            <p class="indent">
              Yang bertanda tangan di bawah ini, menerangkan bahwa surat ini dibuat
              sebagai bukti persetujuan resmi untuk bergabung dan aktif berpartisipasi
              dalam kegiatan <strong><?= $orgName ?></strong>, SMK Negeri 2 Pinrang,
              Kabupaten Pinrang, Provinsi Sulawesi Selatan.
            </p>
          </div>

          <!-- ── A. IDENTITAS ANGGOTA ──────────────────────── -->
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
                  <td>Nomor HP / WhatsApp</td>
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

            <!-- Foto 3×4 -->
            <div class="id-foto">
              <?php if ($fotoUrl): ?>
                <img src="<?= $fotoUrl ?>" alt="Foto <?= $namaLengkap ?>">
              <?php else: ?>
                <div class="id-foto-placeholder">Pas Foto<br>3 &times; 4</div>
              <?php endif; ?>
              <span class="id-foto-label">Foto Siswa</span>
            </div>
          </div>

          <!-- ── B. JADWAL PERTEMUAN ───────────────────────── -->
          <div class="seksi-judul">B.&nbsp;&nbsp;Jadwal Pertemuan Rutin</div>

          <table class="jadwal-table">
            <thead>
              <tr>
                <th style="width:140px;">Hari</th>
                <th>Waktu</th>
                <th>Tempat</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Kamis</td>
                <td>Setelah jam pelajaran &ndash; pukul <strong>17.00 WITA</strong></td>
                <td>Laboratorium Komputer SMKN 2 Pinrang</td>
              </tr>
              <tr>
                <td>Jumat</td>
                <td>Setelah jam pelajaran &ndash; pukul <strong>17.00 WITA</strong></td>
                <td>Laboratorium Komputer SMKN 2 Pinrang</td>
              </tr>
            </tbody>
          </table>
          <p class="catatan-jadwal">
            * Jadwal dapat berubah sewaktu-waktu dan akan dikomunikasikan terlebih dahulu kepada anggota dan orang tua/wali.
          </p>

          <!-- ── C. PERNYATAAN ANGGOTA ─────────────────────── -->
          <div class="seksi-judul">C.&nbsp;&nbsp;Pernyataan Anggota</div>

          <div class="surat-body">
            <p class="indent">
              Saya yang bertanda tangan di bawah ini, <strong><?= $namaLengkap ?></strong>
              (Nomor Induk Anggota: <strong><?= $nia ?></strong>),
              dengan ini menyatakan dengan sesungguhnya bahwa:
            </p>
          </div>

          <ol class="pernyataan-list">
            <li>
              <span class="num">1.</span>
              <span>
                Saya adalah anggota resmi <strong><?= $orgName ?></strong> SMK Negeri 2 Pinrang
                yang terdaftar dengan Nomor Induk Anggota (NIA) <strong><?= $nia ?></strong>.
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
                Saya bersedia hadir dan berpartisipasi aktif dalam setiap kegiatan
                serta pertemuan rutin yang diselenggarakan oleh <?= $orgName ?>.
              </span>
            </li>
            <li>
              <span class="num">4.</span>
              <span>
                Seluruh data dan informasi yang tercantum dalam surat ini adalah benar
                dan dapat dipertanggungjawabkan. Apabila terdapat ketidaksesuaian,
                saya bersedia menerima sanksi sesuai ketentuan yang berlaku.
              </span>
            </li>
          </ol>

          <!-- ── D. IZIN ORANG TUA / WALI ──────────────────── -->
          <div class="seksi-judul">D.&nbsp;&nbsp;Pernyataan Izin Orang Tua / Wali</div>

          <div class="surat-body">
            <p class="indent">
              Saya selaku orang tua/wali dari <strong><?= $namaLengkap ?></strong>
              menyatakan memberikan <strong>izin sepenuhnya</strong> kepada anak/wali kami
              untuk bergabung dan aktif mengikuti seluruh kegiatan
              <strong><?= $orgName ?></strong>, SMK Negeri 2 Pinrang,
              termasuk pertemuan rutin setiap hari <strong>Kamis</strong> dan
              <strong>Jumat</strong> hingga pukul <strong>17.00 WITA</strong>.
            </p>
            <p class="indent">
              Kami menyanggupi untuk memastikan kepulangan anak/wali kami dengan aman
              setelah kegiatan selesai, serta mendukung penuh partisipasi anak/wali kami
              dalam setiap program yang diselenggarakan oleh organisasi.
            </p>
          </div>

          <!-- ── PENUTUP ────────────────────────────────────── -->
          <div class="surat-body" style="margin-top:10px;">
            <p class="indent">
              Demikian surat pernyataan dan izin ini dibuat dengan penuh kesadaran,
              kejujuran, dan tanpa paksaan dari pihak mana pun, untuk dapat dipergunakan
              sebagaimana mestinya.
            </p>
          </div>

          <!-- ── TANDA TANGAN ───────────────────────────────── -->
          <div class="ttd-grid">

            <!-- Kiri: Orang Tua / Wali -->
            <div class="ttd-col">
              <p>Orang Tua / Wali,</p>
              <div class="ttd-space"></div>
              <span class="ttd-name-box">
                (<?= $namaOrangtua ?: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ?>)
              </span>
              <span class="ttd-sub">Orang Tua / Wali Murid</span>
            </div>

            <!-- Kanan: Anggota -->
            <div class="ttd-col">
              <p>Pinrang, <?= $today ?></p>
              <p style="margin-top:2px;">Yang Membuat Pernyataan,</p>
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

<!-- html2pdf CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
        integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
function downloadPDF() {
  var el   = document.getElementById('surat-preview');
  var btn  = document.querySelector('.btn-primary');
  var orig = btn.innerHTML;

  if (!el) { alert('Elemen surat tidak ditemukan.'); return; }

  btn.disabled = true;
  btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:14px;height:14px;animation:spin 1s linear infinite"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99"/></svg>&nbsp;Menyiapkan...';

  /* Sembunyikan bingkai dekoratif sementara agar tidak muncul di PDF */
  el.style.setProperty('--border-hide', 'none');

  var opt = {
    margin      : [10, 12, 10, 12],
    filename    : '<?= addslashes($filenamePdf) ?>',
    image       : { type: 'jpeg', quality: 0.97 },
    html2canvas : {
      scale           : 2,
      useCORS         : true,
      allowTaint      : true,
      backgroundColor : '#ffffff',
      logging         : false,
      removeContainer : true
    },
    jsPDF       : { unit: 'mm', format: 'a4', orientation: 'portrait' },
    pagebreak   : { mode: ['css', 'legacy'] }
  };

  html2pdf()
    .set(opt)
    .from(el)
    .save()
    .then(function () {
      btn.disabled = false;
      btn.innerHTML = orig;
    })
    .catch(function (e) {
      console.error('PDF error:', e);
      alert('Gagal membuat PDF. Gunakan tombol Cetak sebagai alternatif.');
      btn.disabled = false;
      btn.innerHTML = orig;
    });
}
</script>