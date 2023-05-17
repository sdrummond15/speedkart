<?php

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class PilotsViewPilots extends JViewLegacy {

    function display($tpl = null) {

        $doc = JFactory::getDocument();
        $doc->addStyleSheet('components/com_pilots/assets/css/pilots.css');
        $doc->addScript('components/com_pilots/assets/js/pilots.js');

        $this->pilots = $this->get('Pilots');

        parent::display($tpl);
    }
}
