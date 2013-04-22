<?php

class PluginSorter
{
    /**
     * @access public
     * @var modX $modx A reference to the modX object.
     */
    public $modx;
    /**
     * @access public
     * @var array $config A collection of properties to adjust Object behaviour.
     */
    public $config = array();

    public $prefix;

    /**
     * Constructs the PluginSorter object
     *
     * @param modX &$modx A reference to the modX object
     * @param array $config An array of configuration options
     */
    function __construct(modX &$modx, array $config = array())
    {
        $this->modx =& $modx;
        $this->prefix = $prefix = strtolower(get_class($this));

        $basePath = $this->modx->getOption("{$prefix}.core_path", $config, $this->modx->getOption('core_path') . "components/{$prefix}/");
        $assetsPath = $this->modx->getOption("{$prefix}.assets_path" , $config, $this->modx->getOption('assets_path') . "components/{$prefix}/");
        $assetsUrl = $this->modx->getOption("{$prefix}.assets_url" , $config, $this->modx->getOption('assets_url') . "components/{$prefix}/");
        $managerPath = $this->modx->getOption("{$prefix}.manager_path" , $config, $this->modx->getOption('manager_path') . "components/{$prefix}/");
        $managerUrl = $this->modx->getOption("{$prefix}.manager_url" , $config, $this->modx->getOption('manager_url') . "components/{$prefix}/");

        $this->config = array_merge(array(
            'core_path' => $basePath,
            'assets_path' => $assetsPath,
            'model_path' => $basePath . 'model/',
            'processors_path' => $basePath . 'processors/',

            'migrations_path' => $basePath . 'migrations/',

            'use_autoloader' => false,
            'vendor_path' => $basePath . 'vendor/',

            'assets_url' => $assetsUrl,
            'js_url' => $assetsUrl . 'web/js/',
            'css_url' => $assetsUrl . 'web/css/',
            'connector_url' => $managerUrl . 'connector.php',
            'mgr_js_url' => $managerUrl . 'js/',
            'mgr_css_url' => $managerUrl . 'css/',

            'debug' => $this->modx->getOption("{$prefix}.debug", null, false),
            'debug_user' => null,
            'debug_user_id' => null,
        ), $config);

        $this->modx->lexicon->load('pluginsorter:default');
        if ($this->modx->getOption('debug', $this->config)) $this->initDebug();
        if ($this->config['use_autoloader']) require_once $this->config['vendor_path'] . 'autoload.php';
    }

    /**
     * Automatically sort plugins, like MODX would execute per default, for the given event
     *
     * @param string $event The event name
     */
    public function autoSort($event)
    {
        $c = $this->modx->newQuery('modPluginEvent');
        $c->rightJoin('modPlugin', 'Plugin');
        $c->where(array(
            'event' => $event,
        ));
        $c->sortby('Plugin.disabled', 'ASC');
        $c->sortby('priority', 'ASC');
        $c->sortby('Plugin.name', 'ASC');

        $collection = $this->modx->getCollection('modPluginEvent', $c);
        /** @var modPluginEvent $object */
        $idx = 0;
        foreach ($collection as $object) {
            $object->set('priority', $idx);
            $object->save();
            $idx += 1;
        }
    }

    private function initDebug()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', true);
        //$this->modx->setLogTarget('FILE');
        $this->modx->setLogLevel(modX::LOG_LEVEL_INFO);

//        $debugUser = !isset($this->config['debug_user']) ? $this->modx->user->get('username') : 'anonymous';
//        $user = $this->modx->getObject('modUser', array('username' => $debugUser));
//        if ($user == null) {
//            $this->modx->user->set('id', $this->modx->getOption('debug_user_id', $this->config, 1));
//            $this->modx->user->set('username', $debugUser);
//        } else {
//            $this->modx->user = $user;
//        }
    }
}
