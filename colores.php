<?php


error_reporting(0); // para anular los warnings, ahora cuando $_SESSION['error'] se muestra siempre un warning, MALA SOLUCION


// echo "Soy index.php";    // al usar php: index.php > index.html > otro

// include "connection.php";   // si no ecntuentra un fichero no daría un error critico, daria un warning y seguiría sin romper el programa(si pudiera)
// require "connection.php";   // si da error rompe el programa

// include_once "connection.php";  // vigila si se ha llamado al fichero antes y no lo vuelve a llamar, si ya hay una conexion establecida y otro fichero requere esa conexion
                                // el once haría que no se conectara más de una vez 

//SESIONES EN PHP
session_start(); // implica la creacion de $_SESSION (array asociativo vacío), donde se encuentre un session_start puedes pasar datos de un fichero a otro
$_SESSION['token'] = bin2hex(random_bytes(64)); // el token existe solo aqui de momento, lo vamos a enviar con el formulario, cuando lo recibamos en el otro fichero nos
                                                // vamos a asegurar que lo que recibimos es el mismo valor que este, miraremos si los valores coinciden

// echo $_SESSION["id_usuario"] ."<br>";

// Llamar a la conexión una vez
require_once "controlador/connection.php";  // <--

$array_fondo_claro = [  // colores que vamos a querer con letras negras, (por defecto letrasblanco abajo $color)
    "white","yellow","pink","darksalmon","orange","aqua"
];

// 1.Definir la sentencia (query)
$select = "SELECT * FROM colores WHERE id_usuario = ?;";

// 2. Preparación
$select_pre = $conn->prepare($select);

// 3. Ejecución
$select_pre -> execute(array($_SESSION["id_usuario"])); //para que sepa que usuario entra y muestre solo lo suyo

// 4. Obtención valores (SOLO en el caso del select)
$array_filas = $select_pre->fetchAll(); //  cuando se quiera obtener un conjunto de datos (mas de una fila) -> fetchAll
                                        //  tengo un array para todo y un arary associativo para cada fila, 
                                        //  fetch devuelve solo un array asociativo, para una sola fila

// foreach($array_filas as $fila){
//     echo "<pre>";
//     print_r($fila);
//     echo "</pre>";
// }

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <?php include_once "modulos/meta.php"; ?>
    <title>Colores</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include_once "modulos/header.php" ?>
    <main>
        <section>
            <h2>Nuestros amigos</h2>
            <?php foreach($array_filas as $fila): ?>    <!--Este codigo se va a repetir tantas veces como elementos haya en la array -->
            <?php $color = "white";
                if(in_array($fila['color_en'], $array_fondo_claro)){   //in_array(cosa que estamos buscando, array dónde la estamos buscando); devuelve true si lo encuentra
                $color="black";
                }
            ?>
                <div style="background-color: <?= $fila['color_en'] ?> ;color:<?= $color ?>">
                    <p> <?= htmlspecialchars($fila["usuario"], ENT_QUOTES, "UTF-8" )?> </p>    <!-- = <-> php echo -->
                    <span class="icons">
                        <a href="colores.php?id=<?=$fila["id_color"]?>&usuario=<?=$fila["usuario"]?>&color=<?=$fila["color_es"]?>" title="Modificar valor">  <!-- esto crea un evento GET-->
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <a href="delete.php?id=<?=$fila["id_color"]?>">
                            <i class="fa-solid fa-trash-can" title="Eliminar elemento"></i> <!-- title para que al pasar el cursos por encima dé info -->
                        </a>
                        
                    </span>
                </div>

            <?php endforeach ?>

        </section>
        <section >
            <?php if(($_GET)) : // si existe es que se ha producido el click y el evento get?>  
            <h2>Modifica tus datos</h2>
            <form action="update.php" method="post" class="formColores">

                <input type="hidden" name="id_color" value="<?=$_GET['id']?>">   <!--input invisible para obtener id_color y poder modificar en la tabla
                                                                                    id pq nombre link id=<?=$fila["id_color"]?> -->
                <input type="hidden" name="token" value=<?= $_SESSION['token'] ?>>
                <input type="text" name="nombre_que_no_se_corresponde_con_lo_que_hace" style="display:none">

                <fieldset>
                    <div>
                        <label for="usuario">Nombre del usuario:</label>
                        <input type="text" id="usuario" name="usuario" value="<?= $_GET['usuario'] ?>" maxlength="50"> <!-- Para que cuando le demos al boton ponga el nombre de usuario auto -->
                        
                    </div>
                    <div>
                        <label for="color">Nombre del color:</label>
                        <input type="text" id="color" name="color" value="<?= $_GET['color'] ?>" maxlength="25">   <!--Estos nombres son los del link -->
                    </div>
                    <div>
                        <button type="submit">Enviar datos</button>
                        <button type="reset">Borrar formulario</button>
                    </div>
                </fieldset>
            </form>

            <?php else : ?> 
            <h2>Inserta tus datos</h2>
            <!-- linea comentada para que los datos no vayan directamente a insert.php -->
            <!-- <form action="insert.php" method="post"> -->
            <form name="formInsert" class="formColores">

                <input type="hidden" name="id_usuario" value=<?= $_SESSION['id_usuario'] ?>>

                <input type="hidden" name="token" value=<?= $_SESSION['token'] ?>>
                <input type="text" name="nombre_que_no_se_corresponde_con_lo_que_hace" style="display:none">    <!--para honeypot de bots -->

                <fieldset>
                    <div>
                        <label for="usuario">Nombre del usuario:</label>
                        <input type="text" id="usuario" name="usuario" maxlength="50">
                        <p id="errorUsuario" ></p>
                    </div>
                    <div>
                        <label for="color">Nombre del color:</label>
                        <input type="text" id="color" name="color" maxlength="25">
                        <p id="errorColor" ></p>
                    </div>
                    <div>
                        <button type="submit">Enviar datos</button>
                        <button type="reset">Limpiar formulario</button>
                    </div>
                </fieldset>
            </form>
            <?php endif ?>


            <?php if($_SESSION['error']): ?>    <!-- si existe es que se ha mandado un error de vuelta-->
                <p>Se ha producido un error</p>
            <?php endif ?>

        </section>
    </main>

    <script src="js/colores.js"></script>
</body>
</html>
<?php 
$_SESSION['error']=false;
