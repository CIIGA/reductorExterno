<?php
require "../include/cnx.php";
$cnxPlz = conexion('implementtaTijuanaA');
// Obtener el ID del primer ComboBox
$idTarea = $_GET['idTarea'];

// Obtener datos para el segundo ComboBox desde la base de datos
$sql = "SELECT id, descripcion FROM CatalogoDescripcionTarea WHERE idtarea = ?";
$params = array($idTarea);
$options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
$result = sqlsrv_query($cnxPlz, $sql, $params, $options);

// Construir opciones para el segundo ComboBox
$options = "<option value=''>--selecciona una opción</option>";
while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    $options .= "<option value='" . $row['id'] . "'>" . utf8_encode($row['descripcion']) . "</option>";
}

echo $options;

sqlsrv_close($cnxPlz);
?>

