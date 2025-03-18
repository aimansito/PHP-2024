<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        if(isset($_POST["guardar"])){

            echo"<p><strong>Nombre: </strong>".$_POST["Nombre"]."</p>";
            echo"<p><strong>Apellidos: </strong>".$_POST["Apellidos"]."</p>";
            echo"<p><strong>Contraseña: </strong>".$_POST["pass"]."</p>";
            echo"<p><strong>DNI: </strong>".$_POST["dni"]."</p>";
            echo"<p><strong>Sexo: </strong>".$_POST["sexo"]."</p>";
            echo"<p><strong>Nacido en: </strong>".$_POST["nacido"]."</p>";
            echo"<p><strong>Comentarios: </strong>";
            if(isset($_POST["sb"])){
                echo"Si";
            }else{
                echo"No";
            }
            echo"</p>";
        }else
        {
            ?>
            <h1>Rellena tu CV</h1>
    <form action="index.php" method="get" enctype="multipart/form-data">
    <ul>
        <li>
            <label>Nombre</label>
            </br>
            <input type="text" name="Nombre"></input>
        </li>
        </br>
        <li>
            <label>Apellidos</label>
            </br>
            <input type="text" name="Apellidos"></input>
        </li>   
        </br>
        <li>
            <label>Contraseña</label>
            </br>
            <input type="password" name="pass"></input>
        </li>   
        </br>
        <li>
            <label>DNI</label>
            </br>
            <input type="text" name="dni"></input>
        </li>   
        </br>
        <li>
            <label>Sexo </label>
            </br>
            <p>
                Hombre<input type="radio" name="sexo" id="hombre" value="hombre"></input>
            </p>
            <p>
                Mujer<input type="radio" name="sexo" id="mujer" value="mujer"></input>
            </p>
        </li>   
        </br>
        <li>
            <label>Incluir mi foto</label>
            </br>
            <p>
                <input type="file" name="archivo"></input>
            </p>
        </li>   
        </br>
        <li>
            <label for="nacido">Nacido en:</label>
            </br>
            <p>
                <select id="nacido" name="nacido">
                    <option value="Málaga">Málaga</option>
                    <option value="Granada">Granada</option>
                    <option value="Cádiz">Cádiz</option>
                </select>
            </p>
        </li>   
        </br>
        <li>
            <label>Comentarios</label>
            <p>
                <textarea name="area" id="textarea"></textarea>
            </p>
        </li>   
        </br>
        <li>
            <input type="checkbox" name="caja"></label><label>Suscribirse al boletin de Novedades</label>
        </li>   
        </br>
        <li>
            <input type="submit" name="guardar" value="Guardar cambios"/>
            <input type="reset" name="borrar" value="Borrar contenido"/>
        </li>
    </ul>
    </form> 
        <?php>
        }

</body>
</html>