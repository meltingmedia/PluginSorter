<?php
/**
 * Setup English Lexicon Entries for PluginSorter
 *
 * @package pluginsorter
 * @subpackage lexicon
 */
$_lang['pluginsorter.setup_service_error'] = 'Problem with service class.';
$_lang['pluginsorter.setup_sorting_start'] = 'Automatic sorting of existing plugins events in progress…';
$_lang['pluginsorter.setup_sorting_done'] = 'Sorting done.';
$_lang['pluginsorter.setup_autocache_start'] = 'Activating automatic cache refresh…';
$_lang['pluginsorter.setup_autocache_done'] = 'Activation done.';

// Options panel during setup
$_lang['pluginsorter.o_intro'] = '
<h2>Plugin Sorter Installer</h2>
<p>Thanks for installing PluginSorter!<br />There are several options you might consider before going on : </p><br />
<p>
    <ol>
        <li>- Automatically sort events is <b>required for Plugin Sorter to work</b> properly. You can safely skip this right now since you will be able to do it later from the CMP.</li>
        <li>- Automatically refresh MODX cache refreshes the cache when needed. If you know what you are doing, you can safely skip this, and manually clear the cache when you need to. If you enable this option, you can disable it later in the system settings.</li>
    </ol>
</p><br />';

$_lang['pluginsorter.o_auto_sort'] = '
<label for="auto_sort">
<input type="checkbox" name="auto_sort" id="auto_sort" value="true" />&nbsp;Automatically sort existing events</label>';


$_lang['pluginsorter.o_auto_refresh'] = '
<label for="auto_refresh">
<input type="checkbox" name="auto_refresh" id="auto_refresh" value="true" />&nbsp;Automatically refresh MODX cache when needed</label>';
