<?php
/**
 * @package        Joomla.Site
 * @subpackage    com_competitions
 * @copyright    Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license        GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Execute the task.
$controller = JControllerLegacy::getInstance('Competitions');
$controller->execute(JRequest::getVar('task', 'click'));
$controller->redirect();
