<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
         // ej3
         $mes['Enero']=9;
         $mes['Febrero']=12;
         $mes['Marzo']=0;
         $mes['Abril']=17;
         echo "</br>";
         echo "<h3>Ejercicio 3</h3>";
         foreach($mes as $clave => $valor){
             if($valor>0){
                 echo "el mes ".$clave." ha tenido ".$valor." visualizaciones"."</br>";
             }
         }
         echo "--------------"."</br>";
    ?>
</body>
</html>