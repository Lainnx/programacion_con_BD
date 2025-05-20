<?php

require_once "controlador/connection.php";

//Este es el token que recibimos con la respuesta del usuario
$token_url = $_GET["registro"];

//Hay que compararlo con el token que tenemos guardado en la base de datos

// 1.Definir la sentencia (query)
$select = "SELECT * FROM temporal WHERE token_registro = ?;";

// 2. Preparación
$select_pre = $conn->prepare($select);

// 3. Ejecución
$select_pre -> execute(array($token_url)); //para que sepa que usuario entra y muestre solo lo suyo

// 4. Obtención valores (SOLO en el caso del select)
$array_filas = $select_pre->fetchAll();

if(!$array_filas){  // si array_filas viene vacío es que el token no es el mismo que el de la BD, entonces paramos
    header("location:index.php");
}


//******************************************************************* */
// si las cosas han ido bien HACEMOS INSERT

// 1.Definir la sentencia preparada, ponemos ? y PDO sabe que espera 3 valores, para evitar inyecciones de codigo
$insert = "INSERT INTO usuarios(nombre_usuario, password_usuario, email, idioma) VALUES (:nombre,:pass,:email,:idioma);";

// 2. Preparación
$prep = $conn->prepare($insert);

// 3. Parametrizar los valores
$prep -> bindParam(":nombre",$array_filas["nombre_usuario"], PDO::PARAM_STR); // que queremos asignar, de donde sacará el valor (en vez de ?), que le mandamos al PDO (tipo dato)
$prep -> bindParam(":pass",$array_filas["password_usuario"], PDO::PARAM_STR);
$prep -> bindParam(":email",$array_filas["email"], PDO::PARAM_STR);
$prep -> bindParam(":idioma",$array_filas["idioma"], PDO::PARAM_STR);

// 4. Ejecución -  
$prep -> execute(); //ya no hay que indicarle nada



//********************************************************* */
//SI la insercion se ha completado borramos de la tabla temporal


require_once "controlador/connection.php";
// 1.Definir la sentencia preparada, ponemos ? y PDO sabe que espera 3 valores, para evitar inyecciones de codigo

// $id = $_GET['id'];           //ASÍ NO, MALA SEGURIDAD
// $delete = "DELETE FROM colores WHERE id_color=$id;";

$delete = "DELETE FROM temporal WHERE token_registro = ?;";    // ? para el numero de valores que esperamos

// 2. Preparación
$delete_pre = $conn->prepare($delete);

// 3. Ejecución -   en el execute indicamos que pasaremos un array e indicamos para que es cada interrogante [?,?,?]
$delete_pre -> execute([$token_url]);  // aqui le ponemos valor al ? (sino vulnerable a inyecciones de codigo), TIENE QUE IR DENTRO DE UN ARRAY [?]

$delete_pre = null; // para resetear, para que no se vayan acumulando
$conn = null;

//volver a casa
header("location:colores.php");