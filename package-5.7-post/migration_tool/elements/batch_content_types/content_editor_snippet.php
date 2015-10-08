<table class="migration-table table table-bordered table-striped">
    <thead>
    <tr>
        <th><?=t('Handle')?></th>
        <th><?=t('Name')?></th>
        <th><?=t('Activated')?></th>
    </tr>
    </thead>
    <tbody>
    <? foreach($collection->getSnippets() as $snippet) {
        $validator = $snippet->getPublisherValidator();
        ?>
        <tr <? if ($validator->skipItem()) { ?>class="migration-item-skipped"<? } ?>>
            <td><?=$snippet->getHandle()?></td>
            <td><?=$snippet->getName()?></td>
            <td><?=$snippet->getIsActivated() ? t("Yes") : t("No") ?></td>
        </tr>
    <? } ?>
    </tbody>
</table>
