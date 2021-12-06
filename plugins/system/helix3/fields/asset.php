<?php
/**
* @package Helix3 Framework
* @author JoomShaper https://www.joomshaper.com
* @copyright (c) 2010 - 2021 JoomShaper
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

    $jVersion = JVERSION < 4 ? '' : '.j4';

    if(JVERSION < 4)
    {
      JHtml::_('jquery.ui', array('core', 'sortable'));
      JHtml::_('formbehavior.chosen', 'select');
    }
    else
    {
      $doc->addScript($helix_plg_url . '/assets/js/jquery-ui.min.js');
    }

    $doc->addScript($helix_plg_url . '/assets/js/helper'. $jVersion .'.js');
    $doc->addScript($helix_plg_url . '/assets/js/webfont.js');
    $doc->addScript($helix_plg_url . '/assets/js/modal.js');
    
    $doc->addScript($helix_plg_url . '/assets/js/admin.general'. $jVersion .'.js');
    $doc->addScript($helix_plg_url . '/assets/js/admin.layout'. $jVersion .'.js');

    //CSS
    $doc->addStyleSheet($helix_plg_url . '/assets/css/bootstrap.css');
    $doc->addStyleSheet($helix_plg_url . '/assets/css/modal.css');
    $doc->addStyleSheet($helix_plg_url . '/assets/css/font-awesome.min.css');
    $doc->addStyleSheet($helix_plg_url . '/assets/css/admin.general'. $jVersion .'.css');
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
