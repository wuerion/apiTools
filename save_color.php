<?php
header('Content-Type: application/json');

include 'db_connection-php';

$input = json_decode(file_get_contents('php://input'), true);

if(isset($input['color'])) {
    $color = $input['color'];

    //consulta para imprimir el color en la db
    $query = $conn->prepare("INSERT INTO colors (hexa) VALUES (:colors)");
    $query->bindParam(':color', $color);

    if($query->execute()) {
        echo json_encode(['success' => true, 'message' => 'color guardado']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al guardar']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'color no proporcionado']);
}