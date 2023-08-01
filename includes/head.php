<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminZEFE 1.0 | <?=$paginaActual['pag_nombre']?></title>
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