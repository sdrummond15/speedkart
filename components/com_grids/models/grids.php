<?php

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');


class GridsModelGrids extends JModelLegacy
{
    public function getGrids()
    {

        $id_stage = $_GET['id_stage'];
        $id_championship = $_GET['id_championship'];

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('g.positions AS positions,'
            . 'g.id_stage AS etapa,'
            . 's.title AS nome_etapa,'
            . 's.date AS data,'
            . 's.hour AS hora,'
            . 'k.title AS kartodromo,'
            . 'c.title AS circuito,'
            . 'c.image AS img_circuito,'
            . 'ch.year AS ano,'
            . 's.id_championship');
        $query->from('#__grids As g');
        $query->join('LEFT', '#__stages AS s ON g.id_stage = s.id');
        $query->join('LEFT', '#__circuits AS c ON s.id_circuit = c.id');
        $query->join('LEFT', '#__kartings AS k ON c.id_karting = k.id');
        $query->join('LEFT', '#__championships AS ch ON s.id_championship = ch.id');
        $query->where('g.id_stage = ' . $id_stage . ' AND s.id_championship = ' . $id_championship . ' AND g.published = 1');
        $db->setQuery($query);
        $rows = (array)$db->loadObjectList();

        return $rows;

    }

}