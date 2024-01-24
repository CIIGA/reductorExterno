<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Biblioteca</title>
</head>
<body>

<h2>Agregar Libro a la Biblioteca</h2>

<form id="formularioLibro">
    <label for="titulo">Título:</label>
    <input type="text" id="titulo" name="titulo" required>

    <label for="autor">Autor:</label>
    <input type="text" id="autor" name="autor" required>

    <button type="button" onclick="agregarLibroOffline()">Agregar Libro (Offline)</button>
</form>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Abrir o crear la base de datos al cargar la página
    var request = indexedDB.open('biblioteca', 1);

    request.onupgradeneeded = function(event) {
        var db = event.target.result;
        db.createObjectStore('libros', { keyPath: 'id' });
    };

    request.onsuccess = function(event) {
        var db = event.target.result;

        // Agregar un evento al formulario para manejar la adición offline
        document.getElementById('formularioLibro').addEventListener('submit', function (event) {
            event.preventDefault();

            var titulo = document.getElementById('titulo').value;
            var autor = document.getElementById('autor').value;

            agregarLibro(db, { id: Date.now(), titulo: titulo, autor: autor });
            limpiarFormulario();
        });
    };

    request.onerror = function(event) {
        console.error('Error al abrir la base de datos:', event.target.error);
    };
});

function agregarLibroOffline() {
    var titulo = document.getElementById('titulo').value;
    var autor = document.getElementById('autor').value;

    // Obtener la lista actual de libros en localStorage (si existe)
    var librosGuardados = localStorage.getItem('libros') ? JSON.parse(localStorage.getItem('libros')) : [];

    // Agregar el nuevo libro a la lista
    var nuevoLibro = { id: Date.now(), titulo: titulo, autor: autor };
    librosGuardados.push(nuevoLibro);

    // Guardar la lista actualizada en localStorage
    localStorage.setItem('libros', JSON.stringify(librosGuardados));

    // Limpiar el formulario
    limpiarFormulario();
}



function limpiarFormulario() {
    document.getElementById('titulo').value = '';
    document.getElementById('autor').value = '';
}
</script>

</body>
</html>
