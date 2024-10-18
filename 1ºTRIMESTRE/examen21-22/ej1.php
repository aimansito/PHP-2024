<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 6</title>
</head>
<body>
    <h1>Ejercicio 1</h1>
    <form action="ej1.php" method="post" enctype="multipart/form-data">
        <label for="tex">Escribe un texto</label>
        <input type="text" id="tex" name="texto" value="<?php if(isset($_POST["texto"])) echo htmlspecialchars($_POST["texto"]); ?>"/>

        <button type="submit" name="enviar">Contar caracteres</button>
    </form>
    <?php
        function mi_strlen($texto) {
            $cont = 0;
            while (isset($texto[$cont])) {
                $cont++;
            }
            return $cont;
        }

        if (isset($_POST["enviar"])) {
            $texto = $_POST["texto"];
            $numText = mi_strlen($texto);
            echo "<p>Número de caracteres: " . $numText . "</p>";
        }
    ?>
</body>
</html>
