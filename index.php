<?php
require 'vendor/autoload.php';

$app = new \Slim\Slim();

$app->get("/", function(){
	echo "hello";
});


$app->get("/book", function(){
	echo "hello book";
});

$app->get("/book/:id", function($id){
	echo "call book with id -> ".$id;
});

$app->run();
