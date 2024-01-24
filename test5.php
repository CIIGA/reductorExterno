<?php
require "../../acnxerdm/cnx.php";
$plz=$_SESSION['dataB'];
$idUsr=$_SESSION['AspUsr'];

  $Countcu="select COUNT(ctas.Cuenta) as numReg from cuentasCargar as ctas
  inner join implementta on implementta.Cuenta=ctas.Cuenta
  where ctas.estdoVisita is NULL";
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
    <h4 style="text-shadow: 0px 0px 2px #717171;"><img width="35" height="35" src="https://img.icons8.com/color/48/filled-flag.png" alt="filled-flag"/> Cuentas por visitar 
    <span class="badge badge-warning" style="color:#000000;"><?php echo $Countctas['numReg'] ?></span></h4>
    <h6 style="text-shadow: 0px 0px 2px #717171;">Unidad <?php echo $plz ?></h6>
    <h6 style="text-shadow: 0px 0px 2px #717171;"><i class="fas fa-user"></i> <?php echo $usuario['Nombre'] ?></h6>
    
<br>
<form action="" method="get">
    <div class="input-group col-md-15 justify-content-center">
      <input type="text" class="form-control form-control-sm" placeholder="Buscar cuenta" name="find" id="busqueda" required>
      <div class="input-group-prepend">
        <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i></button>
      </div>
    </div>
</form>
<br>

<?php if($Countctas['numReg'] > 0){
  
  if(isset($_GET['find'])){

  $ctaFind=$_GET['find'];
  $cu="select top 100 ctas.id,ctas.Cuenta,ctas.estdoVisita,implementta.Propietario,implementta.Calle,implementta.NumExt,implementta.NumInt,
  implementta.Colonia,implementta.Poblacion,implementta.CP,implementta.Latitud,implementta.Longitud from cuentasCargar as ctas
  inner join implementta on implementta.Cuenta=ctas.Cuenta
  where ((ctas.estdoVisita is NULL) and (ctas.Cuenta='$ctaFind'))";
  $cuen=sqlsrv_query($cnxPlz,$cu);
  $ctas=sqlsrv_fetch_array($cuen);
?>
<?php if(isset($ctas)){ ?>









<?php } else{ ?>
  <hr>
  <div class="alert alert-success" role="alert">
    <img width="25" height="25" src="img/verifica.gif" alt="checkmark--v1"/> No tienes cuentas pendientes de visitar, verifica con tu coordinador.
  </div>
  <div style="text-align: center;">
    <a href="logout.php" class="btn btn-dark btn-sm"><i class="fas fa-sign-out-alt"></i> Salir</a>
  </div>
<?php } ?>
    
    
    
<?php }} ?>
    
    

    
    
    
    
    
    
    
    
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
<script>
    function Confirmar(Mensaje){
      navigator.geolocation.getCurrentPosition(position => {
        var lat=position.coords.latitude;
        var long=position.coords.longitude;
        var text=Mensaje;
        //console.log(lat+','+long);
        //console.log(Mensaje);
        window.location.href = 'registrar.php?laTknResp='+lat+'&loTknResp='+long+'&resp='+Mensaje;
      });
    }
</script>
</html>