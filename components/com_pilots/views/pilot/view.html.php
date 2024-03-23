<?php

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class PilotsViewPilot extends JViewLegacy {

    function display($tpl = null) {

        $doc = JFactory::getDocument();
        $doc->addStyleSheet('components/com_pilots/assets/css/pilot.css');
        $doc->addScript('components/com_pilots/assets/js/pilot.js');

        $this->pilotodetail = $this->get('PilotoDetail');
        $this->corridas = $this->get('Corridas');
        $this->primeiro = $this->get('Primeiro');
        $this->segundo = $this->get('Segundo');
        $this->terceiro = $this->get('Terceiro');
        $this->quarto = $this->get('Quarto');
        $this->quinto = $this->get('Quinto');
        $this->melhorvolta = $this->get('MelhorVolta');
        $this->melhores2a5 = $this->get('Melhores2a5');
        $this->totalpontos = $this->get('TotalPontos');
        $this->historico = $this->get('Historico');

        parent::display($tpl);
    }
}
