<?php
require '../../includes/init.php';
require '../../includes/login-require.php';
$conn = require '../../includes/db.php';

$posts = Post::getAll($conn);
?>

<?php require '../../includes/header.php'; ?>

<h2>Administration</h2>

<?php if (empty($posts)) : ?>
<p>No posts found.</p>
<?php else : ?>
<table>
    <thead>
        <th>Title</th>
    </thead>
    <tbody>
        <?php foreach ($posts as $post) : ?>
        <tr>
            <td>
                <a href="post.php?id=<?php echo $post['id']; ?>"><?php echo htmlspecialchars($post['title']); ?></a>
                </h2>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>
<?php require '../../includes/footer.php'; ?>