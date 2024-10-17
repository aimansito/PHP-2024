<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 5</title>
    <style>
        /* Estilo para las tablas, celdas y encabezados */
        table, td, th {
            border: 1px solid black; /* Añade bordes negros a la tabla, celdas y encabezados */
        }
        table {
            border-collapse: collapse; /* Evita el espaciado doble entre bordes de las celdas */
            width: 90%; /* Establece el ancho de la tabla al 90% del contenedor */
            margin: 0 auto; /* Centra la tabla horizontalmente */
        }
    </style>
</head>
<body>
    <h1>Ejercicio 5</h1>
    
    <?php
        // Intenta abrir el archivo remoto con la función fopen
        // Se usa @ para suprimir errores si el archivo no se puede abrir
        @$fd = fopen("http://dwese.icarosproject.com/PHP/datos_ficheros.txt", "r");
    ?>
    
    <p>
        <table>
            <caption>PIB per capita de los paises de la union europea</caption> <!-- Título de la tabla -->

            <?php
            // Leer la primera línea del archivo
            $linea = fgets($fd);
            // Dividir la línea en columnas usando el tabulador ("\t") como delimitador
            $datos_linea = explode("\t", $linea);
            // Contar cuántas columnas tiene la primera línea
            $n_col = count($datos_linea);

            // Comenzar la fila de encabezados de la tabla
            echo "<tr>";
            // Bucle para recorrer cada elemento de la primera línea (encabezados)
            for($i = 0; $i < $n_col; $i++) {
                // Mostrar cada valor como un encabezado de tabla (<th>)
                echo "<th>$datos_linea[$i]</th>";
            }
            // Cerrar la fila de encabezados
            echo "</tr>";

            // Bucle para leer el resto de las líneas del archivo
            while($linea = fgets($fd)) {
                // Dividir la línea actual en columnas, usando el tabulador como delimitador
                $datos_linea = explode("\t", $linea);
                // Comenzar una nueva fila en la tabla
                echo "<tr>";
                // Mostrar el primer valor de la fila como un encabezado de fila (<th>)
                echo "<th> $datos_linea[0] </th>";

                // Bucle para mostrar los valores de las columnas de esa fila
                for($i = 0; $i < $n_col; $i++) {
                    // Comprobar si existe un valor en la columna actual
                    if(isset($datos_linea[$i])) {
                        // Mostrar el valor en una celda de tabla (<td>)
                        echo "<td>$datos_linea[$i]</td>";
                    } else {
                        // Si no hay valor, dejar la celda vacía
                        echo "<td></td>";
                    }
                }
                // Cerrar la fila de la tabla
                echo "</tr>";
            }
            
            // Cerrar el archivo después de leer todas las líneas
            fclose($fd);
            ?>
        </table>
    </p>
</body>
</html>
