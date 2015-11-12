<table class="migration-table table table-bordered table-striped">
    <thead>
    <tr>
        <th><?=t('Key')?></th>
        <th><?=t('Value')?></th>
    </tr>
    </thead>
    <tbody>
    <? foreach($collection->getValues() as $config) {
        $validator = $config->getPublisherValidator();
    ?>
    <tr <? if ($validator->skipItem()) { ?>class="migration-item-skipped"<? } ?>>
        <td><?=$config->getConfigKey()?></td>
        <td><?=$config->getConfigValue()?></td>
    <? } ?>
    </tbody>
</table>
