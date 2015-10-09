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
            columnKey: 'attribute_set',
            renderInitialColumnData: function(cells, data) {
                var node = data.node;
                cells.eq(1).html(node.data.handle);
                cells.eq(2).text(node.data.attributes);
                cells.eq(3).html('<i class="' + node.data.statusClass + '"></i>');
            },
            source: {
                url: '<?=$view->action('load_batch_collection')?>',
                data: {'id': '<?=$collection->getID()?>'}
            }
        });
    });
</script>