<?php // app/views/pages/pab_status.php ?>

<?php
$page_title       = "Cek Status Pendaftaran PAB | " . ($settings['org_name']['value'] ?? APP_NAME);
$page_description = "Cek status pendaftaran anggota baru COM SMKN 2 Pinrang menggunakan NISN.";
?>

<style>
.pcs-wrap {
  --tx-primary:   var(--c-ink,    #0f172a);
  --tx-secondary: var(--c-muted,  #64748b);
  --tx-muted:     var(--c-muted2, #94a3b8);
  --bg-page:      var(--c-page,   #eef2f6);
  --bg-surface:   var(--c-white,  #ffffff);
  --bd-subtle:    var(--c-border, #e6ebf1);
  --ac:           var(--c-primary,    #0e7490);
  --ac-lt:        var(--c-primary-lt, #06b6d4);
  --green:      var(--c-green-text,   #15803d);
  --green-bg:   var(--c-green-bg,     #f0fdf4);
  --green-bd:   var(--c-green-border, #bbf7d0);
  --red:        var(--c-red-text,     #b91c1c);
  --red-bg:     var(--c-red-bg,       #fef2f2);
  --red-bd:     var(--c-red-border,   #fecaca);
  --amber:      var(--c-amber-icon,   #d9910c);
  --amber-bg:   var(--c-amber-bg,     #fef6e2);
  --amber-bd:   var(--c-amber-border, #fbe3a8);
  --r-sm: var(--radius-sm, 9px);
  --r-md: var(--radius-md, 13px);
  --r-lg: var(--radius-lg, 22px);
  --font-ui: var(--ff, 'Plus Jakarta Sans', sans-serif);

  min-height: calc(100svh - 68px);
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 3.5rem 1.5rem;
  background: var(--bg-page);
  font-family: var(--font-ui);
  color: var(--tx-primary);
}

.pcs-card {
  width: 100%;
  max-width: 460px;
  background: var(--bg-surface);
  border: 1px solid var(--bd-subtle);
  border-radius: var(--r-lg);
  box-shadow: 0 30px 70px -20px rgba(15,23,42,.16), 0 4px 18px rgba(15,23,42,.05);
  padding: 2rem;
}

.pcs-title { font-size: 1.25rem; font-weight: 800; letter-spacing: -.02em; margin-bottom: .35rem; }
.pcs-sub   { font-size: .84rem; color: var(--tx-secondary); line-height: 1.65; margin-bottom: 1.6rem; }

.pcs-form  { display: flex; gap: .6rem; margin-bottom: 1.2rem; }
.pcs-input {
  flex: 1;
  background: #fbfcfe;
  border: 1.5px solid var(--bd-subtle);
  border-radius: var(--r-sm);
  padding: 12px 15px;
  font-size: .9rem;
  color: var(--tx-primary);
  font-family: inherit;
  outline: none;
  transition: border-color .16s, box-shadow .16s, background .16s;
}
.pcs-input:focus { border-color: var(--ac-lt); box-shadow: 0 0 0 3px rgba(6,182,212,.12); background: #fff; }
.pcs-btn {
  padding: 12px 18px;
  background: var(--ac); color: #fff;
  font-weight: 800; font-size: .85rem;
  border: none; border-radius: var(--r-sm); cursor: pointer;
  font-family: inherit;
  transition: background .18s, transform .12s;
  white-space: nowrap;
}
.pcs-btn:hover { background: var(--ac-lt); transform: translateY(-1px); }

.pcs-alert {
  display: flex; gap: 10px; align-items: flex-start;
  border-radius: var(--r-sm);
  padding: .9rem 1rem;
  font-size: .82rem; line-height: 1.6;
  margin-bottom: 1rem;
}
.pcs-alert.error   { background: var(--red-bg);   border: 1px solid var(--red-bd);   color: var(--red); }
.pcs-alert svg { flex-shrink: 0; margin-top: 2px; }

.pcs-result {
  border: 1px solid var(--bd-subtle);
  border-radius: var(--r-md);
  overflow: hidden;
}
.pcs-result-head {
  padding: 1rem 1.25rem;
  display: flex; align-items: center; gap: 10px;
  font-weight: 800; font-size: .88rem;
}
.pcs-result-head.pending  { background: var(--amber-bg); color: var(--amber); border-bottom: 1px solid var(--amber-bd); }
.pcs-result-head.approved { background: var(--green-bg); color: var(--green); border-bottom: 1px solid var(--green-bd); }
.pcs-result-head.rejected { background: var(--red-bg);   color: var(--red);   border-bottom: 1px solid var(--red-bd); }

.pcs-result-body { padding: 1.15rem 1.25rem; }
.pcs-row { display: flex; justify-content: space-between; gap: 1rem; font-size: .83rem; padding: .4rem 0; border-bottom: 1px solid var(--bd-subtle); }
.pcs-row:last-child { border-bottom: none; }
.pcs-row-label { color: var(--tx-muted); }
.pcs-row-value { color: var(--tx-primary); font-weight: 700; text-align: right; }

.pcs-note {
  margin-top: .9rem;
  font-size: .78rem;
  color: var(--tx-secondary);
  line-height: 1.65;
  background: #fbfcfe;
  border: 1px solid var(--bd-subtle);
  border-radius: var(--r-sm);
  padding: .75rem .9rem;
}

.pcs-back { display: block; margin-top: 1.4rem; text-align: center; font-size: .82rem; color: var(--tx-secondary); text-decoration: none; font-weight: 600; }
.pcs-back:hover { color: var(--ac); }
</style>

<div class="pcs-wrap">
  <div class="pcs-card">
    <div class="pcs-title">Cek Status Pendaftaran</div>
    <div class="pcs-sub">Masukkan NISN kamu untuk melihat status pendaftaran PAB.</div>

    <form method="GET" action="<?= BASE_URL ?>/pab/cek-status" class="pcs-form">
      <input
        type="text"
        name="nisn"
        class="pcs-input"
        placeholder="Masukkan 10 digit NISN"
        value="<?= htmlspecialchars($nisnRaw ?? '') ?>"
        inputmode="numeric"
        pattern="[0-9]{10}"
        maxlength="10"
        autocomplete="off"
        required>
      <button type="submit" class="pcs-btn">Cek</button>
    </form>

    <?php if (!empty($errorMsg)): ?>
      <div class="pcs-alert error">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        <span><?= htmlspecialchars($errorMsg) ?></span>
      </div>
    <?php endif; ?>

    <?php if (!empty($result)): ?>
      <?php
        $status = $result['status'] ?? 'pending';
        $labels = [
          'pending'  => 'Menunggu Verifikasi',
          'approved' => 'Diterima — Sudah Bisa Login',
          'rejected' => 'Tidak Diterima',
        ];
        $icons = [
          'pending'  => '<svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>',
          'approved' => '<svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>',
          'rejected' => '<svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>',
        ];
      ?>
      <div class="pcs-result">
        <div class="pcs-result-head <?= htmlspecialchars($status) ?>">
          <?= $icons[$status] ?? '' ?>
          <span><?= htmlspecialchars($labels[$status] ?? ucfirst($status)) ?></span>
        </div>
        <div class="pcs-result-body">
          <div class="pcs-row">
            <span class="pcs-row-label">Nama</span>
            <span class="pcs-row-value"><?= htmlspecialchars($result['nama_lengkap']) ?></span>
          </div>
          <div class="pcs-row">
            <span class="pcs-row-label">Kelas</span>
            <span class="pcs-row-value"><?= htmlspecialchars($result['kelas']) ?></span>
          </div>

          <?php if ($status === 'approved'): ?>
            <?php if (!empty($result['nia'])): ?>
              <div class="pcs-row">
                <span class="pcs-row-label">NIA</span>
                <span class="pcs-row-value"><?= htmlspecialchars($result['nia']) ?></span>
              </div>
            <?php endif; ?>
            <div class="pcs-note">
              Selamat! Pendaftaran kamu sudah disetujui. Silakan login ke portal anggota menggunakan NISN dan password yang kamu buat saat mendaftar.
            </div>
            <a href="<?= BASE_URL ?>/login" class="pcs-btn" style="display:block;text-align:center;margin-top:.9rem;text-decoration:none;">Login Sekarang</a>

          <?php elseif ($status === 'rejected'): ?>
            <?php if (!empty($result['catatan_admin'])): ?>
              <div class="pcs-note">
                <strong>Catatan admin:</strong> <?= htmlspecialchars($result['catatan_admin']) ?>
              </div>
            <?php endif; ?>
            <div class="pcs-note">
              Kamu masih bisa mendaftar ulang dengan NISN yang sama melalui halaman pendaftaran.
            </div>
            <a href="<?= BASE_URL ?>/pab" class="pcs-btn" style="display:block;text-align:center;margin-top:.9rem;text-decoration:none;">Daftar Ulang</a>

          <?php else: ?>
            <div class="pcs-note">
              Pendaftaranmu masih dalam antrean verifikasi oleh Admin. Silakan cek kembali beberapa saat lagi.
            </div>
          <?php endif; ?>
        </div>
      </div>
    <?php endif; ?>

    <a href="<?= BASE_URL ?>/pab" class="pcs-back">← Kembali ke halaman pendaftaran</a>
  </div>
</div>