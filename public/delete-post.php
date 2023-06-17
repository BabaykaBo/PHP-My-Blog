<?php
require '../includes/init.php';

require '../includes/login-require.php';

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


    if ($post->delete($conn)) {

        Url::redirect("/index.php");
        
    }
}
?>

<?php require '../includes/header.php'; ?>
<h2>Delete Post</h2>
<p>Do you want to delete the post "<?php echo $post->title; ?>"?</p>
<p>
<form method="post">
    <button>Yes</button>
</form>
</p>
<p><a href="post.php?id=<?php echo $post->id; ?>">Cancel</a></p>
<?php require '../includes/footer.php' ?>