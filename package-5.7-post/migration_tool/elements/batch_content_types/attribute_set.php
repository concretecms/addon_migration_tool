<table id="migration-tree-table-<?=$type?>" class="table table-bordered table-striped">
    <colgroup>
        <col width="*"></col>
        <col width="*"></col>
        <col width="*"></col>
        <col width="30px"></col>
    </colgroup>
    <thead>
    <tr>
        <th><?=t('Name')?></th>
        <th><?=t('Handle')?></th>
        <th><?=t('Attributes')?></th>
        <th></th>
    </tr>
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

                if (node.data.nodetype == 'attribute_set') {
                    $tdList.eq(1).html(node.data.handle);
                    $tdList.eq(2).text(node.data.attributes);
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
            }
        });
    });
</script>