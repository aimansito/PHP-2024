<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    $texto1= "juan";
    $texto2= "aiman";
    $a= "4";
    $b= "5";
    echo"<h1>Escribe una frase</h1>";
    echo"<p>Atiende en clase</p>";
    echo"<p>".$texto1."y".$texto2."</p>";
    echo"<p>".$num1."+".$num2." es:".($num1 + $num2)."</p>";
    if(isset(Sp) && 5==5){
        $x=$p+$a;
    }
    else{
        $c=$a;
    }
    switch($a){
        case 1: 
            break;
        case 2: 
            break;
        default:  ; 
    }
    echo "</p>".$c."</p>";

    if($a+$b>10){
        echo "<p>La suma de a + b es mayor que 10</p>";
    }else{
        echo"<p>La suma de a+b No es mayor que 10</p>";
    }
    for($i=0;$i<5;$i++){
        echo "<p>".$i."</p>";
    }
    while($i<5){
        echo "<p>".$i."</p>";
        $i++;
    }
    ?>
    <h2><?php echo $texto2; ?></h2>
</body>
</html>