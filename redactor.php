<?php
session_start();
if (!$_SESSION['user']) {
    header('Location: /');
}
else{
    if (!$_SESSION['user']['verific']):
        header('Location: ../verifoff.php');
    endif;
}
require_once "core/core.php" ;

$userID = $_SESSION['user']['id'];
$user = User:: query($userID);
$name = $user['name'];
$login = $user['login'];
$email = $user['email'];
$title = "Редактировать";
require_once "core/header.php";
?>

<body>
    <!-- Редактирование профиля -->
    <div id='redactor'>
        <h1><?=$title?></h1>
        <a href = "profile.php" class = 'back'>Назад</a>
        <form>
            <input type = "hidden" name = "id" value = "<?= $userID ?>">
            <label> ФИО: </label>
            <input  type = "text" name = "name" value = "<?=$name?>" placeholder="Введите полное имя">
            <label> Логин: </label>
            <input type = "text" name = "login" value = "<?=$login?>" placeholder="Введите логин">
            <label> E-mail: </label>
            <input type = "email" name = "email" value = "<?=$email?>" placeholder="Введите электронную почту">
            <label> Изображение профиля: </label>
            <input type = "file" name = "avatar">
            <label> Старый пароль: </label>
            <input type = "password" name = "oldpass" placeholder = "Введите старый пароль">
            <label> Новый пароль : </label>
            <input type = "password" name = "newpass" placeholder = "Введите новый пароль">
            <label> Подтверждение пароля : </label>
            <input type = "password" name = "newpass_confirm" placeholder = "Подтвердите новый пароль">
            <button type = "submit" class = 'update-btn'> Сохранить </button>
        </form>
        <p class="msg none">Lorem ipsum dolor sit amet. </p>
        <script src="js/jquery-3.6.0.min.js"></script>
        <script src="js/main.js"></script>
    </div>
</body>
</html>