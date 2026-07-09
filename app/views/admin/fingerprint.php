<?php
/**
 * app/views/admin/fingerprint.php
 *
 * Variabel yang tersedia:
 * $title, $health (['success'=>bool,'message'=>string]), $anggota (array baris users),
 * $csrfToken, $flash
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
    <div class="card-body d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2">
            <span class="status-dot <?= $health['success'] ? 'status-dot-green' : 'status-dot-red' ?>"></span>
            <strong>Status Mesin GEISA X107:</strong>
            <span><?= htmlspecialchars($health['message']) ?></span>
        </div>

        <div class="d-flex gap-2">
            <form method="post" action="/admin/fingerprint/sync-logs" class="d-inline">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                <button type="submit" class="btn btn-outline-primary btn-sm">
                    <i class="ti ti-refresh"></i> Tarik Log dari Mesin
                </button>
            </form>

            <form method="post" action="/admin/fingerprint/push-bulk" class="d-inline"
                  onsubmit="return confirm('Push semua anggota yang belum tersinkron ke mesin?');">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="ti ti-upload"></i> Push Semua
                </button>
            </form>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>NIA</th>
                        <th>Kelas</th>
                        <th>Status Sync</th>
                        <th>Terakhir Sync</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (empty($anggota)): ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            Belum ada anggota aktif.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($anggota as $row): ?>
                        <?php
                            $badgeClass = match ($row['fp_status']) {
                                'tersinkron' => 'badge-green',
                                'gagal'      => 'badge-red',
                                default      => 'badge-amber',
                            };
                            $badgeLabel = match ($row['fp_status']) {
                                'tersinkron' => 'Tersinkron',
                                'gagal'      => 'Gagal',
                                default      => 'Belum Sync',
                            };
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($row['nama_lengkap']) ?></td>
                            <td><?= htmlspecialchars($row['nia']) ?></td>
                            <td><?= htmlspecialchars($row['kelas']) ?></td>
                            <td>
                                <span class="badge <?= $badgeClass ?>"><?= $badgeLabel ?></span>
                                <?php if ($row['fp_status'] === 'gagal' && !empty($row['fp_last_error'])): ?>
                                    <div class="text-muted small mt-1">
                                        <?= htmlspecialchars($row['fp_last_error']) ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?= $row['fp_synced_at']
                                    ? htmlspecialchars(date('d/m/Y H:i', strtotime($row['fp_synced_at'])))
                                    : '-' ?>
                            </td>
                            <td class="text-end">
                                <form method="post" action="/admin/fingerprint/<?= (int) $row['id'] ?>/push" class="d-inline">
                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-primary" title="Push ke mesin">
                                        <i class="ti ti-upload"></i>
                                    </button>
                                </form>
                                <form method="post" action="/admin/fingerprint/<?= (int) $row['id'] ?>/delete" class="d-inline"
                                      onsubmit="return confirm('Hapus anggota ini dari mesin fingerprint?');">
                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus dari mesin">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
.status-dot {
    display: inline-block;
    width: 10px;
    height: 10px;
    border-radius: 50%;
}
.status-dot-green { background: var(--c-green-500, #22c55e); }
.status-dot-red { background: var(--c-red-500, #ef4444); }
.badge-green { background: var(--c-green-100, #dcfce7); color: var(--c-green-700, #15803d); }
.badge-red { background: var(--c-red-100, #fee2e2); color: var(--c-red-700, #b91c1c); }
.badge-amber { background: var(--c-amber-100, #fef3c7); color: var(--c-amber-700, #b45309); }
</style>