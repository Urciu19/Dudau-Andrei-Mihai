<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions.php';

require_login();

$productId = (int)($_POST['product_id'] ?? 0);
if ($productId <= 0) { header("Location: cos.php"); exit; }

$userId = (int)$_SESSION['user_id'];
$cartId = get_active_cart_id($pdo, $userId);

$pdo->prepare("DELETE FROM cart_items WHERE cart_id = ? AND product_id = ?")
    ->execute([$cartId, $productId]);

header("Location: cos.php");
exit;
