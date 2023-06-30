<?php
require '../includes/init.php';

$conn = require '../includes/db.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $post = Post::getWithCategories($conn, $_GET['id'], true);
} else {
    $post = false;
}
?>
<?php require '../includes/header.php'; ?>

<?php if ($post === false || empty($post)) : ?>
<p>No posts found.</p>
<?php else : ?>

<article>

    <?php if ($post[0]['category_name']) : ?>

    <p>
        Category:
        <?php foreach ($post as $p) : ?>
        <?php echo $p['category_name'] . ';'; ?>
        <?php endforeach; ?>
    </p>

    <?php endif; ?>

    <h2><?php echo htmlspecialchars($post[0]['title']); ?></h2>

    <time datetime="<?php echo $post[0]['published_at']; ?>"><?php
        $datetime = new DateTime($post[0]["published_at"]);
        echo $datetime->format("j F, Y");
    ?></time>

    <?php if ($post[0]['image_file']) : ?>
    <img src="/uploading/<?php echo $post[0]['image_file']; ?>" alt='#'>

    <?php if (Auth::isLoggedIn()) : ?>
    <p><a class="delete" href="admin/delete-post-image.php?id=<?php echo  $_GET['id'] ?>">Delete Post Image</a></p>
    <?php endif; ?>

    <?php endif; ?>

    <p><?php echo htmlspecialchars($post[0]['content']); ?></p>

</article>


<?php if (Auth::isLoggedIn()) : ?>

<p><a href="admin/edit-post.php?id=<?php echo  $_GET['id'] ?>">Edit Post</a></p>
<p><a href="admin/edit-post-image.php?id=<?php echo  $_GET['id'] ?>">Edit Post Image</a></p>
<p><a class="delete" href="admin/delete-post.php?id=<?php echo  $_GET['id'] ?>">Delete Post</a></p>
<?php endif; ?>

<?php endif; ?>

<?php require '../includes/footer.php'; ?>