<?php
/**
 * Setup French Lexicon Entries for PluginSorter
 *
 * @package pluginsorter
 * @subpackage lexicon
 */
$_lang['pluginsorter.setup_service_error'] = 'Problème lors du chargement du service';
$_lang['pluginsorter.setup_sorting_start'] = 'Classement des évènements existants en cours…';
$_lang['pluginsorter.setup_sorting_done'] = 'Classement effectué.';
$_lang['pluginsorter.setup_autocache_start'] = 'Activation du rafraichissment de cache automatique…';
$_lang['pluginsorter.setup_autocache_done'] = 'Activation effectuée.';

// Options panel during setup
$_lang['pluginsorter.o_intro'] = '
<h2>Installation de Plugin Sorter</h2>
<p>Merci d\'installer Plugin Sorter!<br />Il est possible de configurer les options suivantes : </p><br />
<p>
    <ol>
        <li>- Classer les évènements système est <b>requis pour que Plugin Sorter fonctionne</b> correctement. Vous pouvez ne pas activer cette option et effectuer le classement plus tard via la CMP.</li>
        <li>- Rafraîchir automatiquement le cache de MODX. Si vous savez ce que vous faites, vous pouvez ne pas activer cette option. Vous aurez à vider la cache manuellement pour que les changements que vous effecturez soient effectifs. Cette option est configurable via les paramètres système.</li>
    </ol>
</p><br />';

$_lang['pluginsorter.o_auto_sort'] = '
<label for="auto_sort">
<input type="checkbox" name="auto_sort" id="auto_sort" value="true" />&nbsp;Classer les évèments système</label>';


$_lang['pluginsorter.o_auto_refresh'] = '
<label for="auto_refresh">
<input type="checkbox" name="auto_refresh" id="auto_refresh" value="true" />&nbsp;Rafraîchir automatiquement le cache de MODX</label>';
