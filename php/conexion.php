<?php 
include_once("configuracion.php");

// crear sesiones
@session_start();


// creando el objeto de conexion de base de datos
$link = new mysqli(host, user, password, database);

if (mysqli_connect_errno()) {
    echo("hubo error de conexion a DB" . mysqli_connect_errno() . " - " . mysqli_connect_error());
    $_SESSION['mensajeTexto'] = "El sistema está en mantenimiento, initente más tarde";
    $_SESSION['mensajeTipo'] = "is-info";
} else {
    mysqli_set_charset($link, 'utf8');
    // echo("Conexion a base de datos exitosa");
    // $_SESSION['mensajeTexto'] = "Base de datos conectada";
    // $_SESSION['mensajeTipo'] = "is-success";
}

?>