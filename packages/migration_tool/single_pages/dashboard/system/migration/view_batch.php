<?php defined('C5_EXECUTE') or die("Access Denied.");
$dh = Core::make('helper/date');
/** @var \Concrete\Core\Localization\Service\Date $dh */
?>
<div class="ccm-dashboard-header-buttons">
<div class="btn-group" role="group" aria-label="...">
    <a href="javascript:void(0)" data-dialog="add-to-batch" data-dialog-title="<?=t('Add Content')?>" class="btn btn-default"><?=t("Add Content to Batch")?></a>
    <a href="<?=$view->action('batch_files', $batch->getID())?>" class="btn btn-default"><?=t('Files')?></a>
    <div class="btn-group" role="group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?=t('Edit Batch')?>
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <li class="dropdown-header"><?=t('Map Content')?></li>
            <?php foreach ($mappers->getDrivers() as $mapper) {
    ?>
                <li><a href="<?=$view->action('map_content', $batch->getId(), $mapper->getHandle())?>"><?=$mapper->getMappedItemPluralName()?></a></li>
            <?php 
} ?>
            <li class="divider"></li>
            <?php /*
            <li><a href="<?=$view->action('find_and_replace', $batch->getID())?>"><?=t("Find and Replace")?></a></li>
 */ ?>
            <li><a href="javascript:void(0)" data-dialog="create-content" data-dialog-title="<?=t('Import Batch to Site')?>" class=""><span class="text-primary"><?=t("Import Batch to Site")?></span></a>
            </li>

            <li class="divider"></li>
            <li><a href="javascript:void(0)" data-action="rescan-batch" data-dialog-title="<?=t('Rescan Batch')?>" class=""><?=t("Rescan Batch")?></a>
            <li><a href="javascript:void(0)" data-dialog="clear-batch" data-dialog-title="<?=t('Clear Batch')?>" class=""><span class="text-danger"><?=t("Clear Batch")?></span></a>
            </li>
            <li><a href="javascript:void(0)" data-dialog="delete-batch" data-dialog-title="<?=t('Delete Batch')?>"><span class="text-danger"><?=t("Delete Batch")?></span></a></li>
        </ul>
    </div>
</div>
    </div>

<div style="display: none">

    <div id="ccm-dialog-batch-rescan-progress-bar">
        <div class="ccm-ui">
        <div class="progress progress-bar-striped progress-striped active" style="opacity: 0.5">
            <div class="progress-bar" style="width: 100%;"></div>
        </div>
        </div>
    </div>

    <div id="ccm-dialog-create-content" class="ccm-ui">
        <form method="post" action="<?=$view->action('create_content_from_batch')?>">
            <?=Core::make('token')->output('create_content_from_batch')?>
            <input type="hidden" name="id" value="<?=$batch->getID()?>">
            <p><?=t('Create site content from the contents of this batch?')?></p>
            <div class="dialog-buttons">
                <button class="btn btn-default pull-left" onclick="jQuery.fn.dialog.closeTop()"><?=t('Cancel')?></button>
                <button class="btn btn-primary pull-right" onclick="$('#ccm-dialog-create-content form').submit()"><?=t('Import Batch')?></button>
            </div>
        </form>
    </div>

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

    <div id="ccm-dialog-clear-batch" class="ccm-ui">
        <form method="post" action="<?=$view->action('clear_batch')?>">
            <?=Loader::helper("validation/token")->output('clear_batch')?>
            <input type="hidden" name="id" value="<?=$batch->getID()?>">
            <p><?=t('Are you sure you remove all content from this import batch? This cannot be undone.')?></p>
            <div class="dialog-buttons">
                <button class="btn btn-default pull-left" onclick="jQuery.fn.dialog.closeTop()"><?=t('Cancel')?></button>
                <button class="btn btn-danger pull-right" onclick="$('#ccm-dialog-clear-batch form').submit()"><?=t('Clear Batch')?></button>
            </div>
        </form>
    </div>

    <div id="ccm-dialog-add-to-batch" class="ccm-ui">
        <form method="post" enctype="multipart/form-data">
            <?=Loader::helper("validation/token")->output('add_content_to_batch')?>
            <input type="hidden" name="id" value="<?=$batch->getID()?>">
            <div class="form-group">
                <?=Loader::helper("form")->label('file', t('Content File'))?>
                <?=Loader::helper('form')->file('file')?>
            </div>
            <div class="form-group">
                <?=Loader::helper("form")->label('format', t('File Format'))?>
                <?=Loader::helper('form')->select('format', $formats)?>
            </div>
            <div class="form-group">
                <?=Loader::helper("form")->label('method', t('Records'))?>
                <div class="radio">
                    <label><input type="radio" name="importMethod" value="replace" checked> <?=t('Replace all batch content.')?></label>
                </div>
                <div class="radio">
                    <label><input type="radio" name="importMethod" value="append"> <?=t('Add content to batch.')?></label>
                </div>
            </div>
            <div class="ccm-dialog-add-to-batch-progress-bar" style="display: none">
                <h4></h4>
                <div class="progress progress-striped active">
                    <div class="progress-bar" style="width: 0%;"></div>
                </div>
            </div>
        </form>
        <div class="dialog-buttons">
            <button class="btn btn-default pull-left" onclick="jQuery.fn.dialog.closeTop()"><?=t('Cancel')?></button>
            <button class="btn btn-primary pull-right" data-action="add-content"><?=t('Add Content')?></button>
        </div>
    </div>
</div>


<?php if ($batch) {
    ?>

    <h2><?=t('Batch')?>
        <small><?=$dh->formatDateTime($batch->getDate(), true)?></small></h2>

    <?php if ($batch->getNotes()) { ?>
        <p><?=$batch->getNotes()?></p>
    <?php 
        }
    ?>

    <?php Loader::element('batch', array('batch' => $batch), 'migration_tool'); ?>

<?php } ?>


<script type="text/javascript">
    showRescanDialog = function() {
        $('#ccm-dialog-batch-rescan-progress-bar').jqdialog({
            autoOpen: true,
            height: 'auto',
            width: 400,
            modal: true,
            title: '<?=t("Scanning Batch")?>',
            closeOnEscape: false,
            open: function(e, ui) {

            }
        });
    }

    rescanBatchItems = function() {
        $.concreteAjax({
            url: '<?=$view->action('run_batch_content_tasks')?>',
            type: 'POST',
            data: [
                {'name': 'id', 'value': '<?=$batch->getID()?>'},
                {'name': 'ccm_token', 'value': '<?=Core::make('token')->generate('run_batch_content_tasks')?>'}
            ],
            success: function(r) {
                jQuery.fn.dialog.hideLoader();
                $("#ccm-dialog-progress-bar").jqdialog('open');
                window.location.reload();
            }
        });
    }

    $(function() {

        $('a[data-action=rescan-batch]').on('click', function(e) {
            e.preventDefault();
            rescanBatchItems();
            showRescanDialog();
        });

        var uploadErrors = [];

        $('input[name=file]').fileupload({
            dataType: 'json',
            add: function (e, data) {
                $("button[data-action=add-content]").off('click').on('click', function () {
                    data.submit();
                });
            },
            url: '<?=$view->action('add_content_to_batch')?>',
            formData: {
                'ccm_token': $('#ccm-dialog-add-to-batch input[name=ccm_token]').val(),
                'id': $('#ccm-dialog-add-to-batch input[name=id]').val(),
                'format': $('#ccm-dialog-add-to-batch select[name=format]').val(),
                'importMethod': $('#ccm-dialog-add-to-batch input[name=importMethod]:checked').val()
            },

            start: function() {
                $('div#ccm-dialog-add-to-batch input, div#ccm-dialog-add-to-batch select').prop('disabled', true);
                $('div.ccm-dialog-add-to-batch-progress-bar').show();
                $('div.ccm-dialog-add-to-batch-progress-bar h4').html('<?=t('Uploading File...')?>');
                uploadErrors = [];
            },
            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('div.ccm-dialog-add-to-batch-progress-bar div.progress-bar').css(
                    'width',
                    progress + '%'
                );
            },

            error: function(r) {
                var message = r.responseText;
                try {
                    message = jQuery.parseJSON(message).errors;
                    _(message).each(function(error) {
                        uploadErrors.push({ name:name, error:error });
                    });
                } catch (e) {
                    ConcreteAlert.dialog('<?=t('Error')?>', r.statusText);
                }
            },
            done: function(e, data)
            {
                if (data.result.error) {
                    _(data.result.errors).each(function(error) {
                        uploadErrors.push({ name:name, error:error });
                    });
                }
            },
            stop: function() {

                $('div#ccm-dialog-add-to-batch input, div#ccm-dialog-add-to-batch select').prop('disabled', false);
                if (uploadErrors.length) {
                    var str = '';
                    $.each(uploadErrors, function(i, o) {
                        str += o.error + "<br>";
                    });
                    ConcreteAlert.dialog('<?=t('Error')?>', str);
                    $('div.ccm-dialog-add-to-batch-progress-bar').hide();
                    $('div.ccm-dialog-add-to-batch-progress-bar h4').html('');

                } else {
                    $('div.ccm-dialog-add-to-batch-progress-bar div.progress').replaceWith($('#ccm-dialog-batch-rescan-progress-bar div.progress'));
                    $('div.ccm-dialog-add-to-batch-progress-bar h4').html('<?=t('Scanning Batch...')?>');
                    rescanBatchItems();
                }
            }

        });
    });

</script>

<style type="text/css">
    div#ccm-tab-content-batch-content {
        padding-top: 0px;
    }
    #ccm-migration-batch-bulk-errors li {
        position: relative;
        padding-left: 35px
    }
    #ccm-migration-batch-bulk-errors li i {
        position: absolute;
        top: 5px;
        left: 0px;
        width: 30px;
        text-align: center;
    }
</style>