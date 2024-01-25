<?php
session_start();
if (isset($_SESSION['AspUsr'])) {
    require "include/cnx.php";
    $plz = $_SESSION['dataB'];
    $idUsr = $_SESSION['AspUsr'];
    $cnxPlz = conexion('implementtaTijuanaA');

    $Countcu = "select COUNT(ctas.Cuenta) as numReg from asignacionReductorExterno as ctas
  inner join implementta on implementta.Cuenta=ctas.Cuenta";
    $Countcuen = sqlsrv_query($cnxPlz, $Countcu);
    $Countctas = sqlsrv_fetch_array($Countcuen);
    //******************************************************************
    $ne = "select UserName,Nombre from AspNetUsers
where Id='$idUsr'";
    $netU = sqlsrv_query($cnxPlz, $ne);
    $usuario = sqlsrv_fetch_array($netU);
    //******************************************************************

    $sql_tareas = sqlsrv_query($cnxPlz, "select idTarea,DescripcionTarea from CatalogoTareas where idTarea in ('68','69')");
    $sql_servicios = sqlsrv_query($cnxPlz, "select * from catalogoTipoServicio");
    $sql_estatusToma = sqlsrv_query($cnxPlz, " select * from catalogoEstatusToma");
    $sql_tipoToma = sqlsrv_query($cnxPlz, "select * from catalogoTipoToma");

?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Supervision</title>
        <link rel="icon" href="img/implementtaIcon.png">
        <link rel="stylesheet" href="include/fontawesome6/css/all.min.css">
        <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="js/alerta.js"></script>
        <style>
            body {
                background-image: url(img/back.jpg);
                background-repeat: repeat;
                background-size: 100%;
                /*        background-attachment: fixed;*/
                overflow-x: hidden;
                /* ocultar scrolBar horizontal*/
                /* overflow-y: hidden;  ocultar scrolBar horizontal*/
            }

            body {
                font-family: sans-serif;
                font-style: normal;
                font-weight: normal;
                width: 100%;
                height: 100%;
                margin-top: -1%;
                padding-top: 0px;
            }

            .oculto {
                display: none;
            }
            .footer {
              margin-top: auto;
              width: 100%;
            }
       </style>
        </style>

    </head>

    <body>
        <?php
        if (isset($_SESSION['error_vacio'])) {
            echo "<script>
    window.onload = function() {
        mostrarSweetAlert('error', 'Error', '" . htmlspecialchars($_SESSION['error_vacio']) . "');
    };
</script>";
            unset($_SESSION['error_vacio']);
        }
        if (isset($_SESSION['registro_success'])) {
            echo "<script>
    window.onload = function() {
        mostrarSweetAlert('success', 'Registro Exitoso!', '" . htmlspecialchars($_SESSION['registro_success']) . "');
    };
</script>";
            unset($_SESSION['registro_success']);
        }
        if (isset($_SESSION['foto_error'])) {
            echo "<script>
    window.onload = function() {
        mostrarSweetAlert('error', 'Error', '" . htmlspecialchars($_SESSION['foto_error']) . "');
    };
</script>";
            unset($_SESSION['foto_error']);
        }
        if (isset($_SESSION['registro_error'])) {
            echo "<script>
    window.onload = function() {
        mostrarSweetAlert('error', 'Error', '" . htmlspecialchars($_SESSION['registro_error']) . "');
    };
</script>";
            unset($_SESSION['registro_error']);
        }
        ?>
        <nav class="navbar navbar-dark bg-dark">
            <a class="navbar-brand" href="#">
                <img src="img/logoImplementtaHorizontal.png" width="150" height="50" class="d-inline-block align-top" alt="">
            </a>
            <ul class="navbar-nav">

                <li class="nav-item">
                    <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i></a>
                </li>
            </ul>
        </nav>

        <div class="container padding">
            <br>
            <div style="text-align: center;">
                <h6 style="text-shadow: 0px 0px 2px #717171;"><i class="fas fa-user"></i> <?php echo $usuario['Nombre'] ?></h6>
            </div>
            <hr>


        </div>
        <div class="container mt-4">
            <form action="RegistrarReductor.php" method="post" enctype="multipart/form-data" onsubmit="return validarFormulario()">
                <!-- Input de texto -->
                <div class="form-group mb-3">
                    <label>Cuenta: <strong><?= $_SESSION['cuenta'] ?></strong></label>
                </div>

                <!-- Opción desplegable -->
                <div class="form-group mb-3">
                    <label for="opciones">Acción:*</label>
                    <select class="form-control" id="tarea" name="idTarea" required autofocus>
                        <option value="">--seleccione una opción</option>
                        <?php while ($tareas = sqlsrv_fetch_array($sql_tareas)) { ?>
                            <option value="<?= $tareas['idTarea'] ?>"><?= utf8_encode($tareas['DescripcionTarea']) ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label>Descripcion de acción:*</label>
                    <select class="form-control" id="descTarea" name="iddescripciontarea" required>

                    </select>
                </div>

                <div class="form-group mb-3" id="divNiple">
                    <label>Niple:*</label>
                    <select class="form-control" id="niple" name="id_niple">
                        <option value=""></option>
                    </select>
                </div>

                <div class="form-group mb-3" id="divObservaciones">
                    <label>Observaciones:*</label>
                    <select class="form-control" id="observaciones" name="idCatalogoreductores">
                        <option value=""></option>
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label>Lectura:</label>
                    <input type="text" class="form-control" id="lectura" name="lectura" placeholder="Ingresa la lectura">
                </div>

                <div class="form-group mb-3">
                    <label>Tipo de servicio servicio:*</label>
                    <select class="form-control" name="idTipoServicio" required>
                        <option value="">--seleccione una opción</option>
                        <?php while ($servicios = sqlsrv_fetch_array($sql_servicios)) { ?>
                            <option value="<?= $servicios['idTipoServicio'] ?>"><?= utf8_encode($servicios['TipoServicio']) ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label>Estatus de toma:*</label>
                    <select class="form-control" id="estatusToma" name="idEstatusToma" required>
                        <option value="">--seleccione una opción</option>
                        <?php while ($estatusToma = sqlsrv_fetch_array($sql_estatusToma)) { ?>
                            <option value="<?= $estatusToma['idEstatusToma'] ?>"><?= utf8_encode($estatusToma['EstatusToma']) ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group mb-3" id="divTipoToma">
                    <label>Tipo de toma:*</label>
                    <select class="form-control" id="tipoToma" name="idTipoToma">
                        <option value="">--seleccione una opción</option>
                        <?php while ($tipoToma = sqlsrv_fetch_array($sql_tipoToma)) { ?>
                            <option value="<?= $tipoToma['idTipoToma'] ?>"><?= utf8_encode($tipoToma['TipoToma']) ?></option>
                        <?php } ?>
                    </select>
                </div>

                <!-- Área de texto -->
                <div class="form-group mb-3">
                    <label>Conclusiones:</label>
                    <textarea class="form-control" name="observaciones" rows="4" placeholder="Escribe tus conclusiones"></textarea>
                </div>

                <div class="form-group mb-3">
                    <label>Fecha promesa de pago:</label>
                    <input type="date" class="form-control" name="FechaPromesaPago">
                </div>

                <div class="form-group mb-3">
                    <label>Próxima revisión:</label>
                    <input type="date" class="form-control" name="FechaVencimiento">
                </div>

                <h3 class="text-center">Evidencia fotográfica</h3>

                <div class="d-flex justify-content-center mb-3">
                    <label for="dz1" class="btn btn-info mr-2">Tomar foto Evidencia</label>
                    <input id="dz1" type="file" name="foto1" accept="image/*" capture="environment" class="oculto">
                </div>
                <div class="alig-items-center text-center mb-3">
                    <div id="preview1" style="height: 120px;">
                        <img src="img/sinFoto.png" height="100px" width="100px" alt="Foto 1">
                    </div>
                </div>

                <div class="d-flex justify-content-center mb-3">
                    <label for="dz2" class="btn btn-info mr-2">Tomar foto del predio</label>
                    <input id="dz2" type="file" name="foto2" accept="image/*" capture="environment" class="oculto">
                </div>
                <div class="alig-items-center text-center mb-3">
                    <div id="preview2" style="height: 120px;">
                        <img src="img/sinFoto.png" height="100px" width="100px" alt="Foto 2">
                    </div>
                </div>
                <!-- Campo de entrada para latitud -->
                <input type="text" id="latitud" name="latitud" placeholder="Latitud" hidden>

                <!-- Campo de entrada para longitud -->
                <input type="text" id="longitud" name="longitud" placeholder="Longitud" hidden>

                <hr>
                <!-- Botón de envío -->
                <div class="d-flex justify-content-center mb-3">
                    <button type="submit" class="btn btn-warning btn-lg">Finalizar</button>
                </div>
                <div class="d-flex justify-content-center mb-3">
                    <a href="verificar.php" class="btn btn-dark btn-sm"><i class="fas fa-angle-left"></i> Regresar</a>
                </div>

            </form>
        </div>
        
       
        <br><br>
        <!--*************************INICIO FOOTER***********************************************************************-->
        <footer class="text-center footer">
            <div class="container">
                <span class="navbar-text" style="font-size:11px;font-weigth:normal;color: #7a7a7a;">Implementta <i class="far fa-registered"></i><br>
                    Estrategas de México <i class="far fa-registered"></i><br>
                    Centro de Inteligencia Informática y Geografía Aplicada CIIGA
                    <hr style="width:105%;border-color:#7a7a7a;">
                    Creado y diseñado por © <?php echo date('Y') ?> Estrategas de México
                </span>
            </div>
        </footer>
        <br><br><br><br>
        <!--***********************************FIN FOOTER****************************************************************-->
    </body>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="js/fotos.js"></script>
    <script>
        function validarFormulario() {
            var foto1 = document.getElementById('dz1').value;
            var foto2 = document.getElementById('dz2').value;

            // Validar que los campos no estén vacíos
            if (foto1 === '' || foto2 === '') {
                Swal.fire({
                    icon: "error",
                    title: "Datos incompletos",
                    text: "Toma las fotos que se te pide.",
                    timer: 2000, // Duración en milisegundos (2 segundos en este caso)
                    showConfirmButton: false // Ocultar el botón de confirmación
                });
                return false; // Evita que el formulario se envíe
            }

            // Otras validaciones según tus necesidades

            // Si la validación es exitosa, permite que el formulario se envíe
            return true;
        }
    </script>
    <script>
        $(document).ready(function() {
            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        // Obtener latitud y longitud
                        var latitud = position.coords.latitude;
                        var longitud = position.coords.longitude;

                        // Mostrar los valores en los campos de entrada
                        document.getElementById("latitud").value = latitud;
                        document.getElementById("longitud").value = longitud;
                    },
                    function(error) {
                        // Manejar errores de geolocalización
                        console.error("Error al obtener la ubicación:", error.message);
                    }
                );
            } else {
                alert("Tu navegador no soporta la geolocalización.");
            }
        });
    </script>
    <script>
        // Función para llenar el segundo ComboBox con datos de la base de datos
        function llenarDescTarea(idTarea) {
            $.ajax({
                url: 'obtenerDatos/obtener_descTarea.php',
                type: 'GET',
                data: {
                    idTarea: idTarea
                },
                success: function(data) {
                    if (data.trim() === "") {
                        // Si la respuesta está vacía, agregar la opción "Sin datos"
                        $('#descTarea').html("<option value=''>Sin descripciones</option>");
                    } else {
                        // Si hay datos, llenar el segundo ComboBox con la respuesta del servidor
                        $('#descTarea').html(data);
                    }
                }
            });
        }

        // Manejar cambios en el primer ComboBox
        $('#tarea').on('change', function() {
            var idTarea = $(this).val();
            llenarDescTarea(idTarea);
        });
    </script>
    <script>
        $(document).ready(function() {
            // Selecciona el primer select
            var descTarea = $("#descTarea");

            // Selecciona el segundo select
            var divNiple = $("#divNiple");

            // Oculta el segundo select al cargar la página
            divNiple.hide();

            // Selecciona el div del select de observaciones
            var divObservaciones = $("#divObservaciones");
            divObservaciones.hide();

            descTarea.change(function() {
                // Obtén el valor seleccionado
                var descTareaValue = $(this).val();

                // Si el valor seleccionado es específico, muestra el segundo select, de lo contrario, ocúltalo
                if (descTareaValue === "1") {
                    divNiple.show();

                } else {
                    divNiple.hide();
                    if (descTareaValue === "2") {
                        divObservaciones.show();

                    } else {
                        divObservaciones.hide();
                    }
                }



            });

            // Selecciona el select de estatus 
            var estatusToma = $("#estatusToma");

            // Selecciona el div de tipoToma
            var divTipoToma = $("#divTipoToma");

            // Oculta divEstatus
            divTipoToma.hide();

            estatusToma.change(function() {
                // Obtén el valor seleccionado
                var estatusTomaValue = $(this).val();

                // Si el valor seleccionado es específico, muestra el segundo select, de lo contrario, ocúltalo
                if (estatusTomaValue === "2") {
                    divTipoToma.show();

                } else {
                    divTipoToma.hide();
                }



            });

            function llenarNiple() {
                $.ajax({
                    url: 'obtenerDatos/obtener_niple.php',
                    type: 'GET',
                    success: function(data) {
                        if (data.trim() === "") {
                            // Si la respuesta está vacía, agregar la opción "Sin datos"
                            $('#niple').html("<option value=''>Sin descripciones</option>");
                        } else {
                            // Si hay datos, llenar el segundo ComboBox con la respuesta del servidor
                            $('#niple').html(data);
                        }
                    }
                });
            }

            function llenarObservaciones() {
                $.ajax({
                    url: 'obtenerDatos/obtener_observaciones.php',
                    type: 'GET',
                    success: function(data) {
                        if (data.trim() === "") {
                            // Si la respuesta está vacía, agregar la opción "Sin datos"
                            $('#observaciones').html("<option value=''>Sin observaciones</option>");
                        } else {
                            // Si hay datos, llenar el segundo ComboBox con la respuesta del servidor
                            $('#observaciones').html(data);
                        }
                    }
                });
            }

            // Manejar cambios en el primer ComboBox
            $('#descTarea').on('change', function() {
                var descTareaValue = $("#descTarea").val();
                if (descTareaValue === '1') {
                    llenarNiple();
                }
                if (descTareaValue === '2') {
                    llenarObservaciones();
                }

            });



        });
    </script>

    </html>
<?php
} else {
    echo '<meta http-equiv="refresh" content="0,url=logout.php">';
}
?>