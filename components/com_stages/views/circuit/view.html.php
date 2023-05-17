<?php

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class StagesViewCircuit extends JViewLegacy {

    function display($tpl = null) {

        $doc = JFactory::getDocument();
        $doc->addStyleSheet('components/com_stages/assets/css/circuit.css');
        $doc->addScript('components/com_stages/assets/js/circuit.js');

        $this->circuit = $this->get('Circuit');

        parent::display($tpl);
    }
}
