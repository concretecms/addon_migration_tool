<? defined('C5_EXECUTE') or die("Access Denied."); ?>
<div class="ccm-dashboard-header-buttons">
    <a href="<?=$view->action('view_batch', $batch->getID())?>" class="btn btn-default"><i class="fa fa-angle-double-left"></i> <?=t('Batch to Batch')?></a>
</div>

<? if (count($files)) { ?>

    <script type="text/javascript">
        $(function() {
            $('input[data-checkbox=select-all]').on('click', function() {
                if ($(this).is(':checked')) {
                    $('tbody input[type=checkbox]:enabled').prop('checked', true);
                } else {
                    $('tbody input[type=checkbox]:enabled').prop('checked', false);
                }
                $('tbody input[type=checkbox]:enabled').trigger('change');
            });

            $('tbody input[type=checkbox]').on('change', function() {
                if ($('tbody input[type=checkbox]:checked').length) {
                    $('button[data-action=download-files]').prop('disabled', false);
                } else {
                    $('button[data-action=download-files]').prop('disabled', true);
                }
            });

        });
    </script>

    <form method="post" action="<?=View::url('/dashboard/migration/batches/export', 'download_files')?>">
        <input type="hidden" name="id" value="<?=$batch->getID()?>">
        <?=Loader::helper('validation/token')->output('download_files')?>
        <button style="float: right" disabled class="btn small btn-sm" data-action="download-files" type="submit"><?=t('Download Files')?></button>
        <h3><?=t('Files')?></h3>

        <table class="table table-striped zebra-striped">
            <thead>
            <tr>
                <th><input type="checkbox" data-checkbox="select-all"></th>
                <th><?=t('ID')?></th>
                <th style="width: 100%"><?=t('Filename')?></th>
            </tr>
            </thead>
            <tbody>
            <? foreach($files as $file) { ?>
                <tr>
                    <td><input type="checkbox" data-checkbox="batch-file" name="batchFileID[]" value="<?=$file->getFileID()?>"></td>
                    <td><?=$file->getFileID()?></td>
                    <td><?=$file->getFileName()?></td>
                </tr>
            <? } ?>
            </tbody>
        </table>
    </form>
<? } else { ?>
    <h3><?=t('Files')?></h3>
    <p><?=t('No referenced files found.')?></p>
<? } ?>

<h3><?=t('Content XML')?></h3>
<form method="post" action="<?=$view->action('export_batch_xml', $batch->getID())?>">
    <div class="btn-group">
        <button type="submit" name="view" value="1" class="btn btn-default"><?=t('View XML')?></button>
        <button type="submit" name="download" value="1" class="btn btn-default"><?=t('Download XML')?></button>
    </div>
</form>

