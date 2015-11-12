<table class="migration-table table table-bordered table-striped">
    <thead>
    <tr>
        <th><?=t('Library')?></th>
    </tr>
    </thead>
    <tbody>
    <? foreach($collection->getLibraries() as $library) {
        $validator = $library->getPublisherValidator();
        ?>
        <tr <? if ($validator->skipItem()) { ?>class="migration-item-skipped"<? } ?>>
            <td><?=$library->getHandle()?></td>
        </tr>
    <? } ?>
    </tbody>
</table>
