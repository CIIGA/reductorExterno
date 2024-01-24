<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
  <title>Card Colapsable con Ícono Dinámico</title>
</head>
<body>

<div class="container mt-5">
  <div class="card">
    <div class="card-header" id="headingOne">
      <h5 class="mb-0">
        Título de la Card
        <i class="fas fa-minus float-right icon-collapse" data-target="#collapseOne"></i>
      </h5>
    </div>

    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
      <div class="card-body">
        Contenido de la Card
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script>
  // Agregar función de colapso al ícono
  $(document).ready(function() {
    $('.icon-collapse').click(function() {
      var target = $(this).data('target');
      $(target).collapse('toggle');
    });

    // Cambiar el ícono cuando se completa el colapso/despliegue
    $('.card').on('shown.bs.collapse', function () {
      $('.icon-collapse').removeClass('fa-plus').addClass('fa-minus');
    }).on('hidden.bs.collapse', function () {
      $('.icon-collapse').removeClass('fa-minus').addClass('fa-plus');
    });
  });
</script>

</body>
</html>
