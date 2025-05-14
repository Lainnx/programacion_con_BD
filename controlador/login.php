<?php

require_once "connection.php";

$verificarNombre = isset($_POST["nombre"]) && $_POST["nombre"];
$verificarPassword = isset($_POST["password"]) && $_POST["password"];

if(!$verificarNombre || !$verificarPassword){
    echo "Error en los valores";
    die();
}

// Quitar los espacios
$nombre = trim($_POST["nombre"]);
$password = trim($_POST["password"]);

//comprobar que no estén vacíos
if(empty($nombre) || empty($password)){
    echo "Error en los valores";
    die();
}

$nombre = htmlspecialchars($nombre, ENT_QUOTES, "UTF-8");
$password = htmlspecialchars($password, ENT_QUOTES, "UTF-8");

//Comprobar si existe el usuario
$select = "SELECT * FROM usuarios WHERE nombre_usuario = :nombre";
$prep = $conn->prepare($select);
$prep->bindParam(":nombre", $nombre, PDO::PARAM_STR);
$prep->execute();

$usuarioExistente = $prep->fetch(PDO::FETCH_ASSOC); // que prep nos devuelva el valor, le pedimos a fetch que devuelva un array associativo

if(!$usuarioExistente){
    echo "UsuarioInexistente";
    die();
}

// si llegamos aqui es que el usuario existe, ahora falta verificar la pass

if (!password_verify($password, $usuarioExistente["password_usuario"])){    //deveuelve un bool, si es falso e sque no coinciden
    echo "PasswordIncorrecto";
    die();
}

echo "Usuario identificado";

