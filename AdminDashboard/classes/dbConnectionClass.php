<?php

class dbConnection
{
 private $host = 'localhost';
 private $dbName ='gameshop';
 private $username='root';
 private $password='';
 private $pdo;
 private static $instence = null; 

 private function __construct()
 {
    
    try{
        $dsn ='mysql:host='. $this->host . ';dbname=' . $this->dbName;
        $options = [

            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE =>PDO::FETCH_ASSOC,
            PDO::ATTR_PERSISTENT => true,

        ];
        $this->pdo = new PDO($dsn,$this->username, $this->password,$options);
        // echo "connection succefull";

      
    } catch (PDOException $e)
    {
        die('Database connection failed: ' . $e->getMessage());

    };
    }
    // singlton design pattern 
    public static function getInstence(){
        if (self::$instence===null)
        {
            self::$instence=new dbConnection();
        }
        return self::$instence;
    }

     public function getConnection()
     {
        return$this->pdo;
    }
 }


//  $connect= new dbConnection();

//  $connect->getConnection();




?>