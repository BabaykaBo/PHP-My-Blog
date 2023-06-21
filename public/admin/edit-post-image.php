<?php
require '../../includes/init.php';

require '../../includes/login-require.php';

$conn = require '../../includes/db.php';

if (isset($_GET['id'])) {
    $post = Post::getPostByID($conn, $_GET['id']);

    if (!$post) {
        die('No post found');
    }
} else {
    die('ID is not supplied. No post found');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    try {

        if (empty($_FILES)) {
            throw new Exception('Invalid upload');
        }

        switch ($_FILES['file']['error']) {

            case UPLOAD_ERR_OK:
                break;

            case UPLOAD_ERR_NO_FILE:
                throw new Exception('No file uploaded!');
                break;
            
                case UPLOAD_ERR_INI_SIZE:
                throw new Exception('Too big file size!');
                break;
            
                default:
                throw new Exception('An error ocurred!');
        }

        $mime_types = ['image/gif', 'image/png', 'image/jpeg'];

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $_FILES['file']['tmp_name']);

        if ( ! in_array($mime_type, $mime_types)){
            throw new Exception('Invalid file type!');
        }

        finfo_close($finfo);

    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
?>
<?php require "../../includes/header.php"; ?>

<h2>Edit Post image</h2>

<form method="post" enctype="multipart/form-data">

    <label><input type="file" name="file"></label>
    <p><button>Upload</button></p>
</form>

<p><a href="post.php?id=<?php echo $post->id; ?>">Cancel</a></p>

<?php require "../../includes/footer.php"; ?>