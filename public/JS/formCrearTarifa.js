$(document).ready(function () {
    // Valor por defecto
    $(".fibra").show();
    $(".minutos").hide();
    $(".gb").hide();
    $(".tv").hide();

    // Al cargar la página, ajustar required
    $("#velocidad").prop("required", true);
    $("#minutos, #gigas").prop("required", false);

    $('#tipo').on('change', function () {
        let tipo = $(this).val();
        // Oculta y quita required de todos
        $(".fibra, .minutos, .gb, .tv").hide();
        $("#velocidad, #minutos, #gigas").prop("required", false);

        if (tipo === "fibra") {
            $(".fibra").show();
            $("#velocidad").prop("required", true);
        }
        if (tipo === "llamadas") {
            $(".minutos").show();
            $("#minutos").prop("required", true);
        }
        if (tipo === "gb") {
            $(".gb").show();
            $("#gigas").prop("required", true);
        }
        if (tipo === "tv") {
            $(".tv").show();
            // No hay campos extra obligatorios para TV
        }
    });
});