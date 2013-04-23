<?php

require_once dirname(__FILE__) . '/model/pluginsorter/pluginsorter.class.php';

abstract class PluginSorterManagerController extends modManagerController
{
    /** @var PluginSorter $pluginsorter */
    public $pluginsorter;
    public $jsURL;
    public $cssURL;

    public function initialize()
    {
        $this->pluginsorter = new PluginSorter($this->modx);
        $this->jsURL = $this->pluginsorter->config['mgr_js_url'];
        $this->cssURL = $this->pluginsorter->config['mgr_css_url'];
        $this->loadBase();
        parent::initialize();
    }

    /**
     * Load the "base" required assets
     */
    public function loadBase()
    {
        //$this->addCss($this->pluginsorter->config['css_url'] . 'mgr.css');

        $this->addHtml(
'<script type="text/javascript">
    Ext.ns("PluginSorter");
    Ext.onReady(function() {
        PluginSorter.config = '. $this->modx->toJSON($this->getConfig()) .';
        PluginSorter.action = "'. (!empty($_REQUEST['a']) ? $_REQUEST['a'] : 0) .'";
    });
</script>'
        );
    }

    /**
     * Return the component config.
     * Modify this method to unset/remove some sensitive data if any
     *
     * @return array The component config
     */
    public function getConfig()
    {
        return $this->pluginsorter->config;
    }

    public function getLanguageTopics()
    {
        return array('pluginsorter:default');
    }

    public function checkPermissions()
    {
        return $this->modx->hasPermission('save_plugin');
    }

    public function getTemplateFile()
    {
        return '';
    }

    public function process(array $scriptProperties = array())
    {

    }
}

class IndexManagerController extends modExtraManagerController
{
    public static function getDefaultController()
    {
        return 'mgr/home';
    }
}
