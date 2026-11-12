<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/auth.php';
if (is_logged_in()) { redirect('/pages/dashboard.php'); }

$error = ''; $email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $email    = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare('SELECT id, full_name, password_hash, role FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name']    = $user['full_name'];
        $_SESSION['role']    = $user['role'];
        redirect('/pages/dashboard.php');
    }
    // Same message for both cases, so attackers cannot tell which emails exist.
    $error = 'Incorrect email or password.';
}

$pageTitle = 'Log in';
include __DIR__ . '/../includes/header.php';
?>
<section class="auth-card">
  <h1>Welcome back</h1>
  <p class="muted">Log in to track your reports.</p>
  <?php if ($error): ?><div class="alert alert-error"><?= e($error) ?></div><?php endif; ?>
  <form method="post" novalidate>
    <?= csrf_field() ?>
    <div class="field">
      <label for="email">Email</label>
      <input type="email" id="email" name="email" value="<?= e($email) ?>" autofocus>
    </div>
    <div class="field">
      <label for="password">Password</label>
      <input type="password" id="password" name="password">
    </div>
    <button type="submit" class="btn btn-primary btn-block">Log in</button>
  </form>
  <p class="muted center">New here? <a href="register.php">Create an account</a></p>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
