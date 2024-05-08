<?php
require_once '../modelo/SimpleXLSXE.php';

use Shuchkin\SimpleXLSX;

$excel_file = $_FILES['excelfile'];
$nombre = $excel_file['name'];
require_once '../modelo/Mysql.php';

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

    $tabla .= '<table id="tabla" class="datatable table table-striped " style="width:100%">
<thead>
       <tr>

         
    <th scope="col">Número de documento</th>
        <th scope="col">Nombre completo</th>
        <th scope="col">ficha</th>
        <th scope="col">Tipo de documento</th>
        <th scope="col">fecha</th>
        <th scope="col">estado</th>

    </tr>
</thead>
<tbody>';

    if (isset($Datos[0][0])) {

        if ($Datos[0][0] != "FORMATO PARA LA INSCRIPCIÓN DE ASPIRANTES EN SOFIA PLUS v1.0") {

            echo '<form id="form" method="post" action="../index.php"><input type="hidden" name="tab1" value="true"><input type="hidden" name="error" value="El formato del archivo no es compatible"></form><script>document.getElementById("form").submit();</script>';

        }
    }



    $Fichas = mysqli_fetch_all($mysql->efectuarConsulta("SELECT * from fichas"),1);
    $Ingresados = mysqli_fetch_all($mysql->efectuarConsulta("SELECT * from ingresados"),1);
    $Cursados = mysqli_fetch_all($mysql->efectuarConsulta("SELECT * from cursos_aprendiz"),1);
    $CursadosNFicha = mysqli_fetch_all($mysql->efectuarConsulta("SELECT documento ,cursos_aprendiz.ficha,nombre_curso,fecha_inicio,inscripcion from cursos_aprendiz INNER JOIN fichas ON cursos_aprendiz.ficha = fichas.ficha"),1);
    $DocumentoCursados = [];
    foreach ($Cursados as $key => $value) {
        $DocumentoCursados[$key+1] =  $Cursados[$key]["documento"];
    }
    $FichaCursada = [];
    foreach ($Cursados as $key => $value) {
        $FichaCursada[$key+1] =  $Cursados[$key]["ficha"];
    }
    $FichaCursadaNombre = [];
    foreach ($CursadosNFicha as $key => $value) {
        $FichaCursadaNombre[$key+1] =  $CursadosNFicha[$key]["ficha"];
    }


    $FichaRegistrada = [];
    $InicioFicha =[];
    foreach ($Fichas as $key => $value) {
        $FichaRegistrada[$key+1] =  $Fichas[$key]["ficha"];
        $InicioFicha[$key+1] =  $Fichas[$key]["fecha_inicio"];
      
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
  




    
    if(!empty($Datos[$key][6] ) && $Datos[$key][1] != "Tipo de Identificación"){

    //    
            $tabla .= ' 
            <td scope="row"><a href="#">' . $Datos[$key][2] . '</a></td>
            <td>En espera...</td>
            <td>' .  $Datos[$key][3] . '</td>
            <td><a href="#" class="text-primary">' . $Datos[$key][1] . '</a></td>
            <td>' . date("Y-m-d") . '</td>
            <td>';


            if(array_search( $Datos[$key][2] , $DocumentoIngresado) ==true ){
                $tabla .='<span class="badge bg-success">En el sistema</span>';
            }
            else{
                $tabla .='<span class="badge bg-primary">Primera inscripción</span>';
            }

            if(array_search( $Datos[$key][2] , $DocumentoCursados) ==true ){
                $tabla .='<span class="badge bg-warning">Ha hecho otros cursos</span>';


                if(array_search( $Datos[$key][3] , $FichaCursada) ==true){
                    $tabla .='<span class="badge bg-danger">Ya ha hecho este curso (No es posible repetir)</span>';
                }
                else{
                $date1 =  $CursadosNFicha[$key]["fecha_inicio"];                
             
                $date2=date_create($CursadosNFicha[$key]["fecha_inicio"]);
                date_add($date2,date_interval_create_from_date_string("1 year"));
                $date2= date_format($date2,"Y-m-d");
                $fecha =  date("Y-m-d") ;   
                
              
                if ($fecha > $date2) {
                    $tabla .='<span class="badge bg-warning">Ya ha hecho otros cursos pero ya pasó un año</span>';
                   
                } elseif ($fecha < $date1) {
                  

                    if(array_search( $Datos[$key][3] , $FichaCursadaNombre) == false){
                        //  $tabla .='<span class="badge bg-info">Conflicto</span>';
                        $Curso = "";
                        $Curso .= $CursadosNFicha[$key]["ficha"] . " - " . $CursadosNFicha[$key]["nombre_curso"] . " - " . $CursadosNFicha[$key]["inscripcion"];
                        $tabla .= '  <span id="' . str_replace("CC - ", "", $Datos[$key][2]) . '"><button class=^badge btn btn-info ^ onclick="leer(' . str_replace("CC - ", "", $Datos[$key][2]) . ',~' . $Curso . '~)" data-bs-toggle="modal" data-bs-target="#staticBackdrop"  >Conflicto: Se encuentra matriculado en el año vigente </button></span> ';
                      
                      }
                      else{
                        $tabla .='<span class="badge bg-success">Aspirante</span>';
                      }

                } else {
                   
                    if(array_search( $Datos[$key][3] , $FichaCursadaNombre) == false){
                        //  $tabla .='<span class="badge bg-info">Conflicto</span>';
                        $Curso = "";
                        $Curso .= $CursadosNFicha[$key]["ficha"] . " - " . $CursadosNFicha[$key]["nombre_curso"] . " - " . $CursadosNFicha[$key]["inscripcion"];
                        $tabla .= '  <span id="' . str_replace("CC - ", "", $Datos[$key][2]) . '"><button class=^badge btn btn-info ^ onclick="leer(' . str_replace("CC - ", "", $Datos[$key][2]) . ',~' . $Curso . '~)" data-bs-toggle="modal" data-bs-target="#staticBackdrop"  >Conflicto: Se encuentra matriculado en el año vigente </button></span> ';
                      
                      }
                      else{
                        $tabla .='<span class="badge bg-success">Aspirante</span>';
                      }

                }
             
            }
              

            }
            
            else{
                $tabla .='<span class="badge bg-success">Aspirante</span>';
            }
            
$tabla .= '</td>';
        }
       
    
  


        $tabla .= '</td>
                        
        </tr>';

    }



    $tabla .= ' </tbody>
    </table>';
     
      







    Enviar($tabla);
    $mysql->desconectar();
    }




function Enviar($Dato)
{
  
//echo $Dato;
    $cadena = str_replace('"', '^', $Dato);
 echo '<form id="form" method="post" action="../index.php"><input type="hidden" name="tabla" value="' . str_replace('~', chr(39), $cadena) . '"> <input type="hidden" name="tab1" value="true"></form><script>document.getElementById("form").submit();</script>';




}
