<?php
require("bootstrap.php");

use DateTime;

$user = new User();
$user->setUsername("tjadrejcic2");
$user->setFirstname("Tomica");
$user->setLastname("Jadrejčič");
$user->setEmail("jadrejcictomica@live.com");
$user->setPassword("VREjNvL");


$news = new News();
$news->setTitle("Test news2");
$news->setShortDesc("Short desc");
$news->setText("Here is some text");
$news->setImgPath("C:\\test\img.png");
$news->setAuthor($user);
$news->setPostDate(new DateTime());

$user->addNews($news);

try{
    $dm->persist($user);
    $dm->persist($news);
    $dm->flush();
}catch(exception $ex){
    echo("Caught exception ".$ex->getMessage());
}
?>