<?php

/*
 * @package Competitions
 * @com_admininistrations
 * @copyright Copyright (C) Sdrummond, Inc. All rights reserved.
 * @license Sdrummond
 */

// no direct access
defined('_JEXEC') or die;

class CompetitionsHelper
{
    /**
     * Configure the Linkbar.
     *
     * @param    string    The name of the active view.
     *
     * @return    void
     * @since    1.6
     */

    public static function addSubmenu($vName)
    {
        JSubMenuHelper::addEntry(
            JText::_('COM_COMPETITIONS_SUBMENU_RESULTS'),
            'index.php?option=com_competitions&view=results',
            $vName == 'results'
        );
        JSubMenuHelper::addEntry(
            JText::_('COM_COMPETITIONS_SUBMENU_PILOTS'),
            'index.php?option=com_competitions&view=pilots',
            $vName == 'pilots'
        );
        JSubMenuHelper::addEntry(
            JText::_('COM_COMPETITIONS_SUBMENU_STAGES'),
            'index.php?option=com_competitions&view=stages',
            $vName == 'stages'
        );
        JSubMenuHelper::addEntry(
            JText::_('COM_COMPETITIONS_SUBMENU_CHAMPIONSHIPS'),
            'index.php?option=com_competitions&view=championships',
            $vName == 'championships'
        );
        JSubMenuHelper::addEntry(
            JText::_('COM_COMPETITIONS_SUBMENU_KARTINGS'),
            'index.php?option=com_competitions&view=kartings',
            $vName == 'kartings'
        );
        JSubMenuHelper::addEntry(
            JText::_('COM_COMPETITIONS_SUBMENU_CIRCUITS'),
            'index.php?option=com_competitions&view=circuits',
            $vName == 'circuits'
        );
        JSubMenuHelper::addEntry(
            JText::_('COM_COMPETITIONS_SUBMENU_TEAMS'),
            'index.php?option=com_competitions&view=teams',
            $vName == 'teams'
        );
        JSubMenuHelper::addEntry(
            JText::_('COM_COMPETITIONS_SUBMENU_GRIDS'),
            'index.php?option=com_competitions&view=grids',
            $vName == 'grids'
        );
        JSubMenuHelper::addEntry(
            JText::_('COM_COMPETITIONS_SUBMENU_PREVIOUS'),
            'index.php?option=com_competitions&view=previous',
            $vName == 'previous'
        );
    }


    public static function getActions()
    {
        $user = JFactory::getUser();
        $result = new JObject;
        $assetName = 'com_competitions';

        $actions = array(
            'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.state', 'core.delete'
        );

        foreach ($actions as $action) {
            $result->set($action, $user->authorise($action, $assetName));
        }

        return $result;
    }


    public static function getKartingOptions()
    {
        // Initialize variables.
        $options = array();

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->select('id As value, title As text');
        $query->from('#__kartings AS a');
        $query->order('a.title');

        // Get the options.
        $db->setQuery($query);

        $options = $db->loadObjectList();

        // Check for a database error.
        if ($db->getErrorNum()) {
            JError::raiseWarning(500, $db->getErrorMsg());
        }

        // Merge any additional options in the XML definition.
        //$options = array_merge(parent::getOptions(), $options);

        return $options;
    }

    public static function getPilotOptions()
    {
        // Initialize variables.
        $options = array();

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->select('id As value, name As text');
        $query->from('#__pilots AS a');
        $query->order('a.name');

        // Get the options.
        $db->setQuery($query);

        $options = $db->loadObjectList();

        // Check for a database error.
        if ($db->getErrorNum()) {
            JError::raiseWarning(500, $db->getErrorMsg());
        }

        // Merge any additional options in the XML definition.
        //$options = array_merge(parent::getOptions(), $options);

        array_unshift($options, JHtml::_('select.option', '0', JText::_('COM_COMPETITIONS_NO_PILOT')));

        return $options;
    }

    public static function getPilotResultOptions()
    {
        // Initialize variables.
        $options = array();

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->select('id As value, name As text');
        $query->from('#__pilots AS a');
        $query->where('published = 1');
        $query->order('a.name');

        // Get the options.
        $db->setQuery($query);

        $options = $db->loadObjectList();

        // Check for a database error.
        if ($db->getErrorNum()) {
            JError::raiseWarning(500, $db->getErrorMsg());
        }

        // Merge any additional options in the XML definition.
        //$options = array_merge(parent::getOptions(), $options);

        return $options;
    }

    public static function getChampionshipOptions()
    {
        // Initialize variables.
        $options = array();

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->select('id As value, title As text');
        $query->from('#__championships AS a');
        $query->order('a.title');

        // Get the options.
        $db->setQuery($query);

        $options = $db->loadObjectList();

        // Check for a database error.
        if ($db->getErrorNum()) {
            JError::raiseWarning(500, $db->getErrorMsg());
        }

        // Merge any additional options in the XML definition.
        //$options = array_merge(parent::getOptions(), $options);

        return $options;
    }

    public static function getCircuitOptions()
    {
        // Initialize variables.
        $options = array();

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->select('id As value, title As text');
        $query->from('#__circuits AS a');
        $query->order('a.title');

        // Get the options.
        $db->setQuery($query);

        $options = $db->loadObjectList();

        // Check for a database error.
        if ($db->getErrorNum()) {
            JError::raiseWarning(500, $db->getErrorMsg());
        }

        // Merge any additional options in the XML definition.
        //$options = array_merge(parent::getOptions(), $options);

        return $options;
    }

    public static function getStageOptions()
    {
        // Initialize variables.
        $options = array();

        $ano = date("Y");

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->select('s.id As value, s.title As text');
        $query->from('#__stages AS s');
        $query->where('s.id_championship = (SELECT id FROM #__championships WHERE year = '.$ano.')');
        //   $query->order('s.title');

        // Get the options.
        $db->setQuery($query);

        $options = $db->loadObjectList();

        // Check for a database error.
        if ($db->getErrorNum()) {
            JError::raiseWarning(500, $db->getErrorMsg());
        }

        // Merge any additional options in the XML definition.
        //$options = array_merge(parent::getOptions(), $options);

        return $options;
    }

    public static function getTeamOptions()
    {
        // Initialize variables.
        $options = array();

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->select('id As value, title As text');
        $query->from('#__teams AS a');
        $query->order('a.title');

        // Get the options.
        $db->setQuery($query);

        $options = $db->loadObjectList();

        // Check for a database error.
        if ($db->getErrorNum()) {
            JError::raiseWarning(500, $db->getErrorMsg());
        }

        // Merge any additional options in the XML definition.
        //$options = array_merge(parent::getOptions(), $options);

        array_unshift($options, JHtml::_('select.option', '0', JText::_('COM_COMPETITIONS_NO_TEAM')));

        return $options;
    }

    public static function getPilotGridOptions()
    {
        // Initialize variables.
        $options = array();

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->select('id As value, name As text');
        $query->from('#__pilots AS a');
        $query->where('published = 1');
        $query->order('a.name');

        // Get the options.
        $db->setQuery($query);

        $options = $db->loadObjectList();

        // Check for a database error.
        if ($db->getErrorNum()) {
            JError::raiseWarning(500, $db->getErrorMsg());
        }

        // Merge any additional options in the XML definition.
        //$options = array_merge(parent::getOptions(), $options);

        array_unshift($options, JHtml::_('select.option', '0', JText::_('COM_COMPETITIONS_NO_PILOT')));

        return $options;
    }

    public static function getStageGridOptions()
    {
        // Initialize variables.
        $options = array();

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $ano = date("Y");
        $query->select('id As value, title As text');
        $query->from('#__stages AS a');
        $query->where('a.id_championship = (SELECT id FROM #__championships WHERE year = '.$ano.')');
        $query->order('a.id');
        $query->group('a.title');

        // Get the options.
        $db->setQuery($query);

        $options = $db->loadObjectList();

        // Check for a database error.
        if ($db->getErrorNum()) {
            JError::raiseWarning(500, $db->getErrorMsg());
        }

        // Merge any additional options in the XML definition.
        //$options = array_merge(parent::getOptions(), $options);

        return $options;
    }

    public static function getPilotPreviouOptions()
    {
        // Initialize variables.
        $options = array();

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->select('id As value, name As text');
        $query->from('#__pilots AS a');
        $query->order('a.name');

        // Get the options.
        $db->setQuery($query);

        $options = $db->loadObjectList();

        // Check for a database error.
        if ($db->getErrorNum()) {
            JError::raiseWarning(500, $db->getErrorMsg());
        }

        // Merge any additional options in the XML definition.
        //$options = array_merge(parent::getOptions(), $options);

        return $options;
    }

}