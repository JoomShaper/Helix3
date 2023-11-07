<?php
/**
* @package Helix3 Framework
* Template Name - Shaper Helix3
* @author JoomShaper https://www.joomshaper.com
* @copyright (c) 2010 - 2021 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/
//no direct accees
defined('_JEXEC') or die('restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Version;

$doc = Factory::getDocument();
$app = Factory::getApplication();
$menu = $app->getMenu()->getActive();

//Load Helix
$helix3_path = JPATH_PLUGINS . '/system/helix3/core/helix3.php';

if (file_exists($helix3_path))
{
	require_once($helix3_path);
	$helix3 = helix3::getInstance();
}
else
{
	die('Please install and activate helix plugin');
}

//Coming Soon
if ($helix3->getParam('comingsoon_mode'))
{
	header("Location: " . Route::_(Uri::root(true) . "/index.php?tmpl=comingsoon", false));
	exit();
}

//Class Classes
$body_classes = '';
if ($helix3->getParam('sticky_header'))
{
	$body_classes .= ' sticky-header';
}

$body_classes .= ($helix3->getParam('boxed_layout', 0)) ? ' layout-boxed' : ' layout-fluid';

if (isset($menu) && $menu)
{
	if ($menu->getParams()->get('pageclass_sfx'))
	{
		$body_classes .= ' ' . $menu->getParams()->get('pageclass_sfx');
	}
}

$body_classes .= ' off-canvas-menu-init';

//Body Background Image
if ($bg_image = $helix3->getParam('body_bg_image'))
{
	$body_style = 'background-image: url(' . Uri::base(true) . '/' . $bg_image . ');';
	$body_style .= 'background-repeat: ' . $helix3->getParam('body_bg_repeat') . ';';
	$body_style .= 'background-size: ' . $helix3->getParam('body_bg_size') . ';';
	$body_style .= 'background-attachment: ' . $helix3->getParam('body_bg_attachment') . ';';
	$body_style .= 'background-position: ' . $helix3->getParam('body_bg_position') . ';';
	$body_style = 'body.site {' . $body_style . '}';
	
	$doc->addStyledeclaration($body_style);
}

//Custom CSS
if ($custom_css = $helix3->getParam('custom_css'))
{
	$doc->addStyledeclaration($custom_css);
}

//Custom JS
if ($custom_js = $helix3->getParam('custom_js'))
{
	$doc->addScriptdeclaration($custom_js);
}

//preloader & goto top
$doc->addScriptdeclaration("\nvar sp_preloader = '" . $this->params->get('preloader') . "';\n");
$doc->addScriptdeclaration("\nvar sp_gotop = '" . $this->params->get('goto_top') . "';\n");
$doc->addScriptdeclaration("\nvar sp_offanimation = '" . $this->params->get('offcanvas_animation') . "';\n");
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?php $helix3->loadHead(); ?>
		<?php
			$megabgcolor = ($helix3->PresetParam('_megabg')) ? $helix3->PresetParam('_megabg') : '#ffffff';
			$megabgtx = ($helix3->PresetParam('_megatx')) ? $helix3->PresetParam('_megatx') : '#333333';

			$preloader_bg = ($helix3->getParam('preloader_bg')) ? $helix3->getParam('preloader_bg') : '#f5f5f5';
			$preloader_tx = ($helix3->getParam('preloader_tx')) ? $helix3->getParam('preloader_tx') : '#f5f5f5';

			// load css, less and js
			$helix3->addCSS('bootstrap.min.css'); // CSS Files
			
			$version = new Version();
			$JoomlaVersion = $version->getShortVersion();

			if (version_compare($JoomlaVersion, '5.0.0', '<')) {
				$helix3->addCSS('joomla-fontawesome.min.css, font-awesome-v4-shims.min.css');
			} else {
				$helix3->addCSS('fontawesome.min.css, font-awesome-v4-shims.min.css');
			}

			$helix3->addJS('bootstrap.min.js, jquery.sticky.js, main.js') // JS Files
			->lessInit()->setLessVariables(array(
				'preset' => $helix3->Preset(),
				'bg_color' => $helix3->PresetParam('_bg'),
				'text_color' => $helix3->PresetParam('_text'),
				'major_color' => $helix3->PresetParam('_major'),
				'megabg_color' => $megabgcolor,
				'megatx_color' => $megabgtx,
				'preloader_bg' => $preloader_bg,
				'preloader_tx' => $preloader_tx,
			))
			->addLess('master', 'template');
				
			//RTL
			if ($this->direction == 'rtl')
			{
				$helix3->addCSS('bootstrap-rtl.min.css')
					->addLess('rtl', 'rtl');
			}
			
			$helix3->addLess('presets', 'presets/' . $helix3->Preset(), array('class' => 'preset'));
			
			//Before Head
			if ($before_head = $helix3->getParam('before_head')) {
				echo $before_head . "\n";
			}
		?>
	</head>
	
	<body class="<?php echo $helix3->bodyClass($body_classes); ?>">
	
		<div class="body-wrapper">
			<div class="body-innerwrapper">
				<?php $helix3->generatelayout(); ?>
			</div>
		</div>
		
		<!-- Off Canvas Menu -->
		<div class="offcanvas-menu">
			<a href="#" class="close-offcanvas" aria-label="Close"><i class="fa fa-remove" aria-hidden="true" title="<?php echo Text::_('HELIX_CLOSE_MENU'); ?>"></i></a>
			<div class="offcanvas-inner">
				<?php if ($helix3->countModules('offcanvas')) : ?>
					<jdoc:include type="modules" name="offcanvas" style="sp_xhtml"/>
				<?php else : ?>
					<p class="alert alert-warning">
						<?php echo Text::_('HELIX_NO_MODULE_OFFCANVAS'); ?>
					</p>
				<?php endif; ?>
			</div>
		</div>
				
		<?php
			if ($this->params->get('compress_css'))
			{
				$helix3->compressCSS();
			}
			
			$tempOption    = $app->input->get('option');
			
			if ($this->params->get('compress_js') && $tempOption != 'com_config')
			{
				$helix3->compressJS($this->params->get('exclude_js'));
			}
			
			//before body
			if ($before_body = $helix3->getParam('before_body'))
			{
				echo $before_body . "\n";
			}
		?>
				
		<jdoc:include type="modules" name="debug" />
		<jdoc:include type="modules" name="helixpreloader" />
				
		<!-- Go to top -->
		<?php if ($this->params->get('goto_top')) : ?>
			<a href="javascript:void(0)" class="scrollup" aria-label="<?php echo Text::_('HELIX_GOTO_TOP'); ?>">&nbsp;</a>
		<?php endif; ?>
	</body>
</html>