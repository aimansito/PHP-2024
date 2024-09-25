<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        $notas["Dani"]["DWESE"]=7;
        $notas["Dani"]["FOL"]=3;
        $notas["Tomas"]["DWESE"]=7;
        $notas["Tomas"]["FOL"]=3;
        $notas["Clara"]["DWESE"]=7;
        $notas["Clara"]["FOL"]=3;

        echo "<h1>Notas de los alumnos de 2DAW</h1>";
        foreach($notas as $key=>$valor){
        

            echo "<li>".$key;
            
            echo "<ul>";

                foreach($valor as $val=>$notas){
                    echo "<li>".$val.": ".$notas."</li>";
                }

            echo "</ul>";
            echo "</li>";

        }
    ?>
</body>
</html>