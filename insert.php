<?php

require_once "connection.php";   // por defecto los datos de un fichero no pasan a otro, hay que llamar a la conexión otra vez

// $_POST   cuando se envia un formulario por method="post" se crea esta super variable global, aqui estan los datos, solo afecta a las paginas directamente enlazadas
// $_GET    method="get" así se ven los datos en la url


// echo "<pre>";
// print_r($_POST);
// echo "</pre>";

require_once "traduccion_colores.php"; // para pasar la traduccion al execute()

$usuario = $_POST["usuario"];

//para convertir el color en mins i que no isgui case sensitive
$color_es =strtolower( $_POST["color"]);

//traducir el color a ingles
$encontrado = false;
//                                      || cuando queremos obtener tanto la clave comom el valor
foreach ($array_colores_es_en as $clave=>$valor){
    if($clave == $color_es){
        $encontrado = true;
        break;
    }
}
if(!$encontrado){
    $color_es = "blanco";   // si el color no esta en la lista que sea blanco
}


// 1.Definir la sentencia preparada, ponemos ? y PDO sabe que espera 3 valores, para evitar inyecciones de codigo
$insert = "INSERT INTO colores(usuario, color_es, color_en) VALUES (?,?,?);";

// 2. Preparación
$insert_pre = $conn->prepare($insert);

// 3. Ejecución -   en el execute indicamos que pasaremos un array e indicamos para que es cada interrogante [?,?,?]
$insert_pre -> execute([$usuario, $color_es, $array_colores_es_en[$color_es]]); 

$insert_pre = null; // para resetear, para que no se vayan acumulando
$conn = null;

//volver a casa
header("location:index.php");   // para que vuelva a index.php despues de operar en insert.php