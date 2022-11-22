<?php
/**
* @package Helix3 Framework
* @author JoomShaper https://www.joomshaper.com
* @copyright (c) 2010 - 2021 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Image\Image;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;

$doc = Factory::getDocument();
$app = Factory::getApplication();

//Load Helix
$helix3_path = JPATH_PLUGINS.'/system/helix3/core/helix3.php';
if (file_exists($helix3_path))
{
    require_once($helix3_path);
    $this->helix3 = Helix3::getInstance();
}
else
{
    die('Please install and activate helix plugin');
}

//custom css file
$custom_css_path = JPATH_ROOT . '/templates/' . $this->template . '/css/custom.css';

//Comingsoon Logo
if ($logo_image = $this->params->get('comingsoon_logo'))
{
	$logo = Uri::root() . '/' .  $logo_image;
	$path = JPATH_ROOT . '/' .  $logo_image;
}
else
{
    $logo 		= $this->baseurl . '/templates/' . $this->template . '/images/presets/preset1/logo.png';
    $path 		= JPATH_ROOT . '/templates/' . $this->template . '/images/presets/preset1/logo.png';
}

if (file_exists($path))
{
	$image 		 = new Image( $path );
	$logo_width  = $image->getWidth();
	$logo_height = $image->getHeight();
}
else
{
	$logo_width 	= '';
	$logo_height = '';
}

$comingsoon_title = $this->params->get('comingsoon_title');
if ($comingsoon_title)
{
	$doc->setTitle( $comingsoon_title . ' | ' . $app->get('sitename') );
}

$comingsoon_date = explode('-', $this->params->get("comingsoon_date"));

//Load jQuery
HTMLHelper::_('jquery.framework');
?>
<!DOCTYPE html>
<html class="sp-comingsoon" xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
		if($favicon = $this->helix3->getParam('favicon'))
		{
			$doc->addFavicon( Uri::base(true) . '/' .  $favicon);
		}
		else
		{
			$doc->addFavicon( $this->helix3->getTemplateUri() . '/images/favicon.ico' );
		}
    ?>
    <jdoc:include type="head" />
    <?php
	$megabgcolor = ($this->helix3->PresetParam('_megabg')) ? $this->helix3->PresetParam('_megabg') : '#ffffff';
	$megabgtx = ($this->helix3->PresetParam('_megatx')) ? $this->helix3->PresetParam('_megatx') : '#333333';

	$preloader_bg = ($this->helix3->getParam('preloader_bg')) ? $this->helix3->getParam('preloader_bg') : '#f5f5f5';
	$preloader_tx = ($this->helix3->getParam('preloader_tx')) ? $this->helix3->getParam('preloader_tx') : '#f5f5f5';
    $this->helix3->addCSS('bootstrap.min.css, joomla-fontawesome.min.css, font-awesome-v4-shims.min.css')
		->lessInit()->setLessVariables(array(
			'preset' => $this->helix3->Preset(),
			'bg_color' => $this->helix3->PresetParam('_bg'),
			'text_color' => $this->helix3->PresetParam('_text'),
			'major_color' => $this->helix3->PresetParam('_major'),
			'megabg_color' => $megabgcolor,
			'megatx_color' => $megabgtx,
			'preloader_bg' => $preloader_bg,
			'preloader_tx' => $preloader_tx,
		))
        ->addLess('master', 'template')
        ->addLess('presets',  'presets/'.$this->helix3->Preset())
    	->addJS('jquery.countdown.min.js');

    	// has exist custom.css then load it
    	if (file_exists($custom_css_path))
		{
			$this->helix3->addCSS('custom.css');
		}

		//background image
		$comingsoon_bg = '';
		$hascs_bg = '';
		if ($cs_bg = $this->params->get('comingsoon_bg'))
		{
			$comingsoon_bg 	= Uri::root() . $cs_bg;
			$hascs_bg 		= 'has-background';
		}
    ?>
</head>
<body>
	<div class="sp-comingsoon-wrap <?php echo $hascs_bg; ?>" style="background-image: url(<?php echo $comingsoon_bg; ?>);">	
		<div class="container">
			<div class="text-center">
				<div id="sp-comingsoon">
					<div class="comingsoon-page-logo">
						<?php if($comingsoon_logo = $this->params->get('comingsoon_logo')) : ?>
							<img class="comingsoon-logo" alt="logo" src="<?php echo $logo; ?>" />
						<?php else : ?>
							<img class="sp-default-logo comingsoon-logo" alt="logo" src="<?php echo $logo; ?>" />
						<?php endif; ?>
					</div>

					<?php if ($comingsoon_title) : ?>
						<h1 class="sp-comingsoon-title">
							<?php echo $comingsoon_title; ?>
						</h1>
					<?php endif; ?>

					<?php if ($this->params->get('comingsoon_content')) : ?>
						<div class="sp-comingsoon-content">
							<?php echo $this->params->get('comingsoon_content'); ?>
						</div>
					<?php endif; ?>

					<div id="sp-comingsoon-countdown" class="sp-comingsoon-countdown"></div>

					<?php if($this->countModules('comingsoon')) : ?>
					<div class="sp-position-comingsoon">
						<jdoc:include type="modules" name="comingsoon" style="sp_xhtml" />
					</div>
					<?php endif; ?>

					<?php
					//Social Icons
					$facebook 	= $this->params->get('facebook');
					$twitter  	= $this->params->get('twitter');
					$pinterest 	= $this->params->get('pinterest');
					$youtube 	= $this->params->get('youtube');
					$linkedin 	= $this->params->get('linkedin');
					$dribbble 	= $this->params->get('dribbble');
					$behance 	= $this->params->get('behance');
					$skype 		= $this->params->get('skype');
					$flickr 	= $this->params->get('flickr');
					$vk 		= $this->params->get('vk');

					if ($this->params->get('show_social_icons') && ($facebook || $twitter || $pinterest || $youtube || $linkedin || $dribbble || $behance || $skype || $flickr || $vk)) :
					?>
						<ul class="social-icons">
							<?php if ($facebook) : ?>
								<li><a target="_blank" href="<?php echo $facebook; ?>"><i class="fa fa-facebook" area-hidden="true"></i></a></li>
							<?php endif; ?>

							<?php if ($twitter) : ?>
								<li><a target="_blank" href="<?php echo $twitter; ?>"><i class="fa fa-twitter" area-hidden="true"></i></a></li>
							<?php endif; ?>

							<?php if ($pinterest) : ?>
								<li><a target="_blank" href="<?php echo $pinterest; ?>"><i class="fa fa-pinterest" area-hidden="true"></i></a></li>
							<?php endif; ?>

							<?php if ($youtube) : ?>
								<li><a target="_blank" href="<?php echo $youtube; ?>"><i class="fa fa-youtube" area-hidden="true"></i></a></li>
							<?php endif; ?>

							<?php if ($linkedin ) : ?>
								<li><a target="_blank" href="<?php echo $linkedin; ?>"><i class="fa fa-linkedin" area-hidden="true"></i></a></li>
							<?php endif; ?>

							<?php if ($dribbble) : ?>
								<li><a target="_blank" href="<?php echo $dribbble; ?>"><i class="fa fa-dribbble" area-hidden="true"></i></a></li>
							<?php endif; ?>

							<?php if ($behance) : ?>
								<li><a target="_blank" href="<?php echo $behance; ?>"><i class="fa fa-behance" area-hidden="true"></i></a></li>
							<?php endif; ?>

							<?php if ($flickr) : ?>
								<li><a target="_blank" href="<?php echo $flickr; ?>"><i class="fa fa-flickr" area-hidden="true"></i></a></li>
							<?php endif; ?>

							<?php if ($vk) : ?>
								<li><a target="_blank" href="<?php echo $vk; ?>"><i class="fa fa-vk" area-hidden="true"></i></a></li>
							<?php endif; ?>

							<?php if ($skype) : ?>
								<li><a href="skype:<?php echo $skype; ?>'?chat"><i class="fa fa-skype" area-hidden="true"></i></a></li>
							<?php endif; ?>
						<ul>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript">
		jQuery(function($) {
			$('#sp-comingsoon-countdown').countdown('<?php echo trim($comingsoon_date[0]); ?>/<?php echo trim($comingsoon_date[1]); ?>/<?php echo trim($comingsoon_date[2]); ?>', function(event) {
			    $(this).html(event.strftime('<div class="days"><span class="number">%-D</span><span class="string">%!D:<?php echo Text::_("HELIX_DAY"); ?>,<?php echo Text::_("HELIX_DAYS"); ?>;</span></div><div class="hours"><span class="number">%H</span><span class="string">%!H:<?php echo Text::_("HELIX_HOUR"); ?>,<?php echo Text::_("HELIX_HOURS"); ?>;</span></div><div class="minutes"><span class="number">%M</span><span class="string">%!M:<?php echo Text::_("HELIX_MINUTE"); ?>,<?php echo Text::_("HELIX_MINUTES"); ?>;</span></div><div class="seconds"><span class="number">%S</span><span class="string">%!S:<?php echo Text::_("HELIX_SECOND"); ?>,<?php echo Text::_("HELIX_SECONDS"); ?>;</span></div>'));
			});
		});
	</script>
</body>
</html>