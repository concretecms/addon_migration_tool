<? defined('C5_EXECUTE') or die("Access Denied."); ?>

<div class="ccm-dashboard-header-buttons">
    <a href="javascript:void(0)" data-dialog="add-batch" class="btn btn-primary"><?=t("Add Batch")?></a>
</div>

<? if (count($batches)) { ?>

    <table class="table">
        <thead>
        <tr>
            <th><?=t('Batch')?></th>
            <th><?=t('Notes')?></th>
        </tr>
        </thead>
        <tbody>
        <? foreach($batches as $batch) { ?>
            <tr>
                <td style="white-space: nowrap"><a href="<?=$view->action('view_batch', $batch->getID())?>"><?=$batch->getDate()->format('F d, Y g:i a')?></a></td>
                <td width="100%"><?=$batch->getNotes()?></td>
            </tr>
        <? } ?>
        </tbody>
    </table>


<? } else { ?>
    <p><?=$batchEmptyMessage?></p>
<? } ?>

<div style="display: none">
    <div id="ccm-dialog-add-batch" class="ccm-ui">
        <form method="post" action="<?=$view->action('add_batch')?>">
            <?=Loader::helper("validation/token")->output('add_batch')?>
            <div class="form-group">
                <?=Loader::helper("form")->label('date', t('Date'))?>
                <?=Loader::helper('form')->text('date',
                    Core::make('date')->formatDateTime('now', true),
                    array('disabled' => 'disabled')
                )?>
            </div>
            <div class="form-group">
                <?=Loader::helper("form")->label('notes', t('Notes'))?>
                <?=Loader::helper('form')->textarea('notes', '', array("rows" => "3"))?>
            </div>
        </form>
        <div class="dialog-buttons">
            <button class="btn btn-default pull-left" onclick="jQuery.fn.dialog.closeTop()"><?=t('Cancel')?></button>
            <button class="btn btn-primary pull-right" onclick="$('#ccm-dialog-add-batch form').submit()"><?=t('Add Batch')?></button>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function() {
        $('a[data-dialog=add-batch]').on('click', function() {
            jQuery.fn.dialog.open({
                element: '#ccm-dialog-add-batch',
                modal: true,
                width: 320,
                title: '<?=t("Add Batch")?>',
                height: 'auto'
            });
        });
    });
</script>