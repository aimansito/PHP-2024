<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recogida</title>
</head>
<body>
    <h1>Estos son los datos enviados:</h1>

    <?php

        echo "<p><strong>El nombre enviado ha sido: </strong>" . $_POST["name"] . "</p>";
        echo "<p><strong>Ha nacido en: </strong>" . $_POST["nacimiento"] . "</p>";
        echo "<p><strong>El sexo es: </strong>" . $_POST["sex"] . "</p>";

        if (isset($_POST["afic"])) {
            if (count($_POST["afic"]) > 1) {
                echo "<p><b>Las aficiones seleccionadas han sido:</b></p>";
                echo "<ol>";
                for ($i = 0; $i < count($_POST["afic"]); $i++) {

                    echo "<li>" . $_POST["afic"][$i] . "</li>";
                }
                echo "</ol>";
            } else {
                echo "<p><b>La aficion seleccionada ha sido:</b></p>";
                echo "<ol>";
                echo "<li>" . $_POST["afic"][0] . "</li>";
                echo "</ol>";
            }
        } else {
            echo "<p><b>No se han seleccionado aficiones</b></p>";
        }

        /*antes lo que pasaba era que preguntaba si estaba inicializado, lo que tenia que depurar era que tuviera contenido*/
        if ($_POST["coment"] != "") {
            echo "<p><b>El comentario enviado ha sido:</b></p>";
            echo "<p>" . $_POST["coment"] . "</p>";
        } else {
            echo "<p><b>No se ha enviado ningun comentario</b></p>";
        }
    ?>
</body>
</html>