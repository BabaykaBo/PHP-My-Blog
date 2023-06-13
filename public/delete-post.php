<?php
require '../includes/database.php';
require '../includes/posts.php';
require '../includes/url.php';
require '../includes/auth.php';

session_start();

if (! isLoggedIn()){
    redirect('/login.php');
}

$conn = getDB();

if (isset($_GET['id'])) {

    $post = getPost($conn, $_GET['id'], ['id', 'title']);

    if ($post) {
        $id = $post['id'];
        $title = $post['title'];
    } else {
        die('No post found');
    }
} else {
    die('ID is not supplied. No post found');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "DELETE FROM post 
        WHERE id = ? ";

    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt === false) {
        echo mysqli_error($conn);
    } else {
        mysqli_stmt_bind_param(
            $stmt,
            "i",
            $id,
        );

        if (mysqli_stmt_execute($stmt)) {

            redirect("/index.php");
        } else {
            echo mysqli_stmt_error($stmt);
        }
    }
}
?>

<?php require '../includes/header.php'; ?>
<h2>Delete Post</h2>
<p>Do you want to delete the post "<?php echo $title; ?>"?</p>
<p>
<form method="post">
    <button>Yes</button>
</form>
</p>
<p><a href="post.php?id=<?php echo $id; ?>">Cancel</a></p>
<?php require '../includes/footer.php' ?>