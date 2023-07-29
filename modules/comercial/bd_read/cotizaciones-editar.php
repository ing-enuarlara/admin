<?php
include("../../sesion.php");

$idPagina = 77;

include(RUTA_PROYECTO . "includes/verificar-paginas.php");
include(RUTA_PROYECTO . "includes/head.php");

$consuluta= $conexionBdComercial->query("SELECT * FROM comercial_cotizaciones INNER JOIN comercial_clientes ON cli_id=cotiz_cliente WHERE cotiz_id='".$_GET["id"]."'");
$resultadoD = mysqli_fetch_array($consuluta, MYSQLI_BOTH);

$cliente = '';
if(!empty($_GET["cte"])){
    $cliente = $_GET["cte"];
}else{
	$cliente = $resultadoD['cotiz_cliente'];
}
?>
<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome -->
<link rel="stylesheet" href="<?= REDIRECT_ROUTE ?>plugins/fontawesome-free/css/all.min.css">
<!-- daterange picker -->
<link rel="stylesheet" href="<?= REDIRECT_ROUTE ?>plugins/daterangepicker/daterangepicker.css">
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="<?= REDIRECT_ROUTE ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
<!-- Bootstrap Color Picker -->
<link rel="stylesheet" href="<?= REDIRECT_ROUTE ?>plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
<!-- Tempusdominus Bootstrap 4 -->
<link rel="stylesheet" href="<?= REDIRECT_ROUTE ?>plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
<!-- Select2 -->
<link rel="stylesheet" href="<?= REDIRECT_ROUTE ?>plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="<?= REDIRECT_ROUTE ?>plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<!-- Bootstrap4 Duallistbox -->
<link rel="stylesheet" href="<?= REDIRECT_ROUTE ?>plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
<!-- BS Stepper -->
<link rel="stylesheet" href="<?= REDIRECT_ROUTE ?>plugins/bs-stepper/css/bs-stepper.min.css">
<!-- dropzonejs -->
<link rel="stylesheet" href="<?= REDIRECT_ROUTE ?>plugins/dropzone/min/dropzone.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="<?= REDIRECT_ROUTE ?>dist/css/adminlte.min.css">
<!-- summernote -->
<link rel="stylesheet" href="<?= REDIRECT_ROUTE ?>plugins/summernote/summernote-bs4.min.css">
<script type="text/javascript">
    function clientes(datoscliente){
        var id = datoscliente.value;
        location.href = "cotizaciones-editar.php?id=<?=$_GET["id"];?>&cte="+id+"#productos";
    }

    function getPay(pay){
        let msg;
        
        if(pay.value == 1){
            msg = 'La cotización cambiará a pesos colombianos. Es decir que se tomará el valor en dolares y se multiplicará por el TRM de venta actual.';
        }else if(pay.value == 2){
            msg = 'La cotización cambiará a dólares americanos. Es decir que se tomará el valor en pesos y se dividirá entre el TRM de compra actual.';
        }

        alert(msg);
    }
</script>
<?php if($resultadoD['cotiz_vendida']!=1){?>
	<script type="text/javascript">
        function productos(enviada){
            var campo = enviada.title;
            var producto = enviada.name;
            var proceso = 1;
            var valor = enviada.value;
            $('#resp').empty().hide().html("Esperando...").show(1);
            datos = "producto="+(producto)+"&proceso="+(proceso)+"&valor="+(valor)+"&campo="+(campo);
            $.ajax({
                type: "POST",
                url: "../../../ajax/ajax-productos.php",
                data: datos,
                success: function(data){
                $('#resp').empty().hide().html(data).show(1);
                }
            });
        }
	</script>
<?php }?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <?php include(RUTA_PROYECTO . "includes/carga.php"); ?>

        <?php include(RUTA_PROYECTO . "includes/encabezado.php"); ?>

        <?php include(RUTA_PROYECTO . "includes/menu.php"); ?>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?= REDIRECT_ROUTE ?>modules/index.php">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="<?= REDIRECT_ROUTE ?>modules/comercial/bd_read/cotizaciones.php">Cotizaciones</a></li>
                                <li class="breadcrumb-item active"><?= $paginaActual['pag_nombre'] ?></li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    <?php include(RUTA_PROYECTO . "includes/mensajes-informativos.php");?>

                    <div class="row">
                        <!-- column -->
                        <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="card card-success">
                                <div class="card-header">
                                    <h5 class="float-sm-right">Enviar cotización por correo</h5>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form class="form-horizontal" method="post" action="../../../enviar-correos/cotizaciones-enviar-correo.php" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="<?=$_GET["id"];?>">
                                    <div class="card-body">

                                        <div class="form-group col-md-4">
                                            <label for="asuntoInput">Asunto:</label>
                                            <input type="text" class="form-control" id="asuntoInput" placeholder="Asunto" name="asunto" value="COTIZACIÓN #<?= date("dmy", strtotime($resultadoD['cotiz_fecha_propuesta']))."-".$resultadoD['cotiz_id']; ?>" required>
                                        </div>

                                        <div class="form-group col-md-10">
                                            <label for="mensaje">Mensaje:</label>
                                            <textarea name="mensaje" rows="7" cols="80" style="width: 80%" id="mensaje" placeholder="Mensaje...">
                                                Estimado/a <b><?=strtoupper($resultadoD['cli_nombre']);?>,</b><br>
                                                Estamos enviando la cotización por este medio para que la revise y la pueda imprimir según su necesidad.<br><br>
                                                Muchas gracias por preferirnos.<br>
                                            </textarea>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Enviar Cotización</button>
                                    </div>
                                </form>
                            </div>
                            <!-- /.card -->
                        </div>
                        <!--/.column -->
                    </div>
                    <!-- /.row -->

                    <p>
                        <a href="cotizaciones-agregar.php" class="btn btn-primary"><i class="fas fa-solid fa-plus"></i> Agregar nuevo</a>
                        <a href="../../reportes/formato-cotizacion-1.php?id=<?=$_GET["id"];?>" class="btn btn-success" target="_blank"><i class="icon-print"></i> Imprimir</a>
                        <?php
                        if($resultadoD['cotiz_vendida']!=1){
                        ?>
                            <a href="../bd_create/cotizaciones-generar-pedido.php?id=<?= $resultadoD['cotiz_id']; ?>" class="btn btn-info" onClick="if(!confirm('Desea generar pedido de esta cotización?')){return false;}"><i class="icon-money"></i> Generar pedido</a>
                        <?php
                        }
                        ?>
                    </p>

                    <?php
                    $disabled='';
                    $readonly='';
                    if($resultadoD['cotiz_vendida']==1){
                        $disabled='disabled';
                        $readonly='readonly';
                    ?>
                        <script>
                            $(document).ready(function() {
                                document.getElementById('btnEnviar').style.display="none";
                                document.getElementById('btnEnviar2').style.display="none";
                            });
                        </script>
                        <p style="color: black; background-color: aquamarine; padding: 10px; font-weight: bold;">Esta cotización ya generó pedido en la siguiente fecha: <?=$resultadoD['cotiz_fecha_vendida'];?>.</p>
                        <p style="color: black; background-color: gold; padding: 10px; font-weight: bold;"> No es posible hacer más cambios en esta cotización.</p>
                    <?php
                    }
                    ?>	
                    <div class="row">
                        <!-- column -->
                        <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="card card-success">
                                <div class="card-header">
                                    <h5 class="float-sm-right"><?= $paginaActual['pag_nombre'] ?></h5>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form class="form-horizontal" method="post" action="../bd_update/cotizaciones-actualizar.php" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="<?=$_GET["id"];?>">
							        <input type="hidden" name="monedaActual" value="<?=$resultadoD['cotiz_moneda'];?>">
                                    <div class="card-body">
                                        <div class="form-group col-md-6">
                                            <label>Escoja un cliente:</label>
                                            <select data-placeholder="Escoja una opción" class="form-control select2" style="width: 100%;" name="cliente" onChange="clientes(this)" required <?=$disabled?>>
                                                <option value=""></option>
                                                <?php
                                                $where="";
                                                if($datosUsuarioActual['usr_tipo']!=1){
                                                    $where="WHERE cli_id_empresa='".$configuracion['conf_id_empresa']."'";
                                                }
                                                $consulta = $conexionBdComercial->query("SELECT * FROM comercial_clientes 
                                                INNER JOIN ".BDADMIN.".clientes_admin ON cliAdmi_id=cli_id_empresa $where");
                                                while($result = mysqli_fetch_array($consulta, MYSQLI_BOTH)){
                                                    $disabledC = '';
                                                    $dealer = '';
                                                    if($result['cli_categoria']==3){
                                                        $dealer = '(DEALER)';

                                                        if($datosUsuarioActual['usr_tipo']!=1){
                                                            $disabledC = 'disabled';
                                                        }	
                                                    }
                                                    $selected='';
                                                    if($cliente==$result[0]){
                                                        $selected = 'selected';
                                                    }
                                                    $empresa='';
                                                    if($datosUsuarioActual['usr_tipo']==1){
                                                        $empresa=' ['.$result['cliAdmi_nombre'].']';
                                                    }
                                                ?>
                                                    <option value="<?=$result[0];?>" <?=$selected?> <?=$disabledC?>><?=$result['cli_nombre']." ".$dealer." ".$empresa;?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <a href="clientes-editar.php?id=<?=$cliente;?>" class="btn btn-info" target="_blank">Editar cliente</a>
                                        <?php
                                            $consultaCli=$conexionBdComercial->query("SELECT * FROM comercial_clientes WHERE cli_id='".$cliente."'");
                                            $clienteInfo = mysqli_fetch_array($consultaCli, MYSQLI_BOTH);
                                        ?>

                                        <div class="form-group col-md-6">
                                            <label>Vendedor:</label>
                                            <select data-placeholder="Escoja una opción" class="form-control select2" style="width: 100%;" name="vendedor" required <?=$disabled?>>
                                                <option value=""></option>
                                                <?php
                                                    $where="";
                                                    if($datosUsuarioActual['usr_tipo']!=1){
                                                        $where="AND usr_id_empresa='".$configuracion['conf_id_empresa']."'";
                                                    }
                                                    $consulta = $conexionBdAdministrativo->query("SELECT * FROM administrativo_usuarios 
                                                    INNER JOIN ".BDADMIN.".clientes_admin ON cliAdmi_id=usr_id_empresa WHERE usr_bloqueado!=1 $where ORDER BY usr_nombre");
                                                    while($result = mysqli_fetch_array($consulta, MYSQLI_BOTH)){
                                                        $empresa='';
                                                        if($datosUsuarioActual['usr_tipo']==1){
                                                            $empresa=' ['.$result['cliAdmi_nombre'].']';
                                                        }
                                                        $selected='';
                                                        if($resultadoD['cotiz_vendedor']==$result[0]){
                                                            $selected = 'selected';
                                                        }
                                                ?>
                                                    <option value="<?=$result[0];?>" <?=$selected?>><?=strtoupper($result['usr_nombre'])." (".$result['usr_email'].")".$empresa;?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <hr>

                                        <div class="form-group col-md-2">
                                            <label for="exampleInputEmail1">Fecha de propuesta:</label>
                                            <input type="date" class="form-control" id="exampleInputEmail1" name="fechaPropuesta" required value="<?=$resultadoD['cotiz_fecha_propuesta'];?>" <?=$disabled?>>
                                        </div>
                                        
                                        <div class="form-group col-md-2">
                                            <label for="exampleInputEmail1">Fecha de vencimiento:</label>
                                            <input type="date" class="form-control" id="exampleInputEmail1" name="fechaVencimiento" required value="<?=$resultadoD['cotiz_fecha_vencimiento'];?>" <?=$disabled?>>
                                        </div>

                                        <?php
                                            if($clienteInfo['cli_credito']==1){
                                                $msjCredito = "Este cliente tiene crédito con la compañía.";
                                                $colorCredito = 'aquamarine';
                                            }else{
                                                $msjCredito = "Este cliente aún NO tiene crédito con la compañía.";
                                                $colorCredito = 'gold';
                                            }
                                        ?>
                                        <p style="color: black; background-color: <?=$colorCredito;?>; padding: 10px; font-weight: bold;"><?=$msjCredito;?></p>

                                        <div class="form-group col-md-2">
                                            <label>Forma de pago:</label>
                                            <select data-placeholder="Escoja una opción" class="form-control select2" style="width: 100%;" name="formaPago" <?=$disabled?>>
                                                <option value=""></option>
                                                <option value="1" <?php if($resultadoD['cotiz_forma_pago']==1)echo "selected";?>>Contado</option>
                                                <option value="2" <?php if($resultadoD['cotiz_forma_pago']==2)echo "selected";?>>Crédito</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label>Moneda:</label>
                                            <select data-placeholder="Escoja una opción" class="form-control select2" style="width: 100%;" name="moneda" onChange="getPay(this)" <?=$disabled?>>
                                                <option value=""></option>
                                                <option value="1"<?php if($resultadoD['cotiz_moneda']==1)echo "selected";?>>COP</option>
                                                <option value="2"<?php if($resultadoD['cotiz_moneda']==2)echo "selected";?>>USD</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-10">
                                            <label>Productos:</label>
                                            <select data-placeholder="Escoja una opción" class="form-control select2" style="width: 100%;" name="producto[]" multiple="multiple" <?=$disabled?>>
                                                <option value=""></option>
												<?php
                                                    $where="";
                                                    if($datosUsuarioActual['usr_tipo']!=1){
                                                        $where="AND cprod_id_empresa='".$configuracion['conf_id_empresa']."'";
                                                    }
                                                    $consulta = $conexionBdComercial->query("SELECT * FROM comercial_productos
                                                    INNER JOIN comercial_categorias ON ccat_id=cprod_categoria 
                                                    INNER JOIN ".BDADMIN.".clientes_admin ON cliAdmi_id=cprod_id_empresa WHERE cprod_id=cprod_id $where ORDER BY cprod_nombre");
                                                    while($result = mysqli_fetch_array($consulta, MYSQLI_BOTH)){
                                                        $empresa='';
                                                        if($datosUsuarioActual['usr_tipo']==1){
                                                            $empresa=' ['.$result['cliAdmi_nombre'].']';
                                                        }
                                                        $consultaCotizacionP=$conexionBdComercial->query("SELECT czpp_producto, czpp_cotizacion 
                                                        FROM comercial_relacion_productos WHERE czpp_producto='".$result[0]."' AND czpp_cotizacion='".$resultadoD['cotiz_id']."'");
                                                        $productoN = $consultaCotizacionP->num_rows;
												?>
													<option <?php if($productoN>0){echo "selected";}?> value="<?=$result[0];?>"><?=$result[0].". ".strtoupper($result['cprod_nombre'])."/".$result['ccat_nombre']." - (HAY ".$result['cprod_exitencia'].")".$empresa;?></option>
												<?php
												}
												?>
                                            </select>
                                        </div>

                                        <?php
                                            if($resultadoD['cotiz_vendida']==1){
                                        ?>
                                            <div class="form-group col-md-11">
                                                <label>Observaciones:</label>
                                                <div class="input-group">
                                                    <textarea name="notas" rows="3" cols="80" style="width: 80%" placeholder="Observaciones..." <?=$readonly?>><?=$resultadoD['cotiz_observaciones'];?></textarea>
                                                </div>
                                            </div>
                                        <?php }else{ ?>
                                            <div class="form-group col-md-10">
                                                <label for="notas">Observaciones:</label>
                                                <textarea name="notas" rows="5" cols="80" style="width: 80%" id="notas" placeholder="Observaciones...">
                                                    <?=$resultadoD['cotiz_observaciones'];?>
                                                </textarea>
                                            </div>
                                        <?php }?>

                                        <div class="form-group col-md-2">
                                            <label for="envioInput">Costo Envío:</label>
                                            <input type="text" class="form-control" id="envioInput" name="envio" value="<?=$resultadoD['cotiz_envio'];?>" <?=$disabled?>>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer" id="btnEnviar">
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                    </div>
                            </div>
                            <!-- /.card -->
                        </div>
                        <!--/.column -->
                    </div>
                    <!-- /.row -->
					<span id="resp"></span>
                    <div class="card card-success" id="productos">
                        <div class="card-header">
                            <h2 class="m-0 float-sm-right">Productos</h2>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Orden</th>
                                        <th>Productos</th>
                                        <th>Cant.</th> 
                                        <th>Valor Base</th>
                                        <th>IVA</th>
                                        <th>Dcto.</th>
                                        <th>SUBTOTAL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
							            $no = 1;
                                        $sumaUtilidad = 0;
                                        $totalIva = 0;
                                        $subtotal=0;
                                        $totalDescuento=0;
                                        $totalCantidad=0;
                                        $productos = $conexionBdComercial->query("SELECT czpp_id, czpp_valor, czpp_cantidad, czpp_descuento, czpp_impuesto, czpp_orden, czpp_observacion, czpp_descuento_especial, czpp_aprobado_usuario, czpp_aprobado_fecha, cprod_costo, cprod_id, cprod_nombre, cprod_detalles FROM comercial_productos
                                        INNER JOIN comercial_relacion_productos ON czpp_producto=cprod_id AND czpp_cotizacion='".$_GET["id"]."' AND czpp_tipo=1 ORDER BY czpp_orden");
                                        while($prod = mysqli_fetch_array($productos, MYSQLI_BOTH)){
                                            $dcto = 0;
                                            $valorTotal = 0;

                                            $valorTotal = ($prod['czpp_valor'] * $prod['czpp_cantidad']);

                                            if($prod['czpp_cantidad']>0 and $prod['czpp_descuento']>0){
                                                $dcto = ($valorTotal * ($prod['czpp_descuento']/100));
                                                $totalDescuento += $dcto;	
                                            }

                                            $valorConDcto = $valorTotal - $dcto;
                                            $totalIva += ($valorConDcto * ($prod['czpp_impuesto']/100));
                                            $subtotal +=$valorTotal;
                                            $totalCantidad += $prod['czpp_cantidad'];
                                            $sumaUtilidad += ($prod['czpp_valor'] - $prod['cprod_costo']);
                                    ?>
                                    <tr>
                                        <td><?=$no;?></td>
                                        <td><input type="number" title="czpp_orden" name="<?=$prod['czpp_id'];?>" value="<?=$prod['czpp_orden'];?>" onChange="productos(this)" style="width: 50px; text-align: center;" <?=$disabled?>></td>
                                        <td>
                                            <a href="bd_delete/cotizaciones-productos-eliminar.php?idItem=<?=$prod['czpp_id'];?>&id=<?=$_GET["id"];?>" onClick="if(!confirm('Desea eliminar este registro?')){return false;}"><i class="icon-trash"></i></a>
                                            <a href="productos-editar.php?id=<?=$prod['cprod_id'];?>" target="_blank"><?=$prod['cprod_nombre'];?></a><br>
                                            
                                            <span style="font-size: 9px; color: darkblue;"><?=$prod['cprod_detalles'];?></span><br>
                                            
                                            <p><textarea title="czpp_observacion" name="<?=$prod['czpp_id'];?>" onChange="productos(this)" style="width: 300px;" rows="1" <?=$readonly?>><?=$prod['czpp_observacion'];?></textarea></p>
                                        </td>
                                        <td><input type="number" title="czpp_cantidad" name="<?=$prod['czpp_id'];?>" value="<?=$prod['czpp_cantidad'];?>" onChange="productos(this)" style="width: 50px; text-align: center;" <?=$disabled?>></td>
                                        <td>
                                            <input type="text" title="czpp_valor" name="<?=$prod['czpp_id'];?>" value="<?=$prod['czpp_valor'];?>" onChange="productos(this)" style="width: 200px;" <?=$disabled?>>
                                        </td>
                                        <td><input type="text" title="czpp_impuesto" name="<?=$prod['czpp_id'];?>" value="<?=$prod['czpp_impuesto'];?>" onChange="productos(this)" style="width: 50px; text-align: center;" <?=$disabled?>></td>
                                        <td>
                                            <input type="text" title="czpp_descuento" name="<?=$prod['czpp_id'];?>" value="<?=$prod['czpp_descuento'];?>" onChange="productos(this)" style="width: 50px; text-align: center;" <?=$disabled?>><br>
                                                <?php 
                                                if($dcto>0)
                                                    echo "$".number_format($dcto,0,".",".");
                                                ?>
                                        </td>
                                        <td><?=$simbolosMonedas[$resultadoD['cotiz_moneda']];?><?=number_format($valorTotal,0,",",".");?></td>
                                    </tr>
                                    <?php 
                                        $no ++;
                                    }
                                    if($resultadoD['cotiz_envio']==''){$envio=0;}else{$envio=$resultadoD['cotiz_envio'];}
                                    $total = $subtotal- $totalDescuento + $totalIva + $envio;
                                    ?>	
                                </tbody>
                                <tfoot>
                                    <tr style="font-weight: bold; font-size: 16px;">
                                        <td style="text-align: right;" colspan="7">SUBTOTAL</td>
                                        <td><?=$simbolosMonedas[$resultadoD['cotiz_moneda']];?><?=number_format($subtotal,0,",",".");?></td>
                                    </tr>
                                    <tr style="font-weight: bold; font-size: 16px;">
                                        <td style="text-align: right;" colspan="7">DESCUENTO</td>
                                        <td><?=$simbolosMonedas[$resultadoD['cotiz_moneda']];?><?=number_format($totalDescuento,0,",",".");?></td>
                                    </tr>
                                    <tr style="font-weight: bold; font-size: 16px;">
                                        <td style="text-align: right;" colspan="7">IVA</td>
                                        <td><?=$simbolosMonedas[$resultadoD['cotiz_moneda']];?><?=number_format($totalIva,0,",",".");?></td>
                                    </tr>
                                    <tr style="font-weight: bold; font-size: 16px;">
                                        <td style="text-align: right;" colspan="7">ENVÍO</td>
                                        <td><?=$simbolosMonedas[$resultadoD['cotiz_moneda']];?><?=number_format($envio,0,",",".");?></td>
                                    </tr>
                                    <tr style="font-weight: bold; font-size: 16px;">
                                        <td style="text-align: right;" colspan="7">TOTAL NETO</td>
                                        <td><?=$simbolosMonedas[$resultadoD['cotiz_moneda']];?><?=number_format($total,0,",",".");?></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary" id="btnEnviar2">Guardar</button>
                            <a href="../../reportes/formato-cotizacion-1.php?id=<?=$_GET["id"];?>" class="btn btn-success" target="_blank"><i class="icon-print"></i> Imprimir</a>
                        </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.container-fluid -->
            </section>
        </div>
        <?php include(RUTA_PROYECTO . "includes/footer.php"); ?>
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
    </div>
    <!-- jQuery -->
    <script src="<?= REDIRECT_ROUTE ?>plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= REDIRECT_ROUTE ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Select2 -->
    <script src="<?= REDIRECT_ROUTE ?>plugins/select2/js/select2.full.min.js"></script>
    <!-- Bootstrap4 Duallistbox -->
    <script src="<?= REDIRECT_ROUTE ?>plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
    <!-- InputMask -->
    <script src="<?= REDIRECT_ROUTE ?>plugins/moment/moment.min.js"></script>
    <script src="<?= REDIRECT_ROUTE ?>plugins/inputmask/jquery.inputmask.min.js"></script>
    <!-- date-range-picker -->
    <script src="<?= REDIRECT_ROUTE ?>plugins/daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap color picker -->
    <script src="<?= REDIRECT_ROUTE ?>plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
    <!-- bs-custom-file-input -->
    <script src="<?= REDIRECT_ROUTE ?>plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="<?= REDIRECT_ROUTE ?>plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Bootstrap Switch -->
    <script src="<?= REDIRECT_ROUTE ?>plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
    <!-- BS-Stepper -->
    <script src="<?= REDIRECT_ROUTE ?>plugins/bs-stepper/js/bs-stepper.min.js"></script>
    <!-- dropzonejs -->
    <script src="<?= REDIRECT_ROUTE ?>plugins/dropzone/min/dropzone.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= REDIRECT_ROUTE ?>dist/js/adminlte.min.js"></script>
    <!-- Summernote -->
    <script src="<?= REDIRECT_ROUTE ?>plugins/summernote/summernote-bs4.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?= REDIRECT_ROUTE ?>dist/js/demo.js"></script>
    <!-- Page specific script -->
    <script>
        $(function() {
        // Summernote
        $('#notas').summernote()
        $('#mensaje').summernote()

        // CodeMirror
        CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
            mode: "htmlmixed",
            theme: "monokai"
        });
        })
    </script>
    <script>
        $(function() {
            bsCustomFileInput.init();
        });
    </script>
    <script>
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()
            
            $('.pais').select2({
                templateSelection: formatOption
            });

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })

            //Datemask dd/mm/yyyy
            $('#datemask').inputmask('dd/mm/yyyy', {
                'placeholder': 'dd/mm/yyyy'
            })
            //Datemask2 mm/dd/yyyy
            $('#datemask2').inputmask('mm/dd/yyyy', {
                'placeholder': 'mm/dd/yyyy'
            })
            //Money Euro
            $('[data-mask]').inputmask()

            //Date picker
            $('#reservationdate').datetimepicker({
                format: 'L'
            });

            //Date and time picker
            $('#reservationdatetime').datetimepicker({
                icons: {
                    time: 'far fa-clock'
                }
            });

            //Date range picker
            $('#reservation').daterangepicker()
            //Date range picker with time picker
            $('#reservationtime').daterangepicker({
                timePicker: true,
                timePickerIncrement: 30,
                locale: {
                    format: 'MM/DD/YYYY hh:mm A'
                }
            })
            //Date range as a button
            $('#daterange-btn').daterangepicker({
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    },
                    startDate: moment().subtract(29, 'days'),
                    endDate: moment()
                },
                function(start, end) {
                    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
                }
            )

            //Timepicker
            $('#timepicker').datetimepicker({
                format: 'LT'
            })

            //Bootstrap Duallistbox
            $('.duallistbox').bootstrapDualListbox()

            //Colorpicker
            $('.my-colorpicker1').colorpicker()
            //color picker with addon
            $('.my-colorpicker2').colorpicker()

            $('.my-colorpicker2').on('colorpickerChange', function(event) {
                $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
            })

            $("input[data-bootstrap-switch]").each(function() {
                $(this).bootstrapSwitch('state', $(this).prop('checked'));
            })

        })

        // BS-Stepper Init
        document.addEventListener('DOMContentLoaded', function() {
            window.stepper = new Stepper(document.querySelector('.bs-stepper'))
        })

        // DropzoneJS Demo Code Start
        Dropzone.autoDiscover = false

        // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
        var previewNode = document.querySelector("#template")
        previewNode.id = ""
        var previewTemplate = previewNode.parentNode.innerHTML
        previewNode.parentNode.removeChild(previewNode)

        var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
            url: "/target-url", // Set the url
            thumbnailWidth: 80,
            thumbnailHeight: 80,
            parallelUploads: 20,
            previewTemplate: previewTemplate,
            autoQueue: false, // Make sure the files aren't queued until manually added
            previewsContainer: "#previews", // Define the container to display the previews
            clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
        })

        myDropzone.on("addedfile", function(file) {
            // Hookup the start button
            file.previewElement.querySelector(".start").onclick = function() {
                myDropzone.enqueueFile(file)
            }
        })

        // Update the total progress bar
        myDropzone.on("totaluploadprogress", function(progress) {
            document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
        })

        myDropzone.on("sending", function(file) {
            // Show the total progress bar when upload starts
            document.querySelector("#total-progress").style.opacity = "1"
            // And disable the start button
            file.previewElement.querySelector(".start").setAttribute("disabled", "disabled")
        })

        // Hide the total progress bar when nothing's uploading anymore
        myDropzone.on("queuecomplete", function(progress) {
            document.querySelector("#total-progress").style.opacity = "0"
        })

        // Setup the buttons for all transfers
        // The "add files" button doesn't need to be setup because the config
        // `clickable` has already been specified.
        document.querySelector("#actions .start").onclick = function() {
            myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
        }
        document.querySelector("#actions .cancel").onclick = function() {
            myDropzone.removeAllFiles(true)
        }
        // DropzoneJS Demo Code End
    </script>
    <?php include(RUTA_PROYECTO . "includes/pie.php"); ?>
</body>

</html>