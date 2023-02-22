<?php
/**
 * @package Helix3 Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright (c) 2010 - 2021 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
*/
//no direct accees
defined ('_JEXEC') or die('resticted aceess');

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;

class Helix3FeatureTitle {

	private $helix3;

	public function __construct($helix){
		$this->helix3 = $helix;
		$this->position = 'title';
	}

	public function renderFeature() {

		$app 		= Factory::getApplication();
		$menuitem   = $app->getMenu()->getActive(); // get the active item

		if($menuitem) {

			$params 	= $menuitem->getParams(); // get the menu params

			if($params->get('enable_page_title', 0)) {

				$page_title 		 = $menuitem->title;
				$page_title_alt 	 = $params->get('page_title_alt');
				$page_subtitle 		 = $params->get('page_subtitle');
				$page_title_bg_color = $params->get('page_title_bg_color');
				$page_title_bg_image = $params->get('page_title_bg_image');

				$style = '';

				if($page_title_bg_color) {
					$style .= 'background-color: ' . $page_title_bg_color . ';';
				}

				if($page_title_bg_image) {
					$style .= 'background-image: url(' . Uri::root(true) . '/' . $page_title_bg_image . ');';
				}

				if( $style ) {
					$style = 'style="' . $style . '"';
				}

				if($page_title_alt) {
					$page_title 	 = $page_title_alt;
				}

				$output = '';

				$output .= '<div class="sp-page-title"'. $style .'>';
				$output .= '<div class="container">';

				$output .= '<h2>'. $page_title .'</h2>';

				if($page_subtitle) {
					$output .= '<h3>'. $page_subtitle .'</h3>';
				}

				$output .= '<jdoc:include type="modules" name="breadcrumb" style="none" />';

				$output .= '</div>';
				$output .= '</div>';

				return $output;

			}

		}

	}
}
