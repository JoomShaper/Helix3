<?php
/**
 * @package Helix3 Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright (c) 2010 - 2021 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

defined('_JEXEC') or die;

$tooltip = $displayData['tooltip'];

// @deprecated  4.0  The legacy icon flag will be removed from this layout in 4.0
$legacy  = $displayData['legacy'];

?>
<?php if ($legacy) : ?>
	<span class="hasTooltip" title="<?php echo JHtml::tooltipText($tooltip . '', 0); ?>">
		<?php echo JHtml::_('image', 'system/checked_out.png', null, null, true); ?>
	</span>
	<?php echo JText::_('JLIB_HTML_CHECKED_OUT'); ?>
<?php else : ?>
	<span class="hasTooltip icon-lock" title="<?php echo JHtml::tooltipText($tooltip . '', 0); ?>"></span>
	<?php echo JText::_('JLIB_HTML_CHECKED_OUT'); ?>
<?php endif; ?>
