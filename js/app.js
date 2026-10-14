$(document).ready(function () {

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
        
        // cargarDocumentos();
    });

    // Mostrar el nombre del archivo seleccionado (Ya está hecho)
    $("input[type='file']").change(function () {
        let fileName = $(this).val().split('\\').pop();
        if (fileName) {
            $("#nombreArchivoSeleccionado").text("Archivo seleccionado: " + fileName);
        }
    });

    // ==========================================
    // LÓGICA DE ENVÍO DE FORMULARIO 
    // ==========================================
    $("#formDocumento").on("submit", function (e) {
        e.preventDefault(); // Evita que la página se recargue


        
        alert("Aquí el Compañero 3 debe programar el envío con AJAX");
    });

    // ==========================================
    // LÓGICA DE LECTURA DE TABLA 
    // ==========================================
    function cargarDocumentos() {
        
        
    }
});