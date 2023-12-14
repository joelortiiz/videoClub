<?php
include "../lib/model/pelicula.php";
include "../lib/model/actor.php";

session_start();

$cadena_conexion = 'mysql:dbname=videoclub;host=127.0.0.1';
$usuario = 'joel'; // Sustiteable por root
$clave = 'joel'; // Si se utiliza root dejar la clave vacía

try {
    // Aquí creamos conexión con la base de datos
    // Con el usuario joel
    $bd = new PDO($cadena_conexion, $usuario, $clave);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $cliente = $_POST["cliente"];
        $password = md5(htmlspecialchars($_POST["password"]));

        $sql_usu = "SELECT * FROM usuarios WHERE username = '" . $cliente . "' AND password = '" . $password . "'";
        $result = $bd->query($sql_usu);
        // Si la consulta devuelve más de 0 filas cumple la condición.
        if ($result->rowCount() > 0) {
            foreach ($result as $row => $value) {
                // echo $value["username"];
                $_SESSION["username"] = $value["username"];
            }
            $_SESSION["username"] = ucfirst($_SESSION["username"]);
            //Consulta para seleccionar todos los datos de TODAS las películas
            $sql_pelis = "SELECT * FROM peliculas";
            $pelis = $bd->query($sql_pelis);
            $pelisArr = [];
            foreach ($pelis as $peli => $value) {
                // Pelicula($id, $titulo, $genero, $pais, $anyo, $cartel);
                $pelicula = new Pelicula($value["id"], $value["titulo"], $value["genero"], $value["pais"], $value["anyo"], $value["cartel"]);
                array_push($pelisArr, $pelicula);
                //Prueba de funcionamiento:
                //  echo $pelicula->getTitulo();
            }
        } else {
            header("Location: ../index.php?error");
        }
    } else {
        header("Location: ../index.php?error");
    }
    ?>
    <!doctype html>
    <html lang="es">
        <head>
            <meta charset="UTF-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1.0" />
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
            <link rel="stylesheet" href="../css/inicio.css" />
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css">
            <title>VideoClub JoelOrtiz</title>
        </head>
        <body class="body p-4">
            <!-- Start Header -->
            <header class="d-flex flex-column justify-content-center align-items-center">
                <!-- Pendiente añadir cookie de ultima sesion -->
                <h1 class="text-light m-3 text-center">
                    Bienvenido al videoclub,
                    <?php echo $_SESSION["username"]; ?> 
                </h1>
                <div>
               <a href="../index.php?endsession" class="enlace">Cerrar Sesión</a>
                </div>
             </header>
            <!-- End Header -->
            <main class="main p-2">
                <h2>
                    Películas disponibles
                </h2>
                <section class="d-flex flex-column border justify-content-center align-items-center col-md-12">
                    <?php 
                            foreach ($pelisArr as $peli) {
                        ?>
                    <div class="d-flex border flex-column justify-content-center align-items-center col-md-10 border">
                        
                        <div>
                            <p class="titulos fs-3">
                                <?php 
                                   echo $peli->getTitulo();
                                ?>
                            </p>
                        </div>
                        <div class="p-2">
                            <img class="cartel" src="../assets/images/<?php echo $peli->getCartel() ?>" alt="alt"/>
                        </div>
                        <div>
                            
                        </div>
                         </div>
                        <?php
                            }
                        ?>
                   
                </section>
            </main>
        </body>
    </html>

    <?php
    //  Cerramos conexión
    $bd = null;
    echo 'funciona';
} catch (Exception $e) {
    echo "Error en la base de datos: " . $e->getMessage();
}
?>