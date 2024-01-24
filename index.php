<?php
session_start();
//require "../../acnxerdm/cnx.php";
$serverName = "implementta.mx";
  $connectionInfo = array( 'Database'=>'implementtaAdministrator', 'UID'=>'sa', 'PWD'=>'vrSxHH3TdC');
  $cnx = sqlsrv_connect($serverName, $connectionInfo);
  date_default_timezone_set('America/Mexico_City');
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Supervision</title>
<link rel="icon" href="img/implementtaIcon.png">
<!-- Bootstrap -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link href="../fontawesome/css/all.css" rel="stylesheet">
<link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-material-ui/material-ui.css" id="theme-styles">
<style>
  body {
      background-image: url(img/back.jpg);
      background-repeat: repeat;
      background-size: 100%;
  /*        background-attachment: fixed;*/
      overflow-x: hidden; /* ocultar scrolBar horizontal*/
      /*overflow-y: hidden; /* ocultar scrolBar horizontal*/
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
  .jumbotron {
      margin-top:0%;
      margin-bottom:0%;
  }
  .padding {
      padding-right:12%;
      padding-left:12%;
  }
</style>
</head>
<body>
<?php
    if(isset($_POST['login'])){
    $correo=$_POST['correo'];
    $clave=$_POST['clave'];

    $ad="select * from usuariosCuadrilla
    WHERE ((clave='$clave') and (usuario='$correo') and (accessReductorExt=1))";
    $adm=sqlsrv_query($cnx,$ad);
    $admo=sqlsrv_fetch_array($adm);
        
    if((isset($admo)) and ($admo['accessReductorExt'] == 1)){
                
        $_SESSION['AspUsr']=$admo['idAspUser'];
        $_SESSION['dataB']=$admo['dbPlaza'];
        
        echo "<script>
                let timerInterval
                Swal.fire({
                  title: 'Iniciando sesión ',
                  html: 'Bienvenido a Implementta Cortes<br>$correo',
                  icon: 'success',
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
          echo '<meta http-equiv="refresh" content="2,url=IndexTest.php">';
    } else{
        echo "<script>
                let timerInterval
                Swal.fire({
                  title: '¡Error!',
                  html: 'Los datos de acceso no existen en Implementta Cortes <br>Intenta nuevamente.',
                  icon: 'error',
                  timer: 3000,
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
            
        echo '<meta http-equiv="refresh" content="3,url=../reductorExterno/">';
    }
        
    }
?>  
<nav class="navbar navbar-dark bg-dark">
  <a class="navbar-brand" href="#">
    <img src="img/logoImplementtaHorizontal.png" width="156" height="50" class="d-inline-block align-top" alt="">
  </a>
</nav>
    
<div class="container padding" style="text-align:center;">
    <br><br><br>
    <h2 style="text-shadow: 0px 0px 2px #717171;"><img width="50" height="50" src="https://img.icons8.com/color/48/plumbing.png" alt="plumbing"/> Cortes</h2><hr>
    <h5 style="text-shadow: 0px 0px 2px #717171;"> Gestion Reductor Externo</h5>
    <h5 style="text-shadow: 0px 0px 2px #717171;"> Iniciar Sesión</h5>
    <br>

<?php if(isset($_GET['exeption'])){ ?>

  <div class="alert alert-danger" role="alert">
  <img width="30" height="30" src="https://img.icons8.com/fluency/48/error.png" alt="error"/> Para una experiencia óptima, por favor utiliza <b><i class="fab fa-chrome"></i> Google Chrome</b>
  </div>

<?php } else{ ?>
<script src="js/validaNavig.js"></script>
<?php } ?>
<form action="" method="post">
    <div class="md-form form-group">
    <div class="form-group">
        <label for="exampleInputPassword1">Usuario:</label>
        <input type="text" class="form-control" name="correo" placeholder="nombre@erdm.mx" autofocus>
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">Contraseña</label>
        <input type="password" name="clave" class="form-control" placeholder="Contraseña">
    </div>
    </div>
<button type="submit" class="btn btn-primary btn-lg btn-block btn-sm" name="login">Entrar</button>
</form>




    <br><br><br>
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