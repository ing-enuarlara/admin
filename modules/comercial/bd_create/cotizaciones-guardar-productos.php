<?php
//Productos
if(!empty($_POST["producto"])){
    $numProductos = (count($_POST["producto"]));

    if ($numProductos > 0):
        $contProducto = 0;
        while ($contProducto < $numProductos):

            try{
                $consulta=$conexionBdComercial->query("SELECT * FROM comercial_productos WHERE cprod_id='" . $_POST["producto"][$contProducto] . "'");
            } catch (Exception $e) {
                include(RUTA_PROYECTO."includes/error-catch-to-report.php");
            }
            $productoDatos = mysqli_fetch_array($consulta, MYSQLI_BOTH);

            //Para pesos colombianos
            $valorProducto = $productoDatos['cprod_costo'];
            //Si la cotización ya está en USD
            if ($_POST["moneda"] == 2) {
                $valorProducto = round(($productoDatos['cprod_costo']/$precioDolarCOP),2);
            }

            try{
                $conexionBdComercial->query("INSERT INTO comercial_relacion_productos(czpp_cotizacion, czpp_producto, czpp_valor, czpp_orden, czpp_cantidad, czpp_impuesto, czpp_tipo)VALUES('" . $idInsertU . "','" . $_POST["producto"][$contProducto] . "', '" . $valorProducto . "', '" . $numProductos . "', 1, 19, '" . $tipo . "')");
            } catch (Exception $e) {
                include(RUTA_PROYECTO."includes/error-catch-to-report.php");
            }

            $contProducto++;

        endwhile;

    endif;
}