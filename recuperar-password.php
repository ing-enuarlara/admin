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
  <title>AdminLTE 3 | Solicitar nueva contraseña</title>

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
    <?php include("includes/carga.php"); ?>
<div class="login-box">
  <div class="login-logo">
    <a href="index.php"><b>Admin</b>OB</a>
  </div>
  <?php
    if (!empty($_GET['RC']) || !empty($_GET['error'])) {
      if (!empty($_GET['RC'])) {
        switch ($_GET['RC']) {
            case 1:
              $msjRC = 'El correo o usuario ingresado no existe en nuestro sistema.';
            break;


            default:
              $msjRC = 'No hay mensaje';
            break;
        }
      }

      if (!empty($_GET['error'])) {
        switch ($_GET['error']) {
            case 'ER_6':
              $msjRC = $_GET['msj'];
            break;


            default:
              $msjRC = 'No hay mensaje';
            break;
        }
      }
  ?>
    <p style="color:black; font-size: 16px; background-color: gold; padding: 5px;"><?=$msjRC; ?></p>
  <?php } ?>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">¿Ha olvidado su contraseña? Aquí puede recuperar fácilmente una nueva contraseña.</p>

      <form action="recuperar-password-script.php" method="post">
        <div class="input-group mb-3">
          <input type="usuario" class="form-control" placeholder="Email, Usuarios o Nº Documento" name="usuario">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Solicitar nueva contraseña</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <p class="mt-3 mb-1">
        <a href="index.php">Iniciar Sesión</a>
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
