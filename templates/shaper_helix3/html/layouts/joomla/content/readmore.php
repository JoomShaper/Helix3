<?php
/**
 * @package Helix3 Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright (c) 2010 - 2021 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

$params = $displayData['params'];
$item = $displayData['item'];
?>

<p class="readmore">
	<a class="btn btn-secondary" href="<?php echo $displayData['link']; ?>" itemprop="url">
		<?php if (!$params->get('access-view')) :
			echo JText::_('COM_CONTENT_REGISTER_TO_READ_MORE');
		elseif ($readmore = $item->alternative_readmore) :
			echo $readmore;
			if ($params->get('show_readmore_title', 0) != 0) :
				echo JHtml::_('string.truncate', ($item->title), $params->get('readmore_limit'));
			endif;
		elseif ($params->get('show_readmore_title', 0) == 0) :
			echo JText::sprintf(JVERSION < 4 ? 'COM_CONTENT_READ_MORE_TITLE' : 'JGLOBAL_READ_MORE');
		else :
			echo JText::sprintf(JVERSION < 4 ? 'COM_CONTENT_READ_MORE_TITLE' : 'JGLOBAL_READ_MORE_TITLE', JHtml::_('string.truncate', ($item->title), $params->get('readmore_limit')));
		endif; ?>
	</a>
</p>