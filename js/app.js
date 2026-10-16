$(document).ready(function () {
cargarDocumentos();
    // ==========================================
    // LÓGICA DE NAVEGACIÓN (Ya está hecha, no tocar)
    // ==========================================
    $("#btnVerFormulario, #btnNuevoDoc").click(function () {
        $("#vistaDashboard").addClass("hidden");
        $("#vistaFormulario").removeClass("hidden");
        $(".nav-btn").removeClass("active");
        $("#btnVerFormulario").addClass("active");
    });

    $("#btnVerTabla").click(function () {
        $("#vistaFormulario").addClass("hidden");
        $("#vistaDashboard").removeClass("hidden");
        $(".nav-btn").removeClass("active");
        $("#btnVerTabla").addClass("active");
        
        cargarDocumentos();
    });

    // Mostrar el nombre del archivo seleccionado (Ya está hecho)
    $("input[type='file']").change(function () {
        let fileName = $(this).val().split('\\').pop();
        if (fileName) {
            $("#nombreArchivoSeleccionado").text("Archivo seleccionado: " + fileName);
        }
    });


    // ==========================================
    // LÓGICA DE EDICIÓN: Cargar datos al formulario
    // ==========================================
    $(document).on("click", ".btn-editar", function () {
        let id = $(this).data("id");

        $.ajax({
            url: 'php/obtener_documento_por_id.php',
            type: 'GET',
            data: { id: id },
            dataType: 'json',
            success: function (doc) {
                if (doc) {
                    $("#id_documento").val(doc.id_documento);
                    $("input[name='no_oficio']").val(doc.no_oficio);
                    $("input[name='fecha']").val(doc.fecha);
                    $("textarea[name='asunto'], input[name='asunto']").val(doc.asunto);
                    $("input[name='remitente']").val(doc.remitente);
                    $("input[name='destinatario']").val(doc.destinatario);
                    $("select[name='estatus']").val(doc.estatus);

                    $("#vistaDashboard").addClass("hidden");
                    $("#vistaFormulario").removeClass("hidden");
                    $(".nav-btn").removeClass("active");
                    $("#btnVerFormulario").addClass("active");
                } else {
                    alert("No se encontró la información del documento.");
                }
            },
            error: function (xhr, status, error) {
                console.error("Error al obtener el documento para editar:", error);
            }
        });
    });

    $("#btnVerFormulario, #btnNuevoDoc").click(function () {
        $("#formDocumento")[0].reset();
        $("#id_documento").val(""); 
        $("#nombreArchivoSeleccionado").text("");
        $("#vistaDashboard").addClass("hidden");
        $("#vistaFormulario").removeClass("hidden");
        $(".nav-btn").removeClass("active");
        $("#btnVerFormulario").addClass("active");
    });

    // ==========================================
    // LÓGICA DE ENVÍO (CREAR o ACTUALIZAR)
    // ==========================================
    $("#formDocumento").off("submit").on("submit", function (e) {
        e.preventDefault(); 

        let formData = new FormData(this);
        let idDoc = $("#id_documento").val();
        let urlDestino = idDoc ? 'php/actualizar_documento.php' : 'php/guardar_documento.php';

        let btnSubmit = $("#btnSubmit");
        btnSubmit.prop("disabled", true);

        $.ajax({
            url: urlDestino,
            type: 'POST',
            data: formData,
            contentType: false, 
            processData: false, 
            dataType: 'json',
            success: function (response) {
                btnSubmit.prop("disabled", false);
                if (response.status === 'success') {
                    alert(response.message);
                    $("#formDocumento")[0].reset(); 
                    $("#id_documento").val(""); 
                    $("#nombreArchivoSeleccionado").text(""); 
                    
                    $("#vistaFormulario").addClass("hidden");
                    $("#vistaDashboard").removeClass("hidden");
                    $(".nav-btn").removeClass("active");
                    $("#btnVerTabla").addClass("active");
                    cargarDocumentos();
                } else {
                    alert("Error: " + response.message);
                }
            },
            error: function (xhr, status, error) {
                btnSubmit.prop("disabled", false);
                console.error("XHR Response:", xhr.responseText);
                alert("Ocurrió un error en el servidor. Revisa la consola.");
            }
        });
    });

   
    
    // ==========================================
    // LÓGICA DE LECTURA DE TABLA 
    // ==========================================
    function cargarDocumentos() {
        $.ajax({
            url: 'php/obtener_documentos.php',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                let tbody = $("#tablaDocumentosBody"); 
                tbody.empty(); 

                if (data.length === 0) {
                    tbody.append('<tr><td colspan="7" class="text-center">No hay documentos registrados.</td></tr>');
                    return;
                }

                data.forEach(function (doc) {
                    
                    let fila = `
                        <tr data-estatus="${doc.estatus}">
                            <td>${doc.no_oficio}</td>
                            <td>${doc.fecha}</td>
                            <td>${doc.asunto}</td>
                            <td>${doc.remitente}</td>
                            <td>${doc.destinatario}</td>
                            <td>${doc.estatus}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-info btn-editar" data-id="${doc.id_documento}" title="Editar">📝</button>
                                <a href="uploads/${doc.archivo_pdf}" target="_blank" class="btn btn-sm btn-light" title="Ver">👁️</a>
                                <a href="uploads/${doc.archivo_pdf}" download="${doc.archivo_pdf}" class="btn btn-sm btn-light" title="Descargar">📥</a>
                            </td>
                        </tr>
                    `;
                    tbody.append(fila);
                });
            },
            error: function (xhr, status, error) {
                console.error("Error al cargar los documentos:", error);
            }
        });
    }

    // ==========================================
    // LÓGICA DE BUSCADOR Y FILTROS EN TIEMPO REAL
    // ==========================================
    $("#buscarTexto, #filtroEstatus").on("keyup change", function () {
        let textoBusqueda = $("#buscarTexto").val().toLowerCase().trim();
        let estatusSeleccionado = $("#filtroEstatus").val();

        $("#tablaDocumentosBody tr").each(function () {
            let fila = $(this);
            
            if (fila.find("td").length === 1) return;

            let contenidoFila = fila.text().toLowerCase();
            let estatusFila = fila.data("estatus");

            let coincideTexto = contenidoFila.includes(textoBusqueda);
            
            let coincideEstatus = (estatusSeleccionado === "" || estatusFila === estatusSeleccionado);

            if (coincideTexto && coincideEstatus) {
                fila.show();
            } else {
                fila.hide();
            }
        });
    });
});