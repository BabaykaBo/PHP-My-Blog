<?php
require '../classes/Url.php';
require '../classes/User.php';
require '../classes/Database.php';

session_start();

$user = new User();
$user->username = '';
$errors = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = new Database();
    $conn = $db->getConnMySQL();

    $user->username = $_POST['username'];

    if (User::authenticate($conn, $_POST['username'], $_POST['password'])) {
        session_regenerate_id(true);

        $_SESSION['is_logged_in'] = true;

        Url::redirect('/');
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
    <label><input type="text" name="username" value="<?php echo htmlspecialchars($user->username); ?>" placeholder="Type username..."></label>
    <label><input type="password" name="password" placeholder="Type password..."></label>
    <button>Submit</button>
</form>
<p><a href="index.php">Cancel</a></p>
<?php require '../includes/footer.php' ?>