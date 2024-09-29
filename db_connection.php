<?php 
$host = "localhost";
$db = "mytools";
$user = "root";
$pass = "";

try {
    //creamos una nueva conexion usando PDO
    $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);

    //confuguracion del modo de errores de PDO a exepcion
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //consulta de prueba para verificar la conexion y obtenr tablas
    $query = $conn->query("SHOW TABLES");
    $table = $query->fetchAll(PDO::FETCH_ASSOC);

    //mostrar mesaje de conexion existosa
    $response = [
        "estatus" => "success",
        "message" => "Conexion exitisa y tablas encontradas",
        "tables" => $table
    ];
} catch(PDOException $e) {
    //si hay un error en la conexion, mostar el mensaje del error
    $response = [
        "status" => "error",
        "message" => "Error al conexion: " . $e->getMessage()
    ];

    echo json_encode($response);
    exit();
}