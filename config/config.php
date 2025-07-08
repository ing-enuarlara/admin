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
    '#1C1C1C'    => 'Negro carbón',
    '#2F4F4F'    => 'Gris oscuro',
    '#696969'    => 'Gris',
    '#D3D3D3'    => 'Gris claro',
    '#FFFFFF'    => 'Blanco',
    '#FF0000'    => 'Rojo',
    '#800000'    => 'Rojo oscuro',
    '#DC143C'    => 'Carmesí',
    '#FF6347'    => 'Tomate',
    '#FFA500'    => 'Naranja',
    '#FF8C00'    => 'Naranja oscuro',
    '#FFD700'    => 'Dorado',
    '#FFFF00'    => 'Amarillo',
    '#FFFACD'    => 'Amarillo pálido',
    '#008000'    => 'Verde',
    '#006400'    => 'Verde oscuro',
    '#90EE90'    => 'Verde claro',
    '#00FF7F'    => 'Verde primavera',
    '#00FFFF'    => 'Cian',
    '#40E0D0'    => 'Turquesa',
    '#20B2AA'    => 'Verde azulado',
    '#0000FF'    => 'Azul',
    '#000080'    => 'Azul marino',
    '#4682B4'    => 'Azul acero',
    '#87CEFA'    => 'Azul cielo',
    '#8A2BE2'    => 'Violeta',
    '#DA70D6'    => 'Orquídea',
    '#4B0082'    => 'Índigo',
    '#A52A2A'    => 'Marrón',
    '#8B4513'    => 'Marrón madera',
    '#D2691E'    => 'Chocolate',
    '#F5DEB3'    => 'Beige',
    '#FFC0CB'    => 'Rosa',
    '#FF69B4'    => 'Rosa fuerte',
    '#DB7093'    => 'Rosa pálido'
);