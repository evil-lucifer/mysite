<?php

require_once "meet.class.php"; 

$name = $_POST['name'];
$date = $_POST['date'];
$time = $_POST['time'];

$response = Meet:: addMeet($name,$date,$time);

echo json_encode($response);