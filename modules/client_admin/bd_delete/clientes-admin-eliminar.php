<?php   
    require_once("../../sesion.php");

    $idPagina = 19;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

    $conexionBdAdmin->query("DELETE FROM modulos_clien_admin WHERE mxca_id_cliAdmin='" . $_GET["id"] . "'");
    $conexionBdAdmin->query("DELETE FROM clientes_admin WHERE cliAdmi_id='" . $_GET["id"] . "'");
    $conexionBdAdmin->query("DELETE FROM historial_acciones WHERE hil_empresa='" . $_GET["id"] . "'");

    $conexionBdGeneral->query("DELETE FROM configuracion WHERE conf_id_empresa='" . $_GET["id"] . "'");

    $conexionBdAdministrativo->query("DELETE FROM administrativo_usuarios WHERE usr_id_empresa='" . $_GET["id"] . "'");
    
    $conexionBdComercial->query("DELETE FROM comercial_categorias WHERE ccat_id_empresa='" . $_GET["id"] . "'");
    $conexionBdComercial->query("DELETE FROM comercial_marcas WHERE cmar_id_empresa='" . $_GET["id"] . "'");
    $conexionBdComercial->query("DELETE FROM comercial_productos WHERE cprod_id_empresa='" . $_GET["id"] . "'");
    $conexionBdComercial->query("DELETE FROM comercial_productos_fotos WHERE cpf_id_empresa='" . $_GET["id"] . "'");
    
    $conexionBdPaginaWeb->query("DELETE FROM general_color_store WHERE gcs_id_empresa='" . $_GET["id"] . "'");
    $conexionBdPaginaWeb->query("DELETE FROM configuracion WHERE conf_id_empresa='" . $_GET["id"] . "'");
    $conexionBdPaginaWeb->query("DELETE FROM pagina_legales WHERE pal_id_empresa='" . $_GET["id"] . "'");

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/clientes-admin.php";</script>';
    exit();