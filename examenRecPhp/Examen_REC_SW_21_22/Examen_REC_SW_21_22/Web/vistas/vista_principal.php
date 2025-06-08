<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen5 PHP</title>
    <style>
        .enlace {
            border: none;
            background: none;
            text-decoration: underline;
            color: blue;
            cursor: pointer
        }

        .enlinea {
            display: inline
        }

        table {

            width: 90%;
            margin: 0 auto;
            border-collapse: collapse;
            text-align: center;
        }

        table,
        th,
        td {

            border: 1px solid black;
        }

        th {

            background-color: #CCC;
        }

        .centrar{

            text-align: center;
        }
    </style>
</head>

<body>
    <h1>Examen5 PHP</h1>
    <div>
        Bienvenido <strong><?php echo $_SESSION["usuario"]; ?></strong> - <form class="enlinea" method="post" action="index.php"><button class="enlace" name="btnCerrarSesion">Salir</button></form>
    </div>
    <?php
    $url = DIR_SERV . "/grupos";
    $respuesta = consumir_servicios_REST($url, "GET");
    $obj = json_decode($respuesta);

    if (!$obj) {

        session_destroy();
        die("<p>Error al consumir el servicio " . $url . "</p>" . $respuesta);
    }

    if (isset($obj->error)) {

        session_destroy();
        die("<p>" . $obj->error . "</p></body></html>");
    }
    ?>

    <h1>Horario de los Grupos</h1>
    Elija el grupo
    <form action="index.php" method="post">
        <select name="grupos">

            <?php
            foreach ($obj->grupos as $datos) {

                if (isset($_POST["grupos"]) && $_POST["grupos"] == $datos->id_grupo . "-" . $datos->nombre) {

                    echo "<option selected value='" . $datos->id_grupo . "-" . $datos->nombre . "' >$datos->nombre</option>";
                } else {

                    echo "<option value='" . $datos->id_grupo . "-" . $datos->nombre . "' >$datos->nombre</option>";
                }
            }
            ?>
        </select>
        <button name="btnHorario">Ver Horario</button>
    </form>

    <?php
    if (isset($_POST["btnHorario"]) || isset($_POST["btnEditar"])) {


        if (isset($_POST["btnHorario"])) {

            $datos_select = explode("-", $_POST["grupos"]);
            $id_grupo = $datos_select[0];
            $nombre = $datos_select[1];
        }else{

            $id_grupo = $_POST["id_grupo"];
            $nombre = $_POST["nombre"];
        }

        $url = DIR_SERV . "/horario/" . urlencode($id_grupo);
        $respuesta = consumir_servicios_REST($url, "GET");
        $obj = json_decode($respuesta);

        if (!$obj) {

            session_destroy();
            die("<p>Error al consumir el servicio " . $url . "</p>" . $respuesta);
        }

        if (isset($obj->error)) {

            session_destroy();
            die("<p>" . $obj->error . "</p></body></html>");
        }

        if (isset($obj->horario)) {

            foreach ($obj->horario as $datos) {

                if (isset($horarios[$datos->dia][$datos->hora])) {

                    $horarios[$datos->dia][$datos->hora] .= "</br>" . $datos->usuario . "(" . $datos->nombre . ")";
                } else {

                    $horarios[$datos->dia][$datos->hora] = $datos->usuario . "(" . $datos->nombre . ")";
                }
            }
        }

        echo "<h2 class='centrar'>Horario del Grupo: " . $nombre . "</h2>";

        $horas[1] = "8:15-9:15";
        $horas[2] = "9:15-10:15";
        $horas[3] = "10:15-11:15";
        $horas[4] = "11:15-11:45";
        $horas[5] = "11:45-12:45";
        $horas[6] = "12:45-13:45";
        $horas[7] = "13:45-14:45";

        echo "<table>";
        echo "<tr><th></th><th>Lunes</th><th>Martes</th><th>Miercoles</th><th>Jueves</th><th>Viernes</th></tr>";

        for ($i = 1; $i <= 7; $i++) {

            echo "<tr>";

            if ($i == 4) {

                echo "<td>" . $horas[$i] . "</td><td colspan='5' >RECREO</td>";
            } else {

                if ($i < 4) {

                    echo "<td>" . $horas[$i] . "</td>";
                } else {

                    echo "<td>" . $horas[$i] . "</td>";
                }

                for ($j = 1; $j <= 5; $j++) {

                    echo "<td>";
                    echo "<form action='index.php' method='post'>";
                    if (isset($horarios[$j][$i])) {

                        echo $horarios[$j][$i];
                        echo "<input type='hidden' name='datos_grupo' value='" . $horarios[$j][$i] . "' />";
                    }
                    echo "<input type='hidden' name='dia' value='" . $j . "' />
                    <input type='hidden' name='hora' value='" . $i . "' />
                    <input type='hidden' name='id_grupo' value='" . $id_grupo . "' />
                    <input type='hidden' name='nombre' value='" . $nombre . "' />
                    <br/><button class='enlace' name='btnEditar' >Editar</button>
                    </form>";
                }
                echo "</td>";
            }
        }

        echo "</tr>";

        echo "</table>";

        if (isset($_POST["btnEditar"])) {

            $semana = ["", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes"];
            $hora_mostrar = $_POST["hora"];

            if($_POST["hora"] < 4){

                echo "<h2 class='centrar'>Editando la " . $_POST["hora"] . "ª Hora (" . $horas[$_POST["hora"]] . ") del " . $semana[$_POST["dia"]] . "</h2>";
            }else{

                echo "<h2 class='centrar'>Editando la " . ($hora_mostrar - 1) . "ª Hora (" . $horas[$_POST["hora"]] . ") del " . $semana[$_POST["dia"]] . "</h2>";
            }

            $profesores_aula = explode("</br>", $_POST["datos_grupo"]);

            //echo var_dump($profesores_aula);

            echo "<table>";
            echo "<tr><th>Profesor(Aula)</th><th>Accion</th></tr>";

            for($i = 0; $i < count($profesores_aula); $i++){

                $datos_prof = explode("(", $profesores_aula[$i]);
                $datos_prof_prof = $datos_prof[0];
                $datos_prof_aula = substr($datos_prof[1], 0, -1);
                //echo var_dump($datos_prof_aula);

                echo "<tr>";
                echo "<td>".$profesores_aula[$i]."</td>";
                echo "<td>
                <form action='index.php' method='post'>
                <input type='hidden' name='dia' value='".$_POST["dia"]."'/>
                <input type='hidden' name='hora' value='".$_POST["hora"]."'/>
                <input type='hidden' name='usuario_prof' value='".$datos_prof_prof."'/>
                <input type='hidden' name='nombre_aula' value='".$datos_prof_aula."'/>
                <button class='enlace' name='btnQuitar' >Quitar</button>
                </form>
                </td>";
                echo "</tr>";
            }

            echo "</table>";

            $url_prof_libres = DIR_SERV."/profesoresLibres/".urlencode($_POST["dia"])."/".urldecode($_POST["hora"])."/".urldecode($_POST["id_grupo"]);
            $respuesta_prof_libres = consumir_servicios_REST($url_prof_libres, "GET");
            $obj_prof = json_decode($respuesta_prof_libres);

            if (!$obj_prof) {

                session_destroy();
                die("<p>Error al consumir el servicio " . $url_prof_libres . "</p>" . $respuesta_prof_libres);
            }
    
            if (isset($obj_prof->error)) {
    
                session_destroy();
                die("<p>" . $obj_prof->error . "</p></body></html>");
            }

            $url_aulas = DIR_SERV."/aulas";
            $respuesta_aulas = consumir_servicios_REST($url_aulas, "GET");
            $obj_aulas = json_decode($respuesta_aulas);

            if (!$obj_aulas) {

                session_destroy();
                die("<p>Error al consumir el servicio " . $url_aulas . "</p>" . $respuesta_aulas);
            }
    
            if (isset($obj_aulas->error)) {
    
                session_destroy();
                die("<p>" . $obj_aulas->error . "</p></body></html>");
            }


            echo "<div class='centrar'>";
            echo "<form action='index.php' method='post'>";
            echo "Elija Profesor: ";
            echo "<select name='select_profesores' />";
            foreach($obj_prof->profesores_libres as $datos){

                echo "<option value='".$datos->id_usuario."-".$datos->nombre."' >$datos->nombre</option>";
            }
            echo "</select>";
            echo "Elija Aula: ";
            echo "<select name='select_aulas' />";
            foreach($obj_aulas->aulas as $datos){

                echo "<option value='".$datos->id_aula."-".$datos->nombre."' >$datos->nombre</option>";
            }
            echo "</select>";
            echo "<input type='hidden' name='dia' value='".$_POST["dia"]."'/>";
            echo "<input type='hidden' name='hora' value='".$_POST["hora"]."'/>";
            echo "<input type='hidden' name='id_usuario' value=''/>";
            echo "<input type='hidden' name='id_aula' value=''/>";
            echo "<button name='btnAniadir'>Añadir</button>";
            echo "</form>";
            echo "</div>";
        }
    }


    ?>
</body>

</html>