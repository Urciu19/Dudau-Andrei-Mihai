<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}

function is_logged_in(): bool {
  return isset($_SESSION['user_id']);
}

function require_login(): void {
  if (!is_logged_in()) {
    header("Location: autentificare.php");
    exit;
  }
}

function get_active_cart_id(PDO $pdo, int $userId): int {
  $stmt = $pdo->prepare("SELECT id FROM carts WHERE user_id = ? AND status='active' LIMIT 1");
  $stmt->execute([$userId]);
  $row = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($row) return (int)$row['id'];

  $pdo->prepare("INSERT INTO carts (user_id, status) VALUES (?, 'active')")->execute([$userId]);
  return (int)$pdo->lastInsertId();
}

function cart_count(PDO $pdo): int {
  if (!is_logged_in()) return 0;

  $stmt = $pdo->prepare("
    SELECT COALESCE(SUM(ci.quantity), 0) AS cnt
    FROM carts c
    JOIN cart_items ci ON ci.cart_id = c.id
    WHERE c.user_id = ? AND c.status = 'active'
  ");
  $stmt->execute([(int)$_SESSION['user_id']]);
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  return (int)($row['cnt'] ?? 0);
}

function e(string $s): string {
  return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}
