<?php
/**
 * @package Helix3 Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright (c) 2010 - 2021 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

defined('_JEXEC') or die;

use Joomla\CMS\Uri\Uri;

$button = $displayData;

?>
<?php if ($button->get('name')) : ?>
	<?php
		$class    = ($button->get('class')) ? $button->get('class') : null;
		$class	 .= ($button->get('modal')) ? ' modal-button' : null;
		$href     = ($button->get('link')) ? ' href="' . Uri::base() . $button->get('link') . '"' : null;
		$onclick  = ($button->get('onclick')) ? ' onclick="' . $button->get('onclick') . '"' : ' onclick="IeCursorFix(); return false;"';
		$title    = ($button->get('title')) ? $button->get('title') : $button->get('text');
	?>
	<a class="btn-primary <?php echo $class; ?>" title="<?php echo $title; ?>" <?php echo $href . $onclick; ?> rel="<?php echo $button->get('options'); ?>">
		<i class="fa fa-<?php echo $button->get('name'); ?>"></i> <?php echo $button->get('text'); ?>
	</a>
<?php endif;