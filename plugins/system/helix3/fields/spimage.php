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
use Joomla\CMS\Filesystem\File;
use Joomla\CMS\Form\FormField;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Uri\Uri;

class JFormFieldSpimage extends FormField
{

  protected $type = 'Spimage';

  protected function getInput()
  {
    $doc = Factory::getDocument();

    HTMLHelper::_('jquery.framework');

    $plg_path = Uri::root(true) . '/plugins/system/helix3';
    $doc->addScript($plg_path . '/assets/js/spimage.js');
    $doc->addStyleSheet($plg_path . '/assets/css/spimage.css');

    if($this->value) {
      $class1 = ' hide';
      $class2 = '';
    } else {
      $class1 = '';
      $class2 = ' hide';
    }

    $output  = '<div class="sp-image-field clearfix">';
    $output .= '<div class="sp-image-upload-wrapper">';

    if ($this->value)
    {
      $data_src = $this->value;
      $src = Uri::root(true) . '/' . $data_src;

      $basename = basename($data_src);
      $thumbnail = JPATH_ROOT . '/' . dirname($data_src) . '/' . File::stripExt($basename) . '_thumbnail.' . File::getExt($basename);

      if (file_exists($thumbnail))
      {
        $src = Uri::root(true) . '/' . dirname($data_src) . '/' . File::stripExt($basename) . '_thumbnail.' . File::getExt($basename);
      }

      $output .= '<img src="'. $src .'" data-src="' . $data_src . '" alt="">';
    }

    $output .= '</div>';

    $output .= '<input type="file" class="sp-image-upload" accept="image/*" style="display:none;">';
    $output .= '<a class="btn btn-primary btn-sp-image-upload'. $class1 .'" href="#"><i class="fa fa-plus"></i> Upload Image</a>';
    $output .= '<a class="btn btn-danger btn-sp-image-remove'. $class2 .'" href="#"><i class="fa fa-minus-circle"></i> Remove Image</a>';

    $output .= '<input type="hidden" name="'. $this->name .'" id="' . $this->id . '" value="' . htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8')
    . '"  class="form-field-spimage">';
    $output .= '</div>';

    return $output;
  }
}