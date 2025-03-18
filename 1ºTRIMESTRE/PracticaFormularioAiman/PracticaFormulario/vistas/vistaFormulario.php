<?php
$err_nombre = false;
$err_sex = false;

if(isset($_POST["enviar"])){
    $err_nombre = $_POST["name"] == "";
    $err_sex = !isset($_POST["sex"]);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi primera pagina php</title>
</head>
<body>
    <h1>Esta es mi super pagina</h1>
    <form action="index.php" method="post">
        <label for="nombre">Nombre: </label>
        <input type="text" name="name" id="nombre"/>
        <?php
        if($err_nombre){
            echo "<label style='color:red;'>*Campo Obligatorio*</label>";
        }
        ?>
        </br>
        <label for="nacido">Nacido en: </label>
        <select name="nacimiento" id="nacido">
            <option value="malaga" <?php if (isset($_POST["nacimiento"]) && ($_POST["nacimiento"] == "malaga")) echo "selected" ?>>Málaga</option>
            <option value="cadiz" <?php if (isset($_POST["nacimiento"]) && ($_POST["nacimiento"] == "cadiz")) echo "selected" ?>>Cádiz</option>
            <option value="sevilla" <?php if (isset($_POST["nacimiento"]) && ($_POST["nacimiento"] == "sevilla")) echo "selected" ?>>Sevilla</option>
        </select>
        </br>
        <label for="sexo">Sexo: </label>
        <label for="hombre">Hombre: </label>
        <input type="radio" name="sex" id="hombre" value="hombre"/>

        <label for="mujer">Mujer: </label>
        <input type="radio" name="sex" id="mujer" value="mujer">

        <?php
        if ($err_sex) {
            echo "<label style='color:red;'>*Campo obligatorio*</label>";
        }
        ?>
        </br>
        <label>Aficiones: </label>

        <label for="dep"> Deportes</label>
        <input type="checkbox" name="afic[]" id="dep" value="Deportes" 
        <?php
        //hecho a mi manera
        if (isset($_POST["afic"])) {
            for ($i = 0; $i < count($_POST["afic"]); $i++) {
                if (($_POST["afic"][$i]) == "Deportes") {
                    echo "checked";
                }
            }
        }
        ?>>
        <label for="lec"> Lectura</label>
        <?php //manera mas eficinete, ya que se realiza en una sola linea y es como si hiciera un for buscando ese valor en el array ?>
        <input type="checkbox" name="afic[]" id="lec" value="Lectura" <?php if (isset($_POST["afic"]) && in_array("Lectura", $_POST["afic"])) echo "checked"; ?>>

        <label for="otro"> Otros</label>
        <input type="checkbox" name="afic[]" id="otro" value="Otros" <?php if (isset($_POST["afic"]) && in_array("Otros", $_POST["afic"])) echo "checked"; ?>>

        <br />

        <label for="com">Comentarios: </label>
        <!-- esto tiene que estar en una linea, que sino, no sale cmo deberia -->
        <textarea name="coment" id="com" cols="30" rows="10"><?php if (isset($_POST["coment"])) echo $_POST["coment"] ?></textarea>

        </br>
        <input type="submit" value="Enviar datos" name="enviar">
    </form>
</body>
</html>