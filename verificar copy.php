<?php
session_start();
require "include/cnx.php";
$plz=$_SESSION['dataB'];
$idUsr=$_SESSION['AspUsr'];
$cnxPlz=conexion('implementtaTijuanaA');

  $Countcu="select COUNT(ctas.Cuenta) as numReg from asignacionReductorExterno as ctas
  inner join implementta on implementta.Cuenta=ctas.Cuenta";
  $Countcuen=sqlsrv_query($cnxPlz,$Countcu);
  $Countctas=sqlsrv_fetch_array($Countcuen);
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
<link rel="icon" href="img/implementtaIcon.png">
<!-- Bootstrap -->
<link href="../fontawesome/css/all.css" rel="stylesheet">
<link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css"/>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
body {
    background-image: url(img/back.jpg);
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
    <h4 style="text-shadow: 0px 0px 2px #717171;"><img width="48" height="48" src="https://img.icons8.com/fluency/48/pumphouse.png" alt="pumphouse"/> Cuentas por visitar</h4>
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

<?php if($Countctas['numReg'] > 0){ ?>

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
                                <button type="submit" name="search" class="btn btn-lg btn-default">
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










  
  <?php if(isset($_GET['search'])){

  $ctaFind=$_GET['cuenta'];
  $cu="select top 10 ctas.id,ctas.Cuenta,ctas.estdoVisita,implementta.Propietario,implementta.Calle,implementta.NumExt,implementta.NumInt,
  implementta.Colonia,implementta.Poblacion,implementta.CP,implementta.Latitud,implementta.Longitud from cuentasCargar as ctas
  inner join implementta on implementta.Cuenta=ctas.Cuenta
  where ((ctas.estdoVisita is NULL) and (ctas.Cuenta='$ctaFind'))";
  $cuen=sqlsrv_query($cnxPlz,$cu);
  $ctas=sqlsrv_fetch_array($cuen);
?>
<?php if(isset($ctas)){ ?>
  <table class="table table-sm table-hover">
  <thead>
    <tr>
      <th scope="col">Cuenta</th>
      <th scope="col">Direccion</th>
      <th scope="col">Info</th>
    </tr>
  </thead>
  <tbody>
  <?php do{ ?>
    <tr>
      <td><?php echo $ctas['Cuenta'] ?></td>
      <td>
        <?php 
          if($ctas['Calle'] <> ''){
            $calle='Calle '.trim($ctas['Calle']);
          } else{
            $calle='Calle no disp.';
          }
          if($ctas['NumExt'] <> ''){
            $numExt=', Num. Ext. '.trim($ctas['NumExt']);
          } else{
            $numExt=' ';
          }
          if($ctas['NumInt'] <> ''){
            $numInt=', Num. Int. '.trim($ctas['NumInt']);
          } else{
            $numInt=' ';
          }
          if($ctas['Colonia'] <> ''){
            $Colonia=' '.trim($ctas['Colonia']);
          } else{
            $Colonia=' ';
          }
          if($ctas['Poblacion'] <> ''){
            $Poblacion=' Poblacion: '.trim($ctas['Poblacion']);
          } else{
            $Poblacion=' ';
          }
          if($ctas['CP'] <> ''){
            $CP=' C.P. '.trim($ctas['CP']);
          } else{
            $CP=' ';
          }
            $direccion=$calle.$numExt.$numInt.$Colonia.$Poblacion.$CP;
        ?>
        <small class="form-text text-muted"><?php echo utf8_encode(trim($direccion)) ?></small>
      </td>
    <td>
        <a href="info.php?tex=<?php echo $ctas['Cuenta'] ?>" class="btn btn-outline-primary btn-sm" style="padding:0%;border:0px;"><img width="35" height="35" src="https://img.icons8.com/color/48/info--v1.png" alt="info--v1"/></a>
    </td>
    </tr>

<?php } while($ctas=sqlsrv_fetch_array($cuen)); ?>
  </tbody>
</table>
<hr>
<small class="form-text text-muted" style="text-align: center;font-size:12px;font-weigth:normal;color: #7a7a7a;"><i class="fas fa-info-circle"></i> Actualmente se muestra solo la cuenta en busqueda.</small><br>
  <div style="text-align: center;">
    <a href="verificar.php" class="btn btn-dark btn-sm"><i class="fas fa-chevron-left"></i> Regresar a ver todas</a>
  </div>
<?php } else{ ?>
  <hr>
  <div class="alert alert-danger" role="alert" style="text-align: center;">
    <img width="26" height="26" src="https://img.icons8.com/fluency/48/error.png" alt="error"/> No se encontraron resultados para la cuenta: <?php echo '<b>'.$_GET['cuenta'].'</b>' ?>
    <small class="form-text text-muted" style="text-align: center;font-size:12px;font-weigth:normal;color: #7a7a7a;"><i class="fas fa-info-circle"></i> Recuerda asignar las cuentas antes de supervisar.</small>
  </div>
  <div style="text-align: center;">
    <a href="verificar.php" class="btn btn-dark btn-sm"><i class="fas fa-chevron-left"></i> Regresar a ver todas</a>
  </div>
<?php } ?>

<?php } ?>
<?php } else{ ?>
  <hr>
  <div class="alert alert-danger" role="alert">
  <img width="30" height="30" src="https://img.icons8.com/color/48/filled-flag2--v1.png" alt="filled-flag2--v1"/> No tienes cuentas disponibles para visitar, verifica con tu coordinador.
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
<script src="../js/jquery-3.4.1.min.js"></script>
<script src="../js/popper.min.js"></script>    
<script src="../js/bootstrap.js"></script>
</html>