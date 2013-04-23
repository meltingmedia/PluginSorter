<?php

if ($object->xpdo) {

    /** @var $modx modX */
    $modx =& $object->xpdo;

    if ($options['auto_sort']) {
        $modx->log(modX::LOG_LEVEL_INFO, 'Automatic sorting of existing plugins events in progress…');
        $rootPath = $modx->getOption('pluginsorter.core_path', null, $modx->getOption('core_path') . 'components/pluginsorter/');
        $modelPath = $rootPath . 'model/pluginsorter/';
        /** @var $service PluginSorter */
        $service = $modx->getService('PluginSorter', 'pluginsorter', $modelPath);
        if (!$service || !($service instanceof PluginSorter)) {
            $modx->log(modX::LOG_LEVEL_ERROR, 'Problem with service class');
        } else {
            $events = $modx->getCollection('modEvent');
            /** @var modEvent $event */
            foreach ($events as $event) {
                $name = $event->get('name');
                if ('' == $name) continue;
                $service->autoSort($name);
            }

            $modx->log(modX::LOG_LEVEL_INFO, 'Sorting done.');
        }
    }

    if ($options['auto_refresh']) {
        $modx->log(modX::LOG_LEVEL_INFO, 'Activating automatic cache refresh…');

        /** @var modSystemSetting $setting */
        $setting = $modx->getObject('modSystemSetting', 'pluginsorter.refresh_cache');
        if (!$setting) {
            $setting = $modx->newObject('modSystemSetting');
            $setting->fromArray(array(
                'key' => 'pluginsorter.refresh_cache',
                'xtype' => 'combo-boolean',
                'namespace' => 'pluginsorter',
                'area' => '',
            ), '', true, true);
        }
        $setting->set('value', '1');
        $setting->save();

        $modx->log(modX::LOG_LEVEL_INFO, 'Activation done.');
    }
}
