<?php
session_start();
require_once "core.php";

$login = $_POST['login'];
$password = $_POST['password'];

$response = User::authorize($login,$password);

echo json_encode($response);


