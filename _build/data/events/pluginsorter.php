<?php
/**
 * @var modX $modx
 */
$events = array();

$ventName = 'OnPluginEventBeforeSave';
$events[$ventName] = $modx->newObject('modPluginEvent');
$events[$ventName]->fromArray(array(
'event' => $ventName,
'priority' => 0,
'propertyset' => 0,
), '', true, true);

$ventName = 'OnPluginEventRemove';
$events[$ventName] = $modx->newObject('modPluginEvent');
$events[$ventName]->fromArray(array(
'event' => $ventName,
'priority' => 0,
'propertyset' => 0,
), '', true, true);

return $events;