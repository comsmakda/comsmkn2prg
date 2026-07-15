<?php // app/views/admin/kelola_admin.php ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />
<style>
.kad {
  --tx-primary:   var(--c-ink,    #0f172a);
  --tx-secondary: var(--c-muted,  #64748b);
  --tx-muted:     var(--c-muted2, #94a3b8);
  --bg-surface:  var(--c-white, #ffffff);
  --bg-elevated: #f8fafc;
  --bd-subtle:  var(--c-border, #e6ebf1);
  --ac:      var(--c-primary,    #0e7490);
  --ac-dk:   var(--c-primary-dk, #0b5a70);
  --ac-lt:   var(--c-primary-lt, #06b6d4);
  --ac-dim:  var(--c-primary-08, rgba(14,116,144,.08));
  --red:     var(--c-red-text,   #b91c1c);
  --red-d:   var(--c-red-bg,     #fef2f2);
  --green:   var(--c-green-text, #15803d);
  --r-sm: var(--radius-sm, 9px);
  --r-md: var(--radius-md, 13px);
  --r-lg: var(--radius-lg, 22px);
  --font-ui: var(--ff, 'Plus Jakarta Sans', sans-serif);
  --ease: cubic-bezier(0.22,1,0.36,1);
}
.kad * { box-sizing: border-box; margin: 0; padding: 0; }
.kad { font-family: var(--font-ui); color: var(--tx-primary); font-size: 13.5px; line-height: 1.5; max-width: 900px; }
.kad a { text-decoration: none; color: inherit; }

.kad-head { margin-bottom: 24px; }
.kad-head__eyebrow { font-size: 11px; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: var(--ac); margin-bottom: 8px; }
.kad-head__title { font-size: 24px; font-weight: 800; letter-spacing: -0.03em; color: var(--ac-dk); }
.kad-head__sub { font-size: 13px; color: var(--tx-secondary); margin-top: 6px; }

.kad-card { background: var(--bg-surface); border: 1px solid var(--bd-subtle); border-radius: var(--r-lg); overflow: hidden; margin-bottom: 18px; }
.kad-card__head { padding: 16px 20px; border-bottom: 1px solid var(--bd-subtle); font-size: 10.5px; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: var(--tx-muted); display: flex; align-items: center; gap: 8px; }
.kad-card__head i { color: var(--ac); font-size: 15px; }
.kad-card__body { padding: 20px; }

.kad-promote-row { display: flex; gap: 10px; flex-wrap: wrap; align-items: flex-end; }
.kad-promote-row .kad-field { flex: 1; min-width: 220px; }
.kad-promote-row label { display: block; font-size: 11.5px; font-weight: 700; color: var(--tx-secondary); margin-bottom: 6px; }
.kad-promote-row select {
  width: 100%; font-family: var(--font-ui); font-size: 13px; color: var(--tx-primary);
  background: #fbfcfe; border: 1.5px solid var(--bd-subtle); border-radius: var(--r-sm);
  padding: 11px 14px; outline: none; appearance: none;
}
.kad-promote-row select:focus { border-color: var(--ac-lt); box-shadow: 0 0 0 3px rgba(6,182,212,.12); }

.kad-btn-pri {
  display: inline-flex; align-items: center; gap: 7px; padding: 11px 20px;
  background: var(--ac); color: #fff; font-family: var(--font-ui); font-size: 13px; font-weight: 800;
  border: none; border-radius: var(--r-sm); cursor: pointer; white-space: nowrap;
  box-shadow: 0 8px 22px rgba(14,116,144,.22); transition: all .16s var(--ease);
}
.kad-btn-pri:hover { background: var(--ac-lt); transform: translateY(-2px); }
.kad-btn-pri:disabled { opacity: .5; cursor: not-allowed; transform: none; box-shadow: none; }

.kad-btn-danger {
  display: inline-flex; align-items: center; gap: 6px; padding: 9px 15px;
  background: var(--red-d); color: var(--red); font-family: var(--font-ui); font-size: 12.5px; font-weight: 700;
  border: 1px solid rgba(185,28,28,.2); border-radius: var(--r-sm); cursor: pointer;
}
.kad-btn-danger:hover { background: rgba(185,28,28,.14); }

table.kad-admin-tbl { width: 100%; border-collapse: collapse; }
.kad-admin-tbl th { text-align: left; font-size: 10.5px; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; color: var(--tx-muted); padding: 10px 12px; border-bottom: 1px solid var(--bd-subtle); }
.kad-admin-tbl td { padding: 12px; border-bottom: 1px solid var(--bd-subtle); font-size: 13px; }
.kad-admin-tbl tr:last-child td { border-bottom: none; }
.kad-badge-nia { font-size: 10.5px; font-weight: 700; padding: 3px 9px; border-radius: 999px; background: var(--ac-dim); color: var(--ac); white-space: nowrap; }
.kad-badge-none { font-size: 10.5px; font-weight: 700; padding: 3px 9px; border-radius: 999px; background: var(--bg-elevated); color: var(--tx-muted); white-space: nowrap; }
.kad-empty { padding: 30px; text-align: center; color: var(--tx-muted); font-size: 13px; }

.kad-toast {
  position: fixed; bottom: 24px; right: 24px; z-index: 9998; display: flex; align-items: center; gap: 10px;
  padding: 13px 17px; background: var(--bg-surface); border: 1px solid var(--bd-subtle); border-radius: var(--r-sm);
  font-size: 12.5px; font-weight: 700; color: var(--tx-primary);
  box-shadow: 0 20px 45px -14px rgba(15,23,42,.28), 0 4px 16px rgba(15,23,42,.08);
  opacity: 0; transform: translateY(8px); transition: all .16s var(--ease); pointer-events: none; max-width: 320px;
}
.kad-toast.is-visible { opacity: 1; transform: translateY(0); }
.kad-toast__dot { width: 7px; height: 7px; border-radius: 50%; flex-shrink: 0; }
.kad-toast--ok  .kad-toast__dot { background: var(--green); }
.kad-toast--err .kad-toast__dot { background: var(--red); }
</style>

<div class="kad">

  <div class="kad-head">
    <div class="kad-head__eyebrow">Sistem</div>
    <h1 class="kad-head__title">Kelola Admin</h1>
    <p class="kad-head__sub">Jadikan anggota sebagai admin, atau turunkan admin kembali menjadi anggota biasa.</p>
  </div>

  <!-- ── Jadikan anggota sebagai admin ── -->
  <div class="kad-card">
    <div class="kad-card__head"><i class="ti ti-user-plus" aria-hidden="true"></i> Tambah Admin Baru</div>
    <div class="kad-card__body">
      <?php if (empty($eligible)): ?>
        <div class="kad-empty">Tidak ada anggota aktif yang bisa dijadikan admin.</div>
      <?php else: ?>
        <form method="POST" action="<?= BASE_URL ?>/admin/kelola-admin/promote">
          <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
          <div class="kad-promote-row">
            <div class="kad-field">
              <label for="user_id">Pilih Anggota</label>
              <select name="user_id" id="user_id" required>
                <option value="">— Pilih anggota —</option>
                <?php foreach ($eligible as $u): ?>
                  <option value="<?= (int)$u['id'] ?>">
                    <?= htmlspecialchars($u['nama_lengkap']) ?>
                    <?= !empty($u['kelas']) ? ' — ' . htmlspecialchars($u['kelas']) : '' ?>
                    <?= empty($u['nia']) ? ' (belum ada NIA)' : '' ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <button type="submit" class="kad-btn-pri">
              <i class="ti ti-shield-plus" aria-hidden="true"></i>
              Jadikan Admin
            </button>
          </div>
        </form>
      <?php endif; ?>
    </div>
  </div>

  <!-- ── Daftar admin (bukan admin utama) ── -->
  <div class="kad-card">
    <div class="kad-card__head"><i class="ti ti-shield-check" aria-hidden="true"></i> Daftar Admin</div>
    <div class="kad-card__body" style="padding:0;">
      <?php if (empty($adminList)): ?>
        <div class="kad-empty">Belum ada admin tambahan.</div>
      <?php else: ?>
        <table class="kad-admin-tbl">
          <thead>
            <tr>
              <th>Nama</th>
              <th>Email</th>
              <th>NIA</th>
              <th style="text-align:right;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($adminList as $a): ?>
              <tr>
                <td><?= htmlspecialchars($a['nama_lengkap']) ?></td>
                <td><?= htmlspecialchars($a['email'] ?? '—') ?></td>
                <td>
                  <?php if (!empty($a['nia'])): ?>
                    <span class="kad-badge-nia">Wajib Absen</span>
                  <?php else: ?>
                    <span class="kad-badge-none">Belum ada NIA</span>
                  <?php endif; ?>
                </td>
                <td style="text-align:right;">
                  <form method="POST" action="<?= BASE_URL ?>/admin/kelola-admin/<?= (int)$a['id'] ?>/demote"
                        onsubmit="return confirm('Turunkan <?= htmlspecialchars($a['nama_lengkap'], ENT_QUOTES) ?> menjadi anggota biasa?');"
                        style="display:inline;">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
                    <button type="submit" class="kad-btn-danger">
                      <i class="ti ti-shield-minus" aria-hidden="true"></i>
                      Turunkan
                    </button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </div>
  </div>

</div>

<div class="kad-toast" id="kadToast" role="alert" aria-live="polite">
  <span class="kad-toast__dot"></span>
  <span id="kadToastMsg"></span>
</div>

<script>
(function () {
  var toastEl  = document.getElementById('kadToast');
  var toastMsg = document.getElementById('kadToastMsg');
  function showToast(msg, type) {
    toastEl.className = 'kad-toast kad-toast--' + (type || 'ok');
    toastMsg.textContent = msg;
    toastEl.classList.add('is-visible');
    setTimeout(function () { toastEl.classList.remove('is-visible'); }, 3500);
  }
  <?php if (!empty($flash)): ?>
  showToast(<?= json_encode(strip_tags($flash['msg'] ?? '')) ?>, '<?= ($flash['type'] ?? 'info') === 'success' ? 'ok' : 'err' ?>');
  <?php endif; ?>
}());
</script>