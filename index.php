<?php




require_once 'Modelo/funcionarios.PHP';

session_start();


$usuario = new funcionarios();

if (isset($_SESSION['funcionario'])) {
    $usuario = $_SESSION['funcionario'];
} else {
    header("Location: ./login.php");
}




if ($usuario->getLogin() == true) {


    $user = $usuario->getUser();
    $id = $usuario->getId();
    $rol = $usuario->getrol();
} else {
    header("Location: ./login.php");
    exit();
}
echo $user;
echo "<p> </p>";
echo $id;
echo "<p> </p>";
echo $rol;
?>


<form action="./controlador/cerrarsesion.php" method="post"><button type="submit">Cerrar sesión</button></form>


<form action="./controlador/leerexcel.php" method="post" enctype='multipart/form-data'>

<input accept="document/xlsx" type="file" name="excelfile" id="">
<button type="submit">subir archivo</button>
</form>