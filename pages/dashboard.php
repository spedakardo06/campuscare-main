<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_login();

$pageTitle = 'Dashboard';
include __DIR__ . '/../includes/header.php';
?>
<h1>Hello, <?= e($_SESSION['name']) ?></h1>
<p class="muted">What would you like to do today?</p>

<div class="card-grid">
  <a class="action-card card-blue" href="report-lost.php">
    <h2>Report a lost item</h2>
    <p>Tell us what you lost and where.</p>
  </a>
  <a class="action-card card-green" href="report-found.php">
    <h2>Report a found item</h2>
    <p>Post something you found so the owner can claim it.</p>
  </a>
  <div class="action-card card-disabled">
    <h2>Report a campus issue</h2>
    <p>Coming in a later iteration.</p>
  </div>
</div>

<h2 class="section-title">Recent reports</h2>
<div class="empty-state">No reports yet. Your submitted reports will appear here.</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
