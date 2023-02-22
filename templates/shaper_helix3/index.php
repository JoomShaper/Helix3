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

$doc = Factory::getDocument();
$app = Factory::getApplication();
$menu = $app->getMenu()->getActive();

//Load Helix
$helix3_path = JPATH_PLUGINS . '/system/helix3/core/helix3.php';

if (file_exists($helix3_path))
{
	require_once($helix3_path);
	$this->helix3 = helix3::getInstance();
}
else
{
	die('Please install and activate helix plugin');
}

//Coming Soon
if ($this->helix3->getParam('comingsoon_mode'))
{
	header("Location: " . Route::_(Uri::root(true) . "/index.php?tmpl=comingsoon", false));
	exit();
}

//Class Classes
$body_classes = '';
if ($this->helix3->getParam('sticky_header'))
{
	$body_classes .= ' sticky-header';
}

$body_classes .= ($this->helix3->getParam('boxed_layout', 0)) ? ' layout-boxed' : ' layout-fluid';

if (isset($menu) && $menu)
{
	if ($menu->getParams()->get('pageclass_sfx'))
	{
		$body_classes .= ' ' . $menu->getParams()->get('pageclass_sfx');
	}
}

$body_classes .= ' off-canvas-menu-init';

//Body Background Image
if ($bg_image = $this->helix3->getParam('body_bg_image'))
{
	$body_style = 'background-image: url(' . Uri::base(true) . '/' . $bg_image . ');';
	$body_style .= 'background-repeat: ' . $this->helix3->getParam('body_bg_repeat') . ';';
	$body_style .= 'background-size: ' . $this->helix3->getParam('body_bg_size') . ';';
	$body_style .= 'background-attachment: ' . $this->helix3->getParam('body_bg_attachment') . ';';
	$body_style .= 'background-position: ' . $this->helix3->getParam('body_bg_position') . ';';
	$body_style = 'body.site {' . $body_style . '}';
	
	$doc->addStyledeclaration($body_style);
}

//Custom CSS
if ($custom_css = $this->helix3->getParam('custom_css'))
{
	$doc->addStyledeclaration($custom_css);
}

//Custom JS
if ($custom_js = $this->helix3->getParam('custom_js'))
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
		<?php $this->helix3->loadHead(); ?>
		<?php
			$megabgcolor = ($this->helix3->PresetParam('_megabg')) ? $this->helix3->PresetParam('_megabg') : '#ffffff';
			$megabgtx = ($this->helix3->PresetParam('_megatx')) ? $this->helix3->PresetParam('_megatx') : '#333333';

			$preloader_bg = ($this->helix3->getParam('preloader_bg')) ? $this->helix3->getParam('preloader_bg') : '#f5f5f5';
			$preloader_tx = ($this->helix3->getParam('preloader_tx')) ? $this->helix3->getParam('preloader_tx') : '#f5f5f5';

			// load css, less and js
			$this->helix3->addCSS('bootstrap.min.css') // CSS Files
			->addCSS('joomla-fontawesome.min.css, font-awesome-v4-shims.min.css')
			->addJS('bootstrap.min.js, jquery.sticky.js, main.js') // JS Files
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
			->addLess('master', 'template');
				
			//RTL
			if ($this->direction == 'rtl')
			{
				$this->helix3->addCSS('bootstrap-rtl.min.css')
					->addLess('rtl', 'rtl');
			}
			
			$this->helix3->addLess('presets', 'presets/' . $this->helix3->Preset(), array('class' => 'preset'));
			
			//Before Head
			if ($before_head = $this->helix3->getParam('before_head')) {
				echo $before_head . "\n";
			}
		?>
	</head>
	
	<body class="<?php echo $this->helix3->bodyClass($body_classes); ?>">
	
		<div class="body-wrapper">
			<div class="body-innerwrapper">
				<?php $this->helix3->generatelayout(); ?>
			</div>
		</div>
		
		<!-- Off Canvas Menu -->
		<div class="offcanvas-menu">
			<a href="#" class="close-offcanvas" aria-label="Close"><i class="fa fa-remove" aria-hidden="true" title="<?php echo Text::_('HELIX_CLOSE_MENU'); ?>"></i></a>
			<div class="offcanvas-inner">
				<?php if ($this->helix3->countModules('offcanvas')) : ?>
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
				$this->helix3->compressCSS();
			}
			
			$tempOption    = $app->input->get('option');
			
			if ($this->params->get('compress_js') && $tempOption != 'com_config')
			{
				$this->helix3->compressJS($this->params->get('exclude_js'));
			}
			
			//before body
			if ($before_body = $this->helix3->getParam('before_body'))
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