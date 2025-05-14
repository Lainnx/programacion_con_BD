<?php

// echo "<pre>";
// print_r($_POST);
// echo "</pre>";  

require_once "connection.php";   

foreach($_POST as $clave => $valor){
    $_POST[$clave] = trim(htmlspecialchars($valor, ENT_QUOTES, "UTF-8"));

}
// $nombre = $_POST["nombre"];^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
// $nombre = htmlspecialchars($usuario, ENT_QUOTES, "UTF-8");  //  para evitar XSS, ENT_QUOTES para deshabilitar comillas, charset que estamos utilizando
// $password = htmlspecialchars($_POST['password']); // desactiva el efecto del script
// $password2 = htmlspecialchars($_POST['password2']);
// $email = htmlspecialchars($_POST['email']);
// $idioma = htmlspecialchars($_POST['idioma']);

// $usuario = trim($nombre);  // strip()
// $password = trim($password);
//****************************************************************** */

// //vigila si un bot intenta acceder
// if(!empty($_POST['nombre_que_no_se_corresponde_con_lo_que_hace'])){  // si la variable esta vacia todo ha ido bien, si esta llena no lo ha esrito un humano (display:hidden) no se ve
//     $_SESSION['error'] = true;  // para mandar mensaje de error al index
//     header('location:index.php');
//     exit;
// }
// //para impedir el acceso directo a insert.php por link
// if(!hash_equals($_SESSION['token'], $_POST['token'])){  // ! <- nos interesa cuando haya ido mal (que no sean iguales)
//     $_SESSION['error'] = true;  // para mandar mensaje de error al index
//     header('location:index.php');
//     exit;
// }

// if(empty($usuario) || empty($color)){   // no pueden estar vacíos
//     $_SESSION['error'] = true;  // para mandar mensaje de error al index
//     header('location:index.php');
//     exit;
// }

$hash = password_hash($_POST["password"], PASSWORD_DEFAULT);


//SENTENCIA PREPARADA (OTRO METODO, NO CON ?) SISTEMA PAINT

// 1.Definir la sentencia preparada, ponemos ? y PDO sabe que espera 3 valores, para evitar inyecciones de codigo
$insert = "INSERT INTO usuarios(nombre_usuario, password_usuario, email, idioma) VALUES (:nombre,:pass,:email,:idioma);";

// 2. Preparación
$prep = $conn->prepare($insert);

// 3. Parametrizar los valores
$prep -> bindParam(":nombre",$_POST["nombre"], PDO::PARAM_STR); // que queremos asignar, de donde sacará el valor (en vez de ?), que le mandamos al PDO (tipo dato)
$prep -> bindParam(":pass",$hash, PDO::PARAM_STR);
$prep -> bindParam(":email",$_POST["email"], PDO::PARAM_STR);
$prep -> bindParam(":idioma",$_POST["idioma"], PDO::PARAM_STR);

// 4. Ejecución -  
$prep -> execute(); //ya no hay que indicarle nada

$prep = null; // para resetear, para que no se vayan acumulando
$conn = null;

echo "Usuario creado correctamente";