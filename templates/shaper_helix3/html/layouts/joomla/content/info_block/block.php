<?php
/**
 * @package Helix3 Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright (c) 2010 - 2021 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

defined('JPATH_BASE') or die;

use Joomla\CMS\Layout\LayoutHelper;

$blockPosition = $displayData['params']->get('info_block_position', 0);
?>

<dl class="article-info">
	<?php if ($displayData['position'] == 'above' && ($blockPosition == 0 || $blockPosition == 2)
			|| $displayData['position'] == 'below' && ($blockPosition == 1)
			) : ?>

		<dt class="article-info-term"></dt>	
			
		<?php if ($displayData['params']->get('show_author') && !empty($displayData['item']->author )) : ?>
			<?php echo LayoutHelper::render('joomla.content.info_block.author', $displayData); ?>
		<?php endif; ?>

		<?php if ($displayData['params']->get('show_parent_category') && !empty($displayData['item']->parent_slug)) : ?>
			<?php echo LayoutHelper::render('joomla.content.info_block.parent_category', $displayData); ?>
		<?php endif; ?>

		<?php if ($displayData['params']->get('show_category')) : ?>
			<?php echo LayoutHelper::render('joomla.content.info_block.category', $displayData); ?>
		<?php endif; ?>

		<?php echo LayoutHelper::render('joomla.content.comments.comments_count', $displayData); //Helix Comment Count ?>

		<?php if ($displayData['params']->get('show_publish_date')) : ?>
			<?php echo LayoutHelper::render('joomla.content.info_block.publish_date', $displayData); ?>
		<?php endif; ?>
	<?php endif; ?>

	<?php if ($displayData['position'] == 'above' && ($blockPosition == 0)
			|| $displayData['position'] == 'below' && ($blockPosition == 1 || $blockPosition == 2)
			) : ?>
		<?php if ($displayData['params']->get('show_create_date')) : ?>
			<?php echo LayoutHelper::render('joomla.content.info_block.create_date', $displayData); ?>
		<?php endif; ?>

		<?php if ($displayData['params']->get('show_modify_date')) : ?>
			<?php echo LayoutHelper::render('joomla.content.info_block.modify_date', $displayData); ?>
		<?php endif; ?>

		<?php if ($displayData['params']->get('show_hits')) : ?>
			<?php echo LayoutHelper::render('joomla.content.info_block.hits', $displayData); ?>
		<?php endif; ?>
	<?php endif; ?>
</dl>
