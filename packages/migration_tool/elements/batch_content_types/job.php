<table class="migration-table table table-bordered table-striped">
    <thead>
    <tr>
        <th><?=t('Handle')?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($collection->getJobs() as $job) {
    $validator = $job->getPublisherValidator();
    ?>
    <tr <?php if ($validator->skipItem()) {
    ?>class="migration-item-skipped"<?php 
}
    ?>>
        <td><?=$job->getHandle()?></td>
    <?php 
} ?>
    </tbody>
</table>
