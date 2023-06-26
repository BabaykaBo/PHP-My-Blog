<?php

/**
 * Category
 * 
 * Groupings for posts
 */
class Category
{
    /**
     * Get all posts
     * 
     * @param object $conn Connection to DB
     * 
     * @return array An associative array of all categories records
     */
    public static function getAll(object $conn): array
    {
        $sql = "SELECT *
        FROM category
        ORDER BY name DESC;";

        $result = $conn->query($sql);

        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
}
