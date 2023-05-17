<?php

defined('_JEXEC') or die;

$controller = JControllerLegacy::getInstance('Pilots');
$controller->execute(JRequest::getVar('task', 'click'));
$controller->redirect();
