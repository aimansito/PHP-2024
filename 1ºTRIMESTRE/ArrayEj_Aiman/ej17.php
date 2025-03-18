<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        $familias = array(
            "Los Simpsons" => array("Padre" => "Homer", "Madre" => "Marge", "Hijos" => array("H1" => "Bart", "H2" => "Lisa", "H3" => "Maggie")),
            "Los Griffin" => array("Padre" => "Peter", "Madre" => "Lois", "Hijos" => array("H1" => "Chris", "H2" => "Meg", "H3" => "Stewie"))
        );
        echo "<ul>";
        
        foreach ($familias as $indice => $familia) {
            
            echo "<li>" . $indice ;
            echo "<ul>";
            foreach ($familias[$indice] as $tipo => $nombre) {
                if(!is_array($nombre))echo "<li>" . $tipo." : ".$nombre ;
                
               else{
                    echo "<ul>";
                    foreach ($nombre as $hij => $nombres) {
                        echo "<li>".$hij. " : ". $nombres . "</li>";
                    }
                    echo "</ul></li>";
                }
            }
        
            echo "</ul></li>";
        };
        
        echo "</ul>";
        
    ?>
</body>
</html>