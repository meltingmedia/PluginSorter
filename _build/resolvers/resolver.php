<?php

if ($object->xpdo) {

    /** @var $modx modX */
    $modx =& $object->xpdo;
    $modx->lexicon->load('pluginsorter:setup');

    $modx->setOption('cultureKey', $modx->getOption('manager_language'));

    $prefix = 'pluginsorter.setup_';

    if ($options['auto_sort']) {
        $modx->log(modX::LOG_LEVEL_INFO, $modx->lexicon("{$prefix}sorting_start"));
        $rootPath = $modx->getOption('pluginsorter.core_path', null, $modx->getOption('core_path') . 'components/pluginsorter/');
        $modelPath = $rootPath . 'model/pluginsorter/';
        /** @var $service PluginSorter */
        $service = $modx->getService('PluginSorter', 'pluginsorter', $modelPath);
        if (!$service || !($service instanceof PluginSorter)) {
            $modx->log(modX::LOG_LEVEL_ERROR, $modx->lexicon("{$prefix}service_error"));
        } else {
            $events = $modx->getCollection('modEvent');
            /** @var modEvent $event */
            foreach ($events as $event) {
                $name = $event->get('name');
                if ('' == $name) continue;
                $service->autoSort($name);
            }

            $modx->log(modX::LOG_LEVEL_INFO, $modx->lexicon("{$prefix}sorting_done"));
        }
    }

    if ($options['auto_refresh']) {
        $modx->log(modX::LOG_LEVEL_INFO, $modx->lexicon("{$prefix}autocache_start"));

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

        // temporary fix
        $modx->setOption('cultureKey', $modx->getOption('manager_language'));

        $modx->log(modX::LOG_LEVEL_INFO, $modx->lexicon("{$prefix}autocache_done"));
    }
}
