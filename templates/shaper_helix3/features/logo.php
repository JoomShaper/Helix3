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
use Joomla\CMS\Image\Image;
use Joomla\CMS\Uri\Uri;

class Helix3FeatureLogo {

	private $helix3;
	public $position;

	public function __construct( $helix3 ){
		$this->helix3 = $helix3;
		$this->position = $this->helix3->getParam('logo_position', 'logo');
		$this->load_pos = $this->helix3->getParam('logo_load_pos');
	}

	public function renderFeature()
	{

		//Retina Image
		if( $this->helix3->getParam('logo_type') == 'image' ) {
			if( $this->helix3->getParam('logo_image') ) {
				$path = JPATH_ROOT . '/' . $this->helix3->getParam('logo_image');
			} else {
				$path = JPATH_ROOT . '/templates/' . $this->helix3->getTemplate() . '/images/presets/' . $this->helix3->Preset() . '/logo.png';
			}

			if(file_exists($path)) {
				$image = new Image( $path );
				$width 	= $image->getWidth();
				$height = $image->getHeight();
			} else {
				$width 	= '';
				$height = '';
			}

		}

		$html  = '';
		$custom_logo_class = '';
		$sitename = Factory::getApplication()->get('sitename');

		if( $this->helix3->getParam('mobile_logo') ) {
			$custom_logo_class = ' d-none d-lg-block';
		}

		if( $this->helix3->getParam('logo_type') == 'image' ) {
			if( $this->helix3->getParam('logo_image') ) {
				$html .= '<div class="logo">';
				$html .= '<a href="' . Uri::base(true) . '/">';
					$html .= '<img class="sp-default-logo'. $custom_logo_class .'" src="' . $this->helix3->getParam('logo_image') . '" srcset="'. ($this->helix3->getParam('logo_image_2x') ? $this->helix3->getParam('logo_image_2x') . ' 2x' : '') .'" alt="'. $sitename .'">';
					
					if( $this->helix3->getParam('mobile_logo') ) {
						$html .= '<img class="sp-default-logo d-block d-lg-none" src="' . $this->helix3->getParam('mobile_logo') . '" alt="'. $sitename .'">';
					}

				$html .= '</a>';

				$html .= '</div>';
			} else {
				$html .= '<div class="logo">';
					$html .= '<a href="' . Uri::base(true) . '/">';
						$html .= '<img class="sp-default-logo'. $custom_logo_class .'" src="' . $this->helix3->getTemplateUri() . '/images/presets/' . $this->helix3->Preset() . '/logo.png" alt="'. $sitename .'">';
						
						if( $this->helix3->getParam('mobile_logo') ) {
							$html .= '<img class="sp-default-logo d-block d-lg-none" src="' . $this->helix3->getParam('mobile_logo') . '" alt="'. $sitename .'">';
						}
					$html .= '</a>';
				$html .= '</div>';
			}

		} else {
			if( $this->helix3->getParam('logo_text') ) {
				$html .= '<h1 class="logo"> <a href="' . Uri::base(true) . '/">' . $this->helix3->getParam('logo_text') . '</a></h1>';
			} else {
				$html .= '<h1 class="logo"> <a href="' . Uri::base(true) . '/">' . $sitename . '</a></h1>';
			}

			if( $this->helix3->getParam('logo_slogan') ) {
				$html .= '<p class="logo-slogan">' . $this->helix3->getParam('logo_slogan') . '</p>';
			}
		}

		return $html;
	}
}
