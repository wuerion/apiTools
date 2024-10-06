<?php
//perimitir el acceso desde cualquier origen
header('Access-Control-Allow-Origin: http://localhost:4321');
// header("Access-Control-Allow-Methods: POST");
header('Content-Type: application/json');
// Permitir los métodos que se van a utilizar, como GET o POST
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
// Permitir encabezados adicionales si es necesario
header("Access-Control-Allow-Headers: Content-Type");

header('Content-Type: application/json');

include 'db_connection.php';

// obtenemos el cuerpo de las solicitud en formato json
$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['val1']) && isset($input['val2'])) {
    $val1 = $input['val1'];
    $val2 = $input['val2'];

    // para depurar, mostrar los valores recibidos
    error_log("Name recibido: " . $val1);
    error_log("Url recibido: " . $val2);

    try {
        $query = $conn->prepare("INSERT INTO fonts (fontname, fonturl) VALUES (:val1, :val2)");
        $query->bindParam(":val1", $val1);
        $query->bindParam(":val2", $val2);

        // ejecutar consulta
        if ($query->execute()) {
            echo json_encode(['success' => true, 'massege' => 'font guardado']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al guardar']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'error en la base de datos: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'massege' => 'font no proporcionado']);
}