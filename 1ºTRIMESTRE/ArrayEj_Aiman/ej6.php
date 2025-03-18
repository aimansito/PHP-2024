<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        //ej6
        echo "<h3>Ejercicio 6: </h3>";
        $ciudad[]="Madrid";
        $ciudad[]="Barcelona";
        $ciudad[]="Londres";
        $ciudad[]="New York";
        $ciudad[]="Chicago";
        $ciudad[]="Los Angeles";
        for($i=0;$i<count($ciudad);$i++){
            echo "La ciudad con el indice ".$i." tiene el nombre ".$ciudad[$i];
            echo "</br>";
        }
    ?>
</body>
</html>