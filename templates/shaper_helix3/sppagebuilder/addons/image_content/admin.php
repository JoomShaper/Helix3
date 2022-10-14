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
	'addon_name'=>'sp_image_content',
	'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_IMAGE_CONTENT'),
	'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_IMAGE_CONTENT_DESC'),
	'attr'=>array(
		'general' => array(

			'admin_label'=>array(
				'type'=>'text',
				'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_ADMIN_LABEL'),
				'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_ADMIN_LABEL_DESC'),
				'std'=> ''
			),

			'separator1'=>array(
				'type'=>'separator',
				'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_IMAGE_CONTENT_IMAGE')
			),

			'image'=>array(
				'type'=>'media',
				'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_IMAGE_CONTENT_IMAGE'),
			),

			'image_alignment'=>array(
				'type'=>'select',
				'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_IMAGE_CONTENT_IMAGE_ALIGNMENT'),
				'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_IMAGE_CONTENT_IMAGE_ALIGNMENT_DESC'),
				'values'=>array(
					'left'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_LEFT'),
					'right'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_RIGHT'),
				),
				'std'=>'left',
			),

			'separator2'=>array(
				'type'=>'separator',
				'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_IMAGE_CONTENT_CONTENT')
			),

			'title'=>array(
				'type'=>'text',
				'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_IMAGE_CONTENT_TITLE'),
				'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_IMAGE_CONTENT_TITLE_DESC'),
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
				'depends'=>array(array('title', '!=', '')),
			),

			'title_fontsize'=>array(
				'type'=>'number',
				'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_TITLE_FONT_SIZE'),
				'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_TITLE_FONT_SIZE_DESC'),
				'std'=>'',
				'depends'=>array(array('title', '!=', '')),
			),

			'title_lineheight'=>array(
				'type'=>'text',
				'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_TITLE_LINE_HEIGHT'),
				'std'=>'',
				'depends'=>array(array('title', '!=', '')),
			),

			'title_fontstyle'=>array(
				'type'=>'select',
				'title'=> Text::_('COM_SPPAGEBUILDER_ADDON_TITLE_FONT_STYLE'),
				'values'=>array(
					'underline'=> Text::_('COM_SPPAGEBUILDER_GLOBAL_FONT_STYLE_UNDERLINE'),
					'uppercase'=> Text::_('COM_SPPAGEBUILDER_GLOBAL_FONT_STYLE_UPPERCASE'),
					'italic'=> Text::_('COM_SPPAGEBUILDER_GLOBAL_FONT_STYLE_ITALIC'),
					'lighter'=> Text::_('COM_SPPAGEBUILDER_GLOBAL_FONT_STYLE_LIGHTER'),
					'normal'=> Text::_('COM_SPPAGEBUILDER_GLOBAL_FONT_STYLE_NORMAL'),
					'bold'=> Text::_('COM_SPPAGEBUILDER_GLOBAL_FONT_STYLE_BOLD'),
					'bolder'=> Text::_('COM_SPPAGEBUILDER_GLOBAL_FONT_STYLE_BOLDER'),
				),
				'multiple'=>true,
				'std'=>'',
				'depends'=>array(array('title', '!=', '')),
			),

			'title_letterspace'=>array(
				'type'=>'select',
				'title'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_LETTER_SPACING'),
				'values'=>array(
					'0'=> 'Default',
					'1px'=> '1px',
					'2px'=> '2px',
					'3px'=> '3px',
					'4px'=> '4px',
					'5px'=> '5px',
					'6px'=>	'6px',
					'7px'=>	'7px',
					'8px'=>	'8px',
					'9px'=>	'9px',
					'10px'=> '10px'
				),
				'std'=>'0',
				'depends'=>array(array('title', '!=', '')),
			),

			'title_fontweight'=>array(
				'type'=>'text',
				'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_TITLE_FONT_WEIGHT'),
				'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_TITLE_FONT_WEIGHT_DESC'),
				'std'=>'',
				'depends'=>array(array('title', '!=', '')),
			),

			'title_text_color'=>array(
				'type'=>'color',
				'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_TITLE_TEXT_COLOR'),
				'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_TITLE_TEXT_COLOR_DESC'),
				'depends'=>array(array('title', '!=', '')),
			),

			'title_margin_top'=>array(
				'type'=>'number',
				'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_TITLE_MARGIN_TOP'),
				'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_TITLE_MARGIN_TOP_DESC'),
				'placeholder'=>'10',
				'depends'=>array(array('title', '!=', '')),
			),

			'title_margin_bottom'=>array(
				'type'=>'number',
				'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_TITLE_MARGIN_BOTTOM'),
				'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_TITLE_MARGIN_BOTTOM_DESC'),
				'placeholder'=>'10',
				'depends'=>array(array('title', '!=', '')),
			),

			'text'=>array(
				'type'=>'editor',
				'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_IMAGE_CONTENT_CONTENT'),
				'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_IMAGE_CONTENT_CONTENT_DESC'),
			),

			//Button
			'button_text'=>array(
				'type'=>'text',
				'title'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_TEXT'),
				'desc'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_TEXT_DESC'),
				'std'=>'Button Text',
			),

			'button_fontstyle'=>array(
				'type'=>'select',
				'title'=> Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_FONT_STYLE'),
				'values'=>array(
					'underline'=> Text::_('COM_SPPAGEBUILDER_GLOBAL_FONT_STYLE_UNDERLINE'),
					'uppercase'=> Text::_('COM_SPPAGEBUILDER_GLOBAL_FONT_STYLE_UPPERCASE'),
					'italic'=> Text::_('COM_SPPAGEBUILDER_GLOBAL_FONT_STYLE_ITALIC'),
					'lighter'=> Text::_('COM_SPPAGEBUILDER_GLOBAL_FONT_STYLE_LIGHTER'),
					'normal'=> Text::_('COM_SPPAGEBUILDER_GLOBAL_FONT_STYLE_NORMAL'),
					'bold'=> Text::_('COM_SPPAGEBUILDER_GLOBAL_FONT_STYLE_BOLD'),
					'bolder'=> Text::_('COM_SPPAGEBUILDER_GLOBAL_FONT_STYLE_BOLDER'),
				),
				'multiple'=>true,
				'std'=>'',
				'depends'=> array(
					array('button_text', '!=', ''),
				)
			),

			'button_letterspace'=>array(
				'type'=>'select',
				'title'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_LETTER_SPACING'),
				'values'=>array(
					'0'=> 'Default',
					'1px'=> '1px',
					'2px'=> '2px',
					'3px'=> '3px',
					'4px'=> '4px',
					'5px'=> '5px',
					'6px'=>	'6px',
					'7px'=>	'7px',
					'8px'=>	'8px',
					'9px'=>	'9px',
					'10px'=> '10px'
				),
				'std'=>'0',
				'depends'=> array(
					array('button_text', '!=', ''),
				)
			),

			'button_url'=>array(
				'type'=>'media',
				'format'=>'attachment',
				'title'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_URL'),
				'desc'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_URL_DESC'),
				'placeholder'=>'http://',
				'depends'=> array(
					array('button_text', '!=', ''),
				),
			),

			'button_target'=>array(
				'type'=>'select',
				'title'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_LINK_NEWTAB'),
				'desc'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_LINK_NEWTAB_DESC'),
				'values'=>array(
					''=>Text::_('COM_SPPAGEBUILDER_ADDON_GLOBAL_TARGET_SAME_WINDOW'),
					'_blank'=>Text::_('COM_SPPAGEBUILDER_ADDON_GLOBAL_TARGET_NEW_WINDOW'),
				),
				'depends'=> array(
					array('button_text', '!=', ''),
				)
			),

			'button_type'=>array(
				'type'=>'select',
				'title'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_STYLE'),
				'desc'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_STYLE_DESC'),
				'values'=>array(
					'default'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_DEFAULT'),
					'primary'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_PRIMARY'),
					'success'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_SUCCESS'),
					'info'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_INFO'),
					'warning'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_WARNING'),
					'danger'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_DANGER'),
					'link'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_LINK'),
					'custom'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_CUSTOM'),
				),
				'std'=>'default',
				'depends'=> array(
					array('button_text', '!=', ''),
				)
			),

			'button_appearance'=>array(
				'type'=>'select',
				'title'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_APPEARANCE'),
				'desc'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_APPEARANCE_DESC'),
				'values'=>array(
					''=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_APPEARANCE_FLAT'),
					'outline'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_APPEARANCE_OUTLINE'),
					'3d'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_APPEARANCE_3D'),
				),
				'std'=>'flat',
				'depends'=> array(
					array('button_text', '!=', ''),
				)
			),

			'button_background_color'=>array(
				'type'=>'color',
				'title'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_BACKGROUND_COLOR'),
				'desc'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_BACKGROUND_COLOR_DESC'),
				'std' => '#444444',
				'depends'=> array(
					array('button_type', '=', 'custom'),
					array('button_text', '!=', ''),
				)
			),

			'button_color'=>array(
				'type'=>'color',
				'title'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_COLOR'),
				'desc'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_COLOR_DESC'),
				'std' => '#fff',
				'depends'=> array(
					array('button_type', '=', 'custom'),
					array('button_text', '!=', ''),
				)
			),

			'button_background_color_hover'=>array(
				'type'=>'color',
				'title'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_BACKGROUND_COLOR_HOVER'),
				'desc'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_BACKGROUND_COLOR_HOVER_DESC'),
				'std' => '#222',
				'depends'=> array(
					array('button_type', '=', 'custom'),
					array('button_text', '!=', ''),
				)
			),

			'button_color_hover'=>array(
				'type'=>'color',
				'title'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_COLOR_HOVER'),
				'desc'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_COLOR_HOVER_DESC'),
				'std' => '#fff',
				'depends'=> array(
					array('button_type', '=', 'custom'),
					array('button_text', '!=', ''),
				)
			),

			'button_size'=>array(
				'type'=>'select',
				'title'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SIZE'),
				'desc'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SIZE_DESC'),
				'values'=>array(
					''=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SIZE_DEFAULT'),
					'lg'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SIZE_LARGE'),
					'xlg'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SIZE_XLARGE'),
					'sm'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SIZE_SMALL'),
					'xs'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SIZE_EXTRA_SAMLL'),
				),
				'depends'=> array(
					array('button_text', '!=', ''),
				)
			),

			'button_shape'=>array(
				'type'=>'select',
				'title'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SHAPE'),
				'desc'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SHAPE_DESC'),
				'values'=>array(
					'rounded'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SHAPE_ROUNDED'),
					'square'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SHAPE_SQUARE'),
					'round'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SHAPE_ROUND'),
				),
				'depends'=> array(
					array('button_text', '!=', ''),
				)
			),

			'button_block'=>array(
				'type'=>'select',
				'title'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_BLOCK'),
				'desc'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_BLOCK_DESC'),
				'values'=>array(
					''=>Text::_('JNO'),
					'sppb-btn-block'=>Text::_('JYES'),
				),
				'depends'=> array(
					array('button_text', '!=', ''),
				)
			),

			'button_icon'=>array(
				'type'=>'icon',
				'title'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_ICON'),
				'desc'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_ICON_DESC'),
				'depends'=> array(
					array('button_text', '!=', ''),
				)
			),

			'button_icon_position'=>array(
				'type'=>'select',
				'title'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_ICON_POSITION'),
				'values'=>array(
					'left'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_LEFT'),
					'right'=>Text::_('COM_SPPAGEBUILDER_GLOBAL_RIGHT'),
				),
				'depends'=> array(
					array('button_text', '!=', ''),
				),
			),

			'class'=>array(
				'type'=>'text',
				'title'=>Text::_('COM_SPPAGEBUILDER_ADDON_CLASS'),
				'desc'=>Text::_('COM_SPPAGEBUILDER_ADDON_CLASS_DESC'),
				'std'=>''
			),

		),
	),
	)
);
