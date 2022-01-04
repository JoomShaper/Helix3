<?php
/**
 * @package Helix3 Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright (c) 2010 - 2021 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

defined('_JEXEC') or die;

$params = $displayData['params'];
?>
<?php if ($params->get('show_icons')) : ?>
	<span class="icon-plus" aria-hidden="true"></span>
	<?php echo JText::_('JNEW'); ?>
<?php else : ?>
	<?php echo JText::_('JNEW') . '&#160;'; ?>
<?php endif; ?>
