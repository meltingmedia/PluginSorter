<?php

class ToggleStatus extends modProcessor
{
    public $classKey = 'modPlugin';
    /** @var modPlugin */
    public $object;

    public function process()
    {
        //$this->modx->log(modX::LOG_LEVEL_INFO, print_r($this->getProperties(), true));

        $this->object = $this->modx->getObject($this->classKey, $this->getProperty('pluginid'));
        if (!$this->object) return $this->failure();

        $this->object->set('disabled', !($this->object->get('disabled')));
        $this->object->save();
        $this->refreshCache();

        return $this->success('', $this->object);
    }

    public function refreshCache()
    {
        $refresh = $this->getProperty('refreshCache', false);
        if ($refresh) {
            $this->modx->log(modX::LOG_LEVEL_INFO, 'been asked to refresh the cache');
            $this->modx->cacheManager->refresh();
        }
    }
}

return 'ToggleStatus';
