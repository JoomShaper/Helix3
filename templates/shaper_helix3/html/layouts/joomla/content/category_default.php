<?php
/**
 * @package Helix3 Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright (c) 2010 - 2021 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

defined('JPATH_BASE') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;


// Note that this layout opens a div with the page class suffix. If you do not use the category children
// layout you need to close this div either by overriding this file or in your main layout.
$params    = $displayData->params;
$extension = $displayData->get('category')->extension;
$canEdit   = $params->get('access-edit');
$className = substr($extension, 4);

// This will work for the core components but not necessarily for other components
// that may have different pluralisation rules.
if (substr($className, -1) == 's')
{
	$className = rtrim($className, 's');
}

$tagsData = $displayData->get('category')->tags->itemTags;
?>

<div>
	<div class="<?php echo $className .'-category' . $displayData->pageclass_sfx;?>">
		<?php if ($params->get('show_page_heading')) : ?>
			<h1>
				<?php echo $displayData->escape($params->get('page_heading')); ?>
			</h1>
		<?php endif; ?>
		
		<?php if($params->get('show_category_title', 1)) : ?>
			<h2>
				<?php echo HTMLHelper::_('content.prepare', $displayData->get('category')->title, '', $extension . '.category.title'); ?>
			</h2>
		<?php endif; ?>

		<?php if ($params->get('show_cat_tags', 1)) : ?>
			<?php echo LayoutHelper::render('joomla.content.tags', $tagsData); ?>
		<?php endif; ?>

		<?php if ($params->get('show_description', 1) || $params->def('show_description_image', 1)) : ?>
			<div class="category-desc">
				<?php if ($params->get('show_description_image') && $displayData->get('category')->getParams()->get('image')) : ?>
					<img src="<?php echo $displayData->get('category')->getParams()->get('image'); ?>" alt="<?php echo htmlspecialchars($displayData->get('category')->getParams()->get('image_alt')); ?>"/>
				<?php endif; ?>
				<?php if ($params->get('show_description') && $displayData->get('category')->description) : ?>
					<?php echo HTMLHelper::_('content.prepare', $displayData->get('category')->description, '', $extension . '.category'); ?>
				<?php endif; ?>
				<div class="clr"></div>
			</div>
		<?php endif; ?>

		<?php echo $displayData->loadTemplate($displayData->subtemplatename); ?>

		<?php if ($displayData->get('children') && $displayData->maxLevel != 0) : ?>
			<div class="cat-children">
				<h3>
					<?php echo Text::_('JGLOBAL_SUBCATEGORIES'); ?>
				</h3>

				<?php echo $displayData->loadTemplate('children'); ?>
			</div>
		<?php endif; ?>
	</div>
</div>

