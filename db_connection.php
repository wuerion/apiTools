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

    //mostrar mesaje de conexion existosa
    echo "conectado:";

    //consulta de prueba
    $query = $conn->query("SHOW TABLES");
    $tablas = $query->fetchAll(PDO::FETCH_ASSOC);

    //mostrar las tablas encronteadds
    echo "tablas encotrardas";
    foreach ($tablas as $table) {
        echo implode(", ", $tablas) . "<br>";
    }

} catch(PDOException $e) {
    //si hay un error en la conexion, mostar el mensaje del error
    echo "Error en la conexion: " . $e->getMessage();
}