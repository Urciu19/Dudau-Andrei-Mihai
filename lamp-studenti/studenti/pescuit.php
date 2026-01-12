<?php
require_once __DIR__ . '/header.php';

$stmt = $pdo->prepare("
  SELECT p.id, p.name, p.description, p.price, p.image_path
  FROM products p
  JOIN categories c ON c.id = p.category_id
  WHERE c.slug = 'pescuit' AND p.is_active = 1
  ORDER BY p.id ASC
");
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main>
  <h1>Articole pentru Pescuit</h1>

  <div class="cards">
    <?php foreach ($products as $p): ?>
      <div class="card">
        <img src="<?= e($p['image_path'] ?? '') ?>" alt="<?= e($p['name']) ?>">
        <div class="info-produs">
          <strong><?= e($p['name']) ?></strong>
          <p><?= e($p['description'] ?? '') ?></p>
        </div>
        <div class="pret"><?= number_format((float)$p['price'], 2) ?> RON</div>

        <form method="post" action="add_to_cart.php" style="margin:0; box-shadow:none; padding:0; background:transparent; max-width:none;">
          <input type="hidden" name="product_id" value="<?= (int)$p['id'] ?>">
          <button class="add-to-cart" type="submit">Adaugă în coș</button>
        </form>
      </div>
    <?php endforeach; ?>
  </div>
</main>

<?php require_once __DIR__ . '/footer.php'; ?>
