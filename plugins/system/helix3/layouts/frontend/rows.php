<?php
/**
 * @package Helix3 Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright (c) 2010 - 2021 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
 */
defined('_JEXEC') or die('Restricted Access');

use Joomla\CMS\Factory;
use Joomla\CMS\Layout\FileLayout;

//helper & model
$helix3_class   = JPATH_ROOT . '/plugins/system/helix3/core/classes/helix3.php';

if (file_exists($helix3_class))
{
    require_once($helix3_class);
}

$template       = Factory::getApplication()->getTemplate();
$themepath      = JPATH_THEMES . '/' . $template;
$carea_file     = $themepath . '/html/layouts/helix3/frontend/conponentarea.php';
$module_file    = $themepath . '/html/layouts/helix3/frontend/modules.php';
$lyt_thm_path   = $themepath . '/html/layouts/helix3/';

$layout_path_carea  = (file_exists($carea_file)) ? $lyt_thm_path : JPATH_ROOT .'/plugins/system/helix3/layouts';
$layout_path_module = (file_exists($module_file)) ? $lyt_thm_path : JPATH_ROOT .'/plugins/system/helix3/layouts';

$data = $displayData;

$output ='';

$output .= '<div class="row">';

foreach ($data['rowColumns'] as $key => $column)
{
    //Responsive Utilities
    if (isset($column->settings->sm_col) && $column->settings->sm_col)
    {
        $column->className = str_replace('col-sm', 'col-md', $column->settings->sm_col) . ' ' . $column->className;
    }
    
    if (isset($column->settings->xs_col) && $column->settings->xs_col)
    {
        $column->className = str_replace('col-xs', 'col', $column->settings->xs_col) . ' ' . $column->className;
    }

    $hidden_on_phone = isset($column->settings->hidden_xs) && $column->settings->hidden_xs ? true : false;
    $hidden_on_tablet = isset($column->settings->hidden_sm) && $column->settings->hidden_sm ? true : false;
    $hidden_on_desktop = isset($column->settings->hidden_md) && $column->settings->hidden_md ? true : false;

    $responsive_class = '';
    if ($hidden_on_desktop && $hidden_on_tablet && $hidden_on_phone)
    {
        $responsive_class = 'd-none';
    }
    else if ($hidden_on_desktop && $hidden_on_tablet)
    {
        $responsive_class = 'd-block d-md-none';
    }
    else if ($hidden_on_desktop && $hidden_on_phone)
    {
        $responsive_class = 'd-none d-md-block d-lg-none';
    }
    else if ($hidden_on_tablet && $hidden_on_phone)
    {
        $responsive_class = 'd-none d-lg-block';
    }
    else if ($hidden_on_desktop)
    {
        $responsive_class = 'd-lg-none';
    }
    else if ($hidden_on_tablet)
    {
        $responsive_class = 'd-md-none d-lg-block';
    }
    else if ($hidden_on_phone)
    {
        $responsive_class = 'd-none d-md-block';
    }

    $column->className = $column->className . ' ' . $responsive_class;
    //End Responsive Utilities

    if ($column->settings->column_type)
    { //Component
        $getLayout = new FileLayout('frontend.conponentarea', $layout_path_carea );
        $output .= $getLayout->render($column);
    }
    else
    { // Module

        $getLayout = new FileLayout('frontend.modules', $layout_path_module );
        $output .= $getLayout->render($column);
    }
}

$output .= '</div>'; //.row

echo $output;
