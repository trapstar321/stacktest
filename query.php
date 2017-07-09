<?php

require("bootstrap.php");

$user = $dm->getRepository('User')->findOneBy(array('username' => 'tjadrejcic'));
echo("User: ".$user->getFirstname()."<br/>");

$news = $dm->getRepository('News')->findOneBy(array('author'=>$user));
echo("News title: ".$news->getTitle());
?>