<?php
// Подключаем коннект к БД
require_once 'core.php';
 
// Проверка есть ли хеш
if ($_GET['hash']) {
    $hash = $_GET['hash'];
    // Получаем id и подтверждено ли Email
    if ($result = DB::query("SELECT `id`, `verific` FROM `users` WHERE `token`='" . $hash . "'")) {
        while( $row = mysqli_fetch_assoc($result) ) { 
            // Проверяет получаем ли id и Email подтверждён ли 
            if ($row['verific'] == 0) {
                // Если всё верно, то делаем подтверждение
                DB::query("UPDATE `users` SET `verific`=1,`token`=''  WHERE `id`=". $row['id'] );
                $_SESSION['message'] = "Регистрация завершена";
                header('Location: /');
            } else {
                $_SESSION['message'] ="Что то пошло не так";
                header('Location: /');
            }
        } 
    } else {
        $_SESSION['message'] ="Что то пошло не так";
        header('Location: /');
    }
} else {
    $_SESSION['message'] ="Что то пошло не так";
    header('Location: /');
}