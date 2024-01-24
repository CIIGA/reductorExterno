<?php
session_start();
require "../../acnxerdm/cnx.php";
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Inspeccion Asignacion</title>
<link rel="icon" href="../icono/implementtaIcon.png">
<!-- Bootstrap -->
<link rel="stylesheet" href="../css/bootstrap.css">
<link href="../fontawesome/css/all.css" rel="stylesheet">
<link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css"/>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="assets/plugins/qrCode.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
body {
    background-image: url(../img/backImplementta.jpg);
    background-repeat: repeat;
    background-size: 100%;
/*        background-attachment: fixed;*/
    overflow-x: hidden;  /*ocultar scrolBar horizontal
/*    overflow-y: hidden;  ocultar scrolBar horizontal*/
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
    <img src="../img/logoImplementtaHorizontal_contorno.png" width="156" height="50" class="d-inline-block align-top" alt="">
    </a>
    <a href="verificar.php" class="btn btn-primary btn-sm">
        Por inspeccionar <span class="badge badge-danger">8</span>
    </a>
</nav>
    
<div class="container padding">
    <br>
    <h4 style="text-shadow: 0px 0px 2px #717171;"><img width="35" height="35" src="https://img.icons8.com/fluency/48/list.png" alt="list"/> Cuentas asignadas</h4>
    <br>
    
  <form class="form-inline">
    <input class="form-control form-control-sm mr-sm-2" type="search" placeholder="Buscar cuenta o rol de asignacion" aria-label="Search" autofocus>
    <button class="btn btn-outline-primary btn-sm my-2 my-sm-0" type="submit"><i class="fas fa-search"></i> Buscar</button>
  </form>
    
<table class="table table-sm table-hover">
  <thead>
    <tr>
      <th scope="col">Cuenta</th>
      <th scope="col">Direccion</th>
      <th scope="col">Info</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>EH078001</td>
      <td><small class="form-text text-muted">Calle: FRANCISCO VILLA, 7801, Col. LUIS ECHEVERRIA, C.P.21505</small></td>
    <td>        
        <button type="button" class="btn btn-outline-primary btn-sm" style="padding:0%;border:0px;" data-toggle="modal" data-target="#exampleModalCenter">
            <img width="30" height="30" src="https://img.icons8.com/color/48/info--v1.png" alt="info--v1"/>
        </button>
    </td>
    </tr>
    <tr>
      <td>EH078003</td>
      <td><small class="form-text text-muted">Calle: PORFIRIO DIAZ, 0, Col. LUIS ECHEVERRIA, C.P.21505</small></td>
    <td>        
        <button type="button" class="btn btn-outline-primary btn-sm" style="padding:0%;border:0px;" data-toggle="modal" data-target="#exampleModalCenter">
            <img width="30" height="30" src="https://img.icons8.com/color/48/info--v1.png" alt="info--v1"/>
        </button>
    </td>
    </tr>
    <tr>
      <td>EH078004</td>
      <td><small class="form-text text-muted">Calle: VENUSTIANO CARRANZA, 1, 0, Col. LUIS ECHEVERRIA, LUIS ECHEVERRIA, C.P.21505</small></td>
    <td>        
        <button type="button" class="btn btn-outline-primary btn-sm" style="padding:0%;border:0px;" data-toggle="modal" data-target="#exampleModalCenter">
            <img width="30" height="30" src="https://img.icons8.com/color/48/info--v1.png" alt="info--v1"/>
        </button>
    </td>
    </tr>
    <tr>
      <td>EH080001</td>
      <td><small class="form-text text-muted">Calle: FRANCISCO VILLA, 0, 0, Col. LUIS ECHEVERRIA, LUIS ECHEVERRIA, C.P.21505</small></td>
    <td>        
        <button type="button" class="btn btn-outline-primary btn-sm" style="padding:0%;border:0px;" data-toggle="modal" data-target="#exampleModalCenter">
            <img width="30" height="30" src="https://img.icons8.com/color/48/info--v1.png" alt="info--v1"/>
        </button>
    </td>
    </tr>
    <tr>
      <td>AL016007</td>
      <td><small class="form-text text-muted">Calle: FRANCISCO VILLA, 0, 0, Col. LUIS ECHEVERRIA, LUIS ECHEVERRIA, C.P.21505</small></td>
    <td>        
        <button type="button" class="btn btn-outline-primary btn-sm" style="padding:0%;border:0px;" data-toggle="modal" data-target="#exampleModalCenter">
            <img width="30" height="30" src="https://img.icons8.com/color/48/info--v1.png" alt="info--v1"/>
        </button>
    </td>
    </tr>
    <tr>
      <td>EH078001</td>
      <td><small class="form-text text-muted">Calle: FRANCISCO VILLA, 7801, Col. LUIS ECHEVERRIA, C.P.21505</small></td>
    <td>        
        <button type="button" class="btn btn-outline-primary btn-sm" style="padding:0%;border:0px;" data-toggle="modal" data-target="#exampleModalCenter">
            <img width="30" height="30" src="https://img.icons8.com/color/48/info--v1.png" alt="info--v1"/>
        </button>
    </td>
    </tr>
    <tr>
      <td>EH078003</td>
      <td><small class="form-text text-muted">Calle: PORFIRIO DIAZ, 0, Col. LUIS ECHEVERRIA, C.P.21505</small></td>
    <td>        
        <button type="button" class="btn btn-outline-primary btn-sm" style="padding:0%;border:0px;" data-toggle="modal" data-target="#exampleModalCenter">
            <img width="30" height="30" src="https://img.icons8.com/color/48/info--v1.png" alt="info--v1"/>
        </button>
    </td>
    </tr>
    <tr>
      <td>EH078004</td>
      <td><small class="form-text text-muted">Calle: VENUSTIANO CARRANZA, 1, 0, Col. LUIS ECHEVERRIA, LUIS ECHEVERRIA, C.P.21505</small></td>
    <td>        
        <button type="button" class="btn btn-outline-primary btn-sm" style="padding:0%;border:0px;" data-toggle="modal" data-target="#exampleModalCenter">
            <img width="30" height="30" src="https://img.icons8.com/color/48/info--v1.png" alt="info--v1"/>
        </button>
    </td>
    </tr>
    <tr>
      <td>EH080001</td>
      <td><small class="form-text text-muted">Calle: FRANCISCO VILLA, 0, 0, Col. LUIS ECHEVERRIA, LUIS ECHEVERRIA, C.P.21505</small></td>
    <td>        
        <button type="button" class="btn btn-outline-primary btn-sm" style="padding:0%;border:0px;" data-toggle="modal" data-target="#exampleModalCenter">
            <img width="30" height="30" src="https://img.icons8.com/color/48/info--v1.png" alt="info--v1"/>
        </button>
    </td>
    </tr>
    <tr>
      <td>AL016007</td>
      <td><small class="form-text text-muted">Calle: FRANCISCO VILLA, 0, 0, Col. LUIS ECHEVERRIA, LUIS ECHEVERRIA, C.P.21505</small></td>
    <td>        
        <button type="button" class="btn btn-outline-primary btn-sm" style="padding:0%;border:0px;" data-toggle="modal" data-target="#exampleModalCenter">
            <img width="30" height="30" src="https://img.icons8.com/color/48/info--v1.png" alt="info--v1"/>
        </button>
    </td>
    </tr>
  </tbody>
</table>
    
    
<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" style="text-shadow: 0px 0px 2px #717171;">Cuenta: EH078001</h5>
      </div>
      <div class="modal-body">
          
          
          
        <small class="form-text text-muted">Propietario: IRMA ALICIA ORTIZ BALLESTEROS</small>
        <small class="form-text text-muted">Direccion: Calle FRANCISCO VILLA, 7801, Col. LUIS ECHEVERRIA, C.P.21505</small>
        <small class="form-text text-muted">Ubicación : 32.506460,-116.306920</small>
          <hr>
        <a href="https://www.google.com.mx/maps/preview" target="_blank" class="btn btn-outline-primary btn-sm" data-toggle="tooltip" data-placement="bottom" title="Editar"><img width="22" height="22" src="https://img.icons8.com/color/48/google-maps-new.png" alt="google-maps-new"/> Ver en Maps</a>
                &nbsp;
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary btn-sm"><i class="far fa-flag"></i> Marcar para Inspeccionar</button>
      </div>
    </div>
  </div>
</div>
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
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