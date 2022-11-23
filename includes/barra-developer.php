<?php if( $datosUsuarioActual[3]==1 || isset($_SESSION['admin']) ){

  
  $TipoUsr = $conexionBdAdministrativo->query("SELECT * FROM administrativo_roles WHERE utipo_id='".$datosUsuarioActual[3]."'");
  $nombreUSR = mysqli_fetch_array($TipoUsr, MYSQLI_BOTH);
  
  $paginas= $conexionBdSistema->query("SELECT * FROM sistema_paginas WHERE pag_id='".$idPagina."'");
  $rutaPagina = mysqli_fetch_array($paginas, MYSQLI_BOTH);
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
    <b>Id pagina:</b>&nbsp;<?php echo $idPagina;?>&nbsp;|&nbsp;
    <b>Ruta de pagina:</b>&nbsp;<?php echo $rutaPagina['pag_ruta'];?>&nbsp;|&nbsp;
    <b>Id usuario actual:</b>&nbsp;<?php echo $datosUsuarioActual[0];?>&nbsp;|&nbsp;
    <b>Tipo de Usuario:</b>&nbsp;<?php echo $nombreUSR['utipo_nombre'];?>&nbsp;|&nbsp;
		<b>Versión PHP:&nbsp;</b> <?=phpversion(); ?>&nbsp;|&nbsp; 
		<b>Server:&nbsp;</b> <?=$_SERVER['SERVER_NAME']; ?>&nbsp;|&nbsp;

    <?php if( isset($_SESSION['admin']) ){?>
			<b>User Admin:&nbsp;</b> <?=$_SESSION['admin']; ?>&nbsp;|&nbsp;
			<a href="<?=REDIRECT_ROUTE?>includes/return-admin-panel.php" style="color:white; text-decoration:underline;">RETORNAR</a>
		<?php }?>

	</div>

<?php }?>