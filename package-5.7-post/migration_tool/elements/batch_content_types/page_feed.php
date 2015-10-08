<table class="migration-table table table-bordered table-striped">
    <thead>
    <tr>
        <th><?=t('Handle')?></th>
        <th style="width: 100%"><?=t('Title')?></th>
    </tr>
    </thead>
    <tbody>
    <? foreach($collection->getFeeds() as $feed) {
        $validator = $feed->getPublisherValidator();
    ?>
    <tr <? if ($validator->skipItem()) { ?>class="migration-item-skipped"<? } ?>>
        <td><?=$feed->getHandle()?></td>
        <td><?=$feed->getTitle()?></td>
    <? } ?>
    </tbody>
</table>
