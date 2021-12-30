<?php
/**
 * @package Helix3 Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright (c) 2010 - 2021 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

defined('_JEXEC') or die;

$article = $displayData['article'];
$overlib = $displayData['overlib'];

// @deprecated  4.0  The legacy icon flag will be removed from this layout in 4.0
$legacy  = $displayData['legacy'];

$currentDate   = JFactory::getDate()->format('Y-m-d H:i:s');
$isUnpublished = ($article->publish_up > $currentDate)
	|| ($article->publish_down < $currentDate && $article->publish_down !== JFactory::getDbo()->getNullDate());

if ($legacy)
{
	$icon = $article->state ? 'edit.png' : 'edit_unpublished.png';

	if ($isUnpublished)
	{
		$icon = 'edit_unpublished.png';
	}
}
else
{
	$icon = $article->state ? 'edit' : 'eye-close';

	if ($isUnpublished)
	{
		$icon = 'eye-close';
	}
}

?>
<?php if ($legacy) : ?>
	<?php echo JHtml::_('image', 'system/' . $icon, JText::_('JGLOBAL_EDIT'), null, true); ?>
<?php else : ?>
	<span class="hasTooltip icon-<?php echo $icon; ?> tip" title="<?php echo JHtml::tooltipText(JText::_('COM_CONTENT_EDIT_ITEM'), $overlib, 0, 0); ?>"></span>
	<?php echo JText::_('JGLOBAL_EDIT'); ?>
<?php endif; ?>
