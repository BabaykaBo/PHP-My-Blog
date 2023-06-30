<?php if (!empty($post->errors)) : ?>
<ul>
    <?php foreach ($post->errors as $error) : ?>
    <li><?php echo $error; ?></li>
    <?php endforeach; ?>
</ul>
<?php endif; ?>
<form action="" method="post" id="post-form">
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

    <fieldset>
        <legend>Categories</legend>

        <?php foreach ($categories as $category) : ?>
        <div>
            <input type="checkbox" id='category<?php echo $category['id']; ?>' name="category[]"
                value="<?php echo $category['id'] ?>"
                <?php if (in_array($category['id'], $category_ids)):?>checked<?php endif; ?>>
            <label for='category<?php echo $category['id'] ?>'><?php echo htmlspecialchars($category['name']); ?></label>
        </div>
        <?php endforeach; ?>
    </fieldset>

    <button>Save</button>
</form>