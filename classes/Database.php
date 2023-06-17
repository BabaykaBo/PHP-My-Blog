<?php 

/**
 * Database
 * 
 * A connection to the DB
 */
class Database
{   
    /**
     * Get the DB connection
     * 
     * @return object Connection to the database server
     */
    public function getConnMySQL(): PDO {
        require '../db_connect.php';

        $db_host = $host;
        $db_name = $name;
        $db_user = $user;
        $db_pass = $pass;

        $dsn = "mysql:host=$db_host;dbname=$db_name;charset=utf8";

        return new PDO($dsn, $db_user, $db_pass);  
    }
    
}