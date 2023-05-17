<?php

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class StagesViewStages extends JViewLegacy {

    function display($tpl = null) {

        $doc = JFactory::getDocument();
        $doc->addStyleSheet('components/com_stages/assets/css/stages.css');
        $doc->addScript('components/com_stages/assets/js/stages.js');

        $this->stages = $this->get('Stages');

        parent::display($tpl);
    }
}
