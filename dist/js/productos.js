$(document).ready(function () {
    const url = new URL(window.location.href);
    const idProducto = url.searchParams.get("id");
    $("#productos-select").select2({
        placeholder: "Escoja los productos relacionados",
        multiple: true,
        minimumInputLength: 3,
        ajax: {
            type: "GET",
            url: "../../../ajax/ajax-buscar-productos.php",
            dataType: "json",
            data: function (params) {
                var extra = {};
                if (idProducto) {
                    extra.idProducto = idProducto;
                }
                return $.extend({
                    term: params.term
                }, extra);
            },
            processResults: function (items) {
                return {
                    results: items.map(function (item) {
                        return {
                            id: item.id,
                            text: item.text,
                        };
                    })
                };
            }
        }
    });
});

function habilitarVariacion() {
    var prodVariacion = document.getElementById("prodVariacion");
    var variacion = document.getElementById("variacion");
    const tallasContainer = document.getElementById("tallas-container");
    const inputReferencia = document.getElementById("inputReferencia");
    const referencia = inputReferencia.value || '';

    if (prodVariacion.checked) {
        variacion.style.display = "block";
        const refQuemada = document.getElementById("refQuemada");
        refQuemada.value = referencia;
    } else {
        variacion.style.display = "none";
        tallasContainer.innerHTML = `
        <div class="row mb-2">
            <div class="col-md-1"><input type="text" name="tallas[]" placeholder="Talla" class="form-control" /></div>
            <div class="col-md-1">
                <select name="colores[]" data-placeholder="1º color" class="form-control select2" style="width: 100%;">
                <option value="">1º color</option>
                <option value="#000000">Negro</option>
                <option value="#696969">Gris</option>
                <option value="#FFFFFF">Blanco</option>
                <option value="#FF0000">Rojo</option>
                <option value="#FFA500">Naranja</option>
                <option value="#FFFF00">Amarillo</option>
                <option value="#008000">Verde</option>
                <option value="#0000FF">Azul</option>
                <option value="#800080">Morado</option>
                <option value="#8A2BE2">Violeta</option>
                <option value="#A52A2A">Marrón</option>
                <option value="#D2691E">Chocolate</option>
                <option value="#F5DEB3">Beige</option>
                <option value="#FFC0CB">Rosa</option>
                </select>
            </div>
            <div class="col-md-1">
                <select name="colores2[]" data-placeholder="2º color (Opcional)" class="form-control select2" style="width: 100%;">
                <option value="">2º color (Opcional)</option>
                <option value="#000000">Negro</option>
                <option value="#696969">Gris</option>
                <option value="#FFFFFF">Blanco</option>
                <option value="#FF0000">Rojo</option>
                <option value="#FFA500">Naranja</option>
                <option value="#FFFF00">Amarillo</option>
                <option value="#008000">Verde</option>
                <option value="#0000FF">Azul</option>
                <option value="#800080">Morado</option>
                <option value="#8A2BE2">Violeta</option>
                <option value="#A52A2A">Marrón</option>
                <option value="#D2691E">Chocolate</option>
                <option value="#F5DEB3">Beige</option>
                <option value="#FFC0CB">Rosa</option>
                </select>
            </div>
            <div class="col-md-1"><input type="number" name="stocks[]" placeholder="Stock" class="form-control" /></div>
            <div class="col-md-3"><input type="text" name="referencias[]" id="refQuemada" placeholder="Referencia" class="form-control" value="${referencia}" /></div>
            <div class="col-md-3"><input type="text" name="codEan[]" placeholder="EAN" class="form-control" /></div>
            <div class="col-md-1"><button type="button" class="btn btn-success" onclick="agregarVariacion()">+</button></div>
        </div>`;
    }
    $('.select2').select2()
}

function agregarVariacion() {
    const inputReferencia = document.getElementById("inputReferencia");
    const referencia = inputReferencia.value || '';
    const container = document.getElementById("tallas-container");
    const div = document.createElement("div");
    div.classList.add("form-group", "row", "mt-2");
    div.innerHTML = `
                        <div class="col-md-1"><input type="text" name="tallas[]" placeholder="Talla" class="form-control" /></div>
                        <div class="col-md-1">
                        <select name="colores[]" data-placeholder="1º color" class="form-control select2" style="width: 100%;">
                            <option value="">1º color</option>
                            <option value="#000000">Negro</option>
                            <option value="#696969">Gris</option>
                            <option value="#FFFFFF">Blanco</option>
                            <option value="#FF0000">Rojo</option>
                            <option value="#FFA500">Naranja</option>
                            <option value="#FFFF00">Amarillo</option>
                            <option value="#008000">Verde</option>
                            <option value="#0000FF">Azul</option>
                            <option value="#800080">Morado</option>
                            <option value="#8A2BE2">Violeta</option>
                            <option value="#A52A2A">Marrón</option>
                            <option value="#D2691E">Chocolate</option>
                            <option value="#F5DEB3">Beige</option>
                            <option value="#FFC0CB">Rosa</option>
                        </select>
                        </div>
                        <div class="col-md-1">
                        <select name="colores2[]" data-placeholder="2º color (Opcional)" class="form-control select2" style="width: 100%;">
                            <option value="">2º color (Opcional)</option>
                            <option value="#000000">Negro</option>
                            <option value="#696969">Gris</option>
                            <option value="#FFFFFF">Blanco</option>
                            <option value="#FF0000">Rojo</option>
                            <option value="#FFA500">Naranja</option>
                            <option value="#FFFF00">Amarillo</option>
                            <option value="#008000">Verde</option>
                            <option value="#0000FF">Azul</option>
                            <option value="#800080">Morado</option>
                            <option value="#8A2BE2">Violeta</option>
                            <option value="#A52A2A">Marrón</option>
                            <option value="#D2691E">Chocolate</option>
                            <option value="#F5DEB3">Beige</option>
                            <option value="#FFC0CB">Rosa</option>
                        </select>
                        </div>
                        <div class="col-md-1"><input type="number" name="stocks[]" placeholder="Stock" class="form-control" /></div>
                        <div class="col-md-3"><input type="text" name="referencias[]" placeholder="Referencia" class="form-control" value="${referencia}" /></div>
                        <div class="col-md-3"><input type="text" name="codEan[]" placeholder="EAN" class="form-control" /></div>
                        <div class="col-md-1"><button type="button" class="btn btn-danger" onclick="this.closest('.row').remove()">-</button></div>
                        `;
    container.appendChild(div);
    $('.select2').select2()
}

function agregarOtraEspecificacion() {
    const contenedor = document.getElementById("otras-especificaciones-container");
    const nuevaFila = document.createElement("div");
    nuevaFila.classList.add("row", "mb-2");
    nuevaFila.innerHTML = `
                            <div class="col-md-5"><input type="text" class="form-control" placeholder="Etiqueta" name="otras_labels[]"></div>
                            <div class="col-md-5"><input type="text" class="form-control" placeholder="Valor" name="otras_values[]"></div>
                            <div class="col-md-2"><button type="button" class="btn btn-danger" onclick="this.closest('.row').remove()">-</button></div>
                        `;
    contenedor.appendChild(nuevaFila);
}