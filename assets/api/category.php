<?php
include 'db.php';

header('Content-Type: application/json');

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        // Esta parte es para obtener todas las categorias
        $stmt = $pdo->prepare("SELECT * FROM category");
        $stmt->execute();
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        break;
}
?>