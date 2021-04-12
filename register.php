<?php

session_start();
if ($_SESSION['user']) {
    header('Location: /profile.php');
}
$title = "Регистрация";
require_once "core/core.php";
require_once "core/header.php";
?>
<body> 
<!-- Форма регистрации -->
<div id="register"> 
   <form>
        <h1><?=$title?> </h1>
        <label><samp style="color:red">*</samp> ФИО:  </label>
        <input  type="text" name="name" value="<?=$Name?>" placeholder="Введите полное имя">
		<label><samp style="color:red">*</samp> Логин: </label>
        <input type="text" name="login" placeholder="Введите логин">
        <label><samp style="color:red">*</samp> E-mail: </label>
        <input type = "email" name="email" placeholder = "Введите адрес электронной почты">
        <label><samp style="color:red">*</samp> Пароль: </label>
        <input type="password" name="password" placeholder="Введите пароль">
        <label><samp style="color:red">*</samp> Подтверждение пароля: </label>
        <input type="password" name="password_confirm" placeholder="Подтвердите пароль">
    	<button class='register-btn' type="submit" name="addUser">Зарегистрироваться</button>
        <p>
            У вас уже есть аккаунт? - <a href="/index.php">авторизируйтесь</a>!
        </p>
        <p class="msg none">Lorem ipsum dolor sit amet. </p>
   <form>
</div>
    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/main.js"></script>      
</body>
</html>
