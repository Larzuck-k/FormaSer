<?php



require_once 'Modelo/funcionarios.PHP';
require_once 'Modelo/Mysql.PHP';

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



if (isset($_POST['error'])) {

    echo   '<script> console.log("' . $_POST['error'] . '")</script>';
}

if (isset($_POST['incorrecto'])) {

    echo   '<script> console.log("' . $_POST['incorrecto'] . '")</script>';
}


?>











<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>FormaSer Sena</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/logo-sena-verde-complementario-png-2022.png" rel="icon">


    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">

    <link href="assets/css/tabcontrol.css" rel="stylesheet">
    <link href="assets/css/datables.css" rel="stylesheet">
    <link href="assets/css/responsive.css" rel="stylesheet">
    <link href="assets/css/dtbuttons.css" rel="stylesheet">
    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">

    <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Apr 7 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="#" class="logo d-flex align-items-center">
                <img src="assets/img/logo-sena-verde-complementario-png-2022.png" alt="">
                <span class="d-none d-lg-block">Forma</span><span class="text-color-green" style="color: rgb(113, 200, 114);">Ser</span>
            </a>

        </div><!-- End Logo -->


        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">





                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
                        <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $user; ?></span>
                    </a><!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6><?php echo $user; ?> - <?php echo $id; ?></h6>
                            <span><?php echo $rol; ?></span>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <!--
            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
-->


                        <li>
                            <form action="./controlador/cerrarsesion.php" method="post">
                                <a class="d-flex justify-content-center pt-3 pb-3">
                                    <button class="btn btn-success" type="submit"><i class="bi bi-box-arrow-right"></i>
                                        Cerrar sesión</button>
                                </a>
                            </form>


                            <a class="d-flex justify-content-center pt-2 pb-3" data-bs-toggle="modal" data-bs-target="#modalPass">
                                <button class="btn btn-primary" type="button"><i class="bi bi-pass"></i>
                                    Cambiar Contraseña</button>
                            </a>
                        </li>

                    </ul><!-- End Profile Dropdown Items -->
                </li><!-- End Profile Nav -->

            </ul>
        </nav><!-- End Icons Navigation -->

    </header><!-- End Header -->

    <!-- ======= Sidebar ======= -->

    <main id="" class="main p-5">



        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Atención</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Este aprendíz ya se ha matriculado antes en un curso en el año vigente, si desea matricularlo de
                        nuevo en este curso, no es necesario tomar acciones, de lo contrario presione el bóton para
                        cancelar la matrícula.
                        <p></p>
                        <div class="h5">Cursado anteriormente: </div>
                        <div id="razones" class="card bg-warning"></div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" id="btncancelar" class="btn btn-danger" data-bs-dismiss="modal">Cancelar
                            matrícula</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <input type="hidden" name="" id="cancelar">
                    </div>
                </div>
            </div>
        </div>


        <ul class="nav nav-tabs pt-5">
            <li class="nav-item">
                <a class="tablinks nav-link" onclick="openTab(event, 'pestaña1')">Formato 1</a>
            </li>
            <li class="nav-item">
                <a class="tablinks nav-link" onclick="openTab(event, 'pestaña2')">Formato 2</a>
            </li>
            <li class="nav-item">
                <a class="tablinks nav-link" onclick="openTab(event, 'pestaña3')">Formato 3</a>
            </li>
            <li class="nav-item">
                <a class="tablinks nav-link" onclick="openTab(event, 'pestaña4')">Consultar fichas</a>
            </li>
            <li class="nav-item">
                <a class="tablinks nav-link" data-bs-toggle="modal" data-bs-target="#modalTuto">Tutorial</a>
            </li>
        </ul>



        <div class="pagetitle pt-5">


            <h1>Estado de registro en proyectos formativos</h1>

        </div><!-- End Page Title -->

        <section class="section dashboard">


            <div class="row">



                <!-- Left side columns -->
                <div class="col-lg-12">



                    <div id="pestaña1" class="tabcontent">


                        <!-- Reports -->
                        <div class="col-12">
                            <div class="card">

                                <div class="card-body">

                                    <h5 class="card-title">Primer formato</h5>
                                    <form action="./controlador/leerexcel.php" class="form" method="post" enctype='multipart/form-data'>

                                        <input class="btn btn-success form-control " accept=".xlsx, .xls" required type="file" name="excelfile" id="">
                                        <p></p>
                                        <input class="btn btn-primary  form-control" value="Subir archivo seleccionado" type="submit">


                                    </form>

                                </div>


                            </div>
                        </div><!-- End Reports -->

                        <!-- Recent Sales -->
                        <div class="col-12">
                            <div class="card recent-sales overflow-auto">



                                <div class="card-body">
                                    <h5 class="card-title">Aspirantes</span></h5>

                                    <div id="contenedor">

                                        <?php if (isset($_POST["tabla"])) {
                                            echo str_replace('^', '"', $_POST["tabla"]);
                                        } ?>
                                    </div>



                                </div>
                                <div class="card-body text-end pt-3">
                                    <form action="./controlador/subirAprendices.php" method="post">

                                        <input type="submit" class="btn btn-primary text-start" required value="Subir aprendices">
                                        <input name="datostabla" id="datostabla" type="hidden" size="524288" value=" ">
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>

                    <script>
                        tableToJson(document.getElementById("tabla"))



                        function tableToJson(table) {

                            var data = [];

                            // first row needs to be headers
                            var headers = [];
                            for (var i = 0; i < table.rows[0].cells.length; i++) {
                                headers[i] = table.rows[0].cells[i].innerText
                            }

                            // go through cells
                            for (var i = 1; i < table.rows.length; i++) {

                                var tableRow = table.rows[i];
                                var rowData = {};

                                for (var j = 0; j < tableRow.cells.length; j++) {

                                    rowData[headers[j]] = tableRow.cells[j].innerText;

                                }

                                data.push(rowData);

                            }
                            document.getElementById("datostabla").value = JSON.stringify(data);
                            return data;


                        }
                    </script>
                </div>

                <div id="pestaña2" class="tabcontent">

                    <div class="col-12">
                        <div class="card">



                            <div class="card-body">
                                <h5 class="card-title">Segundo formato</h5>
                                <form action="./controlador/leerexcel2.php" class="form" method="post" enctype='multipart/form-data'>


                                    <input class="btn btn-success form-control" accept=".xlsx, .xls" required type="file" name="excelfile" id="">
                                    <p></p>
                                    <input class="btn btn-primary  form-control" value="Subir archivo seleccionado" type="submit">


                                </form>
                            </div>

                        </div>
                    </div>


                    <div class="col-12">
                        <div class="card ">



                            <div class="card-body">
                                <h5 class="card-title">Preinscritos</span></h5>

                                <div id="contenedor">


                                    <?php if (isset($_POST["tabla2"])) {
                                        echo str_replace('^', '"', $_POST["tabla2"]);
                                    } ?>
                                </div>



                            </div>

                        </div>


                    </div>
                </div>

                <div id="pestaña3" class="tabcontent">
                    <div class="col-12">
                        <div class="card">



                            <div class="card-body">
                                <h5 class="card-title">Tercer formato</h5>
                                <form action="./controlador/leerexcel3.php" class="form" method="post" enctype='multipart/form-data'>


                                    <input class="btn btn-success required form-control" accept=".xlsx, .xls" type="file" name="excelfile" id="">
                                    <p></p>
                                    <input id="subir" class="btn btn-primary form-control" value="Subir archivo seleccionado" type="submit">
                                    <input name="datostabla2" id="datostabla2" type="hidden" value=" ">

                                </form>
                            </div>

                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card recent-sales overflow-auto">



                            <div class="card-body">
                                <h5 class="card-title">Inscritos</span></h5>

                                <div id="contenedor">


                                    <?php if (isset($_POST["tabla3"])) {
                                        echo str_replace('^', '"', $_POST["tabla3"]);
                                    } ?>
                                </div>


                            </div>

                        </div>

                    </div>

                </div>


                <script>
                    document.getElementById("subir").addEventListener("click", () => {
                        tableToJson2(document.getElementById("tabla2"))
                    })
                    tableToJson2(document.getElementById("tabla2"))

                    function tableToJson2(table) {
                        var data = [];
                        console.log("A")

                        // first row needs to be headers
                        var headers = [];
                        for (var i = 0; i < table.rows[0].cells.length; i++) {
                            headers[i] = table.rows[0].cells[i].innerText
                        }

                        // go through cells
                        for (var i = 1; i < table.rows.length; i++) {

                            var tableRow = table.rows[i];
                            var rowData = {};

                            for (var j = 0; j < tableRow.cells.length; j++) {

                                rowData[headers[j]] = tableRow.cells[j].innerText;

                            }

                            data.push(rowData);

                        }
                        document.getElementById("datostabla2").value = JSON.stringify(data);
                        return data;


                    }
                </script>


                <div id="pestaña4" class="tabcontent">


                    <div class="col-12">

                        <div class="card">



                            <div class="card-body ">



                                <h5 class="card-title">Buscar fichas</h5>


                                <form action="index.php" method="POST">

                                    <div class="row p-3 ">




                                        <input placeholder="Ingrese la ficha" min="1" aria-placeholder="Ingresar ficha" required type="number" name="Ficha" id="ficha" class=" form-control">
                                        <p></p>
                                        <input type="submit" value="Consultar ficha" class=" btn btn-primary">
                                        <input type="hidden" name="tab4">


                                </form>

                            </div>

                            <div class="">


                                <br>

                                <table class="datatable table table-striped" style="width:100%" id="tablai">
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
                                    <tbody id="miTabla">
                                        <?php
                                        // Verificar si se han enviado parámetros de búsqueda
                                        if (isset($_POST['Ficha'])) {

                                            // Obtener la ficha enviada por GET
                                            $ficha = $_POST['Ficha'];
                                            $mysql = new MySQL();
                                            $mysql->conectar();
                                            // Realizar la consulta SQL para buscar la ficha
                                            $consulta = $mysql->efectuarConsulta("SELECT * FROM  ingresados WHERE ficha =" . $ficha);
                                            $mysql->desconectar();

                                            // Iterar sobre los resultados de la consulta y mostrarlos en la tabla

                                            if (isset($consulta)) {
                                                echo '   <button onclick="tableToExcel(tablai,' . $ficha . ')" class="btn btn-success">Exportar este formato(xls)</button><br> <br>';

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
                                        }

                                        ?>

                                    </tbody>
                                </table>
                            </div>

                            <form form action="./controlador/exportartodos.php" method="post" enctype='multipart/form-data'>
                                <input type="submit" class="btn btn-warning form-control" value="Imprimir formato (separado por fichas)">

                            </form>
                            <br>
                            <form form action="./controlador/exportar.php" method="post" enctype='multipart/form-data'>
                                <input type="submit" class="btn btn-warning form-control" value="Imprimir formato (todas las fichas)">

                            </form>

                        </div>


                    </div>

                </div>

            </div>
            </div>

            </div>

            </div>
        </section>

    </main>


    <div class="modal fade" id="modalTuto" tabindex="-1" aria-labelledby="modalTuto" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title " id="exampleModalLabel">Tutorial</h1>

                </div>
                <div class="modal-body letrap m-4">

                    <h1>Bienvenid@ a la interfaz, <?php echo $user; ?></h1>

                    <br>

                    <div class="bg-info-subtle text-black rounded-1">
                        El aplicativo se encuentra divido en 4 pestañas funcionales.</div>
                    <br>
                    <img src="assets/img/tuto1.png" class="rounded-3 bg-body-tertiary p-1 img img-fluid">
                    <br>
                    <br>


                    <div class="bg-info-subtle text-black rounded-1">
                        Las 3 pestañas de formato mantienen la misma estructura pero el primero tiene una ligera diferencia.</div>
                    <br>
                    <img src="assets/img/tuto5.png" class="rounded-3 bg-body-tertiary p-1 img img-fluid">
                    <br>
                    <br>
                    <div class="bg-info-subtle text-black rounded-1">
                        En la primer pestaña que pertenece al primer formato debe ingresar el formato correspondiente, ejemplo:
                    </div>
                    <br>
                    <img src="assets/img/tuto2.png" class="rounded-3 bg-body-tertiary p-1 img img-fluid">

                    <br>
                    <br>
                    <div class="bg-warning-subtle text-black rounded-1">
                        El sistema requiere el primer formato y luego de subirlo, debe recordar revisar los conflictos (Si se han presentado), para luego enviar los aprendices a la base de datos.
                    </div>
                    <br>
                    <img src="assets/img/tuto10.png" class="rounded-3 bg-body-tertiary p-1 img img-fluid">

                    <br>
                    <br>
                    <div class="bg-warning-subtle text-black rounded-1">
                Estados:   
                    </div>
                    <br>
                    
                    <div class="grid text-center p-4 rounded-3 bg-dark-subtle" style="--bs-gap: .25rem 1rem;">  
                    <img src="assets/img/tuto6.png" class="rounded-3 bg-body-tertiary p-1 img img-fluid">
                    <br>
                    <br>
                    <img src="assets/img/tuto7.png" class="rounded-3 bg-body-tertiary p-1 img img-fluid">
                    <br>
                    <br>
                    <img src="assets/img/tuto8.png" class="rounded-3 bg-body-tertiary p-1 img img-fluid">
                    <br>
                    <br>
                    <img src="assets/img/tuto9.png" class="rounded-3 bg-body-tertiary p-1 img img-fluid">
                   </div>
                  <br>
                    <br>

                    <div class="bg-info-subtle text-black rounded-1">
                       Si se han encontrado conflictos, deberá presionar el botón azul que se encuentra en el estado del aprendíz, el cual mostrará una ventana pidiendo su confirmación.
                    </div>

                    <br>
                    <br>
                    <img src="assets/img/tuto11.png" class="rounded-3 bg-body-tertiary p-1 img img-fluid">
           
                    <br>
                    <br>
                    <div class="bg-info-subtle text-black rounded-1">
                        En la segunda pestaña que pertenece al segundo formato debe ingresar el formato correspondiente, ejemplo:
                    </div>
                    <br>
                    <div class="bg-warning-subtle text-black rounded-1">
                        Validaciones: El sistema debe encontrar en el documeto: "Preinscrito", de lo contrario, retornará error.
                    </div>
                    <br>
                    <img src="assets/img/tuto3.png" class="rounded-3 bg-body-tertiary p-1 img img-fluid">
                    <br>
                    <br>

                    <br>
                    <div class="bg-info-subtle text-black rounded-1">
                        En la tercer pestaña que pertenece al tercer formato debe ingresar el formato correspondiente, ejemplo:
                    </div>
                    <br>
                    <div class="bg-warning-subtle text-black rounded-1">
                        Validaciones: El sistema debe encontrar en el documeto: "Anulado Matricula" o "Matriculado", de lo contrario, retornará error.
                    </div>
                    <br>
                    <img src="assets/img/tuto4.png" class="rounded-3 bg-body-tertiary p-1 img img-fluid">
                    <br>
                   
                    <br>

                    <div class="bg-danger-subtle text-black rounded-1">
                        Nota 1: recordar que el formato 2 y 3 tienen la misma estructura, el sistema lo valida y en caso de que no cumpla, retornará error, deberá retificar que no se confunda con el formato 3.
                    </div>
                    <br>
                    <div class="bg-danger-subtle text-black rounded-1">
                        Nota 2: El formato 1 requiere la confirmación para subir los aprendices presionando el botón de "subir aprendices", en el formato 2 y 3 al subir el archivo, los cambios en la base de datos se realizan automaticamente.
                    </div>
                    <br>
                    <br>
                    <div class="bg-info-subtle text-black rounded-1">
                        En la pestaña de consultar fichas podrá generar todos los informes como un archivo descargable y tambien puede consultar unicamente por ficha.
                    </div>
                    <br>
                    <img src="assets/img/tuto12.png" class="rounded-3 bg-body-tertiary p-1 img img-fluid">
                    <br>
                    <br>

                    <div class="bg-danger-subtle text-black rounded-1">
                        Cuando inicie sesión por primera véz, lo hará con una contraseña pre-establecida, le recomendamos cambiarla inmediatamente aqué:</div>
                    <br>
                
                  
                    <br>
                    <img src="assets/img/tuto13.png" class="rounded-3 bg-body-tertiary p-1 img img-fluid">
                    <br>
                    <br>
                    
                    <div class="bg-info h2 text-white p-2 rounded-1">
                     Muchas gracias.</div>
                    <br>

                    <p></p>

                    <form action="controlador/cambiarpass.php?id=<?php echo $id; ?>" method="post">

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modalPass" tabindex="-1" aria-labelledby="modalPass" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Ingrese Nueva contraseña</h1>
                </div>
                <div class="modal-body">
                    <form action="controlador/cambiarpass.php?id=<?php echo $id; ?>" method="post">

                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Contraseña nueva</label>
                            <input type="password" required class="form-control" name="pass">


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-danger">Cambiar</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>






    <footer id="" class="footer" style=" background-color: rgb(113, 200, 114);">
        <div class="text-center text-white">
            &copy; Copyright <strong><span>Centro de Tecnologias Agroindustriales SENA </span></strong>- Todos los
            derechos reservados, 2024.
        </div>
        <div class="credits">
            <!-- All the links in the footer should remain intact. -->
            <!-- You can delete the links only if you purchased the pro version. -->
            <!-- Licensing information: https://bootstrapmade.com/license/ -->
            <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
            <!--  Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>-->
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/chart.js/chart.umd.js"></script>
    <script src="assets/vendor/echarts/echarts.min.js"></script>
    <script src="assets/vendor/quill/quill.min.js"></script>

    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <script src="assets/js/tabcontrol.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="assets/js/htmltoexcel.js"></script>


    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/datatables.js"></script>
    <script src="assets/js/datatablebuttons.js"></script>
    <script src="assets/js/dtbuttons.js"></script>
    <script src="assets/js/responsive.js"></script>
    <script src="assets/js/jszip.js"></script>
    <script src="assets/js/responsibledt.js"></script>
    <script src="assets/js/dtprint.js"></script>
    <script src="assets/js/pdfmake.js"></script>
    <script src="assets/js/dthtml5.js"></script>
    <script src="assets/js/pdffonts.js"></script>

    <script src="assets/js/cargartabla.js"></script>






    <script>
        let documento;
        let btncancelar = document.getElementById("btncancelar")

        function leer(doc, razon) {

            document.getElementById("cancelar").value = doc
            document.getElementById("razones").innerHTML = `<span class="text-dark">${razon}</span>`;
            documento = doc;
            target = document.getElementById("cancelar").value;
            btncancelar.addEventListener("click", escribir);

        }

        function escribir() {
            console.log(documento)
            document.getElementById(documento.toString()).innerHTML = `<span class="badge bg-dark">Anulado</span>`;

        }
    </script>
    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

</body>

</html>



<?php


if (isset($_POST['tab1'])) {

    echo '<script>
    openTab(event, "pestaña1")
    </script>';
}

if (isset($_POST['tab2'])) {

    echo '<script>
    openTab(event, "pestaña2")
    </script>';
}


if (isset($_POST['tab3'])) {

    echo '<script>
    openTab(event, "pestaña3")
    </script>';
}

if (isset($_POST['tab4'])) {

    echo '<script>
    openTab(event, "pestaña4")
    </script>';
}


if (isset($_POST['error'])) {

    echo   '<script> Swal.fire({
        icon: "error",
        title: "Oops...",
        text: " ' . $_POST['error'] . '",
     
      });  </script>';
}

if (isset($_POST['cambio'])) {

    echo   '<script> Swal.fire({
        icon: "success",
        title: "Hecho",
        text: "Se ha cambiado la contraseña correctamente",
     
      });  </script>';
}

if (isset($_POST['incorrecto'])) {

    echo   '<script> Swal.fire({
        icon: "error",
        title: "Oops...",
        text: " ' . $_POST['incorrecto'] . '",
     
      });  </script>';
}





?>