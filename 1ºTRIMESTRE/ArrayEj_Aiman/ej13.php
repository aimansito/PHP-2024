<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
        echo "<h3>Ejercicio 12</h3>";
        $arr1 = array("Lagartija","Araña","Perro","Gato","Raton");
        $arr2 = array("12","34","45","52","12");
        $arr3 = array("Sauce","Pino","Naranjo","Chopo","Perro","34");

        $arrays = array();

        array_push($arrays,$arr1,$arr2,$arr3);

        foreach(array_reverse($arrays) as $arr){
           foreach(array_reverse($arr) as $valores){
                echo "<p>".$valores."</p>";
           }
        }
    ?>
</body>
</html>