<?php
// Permitir acceso desde http://localhost:4321
header("Access-Control-Allow-Origin: http://localhost:4321");
// Permitir los métodos que se van a utilizar, como GET o POST
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
// Permitir encabezados adicionales si es necesario
header("Access-Control-Allow-Headers: Content-Type");

header('Content-Type: application/json');

//conectar a la db
include 'db_connection.php';

try {
    $query = $conn->prepare("SELECT * FROM fonts");
    $query->execute();
    $fonts = $query->fetchAll(PDO::FETCH_ASSOC);

    // verificar si hay resultados
    if ($fonts) {
        // devolver si hay resultados
        echo json_encode([
            'status' => 'success',
            'data' => $fonts
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'No se encotraron datos'
        ]);
    }
} catch (PDOException $e) {
    // manejo de errores de la db
    echo json_encode([
        'estatus' => 'error',
        'message' => 'Error en la base de datos: ' . $e->getMessage()
    ]);
}

if(!$conn) {
    echo "no conectado";
    exit();
}