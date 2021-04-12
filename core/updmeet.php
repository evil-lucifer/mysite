<?php

require_once "meet.class.php"; 

$id = $_POST['id'];
$name = $_POST['name']; 
$date = $_POST['date'];
$time = $_POST['time'];

$response = Meet::update($id,$name,$date,$time);

echo json_encode($response);
