<table class="table table-bordered table-striped">
    <thead>
    <tr>
        <th><?=t('Handle')?></th>
    </tr>
    </thead>
    <tbody>
    <? foreach($collection->getKeys() as $key) {
        $validator = $key->getPublisherValidator();
    ?>
    <tr <? if ($validator->skipItem()) { ?>class="migration-item-skipped"<? } ?>>
        <td><?=$key->getHandle()?></td>
    <? } ?>
    </tbody>
</table>
