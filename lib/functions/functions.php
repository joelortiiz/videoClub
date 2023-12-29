<?php

function conexion() {
    try {
        $cadena_conexion = 'mysql:dbname=videoclub;host=127.0.0.1';
        $usuario = 'joel'; // Sustituible por root
        $clave = 'joel'; // Si se utiliza root dejar la clave vacía
        // Se crea la conexión con la base de datos
        $bd = new PDO($cadena_conexion, $usuario, $clave);
        return $bd;
    } catch (Exception $e) {
        echo "Error en la Base de datos: " . $e->getMessage();
    }
}

function consultaInicial($bd, $cliente, $password) {
    $_SESSION["password"] = $password;
    //Ciframos con metodología md5 la contraseña recibida
    $password = md5(htmlspecialchars($password));

    $sql_usu = "SELECT * FROM usuarios WHERE username = '" . $cliente . "' AND password = '" . $password . "'";
    $usuarioBD = $bd->query($sql_usu);
    // Si la consulta devuelve más de 0 filas cumple la condición.
    if ($usuarioBD->rowCount() > 0) {
        // Si no existe la cookie, una vez hemos iniciado sesión guardamos la hora de conexión
        if (!isset($_COOKIE["conexion"])) {
            $fecha_actual = date("d/m H:i");
            setcookie("conexion", $fecha_actual, time() + 3600 * 24, "/");
        }
        foreach ($usuarioBD as $row => $value) {

            // Prueba de funcionamiento de consulta:  echo $value["username"];
            $_SESSION["username"] = $value["username"];
            // $_SESSION["username"] = ucfirst($_SESSION["username"]);



            $_SESSION["rol"] = $value["rol"];
            // echo $_SESSION["rol"];
        }
    } else {
        header("Location: ../index.php?error");
    }
}

function esAdmin($bd, $cliente, $password) {
    $admin;
    $password = md5(htmlspecialchars($password));
    $sql_usu = "SELECT rol FROM usuarios WHERE username = '" . $cliente . "' AND password = '" . $password . "'";
    $usuarioBD = $bd->query($sql_usu);

    //Si el usuario tiene rol de administrador cambiamos el valor de la variable a TRUE.
    foreach ($usuarioBD as $row => $value) {
        if ($value["rol"] == 1) {
            return $admin = true;
        } elseif ($value["rol"] == 0) {
            return $admin = false;
        }
    }
}

function cargaPelis($bd) {

    //Consulta para seleccionar todos los datos de TODAS las películas
    $sql_pelis = "SELECT * FROM peliculas";
    $pelis = $bd->query($sql_pelis);
    $pelisArr = [];
    // $actoresArrAlm = [];

    foreach ($pelis as $peli => $value) {
        // Pelicula($id, $titulo, $genero, $pais, $anyo, $cartel);
        $pelicula = new Pelicula($value["id"], $value["titulo"], $value["genero"], $value["pais"], $value["anyo"], $value["cartel"]);
        array_push($pelisArr, $pelicula);
        //Prueba de funcionamiento:
        //  echo $pelicula->getTitulo();
    }
    return $pelisArr;
}

function cargaActor($bd, $actoresArrAlm, $id) {

    $sql_actores = "SELECT * FROM actores WHERE id IN (SELECT idActor FROM actuan WHERE actuan.idPelicula = " . $id . ");";
    $actores = $bd->query($sql_actores);
    $actoresArr = [];
    foreach ($actores as $key => $value) {
        // print_r($value["id"] ." ");
        // Pelicula($id, $titulo, $genero, $pais, $anyo, $cartel);
        $value = new Actor($value["id"], $value["nombre"], $value["apellidos"], $value["fotografia"]);
        array_push($actoresArr, $value);
        array_push($actoresArrAlm, $value);

        //Prueba de funcionamiento:
    }

    echo '<div class="d-flex justify-content-around d-flex flex-wrap">';
    foreach ($actoresArr as $actor) {
        echo "<div class='text-light'>"
        . "<div class='text-center'>" . $actor->getNombre() . " " . $actor->getApellidos() . "</div>"
        . "<div class=''> <img width='200' height='250' class='m-2 rounded' alt='ACTOR/ACTRIZ' src='../assets/images/" . $actor->getFotografia() . "'></div>" .
        "</div>";
    }
    echo '</div>';
}

function actualizarPeli($bd, $tituloA, $generoA, $paisA, $anioA, $cartelA, $idA) {
    //Sentencia SQL para actualizar datos de la BBDD
    $sql_actualizar = "UPDATE peliculas SET titulo = '$tituloA', genero = '$generoA', pais = '$paisA', anyo = '$anioA', cartel = '$cartelA' WHERE id = '$idA'";
    $BDActualizar = $bd->prepare($sql_actualizar);
    $BDActualizar->execute();
    header("Location: ../pages/inicio.php?success");
}
function  eliminarPeli($idD, $bd) {
        //Sentencia SQL para eliminar datos específicos de la BBDD

    $sql_eliminar = "DELETE FROM peliculas WHERE id = '$idD'";
    $BDDelete = $bd->prepare($sql_eliminar);
    $BDDelete->execute();
    header("Location: ../pages/inicio.php?successDel");
}