
function MigrationBatchTableTree($table, options) {
    var my = this;
    options = options || {};
    options = $.extend({
        source: {},
        init: false,
        lazyLoad: false,
        columnKey: false,
        renderInitialColumnData: false,
        renderColumns: function(event, data) {
            my.renderColumns(event, data);
        }
    }, options);
    my.$table = $table;
    my.options = options;
    my.$table.fancytree({
        extensions: ["glyph","table"],
        toggleEffect: false,
        source: options.source,
        init: options.init,
        glyph: {
            preset: 'awesome5'
        },
        table: {
            checkboxColumnIdx: null,
            customStatus: false,
            indentation: 16,         // indent every node level by 16px
            nodeColumnIdx: 0
        },
        lazyLoad: options.lazyLoad,
        renderColumns: options.renderColumns,
        clickFolderMode: 2,
        focusOnSelect: false,
        beforeActivate: function(event, data) {
            return false;
        }
    });
}

MigrationBatchTableTree.prototype.renderColumns = function(event, data) {
    var my = this,
        node = data.node,
        cells = $(node.tr).find(">td");

    if (node.data.exists) {
        $(node.tr).addClass('migration-item-skipped');
    }
    if (node.data.nodetype == my.options.columnKey) {
        my.options.renderInitialColumnData(cells, data);
        cells.eq(cells.length - 1).html('<input data-checkbox="select-item" type="checkbox" name="item[' + my.options.columnKey + '][]" value="' + data.node.data.id + '">');
    } else if (node.data.itemvalue) {
        var colspan = cells.length - 1;
        cells.eq(1).html(node.data.itemvalue);
        cells.eq(1).prop("colspan", colspan).nextAll().remove();
    } else {
        var colspan = cells.length;
        cells.eq(0).prop("colspan", colspan).nextAll().remove();
    }
    $('.launch-tooltip').tooltip({'container': '#ccm-tooltip-holder'});
}

// jQuery Plugin
$.fn.migrationBatchTableTree = function(options) {
    return $.each($(this), function(i, obj) {
        new MigrationBatchTableTree($(this), options);
    });
}

window.MigrationBatchTableTree = MigrationBatchTableTree;
