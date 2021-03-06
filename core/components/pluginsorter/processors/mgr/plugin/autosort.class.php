<?php

class AutoSort extends modProcessor
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
        if (!$event = $this->getProperty('event', false)) {
            $events = $this->getEvents();
        } else {
            $events = array(
                $event,
            );
        }

        foreach ($events as $name) {
            if ($name == '') continue;
            $this->sorter->autoSort($name);
        }

        $this->sorter->refreshCache();

        return $this->success();
    }

    /**
     * Get the whole modEvent names list
     *
     * @return array The events names
     */
    public function getEvents()
    {
        $output = array();
        $collection = $this->modx->getCollection('modEvent');
        /** @var modEvent $event */
        foreach ($collection as $event) {
            $output[] = $event->get('name');
        }

        return $output;
    }
}

return 'AutoSort';
