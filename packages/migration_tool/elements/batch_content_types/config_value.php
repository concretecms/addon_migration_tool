<table class="migration-table table table-bordered table-striped">
    <thead>
    <tr>
        <th><?=t('Key')?></th>
        <th><?=t('Value')?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($collection->getValues() as $config) {
    $validator = $config->getPublisherValidator();
    ?>
    <tr <?php if ($validator->skipItem()) {
    ?>class="migration-item-skipped"<?php 
}
    ?>>
        <td><?=$config->getConfigKey()?></td>
        <td><?=$config->getConfigValue()?></td>
    <?php 
} ?>
    </tbody>
</table>
