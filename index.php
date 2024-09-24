<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi primera pagina PHP</title>
</head>
<body>
    <h1>Esta es mi super pagina</h1>
    <form action="index.php" method="post" enctype="multipart/form-data">
        <p>
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" maxlength="9" value="<?php if(isset($_POST["nombre"])) echo $_POST["nombre"];?>" placeholder="Teclee su Nombre"/>
        <?php
        if(isset($_POST["btnEnviar"])&& $error_nombre)
           echo "<span class='error'> * Campo Vacío *</span>";
        ?>
        </p>
        <p>
        <label for="nacido">Nacido: </label>
        <select name="nacido" id="nacido">
            <option <?php if(isset($_POST["nacido"]) && $_POST["nacido"]=="Málaga") echo "selected";?> value="Málaga">Málaga</option>
            <option <?php if(isset($_POST["nacido"]) && $_POST["nacido"]=="Almería") echo "selected";?> value="Almería">Almería</option>
            <option <?php if(isset($_POST["nacido"]) && $_POST["nacido"]=="Granada") echo "selected";?> value="Granada">Granada</option>
        </select>
        </p>

        <p>
        Sexo<br/>
            <input type="radio" name="sexo" id="hombre" <?php if(isset($_POST["sexo"]) && $_POST["sexo"]=="hombre") echo "checked";?> value="hombre"/><label for="hombre">Hombre</label>
            <input type="radio" name="sexo" id="mujer" <?php if(isset($_POST["sexo"]) && $_POST["sexo"]=="mujer") echo "checked";?> value="mujer"/><label for="mujer">Mujer</label>
            <?php
            if(isset($_POST["btnEnviar"])&& $error_sexo)
               echo "<span class='error'> * Debes elegir un sexo *</span>";
            ?>
        </p>
        <p>
            <label for="aficiones">Aficiones: </label>
            <label for="Deportes">Deportes</label><input type="checkbox" name="Deportes" <?php if(isset($_POST["Deportes"])) echo "checked";?> id="Deportes"/>
            <label for="Lectura">Lectura</label><input type="checkbox" name="Lectura" <?php if(isset($_POST["Lectura"])) echo "checked";?> id="Lectura"/>
            <label for="Otros">Otros</label><input type="checkbox" name="Otros" <?php if(isset($_POST["Otros"])) echo "checked";?> id="Otros"/>
        </p>
        <p>
            <label for="comentarios">Comentarios</label>
            <textarea name="comentarios" id="comentarios" cols="40" rows="5"><?php if(isset($_POST["comentarios"])) echo $_POST["comentarios"];?></textarea>
            <?php
            if(isset($_POST["btnEnviar"])&& $error_comentarios)
               echo "<span class='error'> * Campo Vacío *</span>";
            ?>
        </p>
        <p>
        <input type="submit" value="Enviar" name="btnEnviar"/>  
        </p>
    </form>
</body>
</html>