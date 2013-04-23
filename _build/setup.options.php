<?php
/**
 * Build the setup options form.
 *
 * @package pluginsorter
 * @subpackage build
 */
// set some default values

// Build the setup form
$output = array(
    'intro' => '
<h2>PluginSorter Installer</h2>
<p>Thanks for installing PluginSorter!<br />There are several options you might consider before going on : </p><br />
<p>
    <ol>
        <li>- Automatically sort events is <b>required for PluginSorter to work</b> properly. You can safely skip this right now since you will be able to do it later from the CMP.</li>
        <li>- Automatically refresh MODX cache refreshes the cache when needed. If you know what you are doing, you can safely skip this, and manually clear the cache when you need to. If you enable this option, you can disable it later in the system settings.</li>
    </ol>
</p><br />',

    'auto_sort' => '
<label for="auto_sort">
<input type="checkbox" name="auto_sort" id="auto_sort" value="true" />&nbsp;Automatically sort existing events</label>',

    'auto_refresh' => '
<label for="auto_refresh">
<input type="checkbox" name="auto_refresh" id="auto_refresh" value="true" />&nbsp;Automatically refresh MODX cache when needed</label>',

    'end' => '<br /><br />'
);

// Display the form
switch ($options[xPDOTransport::PACKAGE_ACTION]) {
    case xPDOTransport::ACTION_INSTALL:
    case xPDOTransport::ACTION_UPGRADE:
        return implode("\n", $output);
        break;
    case xPDOTransport::ACTION_UNINSTALL:
        break;
}

return $output;
