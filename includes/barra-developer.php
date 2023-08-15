<?php if( $datosUsuarioActual[3]==1 || isset($_SESSION['admin']) ){

  try{
    $TipoUsr = $conexionBdAdministrativo->query("SELECT * FROM administrativo_roles WHERE utipo_id='".$datosUsuarioActual[3]."'");
  } catch (Exception $e) {
      include(RUTA_PROYECTO."includes/error-catch-to-report.php");
  }
  $nombreUSR = mysqli_fetch_array($TipoUsr, MYSQLI_BOTH);

  $archivo = explode("/", $_SERVER['PHP_SELF']);
  $nombre_fichero = $archivo[6];

  $lines = file(REDIRECT_ROUTE.'.git/HEAD');
  foreach ($lines as $line_num => $line) {
  }
  $ramaActual = substr($line, 16);
?>

	<div style="
        position:relative;
        background-color: #003832; 
        color:#42FF00; 
        height: 50px; 
        width: 100%; 
        margin-bottom: 20px; 
        padding: 7px;
        display:flex; 
        justify-content: center; 
        align-items: center;
        font-family:Arial;
        font-size:16px;
    ">
    <b>Rama Actual GIT:</b>&nbsp;<?=$ramaActual;?>&nbsp;|&nbsp;
    <b>Id Pagina:</b>&nbsp;<?=$idPagina;?>&nbsp;|&nbsp;
    <b>Usuario Actual:</b>&nbsp;<?=$datosUsuarioActual[0];?>&nbsp;|&nbsp;
    <b>T. Usuario:</b>&nbsp;<?=$nombreUSR['utipo_nombre'];?>&nbsp;|&nbsp;
		<b>V PHP:&nbsp;</b> <?=phpversion(); ?>&nbsp;|&nbsp; 
		<b>IP:&nbsp;</b> <?=$_SERVER['REMOTE_ADDR'];?>&nbsp;|&nbsp; 
		<!-- <b>Server:&nbsp;</b> <?=$_SERVER['SERVER_NAME']; ?>&nbsp;|&nbsp; -->
		<b>Host:&nbsp;</b> <?=$_SERVER['HTTP_HOST']." (".http_response_code().")"; ?>&nbsp;|&nbsp;
    <b>Peso Página:&nbsp;</b> <?=number_format(filesize($nombre_fichero)) . ' bytes'; ?>&nbsp;|&nbsp;
    <b>ENV:&nbsp;</b> <?=ENVIROMENT;?>&nbsp;|&nbsp;

    <?php if( isset($_SESSION['admin']) ){?>
			<b>User Admin:&nbsp;</b> <?=$_SESSION['admin']; ?>&nbsp;|&nbsp;
			<a href="<?=REDIRECT_ROUTE?>includes/return-admin-panel.php" style="color:white; text-decoration:underline;">RETORNAR</a>
		<?php }?>

	</div>

<?php }?>