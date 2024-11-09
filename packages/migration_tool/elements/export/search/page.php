<?php
defined('C5_EXECUTE') or die(_("Access Denied."));
$form = Core::make('helper/form');
$pagetypes = array();
$site = Core::make('site')->getActiveSiteForEditing();
$siteType = $site->getType();
$datetime = Loader::helper('form/date_time')->translate('datetime', $_GET);
$list = \Concrete\Core\Page\Type\Type::getList(false, $siteType);
$pagetypes = array('' => t('** Choose a page type'));
foreach ($list as $type) {
    $pagetypes[$type->getPageTypeID()] = $type->getPageTypeDisplayName();
}
?>
<div class="form-group">
    <label class="control-label"><?=t('Keywords')?></label>
    <?=$form->text('keywords')?>
</div>

<div class="form-group">
    <label class="control-label"><?=t('Published on or After')?></label>
    <?=Loader::helper('form/date_time')->datetime('datetime', $datetime, true)?>
</div>


<div class="form-group">
    <label class="control-label"><?=t('Filter by Parent Page')?></label>
    <?=Loader::helper('form/page_selector')->selectPage('startingPoint')?>
</div>

<div class="form-group">
    <label class="control-label"><?=t('Filter by Page Type')?></label>
    <?=$form->select('ptID', $pagetypes)?>
</div>

<div class="form-group">
	<div class="checkbox">
    	<label> <?php echo $form->checkbox('includeSystemPages', 1, !empty($includeSystemPages));  ?><?=t('Include System Pages'); ?></label>
	</div>
    <div class="checkbox">
        <label> <?= $form->checkbox('includeExternalLinks', 1, !empty($includeExternalLinks)) ?><?=t('Include External Links'); ?></label>
    </div>
    <div class="checkbox">
        <label> <?= $form->checkbox('includeAliases', 1, !empty($includeAliases)) ?><?=t('Include Page Aliases'); ?></label>
    </div>
</div>
