<?php

class ListPlugins extends modObjectGetListProcessor
{
    public $classKey = 'modPluginEvent';
    public $languageTopics = array('pluginsorter:default');
    public $defaultSortField = 'modPluginEvent.priority';
    public $defaultSortDirection = 'ASC';
    public $objectType = 'modpluginevent';

    public function prepareQueryBeforeCount(xPDOQuery $c)
    {
        $c->rightJoin('modPlugin', 'Plugin');
        $c->select(array(
            $this->modx->getSelectColumns($this->classKey, $this->classKey),
            $this->modx->getSelectColumns('modPlugin', 'Plugin', 'plugin_', array('name', 'disabled')),
        ));

        $event = $this->getProperty('event');
        if (!empty($event)) {
            $c->where(array(
                'event' => $event,
            ));
        }

        return $c;
    }


    public function getData()
    {
        $data = array();
        $limit = intval($this->getProperty('limit'));
        $start = intval($this->getProperty('start'));

        /* query for chunks */
        $c = $this->modx->newQuery($this->classKey);
        $c = $this->prepareQueryBeforeCount($c);
        $data['total'] = $this->modx->getCount($this->classKey,$c);
        $c = $this->prepareQueryAfterCount($c);

        $sortClassKey = $this->getSortClassKey();
        $sortKey = $this->modx->getSelectColumns($sortClassKey,$this->getProperty('sortAlias',$sortClassKey),'',array($this->getProperty('sort')));
        if (empty($sortKey)) $sortKey = $this->getProperty('sort');

        $c->sortby('event', 'ASC');
        $c->sortby('priority', 'ASC');
        $c->sortby('Plugin.name', 'ASC');
        //$c->sortby($sortKey,$this->getProperty('dir'));

        if ($limit > 0) {
            $c->limit($limit,$start);
        }

//        $c->prepare();
//        $this->modx->log(modX::LOG_LEVEL_INFO, $c->toSQL());

        $data['results'] = $this->modx->getCollection($this->classKey,$c);
        return $data;
    }
}

return 'ListPlugins';
