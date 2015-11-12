<table class="migration-table table table-bordered table-striped">
    <thead>
    <tr>
        <th><?=t('Handle')?></th>
\    </tr>
    </thead>
    <tbody>
    <? foreach($collection->getPackages() as $pkg) {
        $validator = $pkg->getPublisherValidator();
    ?>
    <tr <? if ($validator->skipItem()) { ?>class="migration-item-skipped"<? } ?>>
        <td><?=$pkg->getHandle()?></td>
    <? } ?>
    </tbody>
</table>
