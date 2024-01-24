<?php
session_start();
session_destroy();
$_SESSION['dataB']=NULL;
$_SESSION['AspUsr']=NULL;
echo '<meta http-equiv="refresh" content="0,url=../reductorExterno/">';
?>