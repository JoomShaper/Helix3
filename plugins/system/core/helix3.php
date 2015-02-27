<?php
    /**
    * @package Helix3 Framework
    * @author JoomShaper http://www.joomshaper.com
    * @copyright Copyright (c) 2010 - 2015 JoomShaper
    * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
    */  

    //no direct accees
    defined ('_JEXEC') or die ('resticted aceess');

    jimport('joomla.filesystem.file');
    jimport('joomla.filesystem.folder');
    jimport('joomla.filter.filteroutput');

    class Helix3 {

        private static $_instance;
        private $document;
        private $importedFiles=array();
        private $_less;

        //initialize 
        public function __construct(){

        }
        /**
        * making self object for singleton method
        * 
        */
        final public static function getInstance()
        {
            if( !self::$_instance ){
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
        public static function getDocument($key=false)
        {
            self::getInstance()->document = JFactory::getDocument();
            $doc = self::getInstance()->document;
            if( is_string($key) ) return $doc->$key;
            return $doc;
        }

        public static function getParam( $key ) {
            $params = JFactory::getApplication()->getTemplate(true)->params;

            return $params->get( $key );
        }

        //Body Class
        public static function bodyClass( $class = '' ) {
            $app        = JFactory::getApplication();
            $doc        = JFactory::getDocument();
            $language   = $doc->language;
            $direction  = $doc->direction;
            $option     = str_replace('_', '-', $app->input->getCmd('option', ''));
            $view       = $app->input->getCmd('view', '');
            $layout     = $app->input->getCmd('layout', '');
            $task       = $app->input->getCmd('task', '');
            $itemid     = $app->input->getCmd('Itemid', '');
            $sitename   = $app->get('sitename');

            if( $view == 'modules' ) {
                $layout = 'edit';
            }

            return 'site '   . $option
                            . ' view-' . $view
                            . ($layout ? ' layout-' . $layout : ' no-layout')
                            . ($task ? ' task-' . $task : ' no-task')
                            . ($itemid ? ' itemid-' . $itemid : '')
                            . ($language ? ' ' . $language : '')
                            . ($direction ? ' ' . $direction : '')
                            . ($class ? ' ' . $class : '');
        }

        //Get view
        public static function view( $class = '' ) {
            $app             = JFactory::getApplication();
            $view     = $app->input->getCmd('view', '');
            $layout   = $app->input->getCmd('layout', '');

            if( ($view == 'modules') ) {
                $layout = 'edit';
            }

            return $layout;
        }

        //Get Template name
        public static function getTemplate() {
            return JFactory::getApplication()->getTemplate();
        }

        //Get Template URI
        public static function getTemplateUri() {
            return JURI::base(true) . '/templates/' . self::getTemplate();
        }

        /**
        * Get or set Template param. If value not setted params get and return, 
        * else set params
        *
        * @param string $name
        * @param mixed $value
        */
        public static function Param($name=true, $value=NULL)
        {

            // if $name = true, this will return all param data
            if( is_bool($name) and $name==true ){
                return JFactory::getApplication()->getTemplate(true)->params;
            }
            // if $value = null, this will return specific param data
            if( is_null($value) ) return JFactory::getApplication()->getTemplate(true)->params->get($name);
            // if $value not = null, this will set a value in specific name.

            $data = JFactory::getApplication()->getTemplate(true)->params->get($name);

            if( is_null($data) or !isset($data) ){
                JFactory::getApplication()->getTemplate(true)->params->set($name, $value);
                return $value;
            } else {
                return $data;
            }
        }

        /**
        * Importing features
        * @access private
        */
        private $inPositions    = array();
        private $loadFeature   = array();
       
        private static function importFeatures(){

            $template = JFactory::getApplication()->getTemplate();
            $path = JPATH_THEMES . '/' . $template . '/features';

            if(file_exists($path)) {
                $files = JFolder::files($path, '.php');

                if(count($files)) {

                    foreach($files as $file) {

                        include_once $path . '/' . $file;
                        $name = JFile::stripExt( $file );

                        $class = 'Helix3Feature' . ucfirst( $name );
                        $class = new $class( self::getInstance() );

                        $position = $class->position;

                        self::getInstance()->inPositions[] = $position;

                        if( !empty($position) ) {

                            self::getInstance()->loadFeature[$position][] = $class->renderFeature();

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
        public static function getColXsNo($col_name){
            //Remove Classes name
            $class_remove= array('layout-column', 'column-active', 'col-sm-');
            return trim(str_replace($class_remove, '', $col_name));     
        }

        public static function generatelayout() {

            self::getInstance()->addCSS('custom.css');

            $doc    = JFactory::getDocument();
            $app    = JFactory::getApplication();
            $option = $app->input->getCmd('option', '');
            $view   = $app->input->getCmd('view', '');
            $pagebuilder = false;

            if( ($option == 'com_sppagebuilder') && ( $view == 'page') ) {
                $pagebuilder = true;
            }
            
            //Import Features
            self::importFeatures();

            $params = JFactory::getApplication()->getTemplate(true)->params;
            $rows = json_decode( $params->get('layout') );

            //Load from file if not exists in database
            if(empty($rows)) {
                $layout_file = JPATH_SITE . '/templates/' . self::getTemplate() . '/layout/default.json';
                if(!JFile::exists( $layout_file )) die('Default Layout file is not exists! Please goto to template manager and create a new layout first.');
                $rows = json_decode( JFile::read( $layout_file ) );
            }

            $output = '';

            foreach ($rows as $key => $row) {
                //echo $key;

                $rowColumns = self::rowColumns($row->attr);

                if(!empty($rowColumns)) {

                    $componentArea = false;

                    if (self::hasComponent( $rowColumns ) ) {
                        $componentArea = true;
                    } 

                    $fluidrow = false;
                    if(!empty($row->settings->fluidrow)) {
                        $fluidrow = $row->settings->fluidrow;   
                    }
                    
                    $id = (empty($row->settings->name)) ? 'sp-section-' . ( $key + 1 ) : 'sp-' . JFilterOutput::stringURLSafe( $row->settings->name );

                    $row_class = '';

                    if(!empty($row->settings->custom_class)) {
                        $row_class .= $row->settings->custom_class;
                    }

                    if(!empty($row->settings->hidden_xs)) {
                        $row_class .= ' hidden-xs';   
                    }

                    if(!empty($row->settings->hidden_sm)) {
                        $row_class .= ' hidden-sm';   
                    }

                    if(!empty($row->settings->hidden_md)) {
                        $row_class .= ' hidden-md';   
                    }

                    if($row_class) {
                        $row_class = ' class="'.$row_class.'"';
                    } else {
                        $row_class = '';
                    }

                    //css
                    $row_css = '';

                    if(!empty($row->settings->background_image)) {
                        $row_css .= 'background-image:url("' . JURI::base(true) . '/' . $row->settings->background_image .'");';

                        if(!empty($row->settings->background_repeat)) {
                            $row_css .= 'background-repeat:' . $row->settings->background_repeat .';';
                        }

                        if(!empty($row->settings->background_size)) {
                            $row_css .= 'background-size:' . $row->settings->background_size .';';
                        }

                        if(!empty($row->settings->background_attachment)) {
                            $row_css .= 'background-attachment:' . $row->settings->background_attachment .';';
                        }

                        if(!empty($row->settings->background_position)) {
                            $row_css .= 'background-position:' . $row->settings->background_position .';';
                        }

                    }

                    if(!empty($row->settings->background_color)) {
                        $row_css .= 'background-color:' . $row->settings->background_color .';';
                    }

                    if(!empty($row->settings->color)) {
                        $row_css .= 'color:' . $row->settings->color .';';
                    }

                    if(!empty($row->settings->padding)) {
                        $row_css .= 'padding:' . $row->settings->padding .';';
                    }

                    if(!empty($row->settings->margin)) {
                        $row_css .= 'margin:' . $row->settings->margin .';';
                    }

                    if($row_css) {
                        $doc->addStyledeclaration( '#' . $id . '{ ' . $row_css . ' }' );
                    }

                    //Link Color
                    if(!empty($row->settings->link_color)) {
                        $doc->addStyledeclaration( '#' . $id . ' a{color:' . $row->settings->link_color . ';}' );
                    }

                    //Link Hover Color
                    if(!empty($row->settings->link_hover_color)) {
                        $doc->addStyledeclaration( '#' . $id . ' a:hover{color:' . $row->settings->link_hover_color . ';}' );
                    }

                    // set html5 stracture
                    $sematic = (!empty($row->settings->name)) ? strtolower($row->settings->name) : 'section' ;

                    switch($sematic) {
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

                    $output .= '<'. $sematic .' id="'. $id .'"'.$row_class.'>';

                        if( $componentArea ) {
                            if( !$pagebuilder ) {
                                $output .= '<div class="container">';
                            }
                        } else {
                            if( !$fluidrow ) $output .= '<div class="container">';
                        }
                        
                        $output .= '<div class="row">';
                        
                            foreach ($rowColumns as $key=>$column) {

                                //Responsive Utilities
                                if( isset($column->settings->xs_col) && $column->settings->xs_col ) {
                                    $column->className = $column->settings->xs_col . ' ' . $column->className;
                                }

                                if( isset($column->settings->sm_col) && $column->settings->sm_col ) {
                                    $column->className = preg_replace('/col-sm-\d/', $column->settings->sm_col, $column->className);
                                }

                                if( isset($column->settings->hidden_md) && $column->settings->hidden_md ) {
                                    $column->className = $column->className . ' hidden-md hidden-lg';
                                }

                                if( isset($column->settings->hidden_sm) && $column->settings->hidden_sm ) {
                                    $column->className = $column->className . ' hidden-sm';
                                }
                                
                                if( isset($column->settings->hidden_xs) && $column->settings->hidden_xs ) {
                                    $column->className = $column->className . ' hidden-xs';
                                }
                                //End Responsive Utilities

                                if($column->settings->column_type) { //Component

                                    $output .= '<div id="sp-component" class="'. $column->className .'">';
                                        
                                        $output .= '<div class="sp-column ' . ($column->settings->custom_class) . '">';
                                        $output .= '<jdoc:include type="message" />';
                                        $output .= '<jdoc:include type="component" />';
                                        $output .= '</div>';

                                    $output .= '</div>';

                                } else { // Module

                                    $output .= '<div id="sp-'. JFilterOutput::stringURLSafe( $column->settings->name ) .'" class="'. $column->className .'">';
                                        
                                        $output .= '<div class="sp-column ' . ($column->settings->custom_class) . '">';

                                        if( self::hasFeature($column->settings->name) )
                                        {
                                            $features = self::getInstance()->loadFeature[$column->settings->name]; //Feature
                                            foreach ($features as $feature) {
                                               $output .= $feature;
                                            }
                                        }

                                        $output .= '<jdoc:include type="modules" name="'. $column->settings->name .'" style="sp_xhtml" />';
                                        $output .= '</div>';

                                    $output .= '</div>';
                                }
                            }

                        $output .= '</div>';

                        if( $componentArea ) {
                            if( !$pagebuilder ) {
                                $output .= '</div>';
                            }
                        } else {
                            if( !$fluidrow ) $output .= '</div>';
                        }

                    $output .= '</'. $sematic .'>';
                }

            }

            echo $output;

        }

        /* Detect component row */
        private static function hasComponent( $rowColumns ) {

            $hasComponent = false;

            foreach ($rowColumns as $key=>$column) {

                if($column->settings->column_type) { /* Component */

                    $hasComponent = true;

                }
            }

            return $hasComponent;

        }


        //Get Active Columns
        private static function rowColumns($columns) {
            $doc = JFactory::getDocument();
            $cols = array();

            //Inactive
            $absspan    = 0; //   absence span
            $col_i      = 1;
            $totalPublished = count($columns); // total publish children
            $hasComponent = false;

            foreach ($columns as &$column) {

                $column->settings->name = (!empty($column->settings->name)) ? $column->settings->name : 'none_empty';
                $column->settings->column_type = (!empty($column->settings->column_type)) ? $column->settings->column_type : 0;
                $column->settings->custom_class = (!empty($column->settings->custom_class)) ? $column->settings->custom_class : '';

                if(!$column->settings->column_type) {
                    if( !self::countModules( $column->settings->name ) ) {
                        $col_xs_no = self::getColXsNo($column->className);
                        $absspan+= $col_xs_no;                                 
                        $totalPublished--;
                    }
                } else {
                    $hasComponent = true;
                }
            }

            //Active
            foreach ($columns as &$column) {

                if($column->settings->column_type) {
                    $column->className = 'col-sm-' . (self::getColXsNo($column->className)+$absspan) . ' col-md-' . (self::getColXsNo($column->className)+$absspan);
                    $cols[] = $column;
                    $col_i++;

                } else {

                    if( self::countModules( $column->settings->name ) ) {

                        $last_col = ($totalPublished == $col_i) ? $absspan : '' ;
                        if($hasComponent) {
                            $column->className = 'col-sm-' . self::getColXsNo($column->className) . ' col-md-' . self::getColXsNo($column->className);
                        } else {
                           $column->className = 'col-sm-' . (self::getColXsNo($column->className)+$last_col) . ' col-md-' . (self::getColXsNo($column->className)+$last_col);
                       }

                       $cols[] = $column;
                       $col_i++;
                   }
               }
            }

            return $cols;
        }


    
        //Count Modules
        public static function countModules($position) {
            $doc = JFactory::getDocument();

            return ($doc->countModules($position) or self::hasFeature($position) );
        }

        /**
        * Has feature
        * 
        * @param string $position
        */

        public static function hasFeature($position)
        {

            if(in_array($position, self::getInstance()->inPositions)) {
                return true;
            } else {
                return false;
            }
        }

        /**
        * Add stylesheet
        * 
        * @param mixed $sources. string or array
        * @return self
        */
        public static function addCSS($sources, $attribs = array()) {

            $template = JFactory::getApplication()->getTemplate();
            $path = JPATH_THEMES . '/' . $template . '/css/';

            $srcs = array();

            if( is_string($sources) ) $sources = explode(',', $sources);
            if(!is_array($sources)) $sources = array($sources);

            foreach( (array) $sources as $source ) $srcs[] = trim($source);

            foreach ($srcs as $src) {

                if( file_exists( $path . $src)) { 
                    self::getInstance()->document->addStyleSheet( JURI::base(true) . '/templates/' . $template . '/css/' . $src, 'text/css', NULL, $attribs );
                } else {
                    if($src != 'custom.css') self::getInstance()->document->addStyleSheet( $src, 'text/css', NULL, $attribs );
                }      
            }

            return self::getInstance();
        }    

        /**
        * Add javascript
        * 
        * @param mixed $sources. string or array
        * @param string $seperator. default is , (comma)
        * @return self
        */
        public static function addJS($sources, $seperator=',') {

            $srcs = array();

            $template = JFactory::getApplication()->getTemplate();
            $path = JPATH_THEMES . '/' . $template . '/js/';

            if( is_string($sources) ) $sources = explode($seperator,$sources);
            if(!is_array($sources)) $sources = array($sources);

            foreach( (array) $sources as $source ) $srcs[] = trim($source);

            foreach ($srcs as $src) {

                if( file_exists( $path . $src)) { 
                    self::getInstance()->document->addScript( JURI::base(true) . '/templates/' . $template . '/js/' . $src );
                } else {
                    self::getInstance()->document->addScript( $src );
                } 
     
            }
            return self::getInstance();
        }


        /**
        * Add Inline Javascript
        * 
        * @param mixed $code
        * @return self
        */
        public function addInlineJS($code){
            self::getInstance()->document->addScriptDeclaration($code);
            return self::getInstance();
        }

        /**
        * Add Inline CSS
        * 
        * @param mixed $code
        * @return self
        */
        public function addInlineCSS($code) {
            self::getInstance()->document->addStyleDeclaration($code);
            return self::getInstance();
        }

        /**
        * Less Init
        * 
        */
        public static function lessInit() {
            //import less class file
            require_once __DIR__ . '/classes/lessc.inc.php';
            self::getInstance()->_less = new lessc();

            return self::getInstance();
        }

        /**
        * Instance of Less
        */  
        public static function less() {
            return self::getInstance()->_less;
        }


        /**
        * Set Less Variables using array key and value
        * 
        * @param mixed $array
        * @return self
        */
        public static function setLessVariables($array){
            self::getInstance()->less()->setVariables( $array );
            return self::getInstance();
        }

        /**
        * Set less variable using name and value
        * 
        * @param mixed $name
        * @param mixed $value
        * @return self
        */
        public static function setLessVariable($name, $value){
            self::getInstance()->less()->setVariables( array($name=>$value) );
            return self::getInstance();
        }

        /**
        * Compile less to css when less modified or css not exist
        * 
        * @param mixed $less
        * @param mixed $css
        * @return self
        */
        private static function autoCompileLess($less, $css) {
            // load the cache
            $template = JFactory::getApplication()->getTemplate();
            $cachePath = JPATH_CACHE.'/com_templates/templates/'.$template;
            $cacheFile = $cachePath.'/'.basename($css.".cache");

            if (file_exists($cacheFile)) {
                $cache = unserialize(JFile::read($cacheFile));

                //If root changed then do not compile
                if(isset($cache['root']) && $cache['root']) {
                    if($cache['root'] != $less) {
                        return self::getInstance();
                    }
                }

            } else {
                $cache = $less;
            }

            $lessInit = self::getInstance()->less();
            $newCache = $lessInit->cachedCompile($cache);

            if (!is_array($cache) || $newCache["updated"] > $cache["updated"]) {

                if(!file_exists($cachePath)){
                    JFolder::create($cachePath, 0755);
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
        * @return self
        */
        public static function addLess($less, $css, $attribs = array()) {
            $template = JFactory::getApplication()->getTemplate();
            $themepath = JPATH_THEMES . '/' . $template;

            if( self::getParam('lessoption') and self::getParam('lessoption')=='1' ){
                if( file_exists( $themepath. "/less/".$less.".less" ) ){
                    self::getInstance()->autoCompileLess($themepath. "/less/".$less.".less", $themepath ."/css/".$css.".css");
                }
            }
            self::getInstance()->addCSS( $css.'.css', $attribs );
            return self::getInstance();
        }

        private static function addLessFiles($less, $css)
        {

            $less = self::getInstance()->file('less/'. $less .'.less');
            $css  = self::getInstance()->file('css/'. $css .'.css');
            self::getInstance()->less()->compileFile($less, $css);

            echo $less; die;

            return self::getInstance();
        }

        private static function resetCookie($name)
        {
            if( JRequest::getVar('reset',  ''  , 'get')==1 ) {
                setcookie( $name, '', time() - 3600, '/');
            }
        }

        /**
        * Preset
        * 
        */
        public static function Preset() {
            $template = JFactory::getApplication()->getTemplate();
            $name = $template . '_preset';

            if( isset( $_COOKIE[$name] )) {
                $current = $_COOKIE[$name];
            } else {
                $current = self::getParam('preset');
            }

            return $current;
        }

        public static function PresetParam($name) {
            return self::getParam( self::getInstance()->Preset().$name );
        }

        /**
        * Load Menu
        *
        * @since    1.0
        */
        public static function loadMegaMenu($class="") {
            require_once __DIR__ . '/classes/menu.php';
            return new Helix3Menu($class);
        }

        /**
        * Add Google Fonts
        * 
        * @param string $name. Name of font. Ex: Yanone+Kaffeesatz:400,700,300,200 or Yanone+Kaffeesatz  or Yanone Kaffeesatz
        * @param string $field. Applied selector. Ex: h1, h2, #id, .classname
        */
        public static function addGoogleFont($fonts) {

            $doc = JFactory::getDocument();

            //Families
            $families = array();
            foreach ($fonts as $key => $value) {
                $value = json_decode($value);

                if(isset($value->fontWeight) && $value->fontWeight) {
                    $families[$value->fontFamily]['weight'][] = $value->fontWeight;
                }

                if(isset($value->fontSubset) && $value->fontSubset) {
                    $families[$value->fontFamily]['subset'][] = $value->fontSubset;
                }
            }

            //Selectors
            $selectors = array();
            foreach ($fonts as $key => $value) {
                $value = json_decode($value);

                if(isset($value->fontFamily) && $value->fontFamily) {
                    $selectors[$key]['family'] = $value->fontFamily;   
                }

                if(isset($value->fontSize) && $value->fontSize) {
                    $selectors[$key]['size'] = $value->fontSize;
                }

                if(isset($value->fontWeight) && $value->fontWeight) {
                    $selectors[$key]['weight'] = $value->fontWeight;   
                }

            }

            //Add Google Font URL
            foreach ($families as $key => $value) {
                $output = str_replace(' ', '+', $key);

                $weight = array_unique( $value['weight'] );
                if(isset($weight) && $weight) {
                    $output .= ':' . implode(',', $weight);
                }

                $subset = array_unique( $value['subset'] );
                if(isset($subset) && $subset) {
                    $output .= '&amp;' . implode(',', $subset);
                }

                $doc->addStylesheet( '//fonts.googleapis.com/css?family=' . $output );
            }

            //Add font to Selector
            foreach ($selectors as $key => $value) {

                if(isset($value['family']) && $value['family']) {

                    $output = 'font-family:' . $value['family'] . ', sans-serif; ';

                    if(isset($value['size']) && $value['size']) {
                        $output .= 'font-size:' . $value['size'] . 'px; ';
                    }

                    if(isset($value['weight']) && $value['weight']) {
                        $output .= 'font-weight:' . str_replace('regular', 'normal', $value['weight']) . '; ';
                    }

                    $selectors = explode(',', $key);

                    foreach ($selectors as $selector) {
                        $style = $selector . '{' . $output . '}';
                        $doc->addStyledeclaration( $style );
                    }

                }

            }
            
        }

        //Exclude js and return others js
        private static function excludeJS($key, $excludes) {
            $match = false;
            if($excludes) {
                $excludes = explode(',', $excludes);
                foreach ($excludes as $exclude) {
                    if(JFile::getName($key) == trim($exclude)) {
                        $match = true; 
                    }
                }
            }

            return $match;
        }

        public static function compressJS( $excludes = '' ) {//function to compress js files

            require_once(__DIR__ . '/classes/Minifier.php');

            $doc = JFactory::getDocument();
            $app = JFactory::getApplication();
            $cachetime = $app->get('cachetime', 15);

            $all_scripts = $doc->_scripts;
            $cache_path = JPATH_CACHE . '/com_templates/templates/' . self::getTemplate();
            $scripts = array();
            $root_url = JURI::root(true);
            $minifiedCode = '';
            $md5sum = '';

            //Check all local scripts
            foreach ($all_scripts as $key => $value) {
               $js_file = str_replace($root_url, JPATH_ROOT, $key);

               if(JFile::exists( $js_file )) {
                    if(!self::excludeJS($key, $excludes)) {
                        $scripts[] = $key;
                        $md5sum .= md5($key);
                        $compressed = \JShrink\Minifier::minify( JFile::read( $js_file ), array('flaggedComments' => false) );
                        $minifiedCode .= "/*------ " . JFile::getName($js_file) . " ------*/\n" . $compressed . "\n\n";//add file name to compressed JS

                        unset($doc->_scripts[ $key ]); //Remove sripts
                    }
               }
            }

            //Compress All scripts
            if($minifiedCode) {
                if(!JFolder::exists( $cache_path )) {
                    JFolder::create( $cache_path, 0755 );
                } else {

                    $file = $cache_path . '/' . md5($md5sum) . '.js';

                    if(!JFile::exists($file)) {
                        JFile::write( $file, $minifiedCode );
                    } else {
                        if(filesize($file) == 0 || ((filemtime($file) + $cachetime * 60) < time())) {
                            JFile::write( $file, $minifiedCode );
                        }
                    }

                    $doc->addScript( JURI::base(true) . '/cache/com_templates/templates/' . self::getTemplate() . '/' . md5($md5sum) . '.js' );
                }
            }

            return;
        }


        //Compress CSS files
        public static function compressCSS() {//function to compress css files

            require_once(__DIR__ . '/classes/cssmin.php');

            $doc = JFactory::getDocument();
            $app = JFactory::getApplication();
            $cachetime = $app->get('cachetime', 15);
            $all_stylesheets = $doc->_styleSheets;
            $cache_path = JPATH_CACHE . '/com_templates/templates/' . self::getTemplate();
            $stylesheets = array();
            $root_url = JURI::root(true);
            $minifiedCode = '';
            $md5sum = '';

            //Check all local stylesheets
            foreach ($all_stylesheets as $key => $value) {
               $css_file = str_replace($root_url, JPATH_ROOT, $key);

               global $absolute_url;
                $absolute_url = $key;//absoulte path of each css file

               if(JFile::exists( $css_file )) {
                    $stylesheets[] = $key;
                    $md5sum .= md5($key);
                    $compressed = CSSMinify::process( JFile::read( $css_file ) );

                    $fixUrl = preg_replace_callback('/url\(([^\)]*)\)/',
                        function ($matches) {
                            $url = str_replace(array('"', '\''), '', $matches[1]);

                            global $absolute_url;
                            $base = dirname($absolute_url);
                            while (preg_match('/^\.\.\//', $url)) {
                                $base = dirname($base);
                                $url = substr($url, 3);
                            }
                            $url = $base . '/' . $url;
                            return "url('$url')";

                        },$compressed);

                    $minifiedCode .= "/*------ " . JFile::getName($css_file) . " ------*/\n" . $fixUrl . "\n\n";//add file name to compressed css

                    unset($doc->_styleSheets[ $key ]); //Remove sripts
               }
            }

            //Compress All stylesheets
            if($minifiedCode) {
                if(!JFolder::exists( $cache_path )) {
                    JFolder::create( $cache_path, 0755 );
                } else {

                    $file = $cache_path . '/' . md5($md5sum) . '.css';

                    if(!JFile::exists($file)) {
                        JFile::write( $file, $minifiedCode );
                    } else {
                        if(filesize($file) == 0 || ((filemtime($file) + $cachetime * 60) < time())) {
                            JFile::write( $file, $minifiedCode );
                        }
                    }

                    $doc->addStylesheet( JURI::base(true) . '/cache/com_templates/templates/' . self::getTemplate() . '/' . md5($md5sum) . '.css' );
                }
            }

            return;
        }
    }