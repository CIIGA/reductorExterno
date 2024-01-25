<?php

if(isset($_GET['fIni']) and isset($_GET['fFin'])){
    require_once('PhpSpreadsheet/vendor/autoload.php');

    $nombrePlaza = 'Tijuana Agua';

    $fInicial = $_GET['fIni'].' 00:00:00.000';
    $fFinal = $_GET['fFin'].' 23:59:59.999';

    $serverName = "51.222.44.135";
    $connectionInfo = array( 'Database' => 'implementtaTijuanaA', 'UID'=>'sa', 'PWD'=>'vrSxHH3TdC');
    $cnx = sqlsrv_connect($serverName, $connectionInfo);
    date_default_timezone_set('America/Mexico_City');

    if($cnx == false){
       echo "<script> alert('No es valida la plaza selecionada, no se puede generar el reporte'); </script>";
       exit();
    }
    
    $peticionExcel = new PhpOffice\PhpSpreadsheet\Spreadsheet();

    // delete the default active sheet
    $peticionExcel->removeSheetByIndex(0);

    // Create "Sheet 1" tab as the first worksheet.
    $hojaL = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($peticionExcel, "Hoja 1");

    $peticionExcel->addSheet($hojaL, 0);
    
    $encabezado = [ "Cuenta",
                    "idTarea",
                    "lectura",
                    "medidor",
                    "reductor",
                    "telefono",
                    "observaciones",
                    "contacto",
                    "FechaPromesaPago",
                    "fechaAsignacion",
                    "fechaVencimiento",
                    "fechaCaptura",
                    "Latitud",
                    "Longitud",
                    "FolioSS",
                    "IdAspUser", //--
                    "horainicial",
                    "horafinal",
                    "idTipoServicio",
                    "idEstatusToma",
                    "idTipoToma",
                    "descripcionTomaDirecta",
                    "idDescripcionMulta",
                    "idDetalle",
                    "idMedidorTapado",
                    "idTipoReductor",
                    "noCincho",
                    "idEstatusRequerimiento",
                    "fechaSincronizacion",
                    "folioSelloCorte",
                    "idTipoCorte",
                    "comentarioNoSuspendeServicio",
                    "resultadoSuperviso" ];

    $hojaL->fromArray($encabezado, null, 'A1');
    
    $datos = sqlsrv_query($cnx,"SELECT * FROM registroReductorExterno where convert(date,fechaCaptura) between ? and ? ", array($fInicial, $fFinal) );

    $rowImple = null;
    if($datos != false){
        
        $rowImple = sqlsrv_fetch_array($datos);
        
        
        $numeroDeFila = 2;
        $hasDatos = false;

        while ($rowImple) {

            if( gettype($rowImple['FechaPromesaPago']) != 'string' and $rowImple['FechaPromesaPago'] != null ){
                $fecha1 = trim( $rowImple['FechaPromesaPago']->format('Y/m/d H:i:s') ); 
            }else{ 
                $fecha1 = trim( $rowImple['FechaPromesaPago'] );
            }

            if( gettype($rowImple['fechaAsignacion']) != 'string' and $rowImple['fechaAsignacion'] != null ){
                $fecha2 = trim( $rowImple['fechaAsignacion']->format('Y/m/d H:i:s') ); 
            }else{ 
                $fecha2 = trim( $rowImple['fechaAsignacion'] );
            }

            if( gettype($rowImple['fechaVencimiento']) != 'string' and $rowImple['fechaVencimiento'] != null ){
                $fecha3 = trim( $rowImple['fechaVencimiento']->format('Y/m/d H:i:s') ); 
            }else{ 
                $fecha3 = trim( $rowImple['fechaVencimiento'] );
            }

            if( gettype($rowImple['fechaCaptura']) != 'string' and $rowImple['fechaCaptura'] != null ){
                $fecha4 = trim( $rowImple['fechaCaptura']->format('Y/m/d H:i:s') ); 
            }else{ 
                $fecha4 = trim( $rowImple['fechaCaptura'] );
            }

            $lat = ($rowImple['Latitud'] != null) ? $rowImple['Latitud'] : 'Sin dato';
            $long = ($rowImple['Longitud']!= null) ? $rowImple['Longitud'] : 'Sin dato';
            
            $hojaL->getCell("A".$numeroDeFila)->setValueExplicit($rowImple['Cuenta'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $hojaL->setCellValueByColumnAndRow(2, $numeroDeFila, utf8_encode($rowImple['idTarea'] ) );
            $hojaL->setCellValueByColumnAndRow(3, $numeroDeFila, utf8_encode($rowImple['lectura'] ) );
            $hojaL->setCellValueByColumnAndRow(4, $numeroDeFila, utf8_encode($rowImple['medidor'] ) );
            $hojaL->setCellValueByColumnAndRow(5, $numeroDeFila, utf8_encode($rowImple['reductor'] ) );
            $hojaL->setCellValueByColumnAndRow(6, $numeroDeFila, utf8_encode($rowImple['telefono'] ) );
            $hojaL->setCellValueByColumnAndRow(7, $numeroDeFila, utf8_encode($rowImple['observaciones'] ) );
            $hojaL->setCellValueByColumnAndRow(8, $numeroDeFila, utf8_encode($rowImple['contacto'] ) );
            $hojaL->setCellValueByColumnAndRow(9, $numeroDeFila, $fecha1 );
            $hojaL->setCellValueByColumnAndRow(10, $numeroDeFila, $fecha2 );
            $hojaL->setCellValueByColumnAndRow(11, $numeroDeFila, $fecha3 );
            $hojaL->setCellValueByColumnAndRow(12, $numeroDeFila, $fecha4 );
            $hojaL->setCellValueByColumnAndRow(13, $numeroDeFila, $lat );
            $hojaL->setCellValueByColumnAndRow(14, $numeroDeFila, $long );
            $hojaL->setCellValueByColumnAndRow(15, $numeroDeFila, utf8_encode($rowImple['FolioSS'] ) );
            $hojaL->setCellValueByColumnAndRow(16, $numeroDeFila, utf8_encode($rowImple['IdAspUser'] ) ); //-------
            $hojaL->setCellValueByColumnAndRow(17, $numeroDeFila, utf8_encode($rowImple['horainicial'] ) );
            $hojaL->setCellValueByColumnAndRow(18, $numeroDeFila, utf8_encode($rowImple['horafinal'] ) );
            $hojaL->setCellValueByColumnAndRow(19, $numeroDeFila, utf8_encode($rowImple['idTipoServicio'] ) );
            $hojaL->setCellValueByColumnAndRow(20, $numeroDeFila, utf8_encode($rowImple['idEstatusToma'] ) );
            $hojaL->setCellValueByColumnAndRow(21, $numeroDeFila, utf8_encode($rowImple['idTipoToma'] ) );
            $hojaL->setCellValueByColumnAndRow(22, $numeroDeFila, utf8_encode($rowImple['descripcionTomaDirecta'] ) );
            $hojaL->setCellValueByColumnAndRow(23, $numeroDeFila, utf8_encode($rowImple['idDescripcionMulta'] ) );
            $hojaL->setCellValueByColumnAndRow(24, $numeroDeFila, utf8_encode($rowImple['idDetalle'] ) );
            $hojaL->setCellValueByColumnAndRow(25, $numeroDeFila, utf8_encode($rowImple['idMedidorTapado'] ) );
            $hojaL->setCellValueByColumnAndRow(26, $numeroDeFila, utf8_encode($rowImple['idTipoReductor'] ) );
            $hojaL->setCellValueByColumnAndRow(27, $numeroDeFila, utf8_encode($rowImple['noCincho'] ) );
            $hojaL->setCellValueByColumnAndRow(28, $numeroDeFila, utf8_encode($rowImple['idEstatusRequerimiento'] ) );
            $hojaL->setCellValueByColumnAndRow(29, $numeroDeFila, utf8_encode($rowImple['fechaSincronizacion'] ) );
            $hojaL->setCellValueByColumnAndRow(30, $numeroDeFila, utf8_encode($rowImple['folioSelloCorte'] ) );
            $hojaL->setCellValueByColumnAndRow(31, $numeroDeFila, utf8_encode($rowImple['idTipoCorte'] ) );
            $hojaL->setCellValueByColumnAndRow(32, $numeroDeFila, utf8_encode($rowImple['comentarioNoSuspendeServicio'] ) );
            $hojaL->setCellValueByColumnAndRow(33, $numeroDeFila, utf8_encode($rowImple['resultadoSuperviso'] ) );
        
            $numeroDeFila++;
            $hasDatos = true;
        

            $rowImple = sqlsrv_fetch_array($datos);
        }
        
        foreach ($hojaL->getColumnIterator() as $column)
        {
            $hojaL->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }

        // Create the table
        if($hasDatos){
            $table = new PhpOffice\PhpSpreadsheet\Worksheet\Table('A1:AG'.($numeroDeFila-1), 'Table1');

            // Optional: apply some styling to the table
            $tableStyle = new PhpOffice\PhpSpreadsheet\Worksheet\Table\TableStyle();
            $tableStyle->setTheme(PhpOffice\PhpSpreadsheet\Worksheet\Table\TableStyle::TABLE_STYLE_MEDIUM9);
            $tableStyle->setShowRowStripes(true);
            $table->setStyle($tableStyle);
    
            // Add the table to the sheet
            $hojaL->addTable($table);
        }

        // Save to file.
    
        $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($peticionExcel);
        $fileName = "Reporte_reductores_$nombrePlaza.xlsx";

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'.$fileName.'"');

        $writer->save('php://output');
        //$writer->save($fileName);
    }else{
        //print_r(sqlsrv_errors());
        sqlsrv_close($cnx);
        echo "<script> alert('Hubo un problema, intentelo de nuevo'); </script>";
        //header('Location: cargaCuentasReductores.php');
        exit();
    }
        sqlsrv_close($cnx);
        
    
}else{
    echo "<script> alert('Faltan parametros para realizar esta accion'); </script>";
}

?>