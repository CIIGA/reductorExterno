<?php

session_start();
// $_SESSION['plz'] = 1027;
// unset($_SESSION['plz']);
// unset($_SESSION['plazaBD']);
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
    echo '<meta http-equiv="refresh" content="0,url=https://implementta.net/"';
}

function generarValues($num){
    $values = 'VALUES(?,?)';
    
    for($i = 1;$i < $num/2; $i++){
        $values = $values.', (?,?)';
    }
    
    return $values;
}

if(isset($_POST['upload'])){

    $ext = '';
    if(isset($_FILES['peticionFile']) and $_FILES['peticionFile']['error'] <> 4){
        $archivo = $_FILES['peticionFile']['name'];
        $archivotemp = $_FILES['peticionFile']['tmp_name'];
        $ext = pathinfo($archivo,PATHINFO_EXTENSION);
    }

    if($ext=='xls' or $ext=='xlsx' ){

        //require_once('../PhpSpreadsheet/vendor/autoload.php');
        require_once('PhpSpreadsheet/vendor/autoload.php');

        $tablaGlobal = "asignacionReductorExterno";
        $tokenInsert = date('YmdHis').rand(2000, 9999).rand(3000, 6000);

        $serverName = "51.222.44.135";
        $connectionInfo = array( 'Database' => $bd, 'UID'=>'sa', 'PWD'=>'vrSxHH3TdC');
        $cnx = sqlsrv_connect($serverName, $connectionInfo);
        date_default_timezone_set('America/Mexico_City');

        $exitoUpload = 0;
        $fileName = $archivotemp;
        if(file_exists($fileName)){

            $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($fileName);
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
            $reader->setReadDataOnly(true);

            $spreadsheet = $reader->load($fileName);
            $dataExcel = $spreadsheet->getSheet(0)->toArray(null,false,false,false); //Revisar por si necesita configurar diferente.
            //$dataExcel = $spreadsheet->getActiveSheet()->toArray(null,false,false,false); //Revisar por si necesita configurar diferente.
            $primerFila = $dataExcel[0];

            $token = date('dmyhis').rand(1000,9999);
            $insertados = 0;

            $filaExcel1 = array();
            $insertConsulta = "insert into ".$tablaGlobal."(Cuenta, token)";
                
            for($x=1;$x<count($dataExcel);$x++){
                if(trim($dataExcel[$x][0]) == ''){
                    break;
                }
                $cuenta = trim($dataExcel[$x][0]);

                $filaExcel1[] = trim($dataExcel[$x][0]);
                $filaExcel1[] = $token;

                if(count($filaExcel1) == 200){//Deben ser multiplos de 2

                    if(sqlsrv_query($cnx,$insertConsulta.generarValues(count($filaExcel1)),$filaExcel1) == false ){
                        // print_r(sqlsrv_errors() );
                        // exit();
                        sqlsrv_query($cnx,"DELETE FROM asignacionReductorExterno WHERE token = ?",array($token) );
                        echo '<meta http-equiv="refresh" content="0,url=cargaCuentasReductores.php?errorIns"';
                    }
                    $filaExcel1 = array();
                }
            }

            if(count($filaExcel1) > 0){   
                if(sqlsrv_query($cnx,$insertConsulta.generarValues(count($filaExcel1)),$filaExcel1) == false ){
                    // print_r(sqlsrv_errors() );
                    // exit();
                    sqlsrv_query($cnx,"DELETE FROM asignacionReductorExterno WHERE token = ?",array($token) );
                    echo '<meta http-equiv="refresh" content="0,url=cargaCuentasReductores.php?errorIns"';
                }
                $filaExcel1 = array();
            }

            $cuentasRepetidas = "DELETE FROM g from (
            select cuenta,token FROM [dbo].[asignacionReductorExterno]  WHERE cuenta in ( 
                SELECT Cuenta FROM [dbo].[asignacionReductorExterno] 
                GROUP BY Cuenta
                HAVING count(Cuenta) > 1 
            )	) as g WHERE g.token=?";

            $noEnImplementa = "DELETE FROM asignacionReductorExterno
            WHERE token = ? and cuenta in
            (SELECT DISTINCT a.cuenta FROM [dbo].[asignacionReductorExterno] a
            left join implementta i on i.Cuenta = a.Cuenta 
            where i.Cuenta is null )";

            if( sqlsrv_query($cnx,$cuentasRepetidas,array($token) ) == false and 
                sqlsrv_query($cnx,$noEnImplementa,array($token) ) == false ){
                    sqlsrv_query($cnx,"DELETE FROM asignacionReductorExterno WHERE token = ?",array($token) );
                    echo '<meta http-equiv="refresh" content="0,url=cargaCuentasReductores.php?errorIns"';
            }

            $sqlCount = sqlsrv_query($cnx, "SELECT COUNT(*) FROM $tablaGlobal where token = ?", array($token) );
            if( ($rowCount = sqlsrv_fetch_array($sqlCount)) != null){
                $insertados = $rowCount[0];
            }

            echo '<meta http-equiv="refresh" content="0,url=cargaCuentasReductores.php?ok='.$insertados.'"';
        }
    }else{
        echo '<script>alert("El archivo seleccionado debe estar en formato XLS o XLSX");</script>';
        echo '<meta http-equiv="refresh" content="0,url=cargaCuentasReductores.php"';
    }

}

?>
<html>
<head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title >Carga - Reductores</title>
        <link rel="icon" href="img/implementtaIcon.png">
        <!-- Bootstrap -->
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
    <?php //require "include/nav.php"; ?>

    <div class="container mt-5">
    <?php if( isset($_GET['ok']) ){ ?>
        <div class="alert alert-success">Se subieron correctamente <?php echo $_GET['ok']; ?> registros.</div>
    <?php } else if( isset($_GET['error']) ){ ?>
        <div class="alert alert-danger">Hubo un error al subir los registros, inténtelo de nuevo.</div>
    <?php } ?>

    <div class="text-center">
        <h3 class="mb-4">Carga de cuentas Reductores</h3>
        <h5>Conectado a: <?php echo $nombrePlaza; ?> </h5>
    </div>

    <form class="d-flex flex-column align-items-center mt-4" method="post" enctype="multipart/form-data">
        <label class="mb-3">Para ingresar cuentas:</label>
        <input type="file" name="peticionFile" class="form-control mb-3">
        <button class="btn btn-primary" onclick="espera()" name="upload">Subir cuentas</button>
    </form>
</div>
    </form>

<script>
    function espera(){
        Swal.fire({
        icon: 'info',
        title: 'Cargando datos',
        text: 'Se estan subiendo sus registros espere. . .',
        showCancelButton: false, // Mostrar el botón de cancelar
        showConfirmButton: false,
        allowOutsideClick: false, // Evitar que se cierre haciendo clic afuera
        allowEscapeKey: false, // Evitar que se cierre presionando Esc
        });
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