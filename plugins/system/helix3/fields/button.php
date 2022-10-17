<?php
/**
* @package Helix3 Framework
* @author JoomShaper https://www.joomshaper.com
* @copyright (c) 2010 - 2021 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
*/

//no direct accees
defined ('_JEXEC') or die ('resticted aceess');

use Joomla\CMS\Form\FormField;

class JFormFieldButton extends FormField
{
	protected $type = 'Button';
	protected function getInput() {

		$url = !empty($this->element['url']) ? $this->element['url'] : '#';
		$class = !empty($this->element['class']) ? ' ' . $this->element['class'] : '';
		$text = !empty($this->element['text']) ? $this->element['text'] : 'Button';
		$target = !empty($this->element['target']) ? $this->element['target'] : '_self';

		return '<a id="'. $this->id .'" class="btn'. $class .'" href="'. $url .'" target="' . $target . '">'. JText::_($text) .'</a>';
	}
}
