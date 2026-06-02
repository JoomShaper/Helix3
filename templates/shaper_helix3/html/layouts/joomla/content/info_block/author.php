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

?>
<dd class="createdby" itemprop="author" itemscope itemtype="http://schema.org/Person">
	<i class="fa fa-user" area-hidden="true"></i>
	<?php $author = ($displayData['item']->created_by_alias ? $displayData['item']->created_by_alias : $displayData['item']->author); ?>
	<?php $author = '<span itemprop="name" data-toggle="tooltip" title="' . Text::sprintf('COM_CONTENT_WRITTEN_BY', '') . '">' . $author . '</span>'; ?>
	<?php if (!empty($displayData['item']->contact_link ) && $displayData['params']->get('link_author') == true) : ?>
		<?php echo HTMLHelper::_('link', $displayData['item']->contact_link, $author, array('itemprop' => 'url')); ?>
	<?php else :?>
		<?php echo $author; ?>
	<?php endif; ?>
</dd>