<?php
// PDO
// Datos de acceso a la base de datos
$host = "localhost";
$host = "127.0.0.1";
$database = "colores";
$port = 3307;
$user = "root";
$password = "root";


try{
    $conn = new PDO ("mysql:host=$host;port=$port;dbname=$database;",$user, $password);
    echo "Conectados!!";

} catch (PDOException $e){
    echo $e->getMessage();  // el mensaje que se mostrara si no se puede conectar 
}