<?php 
require_once '../modelo/MySQL.php';
$mysql = new MySQL();
    $mysql->conectar();

$Aprendices = json_decode($_POST["datostabla"],true);

foreach ($Aprendices as $index2 => $j) {

   // print_r( $Aprendices);
  if(str_contains($Aprendices[$index2]["estado"],"No es posible repetirlo") == false && str_contains($Aprendices[$index2]["estado"],"Cancelada") == false)
   $mysql ->efectuarConsulta('Insert into ingresados values(null,"En espera...","'.str_replace("/","-",date("Y/m/d")).'",'.$Aprendices[$index2]["ficha"].' ,"'.$Aprendices[$index2]["estado"].'",'.$Aprendices[$index2]["Número de documento"].' ,"'.$Aprendices[$index2]["Tipo de documento"].'")');

}

$mysql->desconectar();
Enviar();
//
function Enviar()
{


    echo '<form id="form" method="post" action="../index.php"></form>
    <script>document.getElementById("form").submit();</script>
   
    ';
}

?>


