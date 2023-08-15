<?php 
    include("../modules/sesion.php");

    try {
        mysqli_query($conexionBdMicuenta, "UPDATE micuenta_mensajes SET men_destacado='".$_POST["destacado"]."' WHERE men_id ='".$_POST["idMensaje"]."'");
    } catch (Exception $e) {
        include(RUTA_PROYECTO . "includes/error-catch-to-report.php");
    }
    exit;