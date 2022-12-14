<?php
/**
 * @package Helix3 Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright (c) 2010 - 2021 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

defined('JPATH_BASE') or die;
?>
<dd class="published">
	<i class="fa fa-calendar-o" area-hidden="true"></i>
	<time datetime="<?php echo HTMLHelper::_('date', $displayData['item']->publish_up, 'c'); ?>" itemprop="datePublished" data-toggle="tooltip" title="<?php echo Text::_('COM_CONTENT_PUBLISHED_DATE'); ?>">
		<?php echo HTMLHelper::_('date', $displayData['item']->publish_up, Text::_('DATE_FORMAT_LC3')); ?>
	</time>
</dd>