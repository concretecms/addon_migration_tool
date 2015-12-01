<table class="migration-table table table-bordered table-striped">
    <thead>
    <tr>
        <th><?=t('Library')?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($collection->getLibraries() as $library) {
    $validator = $library->getPublisherValidator();
    ?>
        <tr <?php if ($validator->skipItem()) {
    ?>class="migration-item-skipped"<?php 
}
    ?>>
            <td><?=$library->getHandle()?></td>
        </tr>
    <?php 
} ?>
    </tbody>
</table>
