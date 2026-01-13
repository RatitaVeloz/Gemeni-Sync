�jQuery(document).ready(function ($) {
    const sliders = document.querySelectorAll('.ocean-price-slider');

    // Si no hay sliders en esta página, salir
    if (sliders.length === 0) return;

    sliders.forEach(function (slider) {
        // Obtener datos guardados en atributos data-
        const minPrice = parseInt(slider.dataset.min); // Min DB
        const maxPrice = parseInt(slider.dataset.max); // Max DB
        const startMin = parseInt(slider.dataset.startMin); // Selección actual Min
        const startMax = parseInt(slider.dataset.startMax); // Selección actual Max

        // Inicializar noUiSlider
        noUiSlider.create(slider, {
            start: [startMin, startMax], // Valores iniciales
            connect: true, // Color entre los handles
            range: {
                'min': minPrice,
                'max': maxPrice
            },
            step: 1, // Pasos de $1
            format: {
                to: function (value) {
                    return parseInt(value);
                },
                from: function (value) {
                    return parseInt(value);
                }
            }
        });

        // Buscar elementos relacionados dentro del mismo contenedor padre
        // Asumimos que el slider y los inputs están dentro de un .filter-group
        const container = slider.closest('.filter-group');
        const displayValues = container.querySelector('.price-display-values');
        const inputMin = container.querySelector('.input-price-min');
        const inputMax = container.querySelector('.input-price-max');

        // Evento al mover el slider
        slider.noUiSlider.on('update', function (values, handle) {
            // Actualizar inputs ocultos
            if (inputMin) inputMin.value = values[0];
            if (inputMax) inputMax.value = values[1];

            // Actualizar texto visible
            if (displayValues) {
                displayValues.innerHTML = '$' + values[0] + ' - $' + values[1];
            }
        });
    });
});
�*cascade082_file:///c:/xampp/htdocs/ocean/wp-content/themes/hello-elementor-child/assets/js/price-slider.js