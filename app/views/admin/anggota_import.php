<?php // app/views/admin/anggota_import.php ?>

<style>
.imp-root {
  --font-ui: var(--ff, 'Plus Jakarta Sans', sans-serif);
  --bg-surface:  var(--c-white, #ffffff);
  --bg-elevated: #f8fafc;
  --bd-subtle:   var(--c-border, #e6ebf1);
  --bd-accent:   var(--c-primary-25, rgba(14,116,144,.25));
  --tx-primary:   var(--c-ink,   #0f172a);
  --tx-secondary: var(--c-muted, #64748b);
  --tx-muted:     var(--c-muted2,#94a3b8);
  --ac:      var(--c-primary,    #0e7490);
  --ac-dim:  var(--c-primary-08, rgba(14,116,144,.08));
  --amber:   var(--c-amber-icon, #d9910c);
  --amber-d: var(--c-amber-bg,   #fef6e2);
  --green:   var(--c-green-text, #15803d);
  --green-d: var(--c-green-bg,   #f0fdf4);
  --red:     var(--c-red-text,   #b91c1c);
  --red-d:   var(--c-red-bg,     #fef2f2);
  --r-sm: var(--radius-sm, 9px);
  --r-md: var(--radius-sm, 9px);
  --r-lg: var(--radius-md, 13px);
  --r-xl: var(--radius-lg, 22px);
  --ease: cubic-bezier(0.22,1,0.36,1);
  --t-fast: 120ms; --t-base: 160ms;
}
.imp-root * { box-sizing: border-box; margin: 0; padding: 0; }
.imp-root a { text-decoration: none; color: inherit; }
.imp-root { font-family: var(--font-ui); color: var(--tx-primary); font-size: 13.5px; line-height: 1.5; }

.imp-back {
  display: inline-flex; align-items: center; gap: 6px;
  font-size: 12px; font-weight: 700; color: var(--tx-muted);
  margin-bottom: 14px; transition: color var(--t-fast) var(--ease);
}
.imp-back:hover { color: var(--ac); }
.imp-back i { font-size: 14px; }

.imp-head { margin-bottom: 24px; }
.imp-eyebrow {
  display: inline-flex; align-items: center; gap: 7px;
  font-size: 11px; font-weight: 700; letter-spacing: .1em; text-transform: uppercase;
  color: var(--ac); margin-bottom: 7px;
}
.imp-eyebrow::before { content:''; width:6px; height:6px; border-radius:50%; background:var(--ac); box-shadow:0 0 6px var(--ac); }
.imp-title { font-size: 24px; font-weight: 800; letter-spacing: -.03em; color: var(--c-primary-dk, #0b5a70); }
.imp-sub { font-size: 12.5px; color: var(--tx-secondary); margin-top: 5px; }

.imp-grid {
  display: grid;
  grid-template-columns: 1fr 1.3fr;
  gap: 18px;
  align-items: start;
}
@media (max-width: 860px) { .imp-grid { grid-template-columns: 1fr; } }

.imp-card {
  background: var(--bg-surface);
  border: 1px solid var(--bd-subtle);
  border-radius: var(--r-xl);
  padding: 22px;
}
.imp-card__title {
  font-size: 13px; font-weight: 800; color: var(--tx-primary);
  display: flex; align-items: center; gap: 8px; margin-bottom: 14px;
}
.imp-card__title i { font-size: 16px; color: var(--ac); }

/* ── Kolom kiri: instruksi ── */
.imp-steps { display: flex; flex-direction: column; gap: 14px; margin-bottom: 18px; }
.imp-step { display: flex; gap: 11px; }
.imp-step__num {
  width: 24px; height: 24px; border-radius: 50%;
  background: var(--ac-dim); color: var(--ac);
  font-size: 11.5px; font-weight: 800;
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
}
.imp-step__text { font-size: 12.5px; color: var(--tx-secondary); padding-top: 3px; }
.imp-step__text strong { color: var(--tx-primary); }

.imp-cols {
  background: var(--bg-elevated);
  border: 1px solid var(--bd-subtle);
  border-radius: var(--r-lg);
  padding: 12px 14px;
  margin-bottom: 18px;
}
.imp-cols__label { font-size: 10.5px; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; color: var(--tx-muted); margin-bottom: 8px; }
.imp-cols__list { display: flex; flex-wrap: wrap; gap: 6px; }
.imp-col-chip {
  font-size: 11px; font-weight: 700; padding: 4px 10px;
  border-radius: var(--r-sm); background: var(--bg-surface); border: 1px solid var(--bd-subtle); color: var(--tx-secondary);
}
.imp-col-chip--opt { color: var(--tx-muted); font-weight: 600; }

.imp-notice {
  display: flex; gap: 10px; padding: 12px 14px;
  background: var(--amber-d); border: 1px solid rgba(217,145,12,.25);
  border-radius: var(--r-lg); font-size: 11.5px; color: var(--c-amber-text, #8a5a06);
  line-height: 1.55; margin-bottom: 16px;
}
.imp-notice i { font-size: 15px; flex-shrink: 0; margin-top: 1px; }
.imp-notice strong { font-weight: 800; }

.btn-template {
  display: inline-flex; align-items: center; gap: 7px;
  padding: 9px 15px; font-size: 12.5px; font-weight: 700;
  background: var(--bg-surface); color: var(--ac);
  border: 1.5px solid var(--bd-accent); border-radius: var(--r-md);
  cursor: pointer; transition: all var(--t-fast) var(--ease);
}
.btn-template:hover { background: var(--ac-dim); }
.btn-template i { font-size: 14px; }

/* ── Kolom kanan: dropzone ──
   PENTING: .imp-drop adalah tag <label>, yang default-nya display:inline.
   Karena isinya berupa <div> (block), border dashed jadi pecah mengikuti
   baris teks kalau tidak dipaksa jadi block/flex. Makanya di sini WAJIB
   diberi display:flex (bukan cuma text-align:center) supaya border-nya
   menyatu jadi satu kotak utuh, bukan terpecah jadi beberapa kotak kecil. */
.imp-drop {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  border: 2px dashed var(--bd-subtle);
  border-radius: var(--r-lg);
  padding: 34px 20px;
  text-align: center;
  cursor: pointer;
  transition: all var(--t-base) var(--ease);
  background: var(--bg-elevated);
}
.imp-drop:hover, .imp-drop.is-drag { border-color: var(--ac); background: var(--ac-dim); }
.imp-drop__ico { font-size: 30px; color: var(--ac); margin-bottom: 10px; }
.imp-drop__title { font-size: 13px; font-weight: 700; color: var(--tx-primary); margin-bottom: 4px; }
.imp-drop__sub { font-size: 11.5px; color: var(--tx-muted); }
.imp-drop input[type="file"] { display: none; }

.imp-file-preview {
  display: none;
  align-items: center; gap: 10px;
  padding: 11px 13px; margin-top: 14px;
  background: var(--bg-elevated); border: 1px solid var(--bd-subtle);
  border-radius: var(--r-md);
}
.imp-file-preview.is-visible { display: flex; }
.imp-file-preview__ico {
  width: 32px; height: 32px; border-radius: var(--r-sm);
  background: var(--green-d); color: var(--green);
  display: flex; align-items: center; justify-content: center; font-size: 15px; flex-shrink: 0;
}
.imp-file-preview__name { font-size: 12.5px; font-weight: 700; color: var(--tx-primary); word-break: break-all; }
.imp-file-preview__remove { margin-left: auto; color: var(--tx-muted); cursor: pointer; font-size: 15px; flex-shrink: 0; }
.imp-file-preview__remove:hover { color: var(--red); }

.imp-actions { display: flex; justify-content: flex-end; gap: 8px; margin-top: 18px; }
.imp-btn-cancel {
  padding: 10px 17px; font-size: 12.5px; font-weight: 700; color: var(--tx-secondary);
  background: var(--bg-surface); border: 1px solid var(--bd-subtle); border-radius: var(--r-md); cursor: pointer;
}
.imp-btn-submit {
  display: inline-flex; align-items: center; gap: 7px;
  padding: 10px 18px; font-size: 12.5px; font-weight: 700; color: #fff;
  background: var(--ac); border: none; border-radius: var(--r-md); cursor: pointer;
  box-shadow: 0 6px 16px rgba(14,116,144,.22);
}
.imp-btn-submit:disabled { opacity: .5; cursor: not-allowed; }
.imp-btn-submit i { font-size: 14px; }

/* ── error list ── */
.imp-errlist {
  margin-top: 16px;
  border: 1px solid var(--red-d);
  background: var(--red-d);
  border-radius: var(--r-lg);
  padding: 13px 16px;
}
.imp-errlist__title { font-size: 11.5px; font-weight: 800; color: var(--red); margin-bottom: 8px; }
.imp-errlist ul { list-style: none; display: flex; flex-direction: column; gap: 4px; max-height: 180px; overflow-y: auto; }
.imp-errlist li { font-size: 11.5px; color: var(--c-red-text, #b91c1c); }
</style>

<div class="imp-root">

  <a href="<?= BASE_URL ?>/admin/anggota" class="imp-back">
    <i class="ti ti-arrow-left" aria-hidden="true"></i> Kembali ke Anggota
  </a>

  <div class="imp-head">
    <div class="imp-eyebrow">Manajemen Data</div>
    <h1 class="imp-title">Impor Anggota</h1>
    <p class="imp-sub">Tambahkan banyak anggota sekaligus dari file CSV atau Excel.</p>
  </div>

  <div class="imp-grid">

    <!-- ── KIRI: Instruksi ── -->
    <div class="imp-card">
      <div class="imp-card__title"><i class="ti ti-info-circle" aria-hidden="true"></i> Cara Import</div>

      <div class="imp-steps">
        <div class="imp-step">
          <div class="imp-step__num">1</div>
          <div class="imp-step__text">Unduh <strong>template CSV</strong> di bawah, isi sesuai kolom yang tersedia.</div>
        </div>
        <div class="imp-step">
          <div class="imp-step__num">2</div>
          <div class="imp-step__text">Simpan file sebagai <strong>.csv</strong> atau <strong>.xlsx</strong>.</div>
        </div>
        <div class="imp-step">
          <div class="imp-step__num">3</div>
          <div class="imp-step__text">Upload di panel sebelah kanan, lalu klik <strong>Impor Sekarang</strong>.</div>
        </div>
      </div>

      <div class="imp-cols">
        <div class="imp-cols__label">Urutan Kolom (baris pertama = header)</div>
        <div class="imp-cols__list">
          <span class="imp-col-chip">1. Nama Lengkap</span>
          <span class="imp-col-chip">2. Kelas</span>
          <span class="imp-col-chip">3. No HP</span>
          <span class="imp-col-chip imp-col-chip--opt">4. Email (opsional)</span>
          <span class="imp-col-chip imp-col-chip--opt">5. Tahun Daftar (opsional)</span>
        </div>
      </div>

      <div class="imp-notice">
        <i class="ti ti-shield-lock" aria-hidden="true"></i>
        <div>
          <strong>Password tidak diimpor.</strong> Semua anggota baru dari import akan
          diberi password default <strong>comsmakda</strong>. NIA digenerate otomatis
          mengikuti kolom <strong>Tahun Daftar</strong> di tiap baris — kosongkan kolom itu
          kalau mau pakai tahun berjalan. Baris dengan email/No HP yang sudah terdaftar
          akan otomatis dilewati.
        </div>
      </div>

      <a href="<?= BASE_URL ?>/admin/anggota/import/template" class="btn-template">
        <i class="ti ti-download" aria-hidden="true"></i>
        Unduh Template CSV
      </a>
    </div>

    <!-- ── KANAN: Upload ── -->
    <div class="imp-card">
      <div class="imp-card__title"><i class="ti ti-file-upload" aria-hidden="true"></i> Upload File</div>

      <form method="POST" action="<?= BASE_URL ?>/admin/anggota/import" enctype="multipart/form-data" id="import-form">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">

        <label class="imp-drop" id="imp-drop" for="imp-file-input">
          <div class="imp-drop__ico"><i class="ti ti-cloud-upload" aria-hidden="true"></i></div>
          <div class="imp-drop__title">Klik atau seret file ke sini</div>
          <div class="imp-drop__sub">Format .csv atau .xlsx, maks 5MB</div>
          <input type="file" name="file" id="imp-file-input" accept=".csv,.xlsx">
        </label>

        <div class="imp-file-preview" id="imp-file-preview">
          <div class="imp-file-preview__ico"><i class="ti ti-file-check" aria-hidden="true"></i></div>
          <div class="imp-file-preview__name" id="imp-file-name">—</div>
          <i class="ti ti-x imp-file-preview__remove" id="imp-file-remove" aria-hidden="true"></i>
        </div>

        <?php if (!empty($importErrors)): ?>
        <div class="imp-errlist">
          <div class="imp-errlist__title">
            <?= count($importErrors) ?> baris dilewati pada proses import sebelumnya:
          </div>
          <ul>
            <?php foreach ($importErrors as $e): ?>
              <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
        <?php endif; ?>

        <div class="imp-actions">
          <a href="<?= BASE_URL ?>/admin/anggota" class="imp-btn-cancel">Batal</a>
          <button type="submit" class="imp-btn-submit" id="imp-submit-btn" disabled>
            <i class="ti ti-upload" aria-hidden="true"></i>
            Impor Sekarang
          </button>
        </div>
      </form>
    </div>

  </div>
</div>

<script>
(function () {
  'use strict';

  var drop      = document.getElementById('imp-drop');
  var input     = document.getElementById('imp-file-input');
  var preview   = document.getElementById('imp-file-preview');
  var nameEl    = document.getElementById('imp-file-name');
  var removeBtn = document.getElementById('imp-file-remove');
  var submitBtn = document.getElementById('imp-submit-btn');

  function showFile(file) {
    nameEl.textContent = file.name + ' (' + (file.size / 1024).toFixed(0) + ' KB)';
    preview.classList.add('is-visible');
    submitBtn.disabled = false;
  }

  function clearFile() {
    input.value = '';
    preview.classList.remove('is-visible');
    submitBtn.disabled = true;
  }

  input.addEventListener('change', function () {
    if (input.files && input.files[0]) showFile(input.files[0]);
  });

  removeBtn.addEventListener('click', function (e) {
    e.preventDefault();
    clearFile();
  });

  ['dragenter', 'dragover'].forEach(function (evt) {
    drop.addEventListener(evt, function (e) {
      e.preventDefault();
      drop.classList.add('is-drag');
    });
  });
  ['dragleave', 'drop'].forEach(function (evt) {
    drop.addEventListener(evt, function (e) {
      e.preventDefault();
      drop.classList.remove('is-drag');
    });
  });
  drop.addEventListener('drop', function (e) {
    var files = e.dataTransfer.files;
    if (files && files[0]) {
      input.files = files;
      showFile(files[0]);
    }
  });

}());
</script>