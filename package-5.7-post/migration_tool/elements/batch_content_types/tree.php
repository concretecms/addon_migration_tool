<table id="migration-tree-table-<?=$type?>" class="migration-table table table-bordered table-striped">
    <colgroup>
        <col width="*"></col>
    </colgroup>
    <thead>
    <tr> <th><?=t('Tree')?></th> </tr>
    </thead>
    <tbody>
    </tbody>
</table>


<script type="text/javascript">
    $(function() {
        $("#migration-tree-table-<?=$type?>").migrationBatchTableTree({
            columnKey: 'tree',
            renderInitialColumnData: function(cells, data) {
                var node = data.node;
                cells.eq(1).html(node.data.treeName);
            },
            source: {
                url: '<?=$view->action('load_batch_collection')?>',
                data: {'id': '<?=$collection->getID()?>'}
            }
        });
    });
</script>