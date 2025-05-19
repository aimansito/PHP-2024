<?php
echo "<h3>Borrando la foto del usuario: ".$_POST["btnBorrarFoto"]."</h3>";
echo "<form action='index.php' method='post'>";
echo "<p><img src='images/".$_POST["foto_bd"]."' alt='Foto' title='Foto'></p>";
echo "<input type='hidden' name='foto_bd' value='".$_POST["foto_bd"]."'>";
echo "<p><button name='btnContBorrarFoto' value='".$_POST["btnBorrarFoto"]."'>Continuar</button> <button>Atrás</button>";
echo "</form>";
?>