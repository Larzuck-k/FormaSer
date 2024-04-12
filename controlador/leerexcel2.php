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

        ArregloDatos($xlsx->rows(),$_POST['datostabla']);
    } else {
        echo SimpleXLS::parseError();
    }
} elseif ($extension == "xlsx") {
    //si es un archivo xlsx lo abre con SimpleXLSX

    if ($xlsx = SimpleXLSX::parse($guardar_excel)) {


        ArregloDatos($xlsx->rows(),$_POST['datostabla']);
    } else {
        echo SimpleXLSX::parseError();
    }
}



function ArregloDatos($Datos,$Dtabla)
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
       

            foreach ($JSON as $index2 => $j) {
if( str_replace("CC - ","",$Datos[6 + $index][0] )  == $JSON [$index2]["Número de documento"]){

      
    if(     !str_contains($JSON [$index2]["estado"], "(Conflicto)")  ){
    
    $tabla .= ' 
            <th scope="row"><a href="#">' . $Datos[6 + $index][0] . '</a></th>
            <td>'. $Datos[6 + $index][1].'</td>
            <td><a href="#" class="text-primary">' . $Datos[2][1] . '</a></td>
            <td><span class=^badge bg-success^>Preinscrito</span>';
        }else{
            $tabla .= ' 
            <th scope="row"><a href="#">' . $Datos[6 + $index][0] . '</a></th>
            <td>'. $Datos[6 + $index][1].'</td>
            <td><a href="#" class="text-primary">' . $Datos[2][1] . '</a></td>
            <td id="'.str_replace("CC - ","",$Datos[6 + $index][0] ).'"><button class=^badge btn btn-warning^ onclick="leer('.str_replace("CC - ","",$Datos[6 + $index][0] ) .')" data-bs-toggle="modal" data-bs-target="#staticBackdrop"  >Conflicto: Ha estado matriculado en este año (Presione aqui)</button>';

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


    echo '<form id="form" method="post" action="../index.php"><input type="hidden" name="tabla2" value="' . str_replace('"', '^', $Dato) . '"></form>
    <script>document.getElementById("form").submit();</script>
   
    ';
}
