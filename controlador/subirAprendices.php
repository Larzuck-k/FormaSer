<?php 
require_once '../modelo/MySQL.php';
$mysql = new MySQL();
    $mysql->conectar();

$Aprendices = json_decode($_POST["datostabla"],true);

foreach ($Aprendices as $index2 => $j) {
   echo $Aprendices[$index2]["estado"];
   echo "<br>";
   // print_r( $Aprendices);
  if(str_contains($Aprendices[$index2]["estado"],"No es posible repetirlo") == false ){
  


  $result = $mysql->efectuarConsulta("SELECT * FROM ingresados where documento = " . $Aprendices[$index2]["Número de documento"] .  " and ficha = " . $Aprendices[$index2]["ficha"]);

 $row_count = $result->num_rows;

if ($row_count == 0) {

  if(str_contains($Aprendices[$index2]["estado"],"Anulado")){
   $mysql ->efectuarConsulta('Insert into ingresados values(null,"En espera...","'.str_replace("/","-",date("Y/m/d")).'",'.$Aprendices[$index2]["ficha"].' ,"Anulado",'.$Aprendices[$index2]["Número de documento"].' ,"'.$Aprendices[$index2]["Tipo de documento"].'")');

  }

  if(str_contains($Aprendices[$index2]["estado"],"Aspirante")){
   $mysql ->efectuarConsulta('Insert into ingresados values(null,"En espera...","'.str_replace("/","-",date("Y/m/d")).'",'.$Aprendices[$index2]["ficha"].' ,"Aspirante",'.$Aprendices[$index2]["Número de documento"].' ,"'.$Aprendices[$index2]["Tipo de documento"].'")');

  }

}


}
}

$mysql->desconectar();
Enviar();
//
function Enviar()
{


  echo '<form id="form" method="post" action="../index.php"><input type="hidden" name="tab1" value="true"></form><script>document.getElementById("form").submit();</script>';
    
}

?>


