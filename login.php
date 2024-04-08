<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<body>
	


<form class="" action="controlador/login.php" method="post">
	<span class="">
		Ingrese para continuar
	</span>


	<div>
		<input required placeholder="Documento" class="" type="text" name="doc">
		<span class=""></span>

	</div>


	<div class=""">
		<input required placeholder="Contraseña" class="" type="password" name="pass">
		<span class=""></span>

	</div>




	<div class="">
		<button class="" type="submit">
			Ingresar
		</button>
	</div>



</form>



</body>
</html>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        if (<?php if(isset($_GET['Error'])){ echo ($_GET['Error']); } else{echo "false";}?>  == true) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "<?php if(isset($_GET['Mensaje'])){ echo ($_GET['Mensaje']); }?>",
              
            });

        }
    </script>
