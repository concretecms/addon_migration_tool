<?php if ($batch->hasRecords()) {
    ?>

    <h3><?=t('Status')?></h3>
    <div class="alert alert-info" id="migration-batch-status">
        <div data-message="status-message">
            <i class="fa fa-spin fa-refresh"></i> <?=t('Computing Batch Status')?>
        </div>
    </div>

    <script type="text/javascript">
        $(function() {
            $.ajax({
                dataType: 'json',
                type: 'post',
                data: {
                    'ccm_token': '<?=Core::make('token')->generate('validate_batch')?>',
                    'id': '<?=$batch->getID()?>'},
                url: '<?=$view->action('validate_batch')?>',
                success: function(r) {
                    if (r.alertclass && r.message) {
                        $('#migration-batch-status').removeClass().addClass('alert ' + r.alertclass);
                        $('#migration-batch-status').text(r.message);
                        var tab = $('#ccm-tab-content-errors');
                        if (r.messages && r.messages.length) {
                            var html = '<ul id="ccm-migration-batch-bulk-errors" class="list-unstyled">';
                            for (i = 0; i < r.messages.length; i++) {
                                var message = r.messages[i];
                                html += '<li class="text-' + message.levelClass + '">';
                                html += '<i class="' + message.iconClass + '"></i> ';
                                html += message.text;
                                html += '</li>';
                            }
                            html += '</ul>';
                            tab.html(html);
                        } else {
                            tab.html('<p><?=t('None')?></p>');
                        }
                    } else {
                        $('#migration-batch-status').hide();
                    }
                }
            });
        });
    </script>

    <?=Core::make('helper/concrete/ui')->tabs(array(
        array('batch-content', t('Content'), true),
        array('errors', t('Errors')),
    ))?>


    <div class="ccm-tab-content" id="ccm-tab-content-batch-content">

        <?php foreach ($batch->getObjectCollections() as $collection) {
            if ($collection->hasRecords()) {
                $formatter = $collection->getFormatter();
                ?>

                <h3><?=$formatter->getPluralDisplayName()?></h3>
                <?php print $formatter->displayObjectCollection()?>
                <?php
            }
            ?>
            <?php
        }
        ?>

    </div>

    <div class="ccm-tab-content" id="ccm-tab-content-errors">
        <i class="fa fa-spin fa-refresh"></i>
        <?=t('Loading Errors...')?>
    </div>


    <?php

} else {
    ?>
    <p><?=t('This content batch is empty.')?></p>
    <?php
}
?>

<script type="text/javascript">
    $(function() {
        $('div#ccm-dashboard-page').on('click', '[data-dialog]', function() {
            var width = $(this).attr('data-dialog-width');
            if (!width) {
                width = 320;
            }
            var element = '#ccm-dialog-' + $(this).attr('data-dialog');
            jQuery.fn.dialog.open({
                element: element,
                modal: true,
                width: width,
                title: $(this).attr('data-dialog-title'),
                height: 'auto'
            });
        });
    });
</script>