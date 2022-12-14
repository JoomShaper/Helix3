<?php
/**
 * @package Helix3 Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright (c) 2010 - 2021 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
 */

 //no direct access
defined('_JEXEC') or die ('restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Filesystem\File;
use Joomla\CMS\Filesystem\Folder;
use Joomla\CMS\Filter\OutputFilter;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Layout\FileLayout;
use Joomla\CMS\Uri\Uri;

class Helix3
{

	private static $_instance;
	private $document;
	private $importedFiles = array();
	private $_less;

	private $load_pos;

	//initialize
	public function __construct()
	{
	}

	/**
	* making self object for singleton method
	*
	*/
	final public static function getInstance()
	{
		if (!self::$_instance)
		{
			self::$_instance = new self();
			self::getInstance()->getDocument();
		}

		return self::$_instance;
	}

	/**
	* Get Document
	*
	* @param string $key
	*/
	public static function getDocument($key = false)
	{
		self::getInstance()->document = Factory::getDocument();
		$doc                          = self::getInstance()->document;
		if (is_string($key))
		{
			return $doc->$key;
		}

		return $doc;
	}

	public static function getParam($key)
	{
		$params = Factory::getApplication()->getTemplate(true)->params;

		return $params->get($key);
	}

	public static function loadHead()
	{
		$doc         = Factory::getDocument();
		$app         = Factory::getApplication();
		$option      = $app->input->get('option', '');
		$view        = $app->input->get('view', '');
		$layout        = $app->input->get('layout', '');

		// Favicon
		if ($favicon = self::getParam('favicon'))
		{
			$doc->addFavicon(Uri::base(true) . '/' . $favicon);
		}
		else
		{
			$doc->addFavicon(self::getTemplateUri() . '/images/favicon.ico');
		}

		// load legacy css
		if (($view == 'form' && $layout == 'edit') || ($option = 'com_config' && $view == 'modules'))
		{
			if (JVERSION < 4)
			{
				$doc->addStylesheet(Uri::base(true) . '/plugins/system/helix3/assets/css/system.j3.min.css');
			}
			else
			{
				$doc->addStylesheet(Uri::base(true) . '/plugins/system/helix3/assets/css/system.j4.min.css');
			}
		}

		// web fonts
		self::loadWebFonts();

		HTMLHelper::_('jquery.framework');

		// Remove Joomla core bootstrap
		if (JVERSION < 4)
		{
			HTMLHelper::_('bootstrap.framework');
			if(isset($doc->_scripts[Uri::base(true) . '/media/jui/js/bootstrap.min.js'])) {
				unset($doc->_scripts[Uri::base(true) . '/media/jui/js/bootstrap.min.js']);
			}

			$doc->addScript(Uri::root(true) . '/plugins/system/helix3/assets/js/bootstrap.legacy.js');
		}

		echo '<jdoc:include type="head" />';
	}

	//Body Class
	public static function bodyClass($class = '')
	{
		$app       = Factory::getApplication();
		$doc       = Factory::getDocument();
		$language  = $doc->language;
		$direction = $doc->direction;
		$option    = str_replace('_', '-', $app->input->getCmd('option', ''));
		$view      = $app->input->getCmd('view', '');
		$layout    = $app->input->getCmd('layout', '');
		$task      = $app->input->getCmd('task', '');
		$itemid    = $app->input->getCmd('Itemid', '');
		$menu      = $app->getMenu()->getActive();
		if ($menu) {
			$pageclass = $menu->getParams()->get('pageclass_sfx');
		}

		if ($view == 'modules')
		{
			$layout = 'edit';
		}

		return 'site ' . $option
		. ' view-' . $view
		. ($layout ? ' layout-' . $layout : ' no-layout')
		. ($task ? ' task-' . $task : ' no-task')
		. ($itemid ? ' itemid-' . $itemid : '')
		. ($language ? ' ' . $language : '')
		. ($direction ? ' ' . $direction : '')
		. (isset($pageclass) && $pageclass ? ' ' . $pageclass : '')
		. ($class ? ' ' . $class : '');
	}

	//Get view
	public static function view($class = '')
	{
		$app    = Factory::getApplication();
		$view   = $app->input->getCmd('view', '');
		$layout = $app->input->getCmd('layout', '');

		if (($view == 'modules'))
		{
			$layout = 'edit';
		}

		return $layout;
	}

	//Get Template name
	public static function getTemplate()
	{
		return Factory::getApplication()->getTemplate();
	}

	//Get Template URI
	public static function getTemplateUri()
	{
		return Uri::base(true) . '/templates/' . self::getTemplate();
	}

	/**
	* Get or set Template param. If value not setted params get and return,
	* else set params
	*
	* @param string $name
	* @param mixed  $value
	*/
	public static function Param($name = true, $value = null)
	{

		// if $name = true, this will return all param data
		if (is_bool($name) and $name == true)
		{
			return Factory::getApplication()->getTemplate(true)->params;
		}
		// if $value = null, this will return specific param data
		if (is_null($value))
		{
			return Factory::getApplication()->getTemplate(true)->params->get($name);
		}
		// if $value not = null, this will set a value in specific name.

		$data = Factory::getApplication()->getTemplate(true)->params->get($name);

		if (is_null($data) or !isset($data))
		{
			Factory::getApplication()->getTemplate(true)->params->set($name, $value);

			return $value;
		}
		else
		{
			return $data;
		}
	}

	/**
	* Importing features
	*
	* @access private
	*/
	private $inPositions = array();
	public $loadFeature = array();

	private static function importFeatures()
	{

		$template = Factory::getApplication()->getTemplate();
		$path     = JPATH_THEMES . '/' . $template . '/features';

		if (file_exists($path))
		{
			$files = Folder::files($path, '.php');

			if (count($files))
			{
				foreach ($files as $key => $file)
				{

					include_once $path . '/' . $file;
					$name = File::stripExt($file);

					$class = 'Helix3Feature' . ucfirst($name);
					$class = new $class(self::getInstance());

					$position = $class->position;
					$load_pos = (isset($class->load_pos) && $class->load_pos) ? $class->load_pos : '';

					self::getInstance()->inPositions[] = $position;

					if (!empty($position))
					{
						self::getInstance()->loadFeature[$position][$key]['feature'] = $class->renderFeature();
						self::getInstance()->loadFeature[$position][$key]['load_pos'] = $load_pos;
					}
				}
			}
		}

		return self::getInstance();
	}

	/**
	* get number from col-xs
	*
	* @param string $col_name
	*/
	public static function getColXsNo($col_name)
	{
		//Remove Classes name
		$class_remove = array('layout-column', 'column-active', 'col-sm-');

		return (int) trim(str_replace($class_remove, '', $col_name));
	}

	public static function generatelayout()
	{
		self::getInstance()->addCSS('custom.css');
		self::getInstance()->addJS('custom.js');

		$doc         = Factory::getDocument();
		$app         = Factory::getApplication();
		$option      = $app->input->get('option', '');
		$view        = $app->input->get('view', '');
		$layout      = $app->input->get('layout', '');
		$pagebuilder = false;
		$params = Factory::getApplication()->getTemplate(true)->params;

		if ($option == 'com_sppagebuilder')
		{
			$doc->addStylesheet(Uri::base(true) . '/plugins/system/helix3/assets/css/pagebuilder.css');
			$pagebuilder = true;
		}

		// add container width
		$container_width = (int) $params->get('container_width', 1140);
		if ($container_width == 1140)
		{
			$container_css = "@media (min-width: 1400px) {\n";
				$container_css .= ".container {\n";
					$container_css .= "max-width: 1140px;\n";
				$container_css .= "}\n";
			$container_css .= "}";

			self::getInstance()->addInlineCSS($container_css);
		}

		//Import Features
		self::importFeatures();
		$rows   = json_decode($params->get('layout'));

		//Load from file if not exists in database
		if (empty($rows))
		{
			$layout_file = JPATH_SITE . '/templates/' . self::getTemplate() . '/layout/default.json';
			if (!File::exists($layout_file))
			{
				die('Default Layout file is not exists! Please goto to template manager and create a new layout first.');
			}
			$rows = json_decode(file_get_contents($layout_file));
		}

		$output = '';

		foreach ($rows as $key => $row)
		{
			$rowColumns = self::rowColumns($row->attr);

			if (!empty($rowColumns))
			{

				$componentArea = false;

				if (self::hasComponent($rowColumns))
				{
					$componentArea = true;
				}

				$fluidrow = false;
				if (!empty($row->settings->fluidrow))
				{
					$fluidrow = $row->settings->fluidrow;
				}

				$id = (empty($row->settings->name)) ? 'sp-section-' . ($key + 1) : 'sp-' . OutputFilter::stringURLSafe($row->settings->name);

				$row_class = '';

				$hidden_on_phone = isset($row->settings->hidden_xs) && $row->settings->hidden_xs ? true : false;
				$hidden_on_tablet = isset($row->settings->hidden_sm) && $row->settings->hidden_sm ? true : false;
				$hidden_on_desktop = isset($row->settings->hidden_md) && $row->settings->hidden_md ? true : false;

				if ($hidden_on_desktop && $hidden_on_tablet && $hidden_on_phone)
				{
					$row_class = 'd-none';
				}
				else if ($hidden_on_desktop && $hidden_on_tablet)
				{
					$row_class = 'd-block d-md-none';
				}
				else if ($hidden_on_desktop && $hidden_on_phone)
				{
					$row_class = 'd-none d-md-block d-lg-none';
				}
				else if ($hidden_on_tablet && $hidden_on_phone)
				{
					$row_class = 'd-none d-lg-block';
				}
				else if ($hidden_on_desktop)
				{
					$row_class = 'd-lg-none';
				}
				else if ($hidden_on_tablet)
				{
					$row_class = 'd-md-none d-lg-block';
				}
				else if ($hidden_on_phone)
				{
					$row_class = 'd-none d-md-block';
				}

				if (!empty($row->settings->custom_class))
				{
					$row_class .= ' ' . $row->settings->custom_class;
				}

				if ($row_class)
				{
					$row_class = ' class="' . $row_class . '"';
				}
				else
				{
					$row_class = '';
				}

				//css
				$row_css = '';

				if (!empty($row->settings->background_image)) {

					$row_css .= 'background-image:url("' . Uri::base(true) . '/' . htmlspecialchars((JVERSION < 4 ? $row->settings->background_image : HTMLHelper::cleanImageURL($row->settings->background_image)->url), ENT_COMPAT, 'UTF-8') . '");';

					if (!empty($row->settings->background_repeat)) {
						$row_css .= 'background-repeat:' . $row->settings->background_repeat . ';';
					}

					if (!empty($row->settings->background_size)) {
						$row_css .= 'background-size:' . $row->settings->background_size . ';';
					}

					if (!empty($row->settings->background_attachment)) {
						$row_css .= 'background-attachment:' . $row->settings->background_attachment . ';';
					}

					if (!empty($row->settings->background_position)) {
						$row_css .= 'background-position:' . $row->settings->background_position . ';';
					}
				}

				if (!empty($row->settings->background_color)) {
					$row_css .= 'background-color:' . $row->settings->background_color . ';';
				}

				if (!empty($row->settings->color)) {
					$row_css .= 'color:' . $row->settings->color . ';';
				}

				if (!empty($row->settings->padding)) {
					$row_css .= 'padding:' . $row->settings->padding . ';';
				}

				if (!empty($row->settings->margin)) {
					$row_css .= 'margin:' . $row->settings->margin . ';';
				}

				if ($row_css) {
					$doc->addStyledeclaration('#' . $id . '{ ' . $row_css . ' }');
				}

				//Link Color
				if (!empty($row->settings->link_color)) {
					$doc->addStyledeclaration('#' . $id . ' a{color:' . $row->settings->link_color . ';}');
				}

				//Link Hover Color
				if (!empty($row->settings->link_hover_color)) {
					$doc->addStyledeclaration('#' . $id . ' a:hover{color:' . $row->settings->link_hover_color . ';}');
				}

				// set html5 stracture
				$sematic = (!empty($row->settings->name)) ? strtolower($row->settings->name) : 'section';

				switch ($sematic)
				{
					case "header":
					$sematic = 'header';
					break;

					case "footer":
					$sematic = 'footer';
					break;

					default:
					$sematic = 'section';
					break;
				}

				$layout_data = array(
					'sematic' 			=> $sematic,
					'id' 				=> $id,
					'row_class' 		=> $row_class,
					'componentArea' 	=> $componentArea,
					'pagebuilder' 		=> $pagebuilder,
					'fluidrow' 			=> $fluidrow,
					'rowColumns' 		=> $rowColumns,
					'componentArea' 	=> $componentArea,
					'componentArea' 	=> $componentArea,
				);

				$template  		= Factory::getApplication()->getTemplate();
				$themepath 		= JPATH_THEMES . '/' . $template;
				$generate_file	= $themepath . '/html/layouts/helix3/frontend/generate.php';
				$lyt_thm_path   = $themepath . '/html/layouts/helix3/';

				$layout_path  = (file_exists($generate_file)) ? $lyt_thm_path : JPATH_ROOT .'/plugins/system/helix3/layouts';

				$getLayout = new FileLayout('frontend.generate', $layout_path );
				$output .= $getLayout->render($layout_data);

			}
		}

		echo $output;
	}

	/* Detect component row */
	private static function hasComponent($rowColumns)
	{

		$hasComponent = false;

		foreach ($rowColumns as $key => $column)
		{

			if ($column->settings->column_type)
			{ /* Component */

				$hasComponent = true;
			}
		}

		return $hasComponent;
	}

	//Get Active Columns
	private static function rowColumns($columns)
	{
		$doc  = Factory::getDocument();
		$cols = array();

		//Inactive
		$absspan        = 0; //   absence span
		$col_i          = 1;
		$totalPublished = count($columns); // total publish children
		$hasComponent   = false;

		foreach ($columns as &$column)
		{

			$column->settings->name         = (!empty($column->settings->name)) ? $column->settings->name : 'none_empty';
			$column->settings->column_type  = (!empty($column->settings->column_type)) ? $column->settings->column_type : 0;
			$column->settings->custom_class = (!empty($column->settings->custom_class)) ? $column->settings->custom_class : '';

			if (!$column->settings->column_type)
			{
				if (!self::countModules($column->settings->name))
				{
					$col_xs_no = self::getColXsNo($column->className);
					$absspan += $col_xs_no;
					$totalPublished--;
				}
			}
			else
			{
				$hasComponent = true;
			}
		}

		//Active
		foreach ($columns as &$column)
		{

			if ($column->settings->column_type)
			{
				$column->className = 'col-lg-' . (self::getColXsNo($column->className) + $absspan);
				$cols[]            = $column;
				$col_i++;
			}
			else
			{

				if (self::countModules($column->settings->name))
				{

					$last_col = ($totalPublished == $col_i) ? $absspan : 0;
					if ($hasComponent)
					{
						$column->className = 'col-lg-' . self::getColXsNo($column->className);
					}
					else
					{
						$column->className = 'col-lg-' . (self::getColXsNo($column->className) + $last_col);
					}

					$cols[] = $column;
					$col_i++;
				}
			}
		}

		return $cols;
	}

	//Count Modules
	public static function countModules($position)
	{
		$doc = Factory::getDocument();

		return ($doc->countModules($position) or self::hasFeature($position));
	}

	/**
	* Has feature
	*
	* @param string $position
	*/

	public static function hasFeature($position)
	{

		if (in_array($position, self::getInstance()->inPositions))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	/**
	* Add stylesheet
	*
	* @param mixed $sources . string or array
	*
	* @return self
	*/
	public static function addCSS($sources, $attribs = array())
	{

		$template = Factory::getApplication()->getTemplate();
		$path     = JPATH_THEMES . '/' . $template . '/css/';

		$srcs = array();

		if (is_string($sources))
		{
			$sources = explode(',', $sources);
		}
		if (!is_array($sources))
		{
			$sources = array($sources);
		}

		foreach ((array) $sources as $source)
		$srcs[] = trim($source);

		foreach ($srcs as $src)
		{

			if (file_exists($path . $src))
			{
				self::getInstance()->document->addStyleSheet(Uri::base(true) . '/templates/' . $template . '/css/' . $src, [], $attribs);
			}
			else
			{
				if ($src != 'custom.css')
				{
					self::getInstance()->document->addStyleSheet($src, [], $attribs);
				}
			}
		}

		return self::getInstance();
	}

	/**
	* Add javascript
	*
	* @param mixed  $sources   . string or array
	* @param string $seperator . default is , (comma)
	*
	* @return self
	*/
	public static function addJS($sources, $seperator = ',')
	{

		$srcs = array();

		$template = Factory::getApplication()->getTemplate();
		$path     = JPATH_THEMES . '/' . $template . '/js/';

		if (is_string($sources))
		{
			$sources = explode($seperator, $sources);
		}
		if (!is_array($sources))
		{
			$sources = array($sources);
		}

		foreach ((array) $sources as $source)
		$srcs[] = trim($source);

		foreach ($srcs as $src)
		{

			if (file_exists($path . $src))
			{
				self::getInstance()->document->addScript(Uri::base(true) . '/templates/' . $template . '/js/' . $src);
			}
			else
			{
				if ($src != 'custom.js')
				{
					self::getInstance()->document->addScript($src);
				}
			}
		}

		return self::getInstance();
	}

	/**
	* Add Inline Javascript
	*
	* @param mixed $code
	*
	* @return self
	*/
	public function addInlineJS($code)
	{
		self::getInstance()->document->addScriptDeclaration($code);

		return self::getInstance();
	}

	/**
	* Add Inline CSS
	*
	* @param mixed $code
	*
	* @return self
	*/
	public function addInlineCSS($code)
	{
		self::getInstance()->document->addStyleDeclaration($code);

		return self::getInstance();
	}

	/**
	* Less Init
	*
	*/
	public static function lessInit()
	{

		require_once __DIR__ . '/classes/lessc.inc.php';

		self::getInstance()->_less = new helix3_lessc();

		return self::getInstance();
	}

	/**
	* Instance of Less
	*/
	public static function less()
	{
		return self::getInstance()->_less;
	}

	/**
	* Set Less Variables using array key and value
	*
	* @param mixed $array
	*
	* @return self
	*/
	public static function setLessVariables($array)
	{
		self::getInstance()->less()->setVariables($array);

		return self::getInstance();
	}

	/**
	* Set less variable using name and value
	*
	* @param mixed $name
	* @param mixed $value
	*
	* @return self
	*/
	public static function setLessVariable($name, $value)
	{
		self::getInstance()->less()->setVariables(array($name => $value));

		return self::getInstance();
	}

	/**
	* Compile less to css when less modified or css not exist
	*
	* @param mixed $less
	* @param mixed $css
	*
	* @return self
	*/
	private static function autoCompileLess($less, $css)
	{
		// load the cache
		$template  = Factory::getApplication()->getTemplate();
		$cachePath = JPATH_CACHE . '/com_templates/templates/' . $template;
		$cacheFile = $cachePath . '/' . basename($css . ".cache");

		if (file_exists($cacheFile))
		{
			$cache = unserialize(file_get_contents($cacheFile));

			//If root changed then do not compile
			if (isset($cache['root']) && $cache['root'])
			{
				if ($cache['root'] != $less)
				{
					return self::getInstance();
				}
			}
		}
		else
		{
			$cache = $less;
		}

		$lessInit = self::getInstance()->less();
		$newCache = $lessInit->cachedCompile($cache);

		if (!is_array($cache) || $newCache["updated"] > $cache["updated"])
		{

			if (!file_exists($cachePath))
			{
				Folder::create($cachePath, 0755);
			}

			file_put_contents($cacheFile, serialize($newCache));
			file_put_contents($css, $newCache['compiled']);
		}

		return self::getInstance();
	}

	/**
	* Add Less
	*
	* @param mixed $less
	* @param mixed $css
	*
	* @return self
	*/
	public static function addLess($less, $css, $attribs = array())
	{
		$template  = Factory::getApplication()->getTemplate();
		$themepath = JPATH_THEMES . '/' . $template;

		if (self::getParam('lessoption') and self::getParam('lessoption') == '1')
		{
			if (file_exists($themepath . "/less/" . $less . ".less"))
			{
				self::getInstance()->autoCompileLess($themepath . "/less/" . $less . ".less", $themepath . "/css/" . $css . ".css");
			}
		}
		self::getInstance()->addCSS($css . '.css', $attribs);

		return self::getInstance();
	}

	private static function addLessFiles($less, $css)
	{

		$less = self::getInstance()->file('less/' . $less . '.less');
		$css  = self::getInstance()->file('css/' . $css . '.css');
		self::getInstance()->less()->compileFile($less, $css);

		echo $less;
		die;

		return self::getInstance();
	}

	private static function resetCookie($name)
	{
		if (JRequest::getVar('reset', '', 'get') == 1)
		{
			setcookie($name, '', time() - 3600, '/');
		}
	}

	/**
	* Preset
	*
	*/
	public static function Preset()
	{
		$template = Factory::getApplication()->getTemplate();
		$name     = $template . '_preset';

		if (isset($_COOKIE[$name]))
		{
			$current = $_COOKIE[$name];
		}
		else
		{
			$current = self::getParam('preset');
		}

		return $current;
	}

	public static function PresetParam($name)
	{
		return self::getParam(self::getInstance()->Preset() . $name);
	}

	/**
	* Load Menu
	*
	* @since    1.0
	*/
	public static function loadMegaMenu($class = "", $name = '')
	{
		require_once __DIR__ . '/classes/menu.php';

		return new Helix3Menu($class, $name);
	}


	/**
	* Convert object to array
	*
	*/
	public static function object_to_array($obj) {
		if(is_object($obj)) $obj = (array) $obj;
		if(is_array($obj)) {
			$new = array();
			foreach($obj as $key => $val) {
				$new[$key] = self::object_to_array($val);
			}
		}
		else $new = $obj;
		return $new;
	}

	/**
	* Convert object to array
	*
	*/
	public static function font_key_search($font, $fonts) {

		foreach ($fonts as $key => $value) {
			if($value['family'] == $font) {
				return $key;
			}
		}

		return 0;
	}

	/**
	 * Load Web Fonts
	 */
	public static function loadWebFonts()
	{
		//Body Font
		$webfonts = array();

		if (self::getParam('enable_body_font'))
		{
			$webfonts['body'] = self::getParam('body_font');
		}

		//Heading1 Font
		if (self::getParam('enable_h1_font'))
		{
			$webfonts['h1'] = self::getParam('h1_font');
		}

		//Heading2 Font
		if (self::getParam('enable_h2_font'))
		{
			$webfonts['h2'] = self::getParam('h2_font');
		}

		//Heading3 Font
		if (self::getParam('enable_h3_font'))
		{
			$webfonts['h3'] = self::getParam('h3_font');
		}

		//Heading4 Font
		if (self::getParam('enable_h4_font'))
		{
			$webfonts['h4'] = self::getParam('h4_font');
		}

		//Heading5 Font
		if (self::getParam('enable_h5_font'))
		{
			$webfonts['h5'] = self::getParam('h5_font');
		}

		//Heading6 Font
		if (self::getParam('enable_h6_font'))
		{
			$webfonts['h6'] = self::getParam('h6_font');
		}

		//Navigation Font
		if (self::getParam('enable_navigation_font'))
		{
			$webfonts['.sp-megamenu-parent'] = self::getParam('navigation_font');
		}

		//Custom Font
		if (self::getParam('enable_custom_font') && self::getParam('custom_font_selectors'))
		{
			$webfonts[self::getParam('custom_font_selectors')] = self::getParam('custom_font');
		}

		self::addGoogleFont($webfonts);
	}

	/**
	* Add Google Fonts
	*
	* @param string $name  . Name of font. Ex: Yanone+Kaffeesatz:400,700,300,200 or Yanone+Kaffeesatz  or Yanone
	*                      Kaffeesatz
	* @param string $field . Applied selector. Ex: h1, h2, #id, .classname
	*/
	public static function addGoogleFont($fonts)
	{
		$doc = Factory::getDocument();
		$webfonts = '';
		$tpl_path = JPATH_BASE . '/templates/' . Factory::getApplication()->getTemplate() . '/webfonts/webfonts.json';
		$plg_path = JPATH_BASE . '/plugins/system/helix3/assets/webfonts/webfonts.json';

		if (file_exists($tpl_path))
		{
			$webfonts = file_get_contents($tpl_path);
		}
		else if (file_exists($plg_path))
		{
			$webfonts = file_get_contents($plg_path);
		}

		//Families
		$families = array();
		foreach ($fonts as $key => $value)
		{
			$value = json_decode($value);

			if (isset($value->fontWeight) && $value->fontWeight)
			{
				$families[$value->fontFamily]['weight'][] = $value->fontWeight;
			}

			if (isset($value->fontSubset) && $value->fontSubset)
			{
				$families[$value->fontFamily]['subset'][] = $value->fontSubset;
			}
		}

		//Selectors
		$selectors = array();
		foreach ($fonts as $key => $value)
		{
			$value = json_decode($value);

			if (isset($value->fontFamily) && $value->fontFamily)
			{
				$selectors[$key]['family'] = $value->fontFamily;
			}

			if (isset($value->fontSize) && $value->fontSize)
			{
				$selectors[$key]['size'] = $value->fontSize;
			}

			if (isset($value->fontWeight) && $value->fontWeight)
			{
				$selectors[$key]['weight'] = $value->fontWeight;
			}
		}

		//Add Google Font URL
		foreach ($families as $key => $value)
		{
			$output = str_replace(' ', '+', $key);

			// Weight
			if($webfonts) {
				$fonts_array = self::object_to_array(json_decode($webfonts));
				$font_key = self::font_key_search($key, $fonts_array['items']);
				$weight_array = $fonts_array['items'][$font_key]['variants'];
				$output .= ':' . implode(',', $weight_array);
			} else {
				$weight = array_unique($value['weight']);
				if (isset($weight) && $weight)
				{
					$output .= ':' . implode(',', $weight);
				}
			}

			// Subset
			$subset = array_unique($value['subset']);
			if (isset($subset) && $subset)
			{
				$output .= '&amp;subset=' . implode(',', $subset);
			}

			$doc->addStylesheet('//fonts.googleapis.com/css?family=' . $output);
		}

		//Add font to Selector
		foreach ($selectors as $key => $value)
		{

			if (isset($value['family']) && $value['family'])
			{

				$output = 'font-family:' . $value['family'] . ', sans-serif; ';

				if (isset($value['size']) && $value['size'])
				{
					$output .= 'font-size:' . $value['size'] . 'px; ';
				}

				if (isset($value['weight']) && $value['weight'])
				{
					$output .= 'font-weight:' . str_replace('regular', 'normal', $value['weight']) . '; ';
				}

				$selectors = explode(',', $key);

				foreach ($selectors as $selector)
				{
					$style = $selector . '{' . $output . '}';
					$doc->addStyledeclaration($style);
				}
			}
		}
	}

	//Exclude js and return others js
	private static function excludeJS($key, $excludes)
	{
		$match = false;
		if ($excludes)
		{
			$excludes = explode(',', $excludes);
			foreach ($excludes as $exclude)
			{
				if (basename($key) == trim($exclude))
				{
					$match = true;
				}
			}
		}

		return $match;
	}

	public static function compressJS($excludes = '')
	{
		require_once(__DIR__ . '/classes/Minifier.php');

		$doc       = Factory::getDocument();
		$app       = Factory::getApplication();
		$view      = $app->input->get('view');
		$layout    = $app->input->get('layout');
		
		// disable js compress for edit view
		if($view == 'form' || $layout == 'edit')
		{
			return;
		}

		$cachetime = $app->get('cachetime', 15);

		$all_scripts  = $doc->_scripts;
		$cache_path   = JPATH_ROOT . '/cache/com_templates/templates/' . self::getTemplate();
		$scripts      = array();
		$root_url     = Uri::root(true);
		$minifiedCode = '';
		$md5sum       = '';

		//Check all local scripts
		foreach ($all_scripts as $key => $value)
		{
			$js_file = str_replace($root_url, JPATH_ROOT, $key);

			// disable js compress for sp_pagebuilder
			if(strpos($js_file, 'com_sppagebuilder')) {
				continue;
			}

			if (strpos($js_file, JPATH_ROOT) === false) {
				$js_file = JPATH_ROOT . $key;
			}

			if (File::exists($js_file))
			{
				if (!self::excludeJS($key, $excludes))
				{
					$scripts[] = $key;
					$md5sum .= md5($key);
					if(self::isMinifiedJS($js_file))
					{
						$compressed = file_get_contents($js_file);
					}
					else
					{
						$compressed = \JShrink\Minifier::minify(file_get_contents($js_file), array('flaggedComments' => false));
					}
					$minifiedCode .= "/*------ " . basename($js_file) . " ------*/\n" . $compressed . "\n\n";//add file name to compressed JS

					unset($doc->_scripts[$key]); //Remove sripts
				}
			}
		}

		//Compress All scripts
		if ($minifiedCode)
		{
			if (!Folder::exists($cache_path))
			{
				Folder::create($cache_path, 0755);
			}
			else
			{

				$file = $cache_path . '/' . md5($md5sum) . '.js';

				if (!File::exists($file))
				{
					File::write($file, $minifiedCode);
				}
				else
				{
					if (filesize($file) == 0 || ((filemtime($file) + $cachetime * 60) < time()))
					{
						File::write($file, $minifiedCode);
					}
				}

				$doc->addScript(Uri::base(true) . '/cache/com_templates/templates/' . self::getTemplate() . '/' . md5($md5sum) . '.js');
			}
		}

		return;
	}

	private static function isMinifiedJS($file)
	{
		$content = file_get_contents($file);
		$contentLength = strlen($content);
		$numberOfLines = preg_match_all("@[\r\n]@", $content);

		return ($numberOfLines === 1)
			|| (($numberOfLines * 100 / $contentLength) < 1);
	}

	//Compress CSS files
	public static function compressCSS()
	{//function to compress css files

		require_once(__DIR__ . '/classes/cssmin.php');

		$doc             = Factory::getDocument();
		$app             = Factory::getApplication();
		$cachetime       = $app->get('cachetime', 15);
		$all_stylesheets = $doc->_styleSheets;
		$cache_path      = JPATH_ROOT . '/cache/com_templates/templates/' . self::getTemplate();
		$stylesheets     = array();
		$root_url        = Uri::root(true);
		$minifiedCode    = '';
		$md5sum          = '';
		$view      = $app->input->get('view');
		$layout    = $app->input->get('layout');
		
		// disable css compress for edit view
		if($view == 'form' || $layout == 'edit')
		{
			return;
		}

		//Check all local stylesheets
		foreach ($all_stylesheets as $key => $value)
		{
			$css_file = str_replace($root_url, JPATH_ROOT, $key);

			// disable css compress for sp_pagebuilder
			if(strpos($css_file, 'com_sppagebuilder')) {
				continue;
			}

			if (strpos($css_file, JPATH_ROOT) === false) {
				$css_file = JPATH_ROOT . $key;
			}

			global $absolute_url;
			$absolute_url = $key;//absoulte path of each css file

			if (File::exists($css_file))
			{
				$stylesheets[] = $key;
				$md5sum .= md5($key);
				$compressed = CSSMinify::process(file_get_contents($css_file));

				$fixUrl = preg_replace_callback('/url\(([^\)]*)\)/',
				function ($matches)
				{
					$url = str_replace(array('"', '\''), '', $matches[1]);

					global $absolute_url;
					$base = dirname($absolute_url);
					while (preg_match('/^\.\.\//', $url))
					{
						$base = dirname($base);
						$url  = substr($url, 3);
					}
					$url = $base . '/' . $url;

					return "url('$url')";
				}, $compressed);

				$minifiedCode .= "/*------ " . basename($css_file) . " ------*/\n" . $fixUrl . "\n\n";//add file name to compressed css

				unset($doc->_styleSheets[$key]); //Remove scripts
			}
		}

		//Compress All stylesheets
		if ($minifiedCode)
		{
			if (!Folder::exists($cache_path))
			{
				Folder::create($cache_path, 0755);
			}
			else
			{

				$file = $cache_path . '/' . md5($md5sum) . '.css';

				if (!File::exists($file))
				{
					File::write($file, $minifiedCode);
				}
				else
				{
					if (filesize($file) == 0 || ((filemtime($file) + $cachetime * 60) < time()))
					{
						File::write($file, $minifiedCode);
					}
				}

				$doc->addStylesheet(Uri::base(true) . '/cache/com_templates/templates/' . self::getTemplate() . '/' . md5($md5sum) . '.css');
			}
		}

		return;
	}
}
