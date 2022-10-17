<?php
/**
* @package Helix3 Framework
* @author JoomShaper https://www.joomshaper.com
* @copyright (c) 2010 - 2021 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
*/

//no direct accees
defined ('_JEXEC') or die ('resticted aceess');

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Component\ComponentHelper;

class SpTypeMedia
{
	static function getInput($key, $attr)
	{

		if (!isset($attr['std']))
		{
			$attr['std'] = '';
		}

		if($attr['std']!='') {
			$src = 'src="' . Uri::root() .  $attr['std'] . '"';
		} else {
			$src = '';
		}

		$output  = '<div class="form-group">';

		$output .= '<label>' . $attr['title'] . '</label>';
		$output .= '<div class="media">';

		// Joomla
		if (JVERSION < 4)
		{
			HTMLHelper::_('jquery.framework');
			HTMLHelper::_('behavior.modal');

			$output .= '<div class="input-group-j3">';
			$output .= '<input type="text" data-attrname="'.$key.'" class="input-media addon-input form-control form-control-w-auto" value="' . htmlspecialchars($attr['std'], ENT_COMPAT, 'UTF-8') . '" readonly="readonly">';
			$output .= '<a class="modal sppb-btn sppb-btn-primary button-select" title="Select" rel="{handler: \'iframe\', size: {x: 800, y: 500}}">Select</a>';
			$output .= ' <a class="sppb-btn sppb-btn-danger remove-media" href="#"><i class="icon-remove"></i></a>';
			$output .= '</div>';
		}
		else
		{
			$url = 'index.php?option=com_media&view=media&tmpl=component';

			$id = 'helix3_modal';
			$modalHTML = HTMLHelper::_(
				'bootstrap.renderModal',
				'imageModal_' . $id,
				[
					'url'         => $url,
					'title'       => Text::_('JLIB_FORM_CHANGE_IMAGE'),
					'closeButton' => true,
					'height'      => '100%',
					'width'       => '100%',
					'modalWidth'  => '80',
					'bodyHeight'  => '60',
					'footer'      => '<button type="button" class="btn btn-success button-save-selected">' . Text::_('JSELECT') . '</button>'
						. '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">' . Text::_('JCANCEL') . '</button>',
				]
			);

			$output .= '<joomla-field-media class="field-media-wrapper" type="image"
					base-path="' . Uri::root() . '" root-folder="' . ComponentHelper::getParams('com_media')->get('file_path', 'images') . '" url="' . $url . '"
					modal-container=".modal" modal-width="100%" modal-height="400px"
					input=".field-media-input" button-select=".button-select" button-clear=".button-clear"
					button-save-selected=".button-save-selected">';

			$output .= $modalHTML;

			$output .= '<div class="input-group">';
			$output .= '<input type="text" data-attrname="' . $key . '" class="input-media addon-input form-control form-control-w-auto field-media-input" value="' . htmlspecialchars($attr['std'], ENT_COMPAT, 'UTF-8') . '" readonly="readonly">';
			$output .= '<button type="button" class="btn btn-success button-select">' . Text::_('JLIB_FORM_BUTTON_SELECT') . '</button>';
			$output .= '<button type="button" class="btn btn-danger button-clear"><span class="icon-times" aria-hidden="true"></span><span class="visually-hidden">' . Text::_('JLIB_FORM_BUTTON_CLEAR') . '</span></button>';
			$output .= '</div>';

			$output .= '</joomla-field-media>';

		}

		$output .= '</div>';

		if ((isset($attr['desc']) ) && ( isset($attr['desc']) != ''))
		{
			$output .= '<p class="help-block">' . $attr['desc'] . '</p>';
		}
		
		$output .= '</div>';

		return $output;

	}
}
