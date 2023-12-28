<?php
include "../lib/model/pelicula.php";
include "../lib/model/actor.php";
include_once "../functions/functions.php";

try {
    // Aquí creamos conexión con la base de datos
    $bd = conexion();
    // Con el usuario joel
   
    $user;
    $password;
    
  // if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
        if($_POST["cliente"] != "" && $_POST["password"] != ""){
             $password = $_POST["password"] ;
             $user = $_POST["cliente"] ;
             consultaInicial($bd, $_POST["cliente"], $_POST["password"]);
              $admin = esAdmin($bd, $_POST["cliente"], $_POST["password"]);
            $pelisArr = cargaPelis($bd);
            //Variable auxiliar de actores.
            $actoresArrAlm = [];
        }
  // }  
   else {
       echo $user;
              echo $password;

       $_SESSION["username"] = $user;
       $_SESSION["password"] = $password;
       
           // if (isset($_SESSION["username"])){
               
          //  }
        }
   
    ?>
    <!doctype html>
    <html lang="es">
        <head>
            <meta charset="UTF-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1.0" />
                        <link rel="stylesheet" href="../css/inicio.css" />

            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css">
            <title>VideoClub JoelOrtiz</title>
        </head>
        <body class="body text-light">
            <!-- Start Header -->
            <header class="d-flex flex-column justify-content-center align-items-center">
                <!-- Pendiente añadir cookie de ultima sesion -->
                <h1 class="text-light m-3 text-center">
                    Bienvenido al videoclub,
                    <?php echo $_SESSION["username"]; ?> 
                </h1>
                <div>
                    <p class="bg-light p-2 text-primary rounded shadow-none">
                        <?php 
                        if(isset($_COOKIE["conexion"])) {
                           echo "Última Conexión: " .$_COOKIE["conexion"]; 
                           $fecha_actual = date("d/m H:i");
                           setcookie("conexion", $fecha_actual, time() + 3600 * 24, "/");

                        } else {
                            echo 'Ahora mismo.';
                        }
                        ?>
                    </p>
                    <a href="../index.php?endsession" class="enlace">Cerrar Sesión</a>
                </div>
            </header>
            <!-- End Header -->
            <main class="main m-4 p-4">

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
                            <div class="d-flex align-items-center ">
                                <div class="p-2 m-2">
                                    <img class="cartel" src="../assets/images/<?php echo $peli->getCartel() ?>" alt="alt"/>
                                </div>
                                <div>
                                    <table class="table text-light">

                                        <thead class="text-center">
                                            <tr>
                                                <th colspan="2"><?php echo $peli->getTitulo(); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    Género:
                                                </td>
                                                <td>
                                                    <?php echo $peli->getGenero(); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Año:
                                                </td>
                                                <td>
                                                    <?php echo $peli->getAnyo(); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    País:
                                                </td>
                                                <td>
                                                    <?php echo $peli->getPais(); ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                            <?php
                            if ($admin == true) {
                                ?>
                                <div class="mt-2 text-center"> 
                                    <a href="../functions/delete.php?" class="btn btn-danger">Eliminar</a>
                                </div>
                                </td>
                                <td>
                                    <div class="mt-2 text-center"> 
                                        <a href="../pages/update.php" class="btn text-light btn-warning">Actualizar</a>
                                    </div>
                                    <?php
                                }
                                ?>
                                <div class="text-light">
                                    <h2 class="text-center text-light mb-2">
                                        Reparto
                                    </h2>
                                    <?php
                                    $id = $peli->getId();
                                    cargaActor($bd, $actoresArrAlm, $id);
                                    ?>
                                </div>
                                <div>

                                </div>
                        </div>
                        <?php
                    }
                    ?>

                </section>
            </main>
            <footer>
                <?php
                if ($admin == false) {
                    ?>
                    <div class="d-flex bg-secondary col-md-12 p-4 justify-content-center flex-column align-items-center">
                        <h2>
                            <span class="text-primary"> <?php echo $_SESSION["username"]; ?> </span>  , ¿Necesitas ayuda?
                        </h2>
                        <p>
                            Contacta con nuestro equipo de soporte rellenando el siguiente formulario
                        </p>
                        
                        <form class="form" method="POST" action="./contacto.php">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="name" >
                            </div>
                            <div class="mb-3">
                                <label for="correo" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" id="correo" name="mail" >
                            </div>
                            <div class="mb-3">
                                <label for="telefono" class="form-label">Número de Teléfono</label>
                                <input type="tel" class="form-control" id="telefono" name="telefono" >
                            </div>
                            <div class="mb-3">
                             <label for="mensaje" class="form-label">Mensaje</label>
                             <textarea class="form-control" cols="50" name="text" rows="5" ></textarea>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="noRobot" name="noRobot" required>
                                <label class="form-check-label" for="noRobot">No soy un robot</label>
                            </div>
                            
                            <button type="submit" name="contact" class="btn btn-primary">Enviar</button>
                        </form>
                    </div>
                    <?php
                } elseif ($admin == true) {
                ?>
                 <div class="d-flex text-center bg-success col-md-12 p-4 justify-content-center flex-column align-items-center">
                     <h2 class="mb-4">
                            <span class="text-warning"> Añadir película </span>
                        </h2>
                     <?php if(isset($_GET["errorAniadir"])) echo '<p class="text-warning> Faltan datos por introducir !!"'; ?>
                     <form class="form" method="POST" action="./aniadir.php">
                            <div class="mb-3">
                                <label class="form-label">Título</label>
                                <input type="text" class="form-control" name="titulo" >
                            </div>
                            <div class="mb-3">
                                <label  class="form-label">Género</label>
                                <input type="text" class="form-control" name="genero" >
                            </div>
                            <div class="mb-3">
                                <label  class="form-label">País</label>
                                <input type="tel" class="form-control"  name="pais" >
                            </div>
                            <div class="mb-3">
                             <label class="form-label">Año</label>
                             <input type="number" class="form-control" name="anio" >
                            </div>
                             <div class="mb-3">
                             <label class="form-label">Cartel</label>
                             <input type="text" placeholder="imagen.jpg" value="" class="form-control" name="cartel" >
                            </div>
                            <button type="submit" name="aniadirpeli" class="btn btn-primary">Confirmar</button>
                        </form>
                    </div>
                
                <?php
            }
                ?>
            </footer>
        </body>
    </html>

    <?php
    //  Cerramos conexión
    $bd = null;
} catch (Exception $e) {
    echo "Base de datos en mantenimiento: " . $e->getMessage();
}
?>