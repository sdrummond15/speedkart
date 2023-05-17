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
class modQualificationPilotHelper
{
    public static function getPilotoPontosEtapa()
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('s.id AS id_etapa, 
                        s.title AS etapa, 
                        s.photo AS podio, 
                        s.photo2 AS podio2, 
                        r.id_pilot AS id_pilot, 
                        p.name AS piloto, 
                        p.grupo AS grupo, 
                        t.title AS equipe');
        $query->from('#__results As r');
        $query->join('LEFT', '#__stages AS s ON r.id_stage = s.id');
        $query->join('LEFT', '#__pilots AS p ON r.id_pilot = p.id');
        $query->join('LEFT', '#__teams AS t ON p.id_team = t.id');
        $query->where('s.id = ' . self::getStage());
        $query->order('r.position ASC');
        $db->setQuery($query);
        $rows = (array)$db->loadObjectList();

        return $rows;
    }

    public static function getStage()
    {

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('MAX(id_stage) AS stage');
        $query->from('#__results');
        $query->where('published = 1');
        $db->setQuery($query);
        $rows = (array)$db->loadObjectList();

        $id = $rows[0]->stage;

        return $id;
    }

}