<h1>Estos son los datos enviados</h1>
<?php
    echo"<p><strong>Nombre enviado</strong>".$_POST["nombre"]."</p>";
    echo"<p><strong>Nacido en: </strong>".$_POST["nacido"]."</p>";
    echo"<p><strong>El sexo es: </strong>".$_POST["sexo"]."</p>";

    if(isset($_POST["aficiones"])){
        echo"<ol>Las aficiones seleccionadas han sido: </p>";
        for($i=0;$i<count($_POST["aficiones"]);$i++){
            echo "<li>".$_POST["aficiones"][$i]."</li>";
        }

        echo"</ol>";
    }else{
        echo"<p>No has seleccionado ninguna aficion</p>";
    }
    if($_POST["comentarios"]==""){
        echo "<p>No has escrito un comentario</p>";
    }else{
        echo "<p>Has escrito un comentario: ".$_POST["comentarios"]."</p>";
    }
?>