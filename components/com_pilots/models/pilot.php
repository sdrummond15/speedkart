<?php

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');


class PilotsModelPilot extends JModelLegacy
{

    public static function getPilotoDetail(){

        $piloto = $_GET['id_piloto'];

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('p.name AS nome, t.title AS equipe, p.photo_detail AS piloto, p.photo_kart AS pilotokart');
        $query->from('#__pilots As p');
        $query->join('LEFT', '#__teams AS t ON p.id_team = t.id');
        $query->where('p.published = 1 AND p.id ='.$piloto);
        $query->order('piloto');

        $db->setQuery($query);
        $rows = (array) $db->loadObjectList();

        return $rows;
    }

    public static function getCorridas(){

        $piloto = $_GET['id_piloto'];

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('COUNT(r.id_pilot) AS qtd_corridas');
        $query->from('#__results As r');
        $query->where('r.id_pilot ='.$piloto);

        $db->setQuery($query);
        $rows = (array) $db->loadObjectList();

        return $rows;
    }

    public static function getPrimeiro(){

        $piloto = $_GET['id_piloto'];

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('COUNT(r.id_pilot) AS firsts');
        $query->from('#__results As r');
        $query->where('r.id_pilot ='.$piloto.' AND r.position = 1');

        $db->setQuery($query);
        $rows = (array) $db->loadObjectList();

        return $rows;
    }

    public static function getSegundo(){

        $piloto = $_GET['id_piloto'];

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('COUNT(r.id_pilot) AS second');
        $query->from('#__results As r');
        $query->where('r.id_pilot ='.$piloto.' AND r.position = 2');

        $db->setQuery($query);
        $rows = (array) $db->loadObjectList();

        return $rows;
    }

    public static function getTerceiro(){

        $piloto = $_GET['id_piloto'];

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('COUNT(r.id_pilot) AS third');
        $query->from('#__results As r');
        $query->where('r.id_pilot ='.$piloto.' AND r.position = 3');

        $db->setQuery($query);
        $rows = (array) $db->loadObjectList();

        return $rows;
    }

    public static function getQuarto(){

        $piloto = $_GET['id_piloto'];

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('COUNT(r.id_pilot) AS fourth');
        $query->from('#__results As r');
        $query->where('r.id_pilot ='.$piloto.' AND r.position = 4');

        $db->setQuery($query);
        $rows = (array) $db->loadObjectList();

        return $rows;
    }

    public static function getQuinto(){

        $piloto = $_GET['id_piloto'];

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('COUNT(r.id_pilot) AS fifth');
        $query->from('#__results As r');
        $query->where('r.id_pilot ='.$piloto.' AND r.position = 5');

        $db->setQuery($query);
        $rows = (array) $db->loadObjectList();

        return $rows;
    }

    public static function getMelhorVolta(){

        $piloto = $_GET['id_piloto'];

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('COUNT(r.id_pilot) AS best_lap');
        $query->from('#__results As r');
        $query->where('r.id_pilot ='.$piloto.' AND r.position_best_lap = 1');

        $db->setQuery($query);
        $rows = (array) $db->loadObjectList();

        return $rows;
    }

    public static function getMelhores2a5(){

        $piloto = $_GET['id_piloto'];

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('COUNT(r.id_pilot) AS best_lap_2_5');
        $query->from('#__results As r');
        $query->where('r.id_pilot ='.$piloto.' AND r.position_best_lap IN (2,3,4,5)');

        $db->setQuery($query);
        $rows = (array) $db->loadObjectList();

        return $rows;
    }

    public static function getTotalPontos(){

        $piloto = $_GET['id_piloto'];

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('SUM(points) AS points');
        $query->from('#__results As r');
        $query->where('r.id_pilot ='.$piloto);

        $db->setQuery($query);
        $rows = (array) $db->loadObjectList();

        return $rows;
    }

    public static function getHistorico(){

        $piloto = $_GET['id_piloto'];

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('historic AS historico');
        $query->from('#__previous As p');
        $query->where('p.id_pilot ='.$piloto);

        $db->setQuery($query);
        $rows = (array) $db->loadObjectList();

        return $rows;
    }

}