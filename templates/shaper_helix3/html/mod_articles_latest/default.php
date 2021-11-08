<?php
/**
 * @package Helix3 Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright (c) 2010 - 2021 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

defined('_JEXEC') or die;
?>
<div class="latestnews">
<?php foreach ($list as $item) :  ?>
	<div itemscope itemtype="http://schema.org/Article">
		<a href="<?php echo $item->link; ?>" itemprop="url">
			<span itemprop="name">
				<?php echo $item->title; ?>
			</span>
		</a>
		<small><?php echo JHtml::_('date', $item->created, JText::_('DATE_FORMAT_LC3')); ?></small>
	</div>
<?php endforeach; ?>
</div>
