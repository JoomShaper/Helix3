<?php
/**
* @package Helix3 Framework
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2020 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
*/

//no direct accees
defined ('_JEXEC') or die ('resticted aceess');

jimport('joomla.form.formfield');

class JFormFieldAsset extends JFormField
{
  protected	$type = 'Asset';

  protected function getInput()
  {
    $helix_plg_url = JURI::root(true) . '/plugins/system/helix3';
    $doc = JFactory::getDocument();
    $doc->addScriptdeclaration('var layoutbuilder_base="' . JURI::root() . '";');
    $doc->addScriptDeclaration("var basepath = '{$helix_plg_url}';");
    $doc->addScriptDeclaration("var pluginVersion = '{$this->getVersion()}';");

    //Core scripts
    JHtml::_('jquery.framework');
    $doc->addScript($helix_plg_url . '/assets/js/jquery-ui.min.js');
    // $doc->addScript($helix_plg_url . '/assets/js/jquery.ui.core.min.js');
    // $doc->addScript($helix_plg_url . '/assets/js/jquery.ui.sortable.min.js');

    if(JVERSION < 4)
    {
      JHtml::_('formbehavior.chosen', 'select');
    }

    $doc->addScript($helix_plg_url . '/assets/js/helper.js');
    $doc->addScript($helix_plg_url . '/assets/js/webfont.js');
    $doc->addScript($helix_plg_url . '/assets/js/modal.js');
    if(JVERSION < 4)
    {
      $doc->addScript($helix_plg_url . '/assets/js/admin.general.js');
      $doc->addScript($helix_plg_url . '/assets/js/admin.layout.js');
    }
    else
    {
      $doc->addScript($helix_plg_url . '/assets/js/admin.general.j4.js');
      $doc->addScript($helix_plg_url . '/assets/js/admin.layout.j4.js');
    }

    //CSS
    $doc->addStyleSheet($helix_plg_url . '/assets/css/bootstrap.css');
    $doc->addStyleSheet($helix_plg_url . '/assets/css/modal.css');
    $doc->addStyleSheet($helix_plg_url . '/assets/css/font-awesome.min.css');
    if(JVERSION < 4)
    {
      $doc->addStyleSheet($helix_plg_url . '/assets/css/admin.general.css');
    }
    else
    {
      $doc->addStyleSheet($helix_plg_url . '/assets/css/admin.general.j4.css');
    }
  }

  private function getVersion()
  {
    $db = JFactory::getDBO();
    $query = $db->getQuery(true);
    $query
      ->select(array('*'))
      ->from($db->quoteName('#__extensions'))
      ->where($db->quoteName('type').' = '.$db->quote('plugin'))
      ->where($db->quoteName('element').' = '.$db->quote('helix3'))
      ->where($db->quoteName('folder').' = '.$db->quote('system'));
    $db->setQuery($query);
    $result = $db->loadObject();
    $manifest_cache = json_decode($result->manifest_cache);
    
    if (isset($manifest_cache->version))
    {
      return $manifest_cache->version;
    }
    
    return;
  }
}
