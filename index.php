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
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">
    <link rel="assets/css/tabcontrol.css" href="style.css">

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
                                    <form action="./controlador/leerexcel.php" method="post" enctype='multipart/form-data'>

                                        <div class="container text-center ">
                                            <input class="btn btn-success  col-5 p-3" accept=".xlsx, .xls" required type="file" name="excelfile" id="">
                                            <p></p>
                                            <input class="btn btn-primary  col-5 p-3" value="Subir archivo seleccionado" type="submit">

                                        </div>
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
                                        
                                        <input type="submit" class="btn btn-primary text-start" required value="Enviar aprendices">
                                        <input name="datostabla" id="datostabla" type="hidden" value=" ">
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
                                <form action="./controlador/leerexcel2.php" method="post" enctype='multipart/form-data'>

                                    <div class="container text-center ">
                                        <input class="btn btn-success  col-5 p-3" accept=".xlsx, .xls" required  type="file" name="excelfile" id="">
                                        <p></p>
                                        <input class="btn btn-primary  col-5 p-3" value="Subir archivo seleccionado" type="submit">

                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>


                    <div class="col-12">
                        <div class="card recent-sales overflow-auto">



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
                                <form action="./controlador/leerexcel3.php" method="post" enctype='multipart/form-data'>

                                    <div class="container text-center ">
                                        <input class="btn btn-success required  col-5 p-3" accept=".xlsx, .xls" type="file" name="excelfile" id="">
                                        <p></p>
                                        <input id="subir" class="btn btn-primary col-5 p-3" value="Subir archivo seleccionado" type="submit">
                                        <input name="datostabla2" id="datostabla2" type="hidden" value=" ">
                                    </div>
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
       

        <div class=" p-5">
        <form action="index.php" method="POST">
         
         <div class="row text-center align-content-between">
         <h5 class="card-title">Buscar fichas</h5>
         <div class="col-10">
           
         <select class="form form-control" name="Ficha"  id="ficha">
           <?php

           $mysql = new MySQL();
           $mysql->conectar();
           // Realizar la consulta SQL para buscar la ficha
           $consulta = $mysql->efectuarConsulta("SELECT  Ficha, nombre_curso from fichas ");

           while ($fila = mysqli_fetch_array($consulta)) {
               echo '  <option value="'.$fila[0].'">'.$fila[0].' - '.$fila[1].'</option>';

           }
           $mysql->desconectar();
           ?>

       </select>
           </div>

           <div class="col-2 ">
         <input type="submit" value="Consultar ficha" class=" btn btn-primary">
         <input type="hidden" name="tab4">
         </div>
         </div>
       </form>
       <br>
          <div class="col-12">



            <?php



            ?>
            <table class="table table-striped datatable" id="datatable">
              <thead class="text-center thead-dark">
                <tr>
                  <th>Ficha</th>
                  
                  <th>Nombre completo</th>
                  <th>Fecha de ingreso</th>
                  <th>Estado</th>
                  <th>Tipo de documento</th>
                  <th>Documento</th>

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
                  $consulta = $mysql->efectuarConsulta("SELECT * FROM  ingresados WHERE ficha = 2952573");
$mysql->desconectar();

                  // Iterar sobre los resultados de la consulta y mostrarlos en la tabla
                  while ($fila = mysqli_fetch_array($consulta)) {
                    echo "<tr>";
                    echo "<td>{$fila[0]}</td>";
                    echo "<td>{$fila[1]}</td>";
                    echo "<td>{$fila[2]}</td>";
                    echo "<td>{$fila[3]}</td>";
                    echo "<td>{$fila[4]}</td>";
                    echo "<td>{$fila[5]}</td>";
            
                    echo "</tr>";
                  }
                }
              
                ?>
              </tbody>
            </table>
          </div>




        </div>


      </div>

    </div>

  </div>
</div>

            </div>

            </div>
        </section>

    </main>

    <footer id="" class="footer" style=" background-color: rgb(113, 200, 114);">
        <div class="copyright">
            &copy; Copyright <strong><span>Centro de Tecnologias Agroindustriales SENA </span></strong>- Todos los
            derechos reservados, 2024.
        </div>
        <div class="credits">
            <!-- All the links in the footer should remain intact. -->
            <!-- You can delete the links only if you purchased the pro version. -->
            <!-- Licensing information: https://bootstrapmade.com/license/ -->
            <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
            Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/chart.js/chart.umd.js"></script>
    <script src="assets/vendor/echarts/echarts.min.js"></script>
    <script src="assets/vendor/quill/quill.min.js"></script>
    <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <script src="assets/js/tabcontrol.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        openTab(event, 'pestaña1')
    </script>
    <script>
        let documento;
        let btncancelar = document.getElementById("btncancelar")

        function leer(doc) {

            document.getElementById("cancelar").value = doc
            documento = doc;
            target = document.getElementById("cancelar").value;
            btncancelar.addEventListener("click", escribir);

        }

        function escribir() {
            console.log(documento)
            document.getElementById(documento.toString()).innerHTML = `<span class="badge bg-dark">Inscripción cancelada</span>`;

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
        text: " '. $_POST['error'] .'",
     
      });  </script>';
}

if (isset($_POST['incorrecto'])) {

    echo   '<script> Swal.fire({
        icon: "error",
        title: "Oops...",
        text: " '. $_POST['incorrecto'] .'",
     
      });  </script>';
}


?>