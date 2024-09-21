<?php
include 'db_connection.php';

if(!$conn) {
    echo"no conectado";
    exit();
}

// Obtenemos los parametros de la URL (ejemplo: ?web=web1)
if (isset($_GET['web'])) {
    $web = $_GET['web'];

    // Mapeamos el parametro de la web a la tabla correspondiente 
    $tableMap = [
        'colors' => 'colors',
        'gradient' => 'gradient',
        'fonts' => 'fonts',
    ];
    
    //Verificar su la web solicitada existe en el mapa
    if (array_key_exists($web, $tableMap)) {
        $table = $tableMap[$web];
    
        //Hacer la cunsulta a la tabla corespondiente
        $query = $conn->prepare("SELECT * FROM $table");
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
    
        echo json_encode($result);
    } else {
        echo json_encode(['error' => 'web no encontrarda']);
    }
}

?>
