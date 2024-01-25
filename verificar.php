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
  </style>
</head>

<body>
<?php
  if (isset($_SESSION['registro_success'])) {
    echo "<script>
window.onload = function() {
mostrarSweetAlert('success', 'Registro Exitoso!', '" . htmlspecialchars($_SESSION['registro_success']) . "');
};
</script>";
    unset($_SESSION['registro_success']);
} ?>
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
      <h4 style="text-shadow: 0px 0px 2px #717171;"><img width="48" height="48" src="https://img.icons8.com/fluency/48/pumphouse.png" alt="pumphouse" /> Cuentas por visitar</h4>
      <h6 style="text-shadow: 0px 0px 2px #717171;">Unidad <?php echo $plz ?></h6>
      <h6 style="text-shadow: 0px 0px 2px #717171;"><i class="fas fa-user"></i> <?php echo $usuario['Nombre'] ?></h6>
    </div>
    <!--     
<br>
<form action="" method="get">
    <div class="input-group col-md-15 justify-content-center">
      <input type="text" class="form-control form-control-sm" placeholder="Buscar cuenta" name="find" id="busqueda" required>
      <div class="input-group-prepend">
        <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i></button>
      </div>
    </div>
</form>
<br><br> -->

    <?php if ($Countctas['numReg'] > 0) { ?>

      <hr>

      <div class="content-wrapper">
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-8 offset-md-2">
                <form action="">
                  <div class="input-group">
                    <input type="search" name="cuenta" class="form-control form-control-lg" placeholder="Buscar una cuenta..." autofocus>
                    <div class="input-group-append">
                      <button type="submit" class="btn btn-lg btn-default">
                        <i class="fa fa-search"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </section>
      </div>











      <?php if (isset($_GET['cuenta'])) {

        $ctaFind = $_GET['cuenta'];
        $cu = "select i.Cuenta, Propietario, concat(calle,' ',NumExt,' ',NumInt,' ',colonia,', ',Poblacion,' ',CP) as direccion
  from asignacionReductorExterno as a inner join implementta as i on a.Cuenta=i.Cuenta
  where a.Cuenta='$ctaFind'";
        $cuen = sqlsrv_query($cnxPlz, $cu);
        $ctas = sqlsrv_fetch_array($cuen);
      ?>
        <?php if (isset($ctas)) { 
          $_SESSION['cuenta']=$ctas['Cuenta'];
          ?>
          <br>
          <div class="row justify-content-center align-items-center">
            <div class="col-md-6 col-lg-4 mb-4">
              <div class="card ">
                <div class="card-header text-white bg-info">
                <h5 class="card-title">
                    <span style="font-weight: 700; color: white;">Cuenta: <?= $ctas['Cuenta'] ?></span>
                  </h5>
                </div>
                <div class="card-body text-black">
                  
                  <p class="card-text">Propietario: <?= $ctas['Propietario'] ?></p>
                  <p class="card-text">Dirección: <?= $ctas['direccion'] ?></p>
                </div>
                <div class="card-footer text-center bg-info" style="padding: 0;" >
                  <a href="formulario.php" class="btn btn-block btn-lg btn-sm" style="margin: 0; transition: background-color 0.3s;">
                    Gestionar Cuenta <i class="fas fa-arrow-circle-right"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>

          <hr>
          <small class="form-text text-muted" style="text-align: center;font-size:12px;font-weigth:normal;color: #7a7a7a;"><i class="fas fa-info-circle"></i> Actualmente se muestra solo la cuenta en busqueda.</small><br>

        <?php } else { ?>
          <hr>
          <div class="alert alert-danger" role="alert" style="text-align: center;">
            <img width="26" height="26" src="https://img.icons8.com/fluency/48/error.png" alt="error" /> No se encontraron resultados para la cuenta: <?php echo '<b>' . $_GET['cuenta'] . '</b>' ?>
            <small class="form-text text-muted" style="text-align: center;font-size:12px;font-weigth:normal;color: #7a7a7a;"><i class="fas fa-info-circle"></i> Recuerda asignar las cuentas antes de supervisar.</small>
          </div>
        <?php } ?>

      <?php } ?>
    <?php } else { ?>
      <hr>
      <div class="alert alert-danger" role="alert">
        <img width="30" height="30" src="https://img.icons8.com/color/48/filled-flag2--v1.png" alt="filled-flag2--v1" /> No tienes cuentas disponibles para visitar, verifica con tu coordinador.
      </div><br>
      <div style="text-align: center;">
        <a href="logout.php" class="btn btn-dark btn-sm"><i class="fas fa-sign-out-alt"></i> Salir</a>
      </div>
    <?php } ?>
  </div>
  <br><br>
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
  <br><br><br><br>
  <!--***********************************FIN FOOTER****************************************************************-->
</body>
</html>
<?php
} else {
    echo '<meta http-equiv="refresh" content="0,url=logout.php">';
}
?>