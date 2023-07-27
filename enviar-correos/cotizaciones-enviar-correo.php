<?php
include("../modules/sesion.php");

$idPagina = 82;
include(RUTA_PROYECTO."includes/verificar-paginas.php");

require RUTA_PROYECTO.'dist/librerias/correos/vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$consulta= $conexionBdComercial->query("SELECT * FROM comercial_cotizaciones INNER JOIN comercial_clientes ON cli_id=cotiz_cliente INNER JOIN ".BDMODADMINISTRATIVO.".administrativo_usuarios ON usr_id=cotiz_vendedor WHERE cotiz_id='" . $_POST["id"] . "'");
$resultado = mysqli_fetch_array($consulta, MYSQLI_BOTH);

ob_start();
include("template-enviar-cotizaciones.php");
$fin = ob_get_clean();


// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = 0;                                     // Enable verbose debug output
    $mail->isSMTP();                                          // Set mailer to use SMTP
    $mail->Host       = 'smtp.gmail.com';                     // Specify main and backup SMTP servers
    $mail->SMTPAuth   = true;                                 // Enable SMTP authentication
    $mail->Username   = 'enuar2110@gmail.com';                // SMTP username
    $mail->Password   = 'uhmvdszjseiqsvdp';                   // SMTP password
    $mail->SMTPSecure = 'ssl';                                // Enable TLS encryption, `ssl` also accepted
    $mail->Port       = 465;                                  // TCP port to connect to or 587

    //Recipients
    $mail->setFrom($configuracion['conf_email'], $configuracion['conf_empresa']);
    $mail->addAddress($resultado['cli_email'], $resultado['cli_nombre']);     // Add a recipient
    $mail->addAddress($resultado['usr_email'], $resultado['usr_nombre']);     // Add a recipient


    // Content
    $mail->isHTML(true);                                      // Set email format to HTML
    $mail->Subject = $_POST['asunto'];
    $mail->Body = $fin;
    $mail->CharSet = 'UTF-8';

    $mail->send();
} catch (Exception $e) {
    echo "Error: {$mail->ErrorInfo}";
}

include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

echo '<script type="text/javascript">window.location.href="' . $_SERVER['HTTP_REFERER'] . '";</script>';
exit();