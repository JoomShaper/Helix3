<?php
/**
 * @package Helix3 Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright (c) 2010 - 2021 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

use Joomla\CMS\HTML\HTMLHelper;

defined('JPATH_BASE') or die;

?>
<dd class="create">
	<i class="fa fa-clock-o" area-hidden="true"></i>
	<time datetime="<?php echo HTMLHelper::_('date', $displayData['item']->created, 'c'); ?>" itemprop="dateCreated" data-toggle="tooltip" title="<?php echo JText::_('COM_CONTENT_CREATED_DATE'); ?>">
		<?php echo HTMLHelper::_('date', $displayData['item']->created, JText::_('DATE_FORMAT_LC3')); ?>
	</time>
</dd>