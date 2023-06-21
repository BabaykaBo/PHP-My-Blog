<nav>
    <ul>
        <li>
            <?php if ($paginator->previous) : ?>
                <a href="?page=<?php echo $paginator->previous; ?>">Previous Page</a>
            <?php else : ?>
                Previous Page
            <?php endif; ?>
        </li>
        <li>
            <?php if ($paginator->next) : ?>
                <a href="?page=<?php echo $paginator->next; ?>">Next Page</a>
            <?php else : ?>
                Next Page
            <?php endif; ?>
        </li>
    </ul>
</nav>