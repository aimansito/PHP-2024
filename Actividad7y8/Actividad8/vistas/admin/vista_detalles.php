<?php
echo "<h2>Detalles del usuario " . $_POST["btnDetalles"] . "</h2>";
if (isset($json_detalles["usuario"])) {
    echo "<p>";
    echo "<strong>Nombre: </strong>" . $json_detalles["usuario"]["nombre"] . "<br/>";
    echo "<strong>Usuario: </strong>" . $json_detalles["usuario"]["usuario"] . "<br/>";
    echo "<strong>Clave: </strong><br/>";
    echo "<strong>Email: </strong>" . $json_detalles["usuario"]["email"] . "<br/>";
    echo "</p>";
} else {
    echo "<p>El usuario ya no se encuentra registrado en la BD</p>";
}
?>