<?php
require '../includes/database.php';
require '../includes/posts.php';
require '../includes/url.php';
require '../includes/auth.php';

session_start();

if (! isLoggedIn()){
    redirect('/login.php');
}

$conn = getDB();

if (isset($_GET['id'])) {

    $post = getPost($conn, $_GET['id']);

    if ($post) {

        $id = $post['id'];
        $title = $post['title'];
        $content = $post['content'];
        $published_at = $post['published_at'];

    } else {
        die('No post found');
    }
} else {
    die('ID is not supplied. No post found');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = $_POST['title'];
    $content = $_POST['content'];
    $published_at = $_POST['published_at'];

    $errors = validatePost($title, $content, $published_at);

    if (empty($errors)) {
        $sql = "UPDATE post 
                SET title = ?,
                 content = ?, 
                 published_at =?
                WHERE id = ? ";

        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt === false) {
            echo mysqli_error($conn);
        } else {
            if ($published_at == '') {
                $published_at = null;
            }
            mysqli_stmt_bind_param(
                $stmt,
                "sssi",
                $title,
                $content,
                $published_at,
                $id,
            );

            if (mysqli_stmt_execute($stmt)) {

                redirect("/post.php?id=$id");

            } else {
                echo mysqli_stmt_error($stmt);
            }
        }
    }
}
?>
<?php require "../includes/header.php"; ?>
<h2>Edit Post</h2>
<?php require '../includes/post-form.php'; ?>
<br>
<p><a href="post.php?id=<?php echo $id; ?>">Cancel</a></p>
<div><a href="index.php">Home</a></div>
<?php require "../includes/footer.php"; ?>