<?php

class ToggleStatus extends modProcessor
{
    public $classKey = 'modPlugin';
    /** @var modPlugin */
    public $object;
    /** @var PluginSorter */
    public $sorter;

    public function initialize()
    {
        $this->sorter =& $this->modx->pluginsorter;
        return parent::initialize();
    }

    public function process()
    {
        //$this->modx->log(modX::LOG_LEVEL_INFO, print_r($this->getProperties(), true));

        $this->object = $this->modx->getObject($this->classKey, $this->getProperty('pluginid'));
        if (!$this->object) return $this->failure();

        $this->object->set('disabled', !($this->object->get('disabled')));
        $this->object->save();
        $this->sorter->refreshCache();

        return $this->success('', $this->object);
    }
}

return 'ToggleStatus';
