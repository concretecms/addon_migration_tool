<? defined('C5_EXECUTE') or die("Access Denied."); ?>

<div class="ccm-dashboard-header-buttons btn-group">
    <a href="javascript:void(0)" data-dialog="add-to-batch" data-dialog-title="<?=t('Add Content')?>" class="btn btn-default"><?=t("Add Content to Batch")?></a>
    <a href="javascript:void(0)" data-dialog="delete-batch" data-dialog-title="<?=t('Delete Batch')?>" class="btn btn-danger"><?=t("Delete Batch")?></a>
</div>


<div style="display: none">
    <div id="ccm-dialog-delete-batch" class="ccm-ui">
        <form method="post" action="<?=$view->action('delete_batch')?>">
            <?=Loader::helper("validation/token")->output('delete_batch')?>
            <input type="hidden" name="id" value="<?=$batch->getID()?>">
            <p><?=t('Are you sure you want to delete this import batch? This cannot be undone.')?></p>
            <div class="dialog-buttons">
                <button class="btn btn-default pull-left" onclick="jQuery.fn.dialog.closeTop()"><?=t('Cancel')?></button>
                <button class="btn btn-danger pull-right" onclick="$('#ccm-dialog-delete-batch form').submit()"><?=t('Delete Batch')?></button>
            </div>
        </form>
    </div>

    <div id="ccm-dialog-add-to-batch" class="ccm-ui">
        <form method="post" enctype="multipart/form-data" action="<?=$view->action('add_content_to_batch')?>">
            <?=Loader::helper("validation/token")->output('add_content_to_batch')?>
            <input type="hidden" name="id" value="<?=$batch->getID()?>">
            <div class="form-group">
                <?=Loader::helper("form")->label('xml', t('XML File'))?>
                <?=Loader::helper('form')->file('xml')?>
            </div>
        </form>
        <div class="dialog-buttons">
            <button class="btn btn-default pull-left" onclick="jQuery.fn.dialog.closeTop()"><?=t('Cancel')?></button>
            <button class="btn btn-primary pull-right" onclick="$('#ccm-dialog-add-to-batch form').submit()"><?=t('Add Content')?></button>
        </div>
    </div>
</div>


<? if ($batch) { ?>

    <h2><?=t('Batch')?>
        <small><?=$batch->getDate()->format('F d, Y g:i a')?></small></h2>

    <? if ($batch->getNotes()) { ?>
        <p><?=$batch->getNotes()?></p>
    <? } ?>

    <h3><?=t('Records')?></h3>



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
    });
</script>