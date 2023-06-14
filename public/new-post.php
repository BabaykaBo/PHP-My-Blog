<?php
require '../classes/Database.php';
require '../classes/Post.php';
require '../includes/url.php';
require '../includes/auth.php';

session_start();

if (!isLoggedIn()) {
    redirect('/login.php');
}

$post = new Post();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $db = new Database();
    $conn = $db->getConnMySQL();
    
    $post->title = $_POST['title'];
    $post->content = $_POST['content'];
    $post->published_at = $_POST['published_at'];

    if ($post->create($conn)) {

        redirect("/post.php?id={$post->id}");
    }
}

?>
<?php require "../includes/header.php"; ?>
<h2>New Post</h2>
<?php require '../includes/post-form.php'; ?>
<br>
<div><a href="index.php">Home</a></div>
<?php require "../includes/footer.php"; ?>