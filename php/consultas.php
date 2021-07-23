<?php
// //seteo la vida de la session en 7200 segundos    
// ini_set("session.cookie_lifetime","14400");
// //seteo el maximo tiempo de vida de la seession
// ini_set("session.gc_maxlifetime","14400");
@session_start(); 

function validarLoginPacientes($link, $user, $pass)
{
    echo("<br>consulta validarDatosPacientes");
    $query = "SELECT * FROM `pacientes` WHERE `email` = '$user' AND `password` = '$pass' AND `estado_usuario` = 'A'";
    $resultado = mysqli_query($link, $query);
    
    if (mysqli_num_rows($resultado) == 1) {
        $row = $resultado->fetch_assoc();
        // eliminar contenido de sesion
        $_SESSION['mensajeTexto'] = "acceso concedido";
        $_SESSION['mensajeTipo'] = "is-success";
        // $_SESSION['mensajeTexto'] = null;
        // $_SESSION['mensajeTipo'] = null;
        
        $_SESSION['userid'] = $row['id_paciente'];
        $_SESSION['userTipe'] = "paciente";
        $_SESSION['mensajeTexto'] = " userid: " . $_SESSION['userid'] . " tipo= " .$_SESSION['userTipe'];
        header("Location: ../ventanas/chats.php");
        echo("<br>Existe el usuario ". $_SESSION['userid'] ); 
    }
    else {
        echo("<br>No Existe el usuario");
        $_SESSION['mensajeTexto'] = "Error validando datos del usuario";
        $_SESSION['mensajeTipo'] = "danger";
    }
}
function consultarUsuario($link, $id)
{
    if ($_SESSION['userTipe'] == "Medico") {
        $query = "SELECT * FROM `profesor` WHERE `id_profesor` = '$id' AND `estado` = 'A'";
        $resultado = mysqli_query($link, $query);
        
        if (mysqli_num_rows($resultado) == 1) {
            $row = $resultado->fetch_assoc();
            return $row;
        }else {
            $_SESSION['mensajeTexto'] = "Error consultando datos del usuario";
            $_SESSION['mensajeTipo'] = "is-danger";
            header("Location: ../index.php");                
        }

    }elseif ($_SESSION['userTipe'] == "paciente") {
        $query = "SELECT * FROM `pacientes` WHERE `id_paciente` = '$id' AND `estado_usuario` = 'A'";
        $resultado = mysqli_query($link, $query);
        
        if (mysqli_num_rows($resultado) == 1) {
            $row = $resultado->fetch_assoc();
            return $row;
        } else {
            $_SESSION['mensajeTexto'] = "Error consultando datos del usuario";
            $_SESSION['mensajeTipo'] = "is-danger";
            echo("no hay udusrio");
            header("Location: ../index.php");    
        }
        
    }else{
        $_SESSION['mensajeTexto'] = "Error consultando datos del usuario";
        $_SESSION['mensajeTipo'] = "is-danger";
        // echo("no hay usuario");
        header("Location: ../index.php");
    }
}
