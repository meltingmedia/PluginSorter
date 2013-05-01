<?php
/**
 * Build the setup options form.
 *
 * @var modX $modx
 * @var array $options
 *
 * @package pluginsorter
 * @subpackage build
 */

if (!function_exists('loadSetupStrings')) {
    /**
     * @param modX $modx
     * @param array $options
     *
     * @return array
     */
    function loadSetupStrings($modx, $options)
    {
        $path = $modx->getOption('core_path') . 'packages/' . $options['signature'] .'/';
        $lang = $modx->getOption('manager_language', null, $modx->getOption('cultureKey', null, 'en'));
        $file = 'setup.inc.php';

        $search = strtolower(str_replace(' ', '', $options['package_name'])) . '/lexicon';
        $length = strlen($search);
        $lexicon = false;

        $directories = new RecursiveIteratorIterator(
            new ParentIterator(new RecursiveDirectoryIterator($path)),
            RecursiveIteratorIterator::SELF_FIRST
        );
        // Search for the lexicon folder
        foreach ($directories as $directory) {
            if (substr($directory, - $length) == $search) {
                $lexicon = $directory;
                break;
            }
        }
        if (!file_exists($lexicon . '/' . $lang)) {
            // Fallback to english
            $lang = 'en';
        }
        $load = $lexicon . '/' . $lang . '/' . $file;

        /** @var $_lang array */
        include_once($load);

        return $_lang;
    }
}
// Load lexicons
/** @var array $_lang */
$lexicons = loadSetupStrings($modx, $options);

// Build the setup form
$output = array(
    'intro' => $lexicons['pluginsorter.o_intro'],
    'auto_sort' => $lexicons['pluginsorter.o_auto_sort'],
    'auto_refresh' => $lexicons['pluginsorter.o_auto_refresh'],
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
