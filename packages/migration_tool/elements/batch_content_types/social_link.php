<table class="migration-table table table-bordered table-striped">
    <thead>
    <tr>
        <th><?=t('Service')?></th>
        <th><?=t('URL')?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($collection->getLinks() as $link) {
    $validator = $link->getPublisherValidator();
    ?>
        <tr <?php if ($validator->skipItem()) {
    ?>class="migration-item-skipped"<?php 
}
    ?>>
            <td><?=$link->getService()?></td>
            <td><?=$link->getURL()?></td>
        </tr>
    <?php 
} ?>
    </tbody>
</table>
