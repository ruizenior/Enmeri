<?php
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
function validarLoginMedicos($link, $user, $pass)
{
    echo("<br>consulta validarDatosMedicos");
    $query = "SELECT * FROM `medicos` WHERE `email` = '$user' AND `password` = '$pass' AND `estado_usuario` = 'A'";
    $resultado = mysqli_query($link, $query);
    
    if (mysqli_num_rows($resultado) == 1) {
        $row = $resultado->fetch_assoc();
        // eliminar contenido de sesion
        $_SESSION['mensajeTexto'] = "acceso concedido";
        $_SESSION['mensajeTipo'] = "is-success";
        // $_SESSION['mensajeTexto'] = null;
        // $_SESSION['mensajeTipo'] = null;
        
        $_SESSION['userid'] = $row['id_medico'];
        $_SESSION['userTipe'] = "medico";
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
function consultarUsuario($link, $id,$userTipe)
{
    if ($userTipe == "medico") {
        $query = "SELECT * FROM `medicos` WHERE `id_medico` = '$id' AND `estado_usuario` = 'A'";
        $resultado = mysqli_query($link, $query);
        
        if (mysqli_num_rows($resultado) == 1) {
            $row = $resultado->fetch_assoc();
            return $row;
        }else {
            $_SESSION['mensajeTexto'] = "Error consultando datos del usuario";
            $_SESSION['mensajeTipo'] = "is-danger";
            header("Location: ../ventanas/login.php");                
        }

    }elseif ($userTipe == "paciente") {
        $query = "SELECT * FROM `pacientes` WHERE `id_paciente` = '$id' AND `estado_usuario` = 'A'";
        $resultado = mysqli_query($link, $query);
        
        if (mysqli_num_rows($resultado) == 1) {
            $row = $resultado->fetch_assoc();
            return $row;
        } else {
            $_SESSION['mensajeTexto'] = "Error consultando datos del usuario";
            $_SESSION['mensajeTipo'] = "is-danger";
            echo("no hay udusrio");
            header("Location: ../ventanas/login.php");    
        }
        
    }else{
        $_SESSION['mensajeTexto'] = "Error consultando datos del usuario";
        $_SESSION['mensajeTipo'] = "is-danger";
        // echo("no hay usuario");
        header("Location: ../ventanas/login.php");
    }
}



function listChats($link,$id){
    if ($_SESSION['userTipe'] == "medico") {
        $query = "
        SELECT * 
        FROM chats AS C 
        WHERE
            C.id_medico = '$id' AND 
            EXISTS(
                SELECT 1 from pacientes AS P 
                WHERE P.id_paciente = C.id_paciente AND P.estado_usuario = 'A'
            )
        ";
        $resultado = mysqli_query($link, $query);
        return $resultado;

    }elseif ($_SESSION['userTipe'] == "paciente") {
        $query = "
        SELECT C.*, DM.id_mensaje 
        FROM 
            chats AS C 
            INNER JOIN mensajes AS DM ON C.id_chat = DM.id_chat
        GROUP BY
            DM.id_chat
        HAVING
            C.id_paciente = '$id' AND 
            EXISTS(
                SELECT 1 from medicos AS M 
                WHERE M.id_medico = C.id_medico AND M.estado_usuario = 'A'
            )
        ORDER BY
        DM.id_mensaje DESC
        ";
        $resultado = mysqli_query($link, $query);
        return $resultado;

        // if (mysqli_num_rows($resultado) == 1) {
        //     $row = $resultado->fetch_assoc();
        //     return $row;
        // } else {
        //     $_SESSION['mensajeTexto'] = "Error consultando datos del usuario";
        //     $_SESSION['mensajeTipo'] = "is-danger";
        //     echo("no hay udusrio");
        //     header("Location: ../ventanas/login.php");    
        // }
        
    }else{
        $_SESSION['mensajeTexto'] = "Error consultando datos del usuario";
        $_SESSION['mensajeTipo'] = "is-danger";
        // echo("no hay usuario");
        header("Location: ../ventanas/login.php");
    }
}   
function ultimoMensaje($link,$id){
    $query = "
    SELECT * 
    FROM
        mensajes AS M
    WHERE
        M.id_chat='$id'
    ORDER BY
        M.id_mensaje DESC
    LIMIT 1
    ";
    $resultado = mysqli_query($link, $query);
    $ultimosMensaje= $resultado->fetch_assoc();
    return $ultimosMensaje;
}
function consultarChat($link,$id){
    $query = "SELECT * FROM `chats` WHERE `id_chat` = '$id' AND `estado` = 'A'";
    $resultado = mysqli_query($link, $query);
    
    if (mysqli_num_rows($resultado) == 1) {
        $row = $resultado->fetch_assoc();
        return $row;
    } else {
        $_SESSION['mensajeTexto'] = "Inconvenientes para cargar el chat";
        $_SESSION['mensajeTipo'] = "is-danger";
        echo("no hay udusrio");
        header("Location: ../ventanas/login.php");    
    }
}