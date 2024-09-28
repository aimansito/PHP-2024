<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
         // ej2
         $v[1]=90;
         $v[30]=7;
         $v['e']=99;
         $v['hola']=43;
         echo "</br>";
         foreach($v as $clave => $valor){
             echo "la clave es $clave y el valor es $valor</br>";
         }
         echo "--------------";
    ?>
</body>
</html>