<?php

require '../vendor/autoload.php';
require_once '../modelo/MySQL.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

date_default_timezone_set('America/Bogota');

//echo '<script src="../assets/js/htmltoexcel.js"></script>';



$mysql = new MySQL();
$mysql->conectar();

$result = $mysql->efectuarConsulta("SELECT * FROM fichas");
$mysql->desconectar();

$fichas = mysqli_fetch_all($result);
$tabla = "";
$nombres = [];
$contador = 0;

$spreadsheet = new Spreadsheet();

// Set document properties
$spreadsheet->getProperties()->setCreator('SENA APP')
    ->setTitle('Formatos de los aprendices');

    
for ($i = 0; $i < count($fichas); $i++) {

    $GLOBALS["contador"] +=1;
   
 
    // Add some data
    $spreadsheet->setActiveSheetIndex($i)
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
    $consulta = $mysql->efectuarConsulta("SELECT * FROM  ingresados WHERE ficha =" . $fichas[$i][0]);
    $mysql->desconectar();

    $data = mysqli_fetch_all($consulta);

    foreach ($data as $rowData) {

        $spreadsheet->setActiveSheetIndex($i)

            ->setCellValue('A' . $row, $rowData[1])
            ->setCellValue('B' . $row, $rowData[2])
            ->setCellValue('C' . $row, $rowData[3])
            ->setCellValue('D' . $row, $rowData[4])
            ->setCellValue('E' . $row, $rowData[5])
            ->setCellValue('F' . $row, $rowData[6]);
        $row++;
    }

    // Rename worksheet
    $spreadsheet->getActiveSheet()->setTitle($fichas[$i][0]);
    if($GLOBALS["contador"]> 1){
        $spreadsheet->getActiveSheet()->getTabColor()->setARGB('07b107');
        $GLOBALS["contador"] = 0;
    }
 
    if ($i < count($fichas) - 1) {
        $spreadsheet->createSheet();
    }
    $sheet = $spreadsheet->getActiveSheet();
    foreach (range('A', $sheet->getHighestColumn()) as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
     }
}

header('Content-Disposition: attachment;filename="'. date("Y-m-d H:i:s").'.xlsx"');


$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

?>