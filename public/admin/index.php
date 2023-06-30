<?php
require '../../includes/init.php';
require '../../includes/login-require.php';
$conn = require '../../includes/db.php';

$paginator = new Paginator($_GET['page'] ?? 1, 6, Post::getTotal($conn));

$posts = Post::getPage($conn, $paginator->limited, $paginator->offset);
?>

<?php require '../../includes/header.php'; ?>

<h2>Administration</h2>

<?php if (empty($posts)) : ?>
    <p>No posts found.</p>
<?php else : ?>
    <table>
        <thead>
            <th>Title</th>
            <th>Published</th>
        </thead>
        <tbody>
            <?php foreach ($posts as $post) : ?>
                <tr>
                    <td>
                        <a href="post.php?id=<?php echo $post['id']; ?>"><?php echo htmlspecialchars($post['title']); ?></a>
                    </td>

                    <td>
                        <?php if ($post['published_at']) : ?>
                            <time><?php echo htmlspecialchars($post['published_at']); ?></time>
                        <?php else : ?>
                            Unpublished
                            <button id="publish" data-id="<?php echo $post['id']; ?>">Publish</button>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php require '../../includes/pagination.php'; ?>

<?php endif; ?>

<?php require '../../includes/footer.php'; ?>