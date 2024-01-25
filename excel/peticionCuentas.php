<?php

session_start();
// $_SESSION['plz'] = 1027;
// unset($_SESSION['plz']);
$_SESSION['plazaBD'] = "implementtaTijuanaA";


$bd = '';
$nombrePlaza = 'Sin conexion';
// if( isset($_SESSION['plz']) ){
if( isset($_SESSION['plazaBD']) ){
    $bd = $_SESSION['plazaBD'];

    $serverName = "51.222.44.135";
    $connectionInfo = array( 'Database' => 'implementtaAdministrator', 'UID'=>'sa', 'PWD'=>'vrSxHH3TdC');
    $cnx = sqlsrv_connect($serverName, $connectionInfo);
    date_default_timezone_set('America/Mexico_City');

    $sqlBD = sqlsrv_query($cnx, "select pro.nombreProveniente, pro.data from plaza p join proveniente pro
    on p.id_proveniente = pro.id_proveniente
    where pro.data = ? ", array( $bd ) );

    $rowDB = sqlsrv_fetch_array($sqlBD);
    $nombrePlaza = $rowDB['nombreProveniente'];
    // $bd = $rowDB['data'];
}else{
    exit();
    // echo '<meta http-equiv="refresh" content="0,url=https://implementta.net/"';
}

?>
<html>
<head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title ></title>
        <link rel="icon" href="img/implementtaIcon.png">
        <!-- Bootstrap -->
        <!-- <link rel="stylesheet" href="../../css/bootstrap.css"> -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

       <style>
         body {
                background-image: url(img/backImplementta.jpg);
                background-repeat: repeat;
                background-size: 100%;
                background-attachment: fixed;
                min-height: 100vh;
                width: 100%;
                display: flex;
                flex-direction: column;
            }
            .footer {
              margin-top: auto;
              width: 100%;
            }
       </style>

    </head>
    <body>
    <nav class="navbar navbar-dark bg-dark">
        <a class="navbar-brand" href="#">
            <img src="img/logoImplementtaHorizontal_contorno.png" width="150" height="50" class="d-inline-block align-top" alt="">
        </a>
        <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i></a>
        </li>
        </ul>
    </nav>
    

    
    <div class="container mt-5">
    <div class="card p-4">
        <h5 class="text-center mb-4">Conectado a: <?php echo $nombrePlaza; ?></h5>
        
        <div class="mb-3">
            <label class="form-label">Fecha inicio:</label>
            <input id="fIni" type="date" name="fInicio" value="<?php echo date('Y-m-d')?>" class="form-control">
        </div>
        
        <div class="mb-3">
            <label class="form-label">Fecha fin:</label>
            <input id="fFin" type="date" name="fFin" value="<?php echo date('Y-m-d')?>" class="form-control">
        </div>

        <button type="button" class="btn btn-primary" onclick="espera()">Generar excel</button>
    </div>
</div>

<script>
    function espera(){
        let ini = document.getElementById("fIni").value;
        let fin = document.getElementById("fFin").value;

        Swal.fire({
        icon: 'info',
        title: 'Cargando datos',
        text: 'Se esta generando su archivo, espere. . .',
        confirmButtonText: "Generar otro archivo",
        showCancelButton: false, // Mostrar el botón de cancelar
        showConfirmButton: true,
        allowOutsideClick: false, // Evitar que se cierre haciendo clic afuera
        allowEscapeKey: false, // Evitar que se cierre presionando Esc
        }).then((result) => {
            if (result.isConfirmed) {
                location.reload();
            }
        });

        let url = "excelReporte.php?fIni="+ini+"&fFin="+fin;
        //window.open("excelCuentasPeticion.php");
        window.location.replace(url);
    }
</script>
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
<!--***********************************FIN FOOTER****************************************************************-->
    </body>
</html>