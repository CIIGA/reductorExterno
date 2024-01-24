<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Libros Almacenados Offline</title>
</head>
<body>

<h2>Libros Almacenados Offline</h2>

<ul id="listaLibros"></ul>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Obtener la lista de libros almacenados en localStorage
    var librosGuardados = localStorage.getItem('libros') ? JSON.parse(localStorage.getItem('libros')) : [];

    // Mostrar los libros en la lista
    mostrarLibrosEnLista(librosGuardados);
});

// Función para mostrar los libros en la lista
function mostrarLibrosEnLista(libros) {
    var listaLibros = document.getElementById('listaLibros');

    // Limpiar la lista antes de agregar los nuevos elementos
    listaLibros.innerHTML = '';

    libros.forEach(function(libro) {
        var itemLista = document.createElement('li');
        itemLista.textContent = `Título: ${libro.titulo}, Autor: ${libro.autor}`;
        listaLibros.appendChild(itemLista);
    });
}
</script>

</body>
</html>
