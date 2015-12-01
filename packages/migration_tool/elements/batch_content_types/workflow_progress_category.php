<table class="migration-table table table-bordered table-striped">
    <thead>
    <tr>
        <th><?=t('Handle')?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($collection->getCategories() as $category) {
    $validator = $category->getPublisherValidator();
    ?>
    <tr <?php if ($validator->skipItem()) {
    ?>class="migration-item-skipped"<?php 
}
    ?>>
        <td><?=$category->getHandle()?></td>
    <?php 
} ?>
    </tbody>
</table>
