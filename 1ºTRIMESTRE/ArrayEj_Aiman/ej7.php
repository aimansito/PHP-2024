<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
         echo "<h3>Ejercicio 7: </h3>";
         $ciudades['Madrid']="RMA";
         $ciudades['BARCELONA']="FCB";
         $ciudades['LONDRES']="LNDN";
         $ciudades['NEW YORK']="NY";
         $ciudades['CHICAGO']="CHG";
         $ciudades['LOS ANGELES']="LA";
         foreach ($ciudades as $ciudad2 => $abreviatura) {
             echo "La ciudad con el nombre " . $ciudad2 . " tiene la abreviatura " . $abreviatura;
             echo "</br>";
         }
    ?>
</body>
</html>