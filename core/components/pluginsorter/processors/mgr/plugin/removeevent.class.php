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
        $eventName = $this->getProperty('event');
        $id = $this->getProperty('pluginid');
        if (!$eventName || !$id) return $this->failure();

        /** @var modPluginEvent $event */
        $event = $this->modx->getObject($this->classKey, array(
            'event' => $eventName,
            'pluginid' => $id,
        ));
        if (!$event) return $this->failure();

        if (true !== $event->remove()) {
            return $this->failure('Error while removing the modPluginEvent');
        }

        $this->sorter->autoSort($eventName);
        $this->sorter->refreshCache();

        return $this->success();
    }
}

return 'RemoveEvent';
