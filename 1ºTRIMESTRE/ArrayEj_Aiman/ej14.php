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
        $equipos=array("Barcelona"=>"Camp Nou","Real Madrid"=>"Santiago Bernabeu","Valencia"=>"Mestalla","Real Sociedad"=>"Anoeta");
        echo "<table>";
        echo "<tr><th>Estadios</th></tr>";
        foreach ($equipos as $eq => $nombre) {
            echo "<tr>";
            echo "<td>". $eq."</td>";
            echo "<td>". $nombre."</td>";
            echo "</tr>";
        }
        echo "</table>";
        unset($equipos["Real Madrid"]);
        echo "<ol>";
        foreach ($equipos as $eq => $nombre) {
            echo "<li>Equipo: ".$eq.", Estadio: ".$nombre."</li>";
        }
        echo "</ol>";
    ?>
</body>
</html>