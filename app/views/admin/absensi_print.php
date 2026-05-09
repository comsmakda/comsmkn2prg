<?php // app/views/admin/absensi_print.php
$orgName = htmlspecialchars($settings['org_name']['value'] ?? APP_NAME);
?>

<!-- Filter (no-print) -->
<div class="no-print mb-6">
  <form method="GET" class="flex flex-wrap gap-3 items-end">
    <div>
      <label class="block text-xs text-gray-600 mb-1">Filter Kelas</label>
      <select name="kelas" class="border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-700">
        <option value="">Semua Kelas</option>
        <?php foreach ($kelasList as $k): ?>
          <option value="<?= htmlspecialchars($k['kelas']) ?>"
                  <?= ($filter['kelas'] ?? '') === $k['kelas'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($k['kelas']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>
    <button class="px-4 py-2 bg-gray-800 text-white rounded-lg text-sm hover:bg-gray-700">Filter</button>
  </form>
</div>

<!-- Printable area -->
<div class="max-w-4xl mx-auto">

  <!-- Kop surat -->
  <div class="text-center border-b-2 border-gray-800 pb-4 mb-6">
    <h2 class="text-xl font-extrabold uppercase"><?= $orgName ?></h2>
    <p class="text-sm text-gray-600">SMKN 2 Pinrang</p>
  </div>

  <h3 class="text-center font-bold text-lg mb-1">DAFTAR HADIR</h3>
  <p class="text-center text-sm mb-1"><?= htmlspecialchars($sesi['judul']) ?></p>
  <p class="text-center text-xs text-gray-500 mb-6">
    Tanggal: <?= date('d MMMM Y', strtotime($sesi['tanggal'])) ?>
    <?php if (!empty($filter['kelas'])): ?> &mdash; Kelas: <?= htmlspecialchars($filter['kelas']) ?><?php endif; ?>
  </p>

  <table class="w-full border-collapse text-sm">
    <thead>
      <tr class="bg-gray-100 text-gray-700">
        <th class="border border-gray-300 px-3 py-2 text-center w-10">No</th>
        <th class="border border-gray-300 px-3 py-2 text-left">NIA</th>
        <th class="border border-gray-300 px-3 py-2 text-left">Nama Lengkap</th>
        <th class="border border-gray-300 px-3 py-2 text-center">Kelas</th>
        <th class="border border-gray-300 px-3 py-2 text-center w-32">Tanda Tangan</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($records)): ?>
      <tr>
        <td colspan="5" class="text-center py-8 text-gray-400">Tidak ada anggota.</td>
      </tr>
      <?php endif; ?>
      <?php foreach ($records as $i => $r): ?>
      <tr class="<?= $i % 2 === 0 ? '' : 'bg-gray-50' ?>">
        <td class="border border-gray-300 px-3 py-3 text-center text-xs"><?= $i + 1 ?></td>
        <td class="border border-gray-300 px-3 py-3 font-mono text-xs"><?= htmlspecialchars($r['nia'] ?? '—') ?></td>
        <td class="border border-gray-300 px-3 py-3"><?= htmlspecialchars($r['nama_lengkap']) ?></td>
        <td class="border border-gray-300 px-3 py-3 text-center text-xs"><?= htmlspecialchars($r['kelas'] ?? '—') ?></td>
        <td class="border border-gray-300 px-3 py-6">&nbsp;</td><!-- kolom TTD kosong -->
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <!-- Tanda tangan admin -->
  <div class="mt-10 flex justify-end">
    <div class="text-center text-sm">
      <p>Pinrang, <?= date('d MMMM Y') ?></p>
      <p class="mt-1 text-gray-600">Pengurus <?= $orgName ?></p>
      <div class="h-16 mt-2"></div><!-- Ruang TTD -->
      <p class="font-semibold underline">(.....................................)</p>
    </div>
  </div>

  <!-- Jumlah -->
  <p class="mt-4 text-xs text-gray-500">Total: <?= count($records) ?> anggota</p>
</div>
