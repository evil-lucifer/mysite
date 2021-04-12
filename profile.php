<?php
session_start();
if (!$_SESSION['user']) {
    header('Location: /');
}
elseif (!$_SESSION['user']['verific']){
        header('Location: ../verifoff.php');
};
require_once "core/core.php"; 

$userID = $_SESSION['user']['id']; 
$user = User:: query($userID);
$avatar = $user['avatar'];
$name = $user['name'];
$login = $user['login'];
$email = $user['email'];
$title = "Профиль";

require_once "core/header.php";
?>

<body>
    <!-- Профиль -->
    <div class = 'profile'>
        <h1><?=$title?></h1>
        <form>
            <input type = "hidden" name = "id" value = "<?= $userID ?>">
            <?php if($avatar):?>
                <img src ="<?=$avatar?>" width = "400" alt = "">
            <?php else: ?>
                <input type = "file" name = "avatar">
                <button class = 'saveimg' type = "submit"> Сохранить </button>
            <?php endif; ?>
        </form>
        <h2><?= $name?></h2>
        <label><b>E-mail:</b>  <?= $email ?></label>    
        <label><b>Логин: </b>  <?= $login ?></label>
            
        <a href="redactor.php" class="redactor"> Редактировать </a>
        <a href ="meetstr.php" class = "meetings">Cовещания </a> 
        <a href ="users.php" class = "users"> Пользователи </a> 
        <a href="core/logout.php" class="logout">Выход</a>  
    </div>    
    <p class="msg none">Lorem ipsum dolor sit amet. </p>
    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>