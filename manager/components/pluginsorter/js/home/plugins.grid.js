Ext.ns('PluginSorter');
/**
 * @class PluginSorter.PluginsGrid
 * @extends MODx.grid.Grid
 * @param config
 * @xtype pluginsorter-grid-plugins
 */
PluginSorter.PluginsGrid = function(config) {
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


        ,sm: new Ext.grid.RowSelectionModel({
            singleSelect: true
            ,listeners: {
                beforerowselect: function(sm, idx, keep, record) {
                    sm.grid.ddText = '<div>'+ _('pluginsorter.sort', {name: record.data.plugin_name }) +'</div>';
                }
            }
        })

        ,columns: [{
            header: _('pluginsorter.plugin_priority')
            ,dataIndex: 'priority'
            ,sortable: false
            ,fixed: true
            ,width: 80
        },{
            header: _('plugin')
            ,dataIndex: 'plugin_name'
            ,sortable: false
        },{
            header: _('event')
            ,dataIndex: 'event'
            ,sortable: false
        },{
            header: _('disabled')
            ,dataIndex: 'plugin_disabled'
            ,sortable: false
            ,fixed: true
            ,width: 80
            ,renderer: this.rendYesNo
        }]

        ,tbar: [{
            xtype: 'pluginsorter-combo-events'
            ,value: _('pluginsorter.all_events')
            ,id: 'event-filter'
            ,listeners: {
                select: {
                    fn: function(elem, rec, idx) {
                        this.baseParams.event = rec.data.name;
                        this.getStore().reload();
                    }
                    ,scope: this
                }
            }
        }, {
            text: _('pluginsorter.automatic_sort')
            ,id: 'event-sorter'
            ,listeners: {
                click: {
                    fn: function() {
                        var event = Ext.getCmp('event-filter').getValue();
                        MODx.Ajax.request({
                            url: this.config.url
                            ,params: {
                                action: 'plugin/autosort'
                                ,event: (event != _('pluginsorter.all_events')) ? event : ''
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

    PluginSorter.PluginsGrid.superclass.constructor.call(this, config);
    this.addEvents('sort');
    this.on('sort', this.onSort, this);
};

Ext.extend(PluginSorter.PluginsGrid, MODx.grid.Grid, {

    onSort: function(o) {
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

    ,getMenu: function() {
        var m = [];
        m.push({
            text: _('pluginsorter.toggle_status')
            ,handler: this.toggleStatus
        });
        m.push('-');
        m.push({
            text: _('pluginsorter.remove_event')
            ,handler: this.removeFromEvent
        });
        this.addContextMenuItem(m);
    }

    ,toggleStatus: function() {
        var rec = this.menu.record;
        MODx.Ajax.request({
            url: this.config.url
            ,params: {
                action: 'plugin/toggleStatus'
                ,pluginid: rec.pluginid
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

    ,removeFromEvent: function() {
        var rec = this.menu.record;
        MODx.Ajax.request({
            url: this.config.url
            ,params: {
                action: 'plugin/removeEvent'
                ,pluginid: rec.pluginid
                ,event: rec.event
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

    ,rendYesNo: function(v,md) {
        if (v === 1 || v == '1') { v = true; }
        if (v === 0 || v == '0') { v = false; }
        switch (v) {
            case true:
            case 'true':
            case 1:
                md.css = 'red';
                return _('yes');
            case false:
            case 'false':
            case '':
            case 0:
                md.css = 'green';
                return _('no');
        }
    }
});
Ext.reg('pluginsorter-grid-plugins', PluginSorter.PluginsGrid);

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
        ,fields: ['name', 'total']
        ,triggerAction : 'all'
        ,lazyRender: true
        ,editable : true
        ,minChars: 1
        ,url: PluginSorter.config.connector_url
        ,listWidth: 300
        ,tpl: '<tpl for="."><div class="x-combo-list-item">{name} ({total})</div></tpl>'
        ,baseParams: {
            action: 'event/getlist'
            ,combo: true
        }
    });
    PluginSorter.EventsCombo.superclass.constructor.call(this, config);
};
Ext.extend(PluginSorter.EventsCombo, MODx.combo.ComboBox);
Ext.reg('pluginsorter-combo-events', PluginSorter.EventsCombo);
