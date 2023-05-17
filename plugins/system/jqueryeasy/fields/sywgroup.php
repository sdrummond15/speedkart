<?php
/**
 * @copyright	Copyright (C) 2011 Simplify Your Web, Inc. All rights reserved.
 * @license		GNU General Public License version 3 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die ;

class JFormFieldSYWGroup extends JFormField
{
	public $type = 'SYWGroup';
	
	protected $section;
	//protected $iscollapsible;

	protected function getLabel()
	{
		return '';
	}
	
	protected function getInput()
	{
		$html = '';
		
		JHtml::_('stylesheet', 'syw/fonts-min.css', false, true);

		$description = isset($this->element['description']) ? '<p><em>'.JText::_($this->element['description']).'</em></p>' : '';
		
		//$class = $this->iscollapsible ? ' class="collapsible"' : '';
		$class = '';
		
		$html .= '</div></div>';

		if ($this->section == 'begin') {
			$html .= '<div class="well well-small">';
			$html .= '<div'.$class.'>';
			
			if (isset($this->element['label'])) {
				$html .= '<h4>'.JText::_($this->element['label']);
			}
			
// 			if ($this->iscollapsible) {
// 				$html .= '&nbsp;<i class="SYWicon-unfold-more"></i>';
// 			}
			
			if (isset($this->element['label'])) {
				$html .= '</h4>';
			}
			
			$html .= $description.'<br />';
			
			$html .= '</div><div>';
		} else if ($this->section == 'end') {
			$html .= '</div></div>';
		}

		$html .= '<div><div>';

		return $html;
	}
	
	public function setup(SimpleXMLElement $element, $value, $group = null)
	{
		$return = parent::setup($element, $value, $group);
		
		if ($return) {
			
			$this->section = isset($this->element['section']) ? $this->element['section'] : null;
			//$this->iscollapsible = isset($this->element['collapsible']) ? $this->element['collapsible'] : false;
		}
		
		return $return;
	}

}
?>
