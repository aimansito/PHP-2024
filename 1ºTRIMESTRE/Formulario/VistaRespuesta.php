<?php

echo "<p>Respuestas:</p>";
echo "<p>El nombre enviado ha sido: ".$_POST["name"]."</p>";
echo "<p>Ha nacido en: ".$_POST["nacido"]."</p>";
echo "<p>El sexo es: ".$_POST["sexo"]."</p>";



if(!isset($_POST["deporte"]) && !isset($_POST["lectura"]) && !isset($_POST["otro"])){

    echo"<p>No has seleccionado ninguna afición.</p>";

}else{

    echo"<p>Las aficiones que has seleccionado han sido:</p>";



    $aficion[0]="deporte";
    $aficion[1]="lectura";
    $aficion[2]="otro";


    $nombreAficiones[0]="Deporte";
    $nombreAficiones[1]="Lectura";
    $nombreAficiones[2]="Otro";


    echo"<ol>";
    for($i=0;$i<count($aficion);$i++){

        if(isset($_POST[$aficion[$i]])){

            echo"<li>$nombreAficiones[$i]</li></br>";
            

        }
        
       }
       echo"</ol>" ; 
       
       

/*
if(isset($_POST["deporte"])){

    echo"<p>Deporte:Si</p>";

}else{

    echo"<p>Deporte:No</p>";
}

if(isset($_POST["lectura"])){

    echo"<p>Lectura:Si</p>";

}else{

    echo"<p>Lectura:No</p>";
}

if(isset($_POST["otro"])){

    echo"<p>Otro:Si</p>";

}else{

    echo"<p>Otro:No</p>";
}
*/


}

if(($_POST["message"])!=""){

    echo "El comentario enviado ha sido:".$_POST["message"]."</p>";

}else{

    echo"<p>No has hecho ningun comentario</p>";
}





?>