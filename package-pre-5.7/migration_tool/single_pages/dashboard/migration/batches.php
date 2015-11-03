<?
defined('C5_EXECUTE') or die(_("Access Denied."));
$form = Loader::helper('form');
?>


<?=Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Migration Tool'))?>

<? if ($this->controller->getTask() == 'view_batch' && $batch) { ?>

    <script type="text/javascript">
        $(function() {
            $('input.ccm-migration-select-all').on('click', function() {
                if ($(this).is(':checked')) {
                    $('tbody input[type=checkbox]:enabled').prop('checked', true);
                } else {
                    $('tbody input[type=checkbox]:enabled').prop('checked', false);
                }
                $('tbody input[type=checkbox]:enabled').trigger('change');
            });

            $('tbody input[type=checkbox]').on('change', function() {
                if ($('tbody input[type=checkbox]:checked').length) {
                    $('button[data-action=remove-from-batch]').prop('disabled', false);
                } else {
                    $('button[data-action=remove-from-batch]').prop('disabled', true);
                }
            });

            $('button[data-action=remove-from-batch]').on('click', function() {
                var $checkboxes = $('input[data-checkbox=batch-page]');
                if ($checkboxes.length) {
                    var data = $checkboxes.serializeArray();
                    jQuery.fn.dialog.showLoader();
                    data.push({'name': 'id', 'value': '<?=$batch->getID()?>'});
                    data.push({'name': 'ccm_token', 'value': '<?=Loader::helper('validation/token')->generate('remove_from_batch')?>'});
                    $.post('<?=View::url('/dashboard/migration/batches', 'remove_from_batch')?>', data, function(r) {
                        jQuery.fn.dialog.hideLoader();
                        if (r.error) {
                            alert(r.messages.join('<br>'));
                        } else if (r.pages.length) {
                            for (var i = 0; i < r.pages.length; i++) {
                                var cID = r.pages[i];
                                $('tr[data-batch-page=' + cID + ']').remove();
                            }
                        }
                    }, 'json');
                }
            });
        });
    </script>

    <form method="post" action="<?=View::url('/dashboard/migration/batches', 'update_batch')?>">
    <input type="hidden" name="id" value="<?=$batch->getID()?>">
    <?=Loader::helper('validation/token')->output("update_batch")?>
    <div class="well">
        <a href="<?=View::url('/dashboard/migration/batches/add_pages', $batch->getID())?>" class="btn btn-primary"><?=t('Add Pages')?></a>
        <a href="<?=View::url('/dashboard/migration/batches/export', $batch->getID())?>" class="btn btn-primary"><?=t('Export Batch')?></a>
        <button type="submit" onclick="return confirm('<?=t('Delete the Batch?')?>')" name="action" value="delete" class="btn danger btn-danger"><?=t('Delete Batch')?></button>
    </div>

        <? if (count($pages)) { ?>
            <button style="float: right" disabled class="btn small btn-sm" data-action="remove-from-batch" type="button"><?=t('Remove from Batch')?></button>
            <h3><?=t('Pages')?></h3>
        <table class="table table-striped zebra-striped">
            <thead>
            <tr>
                <th style="width: 20px"><input type="checkbox" class="ccm-migration-select-all"></th>
                <th><?=t('Name')?></th>
                <th><?=t('Description')?></th>
            </tr>
            </thead>
            <tbody>
            <? foreach($pages as $page) { ?>
                <tr data-batch-page="<?=$page->getCollectionID()?>">
                    <td><input type="checkbox" data-checkbox="batch-page" name="batchPageID[]" value="<?=$page->getCollectionID()?>"></td>
                    <td><a target="_blank" href="<?=Loader::helper('navigation')->getLinkToCollection($page)?>"><?=$page->getCollectionName()?></td>
                    <td><?=$page->getCollectionDescription()?></td>
                </tr>
            <? } ?>
            </tbody>
        </table>
    <? } else { ?>
            <h3><?=t('Pages')?></h3>
        <p><?=t('No pages in batch.')?></p>
    <? } ?>
    </form>




<? } else { ?>

    <h3><?=t('Batches')?></h3>
    <? if (count($batches)) { ?>

    <table class="table table-striped zebra-striped">
    <thead>
        <tr>
            <th><?=t('ID')?></th>
            <th><?=t('Date')?></th>
            <th><?=t('Description')?></th>
        </tr>
    </thead>
        <? foreach($batches as $batch) { ?>
            <tr>
                <td><a href="<?=View::url('/dashboard/migration/batches', 'view_batch', $batch->getID())?>"><?=$batch->getID()?></td>
                <td style="white-space: nowrap"><?=$batch->getTimestamp()?></td>
                <td style="width: 100%"><?=$batch->getDescription()?></td>
            </tr>
        <? } ?>
    </table>

    <? } else { ?>
        <p><?=t("You have not added any content batches.")?></p>
    <? } ?>

    <form method="post" action="<?=$this->action('submit')?>" class="form-stacked" style="margin-left: -15px">
        <?=Loader::helper('validation/token')->output("submit")?>
        <h3><?=t("Add Batch")?></h3>

        <div class="clearfix">
            <label class="control-label"><?=t('Batch Description')?></label>
            <div class="input">
                <?=$form->textarea('description', array('style' => 'height: 120px'))?>
            </div>
        </div>
        <button class="btn btn-primary"><?=t('Add Batch')?></button>
    </form>

    <div class="ccm-spacer"></div>

<? } ?>
<?=Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper();?>