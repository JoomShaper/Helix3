<?php
/**
 * @package Helix3 Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright (c) 2010 - 2021 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

defined('JPATH_BASE') or die;

?>
<dd class="parent-category-name">
	<i class="fa fa-folder-o" area-hidden="true"></i>
	<?php $title = $this->escape($displayData['item']->parent_title); ?>
	<?php if ($displayData['params']->get('link_parent_category') && !empty($displayData['item']->parent_slug)) : ?>
		<?php echo '<a href="' . Route::_(ContentHelperRoute::getCategoryRoute($displayData['item']->parent_slug)) . '" itemprop="genre" data-toggle="tooltip" title="' . Text::sprintf('COM_CONTENT_PARENT', '') . '">' . $title . '</a>'; ?>
	<?php else : ?>
		<?php echo '<span itemprop="genre" data-toggle="tooltip" title="' . Text::sprintf('COM_CONTENT_PARENT', '') . '">' . $title . '</span>'; ?>
	<?php endif; ?>
</dd>