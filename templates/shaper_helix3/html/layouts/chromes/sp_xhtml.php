<?php
/**
 * @package Helix3 Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright (c) 2010 - 2021 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

defined('_JEXEC') or die;

$module  = $displayData['module'];
$params  = $displayData['params'];
$attribs = $displayData['attribs'];

if ($module->content === null || $module->content === '')
{
	return;
}

$moduleTag     = htmlspecialchars(!empty($params->get('module_tag', 'div')) ? $params->get('module_tag', 'div') : '', ENT_QUOTES, 'UTF-8');
$bootstrapSize = (int) $params->get('bootstrap_size', 0);
$moduleClass   = $bootstrapSize !== 0 ? ' col-sm-' . $bootstrapSize : '';
$headerTag     = htmlspecialchars(!empty($params->get('header_tag', 'h3')) ? $params->get('header_tag', 'h3') : '', ENT_QUOTES, 'UTF-8');
$headerClass   = htmlspecialchars(!empty($params->get('header_class', 'sp-module-title')) ? $params->get('header_class', 'sp-module-title') : '', ENT_COMPAT, 'UTF-8');

if ($module->content)
{
    echo '<' . $moduleTag . ' class="sp-module ' . htmlspecialchars(!empty($params->get('moduleclass_sfx')) ? $params->get('moduleclass_sfx') : '', ENT_COMPAT, 'UTF-8') . $moduleClass . '">';
        if ($module->showtitle)
        {
            echo '<' . $headerTag . ' class="' . $headerClass . '">' . $module->title . '</' . $headerTag . '>';
        }
        echo '<div class="sp-module-content">';
        echo $module->content;
        echo '</div>';
    echo '</' . $moduleTag . '>';
}