<?php
/**
 * @package Helix3 Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright (c) 2010 - 2021 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
 */

 //no direct accees
defined ('_JEXEC') or die ('resticted aceess');

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Form\FormField;
use Joomla\CMS\Filesystem\Folder;

class JFormFieldLayoutlist extends FormField
{
  protected $type = 'Layoutlist';

  public function getInput()
  {
    $template  = self::getTemplate();
    $layoutPath = JPATH_SITE.'/templates/'.$template.'/layout/';
    $laoutlist = Folder::files($layoutPath, '.json');

    $htmls = '<div class="layoutlist"><select id="'.$this->id.'" class="form-select" name="'.$this->name.'">';
    
    if ($laoutlist)
    {
      foreach ($laoutlist as $name)
      {
        $htmls .= '<option value="'.$name.'">'.str_replace('.json','',$name).'</option>';
      }
    }
    
    $htmls .= '</select></div>';
    $htmls .= '<div class="layout-button-wrap"><a href="#" class="btn btn-success layout-save-action" data-action="save">'. Text::_('HELIX_SAVE_COPY') .'</a>';
    $htmls .= '<a href="#" class="btn btn-danger layout-del-action" data-action="remove">'. Text::_('HELIX_DELETE') .'</a></div>';

    return $htmls;
  }


  public function getLabel()
  {
    return false;
  }

  //Get template name
  private static function getTemplate()
  {
    $id = (int) Factory::getApplication()->input->get('id', 0);
    $db = Factory::getDbo();
    $query = $db->getQuery(true);
    $query->select($db->quoteName(array('template')));
    $query->from($db->quoteName('#__template_styles'));
    $query->where($db->quoteName('id') . ' = '. $db->quote($id));
    $db->setQuery($query);

    return $db->loadResult();
  }
}
