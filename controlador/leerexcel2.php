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

if($extension != "xls" && $extension != "xlsx"){

    echo '<form id="form" method="post" action="../index.php"><input type="hidden" name="error" value="El formato del archivo no es compatible"></form>
     
    <script>document.getElementById("form").submit();</script>
    ';
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

if(isset($Datos[2][0])){
  
    if($Datos[2][0] != "Código Ficha" && $Datos[3][0] !=  "Programa de Formación"){

       echo '<form id="form" method="post" action="../index.php"><input type="hidden" name="error" value="El formato del archivo no es compatible"></form><script>document.getElementById("form").submit();</script>';
    
    }
}


if(isset($Datos[6][2])){
  
    if($Datos[6][2] != "Preinscrito" ){

       echo '<form id="form" method="post" action="../index.php"><input type="hidden" name="error" value="El formato del archivo no es compatible"></form><script>document.getElementById("form").submit();</script>';
    
    }
}


$result = $mysql->efectuarConsulta("SELECT * FROM Fichas where ficha = ".$Datos[2][1]);

$row_count = $result->num_rows;

if( $row_count <= 0){


$result = $mysql->efectuarConsulta('Insert Into Fichas values('. $Datos[2][1].',"'. $Datos[3][1].'","'. date("Y-m-d").'")');

}


    foreach ($Datos as $index => $v) {


        if (!empty($Datos[6 + $index][0]) && !empty($Datos[2][1])) {


        
$result = $mysql->efectuarConsulta("SELECT * FROM ingresados where documento = " . preg_replace("/[^0-9\.]/" ,"",$Datos[6 + $index][0]).' and ficha ='.$Datos[2][1]);

$row_count = $result->num_rows;

if ($row_count == 1) {
        
    $tabla .= ' 
            <th scope="row"><a href="#">' . $Datos[6 + $index][0] . '</a></th>
            <td>'. $Datos[6 + $index][1].'</td>
            <td><a href="#" class="text-primary">' . $Datos[2][1] . '</a></td>
            <td><span class=^badge bg-success^>Preinscrito</span>';
       
            $result = $mysql->efectuarConsulta('UPDATE  ingresados set nombre_completo = "'. $Datos[6 + $index][1].'" , estado = "Preinscrito" where documento = ' . preg_replace("/[^0-9\.]/" ,"",$Datos[6 + $index][0]));

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

    echo '<form id="form" method="post" action="../index.php"><input type="hidden" name="tabla2" value="' . str_replace('"', '^', $Dato) . '"><input type="hidden" name="tab2" value="true"></form><script>document.getElementById("form").submit();</script>';

}
