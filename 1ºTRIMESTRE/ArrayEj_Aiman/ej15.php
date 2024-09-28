<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>

    table, td, tr, th{ 
    border:1px solid black;
    }
    </style>
</head>
<body>
    <?php
        $numeros= array("Nº1"=>"3","Nº2"=>"2","Nº3"=>"8","Nº4"=>"123","Nº5"=>"5","Nº6"=>"1");
        asort($numeros);

        echo "<table>";
        echo "<tr><th>Numeros</th></tr>";
        foreach ($numeros as $n => $num) {
            echo "<tr>";
            echo "<td>". $n."</td>";
            echo "<td>". $num."</td>";
            echo "</tr>";
        }
        echo "</table>";

    ?>
</body>
</html>