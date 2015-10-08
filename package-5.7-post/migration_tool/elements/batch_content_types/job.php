<table class="migration-table table table-bordered table-striped">
    <thead>
    <tr>
        <th><?=t('Handle')?></th>
    </tr>
    </thead>
    <tbody>
    <? foreach($collection->getJobs() as $job) {
        $validator = $job->getPublisherValidator();
    ?>
    <tr <? if ($validator->skipItem()) { ?>class="migration-item-skipped"<? } ?>>
        <td><?=$job->getHandle()?></td>
    <? } ?>
    </tbody>
</table>
