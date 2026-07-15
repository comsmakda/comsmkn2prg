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

  /* ══════════════════════════════════════════════
     ORG TREE — bagan tunggal: pembina → ... → seluruh anggota
     ══════════════════════════════════════════════ */
  .org-tree {
    --org-card-w: 9.75rem;
    --org-card-h: 11rem;
    --org-photo: 4.25rem;
    --org-line: var(--c-border);
    --org-gap: 1.5rem;
    --org-stem: 1.5rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: .25rem 0 0;
  }

  .org-level-wrap {
    position: relative;
    display: flex;
    justify-content: center;
    padding-top: var(--org-stem);
    max-width: 100%;
  }
  .org-level-wrap.is-root { padding-top: 0; }
  .org-level-wrap:not(.is-root)::before {
    content: '';
    position: absolute;
    top: 0; left: 50%;
    width: 2px; height: var(--org-stem);
    background: var(--org-line);
    transform: translateX(-50%);
  }

  .org-row {
    position: relative;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    gap: var(--org-gap);
    flex-wrap: nowrap;
    max-width: 100%;
    overflow-x: auto;
    padding-bottom: .25rem;
  }
  .org-row.has-bus { padding-top: var(--org-stem); }
  .org-row.has-bus::before {
    content: '';
    position: absolute;
    top: 0;
    left: calc(var(--org-card-w) / 2);
    right: calc(var(--org-card-w) / 2);
    height: 2px;
    background: var(--org-line);
  }
  .org-row.has-bus > .org-node::before {
    content: '';
    position: absolute;
    top: 0; left: 50%;
    width: 2px; height: var(--org-stem);
    background: var(--org-line);
    transform: translateX(-50%);
  }

  .org-node { position: relative; flex-shrink: 0; }

  /* ── Kartu — SATU ukuran untuk seluruh jenjang (pembina s/d anggota) ── */
  .org-card {
    box-sizing: border-box;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    width: var(--org-card-w);
    min-height: var(--org-card-h);
    background: var(--c-white);
    border: 1px solid var(--c-border);
    border-radius: var(--radius-lg);
    padding: 1.1rem .75rem .95rem;
    box-shadow: 0 16px 34px -20px rgba(15,23,42,.14), 0 3px 8px rgba(15,23,42,.04);
    transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
  }
  .org-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 20px 40px -18px rgba(15,23,42,.18), 0 4px 12px rgba(15,23,42,.06);
    border-color: rgba(14,116,144,.25);
  }
  .org-card--root {
    border-color: rgba(14,116,144,.3);
    background: linear-gradient(135deg, rgba(14,116,144,.05), rgba(6,182,212,.05));
  }

  .org-card__photo-wrap {
    box-sizing: border-box;
    width: var(--org-photo); height: var(--org-photo); margin-bottom: .65rem;
    border-radius: 50%; padding: 2.5px; flex-shrink: 0;
    background: linear-gradient(135deg, rgba(14,116,144,.4), rgba(6,182,212,.4));
  }
  .org-card--root .org-card__photo-wrap {
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
    font-size: 1.05rem; font-weight: 800; color: var(--c-primary); text-transform: uppercase;
  }

  .org-card__jabatan {
    font-size: .63rem; font-weight: 700; letter-spacing: .05em; text-transform: uppercase;
    color: var(--c-primary); margin-bottom: .3rem; line-height: 1.3;
  }
  .org-card__name {
    font-size: .82rem; font-weight: 800; color: var(--c-ink); line-height: 1.3;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
  }
  .org-card__kelas {
    display: inline-block; margin-top: .4rem;
    font-size: .63rem; font-weight: 700; color: var(--c-muted2);
  }
  .org-card__periode {
    display: block; margin-top: .3rem;
    font-size: .66rem; color: var(--c-muted2);
  }

  .org-empty {
    display: flex; align-items: center; gap: .75rem;
    background: var(--c-white); border: 1px dashed var(--c-border);
    border-radius: var(--radius-lg); padding: 1.25rem 1.4rem;
    color: var(--c-muted2); font-size: .82rem;
  }

  /* ── Tier terakhir: Seluruh Anggota — grup dengan garis label, isinya wrap ── */
  .org-leaf-group {
    position: relative;
    box-sizing: border-box;
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 1rem;
    max-width: min(72rem, calc(100vw - 3rem));
    background: rgba(14,116,144,.025);
    border: 1px dashed rgba(14,116,144,.28);
    border-radius: var(--radius-lg);
    padding: 1.9rem 1.25rem 1.35rem;
  }
  .org-leaf-group__label {
    position: absolute;
    top: -.65rem; left: 50%;
    transform: translateX(-50%);
    background: var(--c-white);
    padding: .1rem .7rem;
    font-size: .66rem; font-weight: 800; letter-spacing: .06em; text-transform: uppercase;
    color: var(--c-primary);
    border: 1px solid rgba(14,116,144,.28);
    border-radius: 999px;
  }

  /* ── Mode mobile: level jadi "kotak grup", tanpa bus/stem per-kartu ── */
  @media (max-width: 640px) {
    .org-tree { --org-card-w: 7.4rem; --org-card-h: 9.75rem; --org-photo: 3.5rem; --org-gap: .6rem; }
    .org-row {
      flex-wrap: wrap;
      overflow-x: visible;
      background: var(--c-white);
      border: 1px solid var(--c-border);
      border-radius: var(--radius-lg);
      padding: .9rem .7rem;
    }
    .org-row.has-bus { padding-top: .9rem; }
    .org-row.has-bus::before,
    .org-row.has-bus > .org-node::before { display: none; }
    .org-card { box-shadow: none; border: none; padding: 0; }
    .org-card:hover { transform: none; box-shadow: none; }
    .org-leaf-group { padding: 1.6rem .8rem 1rem; gap: .7rem; }
  }

  /* ─── Empty state ─── */
  .angp-empty {
    text-align: center; padding: 3.75rem 1.5rem; color: var(--c-muted2);
    background: var(--c-white); border: 1px dashed var(--c-border); border-radius: var(--radius-lg);
  }
  .angp-empty i { font-size: 2.4rem; opacity: .35; display: block; margin-bottom: .75rem; }
  .angp-empty__title { font-size: .95rem; font-weight: 700; color: var(--c-muted); margin-bottom: .25rem; }
  .angp-empty__sub { font-size: .8rem; }
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

  <?php
    // ── Bangun daftar level bagan: Pembina di puncak, lalu tier struktur,
    // ditutup dengan tier Seluruh Anggota di paling bawah — semua jadi SATU bagan.
    $orgLevelDefs = [
      'ketua_umum'  => ['ketua_umum'],
      'wakil_ketua' => ['wakil_ketua'],
      'tier_inti'   => ['bendahara', 'wakil_bendahara', 'sekretaris', 'wakil_sekretaris'],
      'tier_koor_bidang' => [
        'koordinator_humas', 'koordinator_perlengkapan', 'koordinator_pdd',
        'ketua_bidang_it_software', 'ketua_bidang_it_network',
        'ketua_bidang_multimedia', 'ketua_bidang_iot_robotic',
      ],
    ];

    $renderLevels = [];

    // Level 0: Pembina (root bagan)
    if (!empty($pembina)) {
      $renderLevels[] = [
        'is_root' => true,
        'people'  => [[
          'jabatan_label' => $pembina['jabatan'] ?? 'Pembina',
          'nama'          => $pembina['nama'],
          'foto'          => $pembina['foto'] ?? null,
          'periode'       => $pembina['periode'] ?? null,
          'kelas'         => null,
        ]],
      ];
    }

    // Level pengurus dari $struktur
    $adaPengurus = false;
    foreach ($orgLevelDefs as $levelKeys) {
      $tierPeople = [];
      foreach ($levelKeys as $jk) {
        foreach (($struktur[$jk] ?? []) as $orang) {
          $tierPeople[] = [
            'jabatan_label' => $jabatanLabel[$jk] ?? '',
            'nama'          => $orang['nama_lengkap'],
            'foto'          => $orang['foto'] ?? null,
            'periode'       => null,
            'kelas'         => $orang['kelas'] ?? null,
          ];
        }
      }
      if (empty($tierPeople)) continue;
      $adaPengurus = true;
      $renderLevels[] = ['is_root' => false, 'people' => $tierPeople];
    }
  ?>

  <!-- ── Struktur Organisasi (satu bagan, sampai anggota) ── -->
  <div class="angp-sec" style="margin-top:0;">
    <div class="angp-sec__row">
      <span class="angp-sec__title">Struktur Organisasi</span>
      <div class="angp-sec__line"></div>
    </div>
    <p class="angp-sec__hint">Bagan kepengurusan aktif, dari pembina hingga seluruh anggota.</p>
  </div>

  <?php if (empty($pembina) && !$adaPengurus && empty($list)): ?>
    <div class="org-empty">
      <i class="ti ti-info-circle" style="font-size:1.2rem;"></i>
      <span>Struktur pengurus belum tersedia.</span>
    </div>
  <?php else: ?>
    <div class="org-tree">
      <?php foreach ($renderLevels as $level): ?>
        <div class="org-level-wrap<?= $level['is_root'] ? ' is-root' : '' ?>">
          <div class="org-row<?= count($level['people']) > 1 ? ' has-bus' : '' ?>">
            <?php foreach ($level['people'] as $p): ?>
              <div class="org-node">
                <div class="org-card<?= $level['is_root'] ? ' org-card--root' : '' ?>">
                  <div class="org-card__photo-wrap">
                    <?php if (!empty($p['foto'])): ?>
                      <img src="<?= UPLOAD_URL . '/' . htmlspecialchars($p['foto']) ?>"
                           class="org-card__photo"
                           alt="Foto <?= htmlspecialchars($p['nama']) ?>">
                    <?php else: ?>
                      <div class="org-card__photo-fallback" aria-hidden="true">
                        <?= htmlspecialchars(mb_strtoupper(mb_substr($p['nama'], 0, 2))) ?>
                      </div>
                    <?php endif; ?>
                  </div>
                  <span class="org-card__jabatan"><?= htmlspecialchars($p['jabatan_label']) ?></span>
                  <p class="org-card__name"><?= htmlspecialchars($p['nama']) ?></p>
                  <?php if (!empty($p['kelas'])): ?>
                    <span class="org-card__kelas"><?= htmlspecialchars($p['kelas']) ?></span>
                  <?php endif; ?>
                  <?php if (!empty($p['periode'])): ?>
                    <span class="org-card__periode">Periode <?= htmlspecialchars($p['periode']) ?></span>
                  <?php endif; ?>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endforeach; ?>

      <!-- ── Tier terakhir: Seluruh Anggota (satu grup, masih bagian bagan yang sama) ── -->
      <?php if (!empty($list)): ?>
        <div class="org-level-wrap">
          <div class="org-leaf-group">
            <span class="org-leaf-group__label">Seluruh Anggota (<?= number_format(count($list)) ?>)</span>
            <?php foreach ($list as $m): ?>
              <div class="org-node">
                <div class="org-card">
                  <div class="org-card__photo-wrap">
                    <?php if (!empty($m['foto'])): ?>
                      <img src="<?= UPLOAD_URL . '/' . htmlspecialchars($m['foto']) ?>"
                           class="org-card__photo"
                           alt="Foto <?= htmlspecialchars($m['nama_lengkap']) ?>">
                    <?php else: ?>
                      <div class="org-card__photo-fallback" aria-hidden="true">
                        <?= htmlspecialchars(mb_strtoupper(mb_substr($m['nama_lengkap'], 0, 2))) ?>
                      </div>
                    <?php endif; ?>
                  </div>
                  <span class="org-card__jabatan">Anggota</span>
                  <p class="org-card__name"><?= htmlspecialchars($m['nama_lengkap']) ?></p>
                  <span class="org-card__kelas"><?= htmlspecialchars($m['kelas'] ?? '—') ?></span>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endif; ?>
    </div>
  <?php endif; ?>

</div>