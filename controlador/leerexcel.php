<?php
require_once '../modelo/SimpleXLSXE.php';

use Shuchkin\SimpleXLSX;

$excel_file = $_FILES['excelfile'];
$nombre = $excel_file['name'];
require_once '../modelo/MySQL.php';

use Shuchkin\SimpleXLS;

require_once '../modelo/SimpleXLS.php';
move_uploaded_file(
    // Ubicación temporal
    $excel_file["tmp_name"],


    //Hace una copia del archivo en la carpeta excel

    $excel = (__DIR__ . "/excel/$nombre")

);
//Crea una variable para guardar la nueva ruta del archivo

$guardar_excel = "../controlador" . "/excel/$nombre";
//Pasa el string a un arreglo para poder separar el nombre del archivo y la extension

$arregloformato = explode('.', $guardar_excel);
//obtinene la extensió del archivo
$extension = end($arregloformato);


//si es un archivo xls lo abre con SimpleXLS

if ($extension == "xls") {
    if ($xlsx = SimpleXLS::parse($guardar_excel)) {

        ArregloDatos($xlsx->rows());
    } else {
        echo SimpleXLS::parseError();
    }
} elseif ($extension == "xlsx") {
    //si es un archivo xlsx lo abre con SimpleXLSX

    if ($xlsx = SimpleXLSX::parse($guardar_excel)) {


        ArregloDatos($xlsx->rows());
    } else {
        echo SimpleXLSX::parseError();
    }
}



function ArregloDatos($Datos)
{
    $mysql = new MySQL();
    $mysql->conectar();

    foreach ($Datos as $index => $v) {

        if (!empty($Datos[2 + $index][2]) && !empty($Datos[2 + $index][3])) {

            // echo $Datos[2+$index][2]  .' = '.$Datos[2+$index][3] .'<br>' ;
            echo  $Datos[2 + $index][2];
            echo  "<br>";

            $result = $mysql->efectuarConsulta("SELECT * FROM ingresados where documento = " . $Datos[2 + $index][2]);

            // $fila = mysqli_fetch_assoc($result);
            $row_count = $result->num_rows;

            if ($row_count == 1) {
                echo  "Se ha inscrito antes (I)";
                echo  "<br>";
                //$result = $mysql->efectuarConsulta("insert into ingresados values (null,Cargando,null,".$Datos[2+$index][3].",Preinscrito,".$Datos[2+$index][2].",".$Datos[2+$index][1].")");
                $result = $mysql->efectuarConsulta("SELECT * FROM cursos_aprendiz where documento = " . $Datos[2 + $index][2]);

                // $fila = mysqli_fetch_assoc($result);
                $row_count2 = $result->num_rows;


                if ($row_count2 == 0) {

                    echo  "No esta en otro curso (X)";
                  

                    // echo "insert into ingresados values (null,Cargando,null,".$Datos[2+$index][3].",Proceso,".$Datos[2+$index][2].",".$Datos[2+$index][1].")" . "<br>";
                } elseif ($row_count2 == 1) {
                    echo  "Esta en otro curso (O)";
                   

                    $result = $mysql->efectuarConsulta("SELECT * FROM cursos_aprendiz where documento = " . $Datos[2 + $index][2] . " and inscripcion between '".date("Y")."-01-01' and '".date("Y")."-12-31'");
                   // $fila = mysqli_fetch_assoc($result);
                    $row_count3 = $result->num_rows;
                    if ($row_count3 == 1) {
                        echo  "<br>";
                        echo  "Se encuentra registrado en un curso en el año actual (R)";
              
                        $result = $mysql->efectuarConsulta("SELECT * FROM cursos_aprendiz where documento = " . $Datos[2 + $index][2].  " and ficha = " . $Datos[2 + $index][3]);

                        // $fila = mysqli_fetch_assoc($result);
                         $row_count4 = $result->num_rows;

                         if($row_count4 == 1){

                            echo  "<br>";
                            echo  "Ya ha hecho este curso";
                  
                         }
                    }
                    if ($row_count3 == 0) {
                        echo  "<br>";
                        echo  "Se encuentra registrado en un curso pero ya pasó la fecha (F)";
                       
                        $result = $mysql->efectuarConsulta("SELECT * FROM cursos_aprendiz where documento = " . $Datos[2 + $index][2].  " and ficha = " . $Datos[2 + $index][3]);
                        // $fila = mysqli_fetch_assoc($result);
                         $row_count4 = $result->num_rows;

                         if($row_count4 == 1){

                            echo  "<br>";
                            echo  "Un curso diferente";
                  
                         }
                    }
                }
            }

            if ($row_count == 0) {
                echo  "No se ha inscrito antes (N)";
                
            }
            echo  "<br>------------------<br>";
        }
    }
    $mysql->desconectar();
}
