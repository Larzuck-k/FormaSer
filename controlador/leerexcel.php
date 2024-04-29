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

if($extension != "xls" && $extension != "xlsx"){

    echo '<form id="form" method="post" action="../index.php"><input type="hidden" name="error" value="El formato del archivo no es compatible"></form>
     
    <script>document.getElementById("form").submit();</script>
    ';
}



function ArregloDatos($Datos)
{
    $tabla = '';
    $mysql = new MySQL();
    $mysql->conectar();

    $tabla .= '<table id="tabla" class="datatable table table-striped " style="width:100%">
<thead>
    <tr>
    <th scope="col">#</th>
         
    <th scope="col">Número de documento</th>
        <th scope="col">Nombre completo</th>
        <th scope="col">ficha</th>
        <th scope="col">Tipo de documento</th>
        <th scope="col">estado</th>

    </tr>
</thead>
<tbody>';

if(isset($Datos[0][0])){
 
    if($Datos[0][0] != "FORMATO PARA LA INSCRIPCIÓN DE ASPIRANTES EN SOFIA PLUS v1.0" ){

       echo '<form id="form" method="post" action="../index.php"><input type="hidden" name="tab1" value="true"><input type="hidden" name="error" value="El formato del archivo no es compatible"></form><script>document.getElementById("form").submit();</script>';
    
    }
}



$elementos = [0];
    foreach ($Datos as $index => $v) {


        if (!empty($Datos[2 + $index][2]) && !empty($Datos[2 + $index][3])) {


for ($i=0; $i < count($elementos); $i++) { 
 
    if(   $Datos[2 + $index][2] != $elementos[$i]){
        $elementos[$i] = $Datos[2 + $index][2];
      
         $tabla .= ' 
      
         <td>'.  $index+1 .'</td>
         <td>' . $Datos[2 + $index][2] . '</td>
        <td>En espera...</td>
        <td><a  class="text-primary">' . $Datos[2 + $index][3] . '</a></td>
        <td><a class="text-primary">' . $Datos[2 + $index][1] . '</a></td>
        <td>';
       

        
          




        $result = $mysql->efectuarConsulta("SELECT * FROM ingresados where documento = " . $Datos[2 + $index][2]);


        $row_count = $result->num_rows;

        if ($row_count >= 1) {



            
            $tabla .= "<span class=^badge bg-success^>En el sistema</span>";
            $tabla .=  "<br>";
            $result = $mysql->efectuarConsulta("SELECT * FROM cursos_aprendiz where documento = " . $Datos[2 + $index][2]);


            $row_count2 = $result->num_rows;


            if ($row_count2 == 0) {

                $tabla .= "<span class=^badge bg-success^>No está en otros cursos</span>";
            } elseif ($row_count2 >= 1) {
                $tabla .= "<span class=^badge bg-warning^>Ha cursado otros programas</span>";


         
                $result = $mysql->efectuarConsulta("SELECT * FROM cursos_aprendiz where documento = " . $Datos[2 + $index][2] .  " and ficha = " . $Datos[2 + $index][3]);

                $row_count4 = $result->num_rows;

                if ($row_count4 >= 1) {

                    $tabla .= "<br>";
                    $tabla .= "<span class=^badge bg-danger^>Ya ha hecho este curso (No es posible repetirlo)</span>";
                } else{
                    $result = $mysql->efectuarConsulta("SELECT * FROM  cursos_aprendiz INNER JOIN fichas ON cursos_aprendiz.ficha = fichas.ficha where documento = " . $Datos[2 + $index][2] . " and inscripcion between '" . date("Y") . "-01-01' and '" . date("Y") . "-12-31'");

                    $row_count3 = $result->num_rows;

                    
                if ($row_count3 >= 1) {


                    
                    $array = mysqli_fetch_all($result, 1);
                    $cursados = "";
              foreach ($array as $index => $value) {
          $cursados .=    $array[0]["nombre_curso"] . " ". $array[0]["ficha"] . " " .$array[0]["inscripcion"] . "  " . $array[0]["documento"] ;
               
//SELECT fichas.ficha as "Ficha anterior",fichas.nombre_curso, ingresados.ficha as "Ficha a inscribir" FROM cursos_aprendiz  INNER JOIN ingresados ON cursos_aprendiz.documento = ingresados.documento   INNER JOIN fichas ON cursos_aprendiz.ficha = fichas.ficha    where cursos_aprendiz.documento = 1112765623  and inscripcion between '2024-01-01' and '2024-12-31'
//2 fichas apartes
              }
                  
                    $tabla .= "<br>";
                    $tabla .=  '  <span id="'.str_replace("CC - ","",$Datos[2 + $index][2] ).'"><button class=^badge btn btn-info^ onclick="leer('.str_replace("CC - ","",$Datos[2 + $index][2] ) .',~'.$cursados.'~)" data-bs-toggle="modal" data-bs-target="#staticBackdrop"  >Conflicto: Se encuentra matriculado en el año vigente (Presione aqui)</button></span> ';

                 

                  
                }
                if ($row_count3 == 0) {
                    $tabla .=  "<br>";
                    $tabla .= "<span class=^badge bg-warning^>Se encuentra registrado en un curso pero ya pasó un año</span>";

                  
                    
                    $result = $mysql->efectuarConsulta("SELECT * FROM cursos_aprendiz where documento = " . $Datos[2 + $index][2] .  " and ficha = " . $Datos[2 + $index][3]);

                    $row_count4 = $result->num_rows;

                    if ($row_count4 >= 1) {

                        $tabla .= "<br>";
                        $tabla .= "<span class=^badge bg-warning^>Es en un curso diferente</span>";
                    }
                }
                }


             
            }
        }

        if ($row_count == 0) {
            $tabla .= "<span class=^badge bg-success^>Aspirante</span>";
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
$cadena =  str_replace('"', '^', $Dato);
      echo '<form id="form" method="post" action="../index.php"><input type="hidden" name="tabla" value="' .str_replace( '~',chr(39),$cadena  ) . '"> <input type="hidden" name="tab1" value="true"></form><script>document.getElementById("form").submit();</script>';
    


   
}
