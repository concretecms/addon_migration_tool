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
            <? /*
            <li><a href="<?=$view->action('find_and_replace', $batch->getID())?>"><?=t("Find and Replace")?></a></li>
 */ ?>
            <li><a href="javascript:void(0)" data-dialog="create-content" data-dialog-title="<?=t('Import Batch to Site')?>" class=""><span class="text-primary"><?=t("Import Batch to Site")?></span></a>
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

    <? if ($batch->hasRecords()) { ?>

    <h3><?=t('Status')?></h3>
    <div class="alert alert-info" id="migration-batch-status">
        <div data-message="status-message">
            <i class="fa fa-spin fa-refresh"></i> <?=t('Computing Batch Status')?>
        </div>
    </div>

    <h3><?=t('Records')?></h3>

        <table id="migration-tree-table" class="table table-bordered table-striped">
            <colgroup>
                <col width="300"></col>
                <col width="*"></col>
                <col width="120px"></col>
                <col width="30px"></col>
            </colgroup>
            <thead>
            <tr> <th><?=t('Page')?></th> <th><?=t('Path')?></th> <th><?=t('Type')?></th> <th> </th> </tr>
            </thead>
            <tbody>
            </tbody>
        </table>


    <?
    } else { ?>
        <p><?=t('This content batch is empty.')?></p>
    <? } ?>



<? } ?>



<script type="text/javascript">
    $(function() {
        $('#migration-tree-table').fancytree({
            extensions: ["glyph","table"],
            toggleEffect: false,
            source: {
                url: '<?=$view->action('load_batch_data')?>',
                data: {'id': '<?=$batch->getID()?>'}
            },
            postProcess: function(event, data){
                data.result = data.response.nodes;
                if (data.response && data.response.validator) {
                    if (data.response.validator.alertclass && data.response.validator.message) {
                        $('#migration-batch-status').removeClass().addClass('alert ' + data.response.validator.alertclass);
                        $('#migration-batch-status').text(data.response.validator.message);
                    } else {
                        $('#migration-batch-status').hide();
                    }
                }
            },
            table: {
                checkboxColumnIdx: null,
                customStatus: false,
                indentation: 16,         // indent every node level by 16px
                nodeColumnIdx: 0
            },
            lazyLoad: function(event, data) {
                data.result = {
                    url: '<?=$view->action('load_batch_page_data')?>',
                    data: {'id': data.node.data.id}
                }
            },
            renderColumns: function(event, data) {
                var node = data.node,
                    $tdList = $(node.tr).find(">td");

                if (node.data.type == 'page') {
                    $tdList.eq(1).text(node.data.pagePath);
                    $tdList.eq(2).text(node.data.pageType);
                    $tdList.eq(3).html('<i class="' + node.data.statusClass + '"></i>');
                } else if (node.data.itemvalue) {
                    $tdList.eq(1).html(node.data.itemvalue);
                    $tdList.eq(1)
                        .prop("colspan", 3)
                        .nextAll().remove();
                } else {
                    $tdList.eq(0)
                        .prop("colspan", 4)
                        .nextAll().remove();
                }

            },
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
    tr.migration-page .fancytree-node {
        width: 300px !important;
        white-space: nowrap;
        overflow: hidden;
    }
</style>


<? /*

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

</style>*/ ?>