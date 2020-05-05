<?php

namespace Anax\View;

/**
 * Template file to render a view with content.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());
if (!$res) {
    return;
}
// var_dump($data);

?>
<table>
    <tr class="first">
        <th>Id</th>
        <th>Bild</th>
        <th>Titel</th>
        <th>År</th>
    </tr>
<?php $id = -1; foreach ($res as $row) :
    $id++; ?>
    <tr>
        <td><?= $row->id ?></td>
        <?php if ($check) : ?>
            <td><img class="thumb" src="../<?= $row->image ?>"></td>
        <?php else : ?>
            <td><img class="thumb" src="./<?= $row->image ?>"></td>
        <?php endif; ?>
        <!-- <?php var_dump($row->image); ?> -->
        <td><?= $row->title ?></td>
        <td><?= $row->year ?></td>
    </tr>
<?php endforeach; ?>
</table>
