<?php
/**
 * @package Helix3 Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright (c) 2010 - 2021 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
 */

//no direct accees
defined ('_JEXEC') or die ('resticted aceess');

use Joomla\CMS\Language\Text;

$rowSettings = array(
	'type'=>'general',
	'title'=>'',
	'attr'=>array(

		'name' => array(
			'type'		=> 'text',
			'title'		=> Text::_('HELIX_SECTION_TITLE'),
			'desc'		=> Text::_('HELIX_SECTION_TITLE_DESC'),
			'std'		=> ''
			),
		'background_color' => array(
			'type'		=> 'color',
			'title'		=> Text::_('HELIX_SECTION_BACKGROUND_COLOR'),
			'desc'		=> Text::_('HELIX_SECTION_BACKGROUND_COLOR_DESC')
			),
		'color' => array(
			'type'		=> 'color',
			'title'		=> Text::_('HELIX_SECTION_TEXT_COLOR'),
			'desc'		=> Text::_('HELIX_SECTION_TEXT_COLOR_DESC')
			),
		'background_image' => array(
			'type'		=> 'media',
			'title'		=> Text::_('HELIX_SECTION_BACKGROUND_IMAGE'),
			'desc'		=> Text::_('HELIX_SECTION_BACKGROUND_IMAGE_DESC'),
			'std'		=> '',
			),
		'background_repeat'=>array(
			'type'=>'select',
			'title'=>Text::_('HELIX_BG_REPEAT'),
			'desc'=>Text::_('HELIX_BG_REPEAT_DESC'),
			'values'=>array(
				'no-repeat'=>Text::_('HELIX_BG_REPEAT_NO'),
				'repeat'=>Text::_('HELIX_BG_REPEAT_ALL'),
				'repeat-x'=>Text::_('HELIX_BG_REPEAT_HORIZ'),
				'repeat-y'=>Text::_('HELIX_BG_REPEAT_VERTI'),
				'inherit'=>Text::_('HELIX_BG_REPEAT_INHERIT'),
				),
			'std'=>'no-repeat',
			),
		'background_size' => array(
			'type'		=> 'select',
			'title'=>Text::_('HELIX_BG_SIZE'),
			'desc'=>Text::_('HELIX_BG_SIZE_DESC'),
			'values'=>array(
				'cover'=>Text::_('HELIX_BG_COVER'),
				'contain'=>Text::_('HELIX_BG_CONTAIN'),
				'inherit'=>Text::_('HELIX_BG_INHERIT'),
				),
			'std'=>'cover',
			),
		'background_attachment'=>array(
			'type'=>'select',
			'title'=>Text::_('HELIX_BG_ATTACHMENT'),
			'desc'=>Text::_('HELIX_BG_ATTACHMENT_DESC'),
			'values'=>array(
				'fixed'=>Text::_('HELIX_BG_ATTACHMENT_FIXED'),
				'scroll'=>Text::_('HELIX_BG_ATTACHMENT_SCROLL'),
				'inherit'=>Text::_('HELIX_BG_ATTACHMENT_INHERIT'),
				),
			'std'=>'fixed',
			),
		'background_position' => array(
			'type'		=> 'select',
			'title'=>Text::_('HELIX_BG_POSITION'),
			'desc'=>Text::_('HELIX_BG_POSITION_DESC'),
			'values'=>array(
				'0 0'=>Text::_('HELIX_BG_POSITION_LEFT_TOP'),
				'0 50%'=>Text::_('HELIX_BG_POSITION_LEFT_CENTER'),
				'0 100%'=>Text::_('HELIX_BG_POSITION_LEFT_BOTTOM'),
				'50% 0'=>Text::_('HELIX_BG_POSITION_CENTER_TOP'),
				'50% 50%'=>Text::_('HELIX_BG_POSITION_CENTER_CENTER'),
				'50% 100%'=>Text::_('HELIX_BG_POSITION_CENTER_BOTTOM'),
				'100% 0'=>Text::_('HELIX_BG_POSITION_RIGHT_TOP'),
				'100% 50%'=>Text::_('HELIX_BG_POSITION_RIGHT_CENTER'),
				'100% 100%'=>Text::_('HELIX_BG_POSITION_RIGHT_BOTTOM'),
				),
			'std'=>'0 0',
			),
		'link_color' => array(
			'type'		=> 'color',
			'title'		=> Text::_('HELIX_LINK_COLOR'),
			'desc'		=> Text::_('HELIX_LINK_COLOR_DESC')
			),
		'link_hover_color' => array(
			'type'		=> 'color',
			'title'		=> Text::_('HELIX_LINK_HOVER_COLOR'),
			'desc'		=> Text::_('HELIX_LINK_HOVER_COLOR_DESC')
			),
		'hidden_xs' 		=> array(
			'type'		=> 'checkbox',
			'title'		=> Text::_('HELIX_HIDDEN_MOBILE'),
			'desc'		=> Text::_('HELIX_HIDDEN_MOBILE_DESC'),
			'std'		=> '',
			),
		'hidden_sm' 		=> array(
			'type'		=> 'checkbox',
			'title'		=> Text::_('HELIX_HIDDEN_TABLET'),
			'desc'		=> Text::_('HELIX_HIDDEN_TABLET_DESC'),
			'std'		=> '',
			),
		'hidden_md' 		=> array(
			'type'		=> 'checkbox',
			'title'		=> Text::_('HELIX_HIDDEN_DESKTOP'),
			'desc'		=> Text::_('HELIX_HIDDEN_DESKTOP_DESC'),
			'std'		=> '',
			),
		'padding' => array(
			'type'		=> 'text',
			'title'		=> Text::_('HELIX_PADDING'),
			'desc'		=> Text::_('HELIX_PADDING_DESC'),
			'std'		=> ''
			),
		'margin' => array(
			'type'		=> 'text',
			'title'		=> Text::_('HELIX_MARGIN'),
			'desc'		=> Text::_('HELIX_MARGIN_DESC'),
			'std'		=> ''
			),
		'fluidrow' 		=> array(
			'type'		=> 'checkbox',
			'title'		=> Text::_('HELIX_ROW_FULL_WIDTH'),
			'desc'		=> Text::_('HELIX_ROW_FULL_WIDTH_DESC'),
			'std'		=> '',
			),
		'custom_class' => array(
			'type'		=> 'text',
			'title'		=> Text::_('HELIX_CUSTOM_CLASS'),
			'desc'		=> Text::_('HELIX_CUSTOM_CLASS_DESC'),
			'std'		=> ''
			),
		)
	);

$columnSettings = array(
	'type'=>'general',
	'title'=>'',
	'attr'=>array(

		'column_type' => array(
			'type'		=> 'checkbox',
			'title'		=> Text::_('HELIX_COMPONENT'),
			'desc'		=> Text::_('HELIX_COMPONENT_DESC'),
			'std'=>'',
			),
		'name' => array(
			'type'		=> 'select',
			'title'		=> Text::_('HELIX_MODULE_POSITION'),
			'desc'		=> Text::_('HELIX_MODULE_POSITION_DESC'),
			'values'	=> array(),
			'std'=>'none',
			),
		'hidden_xs' 		=> array(
			'type'		=> 'checkbox',
			'title'		=> Text::_('HELIX_HIDDEN_MOBILE'),
			'desc'		=> Text::_('HELIX_HIDDEN_MOBILE_DESC'),
			'std'		=> '',
			),
		'hidden_sm' 		=> array(
			'type'		=> 'checkbox',
			'title'		=> Text::_('HELIX_HIDDEN_TABLET'),
			'desc'		=> Text::_('HELIX_HIDDEN_TABLET_DESC'),
			'std'		=> '',
			),
		'hidden_md' 		=> array(
			'type'		=> 'checkbox',
			'title'		=> Text::_('HELIX_HIDDEN_DESKTOP'),
			'desc'		=> Text::_('HELIX_HIDDEN_DESKTOP_DESC'),
			'std'		=> '',
			),
		'sm_col' 		=> array(
			'type'		=> 'select',
			'title'		=> Text::_('HELIX_TABLET_LAYOUT'),
			'desc'		=> Text::_('HELIX_TABLET_LAYOUT_DESC'),
			'values'	=> array(
				'' => "",
				'col-sm-1' => 'col-md-1',
				'col-sm-2' => 'col-md-2',
				'col-sm-3' => 'col-md-3',
				'col-sm-4' => 'col-md-4',
				'col-sm-5' => 'col-md-5',
				'col-sm-6' => 'col-md-6',
				'col-sm-7' => 'col-md-7',
				'col-sm-8' => 'col-md-8',
				'col-sm-9' => 'col-md-9',
				'col-sm-10' => 'col-md-10',
				'col-sm-11' => 'col-md-11',
				'col-sm-12' => 'col-md-12',
				),
			'std'		=> '',
			),
		'xs_col' 		=> array(
			'type'		=> 'select',
			'title'		=> Text::_('HELIX_MOBILE_LAYOUT'),
			'desc'		=> Text::_('HELIX_MOBILE_LAYOUT_DESC'),
			'values'	=> array(
				'' => "",
				'col-xs-1' => 'col-1',
				'col-xs-2' => 'col-2',
				'col-xs-3' => 'col-3',
				'col-xs-4' => 'col-4',
				'col-xs-5' => 'col-5',
				'col-xs-6' => 'col-6',
				'col-xs-7' => 'col-7',
				'col-xs-8' => 'col-8',
				'col-xs-9' => 'col-9',
				'col-xs-10' => 'col-10',
				'col-xs-11' => 'col-11',
				'col-xs-12' => 'col-12',
				),
			'std'		=> '',
			),
		'custom_class' => array(
			'type'		=> 'text',
			'title'		=> Text::_('HELIX_CUSTOM_CLASS'),
			'desc'		=> Text::_('HELIX_CUSTOM_CLASS_DESC'),
			'std'		=> ''
			),
		)
	);

class RowColumnSettings{

	private static function getInputElements( $key, $attr )
	{
		return call_user_func(array( 'SpType' . ucfirst( $attr['type'] ), 'getInput'), $key, $attr );
	}

	public static function getRowSettings($row_settings = array())
	{

		$output = '<div class="hidden">';
		$output .= '<div class="row-settings">';

		foreach ($row_settings['attr'] as $key => $rowAttr) {
			$output .= self::getInputElements( $key, $rowAttr );
		}

		$output .= '</div>';
		$output .= '</div>';

		return $output;
	}

	public static function getColumnSettings($col_settings = array())
	{

		$col_settings['attr']['name']['values'] = self::getPositionss();

		$output = '<div class="hidden">';
		$output .= '<div class="column-settings">';

		foreach ($col_settings['attr'] as $key => $rowAttr) {
			$output .= self::getInputElements( $key, $rowAttr );
		}

		$output .= '</div>';
		$output .= '</div>';

		return $output;
	}

	public static function getTemplateName()
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select($db->quoteName(array('template')));
		$query->from($db->quoteName('#__template_styles'));
		$query->where($db->quoteName('client_id') . ' = 0');
		$query->where($db->quoteName('home') . ' = 1');
		$db->setQuery($query);

		return $db->loadObject()->template;
	}


	public static function getPositionss() {

	    $db = JFactory::getDBO();
	    $query = 'SELECT `position` FROM `#__modules` WHERE  `client_id`=0 AND ( `published` !=-2 AND `published` !=0 ) GROUP BY `position` ORDER BY `position` ASC';

	    $db->setQuery($query);
	    $dbpositions = (array) $db->loadAssocList();

		$template  = self::getTemplateName();

	    $templateXML = JPATH_SITE.'/templates/'.$template.'/templateDetails.xml';
	    $template = simplexml_load_file( $templateXML );
	    $options = array();

	    foreach($dbpositions as $positions) $options[] = $positions['position'];

	    foreach($template->positions[0] as $position)  $options[] =  (string) $position;

	    $options = array_unique($options);

	    $selectOption = array();
	    sort($selectOption);

	    foreach($options as $option) $selectOption[$option] = $option;

	    return $selectOption;
	}

	public static function getSettings($config = null){
		$data = '';
		if ($config) {
			foreach ($config as $key => $value) {
				$data .= ' data-'.$key.'="'.$value.'"';
			}
		}
		return $data;
	}
}