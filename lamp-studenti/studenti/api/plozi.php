<?php
header("Content-Type: application/json");
require_once __DIR__ . "/../db.php";

$method = $_SERVER["REQUEST_METHOD"];

/* GET – afișare studenți */
if ($method === "GET") {
    $stmt = $pdo->query("SELECT nume, an, media FROM plozi");
    echo json_encode($stmt->fetchAll());
    exit;
}

/* POST – adăugare student */
if ($method === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    $nume  = $data["nume"] ?? "";
    $an    = $data["an"] ?? 0;
    $media = $data["media"] ?? 0;

    $stmt = $pdo->prepare(
        "INSERT INTO plozi (nume, an, media) VALUES (?, ?, ?)"
    );
    $stmt->execute([$nume, $an, $media]);

    echo json_encode(["success" => true]);
    exit;
}
