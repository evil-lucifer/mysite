<?php
require_once "core.php";

class User {

	public static function getUserList($role){
		$html = "<table>
            <tr>
                <th>№</th>
                <th>ФИО</th>
                <th>Логин</th>
                <th>Email</th>
            </tr>";
        $i = 0;
        $users=DB::query("SELECT * FROM `users`");
        $users = mysqli_fetch_all($users);
        foreach ($users as $user) {
            $i = number_format($i) + 1;
        	$html .= "<form>
                <tr><td>".$i."</td>
                <td>".$user[1]."</td>
                <td>".$user[2]."</td>
                <td>".$user[3]."</td>";
                if($role == 1 or $role == 3){
                    $html.= "<td style = 'background-color: rgba(0, 0, 0, 0);'><button type = 'button' class = 'delUser' data-id = ".$user[0].">x<a></td>";
				}
				$html.="</tr>";

		}
        $html .= "</table>";
		return $html;
	} 


	public static function addUser($name,$login,$email,$password,$password_confirm){

		$check_login = DB::query("SELECT * FROM `users` WHERE `login` = '$login'");
		if (mysqli_num_rows($check_login) > 0) {
			$response = [
				"status" => false,
				"type" => 1,
				"message" => "Такой логин уже существует",
				"fields" => ['login']
			];
		
			return $response;
		}

		$error_fields = [];

		if ($login === '') {
			$error_fields[] = 'login';
		}

		if ($password === '') {
			$error_fields[] = 'password';
		}

		if ($name === '') {
			$error_fields[] = 'name';
		}

		if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) ) {
			$error_fields[] = 'email';
		}

		if ($password_confirm === '') {
			$error_fields[] = 'password_confirm';
		}

		if (!empty($error_fields)) {
			$response = [
				"status" => false,
				"type" => 1,
				"message" => "Проверьте правильность полей",
				"fields" => $error_fields
			];

			return $response;

			die();
		}

		if ($password === $password_confirm) {
			$name = htmlspecialchars($name);
			$login = htmlspecialchars($login);
			$email = htmlspecialchars($email);
			$password = md5($password);
			$hash = md5($login . time());
			$sql = "INSERT INTO `users`( `name`, `login`, `email`, `token`, `pass`) VALUES ('$name', '$login','$email','$hash','$password')";
			DB::query($sql);
			User::send($email,$hash);

			$response = [
				"status" => true,
				"message" => "Подтвердите на почте!",
			];
			return $response;


		} else {
			$response = [
				"status" => false,
				"message" => "Пароли не совпадают",
			];
			return $response;
		}				
	}	

    public static function authorize($login,$password){
		
		$error_fields = [];

		if ($login === '') {
			$error_fields[] = 'login';
		}

		if ($password === '') {
			$error_fields[] = 'password';
		}

		if (!empty($error_fields)) {
			$response = [
				"status" => false,
				"type" => 1,
				"message" => "Проверьте правильность полей",
				"fields" => $error_fields
			];

			return $response;

		}

		$password = md5($password);
		$check_user = DB::query("SELECT * FROM `users` WHERE `login` = '$login' AND `pass` = '$password'");
		
		if (mysqli_num_rows($check_user) > 0) {
		
			$user = mysqli_fetch_assoc($check_user);

			$_SESSION['user'] = [
				"id" => $user['id'],
				'login' => $user['login'],
				"avatar" => $user['avatar'],
				"email" => $user['email'],
				"verific" => $user['verific'],
			];

			$response = [
				"status" => true
			];
			return $response;

		} else {

			$response = [
				"status" => false,
				"message" => 'Не верный логин или пароль'
			];
			return $response;
		}
	}
	
	public static function send($email,$hash){
		require "PHPMailer\PHPMailer.php";
		require "PHPMailer\SMTP.php";
		require "PHPMailer\Exception.php"; 

        // Создаем письмо
        $body = '
            <html>
            <head>
            <title>Подтвердите Email</title>
            </head>
            <body>
            <p>Что бы подтвердить Email, перейдите по <a href="http://mysite/core/email.php?hash=' . $hash . '">ссылкe</a></p>
            </body>
            </html>
         ';

        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail->CharSet = 'UTF-8';
		$mail->SMTPDebug = 3;
        $mail->isSMTP();                   // Отправка через SMTP
        $mail->Host   = 'smtp.gmail.com';  // Адрес SMTP сервера
        $mail->SMTPAuth   = true;          // Enable SMTP authentication
		$mail->SMTPSecure = 'tls';
		$mail->Username   = 'infotest790@gmail.com';       // ваше имя пользователя (без домена и @)
	    $mail->Password   = 's1u2z3u4k5i6';    // ваш пароль        // шифрование ssl
        $mail->Port   = 587;               // порт подключения
 
    	$mail->setFrom('infotest790@gmail.com', '');    // от кого
	    $mail->addAddress($email, ''); // кому
	    $mail->Subject = "Подтверждение регистрации";
	    $mail->msgHTML($body);
	   // Отправляем
	  	if ($mail->send()) {
			  $response = [
				"status" => true,
				"message" => "Письмо отправлено!"
			  ];
			  return $response;
  	   		
        } else {
			$response = [
				"status" => false,
				"message" => 'Ошибка: ' . $mail->ErrorInfo
			];
			return $response;
        }
	}

	public static function update($id,$name,$login,$email,$newpass,$newpass_confirm,$oldpass,$path){

    	$users = DB::query("SELECT * FROM `users` WHERE `id`='$id'");
		$users = mysqli_fetch_all($users);
		foreach ($users as $user){
			$userLogin = $user[2];
			$userEmail = $user[3];
			$userPass = $user[8];
		}

		$check_login = DB::query("SELECT * FROM `users` WHERE `login` = '$login'");
		if($login != $userLogin){

			if (mysqli_num_rows($check_login) > 0) {
				$response = [
					"status" => false,
					"type" => 1,
					"message" => "Такой логин уже существует",
					"fields" => ['login']
				];
			
				return $response;
			}
		}

		$error_fields = [];

		if ($login === '') {
			$error_fields[] = 'login';
		}

		if ($name === '') {
			$error_fields[] = 'name';
		}

		if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) ) {
			$error_fields[] = 'email';
		}

		if(md5($oldpass) == $userPass){
			if($newpass === $newpass_confirm ){
				$password = md5($newpass);
			}
			else if ($newpass){
				$error_fields[] = "newpass";
				$error_fields[] = "newpass_confirm";
			}

		} else if ($oldpass){
			$error_fields[] = 'oldpass';
		}
		else{
			$password = $userPass;
		}

		if (!empty($error_fields)) {
			$response = [
				"status" => false,
				"type" => 1,
				"message" => "Проверьте правильность полей",
				"fields" => $error_fields
			];

			return $response;
		}

		$avatar = "";
		if ($path){
			$img = 'uploads/' . time() . $path['name'];
			if (!move_uploaded_file($path['tmp_name'], '../' . $img)) {
				$response = [
					"status" => false,
					"type" => 1,
					"message" => 'Ошибка при загрузке аватарки',
					"fields" => 'avatar',
				];
				return $response;
			}
			else {
				$avatar=",`avatar`='$img'";
			}
		}

		if ($email == $userEmail ){
			$name = htmlspecialchars($name);
			$login = htmlspecialchars($login);

			DB::query( "UPDATE `users` SET `name` = '$name', `login` = '$login', `pass` = '$password'".$avatar." WHERE `id` = '$id'");
			$response = [
				"status" => true,
				"message" => "Данные успешно изменены!"
			];

			return $response;
			die();
		}
		else {
			$email = htmlspecialchars($email);
			$hash = md5($login . time());
			DB::query( "UPDATE `users` SET `name` = '$name', `login` = '$login', `pass` = '$password'".$avatar.",`email` = '$email',`verific` = '0',`token`='$hash' WHERE `id` = '$id'");
			User::send($email,$hash);
			$response = [
				"status" => true,
				"message" => "Подтвердите на почте!",
			];
			return $response;
		}	
	}

	public static function delUser($id){
		$result = DB::query("DELETE FROM `users` WHERE `id` = '$id'");
		if($result){
			$response = [
				"status" => true
			];
			return $response; 
		}
		$response = [
			"status" => false
		];
		return $response;
	}

	public static function query($id){
		$user = mysqli_fetch_assoc(DB::query("SELECT * FROM `users` WHERE `id`= '$id'"));
		return $user;
	}
}