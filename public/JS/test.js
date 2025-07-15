$(document).ready(function () {


    // Delegación: escucha todos los cambios en radios dentro de cada línea móvil
    $(document).on('change', 'input[name^="lineas"][name$="[conservar]"]', function () {
        const $linea = $(this).closest('.lineaMovil');

        if ($(this).val() === 'si') {
            $linea.find('.campo-numero').slideDown();
        } else {
            $linea.find('.campo-numero').slideUp();
            $linea.find('input[name^="lineas"][name$="[numero]"]').val('');
        }
    });



    let contadorLineas = $('.lineaMovil').length;

    $(document).on('click', '.añadir-linea', function () {
        $.ajax({
            url: urlLineaMovilPartial,
            type: 'GET',
            data: { index: contadorLineas },
            success: function (html) {
                $('#lineas-moviles').append(html);
                contadorLineas++;
            }
        });
    });


    //ACTULIZAR EL RESUMEN
    // Listeners para fibra
    $('input[name="tarifa_fibra"]').on('change', function () {
        actualizarResumenYPrecio();
    });
    // Listeners para TV
    $('input[name="tarifa_tv"]').on('change', function () {
        actualizarResumenYPrecio();
    });

    // Listeners para cualquier cambio en líneas móviles
    $(document).on('change', '.lineaMovil input, .lineaMovil select', function () {
        actualizarResumenYPrecio();
    });
    // También al añadir o eliminar líneas
    $(document).on('click', '.añadir-linea, .eliminar-linea', function () {
        setTimeout(actualizarResumenYPrecio, 100); // Espera a que el DOM se actualice
    });

    // Función para actualizar el resumen y el precio total
    function actualizarResumenYPrecio() {
        // Fibra
        let fibraSel = $('input[name="tarifa_fibra"]:checked');
        let resumenFibra = '';
        let precioFibra = 0;
        if (fibraSel.length && fibraSel.data('tipo') !== 'sin_fibra') {
            let velocidad = fibraSel.data('velocidad');
            let precio = fibraSel.data('precio');
            resumenFibra = `<b>Fibra:</b> ${velocidad} Mbps  - ${precio} €/mes`;
            precioFibra = parseFloat(precio) || 0;
        } else {
            resumenFibra = '<b>Fibra:</b> Sin fibra contratada';
        }
        $('#resumen-fibra').html(resumenFibra);

        // Móviles
        let resumenMoviles = '';
        let precioMoviles = 0;
        $('.lineaMovil').each(function(index) {
            let idx = $(this).data('index');
            // GB
            let gbInput = $(this).find(`input[name='lineas[${idx}][tarifa_gb]']:checked`);
            let gb = '';
            let precioGb = 0;
            if (gbInput.length) {
                let label = gbInput.next('label').text();
                gb = label.split('-')[0].trim(); // Solo el valor de GB
                let match = label.match(/([\d,.]+) €/);
                if (match) precioGb = parseFloat(match[1].replace(',', '.'));
            }
            // Llamadas
            let llamadasInput = $(this).find(`input[name='lineas[${idx}][tarifa_llamadas]']:checked`);
            let llamadas = '';
            let precioLlamadas = 0;
            if (llamadasInput.length) {
                let label = llamadasInput.next('label').text();
                llamadas = label.split('-')[0].trim(); // Solo el valor de minutos
                let match = label.match(/([\d,.]+) €/);
                if (match) precioLlamadas = parseFloat(match[1].replace(',', '.'));
            }
            precioMoviles += precioGb + precioLlamadas;
            resumenMoviles += `<div><b>Línea móvil #${index+1}:</b> ${gb || 'Sin GB'} | ${llamadas || 'Sin llamadas'} (${(precioGb+precioLlamadas).toFixed(2)} €/mes)</div>`;
        });
        $('#resumen-moviles').html(resumenMoviles || 'Sin líneas móviles');

        // TV
        let tvSel = $('input[name="tarifa_tv"]:checked');
        let resumenTv = '';
        let precioTv = 0;
        if (tvSel.length && tvSel.data('tipo') !== 'sin_tv') {
            let descripcion = tvSel.data('descripcion');
            let precio = tvSel.data('precio'); 
            resumenTv = `<b>TV:</b> ${descripcion} - ${precio} €/mes`;
            precioTv = parseFloat(precio) || 0;
        } else {
            resumenTv = '<b>TV:</b> Sin TV contratada';
        }
        $('#resumen-tv').html(resumenTv);

        // Precio total
        let total = precioFibra + precioMoviles + precioTv;
        $('#total-precio').text(total.toFixed(2));
    }

    // Inicializar resumen y precio
    actualizarResumenYPrecio();


});