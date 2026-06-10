<?php
// app/views/admin/berita_form.php
$isEdit = isset($berita) && $berita !== null;
$action = $isEdit
    ? BASE_URL . '/admin/berita/' . $berita['id'] . '/update'
    : BASE_URL . '/admin/berita/store';
?>
<style>
/* ── Form tokens ── */
.bf-field { display:flex; flex-direction:column; gap:6px; }
.bf-label {
  font-family: var(--fm);
  font-size: 10px;
  font-weight: 500;
  letter-spacing: .1em;
  text-transform: uppercase;
  color: var(--t3);
}
.bf-label span { color: var(--er); margin-left:2px; }
.bf-input,
.bf-textarea,
.bf-select {
  width: 100%;
  background: var(--bg-2);
  border: 1px solid var(--b1);
  border-radius: var(--r3);
  padding: 9px 12px;
  font-family: var(--ff);
  font-size: 13px;
  color: var(--t1);
  outline: none;
  transition: border-color var(--tf) var(--ease), box-shadow var(--tf) var(--ease), background var(--tf) var(--ease);
  appearance: none;
  -webkit-appearance: none;
}
.bf-input:focus,
.bf-textarea:focus,
.bf-select:focus {
  border-color: var(--ba);
  background: var(--bg-3);
  box-shadow: 0 0 0 3px var(--ac-gl);
}
.bf-input::placeholder,
.bf-textarea::placeholder { color: var(--t3); }
.bf-input.title-input {
  font-size: 15px;
  font-weight: 600;
  letter-spacing: -.02em;
  padding: 11px 14px;
}
.bf-textarea { resize: vertical; line-height: 1.7; }
.bf-textarea.code { font-family: var(--fm); font-size: 12.5px; }
.bf-select {
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%235a7391' stroke-width='2' viewBox='0 0 16 16'%3E%3Cpolyline points='4 6 8 10 12 6'/%3E%3C/svg%3E");
  background-repeat: no-repeat;
  background-position: right 10px center;
  padding-right: 32px;
  cursor: pointer;
}
.bf-hint {
  font-size: 11px;
  color: var(--t3);
  line-height: 1.5;
}
.bf-card {
  background: var(--bg-1);
  border: 1px solid var(--b0);
  border-radius: var(--r4);
  padding: 1.1rem 1.2rem;
}
.bf-card-title {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 10px;
  font-weight: 600;
  letter-spacing: .1em;
  text-transform: uppercase;
  color: var(--ac);
  margin-bottom: 1rem;
  font-family: var(--fm);
}
.bf-card-title::after {
  content: '';
  flex: 1;
  height: 1px;
  background: linear-gradient(to right, var(--ba), transparent);
}
.bf-divider { height: 1px; background: var(--b0); margin: .75rem 0; }

/* File upload */
.bf-upload-zone {
  position: relative;
  border: 1px dashed var(--b2);
  border-radius: var(--r3);
  padding: 18px;
  text-align: center;
  cursor: pointer;
  transition: border-color var(--tm), background var(--tm);
}
.bf-upload-zone:hover { border-color: var(--ba); background: var(--ac-lo); }
.bf-upload-zone input[type="file"] {
  position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%;
}
.bf-upload-icon { color: var(--t3); margin: 0 auto 6px; }
.bf-upload-text { font-size: 12px; color: var(--t2); font-weight: 500; }
.bf-upload-sub  { font-size: 11px; color: var(--t3); margin-top: 2px; }

/* Thumb preview */
.bf-thumb-wrap {
  border-radius: var(--r3);
  overflow: hidden;
  aspect-ratio: 16/9;
  background: var(--bg-2);
  border: 1px solid var(--b1);
  position: relative;
}
.bf-thumb-wrap img { width:100%; height:100%; object-fit:cover; display:block; }
.bf-thumb-badge {
  position: absolute; top:7px; right:7px;
  font-family: var(--fm); font-size:9px; font-weight:500;
  background: rgba(0,0,0,.65); color: var(--t1);
  padding: 2px 7px; border-radius: var(--r1);
  backdrop-filter: blur(4px);
}

/* Status badge */
.bf-status-dot {
  width: 6px; height: 6px; border-radius: 50%; flex-shrink:0;
  background: var(--t3);
}
.bf-status-dot.pub { background: var(--ok); box-shadow: 0 0 0 3px var(--ok-d); }
.bf-status-dot.dft { background: var(--wa); box-shadow: 0 0 0 3px var(--wa-d); }

/* Buttons */
.btn-primary {
  display: flex; align-items: center; justify-content: center; gap: 7px;
  width: 100%; padding: 10px 16px;
  background: var(--ac); border: none; border-radius: var(--r3);
  font-family: var(--ff); font-size: 13px; font-weight: 600;
  color: #fff; cursor: pointer; letter-spacing: -.01em;
  transition: opacity var(--tf), transform var(--tf);
}
.btn-primary:hover { opacity: .88; }
.btn-primary:active { transform: scale(.98); }
.btn-primary svg { width:14px; height:14px; flex-shrink:0; }

.btn-ghost {
  display: inline-flex; align-items: center; gap: 6px;
  padding: 7px 13px;
  background: transparent; border: 1px solid var(--b1); border-radius: var(--r3);
  font-family: var(--ff); font-size: 12px; font-weight: 500;
  color: var(--t2); cursor: pointer; text-decoration:none;
  transition: border-color var(--tf), color var(--tf), background var(--tf);
}
.btn-ghost:hover { border-color: var(--b2); color: var(--t1); background: var(--bg-h); }
.btn-ghost svg { width:13px; height:13px; }

.btn-view {
  display: flex; align-items: center; justify-content: center; gap: 6px;
  width: 100%; padding: 8px;
  background: var(--ac-lo); border: 1px solid var(--ba); border-radius: var(--r3);
  font-family: var(--ff); font-size: 12px; font-weight: 500;
  color: var(--ac-hi); cursor: pointer; text-decoration:none;
  transition: background var(--tf), border-color var(--tf);
}
.btn-view:hover { background: rgba(82,130,255,.12); }
.btn-view svg { width:13px; height:13px; }

/* Char counter */
.bf-counter {
  font-family: var(--fm);
  font-size: 10px;
  color: var(--t3);
  text-align: right;
}
.bf-counter.warn { color: var(--wa); }

/* Toolbar markdown hint */
.bf-toolbar {
  display: flex; gap: 4px; flex-wrap: wrap;
  padding: 7px 10px;
  background: var(--bg-2);
  border: 1px solid var(--b1);
  border-bottom: none;
  border-radius: var(--r3) var(--r3) 0 0;
}
.bf-toolbar .bf-textarea { border-radius: 0 0 var(--r3) var(--r3) !important; }
.tb-btn {
  display: flex; align-items: center; gap: 4px;
  padding: 3px 8px; border-radius: var(--r2);
  background: none; border: 1px solid transparent;
  font-family: var(--fm); font-size: 11px; font-weight: 500;
  color: var(--t3); cursor: pointer;
  transition: color var(--tf), background var(--tf), border-color var(--tf);
}
.tb-btn:hover { color: var(--t1); background: var(--bg-3); border-color: var(--b1); }

/* Grid layout */
.bf-grid {
  display: grid;
  grid-template-columns: 1fr 268px;
  gap: 1.1rem;
  align-items: start;
}
@media (max-width: 900px) {
  .bf-grid { grid-template-columns: 1fr; }
  .bf-sidebar { order: -1; }
}
</style>

<!-- ── Page Header ── -->
<div style="display:flex;align-items:flex-start;justify-content:space-between;gap:1rem;margin-bottom:1.5rem;flex-wrap:wrap">
  <div>
    <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px">
      <span style="font-family:var(--fm);font-size:10px;font-weight:600;letter-spacing:.08em;text-transform:uppercase;color:var(--ac)">
        <?= $isEdit ? 'Edit Berita' : 'Berita Baru' ?>
      </span>
      <?php if ($isEdit): ?>
      <span style="font-family:var(--fm);font-size:10px;padding:2px 7px;border-radius:var(--r1);background:var(--<?= ($berita['status']??'draft')==='published'?'ok':'wa' ?>-d);border:1px solid var(--<?= ($berita['status']??'draft')==='published'?'ok':'wa' ?>-b);color:var(--<?= ($berita['status']??'draft')==='published'?'ok':'wa' ?>)">
        <?= ($berita['status']??'draft')==='published' ? 'Published' : 'Draft' ?>
      </span>
      <?php endif; ?>
    </div>
    <h1 style="font-size:1.15rem;font-weight:700;color:var(--t1);letter-spacing:-.025em;line-height:1.2">
      <?= $isEdit ? htmlspecialchars($berita['judul']) : 'Tulis Artikel Baru' ?>
    </h1>
    <?php if ($isEdit): ?>
    <p style="font-size:11.5px;color:var(--t3);margin-top:3px">
      Terakhir diperbarui <?= isset($berita['updated_at']) ? date('d M Y, H:i', strtotime($berita['updated_at'])) : '—' ?>
    </p>
    <?php endif; ?>
  </div>
  <a href="<?= BASE_URL ?>/admin/berita" class="btn-ghost">
    <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 16 16" aria-hidden="true"><polyline points="10 12 6 8 10 4"/></svg>
    Kembali
  </a>
</div>

<?php if (!empty($flash)): ?>
<div class="alert alert-<?= $flash['type']==='success'?'s':($flash['type']==='error'?'e':'w') ?>" style="margin-bottom:1rem;display:flex;align-items:center;gap:10px;padding:10px 14px;border-radius:var(--r3);font-size:12.5px;font-weight:500;border:1px solid">
  <?= htmlspecialchars($flash['msg']) ?>
</div>
<?php endif; ?>

<form method="POST" action="<?= $action ?>" enctype="multipart/form-data" id="bf-form">
  <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">

  <div class="bf-grid">

    <!-- ════ Kolom Kiri ════ -->
    <div style="display:flex;flex-direction:column;gap:1rem">

      <!-- Judul -->
      <div class="bf-card">
        <div class="bf-field">
          <label class="bf-label" for="bf-judul">Judul Berita <span>*</span></label>
          <input
            type="text" id="bf-judul" name="judul"
            class="bf-input title-input"
            value="<?= htmlspecialchars($berita['judul'] ?? '') ?>"
            placeholder="Tulis judul yang menarik dan informatif…"
            maxlength="200"
            required
            oninput="updateCounter(this,'jc',200)"
          >
          <div style="display:flex;justify-content:flex-end">
            <span class="bf-counter" id="jc"><?= strlen($berita['judul'] ?? '') ?>/200</span>
          </div>
        </div>
      </div>

      <!-- Ringkasan -->
      <div class="bf-card">
        <div class="bf-field">
          <div style="display:flex;align-items:center;justify-content:space-between">
            <label class="bf-label" for="bf-ringkasan">Ringkasan / Excerpt</label>
            <span style="font-size:11px;color:var(--t3);font-family:var(--fm)">opsional</span>
          </div>
          <textarea
            id="bf-ringkasan" name="ringkasan" rows="3"
            class="bf-textarea"
            maxlength="300"
            placeholder="Deskripsi singkat yang ditampilkan di daftar artikel dan meta description…"
            oninput="updateCounter(this,'rc',300)"
          ><?= htmlspecialchars($berita['ringkasan'] ?? '') ?></textarea>
          <div style="display:flex;align-items:center;justify-content:space-between">
            <span class="bf-hint">Idealnya 120–160 karakter untuk SEO.</span>
            <span class="bf-counter" id="rc"><?= strlen($berita['ringkasan'] ?? '') ?>/300</span>
          </div>
        </div>
      </div>

      <!-- Konten -->
      <div class="bf-card">
        <div class="bf-card-title">Konten Artikel</div>
        <div class="bf-field">
          <label class="bf-label" for="bf-konten">Isi Artikel <span>*</span></label>

          <!-- Toolbar -->
          <div class="bf-toolbar">
            <button type="button" class="tb-btn" onclick="wrapTag('h2')"><b>H2</b></button>
            <button type="button" class="tb-btn" onclick="wrapTag('h3')"><b>H3</b></button>
            <button type="button" class="tb-btn" onclick="wrapTag('p')"><span>¶</span> P</button>
            <button type="button" class="tb-btn" onclick="wrapTag('strong')"><b>B</b></button>
            <button type="button" class="tb-btn" onclick="wrapTag('em')"><i>I</i></button>
            <button type="button" class="tb-btn" onclick="wrapTag('a','href=\"\"')">
              <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 16 16"><path d="M6 8a3 3 0 0 0 4.5.5l2-2a3 3 0 0 0-4.24-4.24L7 3.5"/><path d="M10 8a3 3 0 0 0-4.5-.5l-2 2a3 3 0 0 0 4.24 4.24L9 12.5"/></svg>
              Link
            </button>
            <button type="button" class="tb-btn" onclick="wrapTag('blockquote')">
              <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 16 16"><path d="M3 3h4v5H3zM9 3h4v5H9z"/><path d="M3 8c0 2 1.5 3 4 4M9 8c0 2 1.5 3 4 4"/></svg>
              Quote
            </button>
            <button type="button" class="tb-btn" onclick="insertImg()">
              <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 16 16"><rect x="2" y="2" width="12" height="12" rx="1.5"/><circle cx="5.5" cy="5.5" r="1.5"/><polyline points="2 11 6 7 9 10 11 8 14 11"/></svg>
              Img
            </button>
            <button type="button" class="tb-btn" onclick="insertList()">
              <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 16 16"><line x1="5" y1="4" x2="14" y2="4"/><line x1="5" y1="8" x2="14" y2="8"/><line x1="5" y1="12" x2="14" y2="12"/><circle cx="2" cy="4" r=".8" fill="currentColor"/><circle cx="2" cy="8" r=".8" fill="currentColor"/><circle cx="2" cy="12" r=".8" fill="currentColor"/></svg>
              UL
            </button>
          </div>

          <textarea
            id="bf-konten" name="konten" rows="22"
            class="bf-textarea code"
            style="border-radius:0 0 var(--r3) var(--r3);"
            placeholder="Tulis isi artikel HTML di sini…&#10;&#10;Contoh:&#10;&lt;h2&gt;Sub Judul&lt;/h2&gt;&#10;&lt;p&gt;Paragraf artikel...&lt;/p&gt;"
            required
          ><?= htmlspecialchars($berita['konten'] ?? '') ?></textarea>
          <span class="bf-hint">Mendukung HTML: &lt;h2&gt; &lt;h3&gt; &lt;p&gt; &lt;ul&gt; &lt;ol&gt; &lt;img&gt; &lt;blockquote&gt; &lt;strong&gt; &lt;em&gt; &lt;a&gt;</span>
        </div>
      </div>

    </div><!-- /kolom kiri -->

    <!-- ════ Kolom Kanan (Sidebar) ════ -->
    <div class="bf-sidebar" style="display:flex;flex-direction:column;gap:1rem">

      <!-- Publikasi -->
      <div class="bf-card">
        <div class="bf-card-title">Publikasi</div>

        <div style="display:flex;flex-direction:column;gap:.75rem">
          <div class="bf-field">
            <label class="bf-label" for="bf-status">Status</label>
            <div style="position:relative">
              <select id="bf-status" name="status" class="bf-select" onchange="updateStatusDot(this)">
                <option value="draft"     <?= ($berita['status'] ?? 'draft') !== 'published' ? 'selected' : '' ?>>
                  Draft — Tidak Tampil
                </option>
                <option value="published" <?= ($berita['status'] ?? '') === 'published' ? 'selected' : '' ?>>
                  Published — Tampil Publik
                </option>
              </select>
            </div>
          </div>

          <div class="bf-divider"></div>

          <button type="submit" class="btn-primary" id="bf-submit">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 16 16" aria-hidden="true">
              <?php if ($isEdit): ?>
                <path d="M2 2h9l3 3v9H2z"/><path d="M5 2v4h6V2"/><rect x="4" y="9" width="8" height="5" rx=".5"/>
              <?php else: ?>
                <path d="M13.5 8.5v4a1 1 0 01-1 1h-9a1 1 0 01-1-1v-9a1 1 0 011-1H11l2.5 2.5z"/><path d="M8 4v5m-2.5-2.5l2.5 2.5 2.5-2.5"/>
              <?php endif; ?>
            </svg>
            <?= $isEdit ? 'Simpan Perubahan' : 'Simpan Berita' ?>
          </button>

          <?php if ($isEdit): ?>
          <a href="<?= BASE_URL ?>/berita/<?= htmlspecialchars($berita['slug'] ?? '') ?>"
             target="_blank" class="btn-view">
            <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 16 16" aria-hidden="true">
              <path d="M1 8s2.5-5 7-5 7 5 7 5-2.5 5-7 5-7-5-7-5z"/><circle cx="8" cy="8" r="2"/>
            </svg>
            Lihat di halaman publik
          </a>
          <?php endif; ?>
        </div>
      </div>

      <!-- Kategori -->
      <div class="bf-card">
        <div class="bf-card-title">Kategori</div>
        <div class="bf-field">
          <label class="bf-label" for="bf-kat">Pilih Kategori</label>
          <select id="bf-kat" name="kategori_id" class="bf-select">
            <option value="">— Tidak ada —</option>
            <?php foreach ($kategoriList as $k): ?>
            <option value="<?= htmlspecialchars($k['id']) ?>"
              <?= ($berita['kategori_id'] ?? '') == $k['id'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($k['nama']) ?>
            </option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <!-- Thumbnail -->
      <div class="bf-card">
        <div class="bf-card-title">Thumbnail</div>

        <?php if (!empty($berita['thumbnail'])): ?>
        <div style="margin-bottom:.85rem">
          <div class="bf-thumb-wrap">
            <img src="<?= UPLOAD_URL . '/' . htmlspecialchars($berita['thumbnail']) ?>" alt="Thumbnail saat ini">
            <span class="bf-thumb-badge">Saat ini</span>
          </div>
        </div>
        <?php endif; ?>

        <div class="bf-upload-zone" id="bf-drop">
          <input type="file" name="thumbnail" accept="image/jpeg,image/png,image/webp,image/gif"
                 onchange="previewThumb(this)">
          <svg class="bf-upload-icon" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
            <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M17 8l-5-5-5 5M12 3v12"/>
          </svg>
          <p class="bf-upload-text">Klik atau seret gambar ke sini</p>
          <p class="bf-upload-sub">JPG, PNG, WEBP — maks. 2 MB</p>
        </div>

        <!-- Preview baru -->
        <div id="bf-new-thumb" style="display:none;margin-top:.7rem">
          <div class="bf-thumb-wrap">
            <img id="bf-thumb-img" src="" alt="Preview">
            <span class="bf-thumb-badge" style="background:rgba(45,212,160,.75);color:#fff">Baru</span>
          </div>
          <button type="button" onclick="clearThumb()" style="margin-top:5px;background:none;border:none;font-size:11px;color:var(--er);cursor:pointer;font-family:var(--ff);padding:0">
            × Hapus pilihan
          </button>
        </div>

        <p class="bf-hint" style="margin-top:.5rem">Rekomendasi: 1200×630 px (rasio 16:9).</p>
      </div>

      <!-- Info (edit mode) -->
      <?php if ($isEdit): ?>
      <div class="bf-card">
        <div class="bf-card-title">Info</div>
        <div style="display:flex;flex-direction:column;gap:8px">
          <?php
            $rows = [
              ['ID Artikel', '#' . $berita['id']],
              ['Slug', $berita['slug'] ?? '—'],
              ['Dibuat', isset($berita['created_at']) ? date('d M Y', strtotime($berita['created_at'])) : '—'],
              ['Penulis', $berita['penulis'] ?? ($_SESSION['user_name'] ?? '—')],
            ];
            foreach ($rows as [$lbl, $val]):
          ?>
          <div style="display:flex;align-items:center;justify-content:space-between;gap:8px">
            <span style="font-size:11.5px;color:var(--t3)"><?= $lbl ?></span>
            <span style="font-size:11.5px;color:var(--t2);font-family:var(--fm);text-align:right;word-break:break-all"><?= htmlspecialchars($val) ?></span>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
      <?php endif; ?>

    </div><!-- /kolom kanan -->
  </div><!-- /grid -->
</form>

<script>
/* Counter */
function updateCounter(el, id, max) {
  var c = document.getElementById(id);
  if (!c) return;
  var n = el.value.length;
  c.textContent = n + '/' + max;
  c.classList.toggle('warn', n > max * .85);
}
/* Init counters */
(function(){
  var j = document.getElementById('bf-judul');
  var r = document.getElementById('bf-ringkasan');
  if (j) updateCounter(j, 'jc', 200);
  if (r) updateCounter(r, 'rc', 300);
})();

/* Toolbar helpers */
function getTA(){ return document.getElementById('bf-konten'); }
function wrapTag(tag, attrs) {
  var ta = getTA();
  var s  = ta.selectionStart, e = ta.selectionEnd;
  var sel = ta.value.substring(s, e) || 'teks di sini';
  var open = attrs ? '<' + tag + ' ' + attrs + '>' : '<' + tag + '>';
  ta.setRangeText(open + sel + '</' + tag + '>', s, e, 'select');
  ta.focus();
}
function insertImg(){
  var ta = getTA();
  var s  = ta.selectionStart;
  var url = prompt('URL gambar:', 'https://');
  if (!url) return;
  var alt = prompt('Alt text:', 'Keterangan gambar') || '';
  ta.setRangeText('<img src="' + url + '" alt="' + alt + '" style="max-width:100%;">', s, s, 'end');
  ta.focus();
}
function insertList(){
  var ta = getTA();
  var s  = ta.selectionStart;
  ta.setRangeText('\n<ul>\n  <li>Item 1</li>\n  <li>Item 2</li>\n  <li>Item 3</li>\n</ul>\n', s, s, 'end');
  ta.focus();
}

/* Thumbnail preview */
function previewThumb(input) {
  if (!input.files || !input.files[0]) return;
  var reader = new FileReader();
  reader.onload = function(e) {
    document.getElementById('bf-thumb-img').src = e.target.result;
    document.getElementById('bf-new-thumb').style.display = 'block';
  };
  reader.readAsDataURL(input.files[0]);
}
function clearThumb() {
  document.querySelector('#bf-drop input[type=file]').value = '';
  document.getElementById('bf-new-thumb').style.display = 'none';
}

/* Drag & drop highlight */
var dz = document.getElementById('bf-drop');
if (dz) {
  ['dragenter','dragover'].forEach(function(ev){
    dz.addEventListener(ev, function(e){ e.preventDefault(); dz.style.borderColor='var(--ac)'; dz.style.background='var(--ac-lo)'; });
  });
  ['dragleave','drop'].forEach(function(ev){
    dz.addEventListener(ev, function(e){ dz.style.borderColor=''; dz.style.background=''; });
  });
}

/* Submit state */
document.getElementById('bf-form').addEventListener('submit', function(){
  var btn = document.getElementById('bf-submit');
  if (btn) { btn.disabled = true; btn.style.opacity = '.6'; }
});
</script>