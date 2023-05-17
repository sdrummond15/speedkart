<?php

/*
 * @package Competitions
 * @com_admininistrations
 * @copyright Copyright (C) Sdrummond, Inc. All rights reserved.
 * @license Sdrummond
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controlleradmin');

/**
 * Clients list controller class.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_banners
 * @since		1.6
 */
class CompetitionsControllerResults extends JControllerAdmin
{
	
	protected $text_prefix = 'COM_COMPETITIONS_RESULTS';

        public function __construct($config = array()) 
        {
            parent::__construct($config);
        }


        public function getModel($name = 'Result', $prefix = 'CompetitionsModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);
		return $model;
	}
}