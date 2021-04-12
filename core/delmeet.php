<?php

require_once "meet.class.php"; 

$id = $_POST['id'];

$response = Meet::delMeet($id);

echo json_encode($response);
