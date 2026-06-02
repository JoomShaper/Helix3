<?php
/**
 * @package Helix3 Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright (c) 2010 - 2021 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
?>

<ol class="breadcrumb">
	<?php
	if ($params->get('showHere', 1))
	{
		echo '<span>' . Text::_('MOD_BREADCRUMBS_HERE') . '&#160;</span>';
	}
	else
	{
		echo '<li class="breadcrumb-item"><i class="fa fa-home"></i></li>';
	}

	// Get rid of duplicated entries on trail including home page when using multilanguage
	for ($i = 0; $i < $count; $i++)
	{
		if ($i == 1 && !empty($list[$i]->link) && !empty($list[$i - 1]->link) && $list[$i]->link == $list[$i - 1]->link)
		{
			unset($list[$i]);
		}
	}

	end($list);
	$last_item_key = key($list);
	prev($list);
	$penult_item_key = key($list);

	$show_last = $params->get('showLast', 1);

	foreach ($list as $key => $item) {
		if ($key != $last_item_key) {
			echo '<li class="breadcrumb-item">';
			if (!empty($item->link)) {
				echo '<a href="' . $item->link . '" class="pathway">' . $item->name . '</a>';
			} else {
				echo $item->name;
			}
			echo '</li>';
		} elseif ($show_last) {
			echo '<li class="breadcrumb-item active">' . $item->name . '</li>';
		}
	}
	?>
</ol>
