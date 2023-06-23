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

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $previous_image = $post->image_file;

    if ($post->setImageFile($conn, null)) {

        if ($previous_image) {
            unlink("../uploading/$previous_image");
        }

        Url::redirect("/admin/post.php?id={$post->id}");
    }
}

?>
<?php require "../../includes/header.php"; ?>

<?php if ($post->image_file) : ?>
    <img src="/uploading/<?php echo $post->image_file; ?>" alt='#'>
<?php endif; ?>

<h2>Delete Post image</h2>

<form method="post">
    <p>Are you sure?</p>
    <button>Delete</button>
</form>

<p><a href="post.php?id=<?php echo $post->id; ?>">Cancel</a></p>

<?php require "../../includes/footer.php"; ?>