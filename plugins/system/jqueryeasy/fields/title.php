<?php
/**
 * @copyright	Copyright (C) 2011 Simplify Your Web, Inc. All rights reserved.
* @license		GNU General Public License version 3 or later; see LICENSE.txt
*/

// no direct access
defined('_JEXEC') or die ;

jimport('joomla.form.formfield');

class JFormFieldTitle extends JFormField
{
	public $type = 'Title';

	protected function getLabel()
	{
		$value = trim($this->element['title']);
		$image_src = $this->element['imagesrc']; // path ex: ../modules/mod_latestnews/images/icon.png (16x16)

		$color = $this->element['color'];
		if (empty($color)) {
			$color = '#d0d0d0';
		}

		$html = '</div>';

		$inline_style = 'background: '.$color.'; ';
		$inline_style .= 'background: linear-gradient(to right, '.$color.' 0%, #fff 100%); ';
		$inline_style .= 'color: #fff; ';
		$inline_style .= 'border-radius: 3px; ';
		$inline_style .= 'font-family: "Courier New", Courier, monospace; ';
		$inline_style .= 'margin: 5px 0; ';
		$inline_style .= 'text-transform: uppercase; ';
		$inline_style .= 'letter-spacing: 3px; ';
		$inline_style .= 'font-weight: bold; ';
		$inline_style .= 'padding: 5px 5px 5px 10px; ';

		$html .= '<div style=\''.$inline_style.'\'>';

		if ($image_src) {
			$html .= '<img style="margin: -1px 4px 0 0; float: left; padding: 0px; width: 16px; height: 16px" src="'.$image_src.'">';
		} 

		if ($value) {
			$html .= JText::_($value);
		}

		//$html .= '</div>';

		return $html;
	}

	protected function getInput()
	{
		return '';
	}

}
?>