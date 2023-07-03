<?php
/**
 * DB connection
 * 
 * Connect to the DB
 *  */ 
$db = new Database(DB_HOST, DB_NAME, DB_USER, DB_PASS);
return $db->getConnMySQL();