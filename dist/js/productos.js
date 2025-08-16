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

function cargarImagen(tipo) {
    if (tipo.value == 'IMG') {
        var urlImg = document.getElementById('urlImg');
        if (urlImg) { urlImg.value = ''; }
        document.getElementById('tipoFile').style.display = 'block';
        document.getElementById('tipoUrl').style.display = 'none';
    }

    if (tipo.value == 'URL') {
        document.getElementById('tipoFile').style.display = 'none';
        document.getElementById('tipoUrl').style.display = 'block';
    }
}

$(document).ready(function () {
    cargarImagen(document.getElementById('tipoImg'));
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