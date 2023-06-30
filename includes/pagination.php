<nav>
    <ul class="pagination">
        <li class="page-item">
            <?php if ($paginator->previous) : ?>
                <a class="page-link" href="?page=<?php echo $paginator->previous; ?>">Previous Page</a>
            <?php else : ?>
                <span class="page-link  disabled">Previous Page</span>
            <?php endif; ?>
        </li>
        <li class="page-item">
            <?php if ($paginator->next) : ?>
                <a class="page-link" href="?page=<?php echo $paginator->next; ?>">Next Page</a>
            <?php else : ?>
                <span class="page-link  disabled">Next Page</span>
            <?php endif; ?>
        </li>
    </ul>
</nav>