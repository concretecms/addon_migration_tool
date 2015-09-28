<table class="table table-bordered table-striped">
    <thead>
    <tr>
        <th><?=t('Handle')?></th>
    </tr>
    </thead>
    <tbody>
    <? foreach($collection->getTypes() as $type) {
        $validator = $type->getPublisherValidator();
    ?>
    <tr <? if ($validator->skipItem()) { ?>class="migration-item-skipped"<? } ?>>
        <td><?=$type->getHandle()?></td>
    <? } ?>
    </tbody>
</table>
