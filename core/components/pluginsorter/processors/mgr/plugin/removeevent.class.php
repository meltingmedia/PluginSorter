<?php

class RemoveEvent extends modProcessor
{
    public $classKey = 'modPluginEvent';
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
        /** @var modPluginEvent $event */
        $event = $this->modx->getObject($this->classKey, array(
            'event' => $this->getProperty('event'),
            'pluginid' => $this->getProperty('pluginid'),
        ));
        if (!$event) return $this->failure();

        $event->remove();

        $this->sorter->autoSort($this->getProperty('event'));
        $this->sorter->refreshCache();

        return $this->success();
    }
}

return 'RemoveEvent';
