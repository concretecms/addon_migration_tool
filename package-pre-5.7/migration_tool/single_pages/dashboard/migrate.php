
<?=Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Migration Tool'))?>

<? if ($this->controller->getTask() == 'submit') { ?>

<h3><?=t('Data')?></h3>

<textarea style="width: 100%; height: 800px"><?=$outputContent?></textarea>
<br/><br/>
<a class="btn" href="<?=$this->url('/dashboard/migrate')?>"><?=t('Back')?></a>

<? } else { ?>
	<form method="post" action="<?=$this->action('submit')?>">

	<div class="clearfix">
		<label class="control-label"><?=t('Select Starting Point')?></label>
		<div class="input">
			<?=Loader::helper('form/page_selector')->selectPage('startingPoint')?>
		</div>
	</div>
	<button class="btn btn-primary"><?=t('Generate XML File')?></button>
</form>

	<div class="ccm-spacer"></div>

<? } ?>

<?=Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper();?>