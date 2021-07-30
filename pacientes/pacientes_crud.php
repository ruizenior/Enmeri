<?php
try {
    //code...
    include_once('../php/conexion.php');
    include_once('../php/consultas.php');
    if (!empty($_GET['accion'])) {
        $opcion = $_GET['accion'];
    }else{
        // session_start();
        $_SESSION['mensajeTexto'] = "Advertencia: accion no permitida";
        $_SESSION['mensajeTipo'] = "is-warning";
        header("Location: ../index.php");
    }
    // CRUD -INS - DLT - UDT
    // $tipoUsuario = $_SESSION['userTipe'];
    echo("entro al archivo");
    switch ($opcion) {
        case 'INS':
            echo("entro a insertar");
            if (isset($_POST['crear'])){
                $nombre = filter_var($_POST['nombres'], FILTER_SANITIZE_STRING);
                $apellido = filter_var($_POST['apellidos'], FILTER_SANITIZE_STRING);
                $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
                $nombre = filter_var($_POST['nombres_usuario'], FILTER_SANITIZE_STRING);
                $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
                
                if (usuarioDisponible($link,$email,$tipoUsuario)){
                    echo("fallo");
                    $query = "
                    INSERT INTO `pacientes`(`id_paciente`,`nombres`, `apeliidos`, `email`, `nombre_usuario`, `password`, `estado_conexion`, estado_usuario, `fecha_registro`) VALUES ('','$nombres', '$apellidos', '$email', '$password', 'D', 'A','')
                    ";
                    $resultado = mysqli_query($link,$query);
                    
                    if (!$resultado) {
                        $_SESSION['mensajeTexto'] = "Error creado el usuario";
                        $_SESSION['mensajeTipo'] = "is-danger";
                        die("Error en base de datos: ". mysqli_error($link));
                        // header("Location: ./createUser.php");
                        echo("Fallo");
                    } else {
                        $_SESSION['mensajeTexto'] = "Usuario creando con exito";
                        $_SESSION['mensajeTipo'] = "is-success";
                        echo("exito");
                        // header("Location: ../index.php");
                    }
                }else {
                    $_SESSION['mensajeTexto'] = "Error, este correo ya esta en uso";
                    $_SESSION['mensajeTipo'] = "is-danger";
                    // header("Location: ./createUser.php");
                    echo("fallo");
                }
            }else {
                $_SESSION['mensajeTexto'] = "ERROR, creando usuario";
                $_SESSION['mensajeTipo'] = "is-danger";
                // header("Location: ./createUser.php");
            }
            break;

        case 'DLT':
            $tipoUsuario = $_SESSION['userTipe'];
            $id = $_SESSION['userid'];
            $usrioId = "id_".$tipoUsuario;
            $query = " UPDATE  `$tipoUsuario` SET `estado` = 'I' WHERE `$usrioId` = '$id'";
            $resultado = mysqli_query($link, $query);
            if (!$resultado) {
                $_SESSION['mensajeTexto'] = "Error borrando el registro";
                $_SESSION['mensajeTipo'] = "is-danger";
                die("Error en base de datos: ". mysqli_error($link));
                header("Location: ./usuarios-Mant.php");
            } else {
                $_SESSION['mensajeTexto'] = "Usuario borrado con exito <br>Si desea restaurar su cuenta contacte con el servicio de mantenimiento";
                $_SESSION['mensajeTipo'] = "is-success";
                $_SESSION['userid'] = null;
                $_SESSION['userTipe'] = null;
                header("Location: ../index.php");
                }
            // cerrar conexion
            mysqli_close($link);
            break;

            // case 'UDT':
            //     $tipoUsuario = $_SESSION['userTipe'];
            //     $id = $_SESSION['userid'];
            //     $nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING);
            //     $apellido = filter_var($_POST['apellido'], FILTER_SANITIZE_STRING);
            //     $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
            //     $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

            //     $DBid = "id_".$tipoUsuario;
            //     $DBnombre = "nombre_".$tipoUsuario;
            //     $DBapellido = "apellido_".$tipoUsuario;
                
            //     $query = " UPDATE  `$tipoUsuario` SET `$DBnombre` = '$nombre', `$DBapellido` = '$apellido', `email` = '$email', `password` = '$password' WHERE `$DBid` = '$id'";
    
            //     $resultado = mysqli_query($link, $query);
    
            //     if (!$resultado) {
            //         $_SESSION['mensajeTexto'] = "Error editando el usuario";
            //         $_SESSION['mensajeTipo'] = "is-danger";
            //         // header("Location: ../usuario/usuarios-Mant.php");
            //         die("Error en base de datos: ". mysqli_error($link));
            //     } else {
            //         $_SESSION['mensajeTexto'] = "Usuario editado con exito ";
            //         $_SESSION['mensajeTipo'] = "is-success";
            //         header("Location: ../usuario/usuarios-Mant.php");
            //     }
            //     // cerrar conexion
            //     mysqli_close($link);
            //     break;
        default:
            $_SESSION['mensajeTexto'] = "Advertencia: accion no encontrada" . "opcion = " . $opcion;
            $_SESSION['mensajeTipo'] = "is-warning";
            // header("Location: ../index.php");
            break;
    }

} catch (Exception $e) {
    echo "Exception no controlada 01: " . $e->getMessage();
    echo "Estamos trabajando en corregir esta situacion";
} catch (Error $e) {
    echo "Error no controlada 01: " . $e->getMessage();
    echo "Estamos trabajando en corregir esta situacion";
}

?>