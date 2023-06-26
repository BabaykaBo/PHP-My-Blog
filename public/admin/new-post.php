<?php
require '../../includes/init.php';

require '../../includes/login-require.php';

$conn = require '../../includes/db.php';

$post = new Post();
$category_ids = [];
$categories = Category::getAll($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $post->title = $_POST['title'];
    $post->content = $_POST['content'];
    $post->published_at = $_POST['published_at'];

    $category_ids = $_POST['category'] ?? [];

    if ($post->create($conn)) {

        $post->setCategories($conn, $category_ids);

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