<?php

defined('_JEXEC') or die;

$controller = JControllerLegacy::getInstance('Stages');
$controller->execute(JRequest::getVar('task', 'click'));
$controller->redirect();
