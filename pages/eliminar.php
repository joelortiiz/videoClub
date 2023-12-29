<?php

//Si no se ha creado una sesión, redirigimos.
if (!$_SESSION["nombre"]) {
    header("Location: ../index.php");
}

try {
    //incluimos archivo funciones
    include '../functions/functions.php';
    //intentamos conexion con base de datos para guardarla en una variable. En caso de no ser correcta redirigimos.
    $bdD = conexion();
    //Id de la pelicula a eliminar
    $idD;
    if(isset($_GET["id"])) {
        $idD=$_GET["id"];
    }
    eliminarPeli($idD, $bdD);
    
} catch (Exception $ex) {
    
}