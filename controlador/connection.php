<?php
// PDO
// Datos de acceso a la base de datos
$host = "localhost";
$host = "127.0.0.1";
$database = "colores";
$port = 3307;
$user = "colores";
$password = "colores";


try{
    $conn = new PDO ("mysql:host=$host;port=$port;dbname=$database;",$user, $password);
    // echo "Conectados!!";

    // foreach($conn -> query("SELECT * FROM usuarios") as $fila){
    //     echo "<pre>";
    //     print_r($fila);   // para mostrar un array, tambien con vardump
    //     echo "</pre>";
    // }


} catch (PDOException $e){
    echo $e->getMessage();  // el mensaje que se mostrara si no se puede conectar 
}