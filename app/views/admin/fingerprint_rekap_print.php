<?php
/**
 * app/views/admin/fingerprint_rekap_print.php
 *
 * Versi cetak, memakai layout 'print' (bukan 'admin' — tanpa sidebar).
 * Pola mengikuti admin/absensi_print.php: kop surat dari $settings,
 * tabel bersih, tombol cetak yang otomatis memanggil window.print().
 *
 * Variabel yang tersedia:
 * $rekap, $tanggalMulai, $tanggalAkhir, $kelas, $settings (array key=>value)
 */

$namaSekolah   = $settings['org_name']       ?? 'SMK Negeri 2 Pinrang';
$alamatSekolah = $settings['contact_address'] ?? '';
?>

<div class="print-wrapper">
    <div class="kop-surat text-center mb-4">
        <h4 class="mb-0"><?= htmlspecialchars($namaSekolah) ?></h4>
        <?php if ($alamatSekolah !== ''): ?>
            <p class="mb-0 small"><?= htmlspecialchars($alamatSekolah) ?></p>
        <?php endif; ?>
        <hr>
    </div>

    <h5 class="text-center mb-1">Rekap Absensi Fingerprint</h5>
    <p class="text-center mb-1">
        Periode: <?= htmlspecialchars(date('d/m/Y', strtotime($tanggalMulai))) ?>
        s/d <?= htmlspecialchars(date('d/m/Y', strtotime($tanggalAkhir))) ?>
        <?php if ($kelas !== ''): ?>
            &mdash; Kelas: <?= htmlspecialchars($kelas) ?>
        <?php endif; ?>
    </p>

    <table class="table table-bordered table-sm mt-3">
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
                <td colspan="8" class="text-center">Tidak ada data.</td>
            </tr>
        <?php else: ?>
            <?php $no = 1; ?>
            <?php foreach ($rekap as $row): ?>
                <?php
                    $statusLabel = match ($row['status']) {
                        'hadir'     => 'Hadir',
                        'terlambat' => 'Terlambat',
                        default     => 'Alpa',
                    };
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($row['nama_lengkap']) ?></td>
                    <td><?= htmlspecialchars($row['nia']) ?></td>
                    <td><?= htmlspecialchars($row['kelas']) ?></td>
                    <td><?= htmlspecialchars(date('d/m/Y', strtotime($row['tanggal']))) ?></td>
                    <td><?= $row['jam_masuk'] ? htmlspecialchars(substr($row['jam_masuk'], 0, 5)) : '-' ?></td>
                    <td><?= $row['jam_pulang'] ? htmlspecialchars(substr($row['jam_pulang'], 0, 5)) : '-' ?></td>
                    <td><?= htmlspecialchars($statusLabel) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>

    <p class="text-end mt-4">
        Pinrang, <?= htmlspecialchars(date('d/m/Y')) ?>
    </p>

    <div class="no-print text-center mt-4">
        <button type="button" class="btn btn-primary" onclick="window.print()">
            <i class="ti ti-printer"></i> Cetak
        </button>
    </div>
</div>

<style>
@media print {
    .no-print { display: none !important; }
}
.print-wrapper {
    max-width: 900px;
    margin: 0 auto;
    padding: 24px;
}
</style>