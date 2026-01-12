<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions.php';

require_login();

$productId = (int)($_POST['product_id'] ?? 0);
$qty = (int)($_POST['quantity'] ?? 1);
if ($productId <= 0) { header("Location: cos.php"); exit; }
if ($qty < 1) $qty = 1;

$userId = (int)$_SESSION['user_id'];
$cartId = get_active_cart_id($pdo, $userId);

$pdo->prepare("
  UPDATE cart_items
  SET quantity = ?
  WHERE cart_id = ? AND product_id = ?
")->execute([$qty, $cartId, $productId]);

header("Location: cos.php");
exit;
