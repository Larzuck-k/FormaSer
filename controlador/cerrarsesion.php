<?php


require_once '../modelo/Funcionarios.php';

session_start();
unset($_SESSION['funcionario']);

session_destroy();
header("Location: ../index.php");
exit();