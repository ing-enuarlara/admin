<?php
include("../modules/sesion.php");
require_once(RUTA_PROYECTO . 'class/SubCategorias.php');
require_once(RUTA_PROYECTO . 'class/Sub_Categorias.php');
require_once(RUTA_PROYECTO . 'class/Producto_Sub_Categorias.php');

if (!empty($_POST['id'])) {
    $arraySubCate = Producto_Sub_Categorias::Select([
        'psct_producto' => $_POST['id'],
    ], "psct_subcategoria")->fetchAll(PDO::FETCH_COLUMN);
}

SubCategorias::foreignKey(SubCategorias::INNER, [
    "cmar_id" => 'subca_marca'
]);
$consultaSubCategorias = Sub_Categorias::SelectJoin(
    [
        "subca_prin" => NO,
        Sub_Categorias::OTHER_PREDICATE => "subca_cate IN (".$_POST['categoria'].")"
    ],
    "cmar.*",
    [
        SubCategorias::class
    ], 
    "", 
    "cmar_id"
);

if (!empty($consultaSubCategorias)) {
?>
    <script type="application/javascript">
        document.getElementById('mensaje').style.display = "none";
        document.getElementById('subCategoria-container').style.display = "block";
    </script>
    <?php
    foreach ($consultaSubCategorias as $datosSubCategorias) {
        $selected = '';
        if (!empty($arraySubCate) && in_array($datosSubCategorias['cmar_id'], $arraySubCate)) {
            $selected = 'selected';
        }
        echo '<option value="' . $datosSubCategorias['cmar_id'] . '" ' . $selected . '>' . $datosSubCategorias['cmar_nombre'] . '</option>';
    }
    exit();
} else {
    ?>
    <script type="application/javascript">
        document.getElementById('mensaje').style.display = "none";
        document.getElementById('subCategoria-container').style.display = "none";
        document.getElementById('marca').value = "0";
    </script>
<?php
}
