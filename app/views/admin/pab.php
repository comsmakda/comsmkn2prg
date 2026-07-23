<?php // app/views/admin/pab.php ?>

<style>
.pab-root {
  --font-ui:   var(--ff, 'Plus Jakarta Sans', sans-serif);
  --font-mono: var(--ff, 'Plus Jakarta Sans', sans-serif);

  --bg-surface:  var(--c-white, #ffffff);
  --bg-elevated: #f8fafc;
  --bg-overlay:  #eef2f6;

  --bd-subtle:  var(--c-border, #e6ebf1);
  --bd-default: var(--c-border, #e6ebf1);
  --bd-accent:  var(--c-primary-25, rgba(14,116,144,.25));

  --tx-primary:   var(--c-ink,    #0f172a);
  --tx-secondary: var(--c-muted,  #64748b);
  --tx-muted:     var(--c-muted2, #94a3b8);

  --ac:      var(--c-primary,    #0e7490);
  --ac-dim:  var(--c-primary-08, rgba(14,116,144,.08));
  --ac-glow: var(--c-primary-12, rgba(14,116,144,.12));

  --green:    var(--c-green-text,   #15803d);
  --green-d:  var(--c-green-bg,     #f0fdf4);
  --green-bd: var(--c-green-border, #bbf7d0);

  --red:    var(--c-red-text,   #b91c1c);
  --red-d:  var(--c-red-bg,     #fef2f2);
  --red-bd: var(--c-red-border, #fecaca);

  --amber:    var(--c-amber-icon,   #d9910c);
  --amber-d:  var(--c-amber-bg,     #fef6e2);
  --amber-bd: var(--c-amber-border, #fbe3a8);

  --r-xs: 6px;
  --r-sm: var(--radius-sm, 9px);
  --r-md: var(--radius-sm, 9px);
  --r-lg: var(--radius-md, 13px);
  --r-xl: var(--radius-lg, 22px);

  --ease: cubic-bezier(0.22,1,0.36,1);
  --t-fast: 120ms; --t-base: 160ms;
}

.pab-root *, .pab-root *::before, .pab-root *::after {
  box-sizing: border-box; margin: 0; padding: 0;
}
.pab-root a { text-decoration: none; color: inherit; }
.pab-root {
  font-family: var(--font-ui);
  color: var(--tx-primary);
  font-size: 13.5px;
  line-height: 1.5;
  -webkit-font-smoothing: antialiased;
}

/* ── Page header ── */
.pab-ph {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  gap: 16px;
  flex-wrap: wrap;
  margin-bottom: 20px;
}
.pab-ph__left {}
.pab-ph__eyebrow {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  font-size: 11px;
  font-weight: 700;
  letter-spacing: 0.1em;
  text-transform: uppercase;
  color: var(--ac);
  margin-bottom: 6px;
}
.pab-ph__eyebrow::before {
  content: '';
  width: 6px; height: 6px;
  border-radius: 50%;
  background: var(--ac);
  box-shadow: 0 0 6px var(--ac);
  flex-shrink: 0;
}
.pab-ph__title {
  font-size: 22px;
  font-weight: 800;
  letter-spacing: -0.03em;
  color: var(--c-primary-dk, #0b5a70);
  line-height: 1.1;
}

/* ── Status bar ── */
.pab-statusbar {
  display: flex;
  align-items: center;
  gap: 12px;
  flex-wrap: wrap;
  margin-bottom: 16px;
  padding: 13px 18px;
  background: var(--bg-surface);
  border: 1px solid var(--bd-subtle);
  border-radius: var(--r-xl);
}
.pab-status-badge {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  font-size: 12px;
  font-weight: 700;
  padding: 5px 13px;
  border-radius: 100px;
  border: 1px solid;
}
.pab-status-badge__dot {
  width: 7px; height: 7px;
  border-radius: 50%;
  flex-shrink: 0;
}
.pab-status-badge--open {
  background: var(--green-d);
  border-color: var(--green-bd);
  color: var(--green);
}
.pab-status-badge--open .pab-status-badge__dot {
  background: var(--green);
  box-shadow: 0 0 5px var(--green);
  animation: pulse-green 1.8s ease-in-out infinite;
}
.pab-status-badge--closed {
  background: var(--red-d);
  border-color: var(--red-bd);
  color: var(--red);
}
.pab-status-badge--closed .pab-status-badge__dot {
  background: var(--red);
}
@keyframes pulse-green {
  0%, 100% { opacity: 1; }
  50% { opacity: 0.4; }
}

.pab-statusbar__sep {
  width: 1px;
  height: 18px;
  background: var(--bd-subtle);
}
.pab-statusbar__txt {
  font-size: 12px;
  color: var(--tx-muted);
}

/* Toggle button */
.pab-toggle {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  padding: 9px 17px;
  font-family: var(--font-ui);
  font-size: 12.5px;
  font-weight: 700;
  border: none;
  border-radius: var(--r-md);
  cursor: pointer;
  transition:
    background  var(--t-fast) var(--ease),
    box-shadow  var(--t-base) var(--ease),
    transform   var(--t-fast) var(--ease);
  margin-left: auto;
}
.pab-toggle i { font-size: 14px; }
.pab-toggle--close {
  background: var(--red-d);
  color: var(--red);
  border: 1px solid var(--red-bd);
}
.pab-toggle--close:hover {
  background: var(--red);
  color: #fff;
  box-shadow: 0 6px 16px rgba(185,28,28,0.22);
  transform: translateY(-1px);
}
.pab-toggle--open {
  background: var(--green-d);
  color: var(--green);
  border: 1px solid var(--green-bd);
}
.pab-toggle--open:hover {
  background: var(--green);
  color: #fff;
  box-shadow: 0 6px 16px rgba(21,128,61,0.22);
  transform: translateY(-1px);
}
.pab-toggle:active { transform: translateY(0); }

/* ── Filter bar ── */
.pab-filterbar {
  display: flex;
  align-items: flex-end;
  gap: 10px;
  flex-wrap: wrap;
  margin-bottom: 16px;
  padding: 15px 18px;
  background: var(--bg-surface);
  border: 1px solid var(--bd-subtle);
  border-radius: var(--r-xl);
}
.pab-filter-field {
  display: flex;
  flex-direction: column;
  gap: 5px;
  min-width: 150px;
}
.pab-filter-field--grow { flex: 1; min-width: 200px; }
.pab-filter-lbl {
  font-size: 10.5px;
  font-weight: 700;
  letter-spacing: 0.04em;
  text-transform: uppercase;
  color: var(--tx-muted);
}
.pab-filter-input,
.pab-filter-select {
  font-family: var(--font-ui);
  font-size: 12.5px;
  color: var(--tx-primary);
  background: var(--bg-elevated);
  border: 1.5px solid var(--bd-subtle);
  border-radius: var(--r-sm);
  padding: 8px 11px;
  outline: none;
  width: 100%;
  transition: border-color var(--t-fast) var(--ease), background var(--t-fast) var(--ease), box-shadow var(--t-base) var(--ease);
}
.pab-filter-input::placeholder { color: var(--tx-muted); }
.pab-filter-input:focus,
.pab-filter-select:focus {
  border-color: var(--c-primary-lt, #06b6d4);
  background: #fff;
  box-shadow: 0 0 0 3px rgba(6,182,212,.12);
}
.pab-filter-actions {
  display: flex;
  gap: 8px;
}
.pab-filter-btn {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 8px 15px;
  font-family: var(--font-ui);
  font-size: 12.5px;
  font-weight: 700;
  border: none;
  border-radius: var(--r-sm);
  cursor: pointer;
  transition: all var(--t-fast) var(--ease);
  white-space: nowrap;
}
.pab-filter-btn--apply {
  background: var(--ac);
  color: #fff;
}
.pab-filter-btn--apply:hover { box-shadow: 0 6px 16px var(--ac-glow); transform: translateY(-1px); }
.pab-filter-btn--reset {
  background: var(--bg-elevated);
  color: var(--tx-secondary);
  border: 1px solid var(--bd-subtle);
}
.pab-filter-btn--reset:hover { border-color: var(--bd-accent); color: var(--tx-primary); background: #fff; }

/* ── Panel / table wrapper ── */
.pab-panel {
  background: var(--bg-surface);
  border: 1px solid var(--bd-subtle);
  border-radius: var(--r-xl);
  overflow: hidden;
}
.pab-panel__head {
  padding: 15px 20px;
  border-bottom: 1px solid var(--bd-subtle);
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 8px;
  flex-wrap: wrap;
}
.pab-panel__head-title {
  font-size: 13px;
  font-weight: 800;
  color: var(--tx-primary);
}
.pab-panel__head-count {
  font-size: 11px;
  color: var(--tx-muted);
  font-weight: 500;
}

/* ── Table ── */
.pab-table-wrap { overflow-x: auto; }
.pab-table {
  width: 100%;
  border-collapse: collapse;
  font-size: 12.5px;
}
.pab-table thead tr {
  background: var(--bg-elevated);
}
.pab-table thead th {
  padding: 11px 16px;
  text-align: left;
  font-size: 10.5px;
  font-weight: 700;
  letter-spacing: 0.08em;
  text-transform: uppercase;
  color: var(--tx-muted);
  white-space: nowrap;
  border-bottom: 1px solid var(--bd-subtle);
}
.pab-table tbody tr {
  border-bottom: 1px solid var(--bd-subtle);
  transition: background var(--t-fast) var(--ease);
}
.pab-table tbody tr:last-child { border-bottom: none; }
.pab-table tbody tr:hover { background: rgba(14,116,144,.03); }
.pab-table td {
  padding: 12px 16px;
  vertical-align: middle;
  color: var(--tx-secondary);
  white-space: nowrap;
}

/* Name cell */
.pab-cell-name {
  display: flex;
  align-items: center;
  gap: 11px;
}
.pab-avatar {
  width: 34px; height: 34px;
  border-radius: var(--r-sm);
  object-fit: cover;
  border: 1px solid var(--bd-subtle);
  display: block;
  flex-shrink: 0;
}
.pab-avatar-fallback {
  width: 34px; height: 34px;
  border-radius: var(--r-sm);
  background: var(--bg-elevated);
  border: 1px solid var(--bd-subtle);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 11.5px;
  font-weight: 700;
  color: var(--tx-muted);
  text-transform: uppercase;
  flex-shrink: 0;
}
.pab-name {
  font-weight: 700;
  color: var(--tx-primary);
  font-size: 13px;
}
.pab-kelas {
  font-size: 10.5px;
  color: var(--tx-muted);
  margin-top: 1px;
  font-weight: 500;
}

/* NISN */
.pab-nisn {
  font-family: var(--font-mono);
  font-size: 11.5px;
  font-weight: 600;
  color: var(--tx-secondary);
  letter-spacing: 0.02em;
}

/* Date */
.pab-date {
  font-size: 11.5px;
  color: var(--tx-muted);
  font-weight: 500;
}

/* NIA */
.pab-nia {
  font-size: 11.5px;
  font-weight: 700;
  color: var(--ac);
}
.pab-nia--empty { color: var(--tx-muted); font-weight: 500; }

/* Status badge */
.pab-badge {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  font-size: 10px;
  font-weight: 700;
  letter-spacing: 0.05em;
  text-transform: uppercase;
  padding: 3px 10px;
  border-radius: 100px;
  border: 1px solid;
  white-space: nowrap;
}
.pab-badge__dot { width: 5px; height: 5px; border-radius: 50%; flex-shrink: 0; }
.pab-badge--pending  { background: var(--amber-d); border-color: var(--amber-bd); color: var(--amber); }
.pab-badge--pending .pab-badge__dot  { background: var(--amber); }
.pab-badge--approved { background: var(--green-d);  border-color: var(--green-bd);  color: var(--green); }
.pab-badge--approved .pab-badge__dot { background: var(--green); }
.pab-badge--rejected { background: var(--red-d);    border-color: var(--red-bd);    color: var(--red); }
.pab-badge--rejected .pab-badge__dot { background: var(--red); }

/* Action buttons */
.pab-actions { display: flex; align-items: center; gap: 6px; }
.pab-btn {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  padding: 7px 13px;
  font-family: var(--font-ui);
  font-size: 11.5px;
  font-weight: 700;
  border: none;
  border-radius: var(--r-sm);
  cursor: pointer;
  white-space: nowrap;
  transition: all var(--t-fast) var(--ease);
  line-height: 1;
}
.pab-btn i { font-size: 12px; }
.pab-btn--approve {
  background: var(--green-d);
  color: var(--green);
  border: 1px solid var(--green-bd);
}
.pab-btn--approve:hover { background: var(--green); color: #fff; transform: translateY(-1px); }
.pab-btn--reject {
  background: var(--red-d);
  color: var(--red);
  border: 1px solid var(--red-bd);
}
.pab-btn--reject:hover { background: var(--red); color: #fff; transform: translateY(-1px); }
.pab-btn--delete {
  background: var(--bg-elevated);
  color: var(--tx-secondary);
  border: 1px solid var(--bd-subtle);
}
.pab-btn--delete:hover { background: var(--red); color: #fff; border-color: var(--red); transform: translateY(-1px); }
.pab-btn:active { transform: translateY(0); }

/* Empty state */
.pab-empty {
  padding: 52px 20px;
  text-align: center;
  color: var(--tx-muted);
}
.pab-empty__ico {
  width: 44px; height: 44px;
  border-radius: var(--r-lg);
  background: var(--bg-elevated);
  border: 1px solid var(--bd-subtle);
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 12px;
  color: var(--tx-muted);
  font-size: 19px;
}
.pab-empty__title { font-size: 13.5px; font-weight: 700; color: var(--tx-secondary); margin-bottom: 4px; }
.pab-empty__sub   { font-size: 12px; color: var(--tx-muted); }

/* ── Modal (shared style for reject & delete) ── */
.pab-modal-overlay {
  display: none;
  position: fixed;
  inset: 0;
  background: rgba(15,23,42,0.45);
  backdrop-filter: blur(3px);
  z-index: 50;
  align-items: center;
  justify-content: center;
  padding: 20px;
}
.pab-modal-overlay.open { display: flex; }
.pab-modal {
  background: var(--bg-surface);
  border: 1px solid var(--bd-subtle);
  border-radius: var(--r-xl);
  width: 100%;
  max-width: 420px;
  overflow: hidden;
  box-shadow: 0 30px 70px -20px rgba(15,23,42,.28), 0 4px 18px rgba(15,23,42,.08);
  animation: modal-in 200ms var(--ease) both;
}
@keyframes modal-in {
  from { opacity: 0; transform: scale(0.95) translateY(8px); }
  to   { opacity: 1; transform: none; }
}
.pab-modal__head {
  padding: 17px 20px;
  border-bottom: 1px solid var(--bd-subtle);
  display: flex;
  align-items: center;
  gap: 11px;
}
.pab-modal__head-ico {
  width: 32px; height: 32px;
  border-radius: var(--r-sm);
  background: var(--red-d);
  border: 1px solid var(--red-bd);
  display: flex; align-items: center; justify-content: center;
  color: var(--red);
  flex-shrink: 0;
  font-size: 15px;
}
.pab-modal__head-title  { font-size: 13.5px; font-weight: 800; color: var(--tx-primary); }
.pab-modal__head-sub    { font-size: 11.5px; color: var(--tx-muted); margin-top: 1px; }
.pab-modal__body { padding: 20px; display: flex; flex-direction: column; gap: 14px; }
.pab-modal__body-name {
  font-size: 13px;
  font-weight: 700;
  color: var(--tx-primary);
  padding: 10px 13px;
  background: var(--bg-elevated);
  border: 1px solid var(--bd-subtle);
  border-radius: var(--r-md);
}

/* Textarea */
.pab-textarea {
  font-family: var(--font-ui);
  font-size: 13px;
  color: var(--tx-primary);
  background: var(--bg-elevated);
  border: 1.5px solid var(--bd-subtle);
  border-radius: var(--r-md);
  padding: 10px 13px;
  outline: none;
  width: 100%;
  resize: vertical;
  min-height: 80px;
  transition:
    border-color var(--t-fast) var(--ease),
    background   var(--t-fast) var(--ease),
    box-shadow   var(--t-base) var(--ease);
}
.pab-textarea::placeholder { color: var(--tx-muted); font-size: 12.5px; }
.pab-textarea:focus {
  border-color: var(--c-primary-lt, #06b6d4);
  background: #fff;
  box-shadow: 0 0 0 3px rgba(6,182,212,.12);
}

.pab-modal__lbl {
  font-size: 11.5px;
  font-weight: 700;
  color: var(--tx-secondary);
  margin-bottom: 6px;
  display: block;
}

.pab-modal__foot {
  padding: 15px 20px;
  border-top: 1px solid var(--bd-subtle);
  display: flex;
  gap: 8px;
}
.pab-modal__foot .pab-btn { flex: 1; justify-content: center; padding: 10px; font-size: 12.5px; }
.pab-btn--cancel {
  background: var(--bg-elevated);
  color: var(--tx-secondary);
  border: 1px solid var(--bd-subtle);
}
.pab-btn--cancel:hover { border-color: var(--bd-accent); color: var(--tx-primary); background: #fff; }
</style>

<div class="pab-root">

  <!-- Page header -->
  <div class="pab-ph">
    <div class="pab-ph__left">
      <div class="pab-ph__eyebrow">Sistem PAB</div>
      <h1 class="pab-ph__title">Verifikasi PAB</h1>
    </div>
  </div>

  <!-- Status bar + toggle -->
  <div class="pab-statusbar">
    <?php if ($pabOpen): ?>
      <span class="pab-status-badge pab-status-badge--open">
        <span class="pab-status-badge__dot"></span>
        PAB Dibuka
      </span>
    <?php else: ?>
      <span class="pab-status-badge pab-status-badge--closed">
        <span class="pab-status-badge__dot"></span>
        PAB Ditutup
      </span>
    <?php endif; ?>

    <span class="pab-statusbar__sep"></span>
    <span class="pab-statusbar__txt">
      <?= $pabOpen ? 'Pendaftaran sedang aktif — anggota baru dapat mendaftar' : 'Pendaftaran ditutup — tidak ada pendaftar baru' ?>
    </span>

    <form method="POST" action="<?= BASE_URL ?>/admin/pab/toggle" style="margin-left:auto;">
      <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
      <button type="submit" class="pab-toggle <?= $pabOpen ? 'pab-toggle--close' : 'pab-toggle--open' ?>">
        <?php if ($pabOpen): ?>
          <i class="ti ti-lock" aria-hidden="true"></i>
          Tutup PAB
        <?php else: ?>
          <i class="ti ti-lock-open" aria-hidden="true"></i>
          Buka PAB
        <?php endif; ?>
      </button>
    </form>
  </div>

  <!-- Filter bar -->
  <form method="GET" action="<?= BASE_URL ?>/admin/pab" class="pab-filterbar">
    <div class="pab-filter-field pab-filter-field--grow">
      <label class="pab-filter-lbl" for="pab-f-search">Cari Nama / NISN</label>
      <input type="text" id="pab-f-search" name="search" class="pab-filter-input"
             placeholder="Ketik nama atau NISN…"
             value="<?= htmlspecialchars($filter['search'] ?? '') ?>">
    </div>

    <div class="pab-filter-field">
      <label class="pab-filter-lbl" for="pab-f-status">Status</label>
      <select id="pab-f-status" name="status" class="pab-filter-select">
        <option value="">Semua Status</option>
        <?php
          $statusOpts = ['pending' => 'Pending', 'approved' => 'Disetujui', 'rejected' => 'Ditolak'];
          foreach ($statusOpts as $val => $lbl):
        ?>
          <option value="<?= $val ?>" <?= ($filter['status'] ?? '') === $val ? 'selected' : '' ?>>
            <?= $lbl ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="pab-filter-field">
      <label class="pab-filter-lbl" for="pab-f-kelas">Kelas</label>
      <select id="pab-f-kelas" name="kelas" class="pab-filter-select">
        <option value="">Semua Kelas</option>
        <?php foreach ($kelasList as $k): ?>
          <option value="<?= htmlspecialchars($k) ?>" <?= ($filter['kelas'] ?? '') === $k ? 'selected' : '' ?>>
            <?= htmlspecialchars($k) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="pab-filter-actions">
      <button type="submit" class="pab-filter-btn pab-filter-btn--apply">
        <i class="ti ti-filter" aria-hidden="true"></i>
        Terapkan
      </button>
      <a href="<?= BASE_URL ?>/admin/pab" class="pab-filter-btn pab-filter-btn--reset">
        Reset
      </a>
    </div>
  </form>

  <!-- Table panel -->
  <div class="pab-panel">
    <div class="pab-panel__head">
      <span class="pab-panel__head-title">Daftar Pendaftar</span>
      <span class="pab-panel__head-count"><?= count($list) ?> hasil</span>
    </div>

    <div class="pab-table-wrap">
      <table class="pab-table">
        <thead>
          <tr>
            <th>Pendaftar</th>
            <th>NISN</th>
            <th>No HP</th>
            <th>Tgl Daftar</th>
            <th>Status</th>
            <th>NIA</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($list)): ?>
          <tr>
            <td colspan="7" style="padding:0;border:none;">
              <div class="pab-empty">
                <div class="pab-empty__ico">
                  <i class="ti ti-user-search" aria-hidden="true"></i>
                </div>
                <div class="pab-empty__title">Belum ada pendaftar</div>
                <div class="pab-empty__sub">Tidak ada data yang cocok dengan filter saat ini</div>
              </div>
            </td>
          </tr>
          <?php endif; ?>
          <?php foreach ($list as $r): ?>
          <tr>
            <!-- Nama + avatar -->
            <td>
              <div class="pab-cell-name">
                <?php if (!empty($r['foto'])): ?>
                  <a href="<?= UPLOAD_URL . '/' . htmlspecialchars($r['foto']) ?>" target="_blank"
                     title="Lihat foto">
                    <img src="<?= UPLOAD_URL . '/' . htmlspecialchars($r['foto']) ?>"
                         class="pab-avatar" alt="<?= htmlspecialchars($r['nama_lengkap']) ?>">
                  </a>
                <?php else: ?>
                  <div class="pab-avatar-fallback">
                    <?= mb_strtoupper(mb_substr($r['nama_lengkap'], 0, 2)) ?>
                  </div>
                <?php endif; ?>
                <div>
                  <div class="pab-name"><?= htmlspecialchars($r['nama_lengkap']) ?></div>
                  <div class="pab-kelas"><?= htmlspecialchars($r['kelas']) ?></div>
                </div>
              </div>
            </td>

            <!-- NISN -->
            <td>
              <?php if (!empty($r['nisn'])): ?>
                <span class="pab-nisn"><?= htmlspecialchars($r['nisn']) ?></span>
              <?php else: ?>
                <span style="color:var(--tx-muted);">—</span>
              <?php endif; ?>
            </td>

            <!-- No HP -->
            <td>
              <?php if (!empty($r['no_hp'])): ?>
                <span style="font-size:11.5px;font-weight:500;">
                  <?= htmlspecialchars($r['no_hp']) ?>
                </span>
              <?php else: ?>
                <span style="color:var(--tx-muted);">—</span>
              <?php endif; ?>
            </td>

            <!-- Tgl Daftar -->
            <td>
              <span class="pab-date"><?= date('d/m/Y', strtotime($r['created_at'])) ?></span>
            </td>

            <!-- Status -->
            <td>
              <?php
                $badgeMap = [
                  'pending'  => ['cls' => 'pab-badge--pending',  'lbl' => 'Pending'],
                  'approved' => ['cls' => 'pab-badge--approved', 'lbl' => 'Disetujui'],
                  'rejected' => ['cls' => 'pab-badge--rejected', 'lbl' => 'Ditolak'],
                ];
                $b = $badgeMap[$r['status']] ?? ['cls' => 'pab-badge--pending', 'lbl' => ucfirst($r['status'])];
              ?>
              <span class="pab-badge <?= $b['cls'] ?>">
                <span class="pab-badge__dot"></span>
                <?= $b['lbl'] ?>
              </span>
            </td>

            <!-- NIA -->
            <td>
              <?php if (!empty($r['nia'])): ?>
                <span class="pab-nia"><?= htmlspecialchars($r['nia']) ?></span>
              <?php else: ?>
                <span class="pab-nia pab-nia--empty">—</span>
              <?php endif; ?>
            </td>

            <!-- Aksi -->
            <td>
              <div class="pab-actions">
                <?php if ($r['status'] === 'pending'): ?>
                  <!-- Approve -->
                  <form method="POST"
                        action="<?= BASE_URL ?>/admin/pab/<?= (int)$r['id'] ?>/approve"
                        onsubmit="return confirm('Setujui pendaftar ini dan generate NIA?')">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
                    <button type="submit" class="pab-btn pab-btn--approve">
                      <i class="ti ti-check" aria-hidden="true"></i>
                      Setujui
                    </button>
                  </form>
                  <!-- Reject -->
                  <button type="button" class="pab-btn pab-btn--reject"
                          onclick="openReject(<?= (int)$r['id'] ?>)">
                    <i class="ti ti-x" aria-hidden="true"></i>
                    Tolak
                  </button>
                <?php endif; ?>

                <?php if ($r['status'] !== 'approved'): ?>
                  <!-- Delete (hanya untuk pending/rejected — yang approved dikelola lewat halaman Anggota) -->
                  <button type="button" class="pab-btn pab-btn--delete"
                          onclick="openDelete(<?= (int)$r['id'] ?>, '<?= htmlspecialchars(addslashes($r['nama_lengkap'])) ?>')">
                    <i class="ti ti-trash" aria-hidden="true"></i>
                    Hapus
                  </button>
                <?php else: ?>
                  <span style="color:var(--tx-muted);font-size:11.5px;">—</span>
                <?php endif; ?>
              </div>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

</div><!-- /.pab-root -->

<!-- ── Modal Tolak ── -->
<div id="rejectModal" class="pab-modal-overlay">
  <div class="pab-modal">
    <div class="pab-modal__head">
      <div class="pab-modal__head-ico">
        <i class="ti ti-x" aria-hidden="true"></i>
      </div>
      <div>
        <div class="pab-modal__head-title">Tolak Pendaftar</div>
        <div class="pab-modal__head-sub">Berikan catatan alasan penolakan (opsional)</div>
      </div>
    </div>

    <form method="POST" id="rejectForm">
      <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
      <div class="pab-modal__body">
        <div>
          <label class="pab-modal__lbl" for="reject-catatan">Catatan</label>
          <textarea id="reject-catatan" name="catatan" rows="3"
                    class="pab-textarea"
                    placeholder="Alasan penolakan…"></textarea>
        </div>
      </div>
      <div class="pab-modal__foot">
        <button type="button" class="pab-btn pab-btn--cancel" onclick="closeReject()">
          Batal
        </button>
        <button type="submit" class="pab-btn pab-btn--reject">
          <i class="ti ti-x" aria-hidden="true"></i>
          Konfirmasi Tolak
        </button>
      </div>
    </form>
  </div>
</div>

<!-- ── Modal Hapus ── -->
<div id="deleteModal" class="pab-modal-overlay">
  <div class="pab-modal">
    <div class="pab-modal__head">
      <div class="pab-modal__head-ico">
        <i class="ti ti-trash" aria-hidden="true"></i>
      </div>
      <div>
        <div class="pab-modal__head-title">Hapus Data Pendaftar</div>
        <div class="pab-modal__head-sub">Tindakan ini tidak bisa dibatalkan</div>
      </div>
    </div>

    <form method="POST" id="deleteForm">
      <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
      <div class="pab-modal__body">
        <p style="font-size:12.5px;color:var(--tx-secondary);">
          Anda akan menghapus data pendaftaran PAB atas nama:
        </p>
        <div class="pab-modal__body-name" id="delete-nama">—</div>
      </div>
      <div class="pab-modal__foot">
        <button type="button" class="pab-btn pab-btn--cancel" onclick="closeDelete()">
          Batal
        </button>
        <button type="submit" class="pab-btn pab-btn--delete" style="border-color:var(--red-bd);">
          <i class="ti ti-trash" aria-hidden="true"></i>
          Ya, Hapus
        </button>
      </div>
    </form>
  </div>
</div>

<script>
(function () {
  'use strict';

  var rejectOverlay = document.getElementById('rejectModal');
  var deleteOverlay = document.getElementById('deleteModal');

  window.openReject = function (id) {
    document.getElementById('rejectForm').action =
      '<?= BASE_URL ?>/admin/pab/' + id + '/reject';
    rejectOverlay.classList.add('open');
    document.getElementById('reject-catatan').focus();
  };

  window.closeReject = function () {
    rejectOverlay.classList.remove('open');
  };

  window.openDelete = function (id, nama) {
    document.getElementById('deleteForm').action =
      '<?= BASE_URL ?>/admin/pab/' + id + '/delete';
    document.getElementById('delete-nama').textContent = nama;
    deleteOverlay.classList.add('open');
  };

  window.closeDelete = function () {
    deleteOverlay.classList.remove('open');
  };

  /* Close on backdrop click */
  [rejectOverlay, deleteOverlay].forEach(function (ov) {
    ov.addEventListener('click', function (e) {
      if (e.target === ov) { ov.classList.remove('open'); }
    });
  });

  /* Close on Escape */
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
      rejectOverlay.classList.remove('open');
      deleteOverlay.classList.remove('open');
    }
  });
}());
</script>