<?php
require '../classes/Database.php';
require '../classes/Post.php';
require '../classes/Url.php';
require '../classes/Auth.php';

session_start();

if (!Auth::isLoggedIn()) {
    Url::redirect('/login.php');
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