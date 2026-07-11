<?php // app/views/admin/nia_sequence.php ?>

<style>
.nias-root {
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
  --t-fast: 120ms; --t-base: 160ms; --t-slow: 300ms;
}
.nias-root * { box-sizing: border-box; margin: 0; padding: 0; }
.nias-root a { text-decoration: none; color: inherit; }
.nias-root { font-family: var(--font-ui); color: var(--tx-primary); font-size: 13.5px; line-height: 1.5; }

.nias-back {
  display: inline-flex; align-items: center; gap: 6px;
  font-size: 12px; font-weight: 700; color: var(--tx-muted);
  margin-bottom: 14px; transition: color var(--t-fast) var(--ease);
}
.nias-back:hover { color: var(--ac); }
.nias-back i { font-size: 14px; }

.nias-head { margin-bottom: 22px; }
.nias-eyebrow {
  display: inline-flex; align-items: center; gap: 7px;
  font-size: 11px; font-weight: 700; letter-spacing: .1em; text-transform: uppercase;
  color: var(--ac); margin-bottom: 7px;
}
.nias-eyebrow::before { content:''; width:6px; height:6px; border-radius:50%; background:var(--ac); box-shadow:0 0 6px var(--ac); }
.nias-title { font-size: 24px; font-weight: 800; letter-spacing: -.03em; color: var(--c-primary-dk, #0b5a70); }
.nias-sub { font-size: 12.5px; color: var(--tx-secondary); margin-top: 5px; }

.nias-notice {
  display: flex; gap: 10px; padding: 13px 15px;
  background: var(--amber-d); border: 1px solid rgba(217,145,12,.25);
  border-radius: var(--r-lg); font-size: 12px; color: var(--c-amber-text, #8a5a06);
  line-height: 1.6; margin-bottom: 22px;
}
.nias-notice i { font-size: 16px; flex-shrink: 0; margin-top: 1px; }
.nias-notice strong { font-weight: 800; }

/* ── Cards grid per tahun ── */
.nias-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 14px;
}

.nias-card {
  background: var(--bg-surface);
  border: 1px solid var(--bd-subtle);
  border-radius: var(--r-xl);
  padding: 18px;
}

.nias-card__head {
  display: flex; align-items: center; justify-content: space-between;
  margin-bottom: 14px;
}
.nias-card__year {
  font-size: 18px; font-weight: 800; letter-spacing: -.02em; color: var(--tx-primary);
}
.nias-card__badge {
  font-size: 10px; font-weight: 700; letter-spacing: .05em; text-transform: uppercase;
  padding: 3px 9px; border-radius: var(--r-sm);
}
.nias-card__badge--synced   { background: var(--green-d); color: var(--green); }
.nias-card__badge--mismatch { background: var(--amber-d); color: var(--amber); }

.nias-stat-row {
  display: flex; justify-content: space-between; align-items: center;
  padding: 9px 0; border-bottom: 1px solid var(--bd-subtle);
  font-size: 12px;
}
.nias-stat-row:last-of-type { border-bottom: none; }
.nias-stat-row__label { color: var(--tx-muted); font-weight: 600; }
.nias-stat-row__val { color: var(--tx-primary); font-weight: 800; font-variant-numeric: tabular-nums; }
.nias-stat-row__val--accent { color: var(--ac); }

.nias-example {
  font-size: 11px; color: var(--tx-muted); margin: 10px 0 14px;
  background: var(--bg-elevated); border: 1px solid var(--bd-subtle);
  border-radius: var(--r-sm); padding: 7px 10px; font-weight: 600;
}
.nias-example strong { color: var(--tx-secondary); font-weight: 800; letter-spacing: .02em; }

.nias-actions { display: flex; flex-direction: column; gap: 8px; }

.btn-sync {
  display: inline-flex; align-items: center; justify-content: center; gap: 7px;
  width: 100%; padding: 9px 13px; font-size: 12px; font-weight: 700;
  background: var(--ac-dim); color: var(--ac);
  border: 1.5px solid var(--bd-accent); border-radius: var(--r-md);
  cursor: pointer; transition: all var(--t-fast) var(--ease);
}
.btn-sync:hover { background: var(--ac); color: #fff; }
.btn-sync i { font-size: 14px; }

.nias-manual {
  display: flex; align-items: center; gap: 8px;
}
.nias-manual input {
  flex: 1; min-width: 0;
  font-family: var(--font-ui); font-size: 12.5px; color: var(--tx-primary);
  background: var(--bg-elevated); border: 1.5px solid var(--bd-subtle);
  border-radius: var(--r-md); padding: 8px 11px; outline: none;
  transition: border-color var(--t-fast) var(--ease);
}
.nias-manual input:focus { border-color: var(--ac); background: #fff; }
.btn-manual {
  display: inline-flex; align-items: center; justify-content: center; gap: 6px;
  padding: 8px 13px; font-size: 12px; font-weight: 700;
  background: var(--bg-surface); color: var(--tx-secondary);
  border: 1.5px solid var(--bd-subtle); border-radius: var(--r-md);
  cursor: pointer; white-space: nowrap; transition: all var(--t-fast) var(--ease);
}
.btn-manual:hover { border-color: var(--red-d); color: var(--red); background: var(--red-d); }

.nias-empty {
  text-align: center; padding: 60px 24px; color: var(--tx-muted);
  background: var(--bg-surface); border: 1px solid var(--bd-subtle); border-radius: var(--r-xl);
}
.nias-empty__ico { font-size: 38px; opacity: .35; margin-bottom: 12px; display: block; }
.nias-empty__title { font-size: 14px; font-weight: 700; color: var(--tx-secondary); margin-bottom: 4px; }
.nias-empty__sub { font-size: 12px; }

/* ── Confirm dialog (sync otomatis) ── */
.nias-overlay {
  display: none; position: fixed; inset: 0; background: rgba(15,23,42,.45);
  backdrop-filter: blur(4px); z-index: 9999; align-items: center; justify-content: center;
}
.nias-overlay.is-open { display: flex; }
.nias-box {
  background: var(--bg-surface); border: 1px solid var(--bd-subtle); border-radius: var(--r-xl);
  padding: 28px; max-width: 380px; width: 90%;
  box-shadow: 0 30px 70px -20px rgba(15,23,42,.28), 0 4px 18px rgba(15,23,42,.08);
  animation: nias-pop var(--t-slow) var(--ease) both;
}
@keyframes nias-pop {
  from { transform: scale(.94) translateY(10px); opacity: 0; }
  to   { transform: scale(1)   translateY(0);    opacity: 1; }
}
.nias-box__ico {
  width: 44px; height: 44px; border-radius: var(--r-lg);
  background: var(--ac-dim); color: var(--ac);
  display: flex; align-items: center; justify-content: center;
  margin-bottom: 16px; font-size: 20px;
}
.nias-box__title { font-size: 15.5px; font-weight: 800; color: var(--tx-primary); margin-bottom: 6px; letter-spacing: -.02em; }
.nias-box__sub { font-size: 12.5px; color: var(--tx-muted); line-height: 1.6; margin-bottom: 20px; }
.nias-box__sub strong { color: var(--tx-secondary); }
.nias-box__acts { display: flex; gap: 8px; justify-content: flex-end; }
.btn-sec-dlg {
  padding: 9px 15px; font-size: 12.5px; font-weight: 700; color: var(--tx-secondary);
  background: var(--bg-surface); border: 1px solid var(--bd-subtle); border-radius: var(--r-md); cursor: pointer;
}
.btn-pri-dlg {
  padding: 9px 15px; font-size: 12.5px; font-weight: 700; color: #fff;
  background: var(--ac); border: none; border-radius: var(--r-md); cursor: pointer;
  box-shadow: 0 6px 16px rgba(14,116,144,.22);
}

@media (max-width: 480px) {
  .nias-grid { grid-template-columns: 1fr; }
}
</style>

<div class="nias-root">

  <a href="<?= BASE_URL ?>/admin/anggota" class="nias-back">
    <i class="ti ti-arrow-left" aria-hidden="true"></i> Kembali ke Anggota
  </a>

  <div class="nias-head">
    <div class="nias-eyebrow">Manajemen Data</div>
    <h1 class="nias-title">Reset Sequence NIA</h1>
    <p class="nias-sub">Sinkronkan atau atur ulang nomor urut NIA per tahun angkatan.</p>
  </div>

  <div class="nias-notice">
    <i class="ti ti-info-circle" aria-hidden="true"></i>
    <div>
      <strong>Sinkron Otomatis</strong> menyamakan nomor urut berikutnya dengan urut tertinggi
      yang benar-benar masih dipakai anggota aktif (aman, tidak akan bentrok).
      <strong>Set Manual</strong> memaksa nomor urut berikutnya ke angka pilihanmu —
      hati-hati, kalau angkanya sama/lebih kecil dari NIA yang masih dipakai, NIA baru bisa bentrok (duplikat).
    </div>
  </div>

  <?php if (empty($rows)): ?>
    <div class="nias-empty">
      <i class="ti ti-hash tbl-empty__ico nias-empty__ico" aria-hidden="true"></i>
      <div class="nias-empty__title">Belum ada data sequence NIA</div>
      <div class="nias-empty__sub">Sequence akan muncul di sini setelah ada anggota yang diaktifkan.</div>
    </div>
  <?php else: ?>
  <div class="nias-grid">
    <?php foreach ($rows as $r): ?>
      <?php
        $tahun       = $r['tahun'];
        $nextUrut    = $r['next_urut'];
        $maxReal     = $r['max_urut_real'];
        $isSynced    = ($nextUrut - 1) === $maxReal;
        $contohNia   = $tahun . ORG_CODE . str_pad((string)($maxReal ?: $nextUrut), NIA_SEQ_DIGITS, '0', STR_PAD_LEFT);
      ?>
      <div class="nias-card">
        <div class="nias-card__head">
          <span class="nias-card__year">Angkatan <?= (int)$tahun ?></span>
          <?php if ($isSynced): ?>
            <span class="nias-card__badge nias-card__badge--synced">Sinkron</span>
          <?php else: ?>
            <span class="nias-card__badge nias-card__badge--mismatch">Perlu Cek</span>
          <?php endif; ?>
        </div>

        <div class="nias-stat-row">
          <span class="nias-stat-row__label">Urut tertinggi (data nyata)</span>
          <span class="nias-stat-row__val"><?= str_pad((string)$maxReal, 3, '0', STR_PAD_LEFT) ?></span>
        </div>
        <div class="nias-stat-row">
          <span class="nias-stat-row__label">NIA berikutnya akan jadi urut</span>
          <span class="nias-stat-row__val nias-stat-row__val--accent">#<?= str_pad((string)$nextUrut, 3, '0', STR_PAD_LEFT) ?></span>
        </div>

        <div class="nias-example">
          Contoh NIA saat ini: <strong><?= htmlspecialchars($contohNia) ?></strong>
        </div>

        <div class="nias-actions">
          <button type="button" class="btn-sync"
                  data-sync-year="<?= (int)$tahun ?>"
                  data-sync-next="<?= (int)$maxReal + 1 ?>">
            <i class="ti ti-refresh" aria-hidden="true"></i>
            Sinkron Otomatis
          </button>

          <form method="POST" class="nias-manual"
                action="<?= BASE_URL ?>/admin/nia-sequence/<?= (int)$tahun ?>/manual">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
            <input type="number" name="next_urut" min="1" max="999"
                   placeholder="Urut berikutnya, mis. 1" required>
            <button type="submit" class="btn-manual">
              <i class="ti ti-edit" aria-hidden="true"></i> Set
            </button>
          </form>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>

  <!-- Dialog konfirmasi sinkron otomatis -->
  <div class="nias-overlay" id="sync-overlay" role="dialog" aria-modal="true" aria-labelledby="sync-title">
    <div class="nias-box">
      <div class="nias-box__ico"><i class="ti ti-refresh" aria-hidden="true"></i></div>
      <div class="nias-box__title" id="sync-title">Sinkron Sequence NIA?</div>
      <div class="nias-box__sub">
        Angkatan <strong id="sync-year-display">—</strong> akan disinkronkan.
        NIA berikutnya jadi urut <strong id="sync-next-display">—</strong>.
      </div>
      <div class="nias-box__acts">
        <button type="button" class="btn-sec-dlg" id="sync-cancel">Batal</button>
        <form method="POST" id="sync-form">
          <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
          <button type="submit" class="btn-pri-dlg">Ya, Sinkronkan</button>
        </form>
      </div>
    </div>
  </div>

</div><!-- /.nias-root -->

<script>
(function () {
  'use strict';

  var overlay      = document.getElementById('sync-overlay');
  var yearDisplay   = document.getElementById('sync-year-display');
  var nextDisplay   = document.getElementById('sync-next-display');
  var form          = document.getElementById('sync-form');
  var cancelBtn     = document.getElementById('sync-cancel');

  document.querySelectorAll('[data-sync-year]').forEach(function (btn) {
    btn.addEventListener('click', function () {
      yearDisplay.textContent = btn.dataset.syncYear;
      nextDisplay.textContent = '#' + String(btn.dataset.syncNext).padStart(3, '0');
      form.action = '<?= BASE_URL ?>/admin/nia-sequence/' + btn.dataset.syncYear + '/sync';
      overlay.classList.add('is-open');
      document.body.style.overflow = 'hidden';
    });
  });

  function closeOverlay() {
    overlay.classList.remove('is-open');
    document.body.style.overflow = '';
  }

  cancelBtn.addEventListener('click', closeOverlay);
  overlay.addEventListener('click', function (e) { if (e.target === overlay) closeOverlay(); });
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && overlay.classList.contains('is-open')) closeOverlay();
  });

}());
</script>