<table class="migration-table table table-bordered table-striped">
    <thead>
    <tr>
        <th><?=t('Name')?></th>
        <th><?=t('Path')?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($collection->getGroups() as $group) {
    $validator = $group->getPublisherValidator();
    ?>
    <tr <?php if ($validator->skipItem()) {
    ?>class="migration-item-skipped"<?php 
}
    ?>>
        <td><?=$group->getName()?></td>
        <td><?=$group->getPath()?></td>
    <?php
} ?>
    </tbody>
</table>
