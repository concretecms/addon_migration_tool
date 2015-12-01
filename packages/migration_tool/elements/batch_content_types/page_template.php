<table class="migration-table table table-bordered table-striped">
    <thead>
    <tr>
        <th><?=t('Handle')?></th>
        <th style="width: 100%"><?=t('Name')?></th>
        <th><?=t('Icon')?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($collection->getTemplates() as $template) {
    $validator = $template->getPublisherValidator();
    ?>
    <tr <?php if ($validator->skipItem()) {
    ?>class="migration-item-skipped"<?php 
}
    ?>>
        <td><?=$template->getHandle()?></td>
        <td><?=$template->getName()?></td>
        <td><?=$template->getIcon()?></td>
    <?php 
} ?>
    </tbody>
</table>
