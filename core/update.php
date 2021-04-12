<?php
require_once 'core.php';

$id =$_POST['id'];
$name = $_POST['name'];
$login = $_POST['login'];
$email = $_POST['email'];
$oldpass = $_POST['oldpass'];
$newpass = $_POST['newpass'];
$newpass_confirm = $_POST['newpass_confirm'];
$path = $_FILES['avatar'];

$response = User::update($id,$name,$login,$email,$newpass,$newpass_confirm,$oldpass,$path);

echo json_encode($response);