<?php

/**
 * Database
 * 
 * A connection to the DB
 */
class Database
{
    /**
     * Hostname
     * @var string
     */
    protected string $db_host;

    /**
     * Database name
     * @var string
     */
    protected string $db_name;

    /**
     * Username
     * @var string
     */
    protected string $db_user;

    /**
     * Password
     * @var string
     */
    protected string $db_pass;

    /**
     * Constructor
     * 
     * @param string $host Hostname
     * @param string $name DB name
     * @param string $user Username
     * @param string $pass Password
     */
    public function __construct($host, $name, $user, $pass)
    {
        $this->db_host = $host;
        $this->db_name = $name;
        $this->db_user = $user;
        $this->db_pass = $pass;
    } 

    /**
     * Get the DB connection
     * 
     * @return object Connection to the database server
     */
    public function getConnMySQL(): PDO
    {

        $dsn = "mysql:host={$this->db_host};dbname={$this->db_name};charset=utf8";

        return new PDO($dsn, $this->db_user, $this->db_pass);
    }
}
