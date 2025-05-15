<?php

session_start();

session_unset();    //vacía el $_SESSION
session_destroy(); // prblema no destruye sesion de inmediato, para que cuando hagamos click se borre la session hacemos el unset(antes de recargar) luego se borra la sesion(despues de recargar)


header("location:../index.php");
// print_r($_SESSION);