<?php
    /**
    * @package Helix3 Framework
    * @author JoomShaper http://www.joomshaper.com
    * @copyright Copyright (c) 2010 - 2015 JoomShaper
    * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
    */  

    //no direct accees
    defined ('_JEXEC') or die ('resticted aceess');

    jimport('joomla.form.formfield');
    jimport('joomla.filesystem.folder');
    jimport('joomla.filesystem.file');


    class JFormFieldPresets extends JFormField {

        protected $type = 'Presets';

        protected function getInput()
        {
            $template = $this->form->getValue('template');
            $templatePresetsDir = JPATH_SITE.'/templates/'.$template.'/images/presets/';
            $base_url = JURI::root(true).'/templates/'.$template.'/images/presets/';
            $root_path = JPATH_SITE.'/templates/'.$template.'/images/presets/';
            $doc = JFactory::getDocument();
            $helix_url = JURI::root(true).'/plugins/system/helix3/';

            $folders = JFolder::folders($templatePresetsDir);

            if( !defined('CURRENT_PRESET') ){
                define('CURRENT_PRESET', $this->value);
               $doc->addScriptDeclaration('var current_preset = "'.$this->value.'";');
            } 

            $html = '';
            $options = array();

            natsort($folders );

            foreach($folders as $folder)
            {

                if(JFile::exists( $root_path . basename($folder) . '/thumbnail.jpg' )) {
                    $image = $base_url . basename($folder) . '/thumbnail.jpg';
                } else {
                    $image = $base_url . basename($folder) . '/thumbnail.png';
                }

                $html .='<div data-preset="'. basename($folder) .'" class="preset' .(($this->value == basename($folder))?' active':'').'">';
                $html .='<div class="preset-title">';
                $html .= basename($folder);
                $html .='</div>';

                $html .='<div class="preset-contents">';
                $html .='<label>';
                $html .='<img  src="'.$image.'" alt="'.basename($folder).'" />';
                $html .='</div>';

                $html .='</label>';
                $html .='</div>';
            }

            $html .='<input type="hidden" id="template-preset" value="'. $this->value .'" name="'. $this->name .'" />';
                
            return $html; 

        }

        public function getLabel()
        {
            return false;
        }

    }
