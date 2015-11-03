<?
defined('C5_EXECUTE') or die(_("Access Denied."));
$form = Loader::helper('form');
?>


<?=Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Add Pages to Batch'))?>

<style type="text/css">
    input.ccm-activate-date-time {
        margin-right: 10px !important;
    }
    table {
        table-layout:fixed;
    }
    table td {
        word-wrap: break-word;
    }

</style>

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
                $('button[data-action=add-to-batch]').prop('disabled', false);
            } else {
                $('button[data-action=add-to-batch]').prop('disabled', true);
            }
        });

        $('button[data-action=add-to-batch]').on('click', function() {
            var $checkboxes = $('input[data-checkbox=batch-page]');
            if ($checkboxes.length) {
                var data = $checkboxes.serializeArray();
                jQuery.fn.dialog.showLoader();
                data.push({'name': 'id', 'value': '<?=$batch->getID()?>'});
                data.push({'name': 'ccm_token', 'value': '<?=Loader::helper('validation/token')->generate('submit')?>'});
                $.post('<?=View::url('/dashboard/migration/batches/add_pages', 'submit')?>', data, function(r) {
                    jQuery.fn.dialog.hideLoader();
                    if (r.error) {
                        alert(r.messages.join('<br>'));
                    } else if (r.pages.length) {
                        alert('<?=t('Pages added successfully.')?>');
                    }
                }, 'json');
            }
        });
    });
</script>

<a href="<?=View::url('/dashboard/migration/batches', 'view_batch', $batch->getID())?>">&lt; <?=t('Back to Batch')?></a>

    <h3><?=t('Search Pages')?></h3>

    <form method="get" action="<?=$this->action('view', $batch->getID())?>" class="form-stacked">

        <div class="clearfix">
            <label class="control-label"><?=t('Keywords')?></label>
            <div class="input">
                <?=$form->text('keywords')?>
            </div>
        </div>

        <div class="clearfix">
            <label class="control-label"><?=t('Published on or After')?></label>
            <div class="input">
                <?=Loader::helper('form/date_time')->datetime('datetime', $datetime, true)?>
            </div>
        </div>


        <div class="clearfix">
            <label class="control-label"><?=t('Filter by Parent Page')?></label>
            <div class="input">
                <?=Loader::helper('form/page_selector')->selectPage('startingPoint')?>
            </div>
        </div>

        <div class="clearfix">
            <label class="control-label"><?=t('Filter by Page Type')?></label>
            <div class="input">
                <?=$form->select('ctID', $pagetypes)?>
            </div>
        </div>


        <button class="btn btn-primary"><?=t('Search')?></button>
    </form>

    <div class="ccm-spacer"></div>

    <button style="float: right" disabled class="btn small btn-sm" data-action="add-to-batch" type="button"><?=t('Add to Batch')?></button>
    <? if (isset($results) && count($results)) { ?>
    <h3><?=t('Results')?></h3>

    <table class="table table-striped zebra-striped">
        <thead>
        <tr>
            <th style="width: 20px"><input type="checkbox" class="ccm-migration-select-all"></th>
            <th><?=t('Name')?></th>
            <th><?=t('Description')?></th>
        </tr>
        </thead>
        <tbody>
        <? foreach($results as $page) { ?>
            <tr>
                <td><input <? if ($batch->containsPageID($page->getCollectionID())) { ?>disabled checked<? } ?> type="checkbox" data-checkbox="batch-page" name="batchPageID[]" value="<?=$page->getCollectionID()?>"></td>
                <td><a target="_blank" href="<?=Loader::helper('navigation')->getLinkToCollection($page)?>"><?=$page->getCollectionName()?></td>
                <td><?=$page->getCollectionDescription()?></td>
            </tr>
        <? } ?>
        </tbody>
    </table>
    <? } else if (!isset($results)) { ?>
    <h3><?=t('Results')?></h3>
        <div class="alert alert-info alert-message block-message"><?=t('Search for pages to include them in the batch.')?></div>
    <? } else { ?>
    <h3><?=t('Results')?></h3>
        <p><?=t('No results found.')?></p>
    <? } ?>

<?=Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper();?>