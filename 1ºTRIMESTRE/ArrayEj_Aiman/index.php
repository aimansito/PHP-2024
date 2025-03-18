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

    // ej 1
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
        echo "--------------";
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
        // ej3
        $mes['Enero']=9;
        $mes['Febrero']=12;
        $mes['Marzo']=0;
        $mes['Abril']=17;
        echo "</br>";
        echo "<h3>Ejercicio 3</h3>";
        foreach($mes as $clave => $valor){
            if($valor>0){
                echo "el mes ".$clave." ha tenido ".$valor." visualizaciones"."</br>";
            }
        }
        echo "--------------"."</br>";
        
        //ej4
        echo "<h3>Ejercicio 4: </h3> ";
        $arr4[]="Pedro";
        $arr4[]="Ana";
        $arr4[]=1;

        print_r($arr4);
        echo "--------------"."</br>";
        //ej5
        echo "<h3>Ejercicio 5: </h3>";
        $persona['Nombre']="Pedro Torres";
        $persona['Direccion']="C/Mayor, 37";
        $persona['Telefono']="12345";
        echo "</br>";
        foreach($persona as $clave => $valor){
            echo "la clave es $clave y el valor es $valor</br>";
        }
        //ej6
        echo "<h3>Ejercicio 6: </h3>";
        $ciudad[]="Madrid";
        $ciudad[]="Barcelona";
        $ciudad[]="Londres";
        $ciudad[]="New York";
        $ciudad[]="Chicago";
        $ciudad[]="Los Angeles";
        for($i=0;$i<count($ciudad);$i++){
            echo "La ciudad con el indice ".$i." tiene el nombre ".$ciudad[$i];
            echo "</br>";
        }
        echo "<h3>Ejercicio 7: </h3>";
        $ciudades['Madrid']="RMA";
        $ciudades['BARCELONA']="FCB";
        $ciudades['LONDRES']="LNDN";
        $ciudades['NEW YORK']="NY";
        $ciudades['CHICAGO']="CHG";
        $ciudades['LOS ANGELES']="LA";
        foreach ($ciudades as $ciudad2 => $abreviatura) {
            echo "La ciudad con el nombre " . $ciudad2 . " tiene la abreviatura " . $abreviatura;
            echo "</br>";
        }
        echo "<h3>Ejercicio 8: </h3>";
        $nombres = array("Pedro","Ismael","Sonia","Clara","Susana","Alfonso","Teresa");
        for($i=0;$i<count($nombres);$i++){
            echo "<p>".$nombres[$i]."</p>";
        }
        echo "<h3>Ejercicio 9: </h3>";
        $lenguajes_cliente=array("lp1"=>"CSS","lp2"=>"JavaScript","lp3"=>"React","lp4"=>"Vue","lp5"=>"Angular");
        $lenguajes_servidor=array("ls1"=>"Php","ls2"=>"Python","ls3"=>"Nodejs","ls4"=>"Ruby","ls5"=>"Java");

        $lenguajes=array_merge($lenguajes_cliente,$lenguajes_servidor);

        echo "<table>";
        echo "<tr><th>Lenguajes</th></tr>";
        foreach ($lenguajes as $nivel => $tipo) {
            echo "<tr>";
            echo "<td>". $nivel."</td>";
            echo "<td>". $tipo."</td>";
            echo "</tr>";
        }
            
        
           
        echo "</table>";
        echo "<h3>Ejercicio 10: </h3>";
        $numeros = array(1,2,3,4,5,6,7,8,9,10);
        $pares = 0;
        $contador = 0;
        for($i=0;$i<count($numeros);$i++){
            if($numeros[$i]%2==0){
                $pares += $numeros[$i];
                $contador++;
            }else{
                echo "Estos son los números impares: ".$numeros[$i];
                echo "</br>";
            }
        }
        echo "Esta es la media de los números pares: ".$pares/$contador;
    ?>
</body>
</html>