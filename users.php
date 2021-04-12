<?php

session_start();
require_once "core/core.php" ;
$title = "Пользователи";

if (!$_SESSION['user']) {
    header('Location: /');
}
else if (!$_SESSION['user']['verific']){
    header('Location: ../verifoff.php');
}

require_once "core/header.php";

$userID = $_SESSION['user']['id'];
$role = (User::query($userID))['id_role'];

?>

<body>
    <?php if($role==1 or $role == 3):?>
        <div class="modal">
        <div class='overlay'></div>
            <div class="del">
                <p> Вы действительно хотите удалить пользователя? </p>
                <button id="yes" style='margin-bottom:5px' name='deluser' type='submit'>Да</button>
                <button id="no" type="button">Нет</button>
            </div>
        </div>
    <?php endif;?>
    <div id='user'>
        <h1><?=$title?></h1>
        <a  href='profile.php' class='back' name='back' > Назад</a>
        <?php print(User::getUserList($role)); ?>
        <p class="msg none">Lorem ipsum dolor sit amet. </p>
    </div>
    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>