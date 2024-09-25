<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario</title>

    <style>
    .error {
        color: red;
    }
    </style>
</head>

<body>
    <h1>
        Rellena tu CV
    </h1>

    <form action="Index.php" method="post" enctype="multipart/form-data">

        <p><label for="name">Nombre</label>
        <input type="text" name="name" id="name" value="<?php if (isset($_POST["name"])) {
                                                                    echo $_POST["name"];
                                                                }   ?>">

            <?php
                if (isset($_POST["enviar"])&&$error_nombre) {

                    echo "<span class='error'>Campo vacio </span>";
                }

                ?>
        </p>

        <label for="nacido">Nacido en: </label>

        <select name="nacido" id="nacidor">

            <option value="Malaga">Malaga</option>

            <option value="Cadiz">Cadiz</option>

            <option value="Sevilla">Sevilla</option>

        </select>





        <p>Sexo:

            

            <input type="radio" name="sexo" id="Hombre" value="Hombre" <?php if (isset($_POST["sexo"]) && $_POST["sexo"] == "Hombre") {
                                                                            echo "checked";
                                                                        }   ?>>
            <label for="Hombre">Hombre</label>
            <input type="radio" name="sexo" id="Mujer" value="Mujer" <?php if (isset($_POST["sexo"]) && $_POST["sexo"] == "Mujer  ") {
                                                                            echo "checked";
                                                                        }   ?>>
            <label for="Mujer">Mujer</label>

            <?php
            if (isset($_POST["enviar"])&&$error_sex) {

                echo "<span class='error'>Eliga un sexo </span>";
            }

            ?>
        </p>
        <p>
            Aficiones:

            <label for="deporte">Deportes</label>
            <input type="checkbox" name="deporte" id="deporte" <?php if (isset($_POST["deporte"])) {
                                                                            echo "checked";
                                                                        }   ?>>

            <label for="lectura">Lectura</label>
            <input type="checkbox" name="lectura" id="lectura" <?php if (isset($_POST["lectura"])) {
                                                                            echo "checked";
                                                                        }   ?>>

            <label for="otro">Otros</label>
            <input type="checkbox" name="otro" id="otro" <?php if (isset($_POST["otro"])) {
                                                                            echo "checked";
                                                                        }   ?>>

            

        </p>





        <p>Comentarios: <textarea id="message" name="message" rows="4"
                cols="30"><?php if (isset($_POST["message"])) { echo $_POST["message"];}?></textarea>
            


        </p>


        <button type="submit" name="enviar">Enviar</button>


    </form>

</body>

</html>