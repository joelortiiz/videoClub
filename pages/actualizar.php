<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["titulo"] != "" && $_POST["genero"] != "" && $_POST["pais"] != "" && $_POST["anio"] != "" && $_POST["cartel"] != "") {


        $tituloA = $_POST["titulo"];
        $generoA = $_POST["genero"];
        $paisA = $_POST["pais"];
        $anioA = $_POST["anio"];
        $cartelA = $_POST["cartel"];
        $idA = $_POST["id"];
        try {
            include '../functions/functions.php';

            $bdA = conexion();
            actualizarPeli($bdA, $tituloA, $generoA, $paisA, $anioA, $cartelA, $idA);
        } catch (Exception $ex) {
            
        }
    } else {
        header("Location: ./inicio.php?errorActualizar");
    }
}