<?php

require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php';
require_once MODX_CORE_PATH.'config/'. MODX_CONFIG_KEY .'.inc.php';
require_once MODX_CONNECTORS_PATH . 'index.php';

$corePath = $modx->getOption('pluginsorter.core_path', null, $modx->getOption('core_path') . 'components/pluginsorter/');
require_once $corePath . 'model/pluginsorter/pluginsorter.class.php';
$modx->pluginsorter = new PluginSorter($modx);

// handle request
$path = $modx->getOption('processors_path', $modx->pluginsorter->config, $corePath . 'processors/');
$modx->request->handleRequest(array(
    'processors_path' => $path,
    'location' => '',
));
