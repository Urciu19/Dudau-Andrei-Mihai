<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions.php';

$error = '';
$ok = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $fullName = trim($_POST['full_name'] ?? '');
  $email    = trim($_POST['email'] ?? '');
  $pass     = (string)($_POST['password'] ?? '');

  if ($fullName === '' || $email === '' || $pass === '') {
    $error = "Completează toate câmpurile.";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = "Email invalid.";
  } else {
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
    $stmt->execute([$email]);

    if ($stmt->fetch()) {
      $error = "Există deja un cont cu acest email.";
    } else {
      $hash = password_hash($pass, PASSWORD_DEFAULT);
      $pdo->prepare(
        "INSERT INTO users (full_name, email, password_hash) VALUES (?, ?, ?)"
      )->execute([$fullName, $email, $hash]);

      header("Location: autentificare.php?created=1");
      exit;
    }
  }
}

require_once __DIR__ . '/header.php';
?>

<main>
  <form method="post">
    <h2 style="text-align:center;">Înregistrare</h2>

    <?php if ($error): ?>
      <p style="color:#b00020; font-weight:bold;"><?= e($error) ?></p>
    <?php endif; ?>

    <label>Nume complet</label>
    <input type="text" name="full_name" required>

    <label>Email</label>
    <input type="email" name="email" required>

    <label>Parolă</label>
    <input type="password" name="password" required>

    <button type="submit">Creează cont</button>

    <p style="text-align:center; margin-top:10px;">
      Ai deja cont? <a href="autentificare.php">Autentificare</a>
    </p>
  </form>
</main>

<?php require_once __DIR__ . '/footer.php'; ?>
