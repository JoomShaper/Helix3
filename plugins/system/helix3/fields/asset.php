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
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Uri\Uri;

class JFormFieldAsset extends FormField
{
	protected	$type = 'Asset';
	
	protected function getInput()
	{
		$v = $this->getVersion();
		$helix_plg_url = Uri::root(true) . '/plugins/system/helix3';
		$doc = Factory::getDocument();
		$doc->addScriptdeclaration('var layoutbuilder_base="' . Uri::root() . '";');
		$doc->addScriptDeclaration("var basepath = '{$helix_plg_url}';");
		$doc->addScriptDeclaration("var pluginVersion = '{$v}';");
		
		//Core scripts
		HTMLHelper::_('jquery.framework');
		
		$jVersion = JVERSION < 4 ? '' : '.j4';
		
		if (JVERSION < 4)
		{
			HTMLHelper::_('jquery.ui', array('core', 'sortable'));
			HTMLHelper::_('formbehavior.chosen', 'select');
		}
		else
		{
			$doc->addScript($helix_plg_url . '/assets/js/jquery-ui.min.js?' . $v);
		}
		
		$doc->addScript($helix_plg_url . '/assets/js/helper'. $jVersion .'.js?' . $v);
		$doc->addScript($helix_plg_url . '/assets/js/webfont.js?' . $v);
		$doc->addScript($helix_plg_url . '/assets/js/modal.js?' . $v);
		
		$doc->addScript($helix_plg_url . '/assets/js/admin.general'. $jVersion .'.js?' . $v);
		$doc->addScript($helix_plg_url . '/assets/js/admin.layout'. $jVersion .'.js?' . $v);
		
		//CSS
		$doc->addStyleSheet($helix_plg_url . '/assets/css/bootstrap.css?' . $v);
		$doc->addStyleSheet($helix_plg_url . '/assets/css/modal.css?' . $v);
		$doc->addStyleSheet($helix_plg_url . '/assets/css/font-awesome.min.css?' . $v);
		$doc->addStyleSheet($helix_plg_url . '/assets/css/admin.general'. $jVersion .'.css?' . $v);
	}
	
	private function getVersion()
	{
		$db = Factory::getDBO();
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
