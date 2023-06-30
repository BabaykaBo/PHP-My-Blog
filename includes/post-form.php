<?php if (!empty($post->errors)) : ?>
<ul>
    <?php foreach ($post->errors as $error) : ?>
    <li><?php echo $error; ?></li>
    <?php endforeach; ?>
</ul>
<?php endif; ?>
<form action="" method="post" id="post-form">
    <div class="mb-3">
        <label class="form-label">Title: <input class="form-control" type="text" name="title" value="<?php echo htmlspecialchars($post->title); ?>"
                placeholder="Post title..."></label>
    </div>
    <div class="mb-3">
        <label class="form-label">Content: <textarea class="form-control" name="content" cols="30" rows="10"
                placeholder="Post content..."><?php echo htmlspecialchars($post->content); ?></textarea></label>
    </div>
    <div class="mb-3">
        <label class="form-label">Publication date: <input class="form-control" id="published_at" name="published_at"
                value="<?php echo htmlspecialchars($post->published_at); ?>"
                placeholder="Example: 2022-12-23 12:12:12"></label>
    </div>

    <fieldset>
        <legend>Categories</legend>

        <?php foreach ($categories as $category) : ?>
        <div>
            <input class="form-check-input" type="checkbox" id='category<?php echo $category['id']; ?>' name="category[]"
                value="<?php echo $category['id'] ?>"
                <?php if (in_array($category['id'], $category_ids)):?>checked<?php endif; ?>>
            <label class="form-check-label" for='category<?php echo $category['id'] ?>'><?php echo htmlspecialchars($category['name']); ?></label>
        </div>
        <?php endforeach; ?>
    </fieldset>

    <button class="btn btn-primary">Save</button>
</form>