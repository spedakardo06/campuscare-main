<?php $flash = get_flash(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($pageTitle ?? 'CampusCare') ?> | CampusCare</title>
  <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/style.css">
</head>
<body>
<header class="navbar">
  <a class="brand" href="<?= BASE_URL ?>/index.php">Campus<span>Care</span></a>
  <nav>
    <?php if (is_logged_in()): ?>
      <a href="<?= BASE_URL ?>/pages/dashboard.php">Dashboard</a>
      <a href="<?= BASE_URL ?>/pages/logout.php">Log out</a>
    <?php else: ?>
      <a href="<?= BASE_URL ?>/pages/login.php">Log in</a>
      <a href="<?= BASE_URL ?>/pages/register.php">Register</a>
    <?php endif; ?>
  </nav>
</header>
<main class="container">
<?php if ($flash): ?>
  <div class="alert alert-<?= e($flash['type']) ?>"><?= e($flash['msg']) ?></div>
<?php endif; ?>
