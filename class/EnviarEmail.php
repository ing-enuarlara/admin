<?php
require_once($_SERVER['DOCUMENT_ROOT']."/sensitive.php");

require RUTA_PROYECTO.'/libs/correos/vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EnviarEmail {

    /**
     * Este función envía un correo electrónico
     * 
     * @param array $data
     * @param string $asunto
     * @param string $bodyTemplateRoute
     * 
     * @return void
     */
    public static function enviar($data, $asunto, $bodyTemplateRoute): void
    {
        global $mail;

        $mail = new PHPMailer(true);

        try {
            
            if(!is_null($bodyTemplateRoute)){
                ob_start();
                include($bodyTemplateRoute);
                $body = ob_get_clean();
            }
            

            //Server settings
            $mail->SMTPDebug = 0;                                       // Enable verbose debug output
            $mail->isSMTP();                                            // Set mailer to use SMTP
            $mail->Host       = EMAIL_SERVER;  	                        // Specify main and backup SMTP servers
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = EMAIL_USER;                             // SMTP username
            $mail->Password   = EMAIL_PASSWORD;                         // SMTP password
            $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
            $mail->Port       = EMAIL_PORT;                             // TCP port to connect to 465 or 587

            //Remitente
            $mail->setFrom(EMAIL_USER, NAME_SENDER);
            
            $destinatario=$data['usuario_email'];
            $destinatario2=empty($data['usuario2_email'])?null:$data['usuario2_email'];

            if (filter_var($destinatario, FILTER_VALIDATE_EMAIL)) {
                $validarDestinatario = self::validarEmail($destinatario);
            } else {
                $validarDestinatario = false;
            }

            if (filter_var($destinatario2, FILTER_VALIDATE_EMAIL)) {
                $validarDestinatario2 = is_null($destinatario2)?true:self::validarEmail($destinatario2);
            } else {
                $validarDestinatario2 = false;
            }

            if($validarDestinatario){
                $mail->addAddress($destinatario, "");
            }else{
                if(!$validarDestinatario){
                    self::enviarReporte($data,$mail,EMAIL_USER,$destinatario,$asunto,$body,ESTADO_EMAIL_ERROR,'Error destinatario'.$destinatario); 
                    self::mensajeError($destinatario);
                }
            }

            if(!is_null($destinatario2)){
                if($validarDestinatario2){
                    $mail->addAddress($destinatario2, $data['usuario2_nombre']);
                }else{
                    if(!$validarDestinatario2){
                        self::enviarReporte($data,$mail,EMAIL_USER,$destinatario2,$asunto,$body,ESTADO_EMAIL_ERROR,'Error destinatario 2'.$destinatario2); 
                        self::mensajeError($destinatario2);
                    }
                }
            }

            // Content
            $mail->isHTML(true);                                   // Set email format to HTML
            $mail->Subject = $asunto;
            $mail->Body = $body;
            $mail->CharSet = 'UTF-8';

            $mail->send();
            self::enviarReporte($data,$mail,EMAIL_USER,$destinatario,$asunto,$body,ESTADO_EMAIL_ENVIADO,''); 
            if(!is_null($destinatario2)){
                self::enviarReporte($data,$mail,EMAIL_USER,$destinatario2,$asunto,$body,ESTADO_EMAIL_ENVIADO,''); 
            }

        } catch (Exception $e) {

            self::enviarReporte($data,$mail,EMAIL_USER,$destinatario,$asunto,$body,ESTADO_EMAIL_ERROR,$e->getMessage());
            echo "Error: {$mail->ErrorInfo}";
        }

    }

    public static function validarEmail($email) 
    {
        $matches = null;
        // Expresion regular
        $regex = "/^[A-z0-9\\._-]+@[A-z0-9][A-z0-9-]*(\\.[A-z0-9_-]+)*\\.([A-z]{2,6})$/";
       return (1 === preg_match($regex, $email, $matches));      
    }

    private static function mensajeError($email) 
    {
        $msj=' El correo '.$email.' no cumple con la estructura de un correo valido';
        $url=$_SERVER["HTTP_REFERER"];
        $pos = strpos($url, "?");
        $simbolConcatenar=$pos===false?"?":"&";
        $url=$url.$simbolConcatenar.'error=ER_6&msj='.$msj;
        echo '<script type="text/javascript">window.location.href="'.$url.'";</script>';
        exit();      
    }

    private static function enviarReporte($data,$mail,$remitente,$destinatario,$asunto,$body,$estado,$descripcion){
        // global $conexionBdAdmin;
        
        // $adjunto=$mail->attachmentExists();

        // try{
        //     mysqli_query($conexionBdAdmin, "INSERT INTO historial_correos_enviados(
        //             hisco_fecha,
        //             hisco_remitente,
        //             hisco_destinatario,
        //             hisco_asunto,
        //             hisco_contenido,
        //             hisco_adjunto,
        //             hisco_archivo_salida,
        //             hisco_estado,
        //             hisco_descripcion_error,
        //             hisco_id_empresa
        //             )VALUES(
        //             now(),
        //             '".$remitente."',
        //             '".$destinatario."',
        //             '".$asunto."',
        //             '".$body."',
        //             '".$adjunto."',
        //             '".$_SERVER["HTTP_REFERER"]."',
        //             '".$estado."',
        //             '".$descripcion."',
        //             '".$data['id_empresa']."')
        //         ");
        // } catch (Exception $e) {
        //     include(ROOT_PATH."/includes/error-catch-to-report.php");
        // }
    }

}