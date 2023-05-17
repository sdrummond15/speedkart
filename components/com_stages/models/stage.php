<?php

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');


class StagesModelStage extends JModelLegacy
{

    public function getStageDetail()
    {

        $stage = $_GET['id_stage'];

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('r.position AS posicao, r.position_grid AS grid, p.name AS piloto, r.turns AS voltas, r.points AS pontos, r.difference_time AS diferenca, r.position_best_lap, r.deductions AS deducao, r.best_lap AS melhor_volta, t.title AS equipe, p.photo_detail AS stageo, p.photo_kart AS stageokart, r.desc_deductions AS motivo');
        $query->from('#__results As r');
        $query->join('LEFT', '#__pilots AS p ON r.id_pilot = p.id');
        $query->join('LEFT', '#__teams AS t ON p.id_team = t.id');
        $query->join('LEFT', '#__stages AS s ON r.id_stage = s.id');
        $query->where('p.published = 1 AND r.id_stage =' . $stage);
        $query->order('r.position');

        $db->setQuery($query);
        $rows = (array)$db->loadObjectList();

        return $rows;
    }

    public function getFirsts()
    {

        $stage = $_GET['id_stage'];

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('p.photo AS foto, p.name AS piloto, t.title AS equipe, r.best_lap AS melhor_volta, p.id AS id_piloto');
        $query->from('#__results As r');
        $query->join('LEFT', '#__pilots AS p ON r.id_pilot = p.id');
        $query->join('LEFT', '#__teams AS t ON p.id_team = t.id');
        $query->where('p.published = 1 AND r.id_stage =' . $stage);
        $query->order('r.position_best_lap LIMIT 5');

        $db->setQuery($query);
        $rows = (array)$db->loadObjectList();

        return $rows;
    }

    public function getDeductions()
    {

        $stage = $_GET['id_stage'];

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('p.name AS piloto, r.deductions AS deducao, t.title AS equipe, r.desc_deductions AS motivo');
        $query->from('#__results As r');
        $query->join('LEFT', '#__pilots AS p ON r.id_pilot = p.id');
        $query->join('LEFT', '#__teams AS t ON p.id_team = t.id');
        $query->join('LEFT', '#__stages AS s ON r.id_stage = s.id');
        $query->where('p.published = 1 AND r.id_stage =' . $stage);
        $query->order('r.position');

        $db->setQuery($query);
        $rows = (array)$db->loadObjectList();

        return $rows;
    }

}