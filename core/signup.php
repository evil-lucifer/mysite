<?php
require_once "core.php";

$name = $_POST['name'];
$login = $_POST['login'];
$email = $_POST['email'];
$password = $_POST['password'];
$password_confirm = $_POST['password_confirm'];

$response = User::addUser($name,$login,$email,$password,$password_confirm); 

echo json_encode($response);