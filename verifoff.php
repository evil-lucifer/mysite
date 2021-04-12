<?php
session_start();
require_once "core/core.php";
$title = "Профиль";
require_once "core/header.php";
?>
<body>
    <!-- Профиль неподтвержденный -->
    <?php 
    $id = $_SESSION['user']['id'];
    $user = User::query($id);
    $email = $user['email'];
    $hash = $user['token'];
    ?>
    <div id = "profile">
        <form >
            <input type="hidden" name="email" value="<?= $email ?>">
            <input type="hidden" name="hash" value="<?= $hash ?>">
            <button class='verif-btn' type="submit" name="verif">Подтвердить e-mail </button>
            <a href="core/logout.php" class="logout">Выход</a>
            <p class="msg none">Lorem ipsum dolor sit amet. </p>
        </form>
    </div>
    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/main.js"></script>      
</body>
</html>