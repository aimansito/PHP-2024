<?php
      function tiene_extension($texto){
        $array_nombre = explode(".",$texto);
        if(count($array_nombre)<=1){
            $respuesta=false;
        }else{
            $respuesta=end($array_nombre);
        }
        return $respuesta;
    }
?>