<table class="migration-table table table-bordered table-striped">
    <thead>
    <tr>
        <th><?=t('Name')?></th>
        <th><?=t('Categories')?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($collection->getSets() as $set) {
    $validator = $set->getPublisherValidator();
    ?>
    <tr <?php if ($validator->skipItem()) {
    ?>class="migration-item-skipped"<?php 
}
    ?>>
        <td><?=$set->getName()?></td>
        <td><?=implode(', ', $set->getJobs())?></td>
        <?php 
} ?>
    </tbody>
</table>