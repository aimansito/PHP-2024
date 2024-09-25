<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 1</title>
</head>
<body>
    <h1>Rellena tu CV</h1>
    <form action="recogida.php" method="post" enctype="multipart/form-data">
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
</body>
</html>