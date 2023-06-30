<?php 
require '../../includes/init.php';
require '../../includes/login-require.php';

$conn = require '../../includes/db.php';

$post = Post::getPostByID($conn, $_POST['id']);

$published_at = $post->publish($conn);
?>

<time><?php echo htmlspecialchars($published_at); ?></time>