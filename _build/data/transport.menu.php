<?php
/**
 * Adds modActions and modMenus into package
 *
 * @var modX $modx
 * @var modAction $action
 * @var modMenu $menu
 * @package pluginsorter
 * @subpackage build
 */
$action = $modx->newObject('modAction');
$action->fromArray(array(
    'id' => 1,
    'namespace' => 'pluginsorter',
    'parent' => 0,
    'controller' => 'index',
    'haslayout' => true,
    'lang_topics' => 'pluginsorter:default',
    'assets' => '',
), '', true, true);

$menu = $modx->newObject('modMenu');
$menu->fromArray(array(
    'text' => 'pluginsorter',
    'parent' => 'components',
    'description' => 'pluginsorter.menu_desc',
    'icon' => 'images/icons/plugin.gif',
    'menuindex' => 0,
    'params' => '',
    'handler' => '',
    'permissions' => 'save_plugin',
//    'action' => '',
//    'namespace' => '',
), '', true, true);
$menu->addOne($action);
unset($menus);

return $menu;