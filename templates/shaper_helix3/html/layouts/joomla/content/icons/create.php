<?php
/**
 * @package Helix3 Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright (c) 2010 - 2021 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

defined('_JEXEC') or die;

$params = $displayData['params'];

// @deprecated  4.0  The legacy icon flag will be removed from this layout in 4.0
$legacy = $displayData['legacy'];

?>
<?php if ($params->get('show_icons')) : ?>
	<?php if ($legacy) : ?>
		<?php echo JHtml::_('image', 'system/new.png', JText::_('JNEW'), null, true); ?>
	<?php else : ?>
		<span class="icon-plus" aria-hidden="true"></span>
		<?php echo JText::_('JNEW'); ?>
	<?php endif; ?>
<?php else : ?>
	<?php echo JText::_('JNEW') . '&#160;'; ?>
<?php endif; ?>
