<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/auth.php';
if (is_logged_in()) { redirect('/pages/dashboard.php'); }

$errors = []; $name = ''; $email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $name     = trim($_POST['full_name'] ?? '');
    $email    = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm_password'] ?? '';

    if (mb_strlen($name) < 2 || mb_strlen($name) > 100) { $errors['full_name'] = 'Enter your full name (2 to 100 characters).'; }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 150) { $errors['email'] = 'Enter a valid email address.'; }
    if (strlen($password) < 8) { $errors['password'] = 'Password must be at least 8 characters.'; }
    if ($password !== $confirm) { $errors['confirm_password'] = 'Passwords do not match.'; }

    if (!$errors) {
        $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $errors['email'] = 'An account with this email already exists.';
        } else {
            $stmt = $pdo->prepare('INSERT INTO users (full_name, email, password_hash, role) VALUES (?, ?, ?, "student")');
            $stmt->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT)]);
            set_flash('success', 'Account created. You can log in now.');
            redirect('/pages/login.php');
        }
    }
}

$pageTitle = 'Register';
include __DIR__ . '/../includes/header.php';
?>
<section class="auth-card">
  <h1>Create your account</h1>
  <p class="muted">Report lost items and campus issues in one place.</p>
  <form method="post" novalidate>
    <?= csrf_field() ?>
    <div class="field">
      <label for="full_name">Full name</label>
      <input type="text" id="full_name" name="full_name" value="<?= e($name) ?>" class="<?= isset($errors['full_name']) ? 'has-error' : '' ?>">
      <?php if (isset($errors['full_name'])): ?><small class="error"><?= e($errors['full_name']) ?></small><?php endif; ?>
    </div>
    <div class="field">
      <label for="email">Email</label>
      <input type="email" id="email" name="email" value="<?= e($email) ?>" class="<?= isset($errors['email']) ? 'has-error' : '' ?>">
      <?php if (isset($errors['email'])): ?><small class="error"><?= e($errors['email']) ?></small><?php endif; ?>
    </div>
    <div class="field">
      <label for="password">Password</label>
      <input type="password" id="password" name="password" class="<?= isset($errors['password']) ? 'has-error' : '' ?>">
      <?php if (isset($errors['password'])): ?><small class="error"><?= e($errors['password']) ?></small><?php endif; ?>
    </div>
    <div class="field">
      <label for="confirm_password">Confirm password</label>
      <input type="password" id="confirm_password" name="confirm_password" class="<?= isset($errors['confirm_password']) ? 'has-error' : '' ?>">
      <?php if (isset($errors['confirm_password'])): ?><small class="error"><?= e($errors['confirm_password']) ?></small><?php endif; ?>
    </div>
    <button type="submit" class="btn btn-primary btn-block">Register</button>
  </form>
  <p class="muted center">Already registered? <a href="login.php">Log in</a></p>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
