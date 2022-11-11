<?php
    //USUARIO ACTUAL
	$consultaUsuarioActual = $conexionBdAdministrativo->query("SELECT * FROM administrativo_usuarios INNER JOIN administrativo_roles ON utipo_id=usr_tipo WHERE usr_id='".$_SESSION["id"]."'");
	$numUsuarioActual = $consultaUsuarioActual->num_rows;

	if($numUsuarioActual == 0){
		echo "<span style='font-family:Arial; color:red;'>El usuario con ID <b>".$_SESSION["id"]."</b> no existe.</samp>";
		exit();
	}

	$datosUsuarioActual = mysqli_fetch_array($consultaUsuarioActual, MYSQLI_BOTH);

	//SABER SI ESTA BLOQUEADO
	if($datosUsuarioActual['usr_bloqueado']==1)
	{
?>		
		<span style='font-family:Arial; color:red;'>Su usuario ha sido bloqueado. Por tanto no tiene permisos para acceder al Sistema.</samp>
        <script type="text/javascript">
		function sacar(){
			window.location.href="../salir.php";
		} 
		setInterval('sacar()', 3000);
        </script>
<?php	
    	exit();	
	}