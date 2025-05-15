<?php


//SESIONES EN PHP
session_start(); // implica la creacion de $_SESSION (array asociativo vacío), donde se encuentre un session_start puedes pasar datos de un fichero a otro
$_SESSION['token'] = bin2hex(random_bytes(64)); // el token existe solo aqui de momento, lo vamos a enviar con el formulario, cuando lo recibamos en el otro fichero nos
                                                // vamos a asegurar que lo que recibimos es el mismo valor que este, miraremos si los valores coinciden



// Llamar a la conexión una vez
require_once "controlador/connection.php";  // <-- controlador carpeta con ficheros con logica


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <?php include_once "modulos/meta.php"; ?>
    <title>Colores</title>
    
</head>
<body>
    <?php include_once "modulos/header.php" ?>
    <main class="main-index">
        <section>
            <img src="img/colores.jpg" alt="Espiral de colores">
        </section>
        <section>
        <?php
            $formulario = $_GET["formulario"] ?? "login";   // ?? = ||, si no hay get el formulario sera el de login

            switch($formulario){
                case "login":
                    include_once "formularios/form_login.php";
                    break;
                case "crear_cuenta":
                    include_once "formularios/form_crear_usuario.php";
                    break;
                case "reset":
                    include_once "formularios/form_reset_password.php";
                    break;
            }
        ?>
        </section>
    </main>

    <script src="js/index.js"></script>
</body>
</html>
<?php 

