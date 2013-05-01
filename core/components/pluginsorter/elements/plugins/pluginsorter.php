<?php
/**
 * This plugin automatically sets (or fix) the plugin rank.
 *
 * @var modX $modx
 */

if ($modx->context->get('key') != 'mgr') return '';
$params = $modx->event->params;

/** @var modPluginEvent $event */
$event =& $params['pluginEvent'];
$priority = $event->get('priority', 0);

switch ($modx->event->name) {
    case 'OnPluginEventBeforeSave':
        if ($params['mode'] == modSystemEvent::MODE_NEW) {
            if ($priority == '0') {
                // Make sure we only deal with 'priority 0' events
                $already = $modx->getObject('modPluginEvent', array(
                    'event' => $event->get('event'),
                    'pluginid:!=' => $event->get('pluginid'),
                    'priority' => 0,
                ));
                if ($already !== false) {
                    // There is a plugin event with that priority already
                    $c = $modx->newQuery('modPluginEvent');
                    $c->where(array(
                        'event' => $event->get('event'),
                        'pluginid:!=' => $event->get('pluginid'),
                    ));

                    $priority = $modx->getCount('modPluginEvent', $c);
                    $event->set('priority', $priority);
                }
            }
        }
        break;
    case 'OnPluginEventRemove':
        $c = $modx->newQuery('modPluginEvent');
        $c->where(array(
            'event' => $event->get('event'),
            'priority:>' => $priority,
        ));

        $collection = $modx->getCollection('modPluginEvent', $c);
        /** @var modPluginEvent $vent */
        foreach ($collection as $vent) {
            $vent->set('priority', ($vent->get('priority') - 1));
            $vent->save();
        }

        break;
}

return '';
