<?php
require "../include/cnx.php";
$cnxPlz = conexion('implementtaTijuanaA');

// Obtener datos para el segundo ComboBox desde la base de datos
$sql = "select * from CatalogoNIple";
$result = sqlsrv_query($cnxPlz, $sql, $options);

// Construir opciones para el segundo ComboBox
$options = "";
while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    $options .= "<option value='" . $row['idniple'] . "'>" . utf8_encode($row['descripcion']) . "</option>";
}

echo $options;

sqlsrv_close($cnxPlz);
?>

