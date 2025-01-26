<?php
    function consumir_servicios_REST($url,$metodo,$datos=null){
        $llamada = curl_init();
        curl_setopt($llamada,CURLOPT_URL,$url);
        curl_setopt($llamada,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($llamada, CURLOPT_CUSTOMREQUEST, $metodo);
        if(isset($datos))
            curl_setopt($llamada,CURLOPT_POSTFIELDS, http_build_query($datos));
        $respuesta = curl_exec($llamada);
        curl_close($llamada);
        return $respuesta;
    }   
    DEFINE('DIR_SERV', 'http://localhost/PHP/servicios_rest/actividad2')
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD con servicios web</title>
</head>
<body>
    <h1>Listado de productos de mi tienda</h1>
    <?php
        $url = DIR_SERV . "/productos";
        $respuesta = consumir_servicios_REST($url, "GET");
        $obj = json_decode($respuesta);
        if(!$obj){
            die("<p>Error consumiento servicio: ".$url."</p>". $respuesta);
        }
        if(isset($obj->error)){
            die("<p>".$obj->error."</p>");            
        }else{
            ?>
             <table>
                <tr>
                    <th>Código</th>
                    <th>Nombre corto</th>
                    <th>PVP</th>
                </tr>
                <?php
                foreach($obj->productos as $fila){
                    echo "<tr><td>".$fila->cod."</td><td>".$fila->$nombre_corto."</td><td>".$fila->PVP."</td></tr>";
                }
        }
    ?>
        
    </table>
</body>
</html>