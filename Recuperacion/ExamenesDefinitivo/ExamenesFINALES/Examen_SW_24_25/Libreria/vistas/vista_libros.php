<?php
$url = DIR_SERV.'/obtenerLibros';
$respuesta = json_decode(consumir_servicios_REST($url, 'GET'), true);

if (!$respuesta) {
    session_destroy();
    die(error_page("Examen Librería SW 24-25", "Error. no se he podido hacer el servicio rest"));
}

if (isset($respuesta['error'])) {
    session_destroy();
    die("Error realizando el servicio. ".$respuesta['error']);
}

//Si no se cierra se han conseguido los libros
?>
<ul>
    <?php
    foreach($respuesta['libros'] as $tupla){
        echo "<li>";
        echo "<img src='images/".$tupla['portada']."' alt=''>";
        echo "<p>".$tupla['titulo']."</p>";
        echo "</li>";
    }
    ?>
</ul>