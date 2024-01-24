<?php
require "../../acnxerdm/cnx.php";
$plz=$_SESSION['dataB'];
$idUsr=$_SESSION['AspUsr'];
//******************************************************************
$ne="select UserName,Nombre from AspNetUsers
where Id='$idUsr'";
$netU=sqlsrv_query($cnxPlz,$ne);
$usuario=sqlsrv_fetch_array($netU);
//******************************************************************
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Supervision</title>
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
if(isset($_GET['resp'])){
    $cuenta=$_GET['resp'];
    $idRegCuentasAsig=$_GET['listCta'];

    $va="select * from cuentasCargar
    where ((cuenta='$cuenta') and (id= $idRegCuentasAsig))";
    $val=sqlsrv_query($cnxPlz,$va);
    $valida=sqlsrv_fetch_array($val);
  if(isset($valida)){

    $estdoVisita='1';
    $fechaVisita=date('Y-m-d').'T'.date('H:i:s');
    $lat=$_GET['laTknResp'];
    $long=$_GET['loTknResp'];
    $idAspUser=$idUsr;
    $observa=$_GET['textObs'];

      $supervisado="update cuentasCargar set estdoVisita='$estdoVisita',fechaVisita='$fechaVisita',long='$long',lat='$lat',idAspUser='$idAspUser',observacion='$observa'
      where id='$idRegCuentasAsig'";
      sqlsrv_query($cnxPlz,$supervisado) or die ('No se ejecuto la consulta update salida');



      echo "<script>
      Swal.fire({
        title: 'Finalizado',
        text: 'Se registro la visita de supervision correctamente',
        icon: 'success',
        allowOutsideClick: false, // Evitar que se cierre haciendo clic afuera
        allowEscapeKey: false, // Evitar que se cierre presionando Esc
        confirmButtonText: 'OK',
      }).then((result) => {
        if (result.isConfirmed) {
          location.href ='verificar.php';
        }
      });
      </script>";

  } else{
        echo "<script>
        let timerInterval
        Swal.fire({
          title: '¡Error!',
          html: 'Los datos de busqueda no existen.',
          icon: 'error',
          timer: 2000,
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
      echo '<meta http-equiv="refresh" content="2,url=../supervision/verificar.php">';
  }

} else{
    echo "<script>
    let timerInterval
    Swal.fire({
      title: '¡Error!',
      html: 'No hay datos de busqueda <br>Intenta nuevamente.',
      icon: 'error',
      timer: 2000,
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
  echo '<meta http-equiv="refresh" content="2,url=../supervision/verificar.php">';
}
?>    
<nav class="navbar navbar-dark bg-dark">
    <a class="navbar-brand" href="#">
        <img src="../img/flor.png" width="60" height="50" class="d-inline-block align-top" alt="">
    </a>
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i></a>
      </li>
    </ul>
</nav>
    
<div class="container padding">
<br>
    <h4 style="text-shadow: 0px 0px 2px #717171;"><img width="42" height="42" src="https://img.icons8.com/external-others-bomsymbols-/91/000000/external-check-flat-locations-others-bomsymbols-.png" alt="external-check-flat-locations-others-bomsymbols-"/>Supervisar Cuenta <?php echo $_GET['resp'] ?></h4>
    <h6 style="text-shadow: 0px 0px 2px #717171;padding-bottom:0px;">Unidad <?php echo $plz ?><br>
    <span class="navbar-text" style="font-size:11px;font-weigth:normal;color: #7a7a7a;padding-top:0px;">Supervisa <?php echo $usuario['Nombre'] ?></span></h6>
<br>
   


    
    
    
    
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