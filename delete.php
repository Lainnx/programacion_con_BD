<?php


require_once "controlador/connection.php";
// 1.Definir la sentencia preparada, ponemos ? y PDO sabe que espera 3 valores, para evitar inyecciones de codigo

// $id = $_GET['id'];           //ASÍ NO, MALA SEGURIDAD
// $delete = "DELETE FROM colores WHERE id_color=$id;";

$delete = "DELETE FROM colores WHERE id_color = ?;";    // ? para el numero de valores que esperamos

// 2. Preparación
$delete_pre = $conn->prepare($delete);

// 3. Ejecución -   en el execute indicamos que pasaremos un array e indicamos para que es cada interrogante [?,?,?]
$delete_pre -> execute([$_GET['id']]);  // aqui le ponemos valor al ? (sino vulnerable a inyecciones de codigo), TIENE QUE IR DENTRO DE UN ARRAY [?]

$delete_pre = null; // para resetear, para que no se vayan acumulando
$conn = null;

//volver a casa
header("location:colores.php");