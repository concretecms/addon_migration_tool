!function(global, $) {

	function MigrationBatchTableTree($table, options) {
		var my = this;
		options = options || {};
		options = $.extend({
			source: {},
			init: false,
			lazyLoad: false,
			renderColumns: false
		}, options);
		my.$table = $table;
		my.$table.fancytree({
			extensions: ["glyph","table"],
			toggleEffect: false,
			source: options.source,
			init: options.init,
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
	}

	// jQuery Plugin
	$.fn.migrationBatchTableTree = function(options) {
		return $.each($(this), function(i, obj) {
			new MigrationBatchTableTree($(this), options);
		});
	}

	global.MigrationBatchTableTree = MigrationBatchTableTree;


}(window, jQuery);