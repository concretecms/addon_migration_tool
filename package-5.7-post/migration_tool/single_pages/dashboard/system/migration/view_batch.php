<? defined('C5_EXECUTE') or die("Access Denied."); ?>
<div class="ccm-dashboard-header-buttons">
<div class="btn-group" role="group" aria-label="...">
    <a href="javascript:void(0)" data-dialog="add-to-batch" data-dialog-title="<?=t('Add Content')?>" class="btn btn-default"><?=t("Add Content to Batch")?></a>
    <div class="btn-group" role="group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?=t('Edit Batch')?>
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <li class="dropdown-header"><?=t('Map Content')?></li>
            <? foreach($mappers->getDrivers() as $mapper) {?>
                <li><a href="<?=$view->action('map_content', $batch->getId(), $mapper->getHandle())?>"><?=$mapper->getMappedItemPluralName()?></a></li>
            <? } ?>
            <li class="divider"></li>
            <li><a href="<?=$view->action('find_and_replace', $batch->getID())?>"><?=t("Find and Replace")?></a>
            </li>
            <li class="divider"></li>
            <li><a href="javascript:void(0)" data-dialog="clear-batch" data-dialog-title="<?=t('Clear Batch')?>" class=""><span class="text-danger"><?=t("Clear Batch")?></span></a>
            </li>
            <li><a href="javascript:void(0)" data-dialog="delete-batch" data-dialog-title="<?=t('Delete Batch')?>"><span class="text-danger"><?=t("Delete Batch")?></span></a></li>
        </ul>
    </div>
</div>
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
    <? if ($batch->hasRecords()) {
        $validator = new \PortlandLabs\Concrete5\MigrationTool\Batch\Page\Validator\BatchValidator($batch);
        $formatter = $validator->getFormatter();
        ?>
        <form method="post" action="<?=$view->action('create_content_from_batch')?>">
            <?=Core::make('token')->output('create_content_from_batch')?>
            <input type="hidden" name="id" value="<?=$batch->getID()?>">
            <div class="alert <?=$formatter->getAlertClass()?>">
                <button class="pull-right btn btn-default" type="submit"><?=t('Create Pages')?></button>
                <?=$formatter->getCreateStatusMessage()?>
                <div class="clearfix"></div>

            </div>
        </form>


        <div id="migration-tree">
            <? $i = 1; ?>
            <ul id="migration-tree-data" style="display: none">
                <li id="p0" class="folder expanded migration-tree-category" data-iconClass="fa fa-files-o"><?=t('Pages')?>
                    <ul>
                        <? foreach($batch->getPages() as $page) {
                            $messages = $validator->validatePage($page); ?>
                            <li class="expanded"><span>
                                <div class="migration-tree-page-column migration-tree-page-path"><?=$page->getBatchPath()?></div>
                                <div class="migration-tree-page-column migration-tree-page-name"><?=$page->getName()?></div>
                                <div class="migration-tree-page-column migration-tree-page-type"><?=$page->getType()?></div>
                                <div class="migration-tree-page-column migration-tree-page-template"><?=$page->getTemplate()?></div>
                            </span>
                                <ul>
                                <? if ($messages->count() > 0) { ?>
                                    <li data-iconClass="<?=$messages->getFormatter()->getCollectionStatusIconClass()?>"><span><span class="text-<?=$messages->getFormatter()->getLevelClass()?>"><?=t('Errors')?></span></span>
                                    <ul>
                                        <? foreach($messages as $m) { ?>
                                            <li data-iconClass="<?=$m->getFormatter()->getIconClass()?>"><span><span><?=$m->getFormatter()->output()?></span></li>
                                        <? } ?>
                                    </ul>
                                    </li>
                                <? } ?>
                                <? if ($page->getAttributes()->count()) { ?>
                                    <li data-iconClass="fa fa-cogs"><?=t('Attributes')?>
                                    <ul>
                                    <? foreach($page->getAttributes() as $attribute) {
                                        $value = $attribute->getAttribute()->getAttributeValue();
                                        if (is_object($value)) {
                                            $attributeFormatter = $value->getFormatter();
                                            print $attributeFormatter->getBatchTreeNodeElementObject();
                                            ?>
                                        <? } ?>
                                    <? } ?>
                                    </ul>
                                    </li>
                                <? } ?>
                                <? if ($page->getAreas()->count()) { ?>
                                    <li data-iconClass="fa fa-code"><?=t('Areas')?>
                                        <ul>
                                            <? foreach($page->getAreas() as $area) { ?>
                                                <li data-iconClass="fa fa-cubes"><?=$area->getName()?>
                                                    <ul>
                                                        <? foreach($area->getBlocks() as $block) {
                                                            $value = $block->getBlockValue();
                                                            if (is_object($value)) {
                                                                $blockFormatter = $value->getFormatter();
                                                                print $blockFormatter->getBatchTreeNodeElementObject();
                                                                ?>
                                                            <? } ?>
                                                        <? } ?>
                                                    </ul>
                                                </li>
                                                <? } ?>
                                        </ul>
                                    </li>
                                <? } ?>
                            </ul>
                            </li>
                        <? } ?>
                    </ul>
                </li>
            </ul>
        </div>

        <?
        /*
        ?>



        <h4><?=t('Pages')?></h4>
        <table class="table">
            <thead>
            <tr>
                <th><?=t('Path')?></th>
                <th><?=t('Name')?></th>
                <th><?=t('Type')?></th>
                <th><?=t('Template')?></th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <? foreach($batch->getPages() as $page) {
                $messages = $validator->validatePage($page); ?>
                <tr class="migration-page-row" data-page="<?=$page->getID()?>">
                    <td><?=$page->getBatchPath()?></td>
                    <td width="100%"><?=$page->getName()?></td>
                    <td><?=$page->getType()?></td>
                    <td><?=$page->getTemplate()?></td>
                    <td><? print $messages->getFormatter()->outputCollectionStatusIcon()?></td>
                    <td><i data-expand="page" class="fa fa-caret-up"></i></td>
                </tr>
                <? if ($messages->count() > 0) { ?>
                <tr>
                    <td colspan="5">
                        <? foreach($messages as $m) { ?>
                            <div><?=$m->getFormatter()->output()?></div>
                        <? } ?>
                    </td>
                </tr>
                <? } ?>
            <? } ?>
            </tbody>
        </table>
    <? */
    } else { ?>
        <p><?=t('This content batch is empty.')?></p>
    <? } ?>



<? } ?>



<script type="text/javascript">
    $(function() {
        $('#migration-tree').fancytree({
            extensions: ["glyph"],
            toggleEffect: false,
            clickFolderMode: 2,
            focusOnSelect: false,
            glyph: {
                map: {
                    doc: "fa fa-file-o",
                    docOpen: "fa fa-file-o",
                    checkbox: "fa fa-square-o",
                    checkboxSelected: "fa fa-check-square-o",
                    checkboxUnknown: "fa fa-share-square",
                    dragHelper: "fa fa-play",
                    dropMarker: "fa fa-angle-right",
                    error: "fa fa-warning",
                    expanderClosed: "fa fa-plus-square-o",
                    expanderLazy: "fa fa-plus-square-o",  // glyphicon-expand
                    expanderOpen: "fa fa-minus-square-o",  // glyphicon-collapse-down
                    folder: "fa fa-folder-o",
                    folderOpen: "fa fa-folder-open-o",
                    loading: "fa fa-spin fa-refresh"
                }
            },
            beforeActivate: function(event, data) {
                return false;
            }
        });
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

<style type="text/css">
    div#migration-tree ul.fancytree-container {
        border: 0px;
    }

    ul.fancytree-container span.migration-tree-category {
        font-weight: bold;
    }

    .migration-tree-page-column {
        float: left;
        margin-right: 20px;
        overflow: hidden;
    }

    .migration-tree-page-path {
        width: 300px;
    }
    .migration-tree-page-name {
        width: 200px;
        font-weight: bold;
    }

    .migration-tree-page-type {
        width: 200px;
        color: #666;
    }

    .migration-tree-page-template {
        width: 200px;
        color: #666;
    }

    .migration-tree-property-key {
        width: 200px;
    }
    .migration-tree-property-value {
        width: 200px;
    }

    div#migration-tree .fancytree-container span.fancytree-focused span.fancytree-title {
        border-color: transparent !important;
    }



</style>