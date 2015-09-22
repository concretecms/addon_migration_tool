<? defined('C5_EXECUTE') or die("Access Denied."); ?>
    <div class="ccm-dashboard-header-buttons">
        <a href="<?=$view->action('view_batch', $batch->getID())?>" class="btn btn-default"><i class="fa fa-angle-double-left"></i> <?=t('Batch to Batch')?></a>
    </div>


    <h2><?=t('Batch')?>
        <small><?=$batch->getDate()->format('F d, Y g:i a')?></small></h2>
