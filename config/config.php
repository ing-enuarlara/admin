<?php
require_once(RUTA_PROYECTO."class/Modulos.php");
require_once(RUTA_PROYECTO."class/Paginas.php");
require_once(RUTA_PROYECTO."class/Clientes_Modulos.php");

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
$coloresBases = array(
    '#000000'    => 'Negro',
    '#696969'    => 'Gris',
    '#FFFFFF'    => 'Blanco',
    '#FF0000'    => 'Rojo',
    '#FFA500'    => 'Naranja',
    '#FFFF00'    => 'Amarillo',
    '#008000'    => 'Verde',
    '#0000FF'    => 'Azul',
    '#800080'    => 'Morado',
    '#8A2BE2'    => 'Violeta',
    '#A52A2A'    => 'Marrón',
    '#D2691E'    => 'Chocolate',
    '#F5DEB3'    => 'Beige',
    '#FFC0CB'    => 'Rosa'
);