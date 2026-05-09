<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | <?= htmlspecialchars($settings['org_name']['value'] ?? APP_NAME) ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/custom.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="font-inter bg-gray-950 text-gray-100 min-h-screen flex items-center justify-center p-4">
  <?= $content ?>
  <script src="<?= BASE_URL ?>/assets/js/main.js"></script>
</body>
</html>
