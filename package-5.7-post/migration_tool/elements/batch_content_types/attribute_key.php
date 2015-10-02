<table id="migration-tree-table-<?=$type?>" class="migration-table table table-bordered table-striped">
    <colgroup>
        <col width="300"></col>
        <col width="*"></col>
        <col width="120px"></col>
        <col width="120px"></col>
        <col width="30px"></col>
    </colgroup>
    <thead>
    <tr> <th><?=t('Name')?></th> <th><?=t('Handle')?></th> <th><?=t('Type')?></th> <th><?=t('Category')?></th> <th> </th> </tr>
    </thead>
    <tbody>
    </tbody>
</table>

<script type="text/javascript">
    $(function() {
        $("#migration-tree-table-<?=$type?>").migrationBatchTableTree({
            source: {
                url: '<?=$view->action('load_batch_collection')?>',
                data: {'id': '<?=$collection->getID()?>'}
            },
            renderColumns: function(event, data) {
                var node = data.node,
                    $tdList = $(node.tr).find(">td");
                if (node.data.skipped) {
                    $(node.tr).addClass("migration-item-skipped");
                }
                if (node.data.nodetype == 'attribute_key') {
                    $tdList.eq(1).html(node.data.handle);
                    $tdList.eq(2).text(node.data.type);
                    $tdList.eq(3).text(node.data.category);
                    $tdList.eq(4).html('<i class="' + node.data.statusClass + '"></i>');
                } else if (node.data.itemvalue) {
                    $tdList.eq(1).html(node.data.itemvalue);
                    $tdList.eq(1)
                        .prop("colspan", 4)
                        .nextAll().remove();
                } else {
                    $tdList.eq(0)
                        .prop("colspan", 5)
                        .nextAll().remove();
                }
                $('.launch-tooltip').tooltip({'container': '#ccm-tooltip-holder'});
            }
        });
    });
</script>