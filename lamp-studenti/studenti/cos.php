<?php
require_once __DIR__ . '/header.php';
require_once __DIR__ . '/functions.php';

if (!is_logged_in()) {
  echo "<main><p>Trebuie să te autentifici ca să vezi coșul.</p></main>";
  require_once __DIR__ . '/footer.php';
  exit;
}

$userId = (int)$_SESSION['user_id'];
$cartId = get_active_cart_id($pdo, $userId);

$stmt = $pdo->prepare("
  SELECT ci.product_id, ci.quantity, p.name, p.price, p.image_path
  FROM cart_items ci
  JOIN products p ON p.id = ci.product_id
  WHERE ci.cart_id = ?
  ORDER BY ci.id ASC
");
$stmt->execute([$cartId]);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total = 0.0;
foreach ($items as $it) $total += (float)$it['price'] * (int)$it['quantity'];
?>

<main>
  <h1>Coșul tău de cumpărături</h1>

  <div class="cards">
    <?php if (!$items): ?>
      <p style="text-align:center;">Coșul este gol.</p>
    <?php else: ?>
      <?php foreach ($items as $it): ?>
        <div class="card">
          <img src="<?= e($it['image_path'] ?? '') ?>" alt="<?= e($it['name']) ?>">
          <div class="info-produs">
            <strong><?= e($it['name']) ?></strong>
            <p>Preț: <?= number_format((float)$it['price'], 2) ?> RON</p>

            <form method="post" action="update_cart.php" style="margin:10px 0 0; box-shadow:none; padding:0; background:transparent; max-width:none;">
              <input type="hidden" name="product_id" value="<?= (int)$it['product_id'] ?>">
              <input type="number" name="quantity" min="1" value="<?= (int)$it['quantity'] ?>" style="width:90px;">
              <button class="add-to-cart" type="submit">Actualizează</button>
            </form>
          </div>

          <form method="post" action="remove_from_cart.php" style="margin:0; box-shadow:none; padding:0; background:transparent; max-width:none;">
            <input type="hidden" name="product_id" value="<?= (int)$it['product_id'] ?>">
            <button class="add-to-cart" type="submit">Șterge</button>
          </form>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>

  <?php if ($items): ?>
    <h2 id="total">Total: <?= number_format($total, 2) ?> RON</h2>
  <?php endif; ?>
</main>

<?php require_once __DIR__ . '/footer.php'; ?>
