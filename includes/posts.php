<?php

/**
 * Get the post record based in ID
 * 
 * @param $conn Connection to the DB
 * @param int $id the post ID
 * @param array $columns Optional list of columns for the select, defaults to *
 * 
 * @return mixed An associative array containing the post or null, if not found
 */
function getPost( $conn, int $id, array $columns = ['*'])
{   
    $col = implode(", ", $columns);
    $sql = "SELECT $col
        FROM post
        WHERE id = :id";

    $stmt = $conn->prepare($sql);

    $stmt->bindValue(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        return $stmt->fetch(PDO::FETCH_ASSOC);
        }
}

/**
 * Validate post data
 * 
 * @param string $title Post title
 * @param string $content Post content
 * @param string $published_at Date and time of post publishing
 * 
 * @return mixed $errors Return array with error messages or empty array
 */
function validatePost(string $title, string $content, string $published_at)
{
    $errors = [];

    if ($title == '') {
        $errors[] = 'Title is required';
    }
    if ($content == '') {
        $errors[] = 'Content is required';
    }
    if ($published_at != '') {
        $date_time = date_create_from_format('Y-m-d H:i:s', $published_at);

        if ($date_time === false) {
            $errors[] = 'Invalid date and time';
        } else {
            $date_errors = date_get_last_errors();

            if ($date_errors['warning_count'] > 0) {
                $errors[] = 'Invalid date and time';
            }
        }
    }
    return $errors;
}
