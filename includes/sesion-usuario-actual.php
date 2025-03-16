<?php
    //USUARIO ACTUAL
    try{
        $consultaUsuarioActual = $conexionBdAdministrativo->query("SELECT * FROM administrativo_usuarios INNER JOIN administrativo_roles ON utipo_id=usr_tipo WHERE usr_id='".$_SESSION["id"]."'");
    } catch (Exception $e) {
        include(RUTA_PROYECTO."includes/error-catch-to-report.php");
    }
	$numUsuarioActual = $consultaUsuarioActual->num_rows;

	if($numUsuarioActual == 0){
		$rutaSalida= REDIRECT_ROUTE."salir.php";
?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="refresh" content="2;url=<?= $rutaSalida ?>">
        <title>Redireccionando...</title>
        <style>
            html, body {
                height: 100%;
                margin: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                background-color: #FAFAFA;
                /* font-family: Arial, sans-serif; */
            }

            .mensaje {
                text-align: center;
            }
        </style>
    </head>
    <body>
        <div class="mensaje">
            <img src="<?=REDIRECT_ROUTE?>files/logo/logo.png" alt="AdminOCBLogo" width="100">
            <p><span style='font-family:Arial; color:red; font-weight:bold;'>El usuario con ID <b><?=$_SESSION["id"]?></b> no existe..</samp></p>
            <p>Redireccionando en 2 segundos...</p>
        </div>
        <script>
            setTimeout(function() {
                window.location.href = '<?= $rutaSalida ?>';
            }, 2000);
        </script>
    </body>
    </html>
<?php	
        exit();	
	}

	$datosUsuarioActual = mysqli_fetch_array($consultaUsuarioActual, MYSQLI_BOTH);

	//SABER SI ESTA BLOQUEADO
	if($datosUsuarioActual['usr_bloqueado']==1)
	{
		$rutaSalida= REDIRECT_ROUTE."salir.php";
?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="refresh" content="2;url=<?= $rutaSalida ?>">
        <title>Redireccionando...</title>
        <style>
            html, body {
                height: 100%;
                margin: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                background-color: #FAFAFA;
                /* font-family: Arial, sans-serif; */
            }

            .mensaje {
                text-align: center;
            }
        </style>
    </head>
    <body>
        <div class="mensaje">
            <img src="<?=REDIRECT_ROUTE?>files/logo/logo.png" alt="AdminOCBLogo" width="100">
            <p><span style='font-family:Arial; color:red; font-weight:bold;'>Su usuario ha sido bloqueado. Por tanto no tiene permisos para acceder al Sistema.</samp></p>
            <p>Redireccionando en 2 segundos...</p>
        </div>
        <script>
            setTimeout(function() {
                window.location.href = '<?= $rutaSalida ?>';
            }, 2000);
        </script>
    </body>
    </html>
<?php	
        exit();	
    }