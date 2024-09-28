<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        echo "<h3>Ejercicio 10: </h3>";
        $numeros = array(1,2,3,4,5,6,7,8,9,10);
        $pares = 0;
        $contador = 0;
        for($i=0;$i<count($numeros);$i++){
            if($numeros[$i]%2==0){
                $pares += $numeros[$i];
                $contador++;
            }else{
                echo "Estos son los números impares: ".$numeros[$i];
                echo "</br>";
            }
        }
        echo "Esta es la media de los números pares: ".$pares/$contador;
    ?>
</body>
</html>