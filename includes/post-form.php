<?php if (!empty($errors)) : ?>
<ul>
    <?php foreach ($errors as $error) : ?>
    <li><?php echo $error; ?></li>
    <?php endforeach; ?>
</ul>
<?php endif; ?>
<form action="" method="post">
    <div>
        <label>Title: <input type="text" name="title" value="<?php echo htmlspecialchars($post->title); ?>"
                placeholder="Post title..."></label>
    </div>
    <div>
        <label>Content: <textarea name="content" cols="30" rows="10"
                placeholder="Post content..."><?php echo htmlspecialchars($post->content); ?></textarea></label>
    </div>
    <div>
        <label>Publication date: <input type="datetime" name="published_at"
                value="<?php echo htmlspecialchars($post->published_at); ?>"
                placeholder="Example: 2022-12-23 12:12:12"></label>
    </div>
    <button>Save</button>
</form>