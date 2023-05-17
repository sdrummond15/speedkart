<?php

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');


class PilotsModelPilots extends JModelLegacy
{
    public function getPilots()
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('p.id AS id_piloto, p.name AS piloto, t.title AS equipe, p.photo AS foto');
        $query->from('#__pilots As p');
        $query->join('LEFT', '#__teams AS t ON p.id_team = t.id');
        $query->where('p.published = 1');
        $query->order('piloto');

        $db->setQuery($query);

        $rows = (array)$db->loadObjectList();

        return $rows;
    }

}