<?
defined('C5_EXECUTE') or die(_("Access Denied."));
$form = Loader::helper('form');
?>


<?=Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Export Batch'))?>

    <a href="<?=View::url('/dashboard/migration/batches', 'view_batch', $batch->getID())?>">&lt; <?=t('Back to Batch')?></a>

<? if (count($files)) { ?>

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
            <th><input type="checkbox" class="ccm-migration-select-all"></th>
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
<a href="<?=View::url('/dashboard/migration/batches/export', 'do_export', $batch->getID())?>" class="btn btn-default"><?=t('Download XML')?></a>



<?=Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper();?>