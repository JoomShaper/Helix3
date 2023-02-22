<?php
/**
 * @package Helix3 Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright (c) 2010 - 2021 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

use Joomla\CMS\HTML\HTMLHelper;

defined('_JEXEC') or die;

$title      = $item->anchor_title ? ' title="' . $item->anchor_title . '"' : '';
$anchor_css = $item->anchor_css ? $item->anchor_css : '';

$linktype   = $item->title;

if ($item->menu_image)
{
	$linktype = HTMLHelper::_('image', $item->menu_image, $item->title);

	if ($item->getParams()->get('menu_text', 1))
	{
		$linktype .= '<a class="image-title">' . $item->title . '</a>';
	}
}
?>
<a class="separator <?php echo $anchor_css; ?>"<?php echo $title; ?>><?php echo $linktype; ?></a>
<?php
if(($module->position == 'offcanvas') && ($item->deeper)) {
	echo '<span class="offcanvas-menu-toggler collapsed" data-bs-toggle="collapse" data-bs-target="#collapse-menu-'. $item->id .'"><i class="open-icon fa fa-angle-down"></i><i class="close-icon fa fa-angle-up"></i></span>';
}
