Ext.ns('PluginSorter.panel');
/**
 * @class PluginSorter.panel.Home
 * @extends MODx.Panel
 * @param {Object} config
 * @xtype pluginsorter-panel-home
 */
PluginSorter.panel.Home = function(config) {
    config = config || {};

    Ext.apply(config, {
        border: false
        ,baseCls: 'modx-formpanel'
        ,cls: 'container'
        ,items: this.buildLayout()
    });
    PluginSorter.panel.Home.superclass.constructor.call(this, config);
};
Ext.extend(PluginSorter.panel.Home, MODx.Panel, {
    buildLayout: function() {
        var layout = [];
        // Header/title
        layout.push({
            html: '<h2>' + _('pluginsorter.management') + '</h2>'
            ,border: false
            ,cls: 'modx-page-header'
        });
        // Tab(s)
        layout.push({
            xtype: 'modx-tabs'
            ,defaults: {
                border: false
                ,autoHeight: true
                ,layout: 'anchor'
            }
            ,border: true
            ,items: this.buildTabs()
        });
        return layout;
    }
    // Build the tabs
    ,buildTabs: function() {
        var tabs = [];
        // Main tab
        tabs.push({
            title: _('pluginsorter')
            ,defaults: {
                autoHeight: true
            }
            ,items: [{
                html: _('pluginsorter.management_desc')
                ,border: false
                ,bodyCssClass: 'panel-desc'
            },{
                xtype: 'pluginsorter-grid-cmpitem'
                ,cls: 'main-wrapper'
                ,preventRender: true
            }]
        });
        return tabs;
    }
});
Ext.reg('pluginsorter-panel-home', PluginSorter.panel.Home);
