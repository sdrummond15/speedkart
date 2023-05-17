<?php

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');


class StagesModelStages extends JModelLegacy
{
    public function getStages()
    {

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('s.title AS etapa, 
                        s.id AS id_stage, 
                        ch.title AS campeonato, 
                        ch.year AS ano, 
                        s.id_circuit AS id_circuito, 
                        s.date AS data, 
                        k.title AS kartodromo, 
                        c.image AS circuito, 
                        s.photo AS podio');
        $query->from('#__stages As s');
        $query->join('LEFT', '#__circuits AS c ON s.id_circuit = c.id');
        $query->join('LEFT', '#__kartings AS k ON c.id_karting = k.id');
        $query->join('LEFT', '#__championships AS ch ON s.id_championship = ch.id');
        $query->where('s.id_championship = (SELECT MAX(id_championship) FROM sd9mk_stages)');
        $query->order('s.id');

        $db->setQuery($query);

        //echo $query;
        $rows = (array)$db->loadObjectList();

        return $rows;

    }

}