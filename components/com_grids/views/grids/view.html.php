<?php

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class GridsViewGrids extends JViewLegacy {

    function display($tpl = null) {

        $doc = JFactory::getDocument();
        $doc->addStyleSheet('components/com_grids/assets/css/grids.css');
        $doc->addScript('components/com_grids/assets/js/grids.js');

        $this->grids = $this->get('Grids');

        parent::display($tpl);
    }
}
