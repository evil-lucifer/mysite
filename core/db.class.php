<?php

class DB {

    protected static $_instance;

    public static function getInstance() {
        if (self::$_instance === null) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }
//соединение с базой данных
    private  function __construct() {
        $this->connect = mysqli_connect("localhost", "root", "") or die("Невозможно установить соединение".mysqli_error($this->connect));
        mysqli_select_db( $this->connect, "labs") or die ("Невозможно выбрать указанную базу".mysqli_error($this->connect));
        $this->query('SET names "utf8"');
    }

//запрос в базу данных
    public static function query($sql) {

        $obj=self::$_instance;

        if(isset($obj->connect)){
            $obj->count_sql++;
            $start_time_sql = microtime(true);
            $result=mysqli_query($obj->connect,$sql)or die("<br/><span style='color:red'>Ошибка в SQL запросе:</span> ".$obj->connect->error);
            return $result;
        }
        return false;
    }

    //возвращает запись в виде объекта
    public static function fetch_object($object)
    {
        return @mysqli_fetch_object($object);
    }


}