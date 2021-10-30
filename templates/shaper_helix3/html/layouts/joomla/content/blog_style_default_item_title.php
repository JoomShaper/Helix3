<?php
/**
 * @package Helix3 Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright (c) 2010 - 2021 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

defined('_JEXEC') or die;

// Create a shortcut for params.
$params = $displayData->params;
$canEdit = $displayData->params->get('access-edit');
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');

$currentDate   = JFactory::getDate()->format('Y-m-d H:i:s');
$isNotPublishedYet = $displayData->publish_up > $currentDate;
$isExpired         = JVERSION < 4 ? $displayData->publish_down < $currentDate && $displayData->publish_down !== JFactory::getDbo()->getNullDate() : !is_null($displayData->publish_down) && $displayData->publish_down < $currentDate;
?>

<?php if ($params->get('show_title') || $displayData->state == 0 || ($params->get('show_author') && !empty($displayData->author ))) : ?>
	<?php if ($params->get('show_title')) : ?>
		<h2 itemprop="name">
			<?php if ($params->get('link_titles') && $params->get('access-view')) : ?>
				<a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($displayData->slug, $displayData->catid, $displayData->language)); ?>" itemprop="url">
				<?php echo $this->escape($displayData->title); ?></a>
			<?php else : ?>
				<?php echo $this->escape($displayData->title); ?>
			<?php endif; ?>
		</h2>
	<?php endif; ?>

	<?php if (JVERSION < 4 ? $displayData->state == 0 : $displayData->state == Joomla\Component\Content\Administrator\Extension\ContentComponent::CONDITION_UNPUBLISHED) : ?>
		<span class="label label-warning"><?php echo JText::_('JUNPUBLISHED'); ?></span>
	<?php endif; ?>
	<?php if ($isNotPublishedYet) : ?>
		<span class="label label-warning"><?php echo JText::_('JNOTPUBLISHEDYET'); ?></span>
	<?php endif; ?>
	<?php if ($isExpired) : ?>
		<span class="label label-warning"><?php echo JText::_('JEXPIRED'); ?></span>
	<?php endif; ?>
<?php endif; ?>
