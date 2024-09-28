<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
         // Creamos un array vacío
         $numeros_pares = array();

         // Usamos un bucle para obtener los primeros 10 números pares
         for ($i = 1; $i <= 10; $i++) {
             $numeros_pares[] = $i * 2;
         }
         echo "<h3>Ejercicio 1:</h3>"."</br>";
         foreach($numeros_pares as $numero){
            
             echo $numero."</br>" ;
         }
    ?>
</body>
</html>