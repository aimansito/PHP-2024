<!DOCTYPE html>
<html lang="es">

<head>
    <title>Segundo Formulario</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .oculta {
            display: none;
        }
        .error{
            color: red;
        }
    </style>
</head>

<body>
    <h1>Segundo Formulario</h1>
    <form method="post" action="index.php" enctype="multipart/form-data">

        <label for="nombre">Nombre: </label><input type="text" name="nombre" id="nombre" value="<?php if(isset($_POST["nombre"])) echo $_POST["nombre"]; ?>" /> 
        <?php
            if(isset($_POST["btnEnviar"]) && $error_nombre){
                echo "<span class='error'>*Campo vacío</span>";
            }
        ?>
        <br /><br />
        <label for="nacido">Nacido en : </label>
        <select id="nacido" name="nacido">
            <option value="Málaga" <?php if(isset($_POST["nacido"]) && $_POST["nacido"]=="Málaga") echo "selected"; ?> >Málaga</option>
            <option value="Cádiz" <?php if(isset($_POST["nacido"]) && $_POST["nacido"]=="Cádiz") echo "selected"; ?>>Cádiz</option>
            <option value="Granada" <?php if(isset($_POST["nacido"]) && $_POST["nacido"]=="Granada") echo "selected"; ?>>Granada</option>
        </select>
        <br /><br />
        Sexo:
         <label for="hombre">Hombre</label><input id="hombre" type="radio" name="sexo" value="Hombre" <?php  if(isset($_POST["sexo"]) && $_POST["sexo"]=="Mujer"); ?> />
         <label for="mujer">Mujer</label><input id="mujer" type="radio" name="sexo" value="Mujer" <?php  if(isset($_POST["sexo"]) && $_POST["sexo"]=="Hombre"); ?> />
         <?php
            if(isset($_POST["btnEnviar"]) && $error_sexo){
                echo "<span class='error'>*Debes elegir un sexo</span>";
            }
         ?>
         <br /><br />


        Aficiones: <label for="deportes">Deportes</label><input id="deportes" type="checkbox" name="aficiones[]" value="Deportes" <?php if(isset($_POST["aficiones"]) && in_array("Deportes",$_POST["aficiones"])) echo "checked";?> />
        <label for="lectura">Lectura</label><input id="lectura" type="checkbox" name="aficiones[]" value="Lectura" <?php if(isset($_POST["aficiones"]) && in_array("Lectura",$_POST["aficiones"])) echo "checked";?> /><label for="otros">Otros</label><input id="otros" type="checkbox" name="aficiones[]" value="Otros" <?php if(isset($_POST["aficiones"]) && in_array("Otros",$_POST["aficiones"])) echo "checked";?> />

        <br /><br />
        <label for="comentarios">Comentarios :</label>
        <textarea id="comentarios" name="comentarios" value="<?php if(isset($_POST["comentarios"])) echo $_POST["comentarios"]; ?>"></textarea>
        <?php
            if(isset($_POST["btnEnviar"]) && $error_comentarios){
                echo "<span class='error'>*Debes comentar</span>";
            }
        ?>
        <br /><br />
        <label for="foto">Incluir mi foto (Archivo de tipo imagen Máx. 500KB): </label><button onclick='event.preventDefault();document.getElementById("foto").click();return false;'>Seleccionar archivo</button><input class="oculta" onchange="document.getElementById('nombre_archivo').innerHTML=' '+document.getElementById('foto').files[0].name+' ';" type="file" name="foto" id="foto" accept="image/*" />
        <span id="nombre_archivo"></span>
        <?php
            if(isset($_POST["btnEnviar"]) && $error_foto){
                if($_FILES["foto"]["name"]==""){
                    echo "<span class='error'>*Debes seleccionar una imagen</span>";
                }elseif ($_FILES["foto"]["error"]) {
                    echo "<span class='error'> * Se ha producido un error en la subida del archivo al servidor</span>";
                } elseif (!tiene_extension($_FILES["foto"]["name"])) {
                    echo "<span class='error'> * El archivo seleccionado no tiene extensión</span>";
                } elseif ($_FILES["foto"]["size"] > 500 * 1024) {
                    echo "<span class='error'> * El archivo seleccionado supera el tamaño permitido</span>";
                } else {
                    echo "<span class='error'> * No es una imagen</span>";
                }
            }
        ?>
        <br /><br />
        <input type="submit" value="Enviar" name="btnEnviar" />&nbsp;
        <input type="submit" value="Borrar Campos" name="btnBorrar" />
    </form>
</body>

</html>