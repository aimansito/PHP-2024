<?php
    const SEGUNDOS_DIA =60*60*24;
    const dia_semana = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado");
    if(isset($_POST["btnCambiar"])&& $_POST["fecha"]!=" "){
        $fecha = $_POST["fecha"];
        
    }else{
        $fecha=date("Y-m-d");

    }
    $segundos_fecha = strtotime($fecha);
    $dia_semana = date("w",$segundos_fecha);
    $dias_pasados=$dia_semana-1;
    if($dias_pasados==-1){
        $dias_pasados = 6;
    }
    $primer_dia = $segundos_fecha-($dias_pasados*SEGUNDOS_DIA);
    $ultimo_dia = $primer_dia+(6*SEGUNDOS_DIA);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fechas</title>
    <style>
        table,th,tr{
            border:1px solid black
        }
        table{
            width:80%;margin:0 auto;
            border-collapse:collapse;
        }
        th {
            background-color: #CCC;
        }
        td{
            text-align:center;
        }
        .recreo{
            background-color: green;
        }
    </style>
</head>
<body>
    <div>
        <form id="form_fecha" action="index.php" method="post">
            <h2 class="text_centrado">Reserva de aulas</h2>
            <p class="text_centrado">
                <label for="fecha"><?php echo dia_semana[$dia_semana] ?></label>
                <input type="date" name="fecha" onchange="document.getElementById('form_fecha').submit" id="fecha" value="<?php echo $fecha;?>"/>
                <button type="submit" name="btnCambiar">Cambiar</button>
            </p>
            <p class="text_centrado">
                Semana<?php echo date("d/m/Y",$primer_dia);?> del Al <?php echo date("d/m/Y",$ultimo_dia);?>
            </p>
        </form>
    </div>
    <?php

        $horas[1]="8:15 9:15";
        $horas[2]="8:15 10:15";
        $horas[3]="8:15 11:15";
        $horas[4]="8:15 12:15";
        $horas[5]="8:15 13:15";
        $horas[6]="8:15 14:15";
        $horas[7]="8:15 15:15";

        echo "<table>";
        echo"<tr>";
        echo "<th></th>";

        for($i=1;$i<=5;$i++){
            echo"<th>".dia_semana[$i]."</th>";
        }

        echo "</tr>";

        for($j=1;$j<=7;$j++){
            echo "<tr>";

            echo "<th>".$horas[$j]."</th>";
            if($j==4){
                echo "<td class='recreo' colspan='5'>RECREO</td>";
            }else{
                for($col=1;$col<=5;$col++){
                    echo "<td></td>";
                }
            }

            echo "</tr>";
        }

        echo "</table>";
    ?>
</body>
</html>