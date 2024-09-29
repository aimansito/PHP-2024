<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        echo "<h3>Ejercicio 3: </h3>";
        $numeros = ["5"=>"1","12"=>"2","13"=>"56","x"=>"42"];
        echo "Número de elementos: ".count($numeros);
        echo "</br>";
        unset($numeros["5"]);
        print_r($numeros);
        unset($numeros);
        //print_r($numeros);
    ?>
</body>
</html>