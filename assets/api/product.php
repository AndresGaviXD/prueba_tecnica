<?php
include 'db.php';

header('Content-Type: application/json');

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        // Listar productos
        $stmt = $pdo->prepare("SELECT product.*, category.name as category_name FROM product LEFT JOIN category ON product.category_id = category.id");
        $stmt->execute();
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        break;

    case 'POST':
        // Crear producto
        $data = json_decode(file_get_contents("php://input"), true);
        $stmt = $pdo->prepare("INSERT INTO product (code, name, category_id, price) VALUES (?, ?, ?, ?)");
        $stmt->execute([$data['code'], $data['name'], $data['category_id'], $data['price']]);
        echo json_encode(["status" => "success"]);
        break;

    case 'PUT':
        // Editar producto
        $data = json_decode(file_get_contents("php://input"), true);
        $stmt = $pdo->prepare("UPDATE product SET code = ?, name = ?, category_id = ?, price = ? WHERE id = ?");
        $stmt->execute([$data['code'], $data['name'], $data['category_id'], $data['price'], $data['id']]);
        echo json_encode(["status" => "success"]);
        break;

    case 'DELETE':
        // Eliminar producto
        $id = $_GET['id'];
        $stmt = $pdo->prepare("DELETE FROM product WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(["status" => "success"]);
        break;
}
?>
