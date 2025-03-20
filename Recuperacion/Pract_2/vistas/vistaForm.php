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
    </style>
</head>
<body>
    <h1>Segundo Formulario</h1>
    <form method="post" action="index.php" enctype="multipart/form-data">

        <label for="nombre">Nombre: </label><input type="text" name="nombre" id="nombre" value="" /> <br /><br />
        <label for="nacido">Nacido en : </label>
        <select id="nacido" name="nacido">
            <option value="Málaga">Málaga</option>
            <option value="Cádiz">Cádiz</option>
            <option value="Granada">Granada</option>
        </select>
        <br /><br />
        Sexo: <label for="hombre">Hombre</label><input id="hombre" type="radio" name="sexo" value="Hombre" /><label for="mujer">Mujer</label><input id="mujer" type="radio" name="sexo" value="Mujer" />
        <br /><br />


        Aficiones: <label for="deportes">Deportes</label><input id="deportes" type="checkbox" name="aficiones[]" value="Deportes" />
        <label for="lectura">Lectura</label><input id="lectura" type="checkbox" name="aficiones[]" value="Lectura" /><label for="otros">Otros</label><input id="otros" type="checkbox" name="aficiones[]" value="Otros" />

        <br /><br />
        <label for="comentarios">Comentarios :</label>
        <textarea id="comentarios" name="comentarios"></textarea>
        <br /><br />
        <label for="foto">Incluir mi foto (Archivo de tipo imagen Máx. 500KB): </label><button onclick='document.getElementById("foto").click();return false;'>Seleccionar archivo</button><input class="oculta" onchange="document.getElementById('nombre_archivo').innerHTML=' '+document.getElementById('foto').files[0].name+' ';" type="file" name="foto" id="foto" accept="image/*" />
        <span id="nombre_archivo">
        </span>
        <br /><br />
        <input type="submit" value="Enviar" name="btnEnviar" />&nbsp;
        <input type="submit" value="Borrar Campos" name="btnBorrar" />
    </form>
</body>
</html>