<?php
    require_once "core.php";

    $id = $_POST['id'];

    if(!$_FILES['avatar']){
        $path = 'uploads/' . time() . $_FILES['avatar']['name'];
        if (!move_uploaded_file($_FILES['avatar']['tmp_name'], '../' . $path)) {
            $response = [
                "status" => false,
                "message" => "Ошибка при загрузке аватарки",
            ];
            echo json_encode($response);
            die();
        }
        DB::query( "UPDATE `users` SET `avatar`='$path' WHERE `users`.`id` = '$id'");
        $response = [
            "status" => true,
        ];
        echo json_encode($response);
    }
