<?php
/**
 * @copyright	Copyright (C) 2011 Simplify Your Web, Inc. All rights reserved.
* @license		GNU General Public License version 3 or later; see LICENSE.txt
*/

// no direct access
defined('_JEXEC') or die ;

jimport('joomla.form.formfield');

class JFormFieldSYWOnlineHelp extends JFormField
{
	protected $type = 'SYWOnlineHelp';

	protected function getLabel()
	{
		$title = $this->element['label'] ? (string) $this->element['label'] : ($this->element['title'] ? (string) $this->element['title'] : '');
		$heading = $this->element['heading'] ? (string) $this->element['heading'] : 'h4';
		$description = (string) $this->element['description'];
		$class = !empty($this->element['class']) ? ' class="' . $this->element['class']. '"' : '';

		$url = (string) $this->element['url'];

		$html = array();

		$html[] = !empty($title) ? '<' . $heading . '>' . JText::_($title) . '</' . $heading . '>' : '';

		$html[] = '<table style="width: 100%"><tr>';
		$html[] = !empty($description) ? '<td>'.JText::_($description).'</td>' : '';
		$html[] = '<td style="text-align: right"><a href="'.$url.'" target="_blank" class="btn btn-info btn-mini btn-xs">';
		$html[] = '<img src="'.JURI::root().'plugins/system/jqueryeasy/images/local-library.png">';
		$html[] = '</a></td>';
		$html[] = '</tr></table>';

		return '</div><div ' . $class . '>' . implode('', $html);
	}

	protected function getInput()
	{
		return '';
	}

}
