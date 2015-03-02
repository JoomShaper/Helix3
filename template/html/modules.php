<?php
/**
* @package Helix Framework
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2015 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/
//no direct accees
defined ('_JEXEC') or die ('resticted aceess');

function modChrome_sp_xhtml($module, $params, $attribs) {

	$moduleTag     = $params->get('module_tag', 'div');
	$bootstrapSize = (int) $params->get('bootstrap_size', 0);
	$moduleClass   = $bootstrapSize != 0 ? ' col-sm-' . $bootstrapSize : '';
	$headerTag     = htmlspecialchars($params->get('header_tag', 'h3'));
	$headerClass   = htmlspecialchars($params->get('header_class', 'sp-module-title'));

	// CSS
	$module_css  = '';
	$module_css .= ($params->get('background_color')) ? 'background-color:' . $params->get('background_color') . ';' : '';
	$module_css .= ($params->get('color')) ? 'color:' . $params->get('color') . ';' : '';
	$module_css .= ($params->get('padding')) ? 'padding:' . $params->get('padding') . ';' : '';
	$module_css .= ($params->get('margin')) ? 'margin:' . $params->get('margin') . ';' : '';
	$module_css  = ($module_css) ? ' style="' . $module_css . '"' : '';
	
	if ($module->content) {
		echo '<' . $moduleTag . ' class="sp-module ' . htmlspecialchars($params->get('moduleclass_sfx')) . $moduleClass . '"'. $module_css .'>';

			if ($module->showtitle)
			{
				if( $params->get('icon') ) {
					$module->title = '<i class="fa '. $params->get('icon') .'"></i> ' . $module->title;
				}

				echo '<' . $headerTag . ' class="' . $headerClass . '">' . $module->title . '</' . $headerTag . '>';
			}

			echo '<div class="sp-module-content">';
			echo $module->content;
			echo '</div>';

		echo '</' . $moduleTag . '>';
	}
}