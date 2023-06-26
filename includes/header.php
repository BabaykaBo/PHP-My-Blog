<!DOCTYPE html>
<html lang="en">
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Blog</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
    <header>
        <h1>My Blog</h1>
        
        <ul>
                <li><a href="/index.php">Home</a></li>
            <?php if (Auth::isLoggedIn()): ?>

                <li><a href="/admin/">Admin</a></li>
                <li><a href="/admin/new-post.php">Add Post</a></li>
                <li><a href="/logout.php">Log Out</a></li>

            <?php else: ?>

                <li><a href="/login.php">Log In</a></li>
                
            <?php endif; ?>
        </ul>

    </header>
    <main>