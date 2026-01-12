<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions.php';

require_login();

$productId = (int)($_POST['product_id'] ?? 0);
if ($productId <= 0) {
  header("Location: cos.php");
  exit;
}

$userId = (int)$_SESSION['user_id'];
$cartId = get_active_cart_id($pdo, $userId);

$pdo->prepare("
  INSERT INTO cart_items (cart_id, product_id, quantity)
  VALUES (?, ?, 1)
  ON DUPLICATE KEY UPDATE quantity = quantity + 1
")->execute([$cartId, $productId]);

header("Location: cos.php");
exit;
