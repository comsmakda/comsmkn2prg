<?php
// app/views/admin/riwayat.php
// CRUD Riwayat Pengurus (Ketua & Pembina)
?>
<style>
/* ═══ selaras design system (settings/dashboard/absensi/berita) ═══
   PERBAIKAN BUG: token di-scope ke .riw-root (BUKAN :root global)
   supaya tidak bentrok/bocor ke halaman admin lain dalam layout yang sama. */
.riw-root {
  --font-ui:   var(--ff, 'Plus Jakarta Sans', sans-serif);
  --font-mono: var(--ff, 'Plus Jakarta Sans', sans-serif);

  --bg:    var(--c-page,  #eef2f6);
  --bg-s:  var(--c-white, #ffffff);
  --bg-e:  #f8fafc;
  --bg-o:  #eef2f6;

  --bd:    var(--c-border, #e6ebf1);
  --bd2:   rgba(15,23,42,.16);
  --bd-ac: var(--c-primary-lt, #06b6d4);

  --tx:  var(--c-ink,    #0f172a);
  --tx2: var(--c-muted,  #64748b);
  --tx3: var(--c-muted2, #94a3b8);

  --ac:   var(--c-primary,    #0e7490);
  --ac-d: var(--c-primary-08, rgba(14,116,144,.08));

  --grn:   var(--c-green-text, #15803d);
  --grn-d: var(--c-green-bg,   #f0fdf4);
  --red:   var(--c-red-text,   #b91c1c);
  --red-d: var(--c-red-bg,     #fef2f2);
  --amb:   var(--c-amber-icon, #d9910c);
  --amb-d: var(--c-amber-bg,   #fef6e2);
  --pur:   var(--c-primary-dk, #0b5a70);
  --pur-d: var(--c-primary-08, rgba(14,116,144,.08));

  --r:  var(--radius-sm, 9px);
  --r2: var(--radius-md, 13px);
  --r3: var(--radius-lg, 22px);
}

.riw-root { font-family: var(--font-ui); color: var(--tx); font-size:13px; }
.riw-root *, .riw-root *::before, .riw-root *::after { box-sizing:border-box; margin:0; padding:0; }

/* ── Page header ── */
.riw-ph { display:flex; align-items:flex-start; justify-content:space-between; gap:16px; flex-wrap:wrap; margin-bottom:24px; }
.riw-ph__eye { font-family:var(--font-mono); font-size:11px; font-weight:700; letter-spacing:.1em; text-transform:uppercase; color:var(--ac); display:inline-flex; align-items:center; gap:7px; margin-bottom:6px; }
.riw-ph__eye::before { content:''; width:6px; height:6px; border-radius:50%; background:var(--ac); box-shadow:0 0 8px var(--ac); }
.riw-ph__title { font-size:24px; font-weight:800; letter-spacing:-.03em; line-height:1.1; color:var(--pur); }
.riw-ph__sub   { font-size:13px; color:var(--tx2); margin-top:5px; }

/* ── Flash ── */
.riw-flash { display:flex; align-items:center; gap:10px; padding:11px 15px; border-radius:var(--r); font-size:12.5px; font-weight:600; border:1px solid transparent; margin-bottom:20px; }
.riw-flash--success { background:var(--grn-d); color:var(--grn); border-color: rgba(21,128,61,.22); }
.riw-flash--error   { background:var(--red-d); color:var(--red); border-color: rgba(185,28,28,.22); }

/* ── Tabs (disiapkan untuk pemakaian mendatang) ── */
.riw-tabs { display:flex; gap:2px; background:var(--bg-s); border:1px solid var(--bd); border-radius:var(--r2); padding:4px; margin-bottom:20px; flex-wrap:wrap; }
.riw-tab  { display:flex; align-items:center; gap:7px; padding:8px 14px; border-radius:var(--r); font-size:12px; font-weight:700; color:var(--tx3); cursor:pointer; border:none; background:none; transition:all 160ms; white-space:nowrap; }
.riw-tab:hover  { color:var(--tx2); background:var(--bg-e); }
.riw-tab.active { background:var(--ac); color:#fff; box-shadow: 0 3px 12px rgba(14,116,144,.25); }

/* ── Card ── */
.riw-card { background:var(--bg-s); border:1px solid var(--bd); border-radius:var(--r3); overflow:hidden; margin-bottom:16px; }
.riw-card__head { display:flex; align-items:center; gap:12px; padding:14px 18px; border-bottom:1px solid var(--bd); }
.riw-card__ico { width:32px; height:32px; border-radius:var(--r); display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.riw-card__ico--blue   { background:var(--ac-d);  color:var(--ac); }
.riw-card__ico--purple { background:var(--pur-d); color:var(--pur); }
.riw-card__ico svg { width:15px; height:15px; }
.riw-card__title { font-size:13px; font-weight:800; letter-spacing:-.01em; }
.riw-card__desc  { font-size:11.5px; color:var(--tx3); margin-top:2px; }
.riw-card__body  { padding:18px; }

/* ── Form ── */
.riw-form { display:flex; flex-direction:column; gap:14px; }
.fg       { display:flex; flex-direction:column; gap:6px; }
.fg--2    { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
.fg--3    { display:grid; grid-template-columns:1fr 1fr 1fr; gap:12px; }
@media(max-width:680px){ .fg--2,.fg--3 { grid-template-columns:1fr; } }

label.lbl { font-size:11.5px; font-weight:700; color:var(--tx2); letter-spacing:.01em; display:flex; align-items:center; gap:6px; }
.lbl__hint { font-family:var(--font-mono); font-size:10px; color:var(--tx3); font-weight:400; margin-left:auto; }

input[type="text"].fi, input[type="number"].fi, select.fi, textarea.fi {
  width:100%; font-family:var(--font-ui); font-size:12.5px; color:var(--tx);
  background:#fbfcfe; border:1.5px solid var(--bd); border-radius:var(--r);
  padding:10px 12px; outline:none; display:block;
  transition:border-color 140ms, background 140ms, box-shadow 140ms;
}
input.fi:focus, select.fi:focus, textarea.fi:focus {
  border-color:var(--bd-ac); background:#fff;
  box-shadow: 0 0 0 3px rgba(6,182,212,.12);
}
input.fi::placeholder, textarea.fi::placeholder { color:var(--tx3); }
textarea.fi { resize:vertical; min-height:60px; line-height:1.65; }

.fdiv { height:1px; background:var(--bd); }

/* ── Image upload ── */
.img-upload { display:flex; align-items:center; gap:14px; }
.img-thumb  { width:64px; height:64px; border-radius:50%; border:1px solid var(--bd); object-fit:cover; flex-shrink:0; background:var(--bg-o); }
.img-thumb--empty { display:flex; align-items:center; justify-content:center; color:var(--tx3); }
.img-thumb--empty svg { width:22px; height:22px; opacity:.5; }
.img-upload__area { flex:1; display:flex; flex-direction:column; gap:6px; }
.img-upload__btn { display:inline-flex; align-items:center; gap:7px; padding:8px 13px; background:var(--bg-e); color:var(--tx2); font-family:var(--font-ui); font-size:12px; font-weight:700; border:1.5px solid var(--bd); border-radius:var(--r); cursor:pointer; transition:all 140ms; width:fit-content; }
.img-upload__btn:hover { border-color:var(--bd-ac); color:var(--ac); background:var(--ac-d); }
.img-upload__btn svg { width:12px; height:12px; }
.img-upload__name { font-family:var(--font-mono); font-size:10.5px; color:var(--tx3); }
input[type="file"].fhidden { position:absolute; width:1px; height:1px; overflow:hidden; clip:rect(0,0,0,0); white-space:nowrap; border:0; }

/* ── Buttons ── */
.btn-prim { display:inline-flex; align-items:center; gap:8px; padding:10px 20px; background:var(--ac); color:#fff; font-family:var(--font-ui); font-size:12.5px; font-weight:800; border-radius:var(--r); border:none; cursor:pointer; transition:all 150ms; text-decoration:none; box-shadow: 0 8px 20px rgba(14,116,144,.22); }
.btn-prim:hover { background:var(--bd-ac); box-shadow: 0 12px 26px rgba(6,182,212,.3); }
.btn-prim svg { width:13px; height:13px; }

.btn-out  { display:inline-flex; align-items:center; gap:7px; padding:8px 16px; background:var(--bg-s); color:var(--tx2); font-size:12px; font-weight:700; border:1.5px solid var(--bd); border-radius:var(--r); cursor:pointer; text-decoration:none; transition:all 150ms; }
.btn-out:hover { border-color:var(--bd-ac); color:var(--ac); background:var(--ac-d); }

.btn-red  { display:inline-flex; align-items:center; gap:7px; padding:7px 14px; background:var(--red-d); color:var(--red); font-size:12px; font-weight:700; border:1px solid rgba(185,28,28,.22); border-radius:var(--r); cursor:pointer; text-decoration:none; transition:all 150ms; }
.btn-red:hover { background:rgba(185,28,28,.14); border-color:rgba(185,28,28,.4); }

/* ── Table pengurus ── */
.riw-table { width:100%; border-collapse:collapse; }
.riw-table th { font-family:var(--font-mono); font-size:10.5px; font-weight:700; letter-spacing:.1em; text-transform:uppercase; color:var(--tx3); padding:11px 12px; text-align:left; background:var(--bg-e); border-bottom:1px solid var(--bd); }
.riw-table td { padding:11px 12px; border-bottom:1px solid var(--bd); font-size:12.5px; color:var(--tx2); vertical-align:middle; }
.riw-table tr:last-child td { border-bottom:none; }
.riw-table tr:hover td { background: rgba(14,116,144,.035); }
.riw-table__avatar { width:36px; height:36px; border-radius:50%; object-fit:cover; }
.riw-table__avatar-ph { width:36px; height:36px; border-radius:50%; background:linear-gradient(135deg, var(--ac), var(--pur)); display:flex; align-items:center; justify-content:center; font-weight:800; font-size:.65rem; color:#fff; }
.riw-badge { display:inline-flex; align-items:center; padding:3px 10px; border-radius:99px; font-family:var(--font-mono); font-size:.65rem; font-weight:700; letter-spacing:.05em; }
.riw-badge--ketua   { background:var(--ac-d);  color:var(--ac);  border:1px solid rgba(14,116,144,.2); }
.riw-badge--pembina { background:var(--pur-d); color:var(--pur); border:1px solid rgba(11,90,112,.2); }
.riw-actions { display:flex; gap:6px; align-items:center; }

/* ── Empty state ── */
.riw-empty { text-align:center; padding:40px 20px; color:var(--tx3); font-size:12.5px; }
.riw-empty svg { margin-bottom:12px; opacity:.35; }
</style>

<div class="riw-root">

<!-- ── Page header ── -->
<div class="riw-ph">
  <div>
    <div class="riw-ph__eye">Admin Panel</div>
    <h1 class="riw-ph__title">Riwayat Pengurus</h1>
    <p class="riw-ph__sub">Kelola daftar Ketua Organisasi &amp; Guru Pembina dari periode ke periode.</p>
  </div>
  <div style="display:flex;gap:8px;flex-wrap:wrap">
    <a href="<?= BASE_URL ?>/admin/settings#riwayat" class="btn-out">
      <svg width="12" height="12" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12L4 7l5-5"/></svg>
      Kembali ke Settings
    </a>
    <a href="#form-tambah" class="btn-prim">
      <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M7 1v12M1 7h12"/></svg>
      Tambah Baru
    </a>
  </div>
</div>

<!-- ── Flash ── -->
<?php if (!empty($flash)): ?>
<div class="riw-flash riw-flash--<?= htmlspecialchars($flash['type']) ?>">
  <?= htmlspecialchars($flash['msg']) ?>
</div>
<?php endif; ?>

<!-- ════════════════════════════════════════
     TABEL DAFTAR
════════════════════════════════════════ -->
<?php
  $ketuaRows   = array_filter($list ?? [], fn($r) => $r['tipe'] === 'ketua');
  $pembinaRows = array_filter($list ?? [], fn($r) => $r['tipe'] === 'pembina');
?>

<!-- Ketua -->
<div class="riw-card">
  <div class="riw-card__head">
    <div class="riw-card__ico riw-card__ico--blue">
      <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M7 1l1.7 3.5L13 5.3l-3 2.9.7 4.1L7 10.4 3.3 12.4l.7-4.1-3-2.9 4.3-.8L7 1z"/></svg>
    </div>
    <div>
      <div class="riw-card__title">Daftar Ketua Organisasi</div>
      <div class="riw-card__desc">Urutan 0 = tampil paling atas (terkini)</div>
    </div>
  </div>
  <div class="riw-card__body" style="padding:0">
    <?php if (count($ketuaRows)): ?>
    <table class="riw-table">
      <thead>
        <tr>
          <th>Urutan</th>
          <th>Foto</th>
          <th>Nama</th>
          <th>Jabatan</th>
          <th>Periode</th>
          <th>Catatan</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($ketuaRows as $r): ?>
        <tr>
          <td style="text-align:center;font-family:var(--font-mono);font-size:11px">
            <?= (int)$r['urutan'] ?>
          </td>
          <td>
            <?php if (!empty($r['foto'])): ?>
              <img src="<?= UPLOAD_URL . '/' . htmlspecialchars($r['foto']) ?>"
                   class="riw-table__avatar" alt="<?= htmlspecialchars($r['nama']) ?>">
            <?php else: ?>
              <div class="riw-table__avatar-ph"><?= strtoupper(mb_substr($r['nama'],0,2)) ?></div>
            <?php endif; ?>
          </td>
          <td style="font-weight:700;color:var(--tx)"><?= htmlspecialchars($r['nama']) ?></td>
          <td><?= htmlspecialchars($r['jabatan']) ?></td>
          <td>
            <span class="riw-badge riw-badge--ketua"><?= htmlspecialchars($r['periode']) ?></span>
          </td>
          <td style="font-size:11.5px;color:var(--tx3);max-width:180px">
            <?= htmlspecialchars($r['catatan'] ?? '') ?>
          </td>
          <td>
            <div class="riw-actions">
              <a href="<?= BASE_URL ?>/admin/riwayat/<?= $r['id'] ?>/edit" class="btn-out" style="padding:5px 12px;font-size:11px">Edit</a>
              <form method="POST" action="<?= BASE_URL ?>/admin/riwayat/<?= $r['id'] ?>/delete"
                    onsubmit="return confirm('Hapus data ini?')" style="margin:0">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
                <button type="submit" class="btn-red" style="padding:5px 12px;font-size:11px">Hapus</button>
              </form>
            </div>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <?php else: ?>
    <div class="riw-empty">
      <svg width="36" height="36" fill="none" stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M8 12h8M12 8v8"/></svg>
      <p>Belum ada data ketua. Tambahkan di form bawah.</p>
    </div>
    <?php endif; ?>
  </div>
</div>

<!-- Pembina -->
<div class="riw-card">
  <div class="riw-card__head">
    <div class="riw-card__ico riw-card__ico--purple">
      <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="7" cy="5" r="3"/><path d="M1 13c0-3.3 2.7-6 6-6s6 2.7 6 6"/></svg>
    </div>
    <div>
      <div class="riw-card__title">Daftar Guru Pembina</div>
      <div class="riw-card__desc">Urutan 0 = tampil paling atas (terkini)</div>
    </div>
  </div>
  <div class="riw-card__body" style="padding:0">
    <?php if (count($pembinaRows)): ?>
    <table class="riw-table">
      <thead>
        <tr>
          <th>Urutan</th>
          <th>Foto</th>
          <th>Nama</th>
          <th>Jabatan</th>
          <th>Periode</th>
          <th>Catatan</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($pembinaRows as $r): ?>
        <tr>
          <td style="text-align:center;font-family:var(--font-mono);font-size:11px">
            <?= (int)$r['urutan'] ?>
          </td>
          <td>
            <?php if (!empty($r['foto'])): ?>
              <img src="<?= UPLOAD_URL . '/' . htmlspecialchars($r['foto']) ?>"
                   class="riw-table__avatar" alt="<?= htmlspecialchars($r['nama']) ?>">
            <?php else: ?>
              <div class="riw-table__avatar-ph" style="background:linear-gradient(135deg, var(--pur), var(--ac))">
                <?= strtoupper(mb_substr($r['nama'],0,2)) ?>
              </div>
            <?php endif; ?>
          </td>
          <td style="font-weight:700;color:var(--tx)"><?= htmlspecialchars($r['nama']) ?></td>
          <td><?= htmlspecialchars($r['jabatan']) ?></td>
          <td>
            <span class="riw-badge riw-badge--pembina"><?= htmlspecialchars($r['periode']) ?></span>
          </td>
          <td style="font-size:11.5px;color:var(--tx3);max-width:180px">
            <?= htmlspecialchars($r['catatan'] ?? '') ?>
          </td>
          <td>
            <div class="riw-actions">
              <a href="<?= BASE_URL ?>/admin/riwayat/<?= $r['id'] ?>/edit" class="btn-out" style="padding:5px 12px;font-size:11px">Edit</a>
              <form method="POST" action="<?= BASE_URL ?>/admin/riwayat/<?= $r['id'] ?>/delete"
                    onsubmit="return confirm('Hapus data ini?')" style="margin:0">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
                <button type="submit" class="btn-red" style="padding:5px 12px;font-size:11px">Hapus</button>
              </form>
            </div>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <?php else: ?>
    <div class="riw-empty">
      <svg width="36" height="36" fill="none" stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M8 12h8M12 8v8"/></svg>
      <p>Belum ada data pembina. Tambahkan di form bawah.</p>
    </div>
    <?php endif; ?>
  </div>
</div>


<!-- ════════════════════════════════════════
     FORM TAMBAH / EDIT
════════════════════════════════════════ -->
<?php
  // Edit mode: jika $editData ada (di-set controller saat GET /admin/riwayat/{id}/edit)
  $editMode = isset($editData) && $editData !== null;
  $formAction = $editMode
    ? BASE_URL . '/admin/riwayat/' . $editData['id'] . '/update'
    : BASE_URL . '/admin/riwayat/store';
  $ed = $editData ?? [];
?>

<div class="riw-card" id="form-tambah">
  <div class="riw-card__head">
    <div class="riw-card__ico <?= $editMode ? 'riw-card__ico--purple' : 'riw-card__ico--blue' ?>">
      <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
        <?php if ($editMode): ?>
          <path d="M9.5 2.5l2 2L5 11H3v-2l6.5-6.5z"/>
        <?php else: ?>
          <path d="M7 1v12M1 7h12"/>
        <?php endif; ?>
      </svg>
    </div>
    <div>
      <div class="riw-card__title"><?= $editMode ? 'Edit Data Pengurus' : 'Tambah Pengurus Baru' ?></div>
      <div class="riw-card__desc">
        <?= $editMode
            ? 'Ubah data ' . htmlspecialchars($editData['nama'])
            : 'Isi form berikut untuk menambahkan ketua atau pembina.' ?>
      </div>
    </div>
  </div>
  <div class="riw-card__body">

    <form method="POST" action="<?= $formAction ?>" enctype="multipart/form-data" class="riw-form">
      <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">

      <!-- Tipe -->
      <div class="fg">
        <label class="lbl" for="f-riw-tipe">Tipe Pengurus</label>
        <select id="f-riw-tipe" name="tipe" class="fi">
          <option value="ketua"   <?= ($ed['tipe'] ?? '') === 'ketua'   ? 'selected' : '' ?>>Ketua Organisasi</option>
          <option value="pembina" <?= ($ed['tipe'] ?? '') === 'pembina' ? 'selected' : '' ?>>Guru Pembina</option>
        </select>
      </div>

      <div class="fdiv"></div>

      <!-- Foto -->
      <div class="fg">
        <label class="lbl">Foto <span class="lbl__hint">Rasio 1:1 / foto formal</span></label>
        <div class="img-upload">
          <?php if (!empty($ed['foto'])): ?>
            <img src="<?= UPLOAD_URL . '/' . htmlspecialchars($ed['foto']) ?>"
                 class="img-thumb" id="prev-riw-foto" alt="Foto">
          <?php else: ?>
            <div class="img-thumb img-thumb--empty" id="prev-riw-foto-empty">
              <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.2">
                <circle cx="10" cy="7" r="4"/><path d="M2 18c0-4.4 3.6-8 8-8s8 3.6 8 8"/>
              </svg>
            </div>
            <img src="" class="img-thumb" id="prev-riw-foto" style="display:none" alt="Preview">
          <?php endif; ?>
          <div class="img-upload__area">
            <label for="f-riw-foto" class="img-upload__btn">
              <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round">
                <path d="M7 9V1M4 4l3-3 3 3M1 11v1a1 1 0 001 1h10a1 1 0 001-1v-1"/>
              </svg>
              Pilih Foto
            </label>
            <input type="file" id="f-riw-foto" name="foto" accept="image/*" class="fhidden"
                   data-preview="prev-riw-foto"
                   data-empty="prev-riw-foto-empty"
                   data-name="fname-riw-foto">
            <span class="img-upload__name" id="fname-riw-foto">
              <?= !empty($ed['foto']) ? htmlspecialchars(basename($ed['foto'])) : 'Belum ada file' ?>
            </span>
          </div>
        </div>
      </div>

      <div class="fdiv"></div>

      <div class="fg--2">
        <div class="fg">
          <label class="lbl" for="f-riw-nama">Nama Lengkap <span class="lbl__hint">wajib</span></label>
          <input id="f-riw-nama" name="nama" type="text" class="fi"
                 placeholder="Nama lengkap dengan gelar..."
                 value="<?= htmlspecialchars($ed['nama'] ?? '') ?>" required>
        </div>
        <div class="fg">
          <label class="lbl" for="f-riw-jabatan">Jabatan</label>
          <input id="f-riw-jabatan" name="jabatan" type="text" class="fi"
                 placeholder="Ketua Umum / Guru Pembina"
                 value="<?= htmlspecialchars($ed['jabatan'] ?? '') ?>">
        </div>
      </div>

      <div class="fg">
        <label class="lbl" for="f-riw-periode">Periode / Masa Jabatan <span class="lbl__hint">wajib — contoh: 2024/2025 atau 2022–2024</span></label>
        <input id="f-riw-periode" name="periode" type="text" class="fi"
               placeholder="2024/2025"
               value="<?= htmlspecialchars($ed['periode'] ?? '') ?>" required>
      </div>

      <div class="fg--3">
        <div class="fg">
          <label class="lbl" for="f-riw-dari">Tahun Mulai <span class="lbl__hint">untuk sorting</span></label>
          <input id="f-riw-dari" name="tahun_dari" type="number" class="fi"
                 placeholder="2024" min="2000" max="2099"
                 value="<?= htmlspecialchars($ed['tahun_dari'] ?? '') ?>">
        </div>
        <div class="fg">
          <label class="lbl" for="f-riw-sampai">Tahun Selesai <span class="lbl__hint">kosong = masih menjabat</span></label>
          <input id="f-riw-sampai" name="tahun_sampai" type="number" class="fi"
                 placeholder="2025" min="2000" max="2099"
                 value="<?= htmlspecialchars($ed['tahun_sampai'] ?? '') ?>">
        </div>
        <div class="fg">
          <label class="lbl" for="f-riw-urutan">Urutan Tampil <span class="lbl__hint">0 = teratas</span></label>
          <input id="f-riw-urutan" name="urutan" type="number" class="fi"
                 placeholder="0" min="0" max="99"
                 value="<?= htmlspecialchars($ed['urutan'] ?? '0') ?>">
        </div>
      </div>

      <div class="fg">
        <label class="lbl" for="f-riw-catatan">Catatan / Keterangan <span class="lbl__hint">opsional</span></label>
        <textarea id="f-riw-catatan" name="catatan" rows="2" class="fi"
                  placeholder="Prestasi, jabatan tambahan, dll."><?= htmlspecialchars($ed['catatan'] ?? '') ?></textarea>
      </div>

      <div style="display:flex;gap:10px;flex-wrap:wrap;padding-top:4px">
        <button type="submit" class="btn-prim">
          <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M2 8v3.5A.5.5 0 002.5 12h9a.5.5 0 00.5-.5V8M7 1v7M4.5 5.5L7 8l2.5-2.5"/>
          </svg>
          <?= $editMode ? 'Simpan Perubahan' : 'Tambahkan' ?>
        </button>
        <?php if ($editMode): ?>
        <a href="<?= BASE_URL ?>/admin/riwayat" class="btn-out">Batal Edit</a>
        <?php endif; ?>
      </div>

    </form>

  </div>
</div>

</div><!-- /.riw-root -->

<script>
/* ── Image preview ── */
document.querySelectorAll('input[type="file"].fhidden').forEach(inp => {
  inp.addEventListener('change', () => {
    const file = inp.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
      const img   = document.getElementById(inp.dataset.preview);
      const empty = document.getElementById(inp.dataset.empty);
      const name  = document.getElementById(inp.dataset.name);
      if (img)   { img.src = e.target.result; img.style.display = 'block'; }
      if (empty)   empty.style.display = 'none';
      if (name)    name.textContent = file.name;
    };
    reader.readAsDataURL(file);
  });
});
</script>