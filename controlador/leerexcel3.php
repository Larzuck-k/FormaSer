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

if ($extension != "xls" && $extension != "xlsx") {

    echo '<form id="form" method="post" action="../index.php"><input type="hidden" name="error" value="El formato del archivo no es compatible"></form>
     
    <script>document.getElementById("form").submit();</script>
    ';
}


function ArregloDatos($Datos)
{
    $tabla = '';
    $mysql = new MySQL();

    $mysql->conectar();

    $tabla .= '<table id="tabla2"  class="datatable table table-striped " style="width:100%">
    <thead>
    <tr>
        <th scope="col">Número de documento</th>
        <th scope="col">Nombre completo</th>
        <th scope="col">fecha</th>
        <th scope="col">ficha</th>
        <th scope="col">estado</th>

    </tr>
    </thead>
    <tbody>';



    if (isset($Datos[2][0]) && isset($Datos[3][0])) {
        $DatoNuevo = [];
        if ($Datos[2][0] != "Código Ficha" && $Datos[3][0] !=  "Programa de Formación") {

            $guardar_excel = "../controlador" . "/excel/" . $GLOBALS['nombre'];

            $arregloformato = explode('.', $guardar_excel);
            //obtinene la extensió del archivo
            $extension = end($arregloformato);

            if ($extension == "xls") {
                if ($xlsx = SimpleXLS::parse($guardar_excel)) {

                    $DatoNuevo = $xlsx->rows(1);
                } else {
                    echo SimpleXLS::parseError();
                }
            } elseif ($extension == "xlsx") {
                //si es un archivo xlsx lo abre con SimpleXLSX

                if ($xlsx = SimpleXLSX::parse($guardar_excel)) {


                    $DatoNuevo = $xlsx->rows(1);
                } else {
                    echo SimpleXLSX::parseError();
                }
            }
            date_default_timezone_set("America/Bogota");

            if ($DatoNuevo[0][0] == "CC" && $DatoNuevo[0][1] == "FICHA") {



                foreach ($DatoNuevo as $index => $v) {
                    if (isset($DatoNuevo[$index + 1][0])) {
                        $GLOBALS['$DatosV2'][$index][0] = $DatoNuevo[$index + 1][0]; //Documento
                        $GLOBALS['$DatosV2'][$index][1] = $DatoNuevo[$index + 1][1]; //Ficha
                        $GLOBALS['$DatosV2'][$index][4] = $DatoNuevo[$index + 1][7]; //Fecha Inicio
                        $GLOBALS['$DatosV2'][$index][2] = $DatoNuevo[$index + 1][3] . " " . $DatoNuevo[$index + 1][4]; //Nombre Completo
                        $GLOBALS['$DatosV2'][$index][3] = "CC"; //Tipo
                    }

                    $result = $mysql->efectuarConsulta("SELECT * FROM Fichas where ficha = " . $DatoNuevo[$index][1]);

                    $row_count = $result->num_rows;
                    $fecha = date("Y-m-d", strtotime(str_replace("/", "-", $DatoNuevo[$index][7])));
                    if ($row_count <= 0) {


                        $result = $mysql->efectuarConsulta('Insert Into Fichas values(' . $DatoNuevo[$index][1]  . ',"' . $DatoNuevo[$index][2] . '","' . $fecha . '")');
                    }
                }




                $Datos = $GLOBALS['$DatosV2'];
                foreach ($Datos as $key => $value) {
                    if (isset($Datos[6 + $key][0])) {


                        $resultU = $mysql->efectuarConsulta("SELECT * FROM ingresados where documento =" . $Datos[$key][0] . " and ficha=" . $Datos[$key][1]);
                        //    $array = mysqli_fetch_all($result, 1);

                        $row_countU = $resultU->num_rows;

                        if ($row_countU == 0) {

                            $fecha = date("Y-m-d", strtotime(str_replace("/", "-", $Datos[$key][4])));

                            $mysql->efectuarConsulta('Insert into ingresados values(null,"' . $Datos[$key][2] . '" ,"' .    $fecha . '",' . $Datos[$key][1] . ' ,"Matriculado",' . preg_replace("/[^0-9\.]/", "", $Datos[$key][0])  . ',"CC")');


                            $tabla .= ' 
    <td scope="row"><a href="#">' . $Datos[$key][0] . '</a></td>
    <td>' . $Datos[$key][2] . '</td>
    <td>' . $Datos[$key][4] . '</td>
    <td><a href="#" class="text-primary">' . $Datos[$key][1] . '</a></td>
    <td><span class=^badge bg-success^>Matriculado</span>';


                            $result2 = $mysql->efectuarConsulta('SELECT * FROM cursos_aprendiz where documento = ' . preg_replace("/[^0-9\.]/", "", $Datos[$key][0]) . ' and ficha =' . $Datos[$key][1]);

                            $row_count2 = $result2->num_rows;
                            if ($row_count2 == 0) {

                                $mysql->efectuarConsulta('INSERT INTO `cursos_aprendiz`  VALUES (NULL, ' . preg_replace("/[^0-9\.]/", "", $Datos[$key][0]) . ', "' .  $fecha . '", ' . $Datos[$key][1] . ') ');
                            }
                        }
                        if ($row_count == 1) {

                            $mysql->efectuarConsulta('UPDATE ingresados SET nombre_completo="' . $Datos[$key][2] . '",fecha_ingreso="' . $fecha .  '",ficha=' . $Datos[$key][1] . ',estado="Matriculado",documento=' . preg_replace("/[^0-9\.]/", "", $Datos[$key][0]) . ',tipo_documento="CC" where documento=' . preg_replace("/[^0-9\.]/", "", $Datos[$key][0]) . ' and ficha = ' . $Datos[$key][1]);


                            $tabla .= ' 
    <td scope="row"><a href="#">' . $Datos[$key][0] . '</a></td>
    <td>' . $Datos[$key][2] . '</td>
    <td>' . $Datos[$key][4] . '</td>
    <td><a href="#" class="text-primary">' . $Datos[$key][1] . '</a></td>
    <td><span class=^badge bg-success^>Matriculado</span>';
                        }
                    }
                    $tabla .= '</td>
                    
</tr>';
                }
            }
            else{

         
                    echo '<form id="form" method="post" action="../index.php"><input type="hidden" name="tab3" value="true"><input type="hidden" name="error" value="El formato del archivo no es compatible"></form><script>document.getElementById("form").submit();</script>';
                      
                
             
                
            }



            $tabla .= ' </tbody>
        </table>';

            Enviar($tabla);


            $mysql->desconectar();
            //   echo '<form id="form" method="post" action="../index.php"><input type="hidden" name="tab3" value="true"><input type="hidden" name="error" value="El formato del archivo no es compatible"></form><script>document.getElementById("form").submit();</script>';
        } else {

            if (isset($Datos[6][2])) {

                if ($Datos[6][2] != "Matriculado " && str_contains($Datos[6][2], "Anulado") == false) {

                    echo '<form id="form" method="post" action="../index.php"><input type="hidden" name="tab3" value="true"><input type="hidden" name="error" value="El formato del archivo no es compatible"></form><script>document.getElementById("form").submit();</script>';
                }
            }

            $result = $mysql->efectuarConsulta("SELECT * FROM Fichas where ficha = " . $Datos[2][1]);

            $row_count = $result->num_rows;


            if ($row_count <= 0) {


                $result = $mysql->efectuarConsulta('Insert Into Fichas values(' . $Datos[2][1] . ',"' . $Datos[3][1] . '","' . date("Y-m-d") . '")');
            }

            foreach ($Datos as $index => $v) {


                if (!empty($Datos[6 + $index][0]) && !empty($Datos[2][1])) {



                    $result = $mysql->efectuarConsulta("SELECT * FROM ingresados where documento = ".preg_replace("/[^0-9\.]/", "", $Datos[6 + $index][0]));
                    $array = mysqli_fetch_all($result, 1);

                    $row_count = $result->num_rows;


                    foreach ($array as $key => $value) {

     
                        if (preg_replace("/[^0-9\.]/", "", $Datos[6 + $index][0]) == $array[$key]["documento"] && $Datos[2][1] == $array[$key]["ficha"] && str_contains($Datos[6 + $index][2], "Matriculado")) {

                            $tabla .= ' 
                                 <td scope="row"><a href="#">' . $Datos[6 + $index][0] . '</a></td>
                                <td>' . $Datos[6 + $index][1] . '</td>
                                <td>' .  date("Y-m-d"). '</td>
                                <td><a href="#" class="text-primary">' . $Datos[2][1] . '</a></td>
                                <td><span class=^badge bg-success^>Matriculado</span>';
                            $result = $mysql->efectuarConsulta('UPDATE  ingresados set estado = "Matriculado",nombre_completo = "' . $Datos[6 + $index][1] . '"  where documento = ' . preg_replace("/[^0-9\.]/", "", $Datos[6 + $index][0]));


                            $result = $mysql->efectuarConsulta('SELECT * FROM cursos_aprendiz where documento = ' . preg_replace("/[^0-9\.]/", "", $Datos[6 + $index][0]) . ' and ficha =' . $Datos[2][1]);

                            $row_count = $result->num_rows;
                            if ($row_count == 0) {
                                $result = $mysql->efectuarConsulta('INSERT INTO `cursos_aprendiz`  VALUES (NULL, ' . preg_replace("/[^0-9\.]/", "", $Datos[6 + $index][0]) . ', "' . date("Y-m-d") . '", ' . $Datos[2][1] . ') ');
                            }
                        }



                        if (preg_replace("/[^0-9\.]/", "", $Datos[6 + $index][0]) == $array[$key]["documento"] && $Datos[2][1] == $array[$key]["ficha"] && str_contains($Datos[6 + $index][2], "Anulado")) {

                            $result = $mysql->efectuarConsulta('UPDATE  ingresados set estado = "Anulado",nombre_completo = "' . $Datos[6 + $index][1] . '"  where documento = ' . preg_replace("/[^0-9\.]/", "", $Datos[6 + $index][0]));
                            $tabla .= ' 
                           <td scope="row"><a href="#">' . $Datos[6 + $index][0] . '</a></td>
                           <td>' . $Datos[6 + $index][1] . '</td>
                           <td>' .  date("Y-m-d"). '</td>
                           <td><a href="#" class="text-primary">' . $Datos[2][1] . '</a></td>
                           <td><span class=^badge bg-dark^>Anulado</span>';
                        }
                    }


                    $result = $mysql->efectuarConsulta("SELECT * FROM ingresados where documento = " . preg_replace("/[^0-9\.]/", "", $Datos[6 + $index][0]));
                    $array = mysqli_fetch_all($result, 1);
                    $row_count = $result->num_rows;
                    if ($row_count == 0) {

                        $tabla .= ' 
                            <td scope="row"><a href="#">' . $Datos[6 + $index][0] . '</a></td>
                            <td>' . $Datos[6 + $index][1] . '</td>
                            <td>' .    date("Y-m-d")  . '</td>
                            <td><a href="#" class="text-primary">' . $Datos[2][1] . '</a></td>
                            <td><span class=^badge bg-success^>Matriculado</span>';

                        $mysql->efectuarConsulta('Insert into ingresados values(null,"' . $Datos[6 + $index][1] . '" ,"' . date("Y-m-d"). '",' . $Datos[2][1] . ' ,"Matriculado",' . preg_replace("/[^0-9\.]/", "", $Datos[6 + $index][0]) . ' ,"' . preg_replace("/[^A-Z\.]/", "", $Datos[6 + $index][0]) . '")');


                        $result = $mysql->efectuarConsulta('SELECT * FROM cursos_aprendiz where documento = ' . preg_replace("/[^0-9\.]/", "", $Datos[6 + $index][0]) . ' and ficha =' . $Datos[2][1]);

                        $row_count = $result->num_rows;
                        if ($row_count == 0) {
                            $result = $mysql->efectuarConsulta('INSERT INTO `cursos_aprendiz`  VALUES (NULL, ' . preg_replace("/[^0-9\.]/", "", $Datos[6 + $index][0]) . ', "' . date("Y-m-d") . '", ' . $Datos[2][1] . ') ');
                        }
                    }
                    $tabla .= '</td>
                    
                    </tr>';
                }
            }

            $tabla .= ' </tbody>
            </table>';

            Enviar($tabla);


            $mysql->desconectar();
        }
    }
}


function Enviar($Dato)
{


    echo '<form id="form" method="post" action="../index.php"><input type="hidden" name="tabla3" value="' . str_replace('"', '^', $Dato) . '"><input type="hidden" name="tab3" value="true"></form><script>document.getElementById("form").submit();</script>';
}
