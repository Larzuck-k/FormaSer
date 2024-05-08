<?php
require_once '../modelo/SimpleXLSXE.php';

use PhpOffice\PhpSpreadsheet\Style\NumberFormat\Wizard\Number;
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

        ArregloDatos($xlsx->rows(0));
    } else {
        echo SimpleXLS::parseError();
    }
} elseif ($extension == "xlsx") {
    //si es un archivo xlsx lo abre con SimpleXLSX

    if ($xlsx = SimpleXLSX::parse($guardar_excel)) {


        ArregloDatos($xlsx->rows(0));
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
    $mysql = new MySQL();
    $mysql->conectar();
    $tabla = '';

    if ($Datos[0][1] ==  "Reporte de Inscripciones"){
        //Valida si es el formato 1
        
    $tabla .= '<table id="tabla2"  class="datatable table table-striped " style="width:100%">
    <thead>
    <tr>
    <th scope="col">Número de documento</th>
    <th scope="col">Nombre completo</th>
    <th scope="col">ficha</th>
    <th scope="col">nombre ficha</th>
    <th scope="col">fecha</th>
    <th scope="col">estado</th>

    </tr>
    </thead>
    <tbody>';

    

  

    $Fichas = mysqli_fetch_all($mysql->efectuarConsulta("SELECT * from fichas"),1);
    $Ingresados = mysqli_fetch_all($mysql->efectuarConsulta("SELECT * from ingresados"),1);
    $Cursados = mysqli_fetch_all($mysql->efectuarConsulta("SELECT * from cursos_aprendiz"),1);
    
    $DocumentoCursados = [];
    foreach ($Cursados as $key => $value) {
        $DocumentoCursados[$key+1] =  $Cursados[$key]["documento"];
    }

    $FichaRegistrada = [];
    foreach ($Fichas as $key => $value) {
        $FichaRegistrada[$key+1] =  $Fichas[$key]["ficha"];
    }

    $DocumentoIngresado = [];
    foreach ($Ingresados as $key => $value) {
        $DocumentoIngresado[$key+1] =  $Ingresados[$key]["documento"];
    }


        //$Datos[i][0]  Documento 
        //$Datos[i][1]  Nombre completo
        //$Datos[i][2]  Estado
        
        //$Datos[2][1] Ficha
        //$Datos[3][1] Nombre ficha
   
       
        $FichaAnterior = "";

foreach ($Datos as $key => $value) {
  




    
    if(!empty($Datos[$key][2] ) && $Datos[$key][2] != "Estado"){

        if(array_search( $Datos[2][1], $FichaRegistrada) ==true ){

        }
        else{
    
        if($FichaAnterior != $Datos[2][1]){
            $fecha = date("Y-m-d");
    
            $result = $mysql->efectuarConsulta('Insert Into Fichas values(' . $Datos[2][1] . ',"' . $Datos[3][1] . '","' . $fecha . '")');
            $FichaAnterior = $Datos[2][1] ;
        }
        }
    


                $estdo = "";
                $clase = "";
                if(  str_contains($Datos[$key][2] ,"Anulado")){
                    $estdo = "Anulado";
                    $clase = "dark";
                 }
                 else{
                    $estdo = "Matriculado";
                    $clase = "success";
                 }
        if(array_search(  preg_replace("/[^0-9\.]/", "",  $Datos[$key][0]) , $DocumentoIngresado) ==true ){

       
            $tabla .= ' 
            <td scope="row"><a href="#">' . $Datos[$key][0] . '</a></td>
            <td>' .$Datos[$key][1]  .'</td>
            <td>' . $Datos[2][1] . '</td>
            <td><a href="#" class="text-primary">' . $Datos[3][1] . '</a></td>
            <td>' . date("Y-m-d") . '</td>
            <td><span class="badge bg-'.$clase.'">'. $estdo  .'</span>';
            
            $mysql->efectuarConsulta('UPDATE ingresados SET nombre_completo="' . $Datos[$key][1] . '",fecha_ingreso="' . date("Y-m-d").  '",ficha=' .  $Datos[2][1] . ',estado="Matriculado",documento=' . preg_replace("/[^0-9\.]/", "", $Datos[$key][0]) . ',tipo_documento="CC" where documento=' . preg_replace("/[^0-9\.]/", "", $Datos[$key][0]) . ' and ficha = ' .  $Datos[2][1]);

        }
        else{

            $tabla .= ' 
            <td scope="row"><a href="#">' . $Datos[$key][0] . '</a></td>
            <td>' .$Datos[$key][1]  .'</td>
            <td>' . $Datos[2][1] . '</td>
            <td><a href="#" class="text-primary">' . $Datos[3][1] . '</a></td>
            <td>' . date("Y-m-d") . '</td>
            <td><span class="badge bg-'.$clase.'">'.$estdo  .'</span>';
            
            
            $fecha = date("Y-m-d");
     $mysql->efectuarConsulta('Insert into ingresados values(null,"' . $Datos[$key][1]. '" ,"' .    $fecha . '",' . $Datos[2][1]. ' ,"Matriculado",' . preg_replace("/[^0-9\.]/", "",  $Datos[$key][0])  . ',"CC")');

      }



        if(array_search(  preg_replace("/[^0-9\.]/", "",  $Datos[$key][0]) , $DocumentoCursados) ==true ){

    

        }
        else{

      
            
            $fecha = date("Y-m-d");
       $mysql->efectuarConsulta('INSERT INTO `cursos_aprendiz`  VALUES (NULL, ' . preg_replace("/[^0-9\.]/", "",  $Datos[$key][0]) . ', "' .  $fecha . '", ' . $Datos[2][1] . ') ');
                                
        
        }

            
        


        }
    
  


        $tabla .= '</td>
                        
        </tr>';

    }



    $tabla .= ' </tbody>
    </table>';
     
      


    }
    else{
    //Lee la segunda hoja
           
        if ($GLOBALS['extension'] == "xls") {
            if ($xlsx = SimpleXLS::parse($GLOBALS['guardar_excel'])) {

                $Datos = $xlsx->rows(1);
            } else {
                echo SimpleXLS::parseError();
            }
        } elseif ($GLOBALS['extension'] == "xlsx") {
            //si es un archivo xlsx lo abre con SimpleXLSX

            if ($xlsx = SimpleXLSX::parse($GLOBALS['guardar_excel'])) {


              $Datos = $xlsx->rows(1);
            } else {
                echo SimpleXLSX::parseError();
            }
        }

    if($Datos[0][9] == "INSTRUCTOR"){
    //Valida si es el formato 2
    date_default_timezone_set("America/Bogota");



    $tabla .= '<table id="tabla2"  class="datatable table table-striped " style="width:100%">
    <thead>
    <tr>
        <th scope="col">Número de documento</th>
        <th scope="col">Nombre completo</th>
        <th scope="col">ficha</th>
        <th scope="col">nombre ficha</th>
        <th scope="col">fecha</th>
        <th scope="col">estado</th>

    </tr>
    </thead>
    <tbody>';



    $Fichas = mysqli_fetch_all($mysql->efectuarConsulta("SELECT * from fichas"),1);
    $Ingresados = mysqli_fetch_all($mysql->efectuarConsulta("SELECT * from ingresados"),1);
    $Cursados = mysqli_fetch_all($mysql->efectuarConsulta("SELECT * from cursos_aprendiz"),1);
    
    $DocumentoCursados = [];
    foreach ($Cursados as $key => $value) {
        $DocumentoCursados[$key+1] =  $Cursados[$key]["documento"];
    }

    $FichaRegistrada = [];
    foreach ($Fichas as $key => $value) {
        $FichaRegistrada[$key+1] =  $Fichas[$key]["ficha"];
    }

    $DocumentoIngresado = [];
    foreach ($Ingresados as $key => $value) {
        $DocumentoIngresado[$key+1] =  $Ingresados[$key]["documento"];
    }


        //$Datos[i][0] Dumento 
        //$Datos[i][1] Ficha
        //$Datos[i][2] Nombre ficha
        //$Datos[i][3] + $Datos[i][4] Nombre completo
        //$Datos[i][7] Fecha de inicio
       
        $FichaAnterior = "";

foreach ($Datos as $key => $value) {
  




    
    if($Datos[$key][0] !="CC"){

        if(array_search( $Datos[$key][1], $FichaRegistrada) ==true ){

        }
        else{
    
        if($FichaAnterior != $Datos[$key][1]){
            $fecha = date("Y-m-d", strtotime(str_replace("/","-",$Datos[$key][7])));
    
            $result = $mysql->efectuarConsulta('Insert Into Fichas values(' . $Datos[$key ][1] . ',"' . $Datos[$key ][2] . '","' . $fecha . '")');
            $FichaAnterior = $Datos[$key ][1] ;
        }
        }
    




        if(array_search( $Datos[$key][0], $DocumentoIngresado) ==true ){

            $tabla .= ' 
            <td scope="row"><a href="#">' . $Datos[$key][0] . '</a></td>
            <td>' . $Datos[$key][3] ." ". $Datos[$key][4]. '</td>
            <td>' . $Datos[$key][1] . '</td>
            <td><a href="#" class="text-primary">' . $Datos[$key][2] . '</a></td>
            <td>' . $Datos[$key][7] . '</td>
            <td><span class="badge bg-success">Matriculado</span>';
            

        }
        else{

            $tabla .= ' 
            <td scope="row"><a href="#">' . $Datos[$key][0] . '</a></td>
            <td>' . $Datos[$key][3] ." ". $Datos[$key][4]. '</td>
            <td>' . $Datos[$key][1] . '</td>
            <td><a href="#" class="text-primary">' . $Datos[$key][2] . '</a></td>
            <td>' . $Datos[$key][7] . '</td>
            <td><span class="badge bg-success">Matriculado</span>';
            
            $fecha = date("Y-m-d", strtotime(str_replace("/","-",$Datos[$key][7])));

            $mysql->efectuarConsulta('Insert into ingresados values(null,"' . $Datos[$key][3] ." ". $Datos[$key][4]. '" ,"' .    $fecha . '",' . $Datos[$key][1] . ' ,"Matriculado",' . preg_replace("/[^0-9\.]/", "", $Datos[$key][0])  . ',"CC")');

      }



        if(array_search( $Datos[$key][0], $DocumentoCursados) ==true ){

    

        }
        else{

      
            
            $fecha = date("Y-m-d", strtotime(str_replace("/","-",$Datos[$key][7])));

            $mysql->efectuarConsulta('INSERT INTO `cursos_aprendiz`  VALUES (NULL, ' . preg_replace("/[^0-9\.]/", "", $Datos[$key][0]) . ', "' .  $fecha . '", ' . $Datos[$key][1] . ') ');
                                
        
        }

            
        $tabla .= '</td>
                        
        </tr>';


        }
    
  
}




    }else{
        //Si no es ninguno, retorna error
        echo '<form id="form" method="post" action="../index.php"><input type="hidden" name="tab3" value="true"><input type="hidden" name="error" value="Este formato no corresponde al sistema."></form><script>document.getElementById("form").submit();</script>';
    }



    
    }
    $tabla .= ' </tbody>
</table>';
    $mysql->desconectar();
    Enviar($tabla);
}


function  Enviar($Dato)
{
    
      echo '<form id="form" method="post" action="../index.php"><input type="hidden" name="tabla3" value="' . str_replace('"', '^', $Dato) . '"><input type="hidden" name="tab3" value="true"></form><script>document.getElementById("form").submit();</script>';
}
