<?php
/**
 * @package Helix3 Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright (c) 2010 - 2021 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

defined('JPATH_BASE') or die;
?>

<?php if ( $displayData['params']->get('link_url') ) : ?>
	<?php $link_title = ( $displayData['params']->get('link_title') ) ? $displayData['params']->get('link_title') : $displayData['params']->get('link_url'); ?>
	<div class="entry-link">
		<a target="_blank" href="<?php echo $displayData['params']->get('link_url'); ?>"><h4><?php echo $link_title; ?></h4></a>
	</div>
<?php endif; ?>