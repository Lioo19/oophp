<?php
if (!$res) {
    return;
}
?>

<article>

<?php foreach ($res as $row) : ?>
    <!-- <?php var_dump($row->data); ?> -->
<section>
    <header>
        <!-- <?php print_r($row->slug) ?> -->
        <?php if ($row->path): ?>
            <h1><a href="blogpost?slug=<?= esc($row->slug) ?>"><?= esc($row->title) ?></a></h1>
            <!-- <h1><a href="?route=blog/<?= esc($row->slug) ?>"><?= esc($row->title) ?></a></h1> -->
            <p><i>Published: <time datetime="<?= esc($row->published_iso8601) ?>" pubdate><?= esc($row->published) ?></time></i></p>
        <?php endif; ?>
    </header>
    <?= $row->data ?>
</section>
<?php endforeach; ?>

</article>
