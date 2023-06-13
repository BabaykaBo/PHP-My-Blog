<?php
require '../includes/database.php';
require '../includes/posts.php';
require '../includes/auth.php';

session_start();

$conn = getDB();

if (isset($_GET['id'])) {

    $post = getPost($conn, $_GET['id']);
} else {
    $post = null;
}
?>
<?php require '../includes/header.php'; ?>

<?php if (is_null($post)) : ?>
<p>No posts found.</p>
<?php else : ?>
<ul>
    <li>
        <h2><?php echo $post['title']; ?></h2>
        <p><?php echo $post['content']; ?></p>
    </li>
</ul>
<?php endif; ?>
<?php if (isLoggedIn()):?>
<p><a href="edit-post.php?id=<?php echo  $_GET['id'] ?>">Edit Post</a></p>
<p><a href="delete-post.php?id=<?php echo  $_GET['id'] ?>">Delete Post</a></p>
<?php endif; ?>
<p><a href="index.php">Home</a></p>
<?php require '../includes/footer.php'; ?>