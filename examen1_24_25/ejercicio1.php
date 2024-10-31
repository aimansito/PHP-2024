
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 1</title>
    <style>
        .error{
            color: red;
        }
    </style>
</head>
<body>
    <h1>Ejercicio 1</h1>
    <form action="ejercicio1.php" method="post" enctype="multiform/form-data">
        <p>
            <label for="fichero">Seleccione un fichero de texto plano para agregar el fichero aulas.txt(Máx. 500KB)</label>
            <input type="file" id="fichero" name="fichero" accept=".txt">
        </p>
        <p>
            <button type="submit" value="Agregar">Agregar</button>
            <button type="Crear/Vaciar" value="Crear">Crear/Vacíar</button>
        </p>
    </form>
    <?php
        if(isset($_POST["Agregar"])){
            if($_FILES("fichero") == ""){
                echo "<span class='error'>El campo está vacío</span>";
            }else if($_FILES("fichero") != "text/plain"){
                echo "</span class='error'>El archivo que has subido no es de texto plano</span>";
            }else{
                echo "<span class='error'>El archivo sobrepasa el tamaño permitido</span>";
            }
        }
        @$var = move_uploaded_file('./Aulas');
    ?>
</body>
</html>