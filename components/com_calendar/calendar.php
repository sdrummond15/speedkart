<?php

defined('_JEXEC') or die;

$controller = JControllerLegacy::getInstance('Calendar');
$controller->execute(JRequest::getVar('task', 'click'));
$controller->redirect();
