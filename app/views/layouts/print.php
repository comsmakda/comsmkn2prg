<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cetak | <?= APP_NAME ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/custom.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    @media print {
      .no-print { display: none !important; }
      body { background: white; color: black; }
    }
  </style>
</head>
<body class="font-inter bg-white text-gray-900 p-6">

  <!-- Print toolbar -->
  <div class="no-print mb-6 flex gap-3">
    <button onclick="window.print()"
            class="px-5 py-2 bg-cyan-600 text-white rounded-lg hover:bg-cyan-500 font-semibold text-sm">
      🖨️ Cetak / Simpan PDF
    </button>
    <button onclick="window.history.back()"
            class="px-5 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-semibold text-sm">
      ← Kembali
    </button>
  </div>

  <?= $content ?>
</body>
</html>
