<?php
if (!$res) {
    return;
}
?>

<article>

<?php foreach ($res as $row) : ?>
<section>
    <header>
        <h1><a href="?route=blog/<?= esc($row->slug) ?>"><?= esc($row->title) ?></a></h1>
        <p><i>Published: <time datetime="<?= esc($row->published_iso8601) ?>" pubdate><?= esc($row->published) ?></time></i></p>
    </header>
    <?= esc($row->data) ?>
</section>
<?php endforeach; ?>

</article>
