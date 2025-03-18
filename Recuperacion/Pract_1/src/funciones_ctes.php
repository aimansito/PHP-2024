<?php
    function LetraNIF($dni) 
    {  
         return substr("TRWAGMYFPDXBNJZSQVHLCKEO", $dni % 23, 1); 
    } 
    
    function dni_valido($texto)
    {
       $dni=strtoupper($texto);
       return LetraNIF(substr($dni,0,8))==substr($dni,-1);
    }
    
    function dni_bien_escrito($texto)
    {
       $dni=strtoupper($texto);
       return strlen($dni)==9 && is_numeric(substr($dni,0,8)) && substr($dni,-1)>="A" && substr($dni,-1)<="Z";
    }

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