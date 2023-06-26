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
    public string $title = '';

    /**
     * The post content
     * @var string
     */
    public string $content = '';

    /**
     * The publication date and time
     * @var ?string
     */
    public ?string $published_at = '';

    /**
     * Array of error massages
     * @var array
     */
    public array $errors = [];

    /**
     * Name of image
     * @var ?string
     */
    public ?string $image_file;

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
        ORDER BY published_at DESC;";

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
     * 
     * @return array The post data with category
     */
    public static function getWithCategories(object $conn, int $id): array
    {
        $sql = "SELECT post.*, category.name AS category_name
        FROM post
        LEFT JOIN post_category
        ON post.id = post_category.post_id
        LEFT JOIN category
        ON post_category.category_id = category.id
        WHERE post.id = :id
        ORDER BY published_at DESC;";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get the post's categories
     * 
     * @param object $conn Connection to the DB
     * 
     * @return array The category
     */
    public function getCategories($conn): array
    {
        $sql = "SELECT category.*
        FROM category
        JOIN post_category
        ON category.id = post_category.category_id
        WHERE post_id = :id;";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get posts for single page
     * 
     * @param object $conn Connection to DB
     * @param int $limited parameter for SQL LIMIT
     * @param int $offset parameter for SQL OFFSET
     * 
     * @return array An associative array of posts records
     */
    public static function getPage(object $conn, int $limited, int $offset): array
    {
        $sql = "SELECT *
        FROM post
        ORDER BY published_at DESC
        LIMIT :limited
        OFFSET :offset;";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':limited', $limited, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get the post record based in ID
     * 
     * @param object $conn Connection to the DB
     * @param int $id the post ID
     * @param array $columns Optional list of columns for the select, defaults to *
     * 
     * @return mixed An object of  the post or false, if not found
     */
    public static function getPostByID(object $conn, int $id, array $columns = ['*']): mixed
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

    /**
     * Update post records
     * 
     * @param object $conn Connection to DB
     * 
     * @return bool True if updating is successful or false if not 
     */
    public function update(object $conn): bool
    {
        if ($this->validatePost()) {
            $sql = "UPDATE post 
                SET title = :title,
                 content = :content, 
                 published_at = :published_at
                WHERE id = :id";

            $stmt = $conn->prepare($sql);

            $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
            $stmt->bindValue(':content', $this->content, PDO::PARAM_STR);
            $stmt->bindValue(':title', $this->title, PDO::PARAM_STR);

            if ($this->published_at === '') {
                $stmt->bindValue(':published_at', null, PDO::PARAM_NULL);
            } else {
                $stmt->bindValue(':published_at', $this->published_at, PDO::PARAM_STR);
            }

            return $stmt->execute();
        } else {

            return false;
        }
    }

    /**
     * Set the post categories
     * 
     * @param object $conn Connection to DB
     * @param array $ids Category IDs
     * 
     * @return void
     */
    public function setCategories(object $conn, array $ids): void
    {
        if ($ids) {
            $sql = "INSERT IGNORE INTO post_category (post_id, category_id)
            VALUES ($this->id, :category_id);";

            $stmt = $conn->prepare($sql);

            foreach ($ids as $id){
                $stmt->bindValue(':category_id', $id, PDO::PARAM_INT);
                $stmt->execute();
            }
        }
            $sql = "DELETE FROM post_category
                    WHERE post_id = {$this->id} ";

            if ($ids) {

                $placeholders = array_fill(0, count($ids), '?');
                $placeholders = implode(", ", $placeholders);

                $sql .= "AND category_id NOT IN ($placeholders);";
            
            }

            $stmt = $conn->prepare($sql);

            foreach ($ids as $i => $id) {
                $stmt->bindValue($i+1, $id, PDO::PARAM_INT);
            }

            $stmt->execute();
    }

    /**
     * Validate post data
     *  
     * @return bool $errors Return array with error messages or empty array
     */
    protected function validatePost(): bool
    {
        $this->errors = [];

        if ($this->title == '') {
            $this->errors[] = 'Title is required';
        }
        if ($this->content == '') {
            $this->errors[] = 'Content is required';
        }
        if ($this->published_at != '') {
            $date_time = date_create_from_format('Y-m-d H:i:s', $this->published_at);

            if ($date_time === false) {
                $this->errors[] = 'Invalid date and time';
            } else {
                $date_errors = date_get_last_errors();

                if ($date_errors['warning_count'] > 0) {
                    $this->errors[] = 'Invalid date and time';
                }
            }
        }
        return empty($this->errors);
    }

    /**
     * Delete post
     * 
     * @param object $conn Connection to DB
     * 
     * @return bool True if deleting is successful or false if not 
     */
    public function delete(object $conn): bool
    {
        $sql = "DELETE FROM post 
                WHERE id = :id ";

        $stmt = $conn->prepare($sql);

        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Create post 
     * 
     * @param object $conn Connection to DB
     * 
     * @return bool True if creating is successful or false if not 
     */
    public function create(object $conn): bool
    {
        if ($this->validatePost()) {

            $sql = "INSERT INTO post (title, content, published_at)
            VALUES (:title, :content, :published_at)";

            $stmt = $conn->prepare($sql);

            $stmt->bindValue(':content', $this->content, PDO::PARAM_STR);
            $stmt->bindValue(':title', $this->title, PDO::PARAM_STR);

            if ($this->published_at === '') {
                $stmt->bindValue(':published_at', null, PDO::PARAM_NULL);
            } else {
                $stmt->bindValue(':published_at', $this->published_at, PDO::PARAM_STR);
            }

            if ($stmt->execute()) {
                $this->id = $conn->lastInsertId();
                return true;
            }
        } else {
            return false;
        }
    }

    /**
     * Get count of the total number of records
     * 
     * @param object $conn Connection to DB
     * 
     * @return int The total number of records
     */
    public static function getTotal(object $conn): int
    {
        return $conn->query('SELECT COUNT(*) FROM post;')->fetchColumn();
    }

    /**
     * Set the image file property
     * 
     * @param object $conn Connection to DB
     * @param string $filename the filename of the image file
     * 
     * @return bool True if it was successful, false otherwise
     */
    public function setImageFile(object $conn, string|null $filename): bool
    {
        $sql = "UPDATE post
                SET image_file = :image_file
                WHERE id = :id;";

        $stmt = $conn->prepare($sql);

        $stmt->bindValue(':image_file', $filename, $filename == null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
