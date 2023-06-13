<?php
require '../includes/url.php';
session_start();

$username = '';
$errors = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];

    if ($_POST['username'] == 'oleh' && $_POST['password'] == 'secret') {
        session_regenerate_id(true);
        $_SESSION['is_logged_in'] = true;
        redirect('/');
    } else {
        $errors = true;
    }
}

?>
<?php require '../includes/header.php' ?>
<?php if ($errors) : ?>
<p>Incorrect data!</p>
<?php endif; ?>
<form method="post">
    <label><input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>"
            placeholder="Type username..."></label>
    <label><input type="password" name="password" placeholder="Type password..."></label>
    <button>Submit</button>
</form>
<p><a href="index.php">Cancel</a></p>
<?php require '../includes/footer.php' ?>