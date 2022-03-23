<?php
    namespace Classes;
    
    /**
     * Simple database wrapper to handle the mysql credentials and create connections
     */
    class Database {
        public static function connect(){
            $conn = new \mysqli('database', 'root', 'password', 'ServicesApi', 3306);

            if($conn->connect_errno){
                return false;
            }

            return $conn;
        }
    }
?>