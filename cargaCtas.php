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
<title>Cargar Cuentas</title>
<link rel="icon" href="../icono/implementtaIcon.png">
<!-- Bootstrap -->
<link rel="stylesheet" href="../css/bootstrap.css">
<link rel="stylesheet" href="css/inputFile.css">
<link href="../fontawesome/css/all.css" rel="stylesheet">
<link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css"/>
<link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined" rel="stylesheet">
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
<?php require "include/nav.php"; ?>
    
<div class="container padding">
    <br>
    <h4 style="text-shadow: 0px 0px 2px #717171;"><img width="35" height="35" src="https://img.icons8.com/fluency/48/list.png" alt="list"/> Cuentas asignadas</h4>
    <br>
    

    
    
<form enctype='multipart/form-data'>
	<div class="upload-files-container">
		<div class="drag-file-area">
			<span class="material-icons-outlined upload-icon"> file_upload </span>
			<h3 class="dynamic-message"> Drag & drop any file here </h3>
			<label class="label"> o </label>
                
            <label class="label"><span class="browse-files"> <input type="file" class="default-file-input"/> <span class="browse-files-text">Busca un Archivo</span></span> </label>
		</div>
		<span class="cannot-upload-message"> <span class="material-icons-outlined">error</span> Please select a file first <span class="material-icons-outlined cancel-alert-button">cancel</span> </span>
		<div class="file-block">
			<div class="file-info"> <span class="material-icons-outlined file-icon">description</span> <span class="file-name"> </span> | <span class="file-size">  </span> </div>
			<span class="material-icons remove-file-icon">delete</span>
			<div class="progress-bar"> </div>
		</div>
		<button type="button" class="upload-button"> Upload </button>
	</div>
</form>
    
    
    
    
    
    
    
    
    
    
    
    
    
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
<script src="js/inputFile.js"></script>      
</html>