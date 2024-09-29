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
    //consulta para obtener todos los datos
    $query = $conn->prepare("SELECT hexa FROM colors");
    $query->execute();
    $colors = $query->fetchAll(PDO::FETCH_ASSOC);

    //verificar si hay resultados
    if ($colors) {
        //devolver los colores en formato json
        echo json_encode([
            'status' => 'success',
            'data' => $colors
        ]);
    } else {
        //si no se encontraron datos, devolver un mensaje de error
        echo json_encode([
            'status' => 'error',
            'message' => 'No se encontraron datos'
        ]);
    }
} catch (PDOException $e) {
    //manejo de errores en la base de datos
    echo json_encode([
        'status' => 'error',
        'message' => 'Error en la base de datos: ' . $e->getMessage()
    ]);
}

// if(!$conn) {
//     echo"no conectado";
//     exit();
// }

// // Obtenemos los parametros de la URL (ejemplo: ?web=web1)
// if (isset($_GET['web'])) {
//     $web = $_GET['web'];

//     // Mapeamos el parametro de la web a la tabla correspondiente 
//     $tableMap = [
//         'colors' => 'colors',
//         'gradient' => 'gradient',
//         'fonts' => 'fonts',
//     ];

//     //Verificar su la web solicitada existe en el mapa
//     if (array_key_exists($web, $tableMap)) {
//         $table = $tableMap[$web];

//         //Hacer la cunsulta a la tabla corespondiente
//         $query = $conn->prepare("SELECT * FROM $table");
//         $query->execute();
//         $result = $query->fetchAll(PDO::FETCH_ASSOC);

//         echo json_encode($result);
//     } else {
//         echo json_encode(['error' => 'web no encontrarda']);
//     }
// }
