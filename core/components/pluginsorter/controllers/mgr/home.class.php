<?php

class PluginSorterMgrHomeManagerController extends PluginSorterManagerController
{

    public function getPageTitle()
    {
        return $this->modx->lexicon('pluginsorter');
    }

    public function loadCustomCssJs()
    {
        $this->addJavascript($this->jsURL . 'home/cmpitem.grid.js');
        $this->addJavascript($this->jsURL . 'home/home.panel.js');

        $this->addHtml('<script type="text/javascript">
            Ext.onReady(function() {
                MODx.add("pluginsorter-panel-home");
            });
        </script>');
    }
}
