<?php
/**
 * DB connection
 * 
 * Connect to the DB
 *  */ 
$db = new Database();
return $db->getConnMySQL();