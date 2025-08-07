<?php
    require_once($_SERVER['DOCUMENT_ROOT']."/admin/constantes.php");
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
        <img src="<?=REDIRECT_ROUTE?>files/logo/logo2.png" alt="AdminOCBLogo" width="100">
        <p><span style='font-family:Arial; font-weight:bold;'>No tienes permiso para entrar aqui.</samp></p>
        <p>Redireccionando en 2 segundos...</p>
    </div>
    <script>
        setTimeout(function() {
            window.location.href = '<?= $rutaSalida ?>';
        }, 2000);
    </script>
</body>
</html>