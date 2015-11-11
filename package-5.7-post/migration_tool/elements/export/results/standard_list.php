<?
defined('C5_EXECUTE') or die(_("Access Denied."));
?>
<? if (count($results)) { ?>

<table class="migration-table table table-bordered table-striped">
    <thead>
    <tr>
        <th><input type="checkbox" data-action="select-all"></th>
        <? foreach($headers as $header) { ?>
            <th><?=$header?></th>
        <? } ?>
    </tr>
    </thead>
    <tbody>
    <? foreach($results as $result) {
        /** @var $result PortlandLabs\Concrete5\MigrationTool\Entity\Export\ExportItem */?>
    <tr>
        <td style="width: 30px">
            <input <? if ($mode == 'search' && is_object($collection) && $collection->contains($result)) { ?>disabled<? } ?> data-checkbox="batch-item" type="checkbox" name="id[<?=$type->getHandle()?>][]" value="<?=$result->getItemIdentifier()?>">
        </td>
        <? foreach($type->getResultColumns($result) as $column) { ?>
            <td><?=$column?></td>
        <? } ?>
    </tr>
    <? } ?>
    </tbody>
</table>

<? } else { ?>

    <p><?=t('No results found.')?></p>

<? } ?>