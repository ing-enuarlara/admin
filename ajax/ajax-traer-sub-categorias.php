<?php
include("../modules/sesion.php");
try{
    $consultaSubCategorias= $conexionBdComercial->query("SELECT * FROM comercial_marcas WHERE cmar_categoria='".$_POST["categoria"]."'");
} catch (Exception $e) {
    include(RUTA_PROYECTO."includes/error-catch-to-report.php");
}
$numSubCategorias=mysqli_num_rows($consultaSubCategorias);

if($numSubCategorias>0){
?>
    <script type="application/javascript">
        document.getElementById('mensaje').style.display = "none";
        document.getElementById('subCategoria-container').style.display = "block";
    </script> 
<?php  
    while($datosSubCategorias = mysqli_fetch_array($consultaSubCategorias, MYSQLI_BOTH)){

        $nombreEmpresa='';
        if($_SESSION["datosUsuarioActual"]['usr_tipo']==DEV){
            try{
                $empresa= $conexionBdAdmin->query("SELECT * FROM clientes_admin WHERE cliAdmi_id='".$datosSubCategorias['cmar_id_empresa']."'");
            } catch (Exception $e) {
                include(RUTA_PROYECTO."includes/error-catch-to-report.php");
            }
            $nomEmpresa = mysqli_fetch_array($empresa, MYSQLI_BOTH);
            $nombreEmpresa="[".$nomEmpresa['cliAdmi_nombre']."]";
        }
        $selected='';
        if(!empty($_POST["subCategoria"]) && $_POST["subCategoria"]==$datosSubCategorias['cmar_id']){$selected='selected';}

        echo '<option value="'.$datosSubCategorias['cmar_id'].'" '.$selected.'>'.$datosSubCategorias['cmar_nombre'].$nombreEmpresa.'</option>';
    }
    exit();
}else{
?>
    <script type="application/javascript">
        document.getElementById('mensaje').style.display = "none";
        document.getElementById('subCategoria-container').style.display = "none";
        document.getElementById('marca').value = "0";
    </script> 
<?php    
}