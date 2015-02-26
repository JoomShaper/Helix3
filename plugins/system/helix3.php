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
jimport( 'joomla.event.plugin' );

class  plgSystemHelix3 extends JPlugin
{

    protected $autoloadLanguage = true;


    function onContentPrepareForm($form, $data) {

        $doc = JFactory::getDocument();
        $plg_path = JURI::root(true).'/plugins/system/helix3';
        JForm::addFormPath(JPATH_PLUGINS.'/system/helix3/params');

        if ($form->getName()=='com_menus.item') { //Add Helix menu params to the menu item   
            
            JHtml::_('jquery.framework');

            if($data['id'] && $data['parent_id'] == 1) {
                
                $doc->addScript($plg_path.'/assets/js/jquery-ui.min.js');
                $doc->addStyleSheet($plg_path.'/assets/css/bootstrap.css');
                $doc->addStyleSheet($plg_path.'/assets/css/font-awesome.min.css');
                $doc->addStyleSheet($plg_path.'/assets/css/modal.css');
                $doc->addStyleSheet($plg_path.'/assets/css/menu.generator.css');
                $doc->addScript($plg_path.'/assets/js/modal.js');
                $doc->addScript( $plg_path. '/assets/js/menu.generator.js' );
                $form->loadFile('menu-parent', false);
            } else {
                $form->loadFile('menu-child', false); 
            }

            $form->loadFile('page-title', false);

        }

        //Article Post format
        if ($form->getName()=='com_content.article') {
            JHtml::_('jquery.framework');
            $doc->addStyleSheet($plg_path.'/assets/css/font-awesome.min.css');
            $doc->addScript($plg_path.'/assets/js/post-formats.js');

            JForm::addFormPath(JPATH_PLUGINS.'/system/helix3/params');
            $form->loadFile('post-formats', false);
        }

    }
}