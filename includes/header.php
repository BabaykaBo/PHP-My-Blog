<!doctype html>
<html lang="en">
<html>

<head>
    <meta charset="utf-8">
    <title>Blog</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/jquery.datetimepicker.min.css">
    <link rel="stylesheet" href="/css/styles.css">
</head>

<body>

    <div class="container">

        <header>
            <h1>My Blog</h1>

            <ul class="nav">
                <li class="nav-item"><a class="nav-link" href="/index.php">Home</a></li>
                <?php if (Auth::isLoggedIn()) : ?>

                    <li class="nav-item"><a class="nav-link" href="/admin/">Admin</a></li>
                    <li class="nav-item"><a class="nav-link" href="/admin/new-post.php">Add Post</a></li>
                    <li class="nav-item"><a class="nav-link" href="/logout.php">Log Out</a></li>

                <?php else : ?>

                    <li class="nav-item"><a class="nav-link" href="/login.php">Log In</a></li>

                <?php endif; ?>
            </ul>

        </header>
        <main>