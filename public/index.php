<?php
require '../includes/database.php';
require '../includes/auth.php';

session_start();

$conn = getDB();

$sql = "SELECT *
        FROM post
        ORDER BY published_at;";

$result = mysqli_query($conn, $sql);

if ($result === false) {
    echo mysqli_error($conn);
    exit;
} else {
    $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
}
?>

<?php require '../includes/header.php'; ?>
<?php if (isLoggedIn()): ?>
<p>You are logged in. <a href="logout.php">Log Out</a></p>
<?php else: ?>
<p>You are not logged in. <a href="login.php">Log In</a></p>
<?php endif; ?>
<br>
<div><a href="new-post.php">Add Post</a></div>
<br>
<?php if (empty($posts)) : ?>
<p>No posts found.</p>
<?php else : ?>
<ul>
    <?php foreach ($posts as $post) : ?>
    <li>
        <h2><a href="post.php?id=<?php echo $post['id']; ?>"><?php echo htmlspecialchars($post['title']); ?></a></h2>
        <p>
            <?php 
                    $content = substr($post['content'], 0, 100) . '...';
                    echo htmlspecialchars($content); 
                    ?>
        </p>
    </li>
    <?php endforeach; ?>
</ul>
<?php endif; ?>
<?php require '../includes/footer.php'; ?>