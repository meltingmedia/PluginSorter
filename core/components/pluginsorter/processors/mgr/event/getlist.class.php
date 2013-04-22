<?php

class ListEvents extends modObjectGetListProcessor
{
    public $classKey = 'modEvent';
    public $languageTopics = array('pluginsorter:default');
    public $defaultSortField = 'name';
    public $defaultSortDirection = 'ASC';
    public $objectType = 'modevent';

    public function prepareQueryBeforeCount(xPDOQuery $c)
    {
        $c->leftJoin('modPluginEvent', 'PluginEvents');
        $c->select(array(
            $this->modx->getSelectColumns($this->classKey, $this->classKey),
            'total' => 'COUNT(PluginEvents.pluginid)'
        ));

        $query = $this->getProperty('query');
        if (!empty($query)) {
            $c->where(array(
                'name:LIKE' => '%'.$query.'%'
            ));
        }

        return $c;
    }

    public function prepareQueryAfterCount(xPDOQuery $c)
    {
        $c->groupby($this->defaultSortField, $this->defaultSortDirection);

        return $c;
    }

    public function beforeIteration(array $list)
    {
        $list[] = array(
            'name' => $this->modx->lexicon('pluginsorter.all_events'),
            'total' => 0,
        );

        return $list;
    }
}

return 'ListEvents';
