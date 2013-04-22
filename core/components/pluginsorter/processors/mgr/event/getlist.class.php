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
        $query = $this->getProperty('query');
        if (!empty($query)) {
            $c->where(array(
                'name:LIKE' => '%'.$query.'%'
            ));
        }

        return $c;
    }
}

return 'ListEvents';