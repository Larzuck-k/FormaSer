<?php

class MYSQL
{
    private $ipServidor = "localhost:3306";
    private $usuarioBase = 'root';
    private $contrasena = '';
    private $nombreBaseDatos = 'bd_formaser';
    private $conexion; // Definimos la propiedad $conexion
    
    public function conectar()
    {
        $this->conexion = mysqli_connect($this->ipServidor, $this->usuarioBase, $this->contrasena, $this->nombreBaseDatos);
        if (!$this->conexion) {
            die("La conexión ha fallado: " . mysqli_connect_error());
        }
        return $this->conexion; // Devolvemos la conexión
    }

    public function desconectar()
    {
        if ($this->conexion) {
            mysqli_close($this->conexion);
            $this->conexion = null; // Limpiamos la propiedad $conexion
            return true;
        } else {
            return false;
        }
    }

    public function efectuarConsulta($consulta)
    {
        $this->conectar();
        if (!$this->conexion) {
            die("Error: No se ha establecido una conexión a la base de datos.");
        }
    
        mysqli_query($this->conexion, "SET lc_time_names = 'es_Es'");
        mysqli_query($this->conexion, "SET NAMES 'utf8'");
    
        $resultadoConsulta = mysqli_query($this->conexion, $consulta);
    
        // Verificar si es una consulta de inserción y obtener el ID generado
        if (strpos(strtoupper($consulta), 'INSERT') !== false) {
            $id_generado = mysqli_insert_id($this->conexion);
            return $id_generado;
        }
    
        return $resultadoConsulta;
    }


    public function ConsultaCompleja($consulta)
    {
        try {
            if ($this->conectar()) {
                $resultado = $this->efectuarConsulta($consulta);
                if ($this->desconectar()) {
                    return $resultado;
                } else {
                    echo "Error al Desconectarse...\n";
                    return false;
                }
            } else {
                echo "Error al conectarse...\n";
                return false;
            }
        } catch (mysqli_sql_exception $ex) {
            echo $ex;
            return false;
        }
    }

    
}




?>
