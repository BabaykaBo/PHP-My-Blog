<?php
require '../includes/init.php';

$user = new User();
$user->username = '';
$errors = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $conn = require '../includes/db.php';

    $user->username = $_POST['username'];

    if (User::authenticate($conn, $_POST['username'], $_POST['password'])) {

        Auth::login();

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
    <div class="form-group">
        <label class="form-label">Username
            <input class="form-control" type="text" name="username" value="<?php echo htmlspecialchars($user->username); ?>"
                placeholder="Type username...">
            </label>
    </div>

    <div class="form-group">
        <label class="form-label">Password
            <input class="form-control" type="password" name="password" placeholder="Type password...">
        </label>
    </div>
    
        <button class="btn btn-primary">Submit</button>
</form>

<?php require '../includes/footer.php' ?>