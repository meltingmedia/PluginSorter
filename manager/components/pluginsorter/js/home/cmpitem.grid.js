Ext.ns('PluginSorter.grid');
/**
 * @class PluginSorter.grid.CmpItem
 * @extends MODx.grid.Grid
 * @param config
 * @xtype pluginsorter-grid-cmpitem
 */
PluginSorter.grid.CmpItem = function(config) {
    config = config || {};

    Ext.applyIf(config, {
        id: 'pluginsorter-grid-cmpitem'
        ,url: PluginSorter.config.connector_url
        ,baseParams: {
            action: 'mgr/plugin/getList'
        }
        ,fields: ['pluginid', 'event', 'priority', 'plugin_name', 'plugin_disabled']
        ,paging: true
        ,autosave: true
        ,remoteSort: true
        ,anchor: '100%'

        ,singleText: _('linkwall.link')
        ,pluralText: _('linkwall.links')

        ,grouping: true
        ,groupBy: 'event'

        ,columns: [{
            header: 'Priority'
            ,dataIndex: 'priority'
            ,sortable: false
            ,fixed: true
            ,width: 80
        },{
            header: 'Plugin'
            ,dataIndex: 'plugin_name'
            ,sortable: false
        },{
            header: 'Event'
            ,dataIndex: 'event'
            ,sortable: false
        },{
            header: 'Disabled'
            ,dataIndex: 'plugin_disabled'
            ,sortable: false
            ,fixed: true
            ,width: 80
        }]
    });

    if (config.grouping) {
        Ext.apply(config, {
            view: new Ext.grid.GroupingView({
                forceFit: true
                //,remoteGroup: true
                ,hideGroupedColumn: true
                ,enableGroupingMenu: false
                ,enableNoGroups: false
                ,scrollOffset: 0
                ,headersDisabled: true
                ,showGroupName: false
                ,groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "'
                    +(config.pluralText || _('records')) + '" : "'
                    +(config.singleText || _('record'))+'"]})'
            })
        });
    }

    PluginSorter.grid.CmpItem.superclass.constructor.call(this, config)
};

Ext.extend(PluginSorter.grid.CmpItem, MODx.grid.Grid, {
    // Search function
    search: function(tf, nv, ov) {
        var s = this.getStore();
        s.baseParams.query = tf.getValue();
        this.getBottomToolbar().changePage(1);
        this.refresh();
    }
});
Ext.reg('pluginsorter-grid-cmpitem', PluginSorter.grid.CmpItem);
