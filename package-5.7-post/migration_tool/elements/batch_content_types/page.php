<table id="migration-tree-table-<?=$type?>" class="table table-bordered table-striped">
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

<script type="text/javascript">
    $(function() {
        $('#migration-tree-table-<?=$type?>').fancytree({
            extensions: ["glyph","table"],
            toggleEffect: false,
            source: {
                url: '<?=$view->action('load_batch_page_collection')?>',
                data: {'id': '<?=$collection->getID()?>'}
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
            init: function() {
                $('[data-editable-property=path]').editable({
                    container: '#ccm-dashboard-content',
                    url: '<?=$view->action('update_page_path')?>'
                });
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
                    $tdList.eq(1).html(node.data.pagePath);
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
                $('.launch-tooltip').tooltip({'container': '#ccm-tooltip-holder'});


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
    });
</script>

<style type="text/css">
    tr.migration-page .fancytree-node {
        width: 300px !important;
        white-space: nowrap;
        overflow: hidden;
    }
</style>