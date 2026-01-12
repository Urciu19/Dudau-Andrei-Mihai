<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions.php';

$cartCnt = cart_count($pdo);
?>
<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="style.css">
</head>

<body class="light" id="top">
  <div class="layout">
    <header>
      <div class="logo-container">
        <img src="imagini/logo.jpg" alt="Logo La Urciu" class="logo">
        <span class="site-title">La Urciu</span>
      </div>

      <nav>
        <a href="intro.php">Acasă</a>
        <a href="pescuit.php">Pescuit</a>
        <a href="vanatoare.php">Vânătoare</a>
        <a href="cos.php">Coș</a>

        <?php if (is_logged_in()): ?>
          <a href="logout.php">Ieșire</a>
        <?php else: ?>
          <a href="autentificare.php">Autentificare</a>
          <a href="inregistrare.php">Înregistrare</a>
        <?php endif; ?>

        <span class="cart-indicator" id="cart-count">🛒 <?= (int)$cartCnt ?></span>
      </nav>

      <div class="theme-selector">
        <label for="theme-selector">🌗 Tema:</label>
        <select id="theme-selector">
          <option value="light">Light</option>
          <option value="dark">Dark</option>
          <option value="camo">Camo</option>
        </select>
      </div>
    </header>
