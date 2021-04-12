<?php

require_once "core.php";

$email = $_POST['email'];
$hash = $_POST['hash'];

$response = User::send($email,$hash);

echo json_encode($response);