<?php

/**
 * Post
 * 
 * A piece of writing for publication
 */
class Post
{
    /**
     * Unique identifier
     * @var int
     */
    public int $id;
    
    /**
     * The post title
     * @var string
     */
    public string $title;
    
    /**
     * The post content
     * @var string
     */
    public string $content;
    
    /**
     * The publication date and time
     * @var datetime
     */
    public $published_at;

    /**
     * Get all posts
     * 
     * @param object $conn Connection to DB
     * 
     * @return array An associative array of all posts records
     */
    public static function getAll(object $conn): array
    {
        $sql = "SELECT *
        FROM post
        ORDER BY published_at;";

        $result = $conn->query($sql);

        if ($result === false) {
            echo 'Server query error!';
        } else {
            return $result->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    /**
     * Get the post record based in ID
     * 
     * @param object $conn Connection to the DB
     * @param int $id the post ID
     * @param array $columns Optional list of columns for the select, defaults to *
     * 
     * @return mixed An object of  the post or null, if not found
     */
    public static function getPostByID(object $conn, int $id, array $columns = ['*'])
    {
        $col = implode(", ", $columns);
        $sql = "SELECT $col
        FROM post
        WHERE id = :id";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Post');

        if ($stmt->execute()) {
            return $stmt->fetch();
        }
    }
}
