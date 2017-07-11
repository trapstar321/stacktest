<?php

require __DIR__.'/../bootstrap.php';
require __DIR__.'/../routes.php';

$paths_to_authenticate = array("/news/add", "/news/update", "/news/test", "/news/my");

$app->add(function($request, $response, $next) use($dm, $paths_to_authenticate){
    $authenticate = false;
    foreach($paths_to_authenticate as $path){
        if(strpos($request->getUri(), $path)!==false){
            $authenticate=true;
        }
    }
    
    if($authenticate){
        $token = $request->getHeader('Authorization');
        $userID = $request->getHeader('UserID');
        if(empty($token) || empty($userID)){
            $response = $response->withStatus(401);            
        }else{
            //compare token with token from db
            $user = $dm->getRepository('User')->find($userID[0]);
            if($user && strcmp($user->getToken(), $token[0])==0){
                $request=$request->withAttribute('user',$user);
                $response=$next($request, $response);                        
            }else{
                $response = $response->withStatus(401);            
            }            
        }        
    }else{
        $response=$next($request, $response);        
    }    

    return $response;
});
$app->run();
?>