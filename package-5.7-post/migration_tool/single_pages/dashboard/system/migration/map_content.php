<? defined('C5_EXECUTE') or die("Access Denied."); ?>
<div class="ccm-dashboard-header-buttons">
    <a href="<?=$view->action('view_batch', $batch->getID())?>" class="btn btn-default"><i class="fa fa-angle-double-left"></i> <?=t('Batch to Batch')?></a>
</div>


<h2><?=t('Batch')?>
    <small><?=$batch->getDate()->format('F d, Y g:i a')?></small></h2>

<h3><?=$mapper->getMappedItemPluralName()?></h3>

<? if (count($items)) { ?>

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
            <? foreach($items as $item) {
                $selectedTargetItem = $targetItemList->getSelectedTargetItem($item);
                ?>
            <tr>
                <td style="white-space: nowrap; vertical-align: middle"><?=$item->getDisplayName()?></td>
                <td>
                    <select name="targetItem[<?=$item->getIdentifier()?>]" class="form-control">
                        <? foreach($targetItemList->getInternalTargetItems() as $targetItem) { ?>
                            <option <? if (is_object($selectedTargetItem) && $selectedTargetItem->matches($targetItem)) { ?>selected="selected" <? } ?> value="<?=$targetItem->getItemID()?>"><?=$targetItem->getItemName()?></option>
                        <? } ?>
                        <optgroup label="** <?=$mapper->getMappedItemPluralName()?>"></optgroup>
                        <? foreach($targetItemList->getMapperTargetItems() as $targetItem) { ?>
                            <option <? if (is_object($selectedTargetItem) && $selectedTargetItem->matches($targetItem)) { ?>selected="selected" <? } ?> value="<?=$targetItem->getItemID()?>"><?=$targetItem->getItemName()?></option>
                        <? } ?>
                    </select>
                </td>
            </tr>
            <? } ?>
        </tbody>
        </table>
        <div class="ccm-dashboard-form-actions-wrapper">
            <div class="ccm-dashboard-form-actions">
                <a href="<?=$view->action('view_batch', $batch->getID())?>" class="btn btn-default"><?=t('Cancel')?></a>
                <button class="pull-right btn btn-primary" type="submit"><?=t('Save')?></button>
            </div>
        </div>
    </form>

<? } else { ?>
    <p><?=t('No items of the selected type found in the batch.')?></p>
<? } ?>