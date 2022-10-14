<?php
/**
* @package SP Page Builder
* @author JoomShaper https://www.joomshaper.com
* @copyright (c) 2010 - 2022 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

//No direct access
defined ('_JEXEC') or die ('restricted access');

use Joomla\CMS\Language\Text;


SpAddonsConfig::addonConfig(
	array( 
		'type'=>'content',
		'addon_name'=>'sp_call_to_action',
		'category'=>'Helix 3',
		'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_CTA'),
		'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_CTA_DESC'),
		'attr'=>array(
			'title'=>array(
				'type'=>'text', 
				'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_CTA_TITLE'),
				'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_CTA_TITLE_DESC'),
				'std'=>'Call to action title',
				),

			'heading_selector'=>array(
				'type'=>'select', 
				'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_HEADINGS'),
				'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_HEADINGS_DESC'),
				'values'=>array(
					'h1'=>Text::_('COM_SPPAGEBUILDER_ADDON_HEADINGS_H1'),
					'h2'=>Text::_('COM_SPPAGEBUILDER_ADDON_HEADINGS_H2'),
					'h3'=>Text::_('COM_SPPAGEBUILDER_ADDON_HEADINGS_H3'),
					'h4'=>Text::_('COM_SPPAGEBUILDER_ADDON_HEADINGS_H4'),
					'h5'=>Text::_('COM_SPPAGEBUILDER_ADDON_HEADINGS_H5'),
					'h6'=>Text::_('COM_SPPAGEBUILDER_ADDON_HEADINGS_H6'),
					),
				'std'=>'h3',
			),

			'title_fontsize'=>array(
				'type'=>'number', 
				'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_TITLE_FONT_SIZE'),
				'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_TITLE_FONT_SIZE_DESC'),
				'std'=>''
				),

			'title_text_color'=>array(
				'type'=>'color',
				'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_TITLE_TEXT_COLOR'),
				'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_TITLE_TEXT_COLOR_DESC'),
				),	

			'title_margin_top'=>array(
				'type'=>'number',
				'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_TITLE_MARGIN_TOP'),
				'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_TITLE_MARGIN_TOP_DESC'),
				'placeholder'=>'10',
				),

			'title_margin_bottom'=>array(
				'type'=>'number',
				'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_TITLE_MARGIN_BOTTOM'),
				'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_TITLE_MARGIN_BOTTOM_DESC'),
				'placeholder'=>'10',
				),							

			'subtitle'=>array(
				'type'=>'text', 
				'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_CTA_SUBTITLE'),
				'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_CTA_SUBTITLE_DESC'),
				'std'=>'Call to action sub title',
				),
			'subtitle_fontsize'=>array(
				'type'=>'number', 
				'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_SUB_TITLE_FONT_SIZE'),
				'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_SUB_TITLE_FONT_SIZE_DESC'),
				'std'=>''
				),	
			'subtitle_text_color'=>array(
				'type'=>'color',
				'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_SUB_TITLE_TEXT_COLOR'),
				'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_SUB_TITLE_TEXT_COLOR_DESC'),
				),								
			'text'=>array(
				'type'=>'editor', 
				'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_CTA_CONTENT'),
				'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_CTA_CONTENT_DESC'),
				),
			'background'=>array(
				'type'=>'color',
				'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_GLOBAL_BACKGROUND'),
				'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_GLOBAL_BACKGROUND_DESC'),
				),
			'color'=>array(
				'type'=>'color',
				'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_GLOBAL_COLOR'),
				'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_GLOBAL_COLOR_DESC'),
				),
			'padding'=>array(
				'type'=>'number',
				'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_GLOBAL_PADDING'),
				'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_GLOBAL_PADDING_DESC'),
				'placeholder'=>'20',
				),
			//Button
			'button_text'=>array(
				'type'=>'text', 
				'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_BUTTON_TEXT'),
				'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_BUTTON_TEXT_DESC'),
				'std'=>'Button Text',
				),
			'button_url'=>array(
				'type'=>'text', 
				'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_BUTTON_URL'),
				'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_BUTTON_URL_DESC'),
				'std'=>'http://'
				),
			'button_size'=>array(
				'type'=>'select', 
				'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_BUTTON_SIZE'),
				'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_BUTTON_SIZE_DESC'),
				'values'=>array(
					''=>Text::_('COM_SPPAGEBUILDER_ADDON_BUTTON_SIZE_DEFAULT'),
					'lg'=>Text::_('COM_SPPAGEBUILDER_ADDON_BUTTON_SIZE_LARGE'),
					'sm'=>Text::_('COM_SPPAGEBUILDER_ADDON_BUTTON_SIZE_SMALL'),
					'xs'=>Text::_('COM_SPPAGEBUILDER_ADDON_BUTTON_SIZE_EXTRA_SAMLL'),
					),
				),
			'button_type'=>array(
				'type'=>'select', 
				'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_BUTTON_TYPE'),
				'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_BUTTON_TYPE_DESC'),
				'values'=>array(
					'default'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_DEFAULT'),
					'primary'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_PRIMARY'),
					'success'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_SUCCESS'),
					'info'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_INFO'),
					'warning'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_WARNING'),
					'danger'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_DANGER'),
					'link'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_LINK'),
					),
				'std'=>'default',
				),
			'button_icon'=>array(
				'type'=>'icon', 
				'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_BUTTON_ICON'),
				'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_BUTTON_ICON_DESC'),
				),
			'button_block'=>array(
				'type'=>'select', 
				'title'=> 'Button Full Width',
				'desc'=>'Button block',
				'values'=>array(
					''=> 'No',
					'sppb-btn-block'=> 'Yes'
					)
				),
			'button_target'=>array(
				'type'=>'select', 
				'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_GLOBAL_TARGET'),
				'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_GLOBAL_TARGET_DESC'),
				'values'=>array(
					''=>Text::_('COM_SPPAGEBUILDER_ADDON_GLOBAL_TARGET_SAME_WINDOW'),
					'_blank'=>Text::_('COM_SPPAGEBUILDER_ADDON_GLOBAL_TARGET_NEW_WINDOW'),
					),
				),
			'button_position'=>array(
				'type'=>'select', 
				'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_CTA_BUTTON_POSITION'),
				'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_CTA_BUTTON_POSITION_DESC'),
				'values'=>array(
					'right'=>Text::_('COM_SPPAGEBUILDER_ADDON_GLOBAL_RIGHT'),
					'bottom'=>Text::_('COM_SPPAGEBUILDER_ADDON_GLOBAL_BOTTOM'),
					),
				),
			'class'=>array(
				'type'=>'text', 
				'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_CLASS'),
				'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_CLASS_DESC'),
				'std'=> ''
				),
			)
		)
	);