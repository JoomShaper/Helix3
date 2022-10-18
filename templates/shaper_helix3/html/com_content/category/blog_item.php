<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

use Joomla\CMS\Factory;
use Joomla\Registry\Registry;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;

defined('_JEXEC') or die;

// Create a shortcut for params.
$params = $this->item->params;
$tpl_params 	= Factory::getApplication()->getTemplate(true)->params;
HTMLHelper::addIncludePath(JPATH_COMPONENT . '/helpers/html');
$canEdit 	 = $this->item->params->get('access-edit');
$info    	 = $params->get('info_block_position', 0);
$useDefList = ($params->get('show_modify_date') || $params->get('show_publish_date') || $params->get('show_create_date')
	|| $params->get('show_hits') || $params->get('show_category') || $params->get('show_parent_category') || $params->get('show_author') );

// Post Format
$post_attribs = new Registry(json_decode( $this->item->attribs ));
$post_format = $post_attribs->get('post_format', 'standard');

?>

<?php if ($this->item->state == 0 || strtotime(!empty($this->item->publish_up) ? $this->item->publish_up : '') > strtotime(Factory::getDate())
	|| ((strtotime(!empty($this->item->publish_down) ? $this->item->publish_down : '') < strtotime(Factory::getDate())) && $this->item->publish_down != Factory::getDbo()->getNullDate())) : ?>
	<div class="system-unpublished">
<?php endif; ?>

<?php
	if($post_format=='standard') {
		echo LayoutHelper::render('joomla.content.intro_image', $this->item);
	} else {
		echo LayoutHelper::render('joomla.content.post_formats.post_' . $post_format, array('params' => $post_attribs, 'item' => $this->item));
	}
?>

<div class="entry-header<?php echo $tpl_params->get('show_post_format') ? ' has-post-format': ''; ?>">

	<?php echo LayoutHelper::render('joomla.content.post_formats.icons',  $post_format); ?>

	<?php if ($useDefList && ($info == 0 || $info == 2)) : ?>
		<?php echo LayoutHelper::render('joomla.content.info_block.block', array('item' => $this->item, 'params' => $params, 'position' => 'above')); ?>
	<?php endif; ?>
	
	<?php echo LayoutHelper::render('joomla.content.blog_style_default_item_title', $this->item); ?>
</div>

<?php if ($canEdit || $params->get('show_print_icon') || $params->get('show_email_icon')) : ?>
	<?php echo LayoutHelper::render('joomla.content.icons', array('params' => $params, 'item' => $this->item, 'print' => false)); ?>
<?php endif; ?>

<?php if (!$params->get('show_intro')) : ?>
	<?php echo $this->item->event->afterDisplayTitle; ?>
<?php endif; ?>
<?php echo $this->item->event->beforeDisplayContent; ?>

<?php echo $this->item->introtext; ?>

<?php if ($useDefList && ($info == 1 || $info == 2)) : ?>
	<?php echo LayoutHelper::render('joomla.content.info_block.block', array('item' => $this->item, 'params' => $params, 'position' => 'below')); ?>
<?php  endif; ?>

<?php if ($params->get('show_readmore') && $this->item->readmore) :
	if ($params->get('access-view')) :
		$link = Route::_(version_compare(JVERSION, '4.0.0', '<') ? ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid, $this->item->language) : Joomla\Component\Content\Site\Helper\RouteHelper::getArticleRoute($this->item->slug, $this->item->catid, $this->item->language));
	else :
		$menu = Factory::getApplication()->getMenu();
		$active = $menu->getActive();
		$itemId = $active->id;
		$link1 = Route::_('index.php?option=com_users&view=login&Itemid=' . $itemId);
		$returnURL = Route::_(version_compare(JVERSION, '4.0.0', '<') ? ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid, $this->item->language) : Joomla\Component\Content\Site\Helper\RouteHelper::getArticleRoute($this->item->slug, $this->item->catid, $this->item->language));
		$link = new Uri($link1);
		$link->setVar('return', base64_encode($returnURL));
	endif; ?>

	<?php echo LayoutHelper::render('joomla.content.readmore', array('item' => $this->item, 'params' => $params, 'link' => $link)); ?>

<?php endif; ?>

<?php if ($this->item->state == 0 || strtotime(!empty($this->item->publish_up) ? $this->item->publish_up : '') > strtotime(Factory::getDate())
	|| ((strtotime(!empty($this->item->publish_down) ? $this->item->publish_down : '') < strtotime(Factory::getDate())) && $this->item->publish_down != Factory::getDbo()->getNullDate())) : ?>
</div>
<?php endif; ?>

<?php if ($params->get('show_tags') && !empty($this->item->tags->itemTags)) : ?>
	<?php echo LayoutHelper::render('joomla.content.tags', $this->item->tags->itemTags); ?>
<?php endif; ?>

<?php echo $this->item->event->afterDisplayContent; ?>
