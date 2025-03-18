<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 6</title>
</head>
<body>
    <h1>Ejercicio 6</h1>

    <?php
        // Intenta abrir el archivo remoto con fopen
        @$fd = fopen("http://dwese.icarosproject.com/PHP/datos_ficheros.txt", "r"); // Usa @ para suprimir errores
        if(!$fd) {
            die("<h3>No se puede abrir el archivo</h3>"); // Si no puede abrir el archivo, detiene la ejecución
        }

        $paises = [];  // Inicializa un array para almacenar los nombres de los países
        $datosPaisSelect = []; // Inicializa un array para guardar los datos del país seleccionado

        // Lee la primera línea del archivo, que contiene los nombres de las columnas (campos de datos)
        $primera_linea = fgets($fd);

        // Itera por cada línea del archivo hasta que termine
        while ($linea = fgets($fd)) {  // Corrige el ciclo para que lea cada línea correctamente
            $datos_linea = explode("\t", $linea); // Divide cada línea por tabulaciones

            // El primer campo (columna 0) contiene varios datos separados por comas
            $datosPrCol = explode(",", $datos_linea[0]);

            // Se almacena el tercer valor del campo (nombre del país)
            $paises[] = $datosPrCol[2]; 

            // Si el país seleccionado coincide con el país de esta línea, guarda sus datos
            if (isset($_POST["pais"]) && $_POST["pais"] == $datosPrCol[2]) {
                $datosPaisSelect = $datos_linea;
            }
        }

        fclose($fd); // Cierra el archivo después de procesarlo
    ?>

    <!-- Formulario para seleccionar un país -->
    <form action="ej6.php" method="post">
        <p>
            <label for="pais">Seleccione un país</label>
            <select name="pais" id="pais">
                <?php
                // Genera una lista desplegable con los nombres de los países
                for ($i = 0; $i < count($paises); $i++) {
                    // Marca como seleccionada la opción si coincide con el país seleccionado previamente
                    if (isset($_POST["pais"]) && $_POST["pais"] == $paises[$i]) {
                        echo "<option selected value='" . $paises[$i] . "'>" . $paises[$i] . "</option>";
                    } else {
                        echo "<option value='" . $paises[$i] . "'>" . $paises[$i] . "</option>";
                    }
                }
                ?>
            </select>
        </p>
        <p>
            <button name="buscar" type="submit">Buscar</button> <!-- Botón para buscar el país seleccionado -->
        </p>
    </form>

    <?php
        // Si el formulario ha sido enviado
        if (isset($_POST["buscar"])) {
            // Muestra el país seleccionado
            echo "<h2>PIB per capita de " . $_POST["pais"] . "</h2>";

            // Muestra los años (nombres de las columnas) de la primera línea
            $datosPrCol = explode("\t", $primera_linea); 

            // Número de años (columnas menos la primera, que es el país)
            $n_anios = count($datosPrCol) - 1;

            echo "<table>";
            echo "<tr>";

            // Imprime los encabezados de las columnas (años)
            for ($i = 1; $i <= $n_anios; $i++) {
                echo "<th>" . htmlspecialchars($datosPrCol[$i]) . "</th>"; // Usa htmlspecialchars para evitar XSS
            }

            echo "</tr><tr>";

            // Imprime los datos del país seleccionado (el PIB por año)
            for ($i = 1; $i <= $n_anios; $i++) {
                if (isset($datosPaisSelect[$i])) {
                    echo "<td>" . htmlspecialchars($datosPaisSelect[$i]) . "</td>";
                } else {
                    echo "<td></td>"; // Si no hay datos, deja la celda vacía
                }
            }

            echo "</tr>";
            echo "</table>"; // Finaliza la tabla
        }
    ?>
</body>
</html>
 