<?php
/**
 * @package Helix3 Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright (c) 2010 - 2021 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

defined('JPATH_BASE') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\Component\Content\Site\Helper\RouteHelper;

if (!isset($displayData['item']->catslug))
{
	$displayData['item']->catslug = $displayData['item']->catid . ':' . $displayData['item']->category_alias;
}

?>
<dd class="category-name">
	<i class="fa fa-folder-open-o" area-hidden="true"></i>
	<?php $title = $this->escape($displayData['item']->category_title); ?>
	<?php if ($displayData['params']->get('link_category') && $displayData['item']->catslug) : ?>
		<?php echo '<a href="' . Route::_(version_compare(JVERSION, '4.0.0', '<') ? ContentHelperRoute::getCategoryRoute($displayData['item']->catslug) : RouteHelper::getCategoryRoute($displayData['item']->catslug)) . '" itemprop="genre" data-toggle="tooltip" title="' . Text::_('COM_CONTENT_CONTENT_TYPE_CATEGORY') . '">' . $title . '</a>'; ?>
	<?php else : ?>
		<?php echo '<span itemprop="genre" itemprop="genre" data-toggle="tooltip" title="' . Text::_('COM_CONTENT_CONTENT_TYPE_CATEGORY') . '">' . $title . '</span>'; ?>
	<?php endif; ?>
</dd>