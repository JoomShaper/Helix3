<?php
/**
 * @package Helix3 Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright (c) 2010 - 2021 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

use Joomla\CMS\Filter\OutputFilter;

defined('_JEXEC') or die;

// Note. It is important to remove spaces between elements.
$class = $item->anchor_css ? 'class="' . $item->anchor_css . '" ' : '';
$title = $item->anchor_title ? 'title="' . $item->anchor_title . '" ' : '';

if ($item->menu_image)
{
	$item->getParams()->get('menu_text', 1) ?
	$linktype = '<img src="' . $item->menu_image . '" alt="' . $item->title . '" /><span class="image-title">' . $item->title . '</span> ' :
	$linktype = '<img src="' . $item->menu_image . '" alt="' . $item->title . '" />';
}
else
{
	$linktype = $item->title;
}

$icon = '';
if (isset($item_decode->icon) && $item_decode->icon) {
	$icon = ' <i class="fa ' . $item_decode->icon . '"></i>';
}

$flink = $item->flink;
$flink = OutputFilter::ampReplace(htmlspecialchars($flink));

switch ($item->browserNav) :
	default:
	case 0:
		$link_rel = ($item->anchor_rel) ? 'rel="' . $item->anchor_rel . '"' : '' ;
		?>
		<a <?php echo $class; ?> href="<?php echo $flink; ?>" <?php echo $title; ?> <?php echo $link_rel ?>><?php echo $icon . ' ' . $linktype; ?></a><?php
	break;
	case 1:
		// _blank
		$link_rel = ($item->anchor_rel == 'nofollow') ? 'noopener noreferrer nofollow' : 'noopener noreferrer';
		?>
		<a <?php echo $class; ?>href="<?php echo $flink; ?>" rel="<?php echo $link_rel ?>" target="_blank" <?php echo $title; ?>><?php echo $icon . ' ' . $linktype; ?></a><?php
	break;
	case 2:
		// Use JavaScript "window.open"
		$options = 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,' . $params->get('window_open');
			?><a <?php echo $class; ?>href="<?php echo $flink; ?>" onclick="window.open(this.href,'targetWindow','<?php echo $options;?>');return false;" <?php echo $title; ?>><?php echo $icon . ' ' . $linktype; ?></a><?php
	break;
endswitch;

if(($module->position == 'offcanvas') && ($item->deeper)) {
	echo '<span class="offcanvas-menu-toggler collapsed" data-bs-toggle="collapse" data-bs-target="#collapse-menu-'. $item->id .'"><i class="open-icon fa fa-angle-down"></i><i class="close-icon fa fa-angle-up"></i></span>';
}