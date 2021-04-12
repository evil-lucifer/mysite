<?php
session_start();
require_once "core/core.php";
if ($_SESSION['user']) {
    header('Location: profile.php');
}
$title = "Авторизация";
require_once "core/header.php";
?>
<body> 
<!-- Форма авторизации -->
<div id="authorize">
    <h1><?=$title?></h1>
    <form>
        <label>Логин:</label> 
        <input type="text" name="login" placeholder = "Введите свой логин">
        <label>Пароль:</label>
        <input type="password" name="password" placeholder = "Введите пароль">
        <button class='login-btn' type="submit"> Войти </button>
        <p>
            У вас нет аккаунта? - <a href="/register.php">зарегистрируйтесь</a>!
        </p>
        <p class="msg none">Lorem ipsum dolor sit amet. </p>
    </form>
</div> 
    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/main.js"></script>       
</body>
</html>
