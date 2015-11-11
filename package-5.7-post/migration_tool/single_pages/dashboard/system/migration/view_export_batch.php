<? defined('C5_EXECUTE') or die("Access Denied."); ?>
<div class="ccm-dashboard-header-buttons">
<div class="btn-group" role="group">
    <a href="<?=$view->action('add_to_batch', $batch->getId())?>" class="btn btn-default"><?=t("Add Content to Batch")?></a>
    <button data-action="remove-from-batch" disabled class="btn btn-default"><?=t('Remove Selected')?></button>
    <a href="javascript:void(0)" data-dialog="create-content" data-dialog-title="<?=t('Export Batch')?>" class="btn btn-primary"><?=t("Export Batch")?></a>
    <a href="javascript:void(0)" data-dialog="delete-batch" data-dialog-title="<?=t('Delete Batch')?>" class="btn btn-danger"><?=t("Delete Batch")?></a>
</div>
</div>

<div style="display: none">

    <div id="ccm-dialog-delete-batch" class="ccm-ui">
        <form method="post" action="<?=$view->action('delete_batch')?>">
            <?=Loader::helper("validation/token")->output('delete_batch')?>
            <input type="hidden" name="id" value="<?=$batch->getID()?>">
            <p><?=t('Are you sure you want to delete this export batch? This cannot be undone.')?></p>
            <div class="dialog-buttons">
                <button class="btn btn-default pull-left" onclick="jQuery.fn.dialog.closeTop()"><?=t('Cancel')?></button>
                <button class="btn btn-danger pull-right" onclick="$('#ccm-dialog-delete-batch form').submit()"><?=t('Delete Batch')?></button>
            </div>
        </form>
    </div>

</div>


<? if ($batch) { ?>

    <h2><?=t('Batch')?>
        <small><?=$batch->getDate()->format('F d, Y g:i a')?></small></h2>

    <? if ($batch->getNotes()) { ?>
        <p><?=$batch->getNotes()?></p>
    <? } ?>

    <? if ($batch->hasRecords()) { ?>

        <form method="post" action="<?=$view->action('remove_batch_items')?>" data-form="remove-batch-items">
            <?=$token->output('remove_batch_items')?>
            <?=$form->hidden('batch_id', $batch->getId())?>


            <? foreach($batch->getObjectCollections() as $collection) {
                if ($collection->hasRecords()) {
                    $itemType = $collection->getItemTypeObject();
                    $formatter = $itemType->getResultsFormatter($batch);
                    ?>

                    <h3><?=$itemType->getPluralDisplayName()?></h3>
                    <? print $formatter->displayBatchResults()?>
                <? } ?>
            <? } ?>

        </form>

    <?
    } else { ?>
        <p><?=t('This export batch is empty.')?></p>
    <? } ?>

<? } ?>



<script type="text/javascript">
    $(function() {
        $('a[data-dialog]').on('click', function() {
            var element = '#ccm-dialog-' + $(this).attr('data-dialog');
            jQuery.fn.dialog.open({
                element: element,
                modal: true,
                width: 320,
                title: $(this).attr('data-dialog-title'),
                height: 'auto'
            });
        });

        $('input[data-action=select-all]').on('click', function() {
            if ($(this).is(':checked')) {
                $(this).closest('table').find('tbody input[type=checkbox]:enabled').prop('checked', true);
            } else {
                $(this).closest('table').find('tbody input[type=checkbox]:enabled').prop('checked', false);
            }
            $(this).closest('table').find('tbody input[type=checkbox]:enabled').trigger('change');
        });

        $('tbody input[type=checkbox]').on('change', function() {
            if ($(this).closest('table').find('tbody input[type=checkbox]:checked').length) {
                $('button[data-action=remove-from-batch]').prop('disabled', false);
            } else {
                $('button[data-action=remove-from-batch]').prop('disabled', true);
            }
        });

        $('button[data-action=remove-from-batch]').on('click', function() {
            $('form[data-form=remove-batch-items]').submit();
        });

    });
</script>