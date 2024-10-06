<?php
// Permitir acceso desde http://localhost:4321
header("Access-Control-Allow-Origin: http://localhost:4321");
// Permitir los métodos que se van a utilizar, como GET o POST
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
// Permitir encabezados adicionales si es necesario
header("Access-Control-Allow-Headers: Content-Type");

header('Content-Type: application/json');

include 'db_connection.php';

//conectar a la db
$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['val1']) && isset($input['val2'])) {
    $val1 = $input['val1'];
    $val2 = $input['val2'];

    // para depurar, mostrar los valores recibidos
    error_log("fontname recibido: " . $val1);
    error_log("fonturl recibido: " . $val2);

    try {
        $query = $conn->prepare("DELETE FROM fonts WHERE fontname = :val1 AND fonturl = :val2");

        $query->bindParam(":val1", $val1);
        $query->bindParam(":val2", $val2);

        // ejecutar la consulta
        if ($query->execute()) {
            //respuesta exitosa
            echo json_encode(['success' => true, 'message' => 'font eliminado']);
        } else {
            //si ocurre algun error en la ejecucuion 
            echo json_encode(['success' => false, 'message' => 'Error al eliminar']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'error en la base de datos: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'font no proporcionado']);
}