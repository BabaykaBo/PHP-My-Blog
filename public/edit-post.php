<?php
require '../classes/Database.php';
require '../classes/Post.php';
require '../includes/posts.php';
require '../includes/url.php';
require '../includes/auth.php';

session_start();

if (!isLoggedIn()) {
    redirect('/login.php');
}

$db = new Database();
$conn = $db->getConnMySQL();

if (isset($_GET['id'])) {
    $post = Post::getPostByID($conn, $_GET['id']);

    if (!$post) {
        die('No post found');
    }
} else {
    die('ID is not supplied. No post found');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $post->title = $_POST['title'];
    $post->content = $_POST['content'];
    $post->published_at = $_POST['published_at'];

    $errors = validatePost($post->title, $post->content, $post->published_at);

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
<p><a href="post.php?id=<?php echo $post->id; ?>">Cancel</a></p>
<div><a href="index.php">Home</a></div>
<?php require "../includes/footer.php"; ?>