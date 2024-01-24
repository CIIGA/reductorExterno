<?php
function conexion($BD)
{
    $serverName = "51.222.44.135";
    $connectionInfo = array('Database' => $BD, 'UID' => 'sa', 'PWD' => 'vrSxHH3TdC');
    // $serverName = "DESKTOP-79KR1H4";
    // $connectionInfo = array('Database' => $BD, 'UID' => 'brayan', 'PWD' => '12345');
    $cnx = sqlsrv_connect($serverName, $connectionInfo);
    // date_default_timezone_set('America/Mexico_City');
    if ($cnx) {
        return $cnx;
    } else {
        echo "error de conexion";
        die(print_r(sqlsrv_errors(), true));
    }
}
?>