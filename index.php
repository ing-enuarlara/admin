<?php
include("conexion.php");
$consultaConfiguracion = $conexionBdGeneral->query("SELECT * FROM configuracion WHERE conf_id=1");
$configuracion = mysqli_fetch_array($consultaConfiguracion, MYSQLI_BOTH);
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Log in</title>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <a href="index.php"><b>Admin</b>LTE</a>
    </div>
    <?php
    if (isset($_GET['error'])) {
      switch ($_GET['error']) {
        case 1:
          $msjError = 'El usuario no existe.';
          break;

        case 2:
          $msjError = 'La clave no es correcta';
          break;

        case 3:
          $msjError = 'Los intentos fallidos de acceso superan el límite';
          break;

        case 4:
          $msjError = 'Su usuario se encuentra bloqueado';
          break;


        default:
          $msjError = 'No hay mensaje';
          break;
      }
    }

    $idSeguimiento = '';
    if (isset($_GET["idseg"]) and is_numeric($_GET["idseg"])) {
      $idSeguimiento = $_GET["idseg"];
    }

    if (isset($_GET['error'])) { ?>
      <p style="color:black; font-size: 16px; background-color: gold; padding: 5px;"><?php echo $msjError; ?></p>
    <?php } ?>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Ingresa tu usuario y contraseña</p>

        <form action="autentico.php" method="post">
          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Usuario" name="Usuario">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Contraseña" name="Clave">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
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