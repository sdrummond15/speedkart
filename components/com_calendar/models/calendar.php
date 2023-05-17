<?php

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');


class CalendarModelCalendar extends JModelLegacy
{
    public function getCalendar(){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('s.title AS etapa, s.grid_order AS grid, s.date AS data, k.title AS kartodromo, s.hour AS hora,c.id AS id_circuito, c.title AS circuito, ch.title AS campeonato, ch.year AS ano');
        $query->from('#__stages AS s');
        $query->join('LEFT', '#__circuits AS c ON s.id_circuit = c.id');
        $query->join('LEFT', '#__championships AS ch ON s.id_championship = ch.id');
        $query->join('LEFT', '#__kartings AS k ON c.id_karting = k.id');
        $query->where('id_championship = (Select MAX(id_championship) from #__stages)');
        $query->order('s.id');

        $db->setQuery($query);
        $rows = (array) $db->loadObjectList();

        return $rows;
    }

}