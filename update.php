<?php

require_once "connection.php";

$update = "UPDATE colores SET ;";    // ? para el numero de valores que esperamos

// 2. Preparación
$update_pre = $conn->prepare($update);

// 3. Ejecución -   en el execute indicamos que pasaremos un array e indicamos para que es cada interrogante [?,?,?]
$update_pre -> execute([$_GET['id'],$_GET['usuario'],$_GET['color']]);  // aqui le ponemos valor al ? (sino vulnerable a inyecciones de codigo), TIENE QUE IR DENTRO DE UN ARRAY [?]

$update_pre = null; // para resetear, para que no se vayan acumulando
$conn = null;

//volver a casa
header("location:index.php");