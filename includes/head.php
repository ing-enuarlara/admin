<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminOCB 1.0 | <?=$paginaActual['pag_nombre'] ?? "Sistema de gestion"; ?></title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="<?=REDIRECT_ROUTE?>files/logo/favicon3.ico">
    <script src="https://kit.fontawesome.com/e84fa1cf78.js" crossorigin="anonymous"></script>
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
    <link rel="stylesheet" href="<?= REDIRECT_ROUTE ?>plugins/font-awesome/css/font-awesome.min.css">