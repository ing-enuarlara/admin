<?php
include("../modules/sesion.php");
require_once(RUTA_PROYECTO . 'class/SubCategorias_Catalogo_Principal.php');
require_once(RUTA_PROYECTO . 'class/Sub_Categorias.php');
require_once(RUTA_PROYECTO . 'class/Clientes_Admin.php');

SubCategorias_Catalogo_Principal::foreignKey(SubCategorias_Catalogo_Principal::INNER, [
    "cmarp_id" => 'subca_marca'
]);
$consultaSubCategorias = Sub_Categorias::SelectJoin(
    [
        "subca_cate" => $_POST["categoria"],
        "subca_prin" => SI
    ],
    "cmarp.*",
    [
        SubCategorias_Catalogo_Principal::class
    ]
);

if (!empty($consultaSubCategorias)) {
?>
    <script type="application/javascript">
        document.getElementById('mensaje').style.display = "none";
        document.getElementById('subCategoria-container').style.display = "block";
    </script>
    <?php
    foreach ($consultaSubCategorias as $datosSubCategorias) {

        $nombreEmpresa = '';
        if ($_SESSION["datosUsuarioActual"]['usr_tipo'] == DEV) {

            $empresa = Clientes_Admin::Select([
                'cliAdmi_id' => $datosSubCategorias['cmarp_id_empresa']
            ])->fetch(PDO::FETCH_ASSOC);
            $nombreEmpresa = "[" . $empresa['cliAdmi_nombre'] . "]";
        }
        $selected = '';
        if (!empty($_POST["subCategoria"]) && $_POST["subCategoria"] == $datosSubCategorias['cmarp_id']) {
            $selected = 'selected';
        }

        echo '<option value="' . $datosSubCategorias['cmarp_id'] . '" ' . $selected . '>' . $datosSubCategorias['cmarp_nombre'] . $nombreEmpresa . '</option>';
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
