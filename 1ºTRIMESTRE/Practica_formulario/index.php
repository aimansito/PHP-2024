<?php
function arrayNom($elemento, $array){
    $esta=false;
    for($i=0M$i<count($array);$i++){
        if($array[$i]==$elemento){
            $esta=true;
            break;
        }
    }
    return $esta;
}



    if(isset($_POST("enviar"))){
        $error_nombre = $_POST["nombre"]=="";
        $error_sexo=!isset($_POST["sexo"]);
        $error_form=$error_nombre || $error_sexo;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi primera pagina</title>
</head>
<body>

    <?php
        if(($_POST["enviar"])&& !$error_form)    {
            require "./vistaRecogida.php";
        }else{
            require "./vistaFormulario.php";
        }
    ?>
</body>
</html>