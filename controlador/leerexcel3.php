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

if ($extension != "xls" && $extension != "xlsx") {

    echo '<form id="form" method="post" action="../index.php"><input type="hidden" name="error" value="El formato del archivo no es compatible"></form>
     
    <script>document.getElementById("form").submit();</script>
    ';
}


function ArregloDatos($Datos, $Dtabla)
{
    $tabla = '';
    $mysql = new MySQL();
    $mysql->conectar();

    $tabla .= '<table id="tabla2"  class="datatable table table-striped " style="width:100%">
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




    
   

        if ($Datos[2][0] != "Código Ficha" && $Datos[3][0] !=  "Programa de Formación") {

         //   echo '<form id="form" method="post" action="../index.php"><input type="hidden" name="tab3" value="true"><input type="hidden" name="error" value="El formato del archivo no es compatible"></form><script>document.getElementById("form").submit();</script>';
       
       
       
       


         $ext = $GLOBALS['extension'];
         $excel = $GLOBALS['guardar_excel'];
         $DatoNuevo;
         if ($ext == "xls") {
             if ($xlsx = SimpleXLS::parse($excel)) {

                 $DatoNuevo = $xlsx->rows(1);
             } else {
                 echo SimpleXLS::parseError();
             }
         } elseif ($ext == "xlsx") {
             //si es un archivo xlsx lo abre con SimpleXLSX

             if ($xlsx = SimpleXLSX::parse($excel)) {


                 $DatoNuevo = $xlsx->rows(1);
             } else {
                 echo SimpleXLSX::parseError();
             }
            }
         


             foreach ($DatoNuevo as $i => $v) {

                 $GLOBALS['$DatosV2'][6 + $i][0] = $DatoNuevo[$i][0]; //Documento
                 $GLOBALS['$DatosV2'][6 + $i][2] = $DatoNuevo[$i][1];//Ficha
                 $GLOBALS['$DatosV2'][6 + $i][1] = $DatoNuevo[$i][3] . " " . $DatoNuevo[$i][4];//Nombre Completo
                 $GLOBALS['$DatosV2'][6 + $i][9] = "CC";
                 $GLOBALS['$DatosV2'][6 + $i][5] = $DatoNuevo[$i][7];



$Datos = $GLOBALS['$DatosV2'];


                 
             }

             $result = $mysql->efectuarConsulta("SELECT * FROM ingresados");
             $array = mysqli_fetch_all($result, 1);
    
             $row_count = $result->num_rows;
             
             foreach ($Datos as $index => $v) {
                     
             if (!empty($Datos[6 + $index][0]) && !empty($Datos[6 + $index][1])) {



       
          

    
                foreach ($array as $key => $value) {
           

                  


                    $result = $mysql->efectuarConsulta("SELECT * FROM ingresados where documento = ". preg_replace("/[^0-9\.]/", "", $Datos[6 + $index][0]));
               
                    $row_count = $result->num_rows;
                    if($row_count == 0){
    
                        $tabla .= ' 
                        <td scope="row"><a href="#">' . $Datos[6 + $index][0] . '</a></td>
                        <td>' . $Datos[6 + $index][2] . '</td>
                        <td><a href="#" class="text-primary">' . $Datos[6 + $index][1] . '</a></td>
                        <td><span class=^badge bg-success^>Matriculado</span>';
                    
                        $mysql ->efectuarConsulta('Insert into ingresados values(null,"' . $Datos[6 + $index][1] . '","'.date("Y-m-d", strtotime( $Datos[6 + $index][5] )) .'",'.$Datos[6 + $index][2].' ,"Matriculado",'.preg_replace("/[^0-9\.]/", "", $Datos[6 + $index][0]).' ,"CC")');
                   }






                   $result = $mysql->efectuarConsulta('SELECT * FROM cursos_aprendiz where documento = ' . preg_replace("/[^0-9\.]/", "", $Datos[6 + $index][0]) . ' and ficha =' . $Datos[6 + $index][2]);
    
                   $row_count = $result->num_rows;
                    if ($row_count == 0) {
                       $result = $mysql->efectuarConsulta('INSERT INTO `cursos_aprendiz`  VALUES (NULL, ' . preg_replace("/[^0-9\.]/", "", $Datos[6 + $index][0]) . ', "' . date("Y-m-d", strtotime( $DatoNuevo[$index][7])) . '", ' . $Datos[6 + $index][0] . ') ');
                    }
    
    
     
     
                    }
    
     
                 
                    $tabla .= '</td>
                
                </tr>';
            
                Enviar($tabla);


                $mysql->desconectar();
            
            }
        
        }

        
        
       
     
    }else{




    
        if (isset($Datos[2][0])) {

     

        $result = $mysql->efectuarConsulta("SELECT * FROM Fichas where ficha = " . $Datos[2][1]);

        $row_count = $result->num_rows;
    
    
        if ($row_count <= 0) {
    
    
            $result = $mysql->efectuarConsulta('Insert Into Fichas values(' . $Datos[2][1] . ',"' . $Datos[3][1] . '","' . date("Y-m-d") . '")');
        }
    
        foreach ($Datos as $index => $v) {
    
    
            if (!empty($Datos[6 + $index][0]) && !empty($Datos[2][1])) {
    
    
    
                $result = $mysql->efectuarConsulta("SELECT * FROM ingresados");
                $array = mysqli_fetch_all($result, 1);
    
                $row_count = $result->num_rows;
    
    
                foreach ($array as $key => $value) {
    
    
    
                    if (preg_replace("/[^0-9\.]/", "", $Datos[6 + $index][0]) == $array[$key]["documento"] && $Datos[2][1] == $array[$key]["ficha"] && str_contains($Datos[6 + $index][2], "Matriculado")) {
    
                        $tabla .= ' 
                             <td scope="row"><a href="#">' . $Datos[6 + $index][0] . '</a></td>
                            <td>' . $Datos[6 + $index][1] . '</td>
                            <td><a href="#" class="text-primary">' . $Datos[2][1] . '</a></td>
                            <td><span class=^badge bg-success^>Matriculado</span>';
                        $result = $mysql->efectuarConsulta('UPDATE  ingresados set estado = "Matriculado",nombre_completo = "' . $Datos[6 + $index][1] . '"  where documento = ' . preg_replace("/[^0-9\.]/", "", $Datos[6 + $index][0]));
    
    
                        $result = $mysql->efectuarConsulta('SELECT * FROM cursos_aprendiz where documento = ' . preg_replace("/[^0-9\.]/", "", $Datos[6 + $index][0]) . ' and ficha =' . $Datos[2][1]);
    
                        $row_count = $result->num_rows;
                        if ($row_count == 0) {
                            echo 'INSERT INTO `cursos_aprendiz`  VALUES (NULL, ' . preg_replace("/[^0-9\.]/", "", $Datos[6 + $index][0]) . ', "' . str_replace("/", "-", date("Y/m/d")) . '", ' . $Datos[2][1] . ') ';
                            $result = $mysql->efectuarConsulta('INSERT INTO `cursos_aprendiz`  VALUES (NULL, ' . preg_replace("/[^0-9\.]/", "", $Datos[6 + $index][0]) . ', "' . str_replace("/", "-", date("Y/m/d")) . '", ' . $Datos[2][1] . ') ');
                        }
                    }
    
    
    
                    if (preg_replace("/[^0-9\.]/", "", $Datos[6 + $index][0]) == $array[$key]["documento"] && $Datos[2][1] == $array[$key]["ficha"] && str_contains($Datos[6 + $index][2], "Anulado")) {
    
                        $result = $mysql->efectuarConsulta('UPDATE  ingresados set estado = "Anulado",nombre_completo = "' . $Datos[6 + $index][1] . '"  where documento = ' . preg_replace("/[^0-9\.]/", "", $Datos[6 + $index][0]));
                        $tabla .= ' 
                       <td scope="row"><a href="#">' . $Datos[6 + $index][0] . '</a></td>
                       <td>' . $Datos[6 + $index][1] . '</td>
                       <td><a href="#" class="text-primary">' . $Datos[2][1] . '</a></td>
                       <td><span class=^badge bg-dark^>Anulado</span>';
                    }
     
     
                    }
    
     
                    $result = $mysql->efectuarConsulta("SELECT * FROM ingresados where documento = ". preg_replace("/[^0-9\.]/", "", $Datos[6 + $index][0]));
                    $array = mysqli_fetch_all($result, 1);
                    $row_count = $result->num_rows;
                    if($row_count == 0){
    
                        $tabla .= ' 
                        <td scope="row"><a href="#">' . $Datos[6 + $index][0] . '</a></td>
                        <td>' . $Datos[6 + $index][1] . '</td>
                        <td><a href="#" class="text-primary">' . $Datos[2][1] . '</a></td>
                        <td><span class=^badge bg-success^>Matriculado</span>';
                    
                        $mysql ->efectuarConsulta('Insert into ingresados values(null,"' . $Datos[6 + $index][1] . '" ,"'.str_replace("/","-",date("Y/m/d")).'",'. $Datos[2][1] .' ,"Matriculado",'.preg_replace("/[^0-9\.]/", "", $Datos[6 + $index][0]).' ,"'.preg_replace("/[^A-Z\.]/", "", $Datos[6 + $index][0]).'")');
                    
    
                        $result = $mysql->efectuarConsulta('SELECT * FROM cursos_aprendiz where documento = ' . preg_replace("/[^0-9\.]/", "", $Datos[6 + $index][0]) . ' and ficha =' . $Datos[2][1]);
    
                        $row_count = $result->num_rows;
                        if ($row_count == 0) {
                            echo 'INSERT INTO `cursos_aprendiz`  VALUES (NULL, ' . preg_replace("/[^0-9\.]/", "", $Datos[6 + $index][0]) . ', "' . str_replace("/", "-", date("Y/m/d")) . '", ' . $Datos[2][1] . ') ';
                            $result = $mysql->efectuarConsulta('INSERT INTO `cursos_aprendiz`  VALUES (NULL, ' . preg_replace("/[^0-9\.]/", "", $Datos[6 + $index][0]) . ', "' . str_replace("/", "-", date("Y/m/d")) . '", ' . $Datos[2][1] . ') ');
                        }
                    }
                    $tabla .= '</td>
                
                </tr>';
              
            }
        }
    
        $tabla .= ' </tbody>
        </table>';
            }

            Enviar($tabla);


            $mysql->desconectar();
        
    }
}
       
        
   


function Enviar($Dato)
{



   //  echo '<form id="form" method="post" action="../index.php"><input type="hidden" name="tabla3" value="' . str_replace('"', '^', $Dato) . '"><input type="hidden" name="tab3" value="true"></form><script>document.getElementById("form").submit();</script>';
}
