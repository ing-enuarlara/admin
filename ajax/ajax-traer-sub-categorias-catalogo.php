<?php
include("../modules/sesion.php");
require_once(RUTA_PROYECTO . 'class/SubCategorias_Catalogo_Principal.php');
require_once(RUTA_PROYECTO . 'class/Clientes_Admin.php');
try{
    $consultaSubCategorias = SubCategorias_Catalogo_Principal::Select([
        'cmarp_categoria' => $_POST["categoria"]
    ])->fetchAll(PDO::FETCH_ASSOC);
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
    foreach($consultaSubCategorias as $datosSubCategorias){

        $nombreEmpresa='';
        if($_SESSION["datosUsuarioActual"]['usr_tipo']==DEV){
            try{
                $empresa = Clientes_Admin::Select([
                    'cliAdmi_id' => $datosSubCategorias['cmarp_id_empresa']
                ])->fetch(PDO::FETCH_ASSOC);
            } catch (Exception $e) {
                include(RUTA_PROYECTO."includes/error-catch-to-report.php");
            }
            $nombreEmpresa="[".$empresa['cliAdmi_nombre']."]";
        }
        $selected='';
        if(!empty($_POST["subCategoria"]) && $_POST["subCategoria"]==$datosSubCategorias['cmarp_id']){$selected='selected';}

        echo '<option value="'.$datosSubCategorias['cmarp_id'].'" '.$selected.'>'.$datosSubCategorias['cmarp_nombre'].$nombreEmpresa.'</option>';
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