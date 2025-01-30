<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Recuperar contraseña</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <script src="https://kit.fontawesome.com/e84fa1cf78.js" crossorigin="anonymous"></script>
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="index.php"><b>Admin</b>OB</a>
  </div>
  <?php
    if (!empty($_GET['error'])) {
      switch ($_GET['error']) {
          case 1:
            $msj = 'La clave no cumple con todos los requerimientos:<br>
            - Debe tener entre 8 y 20 caracteres.<br>
            - Solo se admiten caracteres de la a-z, A-Z, números(0-9) y los siguientes simbolos(. y $).';
          break;
          
          case 2:
            $msj = 'Las Contraseñas Nuevas No Coinciden.';
          break;


          default:
            $msj = 'No hay mensaje';
          break;
      }
  ?>
    <p style="color:black; font-size: 16px; background-color: gold; padding: 5px;"><?=$msj; ?></p>
  <?php } ?>
  <span id="respuestaClaveNueva" style="display:none; font-size: 16px; padding: 5px;"></span>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sólo estás a un paso de tu nueva contraseña, recupérala ahora.</p>

      <form action="confirmar-password-script.php" method="post">
        <input type="hidden" name="idUsuario" value="<?=base64_decode($_GET["idU"]);?>">
        <input type="hidden" name="idEmpresa" value="<?=base64_decode($_GET["idE"]);?>">
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Nueva Contraseña" id="claveNueva" name="claveNueva" oninput="validarClaveNueva(this)">
          <div class="input-group-append" onclick="cambiarTipoInput('claveNueva','icoVer')">
            <div class="input-group-text">
              <i class="fa-solid fa-eye" id="icoVer"></i>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Confirmar Contraseña" id="confirmarClaveNueva" name="confirmarClaveNueva" oninput="claveNuevaConfirmar(this)">
          <div class="input-group-append" onclick="cambiarTipoInput('confirmarClaveNueva','icoVer2')">
            <div class="input-group-text">
              <i class="fa-solid fa-eye" id="icoVer2"></i>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Cambiar Contraseña</button>
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
<?php
  $mensajeClaveNueva = 'La clave no cumple con todos los requerimientos:<br>- Debe tener entre 8 y 20 caracteres.<br>- Solo se admiten caracteres de la a-z, A-Z, números(0-9) y los siguientes simbolos(. y $).';
?>
<script>
  function cambiarTipoInput(id,icoVer) {
    var campo = document.getElementById(id);
    var icoVer = document.getElementById(icoVer);

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

  function validarClaveNueva(enviada) {
    var clave = enviada.value;
    var regex = /^[A-Za-z0-9.$*]{8,20}$/;

    if (regex.test(clave)) {
      document.getElementById("respuestaClaveNueva").style.color = 'green';
      document.getElementById("respuestaClaveNueva").style.display = 'block';
      $("#respuestaClaveNueva").html('Contraseña Valida');
    } else {
      document.getElementById("respuestaClaveNueva").style.color = 'red';
      document.getElementById("respuestaClaveNueva").style.display = 'block';
      $("#respuestaClaveNueva").html('<?= $mensajeClaveNueva ?>');
    }
  }

  function claveNuevaConfirmar(enviada) {
    var valueConfirmar = enviada.value;
    var claveNueva = document.getElementById("claveNueva");

    if (valueConfirmar==claveNueva.value) {
      document.getElementById("respuestaClaveNueva").style.color = 'green';
      document.getElementById("respuestaClaveNueva").style.display = 'block';
      $("#respuestaClaveNueva").html('Las Contraseñas Coinciden');
    } else {
      document.getElementById("respuestaClaveNueva").style.color = 'red';
      document.getElementById("respuestaClaveNueva").style.display = 'block';
      $("#respuestaClaveNueva").html('Las Contraseñas No Coinciden');
    }
  }
</script>
</body>
</html>
