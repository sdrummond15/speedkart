<?php

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');


class StagesModelCircuit extends JModelLegacy
{

    public function getCircuit()
    {

        $circuit = $_GET['id_circuito'];

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('c.title AS circuito,c.id_pilot AS id_piloto, p.name AS piloto, c.image AS foto,c.id_karting AS id_karting, k.title AS kartodromo, c.best_time AS melhor_tempo, c.date_best_time AS data');
        $query->from('#__circuits As c');
        $query->join('LEFT', '#__pilots AS p ON c.id_pilot = p.id');
        $query->join('LEFT', '#__kartings AS k ON c.id_karting = k.id');
        $query->where('c.published = 1 AND c.id =' . $circuit);

        $db->setQuery($query);
        $rows = (array)$db->loadObjectList();

        return $rows;
    }

}