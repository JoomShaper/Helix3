<?php
/**
* @package Helix3 Framework
* @author JoomShaper https://www.joomshaper.com
* @copyright (c) 2010 - 2021 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
*/

//no direct accees
defined ('_JEXEC') or die ('resticted aceess');

use Joomla\CMS\Factory;
use Joomla\CMS\Form\FormField;
use Joomla\CMS\Language\Text;

class JFormFieldOptionio extends FormField
{
	protected $type = 'optionio';

	protected function getInput()
	{
		$input = Factory::getApplication()->input;
		$template_id = $input->get('id',0,'INT');

		$url_cureent =  "//$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

		$export_url = $url_cureent . '&helix3task=export';

		$output = '';
		$output .= '<div class="import-export clearfix" style="margin-bottom:30px;">';
		$output .= '<a class="btn btn-success" target="_blank" href="'. $export_url .'">'. Text::_("HELIX_SETTINGS_EXPORT") .'</a>';
		$output .= '</div>';
		$output .= '<div class="import-export clearfix">';
		$output .= '<textarea id="import-data" name="import-data" rows="5" style="margin-bottom:20px;"></textarea>';
		$output .= '<div><a id="import-settings" class="btn btn-primary" data-template_id="'. $template_id .'" target="_blank" href="#">'. Text::_("HELIX_SETTINGS_IMPORT") .'</a></div>';
		$output .= '</div>';

		return $output;
	}
}
