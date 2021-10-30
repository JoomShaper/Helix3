<?php
/**
 * @package Helix3 Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright (c) 2010 - 2021 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

defined('JPATH_BASE') or die;

$items = $displayData;

if (!empty($items)) : ?>
	<ul class="item-associations">
		<?php foreach ($items as $id => $item) : ?>
			<li>
				<?php echo $item->link; ?>
			</li>
		<?php endforeach; ?>
	</ul>
<?php endif;