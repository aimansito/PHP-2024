<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
         echo "<h3>Ejercicio 8: </h3>";
         $nombres = array("Pedro","Ismael","Sonia","Clara","Susana","Alfonso","Teresa");
         for($i=0;$i<count($nombres);$i++){
             echo "<p>".$nombres[$i]."</p>";
         }
    ?>
</body>
</html>