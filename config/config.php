<?php
try{
    $consultaConfig = $conexionBdGeneral->query("SELECT * FROM configuracion
    LEFT JOIN ".BDADMIN.".localidad_ciudades ON ciu_id=conf_ciudad
    LEFT JOIN ".BDADMIN.".localidad_departamentos ON dep_id=ciu_departamento 
    WHERE conf_id_empresa='".$datosUsuarioActual['usr_id_empresa']."'");
} catch (Exception $e) {
    echo "Excepción catpurada: ".$e->getMessage();
    exit();
}
$configuracion = mysqli_fetch_array($consultaConfig, MYSQLI_BOTH);

$tipoCrud= array("", "Create", "Read", "Update", "Delete");

$formaPago = array("", "CONTADO", "CRÉDITO");
$monedas = array("","COP","USD");
$monedasExt = array("","USD","EURO");
$simbolosMonedas = array("","$","USD");
$estadoPedidos= array("Anulado", "En Preparación", "En Camino", "Entregado", "Devuelto");
$colorEstadoPedidos= array("#dc3545", "#007bff", "#ffc107", "#28a745", "#dc3545");
$colorEstadoTimelinePedidos= array("red", "blue", "yellow", "green", "red");
$tipoFactura = array("Desc.", "Venta", "Compra");
$estadoFactura= array("No Pagado", "Pagado");
$colorEstadoFactura= array("#ffc107", "#28a745");
$enEspanol = array(
    'Sunday'    => 'Domingo',
    'Monday'    => 'Lunes',
    'Tuesday'   => 'Martes',
    'Wednesday' => 'Miércoles',
    'Thursday'  => 'Jueves',
    'Friday'    => 'Viernes',
    'Saturday'  => 'Sábado',
    'January'   => 'Enero',
    'February'  => 'Febrero',
    'March'     => 'Marzo',
    'April'     => 'Abril',
    'May'       => 'Mayo',
    'June'      => 'Junio',
    'July'      => 'Julio',
    'August'    => 'Agosto',
    'September' => 'Septiembre',
    'October'   => 'Octubre',
    'November'  => 'Noviembre',
    'December'  => 'Diciembre',
    'Jan'       => 'Ene',
    'Feb'       => 'Feb',
    'Mar'       => 'Mar',
    'Apr'       => 'Abr',
    'May'       => 'May',
    'Jun'       => 'Jun',
    'Jul'       => 'Jul',
    'Aug'       => 'Ago',
    'Sep'       => 'Sep',
    'Oct'       => 'Oct',
    'Nov'       => 'Nov',
    'Dec'       => 'Dic'
);