<!doctype html>
<html lang="en">
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="assets/fonts/icomoon/style.css">

    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">

   
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link href="assets/img/logo-sena-verde-complementario-png-2022.png" rel="icon">

    <link rel="stylesheet" href="assets/css/styleLog.css">

    <title>FormaSer - Ingreso</title>
  </head>
  <body>
  <!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="assets/fonts/icomoon/style.css">

    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    
    <!-- Style -->
    <link rel="stylesheet" href="assets/css/styleLog.css">

    <title>Login #2</title>
  </head>
  <body>
  

  <div class="d-lg-flex half">
    <div class="bg order-1 order-md-2" style="background-image: url('assets/img/ctacartago.jpg');
    
    background-position-x: right;"></div>
    <div class="contents order-2 order-md-1">

      <div class="container">
        <div class="row align-items-center justify-content-center">
          <div class="col-md-7">
            <h3>Login en <span class="">Forma</span><span class="text-color-green" style="color: rgb(113, 200, 114);">Ser</span></h3>
            <p class="mb-4">Aplicativo de registro de estudiantes del mañana, CTA SENA REGIONAL VALLE</p>
            <form action="controlador/login.php" method="post">
              <div class="form-group first">
                <label for="Identificación">Identificación</label>
                <input required type="number" class="form-control" name="doc" placeholder="C.C" id="username">
              </div>
              <div class="form-group last mb-3">
                <label for="contrasena">Contraseña</label>
                <input required type="password" class="form-control" name="pass" placeholder="Ingresa contraseña" id="contrasena">
              </div>
              
         <br>

              <input type="submit" value="Ingresar" class="btn btn-block btn-green">

            </form>
          </div>
        </div>
      </div>
    </div>

    
  </div>
    
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>




    
    


  </body>
</html>

<?php 

if (isset($_POST['error-login'])) {

  echo   '<script> Swal.fire({
      icon: "error",
      title: "Oops...",
      text: " ' . $_POST['error-login'] . '",
   
    });  </script>';
}

?>