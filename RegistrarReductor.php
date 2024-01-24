<?php
session_start();
if (isset($_SESSION['AspUsr']) and isset($_SESSION['cuenta'])) {
    require "include/cnx.php";
    $cnxPlz = conexion('implementtaTijuanaA');

    // if (isset($_POST['idTarea']) and isset($_POST['iddescripciontarea']) 
    // and isset($_POST['idTipoServicio']) and isset($_POST['idEstatusToma']) 
    // and isset($_POST['latitud']) and isset($_POST['longitud']) and
    // !empty($_POST['idTarea']) and !empty($_POST['iddescripciontarea']) 
    // and !empty($_POST['idTipoServicio']) and !empty($_POST['idEstatusToma']) 
    // and !empty($_POST['latitud']) and !empty($_POST['longitud'])) {
    if (
        isset($_POST['idTarea']) and isset($_POST['iddescripciontarea'])
        and isset($_POST['idTipoServicio']) and isset($_POST['idEstatusToma'])
        and isset($_POST['latitud']) and isset($_POST['longitud']) and
        !empty($_POST['idTarea']) and !empty($_POST['iddescripciontarea'])
    ) {

        $idTipoServicio = $_POST['idTipoServicio'];
        $idtarea = $_POST['idTarea'];
        $iddescripciontarea = $_POST['iddescripciontarea'];
        $id_niple = $_POST['id_niple'];
        $idCatalogoreductores = $_POST['idCatalogoreductores'];
        $lectura = $_POST['lectura'];
        $idEstatusToma = $_POST['idEstatusToma'];
        $idTipoToma = $_POST['idTipoToma'];
        $observaciones = $_POST['observaciones'];
        $FechaPromesaPago = $_POST['FechaPromesaPago'];
        $FechaVencimiento = $_POST['FechaVencimiento'];
        $latitud = $_POST['latitud'];
        $longitud = $_POST['longitud'];
        $id_user = $_SESSION['AspUsr'];
        $cuenta = trim($_SESSION['cuenta']);
        $fechaCaptura = date('Y-m-d') . ' ' . date('H:i:s');


        $fechaActual = date('Ymd');
        $horaActual = date('His');

        $ruta_temporal_evidencia = $_FILES["foto1"]["tmp_name"];
        $ruta_temporal_predio = $_FILES["foto2"]["tmp_name"];

        // Mover el archivo a una ubicación permanente en tu proyecto
        $directorio_destino_evidencia = "fotos/evidencia/";
        $directorio_destino_predio = "fotos/predio/";
        $ruta_destino_evidencia = $directorio_destino_evidencia . 'evidencia' . $cuenta . '_' . $fechaActual . '_' . $horaActual . '.jpg';
        $ruta_destino_predio = $directorio_destino_predio . 'predio' . $cuenta . '_' . $fechaActual . '_' . $horaActual . '.jpg';
        move_uploaded_file($ruta_temporal_evidencia, $ruta_destino_evidencia);
        move_uploaded_file($ruta_temporal_predio, $ruta_destino_predio);

        // Guardar la ruta en la base de datos
        // (Asegúrate de usar funciones seguras para evitar inyección SQL)
        $ruta_db_evidencia = "C:/wamp64/www/reductorExterno/$ruta_destino_evidencia";
        $ruta_db_predio = "C:/wamp64/www/reductorExterno/$ruta_destino_predio";

        $sql_insert = sqlsrv_query($cnxPlz, "INSERT INTO registroReductorExterno (Cuenta,idTarea,idCatalogoreductores,lectura,
        id_niple,observaciones,FechaPromesaPago,fechaVencimiento,fechaCaptura,iddescripciontarea,Latitud,Longitud,IdAspUser,
        idTipoServicio,idEstatusToma,idTipoToma) values ('$cuenta','$idtarea','$idCatalogoreductores','$lectura',
        '$id_niple','$observaciones','$FechaPromesaPago','$FechaVencimiento','$fechaCaptura','$iddescripciontarea','$latitud','$longitud',
        '$id_user','$idTipoServicio','$idEstatusToma','$idTipoToma')");
        if ($sql_insert) {
            $sql_id_ReductorExterno = sqlsrv_query($cnxPlz, "select top 1 idRegistroReductores as id from registroReductorExterno
            where Cuenta='$cuenta' and fechaCaptura='$fechaCaptura'");
            $array_id_ReductorExterno = sqlsrv_fetch_array($sql_id_ReductorExterno);
            $id_ReductorExterno = $array_id_ReductorExterno['id'];
            $sql_foto = sqlsrv_query($cnxPlz, "insert into FotosReductorExterno (ubicacion,id_ReductorExterno,tipo) values
            ('$ruta_db_evidencia','$id_ReductorExterno','E'),
            ('$ruta_db_predio','$id_ReductorExterno','P')");
            if ($sql_foto) {
                $_SESSION['registro_success'] = 'Datos almacenados correctamente.';
                header("Location: verificar.php");
            } else {
                $_SESSION['foto_error'] = 'Error al guardar las fotos.';
                header("Location: formulario.php");
            }
        }else {
            $_SESSION['registro_error'] = 'Error al guardar los datos.';
            header("Location: formulario.php");
        }
    } else {
        $_SESSION['error_vacio'] = 'Llene los campos obligatorios antes de continuar';
        header("Location: formulario.php");
    }
} else {
    header("Location: index.php");
    exit();
}
