<?php
require '../includes/init.php';

$conn = require '../includes/db.php';

$paginator = new Paginator($_GET['page'] ?? 1, 4);

$posts = Post::getPage($conn, $paginator->limited, $paginator->offset);
?>

<?php require '../includes/header.php'; ?>

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