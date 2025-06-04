<?php
    echo "<h2>¿Estás seguro de que quiere usted borrar el libro".$_POST['btnBorrar']."?</h2>";


    echo "
    <form action='index.php' method='post'>
        <button type='submit' name='btnConBorrar' value='".$_POST['btnBorrar']."'>Eliminar</button>
        <button type='submit'>Cancelar</button>
    </form>
    ";
?>