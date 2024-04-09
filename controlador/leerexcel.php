<?php
require_once '../modelo/SimpleXLSXE.php';
use Shuchkin\SimpleXLSX;
$excel_file= $_FILES['excelfile'];
$nombre = $excel_file['name'];


move_uploaded_file(
    // Temp image location
    $excel_file["tmp_name"],

    // New image location, __DIR__ is the location of the current PHP file
    $excel = (__DIR__ . "/excel/$nombre")

);

$guardar_excel = "../controlador" . "/excel/$nombre";


if ( $xlsx = SimpleXLSX::parse($guardar_excel) ) {
    print_r( $xlsx->rows() );
} else {
    echo SimpleXLSX::parseError();
}

?>