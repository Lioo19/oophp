<?php
if (!$res) {
    return;
}
?>

<table>
    <tr class="first">
        <th>Id</th>
        <th>Title</th>
        <th>Type</th>
        <th>Published</th>
        <th>Created</th>
        <th>Updated</th>
        <th>Deleted</th>
        <th>Actions</th>
    </tr>
<?php $id = -1; foreach ($res as $row) :
    $id++; ?>
    <tr>
        <td><?= $row->id ?></td>
        <td><?= $row->title ?></td>
        <td><?= $row->type ?></td>
        <td><?= $row->published ?></td>
        <td><?= $row->created ?></td>
        <td><?= $row->updated ?></td>
        <td><?= $row->deleted ?></td>
        <td>
            <a href="edit?id=<?= esc($row->id) ?>" title="Edit this content">
                <i class="fa fa-pencil-square-o" aria-hidden="true">Edit</i>
            </a> /
            <a href="delete?id=<?= $row->id ?>" title="Delete this content">
                <i class="fa fa-trash-o" aria-hidden="true">Delete</i>
            </a>
        </td>
    </tr>
<?php endforeach; ?>
</table>
<div>
    <a class="button" href="create" title="create">Nytt Inlägg</a>
</div>
