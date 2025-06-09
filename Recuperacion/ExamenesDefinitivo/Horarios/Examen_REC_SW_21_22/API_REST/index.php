<?php

require __DIR__ . '/Slim/autoload.php';

require "src/funciones_CTES.php";

$app= new \Slim\App;

$app->get('/logueado',function(){

    $test=validateToken();
    if(is_array($test))
    {
        echo json_encode($test);
    }
    else
        echo json_encode(array("no_auth"=>"No tienes permiso para usar el servicio"));  
});


$app->post('/login',function($request){
    
    $datos_login[]=$request->getParam("usuario");
    $datos_login[]=$request->getParam("clave");


    echo json_encode(login($datos_login));
});


$app->get('/obtenerAulas',function(){
     $test = validateToken();

    if (is_array($test)) {
        if (isset($test["usuario"])) {
            if ($test["usuario"]["tipo"] == "admin") {
                echo json_encode(obtener_aulas());
            } else {
                echo json_encode(array("no-auth" => "No tienes permiso para usar este servicio"));
            }
        } else {
            echo json_encode($test); 
        }
    } else {
        echo json_encode(array("no-auth" => "No tienes permiso para usar este servicio"));
    }
});

$app->get('/obtenerGrupos', function() {
    $test = validateToken();

    if (is_array($test)) {
        if (isset($test["usuario"])) {
            if ($test["usuario"]["tipo"] == "admin") {
                echo json_encode(obtener_grupos());
            } else {
                echo json_encode(array("no-auth" => "No tienes permiso para usar este servicio"));
            }
        } else {
            echo json_encode($test); 
        }
    } else {
        echo json_encode(array("no-auth" => "No tienes permiso para usar este servicio"));
    }
});


$app->get('/obtenerHorario/{id_grupo}', function($request){

    $test = validateToken();
    if (is_array($test)) {
        if (isset($test["usuario"])) {
            if ($test["usuario"]["tipo"] == "admin") {

                // Obtener el id_grupo desde la ruta
                $id_grupo = $request->getAttribute("id_grupo");
                $datos = ["id_grupo" => $id_grupo];

                echo json_encode(obtener_horario_grupo($datos));

            } else {
                echo json_encode(["no-auth" => "No tienes permiso para usar este servicio"]);
            }
        } else {
            echo json_encode($test); // Error de token (caducado o inválido)
        }
    } else {
        echo json_encode(["no-auth" => "No tienes permiso para usar este servicio"]);
    }

});

$app->get('/profesoresLibres/{dia}/{hora}/{grupo}', function($request){

    $test=validateToken();
    if(is_array($test)){
        if(isset($test["usuario"])){
            if($test["usuario"]["tipo"]=="admin"){
                $datos[]=$request->getAttribute("id_grupo");
                $datos[]=$request->getAttribute("dia");
                $datos[]=$request->getAttribute("hora");

                echo json_encode(obtener_profesores_libres($datos));
            }else{
                echo json_encode(array("no-auth"=>"No tienes permiso para usar este servicio"));
            }
        }else{
            echo json_encode($test);
        }
    }else{
        echo json_encode(array("no-auth"=>"No tienes permiso para usar este servicio"));
    }

});

$app->run();

?>