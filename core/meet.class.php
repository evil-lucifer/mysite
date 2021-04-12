<?php
require_once 'core.php';

class Meet {

	public static function getMeetList($role){
		$html = "<table id = 'meets'>
            <tr>
                <th>День недели</th>
                <th>Название</th>
                <th>Дата</th>
                <th>Время</th>
            </tr>";

        $i = 0;
        $datetime = date("Y-m-d H:i:s") ;
        $meetings = DB::query("SELECT * FROM `meetings` WHERE date > '$datetime' ORDER BY `date` ASC ");
        $meetings = mysqli_fetch_all($meetings);
        $days = array( 0 => 'Воскресенье','Понедельник' , 'Вторник' , 'Среда' , 'Четверг' , 'Пятница' , 'Суббота'  );
        $months = array( 1 => 'янв','фев','мар','апр','май','июн','июл','авг','сен','окт','ноя','дек');
        foreach ($meetings as $meeting) {
            $i = number_format($i) + 1;
            $datetime = explode(" ",$meeting[2]);
            $html .= "<tr id = ".$i.">
                <td>".$days[strftime("%w", strtotime($datetime[0]))]."</td>
                <td>".$meeting[1]."</td>
                <td>".strftime("%e",  strtotime($datetime[0]))." ".$months[(int)(strftime('%m',strtotime($datetime[0])))]."</td>
                <td>".strftime("%H:%M",strtotime($datetime[1]))."</td>
                <td style = 'display: none'>".$datetime[0]."</td>";
                if($role == 1 or $role == 3){
                    $html .= "<td class='button'><button type='button' class = 'upd' value = '".$i."' data-id = '".$meeting[0]."'>Редактировать</button></td>
                    <td class='button'><button type='button' class='delete' value = '".$i."' data-id = '".$meeting[0]."'>Удалить</button></td>";
                }
            $html .= "</tr>";
        } 
        $html .= "</table>";
        if($role == 1 or $role == 3){
            $html .= "<button id='add' type='button' name='addMeet'> Добавить </button>";
        }
        return $html;
	} 

    public static function addMeet($name,$date,$time){
        if ($name === '') {
			$error_fields[] = 'name';
		}

        if ($date === '') {
			$error_fields[] = 'date';
		}

        if ($time === '') {
			$error_fields[] = 'time';
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


        $datetime = $date." ".$time;
        $result = DB::query("INSERT INTO `meetings`( `name`, `date`) VALUES ('$name','$datetime')");
       // $id = DB:: query("SELECT `mid` FROM `meetings` WHERE `name` = '$name', `date` = '$date'");
        if ($result){
            $response = [
                "status" => true,
               // "message" => $id
            ];
            return $response;

        } else{
            $response =[
                "status" => false,
                "message" => "Ошибка в SQL запросе"
            ];
            return $response;
        }
    }

    public static function delMeet($id) {
        $sql = "DELETE FROM `meetings` WHERE `mid` = '$id'";
        $result = DB::query($sql);
        if ($result){
            $response = [
                "status" => true
            ];
        }
        else{
            $response = [
                "status" => false,
                "message" => "Ошибка в SQL запросе"
            ];
        }
        return $response;
    }

    public static function update($id,$name,$date,$time){
        if ($name === '') {
			$error_fields[] = 'name';
		}

        if ($date === '') {
			$error_fields[] = 'date';
		}

        if ($time === '') {
			$error_fields[] = 'time';
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

        $datetime = $date." ".$time;
        $result = DB::query("UPDATE `meetings` SET `name` = '$name', `date` = '$datetime' WHERE `mid` = '$id'");

        if ($result){
            $response = [
                "status" => true,
            ];
            return $response;

        } else{
            $response =[
                "status" => false,
                "message" => "Ошибка в SQL запросе"
            ];
            return $response;
        }

    }
    
}