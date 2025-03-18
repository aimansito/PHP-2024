<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        $arr1 = array("Lagartija","Araña","Perro","Gato","Raton");
        $arr2 = array("12","34","45","52","12");
        $arr3 = array("Sauce","Pino","Naranjo","Chopo","Perro","34");

        $arrays = array_merge($arr1,$arr2,$arr3);

        for($i=0;$i<count($arrays);$i++){
            echo $arrays[$i];
        }
    ?>
</body>
</html>