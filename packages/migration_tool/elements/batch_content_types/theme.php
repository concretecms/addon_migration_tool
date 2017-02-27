<table class="migration-table table table-bordered table-striped">
    <thead>
    <tr>
        <th><?=t('Handle')?></th>
        <th><?=t('Activated')?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($collection->getThemes() as $theme) {
    $validator = $theme->getPublisherValidator();
    ?>
        <tr <?php if ($validator->skipItem()) {
    ?>class="migration-item-skipped"<?php 
}
    ?>>
            <td><?=$theme->getHandle()?></td>
            <td><?=$theme->getIsActivated() ? t("Yes") : t("No") ?></td>
        </tr>
    <?php 
} ?>
    </tbody>
</table>
