Ext.ns('PluginSorter.grid');
/**
 * @class PluginSorter.grid.CmpItem
 * @extends MODx.grid.Grid
 * @param config
 * @xtype pluginsorter-grid-plugins
 */
PluginSorter.grid.CmpItem = function(config) {
    config = config || {};

    Ext.applyIf(config, {
        id: 'pluginsorter-grid-cmpitem'
        ,url: PluginSorter.config.connector_url
        ,baseParams: {
            action: 'plugin/getList'
        }
        ,fields: ['pluginid', 'event', 'priority', 'plugin_name', 'plugin_disabled']
        ,paging: true
        ,autosave: true
        ,remoteSort: true
        ,anchor: '100%'

        ,ddGroup: 'plugins'
        ,enableDragDrop: true

        ,singleText: _('plugin')
        ,pluralText: _('plugins')

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

        ,tbar: [{
            xtype: 'pluginsorter-combo-events'
            ,listeners: {
                select: {
                    fn: function(elem, rec, idx) {
                        this.baseParams.event = rec.data.name;
                        this.getStore().reload();
                    }
                    ,scope: this
                }
            }
        }]


        ,listeners: {
            render: {
                scope: this
                ,fn: function(grid) {
                    this.dropTarget = new Ext.dd.DropTarget(grid.getView().mainBody, {
                        ddGroup: 'plugins'
                        ,copy: false
                        ,notifyOver: function(dragSource, e, data) {
                            if (dragSource.getDragData(e)) {
                                var targetNode = dragSource.getDragData(e).selections[0]
                                    ,sourceNode = data.selections[0];

                                if (sourceNode.data.event != targetNode.data.event) {
                                    return this.dropNotAllowed;
                                }
                            }

                            return this.dropAllowed;
                        }
                        ,notifyDrop: function(dragSource, e, data) {
                            var sm = grid.getSelectionModel()
                                ,rows = sm.getSelections();

                            if (dragSource.getDragData(e)) {
                                var targetNode = dragSource.getDragData(e).selections[0]
                                    ,sourceNode = data.selections[0];

                                if ((targetNode.id != sourceNode.id) && (targetNode.data.category === sourceNode.data.category)) {
                                    grid.fireEvent('sort', {
                                        target: targetNode
                                        ,source: sourceNode
                                        ,event: e
                                        ,dragZone: dragSource
                                    });
                                }
                            }
                        }
                    });
                }
            }
        }
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

    PluginSorter.grid.CmpItem.superclass.constructor.call(this, config);
    this.addEvents('sort');
    this.on('sort', this.onSort, this);
};

Ext.extend(PluginSorter.grid.CmpItem, MODx.grid.Grid, {

    onSort: function(o) {
        console.log(o);


        MODx.Ajax.request({
            url: this.config.url
            ,params: {
                action: 'plugin/sort'
                ,pluginid: o.source.data.pluginid
                ,event: o.source.data.event
                ,priority: o.target.data.priority
            }
            ,listeners: {
                success: {
                    fn: function(r) {
                        this.refresh();
                    }
                    ,scope: this
                }
            }
        });
    }
});
Ext.reg('pluginsorter-grid-plugins', PluginSorter.grid.CmpItem);

PluginSorter.EventsCombo = function(config) {
    config = config || {};

    Ext.applyIf(config, {
        name : 'event'
        ,hiddenName : 'event'
        ,pageSize: 20
        ,forceSelection: true
        ,selectOnFocus: true
        ,displayField : 'name'
        ,valueField : 'name'
        ,fields: ['name']
        ,triggerAction : 'all'
        ,lazyRender: true
        ,editable : true
        ,minChars: 1
        ,url: PluginSorter.config.connector_url
        ,listWidth: 300
        ,baseParams: {
            action: 'event/getlist'
            ,combo: true
        }
    });
    PluginSorter.EventsCombo.superclass.constructor.call(this, config);
};
Ext.extend(PluginSorter.EventsCombo, MODx.combo.ComboBox);
Ext.reg('pluginsorter-combo-events', PluginSorter.EventsCombo);
