<?php
// CAMBIAR CONTRASEÑA
require_once '../modelo/Mysql.php';


$mysql = new MYSQL();

$newpass = hash('SHA256', $_POST['pass']);

$id = $_GET["id"];

$consult = $mysql->efectuarConsulta("UPDATE bd_formaser.funcionarios SET bd_formaser.funcionarios.pass_funcionario = '".$newpass."' 
WHERE id= ".$id." ");

echo '<form id="form" method="post" action="../index.php"><input type="hidden" name="cambio" value="true">  <input type="hidden" name="tab1" value="true"></form><script>document.getElementById("form").submit();</script>';
    

?>