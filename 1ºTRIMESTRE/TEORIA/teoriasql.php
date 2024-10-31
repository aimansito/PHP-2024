<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table,
        td,
        th {
            border: 1px solid black;
        }

        table {
            border-collapse: collapse;
        }
    </style>
</head>

<body>
    <h1>TEORIA BD</h1>
    <?php
    const SERVIDOR_BD = "localhost";
    const USUARIO_BD = "jose";
    const CLAVE_BD = "josefa";
    const NOMBRE_BD = "bd_teoria2";

    try {

        @$conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
        mysqli_set_charset($conexion, "utf8");
    } catch (Exception $e) {
        die("<p>NO se ha podido conectar a la BD: " . $e->getMessage() . "</p></body></html>");
    }

    try {
        $consulta = "select * from t_alumnos";
        $resultado = mysqli_query($conexion, $consulta);
    } catch (Exception $e) {
        mysqli_close($conexion);
        die("<p>No se ha podido realizar la consultar: " . $e->getMessage() . "</p></body></html>");
    }

    $n_tuplas = mysqli_num_rows($resultado);
    echo "<p>El numero de alumnos enla tabla t_alumnos es ahora mismo: " . $n_tuplas . "</p>";


    echo "<h3>Mostrando las duplas</h3>";
    $tupla = mysqli_fetch_assoc($resultado);

    echo "<p>El nombre del primer alumno obtenido es: " . $tupla["nombre"] . "</p>";
    $tupla = mysqli_fetch_row($resultado);
    echo "<p>El telefono del segundo alumno obtenido es: " . $tupla[2] . "</p>";
    $tupla = mysqli_fetch_object($resultado);
    echo "<p>El codigo postal del tercer alumno obtenido es: " . $tupla->cp . "</p>";

    mysqli_data_seek($resultado, 1);

    mysqli_free_result($resultado);

    $tupla = mysqli_fetch_array($resultado);
    echo "<p>El nombre del siguiente alumno obtenidio es: 
        " . $tupla[1] . "y el telefono es: " . $tupla["telefono"] . "</p>";

    echo "<h2>Por ahora todo bien</h2>";

    mysqli_data_seek($resultado, 0);
    echo "<h3> informacion de todos los alumnos</h3";
    echo "<table>";
    echo "<tr>
    <th>Codigo</th>
    <th>Nombre</th>
    <th>Teléfono</th>
    <th>Código Postal</th>
    </tr>";
    while ($tupla = mysqli_fetch_assoc($resultado)) {
        echo "<tr>
            <td>{$tupla['nombre']}</td>
            <td>{$tupla['telefono']}</td>
            <td>{$tupla['codigo_postal']}</td>
          </tr>";
    }
    echo "</table>";

    //LAS NOTAS DE TODOS LOS ALUMNOS DE LA ASIGNATURA. 

    mysqli_close($conexion);
    echo "<h2>Cierro conexión</h2>";
    ?>
</body>

</html>