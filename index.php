<?php
include("conexion.php");
session_start();
if (isset($_SESSION["id"])) {
    header("Location: modules/");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminZEFE 1.0 | Login</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="<?=REDIRECT_ROUTE?>files/logo/favicon.ico">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <script src="https://kit.fontawesome.com/e84fa1cf78.js" crossorigin="anonymous"></script>
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript">
        let docTitle = document.title;
        window.addEventListener("blur", ()=>{
          document.title="Regresa Pronto ;)";
        });
        window.addEventListener("focus", ()=>{
          document.title=docTitle;
        });
    </script>
</head>

<body class="hold-transition login-page">
    <?php include("includes/carga.php"); ?>
    <div class="login-box">
        <div class="login-logo">
            <a href="index.php"><b>Admin</b>ZEFE</a>
        </div>
        <?php
        if (isset($_GET['error'])) {
            switch ($_GET['error']) {
                case 1:
                    $msj = 'El usuario no existe.';
                    break;

                case 2:
                    $msj = 'La clave no es correcta';
                    break;

                case 3:
                    $msj = 'Los intentos fallidos de acceso superan el límite';
                    break;

                case 4:
                    $msj = 'Su usuario se encuentra bloqueado';
                    break;


                default:
                    $msj = 'No hay mensaje';
                    break;
            }
        }
        if (!empty($_GET['RC'])) {
            switch ($_GET['RC']) {
                case 1:
                    $msj = 'Hemos enviado un correo con los pasos para renovar su contraseña.';
                break;
            
                case 2:
                    $msj = 'La contraseña fue cambiada correctamente.';
                break;
    
    
                default:
                    $msj = 'No hay mensaje';
                break;
            }
        }

        $idSeguimiento = '';
        if (isset($_GET["idseg"]) and is_numeric($_GET["idseg"])) {
            $idSeguimiento = $_GET["idseg"];
        }

        if (isset($_GET['error']) || !empty($_GET['RC'])) { ?>
            <p style="color:black; font-size: 16px; background-color: gold; padding: 5px;"><?php echo $msj; ?></p>
        <?php } ?>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Ingresa tu usuario/email y contraseña</p>

                <form action="autentico.php" method="post">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Usuario o Email" name="Usuario">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <script>
                        function cambiarTipoInput() {
                            var campo = document.getElementById("passwordInput");
                            var icoVer = document.getElementById("icoVer");

                            if (campo.type === "password") {
                                campo.type = "text";
                                icoVer.classList.remove("fa-eye");
                                icoVer.classList.add("fa-eye-slash");
                            } else {
                                campo.type = "password";
                                icoVer.classList.remove("fa-eye-slash");
                                icoVer.classList.add("fa-eye");
                            }
                        }
                    </script>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" id="passwordInput" placeholder="Contraseña" name="Clave">
                        <div class="input-group-append">
                            <div class="input-group-text" onclick="cambiarTipoInput()">
                                <i class="fas fa-eye" id="icoVer"></i>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                    Recordarme
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Entrar</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <p class="mb-1">
                    <a href="recuperar-password.php">Recuperar mi contraseña</a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
</body>

</html>