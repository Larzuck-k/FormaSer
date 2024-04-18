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

        ArregloDatos($xlsx->rows(), $_POST['datostabla']);
    } else {
        echo SimpleXLS::parseError();
    }
} elseif ($extension == "xlsx") {
    //si es un archivo xlsx lo abre con SimpleXLSX

    if ($xlsx = SimpleXLSX::parse($guardar_excel)) {


        ArregloDatos($xlsx->rows(), $_POST['datostabla']);
    } else {
        echo SimpleXLSX::parseError();
    }
}



function ArregloDatos($Datos, $Dtabla)
{
    $tabla = '';
    $mysql = new MySQL();
    $mysql->conectar();

    $tabla .= '<table id="tabla2"  class="table table-striped ">
<thead>
    <tr>
        <th scope="col">Número de documento</th>
        <th scope="col">Nombre completo</th>
        <th scope="col">ficha</th>
        <th scope="col">estado</th>

    </tr>
</thead>
<tbody>';
    $JSON = json_decode($Dtabla, true);



    foreach ($Datos as $index => $v) {


        if (!empty($Datos[6 + $index][0]) && !empty($Datos[2][1])) {



            $result = $mysql->efectuarConsulta("SELECT * FROM ingresados");
            $array = mysqli_fetch_all($result, 1);

            $row_count = $result->num_rows;

            foreach ($array as $key => $value) {
                # code...
    

                if (preg_replace("/[^0-9\.]/", "", $Datos[6 + $index][0]) == $array[$key]["documento"] && $Datos[2][1]  == $array[$key]["ficha"]) {

                    $tabla .= ' 
            <th scope="row"><a href="#">' . $Datos[6 + $index][0] . '</a></th>
            <td>' . $Datos[6 + $index][1] . '</td>
            <td><a href="#" class="text-primary">' . $Datos[2][1] . '</a></td>
            <td><span class=^badge bg-success^>Inscrito</span>';
            $result = $mysql->efectuarConsulta('UPDATE  ingresados set estado = "Matriculado",nombre_completo = "'. $Datos[6 + $index][1].'"  where documento = ' . preg_replace("/[^0-9\.]/", "", $Datos[6 + $index][0]));
           

            $result = $mysql->efectuarConsulta('SELECT * FROM cursos_aprendiz where documento = '.preg_replace("/[^0-9\.]/", "", $Datos[6 + $index][0]). ' and ficha ='. $Datos[2][1] );
 
            $row_count = $result->num_rows;
if(  $row_count == 0){
echo 'INSERT INTO `cursos_aprendiz`  VALUES (NULL, '.preg_replace("/[^0-9\.]/", "", $Datos[6 + $index][0]).', "'.str_replace("/","-",date("Y/m/d")).'", '. $Datos[2][1].') ';
          $result = $mysql->efectuarConsulta('INSERT INTO `cursos_aprendiz`  VALUES (NULL, '.preg_replace("/[^0-9\.]/", "", $Datos[6 + $index][0]).', "'.str_replace("/","-",date("Y/m/d")).'", '. $Datos[2][1].') ');
        }
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


function Enviar($Dato)
{


    echo '<form id="form" method="post" action="../index.php"><input type="hidden" name="tabla3" value="' . str_replace('"', '^', $Dato) . '"></form>
    <script>document.getElementById("form").submit();</script>
   
    ';
}
