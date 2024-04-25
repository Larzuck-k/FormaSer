
<?php
echo '<script src="../assets/js/htmltoexcel.js"></script>';
echo '    <link href="../assets/css/hide.css"   rel="stylesheet">';
echo '     <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">';
echo '  <h1>Cargando...</h1>';

require_once '../modelo/MySQL.php';





$mysql = new MySQL();
$mysql->conectar();

$result = $mysql->efectuarConsulta("SELECT * FROM fichas");
$mysql->desconectar();
   
$fichas = mysqli_fetch_all($result);
$st="";
for ($i=0; $i < count($fichas); $i++) { 

$st.=Creartabla($fichas[$i][0],$i);


}
$mysql->desconectar();





function Creartabla($ficha,$time){

    $mysql = new MySQL();
    $mysql->conectar();
    // Realizar la consulta SQL para buscar la ficha
    $consulta = $mysql->efectuarConsulta("SELECT * FROM  ingresados WHERE ficha =" .$ficha);
    

    // Iterar sobre los resultados de la consulta y mostrarlos en la tabla
    echo '<table class="hide" id="tabla'.$ficha.'">
    <thead class="text-center thead-dark">
        <tr>
            <th>ID</th>

            <th>Nombre completo</th>
            <th>Fecha de ingreso</th>
            <th>Ficha</th>
            <th>Estado</th>
            <th>Documento</th>
            <th>Tipo de documento</th>
        </tr>
    </thead>
    <tbody id="miTabla">';
    if (isset($consulta)) {
   
        while ($fila = mysqli_fetch_array($consulta)) {
            echo "<tr>";
            echo "<td>{$fila[0]}</td>";
            echo "<td>{$fila[1]}</td>";
            echo "<td>{$fila[2]}</td>";
            echo "<td>{$fila[3]}</td>";
            echo "<td>{$fila[4]}</td>";
            echo "<td>{$fila[5]}</td>";
            echo "<td>{$fila[6]}</td>";
            echo "</tr>";
        }
    }
    echo '     </tbody>
    </table>';
    return ' setTimeout(() => {tableToExcel("tabla'.$ficha.'",'.$ficha.')}, "'.$time*2 .'");  ';
}

echo '<script>'. $st .'</script>';



 echo '<form id="form" method="post" action="../index.php"> <input type="hidden" name="tab4" value="true"></form><script>setTimeout(() => {document.getElementById("form").submit();}, "'.$time*10+10 .'");</script>';



?>