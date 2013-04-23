<?php

class SortPlugins extends modProcessor
{
    public $classKey = 'modPluginEvent';
    public $rankField = 'priority';
    /** @var xPDOObject */
    public $object;
    public $method;
    /** @var PluginSorter */
    public $sorter;

    public function initialize()
    {
        $this->sorter =& $this->modx->pluginsorter;
        return parent::initialize();
    }

    public function process()
    {
        if (!$this->getObject()) {
            return $this->failure($this->modx->lexicon('pluginsorter.plugin_err_nf'));
        }
        // Target the impacted links if any
        $c = $this->modx->newQuery($this->classKey);
        $c->where(array(
            'event' => $this->object->get('event'),
            'pluginid:!=' => $this->object->get('pluginid'),
        ));
        $c->where($this->getCriteria());

        $method = $this->method;
        $collection = $this->modx->getIterator($this->classKey, $c);
        /** @var xPDOObject $object */
        foreach ($collection as $object) {
            $this->$method($object);
            $object->save();
        }
        // Update the source rank to the targeted one
        $this->object->set($this->rankField, $this->getProperty($this->rankField));
        $this->object->save();
        $this->sorter->refreshCache();

        return $this->success('', $this->object);
    }

    /**
     * Get the targeted link
     * @return null|object
     */
    public function getObject()
    {
        $eventName = $this->getProperty('event');
        $id = $this->getProperty('pluginid');
        if (!$eventName || !$id) return false;

        $this->object = $this->modx->getObject($this->classKey, array(
            'pluginid' => $this->getProperty('pluginid'),
            'event' => $this->getProperty('event'),
        ));

        return $this->object;
    }

    /**
     * Return the proper criteria for the current case
     * @return array
     */
    public function getCriteria()
    {
        $current = $this->object->get($this->rankField);
        $new = $this->getProperty($this->rankField);

        if ($new > $current) {
            // Moving down source
            $criteria = array(
                $this->rankField . ':>' => $current,
                $this->rankField . ':<=' => $new,
            );
            $this->method = 'decrement';
        } else {
            // Moving up source
            $criteria = array(
                $this->rankField . ':>=' => $new,
                $this->rankField . ':<' => $current,
            );
            $this->method = 'increment';
        }

        return $criteria;
    }

    /**
     * Increment the rank of the given link
     * @param xPDOObject $object
     */
    public function decrement(xPDOObject $object)
    {
        $object->set($this->rankField, $object->get($this->rankField) - 1);
    }

    /**
     * Decrement the rank of the given link
     * @param xPDOObject $object
     */
    public function increment(xPDOObject $object)
    {
        $object->set($this->rankField, $object->get($this->rankField) + 1);
    }
}

return 'SortPlugins';
