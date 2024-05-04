<?php

require '../vendor/autoload.php';
require_once '../modelo/MySQL.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

date_default_timezone_set('America/Bogota');

//echo '<script src="../assets/js/htmltoexcel.js"></script>';



$mysql = new MySQL();
$mysql->conectar();

$result = $mysql->efectuarConsulta("SELECT ficha FROM `ingresados` GROUP BY ficha;");
$mysql->desconectar();


$tabla = "";
$nombres = [];


$spreadsheet = new Spreadsheet();

// Set document properties
$spreadsheet->getProperties()->setCreator('SENA APP')
    ->setTitle('Formatos de los aprendices');


 
    // Add some data
    $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A1', 'Nombre completo')
        ->setCellValue('B1', 'Fecha de ingreso')
        ->setCellValue('C1', 'Ficha')
        ->setCellValue('D1', 'Estado')
        ->setCellValue('E1', 'Documento')
        ->setCellValue('F1', 'Tipo de documento');
    // Suppose your HTML table data is in an array


    // Write data to Excel
    $row = 2; // Start from second row, because first row is for column names
    $mysql = new MySQL();
    $mysql->conectar();
    // Realizar la consulta SQL para buscar la ficha
    $consulta = $mysql->efectuarConsulta("SELECT * FROM  ingresados");
    $mysql->desconectar();

    $data = mysqli_fetch_all($consulta);

    
    $sheet = $spreadsheet->getActiveSheet();
    foreach (range('A', $sheet->getHighestColumn()) as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
     }
    foreach ($data as $rowData) {

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A' . $row, $rowData[1])
            ->setCellValue('B' . $row, $rowData[2])
            ->setCellValue('C' . $row, $rowData[3])
            ->setCellValue('D' . $row, $rowData[4])
            ->setCellValue('E' . $row, $rowData[5])
            ->setCellValue('F' . $row, $rowData[6]);
            $row++;
    }

  


header('Content-Disposition: attachment;filename="'. date("Y-m-d H:i:s").'.xlsx"');


$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

?>