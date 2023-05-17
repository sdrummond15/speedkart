<?php

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class CalendarViewCalendar extends JViewLegacy {

    function display($tpl = null) {

        $doc = JFactory::getDocument();
        $doc->addStyleSheet('components/com_calendar/assets/css/calendar.css');
        $doc->addScript('components/com_calendar/assets/js/calendar.js');

        $this->calendar = $this->get('Calendar');

        parent::display($tpl);
    }
}
