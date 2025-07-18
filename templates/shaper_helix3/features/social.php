<?php
/**
 * @package Helix3 Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright (c) 2010 - 2021 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
*/
//no direct accees
defined ('_JEXEC') or die('resticted aceess');

class Helix3FeatureSocial {

	private $helix3;
	public $position;
	public $load_pos;

	public function __construct( $helix3 ){
		$this->helix3   = $helix3;
		$this->position = $this->helix3->getParam('social_position');
		$this->load_pos = $this->helix3->getParam('social_load_pos');
	}

	public function renderFeature() {

		$facebook   = $this->helix3->getParam('facebook');
		$twitter    = $this->helix3->getParam('twitter');
		$pinterest  = $this->helix3->getParam('pinterest');
		$youtube    = $this->helix3->getParam('youtube');
		$linkedin   = $this->helix3->getParam('linkedin');
		$dribbble   = $this->helix3->getParam('dribbble');
		$behance    = $this->helix3->getParam('behance');
		$skype      = $this->helix3->getParam('skype');
		$whatsapp   = $this->helix3->getParam('whatsapp');
		$flickr     = $this->helix3->getParam('flickr');
		$vk         = $this->helix3->getParam('vk');
		$custom     = $this->helix3->getParam('custom');

		if( $this->helix3->getParam('show_social_icons') && ( $facebook || $twitter || $pinterest || $youtube || $linkedin || $dribbble || $behance || $skype || $flickr || $vk ) ) {
			$html  = '<ul class="social-icons">';

			if( $facebook ) {
				$html .= '<li><a target="_blank" href="'. $facebook .'" aria-label="facebook"><i class="fa fa-facebook"></i></a></li>';
			}
			if( $twitter ) {
				$html .= '<li><a target="_blank" href="'. $twitter .'" aria-label="twitter"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor" style="width: 13.56px;position: relative;top: -1.5px;"><path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"/></svg></a></li>';
			}
			if( $pinterest ) {
				$html .= '<li><a target="_blank" href="'. $pinterest .'" aria-label="pinterest"><i class="fa fa-pinterest"></i></a></li>';
			}
			if( $youtube ) {
				$html .= '<li><a target="_blank" href="'. $youtube .'" aria-label="youtube"><i class="fa fa-youtube"></i></a></li>';
			}
			if( $linkedin ) {
				$html .= '<li><a target="_blank" href="'. $linkedin .'" aria-label="linkedin"><i class="fa fa-linkedin"></i></a></li>';
			}
			if( $dribbble ) {
				$html .= '<li><a target="_blank" href="'. $dribbble .'" aria-label="dribbble"><i class="fa fa-dribbble"></i></a></li>';
			}
			if( $behance ) {
				$html .= '<li><a target="_blank" href="'. $behance .'" aria-label="behance"><i class="fa fa-behance"></i></a></li>';
			}
			if( $flickr ) {
				$html .= '<li><a target="_blank" href="'. $flickr .'" aria-label="flickr"><i class="fa fa-flickr"></i></a></li>';
			}
			if( $vk ) {
				$html .= '<li><a target="_blank" href="'. $vk .'" aria-label="vk"><i class="fa fa-vk"></i></a></li>';
			}
			if( $skype ) {
				$html .= '<li><a href="skype:'. $skype .'?chat" aria-label="skype"><i class="fa fa-skype"></i></a></li>';
			}
			if( $whatsapp ) {
				$html .= '<li><a href="whatsapp://send?abid='. $whatsapp .'&text=Hi" aria-label="whatsapp"><i class="fa fa-whatsapp"></i></a></li>';
			}
			if( $custom ) {
				$explt_custom = explode(' ', $custom);
				$html .= '<li><a target="_blank" href="'. $explt_custom[1] .'"><i class="fa '. $explt_custom[0] .'"></i></a></li>';
			}

			$html .= '</ul>';

			return $html;
		}

	}
}