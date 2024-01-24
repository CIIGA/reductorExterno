<?php
session_start();
if (isset($_SESSION['AspUsr'])) {
require "include/cnx.php";

$plz=$_SESSION['dataB'];
$idUsr=$_SESSION['AspUsr'];
$cnx=conexion('implementtaTijuanaA');
//******************************************************************
$ne="select UserName,Nombre from AspNetUsers
where Id='$idUsr'";
$netU=sqlsrv_query($cnx,$ne);
$usuario=sqlsrv_fetch_array($netU);
//******************************************************************
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Inspeccion</title>
<link rel="icon" href="../icono/implementtaIcon.png">
<!-- Bootstrap -->
<link rel="stylesheet" href="../css/bootstrap.css">
<link href="../fontawesome/css/all.css" rel="stylesheet">
<link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css"/>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
body {
    background-image: url(../img/backImplementta.jpg);
    background-repeat: repeat;
    background-size: 100%;
/*        background-attachment: fixed;*/
    overflow-x: hidden; /* ocultar scrolBar horizontal*/
   /* overflow-y: hidden;  ocultar scrolBar horizontal*/
}
body {
    font-family: sans-serif;
    font-style: normal;
    font-weight:normal;
    width: 100%;
    height: 100%;
    margin-top:-1%;
    padding-top:0px;
}
</style>
</head>
<body>
<?php  

?>    
<nav class="navbar navbar-dark bg-dark">
    <a class="navbar-brand" href="#">
        <img src="../img/logoImplementtaHorizontal_contorno.png" width="150" height="50" class="d-inline-block align-top" alt="">
    </a>
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i></a>
      </li>
    </ul>
</nav>
    
<div class="container padding">
<br>
    <h4 style="text-shadow: 0px 0px 2px #717171;"><img width="48" height="48" src="https://img.icons8.com/fluency/48/pumphouse.png" alt="pumphouse"/> Cuentas por visitar</h4>
    <h6 style="text-shadow: 0px 0px 2px #717171;">Unidad <?php echo $plz ?></h6>
    <h6 style="text-shadow: 0px 0px 2px #717171;"><i class="fas fa-user"></i> <?php echo $usuario['Nombre'] ?></h6>
    


<?php

// Función para generar un identificador único del dispositivo (simulación)
function generateDeviceIdentifier() {
    return md5($_SERVER['HTTP_USER_AGENT']);
}

// Verificar si el usuario ya está autenticado
if (isset($_SESSION['AspUsr'])) {
  $cnx=conexion('implementtaAdministrator');
    // Verificar si la sesión está asociada con el dispositivo actual
    $currentDeviceIdentifier = generateDeviceIdentifier();

//**********************************************
    $idaspUser=$_SESSION['AspUsr'];
    $id="select idAspUser,UserAgentReductorExt from usuariosCuadrilla
    WHERE idAspUser='$idaspUser' and UserAgentReductorExt is NULL";
    $ide=sqlsrv_query($cnx,$id);
    $indent=sqlsrv_fetch_array($ide);
  if(isset($indent)){
    $usrAgent=$currentDeviceIdentifier;

    $va1="select idAspUser,UserAgentReductorExt from usuariosCuadrilla
    WHERE UserAgentReductorExt='$usrAgent'";
    $val1=sqlsrv_query($cnx,$va1);
    $valida1=sqlsrv_fetch_array($val1);

    if(!isset($valida1)){
      $cuadrilla="update usuariosCuadrilla set UserAgentReductorExt='$usrAgent'
      where idAspUser='$idaspUser'";
      sqlsrv_query($cnx,$cuadrilla) or die ('No se ejecuto la consulta update salida');
    }
  }

    $idaspUser=$_SESSION['AspUsr'];
    $va="select idAspUser,UserAgentReductorExt from usuariosCuadrilla
    WHERE idAspUser='$idaspUser' and UserAgentReductorExt is not NULL";
    $val=sqlsrv_query($cnx,$va);
    $valida=sqlsrv_fetch_array($val);


    if (!isset($valida['UserAgentReductorExt']) || $valida['UserAgentReductorExt'] !== $currentDeviceIdentifier) {
        //echo '1 La sesión no está asociada con el dispositivo actual, cerrar sesión <hr>';
        //echo 'Este dispositivo: '.$currentDeviceIdentifier;

        
        //session_unset();
        //session_destroy();
        //header("Location: login.php");
        //exit();

        echo "<script>
                let timerInterval
                Swal.fire({
                  title: '¡Error!',
                  html: 'La sesión no está asociada a el dispositivo actual <br>Verifica correcto usuario.',
                  icon: 'error',
                  timer: 4000,
                  timerProgressBar: true,
                  didOpen: () => {
                    Swal.showLoading()
                    const b = Swal.getHtmlContainer().querySelector('b')
                    timerInterval = setInterval(() => {
                      b.textContent = Swal.getTimerLeft()
                    }, 100)
                  },
                  willClose: () => {
                    clearInterval(timerInterval)
                  }
                }).then((result) => {
                  /* Read more about handling dismissals below */
                  if (result.dismiss === Swal.DismissReason.timer) {
                    console.log('I was closed by the timer')
                  }
                })
            </script>";
            
        echo '<meta http-equiv="refresh" content="4,url=logout.php">';

    } else{
      $_SESSION['device_identifier'] = $valida['UserAgentReductorExt'];
      echo 'Entra y continua con la sesion con el Identificador: '.$valida['UserAgentReductorExt'];
      header("Location: verificar.php");
    }
  
} else {
    //echo 'El usuario no está autenticado, redirigir a la página de inicio de sesión';
    header("Location: logout.php");
    exit();
}



?>



    
    
</div>  
<br>
<!--*************************INICIO FOOTER***********************************************************************-->
<footer class="text-center">
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
<script src="../js/jquery-3.4.1.min.js"></script>
<script src="../js/popper.min.js"></script>    
<script src="../js/bootstrap.js"></script>
</html>
<?php
} else {
    echo '<meta http-equiv="refresh" content="0,url=logout.php">';
}
?>