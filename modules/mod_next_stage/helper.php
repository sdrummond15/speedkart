<?php
/**
 * @copyright    Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license        GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

/**
 * @package        Joomla.Site
 * @subpackage    mod_qualification
 * @since        1.5
 */
class modNext_StageHelper
{
    public static function getDataStage()
    {

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('s.id AS id_stage, s.title AS title, s.id_championship AS id_championship, s.date AS data, c.image AS circuitoimg, s.hour AS horario, k.title AS kartodromo, c.title AS tracado');
        $query->from('#__stages As s');
        $query->join('LEFT', '#__circuits AS c ON s.id_circuit = c.id');
        $query->join('LEFT', '#__kartings AS k ON c.id_karting = k.id');
        $query->order('data');

        $db->setQuery($query);
        $rows = (array)$db->loadObjectList();
        return $rows;

    }

    public static function getGrid()
    {

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('s.id_championship AS campeonato, g.id_stage AS etapa');
        $query->from('#__grids AS g');
        $query->join('LEFT', '#__stages AS s ON s.id = g.id_stage');
        $query->where('g.published = 1');

        $db->setQuery($query);
        $rows = (array)$db->loadObjectList();

        return $rows;

    }


}