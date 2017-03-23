<?php

defined('C5_EXECUTE') or die("Access Denied.");
$dateHelper = new \Concrete\Core\Localization\Service\Date();

?>

<div class="ccm-dashboard-header-buttons">
    <div class="btn-group" role="group">
        <a href="javascript:void(0)" data-dialog="delete-log" data-dialog-title="<?=t('Delete Log')?>" class="btn btn-danger"><?=t("Delete Log")?></a>
    </div>
</div>

<div style="display: none">

    <div data-dialog-wrapper="delete-log" class="ccm-ui">
        <form method="post" action="<?=$view->action('delete_log')?>">
            <?=Loader::helper("validation/token")->output('delete_log')?>
            <input type="hidden" name="id" value="<?=$log->getID()?>">
            <p><?=t('Are you sure you want to delete this log? This cannot be undone.')?></p>
            <div class="dialog-buttons">
                <button class="btn btn-default pull-left" onclick="jQuery.fn.dialog.closeTop()"><?=t('Cancel')?></button>
                <button class="btn btn-danger pull-right" onclick="$('div[data-dialog-wrapper=delete-log] form').submit()"><?=t('Delete Log')?></button>
            </div>
        </form>
    </div>

</div>


<?php if (count($entries)) { ?>

    <h3 style="margin-top: 0px"><?=t('Log Entries')?></h3>

    <div class="table-responsive">
        <table id="ccm-conversation-messages" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th><span><?=t('Time')?></span></th>
                <th><span><?=t('Status')?></span></th>
                <th><span><?=t('Item')?></span></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td style="white-space: nowrap"><?=$log->getDateStarted() ? $dateHelper->formatTime($log->getDateStarted(), 'long') : t('N/A') ?></td>
                <td><i class="fa hourglass-start"></i> <?=t('Starting...')?></td>
                <td><?=t('Import batch %s publish started.', $log->getBatchID())?></td>
            </tr>

            <?php foreach($entries as $entry) {
                $object = $entry->getObject();
                $formatter = $object->getLogFormatter();
                ?>
                <tr>
                    <td style="white-space: nowrap">
                        <?=$entry->getTimestamp() ? $dateHelper->formatTime($entry->getTimestamp(), 'long') : t('N/A') ?>
                    </td>
                    <td style="white-space: nowrap"><?=$formatter->getEntryStatusElement($entry)?></td>
                    <td width="100%">
                        <?php
                            print $formatter->getDescriptionElement($entry);
                        ?>
                    </td>
                </tr>
            <?php } ?>
            <tr>
                <td style="white-space: nowrap"><?=$log->getDateCompleted() ? $dateHelper->formatTime($log->getDateCompleted(), 'long') : t('N/A') ?></td>
                <td><i class="fa hourglass-end"></i> <?=t('Finished.')?></td>
                <td><?=t('Import batch %s publish completed.', $log->getBatchID())?></td>
            </tr>
            </tbody>
        </table>
    </div>

    <h3><span class="launch-tooltip" title="<?=t('These are not errors while publishing – these are errors that were reported just prior to beginning the publishing process.')?>"><?=t('Original Batch Errors')?></span></h3>

<?php } else { ?>

    <p><?=t('There are no entries in this log.')?></p>

<?php } ?>


