<?php
    include_once('../php/conexion.php');
    include_once('../php/consultas.php');
    // include_once('llamadas.php');
    // echo "session= " . $_SESSION['userid'] ;
    if (isset($_SESSION['userid'])) {
        # code...
        // echo "<br> bienvenido " . $_SESSION['userid'];
        $vUsuario= $_SESSION['userid'];
        $row = consultarUsuario($link,$vUsuario);
    } else {
        # code...
        // echo "<br> no existe session";
        $_SESSION['mensajeTexto'] = "ERROR, acceso al sistema no registrado";
        $_SESSION['mensajeTipo'] = "is-danger";
        header("Location: ../ventanas/login.php");
    }
?>