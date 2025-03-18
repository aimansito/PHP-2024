<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        //ej5
        echo "<h3>Ejercicio 5: </h3>";
        $persona['Nombre']="Pedro Torres";
        $persona['Direccion']="C/Mayor, 37";
        $persona['Telefono']="12345";
        echo "</br>";
        foreach($persona as $clave => $valor){
            echo "la clave es $clave y el valor es $valor</br>";
        }
    ?>
</body>
</html>