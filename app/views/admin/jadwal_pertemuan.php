<?php
$hariLabel = [
    'senin' => 'Senin', 'selasa' => 'Selasa', 'rabu' => 'Rabu',
    'kamis' => 'Kamis', 'jumat' => 'Jumat', 'sabtu' => 'Sabtu', 'minggu' => 'Minggu',
];
$hariUrut = ['senin','selasa','rabu','kamis','jumat','sabtu','minggu'];
?>
<style>
.jp-head{display:flex;align-items:center;justify-content:space-between;gap:1rem;margin-bottom:1.5rem;flex-wrap:wrap}
.jp-title{font-size:1.35rem;font-weight:800;color:var(--c-ink);letter-spacing:-.02em}
.jp-sub{font-size:.85rem;color:var(--c-muted);margin-top:.2rem}
.jp-card{background:var(--c-white);border:1px solid var(--c-border);border-radius:var(--radius-lg);padding:1.5rem;margin-bottom:1.5rem}
.jp-card-title{font-size:1rem;font-weight:800;color:var(--c-ink);margin-bottom:.25rem;display:flex;align-items:center;gap:.5rem}
.jp-card-title i{color:var(--c-primary)}
.jp-card-desc{font-size:.82rem;color:var(--c-muted);margin-bottom:1.25rem}
.jp-table-wrap{overflow-x:auto}
.jp-table{width:100%;border-collapse:collapse;font-size:.87rem}
.jp-table th{text-align:left;font-size:.72rem;text-transform:uppercase;letter-spacing:.06em;color:var(--c-muted2);font-weight:700;padding:.6rem .7rem;border-bottom:1px solid var(--c-border)}
.jp-table td{padding:.6rem .7rem;border-bottom:1px solid var(--c-border);vertical-align:middle}
.jp-table tr:last-child td{border-bottom:none}
.jp-hari{font-weight:700;color:var(--c-ink)}
.jp-hari-rutin{display:inline-flex;align-items:center;gap:.3rem;font-size:.62rem;font-weight:700;color:var(--c-primary-dk);background:var(--c-primary-08);border:1px solid var(--c-primary-25);border-radius:.4rem;padding:.1rem .4rem;margin-left:.4rem}
.jp-input-time{width:6.5rem;padding:.4rem .55rem;border:1.5px solid var(--c-border);border-radius:.55rem;font-family:var(--ff);font-size:.85rem}
.jp-input-time:focus{outline:none;border-color:var(--c-primary-lt)}
.jp-input-text{width:100%;min-width:10rem;padding:.4rem .6rem;border:1.5px solid var(--c-border);border-radius:.55rem;font-family:var(--ff);font-size:.85rem}
.jp-input-text:focus{outline:none;border-color:var(--c-primary-lt)}
.jp-switch{position:relative;display:inline-block;width:2.4rem;height:1.35rem}
.jp-switch input{opacity:0;width:0;height:0}
.jp-slider{position:absolute;cursor:pointer;inset:0;background:#cbd5e1;border-radius:99px;transition:.2s}
.jp-slider::before{content:"";position:absolute;height:1.05rem;width:1.05rem;left:.15rem;bottom:.15rem;background:#fff;border-radius:50%;transition:.2s}
.jp-switch input:checked + .jp-slider{background:var(--c-primary)}
.jp-switch input:checked + .jp-slider::before{transform:translateX(1.05rem)}
.jp-btn{display:inline-flex;align-items:center;gap:.5rem;padding:.65rem 1.2rem;border-radius:.7rem;background:var(--c-primary);color:#fff;font-weight:700;font-size:.85rem;border:none;transition:background .15s}
.jp-btn:hover{background:var(--c-primary-dk)}
.jp-btn-outline{background:transparent;color:var(--c-red-text);border:1px solid var(--c-red-border);padding:.4rem .6rem;border-radius:.5rem;font-size:.8rem;font-weight:600}
.jp-btn-outline:hover{background:var(--c-red-bg)}
.jp-form-inline{display:flex;gap:.75rem;flex-wrap:wrap;align-items:flex-end;margin-bottom:1.25rem}
.jp-field label{display:block;font-size:.75rem;font-weight:700;color:var(--c-muted);margin-bottom:.3rem}
.jp-empty{text-align:center;padding:1.5rem;color:var(--c-muted2);font-size:.85rem}
</style>

<div class="jp-head">
  <div>
    <div class="jp-title">Jadwal Pertemuan</div>
    <div class="jp-sub">Atur hari &amp; jam pertemuan rutin, serta tandai tanggal tertentu sebagai libur agar anggota tidak tercatat alpa.</div>
  </div>
</div>

<!-- ============================================================
     JADWAL RUTIN PER HARI
     ============================================================ -->
<form method="post" action="<?= BASE_URL ?>/admin/jadwal-pertemuan/simpan">
  <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">

  <div class="jp-card">
    <div class="jp-card-title"><i class="ti ti-calendar-week"></i> Jadwal Rutin Mingguan</div>
    <div class="jp-card-desc">Aktifkan hari yang menjadi jadwal pertemuan. Kalau jadwal pindah hari, cukup nonaktifkan hari lama dan aktifkan hari baru — tidak perlu buat data baru.</div>

    <div class="jp-table-wrap">
      <table class="jp-table">
        <thead>
          <tr>
            <th style="width:6rem">Aktif</th>
            <th>Hari</th>
            <th>Jam Mulai</th>
            <th>Jam Selesai</th>
            <th>Keterangan</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($hariUrut as $hari):
              $j = $jadwalMap[$hari] ?? null;
              $aktif = $j['aktif'] ?? 0;
              $jm = !empty($j['jam_mulai']) ? substr($j['jam_mulai'], 0, 5) : '';
              $js = !empty($j['jam_selesai']) ? substr($j['jam_selesai'], 0, 5) : '';
              $ket = $j['keterangan'] ?? '';
              $isRutin = in_array($hari, ['kamis','jumat'], true);
          ?>
          <tr>
            <td>
              <label class="jp-switch">
                <input type="checkbox" name="aktif[<?= $hari ?>]" value="1" <?= $aktif ? 'checked' : '' ?>>
                <span class="jp-slider"></span>
              </label>
            </td>
            <td>
              <span class="jp-hari"><?= $hariLabel[$hari] ?></span>
              <?php if ($isRutin): ?><span class="jp-hari-rutin">Rutin</span><?php endif; ?>
            </td>
            <td><input type="time" class="jp-input-time" name="jam_mulai[<?= $hari ?>]" value="<?= htmlspecialchars($jm) ?>"></td>
            <td><input type="time" class="jp-input-time" name="jam_selesai[<?= $hari ?>]" value="<?= htmlspecialchars($js) ?>"></td>
            <td><input type="text" class="jp-input-text" name="keterangan[<?= $hari ?>]" value="<?= htmlspecialchars($ket) ?>" placeholder="Opsional, mis. Ruang Lab TKJ"></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <div style="margin-top:1.25rem">
      <button type="submit" class="jp-btn"><i class="ti ti-device-floppy"></i> Simpan Jadwal</button>
    </div>
  </div>
</form>

<!-- ============================================================
     HARI LIBUR MANUAL
     ============================================================ -->
<div class="jp-card">
  <div class="jp-card-title"><i class="ti ti-calendar-off"></i> Tandai Tanggal Libur</div>
  <div class="jp-card-desc">Kalau pertemuan tiba-tiba tidak ada di tanggal yang seharusnya pertemuan, tambahkan tanggalnya di sini supaya anggota tidak dihitung alpa.</div>

  <form method="post" action="<?= BASE_URL ?>/admin/jadwal-pertemuan/libur" class="jp-form-inline">
  <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
  <div class="jp-field">
    <label for="jp-tgl-mulai">Dari Tanggal</label>
    <input type="date" id="jp-tgl-mulai" name="tanggal_mulai" class="jp-input-time" style="width:9.5rem" required>
  </div>
  <div class="jp-field">
    <label for="jp-tgl-akhir">Sampai Tanggal <span style="font-weight:400;color:var(--c-muted2)">(opsional)</span></label>
    <input type="date" id="jp-tgl-akhir" name="tanggal_akhir" class="jp-input-time" style="width:9.5rem">
  </div>
  <div class="jp-field" style="flex:1">
    <label for="jp-ket">Keterangan</label>
    <input type="text" id="jp-ket" name="keterangan" class="jp-input-text" placeholder="Opsional, mis. Libur nasional / Pembina berhalangan">
  </div>
  <button type="submit" class="jp-btn"><i class="ti ti-plus"></i> Tambah</button>
</form>

  <div class="jp-table-wrap">
    <table class="jp-table">
      <thead>
        <tr>
          <th style="width:9rem">Tanggal</th>
          <th style="width:7rem">Hari</th>
          <th>Keterangan</th>
          <th style="width:5rem"></th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($liburList)): ?>
          <tr><td colspan="4" class="jp-empty">Belum ada tanggal libur yang ditandai.</td></tr>
        <?php else: foreach ($liburList as $l): ?>
          <tr>
            <td><?= date('d M Y', strtotime($l['tanggal'])) ?></td>
            <td><?= JadwalPertemuanModel::namaHariIndo($l['tanggal']) ?></td>
            <td><?= htmlspecialchars($l['keterangan'] ?? '-') ?></td>
            <td>
              <form method="post" action="<?= BASE_URL ?>/admin/jadwal-pertemuan/libur/<?= $l['id'] ?>/delete" onsubmit="return confirm('Hapus tanggal libur ini?');">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
                <button type="submit" class="jp-btn-outline"><i class="ti ti-trash"></i></button>
              </form>
            </td>
          </tr>
        <?php endforeach; endif; ?>
      </tbody>
    </table>
  </div>
</div>