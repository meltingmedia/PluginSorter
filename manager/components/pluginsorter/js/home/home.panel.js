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
        ,items: [{
            html: '<h2>' + _('pluginsorter') + '</h2>'
            ,border: false
            ,cls: 'modx-page-header'
        },{
            layout: 'anchor'
            ,items: [{
                html: _('pluginsorter.management_desc')
                ,border: false
                ,bodyCssClass: 'panel-desc'
            },{
                xtype: 'pluginsorter-grid-plugins'
                ,cls: 'main-wrapper'
                ,preventRender: true
            }]
        }]
    });
    PluginSorter.panel.Home.superclass.constructor.call(this, config);
};
Ext.extend(PluginSorter.panel.Home, MODx.Panel);
Ext.reg('pluginsorter-panel-home', PluginSorter.panel.Home);
