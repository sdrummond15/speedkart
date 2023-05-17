<?php

defined('_JEXEC') or die;

$controller = JControllerLegacy::getInstance('Grids');
$controller->execute(JRequest::getVar('task', 'click'));
$controller->redirect();
