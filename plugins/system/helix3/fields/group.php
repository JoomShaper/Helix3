<?php
/**
* @package Helix3 Framework
* @author JoomShaper https://www.joomshaper.com
* @copyright (c) 2010 - 2021 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
*/

//no direct accees
defined ('_JEXEC') or die ('resticted aceess');

use Joomla\CMS\Form\FormField;
use Joomla\CMS\Language\Text;

class JFormFieldGroup extends FormField
{
  protected $type = 'Group';

  public function getInput()
  {
    $text   = (string) $this->element['title'];
    $subtitle  	= (!empty($this->element['subtitle'])) ? '<span>' . Text::_($this->element['subtitle']) . '</span>':'';
    $group = ($this->element['group']=='no')?'no_group':'in_group';
    return '<div class="group_separator '.$group.'" title="'. Text::_($this->element['desc']) .'">' . Text::_($text) . $subtitle . '</div>';
  }

  public function getLabel()
  {
    return false;
  }
}
