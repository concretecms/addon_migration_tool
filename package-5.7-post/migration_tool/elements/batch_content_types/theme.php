<table class="migration-table table table-bordered table-striped">
    <thead>
    <tr>
        <th><?=t('Handle')?></th>
        <th><?=t('Activated')?></th>
    </tr>
    </thead>
    <tbody>
    <? foreach($collection->getThemes() as $theme) {
        $validator = $theme->getPublisherValidator();
        ?>
        <tr <? if ($validator->skipItem()) { ?>class="migration-item-skipped"<? } ?>>
            <td><?=$theme->getHandle()?></td>
            <td><?=$theme->getIsActivated() ? t("Yes") : t("No") ?></td>
        </tr>
    <? } ?>
    </tbody>
</table>
