<?php // app/views/pages/anggota.php ?>

<style>
  .angp {
    max-width: var(--container-w, 75rem);
    margin: 0 auto;
    padding: 2.5rem 1.5rem 4rem;
  }

  /* ─── Page header ─── */
  .angp__eyebrow {
    display: inline-flex; align-items: center; gap: 0.44rem;
    font-size: .68rem; font-weight: 700; letter-spacing: .12em;
    text-transform: uppercase; color: var(--c-primary); margin-bottom: .5rem;
  }
  .angp__eyebrow::before {
    content: ''; width: .375rem; height: .375rem; border-radius: 50%;
    background: var(--c-primary); box-shadow: 0 0 6px var(--c-primary);
  }
  .angp__title {
    font-family: var(--font-display);
    font-size: 1.9rem; font-weight: 800; letter-spacing: -.03em;
    color: var(--c-primary-dk); line-height: 1.15; margin-bottom: .5rem;
  }
  .angp__sub {
    font-size: .88rem; color: var(--c-muted); max-width: 38rem; line-height: 1.6;
  }

  /* ─── Section label ─── */
  .angp-sec { margin-top: 2.75rem; margin-bottom: 1.25rem; }
  .angp-sec__row { display: flex; align-items: center; gap: .75rem; margin-bottom: .35rem; }
  .angp-sec__title {
    font-size: .95rem; font-weight: 800; color: var(--c-ink); letter-spacing: -.01em;
    white-space: nowrap;
  }
  .angp-sec__line { flex: 1; height: 1px; background: linear-gradient(to right, var(--c-border), transparent); }

  /* ─── Pengurus cards (Pembina & Ketua) ─── */
  .pengurus-grid {
    display: grid; grid-template-columns: repeat(auto-fit, minmax(17.5rem, 1fr));
    gap: 1rem;
  }
  .pengurus-card {
    display: flex; align-items: center; gap: 1rem;
    background: var(--c-white); border: 1px solid var(--c-border);
    border-radius: var(--radius-lg); padding: 1.25rem 1.4rem;
    box-shadow: 0 20px 46px -22px rgba(15,23,42,.12), 0 3px 10px rgba(15,23,42,.04);
    transition: transform .2s ease, box-shadow .2s ease;
  }
  .pengurus-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 24px 52px -20px rgba(15,23,42,.16), 0 4px 14px rgba(15,23,42,.06);
  }
  .pengurus-card__photo {
    width: 4.5rem; height: 4.5rem; border-radius: 50%; object-fit: cover; flex-shrink: 0;
    border: 2px solid rgba(14,116,144,.25);
  }
  .pengurus-card__photo-fallback {
    width: 4.5rem; height: 4.5rem; border-radius: 50%; flex-shrink: 0;
    background: rgba(14,116,144,.1); border: 2px solid rgba(14,116,144,.25);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.4rem; font-weight: 800; color: var(--c-primary); text-transform: uppercase;
  }
  .pengurus-card__body { min-width: 0; }
  .pengurus-card__badge {
    display: inline-flex; align-items: center; gap: .3rem;
    font-size: .62rem; font-weight: 700; letter-spacing: .06em; text-transform: uppercase;
    color: var(--c-primary); background: rgba(14,116,144,.08);
    border: 1px solid rgba(14,116,144,.18); border-radius: .38rem;
    padding: .15rem .5rem; margin-bottom: .4rem;
  }
  .pengurus-card__name {
    font-size: 1rem; font-weight: 800; color: var(--c-ink); line-height: 1.3;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
  }
  .pengurus-card__jabatan {
    font-size: .78rem; color: var(--c-muted); margin-top: .15rem;
  }
  .pengurus-card__periode {
    font-size: .7rem; color: var(--c-muted2); margin-top: .2rem; font-weight: 600;
  }
  .pengurus-empty {
    display: flex; align-items: center; gap: .75rem;
    background: var(--c-white); border: 1px dashed var(--c-border);
    border-radius: var(--radius-lg); padding: 1.25rem 1.4rem;
    color: var(--c-muted2); font-size: .82rem;
  }

  /* ─── Filter bar ─── */
  .angp-filter {
    display: flex; align-items: center; gap: .56rem; flex-wrap: wrap;
    margin-bottom: 1.5rem;
  }
  .angp-fi { position: relative; display: flex; align-items: center; }
  .angp-fi__icon {
    position: absolute; left: .69rem; color: var(--c-muted2); pointer-events: none;
    display: flex; font-size: .85rem;
  }
  .angp-fi input, .angp-fi select {
    font-family: var(--font-body); font-size: .82rem; color: var(--c-ink);
    background: var(--c-white); border: 1.5px solid var(--c-border);
    border-radius: var(--radius-sm); padding: .56rem .88rem .56rem 2rem;
    outline: none; -webkit-appearance: none;
    transition: border-color .15s ease, box-shadow .15s ease, background .15s ease;
  }
  .angp-fi input { width: 15.5rem; }
  .angp-fi select { width: 11rem; }
  .angp-fi input:focus, .angp-fi select:focus {
    border-color: var(--c-primary-lt); background: #fff;
    box-shadow: 0 0 0 3px rgba(6,182,212,.12);
  }
  .angp-fi input::placeholder { color: var(--c-muted2); }
  .angp-filter-btn {
    display: inline-flex; align-items: center; gap: .38rem;
    padding: .56rem .94rem; background: var(--c-primary); color: #fff;
    font-family: var(--font-body); font-size: .82rem; font-weight: 700;
    border: none; border-radius: var(--radius-sm); cursor: pointer;
    box-shadow: 0 8px 20px rgba(14,116,144,.2); transition: all .18s ease;
  }
  .angp-filter-btn:hover { background: var(--c-primary-lt); transform: translateY(-1px); }
  .angp-filter-reset {
    font-size: .74rem; font-weight: 600; color: var(--c-muted2);
    padding: .3rem .5rem; transition: color .15s ease;
  }
  .angp-filter-reset:hover { color: var(--c-red-text); }

  /* ─── Member grid ─── */
  .angp-meta { font-size: .78rem; color: var(--c-muted); margin-bottom: .88rem; }
  .angp-meta strong { color: var(--c-ink); font-weight: 700; }

  .member-grid {
    display: grid; grid-template-columns: repeat(auto-fill, minmax(9.5rem, 1fr));
    gap: .81rem;
  }
  .member-card {
    display: flex; flex-direction: column; align-items: center; text-align: center;
    background: var(--c-white); border: 1px solid var(--c-border);
    border-radius: var(--radius-md); padding: 1.1rem .81rem;
    transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
  }
  .member-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 18px 38px -18px rgba(15,23,42,.18), 0 3px 10px rgba(15,23,42,.05);
    border-color: rgba(14,116,144,.25);
  }
  .member-card__photo {
    width: 3.75rem; height: 3.75rem; border-radius: 50%; object-fit: cover;
    border: 2px solid var(--c-border); margin-bottom: .69rem;
  }
  .member-card__photo-fallback {
    width: 3.75rem; height: 3.75rem; border-radius: 50%;
    background: #f4f7fa; border: 2px solid var(--c-border);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.05rem; font-weight: 800; color: var(--c-muted); text-transform: uppercase;
    margin-bottom: .69rem;
  }
  .member-card__name {
    font-size: .82rem; font-weight: 700; color: var(--c-ink); line-height: 1.3;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
  }
  .member-card__kelas {
    display: inline-block; margin-top: .38rem;
    font-size: .66rem; font-weight: 700; color: var(--c-primary);
    background: rgba(14,116,144,.08); border: 1px solid rgba(14,116,144,.16);
    border-radius: .38rem; padding: .15rem .5rem; letter-spacing: .01em;
  }

  /* ─── Empty state ─── */
  .angp-empty {
    text-align: center; padding: 3.75rem 1.5rem; color: var(--c-muted2);
    background: var(--c-white); border: 1px dashed var(--c-border); border-radius: var(--radius-lg);
  }
  .angp-empty i { font-size: 2.4rem; opacity: .35; display: block; margin-bottom: .75rem; }
  .angp-empty__title { font-size: .95rem; font-weight: 700; color: var(--c-muted); margin-bottom: .25rem; }
  .angp-empty__sub { font-size: .8rem; }

  @media (max-width: 480px) {
    .angp-fi input, .angp-fi select { width: 100%; }
    .angp-filter { flex-direction: column; align-items: stretch; }
  }
</style>

<div class="angp">

  <!-- ── Page header ── -->
  <div class="angp__eyebrow">Profil Organisasi</div>
  <h1 class="angp__title">Daftar Anggota</h1>
  <p class="angp__sub">
    Kenali pembina, ketua, serta seluruh anggota aktif Community Of Multimedia
    (COM) SMKN 2 Pinrang.
  </p>

  <!-- ── Pembina & Ketua Terkini ── -->
  <div class="angp-sec">
    <div class="angp-sec__row">
      <span class="angp-sec__title">Pembina &amp; Ketua Terkini</span>
      <div class="angp-sec__line"></div>
    </div>
  </div>

  <?php if (!$pembina && !$ketua): ?>
    <div class="pengurus-empty">
      <i class="ti ti-info-circle" style="font-size:1.2rem;"></i>
      <span>Data pembina/ketua belum tersedia.</span>
    </div>
  <?php else: ?>
    <div class="pengurus-grid">

      <?php if ($pembina): ?>
      <div class="pengurus-card">
        <?php if (!empty($pembina['foto'])): ?>
          <img src="<?= UPLOAD_URL . '/' . htmlspecialchars($pembina['foto']) ?>"
               class="pengurus-card__photo"
               alt="Foto <?= htmlspecialchars($pembina['nama']) ?>">
        <?php else: ?>
          <div class="pengurus-card__photo-fallback" aria-hidden="true">
            <?= htmlspecialchars(mb_strtoupper(mb_substr($pembina['nama'] ?? '?', 0, 2))) ?>
          </div>
        <?php endif; ?>
        <div class="pengurus-card__body">
          <span class="pengurus-card__badge"><i class="ti ti-shield-star" style="font-size:.85em;"></i> Pembina</span>
          <p class="pengurus-card__name"><?= htmlspecialchars($pembina['nama'] ?? '—') ?></p>
          <p class="pengurus-card__jabatan"><?= htmlspecialchars($pembina['jabatan'] ?? '') ?></p>
          <?php if (!empty($pembina['periode'])): ?>
            <p class="pengurus-card__periode">Periode <?= htmlspecialchars($pembina['periode']) ?></p>
          <?php endif; ?>
        </div>
      </div>
      <?php endif; ?>

      <?php if ($ketua): ?>
      <div class="pengurus-card">
        <?php if (!empty($ketua['foto'])): ?>
          <img src="<?= UPLOAD_URL . '/' . htmlspecialchars($ketua['foto']) ?>"
               class="pengurus-card__photo"
               alt="Foto <?= htmlspecialchars($ketua['nama']) ?>">
        <?php else: ?>
          <div class="pengurus-card__photo-fallback" aria-hidden="true">
            <?= htmlspecialchars(mb_strtoupper(mb_substr($ketua['nama'] ?? '?', 0, 2))) ?>
          </div>
        <?php endif; ?>
        <div class="pengurus-card__body">
          <span class="pengurus-card__badge"><i class="ti ti-crown" style="font-size:.85em;"></i> Ketua</span>
          <p class="pengurus-card__name"><?= htmlspecialchars($ketua['nama'] ?? '—') ?></p>
          <p class="pengurus-card__jabatan"><?= htmlspecialchars($ketua['jabatan'] ?? '') ?></p>
          <?php if (!empty($ketua['periode'])): ?>
            <p class="pengurus-card__periode">Periode <?= htmlspecialchars($ketua['periode']) ?></p>
          <?php endif; ?>
        </div>
      </div>
      <?php endif; ?>

    </div>
  <?php endif; ?>

  <!-- ── Daftar Anggota ── -->
  <div class="angp-sec">
    <div class="angp-sec__row">
      <span class="angp-sec__title">Seluruh Anggota Aktif</span>
      <div class="angp-sec__line"></div>
    </div>
  </div>

  <form method="GET" action="<?= BASE_URL ?>/anggota" class="angp-filter">
    <div class="angp-fi">
      <span class="angp-fi__icon"><i class="ti ti-search"></i></span>
      <input type="text" name="search" placeholder="Cari nama…"
             value="<?= htmlspecialchars($filter['search'] ?? '') ?>" autocomplete="off">
    </div>
    <div class="angp-fi">
      <span class="angp-fi__icon"><i class="ti ti-school"></i></span>
      <select name="kelas">
        <option value="">Semua Kelas</option>
        <?php foreach ($kelasList as $k): ?>
          <option value="<?= htmlspecialchars($k['kelas']) ?>"
                  <?= ($filter['kelas'] ?? '') === $k['kelas'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($k['kelas']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>
    <button type="submit" class="angp-filter-btn">
      <i class="ti ti-filter"></i> Filter
    </button>
    <?php if (!empty($filter['search']) || !empty($filter['kelas'])): ?>
      <a href="<?= BASE_URL ?>/anggota" class="angp-filter-reset">✕ Reset</a>
    <?php endif; ?>
  </form>

  <p class="angp-meta">
    Menampilkan <strong><?= number_format(count($list)) ?></strong> anggota
  </p>

  <?php if (empty($list)): ?>
    <div class="angp-empty">
      <i class="ti ti-users-group" aria-hidden="true"></i>
      <div class="angp-empty__title">Tidak ada anggota ditemukan</div>
      <div class="angp-empty__sub">Coba ubah kata kunci pencarian atau filter kelas.</div>
    </div>
  <?php else: ?>
    <div class="member-grid">
      <?php foreach ($list as $m): ?>
        <div class="member-card">
          <?php if (!empty($m['foto'])): ?>
            <img src="<?= UPLOAD_URL . '/' . htmlspecialchars($m['foto']) ?>"
                 class="member-card__photo"
                 alt="Foto <?= htmlspecialchars($m['nama_lengkap']) ?>">
          <?php else: ?>
            <div class="member-card__photo-fallback" aria-hidden="true">
              <?= htmlspecialchars(mb_strtoupper(mb_substr($m['nama_lengkap'], 0, 2))) ?>
            </div>
          <?php endif; ?>
          <p class="member-card__name"><?= htmlspecialchars($m['nama_lengkap']) ?></p>
          <span class="member-card__kelas"><?= htmlspecialchars($m['kelas'] ?? '—') ?></span>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

</div>