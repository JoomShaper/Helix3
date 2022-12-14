<?php
/**
* @package Helix3 Framework
* @author JoomShaper https://www.joomshaper.com
* @copyright (c) 2010 - 2021 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
*/

use Joomla\CMS\HTML\HTMLHelper;

//no direct accees
defined ('_JEXEC') or die ('resticted aceess');

class SpTypeColor{

	static function getInput($key, $attr)
	{

		if(!isset($attr['std'])){
			$attr['std'] = '';
		}

		// Including fallback code for HTML5 non supported browsers.
		HTMLHelper::_('jquery.framework');
		HTMLHelper::_('script', 'system/html5fallback.js', array('version' => 'auto', 'relative' => true, 'conditional' => 'lt IE 9'));

		$output  = '<div class="form-group">';
		$output .= '<label>'.$attr['title'].'</label>';
		$output .= '<input type="text" class="sppb-color addon-input form-control" data-attrname="'.$key.'" placeholder="#rrggbb" value="'.$attr['std'].'">';

		if( ( isset($attr['desc']) ) && ( isset($attr['desc']) != '' ) )
		{
			$output .= '<p class="help-block">' . $attr['desc'] . '</p>';
		}

		$output .= '</div>';

		return $output;
	}

}
