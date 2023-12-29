<?php
session_start();
//Destruimos las sesiones

$_SESSION = array();
session_destroy();

//Redirigimos al inicio con las sesiones cerradas
header('Location: ../index.php');