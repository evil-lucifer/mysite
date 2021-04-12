<?php

require_once "core.php";

$id = $_POST['id'];

$response = User::delUser($id);

echo json_encode($response);