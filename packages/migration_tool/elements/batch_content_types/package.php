<table class="migration-table table table-bordered table-striped">
    <thead>
    <tr>
        <th><?=t('Handle')?></th>
\    </tr>
    </thead>
    <tbody>
    <?php foreach ($collection->getPackages() as $pkg) {
    $validator = $pkg->getPublisherValidator();
    ?>
    <tr <?php if ($validator->skipItem()) {
    ?>class="migration-item-skipped"<?php 
}
    ?>>
        <td><?=$pkg->getHandle()?></td>
    <?php 
} ?>
    </tbody>
</table>
