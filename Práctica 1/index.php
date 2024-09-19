<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 1</title>
</head>
<body>
    <h1>Rellena tu CV</h1>
    <form action="recogidaDatos.php" method="get" enctype="multipart/form-data">
    <ul>
        <li>
            <label>Nombre</label>
            </br>
            <input type="text" name="name"></input>
        </li>
        </br>
        <li>
            <label>Apellidos</label>
            </br>
            <input type="text" name="surname"></input>
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
                Hombre<input type="radio" name="sexo"></input>
            </p>
            <p>
                Mujer<input type="radio" name="sexo"></input>
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
            <label>Nacido en:</label>
            </br>
            <p>
                <select name="select">
                    <option value="1">Málaga</option>
                    <option value="2">Granada</option>
                    <option value="3">Cádiz</option>
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
    </ul>
    </form>
</body>
</html>