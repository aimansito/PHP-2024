<?php
    require __DIR__ . '/Slim/autoload.php';
    require "src/funciones_CTES.php.";

    $app = new \Slim\App;

    $app->post('/login', function($request){
        $datos_login[]=$request->getParam("usuario");
        $datos_login[]=$request->getParam("clave");

        echo json_encode(login($datos_login));
    });

    $app->get('/logueado',function(){
        $test = validateToken();
        if(is_array($test)){
            echo json_encode(logueado($test["usuario"],$test["clave"]));
        }else{
            echo json_encode(["no-auth"=>"No tienes permiso para usar el servicio"]);
        }
    });

    $app->get('/profesor/{id_usuario}',function($request){
        $test = validateToken();
        if(is_array($test)){
            if(isset($test["usuario"])){
                echo json_encode(horariosProfesor($request->getAttribute("id_usuario")));   
            }else{
                echo json_encode($test);
            }
        }else{
            echo json_encode(["no-auth" => "No tienes permiso para usar el servicio"]);
        }
    });

    $app->get('/todosGrupos',function(){
        $test = validateToken();
        if(is_array($test)&& isset($test["tipo"]) && $test["tipo"] == 'admin'){
            echo json_encode(todosGrupos());
        }else{
            echo json_encode(["no-auth"=>"No tienes permiso para usar el servicio"]);
        }
    });

    $app->get('/horariosGrupo/{id_grupo}', function($request){
        $test = validateToken();
        if(is_array($test) && isset($test["tipo"]) && $test["tipo"]=="admin"){
            echo json_encode(horarioGrupo($request->getAttribute("id_grupo")));
        }else{
            echo json_encode(["no-auth" => "No tienes permiso para usar el servicio"]);
        }
    });

    $app->get('/profesoresLibres/{dia}/{hora}/{id_grupo}',function($request){
        $test = validateToken();
        if(is_array($test) && isset($test["tipo"]) && $test["tipo"] == "admin"){
            echo json_encode(profesoresLibres(
                $request->getAttribute("dia"),
                $request->getAttribute("hora"),
                $request->getAttribute("id_grupo")
            ));
        }else{
            echo json_encode(["no-auth" => "No tienes permiso para usar el servicio"]);
        }
    });

    $app->get('/profesoresOcupados/{dia}/{hora}/{id_grupo}', function($request){
        $test = validateToken();
        if(is_array($test) && isset($test["tipo"]) && $test["tipo"] == "admin"){
            echo json_encode(profesoresOcupados(
                $request->getAttribute("dia"),
                $request->getAttribute("hora"),
                $request->getAttribute("id_grupo")
            ));
        }
    });

    $app->delete('/borrarProfesor/{dia}/{hora}/{id_grupo}/{id_usuario}',function($request){
        $test = validateToken();
        if(is_array($test)&&isset($test["tipo"]) && $test["tipo"]=="admin"){
            echo json_encode(borrarProfesor(
                $request->getAttribute("dia"),
                $request->getAttribute("hora"),
                $request->getAttribute("id_grupo"),
                $request->getAttribute("id_usuario")
            ));
        }else{
            echo json_encode(["no-auth"=>"No tienes permiso para usar el servicio"]);
        }
    });

    $app->run();
?>