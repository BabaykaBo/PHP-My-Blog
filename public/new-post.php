<?php
require '../includes/database.php';
require '../includes/posts.php';
require '../includes/url.php';
require '../includes/auth.php';

session_start();

if (! isLoggedIn()){
    redirect('/login.php');
}

$title = '';
$content = '';
$published_at = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = $_POST['title'];
    $content = $_POST['content'];
    $published_at = $_POST['published_at'];

    $errors = validatePost($title, $content, $published_at);

    if (empty($errors)) {
        $conn = getDB();

        $sql = "INSERT INTO post (title, content, published_at)
            VALUES (?, ?, ?)";

        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt === false) {
            echo mysqli_error($conn);
        } else {
            if ($published_at == '') {
                $published_at = null;
            }
            mysqli_stmt_bind_param(
                $stmt,
                "sss",
                $title,
                $content,
                $published_at,
            );

            if (mysqli_stmt_execute($stmt)) {

                $id = mysqli_insert_id($conn);
                
                redirect("/post.php?id=$id");

            } else {
                echo mysqli_stmt_error($stmt);
            }
        }
    }
}
?>
<?php require "../includes/header.php"; ?>
<h2>New Post</h2>
<?php require '../includes/post-form.php'; ?>
<br>
<div><a href="index.php">Home</a></div>
<?php require "../includes/footer.php"; ?>