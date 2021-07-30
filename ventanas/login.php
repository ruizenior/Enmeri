<?php

// incluir archivos
include_once("../php/conexion.php");
include_once("../php/consultas.php");

// VALIDAR EL LOGIN 
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $vUsuario = trim(htmlspecialchars($_POST['usuario']));
    $vClave = trim(htmlspecialchars($_POST['password']));
    $vTipoUsuario = trim(htmlspecialchars($_POST['tipoUsuario']));
    
    // $_SESSION['mensajeTexto']= "nombre_usuario " . $vUsuario . " password " . $vClave;
    // $_SESSION['mensajeTipo']= "is-info";
    echo("Se solicitan datos de " . $vUsuario . "  " . $vClave . " " );
    
    if($vTipoUsuario == 'P'){
        echo("<br> el usuario es de tipo paciente");
        validarLoginPacientes($link,$vUsuario,$vClave);
    }
    else if($vTipoUsuario == 'M'){
        validarLoginMedicos($link,$vUsuario,$vClave);
    }
    else{
        echo('intento de violacion al sistema');
    }
}
?> 

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
            
    <!-- Link hacia el archivo de estilos css -->
    <link rel="stylesheet" href="../mycss/login.css">
    <link rel="stylesheet" href="../package/bootstrap-5.0.1-dist/css/bootstrap.min.css">

    <link rel="icon" type="image/png" href="../img/ENMERI-icon.png">
    <title>Login ENMERI</title>
</head>
<body>
    <div id="contenedor">
        <div id="central">
            <div id="tabs">
                <div id="tab1" class="tab t1">
                    <h6>Paciente</h6>
                </div>
                <div id="tab2" class="tab t2">
                    <h6>Médico</h6>
                </div>
            </div>
            <div id="login" class="">
                <div class="titulo">
                    <img class="img" src="../img/ENMERI-logologin.svg" alt="ENMERI" >
                    <h2>Login Pacientes</h2>
                </div>

                <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="POST" enctype="multipart/form-data" class="login-form" >
                    <input type="text" name="usuario" placeholder="Usuario" required>
                    <input type="password" placeholder="Contraseña" name="password" required>
                    <input type="hidden" name="tipoUsuario" value="P">

                    <button type="submit" title="Ingresar" name="Ingresar">Login</button>
                </form>

                <div class="pie-form">
                    <a href="./contraseña.html">¿Perdiste tu contraseña?</a>
                    <p>¿No tienes Cuenta?  <a href="./registro.html"> Registrate</a></p>
                </div>
            </div>

            <div id="login2" class="active">
                <div class="titulo">
                    <img class="img" src="../img/ENMERI-logologin.svg" alt="ENMERI" >
                    <h2>Login Médicos</h2>
                </div>

                <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="POST" enctype="multipart/form-data" class="login-form">
                    <input type="text" name="usuario" placeholder="Usuario" required>
                    <input type="password" placeholder="Contraseña" name="password" required>
                    <input type="hidden" name="tipoUsuario" value="M">
                    
                    <button type="submit" title="Ingresar" name="Ingresar">Login</button>
                </form>

                <div class="pie-form">
                    <a href="./contraseña.html">¿Perdiste tu contraseña?</a>
                    <p>¿No tienes Cuenta?  <a href="./registro.html"> Registrate</a></p>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery CDN - Slim version (=without AJAX) --> 
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>


    <script>
        $(document).ready(function () {
            $('#tab1').on('click', function (){
                $('#tab1').addClass('active');
                $('#tab2').removeClass('active');
                
                $('#login').removeClass('active');
                $('#login2').addClass('active');

            });
            $('#tab2').on('click', function () {
                $('#tab2').addClass('active');
                $('#tab1').removeClass('active');
                
                $('#login2').removeClass('active');
                $('#login').addClass('active');
            });
            
        });
    </script>
</body>
</html>