<?php   
    require_once("../../sesion.php");

    $idPagina = 19;
    include(RUTA_PROYECTO."includes/verificar-paginas.php");

    try{
        $conexionBdAdmin->query("DELETE FROM modulos_clien_admin WHERE mxca_id_cliAdmin='" . $_GET["id"] . "'");
        $conexionBdAdmin->query("DELETE FROM clientes_admin WHERE cliAdmi_id='" . $_GET["id"] . "'");
        $conexionBdAdmin->query("DELETE FROM historial_acciones WHERE hil_empresa='" . $_GET["id"] . "'");
        $conexionBdAdmin->query("DELETE FROM historial_correos_enviados WHERE hisco_id_empresa='" . $_GET["id"] . "'");
        $conexionBdAdmin->query("DELETE FROM reporte_errores WHERE rperr_id_empresa='" . $_GET["id"] . "'");
	} catch (Exception $e) {
		include(RUTA_PROYECTO."includes/error-catch-to-report.php");
	}

    try{
        $conexionBdGeneral->query("DELETE FROM configuracion WHERE conf_id_empresa='" . $_GET["id"] . "'");
        $conexionBdGeneral->query("DELETE FROM general_color_store WHERE gcs_id_empresa='" . $_GET["id"] . "'");
	} catch (Exception $e) {
		include(RUTA_PROYECTO."includes/error-catch-to-report.php");
	}

    try{
        $conexionBdAdministrativo->query("DELETE FROM administrativo_permisos_rol WHERE perol_id_empresa='" . $_GET["id"] . "'");
        $conexionBdAdministrativo->query("DELETE FROM administrativo_roles WHERE utipo_id_empresa='" . $_GET["id"] . "'");
        $conexionBdAdministrativo->query("DELETE FROM administrativo_usuarios WHERE usr_id_empresa='" . $_GET["id"] . "'");
	} catch (Exception $e) {
		include(RUTA_PROYECTO."includes/error-catch-to-report.php");
	}

    try{
        $conexionBdComercial->query("DELETE FROM comercial_categorias WHERE ccat_id_empresa='" . $_GET["id"] . "'");
        $conexionBdComercial->query("DELETE FROM comercial_marcas WHERE cmar_id_empresa='" . $_GET["id"] . "'");
        $conexionBdComercial->query("DELETE FROM comercial_productos WHERE cprod_id_empresa='" . $_GET["id"] . "'");
        $conexionBdComercial->query("DELETE FROM comercial_productos_fotos WHERE cpf_id_empresa='" . $_GET["id"] . "'");
        $conexionBdComercial->query("DELETE FROM comercial_marca_productos WHERE ctipo_id_empresa='" . $_GET["id"] . "'");
        $conexionBdComercial->query("DELETE FROM comercial_catalogo_principal WHERE cprin_id_empresa='" . $_GET["id"] . "'");
        $conexionBdComercial->query("DELETE FROM comercial_categoria_catalogo_principal WHERE ccatp_id_empresa='" . $_GET["id"] . "'");
        $conexionBdComercial->query("DELETE FROM comercial_clientes WHERE cli_id_empresa='" . $_GET["id"] . "'");
        $conexionBdComercial->query("DELETE FROM comercial_cotizaciones WHERE cotiz_id_empresa='" . $_GET["id"] . "'");
        $conexionBdComercial->query("DELETE FROM comercial_facturas WHERE factura_id_empresa='" . $_GET["id"] . "'");
        $conexionBdComercial->query("DELETE FROM comercial_marca_catalogo_principal WHERE cmarp_id_empresa='" . $_GET["id"] . "'");
        $conexionBdComercial->query("DELETE FROM comercial_ofertas WHERE ofer_id_empresa='" . $_GET["id"] . "'");
        $conexionBdComercial->query("DELETE FROM comercial_ofertas_productos WHERE cop_id_empresa='" . $_GET["id"] . "'");
        $conexionBdComercial->query("DELETE FROM comercial_pagina_marca_catalogo WHERE cpmc_id_empresa='" . $_GET["id"] . "'");
        $conexionBdComercial->query("DELETE FROM comercial_pedidos WHERE pedid_id_empresa='" . $_GET["id"] . "'");
        $conexionBdComercial->query("DELETE FROM comercial_productos_techspecs WHERE cpt_id_empresa='" . $_GET["id"] . "'");
        $conexionBdComercial->query("DELETE FROM comercial_proveedores WHERE prov_id_empresa='" . $_GET["id"] . "'");
        $conexionBdComercial->query("DELETE FROM comercial_relacion_productos WHERE czpp_id_empresa='" . $_GET["id"] . "'");
        $conexionBdComercial->query("DELETE FROM comercial_remisiones WHERE remi_id_empresa='" . $_GET["id"] . "'");
        $conexionBdComercial->query("DELETE FROM comercial_subcate_cate WHERE subca_id_empresa='" . $_GET["id"] . "'");
        $conexionBdComercial->query("DELETE FROM comercial_tallas_color_stock WHERE cpta_empresa='" . $_GET["id"] . "'");
        $conexionBdComercial->query("DELETE FROM comercial_tipo_catalogo_principal WHERE ctipop_id_empresa='" . $_GET["id"] . "'");
        $conexionBdComercial->query("DELETE FROM feedback_productos WHERE feed_id_empresa='" . $_GET["id"] . "'");
	} catch (Exception $e) {
		include(RUTA_PROYECTO."includes/error-catch-to-report.php");
	}

    try{
        $conexionBdMicuenta->query("DELETE FROM micuenta_agenda WHERE age_id_empresa='" . $_GET["id"] . "'");
        $conexionBdMicuenta->query("DELETE FROM micuenta_agenda_usuarios WHERE agus_id_empresa='" . $_GET["id"] . "'");
        $conexionBdMicuenta->query("DELETE FROM micuenta_mensajes WHERE men_id_empresa='" . $_GET["id"] . "'");
	} catch (Exception $e) {
		include(RUTA_PROYECTO."includes/error-catch-to-report.php");
	}

    try{
        $conexionBdPaginaWeb->query("DELETE FROM general_color_store WHERE gcs_id_empresa='" . $_GET["id"] . "'");
        $conexionBdPaginaWeb->query("DELETE FROM configuracion WHERE conf_id_empresa='" . $_GET["id"] . "'");
        $conexionBdPaginaWeb->query("DELETE FROM pagina_legales WHERE pal_id_empresa='" . $_GET["id"] . "'");
        $conexionBdPaginaWeb->query("DELETE FROM blogs WHERE blogs_id_categoria='" . $_GET["id"] . "'");
        $conexionBdPaginaWeb->query("DELETE FROM categorias_blogs WHERE catblo_id_empresa='" . $_GET["id"] . "'");
        $conexionBdPaginaWeb->query("DELETE FROM comentarios WHERE com_id_empresa='" . $_GET["id"] . "'");
        $conexionBdPaginaWeb->query("DELETE FROM feedback WHERE feed_id_empresa='" . $_GET["id"] . "'");
        $conexionBdPaginaWeb->query("DELETE FROM newsletter WHERE new_empresa='" . $_GET["id"] . "'");
        $conexionBdPaginaWeb->query("DELETE FROM respuestas WHERE res_id_empresa='" . $_GET["id"] . "'");
        $conexionBdPaginaWeb->query("DELETE FROM sliders_paginas WHERE slp_id_empresa='" . $_GET["id"] . "'");
        $conexionBdPaginaWeb->query("DELETE FROM visitas_paginas WHERE vis_id_empresa='" . $_GET["id"] . "'");
	} catch (Exception $e) {
		include(RUTA_PROYECTO."includes/error-catch-to-report.php");
	}

    include(RUTA_PROYECTO."includes/guardar-historial-acciones.php");

    echo '<script type="text/javascript">window.location.href="../bd_read/clientes-admin.php";</script>';
    exit();