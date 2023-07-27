<?php
//PRODUCTOS
if(!empty($_POST["producto"])){
    $numero = (count($_POST["producto"]));

    $contador = 0;
    while ($contador < $numero):

        //Se obtienen uno por uno los datos completos de los productos que vienen en el array y .
        $consulta=$conexionBdComercial->query("SELECT cprod_id, cprod_costo, czpp_id, czpp_producto, czpp_valor, czpp_cotizacion FROM comercial_productos 
        LEFT JOIN comercial_relacion_productos ON czpp_producto=cprod_id AND czpp_cotizacion='" . $_POST["id"] . "' 
        WHERE cprod_id='" . $_POST["producto"][$contador] . "'");
        $productoDatos = mysqli_fetch_array($consulta, MYSQLI_BOTH);

        /* 
        * Si el producto NO está asociado a la cotización.
        */
        if ($productoDatos['czpp_id'] == '') {

            //Para pesos colombianos
            $valorProducto = $productoDatos['cprod_costo'];
            //Si la cotización ya está en USD
            if ($_POST["moneda"] == 2) {
                $valorProducto = round(($productoDatos['cprod_costo']/$precioDolarCOP),2);
            }
            $conexionBdComercial->query("INSERT INTO comercial_relacion_productos(czpp_cotizacion, czpp_producto, czpp_cantidad, czpp_impuesto, czpp_descuento, czpp_valor, czpp_orden, czpp_tipo)VALUES('" . $_POST["id"] . "','" . $_POST["producto"][$contador] . "', 1, 19, 0, '" . $valorProducto . "', '" . $numero . "', 1)");

        } else {
            if ($_POST["monedaActual"] != $_POST["moneda"]) {
                
                //Si cambió a pesos colombianos
                if ($_POST["moneda"] == 1) {
                    $valorProducto = $productoDatos['cprod_costo'];
                }
                //Si cambió a Dolares
                else {
                    
                    $valorProducto = round(($productoDatos['cprod_costo']/$precioDolarCOP),2);
                }

                $conexionBdComercial->query("UPDATE comercial_relacion_productos SET czpp_valor='" . $valorProducto . "' WHERE czpp_id='" . $productoDatos['czpp_id'] . "'");
            }
        }

        $contador++;
    endwhile;

    //ELIMINAR LOS QUE YA NO ESTÁN EN LA COTIZACIÓN.
    $productosEnCotizacion = $conexionBdComercial->query("SELECT * FROM comercial_relacion_productos WHERE czpp_cotizacion='" . $_POST["id"] . "'");
    while ($pec = mysqli_fetch_array($productosEnCotizacion, MYSQLI_BOTH)):

        $encontrado = 0;
        $contador = 0;
        while ($contador < $numero):

            if ($pec['czpp_producto'] == $_POST["producto"][$contador]) {
                $encontrado = 1;
                break;
            }

            $contador++;
        endwhile;

        if ($encontrado == 0):
            $conexionBdComercial->query("DELETE FROM comercial_relacion_productos WHERE czpp_producto='" . $pec['czpp_producto'] . "' AND czpp_cotizacion='" . $_POST["id"] . "'");
        endif;

    endwhile;
}else{
    $conexionBdComercial->query("DELETE FROM comercial_relacion_productos WHERE czpp_cotizacion='" . $_POST["id"] . "'");
}