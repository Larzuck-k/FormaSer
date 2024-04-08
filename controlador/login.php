
<?php



//Comprobar datos
require_once '../modelo/MySQL.php';

require_once '../modelo/funcionarios.php';

session_start();

if (
    (isset($_POST['doc']) && !empty($_POST['doc'])) &&
    (isset($_POST['pass']) && !empty($_POST['pass']))
) {

    //llamado del modelo de conexón de consultas





    //Capturar variables


    $doc = $_POST['doc'];
    $pass = hash('SHA256', $_POST['pass']);
    $rol = "";


    //Instanciar la clase
    $mysql = new MySQL();
    $usuario = new funcionarios;

    //Usar método del modelo
    $mysql->conectar();





    $usuarios = $mysql->efectuarConsulta("SELECT * FROM funcionarios WHERE documento_funcionario = " . $doc . " and pass_funcionario = '" . $pass . "' and estado_funcionario = 1");

    $fila = mysqli_fetch_assoc($usuarios);
    if (mysqli_num_rows($usuarios) > 0) {



        $usuario->setLogin(true);
        $usuario->setUser($fila['documento_funcionario']);
        $usuario->setId($fila['id']);
        $usuario->setRol($fila['rol_funcionario']);


        $rol  = $fila['rol_funcionario'];
    } else {

        header("Location: ../login.php?Error=true&Mensaje=Verifique sus datos");
    }



    //Desconectar de la base de datos para liberar memoria

    $mysql->desconectar();

    //Capturar los resultados de la consulta en una fila



    //validar si se encuentran resultados


    if ($rol == "Funcionario" || $rol == "2" || $rol == "3") {
        $_SESSION["funcionario"] = $usuario;
        header("Location: ../index.php");
    }
} else {
    header("Location: ../login.php?Error=true&Mensaje=No se ha encontrado  el usuario o contraseña");
}
