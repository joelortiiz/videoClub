<?php
//session_start();

//Si no se ha creado una sesión con el nombre de usuario, redirigimos.
if (!$_SESSION["nombre"]) {
    header("Location: ../index.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include_once '../lib/functions/functions.php';
    
    if($_POST["titulo"] !="" && $_POST["genero"] !="" && $_POST["pais"] !="" && $_POST["anio"] !="" && $_POST["cartel"]) {
    $titulo = $_POST["titulo"];
    $genero = $_POST["genero"];
    $pais = $_POST["pais"];
    $anio = $_POST["anio"];
    $cartel = $_POST["cartel"];
    
    try {
       $bd = conexion();
       $sql_id = "SELECT MAX(id) FROM peliculas;";
       $idBD = $bd->query($sql_id);
       $id;
        foreach ($idBD as $value) {
            $id = $value;
        }
       // Creamos la consulta SQL para añadir la película
       // Con los datos recibidos por formulario.
        $sql_aniadirPeli = "INSERT INTO peliculas (id, titulo, genero, pais, anyo, cartel) VALUES "
                . "('" .$id ."','" .$titulo ."', '" .$genero ."', '" .$pais ."', '" .$anio ."', '" .$cartel ."');";
        $BDAniadir = $bd->prepare($sql_aniadirPeli);
        $BDAniadir->execute(); 
        session_start();
        header("Location: ./inicio.php");

    } catch (Exception $e) {
        
    } 
    } else {
        header("Location: ./inicio.php?errorAniadir");
    }
   
}
