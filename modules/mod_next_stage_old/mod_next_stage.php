<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_next_stage
 * @copyright	Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once dirname(__FILE__).'/helper.php';
$document = JFactory::getDocument();
$document->addStyleSheet(JURI::base(true) . '/modules/mod_next_stage/assets/css/style.css');

$data = modNext_StageHelper::getDataStage();
$grid = modNext_StageHelper::getGrid();

require JModuleHelper::getLayoutPath('mod_next_stage', $params->get('layout', 'default'));

