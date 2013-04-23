<?php
/**
 * Loads system settings into build
 *
 * @var modX $modx
 * @package pluginsorter
 * @subpackage build
 */
$settings = array();

$settings['pluginsorter.'] = $modx->newObject('modSystemSetting');
$settings['pluginsorter.']->fromArray(array(
    'key' => 'pluginsorter.refresh_cache',
    'value' => '0',
    'xtype' => 'combo-boolean',
    'namespace' => 'pluginsorter',
    'area' => '',
), '', true, true);

return $settings;
