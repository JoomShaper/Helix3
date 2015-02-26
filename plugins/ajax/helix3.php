<?php
/**
* @package Helix3 Framework
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2015 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
*/  

//no direct accees
defined ('_JEXEC') or die ('resticted aceess');

jimport('joomla.plugin.plugin');
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');

class plgAjaxHelix3 extends JPlugin
{
    function onAjaxHelix3()
    {
        if ($_POST['data']) {
            $data = json_decode(json_encode($_POST['data']),true);;
            $action = $data['action'];
            $layoutName = '';

            if (isset($data['layoutName'])) {
                $layoutName = $data['layoutName'];
            }

            $template  = self::getTemplate();
            $layoutPath = JPATH_SITE.'/templates/'.$template.'/layout/';

            $filepath = $layoutPath.$layoutName;

            $report = array();
            $report['action'] = 'none';
            $report['status'] = 'false';

            switch ($action) {
                case 'remove':
                        if (file_exists($filepath)) {
                            unlink($filepath);
                            $report['action'] = 'remove';
                            $report['status'] = 'true';
                        }
                        $report['layout'] = JFolder::files($layoutPath, '.json');
                    break;

                case 'save':
                        if ($layoutName) {
                            $layoutName = strtolower(str_replace(' ','-',$layoutName));
                        }
                        $content = $data['content'];

                        if ($content && $layoutName) {
                            $file = fopen($layoutPath.$layoutName.'.json', 'wb');
                            fwrite($file, $content);
                            fclose($file);
                        }
                        $report['layout'] = JFolder::files($layoutPath, '.json');
                    break;

                case 'load':
                        if (file_exists($filepath)) {
                            $content = file_get_contents($filepath);
                        }

                        if (isset($content) && $content) {
                            echo $layoutHtml = self::loadNewLayout(json_decode($content));
                        }
                        die();
                    break;

                case 'resetLayout':
                    if($layoutName){
                        echo self::resetMenuLayout($layoutName);
                    }
                    die();
                    break;

                default:
                    break;

                case 'voting':
                    
                    if (JSession::checkToken()) {
                        return json_encode($report);
                    }

                    $rate = -1;
                    $pk = 0;

                    if (isset($data['user_rating'])) {
                        $rate = (int)$data['user_rating'];
                    }

                    if (isset($data['id'])) {
                        $id = str_replace('post_vote_','',$data['id']);
                        $pk = (int)$id;
                    }

                    if ($rate >= 1 && $rate <= 5 && $id > 0)
                    {
                        $userIP = $_SERVER['REMOTE_ADDR'];

                        $db    = JFactory::getDbo();
                        $query = $db->getQuery(true);

                        $query->select('*')
                        ->from($db->quoteName('#__content_rating'))
                        ->where($db->quoteName('content_id') . ' = ' . (int) $pk);

                        $db->setQuery($query);

                        try
                        {
                            $rating = $db->loadObject();
                        }
                        catch (RuntimeException $e)
                        {
                            return json_encode($report);
                        }

                        if (!$rating)
                        {
                            $query = $db->getQuery(true);

                            $query->insert($db->quoteName('#__content_rating'))
                            ->columns(array($db->quoteName('content_id'), $db->quoteName('lastip'), $db->quoteName('rating_sum'), $db->quoteName('rating_count')))
                            ->values((int) $pk . ', ' . $db->quote($userIP) . ',' . (int) $rate . ', 1');

                            $db->setQuery($query);

                            try
                            {
                                $db->execute();

                                $data = self::getItemRating($pk);
                                $rating = $data->rating;

                                $report['action'] = $rating;
                                $report['status'] = 'true';

                                return json_encode($report);
                            }
                            catch (RuntimeException $e)
                            {
                                return json_encode($report);;
                            }
                        }
                        else
                        {
                            if ($userIP != ($rating->lastip))
                            {
                                $query = $db->getQuery(true);

                                $query->update($db->quoteName('#__content_rating'))
                                ->set($db->quoteName('rating_count') . ' = rating_count + 1')
                                ->set($db->quoteName('rating_sum') . ' = rating_sum + ' . (int) $rate)
                                ->set($db->quoteName('lastip') . ' = ' . $db->quote($userIP))
                                ->where($db->quoteName('content_id') . ' = ' . (int) $pk);

                                $db->setQuery($query);

                                try
                                {
                                    $db->execute();

                                    $data = self::getItemRating($pk);
                                    $rating = $data->rating;

                                    $report['action'] = $rating;
                                    $report['status'] = 'true';

                                    return json_encode($report);
                                }
                                catch (RuntimeException $e)
                                {
                                    return json_encode($report);
                                }
                            }
                            else
                            {

                                $report['status'] = 'invalid';
                                return json_encode($report);
                            }
                        }
                    }
                    $report['action'] = 'failed';
                    $report['status'] = 'false';
                    return json_encode($report);
                    break;
                //Font variant
                case 'fontVariants':

                    $template_path = JPATH_SITE . '/templates/' . self::getTemplate() . '/webfonts/webfonts.json';
                    $plugin_path   = JPATH_PLUGINS . '/system/helix3/assets/webfonts/webfonts.json';
                    
                    if(JFile::exists( $template_path )) {
                        $json = JFile::read( $template_path );
                    } else {
                        $json = JFile::read( $plugin_path );
                    }
                    
                    $webfonts   = json_decode($json);
                    $items      = $webfonts->items;
                    
                    $output = array(); 
                    $fontVariants = '';
                    $fontSubsets = '';
                    foreach ($items as $item) {
                        if($item->family==$layoutName) {

                            //Variants
                            foreach ($item->variants as $variant) {
                                $fontVariants .= '<option value="'. $variant .'">' . $variant . '</option>'; 
                            }

                            //Subsets
                            foreach ($item->subsets as $subset) {
                                $fontSubsets .= '<option value="'. $subset .'">' . $subset . '</option>'; 
                            }
                        }
                    }

                    $output['variants'] = $fontVariants;
                    $output['subsets']  = $fontSubsets;

                    return json_encode($output);

                    break;

                //Font variant
                case 'updateFonts':

                    jimport( 'joomla.filesystem.folder' );
                    jimport('joomla.http.http');

                    $template_path = JPATH_SITE . '/templates/' . self::getTemplate() . '/webfonts';
                    
                    if(!JFolder::exists( $template_path )) {
                       JFolder::create( $template_path, 0755 );
                    }

                    $url  = 'https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyBVybAjpiMHzNyEm3ncA_RZ4WETKsLElDg';
                    $http = new JHttp();
                    $str  = $http->get($url);

                    if ( JFile::write( $template_path . '/webfonts.json', $str->body )) {
                        echo "<p class='font-update-success'>Google Webfonts list successfully updated! Please refresh your browser.</p>";
                    } else {
                        echo "<p class='font-update-failed'>Google Webfonts update failed. Please make sure that your template folder is writable.</p>";
                    }

                    die();

                    break;
                    
            }

            return json_encode($report);
        }
        
    }

    static public function getItemRating($pk = 0){
        $db    = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('ROUND(rating_sum / rating_count, 0) AS rating, rating_count')
        ->from($db->quoteName('#__content_rating'))
        ->where($db->quoteName('content_id') . ' = ' . (int) $pk);

        $db->setQuery($query);
        $data = $db->loadObject();

        return $data;
    }

    static public function resetMenuLayout($current_menu_id = 0){

        if (!$current_menu_id) {
            return;           
        }

        $items  = self::menuItems();
        $item   = array();
        
        if (isset($items[$current_menu_id]) && !empty($items[$current_menu_id])) {
            $item = $items[$current_menu_id];
        }

        $menuItems = new JMenuSite;

        $no_child = true;
        $count = 0;
        $x_key = 0;
        $y_key = 0;
        $check_child = 0;
        $item_array = array();

        foreach ($item as $key => $id){
            $status = 0;
            if (isset($items[$id]) && is_array($items[$id])){
                $no_child = false;
                $count = $count + 1;
                $check_child = $check_child+1;
                $status = 1;
            }

            if ($check_child === 2){
                $y_key = 0;
                $x_key = $x_key + 1;
                $check_child = 1;
            }

            $item_array[$x_key][$y_key] = array($id,$status);
            $y_key = $y_key + 1;
        }

        if ($no_child === true){
            $count = 1;
        }

        if($count > 4 && $count != 6){
            $count = 4;
        }

        ob_start();

        if($no_child === true)
        {
            echo '<div class="menu-section">';
            echo '<span class="row-move"><i class="fa fa-bars"></i></span>';
            echo '<div class="spmenu sp-row">';
            echo '<div class="column sp-col-md-12" data-column="12">';
            echo '<div class="column-items-wrap">';
            if (!empty($item)) {
                echo '<h4 style="display:none" data-current_child="'.$current_menu_id.'" >'.$menuItems->getItem($current_menu_id)->title.'</h4>';
                echo '<ul class="child-menu-items">';

                foreach ($item as $key => $id)
                {
                    echo '<li>'.$menuItems->getItem($id)->title.'</li>';
                }
                echo '</ul>';
            }
            echo '<div class="modules-container">';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        else
        {
            echo '<div class="menu-section">';
            echo '<span class="row-move"><i class="fa fa-bars"></i></span>';
            echo '<div class="spmenu sp-row">';

            $columnNumber = 12 / $count;
            foreach ($item_array as $key => $item_array)
            {
                echo '<div class="column sp-col-md-'.$columnNumber.'" data-column="'.$columnNumber.'">';
                echo '<div class="column-items-wrap">';

                foreach ($item_array as $key => $item)
                {
                    $id = $item[0];
                    echo '<h4 data-current_child="'.$id.'" >'.$menuItems->getItem($id)->title.'</h4>';
                    if ($item[1])
                    {
                        echo '<ul class="child-menu-items">';
                        echo self::create_menu($id);
                        echo '</ul>';
                    }
                }
                echo '<div class="modules-container"></div>';
                echo '</div>';
                echo '</div>';
            }
            echo '</div>';
            echo '</div>';
        }

        $output = ob_get_contents();
        ob_clean();

        return $output;
    }

    static public function create_menu($current_menu_id)
    {
        $items = self::menuItems();
        $menus = new JMenuSite;

        if (isset($items[$current_menu_id]))
        {
            $item = $items[$current_menu_id];
            foreach ($item as $key => $item_id)
            {
                echo '<li>';
                echo $menus->getItem($item_id)->title;
                echo '</li>';
            }
        }    
    }

    static public function menuItems()
    {
        $menus = new JMenuSite;
        $menus = $menus->getMenu();
        $new = array();
        foreach ($menus as $item) {
            $new[$item->parent_id][] = $item->id;
        }
        return $new;
    }

    static public function loadNewLayout($layout_data = null){

        $lang = JFactory::getLanguage();
        $lang->load('tpl_' . self::getTemplate(), JPATH_SITE, $lang->getName(), true);

        ob_start();
        
        $colGrid = array(
            '12'    => '12',
            '66'    => '6,6',
            '444'   => '4,4,4',
            '3333'  => '3,3,3,3',
            '48'    => '4,8',
            '39'    => '3,9',
            '363'   => '3,6,3',
            '264'   => '2,6,4',
            '210'   => '2,10',
            '57'    => '5,7',
            );

        if ($layout_data) {
        foreach ($layout_data as $row) {
            $rowSettings = self::getSettings($row->settings);
            $name = JText::_('HELIX_SECTION_TITLE');

            if (isset($row->settings->name)) {
                $name = $row->settings->name;
            }
        ?>
        <div class="layoutbuilder-section" <?php echo $rowSettings; ?>>
           <div class="settings-section clearfix">
             <div class="settings-left pull-left">
                <a class="row-move" href="#"><i class="fa fa-arrows"></i></a>
                <strong class="section-title"><?php echo $name; ?></strong>
            </div>
            <div class="settings-right pull-right">
                <ul class="button-group">
                    <li>
                        <a class="btn btn-small add-columns" href="#"><i class="fa fa-columns"></i> <?php echo JText::_('HELIX_ADD_COLUMNS'); ?></a>
                        <ul class="column-list">
                            <?php
                            $_active = '';
                            foreach ($colGrid as $key => $grid){ 
                                if($key == $row->layout){
                                    $_active = 'active';
                                }
                                echo '<li><a href="#" class="column-layout column-layout-' .$key. ' '.$_active.'" data-layout="'.$grid.'"></a></li>';
                                $_active ='';
                            } ?>
                        </ul>
                    </li>
                    <li><a class="btn btn-small add-row" href="#"><i class="fa fa-bars"></i> <?php echo JText::_('HELIX_ADD_ROW'); ?></a></li>
                    <li><a class="btn btn-small row-ops-set" href="#"><i class="fa fa-gears"></i> <?php echo JText::_('HELIX_SETTINGS'); ?></a></li>
                    <li><a class="btn btn-danger btn-small remove-row" href="#"><i class="fa fa-times"></i> <?php echo JText::_('HELIX_REMOVE'); ?></a></li>
                </ul>
            </div>
            </div>
            <div class="row ui-sortable">
            <?php foreach ($row->attr as $column) { $colSettings = self::getSettings($column->settings); ?>
                <div class="<?php echo $column->className; ?>" <?php echo $colSettings; ?>>
                    <div class="column">
                        <?php if (isset($column->settings->column_type) && $column->settings->column_type) {
                           echo '<h6 class="col-title pull-left">Component</h6>';
                        }else{
                            if (!isset($column->settings->name)) {
                                $column->settings->name = 'none';
                            }
                            echo '<h6 class="col-title pull-left">'.$column->settings->name.'</h6>';
                        }
                        ?>
                        <a class="col-ops-set pull-right" href="#" ><i class="fa fa-gears"></i></a>
                    </div>
                </div>
            <?php } ?>
            </div>
        </div>
        <?php
            }
        }
        $items = ob_get_contents();
        ob_end_clean();

        return $items;

    }

    static public function getSettings($config = null){
        $data = '';
        if (count($config)) {
            foreach ($config as $key => $value) {
                $data .= ' data-'.$key.'="'.$value.'"';
            }
        }
        return $data;
    }

    //Get template name
    private static function getTemplate() {

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select($db->quoteName(array('template')));
        $query->from($db->quoteName('#__template_styles'));
        $query->where($db->quoteName('id') . ' = '. $db->quote( JRequest::getVar('id') ));
        $db->setQuery($query);

        return $db->loadResult();
    }
}