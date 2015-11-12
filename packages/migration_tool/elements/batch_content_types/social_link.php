<table class="migration-table table table-bordered table-striped">
    <thead>
    <tr>
        <th><?=t('Service')?></th>
        <th><?=t('URL')?></th>
    </tr>
    </thead>
    <tbody>
    <? foreach($collection->getLinks() as $link) {
        $validator = $link->getPublisherValidator();
        ?>
        <tr <? if ($validator->skipItem()) { ?>class="migration-item-skipped"<? } ?>>
            <td><?=$link->getService()?></td>
            <td><?=$link->getURL()?></td>
        </tr>
    <? } ?>
    </tbody>
</table>
