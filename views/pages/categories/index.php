<?php
/**
 * @var \App\Kernel\View\ViewInterface $view
 * @var array<\App\Models\Category> $categories
 */
?>

<?php $view->component('start'); ?>

<main>

    <div class="container">
        <h3 class="mt-3">Жанры</h3>
        <hr>
        <div class="movies">
            <?php foreach ($categories as $category) { ?>
                <a href="/categories/category?id=<?php echo $category->id() ?>" class="card text-decoration-none movies__item">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $category->name() ?></h5>
                        <p class="card-text">Фильмов <span class="badge bg-info warn__badge"><?php echo $category->moviesCount() ?></span></p>
                    </div>
                </a>
            <?php } ?>
        </div>
    </div>
</main>


<?php $view->component('end'); ?>

