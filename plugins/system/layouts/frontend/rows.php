<?php
/**
 * @package     Helix
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */
defined('_JEXEC') or die('Restricted Access');

//helper & model
$menu_class   = JPATH_ROOT . '/plugins/system/helix3/core/classes/helix3.php';

if (file_exists($menu_class)) {
    require_once($menu_class);
}

$template       = JFactory::getApplication()->getTemplate();
$themepath      = JPATH_THEMES . '/' . $template;
$carea_file     = $themepath . '/html/layouts/helix3/frontend/conponentarea.php';
$module_file    = $themepath . '/html/layouts/helix3/frontend/modules.php';
$lyt_thm_path   = $themepath . '/html/layouts/helix3/';

$layout_path_carea  = (file_exists($carea_file)) ? $lyt_thm_path : JPATH_ROOT .'/plugins/system/helix3/layouts';
$layout_path_module = (file_exists($module_file)) ? $lyt_thm_path : JPATH_ROOT .'/plugins/system/helix3/layouts';

$data = $displayData;

$output ='';

$output .= '<div class="row">';

foreach ($data['rowColumns'] as $key => $column){

    //Responsive Utilities
    if (isset($column->settings->xs_col) && $column->settings->xs_col) {
        $column->className = $column->settings->xs_col . ' ' . $column->className;
    }

    if (isset($column->settings->sm_col) && $column->settings->sm_col) {
        $column->className = preg_replace('/col-sm-\d*/', $column->settings->sm_col, $column->className);
    }

    if (isset($column->settings->hidden_md) && $column->settings->hidden_md) {
        $column->className = $column->className . ' hidden-md hidden-lg';
    }

    if (isset($column->settings->hidden_sm) && $column->settings->hidden_sm) {
        $column->className = $column->className . ' hidden-sm';
    }

    if (isset($column->settings->hidden_xs) && $column->settings->hidden_xs) {
        $column->className = $column->className . ' hidden-xs';
    }
    //End Responsive Utilities

    if ($column->settings->column_type){ //Component
        $getLayout = new JLayoutFile('frontend.conponentarea', $layout_path_carea );
        $output .= $getLayout->render($column);
    }
    else { // Module

        $getLayout = new JLayoutFile('frontend.modules', $layout_path_module );
        $output .= $getLayout->render($column);
    }
}

$output .= '</div>'; //.row

echo $output;
