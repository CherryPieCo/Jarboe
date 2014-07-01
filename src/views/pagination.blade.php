<?php
    $presenter = new Illuminate\Pagination\BootstrapPresenter($paginator);
?>

<?php if ($paginator->getLastPage() > 1): ?>
    <ul class="pagination alternate">
        <?php echo $presenter->render(); ?>
    </ul>
<?php endif; ?>