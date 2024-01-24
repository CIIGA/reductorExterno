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
if(isset($_POST['save'])){
    $observ=$_POST['observacion'];
    $cuenta=$_POST['cuenta'];
    $id=$_POST['id'];

    $mensaje=$cuenta.'&tkn=0DFCC4D6-4068-4A61-8806-171F18A48323&listCta='.$id.'&textObs='.$observ;

    echo "<script>
       navigator.geolocation.getCurrentPosition(position => {
         var lat=position.coords.latitude;
         var long=position.coords.longitude;
         //var text=Mensaje;
         //console.log(lat+','+long);
         window.location.href = 'registrar.php?laTknResp='+lat+'&loTknResp='+long+'&resp=$mensaje';
       });
    </script>";
}
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
<?php if(isset($_GET['tex'])){ 
      $ctaFind=$_GET['tex'];
      $cu="select top 100 ctas.id,ctas.Cuenta,ctas.estdoVisita,implementta.Propietario,implementta.Calle,implementta.NumExt,implementta.NumInt,
      implementta.Colonia,implementta.Poblacion,implementta.CP,implementta.Latitud,implementta.Longitud from cuentasCargar as ctas
      inner join implementta on implementta.Cuenta=ctas.Cuenta
      where ((ctas.estdoVisita is NULL) and (ctas.Cuenta='$ctaFind'))";
      $cuen=sqlsrv_query($cnxPlz,$cu);
      $ctas=sqlsrv_fetch_array($cuen);
if(isset($ctas)){ ?>

<div class="container padding">
<br>
    <h4 style="text-shadow: 0px 0px 2px #717171;"><img width="42" height="42" src="https://img.icons8.com/external-others-bomsymbols-/91/000000/external-check-flat-locations-others-bomsymbols-.png" alt="external-check-flat-locations-others-bomsymbols-"/>Supervisar Cuenta <?php echo $_GET['tex'] ?></h4>
    <h6 style="text-shadow: 0px 0px 2px #717171;padding-bottom:0px;">Unidad <?php echo $plz ?><br>
    <span class="navbar-text" style="font-size:11px;font-weigth:normal;color: #7a7a7a;padding-top:0px;">Supervisa <?php echo $usuario['Nombre'] ?></span></h6>
<br>
      <?php 
        $ctaTarea=$ctas['Cuenta'];
        $store="execute [dbo].[sp_gestionrecienteRoles]'$ctaTarea'";
        $st=sqlsrv_query($cnxPlz,$store) or die ('Execute Stored Procedure Failed... Query store.php');
        $resultSt=sqlsrv_fetch_array($st);

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
      <h6 class="modal-title" style="text-shadow: 0px 0px 2px #717171;">Datos de la cuenta en Implementta</h6>
        <small class="form-text text-muted">Propietario: <?php echo utf8_encode($ctas['Propietario']) ?></small>
        <small class="form-text text-muted">Direccion: <?php echo utf8_encode($direccion) ?></small>
        <?php 
          if(($ctas['Latitud'] == NULL) or ($ctas['Latitud'] == 0.000000) or ($ctas['Longitud'] == NULL) or ($ctas['Longitud'] == 0.000000)){
            $ubi='No disponible';
          } else{
            $ubi=$ctas['Latitud'].','.$ctas['Longitud'];
          }
        ?>
        <small class="form-text text-muted">Ubicación: <?php echo $ubi ?></small>
          <br>
        <?php if($ubi <> 'No disponible'){ ?>
        <div style="text-align: center;">
          <a href="https://www.google.com/maps/search/?api=1&query=<?php echo $ubi ?>&zoom=30" target="_blank" class="btn btn-outline-primary btn-sm" data-toggle="tooltip" data-placement="bottom" title="Editar"><img width="22" height="22" src="https://img.icons8.com/color/48/google-maps-new.png" alt="google-maps-new"/> Ver ubicación de Implementta</a>
        </div>
        <?php } else{ ?>
          <small class="form-text text-muted"><i class="fas fa-terminal"></i> Maps no Disponible</small>
        <?php } ?>
          <hr>
      <?php if(isset($resultSt)){
      if( gettype($resultSt['FechaGestion']) != 'string' and $resultSt['FechaGestion'] != null ){
          $stringDate = trim( $resultSt['FechaGestion']->format('Y/m/d H:i:s') ); 
      } else{
          $stringDate = trim( $resultSt['FechaGestion'] );
      }
  ?>
      <h6 class="modal-title" style="text-shadow: 0px 0px 2px #717171;">Datos de ultima gestion</h6>
        <small class="form-text text-muted">Ultima Gestion: <?php echo $stringDate ?></small>
        <small class="form-text text-muted">Descripción: <?php echo utf8_encode($resultSt['DescripcionTarea']) ?></small>
        <small class="form-text text-muted">Gestor: <?php echo utf8_encode($resultSt['Gestor']) ?></small>
      <?php if(trim($resultSt['observaciones']) == ''){
        $obser='Observaciones: Sin observaciones';
      } else{
        $obser='Observaciones: '.trim($resultSt['observaciones']);
      } ?>
        <small class="form-text text-muted"><?php echo utf8_encode($obser) ?></small>

      <?php 
          if(($resultSt['latitud'] == NULL) or ($resultSt['latitud'] == 0.000000) or ($resultSt['longitud'] == NULL) or ($resultSt['longitud'] == 0.000000)){
            $ubiGest='No disponible';
          } else{
            $ubiGest=$resultSt['latitud'].','.$resultSt['longitud'];
          }
        ?>
        <small class="form-text text-muted">Ubicación: <?php echo $ubiGest ?></small>
          <br>
        <?php if($ubiGest <> 'No disponible'){ ?>
        <div style="text-align: center;">
          <a href="https://www.google.com/maps/search/?api=1&query=<?php echo $ubiGest ?>&zoom=30" target="_blank" class="btn btn-outline-primary btn-sm" data-toggle="tooltip" data-placement="bottom" title="Editar"><img width="22" height="22" src="https://img.icons8.com/color/48/google-maps-new.png" alt="google-maps-new"/> Ver ubicación de ultima gestion</a>
          </div>
        <?php } else{ ?>
          <small class="form-text text-muted"><i class="fas fa-terminal"></i> Maps no Disponible</small>
        <?php } ?>
        <?php } else{ ?>
        <span class="badge badge-warning" style="color:#000000;"><i class="fas fa-exclamation-triangle"></i> No hay tareas recientes para esta cuenta.</span>
      <?php } ?>
      </div>

<hr>

<form action="" method="post">
    <div class="container">
        <div class="form-group">
            <h6 class="modal-title" style="text-shadow: 0px 0px 2px #717171;">Observaciones: </h6>
            <textarea class="form-control" name="observacion" rows="3" placeholder="Observaciones de la visita a supervisión..." minlength="15" maxlength="500" required></textarea>
        </div>
        <input type="hidden" name="cuenta" class="form-control" value="<?php echo $ctas['Cuenta'] ?>">
        <input type="hidden" name="id" class="form-control" value="<?php echo $ctas['id'] ?>">


            <!-- <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="far fa-trash-alt"></i> Eliminar</button> -->
        <div style="text-align:center;">
            <a href="verificar.php" class="btn btn-dark"><i class="fas fa-chevron-left"></i> Cancelar</a>
            <button type="submit" class="btn btn-warning" name="save"><i class="fas fa-check"></i> Registrar Visita</button>

            <!-- <a class="btn btn-warning" onclick="return Confirmar('<?php //echo $ctas['Cuenta'].'&tkn=0DFCC4D6-4068-4A61-8806-171F18A48323&listCta='.$ctas['id'] ?>')"><i class="fas fa-check"></i> Registrar Visita</a> -->
        </div>
    </div>
</form>

<?php } else{
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
    
    } ?>
<?php } else{
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
 } ?>
<br>
<!--*************************INICIO FOOTER***********************************************************************-->
<footer class="text-center">
  <div class="container">
     <span class="navbar-text" style="font-size:11px;color: #7a7a7a;">Implementta <i class="far fa-registered"></i><br>
         Estrategas de México <i class="far fa-registered"></i><br>
         Centro de Inteligencia Informática y Geografía Aplicada CIIGA
         <hr style="width:105%;border-color:#7a7a7a;">
         Creado y diseñado por © <?php echo date('Y') ?> Estrategas de México
      </span>
  </div>
</footer>
<br><br>
<!--***********************************FIN FOOTER****************************************************************-->
</body>
<script src="../js/jquery-3.4.1.min.js"></script>
<script src="../js/popper.min.js"></script>    
<script src="../js/bootstrap.js"></script>
<script>
    // function Confirmar(Mensaje){
    //   navigator.geolocation.getCurrentPosition(position => {
    //     var lat=position.coords.latitude;
    //     var long=position.coords.longitude;
    //     var text=Mensaje;
    //     //console.log(lat+','+long);
    //     //console.log(Mensaje);
    //     window.location.href = 'registrar.php?laTknResp='+lat+'&loTknResp='+long+'&resp='+Mensaje;
    //   });
    // }
</script>
</html>