<?php
/**
 * @package Helix3 Framework
 * @author JoomShaper http://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2015 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
*/
//no direct accees
defined ('_JEXEC') or die('resticted aceess');
 
class Helix3FeatureLogo {

	private $helix3;
	public $position;

	public function __construct( $helix3 ){
		$this->helix3 = $helix3;
		$this->position = $this->helix3->getParam('logo_position', 'logo');
	}

	public function renderFeature() {

		//Retina Image
		if( $this->helix3->getParam('logo_type') == 'image' ) {
			jimport('joomla.image.image');

			if( $this->helix3->getParam('logo_image') ) {
				$path = JPATH_ROOT . '/' . $this->helix3->getParam('logo_image');
			} else {
				$path = JPATH_ROOT . '/templates/' . $this->helix3->getTemplate() . '/images/presets/' . $this->helix3->Preset() . '/logo.png';
			}

			if(file_exists($path)) {
				$image = new JImage( $path );
				$width 	= $image->getWidth();
				$height = $image->getHeight();
			} else {
				$width 	= '';
				$height = '';
			}

		}

		$html  = '';
		$custom_logo_class = '';
		$sitename = JFactory::getApplication()->get('sitename');

		if( $this->helix3->getParam('mobile_logo') ) {
			$custom_logo_class = ' hidden-xs';
		}

		$html .= '<a class="logo" href="' . JURI::base(true) . '/">';

		if( $this->helix3->getParam('logo_type') == 'image' ) {
			if( $this->helix3->getParam('logo_image') ) {
				$html .= '<h1>';
				$html .= '<img class="sp-default-logo'. $custom_logo_class .'" src="' . $this->helix3->getParam('logo_image') . '" alt="'. $sitename .'">';
				if( $this->helix3->getParam('logo_image_2x') ) {
					$html .= '<img class="sp-retina-logo'. $custom_logo_class .'" src="' . $this->helix3->getParam('logo_image_2x') . '" alt="'. $sitename .'" width="' . $width . '" height="' . $height . '">';
				}

				if( $this->helix3->getParam('mobile_logo') ) {
					$html .= '<img class="sp-default-logo visible-xs" src="' . $this->helix3->getParam('mobile_logo') . '" alt="'. $sitename .'">';
				}

				$html .= '</h1>';
			} else {
				$html .= '<h1>';
				$html .= '<img class="sp-default-logo'. $custom_logo_class .'" src="' . $this->helix3->getTemplateUri() . '/images/presets/' . $this->helix3->Preset() . '/logo.png" alt="'. $sitename .'">';
				$html .= '<img class="sp-retina-logo'. $custom_logo_class .'" src="' . $this->helix3->getTemplateUri() . '/images/presets/' . $this->helix3->Preset() . '/logo@2x.png" alt="'. $sitename .'" width="' . $width . '" height="' . $height . '">';

				if( $this->helix3->getParam('mobile_logo') ) {
					$html .= '<img class="sp-default-logo visible-xs" src="' . $this->helix3->getParam('mobile_logo') . '" alt="'. $sitename .'">';
				}

				$html .= '</h1>';
			}
			
		} else {
			if( $this->helix3->getParam('logo_text') ) {
				$html .= '<h1>' . $this->helix3->getParam('logo_text') . '</h1>';
			} else {
				$html .= '<h1>' . $sitename . '</h1>';
			}

			if( $this->helix3->getParam('logo_slogan') ) {
				$html .= '<p class="logo-slogan">' . $this->helix3->getParam('logo_slogan') . '</p>';
			}
		}

		$html .= '</a>';

		return $html;
	}

}