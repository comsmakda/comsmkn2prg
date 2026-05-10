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
$emailOrg     = htmlspecialchars($settings['contact_email']['value'] ?? '');
$alamatOrg    = htmlspecialchars($settings['org_address']['value'] ?? 'SMKN 2 Pinrang');
$namaOrangtua = htmlspecialchars($user['nama_orangtua'] ?? '');
$filenamePdf  = 'Surat_Pernyataan_' . str_replace(' ', '_', $user['nama_lengkap']) . '_' . date('Ymd') . '.pdf';
?>
<style>
  .sp-page { max-width: 960px; margin: 0 auto; }

  .sp-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 20px;
    gap: 16px;
    flex-wrap: wrap;
  }
  .sp-header__title h1 { font-size: 20px; font-weight: 700; color: var(--color-text-1); margin-bottom: 4px; letter-spacing: -0.3px; }
  .sp-header__title p  { font-size: 13px; color: var(--color-text-3); }
  .sp-header__actions  { display: flex; gap: 8px; flex-wrap: wrap; }

  .btn {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 9px 18px; border-radius: var(--radius-md);
    font-size: 13px; font-weight: 600; border: 1px solid transparent;
    cursor: pointer; font-family: inherit; transition: all 150ms ease;
    white-space: nowrap; text-decoration: none;
  }
  .btn svg { width: 14px; height: 14px; flex-shrink: 0; }
  .btn-primary { background: var(--color-accent); color: #fff; box-shadow: 0 0 18px var(--color-accent-glow); }
  .btn-primary:hover { filter: brightness(1.1); transform: translateY(-1px); }
  .btn-ghost { background: var(--color-surface-2); color: var(--color-text-2); border-color: var(--color-border-2); }
  .btn-ghost:hover { background: var(--color-surface-3); color: var(--color-text-1); }

  .sp-shell { background: var(--color-surface); border: 1px solid var(--color-border); border-radius: var(--radius-lg); overflow: hidden; }
  .sp-bar   { display: flex; align-items: center; justify-content: space-between; padding: 9px 16px; background: var(--color-surface-2); border-bottom: 1px solid var(--color-border); }
  .sp-bar__dots { display: flex; gap: 6px; }
  .sp-bar__dots span { width: 10px; height: 10px; border-radius: 50%; display: block; }
  .sp-bar__dots span:nth-child(1) { background: #ef4444; }
  .sp-bar__dots span:nth-child(2) { background: #f59e0b; }
  .sp-bar__dots span:nth-child(3) { background: #22c55e; }
  .sp-bar__label { font-size: 11.5px; color: var(--color-text-3); font-weight: 500; }
  .sp-scroll { overflow-x: auto; padding: 32px 24px; background: #94a3b8; }

  /* ══ SURAT A4 ══ */
  #surat-preview {
    width: 794px;
    min-height: 1123px;
    margin: 0 auto;
    background: #ffffff;
    box-shadow: 0 8px 48px rgba(0,0,0,0.35);
    padding: 48px 56px 56px;
    font-family: 'Times New Roman', Times, Georgia, serif;
    font-size: 12pt;
    line-height: 1.75;
    color: #111;
    position: relative;
    box-sizing: border-box;
  }
  #surat-preview::before {
    content: '';
    position: absolute;
    inset: 14px;
    border: 2px double #222;
    pointer-events: none;
    z-index: 0;
  }
  .surat-inner { position: relative; z-index: 1; }

  /* ── KOP — sesuai kop asli ── */
  .kop {
    display: flex;
    align-items: center;
    padding-bottom: 10px;
    border-bottom: 3.5px solid #111;
  }
  .kop-rule { border: none; border-top: 1px solid #111; margin: 3px 0 18px; }

  .kop__logo { flex-shrink: 0; display: flex; align-items: center; justify-content: center; }
  .kop__logo img { height: 84px; width: auto; max-width: 92px; object-fit: contain; display: block; }
  .kop__logo-fallback {
    width: 80px; height: 80px; border: 2px solid #111; border-radius: 50%;
    display: none; align-items: center; justify-content: center;
    font-size: 20px; font-weight: 900; font-family: Arial, sans-serif;
  }

  .kop__text { flex: 1; text-align: center; padding: 0 8px; }
  .kop__org {
    font-size: 14.5pt; font-weight: 900; text-transform: uppercase;
    font-family: Arial Black, Arial, sans-serif; letter-spacing: 1px; line-height: 1.2; color: #000;
  }
  .kop__school  { font-size: 11pt; font-family: Arial, sans-serif; font-weight: 700; color: #000; margin-top: 2px; }
  .kop__address { font-size: 9pt; font-family: Arial, sans-serif; color: #333; margin-top: 1px; }
  .kop__email   { font-size: 9pt; font-family: Arial, sans-serif; font-style: italic; color: #333; margin-top: 1px; }

  /* ── JUDUL ── */
  .surat-judul { text-align: center; margin: 20px 0 4px; }
  .surat-judul h2 {
    font-size: 13pt; font-weight: 900; text-transform: uppercase;
    letter-spacing: 2px; font-family: Arial, sans-serif;
    text-decoration: underline; text-underline-offset: 3px;
  }
  .surat-judul p { font-size: 10.5pt; font-family: Arial, sans-serif; color: #444; margin-top: 4px; }

  .surat-body p { text-align: justify; margin-bottom: 10px; font-size: 11.5pt; }

  .surat-section-title {
    font-family: Arial, sans-serif; font-weight: 700; font-size: 10.5pt;
    text-transform: uppercase; letter-spacing: 0.5px;
    margin: 16px 0 8px; padding-bottom: 3px; border-bottom: 1px solid #ccc; color: #111;
  }

  /* ── IDENTITAS + FOTO BERDAMPINGAN ── */
  .id-wrapper { display: flex; gap: 20px; align-items: flex-start; margin: 6px 0 14px; }
  .id-table { flex: 1; border-collapse: collapse; font-size: 11.5pt; }
  .id-table td { padding: 3px 0; vertical-align: top; }
  .id-table td:first-child { width: 150px; font-weight: 600; }
  .id-table td:nth-child(2) { width: 14px; padding: 3px 6px; }

  .id-foto { flex-shrink: 0; text-align: center; }
  .id-foto img { width: 84px; height: 106px; object-fit: cover; border: 1.5px solid #888; display: block; }
  .id-foto-placeholder {
    width: 84px; height: 106px; border: 1px dashed #bbb;
    display: flex; align-items: center; justify-content: center;
    font-size: 8pt; color: #bbb; font-family: Arial, sans-serif;
    text-align: center; line-height: 1.4; padding: 4px; box-sizing: border-box;
  }
  .id-foto span { display: block; font-size: 8pt; color: #777; font-family: Arial, sans-serif; margin-top: 4px; font-style: italic; }

  /* ── JADWAL ── */
  .jadwal-box { border: 1px solid #bbb; border-radius: 3px; margin: 10px 0 10px; overflow: hidden; }
  .jadwal-box__head {
    background: #1a1a1a; color: #fff; font-family: Arial, sans-serif;
    font-size: 9pt; font-weight: 700; text-transform: uppercase;
    letter-spacing: 1px; padding: 5px 14px;
  }
  .jadwal-row { display: flex; border-bottom: 1px solid #e5e5e5; }
  .jadwal-row:last-child { border-bottom: none; }
  .jadwal-row__day {
    width: 120px; flex-shrink: 0; padding: 6px 14px;
    font-weight: 700; font-family: Arial, sans-serif; font-size: 10.5pt;
    border-right: 1px solid #e5e5e5; background: #f8f8f8;
  }
  .jadwal-row__info { padding: 6px 14px; font-size: 10.5pt; color: #333; }

  /* ── PERNYATAAN ── */
  .pernyataan-list { margin: 8px 0 12px; padding-left: 0; list-style: none; font-size: 11.5pt; }
  .pernyataan-list li { display: flex; gap: 10px; margin-bottom: 6px; text-align: justify; line-height: 1.6; }
  .pernyataan-list li .num { flex-shrink: 0; width: 20px; font-weight: 700; font-family: Arial, sans-serif; }

  .surat-penutup { margin-top: 8px; font-size: 11.5pt; text-align: justify; }

  /* ── TTD 2 KOLOM ── */
  .ttd-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    margin-top: 28px;
    font-size: 11pt;
    font-family: Arial, sans-serif;
  }
  .ttd-col { text-align: center; }
  .ttd-col p { margin: 0; line-height: 1.5; font-size: 10.5pt; }
  .ttd-space { height: 80px; margin: 8px 0 6px; }
  .ttd-line {
    display: block; border-top: 1px solid #111; padding-top: 5px;
    font-weight: 700; font-size: 10.5pt; width: 220px; margin: 0 auto;
  }
  .ttd-sub { display: block; font-size: 9.5pt; color: #555; margin-top: 2px; }

  /* ── FOOTER ── */
  .surat-footer {
    margin-top: 24px; padding-top: 10px; border-top: 1px dashed #bbb;
    text-align: center; font-size: 8pt; color: #999; font-family: Arial, sans-serif;
  }

  @media print {
    body * { visibility: hidden; }
    #surat-preview, #surat-preview * { visibility: visible; }
    #surat-preview {
      position: absolute; inset: 0; box-shadow: none;
      width: 100%; padding: 18mm 22mm 22mm;
    }
    #surat-preview::before { display: none; }
    .sp-shell, .sp-bar, .sp-scroll, .sp-header { display: none !important; }
  }
  @media (max-width: 768px) {
    .sp-header { flex-direction: column; }
    .sp-header__actions { width: 100%; }
    .btn { flex: 1; justify-content: center; }
  }
  @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
</style>

<div class="sp-page">

  <div class="sp-header">
    <div class="sp-header__title">
      <h1>Surat Pernyataan &amp; Izin Orang Tua</h1>
      <p>Dokumen resmi keanggotaan &mdash; No: <?= $nomorSurat ?></p>
    </div>
    <div class="sp-header__actions">
      <button class="btn btn-ghost" onclick="window.print()">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.75 19.5m10.56-5.671.72.096m-.72-.096L17.25 19.5M9 10.5h.008v.008H9V10.5Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm4.125 0h.008v.008H13.5V10.5Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM6 7.5H4.875a1.875 1.875 0 0 0-1.875 1.875v6c0 1.036.84 1.875 1.875 1.875h14.25A1.875 1.875 0 0 0 21 15.375v-6A1.875 1.875 0 0 0 19.125 7.5H18M6 7.5V6a2.25 2.25 0 0 1 2.25-2.25h7.5A2.25 2.25 0 0 1 18 6v1.5m-12 0h12"/>
        </svg>
        Cetak
      </button>
      <button class="btn btn-primary" onclick="downloadPDF()">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"/>
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
      <div id="surat-preview">
        <div class="surat-inner">

          <!-- KOP -->
          <div class="kop">
            <div class="kop__logo">
              <img src="<?= BASE_URL ?>/assets/img/logo.png" alt="Logo SMKN 2 Pinrang"
                   onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
              <div class="kop__logo-fallback">S2</div>
            </div>
            <div class="kop__text">
              <div class="kop__org"><?= $orgName ?></div>
              <div class="kop__school"><?= $alamatOrg ?></div>
              <div class="kop__address">JL.Kesehatan, Kel.Salo, Kec. Wattang Sawitto, Kab. Pinrang</div>
              <?php if ($emailOrg): ?>
                <div class="kop__email">E-mail : <?= $emailOrg ?></div>
              <?php endif; ?>
            </div>
            <div class="kop__logo">
              <img src="<?= BASE_URL ?>/assets/img/logo-com.png" alt="Logo <?= $orgName ?>"
                   onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
              <div class="kop__logo-fallback"><?= mb_strtoupper(mb_substr(strip_tags($orgName), 0, 2)) ?></div>
            </div>
          </div>
          <hr class="kop-rule">

          <!-- JUDUL -->
          <div class="surat-judul">
            <h2>Surat Pernyataan dan Izin Orang Tua</h2>
            <p>Nomor: <?= $nomorSurat ?></p>
          </div>

          <!-- PEMBUKA -->
          <div class="surat-body" style="margin-top:16px;">
            <p>
              Surat ini dibuat sebagai bukti kesediaan dan persetujuan untuk bergabung
              serta aktif berpartisipasi dalam kegiatan <strong><?= $orgName ?></strong>, SMKN 2 Pinrang.
            </p>
          </div>

          <!-- A. IDENTITAS -->
          <div class="surat-section-title">A. Identitas Anggota</div>
          <div class="id-wrapper">
            <table class="id-table">
              <tbody>
                <tr><td>Nama Lengkap</td><td>:</td><td><?= $namaLengkap ?></td></tr>
                <tr><td>NIA</td><td>:</td><td><?= $nia ?></td></tr>
                <tr><td>Kelas</td><td>:</td><td><?= $kelas ?></td></tr>
                <tr><td>No. HP / WA</td><td>:</td><td><?= $noHp ?></td></tr>
                <tr><td>Tahun Bergabung</td><td>:</td><td><?= $tahunDaftar ?></td></tr>
              </tbody>
            </table>
            <div class="id-foto">
              <?php if ($fotoUrl): ?>
                <img src="<?= $fotoUrl ?>" alt="Foto <?= $namaLengkap ?>">
              <?php else: ?>
                <div class="id-foto-placeholder">Pas Foto<br>3&times;4</div>
              <?php endif; ?>
              <span>Foto Siswa</span>
            </div>
          </div>

          <!-- B. JADWAL -->
          <div class="surat-section-title">B. Jadwal Pertemuan Rutin</div>
          <div class="jadwal-box">
            <div class="jadwal-box__head">Jadwal Pertemuan &mdash; <?= $orgName ?></div>
            <div class="jadwal-row">
              <div class="jadwal-row__day">Kamis</div>
              <div class="jadwal-row__info">Setelah jam pelajaran selesai hingga pukul <strong>17.00 WITA</strong></div>
            </div>
            <div class="jadwal-row">
              <div class="jadwal-row__day">Jumat</div>
              <div class="jadwal-row__info">Setelah jam pelajaran selesai hingga pukul <strong>17.00 WITA</strong></div>
            </div>
          </div>
          <p style="font-size:9.5pt;color:#666;font-family:Arial,sans-serif;margin:0 0 14px;">
            * Jadwal dapat berubah sewaktu-waktu dan akan dikomunikasikan terlebih dahulu kepada anggota dan orang tua/wali.
          </p>

          <!-- C. PERNYATAAN ANGGOTA -->
          <div class="surat-section-title">C. Pernyataan Anggota</div>
          <div class="surat-body">
            <p>Saya yang bertanda tangan di bawah ini, <strong><?= $namaLengkap ?></strong>
               (NIA: <strong><?= $nia ?></strong>), dengan ini menyatakan bahwa:</p>
          </div>
          <ol class="pernyataan-list">
            <li><span class="num">1.</span><span>Saya adalah anggota resmi <strong><?= $orgName ?></strong> SMKN 2 Pinrang yang terdaftar dengan Nomor Induk Anggota (NIA) <strong><?= $nia ?></strong>.</span></li>
            <li><span class="num">2.</span><span>Saya bersedia mematuhi seluruh peraturan, tata tertib, dan kode etik organisasi yang berlaku.</span></li>
            <li><span class="num">3.</span><span>Saya bersedia hadir dan berpartisipasi aktif dalam setiap kegiatan dan pertemuan rutin yang diselenggarakan oleh <?= $orgName ?>.</span></li>
            <li><span class="num">4.</span><span>Seluruh data dan informasi yang tercantum dalam surat ini adalah benar. Apabila terdapat ketidaksesuaian, saya bersedia menerima sanksi sesuai ketentuan yang berlaku.</span></li>
          </ol>

          <!-- D. IZIN ORANG TUA -->
          <div class="surat-section-title">D. Pernyataan Izin Orang Tua / Wali</div>
          <div class="surat-body">
            <p>
              Saya selaku orang tua/wali dari <strong><?= $namaLengkap ?></strong>
              menyatakan memberikan izin kepada anak/wali kami untuk bergabung dan aktif mengikuti
              seluruh kegiatan <strong><?= $orgName ?></strong>, termasuk pertemuan rutin setiap hari
              <strong>Kamis</strong> dan <strong>Jumat</strong> hingga pukul <strong>17.00 WITA</strong>.
              Kami menyanggupi untuk memastikan kepulangan anak/wali kami dengan aman setelah kegiatan selesai.
            </p>
          </div>

          <!-- PENUTUP -->
          <div class="surat-penutup">
            <p>
              Demikian surat pernyataan dan izin ini dibuat dengan penuh kesadaran, kejujuran,
              dan tanpa paksaan dari pihak mana pun, untuk dipergunakan sebagaimana mestinya.
            </p>
          </div>

          <!-- TTD 2 KOLOM -->
          <div class="ttd-grid">

            <div class="ttd-col">
              <p>Orang Tua / Wali,</p>
              <div class="ttd-space"></div>
              <span class="ttd-line">
                (<?= $namaOrangtua ?: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ?>)
              </span>
              <span class="ttd-sub">Orang Tua / Wali</span>
            </div>

            <div class="ttd-col">
              <p>Pinrang, <?= $today ?></p>
              <p>Yang Menyatakan,</p>
              <div class="ttd-space"></div>
              <span class="ttd-line"><?= $namaLengkap ?></span>
              <span class="ttd-sub"><?= $nia ?></span>
            </div>

          </div>

          <!-- FOOTER -->
          <div class="surat-footer">
            Dicetak melalui Sistem Informasi <?= $orgName ?> &mdash; <?= date('d/m/Y H:i') ?>
            &nbsp;|&nbsp; Dokumen ini sah apabila diverifikasi melalui sistem.
          </div>

        </div>
      </div>
    </div>
  </div>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
        integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
function downloadPDF() {
  var btn = document.querySelector('.btn-primary');
  var orig = btn.innerHTML;
  btn.disabled = true;
  btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:14px;height:14px;animation:spin 1s linear infinite"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99"/></svg> Menyiapkan...';
  html2pdf()
    .set({
      margin     : [12, 12, 12, 12],
      filename   : '<?= $filenamePdf ?>',
      image      : { type: 'jpeg', quality: 0.98 },
      html2canvas: { scale: 2, useCORS: true, allowTaint: true, backgroundColor: '#ffffff' },
      jsPDF      : { unit: 'mm', format: 'a4', orientation: 'portrait' },
      pagebreak  : { mode: ['avoid-all', 'css', 'legacy'] }
    })
    .from(document.getElementById('surat-preview'))
    .save()
    .then(function () { btn.disabled = false; btn.innerHTML = orig; })
    .catch(function (e) { console.error(e); btn.disabled = false; btn.innerHTML = orig; });
}
</script>