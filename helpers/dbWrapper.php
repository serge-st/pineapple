<?php

class DB {
    private static $connection;
    
    private static function openConnection(){
        $dbAccess = parse_ini_file(__DIR__ . '/../config.ini');
        $hostname = $dbAccess["mysql.host"];
        $user = $dbAccess["mysql.user"];
        $password = $dbAccess["mysql.password"];
        $database = $dbAccess["mysql.db"];
        
        self::$connection = new mysqli($hostname, $user, $password, $database);

        if (self::$connection->connect_errno){
            $error = "Connection Error: " . self::$connection->connect_errno . ": " . self::$connection->connect_error;
            self::closeConnection();
            exit($error);
        }
    }

    private static function closeConnection(){
        self::$connection->close();
        self::$connection = null;
    }

    public static function converText($text){
        if (self::$connection === null){
            self::openConnection();
        }
        return self::$connection->real_escape_string($text);
    }

    public static function run($sql){
        if (self::$connection === null){
            self::openConnection();
        }

        $response = self::$connection->query($sql);

        if (self::$connection->error){
            $error = self::$connection->error;
            self::closeConnection();
            exit($error);
        }

        self::closeConnection();
        return $response;
    }    
}