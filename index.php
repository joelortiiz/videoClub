<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Iniciar Sesión</title>
        <link rel="stylesheet" href="./css/style.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
        
    </head>
    <body>
        <header>
            <h1 class="header">Bienvenido a VideoClub Joel</h1>
        </header>
        <div class="container">
            <div class="login-container">
                <h2 class="login-title">Iniciar Sesión</h2>
                <?php
                //para ver los errores de inicio de sesión
                if (isset($_GET['error'])) {
                    echo '<p class="text-danger"> Datos incorrectos </p>';
                } elseif(isset($_GET['errorsesion'])) {
                    echo '<p class="text-danger"> Debes iniciar sesión para acceder.</p>';
                }
                if(isset($_GET["logout"])) {
                    session_destroy();
                }
                ?>  
                <form class="login-form" method="POST" action="./pages/inicio.php">
                    <div class="mb-3">
                        <label for="username" class="form-label">Usuario:</label>
                        <input type="text" class="form-control" id="username" name="cliente" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary btn-login">Login</button>
                    </div>
                </form>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
