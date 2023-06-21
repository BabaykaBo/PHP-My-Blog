<?php
require '../../includes/init.php';

require '../../includes/login-require.php';

$post = new Post();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $conn = require '../../includes/db.php';
    
    $post->title = $_POST['title'];
    $post->content = $_POST['content'];
    $post->published_at = $_POST['published_at'];

    if ($post->create($conn)) {

        Url::redirect("/admin/post.php?id={$post->id}");
    }
}

?>
<?php require "../../includes/header.php"; ?>

<h2>New Post</h2>

<?php require '../../includes/post-form.php'; ?>

<br>

<div><a href="/admin/">Cancel</a></div>

<?php require "../../includes/footer.php"; ?>