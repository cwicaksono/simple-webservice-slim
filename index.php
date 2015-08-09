<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(-1);

require 'vendor/autoload.php';
require "libs/NotORM.php";

// database config
// server database
$server = 'localhost';
// database name
$db_name = 'db_test';
// database user
$db_user = 'root';
// database password
$db_pass = 'pratama';

$pdo = new PDO("mysql:host=$server;dbname=$db_name", $db_user, $db_pass);
$db = new NotORM($pdo);

$app = new \Slim\Slim();
$app->response()->header("Content-Type", "application/json");

$app->get("/", function(){
	echo "hello";
});

// get all user
$app->get("/user",function() use ($app,$db){
	foreach ($db->user() as $value) {
		$users["response"][] = array(
			"id" => $value["id"],
			"name" => $value["name"],
			"email" => $value["email"]
		);
	}
	echo json_encode($users);
});

// get single data
$app->get("/user/:id",function($id) use ($app,$db){
	$user = $db->user()->where("id", $id);
	if($value = $user->fetch()){
		$users["data"] = array(
			"id" => $value["id"],
			"name" => $value["name"],
			"email" => $value["email"]
		);
		echo json_encode(array(
			"status" =>200,
			"message" => "data found",
			"response" =>$users["data"]
			));
	}else{
		echo json_encode(array(
			"status"=>400,
			"message"=> "No Data"
			));
	}
	
});

// insert data
$app->post("/user",function() use ($app,$db){
	$user = $app->request()->post();
	$result = $db->user->insert($user);
	if($result){
		echo json_encode(array(
			"status"=>200,
			"message"=>"success"
		));
	}else{
		echo json_encode(array(
			"status"=>400,
			"messages"=>"failed"
		));
	}
});

$app->run();
