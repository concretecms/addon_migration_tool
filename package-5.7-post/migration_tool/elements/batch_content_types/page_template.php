<table class="table table-bordered table-striped">
    <thead>
    <tr>
        <th><?=t('Handle')?></th>
        <th style="width: 100%"><?=t('Name')?></th>
        <th><?=t('Icon')?></th>
    </tr>
    </thead>
    <tbody>
    <? foreach($collection->getTemplates() as $template) { ?>
    <tr>
        <td><?=$template->getHandle()?></td>
        <td><?=$template->getName()?></td>
        <td><?=$template->getIcon()?></td>
    <? } ?>
    </tbody>
</table>
