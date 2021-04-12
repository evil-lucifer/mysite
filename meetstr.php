<?php
session_start();
if (!$_SESSION['user']) {
    header('Location: /');
}
elseif (!$_SESSION['user']['verific']){
        header('Location: ../verifoff.php');
}
require_once "core/core.php" ;
require_once "core/meet.class.php"; 

$title = "Совещания";
$userID = $_SESSION['user']['id'];
$role = (User::query($userID))['id_role'];

require_once "core/header.php";

if($role == 1 or $role == 3): ?>
    <div class = "modal" id = 'modaladd'>
            <div class = "add">
                <form>    
                    <h1>Добавление совещания</h1>
                    <label>Название совещания</label>
                    <input type = "text" name = "name" placeholder = "Введите название">
                    <label>Дата</label>
                    <input type = "date" name = "date">
                    <label>Время</label>
                    <input type = "time" name = "time">
                    <button style = 'margin-bottom:5px' class = "yes" type = "submit" name = 'add'>Добавить</button>
                    <button type = 'button' class = 'no'>Отмена</button>
                    <p class = "msg none">Lorem ipsum dolor sit amet. </p>
                </form>    
            </div>
    </div>
    <div class = "modal" id = 'modalupd'>
            <div class = "update">
                <form > 
                    <h1>Редактирование совещания</h1>   
                    <label>Название совещания</label>
                    <input type = "text" name = "namemeet" value = "" class = "name" placeholder = "Введите название">
                    <label>Дата</label>
                    <input type = "date" name = "datemeet" class = "date" value = "" >
                    <label>Время</label>
                    <input type = "time" name = "timemeet" class = time value = "" >
                    <button style = 'margin-bottom:5px' type = "submit" class = "yes" name=  'update'>Изменить</button>
                    <button type = 'button' class = 'no'>Отмена</button>
                    <p class = "msg none">Lorem ipsum dolor sit amet. </p>
                </form>    
            </div>
    </div>
    <div class = "modal" id = 'modaldel'> 
            <div class = "del">
                <p> Вы действительно хотите удалить совещание? </p>
                <button type = 'submit' style = 'margin-bottom:5px' class = "yes" >Да</button>
                <button type = 'button' class = "no">Нет</button>
            </div>
    </div>
<?php endif; ?>
<div id = 'meet'>
    <h1><?=$title?></h1>
    <a  href = 'profile.php' class = 'back' name = 'back' > Назад</a>
        <?php print(Meet:: getMeetList($role)); ?>
        <p class = "msg none">Lorem ipsum dolor sit amet. </p>
</div>
    <script src = "js/jquery-3.6.0.min.js"></script>
    <script src = "js/main.js"></script>
</body>
</html>
