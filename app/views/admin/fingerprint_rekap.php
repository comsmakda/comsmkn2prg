<?php
/**
 * app/views/admin/fingerprint_rekap.php
 *
 * Variabel yang tersedia:
 * $title, $rekap (array baris hasil FingerprintModel::getRekapHarian),
 * $tanggalMulai, $tanggalAkhir, $kelasTerpilih, $kelasList, $csrfToken, $flash
 */
?>

<div class="page-header">
    <h1 class="page-title"><?= htmlspecialchars($title) ?></h1>
</div>

<?php if (!empty($flash)): ?>
    <div class="alert alert-<?= htmlspecialchars($flash['type']) ?>">
        <?= htmlspecialchars($flash['message']) ?>
    </div>
<?php endif; ?>

<div class="card mb-3">
    <div class="card-body">
        <form method="get" action="/admin/fingerprint/rekap" class="row g-2 align-items-end">
            <div class="col-auto">
                <label class="form-label">Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" class="form-control"
                       value="<?= htmlspecialchars($tanggalMulai) ?>">
            </div>
            <div class="col-auto">
                <label class="form-label">Tanggal Akhir</label>
                <input type="date" name="tanggal_akhir" class="form-control"
                       value="<?= htmlspecialchars($tanggalAkhir) ?>">
            </div>
            <div class="col-auto">
                <label class="form-label">Kelas</label>
                <select name="kelas" class="form-select">
                    <option value="">Semua Kelas</option>
                    <?php foreach ($kelasList as $kelas): ?>
                        <option value="<?= htmlspecialchars($kelas) ?>"
                            <?= $kelasTerpilih === $kelas ? 'selected' : '' ?>>
                            <?= htmlspecialchars($kelas) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">
                    <i class="ti ti-filter"></i> Tampilkan
                </button>
            </div>
            <div class="col-auto ms-auto">
                <a class="btn btn-outline-secondary"
                   target="_blank"
                   href="/admin/fingerprint/rekap/print?tanggal_mulai=<?= urlencode($tanggalMulai) ?>&tanggal_akhir=<?= urlencode($tanggalAkhir) ?>&kelas=<?= urlencode($kelasTerpilih) ?>">
                    <i class="ti ti-printer"></i> Cetak / Export
                </a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
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
                        <td colspan="8" class="text-center text-muted py-4">
                            Tidak ada data untuk rentang tanggal ini.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php $no = 1; ?>
                    <?php foreach ($rekap as $row): ?>
                        <?php
                            $badgeClass = match ($row['status']) {
                                'hadir'     => 'badge-green',
                                'terlambat' => 'badge-amber',
                                default     => 'badge-red',
                            };
                            $badgeLabel = match ($row['status']) {
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
                            <td><span class="badge <?= $badgeClass ?>"><?= $badgeLabel ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
.badge-green { background: var(--c-green-100, #dcfce7); color: var(--c-green-700, #15803d); }
.badge-red { background: var(--c-red-100, #fee2e2); color: var(--c-red-700, #b91c1c); }
.badge-amber { background: var(--c-amber-100, #fef3c7); color: var(--c-amber-700, #b45309); }
</style>