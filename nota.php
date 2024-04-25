<div id="pestaña4" class="tabcontent">
  <div class="col-12">
    <div class="card">



      <div class="card-body">
        <form action="index.php" method="POST">
          <h5 class="card-title">Buscar fichas</h5>
          <input type="number" name="Ficha" id="ficha">
          <input type="submit" class="btn btn-primary btn-sm">
          <input type="hidden" name="tab4">
        </form>

        <div class="container text-center ">
          <div class="col-12">



            <?php



            ?>
            <table class="table table-striped datatable" id="datatable">
              <thead class="text-center thead-dark">
                <tr>
                  <th>Ficha</th>
                  <th>Nombre del curso</th>
                  <th>Fecha de inicio</th>
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
                  $mysql = new Mysql();
                  $mysql->conectar();
                  // Realizar la consulta SQL para buscar la ficha
                  $consulta = $mysql->efectuarConsulta("
SELECT
  cursos_aprendiz.ficha AS Ficha,
  fichas.nombre_curso AS 'Nombre del curso',
  fichas.fecha_inicio AS 'Fecha de inicio',
  ingresados.nombre_completo AS 'Nombre completo',
  ingresados.fecha_ingreso AS 'Fecha de ingreso',
  ingresados.estado AS Estado,
  ingresados.tipo_documento AS 'Tipo de documento',
  ingresados.documento AS Documento
FROM
  cursos_aprendiz
INNER JOIN fichas ON cursos_aprendiz.ficha = fichas.ficha
INNER JOIN ingresados ON cursos_aprendiz.ficha = ingresados.ficha
WHERE
  cursos_aprendiz.ficha = $ficha
");

                  // Iterar sobre los resultados de la consulta y mostrarlos en la tabla
                  while ($fila = mysqli_fetch_array($consulta)) {
                    echo "<tr>";
                    echo "<td>{$fila[0]}</td>";
                    echo "<td>{$fila[1]}</td>";
                    echo "<td>{$fila[2]}</td>";
                    echo "<td>{$fila[3]}</td>";
                    echo "<td>{$fila[4]}</td>";
                    echo "<td>{$fila[5]}</td>";
                    echo "<td>{$fila[6]}</td>";
                    echo "<td>{$fila[7]}</td>";
                    echo "</tr>";
                  }
                }
                $mysql->desconectar();
                ?>
              </tbody>
            </table>
          </div>




        </div>


      </div>

    </div>

  </div>
</div>