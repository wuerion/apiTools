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

//obtenemos el cuerpo de la solucitud en formato json
$input = json_decode(file_get_contents('php://input'), true);

if(isset($input['color'])) {
    $color = $input['color'];

    //para depurar, muestra el valor de $color recibido
    error_log("color recibido: " . $color);
    try{
        //consulta para imprimir el color en la db
        $query = $conn->prepare("INSERT INTO colors (hexa) VALUES (:color)");
        $query->bindParam(':color', $color);
        
        //ejecutar la consulta
        if($query->execute()) {
            //respuesta exitosa
            echo json_encode(['success' => true, 'message' => 'color guardado']);
        } else {
            //si ocurre algun error en la ejecucuion 
            echo json_encode(['success' => false, 'message' => 'Error al guardar']);
        }
    } catch (PDOException $e){
        echo json_encode(['success' => false, 'message' => 'error en la base de datos: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'color no proporcionado']);
}