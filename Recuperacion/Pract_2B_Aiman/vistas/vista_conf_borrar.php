<?php
echo "<p>Se dispone usted a borrar a usuario con id: <strong>" . $_POST["btnBorrar"] . "</strong></p>";
echo "<form action='index.php' method='post'>";
echo "<p><button type='submit' name='btnContBorrar' value='" . $_POST["btnBorrar"] . "'>Continuar</button> ";
echo "<button type='submit'>Atrás</button></p>";
echo "</form>";
?>