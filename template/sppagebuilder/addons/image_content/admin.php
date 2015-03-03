<?php
/**
 * @package SP Page Builder
 * @author JoomShaper http://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2015 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/
//no direct accees
defined ('_JEXEC') or die ('resticted aceess');

SpAddonsConfig::addonConfig(
	array( 
		'type'=>'content',
		'addon_name'=>'sp_image_content',
		'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_IMAGE_CONTENT'),
		'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_IMAGE_CONTENT_DESC'),
		'attr'=>array(

			'separator1'=>array(
				'type'=>'separator', 
				'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_IMAGE_CONTENT_IMAGE')
				),

			'image'=>array(
				'type'=>'media', 
				'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_IMAGE_CONTENT_IMAGE'),
				),
			
			'image_alignment'=>array(
				'type'=>'select', 
				'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_IMAGE_CONTENT_IMAGE_ALIGNMENT'),
				'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_IMAGE_CONTENT_IMAGE_ALIGNMENT_DESC'),
				'values'=>array(
					'left'=>JText::_('COM_SPPAGEBUILDER_ADDON_GLOBAL_LEFT'),
					'right'=>JText::_('COM_SPPAGEBUILDER_ADDON_GLOBAL_RIGHT'),
					),
				'std'=>'left',
				),

			'separator2'=>array(
				'type'=>'separator', 
				'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_IMAGE_CONTENT_CONTENT')
				),

			'title'=>array(
				'type'=>'text', 
				'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_IMAGE_CONTENT_TITLE'),
				'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_IMAGE_CONTENT_TITLE_DESC'),
				),

			'heading_selector'=>array(
				'type'=>'select', 
				'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_HEADINGS'),
				'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_HEADINGS_DESC'),
				'values'=>array(
					'h1'=>JText::_('COM_SPPAGEBUILDER_ADDON_HEADINGS_H1'),
					'h2'=>JText::_('COM_SPPAGEBUILDER_ADDON_HEADINGS_H2'),
					'h3'=>JText::_('COM_SPPAGEBUILDER_ADDON_HEADINGS_H3'),
					'h4'=>JText::_('COM_SPPAGEBUILDER_ADDON_HEADINGS_H4'),
					'h5'=>JText::_('COM_SPPAGEBUILDER_ADDON_HEADINGS_H5'),
					'h6'=>JText::_('COM_SPPAGEBUILDER_ADDON_HEADINGS_H6'),
					),
				'std'=>'h3',
			),

			'title_fontsize'=>array(
				'type'=>'number', 
				'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_TITLE_FONT_SIZE'),
				'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_TITLE_FONT_SIZE_DESC'),
				'std'=>''
				),

			'title_fontweight'=>array(
				'type'=>'text', 
				'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_TITLE_FONT_WEIGHT'),
				'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_TITLE_FONT_WEIGHT_DESC'),
				'std'=>''
				),

			'title_text_color'=>array(
				'type'=>'color',
				'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_TITLE_TEXT_COLOR'),
				'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_TITLE_TEXT_COLOR_DESC'),
				),

			'title_margin_top'=>array(
				'type'=>'number',
				'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_TITLE_MARGIN_TOP'),
				'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_TITLE_MARGIN_TOP_DESC'),
				'placeholder'=>'10',
				),

			'title_margin_bottom'=>array(
				'type'=>'number',
				'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_TITLE_MARGIN_BOTTOM'),
				'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_TITLE_MARGIN_BOTTOM_DESC'),
				'placeholder'=>'10',
				),								
			'text'=>array(
				'type'=>'editor', 
				'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_IMAGE_CONTENT_CONTENT'),
				'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_IMAGE_CONTENT_CONTENT_DESC'),
				),
			//Button
			'button_text'=>array(
				'type'=>'text', 
				'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_BUTTON_TEXT'),
				'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_BUTTON_TEXT_DESC'),
				'std'=>'Button Text',
				),
			'button_url'=>array(
				'type'=>'text', 
				'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_BUTTON_URL'),
				'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_BUTTON_URL_DESC'),
				'std'=>'http://'
				),
			'button_size'=>array(
				'type'=>'select', 
				'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_BUTTON_SIZE'),
				'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_BUTTON_SIZE_DESC'),
				'values'=>array(
					''=>JText::_('COM_SPPAGEBUILDER_ADDON_BUTTON_SIZE_DEFAULT'),
					'lg'=>JText::_('COM_SPPAGEBUILDER_ADDON_BUTTON_SIZE_LARGE'),
					'sm'=>JText::_('COM_SPPAGEBUILDER_ADDON_BUTTON_SIZE_SMALL'),
					'xs'=>JText::_('COM_SPPAGEBUILDER_ADDON_BUTTON_SIZE_EXTRA_SAMLL'),
					),
				),
			'button_type'=>array(
				'type'=>'select', 
				'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_BUTTON_TYPE'),
				'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_BUTTON_TYPE_DESC'),
				'values'=>array(
					'default'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_DEFAULT'),
					'primary'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_PRIMARY'),
					'success'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_SUCCESS'),
					'info'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_INFO'),
					'warning'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_WARNING'),
					'danger'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_DANGER'),
					'link'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_LINK'),
					),
				'std'=>'default',
				),
			'button_icon'=>array(
				'type'=>'icon', 
				'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_BUTTON_ICON'),
				'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_BUTTON_ICON_DESC'),
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
				'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_GLOBAL_TARGET'),
				'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_GLOBAL_TARGET_DESC'),
				'values'=>array(
					''=>JText::_('COM_SPPAGEBUILDER_ADDON_GLOBAL_TARGET_SAME_WINDOW'),
					'_blank'=>JText::_('COM_SPPAGEBUILDER_ADDON_GLOBAL_TARGET_NEW_WINDOW'),
					),
				),
			'class'=>array(
				'type'=>'text', 
				'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_CLASS'),
				'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_CLASS_DESC'),
				'std'=> ''
				),
			)
		)
	);