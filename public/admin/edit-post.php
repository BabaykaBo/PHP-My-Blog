<?php
require '../../includes/init.php';

require '../../includes/login-require.php';

$conn = require '../../includes/db.php';

if (isset($_GET['id'])) {
    $post = Post::getPostByID($conn, $_GET['id']);

    if (!$post) {
        die('No post found');
    }
} else {
    die('ID is not supplied. No post found');
}

$category_ids = array_column($post->getCategories($conn), 'id');
$categories = Category::getAll($conn);


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $post->title = $_POST['title'];
    $post->content = $_POST['content'];
    $post->published_at = $_POST['published_at'];

    $category_ids = $_POST['category'] ?? [];

    if ($post->update($conn)) {

        $post->setCategories($conn, $category_ids);
        
        Url::redirect("/admin/post.php?id={$post->id}");
    }
}
?>
<?php require "../../includes/header.php"; ?>
<h2>Edit Post</h2>
<?php require '../../includes/post-form.php'; ?>

<br>

<p><a href="post.php?id=<?php echo $post->id; ?>">Cancel</a></p>

<?php require "../../includes/footer.php"; ?>