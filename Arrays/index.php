<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Apuntes Arrays</h1>
    <?php
        $nota[0]=5;
        $nota[1]=5;
        $nota[2]=5;
        $nota[3]=5;
        $nota["Juan"]=5;
        $nota[5]=5;
        var_dump($nota);
        echo "</br>";
        print_r($nota);

        $nota1 = array (0=>5,1=>9,8=>,13=>5,"Juan"=>6,2501=>7);
        echo "<p>el numero de elementos que tiene el array nota es: ".count($nota1)."</p>";
        echo "<h2>Elementos del array nota</h2>";
        echo "<ul>";
        /*
        for($i=0;$i<count($nota);$i++){
            echo"<li>".$nota[$i]."</li>";
        }
        */
        foreach($nota as $key=>$valor){
           echo "<li>Clave: ".$key."Valor: ".$valor."</li>";
        }
        echo "</ul>";       // $nota1=array[5,9,8,5,7];
    ?>
</body>
</html>