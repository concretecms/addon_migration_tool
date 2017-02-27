<?php defined('C5_EXECUTE') or die('Access Denied.');
$dh = Core::make('helper/date');
/* @var \Concrete\Core\Localization\Service\Date $dh */
?>
<div class="ccm-dashboard-header-buttons">
    <a href="<?=$view->action('view_batch', $batch->getID())?>" class="btn btn-default"><i class="fa fa-angle-double-left"></i> <?=t('Back to Batch')?></a>
</div>


<h2><?=t('Batch')?>
    <small><?=$dh->formatDateTime($batch->getDate(), true)?></small></h2>

<h3><?=$mapper->getMappedItemPluralName()?></h3>

<?php if (count($items)) {
    ?>

    <form method="post" action="<?=$view->action('save_mapping')?>">
        <?=$token->output('save_mapping')?>
        <?=$form->hidden('id', $batch->getID())?>
        <?=$form->hidden('mapper', $mapper->getHandle())?>

        <table class="table table-striped">
        <thead>
        <tr>
            <th style="white-space: nowrap"><?=t('Batch Item')?></th>
            <th style="width: 100%"><?=t('Maps To')?></th>
        </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item) {
    $selectedTargetItem = $targetItemList->getSelectedTargetItem($item);
    ?>
            <tr>
                <td style="white-space: nowrap; vertical-align: middle"><?=$item->getDisplayName()?></td>
                <td>
                    <select name="targetItem[<?=$item->getIdentifier()?>]" class="form-control">
                        <?php foreach ($targetItemList->getInternalTargetItems() as $targetItem) {
    ?>
                            <option <?php if (is_object($selectedTargetItem) && $selectedTargetItem->matches($targetItem)) {
    ?>selected="selected" <?php 
}
    ?> value="<?=$targetItem->getItemID()?>"><?=$targetItem->getItemName()?></option>
                        <?php 
}
    ?>

        <?php if (count($targetItemList->getMapperCorePropertyTargetItems())) {
    ?>
            <optgroup label="** <?=t('Installed %s', $mapper->getMappedItemPluralName())?>"></optgroup>
            <?php foreach ($targetItemList->getMapperCorePropertyTargetItems() as $targetItem) {
    ?>
                <option <?php if (is_object($selectedTargetItem) && $selectedTargetItem->matches($targetItem)) {
    ?>selected="selected" <?php

}
    ?> value="<?=$targetItem->getItemID()?>"><?=$targetItem->getItemName()?></option>
                <?php

}
}
    ?>


            <?php if (count($targetItemList->getMapperInstalledTargetItems())) {
    ?>
                            <optgroup label="** <?=t('Installed %s', $mapper->getMappedItemPluralName())?>"></optgroup>
                            <?php foreach ($targetItemList->getMapperInstalledTargetItems() as $targetItem) {
    ?>
                                <option <?php if (is_object($selectedTargetItem) && $selectedTargetItem->matches($targetItem)) {
    ?>selected="selected" <?php 
}
    ?> value="<?=$targetItem->getItemID()?>"><?=$targetItem->getItemName()?></option>
                            <?php 
}
    ?>
                        <?php 
}
    ?>
                        <?php if (count($targetItemList->getMapperBatchTargetItems())) {
    ?>
                            <optgroup label="** <?=t('Batch %s', $mapper->getMappedItemPluralName())?>"></optgroup>
                            <?php foreach ($targetItemList->getMapperBatchTargetItems() as $targetItem) {
    ?>
                                <option <?php if (is_object($selectedTargetItem) && $selectedTargetItem->matches($targetItem)) {
    ?>selected="selected" <?php 
}
    ?> value="<?=$targetItem->getItemID()?>"><?=$targetItem->getItemName()?></option>
                            <?php 
}
    ?>
                        <?php 
}
    ?>
                    </select>
                </td>
            </tr>
            <?php 
}
    ?>
        </tbody>
        </table>
        <div class="ccm-dashboard-form-actions-wrapper">
            <div class="ccm-dashboard-form-actions">
                <a href="<?=$view->action('view_batch', $batch->getID())?>" class="btn btn-default"><?=t('Cancel')?></a>
                <button class="pull-right btn btn-primary" type="submit"><?=t('Save')?></button>
            </div>
        </div>
    </form>

<?php 
} else {
    ?>
    <p><?=t('No items of the selected type found in the batch.')?></p>
<?php 
} ?>