<?php

session_start();

require_once "connection.php";
require_once "traduccion_colores.php"; //para tener la traduccion de los colores y poder darle valor a $color_en


$usuario = $_POST["usuario"];
$usuario = htmlspecialchars($usuario, ENT_QUOTES, "UTF-8");  //  para evitar XSS, ENT_QUOTES para deshabilitar comillas, charset que estamos utilizando
$color = htmlspecialchars($_POST['color']);

if(!empty($_POST['nombre_que_no_se_corresponde_con_lo_que_hace'])){  // si la variable esta vacia todo ha ido bien, si esta llena no lo ha esrito un humano (display:hidden) no se ve
    $_SESSION['error'] = true;  // para mandar mensaje de error al index
    header('location:index.php');
    exit;
}

if(!hash_equals($_SESSION['token'], $_POST['token'])){  // ! <- nos interesa cuando haya ido mal (que no sean iguales)
    $_SESSION['error'] = true;  // para mandar mensaje de error al index
    header('location:index.php');
    exit;
}


print_r($_POST); // para ver que llega con el POST
$usuario = $_POST['usuario'];
$color_es = strtolower($_POST['color']);    // cuando se envia el color tiene este nombre
$color_en = $array_colores_es_en[$color_es] ?? $color_es; // array asociativo, si le pasamos color_es (atributo), nos dara color_en (valor)
                // mira si tienes el color en traduccion, si no lo tienes pon directamente el color del formulario
$id_color = $_POST['id_color'];

$update = "UPDATE colores SET usuario = ?, color_es = ?, color_en = ? WHERE id_color = ? ;";    // ? 

// 2. Preparación
$update_pre = $conn->prepare($update);

// 3. Ejecución -   en el execute indicamos que pasaremos un array e indicamos para que es cada interrogante [?,?,?]
$update_pre -> execute([$usuario, $color_es, $color_en, $id_color]);  // aqui le ponemos valor als ? (sino vulnerable a inyecciones de codigo), TIENE QUE IR DENTRO DE UN ARRAY [?]

$update_pre = null; // para resetear, para que no se vayan acumulando
$conn = null;

//volver a casa
header("location:index.php");