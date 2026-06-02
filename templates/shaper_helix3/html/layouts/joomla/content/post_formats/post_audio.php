<?php
/**
 * @package Helix3 Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright (c) 2010 - 2021 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

defined('JPATH_BASE') or die;
?>

<?php if ( $displayData['params']->get('audio') ) : ?>
	<div class="entry-audio ratio ratio-16x9">
		<?php echo $displayData['params']->get('audio'); ?>
	</div>
<?php endif; ?>