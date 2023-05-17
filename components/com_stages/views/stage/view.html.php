<?php

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class StagesViewStage extends JViewLegacy {

    function display($tpl = null) {

        $doc = JFactory::getDocument();
        $doc->addStyleSheet('components/com_stages/assets/css/stage.css');
        $doc->addScript('components/com_stages/assets/js/stage.js');

        $this->stagedetail = $this->get('StageDetail');
        $this->firsts = $this->get('Firsts');
        $this->deductions = $this->get('Deductions');

        parent::display($tpl);
    }
}
