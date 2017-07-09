<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->post('/auth/login', function(Request $request, Response $response) use($dm, $app){
    $username = $request->getParam('username');
    $password = $request->getParam('password');

    $user = $dm->createQueryBuilder('User')
                ->field('username')->equals($username)
                ->field('password')->equals($password)
                ->getQuery()
                ->getSingleResult();
    
    if($user){
        //generate token and update user in db
        $token=bin2hex(openssl_random_pseudo_bytes(8));
        $data = array("token"=>$token, "user_id"=>$user->getID());
        $user->setToken($token);
        $dm->persist($user);
        $dm->flush();
        
        return $response->withJson($data);
    }else{
        $response = $response->withStatus(401);
        return $response->write('Invalid username or password');
    }

    return $response->write($user->getUsername());
});

$app->post('/auth/logout', function(Request $request, Response $response) use($dm){
    $token = $request->getHeader('Authorization');
    $userID = $request->getHeader('UserID');

    if(empty($token) || empty($userID)){
        $response = $response->withStatus(401);      
    }else{        
        $user = $dm->getRepository('User')->find($userID[0]);
        if($user && strcmp($user->getToken(), $token[0])==0){
            $user->setToken(null);
            $dm->persist($user);
            $dm->flush();
        }else{
            $response = $response->withStatus(401);            
        }
    }
    return $response;
});

$app->get('/news/today', function(Request $request, Response $response) use($dm){
    $check = new DateTime();
    $check->setTime(0,0,0);
    $query = $dm->createQueryBuilder('News')
                ->field('post_date')->gte($check)
                ->getQuery();
                
    $cursor = $query->execute();
    $temp=[];
    foreach($cursor as $news){        
        $temp[]=$news->toArray();
    }
    return $response->withJson($temp);    
});

$app->get('/news/{id}', function(Request $request, Response $response) use($dm){
    $id = $request->getAttribute("id");    
    $news = $dm->getRepository('News')->find($id); 
    if(!$news)
        return $response->withStatus(404);
    else      
        return $response->withJson($news->toArray(false));    
});

$app->post('/news/test', function(Request $request, Response $response) use($dm, $app){
    return $response->write($request->getAttribute('user')->getUsername());
});

$app->post('/news/add', function(Request $request, Response $response) use($dm){      
    $user = $request->getAttribute('user');
    $title = $request->getParam('title');
    $short_desc = $request->getParam('short_desc');
    $text = $request->getParam('text');

    $storage = new \Upload\Storage\FileSystem(__DIR__."\imgs");
    $file = new \Upload\File('img', $storage);
    
    //rename filed
    $new_filename = uniqid();
    $file->setName($new_filename);    

    //mime type and filesize validation
    $file->addValidations(array(        
        new \Upload\Validation\Mimetype(array('image/png', 'image/jpg')),                
        new \Upload\Validation\Size('5M')
    ));
    
    //file data
    $data = array(
        'name'       => $file->getNameWithExtension(),
        'extension'  => $file->getExtension(),
        'mime'       => $file->getMimetype(),
        'size'       => $file->getSize()
    );    

    // Try to upload file
    try {
        // Success!
        $file->upload();

        $news = new News();
        $news->setTitle($title);
        $news->setShortDesc($short_desc);
        $news->setText($text);
        $news->setImgPath("imgs/".$file->getNameWithExtension());
        $news->setAuthor($user);
        $news->setPostDate(new DateTime());

        $dm->persist($news);
        $dm->flush();

        return $response->write("OK");    
    } catch (\Exception $e) {
        // Fail!
        $errors = $file->getErrors();           
        $response=$response->withStatus(400);    
        return $response->write($errors[0]);    
    }    
});

$app->post('/news/update/{id}', function(Request $request, Response $response) use($dm){   
    $id = $request->getAttribute("id");    
    
    $title = $request->getParam('title');
    $short_desc = $request->getParam('short_desc');
    $text = $request->getParam('text');

    $storage = new \Upload\Storage\FileSystem(__DIR__."\imgs");
    $file = new \Upload\File('img', $storage);
    
    //rename filed
    $new_filename = uniqid();
    $file->setName($new_filename);    

    //mime type and filesize validation
    $file->addValidations(array(        
        new \Upload\Validation\Mimetype(array('image/png', 'image/jpg')),                
        new \Upload\Validation\Size('5M')
    ));
    
    //file data
    $data = array(
        'name'       => $file->getNameWithExtension(),
        'extension'  => $file->getExtension(),
        'mime'       => $file->getMimetype(),
        'size'       => $file->getSize()
    );    

    //return $response->write($id);

    // Try to upload file
    try {
        // Success!
        $file->upload();

        $news = $dm->getRepository('News')->find($id);         
        if($news){
            $news->setTitle($title);
            $news->setShortDesc($short_desc);
            $news->setImgPath("imgs/".$file->getNameWithExtension());
            $news->setText($text);

            $dm->persist($news);
            $dm->flush();

            return $response->write("OK");    
        }else{
            return $response->withStatus(404);
        }        
    } catch (\Exception $e) {
        // Fail!
        $errors = $file->getErrors();           
        $response=$response->withStatus(400);    
        return $response->write($errors[0]);    
    }    
});
?>