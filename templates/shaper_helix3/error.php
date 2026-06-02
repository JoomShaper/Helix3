<?php
/**
 * @package Helix3 Framework
 * Template Name - Shaper Helix - iii
 * @author JoomShaper https://www.joomshaper.com
 * @copyright (c) 2010 - 2021 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/
//no direct accees
defined ('_JEXEC') or die ('resticted aceess');

use Joomla\CMS\Document\Renderer\Html\HeadRenderer;
use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Language\Text;

$doc = Factory::getDocument();
$params = Factory::getApplication()->getTemplate('true')->params;

//Error Logo
if ($logo_image = $params->get('error_logo')) {
	 $logo = Uri::root() . '/' .  $logo_image;
	 $path = JPATH_ROOT . '/' .  $logo_image;
} else {
    $logo 		= $this->baseurl . '/templates/' . $this->template . '/images/presets/preset1/logo.png';
    $path 		= JPATH_ROOT . '/templates/' . $this->template . '/images/presets/preset1/logo.png';
}

//Favicon
if($favicon = $params->get('favicon')) {
    $doc->addFavicon( Uri::base(true) . '/' .  $favicon);
} else {
    $doc->addFavicon( $this->baseurl . '/templates/' . $this->template . '/images/favicon.ico' );
}

//Stylesheets
$custom_css_path = JPATH_ROOT . '/templates/' . $this->template . '/css/custom.css';
if (file_exists($custom_css_path)) {
	$doc->addStylesheet( $this->baseurl . '/templates/' . $this->template . '/css/custom.css' );
}
$doc->addStylesheet( $this->baseurl . '/templates/' . $this->template . '/css/bootstrap.min.css' );
$doc->addStylesheet( $this->baseurl . '/templates/' . $this->template . '/css/joomla-fontawesome.min.css' );
$doc->addStylesheet( $this->baseurl . '/templates/' . $this->template . '/css/font-awesome-v4-shims.min.css' );
$doc->addStylesheet( $this->baseurl . '/templates/' . $this->template . '/css/template.css' );

$doc->setTitle($this->error->getCode() . ' - '.$this->title);
$header_contents = '';
if(!class_exists('JDocumentRendererHead')) {
  $head = JPATH_LIBRARIES . '/joomla/document/html/renderer/head.php';
  if(file_exists($head)) {
    require_once($head);
  }
}
$header_renderer = new HeadRenderer($doc);
$header_contents = $header_renderer->render(null);

//background image
$error_bg = '';
$hascs_bg = '';
if ($err_bg = $params->get('error_bg')) {
	$error_bg 	= Uri::root() . $err_bg;
	$hascs_bg 	= 'has-background';
}

?>
<!DOCTYPE html>
<html class="error-page" xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
	<head>
	  	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
		<?php echo $header_contents; ?>
	</head>
	<body>
		<div class="error-page-inner <?php echo $hascs_bg; ?>" style="background-image: url(<?php echo $error_bg; ?>);">
			<div>
				<div class="container">
					<?php if(isset($logo) && $logo ) { ?>
						<div class="error-logo-wrap">
							<img class="error-logo" alt="logo" src="<?php echo $logo; ?>" />
						</div>
					<?php } else { ?>
						<p><i class="fa fa-exclamation-triangle"></i></p>
					<?php } ?>
					<h1 class="error-code"><?php echo $this->error->getCode(); ?></h1>
					<p class="error-message"><?php echo $this->error->getMessage(); ?></p>

					<?php if ($this->debug) : ?>
						<div>
							<?php echo $this->renderBacktrace(); ?>
							<?php // Check if there are more Exceptions and render their data as well ?>
							<?php if ($this->error->getPrevious()) : ?>
								<?php $loop = true; ?>
								<?php // Reference $this->_error here and in the loop as setError() assigns errors to this property and we need this for the backtrace to work correctly ?>
								<?php // Make the first assignment to setError() outside the loop so the loop does not skip Exceptions ?>
								<?php $this->setError($this->_error->getPrevious()); ?>
								<?php while ($loop === true) : ?>
									<p><strong><?php echo Text::_('JERROR_LAYOUT_PREVIOUS_ERROR'); ?></strong></p>
									<p><?php echo htmlspecialchars($this->_error->getMessage(), ENT_QUOTES, 'UTF-8'); ?></p>
									<?php echo $this->renderBacktrace(); ?>
									<?php $loop = $this->setError($this->_error->getPrevious()); ?>
								<?php endwhile; ?>
								<?php // Reset the main error object to the base error ?>
								<?php $this->setError($this->error); ?>
							<?php endif; ?>
						</div>
					<?php endif; ?>

					<a class="btn btn-primary btn-lg" href="<?php echo $this->baseurl; ?>/" title="<?php echo Text::_('HOME'); ?>"><i class="fa fa-chevron-left"></i> <?php echo Text::_('HELIX_GO_BACK'); ?></a>
					<?php echo $doc->getBuffer('modules', '404', array('style' => 'sp_xhtml')); ?>
				</div>
			</div>
		</div>
	</body>
</html>