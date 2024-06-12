// public/js/autocomplete.js

// Función para realizar la búsqueda de alimentos basada en la consulta del usuario
function buscarAlimentos(query) {
    // Realizar una solicitud AJAX al controlador Symfony para buscar alimentos
    $.ajax({
        url: '/buscar-alimentos',
        method: 'GET',
        data: { query: query },
        success: function(response) {
            // Actualizar el desplegable de autocompletado con los resultados de la búsqueda
            actualizarDesplegable(response);
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
}

// Función para actualizar el desplegable de autocompletado con los resultados de la búsqueda
function actualizarDesplegable(results) {
    // Eliminar elementos anteriores del desplegable
    $('#alimentos-autocompletado').empty();
    
    // Agregar nuevos elementos al desplegable con los resultados de la búsqueda
    results.forEach(function(result) {
        $('#alimentos-autocompletado').append('<option value="' + result.label + '">' + result.label + '</option>');
    });
}

// Evento que se activa al escribir en el campo de búsqueda de alimentos
$('#busqueda-alimentos').on('input', function() {
    var query = $(this).val();
    if (query.length >= 3) {
        // Realizar la búsqueda de alimentos solo si la longitud de la consulta es al menos 3 caracteres
        buscarAlimentos(query);
    } else {
        // Limpiar el desplegable de autocompletado si la longitud de la consulta es inferior a 3 caracteres
        $('#alimentos-autocompletado').empty();
    }
});
