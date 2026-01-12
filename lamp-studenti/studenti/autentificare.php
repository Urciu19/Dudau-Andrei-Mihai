<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = trim($_POST['email'] ?? '');
  $pass  = (string)($_POST['password'] ?? '');

  $stmt = $pdo->prepare("SELECT id, password_hash FROM users WHERE email = ? LIMIT 1");
  $stmt->execute([$email]);
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  if (!$user || !password_verify($pass, $user['password_hash'])) {
    $error = "Email sau parolă incorecte.";
  } else {
    $_SESSION['user_id'] = (int)$user['id'];

    header("Location: intro.php");
    exit;
  }
}

require_once __DIR__ . '/header.php';
?>

<main>
  <form method="post" action="autentificare.php">
    <h2 style="text-align:center;">Autentificare</h2>

    <?php if ($error): ?>
      <p style="color:#b00020; font-weight:bold;"><?= e($error) ?></p>
    <?php endif; ?>

    <label>Email</label>
    <input type="email" name="email" placeholder="exemplu@email.com" required>

    <label>Parolă</label>
    <input type="password" name="password" placeholder="Parolă" required>

    <button type="submit">Intră în cont</button>

    <p style="text-align:center; margin-top:10px;">
      Nu ai cont? <a href="inregistrare.php">Înregistrare</a>
    </p>
  </form>
</main>

<?php require_once __DIR__ . '/footer.php'; ?>
