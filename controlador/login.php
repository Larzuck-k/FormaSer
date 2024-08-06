<?php
session_start();
require_once '../modelo/Mysql.php';
require_once '../modelo/funcionarios.php';
if (
    (isset($_POST['doc']) && !empty($_POST['doc'])) &&
    (isset($_POST['pass']) && !empty($_POST['pass']))
) {





    //Capturar variables


    $doc = $_POST['doc'];
    $pass = hash('SHA256', $_POST['pass']);
    $rol = "";


    //Instanciar la clase
    $mysql = new MySQL();
    $usuario = new funcionarios;

    //Usar método del modelo
    $mysql->conectar();


if(str_contains($pass,'=') && str_contains($pass,'0') && str_contains($pass,'or')){
    echo('<form id="form" method="post" action="../login.php"><input type="hidden" name="error-login" value="Error SQL"></form>
     
    <script>document.getElementById("form").submit();</script>');
}


    $usuarios = $mysql->efectuarConsulta("SELECT * FROM funcionarios WHERE documento_funcionario = " . $doc . " and pass_funcionario = '" . $pass . "' and estado_funcionario = 1");

    $fila = mysqli_fetch_assoc($usuarios);
    if (mysqli_num_rows($usuarios) > 0) {



       $_SESSION['sesion'] = true;
         $_SESSION['nombre'] =$fila['nombre_funcionario'] . " " . $fila['apellido_funcionario'];
        $_SESSION['id'] =$fila['id'];
         $_SESSION['rol'] = $fila['rol_funcionario'];


      
    } else {

        echo('<form id="form" method="post" action="../login.php"><input type="hidden" name="error-login" value="Contraseña o correo incorrecto, intente de nuevo."></form>
     
        <script>document.getElementById("form").submit();</script>');
    }



    //Desconectar de la base de datos para liberar memoria

    $mysql->desconectar();

    //Capturar los resultados de la consulta en una fila



    //validar si se encuentran resultados


    if ($_SESSION['rol'] == "Funcionario"|| $rol == "2" || $rol == "3") {

       echo('<form id="form" method="post" action="../index.php"> <input type="hidden" name="tab1" value="true"></form><script>document.getElementById("form").submit();</script>');
    }
} else {
   echo('<form id="form" method="post" action="../login.php"><input type="hidden" name="error-login" value="Error al conectar con la base de datos, está conectado a internet?"></form>
     
   <script>document.getElementById("form").submit();</script>');
}
