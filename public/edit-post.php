<?php
require '../includes/init.php';

if (!Auth::isLoggedIn()) {
    Url::redirect('/login.php');
}

$conn = require '../includes/db.php';

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

    if ($post->update($conn)) {

        Url::redirect("/post.php?id={$post->id}");

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