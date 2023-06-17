<?php
require '../classes/Database.php';
require '../classes/Post.php';
require '../classes/Auth.php';

session_start();

$db = new Database();
$conn = $db->getConnMySQL();

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $post = Post::getPostByID($conn, $_GET['id']);
} else {
    $post = false;
}
?>
<?php require '../includes/header.php'; ?>

<?php if ($post === false) : ?>
<p>No posts found.</p>
<?php else : ?>
<ul>
    <li>
        <h2><?php echo $post->title; ?></h2>
        <p><?php echo $post->content; ?></p>
    </li>
</ul>
<?php if (Auth::isLoggedIn()):?>
<p><a href="edit-post.php?id=<?php echo  $post->id ?>">Edit Post</a></p>
<p><a href="delete-post.php?id=<?php echo  $post->id ?>">Delete Post</a></p>
<?php endif; ?>
<?php endif; ?>
<p><a href="index.php">Home</a></p>
<?php require '../includes/footer.php'; ?>