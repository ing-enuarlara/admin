<?php
// Obtener el precio del dólar utilizando la API de Open Exchange Rates
$appId = 'ea44daafcb314c389c173c2aa2754013'; // Reemplaza con tu App ID de Open Exchange Rates
// URL de la API
$url = "https://openexchangerates.org/api/latest.json?app_id=$appId&base=USD&symbols=COP";
// Realizar la solicitud HTTP
$response = file_get_contents($url);
// Decodificar la respuesta JSON
$data = json_decode($response, true);
// Obtener el precio del dólar en pesos colombiano (COP)
$precioDolarCOP = $data['rates']['COP'];
?>