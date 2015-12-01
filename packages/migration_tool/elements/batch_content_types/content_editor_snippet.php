<table class="migration-table table table-bordered table-striped">
    <thead>
    <tr>
        <th><?=t('Handle')?></th>
        <th><?=t('Name')?></th>
        <th><?=t('Activated')?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($collection->getSnippets() as $snippet) {
    $validator = $snippet->getPublisherValidator();
    ?>
        <tr <?php if ($validator->skipItem()) {
    ?>class="migration-item-skipped"<?php 
}
    ?>>
            <td><?=$snippet->getHandle()?></td>
            <td><?=$snippet->getName()?></td>
            <td><?=$snippet->getIsActivated() ? t("Yes") : t("No") ?></td>
        </tr>
    <?php 
} ?>
    </tbody>
</table>
