<table class="migration-table table table-bordered table-striped">
    <thead>
    <tr>
        <th><?=t('Name')?></th>
        <th><?=t('Categories')?></th>
    </tr>
    </thead>
    <tbody>
    <? foreach($collection->getSets() as $set) {
    $validator = $set->getPublisherValidator();
    ?>
    <tr <? if ($validator->skipItem()) { ?>class="migration-item-skipped"<? } ?>>
        <td><?=$set->getName()?></td>
        <td><?=implode(', ', $set->getJobs())?></td>
        <? } ?>
    </tbody>
</table>