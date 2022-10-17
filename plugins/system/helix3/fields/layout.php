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
use Joomla\CMS\Form\FormField;


class JFormFieldLayout extends FormField
{

  protected $type = 'Layout';

  public function getInput()
  {
    $helix_layout_path = JPATH_SITE.'/plugins/system/helix3/layout/';

    $json = json_decode($this->value);

    if (!empty($json))
    {
      $value = $json;
    }
    else
    {
      $layout_file = file_get_contents(JPATH_SITE . '/templates/' . $this->getTemplate() . '/layout/default.json');
      $value = json_decode($layout_file);
    }

    $htmls = $this->generateLayout($helix_layout_path, $value);
    $htmls .= '<input type="hidden" id="'.$this->id.'" name="'.$this->name.'">';
    return $htmls;
  }


  private function generateLayout($path,$layout_data = null)
  {

    ob_start();
    include_once( $path.'generated.php' );
    $items = ob_get_contents();
    ob_end_clean();

    return $items;

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
