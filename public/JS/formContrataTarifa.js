$(document).ready(function () {
    // Función para crear una nueva línea móvil
    function crearLineaMovil() {
        let index = $('#moviles-container .linea-movil').length + 1;
        let $plantilla = $('#plantilla-linea-movil .linea-movil').clone();
        // Asignar el mismo name para todos los radios de datos y llamadas de esta línea
        $plantilla.find('input[type="radio"]').each(function () {
            let name = $(this).attr('name');
            if (name === 'tarifa_gb_plantilla') {
                $(this).attr('name', 'tarifa_gb_linea_' + index);
            } else if (name === 'tarifa_llamadas_plantilla') {
                $(this).attr('name', 'tarifa_llamadas_linea_' + index);
            } else if (name === 'conservar_numero_linea_plantilla') {
                $(this).attr('name', 'conservar_numero_linea_' + index);
                // Cambiar también el id y el for del label para unicidad
                if ($(this).val() === 'si') {
                    $(this).attr('id', 'conservar_si_linea_' + index);
                    $(this).siblings('label[for="conservar_si_plantilla"]').attr('for', 'conservar_si_linea_' + index);
                } else if ($(this).val() === 'no') {
                    $(this).attr('id', 'conservar_no_linea_' + index);
                    $(this).siblings('label[for="conservar_no_plantilla"]').attr('for', 'conservar_no_linea_' + index);
                }
            }
            $(this).prop('checked', false);
        });
        // Cambiar name e id del input de número antiguo
        $plantilla.find('input[name="numero_antiguo_linea_plantilla"]').each(function () {
            $(this).attr('name', 'numero_antiguo_linea_' + index);
            $(this).attr('id', 'numero_antiguo_linea_' + index);
            $(this).val('');
            $(this).closest('#campo-numero-antiguo-plantilla').hide();
        });
        // Asignar listener para eliminar
        $plantilla.find('.eliminar-linea').on('click', function () {
            $(this).closest('.linea-movil').remove();
            actualizarNumeracionLineas();
            actualizarResumenYPrecio();
        });
        // Asignar listeners para radios
        $plantilla.find('input[type="radio"]').on('change', function () {
            actualizarResumenYPrecio();
        });
        $('#moviles-container').append($plantilla);
        actualizarNumeracionLineas();
        actualizarResumenYPrecio();
    }

    // Función para actualizar la numeración de las líneas móviles
    function actualizarNumeracionLineas() {
        $('#moviles-container .linea-movil').each(function (i) {
            $(this).find('.num-linea').text(i + 1);
            // Actualizar los names de los radios para mantener la unicidad por línea
            $(this).find('input[type="radio"][name^="tarifa_gb_"]').attr('name', 'tarifa_gb_linea_' + (i + 1));
            $(this).find('input[type="radio"][name^="tarifa_llamadas_"]').attr('name', 'tarifa_llamadas_linea_' + (i + 1));
        });
    }

    // Inicializar con una línea móvil
    crearLineaMovil();

    // Añadir nueva línea móvil
    $('#anadirLinea').on('click', function (e) {
        e.preventDefault();
        crearLineaMovil();
    });

    // Listeners para fibra
    $('input[name="tarifa_fibra"]').on('change', function () {
        actualizarResumenYPrecio();
    });
    // Listeners para TV
    $('input[name="tarifa_tv"]').on('change', function () {
        actualizarResumenYPrecio();
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
            let descripcion = fibraSel.data('descripcion');
            resumenFibra = `<b>Fibra:</b> ${velocidad} Mbps - ${descripcion} - ${precio} €/mes`;
            precioFibra = parseFloat(precio) || 0;
        } else {
            resumenFibra = '<b>Fibra:</b> Sin fibra contratada';
        }
        $('#resumen-fibra').html(resumenFibra);

        // Móviles
        let resumenMoviles = '';
        let totalMovil = 0;
        $('#moviles-container .linea-movil').each(function (i) {
            let gbSel = $(this).find('input[name="tarifa_gb_linea_' + (i + 1) + '"]:checked');
            let llamadasSel = $(this).find('input[name="tarifa_llamadas_linea_' + (i + 1) + '"]:checked');
            let linea = `<b>Línea ${i + 1}:</b> `;
            let precioGb = 0, precioLlamadas = 0;
            let datos = '', llamadas = '';
            if (gbSel.length) {
                datos = `${gbSel.data('gb')} GB`;
                precioGb = parseFloat(gbSel.data('precio')) || 0;
            }
            if (llamadasSel.length) {
                if (llamadasSel.data('minutos') < 0) {
                    llamadas = 'Minutos Ilimitados';
                } else {
                    llamadas = `${llamadasSel.data('minutos')} minutos`;
                }
                precioLlamadas = parseFloat(llamadasSel.data('precio')) || 0;
            }
            if (!datos && !llamadas) {
                linea += 'Sin datos ni llamadas seleccionados';
            } else {
                linea += datos;
                if (datos && llamadas) linea += ' - ';
                linea += llamadas;
                let precioLinea = precioGb + precioLlamadas;
                if (precioLinea > 0) linea += ` (${precioLinea.toFixed(2)} €/mes)`;
            }
            totalMovil += precioGb + precioLlamadas;
            resumenMoviles += linea + '<br>';
        });
        $('#resumen-moviles').html('<b>Móviles:</b><br>' + resumenMoviles);

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
        let total = precioFibra + totalMovil + precioTv;
        $('#total-precio').text(total.toFixed(2));
    }

    // Inicializar resumen y precio
    actualizarResumenYPrecio();

    // Función para resaltar la opción seleccionada SOLO con clases Bootstrap
    function resaltarOpcionBootstrap() {
        $(document).on('change', '.form-check-input[type=radio]', function () {
            var name = $(this).attr('name');
            $(this).closest('.linea-movil').find('.form-check-input[name="' + name + '"]').each(function () {
                $(this).closest('.tarifa-opcion').removeClass('border-primary bg-primary-subtle border-success bg-success-subtle border-warning bg-warning-subtle');
            });
            var $opcion = $(this).closest('.tarifa-opcion');
            var tipo = $opcion.data('tipo');
            if (tipo === 'fibra') {
                $opcion.addClass('border-primary bg-primary-subtle');
            } else if (tipo === 'gb') {
                $opcion.addClass('border-success bg-success-subtle');
            } else if (tipo === 'llamadas') {
                $opcion.addClass('border-success bg-success-subtle');
            } else if (tipo === 'tv') {
                $opcion.addClass('border-warning bg-warning-subtle');
            }
        });
    }
    // Mostrar/ocultar campo de número antiguo en portabilidad móvil
    $(document).on('change', '.conservar-numero', function () {
        var $linea = $(this).closest('.linea-movil');
        // Buscar el name único de este grupo
        var name = $(this).attr('name');
        var valor = $linea.find('.conservar-numero[name="' + name + '"]:checked').val();
        if (valor === 'si') {
            $linea.find('[id^="campo-numero-antiguo-"]').show();
        } else {
            $linea.find('[id^="campo-numero-antiguo-"]').hide();
            $linea.find('input[name^="numero_antiguo_linea_"]').val('');
        }
    });

    // Función para recolectar los datos del formulario y generar el JSON
    function recolectarDatosParaJson() {
        // 1. Dirección
        let direccion = {
            ciudad: $('#ciudad').val(),
            calle: $('#calle').val(),
            numero: $('#numero').val(),
            cp: $('#cp').val()
        };
        // 2. Fibra
        let fibraSel = $('input[name="tarifa_fibra"]:checked');
        let fibra = null;
        let precioFibra = 0;
        if (fibraSel.length && fibraSel.val() !== '0') {
            precioFibra = parseFloat(fibraSel.data('precio')) || 0;
            fibra = {
                id_tarifa: parseInt(fibraSel.val()),
                velocidad: fibraSel.data('velocidad'),
                precio: precioFibra
            };
        }
        // 3. TV
        let tvSel = $('input[name="tarifa_tv"]:checked');
        let tv = null;
        let precioTv = 0;
        if (tvSel.length && tvSel.val() !== '0') {
            precioTv = parseFloat(tvSel.data('precio')) || 0;
            tv = {
                id_tarifa: parseInt(tvSel.val()),
                tipo: tvSel.data('descripcion'),
                precio: precioTv
            };
        }
        // 4. Líneas móviles
        let lineas = [];
        let precioMovil = 0;
        $('#moviles-container .linea-movil').each(function (i) {
            let linea = {};
            // Portabilidad
            let conservar = $(this).find('input[name^="conservar_numero_linea_"]:checked').val();
            // Si conserva número, pedir teléfono y número antiguo
            if (conservar === 'si') {
                linea.telefono = $(this).find('input[name^="numero_antiguo_linea_"]').val();
            } else {
                
                // Generar un número de teléfono aleatorio (9 dígitos, empieza por 6 o 7)
                let prefijos = ['6', '7'];
                let telefonoAleatorio = prefijos[Math.floor(Math.random() * prefijos.length)];
                for (let i = 0; i < 8; i++) {
                    telefonoAleatorio += Math.floor(Math.random() * 10);
                }
                linea.telefono = telefonoAleatorio;

            }
            // Datos
            let gbSel = $(this).find('input[name^="tarifa_gb_linea_"]:checked');
            if (gbSel.length) {
                linea.id_tarifa = parseInt(gbSel.val());
                linea.gb = parseInt(gbSel.data('gb'));
                linea.precio = parseFloat(gbSel.data('precio')) || 0;
                precioMovil += linea.precio;
            }
            // Llamadas
            let llamadasSel = $(this).find('input[name^="tarifa_llamadas_linea_"]:checked');
            if (llamadasSel.length) {
                linea.llamadas = {
                    id_tarifa: parseInt(llamadasSel.val()),
                    minutos: parseInt(llamadasSel.data('minutos')),
                    precio: parseFloat(llamadasSel.data('precio')) || 0
                };
                precioMovil += linea.llamadas.precio;
            }
            lineas.push(linea);
        });
        // 5. Fecha de contratación (hoy)
        let fecha_contratacion = new Date().toISOString().slice(0, 10);
        // 6. Precio total
        let precio_total = precioFibra + precioTv + precioMovil;
        // 7. Montar el JSON final
        return {
            direccion: direccion,
            ...(fibra && { fibra }),
            movil: { lineas: lineas },
            ...(tv && { tv }),
            fecha_contratacion: fecha_contratacion,
            precio_total: precio_total
        };
    }

    // Antes de enviar el formulario, generar el JSON y ponerlo en el input oculto
    $('#form-contratar-tarifa').on('submit', function(e) {
        const datos = recolectarDatosParaJson();
        $('#json_tarifa').val(JSON.stringify(datos));
        // El formulario se enviará normalmente
    });
});