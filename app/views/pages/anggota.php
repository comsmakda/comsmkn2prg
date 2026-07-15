<?php // app/views/pages/anggota.php ?>

<style>
  .angp {
    max-width: var(--container-w, 75rem);
    margin: 0 auto;
    padding: 0 1.5rem 4rem;
  }

  /* ─── Hero section ─── */
  .angp-hero {
    position: relative;
    width: 100vw;
    margin-left: calc(50% - 50vw);
    margin-right: calc(50% - 50vw);
    margin-bottom: 2.75rem;
    padding: clamp(2.25rem, 5vw, 3.5rem) 1.5rem;
    min-height: clamp(13rem, 24vw, 17rem);
    display: flex;
    align-items: center;
    overflow: hidden;
    isolation: isolate;
  }
  .angp-hero::before {
    content: '';
    position: absolute; inset: 0;
    background-image: url('<?= BASE_URL ?>/assets/img/gedung-smkn2.webp');
    background-size: cover;
    background-position: center 55%;
    filter: blur(2px) saturate(1.05);
    transform: scale(1.06);
    z-index: -3;
  }
  .angp-hero::after {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(100deg, rgba(6,22,32,.93) 0%, rgba(6,32,42,.87) 45%, rgba(6,32,42,.72) 100%);
    z-index: -2;
  }
  .angp-hero__dots {
    content: '';
    position: absolute; inset: 0;
    background-image: radial-gradient(rgba(255,255,255,.14) 1px, transparent 1px);
    background-size: 22px 22px;
    opacity: .5;
    z-index: -1;
  }
  .angp-hero__inner {
    position: relative;
    width: 100%;
    max-width: var(--container-w, 75rem);
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
  }

  .angp__eyebrow {
    display: inline-flex; align-items: center; gap: 0.44rem;
    font-size: .7rem; font-weight: 700; letter-spacing: .1em;
    text-transform: uppercase; color: #8fe9f6; margin-bottom: .65rem;
  }
  .angp__eyebrow::before {
    content: ''; width: .375rem; height: .375rem; border-radius: 50%;
    background: #22d3ee; box-shadow: 0 0 8px #22d3ee; flex-shrink: 0;
  }
  .angp__title {
    font-family: var(--font-display);
    font-size: clamp(1.5rem, 3.4vw, 2.1rem);
    font-weight: 800; letter-spacing: -.02em;
    color: #fff; line-height: 1.2; margin-bottom: .6rem;
  }
  .angp__sub {
    font-size: clamp(.82rem, 1.3vw, .9rem);
    color: rgba(255,255,255,.78); max-width: 34rem; line-height: 1.6;
    margin-left: auto; margin-right: auto;
  }

  /* ─── Section label ─── */
  .angp-sec { margin-top: 2.75rem; margin-bottom: 1.25rem; }
  .angp-sec__row { display: flex; align-items: center; gap: .75rem; margin-bottom: .35rem; }
  .angp-sec__title {
    font-size: .95rem; font-weight: 800; color: var(--c-ink); letter-spacing: -.01em;
    white-space: nowrap;
  }
  .angp-sec__line { flex: 1; height: 1px; background: linear-gradient(to right, var(--c-border), transparent); }
  .angp-sec__hint { font-size: .76rem; color: var(--c-muted2); margin-top: -.15rem; }

  /* ─── Struktur Organisasi (org-chart) ─── */
  .org-chart {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0;
    padding: .5rem 0 1rem;
  }
  .org-tier {
    position: relative;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    gap: .85rem;
    flex-wrap: wrap;
    padding-top: 2.25rem;
  }
  .org-tier:first-child { padding-top: 0; }
  .org-tier::before {
    content: '';
    position: absolute;
    top: 0; left: 50%;
    width: 2px; height: 1.75rem;
    background: var(--c-border);
    transform: translateX(-50%);
  }
  .org-tier:first-child::before { display: none; }

  .org-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    width: 9.5rem;
    background: var(--c-white);
    border: 1px solid var(--c-border);
    border-radius: var(--radius-lg);
    padding: 1rem .8rem .9rem;
    box-shadow: 0 16px 34px -20px rgba(15,23,42,.14), 0 3px 8px rgba(15,23,42,.04);
    transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
  }
  .org-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 20px 40px -18px rgba(15,23,42,.18), 0 4px 12px rgba(15,23,42,.06);
    border-color: rgba(14,116,144,.25);
  }
  .org-card--ketua { width: 11.5rem; padding: 1.35rem 1rem 1.15rem; }

  .org-card__photo-wrap {
    width: 4rem; height: 4rem; margin-bottom: .6rem;
    border-radius: 50%; padding: 2.5px; flex-shrink: 0;
    background: linear-gradient(135deg, rgba(14,116,144,.4), rgba(6,182,212,.4));
  }
  .org-card--ketua .org-card__photo-wrap {
    width: 5.5rem; height: 5.5rem; margin-bottom: .75rem;
    background: conic-gradient(from 180deg, var(--c-primary), #22d3ee, var(--c-primary));
  }
  .org-card__photo {
    width: 100%; height: 100%; border-radius: 50%; object-fit: cover;
    display: block; border: 2.5px solid #fff;
  }
  .org-card__photo-fallback {
    width: 100%; height: 100%; border-radius: 50%;
    background: rgba(14,116,144,.1); border: 2.5px solid #fff;
    display: flex; align-items: center; justify-content: center;
    font-size: 1rem; font-weight: 800; color: var(--c-primary); text-transform: uppercase;
  }
  .org-card--ketua .org-card__photo-fallback { font-size: 1.3rem; }

  .org-card__jabatan {
    font-size: .64rem; font-weight: 700; letter-spacing: .05em; text-transform: uppercase;
    color: var(--c-primary); margin-bottom: .3rem; line-height: 1.3;
  }
  .org-card--ketua .org-card__jabatan { font-size: .68rem; }
  .org-card__name {
    font-size: .8rem; font-weight: 800; color: var(--c-ink); line-height: 1.3;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
  }
  .org-card--ketua .org-card__name { font-size: .96rem; }
  .org-card__kelas {
    display: inline-block; margin-top: .35rem;
    font-size: .64rem; font-weight: 700; color: var(--c-muted2);
  }

  .org-empty {
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
    display: grid; grid-template-columns: repeat(auto-fill, minmax(10.5rem, 1fr));
    gap: .9rem;
  }
  @media (max-width: 640px) {
    .member-grid { grid-template-columns: repeat(2, 1fr); gap: .7rem; }
    .member-card { padding: 1.1rem .6rem .9rem; }
    .member-card__photo-wrap { width: 4.25rem; height: 4.25rem; margin-bottom: .6rem; }
    .member-card__name { font-size: .8rem; }
    .org-card { width: 8rem; }
    .org-card--ketua { width: 9.5rem; }
  }
  @media (max-width: 360px) {
    .member-card__photo-wrap { width: 3.75rem; height: 3.75rem; }
  }
  .member-card {
    display: flex; flex-direction: column; align-items: center; text-align: center;
    background: var(--c-white); border: 1px solid var(--c-border);
    border-radius: var(--radius-md); padding: 1.35rem .9rem 1.1rem;
    transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
  }
  .member-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 18px 38px -18px rgba(15,23,42,.18), 0 3px 10px rgba(15,23,42,.05);
    border-color: rgba(14,116,144,.25);
  }
  .member-card__photo-wrap {
    position: relative; width: 5rem; height: 5rem; margin-bottom: .75rem;
    border-radius: 50%; padding: 3px;
    background: linear-gradient(135deg, rgba(14,116,144,.35), rgba(6,182,212,.35));
  }
  .member-card__photo {
    width: 100%; height: 100%; border-radius: 50%; object-fit: cover;
    display: block; border: 3px solid #fff;
  }
  .member-card__photo-fallback {
    width: 100%; height: 100%; border-radius: 50%;
    background: #f4f7fa; border: 3px solid #fff;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.25rem; font-weight: 800; color: var(--c-muted); text-transform: uppercase;
  }
  .member-card__name {
    font-size: .83rem; font-weight: 700; color: var(--c-ink); line-height: 1.3;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
  }
  .member-card__kelas {
    display: inline-block; margin-top: .4rem;
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

<!-- ── Hero section with blurred background ── -->
<div class="angp-hero">
  <div class="angp-hero__dots"></div>
  <div class="angp-hero__inner">
    <div class="angp__eyebrow">Profil Organisasi</div>
    <h1 class="angp__title">Daftar Anggota</h1>
    <p class="angp__sub">
      Kenali struktur kepengurusan serta seluruh anggota aktif Community Programmer
      (COM) SMKN 2 Pinrang.
    </p>
  </div>
</div>

<div class="angp">

  <!-- ── Struktur Organisasi ── -->
  <div class="angp-sec">
    <div class="angp-sec__row">
      <span class="angp-sec__title">Struktur Organisasi</span>
      <div class="angp-sec__line"></div>
    </div>
    <p class="angp-sec__hint">Susunan pengurus aktif berdasarkan jabatan yang sedang menjabat.</p>
  </div>

  <?php
    // Jenjang tampilan struktur (dari puncak ke bawah).
    // Setiap tier bisa berisi lebih dari satu key jabatan yang tampil sebaris.
    $orgTiers = [
      ['ketua_umum'],
      ['wakil_ketua'],
      ['bendahara', 'wakil_bendahara', 'sekretaris', 'wakil_sekretaris'],
      ['koordinator_humas', 'koordinator_perlengkapan', 'koordinator_pdd'],
      ['ketua_bidang_it_software', 'ketua_bidang_it_network', 'ketua_bidang_multimedia', 'ketua_bidang_iot_robotic'],
    ];

    $adaPengurus = false;
    foreach ($struktur as $jab => $orang) {
      if (!empty($orang)) { $adaPengurus = true; break; }
    }
  ?>

  <?php if (!$adaPengurus): ?>
    <div class="org-empty">
      <i class="ti ti-info-circle" style="font-size:1.2rem;"></i>
      <span>Struktur pengurus belum tersedia.</span>
    </div>
  <?php else: ?>
    <div class="org-chart">
      <?php foreach ($orgTiers as $tierIndex => $tierKeys): ?>
        <?php
          $tierPeople = [];
          foreach ($tierKeys as $jk) {
            foreach (($struktur[$jk] ?? []) as $orang) {
              $tierPeople[] = ['jabatan' => $jk, 'data' => $orang];
            }
          }
          if (empty($tierPeople)) continue; // lompati tier yang belum ada orangnya
        ?>
        <div class="org-tier">
          <?php foreach ($tierPeople as $entry): $o = $entry['data']; ?>
            <div class="org-card <?= $tierIndex === 0 ? 'org-card--ketua' : '' ?>">
              <div class="org-card__photo-wrap">
                <?php if (!empty($o['foto'])): ?>
                  <img src="<?= UPLOAD_URL . '/' . htmlspecialchars($o['foto']) ?>"
                       class="org-card__photo"
                       alt="Foto <?= htmlspecialchars($o['nama_lengkap']) ?>">
                <?php else: ?>
                  <div class="org-card__photo-fallback" aria-hidden="true">
                    <?= htmlspecialchars(mb_strtoupper(mb_substr($o['nama_lengkap'], 0, 2))) ?>
                  </div>
                <?php endif; ?>
              </div>
              <span class="org-card__jabatan"><?= htmlspecialchars($jabatanLabel[$entry['jabatan']] ?? '') ?></span>
              <p class="org-card__name"><?= htmlspecialchars($o['nama_lengkap']) ?></p>
              <?php if (!empty($o['kelas'])): ?>
                <span class="org-card__kelas"><?= htmlspecialchars($o['kelas']) ?></span>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endforeach; ?>
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
          <div class="member-card__photo-wrap">
            <?php if (!empty($m['foto'])): ?>
              <img src="<?= UPLOAD_URL . '/' . htmlspecialchars($m['foto']) ?>"
                   class="member-card__photo"
                   alt="Foto <?= htmlspecialchars($m['nama_lengkap']) ?>">
            <?php else: ?>
              <div class="member-card__photo-fallback" aria-hidden="true">
                <?= htmlspecialchars(mb_strtoupper(mb_substr($m['nama_lengkap'], 0, 2))) ?>
              </div>
            <?php endif; ?>
          </div>
          <p class="member-card__name"><?= htmlspecialchars($m['nama_lengkap']) ?></p>
          <span class="member-card__kelas"><?= htmlspecialchars($m['kelas'] ?? '—') ?></span>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

</div>