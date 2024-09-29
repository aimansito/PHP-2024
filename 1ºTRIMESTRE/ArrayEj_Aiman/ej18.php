<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        $deportes = array("Futbol","Baloncesto","Natacion","Tenis");
        for($i=0;$i<count($deportes);$i++){
            echo "Deportes: ".$deportes[$i]."</br>";
        }
        echo "-------------------------------";
        echo "</br>";
        echo "Primer elemento: ".$deportes[0];
        echo "</br>";
        echo "Segunda posición: ".$deportes[1];
        echo "</br>";
        echo "Última posición: ".$deportes[count($deportes)-1];
        echo "</br>";
        echo "Penúltima posición: ".$deportes[count($deportes)-2];
    ?>
</body>
</html>