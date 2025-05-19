<?php

require __DIR__ . '/Slim/autoload.php';

require "src/funciones_ctes.php";

$app= new \Slim\App;

//A partir de aquí se crean los métodos de la API



$app->post('/login',function($request){
    $usuario=$request->getParam("usuario");
    $clave=$request->getParam("clave");
    echo json_encode(login($usuario,$clave));

});


$app->get('/logueado',function(){
    $test=validateToken();
    if(is_array($test))
        echo json_encode($test);
    else
        echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));
});




$app->get('/repetido_insert/{tabla}/{columna}',function($request){
    $tabla=$request->getAttribute("tabla");
    $columna=$request->getAttribute("columna");
    $valor=$request->getParam("valor");
    echo json_encode(repetido_insert($tabla,$columna,$valor));

});


$app->post('/insertar_usuario',function($request){
    $datos[]=$request->getParam("usuario");
    $datos[]=$request->getParam("nombre");
    $datos[]=$request->getParam("clave");
    $datos[]=$request->getParam("dni");
    $datos[]=$request->getParam("sexo");
    $datos[]=$request->getParam("subscripcion");

    echo json_encode(insertar_usuario($datos));

});

$app->put('/actualizar_foto/{id_usuario}',function($request){
    $id_usuario=$request->getAttribute("id_usuario");
    $foto=$request->getParam("foto");
  
    echo json_encode(actualizar_foto($id_usuario,$foto));

});





$app->get('/repetido_edit/{tabla}/{columna}/{columna_clave}',function($request){

    $test=validateToken();
    if(is_array($test))
    {
        if(isset($test["usuario"]))
        {
            if($test["usuario"]["tipo"]=="admin")
            {
                $tabla=$request->getAttribute("tabla");
                $columna=$request->getAttribute("columna");
                $columna_clave=$request->getAttribute("columna_clave");
                $valor=$request->getParam("valor");
                $valor_clave=$request->getParam("valor_clave");
                echo json_encode(repetido_edit($tabla,$columna,$valor,$columna_clave,$valor_clave));
            }
            else
            {
                echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));
            }  
        }
        else
        {
            echo json_encode($test);
        }
    }    
    else
        echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));




});





$app->get('/obtener_usuarios_no_admin',function(){
  
    $test=validateToken();
    if(is_array($test))
    {
        if(isset($test["usuario"]))
        {
            if($test["usuario"]["tipo"]=="admin")
            {
                echo json_encode(obtener_usuarios_no_admin());
            }
            else
            {
                echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));
            }  
        }
        else
        {
            echo json_encode($test);
        }
    }    
    else
        echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));




});


$app->delete('/borrar_usuario/{id_usuario}',function($request){


    $test=validateToken();
    if(is_array($test))
    {
        if(isset($test["usuario"]))
        {
            if($test["usuario"]["tipo"]=="admin")
            {
                $id_usuario=$request->getAttribute("id_usuario");
                echo json_encode(borrar_usuario($id_usuario));
            }
            else
            {
                echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));
            }  
        }
        else
        {
            echo json_encode($test);
        }
    }    
    else
        echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));



});

$app->get('/detalles_usuario/{id_usuario}',function($request){

    $test=validateToken();
    if(is_array($test))
    {
        if(isset($test["usuario"]))
        {
            if($test["usuario"]["tipo"]=="admin")
            {
                $id_usuario=$request->getAttribute("id_usuario");
                echo json_encode(detalles_usuario($id_usuario));
            }
            else
            {
                echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));
            }  
        }
        else
        {
            echo json_encode($test);
        }
    }    
    else
        echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));



});


$app->put('/actualizar_usuario_con_clave/{id_usuario}',function($request){


    $test=validateToken();
    if(is_array($test))
    {
        if(isset($test["usuario"]))
        {
            if($test["usuario"]["tipo"]=="admin")
            {
                $datos[]=$request->getParam("usuario");
                $datos[]=$request->getParam("nombre");
                $datos[]=$request->getParam("clave");
                $datos[]=$request->getParam("dni");
                $datos[]=$request->getParam("sexo");
                $datos[]=$request->getParam("subscripcion");
                $datos[]=$request->getParam("foto");
                $datos[]=$request->getAttribute("id_usuario");

                echo json_encode(actualizar_usuario_con_clave($datos));
            }
            else
            {
                echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));
            }  
        }
        else
        {
            echo json_encode($test);
        }
    }    
    else
        echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));

});

$app->put('/actualizar_usuario_sin_clave/{id_usuario}',function($request){


    $test=validateToken();
    if(is_array($test))
    {
        if(isset($test["usuario"]))
        {
            if($test["usuario"]["tipo"]=="admin")
            {
                $datos[]=$request->getParam("usuario");
                $datos[]=$request->getParam("nombre");
                $datos[]=$request->getParam("dni");
                $datos[]=$request->getParam("sexo");
                $datos[]=$request->getParam("subscripcion");
                $datos[]=$request->getParam("foto");
                $datos[]=$request->getAttribute("id_usuario");
            
                echo json_encode(actualizar_usuario_sin_clave($datos));
            }
            else
            {
                echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));
            }  
        }
        else
        {
            echo json_encode($test);
        }
    }    
    else
        echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));




});



// Una vez creado servicios los pongo a disposición
$app->run();
?>