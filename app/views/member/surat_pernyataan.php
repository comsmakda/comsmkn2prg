<?php
// app/views/member/surat_pernyataan.php

$orgName = htmlspecialchars($settings['org_name']['value'] ?? APP_NAME);
$today   = date('d') . ' ' . [
  1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',
  7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'
][(int)date('m')] . ' ' . date('Y');

$nomorSurat = 'COM/SP/' . date('Y') . '/' . str_pad($user['id'], 4, '0', STR_PAD_LEFT);
$namaLengkap = htmlspecialchars($user['nama_lengkap']);
$nia         = htmlspecialchars($user['nia']);
$kelas       = htmlspecialchars($user['kelas'] ?? '—');
$noHp        = htmlspecialchars($user['no_hp'] ?? '—');
$tahunDaftar = htmlspecialchars($user['tahun_daftar'] ?? date('Y'));
$fotoUrl     = $user['foto'] ? (UPLOAD_URL . '/' . htmlspecialchars($user['foto'])) : null;
$emailOrg    = htmlspecialchars($settings['contact_email']['value'] ?? '');
$alamatOrg   = htmlspecialchars($settings['org_address']['value'] ?? 'SMKN 2 Pinrang');
?>

<style>
  /* ── Page wrapper ── */
  .sp-page {
    max-width : 900px;
    margin    : 0 auto;
  }

  /* ── Page header ── */
  .sp-header {
    display        : flex;
    align-items    : center;
    justify-content: space-between;
    margin-bottom  : 24px;
    gap            : 12px;
    flex-wrap      : wrap;
  }

  .sp-header__title h1 {
    font-size    : 22px;
    font-weight  : 700;
    color        : var(--color-text-1);
    letter-spacing: -0.4px;
    line-height  : 1.2;
    margin-bottom: 4px;
  }

  .sp-header__title p {
    font-size: 13px;
    color    : var(--color-text-2);
  }

  .sp-header__actions {
    display: flex;
    gap    : 10px;
  }

  /* Buttons */
  .btn {
    display       : inline-flex;
    align-items   : center;
    gap           : 7px;
    padding       : 9px 16px;
    border-radius : var(--radius-md);
    font-size     : 13.5px;
    font-weight   : 600;
    border        : 1px solid transparent;
    cursor        : pointer;
    font-family   : inherit;
    transition    : all 160ms var(--ease);
    white-space   : nowrap;
    text-decoration: none;
  }
  .btn svg { width: 15px; height: 15px; flex-shrink: 0; }

  .btn-primary {
    background: var(--color-accent);
    color     : #fff;
    box-shadow: 0 0 20px var(--color-accent-glow);
  }
  .btn-primary:hover {
    background: var(--color-accent-light);
    box-shadow: 0 0 28px var(--color-accent-glow);
    transform : translateY(-1px);
  }

  .btn-ghost {
    background  : var(--color-surface-2);
    color       : var(--color-text-2);
    border-color: var(--color-border-2);
  }
  .btn-ghost:hover {
    background  : var(--color-surface-3);
    color       : var(--color-text-1);
    border-color: var(--color-border-3);
  }

  /* ── Preview shell ── */
  .sp-preview-shell {
    background   : var(--color-surface);
    border       : 1px solid var(--color-border);
    border-radius: var(--radius-lg);
    overflow     : hidden;
  }

  .sp-preview-bar {
    display        : flex;
    align-items    : center;
    justify-content: space-between;
    padding        : 10px 16px;
    border-bottom  : 1px solid var(--color-border);
    background     : var(--color-surface-2);
    gap            : 10px;
  }

  .sp-preview-bar__dots {
    display: flex;
    gap    : 6px;
  }
  .sp-preview-bar__dots span {
    width        : 10px;
    height       : 10px;
    border-radius: 50%;
    display      : block;
  }
  .sp-preview-bar__dots span:nth-child(1) { background: #ef4444; }
  .sp-preview-bar__dots span:nth-child(2) { background: #f59e0b; }
  .sp-preview-bar__dots span:nth-child(3) { background: #22c55e; }

  .sp-preview-bar__label {
    font-size  : 12px;
    color      : var(--color-text-3);
    font-weight: 500;
  }

  .sp-preview-scroll {
    overflow-x: auto;
    padding   : 28px 20px;
    background: #cbd5e1;
  }

  /* ── The actual letter ── */
  #surat-preview {
    width     : 794px;  /* A4 at 96dpi */
    min-height: 1123px;
    margin    : 0 auto;
    background: #ffffff;
    box-shadow: 0 4px 40px rgba(0,0,0,0.25);
    padding   : 56px 64px 64px;
    font-family: 'Times New Roman', Times, Georgia, serif;
    font-size : 13.5pt;
    line-height: 1.7;
    color     : #1a1a1a;
    position  : relative;
  }

  /* Page border decoration */
  #surat-preview::before {
    content : '';
    position: absolute;
    inset   : 18px;
    border  : 1px solid #c8c8c8;
    pointer-events: none;
  }

  /* KOP SURAT */
  .kop {
    display        : flex;
    align-items    : center;
    gap            : 20px;
    padding-bottom : 14px;
    border-bottom  : 3px double #1a1a1a;
    margin-bottom  : 24px;
  }

  .kop__logo {
    flex-shrink: 0;
  }
  .kop__logo img {
    height    : 72px;
    width     : auto;
    max-width : 80px;
    object-fit: contain;
  }
  .kop__logo-fallback {
    width          : 70px;
    height         : 70px;
    border         : 2px solid #1a1a1a;
    border-radius  : 50%;
    display        : flex;
    align-items    : center;
    justify-content: center;
    font-size      : 22px;
    font-weight    : 900;
    color          : #1a1a1a;
    font-family    : Arial, sans-serif;
    letter-spacing : -1px;
  }

  .kop__text {
    flex      : 1;
    text-align: center;
  }
  .kop__org {
    font-size    : 20pt;
    font-weight  : 900;
    letter-spacing: 2px;
    text-transform: uppercase;
    line-height  : 1.15;
    font-family  : Arial, sans-serif;
  }
  .kop__school {
    font-size  : 10.5pt;
    margin-top : 3px;
    color      : #333;
  }
  .kop__address {
    font-size  : 9.5pt;
    color      : #555;
    margin-top : 1px;
  }

  /* JUDUL */
  .surat-title {
    text-align     : center;
    margin         : 28px 0 6px;
  }
  .surat-title h2 {
    font-size     : 14pt;
    font-weight   : 900;
    text-decoration: underline;
    text-transform: uppercase;
    letter-spacing: 1px;
    font-family   : Arial, sans-serif;
  }
  .surat-nomor {
    text-align : center;
    font-size  : 11pt;
    color      : #444;
    margin-bottom: 28px;
  }

  /* BODY */
  .surat-body p {
    text-align: justify;
    margin-bottom: 12px;
    font-size : 12pt;
  }
  .surat-body strong {
    font-weight: 700;
  }

  /* IDENTITY TABLE */
  .identity-table {
    width        : 100%;
    border-collapse: collapse;
    margin       : 14px 0 20px 24px;
    font-size    : 12pt;
  }
  .identity-table td {
    padding   : 3px 0;
    vertical-align: top;
  }
  .identity-table td:first-child {
    width      : 160px;
    font-weight: 600;
    color      : #1a1a1a;
  }
  .identity-table td:nth-child(2) {
    width  : 16px;
    padding: 3px 8px;
    font-weight: 700;
  }
  .identity-table td:last-child {
    color: #1a1a1a;
  }

  /* TTD */
  .surat-ttd {
    display        : flex;
    justify-content: space-between;
    margin-top     : 40px;
    font-size      : 12pt;
  }

  .ttd-block {
    text-align: center;
    min-width : 180px;
  }

  .ttd-block__space {
    height         : 80px;
    display        : flex;
    align-items    : center;
    justify-content: center;
    margin         : 6px 0;
  }

  .ttd-block__space img {
    max-height: 70px;
    max-width : 60px;
    object-fit: cover;
    border    : 1px solid #aaa;
  }

  .ttd-block__line {
    display        : block;
    border-top     : 1px solid #1a1a1a;
    padding-top    : 4px;
    font-weight    : 700;
    font-size      : 11.5pt;
    min-width      : 200px;
  }

  .ttd-block__sub {
    font-size: 10pt;
    color    : #555;
  }

  /* FOOTER */
  .surat-footer {
    margin-top    : 36px;
    padding-top   : 10px;
    border-top    : 1px dashed #aaa;
    text-align    : center;
    font-size     : 8.5pt;
    color         : #888;
    font-family   : Arial, sans-serif;
  }

  /* ── Print styles ── */
  @media print {
    body * { visibility: hidden; }
    #surat-preview, #surat-preview * { visibility: visible; }
    #surat-preview {
      position  : absolute;
      inset     : 0;
      box-shadow: none;
      width     : 100%;
      padding   : 20mm 24mm 24mm;
      font-size : 12pt;
    }
    #surat-preview::before { display: none; }
    .sp-preview-shell,
    .sp-preview-scroll,
    .sp-preview-bar,
    .sp-header { display: none; }
  }

  @media (max-width: 768px) {
    .sp-header {
      flex-direction: column;
      align-items   : flex-start;
    }
    .sp-header__actions { width: 100%; }
    .btn { flex: 1; justify-content: center; }
  }
</style>

<div class="sp-page">

  <!-- Page header -->
  <div class="sp-header">
    <div class="sp-header__title">
      <h1>Surat Pernyataan Anggota</h1>
      <p>Pratinjau surat resmi keanggotaan Anda &mdash; No: <?= $nomorSurat ?></p>
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

  <!-- Preview shell (browser-like chrome) -->
  <div class="sp-preview-shell">
    <div class="sp-preview-bar">
      <div class="sp-preview-bar__dots">
        <span></span><span></span><span></span>
      </div>
      <span class="sp-preview-bar__label">Pratinjau Dokumen &mdash; A4</span>
      <span></span>
    </div>

    <div class="sp-preview-scroll">
      <!-- ════════════════════════════════════════
           THE ACTUAL LETTER  (id="surat-preview")
           ════════════════════════════════════════ -->
      <div id="surat-preview">

        <!-- KOP SURAT -->
        <div class="kop">
          <div class="kop__logo">
            <img src="<?= BASE_URL ?>/assets/img/logo-com.png"
                 alt="Logo <?= $orgName ?>"
                 onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
            <div class="kop__logo-fallback" style="display:none">
              <?= mb_strtoupper(mb_substr(strip_tags($orgName), 0, 2)) ?>
            </div>
          </div>

          <div class="kop__text">
            <div class="kop__org"><?= $orgName ?></div>
            <div class="kop__school"><?= $alamatOrg ?></div>
            <?php if ($emailOrg): ?>
              <div class="kop__address">Email: <?= $emailOrg ?></div>
            <?php endif; ?>
          </div>
        </div>

        <!-- JUDUL -->
        <div class="surat-title">
          <h2>Surat Pernyataan Anggota</h2>
        </div>
        <div class="surat-nomor">No: <?= $nomorSurat ?></div>

        <!-- ISI -->
        <div class="surat-body">
          <p>Yang bertanda tangan di bawah ini:</p>

          <table class="identity-table">
            <tbody>
              <tr>
                <td>Nama Lengkap</td>
                <td>:</td>
                <td><?= $namaLengkap ?></td>
              </tr>
              <tr>
                <td>NIA</td>
                <td>:</td>
                <td><?= $nia ?></td>
              </tr>
              <tr>
                <td>Kelas</td>
                <td>:</td>
                <td><?= $kelas ?></td>
              </tr>
              <tr>
                <td>No. HP</td>
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

          <p>
            Dengan ini menyatakan dengan sesungguhnya bahwa saya,
            <strong><?= $namaLengkap ?></strong>, adalah anggota resmi
            <strong><?= $orgName ?></strong> SMKN&nbsp;2 Pinrang yang terdaftar dengan
            Nomor Induk Anggota (NIA) <strong><?= $nia ?></strong>.
          </p>

          <p>
            Saya menyatakan kesanggupan untuk mematuhi seluruh peraturan dan tata tertib
            organisasi, serta berpartisipasi aktif dalam setiap kegiatan yang diselenggarakan
            oleh <?= $orgName ?>.
          </p>

          <p>
            Saya juga menyatakan bahwa seluruh data dan informasi yang tercantum dalam surat
            ini adalah benar adanya. Apabila di kemudian hari terdapat ketidaksesuaian data,
            saya bersedia menerima sanksi sesuai ketentuan yang berlaku.
          </p>

          <p>
            Demikian surat pernyataan ini saya buat dengan sebenar-benarnya, dalam keadaan
            sadar dan tanpa paksaan dari pihak mana pun, untuk dapat dipergunakan sebagaimana
            mestinya.
          </p>
        </div>

        <!-- TANDA TANGAN -->
        <div class="surat-ttd">
          <!-- Kolom kiri: Pembina -->
          <div class="ttd-block">
            <p>Mengetahui,</p>
            <p>Pembina <?= $orgName ?></p>
            <div class="ttd-block__space"></div>
            <span class="ttd-block__line">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</span>
          </div>

          <!-- Kolom kanan: Yang Menyatakan -->
          <div class="ttd-block">
            <p>Pinrang, <?= $today ?></p>
            <p>Yang Menyatakan,</p>
            <div class="ttd-block__space">
              <?php if ($fotoUrl): ?>
                <img src="<?= $fotoUrl ?>" alt="Foto <?= $namaLengkap ?>">
              <?php endif; ?>
            </div>
            <span class="ttd-block__line"><?= $namaLengkap ?></span>
            <span class="ttd-block__sub"><?= $nia ?></span>
          </div>
        </div>

        <!-- FOOTER -->
        <div class="surat-footer">
          Dicetak melalui Sistem Informasi <?= $orgName ?> &mdash; <?= date('d/m/Y H:i') ?>
        </div>

      </div><!-- /#surat-preview -->
    </div><!-- /.sp-preview-scroll -->
  </div><!-- /.sp-preview-shell -->

</div><!-- /.sp-page -->

<!-- html2pdf.js CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
        integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
function downloadPDF() {
  var btn = document.querySelector('.btn-primary');
  var original = btn.innerHTML;

  btn.disabled = true;
  btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:15px;height:15px;animation:spin 1s linear infinite"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99"/></svg> Menyiapkan...';

  var element = document.getElementById('surat-preview');

  var opt = {
    margin      : [10, 10, 10, 10],
    filename    : 'Surat_Pernyataan_<?= str_replace(' ','_', $namaLengkap) ?>_<?= date('Ymd') ?>.pdf',
    image       : { type: 'jpeg', quality: 0.98 },
    html2canvas : {
      scale         : 2,
      useCORS       : true,
      allowTaint    : true,
      letterRendering: true,
      backgroundColor: '#ffffff'
    },
    jsPDF       : {
      unit       : 'mm',
      format     : 'a4',
      orientation: 'portrait'
    },
    pagebreak   : { mode: ['avoid-all', 'css', 'legacy'] }
  };

  html2pdf().set(opt).from(element).save().then(function() {
    btn.disabled = false;
    btn.innerHTML = original;
  }).catch(function(err) {
    console.error('PDF error:', err);
    btn.disabled = false;
    btn.innerHTML = original;
  });
}
</script>

<style>
@keyframes spin {
  from { transform: rotate(0deg); }
  to   { transform: rotate(360deg); }
}
</style>